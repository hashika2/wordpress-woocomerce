<?php
add_action('admin_menu', 'rg108_register_checkout_menu_page');

function rg108_register_checkout_menu_page() {
   add_options_page('woocommerce', 'Checkout Settings','manage_options', 'one_settings', 'rg108_setting_checkout_page');   
}    
function rg108_setting_checkout_page(){
   ?>
    <h2>Single Page Checkout Settings</h2> 
   <?php 
    $rg_navigation_data = get_option('cart_colum'); 
    $rg_billing_colum = get_option('billing_colum'); 
 
     if($rg_navigation_data!=''){
        $rg_navigation = get_option('cart_colum');
           
     }else{
         $rg_navigation='2';  
     }
 
     if($rg_billing_colum!=''){
        $rg_billing = get_option('billing_colum');
           
     }else{
         $rg108_billing='1';  
     }
     
    if (isset($_POST['rg_updatedata'])) {
        update_option('cart_colum', sanitize_text_field($_POST['cart_colum']));
        update_option('billing_colum', sanitize_text_field($_POST['billing_colum']) );            
        echo '<div id="message" class="updated"><p><strong>';
        echo 'Settings Updated!';
        echo '</strong></p></div>';
        echo "<script>self.location='admin.php?page=one_settings';</script>";
    }
?>
<div class="welcome-panel option-div ">
       
    <form method="post" action=""> 
        <table>
        <tr>
           <td><?php  _e('Checkout Page Layout:', 'rg108-woocommerce-single-page-checkout');?></td>
            <td> 
                <select id="cart_colum" name="cart_colum" class="styled select180">           
                    <option value="1" <?php selected( $rg_navigation == '1');?>>One Colum</option>	
                    <option value="2" <?php selected( $rg_navigation == '2');?>>Two Colum</option>	           
                </select>
            </td>
        </tr>
        <tr>
        <td><?php  _e('Billing Details / Different address Layout :', 'rg108-woocommerce-single-page-checkout');?></td>
            <td> 
                <select id="cart_colum" name="billing_colum" class="styled select180">           
                    <option value="1" <?php selected( $rg_billing == '1');?>>One Colum</option>	
                    <option value="2" <?php selected( $rg_billing == '2');?>>Two Colum</option>	           
                </select>
            </td>
        </tr>
      
        </table>
        <p>
        <?php $nonce = wp_create_nonce(""); ?>
        <input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo $nonce; ?>" />
        <input type="hidden" name="rg_updatedata" value="1" />
        <input type="submit" value="Save" class="button button-primary"/>
        </p>    
    </form>
     </div> 
     
     <div class="welcome-panel option-div ">
        <h3><?php  _e('Shortcode:', 'rg108-woocommerce-single-page-checkout');?></h3>  
        
        <p>Change This shortcode in your checkout page:</p> 
                
        <p><code>[rg108_woocommerce_single_page_checkout]</code></p>
      
       
    </div> 
     
    <?php    
    }   