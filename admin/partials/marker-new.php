<?php defined('ABSPATH') or die('No script kiddies please!');?>
<div class="wrap">

    <h1><?php _e('Markers', 'brikshya'); ?></h1><?php
    if (isset($_GET['message'])) {
        echo '<div class="success">Marker Successfully Added</div>';
    }
    //?>

    <?php
    if (isset($_GET['error'])) {
        $errors = ($_GET['error']);
        foreach ($errors as $error) {
            if ($error == 'Error:MarkerNameisrequired') {
                echo '<div class="error">Marker Name Required</div>';
                $name_error = "Please Enter Valid Name";
            }

        }
    }
    $sagar = "sagar";
    ?>

    <form action="" method="post" enctype="multipart/form-data">

        <table class="form-table">
            <tbody>
            <tr class="row-marker-name">
                <th scope="row">
                    <label for="marker_name"><?php _e('Marker Name', 'brikshya'); ?></label>
                </th>
                <td>
                    <input type="text" name="marker_name" id="marker_name"

                           class="regular-text <?php if (isset($name_error)) echo $sagar ?>"
                           placeholder="<?php echo esc_attr('', 'brikshya'); ?>" value=""/>
                </td>
            </tr>
            <tr class="row-marker-detail">
                <th scope="row">
                    <label for="marker_detail"><?php _e('Detail', 'brikshya'); ?></label>
                </th>
                <td>
                    <textarea name="marker_detail" id="marker_detail"
                              placeholder="<?php echo esc_attr('', 'brikshya'); ?>" rows="5" cols="30"
                    ></textarea>
                </td>
            </tr>
            <tr class="row-marker-image-id">
                <th scope="row">
                    <label for="marker_image_id"><?php _e('Image', 'brikshya'); ?></label>
                </th>
                <td>
                    <input type="file" name="marker_image[]" id="marker_image_id" class="regular-text"
                    />
                </td>
            </tr>
            </tbody>
        </table>

        <input type="hidden" name="field_id" value="0">

        <?php wp_nonce_field('marker-new'); ?>
        <?php submit_button(__('Add Marker', 'brikshya'), 'primary', 'submit_marker'); ?>
    </form>
</div>