<?php

/**
 * Class ThemeSetup
 *
 * Provides Basic Settings and Functions for setting up the Theme.
 * You can easily set your options by using ThemeSetup::setSettings(array())
 *
 * # Setting ONLY for your Theme
 * If you need to configure actions and filters that are only usable to your current Installation/Website then
 * just use your own add_action and add_filter function. You can use ThemeSetup::getSettings() anywhere.
 *
 * # Settings you wish to later put into the Base
 * In order for you to not be depended on rapid Base changes you can extend ThemeSetup and set your settings and
 * functions there. Once it's available in Base you can just delete your code.
 * Example:
 * // extend my class with my ne Functions
 * class MyThemeSetup extends ThemeSetup {
 *   public static function myPowerSettings {
 *     echo static::getSetting('powerSettingsName');
 *     // [...]
 *   }
 * }
 *
 * MyThemeSetup.setSettings([
 *   'powerSettingName' => 'May the force be with you', // set one string option you can use everywhere
 *   filters => array(
 *     'filter_I_wanna_use' => array('myPowerSettings' => true) // define my function to be added as a filter
 *   ),
 *   actions => array(
 *     'action_I_wanna_use' => array('myPowerSettings' => true) // define my function to be added as an action
 *   )
 * ]);
 *
 * MyThemeSetup::setup();                               // use your ThemeSetup instead of the original one
 *
 */
class ThemeSetup extends ThemeSetupBase {

	/**
	 * This is the global Settings array. You can use it to story any arbitrary setting you wanna use.
	 * actions       array - ↓
	 * filters       array - holds all the filters|actions and function names in this class, just add with
	 *                       ThemeSetup::addSettings(array(
	 *                         'filters' => array(
	 *                           '<filter_I_wanna_use>' => array('<functionName>' => true)
	 *                         )
	 *                       ));
	 *                       or disable it with setting it to false.
	 *
	 * @var array
	 */
	protected static $settings = array(
		'debug' => true,
		'imageQuality' => 85,
		'assetsPath' => null,
		'dummyImages' => true,
		'randomDummyImages' => false,
		'moodleyPreTextToFileName' => 'moodley-brand-identity',
		'preTextToFileName' => '',
		'portraitImageSizes' => array(
			'(max-aspect-ratio: 5/6) AND (min-width: 361px)' => array(
				array('width' => 768),
				array('width' => 1080)
			),
			'(max-aspect-ratio: 5/6)' => array(
				array('width' => 320),
				array('width' => 640)
			),
		),
		'landscapeImageSizes' => array(
			'(min-width: 1367px)' => array(
				array('width' => 1920)
			),
			'(min-width: 1025px)' => array(
				array('width' => 1366),
				array('width' => 1920)
			),
			'(min-width: 667px)' => array(
				array('width' => 1024),
				array('width' => 1366),
				array('width' => 1920)
			),
			'(min-width: 481px)' => array(
				array('width' => 1024),
				array('width' => 1920)
			),
			'' => array(
				array('width' => 480),
				array('width' => 1024)
			)
		),
		'filters' => array(
			'body_class' => array('addSlugToBodyClass' => true),
			'flush_rewrite_rules_hard' => array('preventHtaccessWrites' => true),
			'image_resize_dimensions' => array('allowUpScalingInFrontend::6' => true),
			'intermediate_image_sizes_advanced' => array('setProperImageSizes' => true),
			'upload_dir' => array('saveToSlugFolderOnImportRemoveFilter' => true),
			'wp_generate_attachment_metadata' => array(
				'reSaveFileNameOnImport::2' => true,
				'saveCaptionIfFoundOnImport::2' => true
			),
			'wp_handle_upload_prefilter' => array(
				'addPreTextToFileNameOnImport' => true,
				'addSlugToFileNameOnImport' => true,
				'saveToSlugFolderOnImportAddFilter' => true
			)
		),
		'actions' => array(
			'init' => array(
				'beautifySearchRedirect' => true,
				'cleanFrontendHtmlHead' => true,
				'optionsSettings' => true,
				'removeComments' => true,
				'removeContentEditorForPages' => false,
				'removePosts' => false,
				'supportsMenus' => true,
				'unloadJquery' => true
			),
			'sanitize_file_name' => array('sanitizeNewFilename' => true),
			'show_admin_bar' => array('hideAdminBar' => true),
			'wp_head' => array(
				'robotNoIndexForDevelop' => true,
				'setupRequireJs' => true
			)
		)
	);

	/**
	 * Hides the Admin Bar in the Frontend
	 *
	 * @return bool
	 */
	public static function hideAdminBar() {
		return false;
	}

	/**
	 * Won't allow any .htaccess edits
	 *
	 * @return bool
	 */
	public static function preventHtaccessWrites() {
		return false;
	}

	/**
	 * We usually do not need a different medium size or a large size at all
	 *
	 * @param $sizes
	 * @return mixed
	 */
	public static function setProperImageSizes($sizes) {
		// unset($sizes['thumbnail']);
		// unset($sizes['medium']); // medium will be used within media - we set it to the same as thumbnail
		$sizes['medium']['width'] = 150;
		$sizes['medium']['height'] = 150;
		$sizes['medium']['crop'] = true;

		unset($sizes['large']);

		return $sizes;
	}

	/**
	 * Clears newly added filenames of umlaute (german special characters)
	 *
	 * @param $filename
	 * @return mixed
	 */
	public static function sanitizeNewFilename($filename) {
		return str_ireplace(array('ä', 'ü', 'ö', 'ß'), array('ae', 'ue', 'oe', 'ss'), $filename);
	}

	/**
	 * See self::addImageToSrcSet Description
	 *
	 * @param $image
	 * @return mixed
	 */
	public static function getLandscapeImageSizes($image) {
		return self::addImageToSrcSet(self::getSetting('landscapeImageSizes'), $image);
	}

	/**
	 * See self::addImageToSrcSet Description
	 *
	 * @param $image
	 * @return mixed
	 */
	public static function getPortraitImageSizes($image) {
		return self::addImageToSrcSet(self::getSetting('portraitImageSizes'), $image);
	}

	/**
	 * Returns an array with the default set images sizes filled with a variable
	 *
	 * Example:
	 *   Image::renderPicture(ThemeSetup::getLandscapeImageSizes($element['image']));
	 *
	 * Example:
	 *   Image::renderPicture(array_merge_recursive(
	 *     ThemeSetup::getLandscapeImageSizes($element['image']),
	 *     ThemeSetup::getPortraitImageSizes($element['image_portrait'])
	 *   ));
	 *
	 * @param $imageSizes
	 * @param $image
	 * @return mixed
	 */
	public static function addImageToSrcSet($imageSizes, $image) {
		foreach($imageSizes as $srcSetKey => $srcSet) {
			foreach($srcSet as $srcSetItemKey => $srcSetItem) {
				$imageSizes[$srcSetKey][$srcSetItemKey]['image'] = $image;
			}
		}
		return $imageSizes;
	}

	/**
	 * Sets the Settings for acf options, which allows you to set multiple options pages.
	 *
	 * @return void
	 */
	public static function optionsSettings() {
		if (function_exists('acf_add_options_page')) {
			acf_add_options_page(array(
				'page_title'  => 'Theme General Settings',
				'menu_title'  => 'Theme Settings',
				'menu_slug'   => 'theme-general-settings',
				'capability'  => 'edit_posts',
				'redirect'    => false
			));

			acf_add_options_sub_page(array(
				'page_title'  => 'Theme Header Settings',
				'menu_title'  => 'Header',
				'parent_slug' => 'theme-general-settings',
			));

			acf_add_options_sub_page(array(
				'page_title'  => 'Theme Footer Settings',
				'menu_title'  => 'Footer',
				'parent_slug' => 'theme-general-settings',
			));
		}
	}

	/**
	 * Adds the page slug to the css class of the body tag
	 * Example:
	 *   <body class="page page-id-4 about-us'>
	 *
	 * @param $classes
	 * @return array
	 */
	public static function addSlugToBodyClass($classes) {
		global $post;
		if (isset($post)) {
			$type = $post->post_type === 'page' ? '' : $post->post_type . '-';
			$classes[] = $type . $post->post_name;
		}
		return $classes;
	}

	/**
	 * Tries to find a caption in a filename and if found saves them in the database.
	 * A Caption is defined as surrounded by "__".
	 * Example:
	 *   _slider-klein_01__Bad_Deutsch_Altenburg__.jpg
	 *   => "Bad Deutsch Altenburg" will be saved
	 *
	 * @param $meta
	 * @param $attachmentId
	 * @return mixed
	 */
	public static function saveCaptionIfFoundOnImport($meta, $attachmentId) {
		if ($meta) {
			$path = $meta['file'];

			preg_match('/__(.*)__/', $path, $matches);
			if ($matches && strlen($matches[1]) > 0) {
				wp_update_post(array(
					'ID' => $attachmentId,
					'post_excerpt' => str_replace('_', ' ', $matches[1])
				));
			}
		}
		return $meta;
	}

	/**
	 * Extracts the fileName out of the file path and saves it to the database. Needed if the filename was changed with
	 * another filter. Just add this filter afterwards to also save the changed filename to the database.
	 *
	 * @param $meta
	 * @param $attachmentId
	 * @return mixed
	 */
	public static function reSaveFileNameOnImport($meta, $attachmentId) {
		if ($meta) {
			$path = $meta['file'];

			$start = strrpos($path, '/');
			$length = strrpos($path, '.') - $start;
			$fileName = substr($path, $start+1, $length-1);

			wp_update_post(array(
				'ID' => $attachmentId,
				'post_title' => $fileName,
				'post_name' => $fileName
			));
		}
		return $meta;
	}

	/**
	 * If a file get's uploaded on a page/post then we automatically add the slug in the front of the filename.
	 * Files starting with the exact same slug name will not get double slugs.
	 *
	 * Examples on page with slug "about-us":
	 *   slide_01.jpg => about-us_slide_01.jpg
	 *   about-us_slide_10.jpg => about-us_slide_10.jpg
	 *
	 * @param $file
	 * @return mixed
	 */
	public static function addSlugToFileNameOnImport($file) {
		$postId = isset($_REQUEST['post_id']) ? $_REQUEST['post_id'] : false;
		$fileName = $file['name'];

		// Only do this if we got the post ID otherwise we are probably in the media section
		if ($postId && is_numeric($postId)) {
			$post = get_post($postId);
			if ($post->post_name) {
				if (substr($fileName, 0, strlen($post->post_name)) !== $post->post_name) {
					$file['name'] = $post->post_name . '_' . $fileName;
				}
			}
		}
		return $file;
	}

	/**
	 * Adds a pre-text to the filename.
	 * If the user moodley uploads an image the moodley-pre-text will be added except a (c) is found.
	 *
	 * Examples with moodley-pre-text: "moodley-brand-identity" and pre-text: "power-shop":
	 *   slide_01.jpg => moodley-brand-identity_power-shop_slide_01.jpg
	 *   (c)slide_01.jpg => power-shop_slide_01.jpg
	 *
	 * @param $file
	 * @return mixed
	 */
	public static function addPreTextToFileNameOnImport($file) {
		global $user_login;

		if (static::getSetting('preTextToFileName') !== '') {
			$file['name'] = static::getSetting('preTextToFileName') . '_' . $file['name'];
		}

		if ($user_login === 'moodley' && static::getSetting('moodleyPreTextToFileName') !== '') {
			if (strpos($file['name'], '(c)') === false) {
				$file['name'] = static::getSetting('moodleyPreTextToFileName') . '_' . $file['name'];
			} else {
				$file['name'] = str_replace('(c)', '', $file['name']);
			}
		}

		return $file;
	}

	/**
	 * In Order to to edit the upload folder only when uploading we have to add and remove the filter before and
	 * after the upload.
	 *
	 * @param $file
	 * @return mixed
	 */
	public static function saveToSlugFolderOnImportAddFilter($file) {
		add_filter('upload_dir', array(new static(), 'saveToSlugFolderOnImport'));
		return $file;
	}

	/**
	 * In Order to to edit the upload folder only when uploading we have to add and remove the filter before and
	 * after the upload.
	 *
	 * @param $fileInfo
	 * @return mixed
	 */
	public static function saveToSlugFolderOnImportRemoveFilter($fileInfo) {
		remove_filter('upload_dir', array(new static(), 'saveToSlugFolderOnImport'));
		return $fileInfo;
	}

	/**
	 * If a file gets uploaded within a page it will be placed within a folder with the slug name.
	 *
	 * @param $path
	 * @return mixed
	 */
	public static function saveToSlugFolderOnImport($path) {
		$postId = isset($_REQUEST['post_id']) ? $_REQUEST['post_id'] : false;

		// Only do this if we have no error and we got the post ID otherwise we are probably in the media section
		if (!$path['error'] && $postId && is_numeric($postId)) {
			$post = get_post($postId);
			if ($post->post_name) {

				$customDir = '/' . $post->post_name;

				$path['path']    = str_replace($path['subdir'], '', $path['path']); //remove default subdir (year/month)
				$path['url']     = str_replace($path['subdir'], '', $path['url']);
				$path['subdir']  = $customDir;
				$path['path']   .= $customDir;
				$path['url']    .= $customDir;
			}
		}

		return $path;
	}

	/**
	 * If on the Development Server outputs an meta tag for robots to ignore it
	 */
	public static function robotNoIndexForDevelop() {
		if(isset($_SERVER['CONTEXT'])) {
			echo $_SERVER['CONTEXT'] === 'Development' ? '<meta name="robots" content="noindex,follow" />' : '';
		}
	}

	/**
	 * If on the Development Server outputs an meta tag for robots to ignore it
	 */
	public static function setupRequireJs() {
		echo '
			<script src="' . WP_HOME . '/Base/Js/Vendor/require.js"></script>
			<script type="text/javascript">
				require.config({
					"paths": {
						"base": "' . WP_HOME . '/Base/Js/",
						"project": "' . WP_HOME . '/Assets/Js/"
					}
				});
			</script>
		';
	}


	/**
	 * Modifies the Crop param so it allows upscaling of images in the frontend.
	 *
	 * @link http://alxmedia.se/code/2013/10/thumbnail-upscale-correct-crop-in-wordpress/
	 *
	 * @param $default
	 * @param $orig_w
	 * @param $orig_h
	 * @param $new_w
	 * @param $new_h
	 * @param $crop
	 * @return array|null
	 */
	function allowUpScalingInFrontend($default, $orig_w, $orig_h, $new_w, $new_h, $crop ) {
		if (!$crop || is_admin()) return null; // no crop or not in the Frontend - let WordPress default function handle this

		$aspect_ratio = $orig_w / $orig_h;
		$size_ratio = max($new_w / $orig_w, $new_h / $orig_h);

		$crop_w = round($new_w / $size_ratio);
		$crop_h = round($new_h / $size_ratio);

		$s_x = floor( ($orig_w - $crop_w) / 2 );
		$s_y = floor( ($orig_h - $crop_h) / 2 );

		return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
	}

	/*********************************************************************************************************************
	 * Below are the Functions to be called within Init
	 */

	/**
	 * Cleans the HTML Head by removing not mandatory tags like
	 * - <link rel='prev' title='Home' href='[...]' />
	 * - <link rel='next' title='[...]' href='[...]' />
	 * - <link rel='canonical' href='[...]' />
	 * ...
	 */
	public static function cleanFrontendHtmlHead() {
		remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
		remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
		remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
		remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
		remove_action('wp_head', 'index_rel_link'); // Index link
		remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
		remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
		remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current
		remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
		remove_action('wp_head', 'start_post_rel_link', 10, 0);
		remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
		remove_action('wp_head', 'rel_canonical');
		remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
	}

	/**
	 * Redirects search results from /?s=query to /search/query/, converts %20 to +
	 *
	 * @link http://txfx.net/wordpress-plugins/nice-search/
	 */
	public static function beautifySearchRedirect() {
		global $wp_rewrite;
		if (!isset($wp_rewrite) || !is_object($wp_rewrite) || !$wp_rewrite->using_permalinks()) {
			return;
		}
		$search_base = $wp_rewrite->search_base;
		if (is_search() && !is_admin() && strpos($_SERVER['REQUEST_URI'], "/{$search_base}/") === false) {
			wp_redirect(home_url("/{$search_base}/" . urlencode(get_query_var('s'))));
			exit();
		}
	}

	/**
	 * Prevents the loading of jquery (as it would be by default)
	 */
	public static function unloadJquery() {
		if (!is_admin() && !in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'))) {
			wp_deregister_script('jquery');
		}
	}

	/**
	 * Remove all the Comment Menu Points and the possibility to use comments
	 */
	public static function removeComments() {
		// Removes from admin menu
		function removeCommentsFromAdminMenu() {
			remove_menu_page('edit-comments.php');
		}
		add_action('admin_menu', 'removeCommentsFromAdminMenu');

		// Removes from post and pages
		function removeCommentsSupport() {
			remove_post_type_support('post', 'comments');
			remove_post_type_support('page', 'comments');
		}
		add_action('init', 'removeCommentsSupport', 100);

		// Removes from admin bar
		function removeCommentsFromAdminBar() {
			global $wp_admin_bar;
			$wp_admin_bar->remove_menu('comments');
		}
		add_action('wp_before_admin_bar_render', 'removeCommentsFromAdminBar');
	}

	/**
	 * Remove Posts from the WordPress Menu and Admin Menu
	 */
	public static function removePosts() {
		// Removes from admin menu
		function removePostsFromAdminMenu() {
			remove_menu_page('edit.php');
		}
		add_action('admin_menu', 'removePostsFromAdminMenu');

		// Removes from admin bar
		function removePostsFromAdminBar() {
			global $wp_admin_bar;
			$wp_admin_bar->remove_menu('post');
		}
		add_action('wp_before_admin_bar_render', 'removePostsFromAdminBar');
	}

	/**
	 * Removes the Content Editor for Pages
	 */
	public static function removeContentEditorForPages() {
		remove_post_type_support('page', 'editor');
	}

	/**
	 * Defines that the Theme supports Menus
	 */
	public static function supportsMenus() {
		add_theme_support('menus');
	}

}