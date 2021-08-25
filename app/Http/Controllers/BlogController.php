<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\Subscriber;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show', 'subscribeBlog');
    }

    public function index()
    {
        $blogs = Auth::user() && Auth::user()->role == 'Member' ? Blog::where('user_id', '=', Auth::user()->id)->get() : Blog::get();
        return view('blog.index', compact('blogs'));
    }

    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        $comments = Comment::where('blog_id', '=', $blog->id)->get();
        // $replies = Reply::where('comment_id', '=', $comments->id)->get();
        // $replies = Reply::where('comment_id', '=', 1)->get();
        $replies = Reply::get();
        return view('blog.show', compact('blog', 'comments', 'replies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'min:5|required|string',
            'content' => 'min:10|required|string',
        ]);

        if (Auth::user()->role == 'Member') {
            $files = $request->file('cover');
            $fullFileName = $files->getClientOriginalName();
            $fileName = pathinfo($fullFileName)['filename'];
            $extension = $files->getClientOriginalExtension();
            $Image = $fileName . "-" . Str::random(10) . "-" . date('YmdHis') . "." . $extension;
            $files->storeAs('public/images/blog', $Image);

            Blog::create([
                'cover' => $Image,
                'judul' => $request->judul,
                'content' => $request->content,
                'user_id' => Auth::user()->id
            ]);

            return redirect()->route('indexBlog')->with('status', 'Blog berhasil dibuat');
        } else {
            return redirect()->route('index');
        }
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return $blog->user_id == Auth::user()->id ? view('blog.edit', compact('blog')) : redirect()->route('index');
    }

    public function update(Request $request, $id)
    {
        if ($request->file('cover') == null) {
            $request->validate([
                'judul' => 'min:5|required|string',
                'content' => 'min:10|required|string',
            ]);
            $blog = Blog::findOrFail($id);
            if ($blog->user_id == Auth::user()->id) {
                $blog->update([
                    'judul' => $request->judul,
                    'content' => $request->content,
                ]);

                return redirect()->route('indexBlog')->with('status', 'Blog berhasil diubah');
            } else {
                return redirect()->route('index');
            }
        } else {
            $request->validate([
                'judul' => 'min:5|required|string',
                'content' => 'min:10|required|string',
            ]);

            $files = $request->file('cover');
            $fullFileName = $files->getClientOriginalName();
            $fileName = pathinfo($fullFileName)['filename'];
            $extension = $files->getClientOriginalExtension();
            $Image = $fileName . "-" . Str::random(10) . "-" . date('YmdHis') . "." . $extension;
            $files->storeAs('public/images/blog', $Image);

            $blog = Blog::findOrFail($id);
            if (Storage::exists('public/images/blog/' . $blog->cover)) {
                Storage::delete('public/images/blog/' . $blog->cover);
            }
            $blog->update([
                'judul' => $request->judul,
                'content' => $request->content,
                'cover' => $Image
            ]);

            return redirect()->route('indexBlog')->with('status', 'Blog berhasil diubah');
        }
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        if ($blog->user_id == Auth::user()->id || Auth::user()->role == 'Admin') {
            if (Storage::exists('public/images/blog/' . $blog->cover)) {
                Storage::delete('public/images/blog/' . $blog->cover);
            }
            $blog->delete();

            return redirect()->route('indexBlog')->with('status', 'Blog berhasil dihapus');
        } else {
            return redirect()->route('index');
        }
    }

    public function subscribeBlog(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        Subscriber::create([
            'email' => $request->email
        ]);

        return redirect()->back()->with('status', 'Berhasil subscribe RuBlogs');
    }
}
