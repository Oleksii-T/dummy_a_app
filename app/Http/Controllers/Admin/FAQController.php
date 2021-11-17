<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FAQ;
use App\Http\Requests\Admin\FAQRequest;
use Yajra\DataTables\DataTables;

class FAQController extends Controller
{
    public function index(Request $request){
        if (!$request->ajax()){
            return view('admin.faqs.index');
        }

        return $this->makeDatatable(FAQ::query());
    }

    private function makeDatatable($faqs)
    {
        return DataTables::of($faqs)
            ->editColumn('answer', function ($faq) {
                $answer = strip_tags($faq->answer);
                if (strlen($answer) > 55) {
                    return substr($answer, 0, 55) . '...';
                }
                return $answer;
            })
			->addColumn('action', function($faq){
				return view('admin.faqs.components.action-list', compact('faq'))->render();
			})
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.faqs.create');
    }

    public function store(FAQRequest $request)
    {
        try {
            $data = $request->validated();
            FAQ::create($data);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Faq created successfully',
            'redirect' => route('admin.faqs.index')
        ]);
    }

    public function edit(FAQ $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(FAQRequest $request, FAQ $faq)
    {
        try {
            $data = $request->validated();
            $faq->update($data);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Faq updated successfully',
            'redirect' => route('admin.faqs.index')
        ]);
    }

    public function destroy(FAQ $faq)
    {
		$faq->delete();

		return response()->json([
            'success' => true,
			'message' => "The faq #$faq->id successfully deleted!"
        ]);
    }
}
