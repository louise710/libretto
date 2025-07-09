<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Book;
use Illuminate\Http\Request;


class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::with(['book.author'])->paginate(10);
        return view('review.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $books = Book::all();
        return view('review.create', compact('books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valid = $request->validate([
            'id' => 'required|unique:reviews,id',
            'book_id' => 'required|exists:books,id',
            'content' => 'required',
            'rating' => 'required|integer|min:1|max:5',
        ]);
        Review::create($valid);
        return redirect()->back()->with('success', 'Review Successfully Created');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $review = Review::with(['book.author'])->findOrFail($id);
        return view('review.show', compact('review'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $review = Review::findOrFail($id);
        $books = Book::all();
        return view('review.edit', compact('review', 'books'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $valid = $request->validate([
            'book_id' => 'required|exists:books,id',
            'content' => 'required',
            'rating' => 'required|integer|min:1|max:5',
        ]);
        $review = Review::findOrFail($id);
        $review->update($valid);
        return redirect()->route('reviews.index')->with('success', 'Review updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return redirect()->route('reviews.index')->with('success', 'Review deleted successfully');
    }
}