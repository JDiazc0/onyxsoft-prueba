<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_authors()
    {
        $authors = Author::factory()->count(3)->create();

        $response = $this->getJson('/api/author');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'Authors' => [
                        '*' => [
                            'id',
                            'name',
                            'birth_date',
                            'death_date'
                        ]
                    ],
                    'total'
                ]
            ]);

        $this->assertEquals(3, $response->json('data.total'));
    }

    public function test_can_create_author()
    {
        $authorData = [
            'name' => 'John Doe',
            'birth_date' => '1950-01-01',
            'death_date' => null
        ];

        $response = $this->postJson('/api/author', $authorData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'name',
                    'birth_date',
                    'death_date'
                ]
            ]);

        $this->assertDatabaseHas('authors', $authorData);
    }

    public function test_can_show_author_with_books()
    {
        $author = Author::factory()->create();
        $books = Book::factory()->count(2)->create();
        $author->books()->attach($books->pluck('id'));

        $response = $this->getJson("/api/author/{$author->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'name',
                    'birth_date',
                    'death_date',
                    'books' => [
                        '*' => [
                            'id',
                            'title'
                        ]
                    ]
                ]
            ]);
    }

    public function test_can_update_author()
    {
        $author = Author::factory()->create();
        $updateData = [
            'name' => 'Updated Name',
            'birth_date' => '1960-01-01',
            'death_date' => '2020-01-01'
        ];

        $response = $this->putJson("/api/author/{$author->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'name',
                    'birth_date',
                    'death_date'
                ]
            ]);

        $this->assertDatabaseHas('authors', $updateData);
    }

    public function test_can_delete_author()
    {
        $author = Author::factory()->create();

        $response = $this->deleteJson("/api/author/{$author->id}");

        $response->assertStatus(200)
            ->assertJsonStructure(['message']);

        $this->assertDatabaseMissing('authors', ['id' => $author->id]);
    }
}
