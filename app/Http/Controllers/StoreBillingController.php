<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Order;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Jobs\SendOrderConfirmationJob;

class StoreBillingController extends Controller
{
    public function create()
    {
        $products = Products::orderBy('product_name')->get();

        $threshold = 10;
        $lowStockProducts = Products::where(
            'stock_on_hand', '<', $threshold
        )->orderBy('stock_on_hand')->get();

        return view('billing_management.create', compact(
            'products', 'lowStockProducts'
        ));
    }

    public function customerLookup(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $customer = Customers::where(
            'email', strtolower(trim($data['email']))
        )->first();

        return response()->json([
            'exists' => (bool) $customer,
            'name' => $customer?->customer_name,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_name' => ['nullable', 'string', 'max:150'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => [
                'required', 'integer', 'distinct', 'exists:products,id'
            ],
            'items.*.quantity' => [
                'required', 'integer', 'min:1'
            ],
            'amount_given' => ['nullable', 'numeric', 'min:0'],
        ]);

        $data['customer_email'] = strtolower(trim($data['customer_email']));

        $order = DB::transaction(function () use ($data) {
            $items = collect($data['items'])
                ->sortBy('product_id')->values();

            $ids = $items->pluck('product_id')
                ->unique()->sort()->values();

            // Serialize stock checks on databases that support row locks.
            $products = Products::whereIn('id', $ids)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $subtotal = 0;
            $taxTotal = 0;
            $lines = [];

            foreach ($items as $item) {
                $product = $products->get(
                    (int) $item['product_id']
                );

                $qty = (int) $item['quantity'];

                if (!$product || $product->stock_on_hand < $qty) {
                    throw ValidationException::withMessages([
                        'items' => [
                            'Insufficient stock for ' .
                            ($product?->product_name ?? 'selected product')
                        ],
                    ]);
                }

                $lineSubtotal = round(
                    (float) $product->price * $qty, 2
                );

                $lineTax = round(
                    $lineSubtotal *
                    ((float) $product->tax_percentage / 100), 2
                );

                $subtotal += $lineSubtotal;
                $taxTotal += $lineTax;

                $lines[] = [
                    'product' => $product,
                    'quantity' => $qty,
                    'subtotal' => $lineSubtotal,
                    'tax' => $lineTax,
                    'total' => round($lineSubtotal + $lineTax, 2),
                ];
            }

            $customer = Customers::firstOrNew([
                'email' => strtolower(trim($data['customer_email'])),
            ]);

            if (!$customer->exists && empty($data['customer_name'])) {
                throw ValidationException::withMessages([
                    'customer_email' => [
                        'No customer was found for this email. Provide a customer name to create one.',
                    ],
                ]);
            }

            if (isset($data['customer_name'])) {
                $customer->customer_name = trim($data['customer_name']);
            }

            $customer->save();

            $subtotal = round($subtotal, 2);
            $taxTotal = round($taxTotal, 2);

            $order = Order::create([
                'customer_id' => $customer->id,
                'subtotal' => $subtotal,
                'tax_total' => $taxTotal,
                'grand_total' => round($subtotal + $taxTotal, 2),
            ]);

            

            foreach ($lines as $line) {
                $product = $line['product'];

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $line['quantity'],
                    'unit_price' => $product->price,
                    'tax_percentage' => $product->tax_percentage,
                    'line_subtotal' => $line['subtotal'],
                    'line_tax' => $line['tax'],
                    'line_total' => $line['total'],
                ]);

                // The conditional update protects against stock changing after the check.
                $deducted = Products::whereKey($product->id)
                    ->where('stock_on_hand', '>=', $line['quantity'])
                    ->decrement('stock_on_hand', $line['quantity']);

                if ($deducted !== 1) {
                    throw ValidationException::withMessages([
                        'items' => [
                            'Insufficient stock for '.$product->product_name,
                        ],
                    ]);
                }
            }

            return $order;
        }, attempts: 3);

        Log::channel('single')->info('Order confirmation', [
            'order_id' => $order->id,
            'customer_id' => $order->customer_id,
            'customer_email' => $data['customer_email'],
            'subtotal' => $order->subtotal,
            'tax_total' => $order->tax_total,
            'grand_total' => $order->grand_total,
            'items' => collect($data['items'])->map(fn ($item) => [
                'product_id' => (int) $item['product_id'],
                'quantity' => (int) $item['quantity'],
            ])->values()->all(),
        ]);

        SendOrderConfirmationJob::dispatch($order->id);

        if ($request->expectsJson()) {
            $order->load(['customer', 'items.product']);

            return response()->json([
                'message' => 'Order created successfully.',
                'order' => $order,
            ], 201);
        }

        return redirect()->route('billing.show', $order);
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'items.product']);

        return view('billing_management.bill', compact('order'));
    }
}
