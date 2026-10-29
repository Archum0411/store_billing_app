<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UserCreationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware();

        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');

        Schema::create('roles', function (Blueprint $table): void {
            $table->id();
            $table->string('role_name')->unique();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function test_user_can_be_created_with_the_selected_role(): void
    {
        $roleId = \DB::table('roles')->insertGetId([
            'role_name' => 'Cashier',
            'status' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->post(route('user.store'), [
            'name' => 'Taylor User',
            'email' => 'taylor@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'role_id' => $roleId,
            'status' => '1',
        ]);

        $response->assertRedirect(route('user.index'));
        $this->assertDatabaseHas('users', [
            'name' => 'Taylor User',
            'email' => 'taylor@example.com',
            'role' => (string) $roleId,
            'status' => 1,
        ]);

        $user = User::where('email', 'taylor@example.com')->firstOrFail();
        $this->assertTrue(Hash::check('secret123', $user->password));
    }

    public function test_user_creation_rejects_a_role_that_does_not_exist(): void
    {
        $response = $this->from('/user-create')->post(route('user.store'), [
            'name' => 'Taylor User',
            'email' => 'taylor@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'role_id' => 999,
            'status' => '1',
        ]);

        $response->assertRedirect('/user-create')
            ->assertSessionHasErrors('role_id');
        $this->assertDatabaseCount('users', 0);
    }
}
