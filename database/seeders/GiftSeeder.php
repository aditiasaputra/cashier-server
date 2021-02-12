<?php

namespace Database\Seeders;

use App\Models\Gift;
use Illuminate\Database\Seeder;

class GiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gift::create([
            'name' => 'Kaos Bola',
            'point' => 100,
            'stock' => 50,
            'photo' => 'kaos-bola.jpg'
        ]);
    }
}
