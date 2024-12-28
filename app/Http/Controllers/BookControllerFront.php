<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BookController;
use App\Models\Book;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;

class BookControllerFront extends Controller
{

    public function index(): View
    {
        $bookController = new BookController(app('App\Services\BookServices'));
        $response = $bookController->index();

        $books = $response->getData(true)['data']['Books'] ?? [];

        return view('books.index', compact('books'));
    }

    public function show($book_id): View
    {
        $bookController = new BookController(app('App\Services\BookServices'));

        $response = $bookController->show((int) $book_id);

        $book = $response->getData(true)['data'] ?? null;

        if (!$book) {
            return redirect('/')->with('error', 'Libro no encontrado');
        }
        return view('books.show', compact('book'));
    }
}
