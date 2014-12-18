define([
	'jquery',
	'project/MbiConfig',
], function(
	$,
	mbiConfig
) {
	'use strict';

	// ---------------------------------------------------------------
	// HOVER-ON-MOUSE/TAP-ON-TOUCH HANDLER
	// ---------------------------------------------------------------

	if(Modernizr.touch || $('html').hasClass('ios')) {

		$(document).on('click', '.js_hover', function() {

			if(!$(this).hasClass('is_locked')) {

				if(!$(this).hasClass('is_active')) {

					$('.js_hover').removeClass('is_active');
					$(this).addClass('is_active');

				}

			}

		});

	} else {

		$(document).on('mouseenter', '.js_hover', function() {

			if(!$(this).hasClass('is_locked')) {

				$(this).addClass('is_active');

			}

		});
		$(document).on('mouseleave', '.js_hover', function() {

			if(!$(this).hasClass('is_locked')) {

				$(this).removeClass('is_active');

			}

		});

	}

	mbiConfig.modules.HoverHandler = true;

});