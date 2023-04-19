<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

if (!class_exists('Woocommerce_Boda_Settings')) {

    /**
     * Settings class
     *
     * @since 1.0.0
     */
    class Woocommerce_Boda_Settings extends WC_Settings_Page
    {

        /**
         * Constructor
         * @since  1.0
         */
        public function __construct()
        {

            $this->id = 'woocommerce-boda';
            $this->label = __('BodaBoda Delivery', 'woocommerce-boda');

            // Define all hooks instead of inheriting from parent
            add_filter('woocommerce_settings_tabs_array', array($this, 'add_settings_page'), 20);
            add_action('woocommerce_sections_' . $this->id, array($this, 'output_sections'));
            add_action('woocommerce_settings_' . $this->id, array($this, 'output'));
            add_action('woocommerce_settings_save_' . $this->id, array($this, 'save'));
        }

        /**
         * Get sections.
         *
         * @return array
         */
        public function get_sections()
        {
            $sections = array(
                '' => __('Settings', 'woocommerceboda'),
                //'tab2' => __('Tab2', 'woocommerce-boda') // another tab
            );

            return apply_filters('woocommerce_get_sections_' . $this->id, $sections);
        }

        /**
         * Get settings array
         *
         * @return array
         */
        public function get_settings()
        {

            global $current_section;
            $prefix = 'bbd_ino';

            switch ($current_section) {
                case 'tab2':
                    $settings = array(
                        array()
                    );
                    break;
                default:
                    include 'partials/woocommerce-boda-settings-main.php';
            }

            return apply_filters('woocommerce_get_settings_' . $this->id, $settings, $current_section);
        }

        /**
         * Output the settings
         */
        public function output()
        {
            $settings = $this->get_settings();

            WC_Admin_Settings::output_fields($settings);
        }

        /**
         * Save settings
         *
         * @since 1.0
         */
        public function save()
        {
            $settings = $this->get_settings();

            WC_Admin_Settings::save_fields($settings);
        }
    }

}


return new Woocommerce_Boda_Settings();
