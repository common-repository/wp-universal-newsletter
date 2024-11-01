(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
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
        jQuery(document).ready( function($){
            
            //Real Time Logo Feedback
            var $logo = $('#logo');
           $logo.on('blur', function(){       
               jQuery('#logo-preview').attr('src', $(this).val());
           });
           
           //Set Date format option. Should redo in PHP :(
           var $dateSelect = jQuery('#wp_newsletter_date_format');
           var dateVal = $dateSelect.data('value');
           $dateSelect.find('option[value="'+dateVal+'"]').attr('selected', 'selected');
           
           // Add Color Picker to color fields
           jQuery('.hasColor').wpColorPicker({
               defaultColor: false,
               hide: true,
               pallete: true
            });
            
            $('#upload-btn').click(function(e) {
                e.preventDefault();
                var image = wp.media({ 
                    title: 'Upload Image',
                    // mutiple: true if you want to upload multiple files at once
                    multiple: false
                }).open()
                .on('select', function(){
                    // This will return the selected image from the Media Uploader, the result is an object
                    var uploaded_image = image.state().get('selection').first();
                    // We convert uploaded_image to a JSON object to make accessing it easier
                    // Output to the console uploaded_image
                    console.log(uploaded_image);
                    var image_url = uploaded_image.toJSON().url;
                    // Let's assign the url value to the input field
                    $('#logo').val(image_url);
                    $('#logo-preview').attr('src', image_url);
                });
        });
        });

})( jQuery );
