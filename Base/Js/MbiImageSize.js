define([
	'jquery',
	'base/MbiHelper',
	'project/MbiConfig'
], function(
	$,
	_,
	mbiConfig
) {
	'use strict';

	// ---------------------------------------------------------------
	// IMAGE--COVER
	// ---------------------------------------------------------------
	var module = {

		images: $('.image--cover'),
		init: function() {

			for(var i=0; i<module.images.length; i++) {

				var image = module.images[i];
				var $image = $(image);
				var $parent = $image.parents('[class~="image:parent"]');

				var imageWidth = image.naturalWidth;
				var imageHeight = image.naturalHeight;
				var imageRatio = imageWidth/imageHeight;

				var parentWidth = $parent.innerWidth();
				var parentHeight = $parent.innerHeight();
				var parentRatio = parentWidth/parentHeight;

				if(imageRatio >= parentRatio) {
					$image.addClass('image--fitHeight');
				} else {
					$image.addClass('image--fitWidth');
				}
			};

		},
		checker: function() {

			for(var i=0; i<module.images.length; i++) {

				var $image = $(module.images[i]);
				var $parent = $image.parents('[class~="image:parent"]');

				var imageWidth = $image.innerWidth();
				var imageHeight = $image.innerHeight();

				var parentWidth = $parent.innerWidth();
				var parentHeight = $parent.innerHeight();

				if($image.hasClass('image--fitHeight') && imageWidth < parentWidth) {

					$image.removeClass('image--fitHeight');
					$image.addClass('image--fitWidth');
				} else if($image.hasClass('image--fitWidth') && imageHeight < parentHeight) {

					$image.removeClass('image--fitWidth');
					$image.addClass('image--fitHeight');

				}

			};

		}

	};

	if(_.exists('.image--cover') || _.exists('.swiper')) {

		module.init();

		$(window).load(function() {
			module.checker();
			// $('.image--cover').addClass('image--visible');
		});

		$(window).resize(function() {
			module.checker();
		});

	}

	mbiConfig.modules.MbiImageSize = true;

	return module;

});