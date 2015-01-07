		</main>

		<!-- Footer -->
		<footer id="footer">
			<div class="content-wrapper">
				<?php $menuRenderer->render('Footer'); ?>
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
