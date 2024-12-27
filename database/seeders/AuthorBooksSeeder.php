<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorBooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('author_books')->insert([
            [
                'author_id' => 1,
                'book_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'author_id' => 2,
                'book_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'author_id' => 3,
                'book_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'author_id' => 4,
                'book_id' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'author_id' => 5,
                'book_id' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
