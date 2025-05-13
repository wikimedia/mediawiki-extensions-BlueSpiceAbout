( ( $ ) => {

	$( () => {
		const $container = $( '#bs-about-banner-newsletter-container' );
		if ( $container.length === 0 ) {
			return;
		}

		const banner = new ext.bluespice.about.ui.BannerNewsletter();

		$container.append( banner.$element );
	} );

} )( jQuery );
