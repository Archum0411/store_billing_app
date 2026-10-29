<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{

    public function viewOrderHistory()
    {
        return view('customer_order_management.customer-order-history');
    }

    public function orderHistory(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $email = strtolower(trim($validated['email']));

        $customer = Customers::where('email', $email)->first();

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found.',
                'orders' => [],
            ], 404);
        }

        $orders = $customer->orders()
            ->with('items.product')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'customer' => [
                'name' => $customer->customer_name,
                'email' => $customer->email,
            ],
            'total_orders' => $orders->count(),
            'orders' => $orders->map(
                fn ($order) => $this->formatOrder($order)
            )->values(),
        ]);
    }

    private function formatOrder($order): array
    {
        return [
            'id' => $order->id,
            'created_at' => $order->created_at,
            'subtotal' => $order->subtotal,
            'tax_total' => $order->tax_total,
            'grand_total' => $order->grand_total,
            'items' => $order->items->map(function ($item) {
                return [
                    'product_name' => $item->product?->product_name,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'line_subtotal' => $item->line_subtotal,
                    'line_tax' => $item->line_tax,
                    'line_total' => $item->line_total,
                ];
            })->values(),
        ];
    }
    
}