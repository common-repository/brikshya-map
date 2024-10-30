<?php defined('ABSPATH') or die('No script kiddies please!');
if (!defined('WPINC')) {
    die;
}
$map_api = get_option('wp_brikhsya_gmap_api_key');
if ($map_api == ""):
    echo '<div class="wrap"><div class="error">Please <a href=' . admin_url("admin.php?page=settings") . '>save</a> Google Map API key first.</div></div>';
endif;
if (isset($_GET['message'])) {
    $msg = $_GET['message'];
    if ($msg == "update") {
        echo '<div class="wrap"><div class="success">Map Successfully Updated</div></div>';
    } else {
        echo '<div class="wrap"><div class="success">Map Successfully Added</div></div>';
    }
}

?>
<div class="wrap">
    <h2><?php _e('Maps', 'brikshya'); ?> <a href="<?php echo admin_url('admin.php?page=map&action=new'); ?>"
                                            class="add-new-h2"><?php _e('Add New', 'brikshya'); ?></a></h2>

    <form method="post">
        <input type="hidden" name="page" value="ttest_list_table">

        <?php
        $list_table = new BKTMP_Map_List_Table();
        $list_table->prepare_items();
        $list_table->search_box('search', 'search_id');
        $list_table->display();
        ?>
    </form>
</div>