define([
	'jquery',
	'project/MbiConfig',
	'base/MbiHelper'
], function(
	$,
	mbiConfig,
	_
) {
	'use strict';

	// ---------------------------------------------------------------
	// TEST FOR BROWSER
	//
	// just to circumvent browser specific bugs that cannot be fixed by testing for features.
	// always test for features!
	// ---------------------------------------------------------------

	function getAndroidVersion(ua) {
	    var ua = ua || navigator.userAgent;
	    var match = ua.match(/Android\s([0-9\.]*)/);
	    return match ? match[1] : false;
	};

	function getBrowserVersion() {

		var ua = navigator.userAgent,
			tem,
			M = ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];

		if(/trident/i.test(M[1])) {
			tem = /\brv[ :]+(\d+)/g.exec(ua) || [];
			return 'IE '+(tem[1]||'');
		}
		if(M[1]==='Chrome') {
			tem = ua.match(/\bOPR\/(\d+)/)
			if(tem!=null) {
				return 'Opera '+tem[1];
			}
		}
		M = M[2] ? [M[1], M[2]] : [navigator.appName, navigator.appVersion, '-?'];
		if((tem = ua.match(/version\/(\d+)/i)) != null) {
			M.splice(1,1,tem[1]);
		}
		return M[1];

	}

	function testIE11() {

		var ie11Styles = [
				'msTextCombineHorizontal'
			],
			d = document,
			b = d.body,
			s = b.style,
			isIE11 = false,
			property;

		for (var i = 0; i < ie11Styles.length; i++) {

			property = ie11Styles[i];

			if(s[property] != undefined) {

				isIE11 = true;

			}

		}

		if(isIE11) {
			$('html').addClass('ie11');
		}

		return isIE11;

	}

	function testForBrowser() {

		var browser = {},
			version = getBrowserVersion(),
			isIE11 = testIE11(),
			result;

		browser.firefox = 	typeof InstallTrigger !== 'undefined';
		browser.opera = 	!!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0; // Opera 8.0+ (UA detection to detect Blink/v8-powered Opera)
		browser.safari = 	Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0; // At least Safari 3+: "[object HTMLElementConstructor]"
		browser.chrome = 	!!window.chrome && !browser.opera; // Chrome 1+
		browser.ie = /*@cc_on!@*/false || !!document.documentMode; // At least IE6

		$.each(browser, function(index, value) {
			if(value) {
				$('html').addClass(index).attr('data-browser-name', index).attr('data-browser-version', version);
				result = index;
			} else {
				$('html').addClass('no-'+index);
			}
		});

		var ios = false;
		if((window.navigator.userAgent.match(/iPhone/i)) || (window.navigator.userAgent.match(/iPod/i)) || (window.navigator.userAgent.match(/iPad/i))) {

			$('html').addClass('ios');
			ios = true;

		}

		mbiConfig.browser = {
			'browserName' : result,
			'browserVersion' : version,
			'browserList' : browser,
			'android' : getAndroidVersion(),
			'ios' : ios
		};

	}
	testForBrowser();

	mbiConfig.modules.MbiBrowser = true;

});