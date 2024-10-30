<?php defined('ABSPATH') or die('No script kiddies please!');
$item = BKTMP_Get_Map($id);
?>
<div class="wrap">
    <h1><?= $item->map_name ?></h1>
</div>
<table class="form-table">
    <tbody>
    <tr class="row-marker-shortcode">
        <th scope="row">
            <label id="shortcode" style="cursor: copy;" onclick="copy(this)">[briskhya_map <?= $item->id ?>]</label>
            <br>
            <p class="description"><?php _e('copy shortcode', 'brikshya'); ?></p>
        </th>
    </tr>
    <tr class="row-marker-center">
        <th scope="row">
            <label for="Map Center Point"><?php _e('Lat,Lang:', 'brikshya'); ?></label>
        </th>
        <td>(<?= $item->main_lat ?>,<?= $item->main_long ?>)
        </td>
    </tr>
    <tr class="row-marker-name">
        <th scope="row">
            <label for="Address"><?php _e('Address:', 'brikshya'); ?></label>
        </th>
        <td><?= $item->map_address ?>
        </td>
    </tr>
    <tr class="row-marker-name">
        <th scope="row">
            <label for="Marker Dimention"><?php _e('Detail:', 'brikshya'); ?></label>
        </th>
        <td><?= $item->map_detail ?>
        </td>
    </tr>
    <tr class="row-marker-name">
        <th scope="row">
            <label for="Stylesheet"><?php _e('Stylesheet:', 'brikshya'); ?></label>
        </th>
        <td><?= $item->style ?>
        </td>
    </tr>
    <tr class="row-marker-marker">
        <th scope="row">
            <label for="Marker"><?php _e('Sheet:', 'brikshya'); ?></label>
        </th>
        <td><?= $item->height ?>px x <?= $item->width ?>px
        </td>
    </tr>
    <tr class="row-marker-date">
        <th scope="row">
            <label for="Marker Date"><?php _e('Date Created:', 'brikshya'); ?></label>
        </th>
        <td><?= $item->date ?>
        </td>
    </tr>
    </tbody>
</table>
<a href="<?= basename('wp-admin/admin.php?page=map&action=edit&id=') . $item->id ?>">Edit</a>
