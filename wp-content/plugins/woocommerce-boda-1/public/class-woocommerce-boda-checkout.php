<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

if (!class_exists('Woocommerce_Boda_Main')) {

    /**
     * Checkout related plugin functionalities.
     *
     * @since 1.0.0
     */
    class Woocommerce_Boda_Checkout
    {

        /**
         * Constructor
         * @since  1.0
         */
        public function __construct()
        {
            //change city fieild and add other required missing fields
            add_filter('woocommerce_checkout_fields', array(&$this, 'bbd_ino_override_checkout_fields'));

            //save added fields
            add_action('woocommerce_checkout_update_order_meta', array(&$this, 'bbd_ino_save_custom_fields'), 10, 2);

            // Get the order details once payment is done and send them to boda api
            add_action('woocommerce_thankyou', array(&$this, 'bbd_ino_create_bodaboda_order'), 10, 1);
        }
        
        /**
         * override checkout fields
         * 
         * @param type $fields
         * @return array
         */
        public function bbd_ino_override_checkout_fields($fields)
        {
            //get cities
            $cities = $this->get_cities();
            $cities[null] ='Select a city...';
            
            $city_args = wp_parse_args(array(
                'type' => 'select',
                'options' => $cities,
                'required' => true,
                'input_class' => array(
                    'wc-enhanced-select',
                )
                ), $fields['shipping']['shipping_city']);

            $fields['shipping']['bbd_ino_shipping_city_id'] = $city_args;
            $fields['billing']['bbd_ino_billing_city_id'] = $city_args; // Also change for billing field

            /**
             * include custom shipping and billing fields
             */
            //include google pluscode
            if (get_option('bbd_ino_enable_shipping_plus_code') == 'yes') {
                $plus_code_args = wp_parse_args(array(
                    'type' => 'text',
                    'label' => __('Plus Code', 'woocommerce'),
                    'placeholder' => _x('Google plus code', 'placeholder', 'woocommerce'),
                    'required' => false
                    ), $fields['shipping']['plus_code']);

                $fields['shipping']['bbd_ino_shipping_plus_code'] = $plus_code_args;
                $fields['billing']['bbd_ino_billing_plus_code'] = $plus_code_args;
            }

            //include longitude
            if (get_option('bbd_ino_enable_shipping_longitude') == 'yes') {
                $longitude_args = wp_parse_args(array(
                    'type' => 'number',
                    'label' => __('Longitude', 'woocommerce'),
                    'placeholder' => _x('Longitude', 'placeholder', 'woocommerce'),
                    'required' => false
                    ), $fields['shipping']['longitude']);
                $fields['shipping']['bbd_ino_shipping_longitude'] = $longitude_args;
                $fields['billing']['bbd_ino_billing_longitude'] = $longitude_args;
            }

            //include latitude
            if (get_option('bbd_ino_enable_shipping_latitude') == 'yes') {
                $latitude_args = wp_parse_args(array(
                    'type' => 'number',
                    'label' => __('Latitude', 'woocommerce'),
                    'placeholder' => _x('Latitude', 'placeholder', 'woocommerce'),
                    'required' => false
                    ), $fields['shipping']['latitude']);
                $fields['shipping']['bbd_ino_shipping_latitude'] = $latitude_args;
                $fields['billing']['bbd_ino_billing_latitude'] = $latitude_args;
            }

            /**
             * include custom order fields
             */
            //include private note
            if (get_option('bbd_ino_enable_private_note') == 'yes') {
                $fields['order']['bbd_ino_private_note'] = wp_parse_args(array(
                    'type' => 'textarea',
                    'label' => __('Private Note', 'woocommerce'),
                    'placeholder' => _x('Private notes about your order', 'placeholder', 'woocommerce'),
                    'required' => false
                    ), $fields['order']['bbd_ino_private_note']);
            }

            //include delivery type
            if (get_option('bbd_ino_enable_delivery_type') == 'yes') {
                $fields['order']['bbd_ino_delivery_type'] = wp_parse_args(array(
                    'type' => 'select',
                    'label' => __('Delivery Type', 'woocommerce'),
                    'placeholder' => _x('Delivery Type', 'placeholder', 'woocommerce'),
                    'required' => true,
                    'options' => array(
                        'STANDARD' => 'Standard',
                        'EXPRESS' => 'Express',
                    ),
                    'input_class' => array(
                        'wc-enhanced-select',
                    )
                    ), $fields['order']['bbd_ino_delivery_type']);
            }

            //include signature required
            if (get_option('bbd_ino_enable_signature_required') == 'yes') {
                $fields['order']['bbd_ino_signature_required'] = wp_parse_args(array(
                    'type' => 'checkbox',
                    'label' => __('Signature Required', 'woocommerce'),
                    'required' => false
                    ), $fields['order']['bbd_ino_signature_required']);
            }

            //include id verification
            if (get_option('bbd_ino_enable_id_verification') == 'yes') {
                $fields['order']['bbd_ino_id_verification_required'] = wp_parse_args(array(
                    'type' => 'checkbox',
                    'label' => __('ID Verification Required', 'woocommerce'),
                    'required' => false
                    ), $fields['order']['bbd_ino_id_verification_required']);
            }

            //attach js scripts  and css for checkout page
            wp_enqueue_script('bbd_ino_scripts', plugin_dir_url(__FILE__) . 'js/woocommerce-boda-checkout.js', array('jquery'), false);
            wp_enqueue_style('bbd_ino_styles', plugin_dir_url(__FILE__) . 'css/woocommerce-boda-checkout.css');

            return $fields;
        }
        
        /**
         * Validate and save custom fields
         * 
         * @param int $order_id
         * @param array $posted
         */
        public function bbd_ino_save_custom_fields($order_id, $posted)
        {

            //save custom shiiping fields
            if (isset($posted['bbd_ino_billing_city_id'])) {
                update_post_meta($order_id, 'bbd_ino_billing_city_id', $posted['bbd_ino_billing_city_id']);
            }

            if (isset($posted['bbd_ino_shipping_city_id'])) {
                update_post_meta($order_id, 'bbd_ino_shipping_city_id', $posted['bbd_ino_shipping_city_id']);
            }

            if (isset($posted['bbd_ino_shipping_plus_code'])) {
                update_post_meta($order_id, 'bbd_ino_shipping_plus_code', sanitize_text_field($posted['bbd_ino_shipping_plus_code']));
            }

            if (isset($posted['bbd_ino_shipping_longitude'])) {
                update_post_meta($order_id, 'bbd_ino_shipping_longitude', sanitize_text_field($posted['bbd_ino_shipping_longitude']));
            }

            if (isset($posted['bbd_ino_shipping_latitude'])) {
                update_post_meta($order_id, 'bbd_ino_shipping_latitude', sanitize_text_field($posted['bbd_ino_shipping_latitude']));
            }
            //save custom billing fields
            if (isset($posted['bbd_ino_billing_plus_code'])) {
                update_post_meta($order_id, 'bbd_ino_billing_plus_code', sanitize_text_field($posted['bbd_ino_billing_plus_code']));
            }

            if (isset($posted['bbd_ino_billing_longitude'])) {
                update_post_meta($order_id, 'bbd_ino_billing_longitude', sanitize_text_field($posted['bbd_ino_billing_longitude']));
            }

            if (isset($posted['bbd_ino_billing_latitude'])) {
                update_post_meta($order_id, 'bbd_ino_billing_latitude', sanitize_text_field($posted['bbd_ino_billing_latitude']));
            }
            // save custom order fields
            if (isset($posted['bbd_ino_private_note'])) {
                update_post_meta($order_id, 'bbd_ino_private_note', sanitize_text_field($posted['bbd_ino_private_note']));
            }

            if (isset($posted['bbd_ino_delivery_type'])) {
                update_post_meta($order_id, 'bbd_ino_delivery_type', $posted['bbd_ino_delivery_type']);
            }

            if (isset($posted['bbd_ino_signature_required'])) {
                update_post_meta($order_id, 'bbd_ino_signature_required', sanitize_text_field($posted['bbd_ino_signature_required']));
            }

            if (isset($posted['bbd_ino_id_verification_required'])) {
                update_post_meta($order_id, 'bbd_ino_id_verification_required', sanitize_text_field($posted['bbd_ino_id_verification_required']));
            }
        }
        
        /**
         * Call order create API in thank you screen
         * 
         * @param int $order_id
         */
        public function bbd_ino_create_bodaboda_order($order_id)
        {

            if (!$order_id) {
                return;
            }

            // Allow code execution only once
            if (!get_post_meta($order_id, '_thankyou_action_done', true)) {

                // Get an instance of the WC_Order object
                // Order details can be organized to match API signature
                $order_wc = wc_get_order($order_id);
                $order = (object) $order_wc->get_data();

                //get custom meta fields
                $private_note = get_post_meta($order_id, 'bbd_ino_private_note', true);
                $delivery_type = get_post_meta($order_id, 'bbd_ino_delivery_type', true);
                $id_verification_required = get_post_meta($order_id, 'bbd_ino_id_verification_required', true);
                $signature_required = get_post_meta($order_id, 'bbd_ino_signature_required', true);
                $shipping_city_id = get_post_meta($order_id, 'bbd_ino_shipping_city_id', true);
                $shipping_plus_code = get_post_meta($order_id, 'bbd_ino_shipping_plus_code', true);
                $shipping_longitude = get_post_meta($order_id, 'bbd_ino_shipping_longitude', true);
                $shipping_latitude = get_post_meta($order_id, 'bbd_ino_shipping_latitude', true);
                $billing_city_id = get_post_meta($order_id, 'bbd_ino_billing_city_id', true);
                $billing_plus_code = get_post_meta($order_id, 'bbd_ino_billing_plus_code', true);
                $billing_longitude = get_post_meta($order_id, 'bbd_ino_billing_longitude', true);
                $billing_latitude = get_post_meta($order_id, 'bbd_ino_billing_latitude', true);
                //set values
                $payment_method = $order->payment_method == 'cod' ? 'CASH_ON_DELIVERY' : 'PREPAID';
                $paid = $order->payment_method == 'cod' ? false : true;
                $amount = ($order->payment_method == 'cod') ? floatval($order->total) : 0.00;
                $order_items = [];

                // Loop through order items
                foreach ($order_wc->get_items() as $item_id => $item) {
                    $order_items[] = [
                        'name' => $item->get_name(),
                        'productNo' => strval($item->get_product_id()),
                        'quantity' => (int) $item->get_quantity()
                    ];
                }

                //set locations
                $shipping = (object) $order->shipping;
                $billing = (object) $order->billing;

                //set shipping location
                if ((int) $shipping_city_id === 0) {
                    //shipping address empty-> need to get from billing
                    $name = $billing->first_name . ' ' . $billing->last_name;
                    $address = $billing->company . ', ' . $billing->address_1 . ', ' . $billing->address_2;
                    $country = $billing->country;
                    $shipping_location = [
                        'name' => $name . ' Shipping',
                        'address' => $address,
                        'postalCode' => $billing->postcode,
                        'city' => ['id' => (int) $billing_city_id],
                        'default' => true, // need to map
                        'plusCode' => $billing_plus_code ? $billing_plus_code : '',
                        'status' => 'ACTIVE',
                    ];
                    if ($billing_longitude) {
                        $shipping_location['lon'] = floatval($billing_longitude);
                    }

                    if ($billing_latitude) {
                        $shipping_location['lat'] = floatval($billing_latitude);
                    }
                } else {
                    $name = $shipping->first_name . ' ' . $shipping->last_name;
                    $address = $shipping->company . ' ' . $shipping->address_1 . ' ' . $shipping->address_2;
                    $country = $shipping->country;
                    $shipping_location = [
                        'name' => $name . ' Shipping',
                        'address' => $address,
                        'postalCode' => $shipping->postcode,
                        'city' => ['id' => (int) $shipping_city_id],
                        'default' => true, // need to map
                        'plusCode' => $shipping_plus_code ? $shipping_plus_code : '',
                        'status' => 'ACTIVE',
                    ];
                    if ($shipping_longitude) {
                        $shipping_location['lon'] = floatval($shipping_longitude);
                    }

                    if ($shipping_latitude) {
                        $shipping_location['lat'] = floatval($shipping_latitude);
                    }
                }
                
                $countryCallingCode = $this->get_woocommerce_country_calling_code($country);
                $country_code_prefix = $countryCallingCode;
                $phone = $billing->phone;
                if($country != 'LK'){
                    $country_code_prefix= '+';
                    $phone = $this->make_international_phone_number($phone, $countryCallingCode);
                }

                //set data
                $body = [
                    'name' => $name,
                    'phone' => $phone,
                    'countryCodePrefix' => $country_code_prefix,
                    'email' => $billing->email,
                    'channelOrderNo' => $order_wc->get_order_number(),
                    'channelOrderRef' => $order_wc->get_order_key(),
                    'paymentMethod' => $payment_method,
                    'amount' => $amount,
                    'paid' => $paid,
                    'status' => 'PENDING',
                    'deliveryType' => $delivery_type ? $delivery_type : 'STANDARD',
                    'idVerificationRequired' => $id_verification_required ? true : false,
                    'signatureRequired' => $signature_required ? true : false,
                    'shippingLocation' => $shipping_location,
                    'orderItems' => $order_items,
                    'notesPrivate' => $private_note ? $private_note : null,
                    'notesPublic' => $order_wc->customer_note ? $order_wc->customer_note: null,
                ];
                
                // call boda API
                $response = Woocommerce_Boda_Api::create_order($body);

                // Debug code to see whats in response object
//                echo '<pre>';
//                var_dump($response);
//                echo '</pre></br>';
                // Flag the action as done (to avoid repetitions on reload for example)
                $order_wc->update_meta_data('_thankyou_action_done', true);
                $order_wc->save();
            }
        }
        
        /**
         * GET cities from API or cache and format as list
         * 
         * @return array
         */
        protected function get_cities()
        {
//             //get from cache
//             $cities = get_transient('bbd_ino_cities');

//             if ($cities) {
//                 return $cities;
//             }

            //cache expired or not added. get cities from the API
            $response = Woocommerce_Boda_Api::get_cities();

            if (!$response['success']) {
                // Display an error message
                wc_add_notice(__("Something went wrong while loading the cities!", "woocommerce"), 'error');
                return false;
            }

            //create array
            $api_cities = [];
            foreach ($response['data'] as $city) {
                $api_cities[$city->id] = $city->name;
            }

            //Save the results in a transient named bbd_ino_cities and it expires after 7 days.
            set_transient('bbd_ino_cities', $api_cities, DAY_IN_SECONDS * 7);
            return $api_cities;
        }        
        
        /**
         * Get country calling code by country code
         * 
         * @param string $country_code
         * @return string
         */
        protected function  get_woocommerce_country_calling_code($country_code)
        {
            $code = WC_Countries::get_country_calling_code($country_code);
            return is_array($code) ? $code[0] : $code;
        }
        
        /**
         * Make international phone number for boda
         * 
         * @param string $phone_number
         * @param string $country_code
         * @return string
         */
        protected function make_international_phone_number($phone_number, $country_code_prefix)
        {
            //Remove any parentheses and the numbers they contain:
            $phone = preg_replace("/\([0-9]+?\)/", "", $phone_number);

            //Strip spaces and non-numeric characters:
            $phone = preg_replace("/[^0-9]/", "", $phone);

            //Strip out leading zeros:
            $phone = ltrim($phone, '0');

            //Check if the number doesn't already start with the correct dialling code:
            if (!preg_match('/^' . $country_code . '/', $phone)) {
                $phone = $country_code . $phone;
            }

            //return the converted number:
            return $phone;
        }
    }

}


return new Woocommerce_Boda_Checkout();
