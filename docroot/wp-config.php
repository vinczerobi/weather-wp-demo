<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'weather' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'E8a9WLnx~)U!kAF0._3amZ#xEECcnE$cN2|XDQwxX&J!QtCW%t3NKL:+*(FvLomY' );
define( 'SECURE_AUTH_KEY',  '5(^!p2H&6h,}V;^qByjhg55YYR,&|Db!^%CNr4@yikD=m[m]$nk_n=KhyW4,;fG@' );
define( 'LOGGED_IN_KEY',    'aRjzXBvDCwWncj}Z1 )*{*}IoCnKevEw%z|@UF^q_D:2SFYWr}(Kyk[2!2z-Y7eo' );
define( 'NONCE_KEY',        'EtnodAH;nhctiscBtmX`X=;1vS5E]UJq/K6a.p~UeR>4 &IclgWf@o_S8.QY) 4?' );
define( 'AUTH_SALT',        'df4zyz )3u[U_(@c<e2[bNmjGXT1w5nt2c/)_3CMlnl%|2hy(_Hsc|g.}!@${WF{' );
define( 'SECURE_AUTH_SALT', 'k(:P:u;jzlV}(HW)g7;:|E2/_A04YlLpqDAun:M_4FeItQ@m#yAVJSvRNJ+Bph_3' );
define( 'LOGGED_IN_SALT',   'K.<@)|Dvej/I#ubM`+j3pVjaU gZY[0i}^`j >_XZLvmHuwHT;c+,eTEwiE&aMD(' );
define( 'NONCE_SALT',       'qOTI;ugK13;3+Pc.~X-EHgQA:MGI48dHhBLqlBjI:.!.!hAFs3rP/L_8E4+C&.+P' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */

define('WP_MEMORY_LIMIT', '256M');

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
