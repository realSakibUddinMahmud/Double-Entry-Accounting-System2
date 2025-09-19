<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticationWithBangladeshPhoneTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user registration with valid Bangladesh phone numbers
     */
    public function test_user_registration_with_valid_bangladesh_phone()
    {
        $validPhoneNumbers = [
            '01712345678', // Grameenphone
            '01812345678', // Robi
            '01312345678', // Airtel
            '01412345678', // Banglalink
            '01512345678', // Teletalk
            '01612345678', // Airtel
            '01912345678', // Banglalink
            '+8801712345678', // International format
            '+8801812345678', // International Robi
        ];

        foreach ($validPhoneNumbers as $index => $phone) {
            $userData = [
                'name' => 'Test User ' . $index,
                'phone' => $phone,
                'email' => 'user' . $index . '@test.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ];

            $response = $this->post('/register', $userData);
            
            // Should redirect to home on successful registration
            $response->assertRedirect('/home');
            
            // Check user was created
            $this->assertDatabaseHas('users', [
                'phone' => $phone,
                'name' => $userData['name'],
            ]);
        }
    }

    /**
     * Test user registration with invalid Bangladesh phone numbers
     */
    public function test_user_registration_with_invalid_bangladesh_phone()
    {
        $invalidPhoneNumbers = [
            ['phone' => '01012345678', 'reason' => 'Invalid operator 010'],
            ['phone' => '01112345678', 'reason' => 'Invalid operator 011'],
            ['phone' => '01212345678', 'reason' => 'Invalid operator 012'],
            ['phone' => '0171234567', 'reason' => 'Too short'],
            ['phone' => '017123456789', 'reason' => 'Too long'],
            ['phone' => '02012345678', 'reason' => 'Wrong format'],
            ['phone' => '01712345abc', 'reason' => 'Contains letters'],
            ['phone' => '+8801012345678', 'reason' => 'Invalid international operator'],
            ['phone' => '+88017123456789', 'reason' => 'Too long international'],
            ['phone' => '', 'reason' => 'Empty phone'],
        ];

        foreach ($invalidPhoneNumbers as $index => $testCase) {
            $userData = [
                'name' => 'Test User',
                'phone' => $testCase['phone'],
                'email' => 'invalid' . $index . '@test.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ];

            $response = $this->post('/register', $userData);
            
            // Should return validation errors
            $response->assertStatus(302); // Redirect back
            $response->assertSessionHasErrors('phone');
            
            // Check user was NOT created
            $this->assertDatabaseMissing('users', [
                'phone' => $testCase['phone'],
            ]);
        }
    }

    /**
     * Test user registration with formatted phone numbers
     */
    public function test_user_registration_with_formatted_phone_numbers()
    {
        $formattedPhoneNumbers = [
            '017-1234-5678',
            '017 1234 5678',
            '+880-17-1234-5678',
            '+880 17 1234 5678',
        ];

        foreach ($formattedPhoneNumbers as $index => $phone) {
            $userData = [
                'name' => 'Test User ' . $index,
                'phone' => $phone,
                'email' => 'formatted' . $index . '@test.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ];

            $response = $this->post('/register', $userData);
            
            // Should succeed - formatting should be handled
            $response->assertRedirect('/home');
            
            // Check user was created
            $this->assertDatabaseHas('users', [
                'phone' => $phone,
                'name' => $userData['name'],
            ]);
        }
    }

    /**
     * Test user registration name validation
     */
    public function test_user_registration_name_validation()
    {
        // Valid names
        $validNames = [
            'John Doe',
            'মোহাম্মদ রহিম',
            'O\'Connor',
            'A', // Single character
        ];

        foreach ($validNames as $index => $name) {
            $userData = [
                'name' => $name,
                'phone' => '01712345' . sprintf('%03d', $index),
                'email' => 'name' . $index . '@test.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ];

            $response = $this->post('/register', $userData);
            $response->assertRedirect('/home');
        }

        // Invalid names
        $invalidNames = [
            '', // Empty name
            str_repeat('A', 256), // Too long (over 255 chars)
        ];

        foreach ($invalidNames as $index => $name) {
            $userData = [
                'name' => $name,
                'phone' => '01812345' . sprintf('%03d', $index),
                'email' => 'invalid_name' . $index . '@test.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ];

            $response = $this->post('/register', $userData);
            $response->assertStatus(302);
            $response->assertSessionHasErrors('name');
        }
    }

    /**
     * Test user registration email validation
     */
    public function test_user_registration_email_validation()
    {
        // Valid emails (including null since it's optional)
        $validEmails = [
            'user@example.com',
            'test.email+tag@domain.co.uk',
            null, // Optional email
        ];

        foreach ($validEmails as $index => $email) {
            $userData = [
                'name' => 'Test User ' . $index,
                'phone' => '01312345' . sprintf('%03d', $index),
                'email' => $email,
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ];

            $response = $this->post('/register', $userData);
            $response->assertRedirect('/home');
        }

        // Invalid emails
        $invalidEmails = [
            'invalid-email',
            '@domain.com',
            'user@',
        ];

        foreach ($invalidEmails as $index => $email) {
            $userData = [
                'name' => 'Test User',
                'phone' => '01412345' . sprintf('%03d', $index),
                'email' => $email,
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ];

            $response = $this->post('/register', $userData);
            $response->assertStatus(302);
            $response->assertSessionHasErrors('email');
        }
    }

    /**
     * Test user registration password validation
     */
    public function test_user_registration_password_validation()
    {
        // Valid passwords
        $validPasswords = [
            'password123',
            '12345678', // Minimum 8 characters
            'Complex@Password#2024',
        ];

        foreach ($validPasswords as $index => $password) {
            $userData = [
                'name' => 'Test User ' . $index,
                'phone' => '01512345' . sprintf('%03d', $index),
                'email' => 'pwd' . $index . '@test.com',
                'password' => $password,
                'password_confirmation' => $password,
            ];

            $response = $this->post('/register', $userData);
            $response->assertRedirect('/home');
        }

        // Invalid passwords
        $invalidPasswords = [
            ['password' => '1234567', 'reason' => 'Too short'],
            ['password' => '', 'reason' => 'Empty password'],
        ];

        foreach ($invalidPasswords as $index => $testCase) {
            $userData = [
                'name' => 'Test User',
                'phone' => '01612345' . sprintf('%03d', $index),
                'email' => 'invalid_pwd' . $index . '@test.com',
                'password' => $testCase['password'],
                'password_confirmation' => $testCase['password'],
            ];

            $response = $this->post('/register', $userData);
            $response->assertStatus(302);
            $response->assertSessionHasErrors('password');
        }

        // Password confirmation mismatch
        $userData = [
            'name' => 'Test User',
            'phone' => '01912345678',
            'email' => 'mismatch@test.com',
            'password' => 'password123',
            'password_confirmation' => 'different123',
        ];

        $response = $this->post('/register', $userData);
        $response->assertStatus(302);
        $response->assertSessionHasErrors('password');
    }

    /**
     * Test duplicate phone number prevention during registration
     */
    public function test_duplicate_phone_number_prevention_during_registration()
    {
        // Create first user
        $firstUser = [
            'name' => 'First User',
            'phone' => '01712345678',
            'email' => 'first@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post('/register', $firstUser);
        $response->assertRedirect('/home');

        // Try to register second user with same phone
        $duplicateUser = [
            'name' => 'Second User',
            'phone' => '01712345678', // Same phone
            'email' => 'second@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post('/register', $duplicateUser);
        $response->assertStatus(302);
        $response->assertSessionHasErrors('phone');
        
        // Verify only one user with this phone exists
        $this->assertEquals(1, User::where('phone', '01712345678')->count());
    }

    /**
     * Test user login with phone number
     */
    public function test_user_login_with_phone_number()
    {
        // Create a user
        $user = User::factory()->create([
            'name' => 'Test User',
            'phone' => '01712345678',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Test login with phone and correct password
        $response = $this->post('/login', [
            'phone' => '01712345678',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);

        // Logout for next test
        $this->post('/logout');

        // Test login with phone and wrong password
        $response = $this->post('/login', [
            'phone' => '01712345678',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    /**
     * Test security - XSS prevention in registration form
     */
    public function test_xss_prevention_in_registration_form()
    {
        $xssPayloads = [
            '<script>alert("xss")</script>',
            'javascript:alert("xss")',
            '<img src=x onerror=alert("xss")>',
        ];

        foreach ($xssPayloads as $index => $payload) {
            $userData = [
                'name' => $payload,
                'phone' => '01712345' . sprintf('%03d', $index),
                'email' => 'xss' . $index . '@test.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ];

            $response = $this->post('/register', $userData);
            
            // Either validation should reject it or it should be sanitized
            if ($response->status() !== 302) {
                $user = User::where('phone', $userData['phone'])->first();
                if ($user) {
                    $this->assertStringNotContainsString('<script>', $user->name);
                }
            }
        }
    }
}