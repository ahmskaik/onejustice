<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class RoleModel extends SuperModel
{
    use SoftDeletes;

    protected $table = 'roles';
    protected $primaryKey = 'id';

    public function actions()
    {
        return $this->belongsToMany(ActionModel::class, "role_action", "role_id", "action_id");
    }

    public function users()
    {
        return $this->belongsToMany(SystemUserModel::class, "system_user_roles", "role_id", "user_id");
    }

    public function user()
    {
        return $this->belongsTo(SystemUserModel::class, "created_by");
    }

    public static function getRolesList(array $filters = [])
    {

        $result = self::select(
            [
                "roles.*",
                "system_lookup.name_id",
                "system_lookup.syslkp_data->en as status",
                "system_users.full_name"
            ])
            ->selectRaw('(select count(user_id) from system_user_roles where system_user_roles.role_id =roles.id )as userCounter')
            ->leftJoin('system_users', 'system_users.id', '=', 'roles.created_by')
            ->leftJoin('system_lookup', 'system_lookup.id', '=', 'roles.status');


        if (isset($filters['key']) && !empty($filters['key'])) {
            $result->where('name', 'ilike', "%" . $filters['key'] . "%");
        }


        if (isset($filters['username']) and trim($filters['username'])) {
            $result = $result->where('system_users.full_name', 'ILIKE', '%' . $filters['username'] . '%');
        }


        if (isset($filters['from']) && $filters['from']) {
            $result = $result->where('roles.created_at', '>=', $filters['from']);
        }

        if (isset($filters['to']) && $filters['to']) {
            $result = $result->where(\DB::raw('"roles"."created_at"::date'), '<=', $filters['to']);
        }
        return $result;
    }

    public static function getRoleName($role_id)
    {
        $result = self::where("id", $role_id)->first();
        if ($result)
            return $result->name;
        return "";
    }

    public function deleteOne()
    {
        $this->delete();
    }
}
