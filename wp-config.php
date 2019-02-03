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
define('FS_METHOD','direct');
/*define('FORCE_SSL_ADMIN', true);
// so check for https existence
if (strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false){
	 $_SERVER['HTTPS']='on';
}*/
define('DB_NAME', 'copamaltamorena_live');

/** MySQL database username */
define('DB_USER', 'cmalta_user');

/** MySQL database password */
define('DB_PASSWORD', 'copa2018passwdb');

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
define('AUTH_KEY',         'V}RqHdhkVh0hyg8;|j+V)g,$Hv(SV#T21lt73Kk4Tka%[K_0r(fUp`dZR7Zm&cQo');
define('SECURE_AUTH_KEY',  '$RZ&9h(T]Lt~T#XyrM2$X&;|zbv1gDQcEax+Ju&i`#MB7*7Q*eGCcmQj./`y=}d*');
define('LOGGED_IN_KEY',    'w0e4Et(Q(D9bf3?|@N~;W6/r%ai(A `R;x6n)@3o#YcV1h:xLj|?>-9uP@jJ~?|d');
define('NONCE_KEY',        'IS*B_WK`-IpKM7fC<]^1US&]*Q<^koirBQH*a0,7, -4j9%88`yaF.keF;tD WtG');
define('AUTH_SALT',        ';DE^m{%?]i!6Z,{/EcnLojgEfZO(j2Tvg@xN@Y!WmGx.<Al8$Z_=Zj|~*6[Oc,Dq');
define('SECURE_AUTH_SALT', 'e-~_E@XmCWe1%:Swa3@]QR+Z%eXt&{:t:_VGK)T|[n|KHF.J6hz4HlHmO 4iUA5<');
define('LOGGED_IN_SALT',   ',V>28qW7og]OkC0t6/VPVv+z*<Q<Xy]QbsUDV!oaS# J(R)kkxmSuc1v4`NK?T/_');
define('NONCE_SALT',       'j1eIfQ6[{0[hpt3jOY3C4Z&D9S:s~k97 //nq_3q1=s/Si-,&Ka6+6SHV7a?cywC');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp2_';

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
