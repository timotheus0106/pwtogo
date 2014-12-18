require([
	'jquery',
	'base/Vendor/PictureFill',

	'project/MbiConfig',
	'base/MbiMediaQuery',
	'base/MbiBrowser',
	'base/MbiHelper'

], function(
	$,
	picturefill,
	mbiConfig
) {
	'use strict';

	function scrollbarWidth() {

		// Create the measurement node
		var scrollDiv = document.createElement('div');
		scrollDiv.className = '_scrollbarMeasure';
		document.body.appendChild(scrollDiv);

		// Get the scrollbar width
		mbiConfig.browser.scrollbar = scrollDiv.offsetWidth - scrollDiv.clientWidth;

		// Delete the DIV
		document.body.removeChild(scrollDiv);

	}
	scrollbarWidth();

});