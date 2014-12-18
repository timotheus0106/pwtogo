<?php
/*
Plugin Name: Admin Language
Plugin URI: http://moodley.at/
Description: Sets the Wordpress Backend Language to a fixed value (default en_US)
Version: 1.0.0
Author: Thomas Allmer
Author URI: http://moodley.at/
License: GPL
Copyright: Thomas Allmer
*/

add_filter('locale', 'adminLanguage');
function adminLanguage($locale) {
	if (is_admin()) {
		return 'en_US';
	}

	return $locale;
}

?>