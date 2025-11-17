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
            // Men's sizes (US)
            ['name' => '39'],
            ['name' => '40'],
            ['name' => '41'],
        ];

        foreach ($sizes as $size) {
            Size::updateOrCreate(['name' => $size['name']], $size);
        }
    }
}
