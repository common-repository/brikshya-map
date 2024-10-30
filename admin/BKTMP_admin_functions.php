<?php

/**
 * The public-facing functionality of the plugin.
 *
 */

defined('ABSPATH') or die('No script kiddies please!');
function BKTMP_Map_Api_Key_Store()
{
    $map_api = get_option('wp_brikhsya_gmap_api_key');
    $ajax_nonce = wp_create_nonce("BKTMP_Map_Api_Key_Store_Ajax");
    ?>
    <div id="success_div" style="height: 80px">
    </div>
    <label for="api_key">API Key:</label>
    <input type="text" id="api_key" value="<?= ($map_api) ? $map_api : '' ?>">
    <button id="api_save">save</button>
    <p class="description">You can Generate Google Map API key from <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">this link</a> </p>
    <script type="application/javascript">
        jQuery(document).ready(function () {
            jQuery('#api_save').click(function () {
                var gmap_key = jQuery('#api_key').val();
                var data = {
                    'action': 'BKTMP_Map_Api_Key_Store_Ajax',
                    'security': '<?php echo $ajax_nonce; ?>',
                    'gmap_api': gmap_key
                };
                jQuery.post(ajaxurl, data, function (response) {

                    jQuery("#success_div").html(response);
                });
            });
        });

    </script>

    <?php
}

function BKTMP_Map_Api_Key_Store_Ajax()
{
    $s = check_ajax_referer('BKTMP_Map_Api_Key_Store_Ajax', 'security');
    $map_key = isset($_POST['gmap_api']) ? sanitize_text_field($_POST['gmap_api']) : '';
    $reasult = update_option('wp_brikhsya_gmap_api_key', $map_key);
    if ($reasult) {
        echo '<div class="success">Updated Google Map Api Key: ' . $map_key . '</div>';
    } else {
        echo '<div class="error">Unable to Update</div>';
    }

    wp_die();

}

add_action('wp_ajax_BKTMP_Map_Api_Key_Store_Ajax', 'BKTMP_Map_Api_Key_Store_Ajax');
