<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class InquiryModel extends SuperModel
{
    use SoftDeletes;

    protected $table = 'inquiries';
    protected $primaryKey = 'id';
    protected $guarded = [];


    public static function getList($filter = [])
    {
        return self::query()->select(['inquiries.*']);
    }

    public function scopeUnseenList($query)
    {
        return $query->whereNull('seen_at');
    }
}
