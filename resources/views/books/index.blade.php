@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between mb-4">
        <div class="col-md-6">
            <h1>Books</h1>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('books.create') }}" class="btn btn-primary">Add New Book</a>
        </div>
    </div>

    <div class="row">
        @foreach($books as $book)
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $book->title }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $book->author->name }}</h6>
                    <p class="card-text">
                        <strong>Genres:</strong> 
                        {{ $book->genres->pluck('name')->implode(', ') }}
                    </p>
                    <p class="card-text">
                        <strong>Rating:</strong> 
                        {{ number_format($book->reviews->avg('rating'), 1) }} 
                        ({{ $book->reviews->count() }} reviews)
                    </p>
                    <a href="{{ route('books.show', $book) }}" class="btn btn-sm btn-primary">View Details</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center">
        {{ $books->links() }}
    </div>
</div>
@endsection