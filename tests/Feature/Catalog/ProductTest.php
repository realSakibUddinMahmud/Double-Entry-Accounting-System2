<?php

namespace Tests\Feature\Catalog;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Store;
use App\Models\Tax;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProductTest extends TestCase
{
    protected function authenticate(): User
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);
        $this->be($user);
        return $user;
    }

    public function test_create_product_with_mapping_valid(): void
    {
        $this->authenticate();

        // Seed minimal required records via DB (no factories)
        $categoryId = DB::connection('tenant')->table('categories')->insertGetId([
            'name' => 'Test Category',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $brandId = DB::connection('tenant')->table('brands')->insertGetId([
            'name' => 'Test Brand',
            'slug' => 'test-brand-'.uniqid(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $storeId = DB::connection('tenant')->table('stores')->insertGetId([
            'name' => 'Test Store',
            'address' => 'Dhaka',
            'status' => 1,
            'contact_no' => '01900000001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Use existing units if present; otherwise create a simple unit row
        $firstUnitId = (int) (DB::connection('tenant')->table('units')->min('id') ?? 0);
        if ($firstUnitId <= 0) {
            $firstUnitId = DB::connection('tenant')->table('units')->insertGetId([
                'name' => 'Unit',
                'symbol' => 'U',
                'conversion_factor' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $baseUnitId = $firstUnitId;
        $purchaseUnitId = $firstUnitId;
        $salesUnitId = $firstUnitId;

        $taxId = DB::connection('tenant')->table('taxes')->insertGetId([
            'name' => 'VAT',
            'rate' => 5.00,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $payload = [
            'store_id' => $storeId,
            'name' => 'Test Product',
            'sku' => 'SKU-TEST-001',
            'brand_id' => $brandId,
            'category_id' => $categoryId,
            'barcode' => '1234567890123',
            'base_unit_id' => $baseUnitId,
            'purchase_unit_id' => $purchaseUnitId,
            'sales_unit_id' => $salesUnitId,
            'purchase_cost' => 10.50,
            'cogs' => 10.50,
            'sales_price' => 15.25,
            'tax_id' => $taxId,
            'tax_method' => 'exclusive',
            'description' => 'Test description',
        ];

        $response = $this->post('/products', $payload);

        $response->assertStatus(302);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'category_id' => $categoryId,
            'brand_id' => $brandId,
            'sku' => 'SKU-TEST-001',
        ], 'tenant');

        $this->assertDatabaseHas('product_store', [
            'store_id' => $storeId,
            'purchase_cost' => 10.50,
            'sales_price' => 15.25,
            'tax_id' => $taxId,
            'tax_method' => 'exclusive',
        ], 'tenant');
    }

    public function test_create_product_invalid_unit_fk(): void
    {
        $this->authenticate();

        // Seed minimal required category and store
        $categoryId = DB::connection('tenant')->table('categories')->insertGetId([
            'name' => 'Invalid Test Category',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $storeId = DB::connection('tenant')->table('stores')->insertGetId([
            'name' => 'Invalid Test Store',
            'address' => 'Dhaka',
            'status' => 1,
            'contact_no' => '01900000002',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $payload = [
            'store_id' => $storeId,
            'name' => 'Invalid Units Product',
            'category_id' => $categoryId,
            'base_unit_id' => 999999,
            'purchase_unit_id' => 999998,
            'sales_unit_id' => 999997,
            'purchase_cost' => 5,
            'cogs' => 5,
            'sales_price' => 8,
            'tax_method' => 'exclusive',
        ];

        $response = $this->post('/products', $payload);

        $response->assertStatus(302); // validation redirects back
        $this->assertDatabaseMissing('products', ['name' => 'Invalid Units Product'], 'tenant');
    }
}

