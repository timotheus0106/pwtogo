<?php

$slides = get_sub_field('slides');

// pd($slides);

?><div class="module module--swiper grid__item (1/1)">

	<div class="title">Swiper</div>

	<div class="module__container">

		<div class="swiper" id="swiper_XY" data-init-pagination="#pagination_swiper_XY" data-init-buttons="#control_swiper_XY" data-init-counter="#control_swiper_XY" data-loop="true" data-autoplay="true">
			<div class="swiper__wrapper">

				<?php foreach ($slides as $key => $slide) { ?>
				<div class="swiper__slide">
					<?php

					Image::renderBackgroundImage(array(
						'lap-' => 			array('image' => $slide['image'], 'width' => 600, 'height' => 450),
						'portrait+' => 		array('image' => $slide['image'], 'width' => 960, 'height' => 720)
					), 'class="background background--fullscreen"');

					?>
				</div>
				<?php } ?>

			</div>
		</div>

		<div id="control_swiper_XY" class="control control--swiper">

			<div class="control__button js_swiperPrev"><?php Image::svg('empty'); ?></div>
			<div class="control__counter">
				<span class="control__current">1</span>/<span class="control__total"><?php echo count($slides); ?></span>
			</div>
			<div class="control__button js_swiperNext"><?php Image::svg('empty'); ?></div>

		</div>

		<div id="pagination_swiper_XY" class="pagination pagination--swiper"></div>

	</div>

</div><!-- .module--swiper -->