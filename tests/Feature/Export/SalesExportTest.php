<?php

namespace Tests\Feature\Export;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SalesExportTest extends TestCase
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

    public function test_sales_pdf_export_returns_pdf_with_content_disposition(): void
    {
        $this->authenticate();

        $response = $this->get('/report/sales/export?start_date=2025-01-01&end_date=2025-12-31');

        $response->assertStatus(200);
        $this->assertStringContainsString('application/pdf', (string) $response->headers->get('content-type'));
        $this->assertStringContainsString('attachment; filename=', (string) $response->headers->get('content-disposition'));

        $content = $response->getContent();
        $this->assertNotEmpty($content);
        $this->assertTrue(str_starts_with($content, '%PDF'));
    }
}

