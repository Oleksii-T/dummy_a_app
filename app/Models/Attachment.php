<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    use HasFactory;

	protected $fillable = [
        'attachmentable_id_id',
        'attachmentable_id_type',
        'type',
        'original_name',
        'name',
        'group',
        'path',
        'size'
    ];

	protected $appends= [
		'url'
	];

    protected $hidden = [
        'attachmentable_type',
    ];

    public function attachmentable()
    {
        return $this->morphTo();
    }

	public function getUrlAttribute()
	{
		return Storage::disk('attachments')->url($this->name);
	}
	
	protected static function boot()
    {
        parent::boot();

        static::deleting(function ($attachment) {
            Storage::disk('attachments')->delete($attachment->name);
        });
    }
}
