<?php

/**
 * Class Menu Renderer
 */
Class MenuRenderer {

	public $menuName;

	public $menuNameWithLanguage;

	public $menuArray;

	public $menuArrayFlat;

	public $element;

	public $language;

	public $level = 0;

	public $dirs = array();

	/**
	 * Set some Directories to choose the Templates from
	 *
	 * @param mixed $dirs array => set dirs to this array
	 *                    string => add this path to the dirs
	 *                    true => use Templates dirs from Default Theme and Base
	 *                    false => do not set any dirs
	 */
	public function __construct($dirs = TRUE) {
		if (is_array($dirs)) {
			$this->dirs = $dirs;
		} else if (is_string($dirs)) {
			$this->dirs[] = $dirs;
		}

		// hardcoded default values
		if (count($this->dirs) === 0 && $dirs !== FALSE) {
			$this->dirs[] = WP_CONTENT_DIR . '/themes/Default/Templates/Menu';
			$this->dirs[] = dirname(dirname(__DIR__)) . '/Templates/Menu';
		}
	}

	/**
	 * Renders a menu based on Menu Templates. It allows to define different Templates for each Level. If no Templates
	 * is found it will try to get the next best Version going up the Levels. It will select depending on the following
	 * priorities.
	 *
	 * If WPML for Multi Language is used it will automatically look for the $name . '-' . $language. For Example if
	 * English is the current language and you want to render "Header" it will look for a "Header-en" Menu.
	 *
	 * Example:
	 *   $menuRenderer->render('Header'); //on Page about-us
	 *   1) Page (AboutUs-Header-1.php > Header-1.php; AboutUs-Level-1.php > Header-1.php)
	 *   2) Name (Header-0.php > Level-1.php)
	 *   3) Level appropriate (on level 2 Level-2.php > Level-1.php)
	 *   4) Directory - Theme Menus have priority over Base Menus
	 *
	 * Example:
	 *   Level-0.php
	 *   Level-2.php
	 *   // so level 0 and 1 will use the Level-0.php, level 2 and up will use Level-2.php
	 *
	 * Each Level consists of two Template files Level-0.php to Init this level and Level-0-Item.php for each item in
	 * it's level.
	 *
	 * Example:
	 *   Level-0.php with <?php $this->renderElements(); ?>
	 *   Level-0-Items.php with <?php echo "- " . $this->getElement()['title']; ?>
	 * Result:
	 *   - Home
	 *   - About
	 *   - continuing with every page and subpage
	 *
	 * Example:
	 *   Level-0.php with <?php $this->renderElements(); ?>
	 *   Level-0-Items.php with <?php echo "- " . $this->getElement()['title']; ?>
	 *   Level-1-Items.php with <?php echo "\t- " . $this->getElement()['title']; ?>
	 * Result:
	 *   - Home
	 *     - About
	 *   - continuing with every page in level 0
	 *     - every page in level 1 will be indented
	 *
	 * If you wish to only display up to a certain Level you can provide an empty Level-x.php so it will stop there.
	 *
	 * @param string $menuName Name of the Menu to Render
	 * @param array  $options  Options for native wp function wp_get_nav_menu_items
	 */
	public function render($menuName, $options = array()) {
		$this->menuNameWithLanguage = $menuName;
		if (defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE !== icl_get_default_language()) {
			$this->menuNameWithLanguage .= '-' . ICL_LANGUAGE_CODE;
		}

		$this->menuName = $menuName;
		$this->menuArrayFlat = Helper::getFlatMenuItems($this->menuNameWithLanguage, $options);
		$this->menuArray = Helper::flatArrayToMultilevelArray($this->menuArrayFlat);

		global $post;

		$paths = array();
		foreach($this->dirs as $dir) {
			if (isset($post)) {
				$type = $post->post_type === 'page' ? '' : $post->post_type . '-';
				$postName = function_exists('icl_object_id') ? get_post(icl_object_id($post->ID, 'page', true, icl_get_default_language()))->post_name : $post->post_name;
				$specificLayout = $type . $this->slugToUpperCamelCase($postName);
				for ($i = $this->getLevel(); $i >= 0; $i--) {
					$paths[] = $dir . '/' . $specificLayout . '-' . $this->menuName . '-' . $i . '.php';
				}
				for ($i = $this->getLevel(); $i >= 0; $i--) {
					$paths[] = $dir . '/' . $specificLayout . '-Level-' . $i . '.php';
				}
			}
			for ($i = $this->getLevel(); $i >= 0; $i--) {
				$paths[] = $dir . '/' . $this->menuName . '-' . $i . '.php';
			}
			for ($i = $this->getLevel(); $i >= 0; $i--) {
				$paths[] = $dir . '/Level-' . $i . '.php';
			}
		}
		$this->renderPaths($paths);
	}

	/**
	 * Renders all the child menu items of a page
	 */
	public function renderElements() {
		global $post;

		$elements = $this->hasChildren()  ? $this->element['children'] : $this->menuArray;

		foreach($elements as $element) {
			$this->element = $element;

			$paths = array();
			foreach($this->dirs as $dir) {
				if (isset($post)) {
					$type = $post->post_type === 'page' ? '' : $post->post_type . '-';
					$postName = function_exists('icl_object_id') ? get_post(icl_object_id($post->ID, 'page', true, icl_get_default_language()))->post_name : $post->post_name;
					$specificLayout = $type . $this->slugToUpperCamelCase($postName);
					for ($i = $this->getLevel(); $i >= 0; $i--) {
						$paths[] = $dir . '/' . $specificLayout . '-' . $this->menuName . '-' . $i . '-Item.php';
					}
					for ($i = $this->getLevel(); $i >= 0; $i--) {
						$paths[] = $dir . '/' . $specificLayout . '-Level-' . $i . '-Item.php';
					}
				}
				for ($i = $this->getLevel(); $i >= 0; $i--) {
					$paths[] = $dir . '/' . $this->menuName . '-' . $i . '-Item.php';
				}
				for ($i = $this->getLevel(); $i >= 0; $i--) {
					$paths[] = $dir . '/Level-' . $i . '-Item.php';
				}
			}
			$this->renderPaths($paths);
		}
	}

	/**
	 * Renders all the child menus of a certain page
	 */
	public function renderSubElements() {
		if ($this->hasChildren()) {
			global $post;

			$tempLevel = $this->getLevel();
			$this->level = $this->getLevel() + 1;

			$paths = array();
			foreach($this->dirs as $dir) {
				if (isset($post)) {
					$type = $post->post_type === 'page' ? '' : $post->post_type . '-';
					$postName = function_exists('icl_object_id') ? get_post(icl_object_id($post->ID, 'page', true, icl_get_default_language()))->post_name : $post->post_name;
					$specificLayout = $type . $this->slugToUpperCamelCase($postName);
					for ($i = $this->getLevel(); $i >= 0; $i--) {
						$paths[] = $dir . '/' . $specificLayout . '-' . $this->menuName . '-' . $i . '.php';
					}
					for ($i = $this->getLevel(); $i >= 0; $i--) {
						$paths[] = $dir . '/' . $specificLayout . '-Level-' . $i . '.php';
					}
				}
				for ($i = $this->getLevel(); $i >= 0; $i--) {
					$paths[] = $dir . '/' . $this->menuName . '-' . $i . '.php';
				}
				for ($i = $this->getLevel(); $i >= 0; $i--) {
					$paths[] = $dir . '/Level-' . $i . '.php';
				}
			}
			$this->renderPaths($paths);

			$this->level = $tempLevel;
		}
	}

	/**
	 * Renders a Language Menu by checking for Menu/LanguageItem.php
	 *
	 * Example:
	 *   $menuRenderer->renderLanguageSelector();
	 *
	 * Result (depending on LanguageItem.php):
	 *   <li class="langnav__item langnav__item--active">
	 *     <span class="langnav__entry langnav__entry--active">de</span>
	 *   </li>
	 *   <li class="langnav__item">
	 *     <a class="langnav__entry" href="http://[...]/en/[...]/">en</a>
	 *   </li>
	 *
	 * @param string $params
	 */
	public function renderLanguageSelector($params = 'skip_missing=0&orderby=custom') {
		global $post;
		$languages = icl_get_languages($params);
		foreach($languages as $language) {
			$this->language = $language;

			$paths = array();
			foreach($this->dirs as $dir) {
				if (isset($post)) {
					$type = $post->post_type === 'page' ? '' : $post->post_type . '-';
					$postName = function_exists('icl_object_id') ? get_post(icl_object_id($post->ID, 'page', true, icl_get_default_language()))->post_name : $post->post_name;
					$specificLayout = $type . $this->slugToUpperCamelCase($postName);
					$paths[] = $dir . '/' .  $specificLayout . '-' . 'LanguageItem.php';
				}
				$paths[] = $dir . '/LanguageItem.php';
			}
			$this->renderPaths($paths);
		}
	}

	/**
	 * Checks if a the current element has a menu item parent matching search id or search title
	 *
	 * @param $search
	 * @return bool
	 */
	public function hasParent($search) {
		$parent = $this->getElement();
		$found = false;
		while ($parent['menu_item_parent']) {
			$parent = $this->menuArrayFlat[$parent['menu_item_parent']];
			if ($parent['ID'] === $search || $parent['title'] === $search) {
				$found = true;
				break;
			}
		}
		return $found;
	}

	/**
	 * Checks if the current elements has a matching search id or search title or any of its parents
	 *
	 * @param $search
	 * @return bool
	 */
	public function hasParentOrIsElement($search) {
		$element = $this->getElement();
		return $element['ID'] === $search || $element['title'] === $search || $this->hasParent($search);
	}

	/**
	 * Does the Current Element has Children?
	 *
	 * @return bool
	 */
	public function hasChildren() {
		$element = $this->getElement();
		return count($element['children']) > 0;
	}

	/**
	 * @return boolean
	 */
	public function isActive() {
		$element = $this->getElement();
		return $element['active'];
	}

	/**
 * @return boolean
 */
	public function isCurrent() {
		$element = $this->getElement();
		return $element['current'];
	}

	/**
	 * @return boolean
	 */
	public function isFirst() {
		$element = $this->getElement();
		return $element['first'];
	}

	/**
	 * @return boolean
	 */
	public function isLast() {
		$element = $this->getElement();
		return $element['last'];
	}

	/**
	 * @return mixed
	 */
	public function getElement() {
		return $this->element;
	}

	/**
	 * @return int
	 */
	public function getLevel() {
		return $this->level;
	}

	/**
	 * Goes through an array of paths and checks if an file exists there. Only the first found will be included.
	 * So only those with the highest priority will be "rendered".
	 *
	 * @param $paths
	 */
	public function renderPaths($paths) {
		foreach($paths as $path) {
			if (is_file($path)) {
				include($path);
				// found a template do not search for a less specific one
				return;
			}
		}
		echo 'We did not find a Templates at the following locations:';
		Helper::debug($paths);
	}

	/**
	 * Converts slug to UpperCamelCase Filenames
	 *   haus-und-garten => HausUndGarten
	 *
	 * @param $slug
	 * @return string
	 */
	public function slugToUpperCamelCase($slug) {
		if(strlen($slug)>0) {
			$slug[0] = strtoupper($slug[0]);
			return preg_replace_callback('/-([a-zA-Z0-9])/', create_function('$c', 'return strtoupper($c[1]);'), $slug);
		} else {
			return '';
		}
	}

}

