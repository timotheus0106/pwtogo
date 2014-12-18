<?php

// ------------------------------------------------------------------------
// THEME SETUP
// ------------------------------------------------------------------------

require_once(dirname(WP_CONTENT_DIR) . '/Base/Php/Init.php');

// You can use all settings from /Base/Php/Classes/ThemeSetup.php
ThemeSetup::setSettings(array(
	'preTextToFileName' => 'wptemplate', // do change this to match the project/customer name
	'filters' => array(
		'wp_handle_upload_prefilter' => array(
			'addSlugToFileNameOnImport' => false
		)
	),
	'actions' => array(
		'init' => array(
			'removePosts' => false,
			'removeContentEditorForPages' => false
		)
	)
));
ThemeSetup::setup();

if (!is_admin()) {
	// only if in the FRONTEND
	$renderer = new Renderer();
	$menuRenderer = new MenuRenderer();

} else {
	// only for the BACKEND

}

// ------------------------------------------------------------------------
// PROJECT FUNCTIONS
// ------------------------------------------------------------------------

