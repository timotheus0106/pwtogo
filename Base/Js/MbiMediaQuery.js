define([
	'jquery',
	'base/Vendor/PictureFill',
	'project/MbiConfig'
], function(
	$,
	picturefill,
	mbiConfig
) {
	'use strict';

	var module = {

		mq: new Object(),
		mqBreakpoint: true,
		mqPrevious: 'none',
		mqTag: 'all',
		mqArea: new Object(),
		mqQuery: null,

		/**
		 * Overwrite Defaults
		 * @param {Object} queries Media Queries to be used within mbi system
		 */
		setMediaQueries: function(data) {

			var mediae = {};

			for(var key in data) {
				var obj = data[key];
				for (var prop in obj) {
					if(obj.hasOwnProperty(prop)){
						mediae[key] = 'only screen and (min-width: '+obj[0]+') and (max-width: '+obj[1]+')';
						mediae[key+'+'] = 'only screen and (min-width: '+obj[0]+')';
						mediae[key+'-'] = 'only screen and (max-width: '+obj[1]+')';
					}
				}
			}

			module.mq = mediae;

			return true;

		},

		/**
		 * Checks for Media Query changes
		 *
		 * @returns {null}
		 */
		checkMediaQuery: function() {

			module.mqArea = new Object();

			$.each(module.mq, function(key, query) {

				if(matchMedia(query).matches) {

					if(key.indexOf('+') > -1 || key.indexOf('-') > -1) {

						module.mqArea[key] = query;

					} else {

						module.mqTag = key;
						module.mqQuery = query;

					}

				}

			})

			if(module.mqTag == module.mqPrevious) {

				module.mqBreakpoint = false;

			} else {

				module.mqBreakpoint = true;

				var args = {
					from: module.mqPrevious,
					to: module.mqTag,
					query: module.mqQuery
				}

				$(document).trigger('breakpoint', args); // triggers custom "change of state" event to hook to

			}

			module.mqPrevious = module.mqTag;

		},
		init: function() {

			module.setMediaQueries(mbiConfig.mediaQueries);

			module.checkMediaQuery();

			$(window).resize(function() { // @todo: do this with request animation frame?

				module.checkMediaQuery();

			});

			if(mbiConfig.debug) {
				$(document).on('breakpoint', function(event, data) {

					console.log('breakpoint', data.from+' -> '+data.to);

				});
			}

		}

	}

	module.init(); // init mqs
	mbiConfig.modules.MbiMediaQuery = true;

	return module;

});