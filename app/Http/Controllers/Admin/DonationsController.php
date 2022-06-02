<?php namespace App\Http\Controllers\Admin;

use App\Models\DonationModel;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class DonationsController extends SuperAdminController
{
    public function __construct()
    {
        parent::__construct();
        parent::$data['active_menu'] = 'donation_view';
        parent::$data['active_menuPlus'] = 'donation_view';
        parent::$data['route'] = 'donations';

        parent::$data["breadcrumbs"] =
            [
                trans('admin/dashboard.home') => parent::$data['cp_route_name'],
                trans('admin/donation.donations') => parent::$data['cp_route_name'] . "/" . parent::$data['route']
            ];
    }

    public function index()
    {
        parent::$data["title"] = '';
        parent::$data["page_title"] = trans('admin/donation.donations');
        return view('cp.donations.index', parent::$data);
    }

    public function get(Request $request)
    {
        $filter = [];
        $columns = $request->get('columns');
        $data = DonationModel::getList($filter);
        $table = DataTables::of($data)->editColumn('created_at', function ($data) {
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
                "gateway" => "gateway",
                "amount" => "amount",
                "currency" => "currency",
                "ip" => "IP",
                "created_at" => "Date",
            ];

            $type = $request->input("export");

            if (!in_array($type, ["xlsx", "csv", "pdf"]))
                $type = "csv";

            $filter = [];


            return $this->exportFile("distributors Report", $this->formatAliases($table, $aliases), $type, $filter);


        }

        redirect(parent::$data['cp_route_name'] . '/' . parent::$data['route']);
    }


}
