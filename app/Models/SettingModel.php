<?php

namespace App\Models;

class SettingModel extends SuperModel
{
    protected $table = 'system_settings';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = ['sysset_data'];

    public function getSyssetDataAttribute($value)
    {
        return json_decode($value);
    }
    public function setSyssetDataAttribute($value)
    {
        $this->attributes["sysset_data"] = json_encode($value);
    }
}
