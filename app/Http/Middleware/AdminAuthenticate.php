<?php namespace App\Http\Middleware;

use App\Http\Controllers\Admin\SuperAdminController;
use App\Models\ActionRouteModel;
use App\Models\SystemLookupModel;
use Closure;
use Route;

class AdminAuthenticate
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
        if (\Auth::guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                if (\Cookie::get('relogin'))
                    return redirect(config('app.cp_route_name') . "/relogin");
                return redirect()->guest(config('app.cp_route_name') . '/login');
            }
        }
        $user = \Auth::user();

        if ($user->status != SystemLookupModel::getIdByKey("SYSTEM_USER_STATUS_ACTIVE")) {
            \Auth::logout();
            if (\Cookie::get('relogin'))
                return redirect(config('app.cp_route_name') . "/relogin");

            return redirect(config('app.cp_route_name') . "/login");
        }

        if (ActionRouteModel::inList(Route::currentRouteName()) && !$user->canDo(Route::currentRouteName())) {
            $route = ActionRouteModel::where("route_name", Route::currentRouteName())->first();
            return redirect()->intended(config('app.cp_route_name'))
                ->with("error", "You don't have " . $route->action->name->en . " permission");
        }

       // \App::setLocale(\Cookie::get('locale') ??  config('app.fallback_locale'));


        $obj = new SuperAdminController();
        $obj->setAuthData();
        return $next($request);
    }
}
