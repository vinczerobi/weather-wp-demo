<h2>openweathermap beállítások</h2>
<form method="post" id="poststuff">
	API kulcs: <input type="text" name="openweathermap_apikey" size="30" value="<?php echo $GLOBALS['openweathermap_apikey']; ?>">
	<input type="submit" name="submit" class="button button-primary">
</form>
<?php

/*
ha van api kulcs megadva, akkor lekérjük a lakóhely szerinti aktuális időjárás adatokat - 3-as feladatpont szerint
php oldalon ennek menete:
1. fogjuk az ip címet
2. http://ip-api.com/json/94.21.82.92
3. ebből megkapjuk a város nevét, lat, lon-t
4. a kordinátákkal lekérdezzük az időjárási adatokat openweathermap-ről

*/
if($GLOBALS['openweathermap_apikey']) {
	$location_data = locate_by_ip();
	$weather       = get_weather_by_cord($location_data['lat'], $location_data['lon']);
	$rendered      = render_weather($weather);
	echo '<h2>'.$location_data['city'].' időjárása</h2>';
	echo $rendered;
}
