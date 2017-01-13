<?php
$original_index_wp_path = self::mkPath([$http_dir, 'cms', 'index.php']);
$original_index = file_get_contents($original_index_wp_path);

$custom_index_wp_path = self::mkPath([$http_dir, 'index.php']);
$custom_index = str_replace("'/wp-blog-header.php'", "'/cms/wp-blog-header.php'", $original_index);

file_put_contents($custom_index_wp_path, $custom_index);
$config_dev_file  = __DIR__ . "/../config-dev.php";
$config_prod_file = __DIR__ . "/../config-prod.php";

if( file_exists( $config_prod_file ) ) {
	include $config_prod_file;
}else{
	include $config_dev_file;
}

/**
 * NOTE:
 * in multisite installation you need to remove this two options after configure and enable the network
 * */
define('WP_SITEURL', _BASE_URL . '/' );
define('WP_HOME',    _BASE_URL . '/' );


/* Multisite example */

/**
define( 'WP_ALLOW_MULTISITE', true );
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', true_or_false);
define('DOMAIN_CURRENT_SITE', str_replace(["https://", "http://"], "", _BASE_URL));
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

define( 'SUNRISE', 'on' );**/


define( 'WP_CONTENT_DIR', __DIR__ . '/wp-content');
define( 'WP_CONTENT_URL', _BASE_URL . '/wp-content' );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', __DIR__ . '/_wp');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
