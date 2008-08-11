<?php
/*
Facelift Image Replacement v1.1.1

Facelift was written and is maintained by Cory Mawhorter.  
It is available from http://facelift.mawhorter.net/

===

This file is part of Facelife Image Replacement ("FLIR").

FLIR is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

FLIR is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
*/

define('UNKNOWN_FONT_SIZE', 		16); // in pixels

define('CACHE_CLEANUP_FREQ', 		-1); // -1 disable, 1 everytime, 10 would be about 1 in 10 times this script runs (higher number decreases frequency)
define('CACHE_KEEP_TIME', 			604800); // 604800: 7 days

define('CACHE_DIR', 					'cache');
define('FONTS_DIR', 					'fonts');
define('PLUGIN_DIR',					'plugins');

define('HBOUNDS_TEXT', 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'); // see http://facelift.mawhorter.net/docs/

define('FONT_DISCOVERY', 			false);

// Each font you want to use should have an entry in the fonts array.
$fonts = array();
$fonts['tribalbenji'] 	= 'Tribal_Font.ttf';
$fonts['antagea'] 		  = 'Antagea.ttf';
$fonts['illuminating'] 	= 'ArtOfIlluminating.ttf';
$fonts['bentham'] 		  = 'Bentham.ttf';
$fonts['geo'] 				  = 'Geo_Oblique.ttf';
$fonts['puritan'] 		  = 'Puritan_Regular.ttf';
$fonts['konstytucyja'] 	= 'Konstytucyja_1.ttf';
$fonts['promocyja'] 		= 'Promocyja.ttf';
$fonts['stunfilla'] 		= 'OPN_StunFillaWenkay.ttf';
$fonts['animaldings'] 	= 'Animal_Silhouette.ttf';
$fonts['audimat'] 	    = 'AUdimat_Regular.ttf';
$fonts['diavlo'] 		    = 'Diavlo_Book.ttf';
$fonts['existence'] 	  = 'Existence_Light.ttf';
$fonts['qlassik'] 		  = 'Qlassik_TB.ttf';
$fonts['yanone'] 			  = 'YanoneKaffeesatz_Regular.ttf';
$fonts['baars'] 		    = 'baars_sophia.ttf';
$fonts['comfort'] 	    = 'com4t.ttf';
$fonts['cosmetica'] 		= 'MgOpenCosmeticaRegular.ttf';
$fonts['marlon'] 		    = 'Marlonbk.ttf';
$fonts['steiner'] 	    = 'Steinerlight.ttf';

// The font will default to the following (put your most common font here).
$fonts['default'] 		= $fonts['puritan'];

// Set replacement for "web fonts" here
//$fonts['arial'] = $fonts['helvetica'] = $fonts['sans-serif'] 		= $fonts['puritan'];
//$fonts['times new roman'] = $fonts['times'] = $fonts['serif'] 		= $fonts['bentham'];
//$fonts['courier new'] = $fonts['courier'] = $fonts['monospace'] 	= $fonts['geo'];
?>