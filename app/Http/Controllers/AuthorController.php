<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    private function rules(): array
    {
        return [
            'AuthorName' => 'required|string|max:150',
            'Gender'     => 'nullable|string|max:10',
            'DOB'        => 'nullable|date',
            'POB'        => 'nullable|string|max:150',
            'Address'    => 'nullable|string|max:255',
            'Phone'      => 'nullable|string|max:20',
            'Email'      => 'nullable|email|max:150',
            'Photo'      => 'nullable|string|max:255',
        ];
    }

    public function index(): JsonResponse
    {
        return response()->json(Author::all());
    }
    public function store(Request $request): JsonResponse
    {
        $author = Author::create($request->validate($this->rules()));

        return response()->json($author, 201);
    }

    public function show(Author $author): JsonResponse
    {
        return response()->json($author->load('books'));
    }

    public function update(Request $request, Author $author): JsonResponse
    {
        $author->update($request->validate($this->rules()));

        return response()->json($author);
    }

    public function destroy(Author $author): JsonResponse
    {
        $author->delete();

        return response()->json(['message' => 'Author deleted']);
    }
}