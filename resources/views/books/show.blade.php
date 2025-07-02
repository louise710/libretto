@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>{{ $book->title }}</h1>
            <p class="lead">by {{ $book->author->name }}</p>
            <p><strong>Genres:</strong> {{ $book->genres->pluck('name')->implode(', ') }}</p>
            <p><strong>Added by:</strong> {{ $book->user->name }}</p>
            
            @auth
                @can('update', $book)
                    <a href="{{ route('books.edit', $book) }}" class="btn btn-secondary">Edit</a>
                @endcan
                
                @can('delete', $book)
                    <form action="{{ route('books.destroy', $book) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                @endcan
            @endauth
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <h3>Reviews</h3>
            @auth
                <form action="{{ route('reviews.store', $book) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="content">Your Review</label>
                        <textarea name="content" id="content" rows="3" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="rating">Rating</label>
                        <select name="rating" id="rating" class="form-control" required>
                            <option value="">Select rating</option>
                            <option value="1">1 - Poor</option>
                            <option value="2">2 - Fair</option>
                            <option value="3">3 - Good</option>
                            <option value="4">4 - Very Good</option>
                            <option value="5">5 - Excellent</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                </form>
            @else
                <p><a href="{{ route('login') }}">Login</a> to leave a review.</p>
            @endauth
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @foreach($book->reviews as $review)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">{{ $review->user->name }}</h5>
                            <div>
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <span class="text-warning">★</span>
                                    @else
                                        <span class="text-secondary">★</span>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <p class="card-text">{{ $review->content }}</p>
                        <p class="card-text"><small class="text-muted">{{ $review->created_at->diffForHumans() }}</small></p>
                        
                        @auth
                            @if(auth()->user()->id === $review->user_id)
                                <form action="{{ route('reviews.destroy', $review) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection