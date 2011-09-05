
/*
 * superfish_width_mod v0.3 beta
 * Copyright (c) 2009 Cy Morris
 *
 * Dual licensed under the MIT and GPL licenses:
 * 	http://www.opensource.org/licenses/mit-license.php
 * 	http://www.gnu.org/licenses/gpl.html
 * 
 * Dependencies: jQuery
 *
 * Description: Allows you to set the width of your Superfish menu and have menu items automatically resized to fit.
 
	There are 5 different sizing options:
		1. Don't resize anything (disable this mod)
			HOW: disableMod: true
		2. Make all top menu items the same width, including separators
		   NOTE: If an item is already too big, it will be left too big and the remaining items will be shrunk
			HOW: equalWidth: true, resizeSeps: true
		3. Same as 1, but excluding separators (they will retain their original width)
			HOW: equalWidth: true, resizeSeps: false
		4. Resize each top menu item individually based on ratio of item width to menu width, including separators
			HOW: equalWidth: false, resizeSeps: true
		5. Same as 3, but excluding separators (they will retain their original width)
			HOW: equalWidth: false, resizeSeps: false
*/

;(function($){ // $ will refer to jQuery within this closure

	var defaults = {
		
		equalWidth: true,
		resizeSeps: false,
		vertical: false, // if it's a vertical menu, the items will all be set to 100% of the menu width
		
		/* set the menu width: can be number of pixels (format: 700,) or percent (format: '95%',) */
		menuWidth: 		'100%', 
		
		/* Resize submenus? If true, small submenus will be widened to match their parent item width */
		resizeSubMenus: true
		
	};
	
	var initialized = false;
								  
	$.fn.superfish_width_mod = function(options){
		// get options
		var opts = $.extend({}, $.fn.superfish_width_mod.defaults, options);

		// return original object to support chaining
		rVal = this.each(function() {
								  
			var menu = $(this);
			menu.timer = false;
			
			// support metadata
			var o = $.meta ? $.extend({}, opts, menu.data()) : opts;

			// cache all ul elements
			menuItems = menu.find('>li');

			var origMenuW   = menu.width();
			menu.width( o.menuWidth );
			newMenuW = menu.width();

			var sepAdjust 	= 0;
			var itemCount 	= menuItems.length;
			var itemsWidth = 0;

			// undo from previous resizes
			menuItems.each( function(){ $(this).removeClass('superfish_width_mod_skip'); });

			/*  SEPARATOR WIDTH ADJUSTMENT
				if there are separators but they are not to be resized, we need to adjust the newMenuW ratio to not 
				include them.  First we find each and gather it's width, then we subtract that from the newMenuW
			*/

			if( !o.vertical && !o.resizeSeps ) {
				menu.find('>li>span.separator').each( function() {
					$(this).parent().addClass('separator');
					$(this).parent().addClass('superfish_width_mod_skip');
					sepAdjust += $(this).parent().outerWidth(); // the width of the li
					itemCount--;
				} );
			}
			
			/*  END -- SEPARATOR WIDTH ADJUSTMENT  */
			
			/*  BIG MENU ITEMS ADJUSTMENT
				If equalWidth is set to true but some menu items are too big for the new item width, they 
				will retain their original width, so we have to adjust the newMenuW ratio to not include them
			*/
			if(!o.vertical && o.equalWidth) {
				menuItems.each( function() {
					mItem = $(this);
					if(mItem.hasClass('separator') && !o.resizeSeps) return; // already accounted for if true
					mItem.css('width','auto');
					if(mItem.width() > parseInt( (newMenuW-sepAdjust)/itemCount )) {
						mItem.addClass('superfish_width_mod_skip');
						sepAdjust += mItem.width();
						itemCount--;
					}
				} );
			}
//			alert(itemCount);

			/*  END -- BIG MENU ITEMS ADJUSTMENT */

			nW = 0;

			menuItems.each( function() {
				mItem = $(this);
				if(itemCount == 0) itemCount = 1;
				if(origMenuW == 0) origMenuW = 1;

				// if it's a vertical menu, items will be 100% the width
				if(o.vertical) newItemW = newMenuW;
				// large items and separators
				else if(mItem.hasClass('superfish_width_mod_skip')) newItemW = 0;//mItem.width();
				// resize equally
				else if(o.equalWidth) newItemW = parseInt( (newMenuW-sepAdjust)/itemCount );
				// resize by ratio
				else newItemW = parseInt( mItem.width()/(origMenuW-sepAdjust)*(newMenuW-sepAdjust) );
	
				// do the resize
				if(newItemW > 0) mItem.width( newItemW );
				nW += mItem.outerWidth(true);
				
				mItem.find('>ul').each( function() {
					subMenu = $(this);
					// resize submenus and move their submenus over
					if(o.vertical) {
						subMenu.css('left', newItemW+'px');
					} else if(o.resizeSubMenus && subMenu.width() < newItemW) {
						subMenu.width( newItemW );
						subMenu.find('>li>ul').css('left', newItemW+'px');
					}
				} );
				
			});
			// account for integer truncation ( 1.34232 would have become just 1 )
			while(nW < newMenuW) {
				for(var i=0; i<menuItems.length; i++) {
					mItem = $(menuItems[i]);
					if(mItem.hasClass('superfish_width_mod_skip')) continue;
					mItem.width( mItem.width()+1 );
					nW += 1;
					if(nW == newMenuW) break;
				}
			}
			while(nW > newMenuW) {
				for(var i=0; i<menuItems.length; i++) {
					mItem = $(menuItems[i]);
					if(mItem.hasClass('superfish_width_mod_skip')) continue;
					mItem.width( mItem.width()-1 );
					nW -= 1;
					if(nW == newMenuW) break;
				}
			}
			if(!initialized) $(window).resize( function() { 
				if(menu.timer) clearTimeout(menu.timer);
				menu.timer = setTimeout( 
					function() { 
						menu.superfish_width_mod(options); 
					}, 
					500
				)
			} );
		});

		initialized = true;
		return rVal;

	};
	// expose defaults
	$.fn.superfish_width_mod.defaults = defaults;
	
})(jQuery); // plugin code ends

