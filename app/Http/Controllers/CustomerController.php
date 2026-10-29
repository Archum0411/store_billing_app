<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customers;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customers::latest()->get();
        return view('customer_management.index', compact('customers'));
    }

    public function getCustomers()
    {
        $customers = Customers::where('status', 1)->orderBy('created_at', 'ASC')->get();

        $data = $customers->map(function ($customer) {
            return [
                'id' => $customer->id,
                'customer_name' => $customer->customer_name,
                'email' => $customer->email,
                'status' => $customer->status,
            ];
        });
        return response()->json($data);
    }

    public function create()
    {   
        return view('customer_management.create');
    }

    public function store(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'customer_name' => 'required',
            'email' => 'required|email|unique:customers',
        ]);

        // Create new customer
        Customers::create($validatedData);

        return redirect()->route('customer.index')->with('success', 'Customer created successfully.');
    }

    public function edit($id)
    {
        $customer = Customers::findOrFail($id);
        return view('customer_management.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customers::findOrFail($id);

        $validatedData = $request->validate([
            'customer_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('customers', 'email')->ignore($customer->id),
            ],
        ]);

        $customer->update($validatedData);

        return redirect()->route('customer.index')->with('success', 'Customer updated successfully.');
    }

    public function delete($id)
    {
        $customer = Customers::findOrFail($id);
         if (!$customer) {
            return response()->json(['error' => 'Something went wrong. Please try again.'], 404);
        }

        $customer->update([
            'status' => 0
        ]);

        return response()->json(['success' => true, 'message' => 'Customer deleted successfully.']);
    }


}
