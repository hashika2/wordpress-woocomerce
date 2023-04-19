<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.inovaitsys.com
 * @since      1.0.0
 *
 * @package    Woocommerce_Boda
 * @subpackage Woocommerce_Boda/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Woocommerce_Boda
 * @subpackage Woocommerce_Boda/includes
 * @author     Inova IT Systems <info@inovaitsys.com>
 */
class Woocommerce_Boda
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Woocommerce_Boda_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        $this->define_constants();
        if (defined('WOOCOMMERCE_BODA_VERSION')) {
            $this->version = WOOCOMMERCE_BODA_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'woocommerce-boda';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Constants define
     */
    private function define_constants()
    {
        if (trim(strtolower(BBD_INO_ENVIRONMENT)) == 'production') {
            define('BBD_INO_API_URL', 'https://32i4lynpjj.execute-api.ap-southeast-2.amazonaws.com/');
        }
		else if (trim(strtolower(BBD_INO_ENVIRONMENT)) == 'beta') {
          define('BBD_INO_API_URL', 'https://00knmp109g.execute-api.ap-southeast-2.amazonaws.com/');
        }
		else if (trim(strtolower(BBD_INO_ENVIRONMENT)) == 'stage') {
          define('BBD_INO_API_URL', 'https://lrowqf09kk.execute-api.ap-southeast-2.amazonaws.com/');
        }
		else if (trim(strtolower(BBD_INO_ENVIRONMENT)) == 'demo') {
          define('BBD_INO_API_URL', 'https://0mezchuac5.execute-api.ap-southeast-2.amazonaws.com/');
        }
		else if (trim(strtolower(BBD_INO_ENVIRONMENT)) == 'qa') {
          define('BBD_INO_API_URL', 'https://6espnj2dij.execute-api.ap-southeast-2.amazonaws.com/');
        }
		else if (trim(strtolower(BBD_INO_ENVIRONMENT)) == 'dev') {
          define('BBD_INO_API_URL', 'https://b7ng6sdxf1.execute-api.ap-southeast-2.amazonaws.com/');
        }
		else {
            define('BBD_INO_API_URL', 'http://localhost:3001/');
        }
    }

    /**
     *
     * @param string $name
     * @param mixed $value
     */
    private function define($name, $value)
    {
        if (!defined($name)) {
            define($name, $value);
        }
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Woocommerce_Boda_Loader. Orchestrates the hooks of the plugin.
     * - Woocommerce_Boda_i18n. Defines internationalization functionality.
     * - Woocommerce_Boda_Admin. Defines all hooks for the admin area.
     * - Woocommerce_Boda_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-woocommerce-boda-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-woocommerce-boda-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-woocommerce-boda-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-woocommerce-boda-public.php';

        /**
         * The class responsible for handling all API remote request of the delivery API
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-woocommerce-boda-api.php';

        $this->loader = new Woocommerce_Boda_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Woocommerce_Boda_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {

        $plugin_i18n = new Woocommerce_Boda_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {

        $plugin_admin = new Woocommerce_Boda_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

        // Add plugin settings to WooCommerce
        $this->loader->add_filter('woocommerce_get_settings_pages', $plugin_admin, 'bbd_ino_add_settings');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {

        $plugin_public = new Woocommerce_Boda_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');

        // called only after woocommerce has finished loading
        $this->loader->add_action('woocommerce_init', $plugin_public, 'bbd_ino_is_woocommerce_loaded');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Woocommerce_Boda_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }
}
