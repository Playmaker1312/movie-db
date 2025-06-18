@extends('layouts.template')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            @if($movie->{'cover-image'})
                <img src="{{ asset('storage/' . $movie->{'cover-image'}) }}" class="img-fluid rounded" alt="{{ $movie->title }}">
            @else
                <img src="{{ asset('images/no-image.jpg') }}" class="img-fluid rounded" alt="No Image Available">
            @endif
        </div>
        <div class="col-md-8">
            <h1 class="mb-4">{{ $movie->title }}</h1>
            <div class="card">
                <div class="card-body">
                    <p class="card-text"><strong>Category:</strong> {{ $movie->category->name ?? 'Not Available' }}</p>
                    <p class="card-text"><strong>Year:</strong> {{ $movie->year ?? 'Not Available' }}</p>
                    <p class="card-text"><strong>Actors:</strong> {{ $movie->actors ?? 'Not Available' }}</p>
                    <p class="card-text"><strong>Synopsis:</strong></p>
                    <p class="card-text">{{ $movie->synopsis }}</p>

                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('homepage') }}" class="btn btn-secondary">Back to List</a>
                        @auth
                            @if(auth()->user()->canPerformCrud())
                                <a href="{{ route('movies.edit', $movie->id) }}" class="btn btn-primary">Edit Movie</a>
                                <form action="{{ route('movies.destroy', $movie->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this movie?')">Delete Movie</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection