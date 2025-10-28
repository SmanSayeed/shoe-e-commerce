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
            // Women's shoe sizes (US)
            ['name' => 'Women\'s 5', 'code' => 'W5'],
            ['name' => 'Women\'s 5.5', 'code' => 'W5.5'],
            ['name' => 'Women\'s 6', 'code' => 'W6'],
            ['name' => 'Women\'s 6.5', 'code' => 'W6.5'],
            ['name' => 'Women\'s 7', 'code' => 'W7'],
            ['name' => 'Women\'s 7.5', 'code' => 'W7.5'],
            ['name' => 'Women\'s 8', 'code' => 'W8'],
            ['name' => 'Women\'s 8.5', 'code' => 'W8.5'],
            ['name' => 'Women\'s 9', 'code' => 'W9'],
            ['name' => 'Women\'s 9.5', 'code' => 'W9.5'],
            ['name' => 'Women\'s 10', 'code' => 'W10'],
            ['name' => 'Women\'s 10.5', 'code' => 'W10.5'],
            ['name' => 'Women\'s 11', 'code' => 'W11'],
            ['name' => 'Women\'s 11.5', 'code' => 'W11.5'],
            ['name' => 'Women\'s 12', 'code' => 'W12'],

            // Men's shoe sizes (US)
            ['name' => 'Men\'s 6', 'code' => 'M6'],
            ['name' => 'Men\'s 6.5', 'code' => 'M6.5'],
            ['name' => 'Men\'s 7', 'code' => 'M7'],
            ['name' => 'Men\'s 7.5', 'code' => 'M7.5'],
            ['name' => 'Men\'s 8', 'code' => 'M8'],
            ['name' => 'Men\'s 8.5', 'code' => 'M8.5'],
            ['name' => 'Men\'s 9', 'code' => 'M9'],
            ['name' => 'Men\'s 9.5', 'code' => 'M9.5'],
            ['name' => 'Men\'s 10', 'code' => 'M10'],
            ['name' => 'Men\'s 10.5', 'code' => 'M10.5'],
            ['name' => 'Men\'s 11', 'code' => 'M11'],
            ['name' => 'Men\'s 11.5', 'code' => 'M11.5'],
            ['name' => 'Men\'s 12', 'code' => 'M12'],
            ['name' => 'Men\'s 13', 'code' => 'M13'],
            ['name' => 'Men\'s 14', 'code' => 'M14'],
            ['name' => 'Men\'s 15', 'code' => 'M15'],

            // Kids' shoe sizes (US)
            ['name' => 'Kids\' 1', 'code' => 'K1'],
            ['name' => 'Kids\' 2', 'code' => 'K2'],
            ['name' => 'Kids\' 3', 'code' => 'K3'],
            ['name' => 'Kids\' 4', 'code' => 'K4'],
            ['name' => 'Kids\' 5', 'code' => 'K5'],
            ['name' => 'Kids\' 6', 'code' => 'K6'],
            ['name' => 'Kids\' 7', 'code' => 'K7'],
            ['name' => 'Kids\' 8', 'code' => 'K8'],
            ['name' => 'Kids\' 9', 'code' => 'K9'],
            ['name' => 'Kids\' 10', 'code' => 'K10'],
            ['name' => 'Kids\' 11', 'code' => 'K11'],
            ['name' => 'Kids\' 12', 'code' => 'K12'],
            ['name' => 'Kids\' 13', 'code' => 'K13'],

            // Unisex/One Size
            ['name' => 'One Size', 'code' => 'OS'],
        ];

        foreach ($sizes as $size) {
            Size::updateOrCreate(['code' => $size['code']], $size);
        }
    }
}
