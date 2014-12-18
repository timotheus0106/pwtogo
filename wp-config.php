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
define('AUTH_KEY',         '?+iSY.>_XV[ i-X:|YOORg+|G6U>v!|DjI)R7DS/mGjA/a$9}SG}s30koE NB0@K');
define('SECURE_AUTH_KEY',  ']S~F0Eu)]OoZM=1w+VW8yx}={SQLTN,Qq`rMCT%DH-YV)f.BUpB4QY)[*9!qz>X&');
define('LOGGED_IN_KEY',    'k@.(sUj++Zld1lI8CUp|-$bPo1 h!PoFsI4!n-K%|bWuPn`PIV<cN9Um2La|6g?Y');
define('NONCE_KEY',        'Z]9=vRF95YLpMv3UNz<~:>T!1}P>[}[5C[Ol}.|yxkMP[.6RDE{!}vv_gA3*et0f');
define('AUTH_SALT',        'fl<3AtrS/P/[]p0+i><W{gdn?KLQ-+bu/jV0nO+7w#b%j}B`K]:e0ZM:tb9|=V%x');
define('SECURE_AUTH_SALT', '4m-Sp@-6KHma_fC799;:)vAB/cjqRPQIV%]gV[y(zHAo-j#MDG~hX/QZ!>g,+pcr');
define('LOGGED_IN_SALT',   'h/b@I& +bgX&nsL&OQc77vCh#alz&&7Z=XD6Q+>Jkko#F|[cmz@r|yy<tLO;r-?|');
define('NONCE_SALT',       'NA56|g`Ba>A&~*N@a=LQ]QV. +i)r/-5_ Mv*vj>B.2~AT@;*M@f,S|LZrqO+jKn');

/**#@-*/

if (!isset($_SERVER['CONTEXT']) || (isset($_SERVER['CONTEXT']) && $_SERVER['CONTEXT'] === 'Production')) {

	define('DB_NAME', 'pwtogo'); // Production
	define('DB_USER', 'root'); // Production
	define('DB_PASSWORD', ''); // Production
	define('DB_HOST', 'localhost'); // Production

} else if (isset($_SERVER['DB_DEFAULT']) && $_SERVER['DB_DEFAULT'] === 'Global') {

	define('DB_NAME', 'u51336db1'); // Global Db
	define('DB_USER', 'u51336db1'); // Global Db
	define('DB_PASSWORD', 'ALEZ+(tG4!up'); // Global Db
	$host = isset($_SERVER['DB_DEFAULT_PORT']) ? $_SERVER['DB_DEFAULT_HOST'] . ':' . $_SERVER['DB_DEFAULT_PORT'] : $_SERVER['DB_DEFAULT_HOST'];
	define('DB_HOST', $host); // Global Db

}

/**
 * Load Default WordPress Configuration from Base
 */
require_once('Base/Php/Configuration.php');