<?php

namespace BookStorePlugin\PostTypes;

use BookStorePlugin\Repositories\BookInfoRepository;

/**
 * Class BookPostType
 *
 * @package BookStorePlugin\PostTypes
 */
class BookPostType {

    private BookInfoRepository $booksInfoRepository;

    /**
     * BookPostType constructor.
     */
    public function __construct() {
        $this->booksInfoRepository = new BookInfoRepository();

        // Register the Book post type
        add_action('init', array($this, 'registerBookPostType'));

        // Register the taxonomies
        add_action('init', array($this, 'registerTaxonomies'));

        // Add meta box for ISBN number
        add_action('add_meta_boxes', array($this, 'addISBNMetaBox'));

        // Save ISBN number to books_info table
        add_action('save_post', array($this, 'saveISBN'));
    }

    /**
     * Register the 'Book' custom post type.
     */
    public function registerBookPostType(): void {
        $labels = [
            'name'               => _x('Books', 'post type general name', 'bookstore-plugin'),
            'singular_name'      => _x('Book', 'post type singular name', 'bookstore-plugin'),
            'menu_name'          => _x('Books', 'admin menu', 'bookstore-plugin'),
            'name_admin_bar'     => _x('Book', 'add new on admin bar', 'bookstore-plugin'),
            'add_new'            => _x('Add New', 'book', 'bookstore-plugin'),
            'add_new_item'       => __('Add New Book', 'bookstore-plugin'),
            'new_item'           => __('New Book', 'bookstore-plugin'),
            'edit_item'          => __('Edit Book', 'bookstore-plugin'),
            'view_item'          => __('View Book', 'bookstore-plugin'),
            'all_items'          => __('All Books', 'bookstore-plugin'),
            'search_items'       => __('Search Books', 'bookstore-plugin'),
            'parent_item_colon'  => __('Parent Books:', 'bookstore-plugin'),
            'not_found'          => __('No books found.', 'bookstore-plugin'),
            'not_found_in_trash' => __('No books found in Trash.', 'bookstore-plugin'),
        ];

        $args = [
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'book'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
        ];

        register_post_type('book', $args);
    }


    /**
     * Register the 'Publisher' and 'Authors' taxonomies.
     */
    public function registerTaxonomies(): void {
        // Register Publisher taxonomy
        register_taxonomy('publisher', 'book', [
            'label'        => __('Publisher', 'bookstore-plugin'),
            'rewrite'      => array('slug' => 'publishers'),
            'hierarchical' => true,
        ]);

        // Register Authors taxonomy
        register_taxonomy('authors', 'book', [
            'label'        => __('Authors', 'bookstore-plugin'),
            'rewrite'      => array('slug' => 'authors'),
            'hierarchical' => true,
        ]);
    }


    /**
     * Add ISBN Meta Box to the 'Book' post type.
     */
    public function addISBNMetaBox(): void {
        add_meta_box(
            'isbn_meta_box',
            __('ISBN Number', 'bookstore-plugin'),
            [$this, 'renderISBNMetaBox'],
            'book',
            'normal',
            'high'
        );
    }

    /**
     * Render the content of ISBN Meta Box.
     *
     * @param \WP_Post $post The current post object.
     */
    public function renderISBNMetaBox(\WP_Post $post): void {
        $isbn = get_post_meta($post->ID, '_isbn', true);
?>
        <label for="isbn"><?php _e('ISBN:', 'bookstore-plugin'); ?></label>
        <input type="text" id="isbn" name="isbn" value="<?php echo esc_attr($isbn); ?>" />
<?php
    }

    /**
     * Save ISBN number when the 'Book' post is saved.
     *
     * @param int $post_id The ID of the post being saved.
     */
    public function saveISBN(int $post_id): void {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (isset($_POST['isbn'])) {
            // Sanitize isbn
            $isbn = sanitize_text_field($_POST['isbn']);

            // Save it to post meta data
            update_post_meta($post_id, '_isbn', $isbn);

            // Save it into books_info table
            $data = ['post_id' => $post_id, 'isbn' => $isbn];
            $this->booksInfoRepository->updateOrCreate($data);
        }
    }
}

// Initialize the BookPostType class
new BookPostType();
