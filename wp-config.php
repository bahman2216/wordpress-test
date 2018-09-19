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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'C%1#+bDL&-/;ENbpb7ORX>JYkdje>|2Q(] sd}3+i4YWtQS-#nab6)IVkg?<U^ic');
define('SECURE_AUTH_KEY',  '!o_{F0OJjW?QU/QcR79$V>/DSMg=hm]HZ^KXY8H-1M5LNjYz8zMC?-0F,{xkq;1&');
define('LOGGED_IN_KEY',    ' d?9YP55zVy>hYVxgBO&Z{S00#wXtQ:EQ->|>-My4PK4Gc@6{~]FI]W2ZFGNXk4o');
define('NONCE_KEY',        'V;6~aSttKHg1`aBs2),Dz i,TH`D)dqkO&K%R=27:QI;D#.;KB@Vd`>C 2yDY4ve');
define('AUTH_SALT',        ':)cA5F|_VR7+(GHT;$Q;)$<QRz1Cik4t?|JQ*<f;/XhpA,z$C-YEvjfomD&VLbiu');
define('SECURE_AUTH_SALT', 'JNo`&iw88a<QtGuI1`]PlyJ@RK7=qpY^&CW<mc=ElWgB`:| nE^=RHq[X=h[-JD$');
define('LOGGED_IN_SALT',   'V@j4CZ)WCv:3dhljq@`YYJq.TUvViPU)/O0(sVZwuGQ`R2WB/@?}5%`?7]FHUjUD');
define('NONCE_SALT',       '3Tq@?-Lq1<k2I1~ACq!wjWC.]zPm|lwAp5{AT{ @f!dQ]9])Q/r6FLLVu29&0(Vi');

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
