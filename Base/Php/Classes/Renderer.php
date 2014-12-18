<?php

/**
 * Class Renderer
 */
Class Renderer {

	public $dirs = array();

	public $flexibleContent = array();

	public $renderingFlexibleContentArray = false;

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
			$this->dirs[] = WP_CONTENT_DIR . '/themes/Default/Templates';
			$this->dirs[] = dirname(dirname(__DIR__)) . '/Templates';
		}
	}

	/**
	 * Renders the Content of a WordPress Page within the Content.php Template
	 */
	public function renderContent() {
		global $post;
		$field = 'content';

		if (have_posts()) {
			while (have_posts()) {
				the_post();
			}
			$content = get_the_content();
			$title = get_the_title();
			if ($title || $content) {
				$paths = array();
				foreach($this->dirs as $dir) {
					if (isset($post)) {
						$paths[] = $dir . '/' .  $this->slugToUpperCamelCase($post->post_name) . '-' . $this->fieldNameToUpperCamelCase($field) . '.php';
					}
					$paths[] = $dir . '/' . $this->fieldNameToUpperCamelCase($field) . '.php';
				}
				$this->renderPaths($paths);
			}
		}
	}

	/**
	 * Renders Posts of a WordPress Page within the Posts.php Template
	 *
	 * @param array $options
	 */
	public function renderPosts($options = array('post_type' => 'post')) {
		global $post; //current page
		$page = $post;

		// your are on a valid page
		if (have_posts()) {
			while (have_posts()) {
				the_post();
				$posts = get_posts($options);
				if ($posts) {
					$paths = array();
					foreach($this->dirs as $dir) {
						if (isset($page)) {
							$paths[] = $dir . '/' .  $this->slugToUpperCamelCase($page->post_name) . '-' . $this->fieldNameToUpperCamelCase($options['post_type']) . '.php';
						}
						$paths[] = $dir . '/' . $this->fieldNameToUpperCamelCase($options['post_type']) . '.php';
					}
					foreach ($posts as $post) {
						setup_postdata($post);
						$this->renderPaths($paths);
						wp_reset_postdata();
					}
				}
			}

		}
	}

	/**
	 * Renders all Sub
	 *
	 * @param string $field
	 * @param null   $options
	 */
	public function renderFlexibleContentFields($field = 'content', $options = NULL) {
		global $post;

		if (have_rows($field, $options)) {
			while (have_rows($field, $options)) {
				the_row();

				$paths = array();
				foreach($this->dirs as $dir) {
					if (isset($post)) {
						$type = $post->post_type === 'page' ? '' : $post->post_type . '-';
						$postName = function_exists('icl_object_id') ? get_post(icl_object_id($post->ID, 'page', true, icl_get_default_language()))->post_name : $post->post_name;
						$specificLayout = $type . $this->slugToUpperCamelCase($postName);
						$paths[] = $dir . '/' .  $specificLayout . '-' . $this->fieldNameToUpperCamelCase(get_row_layout()) . '.php';
					}
					$paths[] = $dir . '/' . $this->fieldNameToUpperCamelCase(get_row_layout()) . '.php';
				}
				$this->renderPaths($paths);
			} //while content
		}
	}

	/**
	 * Render a Field
	 *
	 * @param      $field
	 * @param null $options
	 */
	public function renderField($field, $options = NULL) {
		global $post;

		if (have_rows($field, $options)) {
			$paths = array();
			foreach($this->dirs as $dir) {
				if (isset($post)) {
					$type = $post->post_type === 'page' ? '' : $post->post_type . '-';
					$postName = function_exists('icl_object_id') ? get_post(icl_object_id($post->ID, 'page', true, icl_get_default_language()))->post_name : $post->post_name;
					$specificLayout = $type . $this->slugToUpperCamelCase($postName);
					$paths[] = $dir . '/' .  $specificLayout . '-' . $this->fieldNameToUpperCamelCase($field) . '.php';
				}
				$paths[] = $dir . '/' . $this->fieldNameToUpperCamelCase($field) . '.php';
			}
			$this->renderPaths($paths);
		} else {
			Helper::debug('We did not found a Field with the name "' . $field . '".');
		}
	}

	/**
	 * Renders a Flexible Content SubField by not pulling the data from the database but from the array
	 *
	 * Example:
	 *  $this->renderFlexibleContentArray($element['content']);
	 *
	 * @param $flexibleContentArray
	 */
	public function renderFlexibleContentArray($flexibleContentArray) {
		$this->renderingFlexibleContentArray = true;
		foreach($flexibleContentArray as $flexibleContent) {
			$this->flexibleContent = $flexibleContent;

			$paths = array();
			foreach($this->dirs as $dir) {
				if (isset($post)) {
					$type = $post->post_type === 'page' ? '' : $post->post_type . '-';
					$postName = function_exists('icl_object_id') ? get_post(icl_object_id($post->ID, 'page', true, icl_get_default_language()))->post_name : $post->post_name;
					$specificLayout = $type . $this->slugToUpperCamelCase($postName);
					$paths[] = $dir . '/' .  $specificLayout . '-' . $this->fieldNameToUpperCamelCase($this->flexibleContent['acf_fc_layout']) . '.php';
				}
				$paths[] = $dir . '/' . $this->fieldNameToUpperCamelCase($this->flexibleContent['acf_fc_layout']) . '.php';
			}
			$this->renderPaths($paths);

		}
		$this->renderingFlexibleContentArray = false;
	}

	/**
	 * Allows to get the Field data no matter if it's from an array or from the database
	 *
	 * Example:
	 *   if ($this->get('header')) {
	 *      // [...]
	 *   }
	 *
	 * @param        $field
	 * @return bool|mixed|void
	 */
	public function get($field) {
		return !$this->renderingFlexibleContentArray ? get_sub_field($field) : $this->flexibleContent[$field];
	}

	/**
	 * Outputs the data of a Field no matter if it's from an array or from the database
	 *
	 * Example:
	 *   <h2><?php $this->out('header'); ?></h2>
	 *
	 * @param        $field
	 * @return void
	 */
	public function out($field) {
		echo $this->get($field);
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
		Helper::debug('We did not find a Templates at the following locations:');
		Helper::debug($paths);
	}

	/**
	 * Converts acf field names to UpperCamelCase Filenames
	 *   text_image => TextImage
	 *
	 * @param $fieldName
	 * @return string
	 */
	public function fieldNameToUpperCamelCase($fieldName) {
		if(strlen($fieldName)>0) {
			$fieldName[0] = strtoupper($fieldName[0]);
			return preg_replace_callback('/_([a-zA-Z0-9])/', create_function('$c', 'return strtoupper($c[1]);'), $fieldName);
		} else {
			return '';
		}
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

