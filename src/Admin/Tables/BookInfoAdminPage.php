<?php

namespace BookStorePlugin\Admin\Tables;

/**
 * Class BookInfoAdminPage
 *
 * Handles the administration page for Books Info.
 *
 * @package BookStorePlugin\Admin
 */
class BookInfoAdminPage {

    /**
     * Constructor for the BookInfoAdminPage class.
     * Hooks into WordPress admin_menu and admin_enqueue_scripts actions.
     */
    public function __construct() {
        add_action('admin_menu', [$this, 'addAdminMenu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdminStyles']);
    }

    /**
     * Adds the Books Info menu page to the WordPress admin menu.
     */
    public function addAdminMenu(): void {
        add_menu_page(
            __('Books Info', 'bookstore-plugin'),
            __('Books Info', 'bookstore-plugin'),
            'manage_options',
            'books-info',
            [$this, 'renderAdminPage'],
            'dashicons-book-alt'
        );
    }

    /**
     * Enqueues the necessary admin styles for the WP_List_Table.
     */
    public function enqueueAdminStyles(): void {
        wp_enqueue_style('wp-list-table');
    }

    /**
     * Renders the Books Info admin page.
     *
     * Creates an instance of the WP_List_Table class, prepares items, and displays the table.
     */
    public function renderAdminPage(): void {
        // Create an instance of the WP_List_Table class
        $books_info_table = new BookInfoListTable();

        // Prepare items for the table
        $books_info_table->prepare_items();

        // Display the table
        $books_info_table->display();
    }
}

// Initialize the BookInfoAdminPage class
new BookInfoAdminPage();
