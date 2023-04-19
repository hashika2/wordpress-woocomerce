<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.inovaitsys.com
 * @since      1.0.0
 *
 * @package    Woocommerce_Boda
 * @subpackage Woocommerce_Boda/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Woocommerce_Boda
 * @subpackage Woocommerce_Boda/public
 * @author     Inova IT Systems <info@inovaitsys.com>
 */
class Woocommerce_Boda_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Woocommerce_Boda_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Woocommerce_Boda_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/woocommerce-boda-public.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Woocommerce_Boda_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Woocommerce_Boda_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/woocommerce-boda-public.js', array('jquery'), $this->version, false);
    }

    /**
     * Take care of anything that needs woocommerce to be loaded.
     * For instance, if you need access to the $woocommerce global
     *
     * @since    1.0.0
     */
    public function bbd_ino_is_woocommerce_loaded()
    {
        /**
         * Checkout related plugin functionalities
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-woocommerce-boda-checkout.php';
    }
}
