<?php

/*
Plugin Name: MBI Maintenance Mode
Plugin URI: http://moodley.at/
Description: Hide Frontend
Version: 1.0.0
Author: Marcel Seelig, Stefan Wenger
Author URI: http://moodley.at/
License: –
Copyright: –
*/

$die = false;

// if NOT LOGGED IN && FRONTEND
if(!is_user_logged_in() && !is_admin()) {
    $die = true;
}

// IF LOGIN WINDOW
if($_SERVER['SCRIPT_NAME'] == '/wp/wp-login.php'){
    $die = false;
}

if($die) {
    die();
}