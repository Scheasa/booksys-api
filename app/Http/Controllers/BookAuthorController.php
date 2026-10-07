<?php

namespace App\Http\Controllers;

use App\Models\BookAuthor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookAuthorController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(BookAuthor::with(['book', 'author'])->get());
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'BookID'     => 'required|exists:tblBook,BookID',
            'AuthorID'   => 'required|exists:tblAuthor,AuthorID',
            'AuthorDate' => 'nullable|date',
            'Remark'     => 'nullable|string',
        ]);

        $exists = BookAuthor::where('BookID', $data['BookID'])
            ->where('AuthorID', $data['AuthorID'])
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'This book-author link already exists'], 422);
        }

        return response()->json(BookAuthor::create($data), 201);
    }

    public function show(int $bookId, int $authorId): JsonResponse
    {
        $row = BookAuthor::with(['book', 'author'])
            ->where('BookID', $bookId)
            ->where('AuthorID', $authorId)
            ->firstOrFail();

        return response()->json($row);
    }

    public function update(Request $request, int $bookId, int $authorId): JsonResponse
    {
        $data = $request->validate([
            'AuthorDate' => 'nullable|date',
            'Remark'     => 'nullable|string',
        ]);

        $query = BookAuthor::where('BookID', $bookId)->where('AuthorID', $authorId);
        abort_unless($query->exists(), 404);

        $query->update($data);

        return response()->json($query->first());
    }

    public function destroy(int $bookId, int $authorId): JsonResponse
    {
        $deleted = BookAuthor::where('BookID', $bookId)
            ->where('AuthorID', $authorId)
            ->delete();

        abort_unless($deleted, 404);

        return response()->json(['message' => 'Link deleted']);
    }
}