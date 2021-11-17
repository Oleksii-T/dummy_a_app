<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadRequest;
use App\Traits\UploadTrait;

class UploadController extends Controller
{
    use UploadTrait;

    /**
     * @param UploadRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UploadRequest $request)
    {
        try {
            $data = $this->upload($request->file('file'));
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'File upload fails'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
