<?php

use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\AuthorControllerFront;
use App\Http\Controllers\BookControllerFront;
use Illuminate\Support\Facades\Route;

Route::get('/books', [BookControllerFront::class, 'index'])->name('book.index');
Route::get('/books/show/{book_id}', [BookControllerFront::class, 'show'])->name('book.show');

Route::get('/authors', [AuthorControllerFront::class, 'index'])->name('author.index');
Route::get('/authors/show/{author_id}', [AuthorControllerFront::class, 'show'])->name('author.show');
