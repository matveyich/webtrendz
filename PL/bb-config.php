<?php
/** 
 * The base configurations of bbPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys and bbPress Language. You can get the MySQL settings from your
 * web host.
 *
 * This file is used by the installer during installation.
 *
 * @package bbPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for bbPress */
define( 'BBDB_NAME', 'web40-a-wordp-24' );

/** MySQL database username */
define( 'BBDB_USER', 'web40-a-wordp-24' );

/** MySQL database password */
define( 'BBDB_PASSWORD', 'bV3!FsWWC' );

/** MySQL hostname */
define( 'BBDB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'BBDB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'BBDB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/bbpress/ WordPress.org secret-key service}
 *
 * @since 1.0
 */
define('AUTH_KEY',        'p/HEm@e#]Mj>)Q?OFgS7<mNY)t7CAdDfe%6.ynd5Z|]9]*cWKTNJInU>1:M-PMe7');
define('SECURE_AUTH_KEY', '3TEUu>0ILH<*U8ZMNprDb4D?Q>BZ;++9C|$+cn%<YaBm`/^j%@3&l}VP$]xce8FJ');
define('LOGGED_IN_KEY',   'XCg(L$jU?2pEi&<K{Z.;7_ t#;o[?dT9q$Y8htl63B=|ot5&9o4[y`9|`Q:AP 3-');
define('NONCE_KEY',       'PMd+l?e{nH}] %d~T%MS3=G.|{-JL2-$Bc<9^{1nl0|b~0AmNl.imv8wbHD9HD;X');
/**#@-*/

/**
 * bbPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$bb_table_prefix = 'bb_';

/**
 * bbPress Localized Language, defaults to English.
 *
 * Change this to localize bbPress. A corresponding MO file for the chosen
 * language must be installed to a directory called "my-languages" in the root
 * directory of bbPress. For example, install de.mo to "my-languages" and set
 * BB_LANG to 'de' to enable German language support.
 */
define( 'BB_LANG', '' );
?>