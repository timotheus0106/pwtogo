<!DOCTYPE html>
<!--[if lt IE 9]><html class="no-js ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 9]><html class="no-js ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 10]><html class="no-js ie10" <?php language_attributes(); ?>><![endif]-->
<!--[if !IE]> --><html class="no-js" <?php language_attributes(); ?>><!-- <![endif]-->
<head>

	<!--
	/**
	 * This website was carefully designed and built by
	 *
	 * Moodley Brand Identity
	 * http://www.moodley.at/
	 *
	 */
	-->

	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />

	<title>
		<?php global $page, $paged;
		wp_title( '|', true, 'right' );
		bloginfo( 'name' );
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ){
			echo " | $site_description";
		}
		if ( $paged >= 2 || $page >= 2 ){
			echo ' | ' . sprintf( __( 'Page %s', 'moodley' ), max( $paged, $page ) );
		} ?>
	</title>

	<link rel="stylesheet" href="<?php echo(WP_HOME); ?>/Assets/Css/Style.css" />

	<?php
	// ----------------------------------------------------------------
	// FAVICON
	//
	// use http://realfavicongenerator.net/ and be happy
	//
	// don't forget to alter msapplication-TileColor
	// ----------------------------------------------------------------
	?>
	<link rel="shortcut icon" href="<?php echo(WP_HOME); ?>/Assets/FavIcons/favicon.ico" />
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo(WP_HOME); ?>/Assets/FavIcons/apple-touch-icon-57x57.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo(WP_HOME); ?>/Assets/FavIcons/apple-touch-icon-114x114.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo(WP_HOME); ?>/Assets/FavIcons/apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo(WP_HOME); ?>/Assets/FavIcons/apple-touch-icon-144x144.png" />
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo(WP_HOME); ?>/Assets/FavIcons/apple-touch-icon-60x60.png" />
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo(WP_HOME); ?>/Assets/FavIcons/apple-touch-icon-120x120.png" />
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo(WP_HOME); ?>/Assets/FavIcons/apple-touch-icon-76x76.png" />
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo(WP_HOME); ?>/Assets/FavIcons/apple-touch-icon-152x152.png" />
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo(WP_HOME); ?>/Assets/FavIcons/apple-touch-icon-180x180.png" />
	<link rel="icon" type="image/png" href="<?php echo(WP_HOME); ?>/Assets/FavIcons/favicon-192x192.png" sizes="192x192" />
	<link rel="icon" type="image/png" href="<?php echo(WP_HOME); ?>/Assets/FavIcons/favicon-160x160.png" sizes="160x160" />
	<link rel="icon" type="image/png" href="<?php echo(WP_HOME); ?>/Assets/FavIcons/favicon-96x96.png" sizes="96x96" />
	<link rel="icon" type="image/png" href="<?php echo(WP_HOME); ?>/Assets/FavIcons/favicon-16x16.png" sizes="16x16" />
	<link rel="icon" type="image/png" href="<?php echo(WP_HOME); ?>/Assets/FavIcons/favicon-32x32.png" sizes="32x32" />
	<meta name="msapplication-TileColor" content="#1a171b">
	<meta name="msapplication-TileImage" content="<?php echo(WP_HOME); ?>/Assets/FavIcons/mstile-144x144.png" />
	<meta name="msapplication-square70x70logo" content="<?php echo(WP_HOME); ?>/Assets/FavIcons/mstile-70x70.png" />
	<meta name="msapplication-square150x150logo" content="<?php echo(WP_HOME); ?>/Assets/FavIcons/mstile-150x150.png" />
	<meta name="msapplication-square310x310logo" content="<?php echo(WP_HOME); ?>/Assets/FavIcons/mstile-310x310.png" />
	<meta name="msapplication-wide310x150logo" content="<?php echo(WP_HOME); ?>/Assets/FavIcons/mstile-310x150.png" />
	<meta name="application-name" content="<?php echo bloginfo('name'); ?>" />
	<?php
	// ----------------------------------------------------------------
	?>

	<?php wp_head(); ?>

	<script src="<?php echo(WP_HOME); ?>/Assets/BuildJs/header.js"></script>

</head>
<body <?php body_class('no-js'); ?>>

	<script>
		document.body.className = document.body.className.replace('no-js','');
	</script>

	<div class="site">

		<header>

			<!-- SkipLinks -->
			<div id="skip-links">
				<p><a href="#main-menu">Zur Navigation</a></p>
				<p><a href="#content">Zum Inhalt</a></p>
			</div>

			<!-- Header -->
			<div id="header" role="banner">
				<div class="logo-wrapper">
					<a href="<?php echo(WP_HOME); ?>">
						<img src="<?php echo(WP_HOME); ?>/Assets/Images/logo.png" alt="Client Logo" class="logo" />
					</a>
				</div>
			</div>

			<!-- TopNav -->
			<div id="top-nav">

				<!-- MainMenu -->
				<nav class="menu" id="main-menu" role="navigation">
					<div class="menu__content">
						<?php $menuRenderer->render('Header'); ?>
					</div>
				</nav>

			</div>

		</header>

		<!-- Content -->
		<main id="content" role="main">