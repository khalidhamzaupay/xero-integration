<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UpayProductsSeeder extends Seeder
{
    public function run(): void
    {
        $products = [];

        for ($i = 1; $i <= 100; $i++) {
            $salePrice = rand(500, 5000) / 100;   // 5.00 – 50.00
            $costPrice = rand(300, 4000) / 100;   // 3.00 – 40.00

            $products[] = [
                'code'         => 'P-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'name'         => 'Product ' . $i,
                'description'  => 'Auto generated product #' . $i,

                // sales
                'sale_price'   => $salePrice,
                'sale_tax'     => 'NONE',

                // purchase
                'cost_price'   => $costPrice,
                'purchase_tax' => 'NONE',

                // inventory
                'quantity'     => rand(0, 500),
                'is_inventory' => (bool) rand(0, 1),

                // status
                'active'       => (bool) rand(0, 1),
                'merchant_id'  => 1,

                'created_at'   => now(),
                'updated_at'   => now(),
            ];
        }

        DB::table('upayproducts')->insert($products);
    }
}
