<?php

namespace Tests\Feature;

use App\Jobs\SendOrderConfirmationJob;
use App\Models\OrderItem;
use App\Models\Products;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class StoreBillingOrderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware();
        Queue::fake();

        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('products');
        Schema::dropIfExists('customers');

        Schema::create('customers', function (Blueprint $table): void {
            $table->id();
            $table->string('customer_name');
            $table->string('email')->unique();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table): void {
            $table->id();
            $table->string('product_name');
            $table->string('unique_code')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('tax_percentage', 5, 2)->default(0);
            $table->unsignedInteger('stock_on_hand')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('tax_total', 12, 2);
            $table->decimal('grand_total', 12, 2);
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedInteger('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('tax_percentage', 5, 2);
            $table->decimal('line_subtotal', 12, 2);
            $table->decimal('line_tax', 12, 2);
            $table->decimal('line_total', 12, 2);
            $table->timestamps();
        });
    }

    public function test_order_creation_persists_order_items_and_deducts_stock(): void
    {
        $product = $this->createProduct(stock: 5);

        $response = $this->postJson(route('billing.store'), $this->orderPayload($product->id, 2));

        $response
            ->assertCreated()
            ->assertJsonPath('order.subtotal', '20.00')
            ->assertJsonPath('order.tax_total', '2.00')
            ->assertJsonPath('order.grand_total', '22.00');

        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseCount('order_items', 1);
        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'quantity' => 2,
            'line_total' => '22.00',
        ]);
        $this->assertSame(3, $product->fresh()->stock_on_hand);

        Queue::assertPushed(SendOrderConfirmationJob::class);
    }

    public function test_order_is_rejected_when_requested_quantity_exceeds_stock(): void
    {
        $product = $this->createProduct(stock: 1);

        $this->postJson(route('billing.store'), $this->orderPayload($product->id, 2))
            ->assertUnprocessable()
            ->assertJsonValidationErrors('items');

        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('order_items', 0);
        $this->assertSame(1, $product->fresh()->stock_on_hand);
        Queue::assertNothingPushed();
    }

    public function test_order_rolls_back_if_stock_is_taken_after_the_initial_check(): void
    {
        $product = $this->createProduct(stock: 1);

        OrderItem::creating(function (OrderItem $item) use ($product): void {
            DB::table('products')
                ->where('id', $product->id)
                ->update(['stock_on_hand' => 0]);
        });

        try {
            $this->postJson(route('billing.store'), $this->orderPayload($product->id, 1))
                ->assertUnprocessable()
                ->assertJsonValidationErrors('items');
        } finally {
            OrderItem::flushEventListeners();
        }

        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('order_items', 0);
        $this->assertSame(1, $product->fresh()->stock_on_hand);
        Queue::assertNothingPushed();
    }

    private function createProduct(int $stock): Products
    {
        return Products::create([
            'product_name' => 'Test product',
            'unique_code' => 'TEST-001',
            'price' => 10,
            'tax_percentage' => 10,
            'stock_on_hand' => $stock,
            'status' => true,
        ]);
    }

    private function orderPayload(int $productId, int $quantity): array
    {
        return [
            'customer_email' => 'customer@example.com',
            'customer_name' => 'Test customer',
            'items' => [
                [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ],
            ],
        ];
    }
}
