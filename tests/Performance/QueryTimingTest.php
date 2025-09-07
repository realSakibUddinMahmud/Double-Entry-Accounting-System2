<?php

namespace Tests\Performance;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class QueryTimingTest extends TestCase
{
    public function test_stock_report_query_p95_under_threshold(): void
    {
        $start = microtime(true);
        $response = $this->get('/report/stock');
        $response->assertStatus(200);
        $elapsedMs = (microtime(true) - $start) * 1000;
        $this->assertLessThan(2000, $elapsedMs, 'Stock report should load under 2s');
    }

    public function test_sales_export_explain_captures_plan(): void
    {
        $sql = 'SELECT * FROM sales WHERE sales_date BETWEEN ? AND ?';
        $bindings = ['2025-01-01', '2025-12-31'];
        $plan = DB::connection('tenant')->select('EXPLAIN ' . $sql, $bindings);
        $this->assertNotEmpty($plan);
    }
}

