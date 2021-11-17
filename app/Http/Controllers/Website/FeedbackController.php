<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Page;
use App\Http\Requests\Website\FeedbackRequest;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $page = Page::get('contact-us');
        return view('website.contact-us', compact('page'));
    }

    public function store(FeedbackRequest $request, Feedback $feedback)
    {
        try {
            $data = $request->validated();
            if (auth()->check()) {
                $data['user_id'] = auth()->id();
            }
            $feedback = Feedback::create($data);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Message send successfully'
        ]);
    }
}