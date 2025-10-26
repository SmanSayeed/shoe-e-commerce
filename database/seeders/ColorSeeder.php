<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            ['name' => 'Red', 'code' => 'RED', 'hex_code' => '#FF0000'],
            ['name' => 'Blue', 'code' => 'BLUE', 'hex_code' => '#0000FF'],
            ['name' => 'Green', 'code' => 'GREEN', 'hex_code' => '#00FF00'],
            ['name' => 'Black', 'code' => 'BLACK', 'hex_code' => '#000000'],
            ['name' => 'White', 'code' => 'WHITE', 'hex_code' => '#FFFFFF'],
            ['name' => 'Yellow', 'code' => 'YELLOW', 'hex_code' => '#FFFF00'],
            ['name' => 'Orange', 'code' => 'ORANGE', 'hex_code' => '#FFA500'],
            ['name' => 'Purple', 'code' => 'PURPLE', 'hex_code' => '#800080'],
            ['name' => 'Pink', 'code' => 'PINK', 'hex_code' => '#FFC0CB'],
            ['name' => 'Brown', 'code' => 'BROWN', 'hex_code' => '#A52A2A'],
            ['name' => 'Gray', 'code' => 'GRAY', 'hex_code' => '#808080'],
            ['name' => 'Navy', 'code' => 'NAVY', 'hex_code' => '#000080'],
            ['name' => 'Maroon', 'code' => 'MAROON', 'hex_code' => '#800000'],
            ['name' => 'Olive', 'code' => 'OLIVE', 'hex_code' => '#808000'],
            ['name' => 'Teal', 'code' => 'TEAL', 'hex_code' => '#008080'],
        ];

        foreach ($colors as $color) {
            Color::updateOrCreate(['code' => $color['code']], $color);
        }
    }
}
