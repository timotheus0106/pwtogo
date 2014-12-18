define([
	'jquery',
	'base/MbiHelper',
	'base/MbiMediaQuery',
	'project/MbiConfig',

	'base/Vendor/Swiper',
	'base/Vendor/Debounce',
	'base/Vendor/Viewport'
], function(
	$,
	_,
	mbiMq,
	mbiConfig
) {
	'use strict';

	var module = {

		swiperObjects: new Object(),
		swiperElements: '.swiper',

		createSwiper: function(name, options) {

			var element = $('#'+name);

			module.swiperObjects[name] = new Object();
			module.swiperObjects[name].settings = options;

			var args = new Object();
			var argsAfterInit = new Object();

			// iterate through base options

			$.each(options.base, function(key, value) {

				switch(key) {

					case 'initPagination': // @todo: depend on media query to hide/show

						if(!!value) { // if not false/empty/null

							if(value === true) { // if true

								args.pagination = element+' .pagination';

							} else { // if other than true but not false/empty/null

								args.pagination = value;

							}

							args.paginationClickable = true;

							args.paginationElementClass = 'pagination__switch';
							args.paginationActiveClass = 'pagination__switch--active';
							args.paginationVisibleClass = 'pagination__switch--visible';

						}

						delete options.base[key];

						break;
					case 'initButtons':

						if(!!value) {

							if(value === true) {
								value = element;
							}

							module.swiperButtons(name, value);

						}

						delete options.base[key];

						break;
					case 'initCenterActive':

						if(value === true) { // if true

							args.onSlideChangeStart = function(swiper, direction) {

								if(element.is(':in-viewport')) {

									_.scrollto(element, 250);

								}

							};

						}

						delete options.base[key];

						break;
					case 'resizeFix':
					case 'heightAuto':
					case 'widthAuto':
					case 'initCounter':

						// delete options.base[key];

						break;
					default:

						args[key] = value;

						delete options.base[key];

						break;

				}

			});

			// iterate through states options

			if(!!options.states) { // if states exist

				$.each(mbiMq.mq, function(key, value) { // loop through mq

					if(options.states[key] == undefined) { // if there is no state for mq

						// module.swiperObjects[name].settings.states[key] = new Object();

					} else { // pass on state to settings

						module.swiperObjects[name].settings.states[key] = options.states[key];

					}

				});

				$.each(options.states, function(size, state) { // use current state to init with

					if(!!size) {

						if(size == mbiMq.mqTag || size in mbiMq.mqArea) { // if state matches current mq

							$.each(state, function(key, value) {

								args[key] = value;

								delete options.states[key];

							});

						}

					}

				});

			}

			module.swiperObjects[name].swiper = element.swiper(args);

			// functions/handler after swiper creation
			if(!!options.base.initCounter) {

				if(options.base.initCounter === true) {
					options.base.initCounter = element;
				}

				module.swiperCounter(name, options.base.initCounter);

				delete options.base.initCounter;

			}

		},
		swiperChangeState: function() {

			$.each(module.swiperObjects, function(name, item) { // loop through all swiper

				if('states' in item.settings) {

					$.each(item.settings.states, function(stateName, stateValues) { // loop through states

						var current = false;

						if(stateName == mbiMq.mqTag) {
							current = stateName;
						} else if(stateName in mbiMq.mqArea) {
							current = stateName;
						}

						if(current !== false && current in item.settings.states) {

							$.each(item.settings.states[current], function(key, value) {

								item.swiper.params[key] = value;

							});

						}

					});

					if(item.settings.base.resizeFix === true) {

						item.swiper.resizeFix();

					}

				}

			});

		},
		swiperResize: function() {

			$.each(module.swiperObjects, function(name, item) {

				var $item = $('#'+name);

				if(item.settings.base.heightAuto) {

					$item.find('.swiper__slide').css('height', 'auto');
					$item.find('.swiper__wrapper').css('height', 'auto');

				}

				if(item.settings.base.widthAuto) {

					$item.find('.swiper__slide').css('width', 'auto');
					$item.find('.swiper__wrapper').css('width', 'auto');

				}

				// if('states' in item.settings) {

				// 	var current = false;
				// 	if(stateName == mbiMq.mqTag) {
				// 		current = stateName;
				// 	} else if(stateName in mbiMq.mqArea) {
				// 		current = stateName;
				// 	}

				// 	if(current !== false && current in item.settings.states) {

				// 		if(item.settings.states[mbiMq.mqPrevious].cssWidthAndHeight !== item.settings.states[mbiMq.mqTag].cssWidthAndHeight) {

				// 			$item.find('.swiper__slide').removeAttr('style');
				// 			$item.find('.swiper__wrapper').removeAttr('style');

				// 		}

				// 	}

				// }

			});

		},
		swiperInit: function() {

			$.each(module.swiperObjects, function(name, item) {

				item.swiper.reInit();

			});

		},
		swiperCounter: function(name, selector) {

			var $counter = $(selector),
				$total = $counter.find('.control__total'),
				slides = module.swiperObjects[name].swiper.slides.length;

			$total.html(slides);

			var handler = function() {

				var index = module.swiperObjects[name].swiper.activeIndex,
					$current = $counter.find('.control__current');

				$current.html(index+1);

			};

			module.swiperObjects[name].swiper.params.onSlideChangeStart = handler;
			module.swiperObjects[name].swiper.params.onSlideChangeEnd = handler;

		},
		swiperButtons: function(name, selector) {

			var elementNext = selector + ' .js_swiperNext';
			var elementPrev = selector + ' .js_swiperPrev';

			if(_.exists(elementNext)) {
				$(document).on('click', elementNext, function(e) {

					e.preventDefault();
					module.swiperObjects[name].swiper.swipeNext();

				});
			}
			if(_.exists(elementPrev)) {
				$(document).on('click', elementPrev, function(e) {

					e.preventDefault();
					module.swiperObjects[name].swiper.swipePrev();

				});
			}

		},
		slideTo: function(selector, slide) {

			$(selector).each(function() {

				var name = $(this).attr('id');

				if(!!module.swiperObjects[name]) {

					module.swiperObjects[name].swiper.swipeTo(slide);

				}

			});


		},
		init: function() {

			module.swiperChangeState();
			module.swiperInit();

			$(document).on('breakpoint', function(event, data) {

				module.swiperChangeState();
				module.swiperResize();

			});

		}

	};

	// -----------------------------------------------------------------

	module.init();
	mbiConfig.modules.MbiSwiper = true;

	// -----------------------------------------------------------------

	return module;

});