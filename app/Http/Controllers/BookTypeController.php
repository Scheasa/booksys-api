<?php

namespace App\Http\Controllers;

use App\Models\BookType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookTypeController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(BookType::all());
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'BookTypeName' => 'required|string|max:100',
        ]);

        return response()->json(BookType::create($data), 201);
    }

    public function show(BookType $bookType): JsonResponse
    {
        return response()->json($bookType->load('books'));
    }

    public function update(Request $request, BookType $bookType): JsonResponse
    {
        $data = $request->validate([
            'BookTypeName' => 'required|string|max:100',
        ]);

        $bookType->update($data);

        return response()->json($bookType);
    }

    public function destroy(BookType $bookType): JsonResponse
    {
        $bookType->delete();

        return response()->json(['message' => 'Book type deleted']);
    }
}