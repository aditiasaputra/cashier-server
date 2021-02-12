<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'id' => 1,
                'name' => 'Makanan',
                'description' => 'Ini adalah kategori untuk makanan.',
                'photo' => 'makanan.jpg'
            ],
            [
                'id' => 2,
                'name' => 'Minuman',
                'description' => 'Ini adalah kategori untuk minuman.',
                'photo' => 'minuman.jpg'
            ],
            [
                'id' => 3,
                'name' => 'Sayuran',
                'description' => 'Ini adalah kategori untuk sayuran.',
                'photo' => 'sayuran.jpg'
            ],
            [
                'id' => 4,
                'name' => 'Pakaian',
                'description' => 'Ini adalah kategori untuk pakaian.',
                'photo' => 'pakaian.jpg'
            ],
            [
                'id' => 5,
                'name' => 'Kesehatan',
                'description' => 'Ini adalah kategori untuk kesehatan.',
                'photo' => 'kesehatan.jpg'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
