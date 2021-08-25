@extends('layouts.app')
@section('title', $blog->judul.' My Blogg App | RuBlogs')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            @if(Storage::exists('public/images/blog/'.$blog->cover))
                <img src="{{ asset('storage/images/blog/'.$blog->cover) }}" alt="{{ $blog->judul }}" class="w-100 mb-2">
            @else
                <img src="{{ $blog->cover }}" alt="{{ $blog->judul }}" class="w-100 mb-2">
            @endif
            <span class="badge badge-primary">{{ $blog->user->name }}</span>
            <h1 class="m-0">{{ $blog->judul }}</h1>
            <p class="mt-4">{!! $blog->content !!}</p>
        </div>
        <div class="col-md-4">
            <h3 class="m-0">Comments</h3>
            @if($comments->count() == null)
                <p>Haven't Commentars Yet</p>
            @else
                <p>{{ $comments->count() }} Total Commentars</p>
            @endif

            <div class="col-md-8 mb-3">
                <div class="row">
                    <div class="col-4 p-0">
                        <img src="{{ asset('images/user.png') }}" alt="User" class="w-75">
                    </div>
                    <div class="col-8 p-0 d-flex align-items-center">
                        <div>
                            <b class="d-block">
                                @if(Auth::user())
                                    {{ Auth::user()->name }}
                                @else
                                    Anonymous
                                @endif
                            </b>
                            <span class="d-block">Give your comment</span>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('storeComment') }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea name="text_comment" class="form-control @error('text_comment') is-invalid @enderror" placeholder="Your comment..."></textarea>
                    @error('text_comment')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-sm">Post</button>
                </div>
            </form>

            <hr>

            @foreach($comments as $comment)
            <!-- REPLY MODAL -->
                <div class="modal fade" id="{{ 'replyModal'.$comment->id }}" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="replyModalLabel">Reply Comment</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="col-md-6 mb-3">
                                    <div class="row">
                                        <div class="col-4 p-0">
                                            <img src="{{ asset('images/user.png') }}" alt="User" class="w-75">
                                        </div>
                                        <div class="col-8 p-0 d-flex align-items-center">
                                            <div>
                                                @if($comment->user_id == null)
                                                    <div class="d-block font-weight-bold">Anonymous</div>
                                                @else
                                                    <div class="font-weight-bold">
                                                        {{ $comment->user->name }}
                                                        @if($comment->user->role == 'Admin')
                                                            <span class="text-success ml-1">&check;</span>
                                                        @endif
                                                    </div>
                                                @endif
                                                <span class="d-block">{{ $comment->text_comment }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <form action="{{ route('replyComment') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <textarea name="text_reply" class="form-control @error('text_reply') is-invalid @enderror" placeholder="Reply comment..."></textarea>
                                        @error('text_reply')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary btn-sm">Post</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <div class="row">
                        <div class="col-2 p-0">
                            <img src="{{ asset('images/user.png') }}" alt="User" class="w-75">
                        </div>
                        <div class="col-10 p-0 d-flex align-items-center">
                            <div>
                                @if($comment->user_id == null)
                                    <div class="d-block font-weight-bold">Anonymous</div>
                                @else
                                    <div class="font-weight-bold">
                                        {{ $comment->user->name }}
                                        @if($comment->user->role == 'Admin')
                                            <span class="text-success ml-1">&check;</span>
                                        @endif
                                    </div>
                                @endif
                                <span class="d-block">{{ $comment->text_comment }}</span>
                                <small class="badge badge-secondary cursor-pointer" data-toggle="modal" data-target="{{ '#replyModal'.$comment->id }}">Reply</small>
                            </div>
                        </div>

                        {{-- REPLY COMMENT --}}
                        @foreach($replies as $reply)
                        <div class="col-2">

                        </div>
                        <div class="col-10 my-3">
                            <div class="row">
                                <div class="col-2 p-0">
                                    <img src="{{ asset('images/user.png') }}" alt="User" class="w-75">
                                </div>
                                <div class="col-10 p-0 d-flex align-items-center">
                                    <div>
                                        @if($reply->user_id == null)
                                            <div class="d-block font-weight-bold">Anonymous</div>
                                        @else
                                            <div class="font-weight-bold">
                                                {{ $reply->comment->user->name }}
                                                @if($reply->comment->user->role == 'Admin')
                                                    <span class="text-success ml-1">&check;</span>
                                                @endif
                                            </div>
                                        @endif

                                        @if($reply->comment->user_id == null)
                                            <span class="d-block text-secondary">&#8627; repying to <b>Anonymous</b></span>
                                        @else
                                            <span class="d-block text-secondary">&#8627; repying to <b>{{ Str::words($reply->comment->user->name, 2) }}</b></span>
                                        @endif
                                        <span class="d-block">{{ $reply->text_reply }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection