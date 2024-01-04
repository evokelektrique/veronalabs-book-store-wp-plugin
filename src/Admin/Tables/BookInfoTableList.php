<?php

namespace BookStorePlugin\Admin\Tables;

/**
 * Class BookInfoListTable
 */
class BookInfoListTable extends \WP_List_Table {

    /**
     * BookInfoListTable constructor.
     */
    public function __construct() {
        parent::__construct(array(
            'singular' => 'book_info',
            'plural'   => 'book_infos',
            'ajax'     => false,
        ));
    }

    /**
     * Define the columns that are going to be used in the table.
     *
     * @return array
     */
    public function get_columns(): array {
        return array(
            'id'    => __('ID', 'bookstore-plugin'),
            'isbn'  => __('ISBN', 'bookstore-plugin'),
            'title' => __('Title', 'bookstore-plugin'),
            // Add more columns as needed
        );
    }

    /**
     * Prepare the items for the table to process.
     */
    public function prepare_items(): void {
        $columns  = $this->get_columns();
        $hidden   = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);

        $this->items = $this->get_data();
    }

    /**
     * Retrieve data for the table.
     *
     * @return array
     */
    private function get_data(): array {
        // Fetch data from the source (e.g., books_info table)
        // You can customize this method based on your data source

        return array();
    }

    /**
     * Default column rendering method.
     *
     * @param array  $item        The current item.
     * @param string $column_name The name/slug of the column.
     *
     * @return mixed
     */
    public function column_default($item, $column_name): mixed {
        switch ($column_name) {
            case 'id':
                return $item[$column_name];
            case 'post_id':
                return $item[$column_name];
            case 'isbn':
                return $item[$column_name];

            default:
                return print_r($item, true);
        }
    }

    /**
     * Make columns sortable.
     *
     * @return array
     */
    public function get_sortable_columns(): array {
        return array(
            'id'    => array('id', false),
            'isbn'  => array('isbn', false),
            'title' => array('title', false),
            // Add more sortable columns as needed
        );
    }
}
