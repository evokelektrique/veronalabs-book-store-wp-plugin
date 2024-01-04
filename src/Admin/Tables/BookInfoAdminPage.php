<?php

namespace BookStorePlugin\Admin\Tables;

/**
 * Class BookInfoAdminPage
 *
 * @package BookStorePlugin\Admin
 */
class BookInfoAdminPage {

    /**
     * Hook into the admin menu and page creation.
     */
    public function __construct() {
        add_action('admin_menu', array($this, 'addAdminMenu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueueAdminStyles'));
    }

    /**
     * Add admin menu and page.
     */
    public function addAdminMenu(): void {
        add_menu_page(
            __('Books Info', 'bookstore-plugin'),
            __('Books Info', 'bookstore-plugin'),
            'manage_options',
            'books-info',
            array($this, 'renderAdminPage'),
            'dashicons-book-alt'
        );
    }

    /**
     * Enqueue admin styles.
     */
    public function enqueueAdminStyles(): void {
        wp_enqueue_style('wp-list-table');
    }

    /**
     * Render the admin page.
     */
    public function renderAdminPage(): void {
        // Create an instance of the WP_List_Table class
        $books_info_table = new BookInfoListTable();

        // Fetch data from the books_info table
        $data = $this->getBooksInfoData();

        // Set the data for the table
        $books_info_table->set_data($data);

        // Display the table
        $books_info_table->display();
    }

    /**
     * Retrieve data from the books_info table.
     *
     * @return array
     */
    private function getBooksInfoData(): array {
        global $wpdb;

        // Replace 'books_info' with your actual table name
        $table_name = $wpdb->prefix . 'books_info';

        // Query to retrieve data from the table
        $query = "SELECT * FROM $table_name";

        // Fetch results
        $data = $wpdb->get_results($query, ARRAY_A);

        return $data;
    }
}

// Initialize the BookInfoAdminPage class
new BookInfoAdminPage();
