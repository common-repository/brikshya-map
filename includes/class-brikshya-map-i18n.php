<?php
defined('ABSPATH') or die('No script kiddies please!');
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://brikshya.com/
 * @since      1.0.0
 *
 * @package    Brikshya_Map
 * @subpackage Brikshya_Map/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Brikshya_Map
 * @subpackage Brikshya_Map/includes
 * @author     Brikshya Technologies <brikshya.technologie>
 */
class Brikshya_Map_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'brikshya-map',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
