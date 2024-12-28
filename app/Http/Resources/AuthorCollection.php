<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AuthorCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Authors' => $this->collection->map(function ($author) {
                return [
                    'id' => $author->id,
                    'name' => $author->name,
                    'birth_date' => $author->birth_date,
                    'death_date' => $author->death_date,
                ];
            }),
            'total' => $this->collection->count()
        ];
    }
}
