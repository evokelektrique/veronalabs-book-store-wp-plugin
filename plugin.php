<?php

/**
 * Plugin Name:     Book Store Plugin
 * Plugin URI:      https://www.veronalabs.com
 * Plugin Prefix:   BOOKSTORE_PLUGIN
 * Description:     BookStore WordPress Plugin Based on Rabbit Framework!
 * Author:          VeronaLabs
 * Author URI:      https://veronalabs.com
 * Text Domain:     bookstore-plugin
 * Domain Path:     /languages
 * Version:         0.1
 */

use Rabbit\Application;
use Rabbit\Redirects\RedirectServiceProvider;
use Rabbit\Database\DatabaseServiceProvider;
use Rabbit\Logger\LoggerServiceProvider;
use Rabbit\Plugin;
use Rabbit\Redirects\AdminNotice;
use Rabbit\Templates\TemplatesServiceProvider;
use Rabbit\Utils\Singleton;
use League\Container\Container;

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require dirname(__FILE__) . '/vendor/autoload.php';
}

/**
 * Class BookStorePluginInit
 * @package BookStorePluginInit
 */
class BookStorePluginInit extends Singleton {
    /**
     * @var Container
     */
    private $application;

    /**
     * BookStorePluginInit constructor.
     */
    public function __construct() {
        $this->application = Application::get()->loadPlugin(__DIR__, __FILE__, 'config');
        $this->init();
    }

    public function init() {
        try {

            /**
             * Load service providers
             */
            $this->application->addServiceProvider(RedirectServiceProvider::class);
            $this->application->addServiceProvider(DatabaseServiceProvider::class);
            $this->application->addServiceProvider(TemplatesServiceProvider::class);
            $this->application->addServiceProvider(LoggerServiceProvider::class);
            // Load your own service providers here...


            /**
             * Activation hooks
             */
            $this->application->onActivation(function () {
                // Create database tables
                $database = $this->application->get('database');
                
                if(!$database->schema()->hasTable('books_info')) {
                    $database->schema()->create('books_info', function ($table) {
                        $table->increments('id');
                        $table->foreignId('post_id')->constrained();
                        $table->string('isbn');
                        $table->timestamps();
                    });
                }
            });

            /**
             * Deactivation hooks
             */
            $this->application->onDeactivation(function () {
                // Clear events, cache or something else
            });

            $this->application->boot(function (Plugin $plugin) {
                $plugin->loadPluginTextDomain();

                // Import functions
                require_once __DIR__ . "/src/functions.php";
            });
        } catch (\Exception $e) {
            /**
             * Print the exception message to admin notice area
             */
            add_action('admin_notices', function () use ($e) {
                AdminNotice::permanent(['type' => 'error', 'message' => $e->getMessage()]);
            });

            /**
             * Log the exception to file
             */
            add_action('init', function () use ($e) {
                if ($this->application->has('logger')) {
                    $this->application->get('logger')->warning($e->getMessage());
                }
            });
        }
    }

    /**
     * @return Container
     */
    public function getApplication() {
        return $this->application;
    }
}

/**
 * Returns the main instance of BookStorePluginInit.
 *
 * @return BookStorePluginInit
 */
function bookStorePlugin() {
    return BookStorePluginInit::get();
}

bookStorePlugin();
