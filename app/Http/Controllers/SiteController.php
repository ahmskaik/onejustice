<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\LanguageModel;
use App\Models\SettingModel;
use App\Models\SystemLookupModel;
use Illuminate\Routing\Controller as BaseController;

class SiteController extends BaseController
{
    public static $data = [];

    public function __construct()
    {
        self::$data["siteSetting"] = SettingModel::pluck("sysset_data", "name")->toArray();
        self::$data['locale'] = strtolower(\App::getLocale());
        self::$data['fallbackLanguage'] = 'en';
        self::$data['languages'] = LanguageModel::Active()->toArray();
        self::$data["categories"] = CategoryModel::with(['activeSubCategories'])->where('is_featured', true)->ActiveRoots();
         $active_language = LanguageModel::where('iso_code', strtolower(\App::getLocale()))->first();
        self::$data['active_language'] = $active_language;
        self::$data['active_language_id'] = $active_language->id;
        //self::$data['active_language_id'] = self::$data['languages'][array_search('ar', array_column(self::$data['languages'], 'iso_code'))]->id ?? 1;
    }

    public function changeLang($locale)
    {
        if (!array_key_exists($locale, app()->config->get('app.locales'))) {
            $locale = \App::$config->get('app.fallback_locale');
        }
        $link = str_replace(url("") . '/', "", \URL::previous());
        $link_segments = explode('/', $link);
        $link_segments[0] = $locale;
        return redirect(implode('/', $link_segments));
    }

}
