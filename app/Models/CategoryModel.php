<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryModel extends SuperModel
{
    use SoftDeletes;

    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $guarded = [];
    /*public const POST_CATEGORY_PUBLICATIONS = 1;*/
    public const POST_CATEGORY_REPORTS = 1;
    public const POST_CATEGORY_STATEMENTS = 2;
    public const POST_CATEGORY_MEDIA = 3;

    public function getNameAttribute($value)
    {
        return json_decode($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes["name"] = json_encode($value);
    }

    public function subCategories()
    {
        return $this->hasMany(CategoryModel::class, 'parent_id')->with('subCategories');
    }

    public function activeSubCategories()
    {
        return $this->hasMany(CategoryModel::class, 'parent_id')->where('is_active', true);
    }

    public function user()
    {
        return $this->belongsTo(SystemUserModel::class, "created_by");
    }

    public function parent()
    {
        return $this->belongsTo(CategoryModel::class, "parent_id");
    }

    public function scopeActive($query, $exclude_id = '')
    {
        return $query->where('is_active', true)
            ->when($exclude_id, function ($query) use ($exclude_id) {
                $query->where('id', '!=', $exclude_id);
            })->orderBy('id', 'desc')
            ->select('id', 'name->' . strtolower(\App::getLocale()) . ' as title')
            ->get();
    }

    public function scopeFeatured($query, $exclude_id = '', $take = 10, $lang = 'en')
    {
        return $query->where('is_active', true)
            ->when($exclude_id, function ($query) use ($exclude_id) {
                $query->where('id', '!=', $exclude_id);
            })
            ->select('id',
                \DB::raw("concat('" . url('uploads/categories') . "',concat('/' ,icon)) as icon"),
                'name->' . $lang . ' as title')
            ->take($take)
            ->get();
    }

    public static function getActiveList($limit = 10, $lang = 'en')
    {
        $result = self::select('id', 'name->' . strtolower(\App::getLocale()) . ' as title', 'thumb_image')
            ->where('is_active', true)
            ->paginate($limit);


        return $result;
    }

    public static function getFeaturedList($lang = 'en', $limit = 10, $exclude_id = '')
    {
        return self::query()
            ->where('is_active', true)
            ->where('featured', true)
            ->when($exclude_id, function ($query) use ($exclude_id) {
                $query->where('id', '!=', $exclude_id);
            })
            ->select(['id',
                \DB::raw("concat('" . url('uploads/categories') . "',concat('/' ,icon)) as icon"),
                \DB::raw("(CASE WHEN (json_unquote(json_extract(`name`, '$.\"{$lang}\"')) IS NULL OR json_unquote(json_extract(`name`, '$.\"{$lang}\"')) = '') THEN json_unquote(json_extract(`name`, '$.\"" . parent::$defaultLang . "\"')) ELSE json_unquote(json_extract(`name`, '$.\"{$lang}\"')) END) as title"),
            ])
            ->take($limit)
            ->get();
    }

    public function scopeRoots($query, $exclude_id = '')
    {
        return $query->whereNull('parent_id')
            ->when($exclude_id, function ($query) use ($exclude_id) {
                $query->where('id', '!=', $exclude_id);
            })
            ->select('id', 'name->' . strtolower(\App::getLocale()) . ' as title')
            ->orderBy('id', 'desc')->get();
    }

    public function scopeActiveRoots($query, $exclude_id = '')
    {
        $lang = strtolower(\App::getLocale());
        return $query->where('is_active', true)
            ->whereNull('parent_id')
            ->when($exclude_id, function ($query) use ($exclude_id) {
                $query->where('id', '!=', $exclude_id);
            })
            ->select('id',
                \DB::raw("(CASE WHEN (json_unquote(json_extract(`name`, '$.\"{$lang}\"')) IS NULL
                    OR json_unquote(json_extract(`name`, '$.\"{$lang}\"')) = '') THEN
                     json_unquote(json_extract(`name`, '$.\"" . self::$defaultLang . "\"')) ELSE
                     json_unquote(json_extract(`name`, '$.\"{$lang}\"')) END) as title"),
                //  'name->' . strtolower(\App::getLocale()) . ' as title',
                'slug')
            ->orderBy('id', 'desc')->get();
    }

    public function scopeActiveRootsTopNav($query, $exclude_id = '')
    {
        return $query->where('is_active', true)
            ->whereNull('parent_id')
            ->where('top', true)
            ->when($exclude_id, function ($query) use ($exclude_id) {
                $query->where('id', '!=', $exclude_id);
            })->orderBy('id', 'desc')->get();
    }

    public static function getList($filter = [], $lang = 'ar')
    {
        $result = self::query()
            ->leftJoin('system_users as su', 'su.id', '=', 'categories.created_by');

        if (isset($filter['name']) and trim($filter['name'])) {
            $result = $result->where('categories.name->' . $lang, 'like', '%' . $filter['name'] . '%');
        }


        $result->select(
            [
                'categories.id',
                'categories.name->' . $lang . ' as category_name',
                'categories.created_by',
                'categories.is_active as statusValue',
                "su.full_name as creator",
                "categories.created_at as dtime",
                "categories.parent_id",
            ]);

        return $result;
    }

    public function getSubCategoriesTree($parent = 0, &$tree = null, $categories = null, &$st = '')
    {
        $categories = $categories ?? $this->get()->groupBy('parent_id');
        $tree = $tree ?? [];
        $lisCategory = $categories[$parent];
        foreach ($lisCategory as $category) {
            $tree[$category->id] = $st . $category->name->ar;
            if (!empty($categories[$category->id])) {
                $st .= '--';
                $this->getSubCategoriesTree($category->id, $tree, $categories, $st);
                $st = '';
            }
        }

        return $tree;
    }

    public function getParentCategoriesTree($id = 0, &$tree = null, $categories = null, &$st = '')
    {
        $categories = $categories ?? $this->get()->groupBy('id');
        $tree = $tree ?? [];
        $lisCategory = $categories[$id];

        foreach ($lisCategory as $category) {
            $tree[$category->id] = $category->name->{strtolower(\App::getLocale())};
            if (!empty($categories[$category->parent_id])) {
                $this->getParentCategoriesTree($category->parent_id, $tree, $categories, $st);
            }
        }

        return $tree;
    }

    public function getParentCategoriesTreeHTML($id = 0, &$tree = null, $categories = null, &$st = '')
    {
        $categories = $categories ?? $this->get()->groupBy('id');
        $tree = $tree ?? [];
        $lisCategory = $categories[$id];

        foreach ($lisCategory as $category) {
            //if ($category->id == $parent) continue;
            $tree[$category->id] = $st . $category->name->ar;
            if (!empty($categories[$category->parent_id])) {
                $st .= '--';
                $this->getParentCategoriesTree($category->parent_id, $tree, $categories, $st);
                $st = '';
            }
        }

        return $tree;
    }

    public function saveData($data, $slug, $is_active, $parent_id = NULL, $is_featured = false, $icon = "", $main_image = "", $created_by = "")
    {
        $this->name = $data;
        $this->slug = $slug;
        $this->parent_id = $parent_id;
        $this->is_active = $is_active;
        $this->is_featured = $is_featured;

        if ($icon)
            $this->icon = $icon;

        if ($main_image)
            $this->main_image = $main_image;

        if ($created_by)
            $this->created_by = $created_by;


        $this->save();
    }
}
