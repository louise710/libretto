If this is I will implement then what is the blade name of this?
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ isset($book) ? 'Edit Book' : 'Add New Book' }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ isset($book) ? route('books.update', $book) : route('books.store') }}">
                        @csrf
                        @if(isset($book))
                            @method('PUT')
                        @endif

                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">Title</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $book->title ?? '') }}" required autocomplete="title" autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="author_id" class="col-md-4 col-form-label text-md-right">Author</label>

                            <div class="col-md-6">
                                <select id="author_id" class="form-control @error('author_id') is-invalid @enderror" name="author_id" required>
                                    <option value="">Select Author</option>
                                    @foreach($authors as $author)
                                        <option value="{{ $author->id }}" {{ old('author_id', $book->author_id ?? '') == $author->id ? 'selected' : '' }}>
                                            {{ $author->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('author_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="genres" class="col-md-4 col-form-label text-md-right">Genres</label>

                            <div class="col-md-6">
                                <select id="genres" class="form-control @error('genres') is-invalid @enderror" name="genres[]" multiple required>
                                    @foreach($genres as $genre)
                                        <option value="{{ $genre->id }}" {{ isset($book) && $book->genres->contains($genre->id) ? 'selected' : '' }}>
                                            {{ $genre->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('genres')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($book) ? 'Update Book' : 'Add Book' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection