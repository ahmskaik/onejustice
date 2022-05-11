<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RoleRequest;
use App\Models\ActionModel;
use App\Models\RoleModel;
use App\Models\SystemLookupModel;
use App\Models\SystemUserModel;
use App\Models\SystemUserRoleModel;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Session;
use Yajra\Datatables\Datatables;

class RoleController extends SuperAdminController
{
    protected $allowed;

    public function __construct()
    {
        parent::__construct();
        parent::$data['active_menu'] = 'role_view';
        parent::$data['active_menuPlus'] = 'role_view';
        parent::$data['route'] = 'role';
        parent::$data["breadcrumbs"] = ["Dashboard" => parent::$data['cp_route_name'], "roles" => parent::$data['cp_route_name'] . "/role"];
        $this->allowed = ["view" => 2, "status" => 3, "create" => 4, "edit" => 5, "delete" => 6];
        parent::$data['allowed'] = $this->allowed;
    }

    public function index()
    {
        try {
            parent::$data['roleStatus'] = SystemLookupModel::getLookeupByKey("ROLE_STATUS");
            parent::$data['roles'] = RoleModel::where("status", SystemLookupModel::getIdByKey("ROLE_STATUS_ACTIVE"))->get();

        } catch (Exception $e) {
            /*  print_r($e->getMessage());
              return;*/
        }

        if (Session::has("success"))
            parent::$data["success"] = Session::get("success");

        parent::$data['title'] = "Roles Management";
        parent::$data["breadcrumbs"]["List"] = "";
        return view('cp.roles.index', parent::$data);
    }

    public function get(Request $request)
    {
        $columns = $request->get('columns');

        $filter = [];

        $filter["username"] = isset($columns[5]['search']['value']) ? xss_clean($columns[5]['search']['value']) : '';

        $creation_date = isset($columns[4]['search']['value']) ? xss_clean($columns[4]['search']['value']) : '';
        if ($creation_date) {
            $created_at = explode('|', $creation_date);
            $filter['from'] = isset($created_at[0]) ? trim($created_at[0]) : '';
            $filter['to'] = isset($created_at[1]) ? trim($created_at[1]) : '';
        }

        $key = isset($columns[1]['search']['value']) ? xss_clean($columns[1]['search']['value']) : '';
        if ($key) {
            $filter['key'] = $key;
        }

        $roles = RoleModel::getRolesList($filter);

        $table = Datatables::of($roles)
            ->editColumn('status', function ($data) use ($request) {
                if ($request->input("export"))
                    return $data->status;
                return '<div class="d-block kt-align-center"><span class="kt-badge kt-badge--inline kt-badge--pill ' . (trim($data->name_id) == "ROLE_STATUS_ACTIVE" ? "kt-badge--success" : "kt-badge--danger") . '">' . $data->status . '</span></div>';
            })
            ->editColumn('userCounter', function ($data) use ($request) {
                if ($request->input("export"))
                    return $data->userCounter ? $data->userCounter : 0;

                return '<div class="d-block kt-align-center"><span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--info">' . $data->userCounter ?? 0 . '</span></div>';
            })
            ->editColumn('name', function ($data) use ($request) {
                if ($request->input("export"))
                    return $data->name;
                if (in_array($this->allowed["edit"], self::$data["allowedActions"])) {
                    return '<a data-id="' . $data->id . '" class="roletxt" href="' . parent::$data['cp_route_name'] . '/role/edit/' . $data->id . '">' . $data->name . '</a>';
                } else {
                    return '<a data-id="' . $data->id . '" class="roletxt">' . $data->name . '</a>';
                }
            })
            ->editColumn('full_name', function ($data) use ($request) {
                if ($request->input("export"))
                    return $data->full_name;

                return '<div class="d-block kt-align-center">' . ($data->full_name ?? "--") . '</div>';


            })
            ->editColumn('created_at', function ($data) use ($request) {
                if ($request->input("export"))
                    return $data->created_at;

                return '<div class="d-block kt-align-center">' . (($data->created_at) ? date_format(date_create($data->created_at), 'Y-m-d') : "--") . '</div>';


            });

        if (!$request->input("export") && $request->ajax()) {
            $table->addColumn('action', function ($data) {
                $result = '<div class="actions tbl-sm-actions tblactions-five  d-block kt-align-center">';
                if (in_array($this->allowed["edit"], self::$data["allowedActions"])) {
                    $result .= '<a class="btn btn-outline-success btn-icon btn-circle btn-sm ml-2"
                     href="' . parent::$data['cp_route_name'] . '/' . parent::$data['route'] . '/edit/' . $data->id . '"
                     data-skin="dark" data-placement="top" title="edit" data-original-title="edit">
                                    <i class="la la-edit"></i>
                                </a>';
                }
                if (in_array($this->allowed["delete"], self::$data["allowedActions"])) {
                    $result .= '<a class="btn btn-outline-danger btn-icon btn-circle btn-sm ml-2 btn-delete"
                     href="' . parent::$data['cp_route_name'] . '/' . parent::$data['route'] . '/delete/' . $data->id . '"
                     data-skin="dark" data-name="' . $data->name . '"
                     data-placement="top" title="Delete" data-original-title="Delete">
                                    <i class="la la-trash"></i>
                                </a>';
                }

                return $result;
            });
        }

        $table = $table->escapeColumns([])->make(true);

        if ($request->ajax())
            return $table;
        if ($request->input("export")) {
            $table = json_decode(json_encode($table->getData()), true);
            $aliases = ["name" => "Role Name", "status" => "status",
                "userCounter" => "Users Count", "created_at" => "Creation Date", "full_name" => "Created By"];
            $type = $request->input("export");
            if (!in_array($type, ["xlsx", "csv", "pdf"]))
                $type = "csv";

            $filter = [];
            $status = "All";
            if (isset($columns[2]['search']['value']) && $columns[2]['search']['value']) {
                $status = SystemLookupModel::getLookeupValueByID($columns[2]['search']['value']);
            }

            $filter["Name"] = isset($columns[1]['search']['value']) && $columns[1]['search']['value'] ? $columns[1]['search']['value'] : 'N/A';
            $filter["Created By"] = isset($columns[5]['search']['value']) && $columns[5]['search']['value'] ? $columns[5]['search']['value'] : 'N/A';
            $filter["Status"] = $status;
            $filter['from'] = 'N/A';
            $filter['to'] = 'N/A';

            if (isset($columns[4]['search']['value']) && $columns[4]['search']['value']) {
                $created_at = explode('|', $columns[4]['search']['value']);
                $filter['from'] = isset($created_at[0]) ? $created_at[0] : 'N/A';
                $filter['to'] = isset($created_at[1]) ? $created_at[1] : 'N/A';
            }
            return $this->exportFile("Roles Report", $this->formatAliases($table, $aliases), $type, $filter);

        }

        redirect(parent::$data['cp_route_name'] . '/role');
    }

    public function create()
    {
        parent::$data['title'] = '';
        parent::$data['page_title'] = "Add New Role";
        parent::$data['creator'] = Auth::user("admin")->full_name;
        parent::$data['created_at'] = date("Y-m-d");
        parent::$data['actions'] = ActionModel::with("actions")->where("is_active", 1)->where("parent_action_id", NULL)->orderBy("menu_order", "asc")->get();
        parent::$data['roleActions'] = [];
        parent::$data['isRole'] = true;
        parent::$data["result"] = new RoleModel();

        if (Session::has("success"))
            parent::$data["success"] = Session::get("success");

        parent::$data["status"] = false;
        parent::$data["breadcrumbs"]["New"] = "";

        return view('cp.roles.form', parent::$data);
    }

    public function store(RoleRequest $request)
    {
        $role = new RoleModel();
        $role->name = xss_clean($request->input('name'));
        $role->created_by = Auth::user("admin")->id;
        if ($request->input("status") == 1) {
            $role->status = SystemLookupModel::getIdByKey("ROLE_STATUS_ACTIVE");
        } else {
            $role->status = SystemLookupModel::getIdByKey("ROLE_STATUS_INACTIVE");
        }

        $role->save();
        // for saving actions
        $actions = $request->input("action");
        if ($actions && is_array($actions)) {
            $role->actions()->attach($actions);
        }

        $message = "Role Added Successfully";
        $status = "success";
        /*   if ($request->input("quick") == 1) {
               return $role;
           } elseif (isset($_POST["save_new"]))
               return redirect(parent::$data['cp_route_name'] . "/role/create")->with($status, $message);
           else
           return redirect(parent::$data['cp_route_name'] . "/role")->with($status, $message);
   */
        return redirect(parent::$data['cp_route_name'] . "/role/edit/" . $role->id)->with($status, $message);

    }

    public function edit($id)
    {
        $role = RoleModel::with(["user", "actions"])->find($id);
        if (!$role)
            return redirect(parent::$data['cp_route_name'] . "/role");

        parent::$data['title'] = '';
        parent::$data['page_title'] = "Update Role";

        parent::$data['creator'] = $role->user->full_name ?? '';
        parent::$data['created_at'] = date_format(date_create($role->created_at), 'Y-m-d');
        parent::$data['actions'] = ActionModel::with("actions")->where("is_active", 1)->where("parent_action_id", NULL)->orderBy("menu_order", "asc")->get();

        parent::$data['result'] = $role;
        parent::$data['roleActions'] = $role->actions->pluck("id")->toArray();
        parent::$data['isRole'] = true;

        if (Session::has("success"))
            parent::$data["success"] = Session::get("success");

        parent::$data["status"] = $role->status == SystemLookupModel::getIdByKey("ROLE_STATUS_ACTIVE");
        parent::$data["breadcrumbs"]["Edit"] = "";
        return view('cp.roles.form', parent::$data);
    }

    public function update(RoleRequest $request, $id)
    {
        $role = RoleModel::with(["user", "actions"])->find($id);
        if (!$role)
            return redirect(parent::$data['cp_route_name'] . "/role");

        $role->name = xss_clean($request->input('name'));

        if ($request->input("status") == 1) {
            $role->status = SystemLookupModel::getIdByKey("ROLE_STATUS_ACTIVE");
        } else {
            $role->status = SystemLookupModel::getIdByKey("ROLE_STATUS_INACTIVE");
        }

        $role->save();

        // for saving actions
        $actions = $request->input("action");
        $current = $role->actions()->pluck('id')->toArray();
        if ($actions && is_array($actions)) {
            $attach = array_diff($actions, $current);
            $deattach = array_diff($current, $actions);
            if (count($deattach) > 0)
                $role->actions()->detach($deattach);
            $role->actions()->attach($attach);
        } else {
            $role->actions()->detach($current);
        }

        $message = "Role Updated Successfully";
        $status = "success";

        /*  if (isset($_POST["save_new"]))
              return redirect(parent::$data['cp_route_name'] . "/role/create")->with($status, $message);
          else
              return redirect(parent::$data['cp_route_name'] . "/role")->with($status, $message);*/
        return back()->with($status, $message);
    }

    public function changeStatus(Request $request, $id)
    {
        if (\Request::ajax()) {
            $role = RoleModel::find($id);
            if (!$role) {
                return response(["status" => false, "message" => "Role not found"], 200);
            }

            if (SystemLookupModel::getKeyById($role->status) == "ROLE_STATUS_INACTIVE") {
                $role->status = SystemLookupModel::getIdByKey("ROLE_STATUS_ACTIVE");
                $role->save();
                return response(["status" => true, "message" => "Role activated successfully"], 200);
            } else {
                return $this->deactivateRole($role, \Request::input("isDeactivate"), \Request::input("isMove"),
                    \Request::input("newRole"), $role->users->count() < 1 ? true : false);
            }
        } else {
            return redirect(parent::$data['cp_route_name'] . "/role");
        }
    }

    private function deactivateRole($role, $isDeactivate, $isMove, $newRole, $updateAnyWay = false)
    {
        if ($updateAnyWay) {
            $role->status = SystemLookupModel::getIdByKey("ROLE_STATUS_INACTIVE");
            $role->save();
            $message = "Role deactivated successfully";
            $type = "";
        } elseif ($isDeactivate == "true") {
            $users = SystemUserRoleModel::where("role_id", $role->id)->pluck("user_id")->toArray();
            SystemUserModel::whereIn("id", $users)->update(["status" => SystemLookupModel::getIdByKey("SYSTEM_USER_STATUS_INACTIVE")]);
            $role->status = SystemLookupModel::getIdByKey("ROLE_STATUS_INACTIVE");
            $role->save();
            $message = "Role deactivated successfully and all sub users deactivated";
            $type = "deactive";
        } elseif ($isMove == "true") {
            $newRoleObject = RoleModel::find($newRole);
            if ($newRoleObject) {
                foreach ($role->users()->get() as $user) {
                    $user->actions()->detach();
                    $user->actions()->attach($newRoleObject->actions()->pluck("id")->toArray());
                }
                SystemUserRoleModel::where("role_id", $role->id)->update(["role_id" => $newRoleObject->id]);
                $role->status = SystemLookupModel::getIdByKey("ROLE_STATUS_INACTIVE");
                $role->save();
                $message = "Role deactivated successfully and all users moved to " . $newRoleObject->name;
                $type = "move";
            }

        } else {
            return response(["status" => false, "message" => "Missing parameters"], 200);
        }

        return response(["status" => true, "type" => $type, "message" => $message], 200);
    }

    public function usersCount($id)
    {
        if (\Request::ajax()) {
            $role = RoleModel::find($id);
            if (!$role) {
                return response(['status' => false, "message" => "Role not found"], 200);
            }

            return response(["status" => true, "usersCount" => $role->users()->count()], 200);
        } else {
            return redirect(parent::$data['cp_route_name'] . "/role");
        }
    }

    public function delete(Request $request, $id)
    {
        if ($request->ajax()) {
            $_role = RoleModel::find($id);
            if ($id) {
                return $this->deleteRole($_role, \Request::input("isDeactivate"), \Request::input("isMove"), \Request::input("newRole"), \Request::input("deleteUsers"), $_role->users->count() < 1);
                //return response(["status" => true, "message" => "Deleted Successfully"], 200);
            } else {
                return response(["status" => false, "message" => "some errors"], 400);
            }
            // return response(["status" => true, "message" => "Deleted Successfully"], 200);
        }

        return redirect(parent::$data['cp_route_name'] . "/" . parent::$data['route']);

    }

    private function deleteRole($role, $isDeactivate, $isMove, $newRole, $deleteUsers, $updateAnyWay = false)
    {
        if ($updateAnyWay) {
            $role->deleteOne();
            $message = "Role Deleted successfully";
            $type = "";
        } elseif ($isDeactivate == "true") {
            $role->deleteOne();
            $users = SystemUserRoleModel::where("role_id", $role->id)->pluck("user-id")->toArray();
            SystemUserModel::whereIn("id", $users)->update(["status" => SystemLookupModel::getIdByKey("SYSTEM_USER_STATUS_DEACTIVE")]);

            $message = "Role Deleted successfully and all sub users deactivated";
            $type = "deactive";
        } elseif ($isMove == "true") {
            $role->deleteOne();
            $newRoleObject = RoleModel::find($newRole);
            if ($newRoleObject) {
                foreach ($role->users()->get() as $user) {
                    $user->actions()->detach();
                    $user->actions()->attach($newRoleObject->actions()->pluck("id")->toArray());
                }
                SystemUserRoleModel::where("role_id", $role->id)->update(["role_id" => $newRoleObject->id]);

                $message = "Role Deleted successfully and all related users move to " . $newRoleObject->name;
                $type = "move";
            }

        } elseif ($deleteUsers == "true") {
            $role->deleteOne();
            $users = SystemUserRoleModel::where("role_id", $role->Role_ID)->pluck("user_id")->toArray();
            SystemUserModel::whereIn("id", $users)->delete();
            $message = "Role Deleted successfully and all sub users Deleted";
            $type = "deleted";
        } else {
            return response(["status" => false, "message" => "Missing parameters"], 200);
        }

        return response(["status" => true, "type" => $type, "message" => $message], 200);
    }
}
