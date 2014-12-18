define([
	'jquery',
	'project/MbiConfig',
	'base/MbiMediaQuery',
	'base/MbiHelper',
], function(
	$,
	mbiConfig,
	mbiMq,
	_
) {
	'use strict';

	// ---------------------------------------------------------------
	// VIDEO HANDLER
	// ---------------------------------------------------------------
	if(Modernizr.video) {

		// if(mbiConfig.browser.android !== false && parseFloat(mbiConfig.browser.android) < 4.3) {
		// 	$('html').addClass('android-video');
		// }

		if(mbiConfig.browser.android == false || parseFloat(mbiConfig.browser.android) >= 4.3) {

			$(document).on('click', '.js_video', function() {

				var	$button = $(this),
					toggleTarget = $button.attr('data-toggleTarget'),
					target = $button.attr('data-videoTarget'),
					video = $(target).get(0),

					endVideo = function() {

						$button.addClass('is_locked');
						$button.removeClass('js_videoStop');

						video.pause();

						var attr = $button.attr('data-textStart');
						$button.text(attr);

						$(toggleTarget).removeClass('is_active');

						$button.addClass('js_videoPlay');
						$button.removeClass('is_locked');

					},
					playVideo = function() {

						$(target).off('loadstart');

						$button.removeClass('js_videoPlay');

						video.play();

						var attr = $button.attr('data-textPause');
						$button.text(attr);

						$(target).off('canplay');

						$(toggleTarget).addClass('is_active');

						$button.addClass('js_videoStop');
						$button.removeClass('is_locked');

					};

				if($button.hasClass('js_videoPlay')) {

					if(!$button.hasClass('is_locked')) {

						$button.addClass('is_locked');
						$button.removeClass('js_videoPlay');

						video.paused ? video.play() : video.load();

					}

					$(target).on('loadstart', function() {

						var attr = $button.attr('data-textLoading');
						$button.text(attr);

					});

					$(target).on('ended', function() {
						$button.trigger('click');
					});

					$(target).on('canplay', function() {
						playVideo();
					});

					$(target).on('play', function() {
						playVideo();
					});

				} else if($button.hasClass('js_videoStop')) {

					if(!$button.hasClass('is_locked')) {

						endVideo();

					}

				}

			});

		}

	}

});