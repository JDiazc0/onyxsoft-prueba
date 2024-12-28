<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_books()
    {
        $books = Book::factory()->count(3)->create();

        $response = $this->getJson('/api/book');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'Books' => [
                        '*' => [
                            'id',
                            'title',
                            'published_date',
                            'genre',
                            'available',
                        ]
                    ],
                    'total'
                ]
            ]);

        $this->assertEquals(3, $response->json('data.total'));
    }

    public function test_can_create_book_with_authors()
    {
        $authors = Author::factory()->count(2)->create();

        $bookData = [
            'title' => 'Test Book',
            'genre' => 'fiction',
            'published_date' => '2021-01-01',
            'auhtor_ids' => $authors->pluck('id')->toArray()
        ];

        $response = $this->postJson('/api/book', $bookData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'title',
                    'published_date',
                    'genre',
                ]
            ]);

        $this->assertDatabaseHas('books', [
            'title' => 'Test Book',
            'genre' => 'fiction',
            'published_date' => '2021-01-01'
        ]);
    }

    public function test_can_show_book()
    {
        $book = Book::factory()->create();
        $authors = Author::factory()->count(2)->create();
        $book->authors()->attach($authors->pluck('id'));

        $response = $this->getJson("/api/book/{$book->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'title',
                    'published_date',
                    'genre',
                    'authors' => [
                        '*' => [
                            'id',
                            'name'
                        ]
                    ]
                ]
            ]);
    }

    public function test_can_update_book()
    {
        $book = Book::factory()->create();

        $updateData = [
            'title' => 'Updated Title',
            'genre' => 'Updated Genre',
            'published_date' => '2024-02-01'
        ];

        $response = $this->putJson("/api/book/{$book->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'title',
                    'published_date',
                    'genre'
                ]
            ]);

        $this->assertDatabaseHas('books', $updateData);
    }

    public function test_can_rent_book()
    {
        $book = Book::factory()->create(['available' => true]);

        $response = $this->postJson("/api/book/{$book->id}/rent");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'title',
                    'published_date',
                    'genre'
                ]
            ]);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'available' => false
        ]);
    }

    public function test_cannot_rent_unavailable_book()
    {
        $book = Book::factory()->create(['available' => false]);

        $response = $this->postJson("/api/book/{$book->id}/rent");

        $response->assertStatus(400);
    }

    public function test_can_return_book()
    {
        $book = Book::factory()->create(['available' => false]);

        $response = $this->postJson("/api/book/{$book->id}/return");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'title',
                    'published_date',
                    'genre'
                ]
            ]);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'available' => true
        ]);
    }

    public function test_can_add_author_to_book()
    {
        $book = Book::factory()->create();
        $author = Author::factory()->create();

        $response = $this->postJson("/api/book/add-author/{$book->id}/{$author->id}");

        $response->assertStatus(200)
            ->assertJsonStructure(['message']);

        $this->assertDatabaseHas('author_books', [
            'book_id' => $book->id,
            'author_id' => $author->id
        ]);
    }

    public function test_can_remove_author_from_book()
    {
        $book = Book::factory()->create();
        $author = Author::factory()->create();
        $book->authors()->attach($author->id);

        $response = $this->postJson("/api/book/remove-author/{$book->id}/{$author->id}");

        $response->assertStatus(200)
            ->assertJsonStructure(['message']);

        $this->assertDatabaseMissing('author_books', [
            'book_id' => $book->id,
            'author_id' => $author->id
        ]);
    }

    public function test_can_delete_book()
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson("/api/book/{$book->id}");

        $response->assertStatus(200)
            ->assertJsonStructure(['message']);

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
}
