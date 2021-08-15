@extends('layouts.app')
@section('title', 'My Blogg App | RuBlogs')

@section('content')
<div class="jumbotron">
    <div class="container">
        <h1 class="display-4">Selamat Datang di RuBlogs!</h1>
        <p class="lead">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Non facilis vero blanditiis nisi molestiae dolorum suscipit, esse reiciendis consequuntur labore facere excepturi. Molestias qui animi amet odit distinctio perspiciatis nam!</p>
        <hr class="my-4">
        <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
        <a class="btn btn-primary btn-lg" href="#" role="button">See more blogs</a>
    </div>
</div>

<div class="container my-5">
    <h1>Latest Blog</h1>
    @if($blogs->count() == null)
        <div class="alert alert-warning mt-4" role="alert">
            Blog masih kosong
        </div>
    @endif
    <div class="row">
        @foreach($blogs as $blog)
            <div class="col-md-4">
                <div class="col-md-12 p-0 rounded bg-light shadow">
                    <a href="{{ route('showBlog', $blog->id) }}" class="text-dark">
                        <img src="{{ asset('storage/images/blog/'.$blog->cover) }}" alt="{{ $blog->judul }}" class="w-100 rounded-top">
                        <div class="p-3">
                            <h3 class="m-0">{{ $blog->judul }}</h3>
                            <p class="mt-2">{{ $blog->content }}</p>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection