define([
	'jquery',
	'base/MbiHelper',
	'base/MbiSwiper',
	'project/MbiConfig'
], function(
	$,
	_,
	mbiSwiper,
	mbiConfig
) {
	"use strict";

	// ----------------------------------------------------------------
	// MODAL WINDOW
	// ----------------------------------------------------------------
	var module = {

		init: function() {

			// var overlay = $('<div class="modal__overlay"></div>');
			// $('body').append(overlay);

			$(document).on('click', '.js_modalTrigger', function(e) {

				e.preventDefault();
				module.callModal($(this).attr('data-modal'));

			});

			$(document).on('click', '.js_modalClose', function(e) {

				e.preventDefault();
				module.removeModal();

			});

			$(document).on('showModal', '.modal', function(event, uid) {

				module.callModal('#modal--'+uid);

			});

			// if(exists('.js_modalAuto')) {

			// 	var autoLink = $('.js_modalAuto').first().attr('data-modal');
			// 	callModal(autoLink);

			// }

			if(_.exists('.modal--auto')) {

				var autoModal = '#'+$('.modal--auto').first().attr('id');
				module.callModal(autoModal);

			}

		},
		removeModal: function() {

			$('.modal').removeClass('modal--show');
			// $('.modal__overlay').removeClass('modal__overlay--visible');

			$('body').removeClass('has_modal');

		},
		callModal: function(what) {

			if(_.exists(what)) {

				$('.modal').removeClass('modal--show');

				var modal = $(what);
				modal.addClass('modal--show');

				// $('.modal__overlay').addClass('modal__overlay--visible');

				$('body').addClass('has_modal');

				// IF A SWIPER EXISTS GOTO FIRST SLIDE (AGAIN)
				if($(what).find('.swiper')) {

					var id = $(what).find('.swiper').attr('id');
					mbiSwiper.swiperObjects[id].swiper.swipeTo(0,0);
					mbiSwiper.swiperObjects[id].swiper.resizeFix();

				}

				return modal;

			}

		},
		// createModal: function(modal, uid) {

		// 	var modal = $(modal);

		// 	// $('.modal__overlay').before(modal);
		// 	$('body').append(modal);

		// },
		showModal: function(uid) {

			$('.modal').trigger('showModal', uid);

		}

	};

	module.init();

	mbiConfig.modules.MbiModal = true;

	return module;

});