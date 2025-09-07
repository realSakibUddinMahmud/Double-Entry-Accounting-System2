<?php

namespace Tests\Feature\Tenancy;

use Illuminate\Support\Facades\DB;
use Spatie\Multitenancy\Models\Tenant;
use Tests\TestCase;

class TenantIsolationTest extends TestCase
{
    public function test_data_isolated_between_tenants(): void
    {
        // Assume tenant_demo_test already current via TestCase setUp.
        // Insert a product in current tenant
        $pid = DB::connection('tenant')->table('products')->insertGetId([
            'category_id' => DB::connection('tenant')->table('categories')->insertGetId(['name' => 'IsoCat', 'created_at' => now(), 'updated_at' => now()]),
            'name' => 'Isolated Product ' . uniqid(),
            'status' => 1,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $this->assertNotNull($pid);

        // Verify isolation by querying the other database directly via fully qualified name
        $otherCount = DB::connection('tenant')->selectOne('SELECT COUNT(*) AS c FROM tenant_other_test.products WHERE id = ?', [$pid])->c ?? 0;
        $this->assertSame(0, (int) $otherCount);
    }
}

