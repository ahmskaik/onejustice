<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class LanguageModel extends SuperModel
{
    use SoftDeletes;

    protected $table = 'languages';
    protected $primaryKey = 'id';

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->get();
    }

    public function getTranslationsAttribute($value)
    {
        return json_decode($value);
    }

    public function setTranslationsAttribute($value)
    {
        $this->attributes["translations"] = json_encode($value);
    }
}
