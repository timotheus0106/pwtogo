<?php

if (!isset($_SERVER['CONTEXT']) || (isset($_SERVER['CONTEXT']) && $_SERVER['CONTEXT'] === 'Production')) {

	// ==> PRODUCTION System
	define('WP_DEBUG', false);
	define('WP_LOCAL_DEV', false);

	define('WP_HOME',        'http://' . $_SERVER['SERVER_NAME']);
	define('WP_SITEURL',     'http://' . $_SERVER['SERVER_NAME'] . '/WordPress');
	define('WP_CONTENT_URL', 'http://' . $_SERVER['SERVER_NAME'] . '/Content');
	define('WP_CONTENT_DIR', $_SERVER['DOCUMENT_ROOT'] . '/Content');


} else if ($_SERVER['CONTEXT'] === 'Development') {

	/***************************************************************************************************
	 * === Development Settings ===
	 * Settings for your Development should be set via Apache Environment Variables. These
	 * Settings are available for all your projects and need to be set only ONCE.
	 *
	 * <code description="for in example in httpd.conf or settings.conf">
	 *   SetEnv DB1_HOST localhost
	 *   SetEnv DB1_USER root
	 *   SetEnv DB1_PASS
	 *   SetEnv DB1_PORT 3306
	 *   SetEnv CONTEXT Development
	 * </code>
	 *
	 * === Foldername ===
	 * Your Foldername should be the Domainname with an uppercase letter at the beginning and
	 * after every every ".". In General it's wise to refrain from using www in your url (it makes
	 * it just longer). Anyway it must not be contained in the Foldername.
	 *
	 * <example>
	 *                      [URL] => [Foldername]
	 *      http://www.moodley.at => MoodleyAt
	 *      http://sub.domain.com => SubDomainCom
	 *   http://anotherdomain.org => AnotherdomainOrg
	 * </example>
	 *
	 * === Database Name ===
	 * Settings for you DB1_NAME should be different for every Installation. You can either set
	 * it via vhosts (see below) or if it's undefined it will try using the lowercase foldername as
	 * the db name.
	 *
	 * <example>
	 *       [Foldername] => [Database Name]
	 *          MoodleyAt => moodleyat
	 *       SubDomainCom => subdomaincom
	 *   AnotherdomainOrg => anotherdomainorg
	 * </example>
	 *
	 * === Database Name via vHost ===
	 * If you are using vHost you can set your DB1_NAME there
	 *
	 * <code description="for in example in httpd.conf or vHosts.conf">
	 *   <VirtualHost *:80>
	 *     DocumentRoot "/home/action/workspace/www/MydomainCom"
	 *     ServerName mydomaincom.dev.moodley.at
	 *     SetEnv DB1_NAME mydomaincom
	 *   </VirtualHost>
	 * </code>
	 **************************************************************************************************/


	$root = dirname(dirname(__DIR__));

	define('WP_DEBUG', true);
	define('WP_LOCAL_DEV', true);
	define('FS_METHOD', 'direct'); //local updates

	$port = isset($_SERVER['SERVER_FIXED_PORT']) ? $_SERVER['SERVER_FIXED_PORT'] : false;
	$serverName = $port ? $_SERVER['SERVER_NAME'] . ':' . $port : $_SERVER['SERVER_NAME'];
	$serverUrl = 'http://' . $serverName . '/' . basename($root);
	define('WP_HOME',        $serverUrl);
	define('WP_SITEURL',     $serverUrl . '/WordPress');
	define('WP_CONTENT_URL', $serverUrl . '/Content');
	define('WP_CONTENT_DIR', $root .  '/Content');

	if ( isset($_SERVER['DB1_NAME'])) {
		if (!defined('DB_NAME')) {
			define('DB_NAME', $_SERVER['DB1_NAME']);
		}
	} else {
		// set as lower case folder name
		if (!defined('DB_NAME')) {
			define('DB_NAME', strtolower(basename($root)));
		}
	}
	if (!defined('DB_USER')) {
		define('DB_USER', $_SERVER['DB1_USER']);
	}
	if (!defined('DB_PASSWORD')) {
		define('DB_PASSWORD', $_SERVER['DB1_PASS']);
	}
	if (!defined('DB_HOST')) {
		$host = isset($_SERVER['DB1_PORT']) ? $_SERVER['DB1_HOST'] . ':' . $_SERVER['DB1_PORT'] : $_SERVER['DB1_HOST'];
		define('DB_HOST', $host);
	}

}

/** database table prefix **/
if(!isset($table_prefix)) {
	$table_prefix  = 'mbi_';
}

/** set default theme **/
if (!defined('WP_DEFAULT_THEME')) {
	define('WP_DEFAULT_THEME', 'Default');
}

/** Database Charset to use in creating database tables. */
if (!defined('DB_CHARSET')) {
	define('DB_CHARSET', 'utf8');
}

/** The Database Collate type. Don't change this if in doubt. */
if (!defined('DB_COLLATE')) {
	define('DB_COLLATE', '');
}

/** WordPress language **/
if (!defined('WPLANG')) {
	define('WPLANG', 'de_DE');
}

/** increase memory limit **/
if (!defined('WP_MEMORY_LIMIT')) {
	define('WP_MEMORY_LIMIT', '128M');
}

/** only use 1 post revisions **/
if (!defined('WP_POST_REVISIONS')) {
	define('WP_POST_REVISIONS', 1);
}

/** do not create br tags within the contact 7 form */
if (!defined('WPCF7_AUTOP')) {
	define('WPCF7_AUTOP', false);
}



/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH'))
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
