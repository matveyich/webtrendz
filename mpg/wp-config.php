<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
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


define('DB_NAME', 'web146-mpg');

/** MySQL database username */

define('DB_USER', 'web146-mpg');

/** MySQL database password */

define('DB_PASSWORD', '$RD7%0.8FS');

/** MySQL hostname */

define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '$dNO(&Y`)f(R5M>9!4hhj`fPR@Hv<W8os{`1Bm}_-]!9t>LZi}zu-%+17*x&?nhu');
define('SECURE_AUTH_KEY',  'jBS:*^bt>>hrqaH]*nc.&c-^_&d51)-[%Wo^!qe?@e T65&>D/]wM03B}yb3Y1B+');
define('LOGGED_IN_KEY',    '+B3 _T0.1:^<J2%4iwQ-<q:?rnFa{IOTcm9:S)R+1eX8NOKEa-J-R}jTMQ|[s@*A');
define('NONCE_KEY',        'F.T~2q !J>$lh3SS0o@qaw|cK&O8>2KBY0]O3fK@9{dG3`$EgI1YD#,|S%PP&Phr');
define('AUTH_SALT',        'rS8cvX*{nfepNj LX]*_nutq||v6[FW^k]Vlr5<[5b 7ayK8R-<5>qewl@{lE4Pz');
define('SECURE_AUTH_SALT', 'NIDrqE;6a1@`M)U9?Ak#^-V|i +=s{>>rHaeb+[/2FyNo@O6Y(.eODbvML4-)~s.');
define('LOGGED_IN_SALT',   'i^;sJF9.!jmgvn _lzn:ba}3-Pwp~pvOh5AsxR_+Qo+@Ilb(+3l} #)}HB&:#%?d');
define('NONCE_SALT',       '6RIfoGDSXBUH6n;r*04_|*8+#$EDe#p*wE T1 %]v*<E@dz2xA}}!=6D)o,>0!u5');

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

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
