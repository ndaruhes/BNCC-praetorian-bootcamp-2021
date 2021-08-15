<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::get();
        return view('blog.index', compact('blogs'));
    }

    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        return view('blog.show', compact('blog'));
    }

    public function store(Request $request)
    {
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

        Blog::create([
            'cover' => $Image,
            'judul' => $request->judul,
            'content' => $request->content,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('indexBlog')->with('status', 'Blog berhasil dibuat');
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('blog.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        if ($request->file('cover') == null) {
            $request->validate([
                'judul' => 'min:5|required|string',
                'content' => 'min:10|required|string',
            ]);
            $blog = Blog::findOrFail($id);
            $blog->update([
                'judul' => $request->judul,
                'content' => $request->content,
            ]);

            return redirect()->route('indexBlog')->with('status', 'Blog berhasil diubah');
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
        if (Storage::exists('public/images/blog/' . $blog->cover)) {
            Storage::delete('public/images/blog/' . $blog->cover);
        }
        $blog->delete();

        return redirect()->route('indexBlog')->with('status', 'Blog berhasil dihapus');
    }
}
