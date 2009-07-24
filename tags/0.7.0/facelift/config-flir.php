<?php
/* Facelift Image Replacement v1.2.b2

Auto-Generated by FLIR for WordPress at 2008-08-15 21:40:43

Facelift was written and is maintained by Cory Mawhorter.
It is available from http://facelift.mawhorter.net/  */

define('UNKNOWN_FONT_SIZE', 16); // in pixels

define('CACHE_CLEANUP_FREQ', -1); // -1 disable, 1 everytime, 10 would be about 1 in 10 times this script runs (higher number decreases frequency)
define('CACHE_KEEP_TIME', 604800); // 604800: 7 days
define('CACHE_DIR', 'cache');
define('FONTS_DIR', 'fonts');
define('PLUGIN_DIR', 'plugins');

define('HBOUNDS_TEXT', 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'); // see http://facelift.mawhorter.net/docs/

define('ALLOWED_DOMAIN', false); // ex: 'example.com', 'subdomain.domain.com', '.allsubdomains.com', false disabled
define('FONT_DISCOVERY', false);

define('IM_EXEC_PATH', '/usr/bin/');  // ImageMagick binaries path

// Each font you want to use should have an entry in the fonts array.
$fonts = array();
$fonts['baarssophia'] 	= 'baars_sophia.ttf'; // baarssophia 
$fonts['bluehighwaycond'] 	= 'blue_highway_cond.ttf'; // bluehighwaycond 
$fonts['bluehighwayregular'] 	= 'Blue_Highway_regular.ttf'; // bluehighwayregular 
$fonts['deliciousroman'] 	= 'Delicious_Roman.otf'; // deliciousroman 
$fonts['diavlobook'] 	= 'Diavlo_Book.otf'; // diavlobook 
$fonts['fontinregular'] 	= 'Fontin_Regular.ttf'; // fontinregular 
$fonts['hoperound'] 	= 'HopeRound.ttf'; // hoperound 

// The font will default to the following (put your most common font here).
$fonts['default'] 	= 'baars_sophia.ttf';

// Set replacement for "web fonts" here
//$fonts['arial'] = $fonts['helvetica'] = $fonts['sans-serif'] 		= $fonts['puritan'];
//$fonts['times new roman'] = $fonts['times'] = $fonts['serif'] 		= $fonts['bentham'];
//$fonts['courier new'] = $fonts['courier'] = $fonts['monospace'] 	= $fonts['geo'];
?>