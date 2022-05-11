<?php

function compare_date($a, $b)
{
    $a_timestamp = strtotime(key($a)); // convert a (string) date/time to a (int) timestamp
    $b_timestamp = strtotime(key($a));
    // new feature in php 7
    return $a_timestamp <=> $b_timestamp;
}

function getLocalizedDate($time, $fullDate = false)
{
    if (strtolower(\Illuminate\Support\Facades\App::getLocale()) !== 'ar') {
        return date('l, d M Y - h:i A', $time);
    }
    $months = ["Jan" => "يناير", "Feb" => "فبراير", "Mar" => "مارس", "Apr" => "أبريل", "May" => "مايو", "Jun" => "يونيو", "Jul" => "يوليو", "Aug" => "أغسطس", "Sep" => "سبتمبر", "Oct" => "أكتوبر", "Nov" => "نوفمبر", "Dec" => "ديسمبر"];
    $days = ["Sat" => "السبت", "Sun" => "الأحد", "Mon" => "الاثنين", "Tue" => "الثلاثاء", "Wed" => "الأربعاء", "Thu" => "الخميس", "Fri" => "الجمعة"];
    $am_pm = ['AM' => 'صباحاً', 'PM' => 'مساءً'];

    $day = $days[date('D', $time)];
    $month = $months[date('M', $time)];
    $am_pm = $am_pm[date('A', $time)];

    if ($fullDate) {
        $date = $day . ', ' . date('d', $time) . ' ' . $month . ' - ' . date('Y', $time) . ', ' . date('h:i', $time) . ' ' . $am_pm;
    } else {
        $date = $day . ', ' . date('d', $time) . ' ' . $month . ' - ' . date('Y', $time);
    }
    $numbers_ar = ["٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩"];
    $numbers_en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    return str_replace($numbers_en, $numbers_ar, $date);
}

function generateNameInitials(string $name): string
{
    $words = explode(' ', $name);
    if (count($words) >= 2) {
        return strtoupper(substr($words[0], 0, 1) . substr(end($words), 0, 1));
    }
    return makeInitialsFromSingleWord($name);
}

function makeInitialsFromSingleWord(string $name): string
{
    preg_match_all('#([A-Z]+)#', $name, $capitals);
    if (count($capitals[1]) >= 2) {
        return substr(implode('', $capitals[1]), 0, 2);
    }
    return strtoupper(substr($name, 0, 2));
}

function application_last_updated()
{
    return date('F d Y', filemtime(base_path() . '/config/app.php'));
}

function linkify($value, $protocols = array('http', 'mail'), array $attributes = array())
{
    $attr = '';
    foreach ($attributes as $key => $val) {
        $attr .= ' ' . $key . '="' . htmlentities($val) . '"';
    }

    $links = array();

    $value = preg_replace_callback('~(<a .*?>.*?</a>|<.*?>)~i', function ($match) use (&$links) {
        return '<' . array_push($links, $match[1]) . '>';
    }, $value);

    foreach ((array)$protocols as $protocol) {
        switch ($protocol) {
            case 'http':
            case 'https':
                $value = preg_replace_callback('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) {
                    if ($match[1]) $protocol = $match[1];
                    $link = $match[2] ?: $match[3];
                    return '<' . array_push($links, "<a $attr href=\"$protocol://$link\">$link</a>") . '>';
                }, $value);
                break;
            case 'mail':
                $value = preg_replace_callback('~([^\s<]+?@[^\s<]+?\.[^\s<]+)(?<![\.,:])~', function ($match) use (&$links, $attr) {
                    return '<' . array_push($links, "<a $attr href=\"mailto:{$match[1]}\">{$match[1]}</a>") . '>';
                }, $value);
                break;
            case 'twitter':
                $value = preg_replace_callback('~(?<!\w)[@#](\w++)~', function ($match) use (&$links, $attr) {
                    return '<' . array_push($links, "<a $attr href=\"https://twitter.com/" . ($match[0][0] == '@' ? '' : 'search/%23') . $match[1] . "\">{$match[0]}</a>") . '>';
                }, $value);
                break;
            default:
                $value = preg_replace_callback('~' . preg_quote($protocol, '~') . '://([^\s<]+?)(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) {
                    return '<' . array_push($links, "<a $attr href=\"$protocol://{$match[1]}\">{$match[1]}</a>") . '>';
                }, $value);
                break;
        }
    }

    // Insert all link
    return preg_replace_callback('/<(\d+)>/', function ($match) use (&$links) {
        return $links[$match[1] - 1];
    }, $value);
}

function convertDateToMonth($dates)
{
    $months = [];
    foreach ($dates as $date) {
        if ($date && checkdate(substr($date, 5, 2), substr($date, 8, 2), substr($date, 0, 4))) {
            $months[] = substr($date, 0, 7);
        }
    }
    return $months;
}

function getMonthsBetweenTwoDates($start, $end)
{
    $start = (new DateTime($start))->modify('first day of this month');
    $end = (new DateTime($end))->modify('first day of next month');
    $interval = DateInterval::createFromDateString('1 month');
    $period = new DatePeriod($start, $interval, $end);
    $months = [];
    foreach ($period as $item) {
        $months[] = $item->format("Y - m");
    }

    return $months;
}

function getHoursBetweenTwoDates($startdate, $enddate)
{
    $starttimestamp = strtotime($startdate);
    $endtimestamp = strtotime($enddate);
    $difference = abs($endtimestamp - $starttimestamp) / 3600;
    return $difference;
}

function getDatesBetween($date1, $date2, $format = 'Y-m-d')
{
    $dates = array();
    $current = strtotime($date1);
    $date2 = strtotime($date2);
    $stepVal = '+1 day';
    while ($current <= $date2) {
        $dates[] = date($format, $current);
        $current = strtotime($stepVal, $current);
    }
    return $dates;
}

function escape_like($str)
{
    $temp = DB::getPdo()->quote($str);
    $temp = substr($temp, 1);
    $temp = substr($temp, 0, -1);
    return $temp;
}

function firstDay($from)
{
    $d = new DateTime($from);
    $d->modify('first sunday of this month');
    return $d->format('Y-m-d');
}

function lastDay($to)
{
    $d = new DateTime($to);
    $d->modify('last sunday of this month');
    $tmp = strtotime($d->format('Y-m-d') . " + 1 week - 1 day");
    return date('Y-m-d', $tmp);
}

function loadImage($fileName, $dest, $width = 0, $height = 0, $q = 50, $path = "", $zc = 1)
{
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

    if ($ext == 'webp')
        return url("uploads/" . $dest . "/" . $fileName);

    if (!$path)
        $path = url("uploads/" . $dest . "/" . $fileName);

    $result = url("") . "/thumb/timthumb.php?src=" . $path . "&zc=" . $zc . "&q=" . $q;

    if ($width)
        $result .= "&w=" . $width;
    if ($height)
        $result .= "&h=" . $height;

    return $result;
}

function hoursandmins($time, $format = '%02d:%02d')
{
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}

function defaultNa($var)
{
    return $var ? $var : "N / A";
}

function getTimeLeft($time, $lang = "en")
{
    $functionName = "getTimeLeft_" . $lang;
    if(!function_exists($functionName)){
        $functionName = "getTimeLeft_en";
    }
    return $functionName($time);
}

function getTimeLeft_en($ptime)
{
    $etime = time() - $ptime;
    if ($etime < 1) {
        //return '0 seconds';
        return 'Just now';
    }

    $a = array(365 * 24 * 60 * 60 => 'year',
        30 * 24 * 60 * 60 => 'month',
        24 * 60 * 60 => 'day',
        60 * 60 => 'hour',
        60 => 'minute',
        1 => 'second'
    );
    $a_plural = array('year' => 'years',
        'month' => 'months',
        'day' => 'days',
        'hour' => 'hours',
        'minute' => 'minutes',
        'second' => 'seconds'
    );

    foreach ($a as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
        }
    }
}

function getTimeLeft_ar($ptime)
{
    $etime = time() - $ptime;

    if ($etime < 1) {
        //  return '0 ثانية';
        return 'للتو';
    }

    $a = array(365 * 24 * 60 * 60 => 'سنة',
        30 * 24 * 60 * 60 => 'شهر',
        24 * 60 * 60 => 'يوم',
        60 * 60 => 'ساعة',
        60 => 'دقيقة',
        1 => 'ثانية'
    );

    foreach ($a as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return 'منذ ' . $r . ' ' . $str;
        }
    }
}

function setEmptyPeriodWeek($from, $to, $result, $default = [])
{
    if (!$result)
        return $result;

    $week = strftime(" % U", $from);
    $period = ceil(($to - $from) / 60 / 60 / 24 / 7);
    $year = date("Y", $from);
    if (!is_array($result)) {
        $result = $result->keyBy("periodName");
        $result = $result->toArray();
    }

    for ($i = 0; $i < $period; ++$i) {

        $target = str_pad(($i + $week) % 53, 2, '0', STR_PAD_LEFT);
        if ($target == "00") {
            $target = "01";
            ++$week;
        }

        $targetWeek = getStartAndEndDate($target, $year);
        $targetWeek = $targetWeek[0];

        if (date("Y", strtotime($targetWeek)) > $year) {
            ++$year;
            $targetWeek = getStartAndEndDate($target, $year);
            $targetWeek = $targetWeek[0];
        }

        if (!isset($result[$targetWeek])) {
            $result[$targetWeek] = array_merge(["year" => $year, "week" => $target, "period" => $target, "periodName" => $targetWeek, "serial" => ($i + 1)], $default);
        } else {
            $result[$targetWeek]["serial"] = $i + 1;
        }

        if ($target >= 52) {
            ++$year;
        }
    }


    ksort($result);
    return $result;
    return array_values($result);
}

function setEmptyPeriodMonth($from, $to, $result, $default = [])
{
    if (!$result)
        return $result;

    $month = date("m", $from);
    $from = strtotime(date('Y-m-01', $from));
    //echo date("Y - m - d",$from);die();

    $period = ceil(($to - $from) / 60 / 60 / 24 / 31);
    $year = date("Y", $from);
    if (!is_array($result)) {
        $result = $result->keyBy("periodName");
        $result = $result->toArray();
    }
    //echo date("Y - m - d",$to);die();
    //echo $period;die();
    for ($i = 0; $i < $period; ++$i) {
        $target = str_pad(($i + $month) % 12, 2, '0', STR_PAD_LEFT);
        if (!(int)$target)
            $target = 12;
        if (!isset($result[$year . '/' . $target])) {
            $result[$year . '/' . $target] = array_merge(["year" => $year, "month" => $target, "period" => $target, "periodName" => $year . '/' . $target, "serial" => $i + 1], $default);
        } else {
            $result[$year . '/' . $target]["serial"] = $i + 1;
        }

        if ($target >= 12) {
            ++$year;
        }
    }

    ksort($result);
    //return $result;
    return array_values($result);
}

function setEmptyPeriodQuarter($from, $to, $result, $default = [])
{
    if (!$result)
        return $result;

    $quarter = ceil(date("m", $from) / 3);
    $period = ceil(($to - $from) / 60 / 60 / 24 / 93);
    $year = date("Y", $from);

    if (!is_array($result)) {
        $result = $result->keyBy("periodName");
        $result = $result->toArray();
    }
    for ($i = 0; $i < $period; ++$i) {
        $target = str_pad(($i + $quarter) % 4, 2, '0', STR_PAD_LEFT);
        if (!$target)
            $target = 4;
        if (!isset($result[$year . '/' . $target])) {
            $result[$year . '/' . $target] = array_merge(["year" => $year, "quarter" => $target, "period" => $target, "periodName" => $year . '/' . $target, "serial" => $i + 1], $default);
        } else {
            $result[$year . '/' . $target]["serial"] = $i + 1;
        }

        if ($target >= 4) {
            ++$year;
        }
    }

    ksort($result);
    return array_values($result);
}

function setEmptyPeriodYear($from, $to, $result, $default = [])
{
    if (!$result)
        return $result;

    if (!is_array($result)) {
        $result = $result->keyBy("year");
        $result = $result->toArray();
    }

    $counter = 1;
    for ($i = date("Y", $from); $i <= date("Y", $to); ++$i) {
        if (!isset($result[$i])) {
            $result[$i] = array_merge(["year" => $i, "period" => $i, "periodName" => $i, "serial" => $counter], $default);
        } else {
            $result[$i]["serial"] = $counter;
        }
        ++$counter;
    }

    ksort($result);
    //return $result;
    return array_values($result);
}

function formatTimePeriod($type, $period, $year, $firstDay = '')
{
    $result = $period;
    if ($type == "quarter")
        $result = $year . '/' . $period;
    if ($type == "month")
        $result = $year . '/' . $period;
    if ($type == "week")
        $result = $firstDay;
    if ($type == "year")
        $result = $year;

    return $result;
}

function getStartAndEndDate($week, $year)
{

    $time = strtotime("1 January $year", time());
    $day = date('w', $time);
    $time += ((7 * $week) + 1 - $day) * 24 * 3600;
    $return[0] = date('Y-n-j', $time);
    $time += 6 * 24 * 3600;
    $return[1] = date('Y-n-j', $time);
    return $return;
}

// cUrl handler to ping the Sitemap submission URLs for Search Engines…
function myCurl($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $httpCode;
}

function getGoogleApiKey()
{
    return "AIzaSyBmi9g7Lus7Bkqdn0SXp0YpgKws4otICCk";
}


$GLOBALS['final'] = [];
$GLOBALS['array_depth'] = 0;
function compareTwoArray($old, $new, $prim = "", $parentNode = "")
{
    global $array_depth;
    global $final;
    $array_depth++;
    foreach ($old as $key => $value) {
        if ($key != $prim) {
            if (!is_array(json_decode(json_encode($value), true))) {

                //TODO: rename the key when depth is larger than 2!!
                $newKey = $parentNode ? ($key . '_' . $parentNode) : $key;
                $final[$newKey] = [
                    "old" => $value,
                    "new" => isset($new[$key]) ? $new[$key] : ""
                ];
            } else {
                compareTwoArray((array)$value, (array)$new[$key], $prim, $key);
            }
        }
    }
    return $final;
}

function hasOneChild($arr1, $actions)
{
    foreach ($actions as $subAction) {
        if (in_array($subAction->Action_ID, $arr1))
            return true;
    }

    return false;
}

function getPlace($place_id, $lang = 'en')
{
    $request = "https://maps.googleapis.com/maps/api/geocode/json?place_id=$place_id&key=" . getGoogleApiKey() . "&language=" . $lang;
    $result = json_decode(@file_get_contents($request, false, sslStream()), false);


    //if (isset($result->results[0]->formatted_address)) {
    //    return $result->results[0]->formatted_address;
    if (isset($result->results[0]->address_components[0])) {
        return $result->results[0]->address_components[0]->long_name;
    } else {
        return "";
    }
}

function sslStream()
{
    $arrContextOptions = array(
        "ssl" => array(
            "verify_peer" => false,
            "verify_peer_name" => false,
        ),
    );

    return stream_context_create($arrContextOptions);
}

function clean($string)
{
    $string = str_replace(' ', '-', trim($string)); // Replaces all spaces with hyphens.

    //$string = preg_replace("/[^A-Za-z0-9_\s-ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]#u/", "", $string);
    $string = preg_replace("/[^A-Za-z0-9_\s-ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]/u", "", $string);

    // Remove multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);

    // Convert whitespaces and underscore to the given separator
    $string = preg_replace("/[\s_]/", '-', $string);

    //return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

    return $string;
}

function getPlaceObject($place_id, $lang = 'en')
{
    $request = "https://maps.googleapis.com/maps/api/geocode/json?place_id=$place_id&key=" . getGoogleApiKey() . "&language=" . $lang;
    $result = json_decode(@file_get_contents($request, false, sslStream()), false);

    if (isset($result->results[0])) {
        return $result->results[0];
    } else {
        return "";
    }
}

function getPlaceAll($place_id, $lang = 'en')
{
    $request = "https://maps.googleapis.com/maps/api/geocode/json?place_id=$place_id&key=" . getGoogleApiKey() . "&language=" . $lang;
    $result = json_decode(@file_get_contents($request, false, sslStream()), false);
    return $result;
}

function getNumber($number)
{
    if ($number < 1000)
        return $number;

    if ($number < 1000000)
        return ($number / 1000) . "." . ($number % 1000) . " K";

    return ($number / 1000000) . "." . ($number % 1000000) . " M";
}

function partition(array $list, $p)
{
    $listlen = count($list);
    $partlen = floor($listlen / $p);
    $partrem = $listlen % $p;
    $partition = array();
    $mark = 0;
    for ($px = 0; $px < $p; $px++) {
        $incr = ($px < $partrem) ? $partlen + 1 : $partlen;
        $partition[$px] = array_slice($list, $mark, $incr);
        $mark += $incr;
    }
    return $partition;
}

function encode_php_tags($str)
{
    return str_replace(array('<?php', '<?PHP', '<?', '?>'), array('&lt;?php', '&lt;?PHP', '&lt;?', '?&gt;'), $str);
}

function strip_image_tags($str)
{
    $str = preg_replace("#<img\s+.*?src\s*=\s*[\"'](.+?)[\"'].*?\>#", "\\1", $str);
    $str = preg_replace("#<img\s+.*?src\s*=\s*(.+?).*?\>#", "\\1", $str);

    return $str;
}

function generateBreadcrumbs($arr)
{
    $result = '';
    foreach ($arr as $key => $value) {
        if ($value)
            $result .= '<a href="' . $value . '" class="kt-subheader__breadcrumbs-link">' . $key . '</a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>';
        else
            $result .= '<a  class="kt-subheader__breadcrumbs-link">' . $key . '</a>';
    }

    return $result;
}

function generateToken($size = 10)
{
    // return md5(rand(1, $size) . microtime());
    return Str::random($size) . round(microtime(true));
}


// for xx clean
/**
 * XSS Clean
 *
 * **************************************************************
 * *********** This function and other functions that it uses
 * *********** are taken from Codeigniter 2.1.3 and modified
 * *********** them to our needs. In turn, I have taken this from
 * *********** JasonMortonNZ.
 ***************************************************************
 *
 *
 * Sanitizes data so that Cross Site Scripting Hacks can be
 * prevented.  This function does a fair amount of work but
 * it is extremely thorough, designed to prevent even the
 * most obscure XSS attempts.  Nothing is ever 100% foolproof,
 * of course, but I haven't been able to get anything passed
 * the filter .
 *
 * Note: This function should only be used to deal with data
 * upon submission . It's not something that should
 * be used for general runtime processing.
 *
 * This function was based in part on some code and ideas I
 * got from Bitflux: http://channel.bitflux.ch/wiki/XSS_Prevention
 *
 * To help develop this script I used this great list of
 * vulnerabilities along with a few other hacks I've
 * harvested from examining vulnerabilities in other programs:
 * http://ha.ckers.org/xss.html
 *
 * @param mixed   string or array
 * @param bool
 * @return string
 */
function xss_clean($str, $is_image = FALSE)
{
    /*
     * Is the string an array?
     *
     */
    if (is_array($str)) {
        while (list($key) = each($str)) {
            $str[$key] = xss_clean($str[$key]);
        }
        return $str;
    }

    // trim string
    $str = trim($str);

    // strip tags
    $str = strip_tags($str);
    /*
     * Remove Invisible Characters
     */
    $str = remove_invisible_characters($str);
    // Validate Entities in URLs
    $str = validate_entities($str);
    /*
     * URL Decode
     *
     * Just in case stuff like this is submitted:
     *
     * <a href="http://%77%77%77%2E%67%6F%6F%67%6C%65%2E%63%6F%6D">Google</a>
     *
     * Note: Use rawurldecode() so it does not remove plus signs
     *
     */
    $str = rawurldecode($str);
    /*
     * Convert character entities to ASCII
     *
     * This permits our tests below to work reliably.
     * We only convert entities that are within tags since
     * these are the ones that will pose security problems.
     *
     */
    $str = preg_replace_callback("/[a-z]+=([\'\"]).*?\\1/si", function ($match) {
        return str_replace(array('>', '<', '\\'), array('&gt;', '&lt;', '\\\\'), $match[0]);
    }, $str);
    $str = preg_replace_callback("/<\w+.*?(?=>|<|$)/si", 'entity_decode', $str);
    /*
     * Remove Invisible Characters Again!
     */
    $str = remove_invisible_characters($str);
    /*
     * Convert all tabs to spaces
     *
     * This prevents strings like this: ja  vascript
     * NOTE: we deal with spaces between characters later.
     * NOTE: preg_replace was found to be amazingly slow here on
     * large blocks of data, so we use str_replace.
     */
    if (strpos($str, "\t") !== FALSE) {
        $str = str_replace("\t", ' ', $str);
    }
    /*
     * Capture converted string for later comparison
     */
    $converted_string = $str;
    // Remove Strings that are never allowed
    $str = do_never_allowed($str);
    /*
     * Makes PHP tags safe
     *
     * Note: XML tags are inadvertently replaced too:
     *
     * <?xml
     *
     * But it doesn't seem to pose a problem.
     */
    if ($is_image === TRUE) {
        // Images have a tendency to have the PHP short opening and
        // closing tags every so often so we skip those and only
        // do the long opening tags.
        $str = preg_replace('/<\?(php)/i', "&lt;?\\1", $str);
    } else {
        $str = str_replace(array('<?', '?' . '>'), array('&lt;?', '?&gt;'), $str);
    }
    /*
     * Compact any exploded words
     *
     * This corrects words like:  j a v a s c r i p t
     * These words are compacted back to their correct state.
     */
    $words = array(
        'javascript', 'expression', 'vbscript', 'script', 'base64',
        'applet', 'alert', 'document', 'write', 'cookie', 'window'
    );
    foreach ($words as $word) {
        $temp = '';
        for ($i = 0, $wordlen = strlen($word); $i < $wordlen; $i++) {
            $temp .= substr($word, $i, 1) . "\s*";
        }
        // We only want to do this when it is followed by a non-word character
        // That way valid stuff like "dealer to" does not become "dealerto"
        $str = preg_replace_callback('#(' . substr($temp, 0, -3) . ')(\W)#is', function ($matches) {
            return preg_replace('/\s+/s', '', $matches[1]) . $matches[2];
        }, $str);
    }
    /*
     * Remove disallowed Javascript in links or img tags
     * We used to do some version comparisons and use of stripos for PHP5,
     * but it is dog slow compared to these simplified non-capturing
     * preg_match(), especially if the pattern exists in the string
     */
    do {
        $original = $str;
        if (preg_match("/<a/i", $str)) {
            $str = preg_replace_callback("#<a\s+([^>]*?)(>|$)#si", function ($match) {
                return str_replace(
                    $match[1],
                    preg_replace(
                        '#href=.*?(alert\(|alert&\#40;|javascript\:|livescript\:|mocha\:|charset\=|window\.|document\.|\.cookie|<script|<xss|data\s*:)#si',
                        '',
                        filter_attributes(str_replace(array('<', '>'), '', $match[1]))
                    ),
                    $match[0]
                );
            }, $str);
        }
        if (preg_match("/<img/i", $str)) {
            $str = preg_replace_callback("#<img\s+([^>]*?)(\s?/?>|$)#si", function ($match) {
                return str_replace(
                    $match[1],
                    preg_replace(
                        '#src=.*?(alert\(|alert&\#40;|javascript\:|livescript\:|mocha\:|charset\=|window\.|document\.|\.cookie|<script|<xss|base64\s*,)#si',
                        '',
                        filter_attributes(str_replace(array('<', '>'), '', $match[1]))
                    ),
                    $match[0]
                );
            }, $str);
        }
        if (preg_match("/script/i", $str) or preg_match("/xss/i", $str)) {
            $str = preg_replace("#<(/*)(script|xss)(.*?)\>#si", '', $str);
        }
    } while ($original != $str);
    unset($original);
    // Remove evil attributes such as style, onclick and xmlns
    $str = remove_evil_attributes($str, $is_image);
    /*
     * Sanitize naughty HTML elements
     *
     * If a tag containing any of the words in the list
     * below is found, the tag gets converted to entities.
     *
     * So this: <blink>
     * Becomes: &lt;blink&gt;
     */
    $naughty = 'alert|applet|audio|basefont|base|behavior|bgsound|blink|body|embed|expression|form|frameset|frame|head|html|ilayer|iframe|input|isindex|layer|link|meta|object|plaintext|style|script|textarea|title|video|xml|xss';
    $str = preg_replace_callback('#<(/*\s*)(' . $naughty . ')([^><]*)([><]*)#is', function ($matches) {
        // encode opening brace
        $str = '&lt;' . $matches[1] . $matches[2] . $matches[3];
        // encode captured opening or closing brace to prevent recursive vectors
        return $str .= str_replace(array('>', '<'), array('&gt;', '&lt;'), $matches[4]);
    }, $str);
    /*
     * Sanitize naughty scripting elements
     *
     * Similar to above, only instead of looking for
     * tags it looks for PHP and JavaScript commands
     * that are disallowed.  Rather than removing the
     * code, it simply converts the parenthesis to entities
     * rendering the code un-executable.
     *
     * For example: eval('some code')
     * Becomes:     eval&#40;'some code'&#41;
     */
    $str = preg_replace('#(alert|cmd|passthru|eval|exec|expression|system|fopen|fsockopen|file|file_get_contents|readfile|unlink)(\s*)\((.*?)\)#si', "\\1\\2&#40;\\3&#41;", $str);
    // Final clean up
    // This adds a bit of extra precaution in case
    // something got through the above filters
    $str = do_never_allowed($str);
    /*
     * Images are Handled in a Special Way
     * - Essentially, we want to know that after all of the character
     * conversion is done whether any unwanted, likely XSS, code was found.
     * If not, we return TRUE, as the image is clean.
     * However, if the string post-conversion does not matched the
     * string post-removal of XSS, then it fails, as there was unwanted XSS
     * code found and removed/changed during processing.
     */
    if ($is_image === TRUE) {
        return ($str == $converted_string) ? TRUE : FALSE;
    }
    return $str;
}//xss_clean
/**
 * Remove Invisible Characters
 *
 * This prevents sandwiching null characters
 * between ascii characters, like Java\0script.
 *
 * @access  public
 * @param string
 * @return  string
 */
function remove_invisible_characters($str, $url_encoded = TRUE)
{
    $non_displayables = array();
    // every control character except newline (dec 10)
    // carriage return (dec 13), and horizontal tab (dec 09)
    if ($url_encoded) {
        $non_displayables[] = '/%0[0-8bcef]/';  // url encoded 00-08, 11, 12, 14, 15
        $non_displayables[] = '/%1[0-9a-f]/';   // url encoded 16-31
    }
    $non_displayables[] = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';   // 00-08, 11, 12, 14-31, 127
    do {
        $str = preg_replace($non_displayables, '', $str, -1, $count);
    } while ($count);
    return $str;
}//remove_invisible_characters
/**
 * Validate URL entities
 *
 * Called by xss_clean()
 *
 * @param string
 * @return  string
 */
function validate_entities($str)
{
    /*
     * Protect GET variables in URLs
     */
    $xss_hash = md5(time() + mt_rand(0, 1999999999));
    $str = preg_replace('|\&([a-z\_0-9\-]+)\=([a-z\_0-9\-]+)|i', $xss_hash . "\\1=\\2", $str);
    /*
     * Validate standard character entities
     *
     * Add a semicolon if missing.  We do this to enable
     * the conversion of entities to ASCII later.
     *
     */
    $str = preg_replace('#(&\#?[0-9a-z]{2,})([\x00-\x20])*;?#i', "\\1;\\2", $str);
    /*
     * Validate UTF16 two byte encoding (x00)
     *
     * Just as above, adds a semicolon if missing.
     *
     */
    $str = preg_replace('#(&\#x?)([0-9A-F]+);?#i', "\\1\\2;", $str);
    /*
     * Un-Protect GET variables in URLs
     */
    $str = str_replace($xss_hash, '&', $str);
    return $str;
}//validate_entities
/**
 * Do Never Allowed
 *
 * A utility function for xss_clean()
 *
 * @param string
 * @return  string
 */
function do_never_allowed($str)
{
    /**
     * List of never allowed strings
     */
    $never_allowed_str = array(
        'document.cookie' => '',
        'document.write' => '',
        '.parentNode' => '',
        '.innerHTML' => '',
        'window.location' => '',
        '-moz-binding' => '',
        '<!--' => '&lt;!--',
        '-->' => '--&gt;',
        '<![CDATA[' => '&lt;![CDATA[',
        '<comment>' => '&lt;comment&gt;'
    );
    /**
     * List of never allowed regex replacement
     */
    $never_allowed_regex = array(
        'javascript\s*:',
        'expression\s*(\(|&\#40;)', // CSS and IE
        'vbscript\s*:', // IE, surprise!
        'Redirect\s+302',
        "([\"'])?data\s*:[^\\1]*?base64[^\\1]*?,[^\\1]*?\\1?"
    );
    $str = str_replace(array_keys($never_allowed_str), $never_allowed_str, $str);
    foreach ($never_allowed_regex as $regex) {
        $str = preg_replace('#' . $regex . '#is', '', $str);
    }
    return $str;
}//do_never_allowed
/*
 * Remove Evil HTML Attributes (like evenhandlers and style)
 *
 * It removes the evil attribute and either:
 *  - Everything up until a space
 *      For example, everything between the pipes:
 *      <a |style=document.write('hello');alert('world');| class=link>
 *  - Everything inside the quotes
 *      For example, everything between the pipes:
 *      <a |style="document.write('hello'); alert('world');"| class="link">
 *
 * @param string $str The string to check
 * @param boolean $is_image TRUE if this is an image
 * @return string The string with the evil attributes removed
 */
function remove_evil_attributes($str, $is_image)
{
    // All javascript event handlers (e.g. onload, onclick, onmouseover), style, and xmlns
    $evil_attributes = array('on\w*', 'style', 'xmlns', 'formaction');
    if ($is_image === TRUE) {
        /*
         * Adobe Photoshop puts XML metadata into JFIF images,
         * including namespacing, so we have to allow this for images.
         */
        unset($evil_attributes[array_search('xmlns', $evil_attributes)]);
    }
    do {
        $count = 0;
        $attribs = array();
        // find occurrences of illegal attribute strings without quotes
        preg_match_all('/(' . implode('|', $evil_attributes) . ')\s*=\s*([^\s>]*)/is', $str, $matches, PREG_SET_ORDER);
        foreach ($matches as $attr) {
            $attribs[] = preg_quote($attr[0], '/');
        }
        // find occurrences of illegal attribute strings with quotes (042 and 047 are octal quotes)
        preg_match_all("/(" . implode('|', $evil_attributes) . ")\s*=\s*(\042|\047)([^\\2]*?)(\\2)/is", $str, $matches, PREG_SET_ORDER);
        foreach ($matches as $attr) {
            $attribs[] = preg_quote($attr[0], '/');
        }
        // replace illegal attribute strings that are inside an html tag
        if (count($attribs) > 0) {
            $str = preg_replace("/<(\/?[^><]+?)([^A-Za-z<>\-])(.*?)(" . implode('|', $attribs) . ")(.*?)([\s><])([><]*)/i", '<$1 $3$5$6$7', $str, -1, $count);
        }
    } while ($count);
    return $str;
}//remove_evil_attributes
/**
 * HTML Entities Decode
 *
 * This function is a replacement for html_entity_decode()
 *
 * The reason we are not using html_entity_decode() by itself is because
 * while it is not technically correct to leave out the semicolon
 * at the end of an entity most browsers will still interpret the entity
 * correctly.  html_entity_decode() does not convert entities without
 * semicolons, so we are left with our own little solution here. Bummer.
 *
 * @param string
 * @param string
 * @return  string
 */
function entity_decode($arr, $charset = 'UTF-8')
{
    $str = $arr[0];
    if (stristr($str, '&') === FALSE) {
        return $str;
    }
    $str = html_entity_decode($str, ENT_COMPAT, $charset);
    $str = preg_replace_callback('~&#x(0*[0-9a-f]{2,5})~i', create_function('$matches', 'return chr(hexdec($matches[1]));'), $str);
    return preg_replace_callback('~&#([0-9]{2,4})~', create_function('$matches', 'return chr($matches[1]);'), $str);
}//entity_decode
/**
 * Filter Attributes
 *
 * Filters tag attributes for consistency and safety
 *
 * @param string
 * @return  string
 */
function filter_attributes($str)
{
    $out = '';
    if (preg_match_all('#\s*[a-z\-]+\s*=\s*(\042|\047)([^\\1]*?)\\1#is', $str, $matches)) {
        foreach ($matches[0] as $match) {
            $out .= preg_replace("#/\*.*?\*/#s", '', $match);
        }
    }
    return $out;
}//filter_attributes
