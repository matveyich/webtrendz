<?php
/** 
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information by
 * visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'web40-a-wordp-24');

/** MySQL database username */
define('DB_USER', 'web40-a-wordp-24');

/** MySQL database password */
define('DB_PASSWORD', 'bV3!FsWWC');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys.
 *
 * Generated using the {@link http://api.wordpress.org/secret-key/1.1/ WordPress.org secret-key service}
 *
 * @since 2.6.0
 */
define('AUTH_KEY',        'p/HEm@e#]Mj>)Q?OFgS7<mNY)t7CAdDfe%6.ynd5Z|]9]*cWKTNJInU>1:M-PMe7');
define('SECURE_AUTH_KEY', '3TEUu>0ILH<*U8ZMNprDb4D?Q>BZ;++9C|$+cn%<YaBm`/^j%@3&l}VP$]xce8FJ');
define('LOGGED_IN_KEY',   'XCg(L$jU?2pEi&<K{Z.;7_ t#;o[?dT9q$Y8htl63B=|ot5&9o4[y`9|`Q:AP 3-');
define('NONCE_KEY',       'PMd+l?e{nH}] %d~T%MS3=G.|{-JL2-$Bc<9^{1nl0|b~0AmNl.imv8wbHD9HD;X');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', '');

/* That's all, stop editing! Happy blogging. */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
define('WP_DEBUG', true);
?>
