<?php
define('WP_HOME','https://bernstein-dev.mgh.harvard.edu');
define('WP_SITEURL','https://bernstein-dev.mgh.harvard.edu');
define('WP_AUTO_UPDATE_CORE', false);// This setting is required to make sure that WordPress updates can be properly managed in WordPress Toolkit. Remove this line if this WordPress instance is not managed by WordPress Toolkit anymore.
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
define( 'DB_NAME', 'bb37_wp_fl1pl' );

/** MySQL database username */
define( 'DB_USER', 'bb37_wp_0wsk3' );

/** MySQL database password */
define( 'DB_PASSWORD', 'a8f9IQ!x5T' );

/** MySQL hostname */
define( 'DB_HOST', 'erisweb-mysql.partners.org:3306' );

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'C%i9[9O52-*PjPV&8R_6(_B4dX44pZ&@%+YK)]D0l-kSuS40V]6u|]LZnaE]1L@q');
define('SECURE_AUTH_KEY', 'Z7MTsfFw:W/6_9#2107#__L*kkHZ~HQ!HNDytx:8X/0AT3K*S90JX8#!8Q[NXn7b');
define('LOGGED_IN_KEY', '78[JyWab8h11o0S8[)4[62D|H%lcuMk7o1X6&q#v7!E0D|0)v1(_83:3YapvTv@M');
define('NONCE_KEY', '0%+KrbK:1~|*8*Y2l(|tOqN4S54x[*x[@W17IXG1;!m*5yt11MGH919oYXya0JcM');
define('AUTH_SALT', '%#qJJnK6o2_Ta&_R2Fahe#aP&hY@cD|WJ&]*Q2dBXX%7fD!37Gq+:T#c~29OsWKG');
define('SECURE_AUTH_SALT', 'RImP@bcjK+W72:N_pnGNP~2453xhsbn0xppPB(@eL53/5_V;E-]8/p&%xR!BqL27');
define('LOGGED_IN_SALT', '~3+0[/%4Q|[65d0eo9qf]XvDM085#Q~4#5]()n9~QCAI[|+dt2rA37/8ZR*LBIX&');
define('NONCE_SALT', '9wgr07i74a-s55Bh#8gu/3s/YK@bQ9%5b#;;#@0;W7*Avy~fq2[qYjY617;k![8j');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = '0FS60yxr8_';

define('WP_ALLOW_MULTISITE', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

define('CONCATENATE_SCRIPTS', false);

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
