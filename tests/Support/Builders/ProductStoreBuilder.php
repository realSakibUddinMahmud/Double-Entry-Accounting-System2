<?php

namespace Tests\Support\Builders;

use App\Models\ProductStore;

class ProductStoreBuilder
{
    public static function make(): ProductStore
    {
        return \Database\Factories\ProductStoreFactory::new()->create();
    }
}

