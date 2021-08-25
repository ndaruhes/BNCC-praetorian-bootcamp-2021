@extends('layouts.app')
@section('title', $blog->judul.' My Blogg App | RuBlogs')

@section('content')
<div class="col-md-6 mx-auto mt-4">
    <h3>Edit Blog</h1>
    <form action="{{ route('updateBlog', $blog->id) }}" method="POST" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="form-group">
            <label for="">Cover</label>
            @if(Storage::exists(asset('storage/images/blog/'.$blog->cover)))
                <img src="{{ asset('storage/images/blog/'.$blog->cover) }}" alt="{{ $blog->judul }}" class="w-100 mb-2">
            @else
                <img src="{{ $blog->cover }}" alt="{{ $blog->judul }}" class="w-100 mb-2">
            @endif
            <input type="file" name="cover" class="form-control">
        </div>
        <div class="form-group">
            <label for="">Judul</label>
            <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ $blog->judul }}" placeholder="Title...">
            @error('judul')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="">Content</label>
            <textarea name="content" class="form-control @error('content') is-invalid @enderror" cols="30" rows="10" placeholder="Content...">{{ $blog->content }}</textarea>
            @error('content')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
@endsection