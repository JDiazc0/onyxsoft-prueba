<?php

namespace App\Services;

use App\Models\Author;
use Illuminate\Database\Eloquent\Collection;

class AuthorServices
{
    /**
     * Get all authors.
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $authors = Author::all();
    }

    /**
     * Get a specific author.
     * @param int $id
     * @return Author
     */
    public function findAuthor(int $id): Author
    {
        return Author::with('books')->findOrFail($id);
    }

    /**
     * Create a new author.
     * @param array $data
     * @return Author
     */
    public function createAuthor(array $data): Author
    {
        $author =  Author::create(
            [
                'name' => $data['name'],
                'birth_date' => $data['birth_date'],
                'death_date' => $data['death_date'] ?? null,
            ]
        );

        return $author;
    }

    /**
     * Update an author.
     * @param array $data
     * @param int $id
     * @return Author
     */
    public function updateAuthor(array $data, int $id): Author
    {
        $author = Author::findOrFail($id);
        $updateData = [
            'name' => $data['name'] ?? $author->name,
            'birth_date' => $data['birth_date'] ?? $author->birth_date,
        ];

        if (array_key_exists('death_date', $data)) {
            $updateData['death_date'] = $data['death_date'];
        }

        $author->update($updateData);

        return $author;
    }

    /**
     * Delete an author.
     * @param int $id
     * @return bool
     */
    public function deleteAuthor(int $id): bool
    {
        $author = Author::findOrFail($id);
        return $author->delete();
    }
}
