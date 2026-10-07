<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    private function rules(): array
    {
        return [
            'BookTitle'   => 'required|string|max:255',
            'BookTypeID'  => 'required|exists:tblBookType,BookTypeID',
            'PublishDate' => 'nullable|date',
            'NumOfPages'  => 'nullable|integer|min:0',
            'NumOfCopies' => 'nullable|integer|min:0',
            'Edition'     => 'nullable|string|max:50',
            'Publisher'   => 'nullable|string|max:150',
            'BookSource'  => 'nullable|string|max:150',
            'Remark'      => 'nullable|string',
        ];
    }

    public function index(): JsonResponse
    {
        return response()->json(Book::with(['bookType', 'authors'])->get());
    }

    public function store(Request $request): JsonResponse
    {
        $book = Book::create($request->validate($this->rules()));

        return response()->json($book->load('bookType'), 201);
    }

    public function show(Book $book): JsonResponse
    {
        return response()->json($book->load(['bookType', 'authors']));
    }

    public function update(Request $request, Book $book): JsonResponse
    {
        $book->update($request->validate($this->rules()));

        return response()->json($book->load('bookType'));
    }

    public function destroy(Book $book): JsonResponse
    {
        $book->delete(); // pivot rows are removed by ON DELETE CASCADE

        return response()->json(['message' => 'Book deleted']);
    }
}