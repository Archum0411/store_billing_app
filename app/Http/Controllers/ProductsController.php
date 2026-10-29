<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Products::all();
        return view('products_management.index', compact('products'));
    }

    public function getProducts()
    {
        $products = Products::all();

        $data = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'product_name' => $product->product_name,
                'price' => $product->price,
                'tax' => $product->tax_percentage,
                'total_stock' => $product->total_stock,
                'stock_on_hand' => $product->stock_on_hand,
                'status' => $product->status,
            ];
        });

        return response()->json($data);
    }

    public function create()
    {
        return view('products_management.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'tax_percentage' => 'required|numeric|min:0|max:100',
            'stock_on_hand' => 'required|integer|min:0',
        ]);

        $validated['total_stock'] = $validated['stock_on_hand'];

        $product = DB::transaction(function () use ($validated) {
        // Lock the latest product row to reduce concurrent code collisions.
            $latestProduct = Products::query()
                ->orderByDesc('id')
                ->lockForUpdate()
                ->first();

            $nextNumber = ($latestProduct?->id ?? 0) + 1;

            $validated['unique_code'] = 'SKU-' . str_pad(
                $nextNumber,
                4,
                '0',
                STR_PAD_LEFT
            );

           

            return Products::create($validated);
        });


        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Products::findOrFail($id);
        return view('products_management.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
            'tax_percentage' => 'required|numeric|min:0|max:100',
            'stock_on_hand' => 'required|integer|min:0',
        ]);

        $product = Products::findOrFail($id);
        $product->total_stock = $product->total_stock + ($request->stock_on_hand - $product->stock_on_hand);
        $product->update($request->all());

        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }

    public function delete($id)
    {
        $product = Products::findOrFail($id);
        $product->delete();

        return response()->json(['success' => 'Product deleted successfully.']);
    }
}
