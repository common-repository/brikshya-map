<?php
defined('ABSPATH') or die('No script kiddies please!');
/**
 * Fired during plugin activation
 *
 * @link       http://brikshya.com/
 * @since      1.0.0
 *
 * @package    Brikshya_Map
 * @subpackage Brikshya_Map/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Brikshya_Map
 * @subpackage Brikshya_Map/includes
 * @author     Brikshya Technologies <brikshya.technologie>
 */
class Brikshya_Map_Activator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate()
    {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $wpdb->query(sprintf("CREATE TABLE IF NOT EXISTS %s (
            id bigint NOT NULL AUTO_INCREMENT,
            marker_name varchar(100) NOT NULL,
            slug varchar(100) NOT NULL UNIQUE,
            marker_detail varchar(1000) NOT NULL,
            marker_image_id int(55)  NOT NULL,
            date timestamp  NOT NULL,
            PRIMARY KEY  (id)
          ) $charset_collate;",
            $wpdb->prefix . 'brikshya_map_marker'));;
        $wpdb->query(sprintf("CREATE TABLE IF NOT EXISTS %s (
            id bigint NOT NULL AUTO_INCREMENT,
            map_name varchar(100) NOT NULL,
            map_type varchar(10) NOT NULL,
            height integer (10) ,
            width integer (100) ,
            map_detail varchar(1000) NOT NULL,
            map_address varchar(100) NOT NULL,
            main_lat FLOAT,
            main_long FLOAT,
            zoom integer NOT NULL,
            markers LONGTEXT NOT NULL,
            polylines LONGTEXT,
            radius LONGTEXT,
            style varchar(1000),
            GeoJSON varchar(1000),
            date timestamp  NOT NULL,
            PRIMARY KEY  (id)
          ) $charset_collate;",
            $wpdb->prefix . 'brikshya_map_table'));;

    }

}
