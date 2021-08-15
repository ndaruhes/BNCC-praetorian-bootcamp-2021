@extends('layouts.app')
@section('title', 'My Blogg App | RuBlogs')

@section('content')
    <div class="container mt-5">
        @guest
            <h1>Latest Blog</h1>
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
        @else
            <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#exampleModal">
                Create Blog
            </button>

            @include('blog.create')

            @if(session('status'))
                <div class="alert alert-success">{{session('status')}}</div>
            @endif

            <table class="table table-striped">
                <thead>
                    <tr>
                    <th>#</th>
                    <th>Cover</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Author</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($blogs->count() == null)
                        <div class="alert alert-warning" role="alert">
                            Blog masih kosong
                        </div>
                    @endif
                    
                    @foreach($blogs as $blog)
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <td style="width: 15%"><img src="{{ asset('storage/images/blog/'.$blog->cover) }}" alt="{{ $blog->judul }}" class="w-100"></td>
                        <td style="width: 21.25%">{{ $blog->judul }}</td>
                        <td style="width: 21.25%">{{ $blog->content }}</td>
                        <td style="width: 21.25%">{{ $blog->user->name }}</td>
                        <td>
                            <a href="{{ route('showBlog', $blog->id) }}" class="btn btn-secondary btn-sm">See</a>
                            <a href="{{ route('editBlog', $blog->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <a href="#" data-uri="{{ route('deleteBlog', $blog->id) }}" data-toggle="modal" data-target="#confirmDeleteModal" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endguest
    </div>
@endsection