<?php

defined('ABSPATH') or die('No script kiddies please!');
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://brikshya.com/
 * @since      1.0.0
 *
 * @package    Brikshya_Map
 * @subpackage Brikshya_Map/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Brikshya_Map
 * @subpackage Brikshya_Map/admin
 * @author     Brikshya Technologies <brikshya.technologie>
 */
class Brikshya_Map_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->BKTMP_load_dependencies();
        $this->plugin_name = $plugin_name;
        $this->version = $version;

        add_action('admin_menu', array($this, 'BKTMP_admin_menu'));

    }

    private function BKTMP_load_dependencies()
    {
        require_once plugin_dir_path(__FILE__) . 'BKTMP_admin_functions.php';
        require_once plugin_dir_path(__FILE__) . 'class-Map-list-table.php';
        require_once plugin_dir_path(__FILE__) . 'Marker-functions.php';
        require_once plugin_dir_path(__FILE__) . 'class-Marker-list-table.php';
        require_once plugin_dir_path(__FILE__) . 'class-form-handler.php';
    }

    public function BKTMP_Admin_Menu()
    {
        /** Top Menu **/
        add_menu_page(__('Brikshya Maps', 'brikshya'), __('Brikshya Map', 'brikshya'), 'manage_options', 'map', array($this, 'BKTMP_Map_Page'), 'dashicons-groups', null);

        add_submenu_page('map', 'Add Marker', 'Add Marker', 'manage_options', 'marker', array($this, 'BKTMP_Plugin_Page'));

        add_submenu_page('map', 'Map API key', 'Map API key', 'manage_options', 'settings', array($this, 'BKTMP_Settings'));

    }

    /**
     * Handles the plugin page
     *
     * @return void
     */
    public function BKTMP_Plugin_Page()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : 'list';
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if (isset($_GET['error'])) {
//            die();
        }
        switch ($action) {

            case 'view':
                $template = plugin_dir_path(__FILE__) . 'partials/marker-single.php';
                break;

            case 'edit':
                $template = plugin_dir_path(__FILE__) . 'partials/marker-edit.php';
                break;

            case 'new':
                $template = plugin_dir_path(__FILE__) . 'partials/marker-new.php';
                break;

            case 'delete':
                global $wpdb;
                $wpdb->delete(
                    "{$wpdb->prefix}brikshya_map_marker",
                    ['ID' => $id],
                    ['%d']
                );
                $template = plugin_dir_path(__FILE__) . 'partials/marker-list.php';
                break;
            default:
                $template = plugin_dir_path(__FILE__) . 'partials/marker-list.php';
                break;
        }

        if (file_exists($template)) {
            include $template;
        }
    }

    public function BKTMP_Map_Page()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : 'list';
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        switch ($action) {

            case 'list':
                $template = plugin_dir_path(__FILE__) . 'partials/map-list.php';
                break;
            case 'view':
                $template = plugin_dir_path(__FILE__) . 'partials/map-single.php';
                break;

            case 'edit':
                $template = plugin_dir_path(__FILE__) . 'partials/map-edit.php';
                break;

            case 'new':
                $template = plugin_dir_path(__FILE__) . 'partials/map-new.php';
                break;
            case 'delete':
                global $wpdb;
                $wpdb->delete(
                    "{$wpdb->prefix}brikshya_map_table",
                    ['ID' => $id],
                    ['%d']
                );
                $template = plugin_dir_path(__FILE__) . 'partials/map-list.php';
                break;

            default:

                $template = plugin_dir_path(__FILE__) . 'partials/map-list.php';
                break;
        }
        if (file_exists($template)) {
            include $template;
        }
    }

    public function BKTMP_Settings()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : 'list';

        switch ($action) {

            default:
                $template = plugin_dir_path(__FILE__) . 'partials/settings.php';
                break;
        }

        if (file_exists($template)) {
            include $template;
        }
    }

    public function add_ajax()
    {
        wp_localize_script(
            'function',
            'ajax_script',
            array('ajaxurl' => admin_url('admin-ajax.php')));
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/brikshya-map-admin.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/brikshya-map-admin.js', array('jquery'), $this->version, false);

    }

}
