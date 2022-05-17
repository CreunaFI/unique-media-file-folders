=== Unique Media File Folders ===
Contributors: joppuyo
Tags: uuid, media, gallery, folder, directory, upload, image
Requires at least: 4.9
Tested up to: 5.0
Requires PHP: 7.1
License: License: GPLv2 or later

Change the default WordPress upload folder structure to a randomly generated one.

== Description ==

Change the default WordPress upload folder structure to a randomly generated one. Each image and its thumbnails will be given an unique folder with a randomly generated name.

== Installation ==
1. Install this plugin into **wp-content/plugins**
2. Enable **Unique Media File Folders** on your Plugins page

== Changelog ==

= 3.0.0 =
* Breaking change: Changed how the unique folter name is generated, instead of converting a UUIDv4 to base36, we simply generate a base36-style random string character by character
* Fix: Changed Travis to GitHub actions

= 2.0.0 =
* Feature: Use base36 instead of base32 for a shorter folder name
* Breaking: Because we are using a different library, the plugin now requires at least PHP 7.1

= 1.1.2 =
* Fix: Fix error where plugin did not sometimes load correct Composer autoloader

= 1.1.1 =
* Feature: Enable auto update for the plugin

= 1.0.4 =
* Fix: Deploy using Travis

= 1.0.1 =
* Fix: Update PHP requirement to 7.0

= 1.0.0 =
* Initial release
