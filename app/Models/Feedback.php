<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';

    use HasFactory;

    protected $fillable = [
        'user_id',
        'is_read',
        'name',
        'email',
        'title',
        'content'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
