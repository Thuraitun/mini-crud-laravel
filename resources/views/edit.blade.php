@extends('master')

@section('content')

    <div class="container">
        <div class="row mt-5 bg-secondary p-3">
            <div class="col-6 offset-3">
                <h3 class="text-center text-warning mb-3">Update Post</h3>

                {{-- Back Button --}}
                <div class="mb-4">
                    <a href="{{ route('post#update', $post['id']) }}">
                        <button class="btn btn-sm btn-warning me-3">Back</button>
                    </a>
                </div>

                <form action="{{ route('post#updatePost') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <label for="">Post Title</label>
                    <input type="hidden" name="postId" value="{{ $post['id'] }}">
                    <input type="text" name="postTitle" class="form-control my-2 @error('postTitle') is-invalid @enderror" placeholder="Enter post title.." value="{{ old('postTitle',$post['title']) }}">

                    @error('postTitle')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror

                    <label for="">Post Description</label>
                    <textarea name="postDescription" id="" cols="30" rows="10" class="form-control my-2 @error('postDescription') is-invalid @enderror" placeholder="Enter post description..">{{ old('postDescription',$post['description']) }}</textarea>

                    @error('postDescription')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror

                    <div class="">
                        @if ($post['image'] == null)
                            <img src="{{ asset("imagenofound.jpeg") }}" class="img-thumbnail" alt="">
                        @else
                            <img src="{{ asset('storage/'.$post['image']) }}" class="img-thumbnail" style="width:300px" alt="">
                        @endif
                    </div>

                    <div class="text-group mb-2">

                        <label for="postImage">Post Image</label>
                        <input type="file" name="postImage" class="form-control" id="postImage @error('postImage') is-invalid @enderror" value="{{ old('postImage', $post['image']) }}" placeholder="Enter Post Image....">

                        {{-- validation error testing --}}
                        @error('postImage')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror

                    </div>

                    <div class="text-group mb-2">
                        <label for="postPrice">Post Price</label>
                        <input type="number" name="postPrice" class="form-control @error('postPrice') is-invalid @enderror" id="postPrice" value="{{ old('postPrice', $post['price']) }}" placeholder="Enter Post Price....">

                        {{-- validation error testing --}}
                        @error('postPrice')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror

                    </div>

                    <div class="text-group mb-2">
                        <label for="postAddress">Post Address</label>
                        <input type="text" name="postAddress" class="form-control @error('postAddress') is-invalid @enderror" id="postAddress" value="{{ old('postAddress', $post['address']) }}" placeholder="Enter Post Address....">

                        {{-- validation error testing --}}
                        @error('postAddress')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror

                    </div>

                    <div class="text-group mb-2">
                        <label for="postRating">Post Rating</label>
                        <input type="number" min="0" max="5" name="postRating" class="form-control @error('postRating') is-invalid @enderror" id="postTitle" value="{{ old('postRating', $post['rating']) }}" placeholder="Enter Post Rating....">

                        {{-- validation error testing --}}
                        @error('postRating')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror

                    </div>

                    <button class="btn btn-sm btn-info">Update</button>

                </form>
            </div>
        </div>
    </div>

@endsection
