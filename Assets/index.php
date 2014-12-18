<?php require_once('functions.php'); ?><!DOCTYPE html>
<!--[if lt IE 9]><html class="no-js ie8"><![endif]-->
<!--[if IE 9]><html class="no-js ie9"><![endif]-->
<!--[if IE 10]><html class="no-js ie10"><![endif]-->
<!--[if !IE]> --><html class="no-js"><!-- <![endif]-->
<head>
	<meta charset="UTF-8">
	<title>Test</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />

	<link rel="stylesheet" href="Css/Style.css" type="text/css" media="all" />

	<script src="../Base/Js/Vendor/require.js"></script>
	<script type="text/javascript">
		require.config({
			"paths": {
				"base": "../Base/Js/",
				"project": "./Js/"
			}
		});
	</script>
	<script src="./BuildJs/header.js"></script>

</head>
<body>

	<div class="navigation">

		<ul>
			<li>Home</li>
			<li>News</li>
			<li>About</li>
		</ul>

		<div class="button js_toggleNavigation"><?php Image::svg('empty'); ?></div>

	</div><!-- .navigation -->

	<div class="site" id="site_container">

		<div class="grid grid--center (1/1) max(landscape)">

			<div class="grid__item (1/1)">
				<img src="./Images/logo.png" class="image" />
				<div class="button button--text js_toggleNavigation">TOGGLE MENU</div>
			</div>

			<div class="module module--swiper grid__item (1/1)">

				<div class="title">Swiper</div>

				<div class="module__container">

					<div class="swiper" id="swiper_XY" data-init-pagination="#pagination_swiper_XY" data-init-buttons="#control_swiper_XY" data-init-counter="#control_swiper_XY" data-loop="true" data-autoplay="true">
						<div class="swiper__wrapper">

							<div class="swiper__slide">
								<div class="slide__container">Slide 1</div>
							</div>
							<div class="swiper__slide">
								<div class="slide__container">Slide 2</div>
							</div>
							<div class="swiper__slide">
								<div class="slide__container">Slide 3</div>
							</div>
							<div class="swiper__slide">
								<div class="slide__container">Slide 4</div>
							</div>
							<div class="swiper__slide">
								<img src="./Images/dummy.jpg" class="image image--cover" />
							</div>
							<?php
							/*
							<div class="swiper__slide">
								<?php Image::dummy(600,400, array('class' => 'image--stretchWidth')); ?>
							</div>
							*/
							?>

						</div>
					</div>

					<div id="control_swiper_XY" class="control control--swiper">

						<div class="control__button js_swiperPrev"><?php Image::svg('empty'); ?></div>
						<div class="control__counter">
							<span class="control__current">1</span>/<span class="control__total">1</span>
						</div>
						<div class="control__button js_swiperNext"><?php Image::svg('empty'); ?></div>

					</div>

					<div id="pagination_swiper_XY" class="pagination pagination--swiper"></div>

				</div>

			</div><!-- .module--swiper -->

			<div class="module module--raster grid__item grid__item--row (1/1)">

				<div class="title">Hover/Toggle</div>

				<div class="product grid__item (1/4) lap-(1/2) js_hover">
					<div class="product__wrapper hover__container">
						<div class="title">HOVER</div>
					</div>
					<div class="indicator indicator--touch"><?php Image::svg('empty'); ?></div>
				</div>
				<div class="product grid__item (1/4) lap-(1/2) js_hover is_locked">
					<div class="product__wrapper hover__container">
						<div class="title">HOVER</div>
					</div>
					<div class="indicator indicator--touch"><?php Image::svg('empty'); ?></div>
				</div>
				<div class="product grid__item (1/4) lap-(1/2) js_hover">
					<div class="product__wrapper hover__container">
						<div class="title">HOVER</div>
					</div>
					<div class="indicator indicator--touch"><?php Image::svg('empty'); ?></div>
				</div>
				<div class="product grid__item (1/4) lap-(1/2) js_hover">
					<div class="product__wrapper hover__container">
						<div class="title">HOVER</div>
					</div>
					<div class="indicator indicator--touch"><?php Image::svg('empty'); ?></div>
				</div>

			</div><!-- .module--raster -->

			<div class="module module--toggle grid__item grid__item--row (1/1)">

				<div class="title">Toggle</div>

				<div class="grid__item (1/5) lap-(1/3)">
					<div class="button button--text js_toggle" data-toggleClass="is_testA" data-toggleTarget="#toggleTest" data-toggleText="BORDER ON">BORDER OFF</div>
				</div>
				<div class="grid__item (1/5) lap-(1/3)">
					<div class="button button--text js_toggle" data-toggleClass="is_testB" data-toggleTarget="#toggleTest" data-toggleText="COLOR ON">COLOR OFF</div>
				</div>
				<div class="grid__item (1/5) lap-(1/3)">
					<div class="button button--text js_toggle" data-toggleClass="is_testA" data-toggleTarget="#toggleTest" data-toggleText="BORDER ON">BORDER OFF</div>
				</div>
				<div class="grid__item (2/5) lap-(1/1)" id="toggleTest">
					<div class="title">TEST</div>
				</div>

			</div><!-- .module--toggle -->

			<div class="module module--modal grid__item grid__item--row (1/1)">

				<div class="title">Modal</div>

				<div class="grid__item grid__item--center (1/4) tac">
					<div class="button button--text js_modalTrigger" data-modal="#modal_AB">CALL MODAL</div>
				</div>

				<div class="modal" id="modal_AB">
					<div class="modal__wrapper">

						<div class="swiper" id="swiper_AB" data-init-pagination="#pagination_swiper_AB" data-init-buttons="#control_swiper_AB" data-init-counter="#control_swiper_AB" data-loop="true" data-autoplay="true">
							<div class="swiper__wrapper">

								<div class="swiper__slide">
									<div class="slide__container">Text is here.</div>
								</div>
								<div class="swiper__slide">
									<div class="slide__container">
										<img src="./Images/dummy.jpg" class="image image--stretchWidth" />
									</div>
								</div>
								<?php
								/*
								<div class="swiper__slide">
									<?php Image::dummy(600,400, array('class' => 'image--stretchWidth')); ?>
								</div>
								*/
								?>

							</div>
						</div>

						<div id="control_swiper_AB" class="control control--swiper">

							<div class="control__button js_swiperPrev"><?php Image::svg('empty'); ?></div>
							<div class="control__counter">
								<span class="control__current">1</span>/<span class="control__total">1</span>
							</div>
							<div class="control__button js_swiperNext"><?php Image::svg('empty'); ?></div>

						</div>

						<div id="pagination_swiper_AB" class="pagination pagination--swiper"></div>

					</div>
					<div class="button modal__close js_modalClose">
						<?php Image::svg('empty'); ?>
					</div>
				</div><!-- .modal -->

			</div><!-- .module--modal -->

			<div class="module module--video grid__item grid__item--row (1/1)" id="video_container_123">

				<div class="title">Video</div>

				<div class="button button--text js_video js_videoPlay" data-toggleTarget="#video_container_123" data-videoTarget="#video_123" data-textPause="Pause" data-textStart="Play" data-textLoading="Loading&hellip;">Play Video</div>

				<div class="grid__item (1/1)">
					<video class="video" id="video_123" preload poster="./Images/dummy.jpg">
						<source class="video__source video__source--mp4" src="http://martinasperl.at/content/themes/mbi-theme/videos/martinasperl1.mp4" data-mobile-src="http://martinasperl.at/content/themes/mbi-theme/videos/martinasperl1.mp4" type="video/mp4" />
						<source class="video__source" src="http://martinasperl.at/content/themes/mbi-theme/videos/martinasperl1.webm" type="video/webm" />
						<!--<source class="video__source" src="http://martinasperl.at/content/themes/mbi-theme/videos/martinasperl1.ogv" type="video/ogg" />-->
					</video>
				</div>

			</div><!-- .module--video -->

		</div><!-- .grid -->

	</div><!-- .site -->

	<script src="./BuildJs/footer.js"></script>

</body>
</html>