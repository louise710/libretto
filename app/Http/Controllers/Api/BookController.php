<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return Book::with(['author', 'genres', 'reviews'])->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
        ]);

        $book = Book::create([
            'title' => $validated['title'],
            'author_id' => $validated['author_id'],
            'user_id' => auth()->id(),
        ]);

        $book->genres()->attach($validated['genres']);

        return response()->json($book->load(['author', 'genres']), 201);
    }

    public function show(Book $book)
    {
        return $book->load(['author', 'genres', 'reviews.user']);
    }

    public function update(Request $request, Book $book)
    {
        $this->authorize('update', $book);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'author_id' => 'sometimes|exists:authors,id',
            'genres' => 'sometimes|array',
            'genres.*' => 'exists:genres,id',
        ]);

        $book->update($validated);

        if ($request->has('genres')) {
            $book->genres()->sync($validated['genres']);
        }

        return response()->json($book->load(['author', 'genres']));
    }

    public function destroy(Book $book)
    {
        $this->authorize('delete', $book);
        
        $book->delete();
        return response()->json(null, 204);
    }
}