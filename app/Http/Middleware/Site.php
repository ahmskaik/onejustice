<?php

namespace App\Http\Middleware;

use App\Models\LanguageModel;
use App\Models\SettingModel;
use Closure;
use Route;

class Site
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $settings = SettingModel::where("name", "is_open")->first();
        if ($settings->sysset_data[0] != 1) {
            return redirect("/404");
        }
        $activeLanguages = LanguageModel::Active()->pluck('iso_code')->toArray();
        $fallbackLanguage = 'en';
        if (!in_array(\App::getLocale(), $activeLanguages)) {
            return redirect('/' . $fallbackLanguage);
        }

        return $next($request);
    }

}
