<?php

namespace App\Http\Controllers\Admin;

use Analytics;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Spatie\Analytics\Period;

class ReportsController extends SuperAdminController
{
    var $functionsArray;
    var $defaultFrom;
    var $defaultTo;
    var $gaGrouping;
    var $timeGrouping;

    public function __construct()
    {
        parent::__construct();
        parent::$data['active_menu'] = 'report_view';
        parent::$data["breadcrumbs"] = ["Dashboard" => parent::$data['cp_route_name'], "Reports" => ""];
        $this->defaultFrom = date("Y-01-01");
        $this->defaultTo = date("Y-m-d");
        $this->functionsArray = ["year" => "setEmptyPeriodYear", "month" => "setEmptyPeriodMonth", "quarter" => "setEmptyPeriodQuarter", "week" => "setEmptyPeriodWeek"];
        $this->gaGrouping = ["year" => "ga:year", "month" => "ga:yearMonth", "week" => "ga:yearWeek"];
        $this->timeGrouping = ["year" => "Y", "month" => "Ym", "week" => "Yw"];
        parent::$data['active_menu'] = 'visitorsView';

    }

    public function visitors(Request $request)
    {
        $from = strtotime($request->input("from")) ? $request->input("from") : $this->defaultFrom;
        $to = strtotime($request->input("to")) ? $request->input("to") : $this->defaultTo;
        $to = strtotime($to) <= strtotime($from) ? $from : $to;


        $startDate = \Carbon\Carbon::parse($from);
        $endDate = \Carbon\Carbon::parse($to);
        $period = Period::create($startDate, $endDate);


        $result = Analytics::performQuery(
            $period,
            'ga:sessions',
            [
                'metrics' => 'ga:sessions, ga:pageviews',
                'dimensions' => 'ga:yearMonth'
            ]);

        $result = $result->rows;
        foreach ($result as $key => $item) {
            $result[$key]["period"] = date("Y/m", strtotime($item[0]));
            $result[$key]["visitors"] = $item[1];
            $result[$key]["pageViews"] = $item[2];
            unset($result[$key][0]);
            unset($result[$key][1]);
            unset($result[$key][2]);
        }

        $tmp = $result;
        $ActiveUsers = Analytics::performQuery($period, 'ga:users')->rows[0][0];

        $result = ["data" => $result, "active" => $ActiveUsers];

        if ($request->ajax())
            return response(["data" => $result, "from" => date("Y-m", strtotime($from)), "to" => date("Y-m", strtotime($to))], 200);

        $allKeys = array('period' => "Time Period", 'pageViews' => "Page Views", 'visitors' => "Visitors");

        $data = ["result" => $tmp, "filter" => ["From" => defaultNa($request->input("from")), "To" => defaultNa($request->input("to"))], "title" => "Visitors and page views", "exportType" => $request->input("exportType"), "img" => $request->input("img"), "keys" => $allKeys, "generalInfo" => ["Current Active Users" => $result["active"], "Total Visitors" => array_sum(array_column($result["data"], "visitors")), "Total Page Views" => array_sum(array_column($result["data"], "pageViews"))]];

        $this->printingRender($request->input("export"), $data);
    }

    public function country(Request $request)
    {
        $from = strtotime($request->input("from")) ? $request->input("from") : $this->defaultFrom;
        $to = strtotime($request->input("to")) ? $request->input("to") : $this->defaultTo;
        $to = strtotime($to) <= strtotime($from) ? $from : $to;

        $startDate = \Carbon\Carbon::parse($from);
        $endDate = \Carbon\Carbon::parse($to);
        $period = Period::create($startDate, $endDate);

        $maxNo = $request->input("maxNo");
        if ((int)$maxNo)
            $maxNox = ["max-results" => (int)$maxNo];
        else
            $maxNox = [];


        $result = Analytics::performQuery($period, "ga:sessions", array_merge(['sort' => "-ga:sessions", 'dimensions' => "ga:country,ga:region,ga:countryIsoCode"], $maxNox));

        if (is_null($result->rows)) {
            $result = new Collection([]);
            return response(["data" => $result, "from" => date("Y-m", strtotime($from)), "to" => date("Y-m", strtotime($to))], 200);
        }

        $pagesData = [];
        //print_r($result);die();
        foreach ($result->rows as $dateRow) {
            $pagesData[] = ["country" => $dateRow[0] . ' (' . $dateRow[1] . ')', "count" => $dateRow[3]];
        }

        $result = new Collection($pagesData);
        if ($request->ajax())
            return response(["data" => $result, "from" => date("Y-m", strtotime($from)), "to" => date("Y-m", strtotime($to))], 200);


        $allKeys = array('country' => "Country", 'count' => "Count");

        $data = ["result" => $result, "filter" => ["Max No" => $maxNo ? $maxNo : "All", "From" => defaultNa($request->input("from")), "To" => defaultNa($request->input("to"))], "title" => "Visits by countries", "exportType" => $request->input("exportType"), "img" => $request->input("img"), "keys" => $allKeys, "generalInfo" => ["Total Countries" => sizeof($result->toArray()), "Total Count" => array_sum(array_column($result->toArray(), "count"))]];
        $this->printingRender($request->input("export"), $data);
    }

    public function mobileTraffic(Request $request)
    {
        $from = strtotime($request->input("from")) ? $request->input("from") : $this->defaultFrom;
        $to = strtotime($request->input("to")) ? $request->input("to") : $this->defaultTo;
        $to = strtotime($to) <= strtotime($from) ? $from : $to;
        $groupBy = $request->input("groupBy");
        if (!in_array($groupBy, ["year", "month"])) {
            $groupBy = "month";
        }

        $startDate = \Carbon\Carbon::parse($from);
        $endDate = \Carbon\Carbon::parse($to);
        $period = Period::create($startDate, $endDate);


        $result = Analytics::performQuery($period,
            "ga:sessions",
            [
                'dimensions' => "ga:deviceCategory," . $this->gaGrouping[$groupBy]
            ]);
        if (is_null($result->rows)) {
            $result = new Collection([]);
            return response(["data" => $result, "from" => date("Y-m", strtotime($from)), "to" => date("Y-m", strtotime($to))], 200);
        }
        $pagesData = [];
        foreach ($result->rows as $dateRow) {
            if ($groupBy == "week") {
                $tmp = getStartAndEndDate(substr($dateRow[1], 4), substr($dateRow[1], 0, 4));
                $tmp = $tmp[0];
            } elseif ($groupBy == "month") {
                $tmp = formatTimePeriod($groupBy, substr($dateRow[1], 0, 4), substr($dateRow[1], 4));
            } else {
                $tmp = $dateRow[1];
            }

            if (isset($pagesData[$tmp])) {
                $pagesData[$tmp][str_replace(" ", "", $dateRow[0])] = $dateRow[2];
            } else {
                $pagesData[$tmp] = ["periodName" => $tmp, "desktop" => 0, "mobile" => 0, str_replace(" ", "", $dateRow[0]) => $dateRow[2]];
            }
        }
        $result = $this->functionsArray[$groupBy](strtotime($from), strtotime($to), $pagesData, ["desktop" => 0, "mobile" => 0]);
        if ($request->ajax())
            return response(["data" => $result, "from" => date("Y-m", strtotime($from)), "to" => date("Y-m", strtotime($to))], 200);

        $allKeys = array('periodName' => "Time Period", "desktop" => "Desktop", 'mobile' => "Mobile");

        $data = ["result" => $result, "filter" => ["Group By" => $groupBy, "From" => defaultNa($request->input("from")), "To" => defaultNa($request->input("to"))], "title" => "Mobile Traffic", "exportType" => $request->input("exportType"), "img" => $request->input("img"), "keys" => $allKeys, "generalInfo" => ["Total Sessions" => array_sum(array_column($result, "sessions"))]];

        $this->printingRender($request->input("export"), $data);
    }

    public function browsers(Request $request)
    {
        $from = strtotime($request->input("from")) ? $request->input("from") : $this->defaultFrom;
        $to = strtotime($request->input("to")) ? $request->input("to") : $this->defaultTo;
        $to = strtotime($to) <= strtotime($from) ? $from : $to;

        $startDate = \Carbon\Carbon::parse($from);
        $endDate = \Carbon\Carbon::parse($to);
        $period = Period::create($startDate, $endDate);


        $result = Analytics::performQuery(
            $period,
            'ga:sessions',
            [
                'dimensions' => 'ga:browser',
                'sort' => '-ga:sessions'
            ]);

        $result = $result->rows;
        foreach ($result as $key => $item) {
            $result[$key]["browser"] = $item[0];
            $result[$key]["sessions"] = $item[1];
            unset($result[$key][0]);
            unset($result[$key][1]);
        }

        if ($request->ajax())
            return response(["data" => $result, "from" => date("Y-m", strtotime($from)), "to" => date("Y-m", strtotime($to))], 200);

        $allKeys = array('browser' => "Browsers", 'sessions' => "Sessions");

        $data = ["result" => $result, "filter" => ["From" => defaultNa($request->input("from")), "To" => defaultNa($request->input("to"))], "title" => "Browsers", "exportType" => $request->input("exportType"), "img" => $request->input("img"), "keys" => $allKeys, "generalInfo" => ["Total Browsers" => sizeof($result->toArray()), "Total Sessions" => array_sum(array_column($result->toArray(), "sessions"))]];

        $this->printingRender($request->input("export"), $data);
    }

    public function referrers(Request $request)
    {
        $from = strtotime($request->input("from")) ? $request->input("from") : $this->defaultFrom;
        $to = strtotime($request->input("to")) ? $request->input("to") : $this->defaultTo;
        $to = strtotime($to) <= strtotime($from) ? $from : $to;

        $startDate = \Carbon\Carbon::parse($from);
        $endDate = \Carbon\Carbon::parse($to);
        $period = Period::create($startDate, $endDate);


        $result = Analytics::performQuery(
            $period,
            'ga:pageviews',
            [
                'dimensions' => 'ga:fullReferrer',
                'sort' => '-ga:pageviews',
                'max-results' => 10
            ]);

        $result = $result->rows;
        foreach ($result as $key => $item) {
            $result[$key]["url"] = $item[0];
            $result[$key]["pageViews"] = $item[1];
            unset($result[$key][0]);
            unset($result[$key][1]);
        }

        if ($request->ajax())
            return response(["data" => $result, "from" => date("Y-m", strtotime($from)), "to" => date("Y-m", strtotime($to))], 200);

        $allKeys = array('url' => "URL", 'pageViews' => "Page Views");

        $data = ["result" => $result, "filter" => ["From" => defaultNa($request->input("from")), "To" => defaultNa($request->input("to"))], "title" => "Referrers", "exportType" => $request->input("exportType"), "img" => $request->input("img"), "keys" => $allKeys, "generalInfo" => ["Total Url" => sizeof($result->toArray()), "Total Pages Views" => array_sum(array_column($result->toArray(), "pageViews"))]];

        $this->printingRender($request->input("export"), $data);
    }

    public function siteTime(Request $request)
    {
        $from = strtotime($request->input("from")) ? $request->input("from") : $this->defaultFrom;
        $to = strtotime($request->input("to")) ? $request->input("to") : $this->defaultTo;
        $to = strtotime($to) <= strtotime($from) ? $from : $to;
        $groupBy = $request->input("groupBy");
        if (!in_array($groupBy, ["year", "month"])) {
            $groupBy = "month";
        }

        $startDate = \Carbon\Carbon::parse($from);
        $endDate = \Carbon\Carbon::parse($to);
        $period = Period::create($startDate, $endDate);

        $result = Analytics::performQuery($period,
            "ga:sessions,ga:sessionDuration",
            [
                'sort' => $this->gaGrouping[$groupBy],
                'dimensions' => $this->gaGrouping[$groupBy]
            ]);
        if (is_null($result->rows)) {
            $result = new Collection([]);
            return response(["data" => $result, "from" => date("Y-m", strtotime($from)), "to" => date("Y-m", strtotime($to))], 200);
        }

        $pagesData = [];
        foreach ($result->rows as $dateRow) {
            if ($groupBy == "week") {
                $tmp = getStartAndEndDate(substr($dateRow[0], 0, 4), substr($dateRow[0], 4));
                $tmp = $tmp[0];
            } elseif ($groupBy == "month") {
                $tmp = formatTimePeriod($groupBy, substr($dateRow[0], 4), substr($dateRow[0], 0, 4));
            } else {
                $tmp = $dateRow[0];
            }
            $pagesData[$tmp] = ["periodName" => $tmp, "Sessions" => $dateRow[1], "Duration" => $dateRow[2]];
        }

        //return $pagesData;
        $result = $this->functionsArray[$groupBy](strtotime($from), strtotime($to), $pagesData, ["Sessions" => 0, "Duration" => 0]);
        if ($request->ajax())
            return response(["data" => $result, "from" => date("Y-m", strtotime($from)), "to" => date("Y-m", strtotime($to))], 200);

        //return $result;
        $allKeys = array('serial' => "Serial", 'periodName' => "Time Period", 'Sessions' => "Sessions", "Duration" => "Duration");

        $data = ["result" => $result, "filter" => ["Group By" => $groupBy, "From" => defaultNa($request->input("from")), "To" => defaultNa($request->input("to"))], "title" => "Time spend on site", "exportType" => $request->input("exportType"), "img" => $request->input("img"), "keys" => $allKeys, "generalInfo" => ["Total Sessions" => array_sum(array_column($result, "Sessions"))]];

        $this->printingRender($request->input("export"), $data);
    }

    public function keywords(Request $request)
    {
        $from = strtotime($request->input("from")) ? $request->input("from") : $this->defaultFrom;
        $to = strtotime($request->input("to")) ? $request->input("to") : $this->defaultTo;
        $to = strtotime($to) <= strtotime($from) ? $from : $to;

        $startDate = \Carbon\Carbon::parse($from);
        $endDate = \Carbon\Carbon::parse($to);
        $period = Period::create($startDate, $endDate);


        $result = Analytics::performQuery(
            $period,
            'ga:sessions',
            [
                'dimensions' => 'ga:keyword',
                'sort' => '-ga:sessions',
                'max-results' => 10,
                'filters' => 'ga:keyword!=(not set);ga:keyword!=(not provided)'
            ]);

        $result = $result->rows;
        foreach ($result as $key => $item) {
            $result[$key]["keyword"] = $item[0];
            $result[$key]["sessions"] = $item[1];
            unset($result[$key][0]);
            unset($result[$key][1]);
        }


        if ($request->ajax())
            return response(["data" => $result, "from" => date("Y-m", strtotime($from)), "to" => date("Y-m", strtotime($to))], 200);

        $allKeys = array('keyword' => "Keywords", 'sessions' => "Sessions");

        $data = [
            "result" => $result, "filter" =>
                [
                    "From" => defaultNa($request->input("from")),
                    "To" => defaultNa($request->input("to"))
                ],
            "title" => "Keywords",
            "exportType" => $request->input("exportType"),
            "img" => $request->input("img"),
            "keys" => $allKeys,
            "generalInfo" =>
                [
                    "Total Keywords" => sizeof($result),
                    "Total Sessions" => array_sum(array_column($result, "sessions"))
                ]
        ];

        $this->printingRender($request->input("export"), $data);
    }

    public function mostVisited(Request $request)
    {
        $from = strtotime($request->input("from")) ? $request->input("from") : $this->defaultFrom;
        $to = strtotime($request->input("to")) ? $request->input("to") : $this->defaultTo;
        $to = strtotime($to) <= strtotime($from) ? $from : $to;


        $startDate = \Carbon\Carbon::parse($from);
        $endDate = \Carbon\Carbon::parse($to);
        $period = Period::create($startDate, $endDate);
        $maxNo = $request->input("maxNo");
        if ((int)$maxNo)
            $maxNox = ["max-results" => (int)$maxNo];
        else
            $maxNox = [];

        $result = Analytics::performQuery(
            $period,
            'ga:pageviews',
            [
                'dimensions' => 'ga:pagePath',
                'sort' => '-ga:pageviews',
                'max-results' => $maxNox
            ]);

        $result = $result->rows;

        foreach ($result as $key => $item) {
            $result[$key]["url"] = $item[0];
            $result[$key]["pageViews"] = $item[1];
            unset($result[$key][0]);
            unset($result[$key][1]);
        }


        if ($request->ajax())
            return response(["data" => $result, "from" => date("Y-m", strtotime($from)), "to" => date("Y-m", strtotime($to))], 200);

        $allKeys = array('url' => "URL", 'pageViews' => "Page Views");

        $data = ["result" => $result, "filter" => ["From" => defaultNa($request->input("from")), "To" => defaultNa($request->input("to"))], "title" => "Most Visited", "exportType" => $request->input("exportType"), "img" => $request->input("img"), "keys" => $allKeys, "generalInfo" => ["Total Url" => sizeof($result->toArray()), "Total Pages Views" => array_sum(array_column($result->toArray(), "pageViews"))]];

        $this->printingRender($request->input("export"), $data);
    }

    public function newVsReturning(Request $request)
    {
        $from = strtotime($request->input("from")) ? $request->input("from") : $this->defaultFrom;
        $to = strtotime($request->input("to")) ? $request->input("to") : $this->defaultTo;
        $to = strtotime($to) <= strtotime($from) ? $from : $to;
        $groupBy = $request->input("groupBy");
        if (!in_array($groupBy, ["year", "month"])) {
            $groupBy = "month";
        }

        $startDate = \Carbon\Carbon::parse($from);
        $endDate = \Carbon\Carbon::parse($to);
        $period = Period::create($startDate, $endDate);


        $result = Analytics::performQuery($period,
            "ga:sessions",
            [
                'sort' => $this->gaGrouping[$groupBy],
                'dimensions' => "ga:userType," . $this->gaGrouping[$groupBy]
            ]);

        if (is_null($result->rows)) {
            $result = new Collection([]);
            return response(["data" => $result, "from" => date("Y-m", strtotime($from)), "to" => date("Y-m", strtotime($to))], 200);
        }
        //print_r($result);die();
        $pagesData = [];
        foreach ($result->rows as $dateRow) {
            if ($groupBy == "week") {
                $tmp = getStartAndEndDate(substr($dateRow[1], 4), substr($dateRow[1], 0, 4));
                $tmp = $tmp[0];
            } elseif ($groupBy == "month") {
                $tmp = formatTimePeriod($groupBy, substr($dateRow[1], 4), substr($dateRow[1], 0, 4));
            } else {
                $tmp = $dateRow[1];
            }

            if (isset($pagesData[$tmp])) {
                $pagesData[$tmp][str_replace(" ", "", $dateRow[0])] = $dateRow[2];
            } else {
                $pagesData[$tmp] = ["periodName" => $tmp, "year" => substr($dateRow[1], 0, 4), "NewVisitor" => 0, "ReturningVisitor" => 0, str_replace(" ", "", $dateRow[0]) => $dateRow[2]];
            }
        }
        //return $pagesData;
        $result = $this->functionsArray[$groupBy](strtotime($from), strtotime($to), $pagesData, ["NewVisitor" => 0, "ReturningVisitor" => 0]);
        if ($request->ajax())
            return response(["data" => $result, "from" => date("Y-m", strtotime($from)), "to" => date("Y-m", strtotime($to))], 200);

        $allKeys = array('serial' => "Serial", 'periodName' => "Time Period", 'NewVisitor' => "New Visitor", "ReturningVisitor" => "Returning Visitor");

        $data = ["result" => $result, "filter" => ["Group By" => $groupBy, "From" => defaultNa($request->input("from")), "To" => defaultNa($request->input("to"))], "title" => "New Visitors vs Returning Visitors", "exportType" => $request->input("exportType"), "img" => $request->input("img"), "keys" => $allKeys, "generalInfo" => ["Total New Visitors" => array_sum(array_column($result, "NewVisitor")),
            "Total Returning Visitors" => array_sum(array_column($result, "ReturningVisitor"))]];

        $this->printingRender($request->input("export"), $data);
    }


    private function printingRender($exportType, $data)
    {

        if ($exportType == "pdf") {
            $this->exportPDF($data, "cp.reports.pdfReport", $data["title"]);
            exit();
        }

        if ($exportType == "excel") {
            $result = $data["result"];
            if (!is_array($result))
                $result = $result->toArray();

            $final = [];
            $counter = 0;
            $keys = $data["keys"];
            //echo '<pre>';print_r($data);die();
            foreach ($result as $item) {
                $final[$counter] = array_merge(array_flip(array_keys($data["keys"])), (is_array($item)) ? $item : $item->toArray());

                foreach ($final[$counter] as $mykey => $a) {
                    if (in_array($mykey, array_keys($keys))) {
                        $final[$counter][$keys[$mykey]] = $a;
                    }

                    if (!isset($keys[$mykey]) || $mykey != $keys[$mykey])
                        unset($final[$counter][$mykey]);
                }
                ++$counter;
            }
            $this->exportFile($data["title"], $final, "xlsx", $data["filter"]);
            exit();
        }

        if ($exportType == "print") {
            echo view("cp.reports.pdfReport", $data)->render();
        }

        return redirect(parent::$data['cp_route_name']);
    }

    public function visitorsView()
    {
        parent::$data['title'] = "Google Analytics Reports | Visitors View";
        parent::$data["breadcrumbs"]["Reports"] = "";
        parent::$data['active_menuPlus'] = 'visitorsView';
        parent::$data['active_menuPlus2'] = 'visitorsView';
        parent::$data['show_current_date'] = false;

        return view('cp.reports.visitors', parent::$data);
    }

    public function countryView()
    {
        parent::$data['title'] = "Google Analytics Reports | Country View";
        parent::$data["breadcrumbs"]["Reports"] = "";
        parent::$data['active_menuPlus'] = 'countryView';
        parent::$data['active_menuPlus2'] = 'countryView';
        parent::$data['show_current_date'] = false;
        return view('cp.reports.countryView', parent::$data);
    }

    public function mobileTrafficView()
    {
        parent::$data['title'] = "Google Analytics Reports | Mobile Traffic";
        parent::$data["breadcrumbs"]["Reports"] = "";
        parent::$data['active_menuPlus'] = 'mobileTrafficView';
        parent::$data['active_menuPlus2'] = 'mobileTrafficView';
        parent::$data['show_current_date'] = false;
        return view('cp.reports.mobileTrafficView', parent::$data);
    }

    public function browsersView()
    {
        parent::$data['title'] = "Google Analytics Reports | Browsers";
        parent::$data["breadcrumbs"]["Reports"] = "";
        parent::$data['active_menuPlus'] = 'browsersView';
        parent::$data['active_menuPlus2'] = 'browsersView';
        parent::$data['show_current_date'] = false;
        return view('cp.reports.browsers', parent::$data);
    }

    public function referrersView()
    {
        parent::$data['title'] = "Google Analytics Reports | Referrers View";
        parent::$data["breadcrumbs"]["Reports"] = "";
        parent::$data['active_menuPlus'] = 'referrersView';
        parent::$data['active_menuPlus2'] = 'referrersView';
        parent::$data['show_current_date'] = false;

        return view('cp.reports.referrers', parent::$data);
    }

    public function keywordsView()
    {
        parent::$data['title'] = "Google Analytics Reports | Keywords";
        parent::$data["breadcrumbs"]["Reports"] = "";
        parent::$data['active_menuPlus'] = 'keywordsView';
        parent::$data['active_menuPlus2'] = 'keywordsView';
        parent::$data['show_current_date'] = false;
        return view('cp.reports.keywords', parent::$data);
    }

    public function siteTimeView()
    {
        parent::$data['title'] = "Google Analytics Reports | Site Time";
        parent::$data["breadcrumbs"]["Reports"] = "";
        parent::$data['active_menuPlus'] = 'siteTimeView';
        parent::$data['active_menuPlus2'] = 'siteTimeView';
        parent::$data['show_current_date'] = false;
        return view('cp.reports.siteTimeView', parent::$data);
    }

    public function newVsReturningView()
    {
        parent::$data['title'] = "Google Analytics Reports | New Vs Returning";
        parent::$data["breadcrumbs"]["Reports"] = "";
        parent::$data['active_menuPlus'] = 'newVsReturningView';
        parent::$data['active_menuPlus2'] = 'newVsReturningView';
        parent::$data['show_current_date'] = false;
        return view('cp.reports.newVsReturningView', parent::$data);
    }

    public function mostVisitedView()
    {
        parent::$data['title'] = "Google Analytics Reports | Most Visited Pages";
        parent::$data["breadcrumbs"]["Reports"] = "";
        parent::$data['active_menuPlus'] = 'mostVisitedView';
        parent::$data['active_menuPlus2'] = 'mostVisitedView';
        return view('cp.reports.mostVisited', parent::$data);
    }

    public function saveChartImage(Request $request)
    {
        if ($request->input("img")) {
            $name = uniqid() . ".jpg";
            $this->saveBase64Image($request->input("img"), $name, "charts");
            return response(["status" => true, "name" => $name], 200);
        }

        return response(["status" => false, "message" => "No message sent!"], 200);
    }
}
