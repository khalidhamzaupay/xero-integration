<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpayCreditsSeeder extends Seeder
{
    public function run(): void
    {
        // Get all customers
        $customers = DB::table('upaycustomers')->get();

        $credits = [];

        foreach ($customers as $customer) {
            // Each customer gets 1-3 random credits
            $numCredits = rand(1, 3);
            for ($i = 0; $i < $numCredits; $i++) {
                $credits[] = [
                    'type'       => 'advance',
                    'contact_id' => $customer->id,
                    'date'       => now()->subDays(rand(0, 30))->toDateString(),
                    'status'     => 'AUTHORISED',
                    'reference'  => 'CR-' . $customer->id . '-' . rand(1000, 9999),
                    'amount'     => rand(50, 500), // random amount
                    'merchant_id'=> $customer->merchant_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('upaycredits')->insert($credits);
    }
}
