@extends('master')

@section('content')

    <div class="container">
        <div class="row mt-5">
            <div class="col-5 bg-info rounded">
                <div class="p-3">
                    <h3 class="text-center text-white fw-bold mt-4">Create Data</h3>

                    <div class="mt-5"></div>

                    {{-- Created Success Alert !! --}}
                    @if (session('createdSuccess'))

                        <div class="alert-message">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <span class="text-warning">{{ session('createdSuccess') }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>

                    @endif

                    <form action="{{ route('post#create') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="text-group mb-2">
                            <label for="postTitle">Post Title</label>
                            <input type="text" name="postTitle" class="form-control @error('postTitle') is-invalid @enderror" id="postTitle" value="{{ old('postTitle') }}" placeholder="Enter Post Title....">

                            {{-- validation error testing --}}
                            @error('postTitle')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="text-group mb-2">
                            <label for="postDescription">Post Description</label>
                            <textarea name="postDescription" id="postDescription" cols="30" rows="10" class="form-control @error('postDescription') is-invalid @enderror" placeholder="Enter Post Description....">{{ old('postDescription') }}</textarea>

                            {{-- validation error testing --}}
                            @error('postDescription')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="text-group mb-2">

                            <label for="postImage">Post Image</label>
                            <input type="file" name="postImage" class="form-control @error('postImage') is-invalid @enderror" value="{{ old('postImage') }}" placeholder="Enter Post Image....">

                            {{-- validation error testing --}}
                            @error('postImage')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="text-group mb-2">
                            <label for="postPrice">Post Price</label>
                            <input type="number" name="postPrice" class="form-control @error('postPrice') is-invalid @enderror" id="postTitle" value="{{ old('postPrice') }}" placeholder="Enter Post Price....">

                            {{-- validation error testing --}}
                            @error('postPrice')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="text-group mb-2">
                            <label for="postAddress">Post Address</label>
                            <input type="text" name="postAddress" class="form-control @error('postAddress') is-invalid @enderror" id="postAddress" value="{{ old('postAddress') }}" placeholder="Enter Post Address....">

                            {{-- validation error testing --}}
                            @error('postAddress')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="text-group mb-2">
                            <label for="postRating">Post Rating</label>
                            <input type="number" min="0" max="5" name="postRating" class="form-control @error('postRating') is-invalid @enderror" id="postTitle" value="{{ old('postRating') }}" placeholder="Enter Post Rating....">

                            {{-- validation error testing --}}
                            @error('postRating')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="mb-2">
                            <input type="submit" value="Create" class="btn btn-danger">
                        </div>
                    </form>
                </div>
            </div>


            {{-- Data Store --}}

            <div class="col-7 bg-secondary rounded">

                <h3 class="text-center text-warning fw-bold mt-3">Post Data List</h3>

                <h5 class="ms-4 text-white fw-bold mb-3">
                    Total Post - {{ $posts->total() }}
                </h5>

                {{-- Data Searching form --}}

                <form action="{{ route('post#createPage') }}" method="get">
                    <div class="d-flex ms-3 mb-3">
                        <input type="text" class="form-control"  value="{{ request('searchKey') }}" name="searchKey" placeholder="Enter search key....">
                        <button class="btn btn-warning" type="submit">Search</button>
                    </div>
                </form>

                {{-- Alert Message !!! --}}

                <div class="alert-message ms-3 mt-3">

                    @if (session('updatedSuccess'))

                        <div class="alert-message">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <span class="text-warning">{{ session('updatedSuccess') }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>

                    @endif

                </div>

                <div class="data-container">
                    @if (count($posts) != 0)

                        @foreach ($posts as $item)
                            <div class="post m-3 p-3 bg-white rounded">
                                <div class="row mb-3">
                                    <div class="col-8 text-primary fw-bold">{{ $item->title }} | {{ $item->id }}</div>
                                    <div class="col-4 text-danger">{{ $item->created_at->format("j-F-Y | n:i:A") }}</div>
                                </div>

                                <p class="">{{ Str::words($item->description, 20, '.....')}}</p>

                                <small class="text-info fw-bold">Price: {{ $item->price }} ks |</small>
                                <small class="text-info fw-bold">Address: {{ $item->address }} |</small>
                                <small class="text-info fw-bold">Rating: {{ $item->rating }}</small>
                                
                                <div class="text-end">
                                    <a href="{{ route('post#delete', $item->id) }}">
                                        <button class="btn btn-sm btn-danger me-2 rounded">Delete</button>
                                    </a>
                                    <a href="{{ route('post#update', $item->id) }}">
                                        <button class="btn btn-sm btn-primary rounded">Detail</button>
                                    </a>
                                </div>
                            </div>
                        @endforeach

                    @else

                        <h4 class="text-warning fw-bold text-center my-5">This is no data....</h4>

                    @endif
                </div>

                {{-- For Boostrap Pagination --}}
                {{ $posts->appends(request()->query())->links() }}
                {{-- appends is to connect searchKey and pagination --}}
            </div>
        </div>
    </div>
@endsection
