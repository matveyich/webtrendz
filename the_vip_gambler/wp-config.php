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
define('DB_NAME', 'web130-thvpgmblr');

/** MySQL database username */
define('DB_USER', 'web130-thvpgmblr');

/** MySQL database password */
define('DB_PASSWORD', 'r$j5#j4H3j*hYb#7g');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
#define('WP_DEBUG', true);

/**#@+
 * Authentication Unique Keys.
 *
 * Generated using the {@link http://api.wordpress.org/secret-key/1.1/ WordPress.org secret-key service}
 *
 * @since 2.6.0
 */
define('AUTH_KEY',        '6Z.NR+b<y[]{+qY*E,IkxCTF+TYbZAnb_8d5*6Ii5$C8c(.z|a!;RJ,iJix$2~+*');
define('SECURE_AUTH_KEY', '&?834AY_I*#c/wohSc.~G2]xPD=kco-)CLX}N=HsB.{FV[@IQT3ETW7ovdN0`YN5');
define('LOGGED_IN_KEY',   '*u:MH|)C0[S[` `aD3[KqBzclj:^I5O#W|g,E*%=>lb-HI/$0Bw0v8>S;x(1{&@-');
define('NONCE_KEY',       'f<odOwgK}RAki,!$b|-Q2~!LZsXJs}^iDzh]<Fs~Jel_,~6-%mH26,{ra~/+lct_');
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

/// WTZ
define('WP_DEBUG', true);
?>
