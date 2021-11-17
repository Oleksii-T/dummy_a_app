<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    public function index(Request $request, $url)
    {
        $page = Page::where('url', $url)->where('status', 'published')->firstOrFail();

        return view('website.custom-page', compact('page'));
    }
}