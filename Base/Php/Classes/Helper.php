<?php

/**
 * Helper
 *
 **/
Class Helper {

	/**
	 * Formatted and styled print_r output, if ThemeSetup::getSetting('debug') is true
	 *
	 * @param  mixed  	$var   	variable to print_r
	 * @param  string  	$title 	defaults to '$' - display a title on top of debugged value
	 * @param  boolean 	$echo  	defaults to true - echo the tag directly
	 * @return string
	 */
	public static function debug($var, $title = '$', $echo = true) {
		if (!class_exists('ThemeSetup') || ThemeSetup::getSetting('debug') === true) {

			if(empty($var)) {
				$parse = '<span style="color: #666;">false/null/empty</span>';
			} else {
				$parse = print_r($var, true);
			}

			$parse = str_replace('Array', '<span style="color: #4692b9;">Array</span>', $parse);
			$parse = str_replace('Object', '<span style="color: #4692b9;">Object</span>', $parse);

			$parse = str_replace('[]', '<span style="color: #666;">empty Array</span>', $parse);
			$parse = str_replace('[', '<span style="color: #fd523f;">', $parse);
			$parse = str_replace(']', '</span>', $parse);
			$parse = str_replace('(', '<span style="color: #444;">(</span>', $parse);
			$parse = str_replace(')', '<span style="color: #444;">)</span>', $parse);
			$parse = str_replace(" => \n", ' => <span style="color: #666;">false/null/empty</span>'."\n", $parse);
			$parse = str_replace(' => ', ' <span style="color: #666;">:</span> ', $parse);

			$title = '<span style="color: #d6ea31;">'.$title.'</span> <span style="color: #666;">:</span> ';

			$return = '<pre style="font-family: Source Code Pro, Consolas, Courier New, monospace; font-size: 12px; background: #333; color: #eee; border-bottom: 1px dashed #666; padding: 24px;">'.$title;
			$return .= $parse;
			$return .= '</pre>';

			if ($echo === true) {
				echo $return;
			}
			return $return;

		}
		return '';
	}

	/**
	 * Debugs to Browser JavaScript Console
	 *
	 * @param        $data
	 * @param string $title
	 */
	public static function console($data, $title = '$') {
		if (!class_exists('ThemeSetup') || ThemeSetup::getSetting('debug') === true) {
			if (is_array($data) || is_object($data)) {
				echo('<script type="text/javascript">if (console && console.log) { console.log("' . $title . '", ' . json_encode($data) . '); }</script>');
			} else {
				echo('<script type="text/javascript">if (console && console.log) { console.log("' . $title . '", \'' . str_replace("'", "\\'", $data) . '\'); }</script>');
			}
		}
	}

	/**
	 * Converting given phone number into linkable number string.
	 *
	 * Example:
	 *   Helper::phoneToAnchor('+43 123 / 456789');
	 *   => <a href="tel:0043123456789">+43 123 / 456789</a>
	 *
	 *   Helper::phoneToAnchor('+43 123 / 456789', '', true);
	 *   => 0043123456789
	 *
	 *   Helper::phoneToAnchor('123 / 456789', '001', true);
	 *   => 001123456789
	 *
	 * @param string $number           human-readable phone number
	 * @param string $defaultCountry   if no country code is provided in the number us this country code
	 * @param bool   $returnNumberOnly return "clean" number only
	 * @param bool   $echo             directly output via echo
	 * @return string                  full href or "clean" number as string
	 */
	public static function phoneToAnchor($number, $defaultCountry = '0043', $returnNumberOnly = false, $echo = true) {
		$newNumber = $number;
		$newNumber = substr($newNumber, 0, 2) === '00' || $newNumber[0] === '+' ? $newNumber : $defaultCountry . $newNumber;
		$newNumber = str_replace('+', '00', $newNumber);
		$newNumber = str_replace(array('(', ')', ' ', '-', '/', '.'), '', $newNumber);

		$output = $returnNumberOnly === true ? $newNumber : '<a class="tel" href="tel:' . $newNumber . '">' . $number . '</a>';
		if ($echo) {
			echo $output;
		}
		return $output;
	}

	/**
	 * @return string current post name slug
	 **/
	public static function getTheSlug() {
		global $post;
		return $post->post_name;
	}

	/**
	 * split string at <!--more-->
	 * @param	string	$text	full body text
	 * @return	string	parts divided by <!--more-->
	 **/
	public function splitByMore($text) {
		$parts = explode('<!--more-->', $text);
		return $parts;
	}

	/**
	 * add <!--more--> tag after number of character
	 *
	 * @param  string $text  full body text
	 * @param  int    $limit characters after <!--more--> should be added
	 * @return string parts divided at <!--more-->
	 */
	public function splitByLimit($text, $limit = 256) {
		$more = wordwrap($text, $limit, '<!--more-->');
		return static::splitByMore($more);
	}

	/**
	 * cut off text after number of words
	 *
	 * @param	string	$str	string that should be limited
	 * @param	int	$limit	 number of words until break
	 * @param	string	$end_char	limitter (default = ellipse)
	 * @return	string	cutted string including end char
	 **/
	public function wordLimiter($str, $limit = 16, $end_char = '&#8230;') {
		if (trim($str) !== '') {
			preg_match('/^\s*+(?:\S++\s*+){1,'.(int)$limit.'}/', $str, $matches);

			if (strlen($str) == strlen($matches[0])){
				$end_char = '';
			}
			return rtrim($matches[0]).$end_char;
		}
		return $str;
	}

	/**
	 * Cuts off text after number of characters
	 * preserve whole words
	 *
	 * @param  string $str      string that should be limited
	 * @param int     $n        number of characters until break
	 * @param  string $end_char limitter (default = ellipse)
	 * @return  string  cutted string including end char
	 */
	public function characterLimiter($str, $n = 128, $end_char = '&#8230;') {
		if (strlen($str) > $n) {
			$str = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $str));
			if (strlen($str) <= $n) {
				return $str;
			}
			$out = '';
			foreach (explode(' ', trim($str)) as $val) {
				$out .= $val.' ';
				if (strlen($out) >= $n) {
					$out = trim($out);
					return (strlen($out) == strlen($str)) ? $out : $out.$end_char;
				}
			}
		}
		return $str;
	}

	/**
	 * Checks if the given key is the last key in an array.
	 *
	 * <code name="example">
	 *   <?php foreach($entries as $key => $entry) { ?>
	 *     <li <?php echo isLastKey($entries, $key) ? 'class="last"' : ''; ?>>
	 *       <?php echo $entry['name']; ?>
	 *     </li>
	 *   <?php } ?>
	 * </code>
	 *
	 * <code name="result">
	 *   // array has 2 elements and Name2 is the last one
	 *   <li>Name1</li>
	 *   <li class="last">Name2</li>
	 * </code>
	 *
	 * @param $array
	 * @param $key
	 * @return bool
	 */
	public static function isLastKey(&$array, $key) {
		end($array);
		return $key === key($array);
	}

	/**
	 * Convert stdClass Objects to Multidimensional Arrays
	 * Example:
	 *   $object = new stdClass();
	 *   $object->a = 'test me'
	 *   $array = Helper::arrayToObject($object);
	 *   echo $array['a']; //test me
	 *
	 * @link http://www.if-not-true-then-false.com/2009/php-tip-convert-stdclass-object-to-multidimensional-array-and-convert-multidimensional-array-to-stdclass-object/
	 * @param $object
	 * @return array
	 */
	public static function objectToArray($object) {
		if (is_object($object)) {
			// Gets the properties of the given object with get_object_vars function
			$object = get_object_vars($object);
		}

		if (is_array($object)) {
			return array_map(array(new static(), __FUNCTION__), $object);
		} else {
			return $object;
		}
	}

	/**
	 * Convert Multidimensional Arrays to stdClass Objects
	 * Example:
	 *   $object = Helper::arrayToObject(array('a' => 'test me'));
	 *   echo $object->a; //test me
	 *
	 * @link http://www.if-not-true-then-false.com/2009/php-tip-convert-stdclass-object-to-multidimensional-array-and-convert-multidimensional-array-to-stdclass-object/
	 * @param $array
	 * @return object
	 */
	public static function arrayToObject($array) {
		if (is_array($array)) {
			return (object) array_map(array(new static(), __FUNCTION__), $array);
		} else {
			return $array;
		}
	}

	/**
	 * Returns a flat array from WordPress just filled with meta data
	 *
	 * @param string $menuName
	 * @param array  $menuOptions
	 * @return array
	 */
	public static function getFlatMenuItems($menuName = 'Header', $menuOptions = array()) {
		$rawMenuItems = wp_get_nav_menu_items($menuName, $menuOptions);
		if (!$rawMenuItems || count($rawMenuItems) == 0) {
			echo 'The Menu "' . $menuName . '" returned no Elements with the following Options:';
			self::debug($menuOptions);
			return array();
		}
		$arrayMenuItems = static::objectToArray($rawMenuItems);
		$arrayMenuItems = static::fillMenuWithMetaData($arrayMenuItems, $menuOptions);
		return $arrayMenuItems;
	}

	/**
	 * Returns an array with a hierarchy for all the pages of the menu
	 *
	 * Example:
	 *   $menu = Helper::getMenuItems('Footer');
	 *   array(
	 *     10 => array('title' => 'Home'),
	 *     17 => array('title' => 'About Us', active => true 'children' => array(
	 *       8 => array('title' => 'Team', active => true, current => true),
	 *       37 => array('title' => 'Contact')
	 *     )
	 *   )
	 *
	 * @param string $menuName
	 * @param array  $menuOptions
	 * @return array
	 */
	public static function getMenuItems($menuName = 'Header', $menuOptions = array()) {
		$arrayMenuItems = static::getFlatMenuItems($menuName, $menuOptions);
		return static::flatArrayToMultilevelArray($arrayMenuItems);
	}

	/**
	 * Fills a menu array with certain meta data like active or current
	 *
	 * @param       $menuArray
	 * @param array $options
	 * @return mixed
	 */
	public static function fillMenuWithMetaData($menuArray, $options = array()) {
		$activeId = false;
		$newArray = array();

		$options['currentId'] = isset($options['currentId']) ? $options['currentId'] : get_the_ID();

		foreach($menuArray as $menuItem) {
			$menuItem['active'] = $menuItem['current'] = $menuItem['first'] = $menuItem['last'] = false;
			if ($menuItem['object_id'] == $options['currentId']) {
				$menuItem['active'] = $menuItem['current'] = true;
				$activeId = $menuItem['ID'];
			}
			$newArray[$menuItem['ID']] = $menuItem;
		}

		/* set active to all the parents of the current page if a page is found */
		while ($activeId && $activeId > 0) {
			$newArray[$activeId]['active'] = true;
			$activeId = $newArray[$activeId]['menu_item_parent'];
		}

		/* set first and last per level */
		$doItems = $newArray;
		$levelId = 0;
		do {
			$levelItems = $restItems = array();
			foreach ($doItems as $key => $levelItem) {
				if ($levelItem['menu_item_parent'] == $levelId) {
					$levelItems[] = $levelItem;
				} else {
					$restItems[] = $levelItem;
				}
			}

			reset($levelItems);
			$current = current($levelItems);
			$newArray[$current['ID']]['first'] = true;
			end($levelItems);
			$current = current($levelItems);
			$newArray[$current['ID']]['last'] = true;

			$doItems = $restItems;
			reset($doItems);
			$do = current($doItems);
			$levelId = $do['menu_item_parent'];
		} while (count($doItems) > 0);

		return $newArray;
	}

	/**
	 * Convenient function to convert WordPress returns to multilevel Array
	 *
	 * @param array $flat
	 * @param string $type
	 * @return array
	 */
	public static function flatToMultilevelArray($flat, $type = 'pages') {
		$flatArray = static::objectToArray($flat);
		return static::flatArrayToMultilevelArray($flatArray, $type);
	}

	/**
	 * Recursive Function to stitch together a one dimensional array to an array with children
	 *
	 * @param array      $rawItems
	 * @param string     $type
	 * @param array|bool $parent
	 * @return array
	 */
	public static function flatArrayToMultilevelArray($rawItems, $type = 'pages', $parent = false) {
		// default is for page
		$parentKey = 'menu_item_parent';
		$idKey = 'ID';
		if ($type === 'categories') {
			$parentKey = 'parent';
			$idKey = 'term_id';
		}
		$parent = $parent ? $parent : array($idKey => 0);

		$itemsForLevel = array();
		$leftItems = array();
		foreach($rawItems as $item) {
			if ($item[$parentKey] == $parent[$idKey]) {
				$itemsForLevel[$item[$idKey]] = $item;
			} else {
				$leftItems[] = $item;
			}
		}

		$parent['children'] = $itemsForLevel;
		foreach($parent['children'] as &$subItem) {
			$subItem['children'] = self::flatArrayToMultilevelArray($leftItems, $type, $subItem);
		}

		return $parent['children'];
	}

	/**
	 * Returns the permalink respecting the current language if wpml is loaded. If no post is found it will link back
	 * to the homepage.
	 *
	 * @param $postId
	 * @return string
	 */
	public static function getPermalink($postId) {
		if (defined('ICL_LANGUAGE_CODE')) {
			$postIdInLanguage = icl_object_id($postId , 'page', true, ICL_LANGUAGE_CODE);
			return ($postIdInLanguage != 0) ? get_permalink($postIdInLanguage) : icl_get_home_url();
		}
		return get_permalink($postId);
	}

} // end Helper

// ----------------------------------------------------------------
// SETUP DEBUG SHORTHANDS
// ----------------------------------------------------------------

function pd($var, $title = '$', $echo = true) {
	Helper::debug($var, $title, $echo);
}

function pc($var, $title = '$') {
	Helper::console($var, $title);
}
