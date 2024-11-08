<?php
function slug( $string ){
    $string = preg_replace('/[^A-Za-z0-9\-_ ]/', '', $string); // Replaces all spaces with hyphens.
    return strtolower(str_replace(' ', '_', $string)); // Removes special chars.
}


function time_to_timestamp( $time ){
	return strtotime($time);
}

function date_to_datestamp( $date ){
	return strtotime($date);
}

function timestamp_to_time( $timestamp ){
    return (!empty($timestamp)) ? date('h:i:s A', $timestamp) : "";
}

function file_get_contents_ssl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3000); // 3 sec.
    curl_setopt($ch, CURLOPT_TIMEOUT, 10000); // 10 sec.
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function file_get_contents_ssl_with_type($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3000); // 3 sec.
    curl_setopt($ch, CURLOPT_TIMEOUT, 10000); // 10 sec.
    $result = curl_exec($ch);
    $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);  //get content type
    curl_close($ch);
    return [$contentType, $result];
}

function pick_desired_image($url, $type)
{
    $file_with_info = file_get_contents_ssl_with_type($url);

    $img_file = $file_with_info[1];

    $filetype = $file_with_info[0];

    if($filetype === $type)
    {
        return $img_file;
    }else
    {
        return false;
    }
}

function timestamp_to_hours( $timestamp ){
    return (!empty($timestamp)) ? date('H:i:s', $timestamp) : "";
}

function datestamp_to_date( $datestamp ){
    return (!empty($datestamp)) ? date('Y-m-d', $datestamp) : "";
}

function datetime_format( $datetime ){
    return date('Y-m-d h:i:s A', strtotime($datetime));
}

function calculate_total_hour_minute_second($hours_minutes, $timestamp_array = false){
    $hour = 0;
    $minute = 0;
    $second = 0;
    if (!empty($hours_minutes)) {
        foreach($hours_minutes as $hours_minute_second){
            if( $timestamp_array ){
                $hours_minute_second = date('H:i:s', $hours_minute_second);
            }
            $hours_minutes_ext = explode(":", $hours_minute_second);
            $hour += $hours_minutes_ext[0];
            $minute += $hours_minutes_ext[1];
            $second += $hours_minutes_ext[2];
        }
        $hour = $hour * 60*60;
        $minute = $minute * 60;
        $seconds = $second + $minute+ $hour;
        return ( (int)($seconds / 3600) .':'. (int)(($seconds % 3600) / 60) .':'. (int)(($seconds % 3600) % 60));
    }
    return false;
}


function per_day_worked_have_done_from_hour_minute_second($hours_minute_second, $number_of_days, $timestamp_array = false){
    $hour = 0;
    $minute = 0;
    $second = 0;
    if (!empty($hours_minute_second)) {
    if( ! $timestamp_array ){
        $hours_minutes_ext = explode(":", $hours_minute_second);
        $hour += $hours_minutes_ext[0];
        $minute += $hours_minutes_ext[1];
        $second += $hours_minutes_ext[2];
        $hour = $hour * 60*60;
        $minute = $minute * 60;
        $seconds = $second + $minute+ $hour;
    }
    else {
        $seconds = $hours_minute_second;
    }
    $seconds = (int)($seconds / $number_of_days);
    return ( (int) ($seconds / 3600) .':'. (int)(($seconds % 3600) / 60) .':'. (int)(($seconds % 3600) % 60));
    }
    return false;

}

function getSystemSettingValue($key){

    $setting = \App\Models\SystemSetting::where('key',$key)->first();
    if( ! $setting)
        throw new Exception('No Setting Value Found! By using Key:' . $key);
    return $setting->value;
}

function checkPermissionArray($routes_array, $permissions_array )
{
    $count = count($permissions_array);
    foreach ($permissions_array as $key => $value) {
        if (in_array($value, $routes_array)) {
            $count = ($count - 1);
        }
    }
    return ($count == 0) ? true : false;
}


function isSuperAdmin()
{
  return true;
}

function isAdmin()
{
  return true;
}


/**
*   get All Route Names as Array
*/
function getAllRouteNameAsArray()
{

    $routes = Illuminate\Support\Facades\Route::getRoutes();

    $routeNames = collect($routes)->map(function ($route) {
        return $route->getName();
    })->filter()->toArray();

   return $routeNames;

// 	static $routeNames = [];

//     if (count($routeNames)) {
//         return $routeNames;
//     }
// //dd(Route::getRoutes());
// 	$avoidableMiddlewares = ['token.auth', 'CommonAccessMiddleware'];

// 	foreach (Route::getRoutes() as $key=>$route){
// 		$as = $route['action']['as']??'';
// 		if ( $as == "") continue;
// 		$middlewares = $route['action']['middleware']??'';
// 		if (is_array($middlewares)) {
// 			foreach ($middlewares as $key => $value) {
// 				if (!in_array($value, $avoidableMiddlewares) && !in_array($as, $routeNames)) {
// 					$routeNames[] =  $as;
// 				}
// 			}
// 		}
// 	}

// 	return $routeNames;
}

/**
*   route those has no need permission to access
*/
function getAllLogedinUserCanAccessRouteNameAsArray()
{
    $routeNames = [];

  $avoidableMiddlewares = ['CommonAccessMiddleware'];

    return $routeNames;    

    $routeNames = [];

	$avoidableMiddlewares = [ 'CommonAccessMiddleware'];

	foreach (Illuminate\Support\Facades\Route::getRoutes() as $key=>$route){
		$as = $route['action']['as']??'';
		if ( $as == "") continue;
		$middlewares = $route['action']['middleware']??'';
		if (is_array($middlewares)) {
			foreach ($middlewares as $key => $value) {
				if (in_array($value, $avoidableMiddlewares) && !in_array($as, $routeNames)) {
					$routeNames[] =  $as;
				}
			}
		}
	}

	return $routeNames;
}

function integerToRoman($integer)
{
    // Convert the integer into an integer (just to make sure)
    $integer = intval($integer);
    $result = '';

    // Create a lookup array that contains all of the Roman numerals.
    $lookup = array('M' => 1000,
        'CM' => 900,
        'D' => 500,
        'CD' => 400,
        'C' => 100,
        'XC' => 90,
        'L' => 50,
        'XL' => 40,
        'X' => 10,
        'IX' => 9,
        'V' => 5,
        'IV' => 4,
        'I' => 1);

    foreach($lookup as $roman => $value){
        // Determine the number of matches
        $matches = intval($integer/$value);

        // Add the same number of characters to the string
        $result .= str_repeat($roman,$matches);

        // Set the integer to be the remainder of the integer and the value
        $integer = $integer % $value;
    }

    // The Roman numeral should be built, return it
    return $result;
}

/*
200
--- response true with return data

404
--- not found

201
--- if request create with return data

204
--- delete request with no return data

400
--- if request failed or insert failed or return empty data


use Illuminate\Support\Facades\DB;
try {
    DB::beginTransaction();

    DB::commit();
} catch (\PDOException $e) {
    DB::rollBack();
}

*/
/*
200 OK
201 Created
202 Accepted
204 No Content
205 Reset Content

301 Moved Permanently
302 Found
304 Not Modified
307 Temporary Redirect
308 Permanent Redirect (experimental)

400 Bad Request
401 Unauthorized
403 Forbidden
404 Not Found
405 Method Not Allowed
406 Not Acceptable
408 Request Timeout
409 Conflict
415 Unsupported Media Type
423 Locked

500 Internal Server Error
*/

/*
3950597, 3660152, // fixed attendance it mesbaul
11883157, 5514988 // flexible
*/
?>
