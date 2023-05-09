const { __, _x, _n, _nx } = wp.i18n;

( function( $ ) {
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

	$( window ).load( function() {
		// Make update success message in save server settings disppear after 2 seconds.
		if ( $( '.updated' ).length ) {
			$( '.updated' )
				.delay( 2000 )
				.fadeOut();
		}

		// Dismiss admin notices.
		$( '.bbb-warning-notice' ).on( 'click', function() {
			let data = {
				action: 'dismissed_notice_handler',
				type: $( this ).data( 'notice' ),
				nonce: $( this ).data( 'nonce' )
			};

			jQuery.post(
				php_vars.ajax_url,
				data,
				'json'
			);
		});
	});
}( jQuery ) );

function copyToClipboard(elem) {
    /* Copy the text inside the text field */
    navigator.clipboard.writeText(elem.getAttribute('data-value'));

    var tooltip = jQuery(elem).find('.shortcode-tooltip').html( __('Copied:', 'bigbluebutton') );
    var tooltip = jQuery(elem).find('.invite-tooltip').html( __('Copied:', 'bigbluebutton') );
    
    /* Open Help screen when adding shortcode to page */
    if( jQuery(elem).find('.shortcode-tooltip').length != 0 ) {
        if( jQuery(document).find('#contextual-help-link').length != 0 ) {
           jQuery('#screen-meta').show();
           jQuery('#contextual-help-wrap').show();
           jQuery('#tab-link-edit-bbb-room-participants').removeClass('active');
           jQuery('#tab-link-edit-bbb-room-shortcode').addClass('active');
           
           jQuery('#tab-panel-edit-bbb-room-participants').hide();
           jQuery('#tab-panel-edit-bbb-room-shortcode').show();
           
        }
    }
    
    if( jQuery(elem).find('.invite-tooltip').length != 0 ) {
        if( jQuery(document).find('#contextual-help-link').length != 0 ) {
            jQuery('#screen-meta').show();
            jQuery('#contextual-help-wrap').show();
            jQuery('#tab-link-edit-bbb-room-shortcode').removeClass('active');
            jQuery('#tab-link-edit-bbb-room-participants').addClass('active');
            
            jQuery('#tab-panel-edit-bbb-room-shortcode').hide();
            jQuery('#tab-panel-edit-bbb-room-participants').show();
        }
    }
    
}

function copyClipboardExit(elem) {
    var tooltip = jQuery(elem).find('.shortcode-tooltip').html( __('Copy Shortcode', 'bigbluebutton') );
    var tooltip = jQuery(elem).find('.invite-tooltip').html( __('Copy Invite URL', 'bigbluebutton') );
}