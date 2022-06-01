<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\CountryModel;
use App\Models\EventModel;
use App\Models\PostModel;
use Illuminate\Http\Request;

class HomeController extends SiteController
{
    protected $postFields = ['id', 'title', 'summary', 'cover_image', 'type_id', 'category_id', 'date'];

    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        parent::$data["title"] = trans("site.home") . ' | ' . (parent::$data['siteSetting']['app_brand']->{parent::$data['locale']} ?? parent::$data['siteSetting']['app_brand']->{parent::$data['fallbackLanguage']});
        $active_language_id = parent::$data['active_language_id'];
        $this->prepareMainSection($active_language_id);
        $this->prepareReportsSection($active_language_id);
        $this->prepareMediaSection($active_language_id);
        $this->prepareGetInvolvedSection($active_language_id);
        $this->prepareVideosSection($active_language_id);
        return view('site.home.index', parent::$data);
    }

    protected function prepareMainSection($active_language_id)
    {
        parent::$data["featured_article"] = PostModel::Published()->select($this->postFields)->Language($active_language_id)->Featured()->orderby('date', 'desc')->first();
        parent::$data["featured_news"] = PostModel::Published()->select($this->postFields)->Language($active_language_id)->where('is_featured', false)->orderby('date', 'desc')->with(['category', 'type'])->take(4)->get();
    }

    protected function prepareReportsSection($active_language_id)
    {
        parent::$data["featured_report"] = PostModel::Published()->select($this->postFields)->Language($active_language_id)->Featured()->where('category_id', CategoryModel::POST_CATEGORY_REPORTS)->orderby('date', 'desc')->with(['category', 'type'])->first();
        parent::$data["featured_reports_middle"] = PostModel::Published()->select($this->postFields)->Language($active_language_id)->Featured()->where('category_id', CategoryModel::POST_CATEGORY_REPORTS)->orderby('date', 'desc')->with(['category', 'type'])->skip(1)->take(2)->get();
        parent::$data["reports"] = PostModel::Published()->select($this->postFields)->Language($active_language_id)->where('is_featured', false)->where('category_id', CategoryModel::POST_CATEGORY_REPORTS)->orderby('date', 'desc')->with(['category', 'type'])->take(5)->get();
    }

    protected function prepareMediaSection($active_language_id)
    {
        $mediaCategories = CategoryModel::where('parent_id', CategoryModel::POST_CATEGORY_MEDIA)->orWhere('id', CategoryModel::POST_CATEGORY_MEDIA)->get()->pluck('id');
        parent::$data["media"] = PostModel::query()->Published()->Language($active_language_id)->where('is_featured', false)
            ->whereIn('category_id', $mediaCategories)->with(['category', 'type'])->orderby('date', 'desc')->take(4)->get();
    }

    protected function prepareGetInvolvedSection($active_language_id)
    {
        $featured_get_involved = parent::$data["featured_get_involved"] =
            EventModel::Active()->Featured()->with(['type'])
                ->select(['id', 'date', 'type_id', 'title->' . parent::$data["locale"] . ' as the_title', 'cover_image'])
                ->orderby('date', 'desc')->first();
        parent::$data["get_involved_left"] = EventModel::Active()->with(['type'])
            ->when($featured_get_involved, function ($query) use ($featured_get_involved) {
                $query->where('id', '!=', $featured_get_involved->id);
            })
            ->orderby('date', 'desc')
            ->select(['id', 'date', 'type_id', 'title->' . parent::$data["locale"] . ' as the_title', 'cover_image'])
            ->take(2)
            ->get();
        //   parent::$data["get_involved_right"] = EventModel::Active()->with(['type'])->orderby('date', 'desc')->skip(3)->take(6)->select(['id','date', 'type_id', 'title->' . parent::$data["locale"] . ' as the_title', 'cover_image'])->get();
    }

    protected function prepareVideosSection($active_language_id)
    {
        parent::$data["featured_video"] = PostModel::Published()->select($this->postFields)->Language($active_language_id)->Featured()->where('category_id', CategoryModel::POST_CATEGORY_MEDIA)->orderby('date', 'desc')->first();
        parent::$data["videos"] = PostModel::Published()->select($this->postFields)->Language($active_language_id)->where('is_featured', false)->where('category_id', CategoryModel::POST_CATEGORY_MEDIA)->with(['category', 'type'])->orderby('date', 'desc')->skip(1)->take(4)->get();

    }

    public function search(Request $request)
    {
        parent::$data["title"] = trans("site.search_results") . ' | ' . parent::$data["siteSetting"]['app_brand']->{parent::$data["locale"]};

        $query = xss_clean($request->query('s'));
        $active_language_id = parent::$data['active_language_id'];

        $limit = 8;
        parent::$data["posts"] = PostModel::query()
            ->with(['category', 'type'])
            ->Published()
            ->Featured()
            ->where('title', 'like', "%" . $query . "%")
            ->Language($active_language_id)
            ->paginate($limit);

        parent::$data["query"] = $query;
        parent::$data["hasMore"] = 0;
        parent::$data["nextPage"] = parent::$data["posts"]->nextPageUrl();
        $page = $request->input("page") ? (int)$request->input("page") : 1;

        if (parent::$data["posts"]->total() > ($page * $limit))
            parent::$data["hasMore"] = 1;
        if ($request->ajax()) {
            $data = view("site.home.searchResultPart", ["posts" => parent::$data["posts"], "query" => parent::$data["query"], "locale" => parent::$data["locale"]])->render();
            return response(
                [
                    "status" => true,
                    "count" => parent::$data["posts"]->total(),
                    "nextPage" => parent::$data["nextPage"],
                    "hasMore" => parent::$data["hasMore"],
                    "data" => $data,
                    "query" => $query
                ], 200);
        }

        return view('site.home.search', parent::$data);
    }

    public function notfound(Request $request)
    {
        return view('errors.404', parent::$data);
    }

    public function newsMapCount(Request $request)
    {
        $active_language_id = parent::$data['active_language_id'];

        $data = CountryModel::query()->select(
            [
                'id as CountryId',
                'properties->' . parent::$data["locale"] . ' as CountryName',
                'iso_code',
                "latitude",
                "longitude"
            ])
            ->whereHas('posts', function ($q) use ($active_language_id) {
                $q->Language($active_language_id);
                $q->Published();
            })
            ->withCount(['posts as TotalNews' => function ($q) use ($active_language_id) {
                $q->Language($active_language_id);
                $q->Published();
            }])
            ->get();


        return response()->json($data);

    }

    public function getLatestNews(Request $request, $countryId = '')
    {
        $active_language_id = parent::$data['active_language_id'];
        parent::$data["latestNews"] = PostModel::query()
            ->when($countryId, function ($q) use ($countryId) {
                $q->whereHas('countries', function ($q) use ($countryId) {
                    $q->where('countries.id', $countryId);
                });
            })
            ->with(['category', 'countries' => function ($q) {
                $q->select(['countries.id', 'properties->' . parent::$data["locale"] . ' as CountryName']);
            }])
            ->Language($active_language_id)
            ->Published()
            ->take(15)
            ->orderBy('date', 'desc')
            ->get();

        if ($countryId) {
            parent::$data["country"] = CountryModel::query()
                ->where('id', $countryId)
                ->select(['id', 'iso_code', 'properties->' . parent::$data["locale"] . ' as CountryName'])
                ->withCount(['posts as TotalNews' => function ($q) use ($active_language_id) {
                    $q->Language($active_language_id);
                    $q->Published();
                }])
                ->first();
        }

        return view('site.post.parts.latestNews', parent::$data)->render();
    }
}
