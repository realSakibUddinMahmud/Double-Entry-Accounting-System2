<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_valid_login_redirects_to_home(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/login', [
            'phone' => $user->phone,
            'password' => 'password',
        ]);

        $response->assertStatus(302)->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_password_redirects_back_to_login(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/login', [
            'phone' => $user->phone,
            'password' => 'wrong-pass',
        ]);

        $response->assertStatus(302)->assertRedirect('/login');
        $this->assertGuest();
    }
}

