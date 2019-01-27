<?php
/*
Plugin name: Unique Media File Folders
Plugin URI: https://github.com/joppuyo/unique-media-file-folders
Description: Give all media files and their thumbnails their own unique folder
Version: 0.0.1
Author: Johannes Siipola
Author URI: https://siipo.la
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// Check if we are using local Composer
if (file_exists(__DIR__ . '/vendor')) {
    require 'vendor/autoload.php';
}

add_action('plugins_loaded', function () {
    add_filter('wp_handle_upload_prefilter', 'umff_pre_upload');

    add_filter('wp_handle_upload', 'umff_post_upload');
});

function umff_pre_upload($file)
{
    add_filter('upload_dir', 'umff_custom_upload_dir');
    return $file;
}

function umff_post_upload($file_info)
{
    remove_filter('upload_dir', 'umff_custom_upload_dir');
    return $file_info;
}

function umff_custom_upload_dir($path)
{
    if (!empty($path['error'])) {
        return $path;
    }

    $uuid4 = \Ramsey\Uuid\Uuid::uuid4();
    $uuid = $uuid4->getBytes();

    $base32 = new Base2n(5, 'abcdefghijklmnopqrstuvwxyz234567', true);
    $encoded = $base32->encode($uuid);

    $folder_depth = apply_filters('umff_folder_depth', 1);

    if ($folder_depth > 1) {
        $encoded = str_split($encoded);
        foreach ($encoded as $index => &$part) {
            if ($index < $folder_depth - 1) {
                $part = $part . '/';
            }
        }
        $encoded = implode('', $encoded);
    }

    $customdir = "/$encoded";
    $path['path'] = str_replace($path['subdir'], '', $path['path']); //remove default year/month directory
    $path['url'] = str_replace($path['subdir'], '', $path['url']);
    $path['subdir'] = $customdir;
    $path['path'] = $path['path'] . $customdir;
    $path['url'] = $path['path'] . $customdir;
    return $path;
}
