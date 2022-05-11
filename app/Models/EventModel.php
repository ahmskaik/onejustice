<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class EventModel extends SuperModel
{
    use SoftDeletes;

    protected $table = 'events';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function getCoverImage()
    {
        return $this->cover_image ? loadImage($this->cover_image, 'events', 180, 140, 100, "", 0) : 'cp/images/upload-image-rg.jpg';
    }

    public function getTitleAttribute($value)
    {
        return json_decode($value);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes["title"] = json_encode($value);
    }
    public function getSlugAttribute()
    {
        return \Str::slug($this->title['en'], '-');
    }


    public function getBodyAttribute($value)
    {
        return json_decode($value);
    }

    public function setBodyAttribute($value)
    {
        $this->attributes["body"] = json_encode($value);
    }

    public function user()
    {
        return $this->belongsTo(SystemUserModel::class, 'created_by');
    }

    public function type()
    {
        return $this->belongsTo(SystemLookupModel::class, 'type_id');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }


    public static function getList($filter = [])
    {
        $result = self::query()
            ->leftJoin('system_lookup as sys_type', 'sys_type.id', '=', 'events.type_id')
            ->leftJoin('system_users as su', 'su.id', '=', 'events.created_by');

        return $result
            ->select
            (
                [
                    'events.id',
                    'events.title->en as title_en',
                    'events.views',
                    'events.type_id',
                    'sys_type.syslkp_data->en as type',
                    'events.is_active',
                    "events.date",
                    "events.created_at as dtime",
                    "su.full_name as created_by"
                ]
            );
    }

}
