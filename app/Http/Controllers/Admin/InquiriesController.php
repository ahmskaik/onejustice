<?php namespace App\Http\Controllers\Admin;

use App\Models\InquiryModel;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class InquiriesController extends SuperAdminController
{
    public function __construct()
    {
        parent::__construct();
        parent::$data['active_menu'] = 'inquiry_view';
        parent::$data['active_menuPlus'] = 'inquiry_view';
        parent::$data['route'] = 'inquiries';

        parent::$data["breadcrumbs"] =
            [
                trans('admin/dashboard.home') => parent::$data['cp_route_name'],
                trans('admin/inquiry.inquiries') => parent::$data['cp_route_name'] . "/" . parent::$data['route']
            ];
    }

    public function index()
    {
        parent::$data["title"] = '';
        parent::$data["page_title"] = trans('admin/inquiry.inquiries');
        return view('cp.inquiries.index', parent::$data);
    }

    public function get(Request $request)
    {
        $filter = [];
        $columns = $request->get('columns');
        $data = InquiryModel::getList($filter);
        $table = DataTables::of($data)
            ->editColumn('title', function ($data) use ($request) {
                if ($request->input("export"))
                    return $data->title ?? \Str::limit($data->message, 80);

                return '<a href="' . parent::$data['cp_route_name'] . '/' . parent::$data['route'] . '/show/' . $data->id . '">' . ($data->title ?? \Str::limit($data->message, 80)) . '</a>';
            })
            ->addColumn('status', function ($data) use ($request) {

                if ($request->input("export"))
                    return $data->seen_at ? date('Y-m-d', strtotime($data->seen_at)) : 'Not yet';

                if ($data->seen_at) {
                    $label = 'Seen';
                    $class = "kt-badge--success";
                } else {
                    $label = 'Not yet';
                    $class = "kt-badge--danger";
                }

                return '<div class="d-block kt-align-center" title="' . date('Y-m-d', strtotime($data->seen_at)) . '"><span class="kt-badge kt-badge--inline kt-badge--pill ' . $class . '">' . $label . '</span></div>';

            })
            ->editColumn('created_at', function ($data) {
                return date_format(date_create($data->created_at), 'Y-m-d');
            });

        if (!$request->input("export") && $request->ajax()) {
            $table->addColumn('action', function ($data) use ($request) {
                $result = '<div class="actions tbl-sm-actions kt-align-center">';

                $result .= '<a class="btn btn-outline-success btn-icon btn-circle btn-sm ml-2"
                     href="' . parent::$data['cp_route_name'] . '/' . parent::$data['route'] . '/show/' . $data->id . '"
                     data-skin="dark" data-toggle="kt-tooltip" data-placement="top" title="show" data-original-title="show">
                                    <i class="la la-eye"></i>
                                </a>';
                $result .= '<a class="btn btn-outline-danger btn-icon btn-circle btn-sm ml-2 js-btn-delete"
                   href="javascript:;"   data-href="' . parent::$data['cp_route_name'] . '/' . parent::$data['route'] . '/delete/' . $data->id . '"
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
                "dtime" => "Date",
            ];

            $type = $request->input("export");

            if (!in_array($type, ["xlsx", "csv", "pdf"]))
                $type = "csv";

            $filter = [];


            return $this->exportFile("distributors Report", $this->formatAliases($table, $aliases), $type, $filter);


        }

        redirect(parent::$data['cp_route_name'] . '/' . parent::$data['route']);
    }

    public function show(Request $request, $id)
    {
        $inquiry = InquiryModel::find($id);
        if (!$inquiry)
            return redirect(parent::$data['cp_route_name'] . "/" . parent::$data['route']);

        parent::$data["title"] = '';
        parent::$data["page_title"] = trans('admin/inquiry.show_details');
        parent::$data["inquiry"] = $inquiry;

        if (!$inquiry->seen_at)
            $inquiry->update(['seen_at' => now()]);

        return view('cp.inquiries.show', parent::$data);
    }

}
