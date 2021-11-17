<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'url',
        'seo_title',
        'seo_description',
        'status',
        'content'
    ];

    CONST STATUSES = ['draft', 'published', 'static'];

    public static function get($url)
    {
        return self::where('url', $url)->first();
    }
}
