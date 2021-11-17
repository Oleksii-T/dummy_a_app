<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ShareBlog;
use App\Models\Blog;
use App\Models\Page;

class BlogController extends Controller
{
    public function index()
    {
        $page = Page::get('blogs');
        $blogs = Blog::latest()->paginate(15);
        return view('website.blogs.index', compact('blogs', 'page'));
    }

    public function show($blog)
    {
        $blog = Blog::where('slug', $blog)->firstOrFail();
        $latest = Blog::latest()->limit(3)->where('id', '!=', $blog->id)->get();

        return view('website.blogs.show', compact('blog', 'latest'));
    }

    public function shareEmail(Request $request)
    {
        try {
            Mail::to($request->email)->send(new ShareBlog(auth()->user(), $request->id));
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Share fails'
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Blog shared successfully'
        ]);
    }
}
