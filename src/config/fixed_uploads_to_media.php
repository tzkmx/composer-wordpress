<?php
/**
 * @package Uploads_Media
 * @version 0.1
 */
/*
Plugin Name: UploadsToMedia
Plugin URI: https://gist.github.com/tzkmx/4c832432bc63fd67a3a16f940a184145
Description: Fixes paths to media directory
Author: Jesus Franco
Version: 0.1
Author URI: https://tzkmx.wordpress.com/
*/
add_filter( 'upload_dir', function( $uploads_array ) {
    $fixed_uploads_array = [];
    foreach( $uploads_array as $part => $value ) {
        if( in_array( $part, ['path', 'url', 'basedir', 'baseurl'] ) ) {
            $fixed_uploads_array[$part] = str_replace(WP_PATH . '/..', '', $value);
        } else {
            $fixed_uploads_array[$part] = $value;
        }
    }
    return $fixed_uploads_array;
});
