<?php

defined('ABSPATH') or die('No script kiddies please!');

/**
 * Handle the form submissions
 *
 * @package Package
 * @subpackage Sub Package
 */
class BKTMP_Form_Handler
{
    /**
     * Hook 'em all
     */
    public function __construct()
    {
        add_action('admin_init', array($this, 'BKTMP_Add_Marker'));
        add_action('admin_init', array($this, 'BKTMP_Add_Map'));
    }


    /**
     * Handle the Marker new and edit form
     *
     * @return void
     */

    public function BKTMP_Add_Marker()
    {

        if (isset($_POST['submit_marker'])) {


            if (!wp_verify_nonce($_POST['_wpnonce'], 'marker-new')) {
                die(__('Are you cheating?', 'brikshya'));
            }

            if (!current_user_can('read')) {
                wp_die(__('Permission Denied!', 'brikshya'));
            }

            $errors = array();
            $attach_id = '';
            $page_url = admin_url('admin.php?page=marker&action=new');
            $page_url_success = admin_url('admin.php?page=marker');
            $field_id = isset($_POST['field_id']) ? intval($_POST['field_id']) : 0;
            if (isset($_FILES['marker_image'])) {
                $files = $_FILES["marker_image"];
                if (($files['size'][0]) != 0) {
                    require_once(ABSPATH . 'wp-admin/includes/image.php');
                    require_once(ABSPATH . 'wp-admin/includes/file.php');
                    require_once(ABSPATH . 'wp-admin/includes/media.php');
                    foreach ($files['name'] as $key => $value) {
                        if ($files['name'][$key]) {
                            $file = array(
                                'name' => $files['name'][$key],
                                'type' => $files['type'][$key],
                                'tmp_name' => $files['tmp_name'][$key],
                                'error' => $files['error'][$key],
                                'size' => $files['size'][$key]
                            );

                            $_FILES = array("marker_image_id" => $file);

                            foreach ($_FILES as $file => $array) {
                                // upload our file in WP database
                                $attach_id = media_handle_upload($file, 0, $_FILES);
                                $marker_image_id = $attach_id;
                            }
                        }
                    }
                } else {
                    $attach_id = 568;
                    $marker_image_id = $attach_id;
                }
            } else {
                $marker_image_id = isset($_POST['marker_image_id']) ? intval($_POST['marker_image_id']) : 0;
            }
            $marker_name = isset($_POST['marker_name']) ? sanitize_text_field($_POST['marker_name']) : '';
            $slug = isset($_POST['slug']) ? sanitize_text_field($_POST['slug']) : '';
            $marker_detail = isset($_POST['marker_detail']) ? wp_kses_post($_POST['marker_detail']) : '';

            // some basic validation
            if (!$marker_name) {
                $errors[] = __('Error: Marker Name is required', 'brikshya');
            }


            if (!$marker_detail) {
                $marker_detail = " ";
            }

            if (!$marker_image_id) {
                $errors[] = __('Error:  Marker is required', 'brikshya');
            }

//             bail out if error found
            if ($errors) {
//                $first_error = reset($errors);
                $first_error = $errors;
                $redirect_to = add_query_arg(array('error' => $first_error), $page_url);
                wp_safe_redirect($redirect_to);

                exit;
            }
            $slug = BKTMP_CreateSlug($marker_name, 'wp_brikshya_map_marker', 'slug');


            $fields = array(
                'marker_name' => $marker_name,
                'slug' => $slug,
                'marker_detail' => $marker_detail,
                'marker_image_id' => $marker_image_id,
            );
            if (!$field_id) {

                $insert_id = BKTMP_Insert_Marker($fields);

            } else {

                $fields['id'] = $field_id;

                $insert_id = BKTMP_Insert_Marker($fields);
            }

            if (is_wp_error($insert_id)) {
                $redirect_to = add_query_arg(array('message' => 'error'), $page_url);
            } else {
                $redirect_to = add_query_arg(array('message' => 'success'), $page_url_success);
            }

            wp_safe_redirect($redirect_to);
            exit;
        } elseif (isset($_POST['update_marker'])) {

            if (!wp_verify_nonce($_POST['_wpnonce'], 'marker-new')) {
                die(__('Are you cheating?', 'brikshya'));
            }

            if (!current_user_can('read')) {
                wp_die(__('Permission Denied!', 'brikshya'));
            }

            $errors = array();
            $attach_id = '';
            $page_url = admin_url('admin.php?page=marker&action=edit');
            $page_url_success = admin_url('admin.php?page=marker');
            $field_id = isset($_POST['field_id']) ? intval($_POST['field_id']) : 0;
            $marker_name = isset($_POST['marker_name']) ? sanitize_text_field($_POST['marker_name']) : '';
//            $slug = isset($_POST['slug']) ? sanitize_text_field($_POST['slug']) : '';
            $marker_detail = isset($_POST['marker_detail']) ? wp_kses_post($_POST['marker_detail']) : '';

            // some basic validation
            if (!$marker_name) {
                $errors[] = __('Error: Marker Name is required', 'brikshya');
            }

            if (!$marker_detail) {
                $errors[] = __('Error:  is required', 'brikshya');
            }


//             bail out if error found
            if ($errors) {
                $first_error = reset($errors);
                $redirect_to = add_query_arg(array('error' => $first_error), $page_url);
                wp_safe_redirect($redirect_to);
                exit;
            }

            $fields = array(
                'marker_name' => $marker_name,
                'marker_detail' => $marker_detail,
            );
            if ($field_id) {

                $fields['id'] = $field_id;

                $insert_id = BKTMP_Update_Marker($fields);
            }

            if (is_wp_error($insert_id)) {
                $redirect_to = add_query_arg(array('message' => 'error'), $page_url);
            } else {
                $redirect_to = add_query_arg(array('message' => 'update'), $page_url_success);
            }
            wp_safe_redirect($redirect_to);
            exit;

        } else {
            return;
        }
    }


    public function BKTMP_Add_Map()
    {
//Map insert and update

        if (isset($_POST['submit_map'])) {


            if (!wp_verify_nonce($_POST['_wpnonce'], 'map-new')) {
                die(__('Are you cheating?', 'brikshya'));
            }

            if (!current_user_can('read')) {
                wp_die(__('Permission Denied!', 'brikshya'));
            }
            if (isset($_POST['marker_counter'])) {
                $marker_counter = sanitize_text_field($_POST['marker_counter']);
            } else($marker_counter = 0);
            $errors = array();
            $page_url = admin_url('admin.php?page=map&action=new');
            $page_url_success = admin_url('admin.php?page=map&action=list');
            $field_id = isset($_POST['field_id']) ? intval($_POST['field_id']) : 0;
            $c = (int)$marker_counter;
            for ($i = 0; $i <= $c; $i++) {
                if (isset($_POST['address_' . $i])) {
                    $markers['address_' . $i] = sanitize_text_field($_POST['address_' . $i]);
                    $markers['lat_' . $i] = sanitize_text_field($_POST['lat_' . $i]);
                    $markers['lang_' . $i] = sanitize_text_field($_POST['lang_' . $i]);
                    if (!empty($_POST['marker_' . $i])) {

                        $markers['marker_' . $i] = sanitize_text_field($_POST['marker_' . $i]);
                    } else {
                        $markers['marker_' . $i] = "";

                    }
                }
            }

            $GeoJSON = BKTMP_File_Uploader('GeoJSON');;
            $markers['marker_counter'] = $i - 1;
            $map_name = isset($_POST['map_name']) ? sanitize_text_field($_POST['map_name']) : '';
            $map_type = isset($_POST['map_type']) ? sanitize_text_field($_POST['map_type']) : '';
            $height = isset($_POST['height']) ? sanitize_text_field($_POST['height']) : '';
            $width = ' ';
//            $width = isset($_POST['width']) ? sanitize_text_field($_POST['width']) : '';
            $map_detail = isset($_POST['map_detail']) ? sanitize_text_field($_POST['map_detail']) : '';
            $map_address = isset($_POST['map_address']) ? sanitize_text_field($_POST['map_address']) : '';
            $main_lat = isset($_POST['main_lat']) ? sanitize_text_field($_POST['main_lat']) : '';
            $main_long = isset($_POST['main_long']) ? sanitize_text_field($_POST['main_long']) : '';
            $zoom = isset($_POST['zoom']) ? sanitize_text_field($_POST['zoom']) : '';
            $style = isset($_POST['style']) ? wp_kses_post($_POST['style']) : '';
            if (isset($_POST['polylines_set'])) {
                $polylines = isset($_POST['polylines']) ? wp_kses_post($_POST['polylines']) : '';

            } else {
                $polylines = null;
            }
            if (isset($_POST['radius_set']) && $_POST['radius'] && $_POST['radius_lat'] && $_POST['radius_long']) {
                $radius_1 = isset($_POST['radius']) ? wp_kses_post($_POST['radius']) : '';
                $radius_lat = isset($_POST['radius_lat']) ? wp_kses_post($_POST['radius_lat']) : '';
                $radius_long = isset($_POST['radius_long']) ? wp_kses_post($_POST['radius_long']) : '';
                $radius_d['radius'] = $radius_1;
                $radius_d['radius_lat'] = $radius_lat;
                $radius_d['radius_long'] = $radius_long;
                $radius = json_encode($radius_d);
            } else {
                $radius = null;
            }
            // some basic validation
            if (!$map_name) {
                $errors[] = __('Error: Map Name is required', 'brikshya');
            }

            if (!$map_type) {
                $map_type = 'roadmap';
            }

            if (!$height) {
                $errors[] = __('Error: Height is required', 'brikshya');
            }

            if (!$width) {
                $errors[] = __('Error: Width is required', 'brikshya');
            }


            if (!$map_address) {
                $errors[] = __('Error: Address is required', 'brikshya');
            }

            if (!$main_lat) {
                $errors[] = __('Error: lat is required', 'brikshya');
            }

            if (!$main_long) {
                $errors[] = __('Error: long is required', 'brikshya');
            }
            if (!$zoom) {
                $errors[] = __('Error: zoom is required', 'brikshya');
            }

            if (!$markers) {
                $errors[] = __('Error: Markers is required', 'brikshya');
            }

            if (!$style) {
                $style = "";
            }
            if (!$polylines) {
                $polylines = "";
            }
            if (!$radius) {
                $radius = "";
            }


            // bail out if error found
            if ($errors) {
                $first_error = reset($errors);
                $redirect_to = add_query_arg(array('error' => $errors), $page_url);
                wp_safe_redirect($redirect_to);
                exit;
            }

            $fields = array(
                'map_name' => $map_name,
                'map_type' => $map_type,
                'height' => $height,
                'width' => $width,
                'map_detail' => $map_detail,
                'map_address' => $map_address,
                'main_lat' => $main_lat,
                'main_long' => $main_long,
                'zoom' => $zoom,
                'markers' => json_encode($markers),
                'style' => $style,
                'polylines' => $polylines,
                'radius' => $radius,
                'GeoJSON' => $GeoJSON,
            );

            // New or edit?
            if (!$field_id) {

                $insert_id = BKTMP_Insert_Map($fields);

            }
            if (is_wp_error($insert_id)) {
                $redirect_to = add_query_arg(array('message' => 'error'), $page_url);
            } else {
                $redirect_to = add_query_arg(array('message' => 'success'), $page_url_success);
            }

            wp_safe_redirect($redirect_to);
            exit;
        } elseif (isset($_POST['update_map'])) {
            if (!wp_verify_nonce($_POST['_wpnonce'], 'map-new')) {
                die(__('Are you cheating?', 'brikshya'));
            }

            if (!current_user_can('read')) {
                wp_die(__('Permission Denied!', 'brikshya'));
            }

            $errors = array();
            $page_url = admin_url('admin.php?page=map');
            $page_url_success = admin_url('admin.php?page=map');
            $field_id = isset($_POST['field_id']) ? intval($_POST['field_id']) : 0;

            $map_name = isset($_POST['map_name']) ? sanitize_text_field($_POST['map_name']) : '';
            $map_type = isset($_POST['map_type']) ? sanitize_text_field($_POST['map_type']) : '';
            $height = isset($_POST['height']) ? sanitize_text_field($_POST['height']) : '';
            $width = isset($_POST['width']) ? sanitize_text_field($_POST['width']) : '';
            $width = ' ';
            $map_detail = isset($_POST['map_detail']) ? sanitize_text_field($_POST['map_detail']) : '';
            $map_address = isset($_POST['map_address']) ? sanitize_text_field($_POST['map_address']) : '';
//            $main_lat = isset($_POST['main_lat']) ? sanitize_text_field($_POST['main_lat']) : '';
//            $main_long = isset($_POST['main_long']) ? sanitize_text_field($_POST['main_long']) : '';
            $style = isset($_POST['style']) ? wp_kses_post($_POST['style']) : '';
            $zoom = isset($_POST['zoom']) ? sanitize_text_field($_POST['zoom']) : '';
//            $date = isset($_POST['date']) ? sanitize_text_field($_POST['date']) : '';

            // some basic validation
            if (!$map_name) {
                $errors[] = __('Error: Map Name is required', 'brikshya');
            }
            if (!$map_type) {
                $map_type = 'roadmap';
            }

            if (!$height) {
                $errors[] = __('Error: Height is required', 'brikshya');
            }

            if (!$width) {
                $errors[] = __('Error: Width is required', 'brikshya');
            }

            if (!$map_detail) {
                $map_detail = '';
            }

            if (!$map_address) {
                $errors[] = __('Error: Address is required', 'brikshya');
            }
            if (!$zoom) {
                $errors[] = __('Error: zoom is required', 'brikshya');
            }
            if (isset($_POST['polylines_set'])) {
                $polylines = isset($_POST['polylines']) ? wp_kses_post($_POST['polylines']) : '';

            } else {
                $polylines = null;
            }
            if (isset($_POST['radius_set']) && $_POST['radius'] && $_POST['radius_lat'] && $_POST['radius_long']) {
                $radius_1 = isset($_POST['radius']) ? wp_kses_post($_POST['radius']) : '';
                $radius_lat = isset($_POST['radius_lat']) ? wp_kses_post($_POST['radius_lat']) : '';
                $radius_long = isset($_POST['radius_long']) ? wp_kses_post($_POST['radius_long']) : '';
                $radius_d['radius'] = $radius_1;
                $radius_d['radius_lat'] = $radius_lat;
                $radius_d['radius_long'] = $radius_long;
                $radius = json_encode($radius_d);
            } else {
                $radius = null;
            }

            if (!$style) {
                $style = '';
            }


            // bail out if error found
            if ($errors) {
                $first_error = reset($errors);
                $redirect_to = add_query_arg(array('error' => $first_error), $page_url);
                wp_safe_redirect($redirect_to);
                exit;
            }

            $fields = array(
                'map_name' => $map_name,
                'map_type' => $map_type,
                'height' => $height,
                'width' => $width,
                'map_detail' => $map_detail,
                'map_address' => $map_address,
                'style' => $style,
                'zoom' => $zoom,
                'polylines' => $polylines,
                'radius' => $radius,
            );

            if ($field_id) {

                $fields['id'] = $field_id;

                $insert_id = BKTMP_Update_Map($fields);
            }

            if (is_wp_error($insert_id)) {
                $redirect_to = add_query_arg(array('message' => 'error'), $page_url);
            } else {
                $redirect_to = add_query_arg(array('message' => 'update'), $page_url_success);
            }

            wp_safe_redirect($redirect_to);
            exit;
        } else {
            return;
        }
    }
}


new BKTMP_Form_Handler();