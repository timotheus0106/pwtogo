<?php

	require_once('Classes/ThemeSetupBase.php');
	require_once('Classes/ThemeSetup.php');

	if (!is_admin()) {
		// only if in the FRONTEND
		require_once('Classes/Renderer.php');
		require_once('Classes/MenuRenderer.php');
		require_once('Classes/WalkerUlRecursive.php');
		require_once('Classes/Helper.php');
		require_once('Classes/Image.php');

	} else {
		// only for the BACKEND

	}