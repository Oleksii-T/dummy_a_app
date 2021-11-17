<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Http\Requests\Admin\BlogRequest;
use Yajra\DataTables\DataTables;
use App\Traits\UploadTrait;

class BlogController extends Controller
{
    use UploadTrait;

    public function index(Request $request)
    {
        if (!$request->ajax()){
            return view('admin.blogs.index');
        }

        return $this->makeDatatable(Blog::query());
    }

    private function makeDatatable($blogs)
    {
		if (request()->category) {
            $blogs->whereHas('categories', function($q){
                $q->where('id', request()->category);
            });
        }

        return DataTables::of($blogs)
            ->editColumn('content', function ($blog) {
                $content = strip_tags($blog->content);
                if (strlen($content) > 55) {
                    return substr($content, 0, 55) . '...';
                }
                return $content;
            })
			->addColumn('action', function($blog){
				return view('admin.blogs.components.action-list', compact('blog'))->render();
			})
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(BlogRequest $request)
    {
        try {
            $data = $request->validated();
            $blog = Blog::create($data);
            $image = $this->upload($request->file('image'));
            $blog->image()->create($image);
            $blog->categories()->attach($data['categories']);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Blog created successfully',
            'redirect' => route('admin.blogs.index')
        ]);
    }

    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(BlogRequest $request, Blog $blog)
    {
        try {
            $data = $request->validated();
            $blog->update($data);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Blog updated successfully',
            'redirect' => route('admin.blogs.index')
        ]);
    }

    public function destroy(Blog $blog)
    {
		$blog->delete();

		return response()->json([
            'success' => true,
			'message' => "The blog #$blog->id successfully deleted!"
        ]);
    }
}