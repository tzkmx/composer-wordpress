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
    public static function config(Event $event)
    {
        $vendor_dir = $event->getComposer()->getConfig()->get('vendor-dir');
        $base_dir = dirname($vendor_dir);
        $http_dir = self::mkPath([$base_dir, 'public']);

        $original_index_wp_path = self::mkPath([$http_dir, 'cms', 'index.php']);
        $original_index = file_get_contents($original_index_wp_path);

        $custom_index_wp_path = self::mkPath([$http_dir, 'index.php']);
        $custom_index = str_replace("'/wp-blog-header.php'", "'/cms/wp-blog-header.php'", $original_index);

        file_put_contents($custom_index_wp_path, $custom_index);
    }

    public static function mkPath($parts)
    {
        return implode(DIRECTORY_SEPARATOR, $parts);
    }
}