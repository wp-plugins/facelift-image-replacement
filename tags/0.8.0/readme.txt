=== Facelift Image Replacment (FLIR) ===
Contributors: dzappone, cmawhorter
Donate link: http://www.23systems.net/donate/
Tags: flir, titles, posts, images, themes, facelift
Requires at least: 2.5
Tested up to: 2.7
Stable tag: 0.8.0

Facelift Image Replacment is a script that generates image representations of text on your web page in fonts that visitors would not be able to see.

== Description ==

FLIR for WordPress implements Facelift Image Replacement (FLIR) by Cory Mawhorter.  It is in rapid development and at this time almost completely configurable from the admin panel.  Several freeware fonts are provided with FLIR for WordPress.

FLIR for WordPress is SEO friendly and only renders the image in the browser if JavaScript is enabled.  You HTML/XHTML code remains unchanged leaving your head tags readable by search engines and the page readable by those without JavaScript.

Facelift Image Replacement (or FLIR, pronounced fleer) is an image replacement script that dynamically generates image representations of text on your web page in fonts that otherwise might not be visible to your visitors. The generated image will be automatically inserted into your web page via Javascript and visible to all modern browsers. Any element with text can be replaced: from headers (`<h1>`, `<h2>`, etc.) to `<span>` elements and everything in between!

You can see examples of what it does here: <a href="http://facelift.mawhorter.net/examples/">http://facelift.mawhorter.net/examples/</a>

= IMPORTANT: If using a version prior to 0.7.0 please <em>delete</em> your existing version before installing this version =

Before running autoupdate please empty your `facelift/cache` folder.

== Installation ==

= Requirements =

= IMPORTANT: If using a version prior to 0.7.0 please <em>delete</em> your existing version before installing this version =

PHP and GD. Little testing has been done with different versions of PHP. If you have PHP 5 with GD enabled you shouldn't have any problems. PHP 4 currently has some issues but should be resolved in the next release of Facelift. A newer version of ImageMagick (6.3.7+) is required for the FancyFonts and QuickEffects plugins.

If GD is not installed on your server you will have to recompile PHP to include GD. If you are comfortable in WHM for cPanel, you can do that under the "Update Apache" tab (check the "GD" box). Check your settings carefully (especially the PHP version - cPanel may try to change it) before you hit build. Plesk and ISPConfig should have GD enabled by default.  If you are not comfortable doing it yourself, ask your hosting company to do it for you. (Thanks Steve!)

1. Extract to your `wp-content/plugins` directory.
2. Look in `wp-content/plugins/facelift-image-replacement/facelift`
3. Set the `wp-content/plugins/facelift-image-replacement/facelift/config-flir.php` to be writable
3. Set the `wp-content/plugins/facelift-image-replacement/facelift/cache` to be writable
4. Add fonts of your choice to `wp-content/plugins/facelift-image-replacement/facelift/fonts` folder
5. Activate plugin in WordPress admin panel
5. Set FLIR configuration in the admin panel - `config-flir.php` must be writable for changes to take effect.
7. Customize tags for FLIR on FLIR submenu under the Design menu

= Notes =

* QuickEffect Plugin is not implemented yet
* If using a version older than 0.7 completely delete any old verions before upgrading
* You cannot auto-upgrade from versions older 0.7.0
* Text remains intact in source so search engines see your page as text!

== Screenshots ==

1. Before Facelift Image Replacement
2. After Facelift Image Replacement

== Frequently Asked Questions ==

= It doesn't work, how can I make it work? =

* Please ensure that you have a cache directory at `wp-content/plugins/facelift-image-replacement/facelift/cache` and that it is writable. (`chmod a+w /cache`)
* Please ensure that your config-flir.php file exists at `wp-content/plugins/facelift-image-replacement/facelift/config-flir.php` and that it is writable. (`chmod a+w config-flir.php`)
* Make sure the `wp-content/plugins/facelift-image-replacement/facelift/` is readable
* Check your theme's `footer.php` file and make sure it has the `wp_footer();` function in it.  It should be located just above the `</body>` element close tag.
* Check your theme's `header.php` file and make sure it has the `wp_head();` function in it.  It should be located just above the `</head>` element close tag.
* Check the FLIR admin panel under the design menu and make certain all the options are set in the FLIR Configuration section.  Read the help text on the right of each option for information.
* Check the FLIR admin panel under the design menu and make certain all the options you want are set in the Elements to Replace section.  Heading 1 is generally used for the blog heading, Heading 2 is used for the posts on the main page and on individual post pages, Heading 3 is often used with posts on the catagories and tags pages.  Small is often used for the date and author of the post.

= Is FLIR be configurable from the admin panel? =

FLIR is almost completely configurable from the admin panel.  Eventually it is planned to be able to configure FLIR almost completely from the admin panel.  At present to configure how and what fonts are used with flir and certain element to be replaced by FLIR.

= Will the FLIR plugins be usable? =

At present the FancyFonts plugin is implemented.  QuickEffects will be implemented next.  They require ImageMagick 6.3.7 or higher to function correctly and will be configurable from the admin panel.

= What about the fonts that come with FLIR? =

All the fonts that come with FLIR are either free or Open Source.

= What advantages would you say FLIR provides over sIFR? Besides, of course, from needing flash? =

* Facelift creates transparent PNGs which can lie over the top of any background you want.   For example, take a look at <a href="http://facelift.mawhorter.net/examples/">Example #5</a>. 
* It can easily create multi colored/font headers.  (<a href="http://facelift.mawhorter.net/examples/">Example #3</a>)
* It can replace links and maintain their clickability (though I believe this functionality was added to sIFR).
* It is very easy to implement.  No other tools besides a web browser are needed and it is very easy to maintain.
* It plays well with third party libraries such as jQuery and prototype.
* You can take advantage of plugins such as the QuickEffects plugin and add things like drop shadows and pattern/gradient fills if you have ImageMagick installed on your server.

= Is there some kind of caching system? If so, how does it work? =

Facelift caches all images it generates to disk.  It then will send appropriate headers to the browser if the image has not changed.  This allows for drastic speed increases in rendering when browsing a website.  After a couple of page views you sometimes won't even notice the text get replaced.  By default, the cached images are saved indefinitely, but you can change facelift to run through the cache every so often and remove old images to save disk space.  Just change the settings in the admin panel.

= It still doesn't work / I have other questions =

* the best places to get answers are <a href="http://www.23systems.net/plugins/facelift-image-replacement-flir/">Facelift Image Replacement (FLIR) for WordPress @ 23Systems </a> and or <a hreg="http://forums.mawhorter.net/viewforum.php?id=11">FLIR Integration with WordPress</a>.

== Known Issues ==

* Automatically updating the plugin may not work.  This is most likely caused by the cache folder files being owned by www-data rather than the account holder for the web site.  On deactivation the plugin now clears the cache folder and hopefully eliminates this issues.
* Rendering in Konqueror is incorrect and displays all rendered text as the default size and black.

== Changelog ==

= 0.8.0 =

* Updated Facelift to 1.2 release
 * Font Collections
 * Basic Callback Functions
 * Better error handling
 * Bug in generateURL causing HTML not to be sanitized
 * Added functionality/bug fixes for “wrap” mode.  Better line-height support.
 * Rewrote element replacement algorithm. You no longer need to encapsulate plain text in span elements to have it replaced.  The new algo is recursive so it can replace any number of child elements.  You could even run it on document.body if you wanted to!
 * Added flir-image and flir-span classnames to the elements flir creates
 * Javascript Plugin support!
 * Moved DetectImageState code from facelift.js into a Javascript plugin
 * querySelectorAll support for the browsers that support it (Safari, FF3.1 alpha)
 * Font size modifier for cSize in FLIRStyle. You can now specify a font size calculation to be applied against the CSS font size.  For example, if you want the generated image to have a font size that is 140% the one you specified in your CSS you could do   cSize:’*1.4'.  All font sizes will then be multipled by 1.4.
 * FLIRStyle.buildURL no longer requires an HTML object to be passed
 * Hover caching problems fixed.  Better hover style support.
 * JPG and GIF support! Set the “output” option in FLIRStyle.  The default output option is auto.  Auto will cause the generated image to be a transparent png if the element doesn’t have a background color set.  Otherwise it will use GIF.
 * Hover now only works with <A> elements.
* Rewrote code for better readability and adherence to code conventions (hopefully)
* Redesigned admin interface to be more logically organized (again, hopefully)
 * Added more helpful information to the configuration text.
* Added ability to specify all elements to replace rather than just the few I had.
* For example you can specify something like h1,h2,div#sidebar a to have your h1, h2 headers and all of the sidebar links replaced.
* Fixed deactivation routine to preserve config-flir.php during auto upgrade.
 * If manually upgrading please deactivate plugin before upgrading to ensure config-flir.php is configured correctly. 

= 0.7.7 =

* Updated Facelift to 1.2b3-3

= 0.7.6 =

* Updated Facelift to 1.2b3-2 

= 0.7.5 =

* Added Facelift FancyFonts plugin option.  FancyFonts uses ImageMagick to render fonts instaed of GD and can be useful 
* Fixed the errant semi-colon issue that everybody keeps telling me about but I kept not seeing for some reason
* Added (hopefully) better text prompts to the admin panel

= 0.7.0 =

* Initialize plugin and set basic settings on install - note: the new version will overwrite your current `config-flir.php`
* Set all `config-flir.php` settings (except allowed domain and font discovery which is done by the plugin)
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
* Auto rendering of `<h1>` to `<h5>` only
* Using Facelift 1.1

== Upcoming Features ==

* Quick Effects (requires ImageMagick) ~v0.9
* More...

== Under consideration ==

* Uploading of fonts from within the plugin

== Development Version ==

* Always the latest code
* May be buggy - actually probably is
* Please remove existing version before installing the development version