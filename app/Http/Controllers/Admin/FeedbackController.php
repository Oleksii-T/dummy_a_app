<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use Yajra\DataTables\DataTables;

class FeedbackController extends Controller
{

    public function index(Request $request)
    {
        if (!$request->ajax()){
            return view('admin.feedbacks.index');
        }

        return $this->makeDatatable(Feedback::query());
    }

    private function makeDatatable($feedbacks)
    {
        if (request()->is_read !== null) {
            $feedbacks->where('is_read', request()->is_read);
        }

        return DataTables::of($feedbacks->orderBy('is_read'))
			->addColumn('user', function($feedback){
                $user = $feedback->user;
                if ($user) {
                    return '<a href="' . route('admin.users.edit', $user) . '">' . $feedback->name . '</a>';
                }
                return $feedback->name;
			})
			->editColumn('content', function($feedback){
                $content = $feedback->content;
                if (strlen($content) > 40) {
                    return substr($content, 0, 40) . '...';
                }
                return $content;
			})
			->editColumn('created_at', function($feedback){
                return $feedback->created_at->format('Y-m-d H:i');
			})
			->addColumn('action', function($feedback){
				return view('admin.feedbacks.components.action-list', compact('feedback'))->render();
			})
            ->rawColumns(['user', 'action'])
            ->make(true);
    }

    public function show(Feedback $feedback)
    {
        return view('admin.feedbacks.show', compact('feedback'));
    }

    public function read(Feedback $feedback)
    {
		$feedback->update(['is_read' => true]);

		return response()->json([
            'success' => true,
			'message' => "The feedback #$feedback->id successfully readed!"
        ]);
    }

    public function destroy(Feedback $feedback)
    {
		$feedback->delete();

		return response()->json([
            'success' => true,
			'message' => "The feedback #$feedback->id successfully deleted!"
        ]);
    }
}