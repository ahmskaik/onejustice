<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class DonationModel extends SuperModel
{
    use SoftDeletes;

    protected $table = 'donations';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = ['payload'=>'array'];

    public static function getList($filter = [])
    {
        return self::query()->select(['donations.*']);
    }
}
