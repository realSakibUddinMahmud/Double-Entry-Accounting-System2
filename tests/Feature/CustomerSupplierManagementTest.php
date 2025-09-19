<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Customer;
use App\Models\Supplier;

class CustomerSupplierManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '01712345678',
        ]);
        
        $this->actingAs($this->user);
    }

    /**
     * Test customer creation with valid Bangladesh phone numbers
     */
    public function test_customer_creation_with_valid_bangladesh_phone()
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
        ];

        foreach ($validPhoneNumbers as $phone) {
            $customerData = [
                'name' => 'Test Customer ' . substr($phone, -4),
                'phone' => $phone,
                'email' => 'customer' . substr($phone, -4) . '@test.com',
                'address' => 'Test Address, Dhaka',
            ];

            $response = $this->post(route('customers.store'), $customerData);
            
            // Should redirect back with success or create successfully
            $this->assertNotEquals(422, $response->status(), 
                "Phone {$phone} should be valid but validation failed");
                
            // Check if customer was created
            $this->assertDatabaseHas('customers', [
                'phone' => $phone,
                'name' => $customerData['name'],
            ]);
        }
    }

    /**
     * Test customer creation with invalid Bangladesh phone numbers
     */
    public function test_customer_creation_with_invalid_bangladesh_phone()
    {
        $invalidPhoneNumbers = [
            '01012345678', // Invalid operator 010
            '01112345678', // Invalid operator 011
            '01212345678', // Invalid operator 012
            '0171234567',  // Too short
            '017123456789', // Too long
            '02012345678', // Doesn't start with 01
            '01712345abc', // Contains letters
            '+8801012345678', // Invalid operator with international format
        ];

        foreach ($invalidPhoneNumbers as $phone) {
            $customerData = [
                'name' => 'Test Customer',
                'phone' => $phone,
                'email' => 'test@example.com',
                'address' => 'Test Address',
            ];

            $response = $this->post(route('customers.store'), $customerData);
            
            // Should return validation error
            $response->assertStatus(302); // Redirect back with errors
            $response->assertSessionHasErrors('phone');
            
            // Check that customer was NOT created
            $this->assertDatabaseMissing('customers', [
                'phone' => $phone,
            ]);
        }
    }

    /**
     * Test supplier creation with Bangladesh phone validation
     */
    public function test_supplier_creation_with_bangladesh_phone_validation()
    {
        // Valid supplier data
        $validSupplierData = [
            'name' => 'ABC Trading Company',
            'contact_person' => 'Mr. Rahman',
            'phone' => '01712345678',
            'email' => 'abc@trading.com',
            'address' => 'Dhanmondi, Dhaka',
        ];

        $response = $this->post(route('suppliers.store'), $validSupplierData);
        
        $this->assertNotEquals(422, $response->status());
        $this->assertDatabaseHas('suppliers', [
            'phone' => '01712345678',
            'name' => 'ABC Trading Company',
        ]);

        // Invalid supplier data with wrong phone
        $invalidSupplierData = [
            'name' => 'XYZ Company',
            'contact_person' => 'Mr. Karim',
            'phone' => '01012345678', // Invalid operator
            'email' => 'xyz@company.com',
            'address' => 'Gulshan, Dhaka',
        ];

        $response = $this->post(route('suppliers.store'), $invalidSupplierData);
        
        $response->assertStatus(302);
        $response->assertSessionHasErrors('phone');
        $this->assertDatabaseMissing('suppliers', [
            'phone' => '01012345678',
        ]);
    }

    /**
     * Test customer name validation
     */
    public function test_customer_name_validation()
    {
        // Valid names
        $validNames = [
            'John Doe',
            'মোহাম্মদ রহিম',
            'A', // Single character
            'O\'Connor', // Apostrophe
        ];

        foreach ($validNames as $name) {
            $customerData = [
                'name' => $name,
                'phone' => '01712345678',
                'email' => 'test@example.com',
            ];

            $response = $this->post(route('customers.store'), $customerData);
            $this->assertNotEquals(422, $response->status(), 
                "Name '{$name}' should be valid but was rejected");
        }

        // Invalid names
        $invalidData = [
            ['name' => '', 'phone' => '01712345678'], // Empty name
            ['name' => str_repeat('A', 256), 'phone' => '01712345678'], // Too long
        ];

        foreach ($invalidData as $data) {
            $response = $this->post(route('customers.store'), $data);
            $response->assertStatus(302);
            $response->assertSessionHasErrors('name');
        }
    }

    /**
     * Test customer email validation
     */
    public function test_customer_email_validation()
    {
        // Valid emails (including empty since it's optional)
        $validEmails = [
            'user@example.com',
            'test.email+tag@domain.co.uk',
            '', // Empty email should be allowed
            null, // Null email should be allowed
        ];

        foreach ($validEmails as $email) {
            $customerData = [
                'name' => 'Test Customer',
                'phone' => '01712345' . sprintf('%03d', array_search($email, $validEmails)),
                'email' => $email,
            ];

            $response = $this->post(route('customers.store'), $customerData);
            $this->assertNotEquals(422, $response->status(), 
                "Email '{$email}' should be valid but was rejected");
        }

        // Invalid emails
        $invalidEmails = [
            'invalid-email',
            '@domain.com',
            'user@',
            'user@domain',
        ];

        foreach ($invalidEmails as $email) {
            $customerData = [
                'name' => 'Test Customer',
                'phone' => '01712345' . sprintf('%03d', array_search($email, $invalidEmails) + 100),
                'email' => $email,
            ];

            $response = $this->post(route('customers.store'), $customerData);
            $response->assertStatus(302);
            $response->assertSessionHasErrors('email');
        }
    }

    /**
     * Test duplicate phone number prevention
     */
    public function test_duplicate_phone_number_prevention()
    {
        // Create first customer
        $customerData = [
            'name' => 'First Customer',
            'phone' => '01712345678',
            'email' => 'first@test.com',
        ];

        $response = $this->post(route('customers.store'), $customerData);
        $this->assertNotEquals(422, $response->status());

        // Try to create second customer with same phone
        $duplicateData = [
            'name' => 'Second Customer',
            'phone' => '01712345678', // Same phone
            'email' => 'second@test.com',
        ];

        $response = $this->post(route('customers.store'), $duplicateData);
        $response->assertStatus(302);
        $response->assertSessionHasErrors('phone');
        
        // Verify only one customer exists with this phone
        $this->assertEquals(1, Customer::where('phone', '01712345678')->count());
    }

    /**
     * Test Bengali language support in customer data
     */
    public function test_bengali_language_support_in_customer_data()
    {
        $bengaliCustomerData = [
            'name' => 'মোহাম্মদ রহিম উদ্দিন',
            'phone' => '01712345678',
            'email' => 'rahim@example.com',
            'address' => 'ঢাকা, বাংলাদেশ',
        ];

        $response = $this->post(route('customers.store'), $bengaliCustomerData);
        $this->assertNotEquals(422, $response->status());
        
        $this->assertDatabaseHas('customers', [
            'name' => 'মোহাম্মদ রহিম উদ্দিন',
            'address' => 'ঢাকা, বাংলাদেশ',
        ]);
    }

    /**
     * Test security - XSS prevention in customer forms
     */
    public function test_xss_prevention_in_customer_forms()
    {
        $xssAttempts = [
            '<script>alert("xss")</script>',
            'javascript:alert("xss")',
            '<img src=x onerror=alert("xss")>',
        ];

        foreach ($xssAttempts as $xssPayload) {
            $customerData = [
                'name' => $xssPayload,
                'phone' => '01712345' . sprintf('%03d', array_search($xssPayload, $xssAttempts)),
                'email' => 'test@example.com',
                'address' => $xssPayload,
            ];

            $response = $this->post(route('customers.store'), $customerData);
            
            // Either the input should be rejected or sanitized
            // We'll check that the raw script tags are not stored
            if ($response->status() !== 422) {
                $customer = Customer::where('phone', $customerData['phone'])->first();
                if ($customer) {
                    $this->assertStringNotContainsString('<script>', $customer->name);
                    $this->assertStringNotContainsString('<script>', $customer->address);
                }
            }
        }
    }
}