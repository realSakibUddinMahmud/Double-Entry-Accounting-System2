<?php

use Illuminate\Database\Capsule\Manager as Capsule;

require __DIR__ . '/../vendor/autoload.php';

// Minimal bootstrap for running inside app context
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tenants = (int) (getenv('TENANTS') ?: 1);
$numProducts = (int) (getenv('PRODUCTS') ?: 100000);
$numSales = (int) (getenv('SALES') ?: 50000);

echo "Seeding scale data: tenants={$tenants} products={$numProducts} sales={$numSales}\n";

// Assume default tenant connection; adjust if needed
$now = now();

// Seed products in chunks
$chunk = 5000;
for ($i = 1; $i <= $numProducts; $i += $chunk) {
    $rows = [];
    $max = min($i + $chunk - 1, $numProducts);
    for ($j = $i; $j <= $max; $j++) {
        $rows[] = [
            'name' => "Product {$j}",
            'sku' => sprintf('SKU-%06d', $j),
            'unit_id' => 1,
            'category_id' => 1,
            'brand_id' => 1,
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }
    \DB::connection('tenant')->table('products')->insertOrIgnore($rows);
    echo ".";
}
echo "\nProducts seeded.\n";

// Seed random sales headers/items minimal shape if tables exist
if (\Schema::connection('tenant')->hasTable('sales') && \Schema::connection('tenant')->hasTable('sale_items')) {
    $storeId = 1;
    $salesChunk = 2000;
    for ($i = 1; $i <= $numSales; $i += $salesChunk) {
        $max = min($i + $salesChunk - 1, $numSales);
        $sales = [];
        for ($s = $i; $s <= $max; $s++) {
            $sales[] = [
                'store_id' => $storeId,
                'customer_id' => 1,
                'sales_date' => $now->copy()->subDays(rand(0, 90)),
                'total_amount' => rand(100, 10000) / 100,
                'payment_status' => 'paid',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        \DB::connection('tenant')->table('sales')->insert($sales);
        echo ".";
    }
    echo "\nSales seeded.\n";
}

echo "Done.\n";

