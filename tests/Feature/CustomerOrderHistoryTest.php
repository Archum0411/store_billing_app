<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class CustomerOrderHistoryTest extends TestCase
{
    public function test_authenticated_user_can_open_customer_order_history(): void
    {
        $this->actingAs(new User(['name' => 'Admin']))
            ->get('/customer-order-history-view')
            ->assertOk()
            ->assertSee('Customer Order History')
            ->assertSee('customer\\/order-history', false);
    }
}
