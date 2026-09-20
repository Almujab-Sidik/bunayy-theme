/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function() {
	const siteNavigation = document.getElementById( 'site-navigation' );

	// Return early if the navigation doesn't exist.
	if ( ! siteNavigation ) {
		return;
	}

	const button = siteNavigation.getElementsByTagName( 'button' )[ 0 ];

	// Return early if the button doesn't exist.
	if ( 'undefined' === typeof button ) {
		return;
	}

	const menu = siteNavigation.getElementsByTagName( 'ul' )[ 0 ];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	if ( ! menu.classList.contains( 'nav-menu' ) ) {
		menu.classList.add( 'nav-menu' );
	}

	// Toggle the .toggled class and the aria-expanded value each time the button is clicked.
	button.addEventListener( 'click', function() {
		siteNavigation.classList.toggle( 'toggled' );

		if ( button.getAttribute( 'aria-expanded' ) === 'true' ) {
			button.setAttribute( 'aria-expanded', 'false' );
			closeSubmenus();
		} else {
			button.setAttribute( 'aria-expanded', 'true' );
		}
	} );

	// Remove the .toggled class and set aria-expanded to false when the user clicks outside the navigation.
	document.addEventListener( 'click', function( event ) {
		const isClickInside = siteNavigation.contains( event.target );

		if ( ! isClickInside ) {
			siteNavigation.classList.remove( 'toggled' );
			button.setAttribute( 'aria-expanded', 'false' );
			closeSubmenus();
		}
	} );

	// Get all the link elements with children within the menu.
	const linksWithChildren = menu.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

	// Toggle submenus when a parent link is clicked on small screens.
	for ( const link of linksWithChildren ) {
		link.setAttribute( 'aria-haspopup', 'true' );
		link.setAttribute( 'aria-expanded', 'false' );
		link.addEventListener( 'click', toggleSubmenu, false );
	}

	/**
	 * Opens or closes a submenu on small screens.
	 */
	function toggleSubmenu( event ) {
		if ( window.getComputedStyle( button ).display === 'none' ) {
			return;
		}

		const willOpen = this.getAttribute( 'aria-expanded' ) !== 'true';
		event.preventDefault();
		closeSubmenus( this );
		this.parentNode.classList.toggle( 'focus', willOpen );
		this.setAttribute( 'aria-expanded', willOpen ? 'true' : 'false' );
	}

	/**
	 * Closes every submenu except the supplied parent link.
	 */
	function closeSubmenus( except ) {
		for ( const link of linksWithChildren ) {
			if ( link !== except ) {
				link.parentNode.classList.remove( 'focus' );
				link.setAttribute( 'aria-expanded', 'false' );
			}
		}
	}
}() );
