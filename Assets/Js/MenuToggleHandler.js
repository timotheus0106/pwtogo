define([
	'jquery',
	'project/MbiConfig',
], function(
	$,
	mbiConfig
) {
	'use strict';

	// ---------------------------------------------------------------
	// MENU TOGGLE HANDLER
	//
	// simple toggles a menu, using one or more buttons.
	// the buttons also receive an active class and are connected to the navigation state.
	// a click outside the navigation also closes it.
	// ---------------------------------------------------------------

	var $body = $('body'),
		buttonsClass = '.js_toggleNavigation',
		$buttons = $(buttonsClass),

		navigationSelector = '.navigation',
		menuClass = 'has_navigation--open',
		buttonActiveClass = 'is_active',

		navClicker = function(e) {

			if($(e.target).closest(navigationSelector).length === 0 ) { // "it's magic"

				$body.removeClass(menuClass);
				$buttons.removeClass(buttonActiveClass);
				$(document).off('click', navClicker); // remove click handler when clicked once

			}

		};

	$(document).on('click', buttonsClass, function() {

		var $this = $(this);

		if(!$this.hasClass('is_locked')) {

			$buttons.addClass('is_locked');

			if($body.hasClass(menuClass)) { // if nav open

				$body.removeClass(menuClass); // close nav
				$buttons.removeClass(buttonActiveClass);
				$(document).off('click', navClicker); // remove click outside nav to close

			} else { // if nav closed

				$body.addClass(menuClass); // open nav
				$buttons.addClass(buttonActiveClass);
				$(document).on('click', navClicker); // add click outside nav to close

			}

			$buttons.removeClass('is_locked');

		}

	});

	mbiConfig.modules.MenuToggleHandler = true;

});