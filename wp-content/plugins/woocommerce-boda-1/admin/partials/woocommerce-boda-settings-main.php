<?php
$settings = array(
    array(
        'name' => __('Token Configuration', 'woocommerce-boda'),
        'type' => 'title',
        'id' => $prefix . 'general_config_settings'
    ),
    array(
        'id' => $prefix . '_token',
        'name' => __('API Token', 'woocommerce-boda'),
        'type' => 'text',
        'desc_tip' => __(' The API token of the Boda Delivery API. ', 'woocommerce-boda')
    ),
	array(
        'id' => $prefix . '_secret',
        'name' => __('Secret', 'woocommerce-boda'),
        'type' => 'text',
        'desc_tip' => __(' The API secret of the Boda Delivery API. ', 'woocommerce-boda')
    ),
    array(
        'id' => $prefix . '_channel',
        'name' => __('Channel', 'woocommerce-boda'),
        'type' => 'text',
        'desc_tip' => __(' The API Channel of the Boda Delivery API. ', 'woocommerce-boda')
    ),
    array(
        'id' => '',
        'name' => __('General Configuration', 'woocommerce-boda'),
        'type' => 'sectionend',
        'desc' => '',
        'id' => $prefix . 'general_config_settings'
    ),
    array(
        'name' => __('Extra Fields (Enable/Disable)', 'woocommerce-boda'),
        'type' => 'title',
        'id' => $prefix . 'extra_fields',
    ),
    array(
        'id' => $prefix . '_enable_delivery_type',
        'name' => __('Delivery Type', 'woocommerce-boda'),
        'type' => 'checkbox',
    //'desc_tip' => __(' Enable/Disable Express shipping.', 'woocommerce-boda')
    ),
    array(
        'id' => $prefix . '_enable_private_note',
        'name' => __('Private Note', 'woocommerce-boda'),
        'type' => 'checkbox',
    //'desc_tip' => __(' Enable/Disable Private Note.', 'woocommerce-boda')
    ),
    array(
        'id' => $prefix . '_enable_id_verification',
        'name' => __('ID Verification Required', 'woocommerce-boda'),
        'type' => 'checkbox',
    //'desc_tip' => __(' Enable/Disable ID Verification Required.', 'woocommerce-boda')
    ),
    array(
        'id' => $prefix . '_enable_signature_required',
        'name' => __('Signature Required', 'woocommerce-boda'),
        'type' => 'checkbox',
    //'desc_tip' => __(' Enable/Disable Signature Required.', 'woocommerce-boda')
    ),
    array(
        'id' => $prefix . '_enable_shipping_plus_code',
        'name' => __('Shipping Plus Code', 'woocommerce-boda'),
        'type' => 'checkbox',
    //'desc_tip' => __(' Enable/Disable Shipping Plus Code.', 'woocommerce-boda')
    ),
    array(
        'id' => $prefix . '_enable_shipping_longitude',
        'name' => __('Shipping Longitude', 'woocommerce-boda'),
        'type' => 'checkbox',
    //'desc_tip' => __(' Enable/Disable Shipping Longitude.', 'woocommerce-boda')
    ),
    array(
        'id' => $prefix . '_enable_shipping_latitude',
        'name' => __('Shipping Latitude', 'woocommerce-boda'),
        'type' => 'checkbox',
    //'desc_tip' => __(' Enable/Disable Shipping Latitude.', 'woocommerce-boda')
    ),
    array(
        'id' => '',
        'name' => __('Extra Fields', 'woocommerce-boda'),
        'type' => 'sectionend',
        'desc' => '',
        'id' => $prefix . 'extra_fields',
    ),
);
