=== Facelift Image Replacment (FLIR) ===
Contributors: dzappone, cmawhorter
Donate link: http://www.23systems.net/donate/
Tags: flir, titles, posts, images, themes, facelift
Requires at least: 2.5
Tested up to: 2.6
Stable tag: 0.5.5

Facelift Image Replacment is a script that generates image representations of text on your web page in fonts that visitors would not be able to see.

== Description ==

FLIR for WordPress implements Facelife Image Replacement by Cory Mawhorter.  It is currently in early development but is usable at this time with some manual configuration.  Several freeware fonts are provided with FLIR for WordPress

Facelift Image Replacement (or FLIR, pronounced fleer) is an image replacement script that dynamically generates image representations of text on your web page in fonts that otherwise might not be visible to your visitors. The generated image will be automatically inserted into your web page via Javascript and visible to all modern browsers. Any element with text can be replaced: from headers (`<h1>`, `<h2>`, etc.) to `<span>` elements and everything in between!

You can see examples of what it does here: <a href="http://facelift.mawhorter.net/examples/">http://facelift.mawhorter.net/examples/</a>

== Installation ==

= Delete your existing version before installing this version =

1. Extract to your `wp-content/plugins` directory.
2. Look in `wp-content/plugins/facelift-image-replacement/facelift`
3. Set the `wp-content/plugins/facelift-image-replacement/facelift/cache` to be writable
4. Add fonts of your choice to `wp-content/plugins/facelift-image-replacement/facelift/fonts` folder
5. Open `config-flir.php` and customize to your liking. All the variables and options are explained in-depth inside the file.
6. Activate plugin in WordPress admin panel
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

== Changelog ==

= 0.5.5 =

* Removed prototype implementation in favor of jQuery, noticeable improvement in speed.
* Bug with IE in rendering header in some cases not jQuery related

= 0.5.0 =

* Added per element modes

= 0.4.1 =

* Updated something but I can't remember what it was

= 0.4.0 =

* Basic admin functionality added
* Implemented prototype in plugin for per element rendering
* Updated Facelift to 1.2b

= 0.3.0 =

* Initial Release
* Auto redering of `<h1>` to `<h5>` only
* Using Facelift 1.1

== Upcoming Features ==

* Configuration of Facelift from admin panel ~v0.7
* User defined element replacement ~v0.8
* Quick Effects (require ImageMagick)
* More...