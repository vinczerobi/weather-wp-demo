<?php
/*
Plugin Name: openweathermap demo
Plugin URI:  
Description: Demonstrates how to use openweathermap api and create wp widget
Version:     1.0
Author:      Vincze Róbert
Author URI:  http://example.com
*/


add_action('init', function() {
    add_rewrite_rule(
        '^city/([^/]*)/?', 				// a 'city/{lakohelyed_neve}' mintázat
        'index.php?city=$matches[1]',	// a 'city' változó beállítása a lekérdezésben
        'top' 							// a szabály helye
    );
});


if(is_admin()) {
	if(!empty($_POST['openweathermap_apikey'])) {
		$openweathermap_apikey = $_POST['openweathermap_apikey'];
		update_option('openweathermap_apikey', $openweathermap_apikey);
	} else {
		$openweathermap_apikey = (string)get_option('openweathermap_apikey');
	}
	$GLOBALS['openweathermap_apikey'] = $openweathermap_apikey;			// osztály tulajdonsággal elegánsabb lenne

	add_action('admin_menu', function() {
		add_submenu_page('options-general.php', 'openweathermap beállítások', 'openweathermap beállítások', 'administrator', 'openweathermap', 'openweathermap_settings');
	});

	function openweathermap_settings() {
		include 'settings.php';
	}
}

else {		// publikus felületen vagyunk

	add_filter('query_vars', function() {
	    $vars[] = 'city'; // regisztráljuk a 'city' változót
	    return $vars;
	});

	add_action('template_redirect', function() {
	    // Ellenőrizzük, hogy a 'city' változó létezik-e
	    if (get_query_var('city')) {
	        $city = get_query_var('city'); // a 'city' változó értéke

			if(empty($GLOBALS['openweathermap_apikey'])) {
				$GLOBALS['openweathermap_apikey'] = (string)get_option('openweathermap_apikey');
			}

			$url = "http://api.openweathermap.org/geo/1.0/direct?q={$city}&limit=1&appid=".$GLOBALS['openweathermap_apikey'];
			$response = wp_remote_get($url);
			$geocode  = wp_remote_retrieve_body( $response );
			$geo      = json_decode($geocode, true)[0];
			$weather  = get_weather_by_cord($geo['lat'], $geo['lon']);
			$rendered = render_weather($weather);
			echo '<h2>'.$city.' időjárása</h2>';
			echo $rendered;

	        exit; // Megállítjuk a további WordPress betöltést
	    }

	});

}


/**
 * IP cím alapján betájoljuk a látogatót
 *
 * @param -
 * @return array ['city', 'lat', 'lon'].
 */
function locate_by_ip() {
# külső apival kérjük az ip címünket hogy localban is működjön
	$response   = wp_remote_get("https://api.ipify.org");
	$ip_address = wp_remote_retrieve_body( $response );

# ip cím alapján város, lat, lon
	$response   = wp_remote_get("http://ip-api.com/json/{$ip_address}");
	$mylocation = wp_remote_retrieve_body( $response );

	$location_data = json_decode($mylocation, true);
	return $location_data;
}


/**
 * Kordináták alapján lekérjük az időjárás adatokat. Az egyszerűség kedvéért most csak az aktuálisakat
 *
 * @param int lat, lon.
 * @return array.
 */
function get_weather_by_cord($lat, $lon) {
	$url = "https://api.openweathermap.org/data/3.0/onecall?lat={$lat}&lon={$lon}&exclude=minutely,hourly,daily,alerts&lang=hu&units=metric&appid=".$GLOBALS['openweathermap_apikey'];
	$response = wp_remote_get($url);
	$weather  = wp_remote_retrieve_body( $response );
	return json_decode($weather, true);;
}


/**
 * Megjeleníthetővé tesszük a lekért időjárás adatokat
 *
 * @param json weather.
 * @return html.
 */
function render_weather($weather) {
	$ret = '';
	$c = $weather['current'];
	$ret .= '<img src="https://openweathermap.org/img/wn/'.$c['weather'][0]['icon'].'@2x.png" style="background-color:white; border:1px solid black; margin-right:10px; float:left;">';
	$ret .= 'Napkelte: '.date('Y-m-d H:i',$c['sunrise']);
	$ret .= '<br>Napnyugta: '.date('Y-m-d H:i',$c['sunset']);
	$ret .= '<br>Hőmérséklet: '.$c['temp'].' ˚C';
	$ret .= '<br>Nyomás: '.$c['pressure'];
	$ret .= '<br>Szél: '.$c['wind_speed'];

	return $ret;
}
