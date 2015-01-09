require([
	'jquery',
	'project/MbiConfig',
	'base/MbiMediaQuery',
	'base/MbiHelper',

	'project/Helper',
	'base/footer',
	'base/MbiModal',
	'base/MbiImageSize',
	'base/MbiBackgroundImage',

	'project/Vendor/zclip-min'
	// 'project/ToggleHandler',
	// 'project/MenuToggleHandler'
], function(
	$,
	mbiConfig,
	mbiMq,
	_,
	Ajaxx,
	zclip
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
	// ADD NEW PORTAL
	// ----------------------------------------------------------------


	function addNewPortal(){

		$('#form__addNewPortal').submit(function(e){
			e.preventDefault();

			var form = $("#form__addNewPortal").serializeArray();
			// var portalName = $(this).parent().parent().attr('data-portalName');
			var portalName = $('.modal.modal__addNewPortal').attr('data-edit');
			// $('.errorMsg').remove();
			var is_editing = 'false';
			if ($('.modal.modal__addNewPortal').hasClass('editing')) {
				is_editing = 'true';
			}

			_.ajax('addNewPortal', {

		        form: form,
		        oldPortal: portalName,
		        is_editing: is_editing

		    }, function(data) {

		        if(data.success === true) {
		            $('.modal.modal__addNewPortal').removeClass('modalOpen').removeClass('editing');
		            location.reload();
		        } else {

		        }
		    });
		});
	}


	// ----------------------------------------------------------------
	// OPEN PORTAL CLICK
	// ----------------------------------------------------------------

	function openPortalInfo(){
		$('.portal__name').click(function(){

			$('.portal--item').removeClass('open').removeAttr('style');

			if ($(this).parent('.portal--item').hasClass('open')) {

				// $(this).css('max-height', piHeight);
				// $(this).parent('.portal--item').removeAttr('style');
				// $(this).parent('.portal--item').removeClass('open');

			} else {
				var $poratlInfo = $(this).siblings('.portalInfos');
				var piHeight = $poratlInfo.outerHeight();

				$(this).parent('.portal--item').css('max-height', piHeight + 120);
				$(this).parent('.portal--item').addClass('open');

			}

		});
	}

	// ----------------------------------------------------------------
	// ADD NEW PORTAL SHOW MODAL
	// ----------------------------------------------------------------

	function showModal(){
		$('.js_newPortal').on('click', function(){
			$('.modal.modal__addNewPortal').addClass('modalOpen');
		});
	}

	// ----------------------------------------------------------------
	// COPY TO CLIPBOARD
	// ----------------------------------------------------------------

	function copyToClipboard(){
		// $('.copy--button').zclip({
		// 	path:'js/ZeroClipboard.swf',
		// 	copy:$('.contentTest').text()
		// });
	}

	// ----------------------------------------------------------------
	// LOGOUT USER
	// ----------------------------------------------------------------

	function logout(){
		$('.js_logout').on('click', function(){
			var something = 'something';
			_.ajax('logout', {

		        something: something

		    }, function(data) {

		        if(data.success === true) {
		            // $('.modal.modal__addNewPortal').removeClass('modalOpen');
		            // location.reload();
		            location.href = data.gotopage;
		        } else {

		        }
		    });
		});
	}

	// ----------------------------------------------------------------
	// DELETE PORTAL
	// ----------------------------------------------------------------


	function deleteButton(){

		$('.js_deleteButton').on('click', function(){
			var portalName = $(this).parent().parent().attr('data-portalName');

			console.log('clicked');

			_.ajax('deletePortal', {

				portalName: portalName

		    }, function(data) {

		        if(data.success === true) {
		            $('.modal.modal__addNewPortal').removeClass('modalOpen');
		            location.reload();
		        } else {

		        }
		    });

		});
	}

	// ----------------------------------------------------------------
	// EDIT PORTAL
	// ----------------------------------------------------------------

	function editButton(){
		$('.js_editButton').on('click', function(){
			var portalName = $(this).parent().parent().attr('data-portalName');

			_.ajax('editPortal', {

		        portalName: portalName

		    }, function(data) {

		        if(data.success === true) {
		            var portal = data.portal
                    var mail = data.mail
                    var user = data.user
                    var password = data.password
                    var addInfo = data.addInfo

		            $('.modal.modal__addNewPortal').addClass('modalOpen').addClass('editing');
		            $('.modal.modal__addNewPortal').attr('data-edit', portal);

		            $('.c_portal').val(portal);
		            $('.c_email').val(mail);
		            $('.c_username').val(user);
		            $('.c_password').val(password);
		            $('#c_further').val(addInfo);



		            // location.reload();
		        } else {

		        }
		    });
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
		showModal();
		addNewPortal();
		copyToClipboard();
		deleteButton();
		editButton();
		logout();
	});


});