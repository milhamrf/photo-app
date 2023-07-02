@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Photo Gallery</h2>
                <a href="{{ route('photos.create') }}" class="btn btn-primary">Add Photo</a>
            </div>
            <hr>
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <div class="row">
                @foreach($photos as $photo)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ Storage::url($photo->image) }}"  width="100" class="card-img-top" alt="{{ $photo->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $photo->title }}</h5>
                            <p class="card-text">{{ $photo->description }}</p>
                            <a href="{{ route('photos.show', $photo->id) }}" class="btn btn-primary">View</a>
                            <a href="{{ route('photos.edit', $photo->id) }}" class="btn btn-secondary">Edit</a>
                            <form action="{{ route('photos.destroy', $photo->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this photo?')">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
