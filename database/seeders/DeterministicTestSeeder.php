<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeterministicTestSeeder extends Seeder
{
    public function run(): void
    {
        // Minimal deterministic data for tests; idempotent via upsert
        DB::table('stores')->updateOrInsert(['id' => 1], [
            'id' => 1,
            'name' => 'Main Store',
            'address' => 'Dhaka',
            'status' => 1,
            'contact_no' => '01900000000',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('categories')->updateOrInsert(['id' => 1], [
            'id' => 1,
            'name' => 'General',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('units')->updateOrInsert(['id' => 1], [
            'id' => 1,
            'name' => 'Piece',
            'symbol' => 'pc',
            'conversion_factor' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

