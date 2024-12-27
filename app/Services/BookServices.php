<?php

namespace App\Services;

use App\Models\Author;
use App\Models\Book;
use App\Models\RentBook;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class BookServices
{
    /**
     * Get all books.
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $books = Book::all();
    }

    /**
     * Get a specific book.
     * @param int $id
     * @return Book
     *      */
    public function findBook(int $id): Book
    {
        return Book::with('authors')->findOrFail($id);
    }

    /**
     * Create a new book.
     * @param array $data
     * @return Book
     */
    public function createBook(array $data): Book
    {
        $book =  Book::create(
            [
                'title' => $data['title'],
                'genre' => $data['genre'],
                'published_date' => $data['published_date'],
            ]
        );

        if (isset($data['author_ids'])) {
            $book->authors()->attach($data['author_ids']);
        }

        return $book;
    }

    /**
     * Update an book.
     * @param array $data
     * @param int $id
     * @return Book
     */
    public function updateBook(array $data, int $id): Book
    {
        $book = Book::findOrFail($id);
        $updateData = [
            'title' => $data['title'] ?? $book->title,
            'published_date' => $data['published_date'] ?? $book->published_date,
            'genre' => $data['genre'] ?? $book->genre,
        ];

        $book->update($updateData);

        return $book;
    }

    /**
     * Rent a book.
     * @param int $book_id
     * @return Book
     */
    public function rentBook(int $book_id): Book
    {
        return DB::transaction(function () use ($book_id) {
            $book = Book::findOrFail($book_id);

            if (!$book->available) {
                throw new \Exception('Book is not available', 400);
            }

            $book->update(['available' => false]);

            return $book;
        });
    }

    /**
     * Return a rented book.
     * @param int $book_id
     * @return Book
     */
    public function returnBook(int $book_id): Book
    {
        return DB::transaction(function () use ($book_id) {
            $book = Book::findOrFail($book_id);

            $book->update(['available' => true]);;

            return $book;
        });
    }

    /**
     * Add an author to a book.
     * @param int $book_id
     * @param int $author_id
     * @return void
     */
    public function addAuthorToBook(int $book_id, int $author_id): void
    {
        DB::transaction(function () use ($book_id, $author_id) {
            $book = Book::findOrFail($book_id);
            $author = Author::findOrFail($author_id);

            // Crear la relación sin duplicar registros existentes
            $book->authors()->syncWithoutDetaching([$author_id]);
        });
    }

    /**
     * Remove an author from a book.
     */
    public function removeAuthorFromBook(int $bookId, int $authorId): void
    {
        DB::transaction(function () use ($bookId, $authorId) {

            $book = Book::findOrFail($bookId);

            $exists = $book->authors()->where('author_id', $authorId)->exists();

            if (!$exists) {
                throw new \Exception('The specified relationship does not exist.', 404);
            }

            $book->authors()->detach($authorId);
        });
    }

    /**
     * Delete an book.
     * @param int $id
     * @return bool
     */
    public function deleteBook(int $id): bool
    {
        $book = Book::findOrFail($id);
        return $book->delete();
    }
}
