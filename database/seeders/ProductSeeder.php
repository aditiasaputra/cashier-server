<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'id' => 1,
                'category_id' => 1,
                'name' => 'Mie Instan',
                'weight' => 25,
                'price' => 3000,
                'stock' => 100,
                'photo' => 'mie.jpg'
            ],
            [
                'id' => 2,
                'category_id' => 5,
                'name' => 'Sabun Ok',
                'weight' => 20,
                'price' => 2500,
                'stock' => 100,
                'photo' => 'sabun-ok.jpg'
            ],
            [
                'id' => 3,
                'category_id' => 4,
                'name' => 'Baju bola',
                'weight' => 50,
                'price' => 10000,
                'stock' => 50,
                'photo' => 'baju-bola.jpg'
            ],
            [
                'id' => 4,
                'category_id' => 1,
                'name' => 'Snack',
                'weight' => 20,
                'price' => 10000,
                'stock' => 100,
                'photo' => 'snack.jpg'
            ],
            [
                'id' => 5,
                'category_id' => 2,
                'name' => 'Cola',
                'weight' => 100,
                'price' => 5000,
                'stock' => 100,
                'photo' => 'cola.jpg'
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
