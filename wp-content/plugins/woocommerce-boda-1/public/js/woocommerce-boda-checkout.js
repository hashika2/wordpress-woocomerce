(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
        $( ':input.wc-enhanced-select' ).filter( ':not(.enhanced)' ).each( function() {
            var select2_args = { minimumResultsForSearch: 2 };
            $( this ).select2( select2_args ).addClass( 'enhanced' );
        });
        
              
        setReadonlyAndEmptyCityFields();
        $('#bbd_ino_billing_city_id').on('change',function(){
            $("#billing_city").val($( "#bbd_ino_billing_city_id option:selected" ).text());
        });
        
        $('#bbd_ino_shipping_city_id').on('change',function(){
            $("#shipping_city").val($( "#bbd_ino_shipping_city_id option:selected" ).text());
        });
        
        function setReadonlyAndEmptyCityFields(){
           //set values empty 
           $("#billing_city").val('');
           $("#shipping_city").val('');
           
           //set readonly
           $("#billing_city").prop('readonly', true);
           $("#shipping_city").prop('readonly', true);
        }

})( jQuery );
