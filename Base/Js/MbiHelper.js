define([
	'jquery',
	'project/MbiConfig'
	// 'base/Vendor/JQueryEasing'
], function(
	$,
	mbiConfig
) {
	'use strict';

	var module = {

		/**
		 * if element exists
		 *
		 * USAGE: if(_.exists('.item')) { … }
		 *
		 * @param  {String} element 	selector to check
		 * @return {Bool}         		if exists or not
		 */
		exists: function(element, $container) {

			var test;

			if(typeof $container == 'undefined') {
				test = $(element).length;
			} else {
				test = $container.find(element).length;
			}

			if(test > 0) {
				return true;
			} else {
				return false;
			}

		},
		/**
		 * Scroll viewport to a certain element
		 *
		 * USAGE: _.scrollToTarget('')
		 *
		 * @param  {String}   	element   	css selector of element to scroll to
		 * @param  {Int}   		speed     	speed of scroll anmation (standard is 500)
		 * @param  {Int}   		offset    	offset (standard is 0)
		 * @param  {Function} 	callback  	callback function after scrollto event is finished (standard is empty function)
		 * @param  {String}   	container 	container to scroll (standard is 'html, body')
		 */
		scrollToTarget: function(element, speed, offset, callback, container) {

			var value, top;

			if(typeof callback == 'undefined') {
				callback = function() {
					// nothing
				}
			}
			if(typeof speed == 'undefined') {
				speed = 1000;
			}
			if(typeof offset == 'undefined') {
				offset = 0;
			}

			if(typeof element == 'undefined') {
				element = 'body';
			}

			if(typeof container == 'undefined') {
				container = 'html, body';
				top = $(element).offset().top;
			} else {
				top = $(element).position().top;
			}

			value = top + offset;

			$(container).animate({
				scrollTop: value
			}, speed, 'easeOutExpo').promise().done(callback);

		},
		/**
		 * get prefixed name for transitionend event
		 *
		 * usage: $('.element').on(mbiHelper.transitionend(), function() { … });
		 *
		 * @return {String} prefixed transitionend event name
		 */
		transitionend: function() {

			var transitionend = (function(transition) {

				var transEndEventNames = {
					'WebkitTransition': 'webkitTransitionEnd', // Saf 6, Android Browser
					'MozTransition': 'transitionend', // only for FF < 15
					'transition': 'transitionend' // IE10, Opera, Chrome, FF 15+, Saf 7+
				};

				return transEndEventNames[transition];

			})(Modernizr.prefixed('transition'));

			return transitionend;

		},
		animationend: function() {

			var animationend = (function(animation) {

				var animationEndEventNames = {
					'WebkitAnimation': 'webkitAnimationEnd',
					'OAnimation': 'oAnimationEnd',
					'MSAnimation': 'MSAnimationEnd',
					'animation': 'animationend'
				};

				return animationEndEventNames[animation];

			})(Modernizr.prefixed('animation'));

			return animationend;

		},

		parseURI: function(uri) {

			var match = uri.match(/^(https?\:)\/\/(([^:\/?#]*)(?:\:([0-9]+))?)(\/[^?#]*)(\?[^#]*|)(#.*|)$/);
			return match && {
				protocol: 	match[1],
				host: 		match[2],
				hostname: 	match[3],
				port: 		match[4],
				pathname: 	match[5],
				search: 	match[6],
				hash: 		match[7]
			}

		},
		ajax: function(action, ajaxData, responseFunction) {

            ajaxData.action = action;

            $.ajax({

                type: 'POST',
                data: ajaxData

            }).done(function(response) {

                responseFunction(response);

            }).fail(function(xhr, ajaxOptions, thrownError) {

                alert(thrownError);

            });

        },
		/**
		 * EXAMPLES:
		 *
		 * _.log('This is a message displayed as a notice in console.', 'notice');
		 * _.log('This is a message displayed as a normal string in console.');
		 * _.log({ 'info': 'This is a object displayed in console.' });
		 * _.log({ 'info': 'This is a object displayed in console including a name for the object.' }, 'name of object');
		 *
		 * @param  {mixed} message
		 * @param  {mixed} type (error, notice, info, event)
		 */
		log: function(message, type) {

			if(mbiConfig.debug === true) {

				var color = 'black',
					title = '';

				if(type == 'error') {
					color = 'tomato';
					title = '[error]';
				} else if(type == 'notice') {
					color = 'peru';
					title = '[notice]';
				} else if(type == 'info') {
					color = 'seagreen';
					title = '[info]';
				} else if(type == 'event') {
					color = 'hotpink';
					title = '[event]';
				} else if(typeof message == 'object' && typeof type == 'undefined') {
					type = '';
				}

				if(window.console && window.console.log) {
					if (typeof message == 'object') {
						color = 'cornflowerblue';
						title = '[object]';
						console.log('%c'+title+' '+type, 'color: '+color+';', message);
					} else if (typeof type == 'object') {
						color = 'cornflowerblue';
						title = '[object]';
						console.log('%c'+title+' '+message, 'color: '+color+';', type);
					} else {
						console.log('%c'+title+' '+message, 'color: '+color+';');
					}
				}

			}

		}

	}

	mbiConfig.modules.MbiHelper = true;

	return module;

});

// ----------------------------------------------------------------
// JQUERY HELPER (GLOBAL)
// ----------------------------------------------------------------

$.fn.outerHTML = function() {

	// IE, Chrome & Safari will comply with the non-standard outerHTML, all others (FF) will have a fall-back for cloning
	return (!this.length) ? this : (this[0].outerHTML || (
	  function(el){
		  var div = document.createElement('div');
		  div.appendChild(el.cloneNode(true));
		  var contents = div.innerHTML;
		  div = null;
		  return contents;
	})(this[0]));

}

$.extend( $.easing, {
	easeOutExpo: function (x, t, b, c, d) {
		return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
	}
});