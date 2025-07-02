<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }
    public function store(Request $request, Book $book)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'rating' => 'required|integer|between:1,5',
        ]);
        
        $book->reviews()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
            'rating' => $validated['rating'],
        ]);
        
        return back()->with('success', 'Review added successfully!');
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);
        
        $review->delete();
        return back()->with('success', 'Review deleted successfully!');
    }
}