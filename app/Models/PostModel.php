<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class PostModel extends SuperModel
{
    use SoftDeletes;

    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected static $postFields = ['id', 'title', 'summary', 'cover_image', 'type_id', 'category_id', 'date'];

    public function getSlugAttribute()
    {
        return \Str::slug($this->title, '-');
    }

    public function getCoverImage()
    {
        return $this->cover_image ? loadImage($this->cover_image, 'posts', 180, 140, 100, "", 0) : 'cp/images/upload-image-rg.jpg';
    }

    public function countries()
    {
        return $this->belongsToMany(CountryModel::class, "post_countries", "post_id", "country_id");
    }

    public function user()
    {
        return $this->belongsTo(SystemUserModel::class, 'created_by');
    }

    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id');
    }

    public function type()
    {
        return $this->belongsTo(SystemLookupModel::class, 'type_id');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public static function get($active_language_id)
    {
        return self::Published()->select(self::$postFields)->Language($active_language_id)->orderby('date', 'desc');
    }

    public function scopePublished($query)
    {
        return $query->where('status_id', SystemLookupModel::getIdByKey('POST_STATUS_PUBLISHED'));
    }

    public function scopeLanguage($query, $language_id)
    {
        return $query->where('language_id', $language_id);
    }

    public function scopeReports($query)
    {
        return $query->where('category_id', SystemLookupModel::getIdByKey('POST_TYPE_REPORT'));
    }

    public static function getList($filter = [])
    {
        $result = self::query()
            ->leftJoin('system_lookup as sys_status', 'sys_status.id', '=', 'posts.status_id')
            ->leftJoin('categories', 'categories.id', '=', 'posts.category_id')
            ->leftJoin('languages', 'languages.id', '=', 'posts.language_id')
            ->leftJoin('system_users as su', 'su.id', '=', 'posts.created_by')
            ->when(isset($filter['category_id']) && $filter['category_id'], function ($query) use ($filter) {
                $query->where('posts.category_id', $filter['category_id']);
            })->when(isset($filter['status_id']) && $filter['status_id'], function ($query) use ($filter) {
                $query->where('posts.status_id', $filter['status_id']);
            })
            ->when(isset($filter['language_id']) && $filter['language_id'], function ($query) use ($filter) {
                $query->where('posts.language_id', $filter['language_id']);
            })->when(isset($filter['type_id']) && $filter['type_id'], function ($query) use ($filter) {
                $query->where('posts.type_id', $filter['type_id']);
            })
            ->when(isset($filter['title']) && $filter['title'], function ($query) use ($filter) {
                $query->where('posts.title', 'like', "%" . $filter['title'] . "%");
            });

        if (isset($filter['is_featured'])) {
            $result = $result->where('posts.is_featured', $filter['is_featured']);
        }


        return $result
            ->select
            (
                [
                    'posts.id',
                    'posts.title',
                    'posts.views',
                    'posts.date',
                    'posts.is_featured',
                    'sys_status.syslkp_data->en as status',
                    'sys_status.syslkp_data->class as statusClass',
                    'categories.name->en as category',
                    "posts.date as dtime",
                    "languages.name as language",
                    "languages.flag",
                    "su.full_name as created_by"
                ]
            );
    }

}
