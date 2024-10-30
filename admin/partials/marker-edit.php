<?php defined('ABSPATH') or die('No script kiddies please!');?>
<div class="wrap">
    <h1><?php _e( 'Markers', 'brikshya' ); ?></h1>

    <?php $item = BKTMP_Get_Marker( $id ); ?>

    <form action="" method="post">

        <table class="form-table">
            <tbody>
            <tr class="row-marker-name">
                <th scope="row">
                    <label for="marker_name"><?php _e( 'Marker Name', 'brikshya' ); ?></label>
                </th>
                <td>
                    <input type="text" name="marker_name" id="marker_name" class="regular-text" placeholder="<?php echo esc_attr( '', 'brikshya' ); ?>" value="<?php echo esc_attr( $item->marker_name ); ?>" required="required" />
                </td>
            </tr>
            <tr class="row-marker-slug">
                <th scope="row">
                    <label for="marker_name"><?php _e( 'Slug', 'brikshya' ); ?></label>
                </th>
                <td>
                    <input type="text" name="" id="marker_slug" class="regular-text" disabled placeholder="<?php echo esc_attr( '', 'brikshya' ); ?>" value="<?php echo esc_attr( $item->slug ); ?>" required="required" />
                </td>
            </tr>
            <tr class="row-marker-detail">
                <th scope="row">
                    <label for="marker_detail"><?php _e( 'Detail', 'brikshya' ); ?></label>
                </th>
                <td>
                    <textarea name="marker_detail" id="marker_detail"placeholder="<?php echo esc_attr( '', 'brikshya' ); ?>" rows="5" cols="30" required="required"><?php echo esc_textarea( $item->marker_detail ); ?></textarea>
                </td>
            </tr>
<!--            <tr class="row-marker-image-id">-->
<!--                <th scope="row">-->
<!--                    <label for="marker_image_id">--><?php //_e( '', 'brikshya' ); ?><!--</label>-->
<!--                </th>-->
<!--                <td>-->
                    <input type="hidden" name="marker_image_id" id="marker_image_id" class="regular-text" placeholder="<?php echo esc_attr( '', 'brikshya' ); ?>" value="<?php echo esc_attr( $item->marker_image_id ); ?>" required="required" />
<!--                </td>-->
<!--            </tr>-->
            </tbody>
        </table>

        <input type="hidden" name="field_id" value="<?php echo $item->id; ?>">

        <?php wp_nonce_field( 'marker-new' ); ?>
        <?php submit_button( __( 'Update Marker', 'brikshya' ), 'primary', 'update_marker' ); ?>

    </form>
</div>