<?php

// DEFINE ASSETS PATH (e.g. necessary for Image::svg(); )
define('ASSETS_PATH', dirname(__FILE__));

// START WORDPRESS
define('WP_USE_THEMES', true);
require('./WordPress/wp-blog-header.php');