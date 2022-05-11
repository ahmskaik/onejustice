<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class PolicyModel extends SuperModel
{
    use SoftDeletes;

    protected $table = 'policies';
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

    public function getBodyAttribute($value)
    {
        return json_decode($value);
    }

    public function setBodyAttribute($value)
    {
        $this->attributes["body"] = json_encode($value);
    }

    public function type()
    {
        return $this->belongsTo(SystemLookupModel::class, 'type_id');
    }
}
