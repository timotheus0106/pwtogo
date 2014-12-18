		</main>

		<!-- Footer -->
		<footer id="footer">
			<div class="content-wrapper">
				<?php $menuRenderer->render('Footer'); ?>
				<div class="social">
					<h2>Follow<span class="visually-hidden"> us on:</span></h2>
					<ul id="social">
						<?php
						foreach(get_field('social_media', 'options') as $socialMedia) {
							if ($socialMedia['type'] !== 'Mail') {
								echo '<li class="' . sanitize_title($socialMedia['type']) .'"><a href="' . $socialMedia['url'] . '"><span>' . $socialMedia['type'] . '</span></a></li>';
							} else {
								echo '<li class="' . sanitize_title($socialMedia['type']) .'"><a href="mailto:' . $socialMedia['e-mail'] . '"><span>' . $socialMedia['type'] . '</span></a></li>';
							}
						}
						?>
					</ul>
				</div>
			</div>
		</footer>

	</div><!-- .site -->

	<script src="<?php echo(WP_HOME); ?>/Assets/BuildJs/footer.js"></script>

	<?php wp_footer(); ?>

	<?php if (!isset($_SERVER['CONTEXT']) || (isset($_SERVER['CONTEXT']) && $_SERVER['CONTEXT'] === 'Production')) { ?>
		<!-- Put HTML Code here that should only be rendered on the LIVE SERVER => for example the Google Analytics JavaScript Code -->
	<?php } ?>

</body>
</html>
