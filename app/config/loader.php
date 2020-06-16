<?php
/** @var string Directory containing all of the site's files */
$root_dir = dirname(dirname(__DIR__));
/** @var string Document Root */
$webroot_dir = $root_dir . '/public';

/**
 * Use Dotenv to set required environment variables and load .env file in root
 * @var \Dotenv\Dotenv $dotenv
 */
$dotenv = Dotenv\Dotenv::createUnsafeMutable($root_dir);
$dotenv->load();
$requiredVars = ['DB_NAME', 'DB_USER', 'DB_PASSWORD', 'WP_HOME', 'WP_SITEURL'];
$dotenv->required($requiredVars);
/**
 * Set up our global environment constant and load its config first
 * Default: development
 */
define('WP_ENV', getenv('WP_ENV') ?: 'development');
$env_config = __DIR__ . '/environments/' . WP_ENV . '.php';
if (file_exists($env_config)) {
    require_once $env_config;
}
/**
 * URLs
 */
define('WP_HOME', getenv('WP_HOME'));
define('WP_SITEURL', getenv('WP_SITEURL'));
/**
 * WP custom path
 */
define('WP_PATH', substr(WP_SITEURL, strrpos(WP_SITEURL, '/') ) );
/**
 * DB settings
 */
define('DB_NAME', getenv('DB_NAME'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASSWORD', getenv('DB_PASSWORD'));
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');
$table_prefix = getenv('DB_PREFIX') ?: 'wp_';

/*
 * Custom Settings
 */
define('AUTOMATIC_UPDATER_DISABLED', true);
define('DISABLE_WP_CRON', getenv('DISABLE_WP_CRON') ?: false);
define('DISALLOW_FILE_EDIT', true);

/**
 * Bootstrap WordPress
 */
if (!defined('ABSPATH')) {
    define('ABSPATH', $webroot_dir . WP_PATH);
}
/**
 * Custom Media, Plugins and Theme paths
 * @see https://gist.github.com/tzkmx/4c832432bc63fd67a3a16f940a184145
 */
define('WP_CONTENT_DIR', $webroot_dir);
define('WP_CONTENT_URL', WP_HOME);
define('WP_PLUGIN_DIR' , $webroot_dir . '/extensions');
define('WP_PLUGIN_URL' , WP_HOME . '/extensions');
define('WPMU_PLUGIN_DIR' , $webroot_dir . '/must');
define('WPMU_PLUGIN_URL' , WP_HOME . '/must');
define('UPLOADS', '../media');
