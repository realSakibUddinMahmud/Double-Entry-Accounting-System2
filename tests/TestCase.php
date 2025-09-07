<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Ensure a current tenant is set for multitenancy tests
        try {
            $tenant = \Spatie\Multitenancy\Models\Tenant::where('domain', '127.0.0.1')
                ->orWhere('domain', 'localhost')
                ->first();
            if ($tenant) {
                $tenant->makeCurrent();
            }
        } catch (\Throwable $e) {
            // ignore in case landlord connection is not ready
        }
    }
}
