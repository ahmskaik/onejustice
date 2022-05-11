<?php

namespace App\Models;

class BannerModel extends SuperModel
{
    protected $table = 'banners';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function getImage()
    {
        return $this->image ? loadImage($this->image, 'banners', 180, 140, 100, "", 0) : 'cp/images/upload-image-rg.jpg';
    }

    public function getTitleAttribute($value)
    {
        return json_decode($value);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes["title"] = json_encode($value);
    }

    public function user()
    {
        return $this->belongsTo(SystemUserModel::class, 'created_by');
    }

    public function position()
    {
        return $this->belongsTo(SystemLookupModel::class, 'position_id');
    }

    public static function getList($filter = [])
    {
        $result = self::query()
            ->leftJoin('system_lookup as sys_position', 'sys_position.id', '=', 'banners.position_id')
            ->leftJoin('system_users as su', 'su.id', '=', 'banners.created_by');

        return $result
            ->select
            (
                [
                    'banners.id',
                    'banners.title->en as title_en',
                    'banners.title->ar as title_ar',
                    'banners.position_id',
                    'sys_position.syslkp_data->en as position',
                    'banners.is_active',
                    "banners.created_at as dtime",
                    "su.full_name as created_by"
                ]
            );
    }

}
