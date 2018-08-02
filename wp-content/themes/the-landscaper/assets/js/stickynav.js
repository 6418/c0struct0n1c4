/* Sticky Navigation */
define( ['jquery', 'underscore'], function ( $, _ ) {
	'use strict';

	var navigation   = $( '.navigation' ),
		bodyClass    = $( 'body' ),
		stickyNavTop = navigation.offset().top,
		navbarHeight = navigation.height(),
		adminBar     = $( 'body' ).hasClass( 'admin-bar' ) ? 32 : 0;

	// check if default header isset for the height
	if ( $( '.header' ).hasClass( 'header-default' ) ) {
		navbarHeight = navigation.height() / 2;
	}

	$(window).on( 'scroll', function(){
		if( $(window).scrollTop() > stickyNavTop - adminBar ) {
			if( bodyClass.hasClass( 'fixed-navigation' ) ) {
				bodyClass.addClass( 'is-sticky-nav' );
				$( '.sticky-offset' ).height( navbarHeight );
				navigation.addClass( 'is-sticky' );
			}
		} else {
			bodyClass.removeClass( 'is-sticky-nav' );
			navigation.removeClass( 'is-sticky' );
		}
	});

	var updateLayout = _.debounce(function() {
		stickyNavTop;
		navbarHeight;
		$( '.sticky-offset' ).height( navbarHeight );
	}, 100 );

	window.addEventListener("resize", updateLayout, false);
});