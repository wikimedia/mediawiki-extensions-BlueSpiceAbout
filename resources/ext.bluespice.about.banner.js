( ( $ ) => {

	$( () => {
		const $container = $( '#bs-about-banner-container' );
		if ( $container.length === 0 ) {
			return;
		}

		const banner = new ext.bluespice.about.ui.Banner();

		$container.append( banner.$element );
	} );

} )( jQuery );
