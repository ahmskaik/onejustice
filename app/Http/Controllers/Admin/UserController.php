<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserRequest;
use App\Models\ActionModel;
use App\Models\RoleModel;
use App\Models\SettingModel;
use App\Models\SystemLookupModel;
use App\Models\SystemUserModel;
use App\Models\SystemUserRoleModel;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Session;
use Validator;
use Yajra\Datatables\Datatables;

class UserController extends SuperAdminController
{

    public function __construct()
    {
        parent::__construct();
        parent::$data['active_menu'] = 'role_view';
        parent::$data['active_menuPlus'] = 'user_view';
        parent::$data['route'] = 'user';
        parent::$data["breadcrumbs"] = [
            trans('admin/dashboard.home') => parent::$data['cp_route_name'],
            trans('admin/user.users') => parent::$data['cp_route_name'] . "/" . parent::$data['route']

        ];
    }

    public function index()
    {
        parent::$data['userStatus'] = SystemLookupModel::getLookeupByKey("SYSTEM_USER_STATUS");
        parent::$data['roles'] = RoleModel::all();

        parent::$data["title"] = '';
        parent::$data["page_title"] = trans('admin/user.users');

        parent::$data["breadcrumbs"]["List"] = "";
        return view('cp.users.index', parent::$data);
    }

    public function get(Request $request)
    {
        $columns = $request->get('columns');

        $role_id = isset($columns[2]['search']['value']) ? xss_clean($columns[2]['search']['value']) : '';
        $filter = [];

        $filter["username"] = isset($columns[8]['search']['value']) ? xss_clean($columns[8]['search']['value']) : '';

        $creation_date = isset($columns[7]['search']['value']) ? xss_clean($columns[7]['search']['value']) : '';
        if ($creation_date) {
            $created_at = explode('|', $creation_date);
            $filter['from'] = isset($created_at[0]) ? trim($created_at[0]) : '';
            $filter['to'] = isset($created_at[1]) ? trim($created_at[1]) : '';
        }

        if ($role_id)
            $filter['role_id'] = $role_id;

        $key = isset($columns[1]['search']['value']) ? $columns[1]['search']['value'] : '';
        if ($key) {
            $filter['key'] = $key;
        }
        $users = SystemUserModel::getUsersList($filter);

        $table = Datatables::of($users)
            ->editColumn('full_name', function ($data) use ($request) {
                if ($request->input("export"))
                    return $data->full_name;
                return '<a href=" ' . parent::$data['cp_route_name'] . '/' . parent::$data['route'] . '/edit/' . $data->id . '">' . $data->full_name . '</a>';
            })
            ->editColumn('status', function ($data) use ($request) {
                if ($request->input("export"))
                    return $data->status;
                return '<div class="d-block kt-align-center"><span class="kt-badge kt-badge--inline kt-badge--pill ' . (trim($data->name_id) == "SYSTEM_USER_STATUS_ACTIVE" ? "kt-badge--success" : "kt-badge--danger") . '">' . $data->status . '</span></div>';
            })
            ->editColumn('email', function ($data) use ($request) {
                if ($request->input("export"))
                    return $data->email;
                return '<span class="tdemail popovers" data-container="body" data-trigger="hover" data-placement="top" data-content="' . $data->email . '">' . $data->email . '</span>';
            })
            ->editColumn('role_name', function ($data) use ($request) {
                if ($request->input("export"))
                    return $data->role_name;
                return '<span class="roleName">' . $data->role_name . '</span>';
            })
            ->editColumn('created_at', function ($data) {
                return ($data->created_at) ? date_format(date_create($data->created_at), 'Y-m-d') : "";
            })
            ->editColumn('id', function ($data) use ($request) {
                return '<input name="id[]" type="checkbox" value="' . $data->id . '" class="checkboxes" />';
            });


        if (!$request->input("export") && $request->ajax()) {
            $table->addColumn('action', function ($data) {
                $result = '<div class="actions tbl-sm-actions tblactions-five  d-block kt-align-center">';
                $result .= '<a class="btn btn-outline-success btn-icon btn-circle btn-sm ml-2"
                     href="' . parent::$data['cp_route_name'] . '/' . parent::$data['route'] . '/edit/' . $data->id . '"
                     data-skin="dark"  data-placement="top" title="edit" data-original-title="edit">
                                    <i class="la la-edit"></i>
                                </a>';

                $result .= '<a class="btn btn-outline-info btn-icon btn-circle btn-sm ml-2"
                     href="' . parent::$data['cp_route_name'] . '/' . parent::$data['route'] . '/edit/' . $data->id . '"
                     data-skin="dark" data-modal="modal-changepassword"
                     data-name="' . $data->full_name . '"
                     data-placement="top" title="Change password" data-original-title="Change password">
                                    <i class="la la-key"></i>
                                </a>';


                $result .= '<a class="btn btn-outline-danger btn-icon btn-circle btn-sm ml-2 btn-delete"
                     href="' . parent::$data['cp_route_name'] . '/' . parent::$data['route'] . '/delete/' . $data->id . '"
                     data-skin="dark" data-name="' . $data->full_name . '"
                     data-placement="top" title="Delete" data-original-title="Delete">
                                    <i class="la la-trash"></i>
                                </a>';


                $result .= "</div>";
                return $result;
            });
        }

        $table = $table->escapeColumns([])->make(true);

        if ($request->ajax())
            return $table;
        if ($request->input("export")) {
            $table = json_decode(json_encode($table->getData()), true);
            $aliases = ["full_name" => "Full Name", "name" => "Role Name", "user_name" => "Username", "status" => "Status", "email" => "Email Address", "mobile" => "Mobile No.", "created_at" => "Creation Date", "created_by" => "Created By"];
            $type = $request->input("export");
            if (!in_array($type, ["xlsx", "csv", "pdf"]))
                $type = "csv";

            $filter = [];
            $typesValue = 'N/A';
            if (isset($columns[2]['search']['value']) && $columns[2]['search']['value']) {
                $typesValue = RoleModel::getRoleName($columns[2]['search']['value']);
            }

            $status = "All";
            if (isset($columns[4]['search']['value']) && $columns[4]['search']['value']) {
                $status = SystemLookupModel::getLookeupValueByID($columns[4]['search']['value']);
            }

            $filter["Search"] = isset($columns[1]['search']['value']) && $columns[1]['search']['value'] ? $columns[1]['search']['value'] : 'N/A';
            $filter["Role"] = $typesValue;
            $filter["Created By"] = isset($columns[8]['search']['value']) && $columns[8]['search']['value'] ? $columns[8]['search']['value'] : 'N/A';
            $filter["Email"] = isset($columns[5]['search']['value']) && $columns[5]['search']['value'] ? $columns[5]['search']['value'] : 'N/A';
            $filter["Mobile"] = isset($columns[6]['search']['value']) && $columns[6]['search']['value'] ? $columns[6]['search']['value'] : 'N/A';
            $filter["Status"] = $status;
            $filter['from'] = 'N/A';
            $filter['to'] = 'N/A';

            if (isset($columns[7]['search']['value']) && $columns[7]['search']['value']) {
                $created_at = explode('|', $columns[7]['search']['value']);
                $filter['from'] = isset($created_at[0]) ? $created_at[0] : 'N/A';
                $filter['to'] = isset($created_at[1]) ? $created_at[1] : 'N/A';
            }

            return $this->exportFile("System Users Report", $this->formatAliases($table, $aliases), $type, $filter);

        }
        redirect(parent::$data['cp_route_name'] . '/users');
    }

    public function create()
    {
        parent::$data['title'] = '';
        parent::$data['page_title'] = trans('admin/user.create_new_user');
        parent::$data['src'] = "cp/images/avatar-img.jpg";
        parent::$data['roles'] = ['' => ''] + RoleModel::where("status", SystemLookupModel::getIdByKey("ROLE_STATUS_ACTIVE"))->pluck("name", "id")->toArray();
        parent::$data['creator'] = Auth::user("admin")->full_name;
        parent::$data['lastLogin'] = '-----------';
        parent::$data['lastIP'] = '-----------';
        parent::$data['roleActions'] = [];
        parent::$data['actions'] = ActionModel::with("actions")->where("is_active", 1)->where("parent_action_id", NULL)->orderBy("menu_order", "asc")->get();
        parent::$data['roleActionsDefault'] = [];

        if (Session::has("success"))
            parent::$data["success"] = Session::get("success");

        parent::$data["result"] = new SystemUserModel;
        parent::$data["status"] = true;

        parent::$data["isProfile"] = false;
        parent::$data["breadcrumbs"][trans('admin/user.create_new_user')] = "";

        return view('cp.users.form', parent::$data);
    }

    public function store(UserRequest $request)
    {
        $roleid = $request->input("roleid");
        $tmp = RoleModel::find($request->input("roleid"));
        if (!$tmp) {
            $role = new RoleController;
            $roleRequest = new Requests\RoleRequest();
            $roleRequest->merge($request->all());
            $roleRequest->merge(["Role_Name" => $request->input("roleid"), "Role_Status" => 1, "quick" => 1]);
            $newRole = $role->store($roleRequest);
            $roleid = $newRole->Role_ID;
        }

        $user = new SystemUserModel();
        $user->user_name = xss_clean($request->input("user_name"));
        $user->password = bcrypt(xss_clean($request->input("password")));
        $user->email = xss_clean($request->input("email"));
        $user->full_name = xss_clean($request->input("full_name"));

        if ($request->input("dob")) {
            $user->dob = date_format(date_create($user->dob), 'Y-m-d');
        }


        $user->mobile = $request->input("mobile");
        $user->created_by = Auth::user("admin")->id;
        if ($request->input("status") == 1)
            $user->status = SystemLookupModel::getIdByKey("SYSTEM_USER_STATUS_ACTIVE");
        else
            $user->status = SystemLookupModel::getIdByKey("SYSTEM_USER_STATUS_INACTIVE");

        if ($request->hasFile("avatar")) {
            $user->avatar = $this->upload($request->file("avatar"), "users");
        }
        $user->save();

        $user->roles()->attach($roleid, ["is_customized" => ($request->input("is_customized") == "Yes") ? 1 : 0]);

        if ($request->input("action")) {
            $user->actions()->attach($request->input("action"));
        }

        if ($request->ajax()) {
            return response(["status" => true, "message" => "User created successfully"], 200);
        }

        if (isset($_POST["save_new"]))
            return redirect(parent::$data['cp_route_name'] . "/user/create")->with("success", "User created successfully");


        return redirect(parent::$data['cp_route_name'] . "/user")->with("success", "User created successfully");
    }

    public function edit($id, $isProfile = false)
    {
        /* if ($id == 1 && !$isProfile) {
             return redirect(parent::$data['cp_route_name'] . "/user");
         }*/

        $user = SystemUserModel::find($id);
        if (!$user)
            return redirect(parent::$data['cp_route_name'] . "/user");

        parent::$data['title'] = '';
        parent::$data['page_title'] = trans('admin/user.update_user');
        parent::$data['src'] = $user->avatar;//"cp/images/avatar-img.jpg";

        /* if ($user->avatar)
             parent::$data['src'] = "uploads/users/" . $user->avatar;*/

        parent::$data['roles'] = RoleModel::where("status", SystemLookupModel::getIdByKey("ROLE_STATUS_ACTIVE"))->pluck("name", "id");
        parent::$data['creator'] = isset($user->user->full_name) ? $user->user->full_name : "--------";
        parent::$data['lastLogin'] = '-----------';

        if (strtotime($user->last_loginDate)) {
            parent::$data['lastLogin'] = $user->last_loginDate;
        }

        parent::$data['roleActions'] = $user->actions->pluck("id")->toArray();
        parent::$data['actions'] = ActionModel::with("actions")->where("is_active", 1)->where("parent_action_id", NULL)->orderBy("menu_order", "asc")->get();


        if (strtotime($user->dob) > 0)
            $user->dob = date_format(date_create($user->dob), 'Y-m-d');
        else
            $user->dob = "";

        parent::$data['lastIP'] = '-----------';
        if ($user->last_IPAddress)
            parent::$data['lastIP'] = $user->last_IPAddress;


        $user->roleid = isset($user->roles[0]) ? $user->roles[0]->id : "";
        $user->is_customized = "No";

        if (isset($user->roles[0])) {
            $tmp = SystemUserRoleModel::where("user_id", $user->id)->where("role_id", $user->roleid)->first();
            if ($tmp && $tmp->is_customized == 1)
                $user->is_customized = "Yes";
            else
                $user->is_customized = "No";
        }
        parent::$data["result"] = $user;
        parent::$data["user"] = $user;

        if (Session::has("success"))
            parent::$data["success"] = Session::get("success");

        if (Session::has("error"))
            parent::$data["error"] = Session::get("error");

        if (Session::has("tab2"))
            parent::$data["tab2"] = Session::get("tab2");

        parent::$data["isProfile"] = $isProfile;
        parent::$data["status"] = $user->status == SystemLookupModel::getIdByKey("SYSTEM_USER_STATUS_ACTIVE");
        parent::$data["breadcrumbs"][trans('admin/user.update_user')] = "";


        if ($isProfile) {
            unset(parent::$data["breadcrumbs"]["Edit"]);
            parent::$data["breadcrumbs"]["Profile"] = "";
            return view('cp.users.profileEdit', parent::$data);
        }

        return view('cp.users.form', parent::$data);
    }

    public function update(UserRequest $request, $id, $isProfile = false)
    {
        /*  if ($id == 1 && !$isProfile) {
              return redirect(parent::$data['cp_route_name'] . "/user");
          }*/
        $user = SystemUserModel::find($id);
        if (!$user)
            return redirect(parent::$data['cp_route_name'] . "/" . parent::$data['route']);

        if (!$isProfile) {
            $roleid = $request->input("roleid");
            $tmp = RoleModel::find($request->input("roleid"));
            if (!$tmp) {
                $role = new RoleController;
                $roleRequest = new Requests\RoleRequest();
                $roleRequest->merge($request->all());
                $roleRequest->merge(["name" => $request->input("roleid"), "status" => 1, "quick" => 1]);
                $newRole = $role->store($roleRequest);
                $roleid = $newRole->id;
            }
        }


        $user->user_name = xss_clean($request->input("user_name"));
        if ($request->input("password")) {
            $user->password = bcrypt(xss_clean($request->input("password")));
        }

        $user->email = xss_clean($request->input("email"));

        $user->full_name = xss_clean($request->input("full_name"));

        if ($request->input("dob")) {
            $user->dob = date_format(date_create($request->input("dob")), 'Y-m-d');
        }

        $user->mobile = xss_clean($request->input("mobile"));

        if (!$isProfile) {
            if ($request->input("status") == 1)
                $user->status = SystemLookupModel::getIdByKey("SYSTEM_USER_STATUS_ACTIVE");
            else
                $user->status = SystemLookupModel::getIdByKey("SYSTEM_USER_STATUS_INACTIVE");
        }

        if ($request->hasFile("avatar")) {
            $user->avatar = $this->upload($request->file("avatar"), "users");
        }

        $user->save();


        if (!$isProfile) {
            $user->roles()->detach();
            $user->roles()->attach($roleid, ["is_customized" => ($request->input("is_customized") == "Yes") ? 1 : 0]);
            if ($request->input("action")) {

                $actions = $request->input("action");
                $current = $user->actions()->pluck('id')->toArray();

                if ($actions && is_array($actions)) {

                    $attach = array_diff($actions, $current);
                    $deattach = array_diff($current, $actions);
                    if (count($deattach) > 0)
                        $user->actions()->detach($deattach);
                    $user->actions()->attach($attach);
                } else {
                    $user->actions()->detach($current);
                }
            }

        }

        if ($request->ajax()) {
            return response(["status" => true, "message" => "User updated successfully"], 200);
        }

        if ($isProfile)
            return redirect(parent::$data['cp_route_name'] . "/profile/edit")->with("success", "Profile updated successfully");

        if (isset($_POST["save_new"]) && !$isProfile)
            return redirect(parent::$data['cp_route_name'] . "/" . parent::$data['route'] . "/create")->with("success", "User updated successfully");

        return redirect(parent::$data['cp_route_name'] . "/" . parent::$data['route'])->with("success", "User updated successfully");
    }

    public function changeStatus(Request $request)
    {
        if ($request->ajax()) {
            $ids = $request->input("id");

            if (!$ids || is_array($ids)) {
                redirect('/' . parent::$data['cp_route_name'] . '/user');
            }

            if ($key = array_search(1, $ids) !== false) {
                unset($ids[$key]);
            }
            $status = $request->input("status");
            if ($status == "SYSTEM_USER_STATUS_ACTIVE") {
                SystemUserModel::whereIn("id", $ids)->update(["status" => SystemLookupModel::getIdByKey("SYSTEM_USER_STATUS_ACTIVE")]);
                $message = "Activated successfully";
            } else {
                SystemUserModel::whereIn("id", $ids)->update(["status" => SystemLookupModel::getIdByKey("SYSTEM_USER_STATUS_INACTIVE")]);
                $message = "Deactivated successfully";
            }

            return response(['status' => true, 'message' => $message], 200);
        } else {
            redirect('./' . parent::$data['cp_route_name'] . '/user');
        }
    }

    public function changeStatusAll(Request $request)
    {
        $ids = $request->input("id");
        if ($key = array_search(1, $ids) !== false) {
            unset($ids[$key]);
        }
        $status = $request->input("status");
        $existStatus = ["SYSTEM_USER_STATUS_ACTIVE", "SYSTEM_USER_STATUS_INACTIVE"];
        if (\Request::ajax() && $ids && is_array($ids) && in_array($status, $existStatus)) {
            SystemUserModel::whereIn("id", $ids)->update(["status", SystemLookupModel::getIdByKey($status)]);

            return response(['status' => true, 'message' => "Status changed successfully"], 200);
        } else {
            redirect(parent::$data['cp_route_name'] . '/user');
        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        if ($request->input("id") == 1) {
            return redirect(parent::$data['cp_route_name'] . "/user");
        }

        $user = SystemUserModel::find($request->input("id"));
        $user->password = bcrypt(xss_clean($request->input("password")));
        $user->save();

        if ($request->input("sendEmail") == 1) {
            $subject = "Your New Password";
            $bodyPath = "cp.users.changePassword";

            $data["name"] = $user->full_name;
            $data["newPassword"] = xss_clean($request->input("password"));
            $set = SettingModel::pluck("sysset_data", "name")->toArray();
            $data["facebookLink"] = $set["facebook"]->EN;
            $data["twitterLink"] = $set["twitter"]->EN;
            $data["instagramLink"] = $set["instagram"]->EN;
            $data["youtubeLink"] = $set["youtube"]->EN;
            $data["linkedInLink"] = $set["linkedin"]->EN;

            $toMail = $user->email;
            $toName = $user->full_name;
            $cc = "";

            $this->sendEmail($subject, $bodyPath, $data, $toMail, $toName, $cc);
        }

        if ($request->ajax())
            return response(["status" => true, "message" => "Password updated successfully"], 200);
    }

    public function changeRole(Request $request)
    {
        if ($request->ajax()) {
            $ids = $request->input("id");
            if ($key = array_search(1, $ids) !== false) {
                unset($ids[$key]);
            }
            $roleid = $request->input("roleid");
            $role = RoleModel::find($roleid);

            if (!$ids || !$role) {
                redirect('/' . parent::$data['cp_route_name'] . '/user');
            }


            SystemUserRoleModel::whereIn("user_id", $ids)->update(["role_id" => $role->id]);
            foreach ($ids as $id) {
                $user = SystemUserModel::find($id);
                if ($user) {
                    $user->actions()->detach();
                    $user->actions()->attach($role->actions()->pluck("id")->toArray());
                }
            }
            $message = "Role changed successfully";

            return response(['status' => true, 'message' => $message], 200);
        } else {
            redirect('./' . parent::$data['cp_route_name'] . '/user');
        }
    }

    public function actionRole($id)
    {
        if (\Request::ajax()) {
            $role = RoleModel::find($id);
            if (!$role)
                return response(["status" => false, "message" => "Role not found"], 200);

            return response(["status" => true, "result" => $role->actions()->pluck("id")->toArray()], 200);
        } else {
            return redirect(parent::$data['cp_route_name'] . "/user");
        }
    }

    public function profile()
    {
        return $this->edit(Auth::user("admin")->id, true);
    }

    public function profileOverview()
    {
        parent::$data["title"] = "Profile Overview";
        parent::$data["breadcrumbs"]["Profile"] = "";
        $user = Auth::user("admin");

        parent::$data['src'] = "cp/images/avatar-img.jpg";
        if ($user->avatar)
            parent::$data['src'] = "uploads/users/" . $user->avatar;

        parent::$data['creator'] = isset($user->user->full_name) ? $user->user->full_name : "--------";
        parent::$data['lastLogin'] = '-----------';

        if (strtotime($user->last_loginDate)) {
            parent::$data['lastLogin'] = $user->last_loginDate;
        }

        if (strtotime($user->dob) > 0)
            $user->dob = date_format(date_create($user->dob), 'Y-m-d');
        else
            $user->dob = "";

        parent::$data['lastIP'] = '-----------';
        if ($user->last_IPAddress)
            parent::$data['lastIP'] = $user->last_IPAddress;

        parent::$data["user"] = $user;
        parent::$data["activeProfileTab"] = true;
        return view("cp.users.profileOver", parent::$data);
    }

    public function updateProfile(UserRequest $request)
    {
        return $this->update($request, Auth::user("admin")->id, true);
    }


    public function validateInput(Request $request, $user_id = 0)
    {

        if ($request->ajax()) {

            $rules = [
                "user_name" => "unique:system_users,user_name," . $user_id . ',id,deleted_at,NULL',
                "email" => "unique:system_users,email," . $user_id . ',id,deleted_at,NULL',
            ];

            $messages = [
                'email.unique' => 'Email is already exist!',
                'user_name.unique' => 'Username is already exist!',
            ];

            $val = Validator::make($request->all(), $rules, $messages);
            return $val->messages();

            if ($val->fails()) {
                return response(["status" => false, "message" => $val->messages()], 200);
            }

            return response(["status" => true], 200);
        }

        return redirect(parent::$data['cp_route_name'] . "/" . parent::$data['route']);
    }

    public function updatePasswordProfile(Request $request)
    {
        $oldPassword = xss_clean($request->input("oldPassword"));
        $newPassword = xss_clean($request->input("password"));
        $confirmPassword = xss_clean($request->input("confirm_password"));
        $user = Auth::user("admin");

        if (Hash::check($oldPassword, $user->password) && $newPassword && $newPassword == $confirmPassword) {
            $user->password = bcrypt($newPassword);
            $user->save();

            return redirect(parent::$data['cp_route_name'] . "/profile/edit")->with("success", "Password updated successfully");
        }

        return redirect(parent::$data['cp_route_name'] . "/profile/edit")->with("error", "Check your information")
            ->with("tab2", "active");
    }

    public function delete(Request $request, $id)
    {
        if ($request->ajax()) {
            $_user = SystemUserModel::find($id);
            if ($_user) {
                $_user->delete();
            }
            return response(["status" => true, "message" => "Deleted Successfully"], 200);
        }

        return redirect(parent::$data['cp_route_name'] . "/" . parent::$data['route']);
    }
}
