<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('books')->insert([
            [
                'title' => 'Cien años de soledad',
                'genre' => 'Realismo mágico',
                'published_date' => '1967-05-30',
                'available' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => '1984',
                'genre' => 'Ciencia ficción',
                'published_date' => '1949-06-08',
                'available' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Don Quijote de la Mancha',
                'genre' => 'Novela',
                'published_date' => '1605-01-16',
                'available' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'El Principito',
                'genre' => 'Fábula',
                'published_date' => '1943-04-06',
                'available' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Rayuela',
                'genre' => 'Novela',
                'published_date' => '1963-06-28',
                'available' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
