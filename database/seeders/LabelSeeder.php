<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $labels = [
            ['name' => 'Politics', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Health', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Food', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Technology', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Education', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Environment', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sports', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Fashion', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Travel', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Finance', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Culture', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Science', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Art', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'History', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Music', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Literature', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Psychology', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Space', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Economy', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Philosophy', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($labels as $label) {
            DB::table('labels')->insert($label);
        };
    }
}
