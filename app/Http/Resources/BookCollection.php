<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BookCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Books' => $this->collection->map(function ($book) {
                return [
                    'id' => $book->id,
                    'title' => $book->title,
                    'published_date' => $book->published_date,
                    'genre' => $book->genre,
                    'available' => $book->available,
                ];
            }),
            'total' => $this->collection->count()
        ];
    }
}
