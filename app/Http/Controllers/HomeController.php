<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\CountryModel;
use App\Models\EventModel;
use App\Models\PostModel;
use Illuminate\Http\Request;
use NZTim\Mailchimp\Exception\MailchimpException;
use NZTim\Mailchimp\Mailchimp;

class HomeController extends SiteController
{
    protected $postFields = ['id', 'title', 'summary', 'cover_image', 'type_id', 'category_id', 'date'];

    // protected $postFields = ['*'];

    public function index(Request $request)
    {
        parent::$data["title"] = trans("site.home") . ' | ' . (parent::$data['siteSetting']['app_brand']->{parent::$data['locale']} ?? parent::$data['siteSetting']['app_brand']->{parent::$data['fallbackLanguage']});
        $active_language_id = parent::$data['active_language_id'];
        $this->prepareMainSection($active_language_id);
        $this->prepareReportsSection($active_language_id);
        $this->prepareMediaSection($active_language_id);
        $this->prepareGetInvolvedSection($active_language_id);
        $this->prepareResourcesSection($active_language_id);
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

    protected function prepareResourcesSection($active_language_id)
    {
        //$resourcesCategories = CategoryModel::where('parent_id', CategoryModel::POST_CATEGORY_STATEMENTS)->orWhere('id', CategoryModel::POST_CATEGORY_STATEMENTS)->get()->pluck('id');
        $resourcesCategories = CategoryModel::whereIn('id', [CategoryModel::POST_CATEGORY_STATEMENTS, CategoryModel::POST_CATEGORY_PUBLICATIONS])->get()->pluck('id');
        parent::$data["featured_resources"] = PostModel::Published()->select($this->postFields)->Language($active_language_id)->Featured()->whereIn('category_id', $resourcesCategories)->with(['category', 'type'])->orderby('date', 'desc')->take(2)->get();
        parent::$data["resources"] = PostModel::Published()->select($this->postFields)->Language($active_language_id)->where('is_featured', false)->whereIn('category_id', $resourcesCategories)->with(['category', 'type'])->orderby('date', 'desc')->take(4)->get();
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

        parent::$data["more_posts"] = PostModel::query()
            ->with(['category', 'type'])
            ->Published()
            ->Featured()
            ->Language($active_language_id)
            ->take(5)
            ->get();
        return view('site.home.search', parent::$data);

    }

    public function notfound(Request $request)
    {
        return view('errors.404', parent::$data);
    }

    public function getNews(Request $request, $country = '')
    {
        return view('site.test', parent::$data);
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

        $jayParsedAry = [
            [
                "CountryId" => "53F0872E-3263-4ED6-9DDB-00935F2DFCA7",
                "CountryName" => "إمارات عربية متحدة",
                "TotalNews" => "1",
                "latitude" => "23.424076",
                "longitude" => "53.847818"
            ],
            [
                "CountryId" => "CBDF69D8-3C1D-4D1C-9CBF-01E73F7ABDAD",
                "CountryName" => "موريتانيا",
                "TotalNews" => "1",
                "latitude" => "21.00789",
                "longitude" => "-10.940835"
            ],
            [
                "CountryId" => "684FB93D-A7DC-427F-9783-11E808951591",
                "CountryName" => "سوريا",
                "TotalNews" => "13",
                "latitude" => "34.802075",
                "longitude" => "38.996815"
            ],
            [
                "CountryId" => "CAB79AC1-E9FC-426C-81A5-167960F559F5",
                "CountryName" => "صومال",
                "TotalNews" => "0",
                "latitude" => "5.152149",
                "longitude" => "46.199616"
            ],
            [
                "CountryId" => "46857CA1-D065-45EE-B488-1F4DAC8608BB",
                "CountryName" => "يمن",
                "TotalNews" => "5",
                "latitude" => "15.552727",
                "longitude" => "48.516388"
            ],
            [
                "CountryId" => "934BC0F2-AEC3-494B-B3A8-44BFF38B2934",
                "CountryName" => "جيبوتي",
                "TotalNews" => "0",
                "latitude" => "11.825138",
                "longitude" => "42.590275"
            ],
            [
                "CountryId" => "616C1F29-F641-491D-ACE2-4CCE02168657",
                "CountryName" => "فلسطين",
                "TotalNews" => "7",
                "latitude" => "31.952162",
                "longitude" => "35.233154"
            ],
            [
                "CountryId" => "CE619CD0-995A-4F9E-881D-6898C1399AD7",
                "CountryName" => "كويت",
                "TotalNews" => "0",
                "latitude" => "29.31166",
                "longitude" => "47.481766"
            ],
            [
                "CountryId" => "E4F82A05-805A-44A5-ACCC-775B4641EDF8",
                "CountryName" => "أردن",
                "TotalNews" => "3",
                "latitude" => "30.585164",
                "longitude" => "36.238414"
            ],
            [
                "CountryId" => "F67F367D-EE01-4F9F-9675-89AB6177F586",
                "CountryName" => "عُمان",
                "TotalNews" => "1",
                "latitude" => "21.512583",
                "longitude" => "55.923255"
            ],
            [
                "CountryId" => "96B07C17-F400-41D1-8CC4-99AD92C2B85B",
                "CountryName" => "لبنان",
                "TotalNews" => "0",
                "latitude" => "33.854721",
                "longitude" => "35.862285"
            ],
            [
                "CountryId" => "75B20C23-11FB-4665-9BF5-9CBB520655DA",
                "CountryName" => "تونس  ",
                "TotalNews" => "0",
                "latitude" => "33.886917",
                "longitude" => "9.537499"
            ],
            [
                "CountryId" => "8465B353-424C-49B6-A79F-9FF78C04564E",
                "CountryName" => "سعودية",
                "TotalNews" => "1",
                "latitude" => "23.885942",
                "longitude" => "45.079162"
            ],
            [
                "CountryId" => "D1BA76BE-AD33-4927-9669-BA5A7E671851",
                "CountryName" => "مصر",
                "TotalNews" => "4",
                "latitude" => "26.820553",
                "longitude" => "30.802498"
            ],
            [
                "CountryId" => "C3B47BDB-5D72-4A82-9723-C6B9B51D113C",
                "CountryName" => "جزر القمر",
                "TotalNews" => "0",
                "latitude" => "-11.6455",
                "longitude" => "43.3333"
            ],
            [
                "CountryId" => "334298CD-78B8-47DD-A51E-C78A92A245EB",
                "CountryName" => "بحرين",
                "TotalNews" => "0",
                "latitude" => "26.0667",
                "longitude" => "50.5577"
            ],
            [
                "CountryId" => "7E2C9D9C-9522-4F47-B341-C7D32093814E",
                "CountryName" => "جزائر",
                "TotalNews" => "2",
                "latitude" => "28.033886",
                "longitude" => "1.659626"
            ],
            [
                "CountryId" => "55067621-46C8-485D-B56C-CF39C3167EEE",
                "CountryName" => "مغرب",
                "TotalNews" => "0",
                "latitude" => "31.791702",
                "longitude" => "-7.09262"
            ],
            [
                "CountryId" => "B5A97D9C-0D4D-4CD5-9A04-D38E8B644CCB",
                "CountryName" => "عراق",
                "TotalNews" => "5",
                "latitude" => "33.223191",
                "longitude" => "43.679291"
            ],
            [
                "CountryId" => "750CC971-AD74-4703-8017-D79C7C23A9BB",
                "CountryName" => "إسرائيل",
                "TotalNews" => "5",
                "latitude" => "31.046051",
                "longitude" => "34.851612"
            ],
            [
                "CountryId" => "78069AA7-858E-4343-84EF-DF8A845CE36C",
                "CountryName" => "ليبيا",
                "TotalNews" => "2",
                "latitude" => "26.3351",
                "longitude" => "17.228331"
            ],
            [
                "CountryId" => "7D165E85-4625-4C5E-A03E-ED26C26686E0",
                "CountryName" => "قطر",
                "TotalNews" => "3",
                "latitude" => "25.354826",
                "longitude" => "51.183884"
            ],
            [
                "CountryId" => "401C60BF-7529-442E-8B23-EDB5B8317DD6",
                "CountryName" => "سودان",
                "TotalNews" => "0",
                "latitude" => "12.862807",
                "longitude" => "30.217636"
            ],
            [
                "CountryId" => "880B0224-DCC0-44D8-BA8E-2CAA913FC86E",
                "CountryName" => "روسيا",
                "TotalNews" => "2",
                "latitude" => "61.52401",
                "longitude" => "105.318756"
            ],
            [
                "CountryId" => "17C158D5-E4AE-478E-A87F-39F07D4F2D42",
                "CountryName" => "أفغانستان ",
                "TotalNews" => "1",
                "latitude" => "33.93911",
                "longitude" => "67.709953"
            ],
            [
                "CountryId" => "0CA74E76-632B-4031-AB70-495E611F8498",
                "CountryName" => "تشيكيا",
                "TotalNews" => "1",
                "latitude" => "49.817492",
                "longitude" => "15.472962"
            ],
            [
                "CountryId" => "7E73C3EB-7E16-4E89-ABAA-51EC326E23FE",
                "CountryName" => "تركيا",
                "TotalNews" => "2",
                "latitude" => "38.963745",
                "longitude" => "35.243322"
            ],
            [
                "CountryId" => "E02B4D62-6A3C-4A7C-A815-5BEE9E656D26",
                "CountryName" => "ألمانيا",
                "TotalNews" => "2",
                "latitude" => "51.165691",
                "longitude" => "10.451526"
            ],
            [
                "CountryId" => "A4CB9186-DEE2-4879-81AC-8151906089B3",
                "CountryName" => "ولايات متحدة أميركية",
                "TotalNews" => "12",
                "latitude" => "37.09024",
                "longitude" => "-95.712891"
            ],
            [
                "CountryId" => "3E6D21CD-6BB2-4986-B752-829A324B5139",
                "CountryName" => "فرنسا",
                "TotalNews" => "1",
                "latitude" => "46.227638",
                "longitude" => "2.213749"
            ],
            [
                "CountryId" => "9601D4B3-C98A-44EE-8D7D-874EABE43136",
                "CountryName" => "صين",
                "TotalNews" => "1",
                "latitude" => "35.86166",
                "longitude" => "104.195397"
            ],
            [
                "CountryId" => "CFC98E26-E8F9-4C71-8422-92FD92C250EF",
                "CountryName" => "يابان",
                "TotalNews" => "1",
                "latitude" => "36.204824",
                "longitude" => "138.252924"
            ],
            [
                "CountryId" => "90DCC9B7-3A8A-4D23-80BD-A5DE7432E67A",
                "CountryName" => "كولومبيا",
                "TotalNews" => "1",
                "latitude" => "4.570868",
                "longitude" => "-74.297333"
            ],
            [
                "CountryId" => "D1065203-4CAE-4DEA-AD04-E05D8594D99A",
                "CountryName" => "مالي",
                "TotalNews" => "1",
                "latitude" => "17.570692",
                "longitude" => "-3.996166"
            ]
        ];

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
