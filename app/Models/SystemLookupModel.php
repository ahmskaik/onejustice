<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class SystemLookupModel extends SuperModel
{
    use SoftDeletes;

    protected $table = 'system_lookup';
    protected $primaryKey = 'id';
    private static $lookupArray = [];

    public static function setLookupArray()
    {
        static::$lookupArray = self::select(["id", "name_id"])->pluck("id", "name_id")->toArray();
    }

    public function getLookupArray()
    {
        return static::$lookupArray;
    }

    public function user()
    {
        return $this->belongsTo($this->model("SystemUserModel"), "system_user_id");
    }

    public function getSyslkpDataAttribute($value)
    {
        return json_decode($value);
    }

    public function setSyslkpDataAttribute($value)
    {
        $this->attributes["syslkp_data"] = json_encode($value);
    }

    public static function getValue($id, $locale = 'en')
    {
        $data = self::find($id);
        if ($data)
            return $data->syslkp_data->{$locale};

        return "";
    }

    public static function getLookeupByKey($key, $lang = "en", $order = "asc")
    {
        return self::where('parent_id', '=', self::getIdByKey($key))
            ->where('is_active', '=', 1)
            ->select([
                "system_lookup.id",
                "system_lookup.slug",
                "system_lookup.name_id",
                \DB::raw("(CASE WHEN (json_unquote(json_extract(`syslkp_data`, '$.\"{$lang}\"')) IS NULL
                    OR json_unquote(json_extract(`syslkp_data`, '$.\"{$lang}\"')) = '') THEN
                     json_unquote(json_extract(`syslkp_data`, '$.\"" . self::$defaultLang . "\"')) ELSE
                     json_unquote(json_extract(`syslkp_data`, '$.\"{$lang}\"')) END) as text"),

             //   "syslkp_data->" . $lang . " as text",
                "syslkp_data->icon as icon"
            ])
            ->orderBy('order', $order)
            ->orderBy('id', $order)
            ->get();
    }

    public static function getLookeupValueByID($id, $lang = "en")
    {
        return self::where('id', '=', $id)
            ->select(["syslkp_data->" . $lang . " AS text"])->first()->syslkp_data;
    }

    public static function getIdByKey($key)
    {
        return static::$lookupArray[$key];
        //return self::where('name_id', '=', $key)->first()->id;
    }

    public static function getKeyById($id)
    {
        return array_search($id, static::$lookupArray);
        //return self::where('id', '=', $id)->first()->name_id;
    }

    public static function getLookupList($name_id)
    {
        return self::where('parent_id', function ($query) use ($name_id) {
            $query->select('id')->from('system_lookup')->where('name_id', '=', $name_id);
        })->pluck('id')->toArray();
    }


}
