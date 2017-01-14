<?php
/** @var string Directory containing all of the site's files */
$root_dir = dirname(dirname(__DIR__));
/** @var string Document Root */
$webroot_dir = $root_dir . '/public';

/**
 * Use Dotenv to set required environment variables and load .env file in root
 */
$dotenv = new Dotenv\Dotenv($root_dir);
if (file_exists($root_dir . '/.env')) {
    $dotenv->load();
    $dotenv->required(['DB_NAME', 'DB_USER', 'DB_PASSWORD', 'WP_HOME', 'WP_SITEURL']);
}
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
    define('ABSPATH', $webroot_dir . '/cms');
}
/**
 * Custom Media, Plugins and Theme paths
 * check webroot dir, upload, register_theme_directory
 */
define('WP_CONTENT_DIR', $webroot_dir);
define('WP_CONTENT_URL', WP_HOME);
define('WP_PLUGIN_DIR' , $webroot_dir . '/extensions');
define('WP_PLUGIN_URL' , WP_HOME . '/extensions');
define('WPMU_PLUGIN_DIR' , $webroot_dir . '/extensions/must');
define('WPMU_PLUGIN_URL' , WP_HOME . '/extensions/must');
define('UPLOADS', 'media');
register_theme_directory($webroot_dir . '/themes');
