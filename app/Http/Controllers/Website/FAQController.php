<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\FAQ;
use App\Models\Page;

class FAQController extends Controller
{
    /**
     * @return $this
     */
    public function index()
    {
        $faqs = FAQ::latest()->get();
        $page = Page::get('faq');
        return view('website.faq', compact('faqs', 'page'));
    }
}
