<?php defined('ABSPATH') or die('No script kiddies please!'); ?>
<div class="wrap">
    <h1><?php _e('Add Map', 'brikshya'); ?></h1>
    <?php $item = BKTMP_Get_Map($id);
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
            if ($error == 'Error:Widthisrequired') {
                echo '<div class="error">Width is required</div>';
                $width_error = " ";
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
    if (isset($item->radius) && !empty($item->radius)) {
        $radius_j = $item->radius;
        $radius_d = json_decode($radius_j, true);
        if (is_array($radius_d)) {
            $radius_lat = $radius_d['radius_lat'];
            $radius_long = $radius_d['radius_long'];
            $radius_r = $radius_d['radius'];
        } else {
            $radius_r = null;
            $radius_lat = '';
            $radius_long = '';
            $radius_r = '';
        }
    } else {
        $radius_r = null;
        $radius_lat = '';
        $radius_long = '';
        $radius_r = '';
    }
    ?>


    <form action="" method="post">

        <table class="form-table">
            <tbody>
            <tr class="row-map-name">
                <th scope="row">
                    <label for="map_name"><?php _e('Map Name', 'brikshya'); ?></label>
                </th>
                <td>
                    <input type="text" name="map_name" id="map_name"
                           class="regular-text <?php if (isset($name_error)) echo $sagar ?>"
                           placeholder="<?php echo esc_attr('', 'brikshya'); ?>"
                           value="<?php echo esc_attr($item->map_name); ?>" required="required"/>
                    <span class="description"><?php _e('Map Name For Your Identity ', 'brikshya'); ?></span>
                </td>
            </tr>
            <tr class="row-map-type">
                <th scope="row">
                    <label for="map_type"><?php _e('Map Type', 'brikshya'); ?></label>
                </th>
                <td>
                    <select class="regular-text" name="map_type">
                        <option value="roadmap" <?php if ($item->map_type == "roadmap") echo "selected" ?>>Roadmap
                        </option>
                        <option value="satellite" <?php if ($item->map_type == "satellite") echo "selected" ?>>
                            Satellite
                        </option>
                        <option value="hybrid"<?php if ($item->map_type == "hybrid") echo "selected" ?>>Hybrid</option>
                        <option value="terrain" <?php if ($item->map_type == "terrain") echo "selected" ?>>Terrain
                        </option>
                    </select>
                    <span class="description"><?php _e('Map Name For Your Identity ', 'brikshya'); ?></span>
                </td>
            </tr>
            <tr class="row-height">
                <th scope="row">
                    <label for="height"><?php _e('Height', 'brikshya'); ?></label>
                </th>
                <td>
                    <input type="text" name="height" id="height"
                           class="regular-text <?php if (isset($name_error)) echo $sagar ?>"
                           placeholder="<?php echo esc_attr('', 'brikshya'); ?>"
                           value="<?php echo esc_attr($item->height); ?>" required="required"/>
                    <span class="description"><?php _e('Enter Hight In pixel that You need For Your Website', 'brikshya'); ?></span>
                </td>
            </tr>
            <tr class="row-width">
                <th scope="row">
                    <label for="width"><?php _e('Width', 'brikshya'); ?></label>
                </th>
                <td>
                    <input type="text" name="width" id="width"
                           class="regular-text <?php if (isset($name_error)) echo $sagar ?>"
                           placeholder="<?php echo esc_attr('', 'brikshya'); ?>"
                           value="<?php echo esc_attr($item->width); ?>" required="required"/>
                    <span class="description"><?php _e('Enter Width In pixel that You need For Your Website', 'brikshya'); ?></span>
                </td>
            </tr>
            <tr class="row-map-detail">
                <th scope="row">
                    <label for="map_detail"><?php _e('Detail', 'brikshya'); ?></label>
                </th>
                <td>
                    <input type="text" name="map_detail" id="map_detail" class="regular-text"
                           placeholder="<?php echo esc_attr('', 'brikshya'); ?>"
                           value="<?php echo esc_attr($item->map_detail); ?>"/>
                    <span class="description"><?php _e('Enter Map detail for Better Understanding', 'brikshya'); ?></span>
                </td>
            </tr>
            <tr class="row-map-address">
                <th scope="row">
                    <label for="map_address"><?php _e('Address', 'brikshya'); ?></label>
                </th>
                <td>
                    <input type="text" name="map_address" id="map_address"
                           class="regular-text <?php if (isset($name_error)) echo $sagar ?>"
                           placeholder="<?php echo esc_attr('', 'brikshya'); ?>"
                           value="<?php echo esc_attr($item->map_address); ?>" required="required"/>
                </td>
            </tr>
            <tr class="row-main-lat">
                <th scope="row">
                    <label for="main_lat"><?php _e('lat', 'brikshya'); ?></label>
                </th>
                <td>
                    <input type="text" name="main_lat" id="main_lat" step="any"
                           class="regular-text <?php if (isset($name_error)) echo $sagar ?>"
                           placeholder="<?php echo esc_attr('', 'brikshya'); ?>"
                           value="<?php echo esc_attr($item->main_lat); ?>" required="required"/>
                </td>
            </tr>
            <tr class="row-main-long">
                <th scope="row">
                    <label for="main_long"><?php _e('long', 'brikshya'); ?></label>
                </th>
                <td>
                    <input type="text" name="main_long" id="main_long" step="any"
                           class="regular-text <?php if (isset($name_error)) echo $sagar ?>"
                           placeholder="<?php echo esc_attr('', 'brikshya'); ?>"
                           value="<?php echo esc_attr($item->main_long); ?>" required="required"/>
                </td>
            </tr>
            <tr class="row-zoom">
                <th scope="row">
                    <label for="zoom"><?php _e('Zoom Level: ', 'brikshya'); ?><span id="zoom-level"></span></label>
                </th>
                <td>
                    <input type="range" class="regular-text <?php if (isset($name_error)) echo $sagar ?>" id="zoom"
                           onchange="zoomchange()" name="zoom" min="0"
                           max="19">


                    <p class="description"><?php _e('Enter Width In pixel that You need For Your Website', 'brikshya'); ?></p>
                </td>
            </tr>
            <tr class="row-style">
                <th scope="row">
                    <label for="style"><?php _e('style', 'brikshya'); ?></label>
                </th>
                <td>
                    <textarea name="style" id="style"
                              placeholder="<?php echo esc_attr('lat, long , lat, long', 'brikshya'); ?>" rows="5"
                              cols="30"><?php echo esc_attr($item->style); ?></textarea>
                    <p class="description"><?php _e('This stypesheet will be applied to the Map on loading to the Website. Include css without any bracket <span class="tooltip"> Example<span class="tooltiptext">visibility: hidden; width: 120px;<br>  background-color: black;<br>color: #fff;<br>text-align:left;<br>border-radius: 6px;<br>padding: 5px 0;</span></span>', 'brikshya'); ?></p>
                </td>
            </tr>
            <tr class="row-polylines-set">
                <th scope="row">
                    <?php _e('Set Polylines', 'fdsa'); ?>
                </th>
                <td>
                    <label for="polylines_set"><input type="checkbox" <?php if (($item->polylines)) echo 'checked'; ?>
                                                      name="polylines_set" onclick="sagar_polylines()"
                                                      id="polylines_set"
                                                      value="on"/> <?php _e('', 'fdsa'); ?></label>
                </td>
            </tr>
            <tr class="row-polylines">

                <th scope="row">
                    <label for="polylines" id="label_polylines"
                        <?php if (!($item->polylines)) echo 'style="display: none;"'; ?>><?php _e('Polylines', 'fdsa'); ?></label>
                </th>
                <td>
                    <textarea name="polylines"
                              id="polylines" <?php if (!($item->polylines)) echo 'style="display: none;"'; ?>
                              placeholder="<?php echo esc_attr('', 'fdsa'); ?>" rows="5"
                              cols="30"><?php echo esc_attr($item->polylines); ?></textarea>
                    <p class="description" id="description_polylines"
                       style="display: none;"><?php _e('Entering wrong format of polylines will lead to erros on google map <span class="tooltip"> Example<span class="tooltiptext">28.261576, 83.979304, 28.261038, 83.979561,28.260574, 83.979894,28.258906, 83.981064,28.257252, 83.981484,28.254419, 83.982925, 28.249180, 83.986726,28.248298, 83.986265,28.246143, 83.987958,28.245696, 83.988972</span></span>', 'fdsa'); ?></p>
                </td>
            </tr>
            <tr class="row-radius-set">
                <th scope="row">
                    <?php _e('Set Radius', 'fdsa'); ?>
                </th>
                <td>
                    <label for="radius_set"><input <?php if ($radius_r != null) echo 'checked'; ?> type="checkbox"
                                                                                                   name="radius_set"
                                                                                                   onclick="sagar_radius()"
                                                                                                   id="radius_set"
                                                                                                   value="on"/> <?php _e('', 'fdsa'); ?>
                    </label>
                </td>
            </tr>
            <tr class="row-Radius">
                <th scope="row">
                    <label for="Radius"
                           id="label_radius" <?php if ($radius_r == null) echo 'style="display: none;"'; ?>><?php _e('Radius', 'fdsa'); ?></label>
                </th>
                <td>
                    <input type="number" min="0" name="radius" id="radius" step="any" class="regular-text"
                        <?php if ($radius_r == null) echo 'style="display: none;"'; ?>
                           placeholder="<?php echo esc_attr('', 'brikshya'); ?>"
                           value="<?php echo esc_attr($radius_r); ?>"/>
                    <p class="description" id="desc_rad"
                        <?php if ($radius_r == null) echo 'style="display: none;"'; ?>><?php _e('Enter Radius In meters', 'brikshya'); ?></p>
                </td>
            </tr>
            <tr class="row-Radius_lat">
                <th scope="row">
                    <label for="Radius_lat" id="label_radius_lat"
                        <?php if ($radius_r == null) echo 'style="display: none;"'; ?>><?php _e('Latitude', 'birkshya'); ?></label>
                </th>
                <td>
                    <input type="number" name="radius_lat" id="radius_lat" step="any" class="regular-text"
                        <?php if ($radius_r == null) echo 'style="display: none;"'; ?>
                           placeholder="<?php echo esc_attr('', 'brikshya'); ?>"
                           value="<?php echo esc_attr($radius_lat); ?>"/>
                    <p class="description" id="desc_rad1"
                        <?php if ($radius_r == null) echo 'style="display: none;"'; ?>>Please Use <a
                                href="https://www.latlong.net/" target="_blank">latlong</a>
                        or similar sites to get latitude and longitude </p>
                </td>
            </tr>

            <tr class="row-Radius_long">
                <th scope="row">
                    <label for="Radius" id="label_radius_long"
                        <?php if ($radius_r == null) echo 'style="display: none;"'; ?>><?php _e('Longitude', 'birkshya'); ?></label>
                </th>
                <td>
                    <input type="number" name="radius_long" id="radius_long" class="regular-text"
                        <?php if ($radius_r == null) echo 'style="display: none;"'; ?>
                           placeholder="<?php echo esc_attr('', 'birkshya'); ?>"
                           value="<?php echo esc_attr($radius_long); ?>"/>
                </td>
            </tr>
            </tbody>
        </table>
        <input type="hidden" name="field_id" value="<?php echo $item->id; ?>">
        <?php
        $zoom = $item->zoom;
        wp_nonce_field('map-new'); ?>
        <?php submit_button(__('Update Map', 'brikshya'), 'primary', 'update_map'); ?>

    </form>
</div>
<script>
    jQuery(document).ready(function () {
        var x = '<?=$zoom?>';
        document.getElementById("zoom").value = x;
        document.getElementById("zoom-level").innerHTML = x;

    });

    function zoomchange() {
        var x = document.getElementById("zoom").value;
        document.getElementById("zoom-level").innerHTML = x;
    }

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
            document.getElementById('desc_rad1').style.display = 'block';
            document.getElementById('label_radius_lat').style.display = 'block';
            document.getElementById('radius_long').style.display = 'block';
            document.getElementById('label_radius_long').style.display = 'block';
            document.getElementById('radius').style.display = 'block';
            document.getElementById('label_radius').style.display = 'block';
        } else {
            document.getElementById('radius_lat').style.display = 'none';
            document.getElementById('desc_rad').style.display = 'none';
            document.getElementById('desc_rad1').style.display = 'none';
            document.getElementById('label_radius_lat').style.display = 'none';
            document.getElementById('radius_long').style.display = 'none';
            document.getElementById('label_radius_long').style.display = 'none';
            document.getElementById('radius').style.display = 'none';
            document.getElementById('label_radius').style.display = 'none';
        }

    }


</script>