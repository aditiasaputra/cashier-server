<?php

namespace Database\Seeders;

use App\Models\Prefix;
use Illuminate\Database\Seeder;

class PrefixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prefixes = [
            [
                'id' => 1,
                'name' => 'INV-2020',
                'active' => false
            ],
            [
                'id' => 2,
                'name' => 'INV-2021',
                'active' => true
            ],
            [
                'id' => 3,
                'name' => 'INV-2022',
                'active' => false
            ],
        ];

        foreach ($prefixes as $prefix) {
            Prefix::create($prefix);
        }
    }
}
