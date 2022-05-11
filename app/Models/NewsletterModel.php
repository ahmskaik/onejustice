<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Str;

class NewsletterModel extends SuperModel
{
    use SoftDeletes;

    protected $table = 'newsletters';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public static function getList($filter = [])
    {
        $result = self::query()
            ->leftJoin('languages', 'languages.id', '=', 'newsletters.language_id')
            ->leftJoin('system_users as su', 'su.id', '=', 'newsletters.created_by')
            ->when(isset($filter['language_id']) && $filter['language_id'], function ($query) use ($filter) {
                $query->where('newsletters.language_id', $filter['language_id']);
            });

        return $result
            ->select
            (
                [
                    'newsletters.id',
                    'newsletters.title',
                    'newsletters.date',
                    'newsletters.is_active',
                    "newsletters.created_at as dtime",
                    "languages.name as language",
                    "languages.flag",
                    "su.full_name as created_by"
                ]
            );
    }

    public function getSlugAttribute()
    {
        return Str::slug($this->title, '-');
    }

    public function getCoverImage()
    {
        return $this->cover_image ? loadImage($this->cover_image, 'newsletters', 180, 140, 100, "", 0) : 'cp/images/upload-image-rg.jpg';
    }

    public function user()
    {
        return $this->belongsTo(SystemUserModel::class, 'created_by');
    }

    public function language()
    {
        return $this->belongsTo(LanguageModel::class, 'language_id');
    }

}
