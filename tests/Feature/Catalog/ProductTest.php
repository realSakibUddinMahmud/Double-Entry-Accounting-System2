<?php

namespace Tests\Feature\Catalog;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Store;
use App\Models\Tax;
use App\Models\Unit;
use App\Models\User;
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

        $category = Category::factory()->create();
        $brand = Brand::factory()->create();
        $store = Store::factory()->create();
        $baseUnit = Unit::factory()->create(['conversion_factor' => 1]);
        $purchaseUnit = Unit::factory()->create();
        $salesUnit = Unit::factory()->create();
        $tax = Tax::factory()->create();

        $payload = [
            'store_id' => $store->id,
            'name' => 'Test Product',
            'sku' => 'SKU-TEST-001',
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'barcode' => '1234567890123',
            'base_unit_id' => $baseUnit->id,
            'purchase_unit_id' => $purchaseUnit->id,
            'sales_unit_id' => $salesUnit->id,
            'purchase_cost' => 10.50,
            'cogs' => 10.50,
            'sales_price' => 15.25,
            'tax_id' => $tax->id,
            'tax_method' => 'exclusive',
            'description' => 'Test description',
        ];

        $response = $this->post('/products', $payload);

        $response->assertStatus(302);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'sku' => 'SKU-TEST-001',
        ]);

        $this->assertDatabaseHas('product_store', [
            'store_id' => $store->id,
            'purchase_cost' => 10.50,
            'sales_price' => 15.25,
            'tax_id' => $tax->id,
            'tax_method' => 'exclusive',
        ]);
    }

    public function test_create_product_invalid_unit_fk(): void
    {
        $this->authenticate();

        $category = Category::factory()->create();
        $store = Store::factory()->create();

        $payload = [
            'store_id' => $store->id,
            'name' => 'Invalid Units Product',
            'category_id' => $category->id,
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
        $this->assertDatabaseMissing('products', ['name' => 'Invalid Units Product']);
    }
}

