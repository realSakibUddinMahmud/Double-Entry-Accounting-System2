<?php

namespace Tests\Feature\Reports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ExportTest extends TestCase
{
    protected function authenticate(): User
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
            'tenant_id' => 1,
        ]);
        $this->be($user);
        return $user;
    }

    public function test_sales_pdf_export_returns_pdf(): void
    {
        $this->authenticate();

        $response = $this->get('/report/sales/export?start_date=2025-01-01&end_date=2025-12-31');

        $response->assertStatus(200);
        $this->assertTrue(str_contains($response->headers->get('content-type'), 'application/pdf'));
    }
}

