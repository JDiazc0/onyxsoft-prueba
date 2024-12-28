<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Http\Resources\AuthorCollection;
use App\Http\Resources\AuthorResponse;
use App\Models\Author;
use App\Services\AuthorServices;
use Symfony\Component\HttpFoundation\Response;

class AuthorController extends Controller
{
    protected $authorService;

    public function __construct(AuthorServices $authorService)
    {
        $this->authorService = $authorService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'message' => 'Authors retrieved successfully',
            'data' => new AuthorCollection($this->authorService->getAll())
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request)
    {

        $data = $request->validated();

        $author = $this->authorService->createAuthor($data);

        return response()->json([
            'message' => 'Author created successfully',
            'data' => new AuthorResponse($author)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {

        $authorFinded = $this->authorService->findAuthor($author->id);

        return response()->json([
            'message' => 'Author retrieved successfully',
            'data' => new AuthorResponse($authorFinded)
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthorRequest $request, Author $author)
    {

        $data = $request->validated();

        $author = $this->authorService->updateAuthor($data, $author->id);

        return response()->json([
            'message' => 'Author updated successfully',
            'data' => new AuthorResponse($author)
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {

        $this->authorService->deleteAuthor($author->id);

        return response()->json([
            'message' => 'Author deleted successfully'
        ], Response::HTTP_OK);
    }
}
