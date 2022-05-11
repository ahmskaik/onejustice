<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;

class SystemUserModel extends SuperModel implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, Notifiable;
    use SoftDeletes;

    /* use Impersonate;*/

    protected $table = 'system_users';
    protected $primaryKey = 'id';
    protected $fillable = ['full_name', 'user_name', 'password'];

    public function getAvatar($value)
    {
        return $value ? ('uploads/users/' . $this->avatar) : 'assets/media/project-logos/7.png';
    }

    public function roles()
    {
        return $this->belongsToMany(RoleModel::class, "system_user_roles", "user_id", "role_id");
    }

    public function actions()
    {
        return $this->belongsToMany(ActionModel::class, "system_user_action", "user_id", "action_id");
    }

    public function user()
    {
        return $this->belongsTo(SystemUserModel::class, "created_by");
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public static function getUsersList(array $filters = [])
    {

        $result = self::select(["system_users.*", "roles.name as role_name", "sys_status.syslkp_data->en as status",
            "roles.id as role_id", "sys_status.name_id", "su.full_name as created_by"])
            ->leftJoin('system_users as su', 'su.id', '=', 'system_users.created_by')
            ->leftJoin('system_user_roles', 'system_user_roles.user_id', '=', 'system_users.id')
            ->leftJoin('roles', 'roles.id', '=', 'system_user_roles.role_id')
            ->leftJoin('system_lookup as sys_status', 'sys_status.id', '=', 'system_users.status');


        if (isset($filters['key']) && $filters['key']) {
            $result = $result->where(function ($q) use ($filters) {
                $q->where('system_users.user_name', 'like', "%" . $filters['key'] . "%")
                    ->orWhere('system_users.full_name', 'like', "%" . $filters['key'] . "%");
            });
        }

        if (isset($filters["role_id"]) && $filters["role_id"]) {
            $result = $result->where('role_id', '=', $filters['role_id']);
        }

        if (isset($filters['from']) && $filters['from']) {
            $result = $result->where('system_users.created_at', '>=', $filters['from']);
        }

        if (isset($filters['to']) && $filters['to']) {
            $result = $result->where(\DB::raw('"system_users"."created_at"::date'), '<=', $filters['to']);
        }
        if (isset($filters['username']) and trim($filters['username'])) {
            $result = $result->where('su.full_name', 'ILIKE', '%' . $filters['username'] . '%');
        }
        //$result = $result->where("system_users.id", "!=", 1);

        return $result;
    }

    public function canDo($route)
    {
        foreach ($this->actions()->with("routes")->get() as $action) {
            if (in_array($route, $action->routes->pluck("route_name")->toArray()))
                return true;
        }

        return false;
    }

    public function getUserActions()
    {
        return self::with(["actions" => function ($q) {
            $q
                //->where("Action_PredecesorActionID", "<", 1)
                ->where("is_menuItem", 1)->where("is_active", 1)
                ->orderBy("menu_order", "asc");
        }, "actions.actions" => function ($q) {
            $q->where("Action_IsMenuItem", 1)->where("is_active", 1)->orderBy("menu_order", "asc");
        }, "actions.routes"])->where("id", $this->id)->first();
    }

    public function getAllowedActions()
    {
        return self::with(["actions" => function ($q) {
            $q->select(["id", "name"]);
        }])->where("id", $this->id)->pluck("id")->toArray();
    }

    public static function updateLoginInfo($id, $SysUsr_LastLoginDate, $SysUsr_LastIPAddress)
    {
        return self::where('id', $id)
            ->update([
                'last_loginDate' => $SysUsr_LastLoginDate,
                'last_IPAddress' => $SysUsr_LastIPAddress
            ]);
    }

    public function deleteOne()
    {
        $this->delete();
    }
}
