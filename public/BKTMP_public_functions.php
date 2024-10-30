<?php

/**
 * The public-facing functionality of the plugin.
 *
 */
defined('ABSPATH') or die('No script kiddies please!');
//generates shorcode for the map
function BKTMP_Map_sortcode($atts)
{

    global $wpdb;
    $id = (int)$atts[0];
    $table_name = $wpdb->prefix . "brikshya_map_table";
    $charset_collate = $wpdb->get_charset_collate();
    $maps = $wpdb->get_results("SELECT * FROM $table_name Where $table_name.id=$id");
    if ($maps) {
        foreach ($maps as $m) {
            $map_map_name = $m->map_name;
            $map_map_type = $m->map_type;
            $map_height = (int)$m->height;
            $map_width = (int)$m->width;
            $map_map_detail = $m->map_detail;
            $map_main_lat = (float)$m->main_lat;
            $map_main_long = (float)$m->main_long;
            $style = $m->style;
            $GeoJSON = $m->GeoJSON;
            $target_file = wp_upload_dir()['baseurl'] . '/brikshya-map/' . $GeoJSON;
            $zoom = (int)$m->zoom;
            $polygons_compact = $m->polylines;
            if ($polygons_compact) {
                $polygons_array = explode(",", $polygons_compact);
                $p_counter = count($polygons_array);
                foreach ($polygons_array as $arrays) {
                    $p_array[] = (float)$arrays;
                }
            }
            $v = json_decode($m->markers, true);
            $radius = json_decode($m->radius, true);
            if (is_array($radius)) {
                $lat = $radius['radius_lat'];
                $long = $radius['radius_long'];
                $rad = $radius['radius'];
            }

            if (is_array($v)) {
                $counter = (int)$v["marker_counter"];
                $sagar = 0;
                for ($i = 0; $i <= $counter; $i++) {
                    if (isset($v["lat_" . $i])) {


                        $map["lat_" . $i] = $v["lat_" . $i];
                        $map["lang_" . $i] = $v["lang_" . $i];
                        $id = BKTMP_Imgid_From_Slug($v["marker_" . $i]);
                        $marker_url = wp_get_attachment_image_url($id);
                        $map["marker_image_" . $i] = $marker_url;
                        $sagar++;
                    }

                }
                $map["counter"] = $i - 1;
            }
        }
        $html = '<style>';
        $html .= '.brikshya_map{';
//        $html .= 'position:relative; padding-bottom:75%;overflow:hidden;width:100%;height:100%;';
        $html .= $style;
        $html .= '}';
        $html .= '.brikshya_map_iframe{';
        $html .= 'position:relative;top:0;left:0;height:' . $map_height . 'px; width:100%;';
        $html .= '}';
        $html .= '</style>';
        $html .= '<div class="brikshya_map"><div id="map" class="brikshya_map_iframe"></div></div>';
        $html .= "
<script>
    function initMap() {
        
        var map = new google.maps.Map(document.getElementById('map'), {
            center: new google.maps.LatLng($map_main_lat, $map_main_long),
            zoom: $zoom,
            mapTypeId: '$map_map_type'
        });";

        if ($GeoJSON) {
            $html .= " 
            map.data.loadGeoJson('$target_file');";
        }
        $html .= "
        var icons = { ";
        for ($j = 0; $j <= $sagar; $j++) {
            if (isset($map["marker_image_" . $j])) {
                $marker_url = $map["marker_image_" . $j];
                $html .= "
        " . $j . ": {
                icon: '" . $marker_url . "',
            },";
            }
        }
        $html .= "};";
        if ($polygons_compact) {
            $html .= " 
            var flightPlanCoordinates = [";
            for ($z = 0; $z < $p_counter; $z = $z + 2) {
                $zz = $z + 1;
                $html .= " {lat: $p_array[$z], lng: $p_array[$zz]},";
            }

            $html .= "];
        
        var flightPath = new google.maps.Polyline({
            path: flightPlanCoordinates,
            geodesic: true,
            strokeColor: '#FF0000',
            strokeOpacity: 1.0,
            strokeWeight: 2
        });
         flightPath.setMap(map);
        ";

        }
        if ($radius) {
            $html .= " 
            var cityCircle = new google.maps.Circle({
            strokeColor: '#FF0000',
            strokeOpacity: 0.6,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.2,
            map: map,
            center: new google.maps.LatLng($lat, $long),
            radius: $rad
        });";
        }
        $html .= "
        var features = [";
        for ($j = 0; $j <= $sagar; $j++) {
            if (isset($map["lang_" . $j])) {
                $marker_url = $map["marker_image_" . $j];
                $lat = $map["lat_" . $j];
                $lang = $map["lang_" . $j];
                $html .= "
            {
                position: new google.maps.LatLng($lat,$lang),
                type: '" . $j . "',

            },";
            }
        }

        $html .= "];

        features.forEach(function (feature) {
            var marker = new google.maps.Marker({
                position: feature.position,
                icon: icons[feature.type].icon,
                map: map,
                });
        });
    }
</script > ";
        $html .= "
<script type = 'text/javascript'
        src = 'https://maps.googleapis.com/maps/api/js?key=" . get_option('wp_brikhsya_gmap_api_key') . "&amp;libraries=places&amp;callback=initMap' ></script > ";
    } else {
        $html = "<h2>no data found</h2>";
    }
    $a = shortcode_atts(array(
        'foo' => $html,
    ), $atts);

    return "{$a['foo']}";
}

add_shortcode('briskhya_map', 'BKTMP_Map_sortcode');

function BKTMP_CreateSlug($title, $table_name, $field_name)
{


    global $wpdb;

    $slug = preg_replace("/-$/", "", preg_replace('/[^a-z0-9]+/i', "-", strtolower($title)));

    $counter = 1;

    do {

        $query = "SELECT * FROM $table_name WHERE  $field_name  = '" . $slug . "'";
        $result = $wpdb->get_results($query);


        if ($result) {
            $count = strrchr($slug, "_");
            $count = str_replace("_", "_", $count);
            if ($count > 0) {

                $length = count($count) + 1;
                $newSlug = str_replace(strrchr($slug, "_"), '', $slug);
                $slug = $newSlug . '_' . $length;

                $count++;

            } else {
                $slug = $slug . '_' . $counter;
            }

        }

        $counter++;

    } while ($result);

    return $slug;
}

function BKTMP_Imgid_From_Slug($slug)
{
    global $wpdb;
    $table_name = $wpdb->prefix . "brikshya_map_marker";
    $slug_field_name = "slug";
    $img_id_field_name = "marker_image_id";
    $slug = sanitize_text_field($slug);
    $query = "SELECT $img_id_field_name FROM $table_name WHERE  $slug_field_name  = '" . $slug . "'";
    $result = $wpdb->get_results($query);
    if ($result) {
        $id = (int)$result[0]->marker_image_id;
        return $id;
    } else return null;
}

function BKTMP_File_Uploader($filename)
{
    if ($_FILES[$filename]['size'] == 0) {
        return null;
    }

    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');
    $target_dir = BKTMP_File_Upload_DIR();
    $new_name = round(microtime(true)) . basename($_FILES[$filename]["name"]);;
    $target_file = $target_dir . $new_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($imageFileType != "application/json" && $imageFileType != "json" && $imageFileType != "geojson") {
        return null;
    }
    if (!is_dir($target_dir)) {
        mkdir($target_dir);
    }
    if (move_uploaded_file($_FILES[$filename]["tmp_name"], $target_file)) {
        return $new_name;
    } else {
        return null;
    }


}

function BKTMP_File_Upload_DIR()
{
    $current_user = wp_get_current_user();
    $local_dir = 'brikshya-map';
    $upload_dir = wp_upload_dir();
    if (isset($current_user->user_login) && !empty($upload_dir['basedir'])) {
        $user_dirname = $upload_dir['basedir'] . '/' . $local_dir;
        if (!file_exists($user_dirname)) {
            wp_mkdir_p($user_dirname);
        }
        return $user_dirname . '/';
    }
    return null;
}