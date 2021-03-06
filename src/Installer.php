<?php
/**
 * Created by PhpStorm.
 * User: tzkmx
 * Date: 13/01/2017
 * Time: 11:00 AM
 */

namespace Tzkmx\WP;
use Composer\Script\Event;


class Installer
{
    static $http_dir;
    static $base_dir;

    /**
     * Supports: --skip-wp-config --skip-must-use.
     *
     * @var array custom arguments via command line on manual script run
     */
    static $customArguments = [];

    public static function config(Event $event)
    {
        self::initializeParameters($event);

        self::rebuildIndex();
        self::initializeSalts();
        self::initializeDotenv();
        self::initializeWpconfig();

        try {
            self::installMustUsePlugins();
        } catch (\ErrorException $e) {
            echo "Maybe you should run this script with option --skip-must-use\n";
            echo $e->getMessage(), "\n";
        }
    }

    protected static function initializeParameters(Event $event)
    {
        self::$customArguments = array_flip($event->getArguments());
        $vendor_dir = $event->getComposer()->getConfig()->get('vendor-dir');
        self::$base_dir = dirname( $vendor_dir );
        self::$http_dir = self::mkPath([self::$base_dir, 'public']);
    }

    protected static function shouldSkip(string $key): bool
    {
        return isset(self::$customArguments['--skip-' . $key]);
    }

    protected static function rebuildIndex()
    {
        $custom_index_wp_path = self::mkPath([self::$http_dir, 'index.php']);

        if(! file_exists($custom_index_wp_path) ) {
            $original_index_wp_path = self::mkPath([self::$http_dir, 'cms', 'index.php']);
            $original_index = file_get_contents($original_index_wp_path);

            $custom_index = str_replace("'/wp-blog-header.php'", "'/cms/wp-blog-header.php'", $original_index);

            file_put_contents($custom_index_wp_path, $custom_index);
        }
    }
    protected static function initializeSalts()
    {
        $salts_filename = self::mkPath([self::$base_dir, 'salts.php']);
        if(! file_exists($salts_filename) ) {
            $salts = "<?php\n" . file_get_contents('https://api.wordpress.org/secret-key/1.1/salt/');
            file_put_contents($salts_filename, $salts);
        }
    }
    protected static function initializeDotenv()
    {
        $dotenvToCreate = self::mkPath([self::$base_dir, '.env']);

        if(! file_exists($dotenvToCreate) ) {
            copy( self::mkPath([self::$base_dir, '.env.example']), $dotenvToCreate );
            echo "Customize your .env file for required environment: $dotenvToCreate \n";
        }
    }
    protected static function initializeWpconfig()
    {
        if (self::shouldSkip('wp-config')) return;

        copy( self::mkPath([self::$base_dir, 'src', 'config', 'wp-config-base.php']),
            self::mkPath([self::$http_dir, 'wp-config.php']));
    }
    protected static function installMustUsePlugins()
    {
        if (self::shouldSkip('must-use')) return;

        mkdir( self::mkPath([self::$http_dir, 'must']), 0775 );
        copy( self::mkPath([self::$base_dir, 'src', 'config', 'fixed_uploads_to_media.php']),
            self::mkPath([self::$http_dir, 'must', 'uploads_to_media.php']));
    }
    public static function mkPath($parts)
    {
        return implode(DIRECTORY_SEPARATOR, $parts);
    }
}