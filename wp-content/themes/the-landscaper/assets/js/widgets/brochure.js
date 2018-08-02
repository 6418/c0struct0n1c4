// The Upload Button for the Brochure Widget

jQuery(document).ready(function() {
    'use strict';

    // Uploading files variable
    var custom_file_frame;

    jQuery(document).on( 'click', '.upload-file-button', function( event ) {
        event.preventDefault();

        var returnName = jQuery(this);
        
        // If the frame already exists, reopen it
        if ( typeof( custom_file_frame )!== "undefined" ) {
            custom_file_frame.close();
        }

        // Create WP media frame.
        custom_file_frame = wp.media.frames.customHeader = wp.media({
            title: "Choose a File",
            button: { text: "Select File" },
            multiple: false
        });

        // Callback for selected image
        custom_file_frame.on( 'select', function() {
            var attachment = custom_file_frame.state().get( 'selection' ).first().toJSON();
            returnName.closest( 'p' ).find( '.upload-file-url' ).val(attachment.url);
        });

        // Open modal
        custom_file_frame.open();
    });
});