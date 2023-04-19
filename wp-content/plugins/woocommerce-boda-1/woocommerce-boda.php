<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.inovaitsys.com
 * @since             1.0.0
 * @package           Woocommerce_Boda
 *
 * @wordpress-plugin
 * Plugin Name:       BodaBoda Delivery
 * Plugin URI:        http://www.bodaboda.lk
 * Description:       WooCommerce plugin to support BodaBoda Delivery API.
 * Version:           1.0.0
 * Author:            Inova IT Systems
 * Author URI:        http://www.inovaitsys.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce-boda
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('WOOCOMMERCE_BODA_VERSION', '1.0.0');

/**
 * Environment, should be either test or production
 * Note: if youre on localhost, even if you change this constant to production, it'll still use test :)
 */
$bbd_ino_env = 'beta';

//if (isset($_SERVER['SERVER_NAME']) && strpos($_SERVER['SERVER_NAME'], 'localhost') !== false || ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG )) {
//    $bbd_ino_env = 'test';
//}

define('BBD_INO_ENVIRONMENT', $bbd_ino_env);


if (!function_exists('is_plugin_active')) {
    include_once(ABSPATH . '/wp-admin/includes/plugin.php');
}

/**
 * Check for the existence of WooCommerce and any other requirements
 */
function bbd_ino_check_requirements()
{
    if (is_plugin_active('woocommerce/woocommerce.php')) {
        return true;
    } else {
        add_action('admin_notices', ' bbd_ino_missing_wc_notice');
        return false;
    }
}

/**
 * Display a message advising WooCommerce is required
 */
function bbd_ino_missing_wc_notice()
{
    $class = 'notice notice-error';
    $message = __('BodaBoda Delivery requires WooCommerce to be installed and active.', 'woocommerce-boda');

    printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woocommerce-boda-activator.php
 */
function activate_woocommerce_boda()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-woocommerce-boda-activator.php';
    Woocommerce_Boda_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woocommerce-boda-deactivator.php
 */
function deactivate_woocommerce_boda()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-woocommerce-boda-deactivator.php';
    Woocommerce_Boda_Deactivator::deactivate();
}
register_activation_hook(__FILE__, 'activate_woocommerce_boda');
register_deactivation_hook(__FILE__, 'deactivate_woocommerce_boda');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-woocommerce-boda.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woocommerce_boda()
{
    if (bbd_ino_check_requirements()) {
        $plugin = new Woocommerce_Boda();
        $plugin->run();
    }
}
run_woocommerce_boda();
