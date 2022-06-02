<?php namespace App\Http\Controllers\Admin;

use App;
use App\Http\Controllers\Controller;
use App\Models\ActionModel;
use App\Models\ActionRouteModel;
use App\Models\InquiryModel;
use App\Models\LanguageModel;
use App\Models\SystemUserModel;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Mpdf;
use Request;
use Route;
use Str;

class SuperAdminController extends Controller
{
    public static $data = [];
    public $characters = ["", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
    public $defaultEmail = "ahmed@onejustice.net";
    public $siteName = "onejustice";

    public function __construct()
    {
        self::$data['cp_route_name'] = config('app.cp_route_name');

        self::$data['locale'] = \Cookie::get('locale') ?? config('app.fallback_locale');//strtolower(App::getLocale());
        self::$data['languages'] = LanguageModel::Active();
        self::$data['show_current_date'] = true;

        self::$data['globals']['languages'] = self::$data['languages']->pluck('name', 'iso_code', 'locale', 'is_rtl');
        self::$data['globals']['locale'] = \Cookie::get('locale') ?? config('app.fallback_locale');//strtolower(App::getLocale());

    }
 public function changeLang($locale)
    {
        if (!array_key_exists($locale, app()->config->get('app.locales'))) {
            $locale = config('app.fallback_locale');
        }
        \Cookie::queue("locale", $locale, 99999);
        App::setlocale($locale);
        return back();
    }
    public function setAuthData()
    {
        $user = Auth::user();
        self::$data["menuActions"] = [];

        if (!Request::ajax()) {
            if ($user) {
                self::$data["menuActions"] = ActionModel::getMenu($user->id);
            }
        }

        //inquiries
        self::$data["menuActionsValue"][24] = InquiryModel::UnseenList()->count();


        if ($user) {
            self::$data["allowedActions"] = $user->actions->pluck("id")->toArray();
            //self::$data["allowedRoutes"] = ActionRouteModel::whereIn('action_id',self::$data["allowedActions"])->get()->pluck('route_name')->toArray();
            self::$data["adminUser"] = $user;
            $route = ActionRouteModel::where("route_name", Route::currentRouteName())->first();
            self::$data["actionRouteName"] = isset($route->action->name->{strtolower(App::getLocale())}) ? $route->action->name->{strtolower(App::getLocale())} : "";
            if ($route) {
                self::$data["canLog"] = $route->is_logging;
                self::$data["canLogDetails"] = $route->is_LoggingDetails;
            }
        }
    }

    public function upload($file, $dest = 'general', $name = "")
    {
        $path = public_path('uploads'); // upload directory
        $ext = $file->guessClientExtension();
        $filename = time() . Str::random(25) . '.' . $ext;
        if ($name)
            $filename = $name . "_" . time() . '.' . $ext;
        $uploadSuccess = $file->move($path . DIRECTORY_SEPARATOR . $dest, $filename);

        if ($uploadSuccess) {
            return $filename;
        } else {
            return "";
        }
    }

    public function saveBase64Image($image, $name, $dest)
    {
        $path = 'uploads/' . $dest . '/' . $name;
        //get the base-64 from data
        $base64_str = substr($image, strpos($image, ",") + 1);

        //decode base64 string
        $image = base64_decode($base64_str, true);
        file_put_contents($path, $image);

    }

    public function exportFile($reportName, $table, $type = "xlsx", $filter = [])
    {
        if ($type != "pdf") {
            return Excel::download(
                new App\Exports\DataExport($table, $reportName, $filter),
                $reportName . '.xlsx');
        } else {

            if (is_array($table['data']) && sizeof($table['data'])) {
                $allKeys = array_combine(array_keys($table['data'][0]), array_keys($table['data'][0]));
                $result = array_values($table['data']);
                $aliases = $table['aliases'];
            } else {
                $allKeys = [];
                $result = [];
                $aliases = [];
            }
            $data = [
                "filter" => $filter,
                "result" => $result,
                "title" => $reportName,
                "exportType" => "table",
                "img" => "",
                "keys" => $allKeys,
                "aliases" => $aliases,
            ];

            $this->exportPDF($data, "cp.reports.pdfReport", $data["title"]);
            exit();
        }
    }

    public function uploadProfile()
    {
        $path = public_path('uploads'); // upload directory
        $file = \Input::file('choose-file');
        $ext = $file->guessClientExtension();
        $message = '';
        $filename = time() . \Str::random(25) . '.' . $ext;
        $uploadSuccess = $file->move($path . DIRECTORY_SEPARATOR . "users", $filename);

        if ($uploadSuccess) {
            $user = SystemUserModel::find(\Auth::user("admin")->id);
            $user->avatar = $filename;
            $user->save();
            return response(array('status' => 1, 'file_name' => $filename, 'my_server' => \URL::asset('')));
        } else {
            return response(array('status' => 2, 'message' => $message));
        }
    }

    protected function exportPDF($result, $view, $reportName)
    {
        $html = view($view, $result)->render();
        $config = ["mode" => '', 'format' => 'A4', 'default_font_size' => '0', 'default_font' => '', 'mgl' => '15', 'mgr' => '15', 'mgt' => '0', 'mgb' => '0', 'mgh' => '0', 'mgf' => '0', 'orientation' => 'P'];
        $mpdf = new mPDF($config);
        $mpdf->useAdobeCJK = true;
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        //$mpdf->SetAutoFont(AUTOFONT_ALL);
        $mpdf->WriteHTML($html);
        $mpdf->Output($reportName . ".pdf", 'I');
    }

    protected function formatAliases($data, $aliases, $extraHeaders = [])
    {
        $headers = array_merge($aliases, $extraHeaders);
        $final = [
            "aliases" => $headers,
            "draw" => $data["draw"],
            "recordsTotal" => $data["recordsTotal"],
            "recordsFiltered" => $data["recordsFiltered"],
            "data" => []
        ];

        $__aliases = [];
        $counter = 0;
        if (count($data["data"])) {
            foreach ($data["data"] as $item) {
                $final["data"][$counter]["No"] = $counter + 1;
                $__aliases["No"] = "No";
                $emptyCells = array_diff(array_keys($headers), array_keys($item));
                foreach ($emptyCells as $cell) {
                    if ($cell != 'No') {
                        $final["data"][$counter][$cell] = '';
                    }
                }
                foreach ($item as $key => $value) {
                    if (array_key_exists($key, $headers)) {
                        if (in_array($key, $extraHeaders)) {
                            $__aliases[$key] = $extraHeaders[$key];
                        } else {
                            $__aliases[$key] = $headers[$key];
                        }
                        $final["data"][$counter][$key] = $value;
                    } else {
                    }
                }

                ++$counter;
            }

            $final['aliases'] = $__aliases;   //array_merge($extraHeaders, array_values($__aliases));
        } else {
            $final['aliases'] = $aliases;
        }

        return $final;
    }
}

