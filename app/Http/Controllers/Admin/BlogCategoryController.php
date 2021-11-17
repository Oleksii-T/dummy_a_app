<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Http\Requests\Admin\BlogCategoryRequest;
use Yajra\DataTables\DataTables;

class BlogCategoryController extends Controller
{
    public function index(Request $request){
        if (!$request->ajax()){
            return view('admin.blog-categories.index');
        }

        return $this->makeDatatable(BlogCategory::query());
    }

    private function makeDatatable($categories)
    {
        return DataTables::of($categories)
			->addColumn('action', function($category){
				return view('admin.blog-categories.components.action-list', compact('category'))->render();
			})
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.blog-categories.create');
    }

    public function store(BlogCategoryRequest $request)
    {
        try {
            $data = $request->validated();
            BlogCategory::create($data);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Blog category created successfully',
            'redirect' => route('admin.blog-categories.index')
        ]);
    }

    public function edit(BlogCategory $blogCategory)
    {
        return view('admin.blog-categories.edit', compact('blogCategory'));
    }

    public function update(BlogCategoryRequest $request, BlogCategory $blogCategory)
    {
        try {
            $data = $request->validated();
            $blogCategory->update($data);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Blog category updated successfully',
            'redirect' => route('admin.blog-categories.index')
        ]);
    }

    public function destroy(BlogCategory $blogCategory)
    {
		$blogCategory->delete();

		return response()->json([
            'success' => true,
			'message' => "The blog category #$blogCategory->id successfully deleted!"
        ]);
    }
}
