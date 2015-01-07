require([
	'jquery',
	'project/MbiConfig',
	'base/MbiMediaQuery',
	'base/MbiHelper',

	'project/Helper',
	'base/footer',
	'base/MbiModal',
	'base/MbiImageSize',
	'base/MbiBackgroundImage'

	// 'project/HoverHandler',
	// 'project/ToggleHandler',
	// 'project/MenuToggleHandler'
], function(
	$,
	mbiConfig,
	mbiMq,
	_,
	Ajaxx
) {
	'use strict';

	// ------------------------------------------------------------------------
	// DEBUG (depends on debug value in Config.json)
	// ------------------------------------------------------------------------

	if(mbiConfig.debug) {

		console.log(mbiConfig);
		console.log(mbiMq);

	}

	// ----------------------------------------------------------------
	// CHECK LOGIN
	// ----------------------------------------------------------------
	var userId = '';

	function checkLogin(){

		$('#checkLogin').submit(function(e){
			e.preventDefault();

			var form = $("#checkLogin").serializeArray();
			$('.errorMsg').remove();

			_.ajax('checklogin', {

		        form: form

		    }, function(data) {

		        if(data.success === true) {
		            location.href = data.pageUrl;
		        } else {
		            $('.submit').prepend(data.content);

		            $('.errorMsg').fadeOut(4000, function() {
			            $('.errorMsg').remove();
			        });
		        }
		    });    
		});
	}

	// ----------------------------------------------------------------
	// OPEN PORTAL CLICK
	// ----------------------------------------------------------------

	function openPortalInfo(){
		$('.portal--item').click(function(){

			if ($(this).hasClass('open')) {

				// $(this).css('max-height', piHeight);
				$(this).removeAttr('style');
				$(this).removeClass('open');

			} else {
				var $poratlInfo = $(this).children('.portalInfos');
				var piHeight = $poratlInfo.outerHeight() + 50;

				$(this).css('max-height', piHeight);
				$(this).addClass('open');
				
			}

		});
	}

	// ----------------------------------------------------------------
	// SWIPER SETUP
	// ----------------------------------------------------------------
	// if(_.exists('.swiper')) {
	// 	require(['base/MbiSwiper'], function(mbiSwiper) {

	// 		$('.swiper').each(function() {

	// 			var id = $(this).attr('id'), // create swiper with id assigned to container
	// 				data = $('#'+id).data(),

	// 				args = {

	// 					roundLengths: 		true,
	// 					resizeFix: 			true,
	// 					grabCursor: 		true,

	// 					// @todo: move wrapper names into base ?

	// 					wrapperClass: 		'swiper__wrapper',
	// 					slideClass: 		'swiper__slide',
	// 					slideActiveClass: 	'swiper__slide--active',
	// 					slideVisibleClass: 	'swiper__slide--visible',
	// 					noSwipingClass: 	'swiper--noSwiping',

	// 				},
	// 				/**
	// 				 * set different swiper options
	// 				 * use values from mbiMq.mq
	// 				 */
	// 				states = {

	// 					'palm': {
	// 						slidesPerView: 1
	// 					},
	// 					'lap+': {
	// 						slidesPerView: 3
	// 					}

	// 				};

	// 			// @todo: move value check into swiper module ?

	// 			if('loop' in data) {
	// 				if(data.loop === true) {
	// 					args.loop = true;
	// 				}
	// 			}

	// 			if('autoplay' in data) {
	// 				if(data.autoplay === true) {
	// 					args.autoplay = 6000;
	// 				} else if(data.autoplay === parseInt(data.autoplay, 10)) { // if is integer
	// 					args.autoplay = data.autoplay;
	// 				}
	// 			}

	// 			if('initCounter' in data) {
	// 				args.initCounter = data.initCounter;
	// 				args.loop = false; // counter + loop does not work (yet)
	// 			}

	// 			if('initButtons' in data) {
	// 				args.initButtons = data.initButtons;
	// 			}

	// 			if('initPagination' in data) {
	// 				args.initPagination = data.initPagination;
	// 			}

	// 			// INIT SWIPER WITH ARGUMENTS
	// 			var options = { base: args };
	// 			if(!_.exists($(this).parents('.modal'))) { // e.g. if within modal omit states
	// 				options.states = states;
	// 			}

	// 			mbiSwiper.createSwiper(id, options);

	// 		});

	// 	});
	// }

	// ------------------------------------------------------------------------
	// DEPRECATED BROWSER MESSAGE
	//
	// uses information from mbiConfig.browser
	//
	// NOTE
	// better making use of graceful degradation OR progressive enhancement
	// rather than having to exclude certain browser!
	// ------------------------------------------------------------------------

	if(
		mbiConfig.browser.browserList.chrome 	&& mbiConfig.browser.browserVersion < 30 	&& Modernizr.touch == false
		||
		mbiConfig.browser.browserList.firefox 	&& mbiConfig.browser.browserVersion < 15
		||
		mbiConfig.browser.browserList.safari 	&& mbiConfig.browser.browserVersion < 6
		||
		mbiConfig.browser.browserList.ie 		&& mbiConfig.browser.browserVersion < 9
		||
		mbiConfig.browser.browserList.opera 	&& mbiConfig.browser.browserVersion < 12
	) {

		alert('This page will not work on this browser ('+mbiConfig.browser.browserName+' '+mbiConfig.browser.browserVersion+') because someone did not think about graceful degradation or progressive enhancement!');

	}

	$(document).ready(function(){
		checkLogin();
		openPortalInfo();
		// setBodyAttr();
	});


});