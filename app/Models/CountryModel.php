<?php

namespace App\Models;


class CountryModel extends SuperModel
{
    protected $table = 'countries';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'postal', 'properties'];

    public static function getCountriesList(array $filters = [])
    {
        $result = self::select('*')->withCount('cities');
        if (isset($filters['continent']) && $filters['continent']) {
            $result = $result->where('continent', $filters['continent']);
        }
        if (isset($filters['name']) && $filters['name']) {
            $result = $result->where(function ($q) use ($filters) {
                $q->where('properties->en', 'like', "%" . $filters['name'] . "%")
                    ->orWhere('properties->ar', 'like', "%" . $filters['name'] . "%");
            });


        }
        return $result;
    }

    public function getPropertiesAttribute($value)
    {
        return json_decode($value);
    }

    public function setPropertiesAttribute($value)
    {
        $this->attributes["properties"] = json_encode($value);
    }

    public function getGeometryAttribute($value)
    {
        return json_decode($value);
    }

    public function setGeometryAttribute($value)
    {
        $this->attributes["geometry"] = json_encode($value);
    }

    public function posts()
    {
        return $this->belongsToMany(PostModel::class, "post_countries", "country_id", "post_id");
    }

    public function cities()
    {
        return $this->hasMany(CityModel::class, 'country_id');
    }
}
