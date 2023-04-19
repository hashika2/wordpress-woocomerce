<?php
if (!class_exists('Woocommerce_Boda_Api')) {

    /**
     * The class responsible for handling all API remote request of the delivery API

     * @since      1.0.0
     *
     * @package    Woocommerce_Boda
     * @subpackage Woocommerce_Boda/includes
     */
    class Woocommerce_Boda_Api
    {

        protected static $base_url = BBD_INO_API_URL;

        /**
         * Get all cities
         *
         * @return array
         *
         * @since    1.0.0
         * @access   public
         */
        public static function get_cities()
        {
			$url = self::$base_url . 'channel/city/all/order';
            $response = self::do_get($url);
			return $response;
        }

        /**
         * Create delivery  order
         *
         * @param array $data
         * @return array
         *
         * @since    1.0.0
         * @access   public
         */
        public static function create_order($data)
        {
            $url = self::$base_url . 'channel/order';			
            $response = self::do_post($url, $data);	
            return $response;
        }

        /**
         * Remote HTTP POST request from native wp functions
         *
         * @param string $url
         * @param array $body
         * @param array $extra_headers
         * @return array
         *
         * @since    1.0.0
         * @access   protected
         */
        protected static function do_post($url, $body, $extra_headers = array())
        {
            $secret_key = get_option('bbd_ino_secret', true);            
            $channel  =  get_option('bbd_ino_channel', true);
            $curr_time = time();
            $message =  $channel."-".$curr_time;
            
            $secret =  hash_hmac( "sha256", $message,  $secret_key );
			
			$response = wp_remote_post($url, array(
                'body' => wp_json_encode($body),
                'timeout' => 60,
                'headers' => array_merge(array(
                    'Authorization' => 'Api-Key ' . get_option('bbd_ino_token', true),
                    'Content-Type' => 'application/json',
					'timestamp' => $curr_time,
                    'channel' => $channel,
                    'secret' => $secret
                    ), $extra_headers)
            ));	
			
            return self::handle_response($response);
        }

        /**
         * Remote HTTP GET request from native wp functions
         *
         * @param string $url
         * @param array $body
         * @param array $extra_headers
         * @return array
         *
         * @since    1.0.0
         * @access   private
         */
        protected static function do_get($url, $extra_headers = array())
        {
			$secret_key = get_option('bbd_ino_secret', true);            
            $channel  =  get_option('bbd_ino_channel', true);
            $curr_time = time();
            $message =  $channel."-".$curr_time;            
            $secret =  hash_hmac( "sha256", $message,  $secret_key );
			
			/*
			$response = wp_remote_get($url, array(
                'timeout' => 30,
                'headers' => array_merge(array(
                    'Authorization' => 'Api-Key ' . get_option('bbd_ino_token', true),
                    'Content-Type' => 'application/json',
                    ), $extra_headers)
            ));
			*/			
		
			$response = wp_remote_get($url, array(
                    'timeout' => 30,
                    'headers' => array_merge(array(
                        'Authorization' => 'Api-Key ' . get_option('bbd_ino_token', true),                     
                        'Content-Type' => 'application/json',
                        'timestamp' => $curr_time,
                        'channel' => $channel,
                        'secret' => $secret
                        ), $extra_headers)
           ));			
			
            return self::handle_response($response);
        }

        /**
         * Handle HTTP response
         *
         * @param wp_remote_response $response
         * @return array
         */
        protected static function handle_response($response)
        {
			if (is_wp_error($response)) {
                //network error
                return array(
                    'success' => false,
                    'code' => wp_remote_retrieve_response_code($response),
                    'error' => $response->get_error_message()
                );
            }

            $body = json_decode(wp_remote_retrieve_body($response));
            
            $status_code = wp_remote_retrieve_response_code($response);
            if(!$status_code){
                $status_code = $body->code ? $body->code : ($body->statusCode ? $body->statusCode : 0);
            }
            
            if ($status_code && in_array($status_code, array(200, 201))) {
                 //send success response
                return array(
                    'success' => true,
                    'code' => $status_code,
                    'data' => $body->data
                );
            }

            //API error
            return array(
                'success' => false,
                'code' => $status_code,
                'error' => $body->message
            );
        }
    }

}