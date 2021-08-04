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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress_prueba' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '1998' );

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
define( 'AUTH_KEY',         'H{/JI{/^)[IMT~5)}+PBs/is?0(#/m?D`dDTFnnkFYE:UiabG{nCJ7Dg@.12lXcE' );
define( 'SECURE_AUTH_KEY',  'a?tAJoS>~z|:1%WR_3q;D};[3fi60pso(cGDT+#ywEN5Oyw0hHF|YM2vO_WIlZR>' );
define( 'LOGGED_IN_KEY',    '%3-z/CG|+s<?<SO|v-$2cNfz]X:$arj|{i&**)~u]i4BOq~:xf%pSR)+YO5oymeu' );
define( 'NONCE_KEY',        '*vj VNM2jZ=~WIl-o[h^i}S)B YZz0{*zB+D!D-D}0mx7Y?TI<!$a4~9mp*`#<k;' );
define( 'AUTH_SALT',        'I9Edi/0]KNW-U2b CBmA*GqL<8d -cvd9,]_dX?|sABXaT^&wHn&b+`M{S17krd{' );
define( 'SECURE_AUTH_SALT', 'XL[`-:T7ZX @j%J_mW*FRB02 C<IsP5/.!Ys1(j4,!JyqGEOF<~!c))5N-3R2wQS' );
define( 'LOGGED_IN_SALT',   '*N4y5=%d7!tt^-3v}P`xSY+YiLFQQzojGD^3bZ6bf?I53Fo.;__z#^e5GtmIRrbq' );
define( 'NONCE_SALT',       ' |?B]ZQUv^5QKM4wB*-Fl,`Q[jd5EE?])qT7#ngP!*Y_7O~h!4htO*PAcMVZjQ7[' );

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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
