@extends('layouts.app')
@section('title', $blog->judul.' My Blogg App | RuBlogs')

@section('content')
<div class="col-md-5 mx-auto mt-4">
    <h1>Show Blog</h1>
    <img src="{{ asset('storage/images/blog/'.$blog->cover) }}" alt="{{ $blog->judul }}" class="w-100 mb-2">
    <span class="badge badge-primary">{{ $blog->user->name }}</span>
    <h1 class="m-0">{{ $blog->judul }}</h1>
    <p class="mt-4">{{ $blog->content }}</p>
</div>
@endsection