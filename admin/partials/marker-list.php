<?php defined('ABSPATH') or die('No script kiddies please!');?>
<div class="wrap">
    <h2><?php _e('Marker', 'birkshya'); ?> <a href="<?php echo admin_url('admin.php?page=marker&action=new'); ?>"
                                              class="add-new-h2"><?php _e('Add New', 'birkshya'); ?></a></h2>
    <?php
    if (isset($_GET['message'])) {
        $msg = $_GET['message'];
        if ($msg == "update") {
            echo '<div class="wrap"><div class="success">Marker Successfully Updated</div></div>';
        } else {
            echo '<div class="wrap"><div class="success">Marker Successfully Added</div></div>';
        }
    }
    ?>

    <form method="post">
        <input type="hidden" name="page" value="ttest_list_table">

        <?php
        $list_table = new BKTMP_Marker_List_Table();
        $list_table->prepare_items();
        $list_table->search_box('search', 'search_id');
        $list_table->display();
        ?>
    </form>
</div>
