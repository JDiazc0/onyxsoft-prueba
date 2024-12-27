<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('authors')->insert([
            [
                'name' => 'Gabriel García Márquez',
                'birth_date' => '1927-03-06',
                'death_date' => '2014-04-17',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'George Orwell',
                'birth_date' => '1903-06-25',
                'death_date' => '1950-01-21',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Miguel de Cervantes',
                'birth_date' => '1547-09-29',
                'death_date' => '1616-04-22',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Antoine de Saint-Exupéry',
                'birth_date' => '1900-06-29',
                'death_date' => '1944-07-31',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Julio Cortázar',
                'birth_date' => '1914-08-26',
                'death_date' => '1984-02-12',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
