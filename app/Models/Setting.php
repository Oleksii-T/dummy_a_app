<?php

namespace App\Models;

use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory, UploadTrait;

    /**
     * @var array
     */
    protected $fillable = [
        'key',
        'value',
        'is_file'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'value' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function file()
    {
        return $this->morphOne(Attachment::class, 'attachmentable');
    }

    /**
     * @param $key
     * @param bool $onlyValue
     * @return null
     */
    public static function get($key, $onlyValue = true)
    {
        try {
            $setting = self::where('key', $key)->first();
            if ($setting->is_file) {
                return $setting->file;
            }
            return $onlyValue ? $setting->value['value'] : $setting->value;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param $key
     * @param $value
     * @return bool
     */
    public static function set($key, $value)
    {
        try {
            if (is_object($value) && get_class($value) == 'Illuminate\Http\UploadedFile') {
                self::updateOrCreate([
                    'key' => $key
                ], [
                    'key' => $key,
                    'value' => null,
                    'is_file' => true
                ]);

                $setting = self::where('key', $key)->first();
                $uploaded = self::upload($value);
                $setting->file()->delete();
                $setting->file()->create($uploaded);

                return true;
            }

            self::updateOrCreate([
                'key' => $key
            ], [
                'key' => $key,
                'value' => is_string($value) ? ['value' => $value] : $value
            ]);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
