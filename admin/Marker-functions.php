<?php

/**
 * Get all Marker
 *
 * @param $args array
 *
 * @return array
 */
defined('ABSPATH') or die('No script kiddies please!');
function BKTMP_Get_All_Marker($args = array())
{
    global $wpdb;

    $defaults = array(
        'number' => 20,
        'offset' => 0,
        'orderby' => 'id',
        'order' => 'ASC',
    );

    $args = wp_parse_args($args, $defaults);
    $cache_key = 'Marker-all';
    $items = wp_cache_get($cache_key, 'birkshya');

    if (false === $items) {
        $items = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'brikshya_map_marker ORDER BY ' . $args['orderby'] . ' ' . $args['order'] . ' LIMIT ' . $args['offset'] . ', ' . $args['number']);

        wp_cache_set($cache_key, $items, 'birkshya');
    }

    return $items;
}

/**
 * Fetch all Marker from database
 *
 * @return array
 */
function BKTMP_Get_Marker_Count()
{
    global $wpdb;

    return (int)$wpdb->get_var('SELECT COUNT(*) FROM ' . $wpdb->prefix . 'brikshya_map_marker');
}

/**
 * Fetch a single Marker from database
 *
 * @param int $id
 *
 * @return array
 */
function BKTMP_Get_Marker($id = 0)
{
    global $wpdb;

    return $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'brikshya_map_marker WHERE id = %d', $id));
}

/**
 * Insert a new Marker
 *
 * @param array $args
 */
function BKTMP_Insert_Marker($args = array())
{
    global $wpdb;

    $defaults = array(
        'id' => null,
        'marker_name' => '',
        'slug' => '',
        'marker_detail' => '',
        'marker_image_id' => '',

    );

    $args = wp_parse_args($args, $defaults);
    $table_name = $wpdb->prefix . 'brikshya_map_marker';

    // some basic validation
    if (empty($args['marker_name'])) {
        return new WP_Error('no-marker_name', __('No Marker Name provided.', 'brikshya'));
    }
    if (empty($args['slug'])) {
        return new WP_Error('no-slug', __('No  provided.', 'brikshya'));
    }
    if (empty($args['marker_detail'])) {
        return new WP_Error('no-marker_detail', __('No  provided.', 'brikshya'));
    }
    if (empty($args['marker_image_id'])) {
        return new WP_Error('no-marker_image_id', __('No  provided.', 'brikshya'));
    }

    // remove row id to determine if new or update
    $row_id = (int)$args['id'];
    unset($args['id']);

    if (!$row_id) {

        $args['date'] = current_time('mysql');

        // insert a new
        if ($wpdb->insert($table_name, $args)) {
            return $wpdb->insert_id;
        }

    } else {

        // do update method here
        if ($wpdb->update($table_name, $args, array('id' => $row_id))) {
            return $row_id;
        }
    }

    return false;
}

function BKTMP_Update_Marker($args = array())
{
//    var_dump($args);
//    die();
    global $wpdb;

    $defaults = array(
        'id' => null,
        'marker_name' => '',
        'marker_detail' => '',
    );

    $args = wp_parse_args($args, $defaults);
    $table_name = $wpdb->prefix . 'brikshya_map_marker';

    // some basic validation
    if (empty($args['marker_name'])) {
        return new WP_Error('no-marker_name', __('No Marker Name provided.', 'brikshya'));
    }
    if (empty($args['marker_detail'])) {
        return new WP_Error('no-marker_detail', __('No  provided.', 'brikshya'));
    }
//    if (empty($args['marker_image_id'])) {
//        return new WP_Error('no-marker_image_id', __('No  provided.', 'brikshya'));
//    }

    // remove row id to determine if new or update
    $row_id = (int)$args['id'];
    unset($args['id']);

    if ($row_id) {

        // do update method here
        if ($wpdb->update($table_name, $args, array('id' => $row_id))) {
            return $row_id;
        }
    }

    return false;
}

function BKTMP_Get_All_Map($args = array())
{
    global $wpdb;

    $defaults = array(
        'number' => 20,
        'offset' => 0,
        'orderby' => 'id',
        'order' => 'ASC',
    );

    $args = wp_parse_args($args, $defaults);
    $cache_key = 'Map-all';
    $items = wp_cache_get($cache_key, 'brikshya');

    if (false === $items) {
        $items = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'brikshya_map_table ORDER BY ' . $args['orderby'] . ' ' . $args['order'] . ' LIMIT ' . $args['offset'] . ', ' . $args['number']);

        wp_cache_set($cache_key, $items, 'brikshya');
    }

    return $items;
}

/**
 * Fetch all Map from database
 *
 * @return array
 */
function BKTMP_Get_Map_Count()
{
    global $wpdb;

    return (int)$wpdb->get_var('SELECT COUNT(*) FROM ' . $wpdb->prefix . 'brikshya_map_table');
}

/**
 * Fetch a single Map from database
 *
 * @param int $id
 *
 * @return array
 */
function BKTMP_Get_Map($id = 0)
{
    global $wpdb;

    return $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'brikshya_map_table WHERE id = %d', $id));
}

function BKTMP_Insert_Map($args = array())
{
    global $wpdb;

    $defaults = array(
        'id' => null,
        'map_name' => '',
        'map_type' => '',
        'height' => '',
        'width' => '',
        'map_detail' => '',
        'map_address' => '',
        'main_lat' => '',
        'main_long' => '',
        'markers' => '',
        'style' => '',
        'polylines' => '',
        'radius' => '',
        'GeoJSON' => '',
        'zoom' => '',
        'date' => '',

    );

    $args = wp_parse_args($args, $defaults);
    $table_name = $wpdb->prefix . 'brikshya_map_table';

    // some basic validation
    if (empty($args['map_name'])) {
        return new WP_Error('no-map_name', __('No Map Name provided.', 'brikshya'));
    }
    if (empty($args['map_type'])) {
        $args['map_type'] = "roadmap";
    }
    if (empty($args['height'])) {
        $args['height'] = "";
    }
    if (empty($args['width'])) {
        $args['width'] = "";
    }
    if (empty($args['map_detail'])) {
        $args['map_detail'] = "";
    }
    if (empty($args['map_address'])) {
        return new WP_Error('no-map_address', __('No Address provided.', 'brikshya'));
    }
    if (empty($args['main_lat'])) {
        return new WP_Error('no-main_lat', __('No lat provided.', 'brikshya'));
    }
    if (empty($args['main_long'])) {
        return new WP_Error('no-main_long', __('No long provided.', 'brikshya'));
    }
    if (empty($args['markers'])) {
        return new WP_Error('no-markers', __('No Markers provided.', 'brikshya'));
    }
    if (empty($args['style'])) {
        $args['style'] = "";
    }
    if (empty($args['polylines'])) {
        $args['polylines'] = "";
    }
    if (empty($args['radius'])) {
        $args['radius'] = "";
    }
    if (empty($args['GeoJSON'])) {
        $args['GeoJSON'] = null;
    }
    // remove row id to determine if new or update
    $row_id = (int)$args['id'];
    unset($args['id']);

    if (!$row_id) {

        $args['date'] = current_time('mysql');

        // insert a new
        if ($wpdb->insert($table_name, $args)) {
            return $wpdb->insert_id;
        }

    }

    return false;
}

function BKTMP_Update_Map($args = array())
{
    global $wpdb;

    $defaults = array(
        'id' => null,
        'map_name' => '',
        'map_type' => '',
        'height' => '',
        'width' => '',
        'map_detail' => '',
        'map_address' => '',
        'style' => '',
        'zoom' => '',
        'polylines' => '',
        'radius' => '',

    );

    $args = wp_parse_args($args, $defaults);
    $table_name = $wpdb->prefix . 'brikshya_map_table';

    // some basic validation
    if (empty($args['map_name'])) {
        return new WP_Error('no-map_name', __('No Map Name provided.', 'brikshya'));
    }
    if (empty($args['map_type'])) {
        $args['map_type'] = "roadmap";
    }
    if (empty($args['height'])) {
        $args['height'] = "";
    }
    if (empty($args['width'])) {
        $args['width'] = "";
    }
    if (empty($args['map_detail'])) {
        $args['map_detail'] = "";
    }
    if (empty($args['map_address'])) {
        return new WP_Error('no-map_address', __('No Address provided.', 'brikshya'));
    }
    if (empty($args['style'])) {
        $args['style'] = "";
    }
    if (empty($args['polylines'])) {
        $args['polylines'] = "";
    }
    if (empty($args['radius'])) {
        $args['radius'] = "";
    }
    // remove row id to determine if new or update
    $row_id = (int)$args['id'];
    unset($args['id']);

    if ($row_id) {
        // do update method here
        if ($wpdb->update($table_name, $args, array('id' => $row_id))) {
            return $row_id;
        }
    }

    return false;
}