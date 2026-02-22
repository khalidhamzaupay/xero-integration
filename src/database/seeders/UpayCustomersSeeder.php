<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UpayCustomersSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 20; $i++) {
            DB::table('upaycustomers')->insert([
                'name' => $faker->name,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'status' => $faker->randomElement(['active', 'inactive']),

                'address_1' => $faker->streetAddress,
                'city' => $faker->city,
                'region' => $faker->state,
                'country' => $faker->country,
                'postal' => $faker->postcode,

                'phone' => $faker->phoneNumber,
                'phone_code' => '+965',

                'website' => $faker->domainName,
                'notes' => $faker->sentence,
                'merchant_id' => $faker->numberBetween(1, 5),

                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
