# Unique Media File Folders

Change the default WordPress upload folder structure to a randomly generated one. Each image and its thumbnails will be given an unique folder with a randomly generated name.

## Why?

Because WordPress default media file paths are not very good. You either get year-month folders which may look funny if you are re-using content and is reminiscent of WordPress' blogging engine roots. The other option is to put all files into one folder which does not scale when you start to have a lot of files.

Too many files in a folder can lead to performance issues on filesystems like EXT4. If all your files are in the same folder, you’ll also run into file name conflicts.

## How it looks

Instead of the following file paths:

```
https://example.com/wp-content/uploads/2019/01/image.jpg
https://example.com/wp-content/uploads/2019/01/image-150x150.jpg
https://example.com/wp-content/uploads/2019/01/image-300x168.jpg
https://example.com/wp-content/uploads/2019/01/image-768x432.jpg
https://example.com/wp-content/uploads/2019/01/image-1024x576.jpg
```

Following file paths will be generated

```
https://example.com/wp-content/uploads/cnk3nae60p6f3e942b4cpvm8q5/image.jpg
https://example.com/wp-content/uploads/cnk3nae60p6f3e942b4cpvm8q5/image-150x150.jpg
https://example.com/wp-content/uploads/cnk3nae60p6f3e942b4cpvm8q5/image-300x168.jpg
https://example.com/wp-content/uploads/cnk3nae60p6f3e942b4cpvm8q5/image-768x432.jpg
https://example.com/wp-content/uploads/cnk3nae60p6f3e942b4cpvm8q5/image-1024x576.jpg
```

## Customizing folder depth

By default, folder depth is 1 so every file will be given its own folder. Customize folder depth using `umff_folder_depth` filter. For example:

```
add_filter('umff_folder_depth', function() {
    return 4;
});
```

Will yield the following folder structure:

```
https://example.com/wp-content/uploads/c/n/k/3nae60p6f3e942b4cpvm8q5/image.jpg
https://example.com/wp-content/uploads/c/n/k/3nae60p6f3e942b4cpvm8q5/image-150x150.jpg
https://example.com/wp-content/uploads/c/n/k/3nae60p6f3e942b4cpvm8q5/image-300x168.jpg
https://example.com/wp-content/uploads/c/n/k/3nae60p6f3e942b4cpvm8q5/image-768x432.jpg
https://example.com/wp-content/uploads/c/n/k/3nae60p6f3e942b4cpvm8q5/image-1024x576.jpg
```

## How it works

For all of your files, first a UUID4 will be generated. It will then be encoded into [Base32](https://en.wikipedia.org/wiki/Base32) which means it will contain characters from a to z and 2 to 7. This is used as the folder name. If folder depth option is greater than 1, first n characters of the UUID are used as subfolders.

## Further reading

[Structuring WordPress’ upload directory to handle lots of files - Ctrl blog](https://www.ctrl.blog/entry/wp-content-uploads)
