<?php

use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Author endpoints
Route::group(['prefix' => 'author'], function () {
    Route::get('/', [AuthorController::class, 'index']);
    Route::get('/{author}', [AuthorController::class, 'show']);
    Route::post('', [AuthorController::class, 'store']);
    Route::put('/{author}', [AuthorController::class, 'update']);
    Route::delete('/{author}', [AuthorController::class, 'destroy']);
});

// Book endpoints
Route::group(['prefix' => 'book'], function () {
    Route::get('/', [BookController::class, 'index']);
    Route::get('/{book}', [BookController::class, 'show']);
    Route::post('', [BookController::class, 'store']);
    Route::put('/{book}', [BookController::class, 'update']);
    Route::delete('/{book}', [BookController::class, 'destroy']);
    // Rent book
    Route::post('/{book}/rent', [BookController::class, 'rentBook']);
    Route::post('/{book}/return', [BookController::class, 'returnBook']);
    // Add Author to Book
    Route::post('add-author/{book}/{author}', [BookController::class, 'addAuthor']);
    Route::post('remove-author/{book}/{author}', [BookController::class, 'removeAuthor']);
});
