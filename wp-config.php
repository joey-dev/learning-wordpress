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
define( 'DB_NAME', 'learn_wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '=PIyTdHOV|NZePQ+fmwl6DM[^R!X]([[b0:lu.f Q,jsZ#VAowW@vS@wu,;GJf#?' );
define( 'SECURE_AUTH_KEY',  'V;J7}_B#em= _f&zt*5]XHC8AG? ]=,j~0@keqE|$LLN]6v30}4j+Rm?b@W_ENrB' );
define( 'LOGGED_IN_KEY',    'h$y_LZ:_DG#;hp&L1!5n:Lqb6L{*g;eGeR0y,7gx`fwH<Q~Kx(hgIGuDw} vH^0m' );
define( 'NONCE_KEY',        'aKv~CEUpFh?xsp0 -Th%Y**`qz)~4i_5psL1S]zowi0!o[i__I6UdJ^imy7#LL! ' );
define( 'AUTH_SALT',        'T!#4 {!q.M:!O^8C:#[L*4B03[3OIxI%;W4@(u# )|nAZ6By|XF=_JH6AL:S!-i(' );
define( 'SECURE_AUTH_SALT', '!.t^tD!hZARnb7pqc;X-1bdG2L.2!Lp7I+7?)b?0<}f6JyJXvr8M;fsIu@8.;1:(' );
define( 'LOGGED_IN_SALT',   'QG({ptK3 E8%Zo`B8%jJ|5qQmKP&h3DepLy3N>SFf_?XVN 73@4~iIs+A^@Ks)n@' );
define( 'NONCE_SALT',       ';nFG[A*.|QZTz|%qzy#kRQR@yD2&`H?b}4gEU%fHGPL}JJ:B~$IQ*otMALXwY`a%' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
