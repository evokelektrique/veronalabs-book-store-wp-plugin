<?php

namespace BookStorePlugin\Admin\Tables;

use BookStorePlugin\Repositories\BookInfoRepository;
use Carbon\Carbon;

/**
 * Class BookInfoListTable
 */
class BookInfoListTable extends \WP_List_Table {

    /**
     * BookInfoListTable constructor.
     */
    public function __construct() {
        parent::__construct([
            'singular' => 'book_info',
            'plural'   => 'book_infos',
            'ajax'     => false,
        ]);
    }

    /**
     * Define the columns that are going to be used in the table.
     *
     * @return array
     */
    public function get_columns(): array {
        return [
            'id'         => __('ID', 'bookstore-plugin'),
            'post_id'    => __('Post ID', 'bookstore-plugin'),
            'isbn'       => __('ISBN', 'bookstore-plugin'),
            'created_at' => __('Created At', 'bookstore-plugin'),
            'updated_at' => __('Updated At', 'bookstore-plugin'),
        ];
    }

    /**
     * Prepare the items for the table to process.
     */
    public function prepare_items(): void {
        $columns  = $this->get_columns();
        $hidden   = [];
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = [$columns, $hidden, $sortable];

        // Retrieve data and set it
        $this->items = $this->get_data();

        // Pagination settings
        $per_page = 20; // Number of items per page
        $current_page = $this->get_pagenum();
        $total_items = count($this->items);

        // Slice the data for the current page
        $this->items = array_slice($this->items, (($current_page - 1) * $per_page), $per_page);

        // Set pagination parameters
        $this->set_pagination_args([
            'total_items' => $total_items,
            'per_page'    => $per_page,
            'total_pages' => ceil($total_items / $per_page),
        ]);
    }

    /**
     * Retrieve data for the table from the BookInfo repository.
     *
     * @return array
     */
    private function get_data(): array {
        // Instantiate the BookInfoRepository to interact with the data source
        $bookInfoRepository = new BookInfoRepository();

        // Fetch all data from the BookInfo repository and convert it to an array
        $data = $bookInfoRepository->all()->toArray();

        // Return the data array or an empty array if no data is found
        return $data ?: [];
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
            case 'created_at':
                return Carbon::parse($item[$column_name])->diffForHumans();
            case 'updated_at':
                return Carbon::parse($item[$column_name])->diffForHumans();
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
        return [
            'id'      => ['id', true],
            'post_id' => ['post_id', true],
            'isbn'    => ['isbn', false],
            'title'   => ['title', false],
        ];
    }
}
