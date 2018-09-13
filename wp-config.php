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
define('DB_NAME', 'newcaren_newcare-full');

/** MySQL database username */
define('DB_USER', 'newcaren_root');

/** MySQL database password */
define('DB_PASSWORD', '@dmin1234');

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
 define('AUTH_KEY',         'sB$8@->>nF88~ZN50|,p_*Jh?W+V5:Zc:8!{J#2X_{U#l|?13Zhk?Es9TzMbt+Vi');
 define('SECURE_AUTH_KEY',  '+6A[W`4gS6N8wIE9kJIV-|z93U8/G5n2UMstZ47RL0eNI-{)!_Vyz-fg-f>4|A#P');
 define('LOGGED_IN_KEY',    'R~P!)x(h5>{:3m!?:rBKPO8-ps.I^P,*O{5U@` G=-QVEg9#8: 9&#2gASz@]p!E');
 define('NONCE_KEY',        'B+/@SH-GTfCk;7<c*|a _/~hD/%|Y-#W@br=n0|}|5$YjQ:Inkn0j%-w,i~JDA/N');
 define('AUTH_SALT',        'wbNd|5RC8=@LTU/{>@(h+mK(PgA-`a--olMhaDSxm&s,RV;CiLoF-auC_cY{kXkL');
 define('SECURE_AUTH_SALT', '!G;}$,W26H~nz@n4y2M 38)>=WJr`B4hGX#9KJFtXNK;~3!dq%q;T 4w3@6H+6|l');
 define('LOGGED_IN_SALT',   'N@zf:D5ctq]3;c}7sl{OP& P@apr+3*_wb5`cJ:`G!RqYITENGEi0iTvAHFK?lZP');
 define('NONCE_SALT',       ';(D-28QPYk*4++7GOe~6S1)^* e+}Mf1 E$}r)C>q)c}W+k/g%C;))cFy,Th*h0$');

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

# Disables all core updates. Added by SiteGround Autoupdate:
define( 'WP_AUTO_UPDATE_CORE', false );
