<?php

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '');
define('SECURE_AUTH_KEY',  '');
define('LOGGED_IN_KEY',    '');
define('NONCE_KEY',        '');
define('AUTH_SALT',        '');
define('SECURE_AUTH_SALT', '');
define('LOGGED_IN_SALT',   '');
define('NONCE_SALT',       '');

/**#@-*/

if (!isset($_SERVER['CONTEXT']) || (isset($_SERVER['CONTEXT']) && $_SERVER['CONTEXT'] === 'Production')) {

	define('DB_NAME', 'pwtogo'); // Production
	define('DB_USER', 'root'); // Production
	define('DB_PASSWORD', ''); // Production
	define('DB_HOST', 'localhost'); // Production

} else if (isset($_SERVER['DB_DEFAULT']) && $_SERVER['DB_DEFAULT'] === 'Global') {

	define('DB_NAME', 'pwtogo'); // Global Db
	define('DB_USER', 'root'); // Global Db
	define('DB_PASSWORD', ''); // Global Db
	//$host = isset($_SERVER['DB_DEFAULT_PORT']) ? $_SERVER['DB_DEFAULT_HOST'] . ':' . $_SERVER['DB_DEFAULT_PORT'] : $_SERVER['DB_DEFAULT_HOST'];
	define('DB_HOST', 'localhost'); // Global Db

}

/**
 * Load Default WordPress Configuration from Base
 */
require_once('Base/Php/Configuration.php');