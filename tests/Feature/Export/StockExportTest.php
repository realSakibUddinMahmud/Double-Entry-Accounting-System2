<?php

namespace Tests\Feature\Export;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class StockExportTest extends TestCase
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

    public function test_stock_pdf_export_returns_pdf(): void
    {
        $this->authenticate();

        $response = $this->get('/report/stock/export');

        $response->assertStatus(200);
        $this->assertStringContainsString('application/pdf', (string) $response->headers->get('content-type'));
        $content = $response->getContent();
        $this->assertNotEmpty($content);
        $this->assertTrue(str_starts_with($content, '%PDF'));
    }
}

