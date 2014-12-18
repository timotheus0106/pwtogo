<div class="news-entry" id="post<?php the_ID(); ?>">
	<h2>
		<small class="date"><?php echo date_i18n('d. F Y', strtotime(get_the_date('m/d/Y'))); ?></small>
		<span><?php the_title(); ?></span>
	</h2>
	<?php the_content(); ?>
</div>