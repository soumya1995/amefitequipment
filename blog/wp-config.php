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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'amefitequipm_eamefit');

/** MySQL database username */
define('DB_USER', 'amefitequipm');

/** MySQL database password */
define('DB_PASSWORD', 'Fmk6#r82');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'n6w[5>?cXG(^+#y[|<X>h3l%QQ/4<rs*8`_FX&f|:L [%jr^xi!QddzyOh+h94Nt');
define('SECURE_AUTH_KEY',  '<_ESZn%H&uvGQW8eBeqbE7znmZmKJs(%6ryu1h2DTSYTcNP}d{~BM$FA$+:1*kEL');
define('LOGGED_IN_KEY',    '=/Uzl;cFf1KsH5PLkJZ81ZF>X v5XK%}LY||Bx!%9JBjXtyTw;zDj9B^}uBmDWH1');
define('NONCE_KEY',        '_2th=>E(x@nI.7?u7`U>.$!:4v}uB)JLo-N5gIqwfmpX3/1vCeK1(HPcy:hr-;Sa');
define('AUTH_SALT',        'avo4?0(h`~ELp7CS~2l*Wc!q*zZ8:UsbEVN//,+!B=R+<1nuzE2^t_ON4U,_|yHo');
define('SECURE_AUTH_SALT', '|mH[}VU~j{(LG0k//QG]=_Z}8jlGh}dE}2%c!Q*:#`[-0tHE>RdL#xJN|?&66piu');
define('LOGGED_IN_SALT',   'XxkN2f<X}ii(XTo-{_YH/_.u40QU!JC1Qk$A8TE3L]+x+4;4*iR(w+y.]^~y:ah(');
define('NONCE_SALT',       '|Ne:Q-dc?5Pd^}<!^(Ijy$I-Su{|<u0LF+<UT*Ds(slwo Zj^wob}|.-Mn7.,tCU');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
