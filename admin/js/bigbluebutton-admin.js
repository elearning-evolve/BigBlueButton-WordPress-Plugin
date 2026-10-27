const { __, _x, _n, _nx } = wp.i18n;

function bbbCopyTextToClipboard(text) {
    text = text == null ? '' : String(text);
    if (navigator.clipboard && window.isSecureContext) {
        return navigator.clipboard.writeText(text);
    }
    return new Promise(function (resolve, reject) {
        try {
            var ta = document.createElement('textarea');
            ta.value = text;
            ta.setAttribute('readonly', '');
            ta.style.position = 'fixed';
            ta.style.left = '-9999px';
            ta.style.top = '0';
            document.body.appendChild(ta);
            ta.select();
            var ok = document.execCommand('copy');
            document.body.removeChild(ta);
            if (ok) { resolve(); } else { reject(new Error('copy failed')); }
        } catch (e) { reject(e); }
    });
}

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

	$( window ).on( 'load', function() {
		// Only this plugin's Room Settings success notice. Do not touch core or other plugins' .updated notices.
		var $settingsSaved = $( '.vcbbb-settings-notice.notice-success' );
		if ( $settingsSaved.length ) {
			$settingsSaved.delay( 2000 ).fadeOut();
		}

		// Dismiss admin notices.
		$( '.bbb-warning-notice' ).on( 'click', function() {
			let data = {
				action: 'dismissed_notice_handler',
				type: $( this ).data( 'notice' ),
				nonce: $( this ).data( 'nonce' )
			};

			jQuery.post(
				vcbbb_php_vars.ajax_url,
				data,
				'json'
			);
		});
	});

	$( function() {
		var $page = $( '.vcbbb-shortcode-page' );
		if ( ! $page.length ) {
			return;
		}

		var $modal = $page.find( '#vcbbb-sc-modal' );
		var $body = $modal.find( '.vcbbb-sc-modal-body' );
		var lastFocus = null;

		function closeShortcodeModal() {
			$modal.removeClass( 'is-open' ).attr( 'aria-hidden', 'true' );
			$( 'body' ).removeClass( 'vcbbb-sc-modal-open' );
			$body.empty();
			if ( lastFocus && lastFocus.focus ) {
				lastFocus.focus();
			}
			lastFocus = null;
		}

		function openShortcodeModal( card ) {
			lastFocus = document.activeElement;
			$body.html( $( card ).html() );
			$modal.addClass( 'is-open' ).attr( 'aria-hidden', 'false' );
			$( 'body' ).addClass( 'vcbbb-sc-modal-open' );
			$modal.find( '.vcbbb-sc-modal-close' ).trigger( 'focus' );
		}

		$page.on( 'click', '.vcbbb-sc-copy', function( e ) {
			e.stopPropagation();
		});

		$page.on( 'click', '.vcbbb-sc-card', function( e ) {
			if ( $( e.target ).closest( '.vcbbb-sc-copy' ).length ) {
				return;
			}
			if ( window.getSelection && String( window.getSelection() ) ) {
				return;
			}
			openShortcodeModal( this );
		});

		$page.on( 'keydown', '.vcbbb-sc-card', function( e ) {
			if ( e.key === 'Enter' || e.key === ' ' ) {
				e.preventDefault();
				openShortcodeModal( this );
			}
		});

		$modal.on( 'click', '.vcbbb-sc-modal-backdrop, .vcbbb-sc-modal-close', function( e ) {
			e.preventDefault();
			closeShortcodeModal();
		});

		$( document ).on( 'keydown.vcbbbScModal', function( e ) {
			if ( e.key === 'Escape' && $modal.hasClass( 'is-open' ) ) {
				closeShortcodeModal();
			}
		});
	});
}( jQuery ) );

function copyToClipboard(elem) {
    var val = elem.getAttribute('data-value');
    if (val === null) { return; }
    bbbCopyTextToClipboard(val).then(function () {
        var $el = jQuery(elem);
        if ($el.find('.shortcode-tooltip').length) {
            $el.find('.shortcode-tooltip').html(__('Copied:', 'video-conferencing-with-bbb'));
        }
        if ($el.find('.invite-tooltip').length) {
            $el.find('.invite-tooltip').html(__('Copied:', 'video-conferencing-with-bbb'));
        }
        if ($el.find('.shortcode-tooltip').length != 0) {
            if (jQuery(document).find('#contextual-help-link').length != 0) {
                jQuery('#screen-meta').show();
                jQuery('#contextual-help-wrap').show();
                jQuery('#tab-link-edit-bbb-room-participants').removeClass('active');
                jQuery('#tab-link-edit-bbb-room-shortcode').addClass('active');
                jQuery('#tab-panel-edit-bbb-room-participants').hide();
                jQuery('#tab-panel-edit-bbb-room-shortcode').show();
            }
        }
        if ($el.find('.invite-tooltip').length != 0) {
            if (jQuery(document).find('#contextual-help-link').length != 0) {
                jQuery('#screen-meta').show();
                jQuery('#contextual-help-wrap').show();
                jQuery('#tab-link-edit-bbb-room-shortcode').removeClass('active');
                jQuery('#tab-link-edit-bbb-room-participants').addClass('active');
                jQuery('#tab-panel-edit-bbb-room-shortcode').hide();
                jQuery('#tab-panel-edit-bbb-room-participants').show();
            }
        }
    });
}

function copyClipboardExit(elem) {
    var $el = jQuery(elem);
    if ($el.find('.shortcode-tooltip').length) {
        $el.find('.shortcode-tooltip').html(__('Copy Shortcode', 'video-conferencing-with-bbb'));
    }
    if ($el.find('.invite-tooltip').length) {
        $el.find('.invite-tooltip').html(__('Copy Invite URL', 'video-conferencing-with-bbb'));
    }
}