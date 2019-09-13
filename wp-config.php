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
define( 'DB_NAME', 'zlash_db' );

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
define( 'AUTH_KEY',         'Fs|YexqP+a%2M=GegiK|+L{Gv1>|od/P/%MF~,@$c4IrCp?=gbZk4j=E4I{c52lS' );
define( 'SECURE_AUTH_KEY',  'oP354,lA_}-y@4$H}C)v&.Ti%JwL}Xs(=haDH)U-X</$*Z_ s& }8+XyO0Fv,RL~' );
define( 'LOGGED_IN_KEY',    'uscjsP(Uk&_Db2{:}:~dF3z:0mJq3;f&~j/R@3I)V3N[f?uS,2d[W)uk6fU]uh@F' );
define( 'NONCE_KEY',        'GKW~0aTOX XT,7p5OwtD]fSz0Y*]R@:DY@5BA,*^;Tq%wj%{gb2BTd[[QiD1p@X`' );
define( 'AUTH_SALT',        'L%w//E(UE 3Kc9ZlC9)yTiPk!/z4)G`KE4wQPd6:lU)V<7$6ImA*IhOO696ZNj=z' );
define( 'SECURE_AUTH_SALT', 'Ch&;D,49@gt0!gq712fKmsucai1hd;%T#<i7$AF)NXVG}KXd6X_drm(TO}6RouvJ' );
define( 'LOGGED_IN_SALT',   'Bz3iN/*hmjTg**Sj`Hsg/WgZPAEe#HBhZt3tX,cgVBv+3*IB*~U2n~3kulB).6zU' );
define( 'NONCE_SALT',       '$w .73ZC6pnF[Gb,L/.x30.gg_x3)Be=gr3F u&e/)F=;bd2WME [{:X qBdI2Ny' );

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
