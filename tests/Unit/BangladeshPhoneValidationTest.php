<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Rules\BangladeshPhone;

class BangladeshPhoneValidationTest extends TestCase
{
    private $rule;

    protected function setUp(): void
    {
        parent::setUp();
        $this->rule = new BangladeshPhone();
    }

    /**
     * Test valid Bangladesh phone numbers with local format
     */
    public function test_valid_local_phone_numbers()
    {
        $validNumbers = [
            '01712345678', // Grameenphone
            '01812345678', // Robi
            '01312345678', // Airtel
            '01412345678', // Banglalink
            '01512345678', // Teletalk
            '01612345678', // Airtel
            '01912345678', // Banglalink
        ];

        foreach ($validNumbers as $number) {
            $this->assertTrue(
                $this->rule->passes('phone', $number),
                "Number {$number} should be valid but was rejected"
            );
        }
    }

    /**
     * Test valid Bangladesh phone numbers with international format
     */
    public function test_valid_international_phone_numbers()
    {
        $validNumbers = [
            '+8801712345678', // Grameenphone
            '+8801812345678', // Robi
            '+8801312345678', // Airtel
            '+8801412345678', // Banglalink
            '+8801512345678', // Teletalk
            '+8801612345678', // Airtel
            '+8801912345678', // Banglalink
        ];

        foreach ($validNumbers as $number) {
            $this->assertTrue(
                $this->rule->passes('phone', $number),
                "Number {$number} should be valid but was rejected"
            );
        }
    }

    /**
     * Test invalid operator prefixes
     */
    public function test_invalid_operator_prefixes()
    {
        $invalidNumbers = [
            '01012345678', // Invalid prefix 010
            '01112345678', // Invalid prefix 011
            '01212345678', // Invalid prefix 012
            '+8801012345678', // Invalid prefix 010 with international format
            '+8801112345678', // Invalid prefix 011 with international format
            '+8801212345678', // Invalid prefix 012 with international format
        ];

        foreach ($invalidNumbers as $number) {
            $this->assertFalse(
                $this->rule->passes('phone', $number),
                "Number {$number} should be invalid but was accepted"
            );
        }
    }

    /**
     * Test invalid phone number lengths
     */
    public function test_invalid_phone_lengths()
    {
        $invalidNumbers = [
            '0171234567',      // Too short (10 digits)
            '017123456789',    // Too long (12 digits)
            '+880171234567',   // Too short international (13 characters)
            '+88017123456789', // Too long international (15 characters)
        ];

        foreach ($invalidNumbers as $number) {
            $this->assertFalse(
                $this->rule->passes('phone', $number),
                "Number {$number} should be invalid due to length but was accepted"
            );
        }
    }

    /**
     * Test invalid formats
     */
    public function test_invalid_formats()
    {
        $invalidNumbers = [
            '02012345678',    // Doesn't start with 01
            '1712345678',     // Missing leading 0
            '8801712345678',  // Missing + for international format
            '01712345abc',    // Contains letters
            'abc1234567890',  // Starts with letters
            '',               // Empty string
            '880-1712345678', // Invalid international format
        ];

        foreach ($invalidNumbers as $number) {
            $this->assertFalse(
                $this->rule->passes('phone', $number),
                "Number '{$number}' should be invalid due to format but was accepted"
            );
        }
    }

    /**
     * Test phone numbers with formatting characters
     */
    public function test_phone_numbers_with_formatting()
    {
        $formattedNumbers = [
            '017-1234-5678',   // With hyphens
            '017 1234 5678',   // With spaces
            '+880-17-1234-5678', // International with hyphens
            '+880 17 1234 5678', // International with spaces
        ];

        foreach ($formattedNumbers as $number) {
            $this->assertTrue(
                $this->rule->passes('phone', $number),
                "Formatted number '{$number}' should be valid but was rejected"
            );
        }
    }

    /**
     * Test validation error message
     */
    public function test_validation_error_message()
    {
        $message = $this->rule->message();
        
        $this->assertStringContainsString('Bangladesh phone number', $message);
        $this->assertStringContainsString('01XXXXXXXXX', $message);
        $this->assertStringContainsString('+8801XXXXXXXXX', $message);
        $this->assertStringContainsString('013, 014, 015, 016, 017, 018, 019', $message);
    }
}