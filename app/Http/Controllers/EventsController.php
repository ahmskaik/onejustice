<?php

namespace App\Http\Controllers;

use App\Models\EventModel;
use App\Models\SystemLookupModel;
use Illuminate\Http\Request;

class EventsController extends SiteController
{
    public function index(Request $request, $type = "")
    {
        if ($type) {
            $type = SystemLookupModel::where('slug', xss_clean($type))->where('is_active', true)->first();
            if (!$type)
                return redirect()->to(route('site.home'));
        }

        parent::$data["title"] = $type ? ($type->syslkp_data->{parent::$data['locale']} ?? $type->syslkp_data->{parent::$data['fallbackLanguage']}) : trans('site.get_involved');
        parent::$data["type"] = $type;

        parent::$data["types"] = !$type ? parent::$data["get_involved_types"] : [];
        $lang = parent::$data["locale"];
        $main_event = parent::$data["main_event"] = EventModel::query()
            ->Active()
            ->Featured()
            ->when($type, function ($query) use ($type) {
                $query->where('type_id', $type->id);
            })
            ->orderby('date', 'desc')
            ->select(['id',
                \DB::raw("(CASE WHEN (json_unquote(json_extract(`title`, '$.\"{$lang}\"')) IS NULL
                    OR json_unquote(json_extract(`title`, '$.\"{$lang}\"')) = '') THEN
                     json_unquote(json_extract(`title`, '$.\"" . parent::$data["fallbackLanguage"] . "\"')) ELSE
                     json_unquote(json_extract(`title`, '$.\"{$lang}\"')) END) as the_title"),
                //'title->' . parent::$data["locale"] . ' as the_title',
                'cover_image', 'type_id', 'date'])
            ->first();

        parent::$data["featured_events"] = EventModel::query()
            ->with(['type'])
            ->Active()
            ->Featured()
            ->when($type, function ($query) use ($type) {
                $query->where(function ($q) use ($type) {
                    $q->where('type_id', $type->id);
                });
            })
            ->when(!is_null($main_event), function ($query) use ($main_event) {
                $query->where('id', '!=', $main_event->id);
            })
            ->orderby('date', 'desc')
            ->take(2)
            ->select(['id',
                \DB::raw("(CASE WHEN (json_unquote(json_extract(`title`, '$.\"{$lang}\"')) IS NULL
                    OR json_unquote(json_extract(`title`, '$.\"{$lang}\"')) = '') THEN
                     json_unquote(json_extract(`title`, '$.\"" . parent::$data["fallbackLanguage"] . "\"')) ELSE
                     json_unquote(json_extract(`title`, '$.\"{$lang}\"')) END) as the_title"),
                //'title->' . parent::$data["locale"] . ' as the_title',
                'cover_image', 'type_id', 'date'])
            ->get();


        $limit = 8;
        parent::$data["events"] = EventModel::query()
            ->with(['type'])
            ->Active()
            ->when($type, function ($query) use ($type) {
                $query->where(function ($q) use ($type) {
                    $q->where('type_id', $type->id);
                });
            })
            ->orderby('date', 'desc')
            ->when(!is_null($main_event), function ($query) use ($main_event) {
                $query->where('id', '!=', $main_event->id);
            })
            ->whereNotIn('id', parent::$data["featured_events"]->pluck('id'))
            ->select(['id',
                \DB::raw("(CASE WHEN (json_unquote(json_extract(`title`, '$.\"{$lang}\"')) IS NULL
                    OR json_unquote(json_extract(`title`, '$.\"{$lang}\"')) = '') THEN
                     json_unquote(json_extract(`title`, '$.\"" . parent::$data["fallbackLanguage"] . "\"')) ELSE
                     json_unquote(json_extract(`title`, '$.\"{$lang}\"')) END) as the_title"),
                //'title->' . parent::$data["locale"] . ' as the_title',
                'cover_image', 'type_id', 'date'])
            ->paginate($limit);

        parent::$data["hasMore"] = 0;
        parent::$data["nextPage"] = parent::$data["events"]->nextPageUrl();
        $page = $request->input("page") ? (int)$request->input("page") : 1;

        if (parent::$data["events"]->total() > ($page * $limit))
            parent::$data["hasMore"] = 1;


        if ($request->ajax()) {
            $data = view("site.event.eventsListPart", ["events" => parent::$data["events"],'fallbackLanguage'=>parent::$data['fallbackLanguage'], "type" => parent::$data["type"], "locale" => parent::$data["locale"]])->render();
            return response(["status" => true, "count" => parent::$data["events"]->total(), "nextPage" => parent::$data["nextPage"], "hasMore" => parent::$data["hasMore"], "data" => $data], 200);
        }

        return view('site.event.list', parent::$data);
    }

    public function show(Request $request, $id, $type = '', $slug = '')
    {
        $event = EventModel::Active()->select(['id', 'date', 'type_id', 'title->' . parent::$data["locale"] . ' as the_title', 'body->' . parent::$data["locale"] . ' as the_body', 'cover_image'])->find($id);
        if (!$event)
            return redirect()->to(route('site.home'));

        parent::$data["title"] = $event->the_title;
        parent::$data["event"] = $event;

        $event->increment('views');
        $lang = parent::$data["locale"];

        parent::$data["events_may_like"] = EventModel::query()
            ->with(['type'])
            ->Active()
            ->where('id', '!=', $event->id)
            ->select(['id',
                \DB::raw("(CASE WHEN (json_unquote(json_extract(`title`, '$.\"{$lang}\"')) IS NULL
                    OR json_unquote(json_extract(`title`, '$.\"{$lang}\"')) = '') THEN
                     json_unquote(json_extract(`title`, '$.\"" . parent::$data["fallbackLanguage"] . "\"')) ELSE
                     json_unquote(json_extract(`title`, '$.\"{$lang}\"')) END) as the_title"),
               // 'title->' . parent::$data["locale"] . ' as the_title',
                'cover_image', 'type_id', 'date'])
            ->orderby('date', 'desc')
            ->take(3)
            ->get();

        return view('site.event.details', parent::$data);
    }

}
