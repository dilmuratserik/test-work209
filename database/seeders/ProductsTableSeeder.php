<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Product;
use Faker\Factory as Faker;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            Product::create([
                'name' => $faker->word,
                'price' => $faker->randomFloat(2, 10, 100),
                'stock' => $faker->numberBetween(1, 100),
            ]);
        }
    }
}
