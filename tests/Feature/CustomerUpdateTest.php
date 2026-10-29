<?php

namespace Tests\Feature;

use App\Models\Customers;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CustomerUpdateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware();

        Schema::dropIfExists('customers');
        Schema::create('customers', function (Blueprint $table): void {
            $table->id();
            $table->string('customer_name');
            $table->string('email')->unique();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function test_customer_can_be_updated_without_changing_their_email(): void
    {
        $customer = Customers::create([
            'customer_name' => 'Original Name',
            'email' => 'customer@example.com',
        ]);

        $this->put(route('customer.update', $customer->id), [
            'customer_name' => 'Updated Name',
            'email' => 'customer@example.com',
        ])
            ->assertRedirect(route('customer.index'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'customer_name' => 'Updated Name',
            'email' => 'customer@example.com',
        ]);
    }

    public function test_customer_update_rejects_an_email_used_by_another_customer(): void
    {
        $customer = Customers::create([
            'customer_name' => 'Original Name',
            'email' => 'customer@example.com',
        ]);
        Customers::create([
            'customer_name' => 'Other Customer',
            'email' => 'other@example.com',
        ]);

        $this->from(route('customer.edit', $customer->id))
            ->put(route('customer.update', $customer->id), [
                'customer_name' => 'Updated Name',
                'email' => 'other@example.com',
            ])
            ->assertRedirect(route('customer.edit', $customer->id))
            ->assertSessionHasErrors('email');

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'email' => 'customer@example.com',
        ]);
    }
}
