<?php

/**
 * Image
 *
 **/
Class Image {

	/**
	 * Renders a responsive Image and makes sure all used images available in their sizes.
	 * Outputs a Picture Tag - Should be used with
	 *
	 * @link: http://scottjehl.github.io/picturefill/
	 *
	 * Example:
	 *   Image::renderPicture(array(
	 *     '(min-width: 1000px)' => array(
	 *       array('image' => get_field('image_big'), 'width' => 800, 'dummy-height' => 400)
	 *     ),
	 *     '(min-width: 800px)' => array(
	 *       array('image' => get_field('image'), 'width' => 600)
	 *     ),
	 *     '' => array(
	 *       array('image' => get_field('image'), 'width' => 300),
	 *     )
	 *   ));
	 *
	 *   <picture>
	 *     <!--array(if IE 9)><video style="display: none;"><!array(endif)-->
	 *     <source srcset="image_big-800x000.jpg 800w" media="(min-width: 1000px)" />
	 *     <source srcset="image-600x000.jpg 600w" media="(min-width: 800px)" />
	 *     <!--array(if IE 9)></video><!array(endif)-->
	 *     <img srcset="image-300x000.jpg 300w" alt="" />
	 *   </picture>
	 *
	 * Example:
	 *   Image::renderPicture(array(
	 *     '(min-width: 800px)' => array(
	 *       array('image' => get_field('image'), 'width' => 500),
	 *       array('image' => get_field('image'), 'width' => 1000),
	 *       'tagAttributes' => 'class="my-source"'
	 *     ),
	 *     '' => array(
	 *       array('image' => get_field('image'), 'width' => 300),
	 *       array('image' => get_field('image'), 'width' => 600),
	 *       'tagAttributes' => 'class="my-image"',
	 *       'quality' => 60
	 *     )
	 *   ), 'class="my-picture"');
	 *
	 *   <picture class="my-picture">
	 *     <!--[if IE 9]><video style="display: none;"><![endif]-->
	 *     <source srcset="image-500x000.jpg 500w, image-1000x000.jpg 1000w" lass="my-source" media="(min-width: 800px)" />
	 *     <!--[if IE 9]></video><![endif]-->
	 *     <img srcset="image-300x000.jpg 300w, image-600x000.jpg 600w" class="my-image" alt="" />
	 *   </picture>
	 *
	 * FEATURE Fallback
	 *   If no Image is provided a dummy Image from an external service will be used. You can provide a specific height
	 *   for these images with array('image' => get_field('image'), 'width' => 500, 'dummy-height' => 300). This is a
	 *   separate parameter so it won't interfere with later used real images. If a fixed 'height' => 100 is set this will
	 *   be used for real and dummy images. (eg it has a higher priority then dummy-height)
	 *
	 * @param array  $options breakpoints with images
	 * @param string $tagAttributes add attributes to the picture tag if needed
	 * @param bool   $echo    defaults to true - echo the tag directly
	 * @return string
	 */
	public static function renderPicture($options = array(), $tagAttributes = '', $echo = true) {
		if (!array_key_exists('', $options)) {
			return 'You have to provide a default image';
		}

		$tagAttributes = $tagAttributes !== '' ? ' ' . $tagAttributes : '';
		$output = PHP_EOL . '<picture' . $tagAttributes . '>' . PHP_EOL .  "\t" . '<!--[if IE 9]><video style="display: none;"><![endif]-->' . PHP_EOL;
		$output .= isset($_GET['regenerateImages']) && $_GET['regenerateImages'] ? '<!-- Images are forcefully regenerated -->' . PHP_EOL : '';
		foreach($options as $media => $imageSet) {
			if ($media !== '') {
				$options[$media]['tagAttributes'] = array_key_exists('tagAttributes', $options[$media]) ? $options[$media]['tagAttributes'] : '';
				$output .= "\t" . '<source srcset="' . static::renderSrcSet($imageSet) . '" ' . $options[$media]['tagAttributes'] . '  media="' . $media . '" />' . PHP_EOL;
			}
		}
		$output .= "\t" . '<!--[if IE 9]></video><![endif]-->' . PHP_EOL;

		$options['']['tagAttributes'] = array_key_exists('tagAttributes', $options['']) ? $options['']['tagAttributes'] : '';
		$output .= "\t" . '<img srcset="' . static::renderSrcSet($options['']) . '" ' . $options['']['tagAttributes'] . ' alt="" />' . PHP_EOL;

		$output .= '</picture>';

		if ($echo === true) {
			echo $output;
		}
		return $output;
	}

	/**
	 * Renders an actual image tag and makes sure that the image is available in the defined size.
	 *
	 * Examples:
	 *   Image::render(get_field('image'), array('width' => 200, 'height' => 100, 'tagAttributes' => 'class="special-image"'));
	 *   Image::render('path/within/content/file.jpg', array('width' => 200));
	 *   Image::render(get_field('image'), array('width' => 200, 'dummy-height' => 400));
	 *
	 * FEATURE Fallback
	 *   If no Image is provided a dummy Image from an external service will be used. You can provide a specific height
	 *   for these images with array('image' => get_field('image'), 'width' => 500, 'dummy-height' => 300). This is a
	 *   separate parameter so it won't interfere with later used real images. If a fixed 'height' => 100 is set this will
	 *   be used for real and dummy images. (eg it has a higher priority then dummy-height)
	 *
	 * @param bool|object|string $imageParam path to File or WordPress Image Object
	 * @param array              $options    width|height|tagAttributes|quality
	 * @param bool               $echo       defaults to true - echo the tag directly
	 * @return mixed
	 */
	public static function render($imageParam = false, $options = array(), $echo = true) {
		if (is_string($imageParam) || $imageParam === NULL || $imageParam === false) {
			$image = array(
				'path' => $imageParam,
				'url' => static::contentPathToUrl($imageParam)
			);
		} else {
			$image = $imageParam;
			$image['path'] = get_attached_file($image['id']);
		}
		if (file_exists($image['path'])) {
			$size = getimagesize($image['path']);

			if (isset($imageArray['width']) && $imageArray['width'] != $size[0] || isset($imageArray['height']) && $imageArray['height'] != $size[1]) {
				$image = static::resize($image['path'], $options);
			}
		} else {
			if (!class_exists('ThemeSetup') || ThemeSetup::getSetting('dummyImages') === true) {
				$image['url'] = self::dummyUrl($options);
			} else {
				$image['url'] = 'Image at "' . $image['path'] . '" does not exists.';
			}
		}

		$options['tagAttributes'] = array_key_exists('tagAttributes', $options) ? $options['tagAttributes'] : '';
		$image['title'] = array_key_exists('title', $image) ? $image['title'] : '';

		$output = '';
		$output .= isset($_GET['regenerateImages']) && $_GET['regenerateImages'] ? PHP_EOL . '<!-- Images are forcefully regenerated -->' . PHP_EOL : '';
		$output .= '<img src="' . $image['url'] . '" alt="' . $image['title'] . '" ' . $options['tagAttributes'] . ' />';
		if ($echo === true) {
			echo $output;
		}
		return $output;
	}

	/**
	 * Takes the Path to an Image and generates the Url for the Frontend.
	 *
	 * @param $path
	 * @return mixed
	 */
	public static function contentPathToUrl($path) {
		return defined('WP_CONTENT_DIR') ? str_replace(WP_CONTENT_DIR, WP_CONTENT_URL, $path) : '';
	}


	/**
	 * Make sure all given Images are available in the needed sizes and returns a string that can be used
	 * in a srcset. Each Image will have its path and width returned.
	 *
	 * Currently a defined width is required for each image.
	 *
	 * Example:
	 *   static::renderSrcSet(array(
	 *     array('image' => get_field('image'), 'width' => 900)
	 *   ));
	 *   => http://[...]image-900x600.jpg 900w
	 *
	 *   static::renderSrcSet(array(
	 *     array('image' => get_field('image'), 'width' => 900)
	 *     array('image' => get_field('image'), 'width' => 450)
	 *   ));
	 *   => http://[...]image-900x600.jpg 900w http://[...]image-450x300.jpg 450w
	 *
	 * @param array $images
	 * @return string
	 */
	public static function renderSrcSet($images = array()) {
		$srcSet = '';

		foreach($images as $imageArray) {
			if (!is_array($imageArray)) {
				continue;
			}
			if (!array_key_exists('width', $imageArray)) {
				return 'Image has to have a defined width';
			}
			if (is_string($imageArray['image']) || $imageArray['image'] === NULL || $imageArray['image'] === false) {
				$image = array(
					'path' => $imageArray['image'],
					'url' => static::contentPathToUrl($imageArray['image'])
				);
			} else {
				$image = $imageArray['image'];
				$image['path'] = get_attached_file($image['id']);
			}

			$srcSet = $srcSet !== '' ? $srcSet . ', ' : '';
			if (file_exists($image['path'])) {
				$size = getimagesize($image['path']);

				if (isset($imageArray['width']) && $imageArray['width'] != $size[0] || isset($imageArray['height']) && $imageArray['height'] != $size[1]) {
					$image = static::resize($image['path'], $imageArray);
				}

				$srcSet .= $image['url'] . ' ' . $imageArray['width'] . 'w';
			} else {
				if (!class_exists('ThemeSetup') || ThemeSetup::getSetting('dummyImages') === true) {
					$dummyImage = self::dummyImage($imageArray);
					$srcSet .= $dummyImage['url'] . ' ' . $dummyImage['width'] . 'w';
				} else {
					$srcSet .= 'Image at "' . $image['path'] . '" does not exists.';
				}

			}
		}

		return $srcSet;
	}

	/**
	 * Uses the WordPress Image Editor to actually resize an Image and return it.
	 *
	 * If width AND height are provided the image will be exactly cropped to this size.
	 * If width OR height are provided it will be relatively downscaled (no upscale)
	 *
	 * @param string $path
	 * @param array $options
	 * @return array|bool|WP_Error
	 */
	public static function resize($path, $options = array()) {
		if(class_exists('ThemeSetup')) {

			$crop = array_key_exists('width', $options) && array_key_exists('height', $options);
			$size = getimagesize($path);
			$ratio = $size[0] / $size[1];

			if (!array_key_exists('width', $options)) {
				$options['width'] = intval($options['height'] / $ratio);
			}
			if (!array_key_exists('height', $options)) {
				$options['height'] =  intval($options['width'] / $ratio);
			}

			if (!(isset($_GET['regenerateImages']) && $_GET['regenerateImages'])) { // force regenerating

				$pathInfo = pathinfo($path);
				$imageSizeName = $pathInfo['filename'] . '-' . $options['width'] . 'x' . $options['height'] . '.' . $pathInfo['extension'];
				$checkPath = $pathInfo['dirname'] . '/' . $imageSizeName;
				if (file_exists($checkPath)) {
					$foundImage = array(
						'path' => $checkPath,
						'file' => $imageSizeName,
						'width' => $options['width'],
						'height' => $options['height'],
						'mime-type' => 'image/jpeg',
						'url' => static::contentPathToUrl($checkPath)
					);
					return $foundImage;
				}

			}

			$imageEditor = wp_get_image_editor($path);
			if (!is_wp_error($imageEditor)) {
				$quality = array_key_exists('quality', $options) ? $options['quality'] : ThemeSetup::getSetting('imageQuality');
				$imageEditor->set_quality($quality);
				$imageEditor->resize($options['width'], $options['height'], $crop);
				$image = $imageEditor->save();
				$image['url'] = static::contentPathToUrl($image['path']);
				return $image;
			}
			return false;

		}
		return false;
	}

	/**
	 * Renders a responsive Image as CSS Background Image and makes sure all used images available in their sizes.
	 * Outputs a Div Tag with attributes - Only works with
	 *
	 * USAGE:
	 * 	Image::renderBackgroundImage(array(
	 *		'lap-' => 			array('image' => $imageArray, 'width' => 600, 'height' => 450),
	 *		'portrait+' => 		array('image' => $imageArray, 'width' => 960, 'height' => 720)
	 *	), 'class="background background--fullscreen"');
	 *
	 * @link ./Base/Js/MbiBackgroundImage.js
	 *
	 * @param array  	$images 			images
	 * @param string 	$tagAttributes 		add attributes to the picture tag if needed
	 * @param bool   	$echo    			defaults to true - echo the tag directly
	 * @return string
	 */
	public static function renderBackgroundImage($images = array(), $tagAttributes = '', $echo = true) {

		$tagAttributes = $tagAttributes !== '' ? $tagAttributes . ' ' : '';
		$output = '<div id="background_'.uniqid().'" ' . $tagAttributes . 'data-srcset="';
		$values = array();

		foreach($images as $mediaQuery => $imageArray) {

			if (!is_array($imageArray)) {
				continue;
			}
			if (!array_key_exists('width', $imageArray)) {
				return 'Image has to have a defined width';
			}
			if (is_string($imageArray['image'])) {
				$image = array(
					'path' => $imageArray['image'],
					'url' => static::contentPathToUrl($imageArray['image'])
				);
			} else {
				$image = $imageArray['image'];
				$image['path'] = get_attached_file($image['id']);
			}
			if (!file_exists($image['path'])) {
				return 'Image at "' . $image['path'] . '" does not exists.';
			}
			$size = getimagesize($image['path']);

			if (isset($imageArray['width']) && $imageArray['width'] != $size[0] || isset($imageArray['height']) && $imageArray['height'] != $size[1]) {
				$image = static::resize($image['path'], $imageArray);
			}

			$values[] = $image['url'] . ' ' . $mediaQuery;

		}

		$output .= implode(',', $values);
		$output .= '"></div>';

		$output = trim($output);

		if ($echo === true) {
			echo $output;
		}

		return $output;

	}

	/**
	 * Inline a SVG file into HTML.
	 *
	 * Example:
	 * 		Helper::svg('test', array('class' => 'someClass'));
	 *  	=> <svg class="svg svg--test someClass" … </svg>
	 *
	 * @param  string  	$iconName 	filename within ./Assets/Svg/ without extension
	 * @param  array   	$options  	use options
	 * @param  boolean 	$echo     	defaults to true - echo the tag directly
	 * @return string
	 */
	public static function svg($iconName, $options = array(), $echo = true) {

		$file = ThemeSetup::getSetting('assetsPath').'/Svg/'.$iconName.'.svg';
		$class = 'svg svg--'.$iconName;
		if(isset($options['class']) && !empty($options['class'])) {
			$class .= ' '.$options['class'];
		}

		if(file_exists($file)) {

			$return = file_get_contents($file);
			$return = str_replace('<svg', '<svg class="'.$class.'"', $return);

		} else {

			$return = '<svg class="'.$class.'" x="0" y="0" width="32" height="32" viewBox="0 0 32 32">';
			$return .= '<g style="fill: none; stroke: silver; stroke-width: 1px; vector-effect: non-scaling-stroke;">';
			$return .= '<line x1="0" y1="0" x2="32" y2="32" />';
			$return .= '<line x1="32" y1="0" x2="0" y2="32" />';
			$return .= '<rect x="0" y="0" width="32" height="32" />';
			$return .= '</g>';
			$return .= '</svg>';

		}

		if ($echo === true) {
			echo $return;
		}
		return $return;

	}

	/**
	 * Outputs a placeholder Image from one of the defined services.
	 *
	 * Example:
	 * Image::dummyImage(array('width' => 1920, 'dummy-height' => 700));
	 *
	 * Return:
	 *   array(
	 *     'url' => 'http://placehold.it/1920x700'
	 *     'width' => 1920,
	 *     'height' => 700,
	 *     'dummy-height' => 700
	 *   )
	 *
	 * @param array $options
	 * @return array
	 */
	public static function dummyImage($options = array('width' => 100, 'height' => 100)) {
		if (isset($options['dummy-height']) && !isset($options['height'])) {
			$options['height'] = $options['dummy-height'];
		}
		if (isset($options['width']) && !isset($options['height'])) {
			$options['height'] = floor($options['width'] * 0.5625);
		}
		$options['width'] = isset($options['width']) ? $options['width'] : 100;
		$options['height'] = isset($options['height']) ? $options['height'] : 100;

		$services = array(
			'placehold.it' => 'http://placehold.it/' . $options['width'] . 'x' . $options['height'], // fastest
			'placeimg.com' => 'https://placeimg.com/' . $options['width'] . '/' . $options['height'] . '/arch/grayscale', // nicest
			'placekitten.com' => 'http://placekitten.com/g/' . $options['width'] . '/' . $options['height'] . '/' // cutest
		);
		$random = (!class_exists('ThemeSetup') || ThemeSetup::getSetting('randomDummyImages') === false) ? false : true;
		$options['url'] = $random ? $services[array_rand($services)] : $services['placehold.it'];
		return $options;
	}

	/**
	 * Outputs a placeholder Image Url from one of the defined services.
	 *
	 * Example:
	 * Image::dummyUrl(array('width' => 1920, 'dummy-height' => 700));
	 *
	 * Return:
	 * http://placehold.it/1920x700
	 *
	 * @param array $options
	 * @return string
	 */
	public static function dummyUrl($options = array('width' => 100, 'height' => 100)) {
		return self::dummyImage($options)['url'];
	}

}