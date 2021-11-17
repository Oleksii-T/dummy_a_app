<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

trait UploadTrait {

	// saves file to file storage
	protected static function upload($file)
	{
        $storage = Storage::disk('attachments');
		$fileNewName = $storage->putFile('', new File($file));
		$relativePath = str_replace(base_path().'/', '', $storage->path($fileNewName));
		return [
			'type' => explode('/', $file->getMimeType())[0],
			'original_name' => $file->getClientOriginalName(),
			'name' => $fileNewName,
			'path' => $relativePath,
			'size' => $file->getSize(),
			'url' => $storage->url($fileNewName)
		];
	}

}