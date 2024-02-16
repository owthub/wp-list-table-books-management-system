<?php 

class BooksManagement {

    private $message = "";

    public function __construct(){
        
        // Add Menu
        add_action("admin_menu", array($this, "addBMSMenus"));

        // Add Plugin Scripts
        add_action("admin_enqueue_scripts", array($this, "addBMSPluginScripts"));
    }

    // Setup Menus and Submenus
    public function addBMSMenus(){

        add_menu_page("Books Management System", "Books System", "manage_options", "books-system", array($this, "bmsAddBookHandler"), "dashicons-book-alt", 14);

        add_submenu_page("books-system", "Add Book Page", "Add Book", "manage_options", "books-system", array($this, "bmsAddBookHandler"));

        add_submenu_page("books-system", "List Books Page", "List Books", "manage_options", "list-books", array($this, "bmsListBooksHandler"));
    }

    public function addBooksSystemHandler(){

        echo "This is a sample message";
    }

    public function bmsAddBookHandler(){

        $this->saveBookData();

        $response = $this->message;

        //echo "<h3 class='bms-h3'>This is Add Book Page</h3>";
        ob_start(); // PHP Buffer Start
        include_once BMS_PLUGIN_PATH . 'pages/add-book.php'; // Read Content
        $content = ob_get_contents(); // Content stored in variable
        ob_end_clean(); // Buffer clean

        echo $content; // Content print
    }

    private function saveBookData(){

        global $wpdb;

        $tablePrefix = $wpdb->prefix; // wp_

        if( $_SERVER['REQUEST_METHOD'] == "POST" && isset($_REQUEST['btn_form_submit'])){

            // Sanitize
            $book_name = sanitize_text_field($_REQUEST['book_name']);
            $book_author = sanitize_text_field($_REQUEST['author_name']);
            $book_price = sanitize_text_field($_REQUEST['book_price']);
            $book_image = sanitize_text_field($_REQUEST['cover_image']);

            // Insert data
            $wpdb->insert("{$tablePrefix}books_system", [
                "name" => $book_name,
                "author" => $book_author,
                "book_price" => $book_price,
                "profile_image" => $book_image
            ]);

            $book_id = $wpdb->insert_id;

            if($book_id > 0){

                $this->message = "Successfully, book has been created";
            }else{

                $this->message = "Failed to create book";
            }
        }
    }

    public function bmsListBooksHandler(){

        //echo "<h3 class='bms-h3'>This is List Book Page</h3>";

        ob_start();

        include_once BMS_PLUGIN_PATH . 'pages/list-book.php';
        $content = ob_get_contents();
        ob_end_clean();

        echo $content;

    }

    // Create table structure
    public function bmsCreateTable(){

        global $wpdb;

        $table_prefix = $wpdb->prefix; // wp_, tbl_

        $tableSql = 'CREATE TABLE `'.$table_prefix.'books_system` (
            `id` int NOT NULL AUTO_INCREMENT,
            `name` varchar(120) NOT NULL,
            `author` varchar(120) NOT NULL,
            `profile_image` text,
            `book_price` int DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4';

        include_once ABSPATH . 'wp-admin/includes/upgrade.php';

        dbDelta($tableSql);
    }

    // Drop Table
    public function bmsDropTable(){

        global $wpdb;

        $tablePrefix = $wpdb->prefix; // wp_, tbl_

        $tableDropMySQL = "DROP TABLE IF EXISTS {$tablePrefix}books_system";

        $wpdb->query($tableDropMySQL);
    }

    // Add Plugin Scripts
    public function addBMSPluginScripts(){

        // CSS
        wp_enqueue_style("bms-style", BMS_PLUGIN_URL . 'assets/css/style.css', array(), "1.0", "all");

        // JS
        wp_enqueue_media();
        wp_enqueue_script("bms-validation", BMS_PLUGIN_URL . 'assets/js/jquery.validate.min.js', array("jquery"), "1.0");
        wp_enqueue_script("bms-script", BMS_PLUGIN_URL . 'assets/js/script.js', array("jquery"), "1.0");
    }
}