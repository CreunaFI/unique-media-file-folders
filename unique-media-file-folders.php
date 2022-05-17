<?php
/*
Plugin name: Unique Media File Folders
Plugin URI: https://github.com/CreunaFI/unique-media-file-folders
Description: Give all media files and their thumbnails their own unique folder
Version: 3.0.0
Author: Johannes Siipola
Author URI: https://siipo.la
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// Check if we are using local Composer
if (file_exists(__DIR__ . '/vendor')) {
    require __DIR__ . '/vendor/autoload.php';
}

$update_checker = Puc_v4_Factory::buildUpdateChecker(
    'https://github.com/CreunaFI/unique-media-file-folders',
    __FILE__,
    "unique-media-file-folders"
);
$update_checker->getVcsApi()->enableReleaseAssets();

add_action('plugins_loaded', function () {
    add_filter('wp_handle_upload_prefilter', 'umff_pre_upload');
    add_filter('wp_handle_upload', 'umff_post_upload');
});

add_action('umff_pre_upload', 'umff_pre_upload');
add_action('umff_post_upload', 'umff_post_upload');

// ACF Image Aspect Ratio Crop compat
add_filter('aiarc_pre_customize_upload_dir', 'umff_pre_upload');
add_filter('aiarc_after_customize_upload_dir', 'umff_post_upload');

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

    $encoded = umff_random_string(25);

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
    $path['url'] = $path['url'] . $customdir;
    return $path;
}

function umff_random_string($length) {
    $random_string = '';
    for($i = 0; $i < $length; $i++) {
        $number = random_int(0, 36);
        $character = base_convert($number, 10, 36);
        $random_string = $random_string . $character;
    }

    return $random_string;
}