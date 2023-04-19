<?php 
    add_filter ('woocommerce_add_to_cart_redirect', 'rg108_checkout_woo_redirect');
   
    function rg108_checkout_woo_redirect() {
        global $woocommerce;
        $checkout_url = wc_get_checkout_url();
        return $checkout_url;
    }
    
    add_shortcode('rg108_woocommerce_single_page_checkout', 'rg108_single_page_checkout');        
        function rg108_single_page_checkout( $atts ) {
             $colum_option = get_option('cart_colum');
        if($colum_option=="2"){
            $colum_option_class='col-md-6';
        }else{
            $colum_option_class='col-md-12';
        } 
    ?>    
        <div class="row">
            <div class="<?php echo $colum_option_class; ?>">
                <?php echo do_shortcode ('[woocommerce_cart]') ?>
            </div>
            <div class="<?php echo $colum_option_class; ?>">
                <?php echo do_shortcode ('[woocommerce_checkout]') ?>
            </div>
        </div>    
    <?php   
    }        
add_action( 'wp_head', 'rg108_plugin_style' );
function rg108_plugin_style() {
    
     $option_billing_colum = get_option('billing_colum');
        if($option_billing_colum=="1"){
            $option_val__billing_colum='98%';
        }else{
            $option_val__billing_colum='48%';
        }
    
?>
<style type="text/css" media="screen">
   .woocommerce #customer_details .col-1,.woocommerce #customer_details .col-2{
    width: <?php echo $option_val__billing_colum;?>;
   }
    .cart-collaterals .cross-sells{
    display: none;
   }
   
@media (max-width:640px) {
     .woocommerce #customer_details .col-1,.woocommerce #customer_details .col-2{
    width: 100% !important;
   }
}
</style>
<?php } 
add_action( 'admin_head', 'rg108_plugin_style_admin' );
function rg108_plugin_style_admin() {?>
<style type="text/css" media="screen">
   .wp-admin select.styled{
    width: 240px;
   }
   .option-div{
    width: 90%;
   }
      
</style>
<?php } 
    
        ?>