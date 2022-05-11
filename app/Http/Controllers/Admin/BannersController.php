<?php namespace App\Http\Controllers\Admin;

use App\Models\BannerModel;
use App\Models\SystemLookupModel;
use Auth;
use Illuminate\Http\Request;
use Str;
use Yajra\Datatables\Datatables;

class BannersController extends SuperAdminController
{
    public function __construct()
    {
        parent::__construct();
        parent::$data['active_menu'] = 'banners_view';
        parent::$data['active_menuPlus'] = 'banners_view';
        parent::$data['route'] = 'banners';

        parent::$data["breadcrumbs"] =
            [
                trans('admin/dashboard.home') => parent::$data['cp_route_name'],
                'banners' => parent::$data['cp_route_name'] . "/" . parent::$data['route']
            ];
    }

    public function index()
    {
        parent::$data["title"] = 'Banners';
        parent::$data["page_title"] = 'Banners';
        parent::$data["positions"] = SystemLookupModel::getLookeupByKey("BANNER_POSITION", parent::$data['locale']);
        return view('cp.banners.index', parent::$data);
    }

    public function get(Request $request)
    {
        $filter = [];
        $columns = $request->get('columns');
        $filter['language_id'] = $request->language_id ?? '';

        $data = BannerModel::getList($filter);

        $table = DataTables::of($data)
            ->editColumn('title_en', function ($data) use ($request) {
                if ($request->input("export"))
                    return $data->title_en ? $data->title_en : ($data->title_ar ? $data->title_ar : trans('admin/dashboard.untitled'));

                if (trim($data->title_en) && trim($data->title_en) != 'null') {
                    $title = Str::limit($data->title_en, 40);
                } elseif (trim($data->title_ar) && trim($data->title_ar) != 'null') {
                    $title = $data->title_ar;
                } else {
                    $title = trans('admin/dashboard.untitled');
                }
                //$title = ($data->title_en ? Str::limit($data->title_en, 40) : ($data->title_ar ? Str::limit($data->title_ar, 40) : trans('admin/dashboard.untitled')));

                return '<a href="' . parent::$data['cp_route_name'] . '/' . parent::$data['route'] . '/edit/' . $data->id . '">' . $title . '</a>';
            })
            ->addColumn('status', function ($data) use ($request) {

                if ($request->input("export"))
                    return ($data->is_active ? 'Active' : 'inActive');
                return '<div class="d-block kt-align-center" title="' . ($data->is_active) . '"><span class="kt-badge kt-badge--inline kt-badge--pill ' . ("kt-badge--" . ($data->is_active ? 'success' : 'danger')) . '">' . ($data->is_active ? 'Active' : 'inActive') . '</span></div>';
            })
            ->editColumn('dtime', function ($data) {
                return date_format(date_create($data->created_at), 'Y-m-d');
            });

        if (!$request->input("export") && $request->ajax()) {
            $table->addColumn('action', function ($data) use ($request) {
                $result = '<div class="actions tbl-sm-actions kt-align-center">';

                $result .= '<a class="btn btn-outline-success btn-icon btn-circle btn-sm ml-2"
                     href="' . parent::$data['cp_route_name'] . '/' . parent::$data['route'] . '/edit/' . $data->id . '"
                     data-skin="dark" data-toggle="kt-tooltip" data-placement="top" title="show" data-original-title="Edit">
                                    <i class="la la-edit"></i>
                                </a>';
                $result .= '<a class="btn btn-outline-danger btn-icon btn-circle btn-sm ml-2 btn-delete"
                   href="javascript:;" data-name="' . $data->title_en . '"     data-href="' . parent::$data['cp_route_name'] . '/' . parent::$data['route'] . '/delete/' . $data->id . '"
                     data-skin="dark" data-toggle="kt-tooltip" data-placement="top" title="delete" data-original-title="delete">
                                    <i class="la la-trash"></i>
                                </a>';

                $result .= "</div>";
                return $result;
            });
        }

        $table = $table->escapeColumns([])->make(true);

        if (\Request::ajax())
            return $table;

        if ($request->input("export")) {
            $table = json_decode(json_encode($table->getData()), true);

            $aliases = [
                "name" => "Name",
                "creator" => "Creator",
                "dtime" => "Date",
            ];

            $type = $request->input("export");

            if (!in_array($type, ["xlsx", "csv", "pdf"]))
                $type = "csv";

            $filter = [];

            return $this->exportFile("Banners Report", $this->formatAliases($table, $aliases), $type, $filter);
        }

        redirect(parent::$data['cp_route_name'] . '/' . parent::$data['route']);
    }

    public function create()
    {
        parent::$data['title'] = '';
        parent::$data['page_title'] = 'Add New Banner';
        parent::$data["breadcrumbs"]['Add New Banner'] = "";

        parent::$data['form'] = "add";
        parent::$data['banner'] = new BannerModel();
        parent::$data["positions"] = SystemLookupModel::getLookeupByKey("BANNER_POSITION", parent::$data['locale']);
        parent::$data['show_current_date'] = false;
        parent::$data["show_language_bar"] = true;

        parent::$data['creator'] = Auth::user("admin")->full_name;
        parent::$data['created_at'] = date("Y-m-d");

        return view('cp.banners.form', parent::$data);
    }

    public function store(Request $request)
    {
        $attributes = request()->validate([
            'title' => ['array', 'required'],
            'position_id' => ['required'],
            'is_Active' => [],
            'link' => [],
            'is_external_link' => [],
            'image' => [],
        ]);


        if (request('image'))
            $attributes['image'] = $this->upload(request('image'), "banners");


        $attributes['created_by'] = Auth::user("admin")->id;
        $attributes['is_external_link'] = isset($request->is_external_link) && $request->is_external_link;
        $attributes['is_active'] = isset($request->is_active);

        $banner = BannerModel::create($attributes);

        return redirect(parent::$data['cp_route_name'] . '/' . parent::$data['route'] . '/edit/' . $banner->id)
            ->with("success", "Created Successfully");
    }

    public function edit($id)
    {
        $banner = BannerModel::find($id);
        if (!$banner)
            return redirect(parent::$data['cp_route_name'] . "/" . parent::$data['route']);

        parent::$data['title'] = '';
        parent::$data['page_title'] = 'Edit Banner';
        parent::$data["breadcrumbs"]['Edit Banner'] = "";
        parent::$data['show_current_date'] = false;
        parent::$data["show_language_bar"] = true;

        parent::$data['created_at'] = date_format(date_create($banner->created_at), 'Y-m-d');
        parent::$data['creator'] = $banner->user->full_name;
        parent::$data["positions"] = SystemLookupModel::getLookeupByKey("BANNER_POSITION", parent::$data['locale']);

        parent::$data['form'] = "edit";
        parent::$data['banner'] = $banner;

        return view('cp.banners.form', parent::$data);
    }

    public function update(Request $request, $id)
    {
        $banner = BannerModel::find($id);

        if (!$banner)
            return redirect(parent::$data['cp_route_name'] . "/" . parent::$data['route']);

        $attributes = request()->validate([
            'title' => ['array', 'required'],
            'position_id' => ['required'],
            'is_Active' => [],
            'link' => [],
            'is_external_link' => [],
            'image' => [],
        ]);


        if (request('image'))
            $attributes['image'] = $this->upload(request('image'), "banners");

        $attributes['is_active'] = isset($request->is_active);
        $attributes['is_external_link'] = isset($request->is_external_link) && $request->is_external_link;

        $banner->update($attributes);

        return redirect(parent::$data['cp_route_name'] . '/' . parent::$data['route'] . '/edit/' . $banner->id)
            ->with("success", "Updated Successfully");
    }

    public function delete(Request $request, $id)
    {
        $banner = BannerModel::find($id);

        if (!$banner)
            return redirect(parent::$data['cp_route_name'] . "/" . parent::$data['route']);

        $banner->delete();


        if ($request->ajax())
            return response(["status" => true, "message" => "Deleted Successfully"], 200);

        return redirect(parent::$data['cp_route_name'] . "/" . parent::$data['route']);
    }
}
