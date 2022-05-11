<?php

namespace App\Http\Controllers\Admin;

use App\Models\CategoryModel;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class CategoriesController extends SuperAdminController
{

    public function __construct()
    {
        parent::__construct();
        parent::$data['active_menu'] = 'category_view';
        parent::$data['active_menuPlus'] = 'category_view';
        parent::$data['route'] = 'categories';
        parent::$data["breadcrumbs"] =
            [
                trans('admin/dashboard.home') => parent::$data['cp_route_name'],
                trans('admin/category.categories') => parent::$data['cp_route_name'] . "/" . parent::$data['route']
            ];
    }

    public function index()
    {
        parent::$data["title"] = '';
        parent::$data["page_title"] = trans('admin/dashboard.categories');

        return view('cp.categories.index', parent::$data);
    }

    public function get(Request $request)
    {
        $isExport = $request->input("export");
        $filter = [];
        $columns = $request->get('columns');
        $creation_date = isset($columns[3]['search']['value']) ? xss_clean($columns[3]['search']['value']) : '';
        $filter["name"] = isset($columns[1]['search']['value']) ? xss_clean($columns[1]['search']['value']) : '';

        if ($creation_date) {
            $created_at = explode('|', $creation_date);
            $filter['from'] = isset($created_at[0]) ? trim($created_at[0]) : '';
            $filter['to'] = isset($created_at[1]) ? trim($created_at[1]) : '';
        }

        $data = CategoryModel::getList($filter, strtolower(\App::getLocale()));

        $is_rtl = strtolower(\App::getLocale()) == 'ar';

        $arrow = $is_rtl ? 'fa-arrow-left' : 'fa-arrow-right';

        $table = DataTables::of($data)
            ->editColumn('category_name', function ($data) use ($request) {
                if ($request->input("export"))
                    return $data->category_name;
                return '<a href=" ' . route('edit_category', ['id' => $data->id]) . '">' . ($data->category_name) . '</a>';
            })
            ->editColumn('dtime', function ($data) {
                return date_format(date_create($data->dtime), 'Y-m-d');
            })
            ->editColumn('statusValue', function ($data) use ($isExport) {
                if ($isExport)
                    return $data->statusValue ? 'Active' : 'inActive';
                return '<span class="kt-badge kt-badge--inline kt-badge--pill ' . ($data->statusValue ? "kt-badge--success" : "kt-badge--danger") . '">' . ($data->statusValue ? 'Active' : 'inActive') . '</span>';
            });


        $table->addColumn('parent', function ($data) use ($request, $isExport, $arrow) {

            if (!empty($data->parent_id)) {
                $parentSeries = array_reverse((new CategoryModel)->getParentCategoriesTree($data->parent_id));
                if (!$isExport)
                    return '<span class="kt-badge kt-badge--success kt-badge--dot"></span> <span class="categories-queue kt-font-bold kt-font-success"> ' . implode(' <i class="fa ' . $arrow . '"></i> ', $parentSeries) . '</span>';

                return implode(' > ', $parentSeries);
            } else {
                if (!$isExport) {
                    return '<span class="kt-badge kt-badge--danger kt-badge--dot"></span> <span class="kt-font-bold kt-font-danger">-- ' . trans('admin/dashboard.root') . ' --</span>';
                }
                return trans('admin/dashboard.root');
            }
        });


        if (!$request->input("export") && $request->ajax()) {
            $table->addColumn('action', function ($data) use ($request) {
                $result = '<div class="actions tbl-sm-actions kt-align-center">';

                $result .= '<a class="btn btn-outline-success btn-icon btn-circle btn-sm ml-2"
                     href="' . parent::$data['cp_route_name'] . '/' . parent::$data['route'] . '/edit/' . $data->id . '"
                     data-skin="dark" data-toggle="kt-tooltip" data-placement="top" title="edit" data-original-title="edit">
                                    <i class="la la-edit"></i>
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
                "category_name" => "Category Name",
                "statusValue" => "Status",
                "dtime" => "Created At",
                "creator" => "Created By",
                "parent" => "Parent Category"
            ];
            $type = $request->input("export");
            if (!in_array($type, ["xlsx", "csv", "pdf"]))
                $type = "csv";

            $filter = [];

            $filter["Name"] = isset($columns[1]['search']['value']) && $columns[1]['search']['value'] ? $columns[1]['search']['value'] : 'N/A';

            $this->exportFile("Categories Report", $this->formatAliases($table, $aliases), $type, $filter);

        }


        return redirect(parent::$data['cp_route_name'] . '/' . parent::$data['route']);

    }

    public function create()
    {
        parent::$data['title'] = '';
        parent::$data['page_title'] = trans('admin/category.add_category');
        parent::$data["breadcrumbs"][trans('admin/category.add_category')] = "";

        parent::$data["category"] = new CategoryModel();
        parent::$data["categories"] = CategoryModel::with('subCategories')->Roots();

        parent::$data['creator'] = \Auth::user("admin")->full_name;
        parent::$data['created_at'] = date("Y-m-d");
        parent::$data['icon'] = "cp/media/misc/upload-image-rg.jpg";
        parent::$data['main_image'] = "cp/media/misc/upload-image-rg.jpg";
        parent::$data["show_language_bar"] = true;

        return view('cp.categories.form', parent::$data);
    }

    public function store(Request $request)
    {
        $category = $request->input("category");
        $validator = $this->validateCategory($category);

        if ($validator->fails()) {
            $return =
                [
                    'flag' => false,
                    "category_id" => 0,
                    "errors" => $validator->errors(),
                    'message' => "Check Information"
                ];

            if ($request->ajax())
                return response()->json($return, 400);

            return redirect(parent::$data['cp_route_name'] . '/' . parent::$data['route'] . '/create/')
                ->with("errors", $validator->messages());
        }

        $title = array_map(function ($i) {
            return xss_clean($i);
        }, $category['title']);

        $parent_id = $this->getParentID($request);


        $status = isset($category['is_active']);

        $created_by = \Auth::user('admin')->id;

        $is_featured = isset($category['is_featured']) && $category['is_featured'] == 1;

        $icon = '';
        if ($request->hasFile("icon")) {
            $icon = $this->upload($request->file("icon"), "categories");
        }

        $main_image = '';
        if ($request->hasFile("main_image")) {
            $main_image = $this->upload($request->file("main_image"), "categories");
        }
        /*
                \DB::beginTransaction();
                try {*/

        $categoryObj = new CategoryModel();

        $categoryObj->saveData($title, $category['slug'], $status, $parent_id, $is_featured, $icon, $main_image, $created_by);


        /*     \DB::commit();
         } catch (\Exception $e) {
             \DB::rollback();
             $return = ['flag' => false, 'message' => $e->getMessage()];
             return response()->json($return, 404);

         }*/
        if ($request->ajax()) {
            $return = ['flag' => true, 'route' => parent::$data['route'], 'message' => "Category Created Successfully"];
            return response()->json($return, 200);
        }
        return redirect(parent::$data['cp_route_name'] . '/' . parent::$data['route'] . '/edit/' . $categoryObj->id);
    }

    public function edit($id)
    {
        $category = CategoryModel::find($id);
        if (!$category)
            return redirect(parent::$data['cp_route_name'] . "/" . parent::$data['route']);

        parent::$data['title'] = '';
        parent::$data['page_title'] = trans('admin/category.add_category');
        parent::$data["breadcrumbs"][trans('admin/category.add_category')] = "";
        parent::$data['show_current_date'] = false;

        parent::$data["category"] = $category;


        parent::$data["categories"] = CategoryModel::with('subCategories')->Roots($category->id);

        parent::$data['creator'] = $category->user->full_name;
        parent::$data['created_at'] = $category->created_at;

        parent::$data['icon'] = $category->icon ? ("uploads/categories/" . $category->icon) : "cp/media/misc/upload-image-rg.jpg";
        parent::$data['main_image'] = $category->main_image ? ("uploads/categories/" . $category->main_image) : "cp/media/misc/upload-image-rg.jpg";

        parent::$data["show_language_bar"] = true;

        return view('cp.categories.form', parent::$data);
    }

    public function update(Request $request, $id)
    {
        $categoryObj = CategoryModel::find($id);

        if (!$categoryObj)
            return redirect(parent::$data['cp_route_name'] . "/" . parent::$data['route']);

        $category = $request->input("category");

        $validator = $this->validateCategory($category, $id);

        if ($validator->fails()) {
            $return =
                [
                    'flag' => false,
                    "category_id" => $categoryObj->id,
                    "errors" => $validator->errors(),
                    'message' => "Check Information"
                ];

            if ($request->ajax())
                return response()->json($return, 400);

            return redirect(parent::$data['cp_route_name'] . '/' . parent::$data['route'] . '/edit/' . $categoryObj->id)
                ->with("errors", $validator->messages());
        }


        $title = array_map(function ($i) {
            return xss_clean($i);
        }, $category['title']);

        $parent_id = $this->getParentID($request);


        $status = isset($category['is_active']);

        $is_featured = isset($category['is_featured']) && $category['is_featured'] == 1;

        $icon = $category->icon ?? '';

        if ($request->hasFile("icon")) {
            $icon = $this->upload($request->file("icon"), "categories");
        }

        $main_image = $categoryObj->main_image ?? '';
        if ($request->hasFile("main_image")) {
            $main_image = $this->upload($request->file("main_image"), "categories");
        }


        /*   \DB::beginTransaction();
           try {*/

        $categoryObj->saveData($title, $category['slug'], $status, $parent_id, $is_featured, $icon, $main_image, "");

        /*    \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            $return = ['flag' => false, 'message' => $e->getMessage()];
            return response()->json($return, 404);
        }*/

        if ($request->ajax()) {
            $return = ['flag' => true, 'route' => parent::$data['route'], 'message' => "Category Updated Successfully"];
            return response()->json($return, 200);
        }
        return redirect(parent::$data['cp_route_name'] . '/' . parent::$data['route'] . '/edit/' . $categoryObj->id);

    }

    public function productsCount($id)
    {
        if (\Request::ajax()) {
            $category = CategoryModel::find($id);
            if (!$category) {
                return response(['flag' => false, "message" => "Category not found"], 200);
            }

            return response(["flag" => true, "productsCount" => $category->products()->count()], 200);

        } else {
            return redirect(parent::$data['cp_route_name'] . "/" . parent::$data['route']);
        }
    }

    private function getParentID($request)
    {
        return isset($request->input('product')['categories'][0]) && !empty($request->input('product')['categories'][0])
            ? xss_clean($request->input('product')['categories'][0]) : NULL;
    }

    public function validateCategory($category, $id = null)
    {
        $hasError = false;
        $validator = [
            'category' => $category,
            'title' => $category['title'],
        ];
        $rules = [
            'category' => 'array',
            'title.*' => 'required',
        ];

        $messages = [

        ];

        return \Validator::make($validator, $rules, $messages);
    }
}
