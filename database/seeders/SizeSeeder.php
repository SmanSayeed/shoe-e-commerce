<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizes = [
            ['name' => 'Extra Small', 'code' => 'XS'],
            ['name' => 'Small', 'code' => 'S'],
            ['name' => 'Medium', 'code' => 'M'],
            ['name' => 'Large', 'code' => 'L'],
            ['name' => 'Extra Large', 'code' => 'XL'],
            ['name' => 'XXL', 'code' => 'XXL'],
            ['name' => 'XXXL', 'code' => 'XXXL'],
            ['name' => 'One Size', 'code' => 'OS'],
            ['name' => '5', 'code' => '5'],
            ['name' => '6', 'code' => '6'],
            ['name' => '7', 'code' => '7'],
            ['name' => '8', 'code' => '8'],
            ['name' => '9', 'code' => '9'],
            ['name' => '10', 'code' => '10'],
            ['name' => '11', 'code' => '11'],
            ['name' => '12', 'code' => '12'],
        ];

        foreach ($sizes as $size) {
            Size::updateOrCreate(['code' => $size['code']], $size);
        }
    }
}
