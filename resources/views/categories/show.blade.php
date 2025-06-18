@extends('layouts.template')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2>{{ $category->name }}</h2>
                    <div>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">Edit Category</a>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="mb-4">
                        <h4>Description</h4>
                        <p>{{ $category->description ?? 'No description available.' }}</p>
                    </div>

                    <div class="mb-4">
                        <h4>Movies in this Category</h4>
                        @if($movies->count() > 0)
                            <div class="row">
                                @foreach($movies as $movie)
                                    <div class="col-md-4 mb-4">
                                        <div class="card h-100">
                                            @if($movie->cover_image)
                                                <img src="{{ asset('storage/' . $movie->cover_image) }}" class="card-img-top" alt="{{ $movie->title }}" style="height: 200px; object-fit: cover;">
                                            @endif
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $movie->title }}</h5>
                                                <p class="card-text">{{ Str::limit($movie->synopsis, 100) }}</p>
                                                <a href="{{ route('movies.show', $movie) }}" class="btn btn-primary">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="d-flex justify-content-center mt-4">
                                {{ $movies->links() }}
                            </div>
                        @else
                            <p>No movies found in this category.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 