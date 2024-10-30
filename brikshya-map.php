<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://brikshya.com/
 * @since             1.0.0
 * @package           Brikshya_Map
 *
 * @wordpress-plugin
 * Plugin Name:       Brikshya Map
 * Plugin URI:        http://brikshya.com/wordpress/pluging
 * Description:       This plugin is developed to add google map easily on website. with sortcode user can add the google map.
 * Version:           1.0.1
 * Author:            Brikshya Technologies
 * Author URI:        http://brikshya.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       brikshya-map
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die('No script kiddies please!');
}


/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('BRIKSHYA_MAP_CURRENT_VERSION', '1.0.1');


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-brikshya-map-activator.php
 */
function activate_brikshya_map()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-brikshya-map-activator.php';
    Brikshya_Map_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-brikshya-map-deactivator.php
 */
function deactivate_brikshya_map()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-brikshya-map-deactivator.php';
    Brikshya_Map_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_brikshya_map');
register_deactivation_hook(__FILE__, 'deactivate_brikshya_map');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-brikshya-map.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_brikshya_map()
{

    $plugin = new Brikshya_Map();
    $plugin->run();

}

run_brikshya_map();
