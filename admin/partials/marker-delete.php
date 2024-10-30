<?php defined('ABSPATH') or die('No script kiddies please!');?>
global $wpdb;
$removefromdb = $wpdb->query("DELETE FROM wp_brikshya_map_marker WHERE id = $id");
wp_redirect(admin_url('admin.php?page=map'));
?>
