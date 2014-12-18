define([
	'jquery',
	'project/MbiConfig',
], function(
	$,
	mbiConfig
) {
	'use strict';

	// ---------------------------------------------------------------
	// TOGGLE HANDLER
	// ---------------------------------------------------------------
	$(document).on('click', '.js_toggle', function() {

		var toggleTarget,
			toggleClass,
			toggleButtonClass = 'is_active',
			$this = $(this);

		if(!$this.hasClass('is_locked')) {

			// toggle class (for button)
			if(!!$this.attr('data-toggleClass')) {
				toggleClass = $this.attr('data-toggleClass');
			} else {
				toggleClass = 'is_active';
			}

			// toggle target (menu, popup, etc.)
			if(!!$this.attr('data-toggleTarget')) {
				toggleTarget = $(this).attr('data-toggleTarget');
			} else {
				toggleTarget = '.js_toggle';
			}

			var $toggleTarget = $(toggleTarget),
				toggleState = $toggleTarget.hasClass(toggleClass),
				$toggleButtons = $('[data-toggleTarget='+toggleTarget+'][data-toggleClass='+toggleClass+']');

			// toggle text (for button(s))
			$toggleButtons.each(function(i, value) {

				if($(this).attr('data-toggleText')) {

					var attr = $(this).attr('data-toggleText');
					var text = $(this).text();

					$(this).attr('data-toggleText', text);
					$(this).text(attr);

				}

			});

			// toggle button-set and target (on/off)
			if(toggleState) {
				$toggleTarget.removeClass(toggleClass);
				$toggleButtons.removeClass(toggleButtonClass);
			} else {
				$toggleTarget.addClass(toggleClass);
				$toggleButtons.addClass(toggleButtonClass);
			}

		}

	});

mbiConfig.modules.ToggleHandler = true;

});