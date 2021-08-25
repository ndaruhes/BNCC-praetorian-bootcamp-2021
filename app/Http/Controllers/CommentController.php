<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Reply;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $blogId = Str::substr(str_replace(url('/'), '', url()->previous()), 6);
        $userId = Auth::user() ? Auth::user()->id : null;

        $request->validate([
            'text_comment' => 'min:3|required|string',
        ]);

        Comment::create([
            'blog_id' => $blogId,
            'user_id' => $userId,
            'text_comment' => $request->text_comment

        ]);

        return redirect()->route('showBlog', [$blogId])->with('status', 'Comment added succesfully');
    }

    public function replyComment(Request $request)
    {
        $blogId = Str::substr(str_replace(url('/'), '', url()->previous()), 6);
        $userId = Auth::user() ? Auth::user()->id : null;

        $request->validate([
            'text_reply' => 'min:3|required|string',
            'comment_id' => 'required|numeric',
        ]);

        Reply::create([
            'text_reply' => $request->text_reply,
            'comment_id' => $request->comment_id,
            'user_id' => $userId
        ]);

        return redirect()->route('showBlog', [$blogId])->with('status', 'Reply added succesfully');
    }
}
