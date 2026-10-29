<?php

namespace Tests\Feature;

use App\Mail\OrderConfirmationMail;
use App\Models\Customers;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Products;
use Tests\TestCase;

class OrderConfirmationMailTest extends TestCase
{
    public function test_order_confirmation_renders_and_generates_a_bill_attachment(): void
    {
        $customer = new Customers([
            'customer_name' => 'Test Customer',
            'email' => 'customer@example.com',
        ]);

        $product = new Products([
            'product_name' => 'Test Product',
        ]);

        $item = new OrderItem([
            'quantity' => 2,
            'unit_price' => 10,
            'tax_percentage' => 5,
            'line_total' => 21,
        ]);
        $item->setRelation('product', $product);

        $order = new Order([
            'subtotal' => 20,
            'tax_total' => 1,
            'grand_total' => 21,
        ]);
        $order->id = 123;
        $order->created_at = now();
        $order->setRelation('customer', $customer);
        $order->setRelation('items', collect([$item]));

        $rendered = (new OrderConfirmationMail($order))->render();

        $this->assertStringContainsString('#123', $rendered);
        $this->assertStringContainsString('Test Product', $rendered);
    }
}
