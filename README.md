# Unique Media File Folders

[![Build Status](https://travis-ci.com/CreunaFI/unique-media-file-folders.svg?branch=master)](https://travis-ci.com/CreunaFI/unique-media-file-folders) [![Packagist](https://img.shields.io/packagist/v/joppuyo/unique-media-file-folders.svg?style=flat)](https://packagist.org/packages/joppuyo/unique-media-file-folders)

Change the default WordPress upload folder structure to a randomly generated one. Each image and its thumbnails will be given an unique folder with a randomly generated name.

## Why?

Because WordPress default media file paths are not very good. You either get year-month folders which may look funny if you are re-using content and is reminiscent of WordPress' blogging engine roots. The other option is to put all files into one folder which does not scale when you start to have a lot of files.

Too many files in a folder can lead to performance issues on filesystems like EXT4. If all your files are in the same folder, you’ll also run into file name conflicts.

## How it works

Instead of the following file paths:

```
https://example.com/wp-content/uploads/2019/01/photo.jpg
https://example.com/wp-content/uploads/2019/01/photo-150x150.jpg
https://example.com/wp-content/uploads/2019/01/photo-300x168.jpg

https://example.com/wp-content/uploads/2019/01/image.png
https://example.com/wp-content/uploads/2019/01/image-150x150.png
https://example.com/wp-content/uploads/2019/01/image-300x168.png
```

The plugin will generate the following paths:

```
https://example.com/wp-content/uploads/cnk3nae60p6f3e942b4cpvm8q/photo.jpg
https://example.com/wp-content/uploads/cnk3nae60p6f3e942b4cpvm8q/photo-150x150.jpg
https://example.com/wp-content/uploads/cnk3nae60p6f3e942b4cpvm8q/photo-300x168.jpg

https://example.com/wp-content/uploads/2xv5r4tnlrcodofcq3ageksmb/image.png
https://example.com/wp-content/uploads/2xv5r4tnlrcodofcq3ageksmb/image-150x150.png
https://example.com/wp-content/uploads/2xv5r4tnlrcodofcq3ageksmb/image-300x168.png
```

## How to install

1. Download latest version from the [Releases tab](https://github.com/CreunaFI/unique-media-file-folders/releases)
2. Unzip the plugin into your wp-content/plugins directory
3. Activate **Unique Media File Folders** from your Plugins page

## Customizing folder depth

By default, folder depth is 1 so every file will be given its own folder. Customize folder depth using `umff_folder_depth` filter. For example:

```
add_filter('umff_folder_depth', function() {
    return 4;
});
```

Will yield the following folder structure:

```
https://example.com/wp-content/uploads/c/n/k/3nae60p6f3e942b4cpvm8q/photo.jpg
https://example.com/wp-content/uploads/c/n/k/3nae60p6f3e942b4cpvm8q/photo-150x150.jpg
https://example.com/wp-content/uploads/c/n/k/3nae60p6f3e942b4cpvm8q/photo-300x168.jpg

https://example.com/wp-content/uploads/2/x/v/5r4tnlrcodofcq3ageksmb/image.png
https://example.com/wp-content/uploads/2/x/v/5r4tnlrcodofcq3ageksmb/image-150x150.png
https://example.com/wp-content/uploads/2/x/v/5r4tnlrcodofcq3ageksmb/image-300x168.png
```

## How are paths generated

For all of your files, first a UUID4 will be generated. It will then be encoded into [Base36](https://en.wikipedia.org/wiki/Base36) which means it will contain characters from a to z and 0 to 9. This is used as the folder name. If folder depth option is greater than 1, first n characters of the UUID are used as subfolders.

## Further reading

[Structuring WordPress’ upload directory to handle lots of files - Ctrl blog](https://www.ctrl.blog/entry/wp-content-uploads)
