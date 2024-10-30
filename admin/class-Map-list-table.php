<?php

defined('ABSPATH') or die('No script kiddies please!');
//var_dump($_POST);
if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * List table class
 */
class BKTMP_Map_List_Table extends \WP_List_Table
{


    function __construct()
    {
        parent::__construct(array(
            'singular' => 'Map',
            'plural' => 'Maps',
            'ajax' => true
        ));
    }

    function get_table_classes()
    {
        return array('widefat', 'fixed', 'striped', $this->_args['plural']);
    }

    /**
     * Message to show if no designation found
     *
     * @return void
     */
    function no_items()
    {
        _e('No Map!', 'brikshya');
    }

    /**
     * Default column values if no callback found
     *
     * @param  object $item
     * @param  string $column_name
     *
     * @return string
     */
    function column_default($item, $column_name)
    {

        switch ($column_name) {
            case 'map_name':
                return $item->map_name;

            case 'map_address':
                return $item->map_address;

            case 'main_latlng':
                $lat = $item->main_lat;
                $lang = $item->main_long;
                $latlng = $lat;
                $latlng .= ', ';
                $latlng .= $lang;
                return $latlng;

            case 'main_sortcode':
                $sortcode = "<span style='cursor: copy;' onclick='copy(this)'> [briskhya_map $item->id ]</span>";
                return $sortcode;

            default:
                return isset($item->$column_name) ? $item->$column_name : '';
        }
    }

    /**
     * Get the column names
     *
     * @return array
     */
    function get_columns()
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'id' => __('ID', 'brikshya'),
            'map_name' => __('Map Name', 'brikshya'),
            'map_address' => __('Address', 'brikshya'),
            'main_latlng' => __('Latitude , Longitude', 'brikshya'),
            'main_sortcode' => __('Shortcode', 'brikshya'),

        );

        return $columns;
    }

    /**
     * Render the designation name column
     *
     * @param  object $item
     *
     * @return string
     */
    function column_map_name($item)
    {

        $actions = array();
        $actions['edit'] = sprintf('<a href="%s" data-id="%d" title="%s">%s</a>', admin_url('admin.php?page=map&action=edit&id=' . $item->id), $item->id, __('Edit this item', 'brikshya'), __('Edit', 'brikshya'));
        $actions['delete'] = sprintf('<a href="%s" class="submitdelete" data-id="%d" title="%s">%s</a>', admin_url('admin.php?page=map&action=delete&id=' . $item->id), $item->id, __('Delete this item', 'brikshya'), __('Delete', 'brikshya'));

        return sprintf('<a href="%1$s"><strong>%2$s</strong></a> %3$s', admin_url('admin.php?page=map&action=view&id=' . $item->id), $item->map_name, $this->row_actions($actions));
    }

    /**
     * Get sortable columns
     *
     * @return array
     */
    function get_sortable_columns()
    {
        $sortable_columns = array(
            'name' => array('name', true),
        );

        return $sortable_columns;
    }

    /**
     * Set the bulk actions
     *
     * @return array
     */
    function get_bulk_actions()
    {
        $actions = array(
            'delete' => __('Delete Map', 'brikshya'),
        );

        return $actions;

    }

    function search_box($text, $input_id)
    {
        if (empty($_REQUEST['s']) && !$this->has_items())
            return;

        $input_id = $input_id . '-search-input';

        if (!empty($_REQUEST['orderby']))
            echo '<input type="hidden" name="orderby" value="' . esc_attr($_REQUEST['orderby']) . '" />';
        if (!empty($_REQUEST['order']))
            echo '<input type="hidden" name="order" value="' . esc_attr($_REQUEST['order']) . '" />';
        if (!empty($_REQUEST['post_mime_type']))
            echo '<input type="hidden" name="post_mime_type" value="' . esc_attr($_REQUEST['post_mime_type']) . '" />';
        if (!empty($_REQUEST['detached']))
            echo '<input type="hidden" name="detached" value="' . esc_attr($_REQUEST['detached']) . '" />';
        ?>
        <p class="search-box">
            <label class="screen-reader-text" for="<?php echo esc_attr($input_id); ?>"><?php echo $text; ?>:</label>
            <input type="search" id="<?php echo esc_attr($input_id); ?>" name="s"
                   value="<?php _admin_search_query(); ?>"/>
            <?php submit_button($text, '', '', false, array('id' => 'search-submit')); ?>
        </p>
        <?php
    }

    /**
     * Render the checkbox column
     *
     * @param  object $item
     *
     * @return string
     */
    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="Map_id[]" value="%d" />', $item->id
        );
    }

    /**
     * Set the views
     *
     * @return array
     */
    public function get_views_()
    {
        $status_links = array();
        $base_link = admin_url('admin.php?page=sample-page');

        foreach ($this->counts as $key => $value) {
            $class = ($key == $this->page_status) ? 'current' : 'status-' . $key;
            $status_links[$key] = sprintf('<a href="%s" class="%s">%s <span class="count">(%s)</span></a>', add_query_arg(array('status' => $key), $base_link), $class, $value['label'], $value['count']);
        }

        return $status_links;
    }

    /**
     * Prepare the class items
     *
     * @return void
     */
    function prepare_items()
    {
        $this->process_bulk_action();
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);

        $per_page = 20;
        $current_page = $this->get_pagenum();
        $offset = ($current_page - 1) * $per_page;
        $this->page_status = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : '2';

        // only ncessary because we have sample data
        $args = array(
            'offset' => $offset,
            'number' => $per_page,
        );

        if (isset($_REQUEST['orderby']) && isset($_REQUEST['order'])) {
            $args['orderby'] = $_REQUEST['orderby'];
            $args['order'] = $_REQUEST['order'];
        }

        $this->items = BKTMP_Get_All_Map($args);

        $this->set_pagination_args(array(
            'total_items' => BKTMP_Get_Map_Count(),
            'per_page' => $per_page
        ));


    }

    function process_bulk_action()
    {
        if (isset($_POST['_wpnonce']) && !empty($_POST['_wpnonce'])) {
            $nonce = filter_input(INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING);

            $action = $this->current_action();

            $page_url_success = admin_url('admin.php?page=map&action=list');
            if ('delete' === $action) {
                global $wpdb;
                foreach ($_POST['Map_id'] as $event) {
                    $wpdb->delete($wpdb->prefix . 'brikshya_map_table', array('id' => $event));
                }
                ob_start();
                ob_flush();
            }
        }
    }

}
