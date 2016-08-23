/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function( $ ) {
	var container, button, menu, links, subMenus, i, len;

	container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}

	button = container.getElementsByTagName( 'button' )[0];
	if ( 'undefined' === typeof button ) {
		return;
	}

	menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	menu.setAttribute( 'aria-expanded', 'false' );
	if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
		menu.className += ' nav-menu';
	}

	button.onclick = function() {
		if ( -1 !== container.className.indexOf( 'toggled' ) ) {
			container.className = container.className.replace( ' toggled', '' );
			button.setAttribute( 'aria-expanded', 'false' );
			menu.setAttribute( 'aria-expanded', 'false' );
		} else {
			container.className += ' toggled';
			button.setAttribute( 'aria-expanded', 'true' );
			menu.setAttribute( 'aria-expanded', 'true' );
		}
	};

	// Get all the link elements within the menu.
	links    = menu.getElementsByTagName( 'a' );
	subMenus = menu.getElementsByTagName( 'ul' );

	// Set menu items with submenus to aria-haspopup="true".
	for ( i = 0, len = subMenus.length; i < len; i++ ) {
		subMenus[i].parentNode.setAttribute( 'aria-haspopup', 'true' );
	}

	// Each time a menu link is focused or blurred, toggle focus.
	for ( i = 0, len = links.length; i < len; i++ ) {
		links[i].addEventListener( 'focus', toggleFocus, true );
		links[i].addEventListener( 'blur', toggleFocus, true );
	}

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		var self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

			// On li elements toggle the class .focus.
			if ( 'li' === self.tagName.toLowerCase() ) {
				if ( -1 !== self.className.indexOf( 'focus' ) ) {
					self.className = self.className.replace( ' focus', '' );
				} else {
					self.className += ' focus';
				}
			}

			self = self.parentElement;
		}
	}

	/**
	 * Toggles `focus` class to allow submenu access on tablets.
	 */
	( function( container ) {
		var touchStartFn, i,
			parentLink = container.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

		if ( 'ontouchstart' in window ) {
			touchStartFn = function( e ) {
				var menuItem = this.parentNode, i;

				if ( ! menuItem.classList.contains( 'focus' ) ) {
					e.preventDefault();
					for ( i = 0; i < menuItem.parentNode.children.length; ++i ) {
						if ( menuItem === menuItem.parentNode.children[i] ) {
							continue;
						}
						menuItem.parentNode.children[i].classList.remove( 'focus' );
					}
					menuItem.classList.add( 'focus' );
				} else {
					menuItem.classList.remove( 'focus' );
				}
			};

			for ( i = 0; i < parentLink.length; ++i ) {
				parentLink[i].addEventListener( 'touchstart', touchStartFn, false );
			}
		}
	}( container ) );
        
        function initMainNavigation( container ) {
		// Add dropdown toggle that display child menu items.
		container.find( '.menu-item-has-children > a, .page_item_has_children > a' ).after( '<button class="dropdown-toggle" aria-expanded="false"></button>' );

		// Toggle buttons and submenu items with active children menu items.
		container.find( '.current-menu-ancestor > button' ).addClass( 'toggle-on' );
		container.find( '.current-menu-ancestor > .sub-menu' ).addClass( 'toggled-on' );
                
                //toggle the primary menu to be displayed 
                container.find( '#primary-menu' ).toggleClass('toggled-on');

		container.find( '.dropdown-toggle' ).click( function( e ) {
			var _this = $( this );
			e.preventDefault();
			_this.toggleClass( 'toggle-on' );
			_this.next( '.children, .sub-menu' ).toggleClass( 'toggled-on' );
			_this.attr( 'aria-expanded', _this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
		} );
	}
	initMainNavigation( $( '.main-navigation' ) );
        
        //toggle the primary menu to be displayed
        $('.menu-toggle').click(function() {
            $("#primary-menu").toggleClass('shown');
        });

	// Re-initialize the main navigation when it is updated, persisting any existing submenu expanded states.
	$( document ).on( 'customize-preview-menu-refreshed', function( e, params ) {
		if ( 'primary' === params.wpNavMenuArgs.theme_location ) {
			initMainNavigation( params.newContainer );

			// Re-sync expanded states from oldContainer.
			params.oldContainer.find( '.dropdown-toggle.toggle-on' ).each(function() {
				var containerId = $( this ).parent().prop( 'id' );
				$( params.newContainer ).find( '#' + containerId + ' > .dropdown-toggle' ).triggerHandler( 'click' );
			});
		}
	});
        
        // Hide/show toggle button on scroll
        
        var position, direction, previous;
        
        $(window).scroll(function() {
            if ( $(this).scrollTop() >= position ) {
                direction = "down";
                if ( direction!== previous ) {
                    $('.menu-toggle').addClass('hide');
                    
                    previous = direction;
                }
            } else {
                direction = 'up';
                if ( direction !== previous ) {
                    $('.menu-toggle').removeClass('hide');
                    
                    previous = direction;
                }
            }
            
            position = $(this).scrollTop();
        });
        
        // Remove inline styling form centered images
        $("figure.aligncenter").each(function() {
            $(this).removeAttr("width");
            $(this).removeAttr("height");
            //get text value of the style attr
            var style = $(this).attr("style");   
            
            style = "width: 100px";
            
            //get starting index of "height and width" styles
            var wStart = style.indexOf("width");
            var hStart  = style.indexOf("height");
            
            if (wStart >= 0 ) { 
                //get index of ending semi-colon
                var wEnd = style.indexOf(";", wStart) + 1;
                if (wEnd <= 0) {
                    var rem = style.substr(wStart);
                } else {
                    var rem = style.substr(wStart, wEnd);
                }
                style = style.replace(rem,"");
            }
            
            if (hStart >= 0 ) { 
                //reset hStart since width has been deleted
                hStart  = style.indexOf("height");
                var hEnd = style.indexOf(";", hStart) + 1;
                if (hEnd <= 0) {
                    var rem = style.substr(hStart);
                } else {
                    var rem = style.substr(hStart, hEnd);
                }
                style = style.replace(rem,"");
            }
                       
            $(this).attr("style", style);
            
            
        });
        
        $('.custom-menu li').mouseenter(function() {
            $(this).css("z-index", "1000");
        });
        $('.custom-menu li').mouseleave(function() {
            setTimeout(function() {
                $(this).css("z-index", "1");
            }.bind(this), 300);
        })
        
        
} )( jQuery );
