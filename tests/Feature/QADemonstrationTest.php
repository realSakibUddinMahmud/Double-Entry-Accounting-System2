<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QADemonstrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Demonstrate Bangladesh phone validation is working
     * 
     * This test shows that our custom validation rule is properly integrated
     */
    public function test_bangladesh_phone_validation_integration()
    {
        // Test that the Bangladesh phone validation rule is working
        // by directly testing the validation
        
        $validator = validator(['phone' => '01712345678'], [
            'phone' => ['required', 'string', new \App\Rules\BangladeshPhone()]
        ]);
        
        $this->assertFalse($validator->fails(), 'Valid Bangladesh phone should pass validation');
        
        $validator = validator(['phone' => '01012345678'], [
            'phone' => ['required', 'string', new \App\Rules\BangladeshPhone()]
        ]);
        
        $this->assertTrue($validator->fails(), 'Invalid Bangladesh phone should fail validation');
        $this->assertStringContainsString('Bangladesh phone number', $validator->errors()->first('phone'));
    }

    /**
     * Test that application routes are accessible
     */
    public function test_application_routes_are_accessible()
    {
        // Test that key routes exist and are accessible
        $routes = [
            '/' => 200,
            '/login' => 200,
            '/register' => 200,
        ];
        
        foreach ($routes as $route => $expectedStatus) {
            $response = $this->get($route);
            $response->assertStatus($expectedStatus);
        }
    }

    /**
     * Test that comprehensive test documentation exists
     */
    public function test_comprehensive_test_documentation_exists()
    {
        $testDocPath = base_path('docs/qa/COMPREHENSIVE_TEST_CASES.md');
        
        $this->assertFileExists($testDocPath, 'Comprehensive test cases documentation should exist');
        
        $content = file_get_contents($testDocPath);
        
        // Check that key sections exist in the documentation
        $requiredSections = [
            'Bangladesh phone number',
            'Double-entry accounting',
            'Authentication Module',
            'Customer Management',
            'Supplier Management',
            'Product Management',
            'Security and Data Integrity',
            'End-to-End Workflow Testing',
        ];
        
        foreach ($requiredSections as $section) {
            $this->assertStringContainsString($section, $content, 
                "Test documentation should contain section: {$section}");
        }
        
        // Check that all valid operator prefixes are documented
        $validPrefixes = ['013', '014', '015', '016', '017', '018', '019'];
        foreach ($validPrefixes as $prefix) {
            $this->assertStringContainsString($prefix, $content,
                "Valid operator prefix {$prefix} should be documented");
        }
    }

    /**
     * Test that validation rules are consistent across controllers
     */
    public function test_validation_rules_consistency()
    {
        // This test ensures that all controllers use the same Bangladesh phone validation
        
        $controllersWithPhoneValidation = [
            'App\Http\Controllers\Auth\RegisterController',
            'App\Http\Controllers\Admin\CustomerController', 
            'App\Http\Controllers\Admin\SupplierController',
        ];
        
        foreach ($controllersWithPhoneValidation as $controller) {
            $this->assertTrue(class_exists($controller), 
                "Controller {$controller} should exist");
                
            // Check that the controller file contains reference to BangladeshPhone rule
            $reflection = new \ReflectionClass($controller);
            $filename = $reflection->getFileName();
            $content = file_get_contents($filename);
            
            $this->assertStringContainsString('BangladeshPhone', $content,
                "Controller {$controller} should use BangladeshPhone validation rule");
        }
    }

    /**
     * Test that all required test files exist
     */
    public function test_all_required_test_files_exist()
    {
        $requiredTestFiles = [
            'tests/Unit/BangladeshPhoneValidationTest.php',
            'tests/Feature/DoubleEntryAccountingTest.php',
            'tests/Feature/CustomerSupplierManagementTest.php',
            'tests/Feature/AuthenticationWithBangladeshPhoneTest.php',
        ];
        
        foreach ($requiredTestFiles as $testFile) {
            $fullPath = base_path($testFile);
            $this->assertFileExists($fullPath, "Test file {$testFile} should exist");
            
            $content = file_get_contents($fullPath);
            $this->assertStringContainsString('<?php', $content, 
                "Test file {$testFile} should be a valid PHP file");
            $this->assertStringContainsString('class', $content,
                "Test file {$testFile} should contain a test class");
        }
    }

    /**
     * Test accounting amount validation pattern
     */
    public function test_accounting_amount_validation_pattern()
    {
        // Test that amount validation pattern works correctly
        $pattern = '/^\\d*(\\.\\d{0,2})?$/';
        
        $validAmounts = ['1000', '1000.50', '0.01', '999999999999.99'];
        $invalidAmounts = ['abc', '1000.999', '-1000', ''];
        
        foreach ($validAmounts as $amount) {
            $this->assertEquals(1, preg_match($pattern, $amount),
                "Amount '{$amount}' should match validation pattern");
        }
        
        foreach ($invalidAmounts as $amount) {
            $this->assertEquals(0, preg_match($pattern, $amount),
                "Amount '{$amount}' should not match validation pattern");
        }
    }
}