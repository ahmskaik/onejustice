<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class MediaGalleryModel extends SuperModel
{
    use SoftDeletes;

    protected $table = 'media_gallery';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function getTitleAttribute($value)
    {
        return json_decode($value);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes["title"] = json_encode($value);
    }

    public function getPathAttribute()
    {
        if ($this->type === 'image')
            return url('uploads/slider/' . $this->file_name);

        return "http://img.youtube.com/vi/$this->file_name/hqdefault.jpg";
    }

    public function language()
    {
        return $this->belongsTo(LanguageModel::class, 'language_id');
    }

    public static function getWebHomeSlides($lang = "en")
    {
        return self::select([
            "media_gallery.id",
            \DB::raw("(CASE WHEN (type = 'video') THEN file_name ELSE concat('" . url('uploads/slider') . "',concat('/' ,file_name))   END) as file_name"),
            "link",
            "type",
            "languages.iso_code as language",
            "title->$lang as caption"
        ])
            ->leftJoin('languages', function ($join) use ($lang) {
                $join->on('languages.id', '=', 'language_id')
                    ->where(function ($query) use ($lang) {
                        $query->where('languages.iso_code', $lang)
                            ->orWhereNull('language_id');
                    });
            })
            ->where('media_gallery.is_active', true)
            ->take(10)
            ->orderBy('media_gallery.sort_order', 'asc')
            ->get();
    }
}
