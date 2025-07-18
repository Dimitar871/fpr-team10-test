<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('themes')->insert([
            [
                'id' => 1,
                'title' => 'Light mode',
                'main_color' => 'f9f9f9',
                'background_color' => 'eeeeee',
                'text_color' => '2e2e2e',
                'sub_color' => '3aa499',
                'accent_color' => '7be8dd',
                'edit_color' => '0000ff',
                'delete_color' => 'ff0000',
                'create_color' => '3aa499',
                'extra_color' => '305e56',
                'points' => 0,
            ],
            [
                'id' => 2,
                'title' => 'Dark mode',
                'main_color' => '222222',
                'background_color' => '121212',
                'text_color' => 'ffffff',
                'sub_color' => '3aa499',
                'accent_color' => '7be8dd',
                'edit_color' => '03dac6',
                'delete_color' => 'cf6679',
                'create_color' => '3700b3',
                'extra_color' => '7cc1b8',
                'points' => 0,
            ],
            [
                'id' => 3,
                'title' => 'Syntess',
                'main_color' => 'f9f9f9',
                'background_color' => 'c4ccc2',
                'text_color' => '004d40',
                'sub_color' => 'ad2424',
                'accent_color' => 'bf3d3d',
                'edit_color' => '00838f',
                'delete_color' => 'ad2424',
                'create_color' => '005e03',
                'extra_color' => 'c4ccc2',
                'points' => 100,
            ],
            [
                'id' => 4,
                'title' => 'Sunset Glow',
                'main_color' => 'f2edeb',
                'background_color' => '#e8d9e8',
                'text_color' => '925e78',
                'sub_color' => 'fabc2a',
                'accent_color' => 'f05365',
                'edit_color' => 'bd93bd',
                'delete_color' => 'f05365',
                'create_color' => 'fabc2a',
                'extra_color' => '925e78',
                'points' => 125,
            ],
            [
                'id' => 5,
                'title' => 'Forest Night',
                'main_color' => '5a9a4a',
                'background_color' => '4a7d32',
                'text_color' => '1b1b1b',
                'sub_color' => '388e3c',
                'accent_color' => '66bb6a',
                'edit_color' => '1b5e20',
                'delete_color' => 'd32f2f',
                'create_color' => '43a047',
                'extra_color' => '233a23',
                'points' => 150,
            ],
            [
                'id' => 6,
                'title' => 'Midnight Purple',
                'main_color' => '4b2179',
                'background_color' => '3d1a65',
                'text_color' => 'e0d7ff',
                'sub_color' => '4e157a',
                'accent_color' => '5e3ea1',
                'edit_color' => '6a1b9a',
                'delete_color' => 'b71c1c',
                'create_color' => '7b1fa2',
                'extra_color' => '715ca6',
                'points' => 175,
            ],
            [
                'id' => 7,
                'title' => 'Steampunk',
                'main_color' => '2e2e2e',
                'background_color' => '1a1a1a',
                'text_color' => 'dfd6c3',
                'sub_color' => '6a4b8a',
                'accent_color' => '7e57c2',
                'edit_color' => '7f8c8d',
                'delete_color' => 'c0392b',
                'create_color' => '27ae60',
                'extra_color' => 'b29472',
                'points' => 225,
            ],
            [
                'id' => 8,
                'title' => 'Old School',
                'main_color' => 'dfd6c3',
                'background_color' => 'd1c7b3',
                'text_color' => '2e2e2e',
                'sub_color' => 'b29472',
                'accent_color' => 'a67c00',
                'edit_color' => '7f8c8d',
                'delete_color' => 'c0392b',
                'create_color' => '27ae60',
                'extra_color' => '64583f',
                'points' => 300,
            ],
            [
                'id' => 9,
                'title' => 'Beige Red Blue',
                'main_color' => 'f5f1e8',
                'background_color' => 'e7e3d8',
                'text_color' => '2e2e2e',
                'sub_color' => 'b33a3a',
                'accent_color' => '3a57b5',
                'edit_color' => '8a2c2c',
                'delete_color' => 'b71c1c',
                'create_color' => '3a57b5',
                'extra_color' => '5a4d4e',
                'points' => 310,
            ],
            [
                'id' => 10,
                'title' => 'Navy Burgundy Beige',
                'main_color' => 'dcd3c9',
                'background_color' => 'c9bfb7',
                'text_color' => '2e2e2e',
                'sub_color' => '5a1a29',
                'accent_color' => '172d5b',
                'edit_color' => 'b7415e',
                'delete_color' => '9e1b23',
                'create_color' => '172d5b',
                'extra_color' => '492631',
                'points' => 320,
            ],
            [
                'id' => 11,
                'title' => 'Peaches',
                'main_color' => 'f0f0f0',
                'background_color' => 'e6e6e6',
                'text_color' => '2e2e2e',
                'sub_color' => 'd94f70',
                'accent_color' => 'f3c623',
                'edit_color' => '31a2ac',
                'delete_color' => 'd32f2f',
                'create_color' => '56b870',
                'extra_color' => '7a595d',
                'points' => 350,
            ],
            [
                'id' => 12,
                'title' => 'Grey',
                'main_color' => '2a2f45',
                'background_color' => '23283f',
                'text_color' => 'dfe6f0',
                'sub_color' => '4a5276',
                'accent_color' => '6272a3',
                'edit_color' => '7c94d1',
                'delete_color' => 'cc444b',
                'create_color' => '78b159',
                'extra_color' => '5a617b',
                'points' => 370,
            ],
            [
                'id' => 13,
                'title' => 'Daisy Flower',
                'main_color' => 'fffdee',
                'background_color' => 'fffbdc',
                'text_color' => '4a4a4a',
                'sub_color' => 'f7d354',
                'accent_color' => 'fce181',
                'edit_color' => 'dbba27',
                'delete_color' => 'd32f2f',
                'create_color' => '7bb661',
                'extra_color' => '6a6548',
                'points' => 390,
            ],
            [
                'id' => 14,
                'title' => 'Blue Mystique',
                'main_color' => '141d26',
                'background_color' => '0f1c2f',
                'text_color' => 'f0f4f8',
                'sub_color' => '4a90e2',
                'accent_color' => '1b263b',
                'edit_color' => '4a90e2',
                'delete_color' => 'd72631',
                'create_color' => '2e86ab',
                'extra_color' => '9b59b6',
                'points' => 180,
            ],
            [
                'id' => 15,
                'title' => 'Dark Red',
                'main_color' => '3a1e23',
                'background_color' => '2a1218',
                'text_color' => 'e3e3e3',
                'sub_color' => '541e3b',
                'accent_color' => '1f2a57',
                'edit_color' => 'a72d3b',
                'delete_color' => 'd32f2f',
                'create_color' => '3b7a57',
                'extra_color' => '502430',
                'points' => 430,
            ],
            [
                'id' => 16,
                'title' => 'Lavender and White',
                'main_color' => 'e8e6f9',
                'background_color' => 'd9d7f4',
                'text_color' => '3a3a3a',
                'sub_color' => 'a694c7',
                'accent_color' => 'b0a7e6',
                'edit_color' => '6651a4',
                'delete_color' => 'd32f2f',
                'create_color' => '7bb661',
                'extra_color' => '504d63',
                'points' => 450,
            ],
        ]);
    }
}
