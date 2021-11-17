<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Http\Requests\Admin\PageRequest;
use Yajra\DataTables\DataTables;

class PageController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()){
            return view('admin.pages.index');
        }

        return $this->makeDatatable(Page::query());
    }

    private function makeDatatable($pages)
    {
        if (request()->status !== null) {
            $pages->where('status', request()->status);
        }

        return DataTables::of($pages)
			->editColumn('url', function($page){
                return '<a href="'.url($page->url).'" target="_blank">'.url($page->url).'</a>';
			})
			->editColumn('created_at', function($page){
                return $page->created_at->format('Y-m-d');
			})
			->addColumn('action', function($page){
				return view('admin.pages.components.action-list', compact('page'))->render();
			})
            ->rawColumns(['url', 'action'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(PageRequest $request)
    {
        try {
            $data = $request->validated();
            $page = Page::create($data);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Page created successfully',
            'redirect' => route('admin.pages.index')
        ]);
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(PageRequest $request, Page $page)
    {
        try {
            $data = $request->validated();
            $page->update($data);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Page updated successfully',
            'redirect' => route('admin.pages.index')
        ]);
    }

    public function destroy(Page $page)
    {
        if ($page->status == 'static') {
            return response()->json([
                'success' => false,
                'message' => "The static page can not be deleted!"
            ]);

        }
		$page->delete();

		return response()->json([
            'success' => true,
			'message' => "The page #$page->id successfully deleted!"
        ]);
    }
}