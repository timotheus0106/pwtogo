/**
 * @todo: lazy load with loading animation
 */
require([
	'jquery',
	'base/MbiHelper',
	'project/MbiConfig',
	'base/MbiMediaQuery'
], function(
	$,
	_,
	mbiConfig,
	mbiMq
) {
	'use strict';

	// ----------------------------------------------------------------
	// BACKGROUND IMAGE SRCSET
	// ----------------------------------------------------------------

	var module = {

		container: '.background',
		sheets: new Object(),
		add: function(selector, rules, media, index) {

			var sheet = module.sheets[media];

			if('insertRule' in sheet) {
				sheet.insertRule(selector + '{' + rules + '}', index);
			} else if('addRule' in sheet) {
				sheet.addRule(selector, rules, index);
			}

		},
		check: function() {

			$(module.container).each(function() {

				var	$this = $(this),
					set = $this.attr('data-srcset');

				if(typeof set == 'undefined') {
					return;
				}
				var sources = set.split(','),
					delay = $this.attr('data-delay'),
					data = {},
					id = $this.attr('id');

				$.each(sources, function(i, source) {

					var trim = source.trim(),
						split = trim.split(' '),
						url = split[0],
						area = split[1]; // e.g. lap+

					module.add('#'+id, 'background-image: url('+url+');', area);

				});

			});

		},
		init: function() {

			var queries = mbiMq.mq;

			$.each(queries, function(key, query) {

				var style = document.createElement('style');
				style.setAttribute('media', query);
				style.setAttribute('data-mq', key);
				style.appendChild(document.createTextNode('')); // WebKit hack :(
				document.head.appendChild(style);

				module.sheets[key] = style.sheet;

			});

			// console.log(module.sheets);

			module.check();

		}

	};

	module.init();

	mbiConfig.modules.MbiBackgroundImage = true;

	return module;

});