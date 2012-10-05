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
define('DB_NAME', 'web146-qpre');

/** MySQL database username */
define('DB_USER', 'web146-qpre');

/** MySQL database password */
define('DB_PASSWORD', '2q4fTwyj/');

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
define('AUTH_KEY',        'WTr||k[q?^8v:n$FNI,BL):-$4r2/&z0-b/F(I!>`(,daX+1=}4FdKtd@NhwY~Aa');
define('SECURE_AUTH_KEY', 'qZ8Zd!2;-X2U.b7hR#IB`#l(- L[HJ;zSDu^-H=F{16I}+<[GmZ[ ^gi+~N9LwhG');
define('LOGGED_IN_KEY',   'p=t]su|S%f/pf[A9Zo+t> b)UBHp`$tpjXq|%J9%u=~C||llJusFVPJ+YuMzvu S');
define('NONCE_KEY',       ' z4-/6o(7-FhTv*k|@4QYX>=^sND[+iYx<k-HU=$=TT~)=D%:<fcNa!P=cza,v(J');
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
//define('WP_DEBUG', true);

?>
