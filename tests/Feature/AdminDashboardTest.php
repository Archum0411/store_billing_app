<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    public function test_authenticated_user_can_open_the_admin_dashboard(): void
    {
        $user = new User(['name' => 'Admin']);

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Welcome, Admin');
    }
}
