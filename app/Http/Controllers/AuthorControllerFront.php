<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\AuthorController;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;

class AuthorControllerFront extends Controller
{
    public function index(): View
    {
        $authorController = new AuthorController(app('App\Services\AuthorServices'));
        $response = $authorController->index();

        $authors = $response->getData(true)['data']['Authors'] ?? [];

        return view('authors.index', compact('authors'));
    }

    public function show($author_id): View
    {
        $authorController = new AuthorController(app('App\Services\AuthorServices'));

        $response = $authorController->show($author_id);

        $author = $response->getData(true)['data'] ?? null;

        if (!$author) {
            return redirect('/')->with('error', 'Libro no encontrado');
        }
        return view('authors.show', compact('author'));
    }
}
