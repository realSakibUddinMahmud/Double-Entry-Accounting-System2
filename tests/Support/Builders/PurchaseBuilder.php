<?php

namespace Tests\Support\Builders;

use App\Models\ProductStore;
use App\Models\Purchase;
use App\Models\PurchaseItem;

class PurchaseBuilder
{
    public static function makeWithItems(int $items = 1): Purchase
    {
        $purchase = \Database\Factories\PurchaseFactory::new()->create();

        for ($i = 0; $i < $items; $i++) {
            $ps = \Database\Factories\ProductStoreFactory::new()->create([
                'store_id' => $purchase->store_id,
            ]);

            \Database\Factories\PurchaseItemFactory::new()->create([
                'purchase_id' => $purchase->id,
                'product_id' => $ps->product_id,
                'unit_id' => $ps->purchase_unit_id,
            ]);
        }

        return $purchase->fresh('items');
    }
}

