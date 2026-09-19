document.addEventListener( 'click', ( event ) => {
	const trigger = event.target.closest( '.event-gallery__trigger' );

	if ( ! trigger ) {
		return;
	}

	const dialog = document.querySelector( '#event-lightbox' );
	const image  = dialog.querySelector( '.event-lightbox__image' );

	image.src = trigger.dataset.eventLightboxSrc;
	image.alt = trigger.dataset.eventLightboxAlt;
	dialog.showModal();
} );
