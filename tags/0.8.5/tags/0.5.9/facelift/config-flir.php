<?php
/* Facelift Image Replacement v1.1.1

Facelift was written and is maintained by Cory Mawhorter.
It is available from http://facelift.mawhorter.net/  */

define('UNKNOWN_FONT_SIZE', 20); // in pixels

define('CACHE_CLEANUP_FREQ', 10); // -1 disable, 1 everytime, 10 would be about 1 in 10 times this script runs (higher number decreases frequency)
define('CACHE_KEEP_TIME', 604800); // 604800: 7 days
define('CACHE_DIR', 'cache');
define('FONTS_DIR', 'fonts');
define('PLUGIN_DIR', 'plugins');

define('HBOUNDS_TEXT', 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!()'); // see http://facelift.mawhorter.net/docs/

define('FONT_DISCOVERY', false);

define('IM_EXEC_PATH', '/usr/bin/');  // ImageMagick binaries path

// Each font you want to use should have an entry in the fonts array.
$fonts = array();
$fonts['comt'] 	= 'com4t.ttf';
$fonts['diavlobook'] 	= 'Diavlo_Book.ttf';
$fonts['existencelight'] 	= 'Existence_Light.ttf';
$fonts['geooblique'] 	= 'Geo_Oblique.ttf';
$fonts['mgopencosmeticaregular'] 	= 'MgOpenCosmeticaRegular.ttf';
$fonts['puritanregular'] 	= 'Puritan_Regular.ttf';
$fonts['qlassiktb'] 	= 'Qlassik_TB.ttf';

// The font will default to the following (put your most common font here).
$fonts['default'] 	= 'Qlassik_TB.ttf';

// Set replacement for "web fonts" here
//$fonts['arial'] = $fonts['helvetica'] = $fonts['sans-serif'] 		= $fonts['puritan'];
//$fonts['times new roman'] = $fonts['times'] = $fonts['serif'] 		= $fonts['bentham'];
//$fonts['courier new'] = $fonts['courier'] = $fonts['monospace'] 	= $fonts['geo'];
?>
