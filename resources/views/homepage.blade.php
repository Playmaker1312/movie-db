@extends('layouts.template')

@section('content')
    <h1 class="text-success">Film Terbaru</h1>

    <div class="row">
        @foreach($movies as $movie)
        <div class="col-lg-6">
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-4">
                        @if($movie->{'cover-image'})
                            <img src="{{ asset('storage/' . $movie->{'cover-image'}) }}" class="img-fluid rounded-start" alt="{{ $movie->title }}" style="height: 100%; object-fit: cover;">
                        @else
                            <img src="{{ asset('images/no-image.jpg') }}" class="img-fluid rounded-start" alt="No Image Available" style="height: 100%; object-fit: cover;">
                        @endif
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{ $movie->title }}</h5>
                            <p class="card-text">{{ Str::words($movie->synopsis, 20) }}</p>
                            <a href="{{ route('movies.show', $movie->id) }}" class="btn btn-success">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        {{ $movies->links() }}
    </div>
@endsection