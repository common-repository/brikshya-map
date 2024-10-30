<?php defined('ABSPATH') or die('No script kiddies please!'); ?>
<div class="wrap">
    <h1><?php _e('Add Map', 'brikshya'); ?></h1>
    <?php
    if (isset($_GET['error'])) {
        $errors = ($_GET['error']);
        foreach ($errors as $error) {
            if ($error == 'Error:MapNameisrequired') {
                echo '<div class="error">Marker Name Required</div>';
                $name_error = " ";
            }
            if ($error == 'Error:Heightisrequired') {
                echo '<div class="error">Height is Required</div>';
                $height_error = " ";
            }
//            if ($error == 'Error:Widthisrequired') {
//                echo '<div class="error">Width is required</div>';
//                $width_error = " ";
//            }
            if ($error == 'Error:Detailisrequired') {
                echo '<div class="error">Detail is Required</div>';
                $detail_error = " ";
            }
            if ($error == 'Error:Addressisrequired') {
                echo '<div class="error">Address is Required</div>';
                $address_error = " ";
            }
            if ($error == 'Error:latisrequired') {
                echo '<div class="error">Latitude is Required</div>';
                $lat_error = " ";
            }
            if ($error == 'Error:longisrequired') {
                echo '<div class="error">Longitude is Required</div>';
                $long_error = " ";
            }

        }
    }
    $sagar = "sagar";
    ?>
    <!--    <div id="floating-panel">-->
    <!--        <input onclick="clearMarkers();" type=button value="Hide Markers">-->
    <!--        <input onclick="showMarkers();" type=button value="Show All Markers">-->
    <!--        <input onclick="deleteMarkers();" type=button value="Delete Markers">-->
    <!--    </div>-->
    <div id="map"></div>
    <p>Click on the map to add markers.</p>
    <form action="" method="post" enctype="multipart/form-data">

        <table class="form-table">
            <tbody>
            <tr class="row-map-name">
                <th scope="row">
                    <label for="map_name"><?php _e('Map Name', 'brikshya'); ?></label>
                </th>
                <td>
                    <input required="required" type="text" name="map_name" id="map_name"
                           class="regular-text <?php if (isset($name_error)) echo $sagar ?>"
                           placeholder="<?php echo esc_attr('Map Name', 'brikshya'); ?>" value=""/>
                    <span class="description"><?php _e('Map Name For Your Identity ', 'brikshya'); ?></span>
                </td>
            </tr>
            <tr class="row-map-type">
                <th scope="row">
                    <label for="map_type"><?php _e('Map Type', 'brikshya'); ?></label>
                </th>
                <td>
                    <select class="regular-text" name="map_type">
                        <option value="roadmap">Roadmap</option>
                        <option value="satellite">Satellite</option>
                        <option value="hybrid">Hybrid</option>
                        <option value="terrain">Terrain</option>
                    </select>
                    <span class="description"><?php _e('Map Name For Your Identity ', 'brikshya'); ?></span>
                </td>
            </tr>
            <tr class="row-height">
                <th scope="row">
                    <label for="height"><?php _e('Height', 'brikshya'); ?></label>
                </th>
                <td>
                    <input required="required" type="number" min="50" name="height" id="height"
                           class="regular-text <?php if (isset($name_error)) echo $sagar ?>"
                           placeholder="<?php echo esc_attr('', 'brikshya'); ?>" value="500"/>
                    <span class="description"><?php _e('Enter Hight In pixel that You need For Your Website', 'brikshya'); ?></span>
                </td>
            </tr>
            <!--            <tr class="row-width">-->
            <!--                <th scope="row">-->
            <!--                    <label for="width">--><?php //_e('Width', 'brikshya'); ?><!--</label>-->
            <!--                </th>-->
            <!--                <td>-->
            <!--                    <input required="required" type="number" min="50" name="width" id="width"-->
            <!--                           class="regular-text --><?php //if (isset($name_error)) echo $sagar ?><!--"-->
            <!--                           placeholder="--><?php //echo esc_attr('', 'brikshya'); ?><!--" value=""/>-->
            <!--                    <span class="description">-->
            <?php //_e('Enter Width In pixel that You need For Your Website', 'brikshya'); ?><!--</span>-->
            <!--                </td>-->
            <!--            </tr>-->
            <tr class="row-map-detail">
                <th scope="row">
                    <label for="map_detail"><?php _e('Detail', 'brikshya'); ?></label>
                </th>
                <td>
                    <textarea name="map_detail" id="map_detail"
                              placeholder="<?php echo esc_attr('Map Detail', 'brikshya'); ?>"
                              rows="5"
                              cols="30"></textarea>
                    <p class="description"><?php _e('Enter Map detail for Better Understanding', 'brikshya'); ?></p>
                </td>
            </tr>
            <tr class="row-zoom">
                <th scope="row">
                    <label for="zoom"><?php _e('Zoom Level: ', 'brikshya'); ?><span id="zoom-level"></span></label>
                </th>
                <td>
                    <input type="range" onclick="sagar()"
                           class="regular-text <?php if (isset($name_error)) echo $sagar ?>" id="zoom"
                           onchange="zoomchange()" name="zoom" min="0"
                           max="19">


                    <p class="description"><?php _e('Enter Width In pixel that You need For Your Website', 'brikshya'); ?></p>
                </td>
            </tr>
            <tr class="row-map-address">
                <th scope="row">
                    <label for="map_address"><?php _e('Address', 'brikshya'); ?></label>
                </th>
                <td>
                    <input required="required" type="text" name="map_address" id="map_address"
                           class="regular-text <?php if (isset($name_error)) echo $sagar ?>"
                           placeholder="<?php echo esc_attr('', 'brikshya'); ?>" value=""/>
                    <input type="hidden" name="main_lat" id="main_lat" step="any"
                           class="regular-text <?php if (isset($name_error)) echo $sagar ?>"
                           placeholder="<?php echo esc_attr('', 'brikshya'); ?>" value=""/>
                    <input type="hidden" name="main_long" id="main_long" step="any"
                           class="regular-text <?php if (isset($name_error)) echo $sagar ?>"
                           placeholder="<?php echo esc_attr('', 'brikshya'); ?>" value=""/>
                </td>
            </tr>
            <tr class="row-style">
                <th scope="row">
                    <label for="style"><?php _e('style', 'brikshya'); ?></label>
                </th>
                <td>
                    <textarea name="style" id="style" placeholder="<?php echo esc_attr('', 'brikshya'); ?>"
                              rows="5"
                              cols="30"></textarea>
                    <p class="description"><?php _e('This stypesheet will be applied to the Map on loading to the Website. Include css without any bracket <span class="tooltip"> Example<span class="tooltiptext">visibility: hidden; width: 120px;<br>  background-color: black;<br>color: #fff;<br>text-align:left;<br>border-radius: 6px;<br>padding: 5px 0;</span></span>', 'brikshya'); ?></p>
                </td>
            </tr>
            <tr class="row-polylines-set">
                <th scope="row">
                    <?php _e('Set Polylines', 'fdsa'); ?>
                </th>
                <td>
                    <label for="polylines_set"><input type="checkbox" name="polylines_set" onclick="sagar_polylines()"
                                                      id="polylines_set"
                                                      value="on"/> <?php _e('', 'fdsa'); ?></label>
                </td>
            </tr>
            <tr class="row-polylines">

                <th scope="row">
                    <label for="polylines" id="label_polylines"
                           style="display: none;"><?php _e('Polylines', 'fdsa'); ?></label>

                </th>
                <td>
                    <textarea name="polylines" id="polylines" style="display: none;"
                              placeholder="<?php echo esc_attr('', 'fdsa'); ?>" rows="5"
                              cols="30"></textarea>
                    <p class="description" id="description_polylines"
                       style="display: none;"><?php _e('Entering wrong format of polylines will lead to erros on google map. <span class="tooltip"> Example<span class="tooltiptext">28.261576, 83.979304, 28.261038, 83.979561,28.260574, 83.979894,28.258906, 83.981064,28.257252, 83.981484,28.254419, 83.982925, 28.249180, 83.986726,28.248298, 83.986265,28.246143, 83.987958,28.245696, 83.988972</span></span>', 'fdsa'); ?></p>
                    <p class="description" id="description_polylines1" style="display: none;">Please Use <a
                                href="https://www.latlong.net/" target="_blank">latlong</a>
                        or similar sites to get latitude and longitude </p>
                </td>
            </tr>
            <tr class="row-radius-set">
                <th scope="row">
                    <?php _e('Set Radius', 'fdsa'); ?>
                </th>
                <td>
                    <label for="radius_set"><input type="checkbox" name="radius_set" onclick="sagar_radius()"
                                                   id="radius_set"
                                                   value="on"/> <?php _e('', 'fdsa'); ?></label>
                </td>
            </tr>
            <tr class="row-Radius">
                <th scope="row">
                    <label for="Radius" id="label_radius" style="display: none;"><?php _e('Radius', 'fdsa'); ?></label>
                </th>
                <td>
                    <input type="number" min="0" name="radius" id="radius" class="regular-text"
                           style="display: none;"
                           placeholder="<?php echo esc_attr('', 'brikshya'); ?>" value=""/>
                    <p class="description" id="desc_rad"
                       style="display: none;"><?php _e('Enter Radius In meters', 'brikshya'); ?></p>
                </td>
            </tr>
            <tr class="row-Radius_lat">
                <th scope="row">
                    <label for="Radius_lat" id="label_radius_lat"
                           style="display: none;"><?php _e('Latitude', 'birkshya'); ?></label>
                </th>
                <td>
                    <input type="number" name="radius_lat" id="radius_lat" step="any" class="regular-text"
                           style="display: none;"
                           placeholder="<?php echo esc_attr('', 'brikshya'); ?>" value=""/>
                </td>
            </tr>
            <tr class="row-Radius_long">
                <th scope="row">
                    <label for="Radius" id="label_radius_long"
                           style="display: none;"><?php _e('Longitude', 'birkshya'); ?></label>
                </th>
                <td>
                    <input type="number" name="radius_long" id="radius_long" step="any" class="regular-text"
                           style="display: none;"
                           placeholder="<?php echo esc_attr('', 'birkshya'); ?>" value=""/>
                </td>
            </tr>
            <th scope="row">
                <label for="GeoJSON" id="label_GeoJSON" "><?php _e('GeoJSON', 'brikshya'); ?></label>
            </th>
            <td>
                <input type="file" name="GeoJSON" id="GeoJSON" class="regular-text"
                       placeholder="<?php echo esc_attr('', 'brikshya'); ?>" value=""/>
            </td>
            </tr>
            </tbody>
        </table>

        <hr>
        <h3>Markers:</h3>
        <div id="info">
        </div>
        <div id="counter">
            <input type="hidden" name="field_id" value="0">
        </div>
        <p class="description">Please <a href="<?= basename('wp-admin/admin.php?page=marker&action=new') ?>">Add
                Marker</a>
            First!</p>
        <?php wp_nonce_field('map-new'); ?>
        <?php submit_button(__('Add Map', 'brikshya'), 'primary', 'submit_map'); ?>
    </form>
</div>


<script>

    jQuery(document).ready(function () {
        var x = 12;
        var marker_id;
        document.getElementById("zoom").value = x;
        document.getElementById("zoom-level").innerHTML = x;
        document.getElementById("counter").innerHTML = ("<input name='marker_counter' value='" + marker_id + "' placeholder='0' type='hidden' >");


    });


    function sagar_polylines() {
        if (document.getElementById('polylines_set').checked) {
            document.getElementById('polylines').style.display = 'block';
            document.getElementById('label_polylines').style.display = 'block';
            document.getElementById('description_polylines').style.display = 'block';
            document.getElementById('description_polylines1').style.display = 'block';
        } else {
            document.getElementById('polylines').style.display = 'none';
            document.getElementById('label_polylines').style.display = 'none';
            document.getElementById('description_polylines').style.display = 'none';
            document.getElementById('description_polylines1').style.display = 'none';
        }

    }


    function sagar_radius() {
        if (document.getElementById('radius_set').checked) {
            document.getElementById('radius_lat').style.display = 'block';
            document.getElementById('desc_rad').style.display = 'block';
            document.getElementById('label_radius_lat').style.display = 'block';
            document.getElementById('radius_long').style.display = 'block';
            document.getElementById('label_radius_long').style.display = 'block';
            document.getElementById('radius').style.display = 'block';
            document.getElementById('label_radius').style.display = 'block';
        } else {
            document.getElementById('radius_lat').style.display = 'none';
            document.getElementById('desc_rad').style.display = 'none';
            document.getElementById('label_radius_lat').style.display = 'none';
            document.getElementById('radius_long').style.display = 'none';
            document.getElementById('label_radius_long').style.display = 'none';
            document.getElementById('radius').style.display = 'none';
            document.getElementById('label_radius').style.display = 'none';
        }

    }


    function zoomchange() {
        var x = document.getElementById("zoom").value;
        document.getElementById("zoom-level").innerHTML = x;
    }

    function initMap() {

        var markers = [];

        let map;
        let home_marker_url='<?php echo  plugins_url('orange_marker.png', __FILE__ )?>';
        let marker_id = 1;
        let marker_address_id;
        let marker_lat;
        let marker_long;
        let marke;
        let marker;
        let myLatlng = new google.maps.LatLng(28.225342661880788, 83.99323885685408);
        let geocoder = new google.maps.Geocoder();
        let infowindow = new google.maps.InfoWindow();

        let mapOptions = {
            zoom: 13,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById("map"), mapOptions);

        marker = new google.maps.Marker({
            map: map,
            position: myLatlng,
            icon : home_marker_url,
            draggable: true
        });

        geocoder.geocode({'latLng': myLatlng}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    jQuery('#map_address').val(results[0].formatted_address);
                    jQuery('#main_lat').val(marker.getPosition().lat());
                    jQuery('#main_long').val(marker.getPosition().lng());
                }
            }
        });

        google.maps.event.addListener(marker, 'dragend', function () {
            geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        jQuery('#map_address').val(results[0].formatted_address);
                        jQuery('#main_lat').val(marker.getPosition().lat);
                        jQuery('#main_long').val(marker.getPosition().lng);

                    }
                }
            });
        });

        // infowindow.setContent(results[0].formatted_address);

        map.addListener('click', function (e) {

            placeMarkerAndPanTo(e.latLng, map);
            var geocoder = geocoder = new google.maps.Geocoder();
            var lat = e.latLng.lat();
            var lang = e.latLng.lng();
            var latlng = new google.maps.LatLng(lat, lang);


            function placeMarkerAndPanTo(latLng, map) {
                var marke = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    marker_id: marker_id,
                    draggable: true
                });
                infowindow = new google.maps.InfoWindow({
                    content: 'Marker S.No '+(marker_id)
                });
                marke.addListener('click', function() {
                    infowindow.open(map, marke);
                });
                map.panTo(latLng);

                google.maps.event.addListener(marker, 'dragend', function () {
                    geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[0]) {
                                jQuery('#map_address').val(results[0].formatted_address);
                                jQuery('#main_lat').val(marker.getPosition().lat);
                                jQuery('#main_long').val(marker.getPosition().lng);

                            }
                        }
                    });
                });
                marke.addListener('dragend', function () {
                    geocoder.geocode({'latLng': marke.getPosition()}, function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[0]) {
                                jQuery('#address_'+marke.marker_id).val(results[0].formatted_address);
                                jQuery('#lat_'+marke.marker_id).val(marke.getPosition().lat);
                                jQuery('#lang_'+marke.marker_id).val(marke.getPosition().lng);

                            }
                        }
                    });
                });
            }




            geocoder.geocode({'latLng': latlng}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                        address = results[1].formatted_address;
                    }
                } else {
                    address = "Unidentified Place";
                }
                let form = jQuery("<div id='marker_div_" + marker_id + "' class=\"sagar\">\n" +
                    "SN " + marker_id +
                    "    <input type=\"text\" id='address_" + marker_id + "'  value='" + address + "'  name='address_" + marker_id + "'  class=\"name\">\n" +
                    "<tr class=\"row-map-address\">\n" +
                    "    <input type=\"hidden\" value='" + lat + "'  name='lat_" + marker_id + "'  id='lat_" + marker_id + "' class=\"name\">\n" +
                    "    <input type=\"hidden\" value='" + lang + "'  name='lang_" + marker_id + "' id='lang_" + marker_id + "' class=\"name\">\n" +
                    "<select class=\"dropdown\" id=\"mydropdown\"  name='marker_" + marker_id + "' title=\"My Dropdown\">" +
                    "<option value=\"\">Select Marker</option>" +
                    "<?php
                        global $wpdb;
                        $table_name = $wpdb->prefix . "brikshya_map_marker";
                        $charset_collate = $wpdb->get_charset_collate();
                        $map_markers = $wpdb->get_results("SELECT * FROM $table_name");
                        if (is_array($map_markers)) {
                        foreach ($map_markers as $map_marker) {
                        ?>" +
                    "<option  value=\"<?=$map_marker->slug?>\"><?=$map_marker->marker_name?></option>" +
                    "<?php }
                        }
                        ?>" +
                    "<select/>" +
                    "" +
                    "</div>");

                jQuery("#info").append(form);
                document.getElementById("counter").innerHTML = ("<input name='marker_counter' value='" + marker_id + "' placeholder='0' type='hidden' >");
                marker_id++;
            });





        });


    }

    function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
        }
    }

    // Removes the markers from the map, but keeps them in the array.
    function clearMarkers() {
        setMapOnAll(null);
    }

    // Shows any markers currently in the array.
    function showMarkers() {
        setMapOnAll(map);
    }

    // Deletes all markers in the array by removing references to them.
    function deleteMarkers() {
        clearMarkers();
        markers = [];
    }


</script>
<script defer
        src="http://maps.googleapis.com/maps/api/js?key=<?= get_option('wp_brikhsya_gmap_api_key'); ?>&libraries=places&callback=initMap"></script>