<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         '~wMK-IC_z,sR.9~[9h?Y{i_TUD8hok;cgY2f^fTR24U%s|N^RiZ/ymbR4kINH?v+' );
define( 'SECURE_AUTH_KEY',  'Wj].&8~`a,.ot2E&* bo,?SN7|-EJAMi]%;P(I8*E.&6f*g~D3c.GU/L FQKpP.g' );
define( 'LOGGED_IN_KEY',    ']xe)>rP7R^(pytBj`;aD_[dt7`}C ;AvdWz.m/y[fWt1AG#949F<>4M?K]GmvhzI' );
define( 'NONCE_KEY',        'K: Q>`wQXZ`3 j*w3~ej<3LJKtvdd]oL}v(ic1r~Y3|~ZUb=afg%$hW] p3MTr{o' );
define( 'AUTH_SALT',        ')sNYl+sXCOE(HAQcFJj(8{h2<N!mo(*$-H}##VkS=s<;f+pBCe,6`yfZY7zw@-gk' );
define( 'SECURE_AUTH_SALT', 'cT1C;>*`2hz3V&nI(9Af76aYRuD;bvkxE*?5n=:l:#:tDYIFqs-Az}[b&^g@ODjA' );
define( 'LOGGED_IN_SALT',   '2+n4_d&fn7{]fx=N[<D>b,2iltBZ_~y,XCp(@So%nAXZ[w_*-a5OVqn[^}?_PYSp' );
define( 'NONCE_SALT',       'stay4C4-f3)~VCNBkn<&/9z6P;ZNF>J!?gR}H{1f$>oX>^1b.YgU;YxX!f,Zj$!z' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
