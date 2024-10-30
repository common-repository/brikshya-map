<?php

defined('ABSPATH') or die('No script kiddies please!');
if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * List table class
 */
class BKTMP_Marker_List_Table extends \WP_List_Table
{

    function __construct()
    {
        parent::__construct(array(
            'singular' => 'Marker',
            'plural' => 'Markers',
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
        _e('No Marker Found', 'birkshya');
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
            case 'marker_name':
                return $item->marker_name;

            case 'marker_detail':
                return $item->marker_detail;

            case 'marker_image_id':
                $img_slug = $item->slug;
                $id = BKTMP_Imgid_From_Slug($img_slug);
                $img_url = wp_get_attachment_image($id, 'thumbnail');
                return $img_url;


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
            'marker_name' => __('Marker Name', 'birkshya'),
            'marker_detail' => __('Detail', 'birkshya'),
            'marker_image_id' => __('Pin', 'birkshya'),

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
    function column_marker_name($item)
    {

        $actions = array();
        $actions['edit'] = sprintf('<a href="%s" data-id="%d" title="%s">%s</a>', admin_url('admin.php?page=marker&action=edit&id=' . $item->id), $item->id, __('Edit this item', 'birkshya'), __('Edit', 'birkshya'));
        $actions['delete'] = sprintf('<a href="%s" class="submitdelete" data-id="%d" title="%s">%s</a>', admin_url('admin.php?page=marker&action=delete&id=' . $item->id), $item->id, __('Delete this item', 'birkshya'), __('Delete', 'birkshya'));

        return sprintf('<a href="%1$s"><strong>%2$s</strong></a> %3$s', admin_url('admin.php?page=marker&action=view&id=' . $item->id), $item->marker_name, $this->row_actions($actions));
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
            'delete' => __('Delete Marker', 'birkshya'),
        );
        return $actions;
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
            '<input type="checkbox" name="Marker_id[]" value="%d" />', $item->id
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

        $this->items = BKTMP_Get_All_Marker($args);

        $this->set_pagination_args(array(
            'total_items' => BKTMP_Get_Marker_Count(),
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
                foreach ($_POST['Marker_id'] as $event) {
                    $wpdb->delete($wpdb->prefix . 'brikshya_map_marker', array('id' => $event));
                }
                ob_start();
                ob_flush();
                $redirect_to = add_query_arg(array('message' => 'update'), $page_url_success);
//                wp_safe_redirect($redirect_to);
            }
        }
    }
}