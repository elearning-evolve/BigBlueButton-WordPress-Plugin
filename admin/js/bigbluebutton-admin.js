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
        
        $("#toplevel_page_bbb_room ul li:nth-child(6) a").on( 'click', function(){
            window.open('https://elearningevolve.com/products/video-conferencing-with-bbb-pro/', '_blank').focus();
        })
    
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
}

function copyClipboardExit(elem) {
    var tooltip = jQuery(elem).find('.shortcode-tooltip').html( __('Copy Shortcode', 'bigbluebutton') );
}