<?php

namespace Tests\Support\Builders;

use App\Models\ProductStore;
use App\Models\Sale;
use App\Models\SaleItem;

class SaleBuilder
{
    public static function makeWithItems(int $items = 1): Sale
    {
        $sale = \Database\Factories\SaleFactory::new()->create();

        for ($i = 0; $i < $items; $i++) {
            $ps = \Database\Factories\ProductStoreFactory::new()->create([
                'store_id' => $sale->store_id,
            ]);

            \Database\Factories\SaleItemFactory::new()->create([
                'sale_id' => $sale->id,
                'product_id' => $ps->product_id,
                'unit_id' => $ps->sales_unit_id,
            ]);
        }

        return $sale->fresh('items');
    }
}

