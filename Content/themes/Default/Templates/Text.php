<div class="text-block">
	<?php if (get_sub_field('header') !== '') { ?>
		<h3 class="header"><?php the_sub_field('header'); ?></h3>
	<?php } ?>

	<div class="text">
		<?php the_sub_field('text'); ?>
	</div>
</div>