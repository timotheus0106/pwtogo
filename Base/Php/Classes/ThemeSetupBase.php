<?php

/**
 * Class ThemeSetupBase
 *
 * Provides a ThemeSetup Base Class where the actions and filters will be registered accordingly if the setup function
 * is called.
 */
class ThemeSetupBase {

	/**
	 * @var array
	 */
	protected static $settings = array();

	/**
	 * Merges the given setting into the global settings array. Replacing values if they are found.
	 *
	 * @param  $settings
	 * @return void
	 */
	public static function setSettings($settings) {
		static::$settings = array_replace_recursive(static::$settings, $settings);
	}

	/**
	 * @return array The whole settings array
	 */
	public static function getSettings() {
		return static::$settings;
	}

	/**
	 * @param  string $key    Key of the value you want to set
	 * @param  mixed  $value  The value you want to set
	 * @return void
	 */
	public static function setSetting($key, $value) {
		static::$settings[$key] = $value;
	}

	/**
	 * @param  string $key They key of the value you want to read out
	 * @return mixed
	 */
	public static function getSetting($key) {
		return array_key_exists($key, static::$settings) ? static::$settings[$key] : false;
	}

	/**
	 * If in WordPress, goes through all as string defined actions and filters and adds them accordingly.
	 * Otherwise sets some settings only to be used within ./Assets.
	 */
	public static function setup() {

		self::setSetting('assetsPath',  dirname(dirname(dirname(__DIR__))).'/Assets');
		if (function_exists('add_action')) {

			// actions
			foreach (static::getSetting('actions') as $actionName => $functionNames) {
				foreach($functionNames as $functionName => $do) {
					if ($do === true) {
						if (is_string($functionName) && method_exists(new static(), $functionName)) {
							add_action($actionName, array(new static(), $functionName));
						}
					}
				}
			}

			// filters
			foreach (static::getSetting('filters') as $filterName => $functionNames) {
				foreach($functionNames as $functionName => $do) {
					if ($do === true) {
						$parts = explode('::', $functionName);
						$functionName = count($parts) > 1 && strlen($parts[1]) > 0 ? $parts[0] : $functionName;
						$arguments =  count($parts) > 1 && strlen($parts[1]) > 0 ? $parts[1] : 1;
						if (is_string($functionName) && method_exists(new static(), $functionName)) {
							add_filter($filterName, array(new static(), $functionName), 10, $arguments);
						}
					}
				}
			}

		}

	}

}