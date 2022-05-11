<?php

namespace App\Models;

class ActionModel extends SuperModel
{
    protected $table = 'actions';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function getNameAttribute($value)
    {
        return json_decode($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes["name"] = json_encode($value);
    }
    public function getMenuGroupNameAttribute($value)
    {
        return json_decode($value);
    }

    public function setMenuGroupNameAttribute($value)
    {
        $this->attributes["menu_group_name"] = json_encode($value);
    }
    public function actions()
    {
        return $this->hasMany(ActionModel::class, "parent_action_id");
    }

    public function countActionsMenu()
    {
        return $this->hasOne($this->model("ActionModel"), "parent_action_id_menu")
            ->select(["id", "parent_action_id_menu", \DB::raw("count(*) as actionsNo")])
            ->where("is_menuItem", 1)->where("is_active", 1)->orderBy("menu_order", "asc")
            ->groupBy("parent_action_id_menu", "id");
    }

    public function countActions()
    {
        return $this->hasOne($this->model("ActionModel"), "parent_action_id")
            ->select(["id", "parent_action_id", \DB::raw("count(*) as actionsNo")])
            ->where("is_menuItem", 1)->where("is_active", 1)->orderBy("menu_order", "asc")
            ->groupBy("parent_action_id", "Actions.id");
    }

    public function actionsMenu()
    {
        return $this->hasMany(ActionModel::class, "parent_action_id_menu");
    }

    public function routes()
    {
        $o = $this->hasMany(ActionRouteModel::class, "action_id")->orderBy("id", "asc");
        return $o;
    }

    public function routesLog()
    {
        return $this->hasMany(ActionRouteModel::class, "action_id")->where("can_Logging", 1);
    }

    public function route()
    {
        return $this->hasOne(ActionRouteModel::class, "action_id")->orderBy("id", "asc")->limit(1);
    }

    public function users()
    {
        return $this->belongsToMany(SystemUserModel::class, "system_user_action", "user_id", "action_id");
    }

    public static function getMenu($user_id)
    {
        $o = self::with(["routes", "actionsMenu.routes", "actionsMenu.actionsMenu.routes", "actionsMenu" => function ($q) {
            $q->where("is_menuItem", 1)
                ->where("is_active", 1)
                ->orderBy("menu_order", "asc");
        }, "actionsMenu.countActionsMenu" => function ($q) {
        }, "actionsMenu.actionsMenu.countActionsMenu" => function ($q) {
        }, "users" => function ($q) use ($user_id) {
            $q->where("id", $user_id);
        }])
            ->whereNull("parent_action_id")
            ->whereNull("parent_action_id_menu")
            ->where("is_menuItem", 1)
            ->where("is_active", 1)
            ->orderBy("menu_order", "asc")
            ->get();
        return $o;
    }

    public static function actionsForLog()
    {
        return self::with(["actions.routesLog", "routesLog"])
            ->where(function ($q) {
                //    $q->orHas("routesLog")->orHas("actions.routesLog");
            })
            ->where("is_active", 1)
            ->where("parent_action_id", NULL)
            ->orderBy("menu_order", "asc")
            ->get();
    }
}
