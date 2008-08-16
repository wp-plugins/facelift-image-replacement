=== Facelift Image Replacment (FLIR) ===
Contributors: dzappone, cmawhorter
Donate link: http://www.23systems.net/donate/
Tags: flir, titles, posts, images, themes, facelift
Requires at least: 2.5
Tested up to: 2.6.1
Stable tag: 0.7.0

Facelift Image Replacment is a script that generates image representations of text on your web page in fonts that visitors would not be able to see.

== Description ==

FLIR for WordPress implements Facelife Image Replacement by Cory Mawhorter.  It is currently in early development but is usable at this time with some manual configuration.  Several freeware fonts are provided with FLIR for WordPress

FLIR for WordPress is SEO friendly and only renders the image in the browser if JavaScript is enabled.  You HTML/XHTML code remains unchanged leaving your head tags readable by search engines and the page readable by those without JavaScript.

Facelift Image Replacement (or FLIR, pronounced fleer) is an image replacement script that dynamically generates image representations of text on your web page in fonts that otherwise might not be visible to your visitors. The generated image will be automatically inserted into your web page via Javascript and visible to all modern browsers. Any element with text can be replaced: from headers (`<h1>`, `<h2>`, etc.) to `<span>` elements and everything in between!

You can see examples of what it does here: <a href="http://facelift.mawhorter.net/examples/">http://facelift.mawhorter.net/examples/</a>

= IMPORTANT: Delete your existing version before installing this version =

== Installation ==

= Requirements =

= IMPORTANT: Delete your existing version before installing this version =

PHP and GD. Little testing has been done with different versions of PHP. If you have PHP 5 with GD enabled you shouldn't have any problems. Later versions PHP 4 should(?) also be okay. A newer version of ImageMagick is required for the FancyFonts and QuickEffects plugins.

If GD is not installed on your server you will have to recompile PHP to include GD. If you are comfortable in WHM, you can do that under the “Update Apache” tab (check the “GD” box). Check your settings carefully (especially the PHP version - cPanel may try to change it) before you hit build. Plesk should have it enabled by default.  If you are not comfortable doing it yourself, ask your hosting company to do it for you. (Thanks Steve!)

1. Extract to your `wp-content/plugins` directory.
2. Look in `wp-content/plugins/facelift-image-replacement/facelift`
3. Set the `wp-content/plugins/facelift-image-replacement/facelift/config-flir.php` to be writable
3. Set the `wp-content/plugins/facelift-image-replacement/facelift/cache` to be writable
4. Add fonts of your choice to `wp-content/plugins/facelift-image-replacement/facelift/fonts` folder
5. Activate plugin in WordPress admin panel
5. Set FLIR configuration in the admin panel - config-flir.php must be writable for changes to take effect.
7. Customize tags for FLIR on FLIR submenu under the Design menu

= Notes =

* Plugins are not implemented yet
* Completely delete any old verions before upgrading as this plugin is under rapid development
* You cannot auto-upgrade from version 0.3.0
* Detailed instruction on the admin panel coming soon
* Text remains intact in source so search engines see your page as text!

== Screenshots ==

1. Before Facelift Image Replacement
2. After Facelift Image Replacement

== Frequently Asked Questions ==

= It doesn't work =

The most common reason for it not working is that your cache directory is not writable or does not exist.  Please ensure that you have a cahve directory at `wp-content/plugins/facelift-image-replacement/facelift/cache` and that it is writable.

= Will FLIR be configurable from the admin panel? =

Partially implemented at this time.  Eventually it is planned to be able to configure FLIR almost completely from the admin panel.  Once complete it should allow you to configure how and what fonts are replaced by FLIR.

= Will the FLIR plugins be usable? =

Yes, eventually they will.  They will require ImageMagick 6.3.7 or higher to function correctly and will be configurable from the admin panel.

= What about the fonts that come with FLIR? =

All the fonts that come with FLIR are either free or Open Source.

== Known Issues ==

* Automatically updating the plugin does not always work - I have not tracked down the issue but I suspect it has to do with the cache folder

== Changelog ==

= 0.7.0 =

* Initialize plugin and set basic settings on install - note: the new version will overwrite your current config-flir.php
* Set all config-flir.php settings (except allowed domain and font discovery which is done by the plugin)
* Ability to flush cache on demand
* Ability to reset the entire plugin and reinitialize
* Ability to choose to have fonts automatically replaced for h1 to h5 headers or select a specific JavaScript library to use (jQuery, Prototype, Scriptaculous)
* Latest version of Facelift 1.2b2 which fixes numerous rendering issues.
* Admin panel page reloads after saving changes to reflect updates
* Reduced number of fonts that come with plugin - all fonts are freeware/open source and redistributable
* Easy addition of your own fonts - just drop in fonts folder and configure from admin panel
* Selection of what fonts to include during element font selection
* Moved additional admin includes into subdirectory
* Minor cosmetic and coding fixes

= 0.5.9 =

* Fixed issue with not running correctly when WordPress is installed in a sub-directory (i.e. http://yousite.com/personal/blog/)

= 0.5.5 =

* Removed prototype implementation in favor of jQuery, noticeable improvement in speed.
* Bug with IE in rendering header in some cases not jQuery related

= 0.5.0 =

* Added per element modes

= 0.4.1 =

* Updated Facelift to 1.2b

= 0.4.0 =

* Basic admin functionality added
* Implemented prototype in plugin for per element rendering

= 0.3.0 =

* Initial Release
* Auto redering of `<h1>` to `<h5>` only
* Using Facelift 1.1

== Upcoming Features ==

* Better test descriptions in admin panel ~v0.7.1
* User defined element replacement ~v0.8
* Quick Effects (require ImageMagick) ~v0.9
* More...

== Under consideration ==

* Uploading of fonts from within the plugin

== Development Version ==

* Always the latest code
* May be buggy - actually probably is
* Please remove existing version before installing the development version