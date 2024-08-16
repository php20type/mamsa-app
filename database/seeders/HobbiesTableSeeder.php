<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HobbiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hobbies = [
            ['name' => 'Gardening', 'status' => 1],
            ['name' => 'Football', 'status' => 1],
            ['name' => 'Books', 'status' => 1],
            ['name' => 'Hiking and nature', 'status' => 1],
            ['name' => 'Pets', 'status' => 1],
            ['name' => 'Grandchildren', 'status' => 1],
            ['name' => 'Arts and crafts', 'status' => 1],
            ['name' => 'Music', 'status' => 1],
            ['name' => 'Travels', 'status' => 1],
            ['name' => 'Quotes and facts', 'status' => 1],
            ['name' => 'Folklore', 'status' => 1],
            ['name' => 'History', 'status' => 1],
        ];

        DB::table('hobbies')->insert($hobbies);
    }
}
