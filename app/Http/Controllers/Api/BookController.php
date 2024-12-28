<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResponse;
use App\Models\Author;
use App\Models\Book;
use App\Services\BookServices;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookServices $bookService)
    {
        $this->bookService = $bookService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = $this->bookService->getAll();

        return response()->json([
            'message' => 'Books retrieved successfully',
            'data' => new BookCollection($books)
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $data = $request->validated();

        $book = $this->bookService->createBook($data);

        return response()->json([
            'message' => 'Book created successfully',
            'data' => new BookResponse($book)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $bookFinded = $this->bookService->findBook($book->id);

        return response()->json([
            'message' => 'Book retrieved successfully',
            'data' => new BookResponse($bookFinded)
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $data = $request->validated();

        $book = $this->bookService->updateBook($data, $book->id);

        return response()->json([
            'message' => 'Book updated successfully',
            'data' => new BookResponse($book)
        ], Response::HTTP_OK);
    }

    /**
     * Rent a specified book to a client.
     */
    public function rentBook(Book $book)
    {
        try {
            $rentBook = $this->bookService->rentBook($book->id);

            return response()->json([
                'message' => 'Book rented successfully',
                'data' => new BookResponse($rentBook)
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Rent a specified book to a client.
     */
    public function returnBook(Book $book)
    {
        $rentBook = $this->bookService->returnBook($book->id);

        return response()->json([
            'message' => 'Book returned correctly',
            'data' => new BookResponse($rentBook)
        ], Response::HTTP_OK);
    }

    /**
     * Add an author to a book.
     */
    public function addAuthor(Book $book, Author $author)
    {
        $this->bookService->addAuthorToBook($book->id, $author->id);

        return response()->json([
            'message' => 'Author added to book successfully'
        ], Response::HTTP_OK);
    }

    /**
     * Remove an author to a book.
     */
    public function removeAuthor(Book $book, Author $author)
    {
        try {
            $this->bookService->removeAuthorFromBook($book->id, $author->id);

            return response()->json([
                'message' => 'Author removed from book successfully.',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $this->bookService->deleteBook($book->id);

        return response()->json([
            'message' => 'Book deleted successfully'
        ], Response::HTTP_OK);
    }
}
