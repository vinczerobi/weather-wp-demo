<?php
/**
 * openweathermap widget
 *
 * @package
 * @author VR
 * @copyright Copyright (c) 2024
 * @version $Id$
 * @access public
 */
class Weather_Widget extends WP_Widget {
	/**
	 * Weather_Widget::Weather_Widget()
	 *
	 */
	function __construct() {
		$widget_ops = array('classname' => '', 'description' => 'openweathermap api alapon.');
		parent::__construct(false, $name = "Időjárás Widget", $widget_ops);
	}

	/**
	 * Weather_Widget::widget()
	 *
	 * @param mixed $args
	 * @param mixed $instance
	 * @return
	 */
	function widget($args,$instance) {
		$city = apply_filters('widget_title', empty($instance['city']) ? '' : $instance['city'], $instance, $this->id_base);

		if(empty($city)) {
			$location_data = locate_by_ip();
			$city = $location_data['city'];
		}

		else {
			$apikey   = (string)get_option('openweathermap_apikey');
			$url      = "http://api.openweathermap.org/geo/1.0/direct?q={$city}&limit=1&appid=".$apikey;
			$response = wp_remote_get($url);
			$geocode  = wp_remote_retrieve_body( $response );
			$location_data = json_decode($geocode, true)[0];
		}

		$weather  = get_weather_by_cord($location_data['lat'], $location_data['lon']);
		$rendered = render_weather($weather);
		echo '<h2>'.$city.' időjárása</h2>';
		echo $rendered;
	}

	/**
	 * Weather_Widget::update()
	 *
	 * @param mixed $new_instance
	 * @param mixed $old_instance
	 * @return
	 */
	function update($new_instance,$old_instance) {
		$instance = $old_instance;
		$instance['city'] = strip_tags($new_instance['city']);
		return $instance;
	}

	/**
	 * Weather_Widget::form()
	 *
	 * @param mixed $instance
	 * @return
	 */
	function form($instance) {
		$instance    = wp_parse_args((array)$instance, array('city' => ''));
		$city        = strip_tags($instance['city']);		// a mező értéke
		$nameFieldId = $this->get_field_id("city");
		?>
		<p>
			<label for="<?php echo $nameFieldId; ?>">Város</label>
			<input type="text" class="widefat" name="<?php echo $this->get_field_name('city'); ?>" id="<?php echo $nameFieldId; ?>" value="<?php echo $city; ?>"/>
			<i>Üres mező esetén pozíció szerinti adatok jelennek meg</i>
		</p>
		<?php
	}
}
