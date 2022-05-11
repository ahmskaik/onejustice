<?php

namespace App\Models;

class ActionRouteModel extends SuperModel
{
    protected $table = 'action_route';
    protected $primaryKey = 'id';
    protected $fillable = ['is_logging', 'is_loggingDetails'];
    public $timestamps = false;

    public function action()
    {
        return $this->belongsTo($this->model("ActionModel"), "action_id");
    }

    public static function inList($route)
    {
        return self::where("route_name", $route)->count();
    }

    public static function getRouteLogs(){
        return self::with("action")->where("can_Logging",1)->orderBy("action_id","asc")->get();
    }

}
