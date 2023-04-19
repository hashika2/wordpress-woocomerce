<?php
/**
   *
   * @package   rg108-woocommerce-single-page-checkout
   * @author    Brij Raj Singh <brijraj@anaadisoft.com>
   * @license   MIT License
   * @link      https://anaadisoft.com
   * @copyright 2021 Anaadisoft.com
   * 
 */

// If uninstall, not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Delete plugin settings
delete_option( 'rg108-woocommerce-single-page-checkout' );
delete_site_option( 'rg108-woocommerce-single-page-checkout' );