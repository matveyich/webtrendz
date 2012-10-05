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
define('DB_NAME', 'web40-a-word-205');

/** MySQL database username */
define('DB_USER', 'web40-a-word-205');

/** MySQL database password */
define('DB_PASSWORD', 'JX-Fd6cgt');

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
define('AUTH_KEY',        'R|?G-<-/ghQP/u}3H6t#+wS$;LpaaQ}4i)F<9L/:0<DTYt?Wq|f0-k#kGp#?q6UO');
define('SECURE_AUTH_KEY', 'X2jp=pXpdA]N-X@,^Y(_f|.o~C)k)6Ep*KtU$$O->y:69b*Fj`M]6T+|}_vtn1e2');
define('LOGGED_IN_KEY',   ':@6Gp871G7),lOf/YqCpZgF$g@0jJpqkrNFaJAnKr},f<eHb!Wm}R$SDm-X=x/w)');
define('NONCE_KEY',       'A=,B}1xRhv##,=>T16ii:zrV@F(/Y@+hVWZsvzTB:^&GkejVNV8Y3nmg^5K&{._J');
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
?>
