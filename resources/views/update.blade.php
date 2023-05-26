@extends('master')

@section('content')

    <div class="container">
        <div class="row mt-5 bg-secondary p-3">
            <div class="col-8 offset-2">
                <h3 class="text-center text-warning fw-bold mb-5">Post Detail</h3>
                <div class="shadow-lg p-3 bg-white rounded">
                    <div class="row mb-3">
                        <div class="col-8 text-primary fw-bold">{{ $post->title }} | {{ $post->id }}</div>
                        <div class="col-4 text-danger">{{ $post->created_at->format("j-F-Y | n:i:A") }}</div>
                    </div>

                    <div class="">
                        @if ($post->image == null)
                            <img src="{{ asset("imagenofound.jpeg") }}" class="img-thumbnail rounded mx-auto d-block" alt="">
                        @else
                            <img src="{{ asset("storage/$post->image") }}" class="img-thumbnail rounded mx-auto d-block" alt="">
                        @endif
                    </div>
        
                    <p class="mt-3">{{ $post->description }}</p>

                    <div class="mb-3">
                        <small class="text-primary">Price: {{ $post->price }}ks |</small>
                        <small class="text-primary">Address: {{ $post->address }} |</small>
                        <small class="text-primary">Rating: {{ $post->rating }}</small>
                    </div>
                    <a href="{{ route('post#createPage') }}">
                        <button class="btn btn-sm btn-warning me-3">Back</button>
                    </a>
                    <a href="{{ route('post#edit', $post->id ) }}">
                        <button class="btn btn-sm btn-info">Edit</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
