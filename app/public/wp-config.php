<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );


define( 'WP_MEMORY_LIMIT', '128M' );
/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '5mlGj3r0225tKo8Wv1D3YN02LJbDIP6aCpyiqSUWuNSATf1mVeT1NX0tP4zRCLsY4ci9sAi5EvMSxCAhhT1j6Q==');
define('SECURE_AUTH_KEY',  'Y15NkxBvz7aQE41qjpcncD7jTB/NTBCczzn2peVvZGrPJTW2MD3DERa7u776JXZP/jyOuoqu7DCsP21lK2yswg==');
define('LOGGED_IN_KEY',    'enHjfL4pYSNkVIXcSWuHAXI/HceD8Bg9h6T+cYo7dX1hQG3w1+HNONGzuV1JQ8pnDMHSoP9dvX9xXgL9wN/NCQ==');
define('NONCE_KEY',        '47Lhy7YzBIB/rcs7RpNOH4jpuIHKv7aBvq/3pg6j06m/deqgpTRnJIftHbac6Dy8i3brxPzAU0bMgIjo1qcrZg==');
define('AUTH_SALT',        'YMN9ACFSNZ1+5XdLHYm4Vb9Pjfo/K+OzqKrG0z/AO000DDkxw/2P5M0A+DS1KBGFlUJMLzfFarkFtViS3BPzMA==');
define('SECURE_AUTH_SALT', 'p0B/orwAKfyRlXmyAlR9ObEtLR/NRURSXsZ5RULHAPSOfH6ChDE3pSFVLYWzhG+BDPbl5+YxD1bY/2fS9tkBSw==');
define('LOGGED_IN_SALT',   'w6Wg8zrmjyW3959214UHcDUz20XoIZZTe8b5Z4UxqognAGB0nPbl/Ts83aRMnhmUxgdaZmxIT7uhHfc+tODeBA==');
define('NONCE_SALT',       'hRCarvJaOVWoGwTZb7q6nGgVQg55P3/J/4K/91gvno2BLVlOtSy+9Si6MscuUdz0ivsb0hU90irX6GgtBmGR4w==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';





/* Inserted by Local by Flywheel. See: http://codex.wordpress.org/Administration_Over_SSL#Using_a_Reverse_Proxy */
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
	$_SERVER['HTTPS'] = 'on';
}

/* Inserted by Local by Flywheel. Fixes $is_nginx global for rewrites. */
if (strpos($_SERVER['SERVER_SOFTWARE'], 'Flywheel/') !== false) {
	$_SERVER['SERVER_SOFTWARE'] = 'nginx/1.10.1';
}
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

