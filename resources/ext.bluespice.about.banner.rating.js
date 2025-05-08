( ( $ ) => {

	$( () => {
		const $container = $( '#bs-about-banner-rating-container' );
		if ( $container.length === 0 ) {
			return;
		}

		const banner = new ext.bluespice.about.ui.BannerRating();

		$container.append( banner.$element );
	} );

} )( jQuery );
