<?php namespace App\Http\Controllers\Admin;

use App\Models\CategoryModel;
use App\Models\PostModel;
use App\Models\SystemLookupModel;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class PostsController extends SuperAdminController
{
    public function __construct()
    {
        parent::__construct();
        parent::$data['active_menu'] = 'posts_view';
        parent::$data['active_menuPlus'] = 'posts_view';
        parent::$data['route'] = 'posts';

        parent::$data["breadcrumbs"] =
            [
                trans('admin/dashboard.home') => parent::$data['cp_route_name'],
                'posts' => parent::$data['cp_route_name'] . "/" . parent::$data['route']
            ];
    }

    public function index()
    {
        parent::$data["title"] = 'Posts';
        parent::$data["page_title"] = 'Posts';
        parent::$data["categories"] = CategoryModel::getList([], parent::$data['locale'])->get();
        parent::$data["statuses"] = SystemLookupModel::getLookeupByKey("POST_STATUS", parent::$data['locale']);
        parent::$data["types"] = SystemLookupModel::getLookeupByKey("POST_TYPE", parent::$data['locale']);
     //   parent::$data["languages"] = parent::$data['languages'];
        return view('cp.posts.index', parent::$data);
    }

    public function get(Request $request)
    {
        $filter = [];
        $columns = $request->get('columns');
        $filter['language_id'] = $request->language_id ?? '';
        $filter["category_id"] = isset($columns[2]['search']['value']) ? xss_clean($columns[2]['search']['value']) : '';

        $data = PostModel::getList($filter);

        $table = DataTables::of($data)
            ->editColumn('title', function ($data) use ($request) {
                if ($request->input("export"))
                    return $data->title;

                return '<a href="' . parent::$data['cp_route_name'] . '/' . parent::$data['route'] . '/edit/' . $data->id . '"><img title="' . $data->language . '" class="mr-2" src="cp/media/flags/png16px/' . $data->flag . '.png">' . \Str::limit($data->title, 70) . '</a>';
            })
            ->addColumn('status', function ($data) use ($request) {

                if ($request->input("export"))
                    return $data->status;
                return '<div class="d-block kt-align-center" title="' . ($data->status) . '"><span class="kt-badge kt-badge--inline kt-badge--pill ' . ("kt-badge--" . $data->statusClass) . '">' . $data->status . '</span></div>';
            })
            ->editColumn('views', function ($data) use ($request) {
                if ($request->input("export"))
                    return $data->views ?? 0;

                return '<div class="d-block kt-align-center"><i class="fa fa-eye"></i> ' . ($data->views ?? 0) . '</div>';
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
                   href="javascript:;" data-name="' . $data->title . '"    data-href="' . parent::$data['cp_route_name'] . '/' . parent::$data['route'] . '/delete/' . $data->id . '"
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

            return $this->exportFile("distributors Report", $this->formatAliases($table, $aliases), $type, $filter);
        }

        redirect(parent::$data['cp_route_name'] . '/' . parent::$data['route']);
    }

    public function create()
    {
        parent::$data['title'] = '';
        parent::$data['page_title'] = 'Add New Post';
        parent::$data["breadcrumbs"]['Add New Post'] = "";

        parent::$data['form'] = "add";
        parent::$data['post'] = new PostModel();
        parent::$data["categories"] = CategoryModel::getList([], parent::$data['locale'])->get();
        parent::$data["statuses"] = SystemLookupModel::getLookeupByKey("POST_STATUS", parent::$data['locale']);
        parent::$data["types"] = SystemLookupModel::getLookeupByKey("POST_TYPE", parent::$data['locale']);
        //parent::$data["languages"] = parent::$data['languages'];

        parent::$data['creator'] = \Auth::user("admin")->full_name;
        parent::$data['created_at'] = date("Y-m-d");

        return view('cp.posts.form', parent::$data);
    }

    public function store(Request $request)
    {
        $attributes = request()->validate([
            'title' => ['required', 'string', 'max:255'],
            'summary' => ['required'],
            'body' => ['required'],
            'status_id' => ['required'],
            'category_id' => ['required'],
            'language_id' => ['required'],
            'type_id' => ['required'],
            'date' => ['required'],
            //'is_featured' => ['required'],
            'cover_image' => ['required'],
            // 'views' => [],
            'tags' => [],
        ]);

        if (request('cover_image'))
            $attributes['cover_image'] = $this->upload(request('cover_image'), "posts");

        // if (request('tags'))
        //    $attributes['tags'] = is_array(json_decode(request('tags'))) ? \Arr::pluck(json_decode(request('tags')), 'value') : \Arr::wrap(request('tags'));


        $attributes['created_by'] = \Auth::user("admin")->id;
        $attributes['is_featured'] = isset($request->is_featured);

        $post = PostModel::create($attributes);


        return redirect(parent::$data['cp_route_name'] . '/' . parent::$data['route'] . '/edit/' . $post->id)
            ->with("success", "Created Successfully");
    }

    public function edit($id)
    {
        $post = PostModel::find($id);
        if (!$post)
            return redirect(parent::$data['cp_route_name'] . "/" . parent::$data['route']);

        parent::$data['title'] = '';
        parent::$data['page_title'] = 'Edit Post';
        parent::$data["breadcrumbs"]['Edit Post'] = "";

        parent::$data['created_at'] = date_format(date_create($post->created_at), 'Y-m-d');
        parent::$data['creator'] = $post->user->full_name;
        parent::$data["categories"] = CategoryModel::getList([], parent::$data['locale'])->get();
        parent::$data["statuses"] = SystemLookupModel::getLookeupByKey("POST_STATUS", parent::$data['locale']);
        parent::$data["types"] = SystemLookupModel::getLookeupByKey("POST_TYPE", parent::$data['locale']);
        //  parent::$data["languages"] = parent::$data['languages'];

        parent::$data['form'] = "edit";
        parent::$data['post'] = $post;

        return view('cp.posts.form', parent::$data);
    }

    public function update(Request $request, $id)
    {
        $post = PostModel::find($id);

        if (!$post)
            return redirect(parent::$data['cp_route_name'] . "/" . parent::$data['route']);

        $attributes = request()->validate([
            'title' => ['required', 'string', 'max:255'],
            'summary' => [],
            'body' => [],
            'status_id' => [],
            'category_id' => [],
            'language_id' => [],
            'type_id' => [],
            'is_featured' => [],
            'date' => [],
            'cover_image' => [],
            'views' => [],
            'tags' => [],
        ]);

        if (request('cover_image'))
            $attributes['cover_image'] = $this->upload(request('cover_image'), "posts");


        if (request('tags'))
            $attributes['tags'] = is_array(json_decode(request('tags'))) ?
                \Arr::pluck(json_decode(request('tags')), 'value') : \Arr::wrap(request('tags'));

        $attributes['is_featured'] = isset($request->is_featured);


        $post->update($attributes);

        return redirect(parent::$data['cp_route_name'] . '/' . parent::$data['route'] . '/edit/' . $post->id)
            ->with("success", "Updated Successfully");
    }
    public function delete(Request $request, $id)
    {
        $post = PostModel::find($id);

        if (!$post)
            return redirect(parent::$data['cp_route_name'] . "/" . parent::$data['route']);

        $post->delete();


        if ($request->ajax())
            return response(["status" => true, "message" => "Deleted Successfully"], 200);

        return redirect(parent::$data['cp_route_name'] . "/" . parent::$data['route']);
    }
}
