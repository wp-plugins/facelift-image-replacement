<?php
/*
Facelift Image Replacement v1.2 beta 3
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

require('config-flir.php');
require('inc-flir.php');

define('DEBUG', false);
define('ENABLE_FONTSIZE_BUG', false);

define('IS_WINDOWS', (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'));

if(version_compare(PHP_VERSION, '4.3.0', '<'))
	die($ERROR_MSGS['PHP_TOO_OLD']);
	
if(false !== ALLOWED_DOMAIN && $_SERVER['HTTP_REFERER'] != '') {
	$refhost = get_hostname($_SERVER['HTTP_REFERER']);
	if(substr(ALLOWED_DOMAIN, 0, 1) == '.') {
		if(false === strpos($refhost, substr(ALLOWED_DOMAIN, 1)))
			die($ERROR_MSGS['DISALLOWED_DOMAIN']);
	}else {
		if($refhost != ALLOWED_DOMAIN) 
			die($ERROR_MSGS['DISALLOWED_DOMAIN']);
	}
}

$fonts_dir = str_replace('\\', '/', realpath(FONTS_DIR.'/'));

if(substr($fonts_dir, -1) != '/')
	$fonts_dir .= '/';

$FLIR = array();
$FStyle = preg_match('#^\{("[\w]+":"[^"]*",?)*\}$#i', $_GET['fstyle'])?json_decode($_GET['fstyle'], true):array();

$FLIR['mode']		= isset($FStyle['mode']) ? $FStyle['mode'] : '';

$FLIR['dpi'] = preg_match('#^[0-9]+$#', $FStyle['dpi']) ? $FStyle['dpi'] : 96;
$FLIR['size'] 	= is_number($FStyle['cSize'], true) ? $FStyle['cSize'] : UNKNOWN_FONT_SIZE; // pixels
$FLIR['size_pts'] = ENABLE_FONTSIZE_BUG ? $FLIR['size'] : round(((72/$FLIR['dpi'])*$FLIR['size']), 2);
$FLIR['maxheight']= is_number($_GET['h']) ? $_GET['h'] : UNKNOWN_FONT_SIZE; // pixels
$FLIR['maxwidth']= is_number($_GET['w']) ? $_GET['w'] : 800; // pixels

$font_file = '';
$FStyle['cFont'] = strtolower($FStyle['cFont']);
if(isset($fonts[$FStyle['cFont']])) {
	$font_file = $fonts[$FStyle['cFont']];
}elseif(FONT_DISCOVERY) {
	$font_file = discover_font($fonts['default'], $FStyle['cFont']);
}else {
	$font_file = $fonts['default'];
}
$FLIR['font'] 	= $fonts_dir.$font_file;

$FLIR['color'] = array();
if(preg_match('#(\(([0-9]{1,3}), ?([0-9]{1,3}), ?([0-9]{1,3})\))#i', $FStyle['cColor'], $m)) {
	$FLIR['color']['red'] 		= $m[2];
	$FLIR['color']['green'] 	= $m[3];
	$FLIR['color']['blue']	 	= $m[4];
}elseif(preg_match('#[a-f0-9]{3}|[a-f0-9]{6}#i', $FStyle['cColor'])) {
		if(strlen($FStyle['cColor']) == 3)
			$FStyle['cColor'] = $FStyle['cColor'][0].$FStyle['cColor'][0].$FStyle['cColor'][1].$FStyle['cColor'][1].$FStyle['cColor'][2].$FStyle['cColor'][2];
			
		$colors 	= explode(',',substr(chunk_split($FStyle['cColor'], 2, ','), 0, -1));
		$FLIR['color']['red'] 		= hexdec($colors[0]);
		$FLIR['color']['green'] 	= hexdec($colors[1]);
		$FLIR['color']['blue']	 	= hexdec($colors[2]);
}else {
	$FLIR['color'] = css2hex($FStyle['cColor']);
}


$FLIR['opacity'] = is_number($FStyle['cOpacity'], true) ? $FStyle['cOpacity']*100 : 100;
if($FLIR['opacity'] > 100 || $FLIR['opacity'] < 0) 
	$FLIR['opacity'] = 100;	

$FLIR['text'] 	= trim($_GET['text'])!=''?$_GET['text']:'null';
$FLIR['text']		= preg_replace_callback('#\%u([a-f0-9]{4})#i', create_function('$m', 'return "&#".hexdec($m[1]).";";'), $FLIR['text']);

$FLIR['cache'] 	= get_cache_fn(md5(($FLIR['mode']=='wrap'?$FLIR['maxwidth']:'').$FLIR['font'].(print_r($FStyle,true).$FLIR['text'])));
if(!file_exists(CACHE_DIR)) @mkdir(CACHE_DIR); // if cache directory doesn't exist, try to create it

$FLIR['text'] = str_replace(array('{amp}', '{plus}'), array('&','+'), $FLIR['text']);

$FLIR['text_encoded'] = $FLIR['text'];
$FLIR['text'] = html_entity_decode_utf8($FLIR['text']);

if(trim($FStyle['cSpacing']) != '') {
	$letter_bounds = convertBoundingBox(imagettfbbox($FLIR['size_pts'], 0, $FLIR['font'], ' '));
	$spaces = ceil(($FStyle['cSpacing']/$letter_bounds['width']));
	if($spaces>0) {
		$FLIR['text'] = space_out($FLIR['text'], $spaces);
		define('SPACING_GAP', $spaces);
	}
}

if(file_exists($FLIR['cache']) && !DEBUG) {
	output_file($FLIR['cache']);
}else {	
	$REAL_HEIGHT_BOUNDS = $FStyle['realFontHeight']=='true' ? convertBoundingBox(imagettfbbox($FLIR['size_pts'], 0, $FLIR['font'], HBOUNDS_TEXT)) : false;
	
	switch($FLIR['mode']) {
		default:
			$dir = dir(PLUGIN_DIR);
			$php_mode = strtolower($FLIR['mode'].'.php');
			while(false !== ($entry = $dir->read())) {
				$p = PLUGIN_DIR.'/'.$entry;
				if(is_dir($p) || $entry == '.' || $entry == '..') continue;
				
				if($php_mode == strtolower($entry)) {
					$dir->close();
					$PLUGIN_ERROR = false;					
					
					include($p);
										
					if(false !== $PLUGIN_ERROR)
						break;
					else
						break(2);
				}
			}
			$dir->close();

			$bounds = convertBoundingBox(imagettfbbox($FLIR['size_pts'], 0, $FLIR['font'], $FLIR['text']));  // second argument '0' is angle of text
			if($FStyle['realFontHeight']!='true') 
				$REAL_HEIGHT_BOUNDS = $bounds;

			if(false === (@$image = imagecreatetruecolor($bounds['width'], $REAL_HEIGHT_BOUNDS['height'])))
				die($ERROR_MSGS['COULD_NOT_CREATE']);
			imagesavealpha($image, true);
			imagealphablending($image, false);
	
			imagefilledrectangle($image, 0, 0, imagesx($image), imagesy($image), gd_bkg());
			
			
			imagettftext($image, $FLIR['size_pts'], 0, $bounds['xOffset'], $REAL_HEIGHT_BOUNDS['yOffset'], gd_color(), $FLIR['font'], $FLIR['text']);
			break;
		case 'wrap':
			if(!is_number($FStyle['cLine'], true))
				$FStyle['cLine'] = 1.0;

			$bounds = convertBoundingBox(imagettfbbox($FLIR['size_pts'], 0, $FLIR['font'], $FLIR['text']));  // second argument '0' is angle of text
			if($FStyle['realFontHeight']!='true') 
				$REAL_HEIGHT_BOUNDS = $bounds;
	
			// if mode is wrap, check to see if text needs to be wrapped, otherwise let continue to progressive
			if($bounds['width'] > $FLIR['maxwidth']) {
				$image = imagettftextbox($FLIR['size_pts'], 0, 0, 0, $FLIR['color'], $FLIR['font'], $FLIR['text'], $FLIR['maxwidth'], strtolower($FStyle['cAlign']), $FStyle['cLine']);
				break;
			}else {
				if(false === (@$image = imagecreatetruecolor($bounds['width'], $REAL_HEIGHT_BOUNDS['height'])))
					die($ERROR_MSGS['COULD_NOT_CREATE']);
				imagesavealpha($image, true);
				imagealphablending($image, false);
		
				imagefilledrectangle($image, 0, 0, imagesx($image), imagesy($image), gd_bkg());
				
				imagettftext($image, $FLIR['size_pts'], 0, $bounds['xOffset'], $REAL_HEIGHT_BOUNDS['yOffset'], gd_color(), $FLIR['font'], $FLIR['text']);
			}
			break;
		case 'progressive':
			$bounds = convertBoundingBox(imagettfbbox($FLIR['size_pts'], 0, $FLIR['font'], $FLIR['text']));  // second argument '0' is angle of text
			if($FStyle['realFontHeight']!='true') 
				$REAL_HEIGHT_BOUNDS = $bounds;
			
			$offset_left = 0;
			
			$nsize=$FLIR['size_pts'];
			while(($REAL_HEIGHT_BOUNDS['height'] > $FLIR['maxheight'] || $bounds['width'] > $FLIR['maxwidth']) && $nsize > 2) {
				$nsize-=0.5;
				$bounds = convertBoundingBox(imagettfbbox($nsize, 0, $FLIR['font'], $FLIR['text']));
				$REAL_HEIGHT_BOUNDS = $FStyle['realFontHeight']=='true' ? convertBoundingBox(imagettfbbox($nsize, 0, $FLIR['font'], HBOUNDS_TEXT)) : $bounds;
			}
			$FLIR['size_pts'] = $nsize;
	
			if(false === (@$image = imagecreatetruecolor($bounds['width'], $REAL_HEIGHT_BOUNDS['height'])))
				die($ERROR_MSGS['COULD_NOT_CREATE']);
			imagesavealpha($image, true);
			imagealphablending($image, false);
	
			imagefilledrectangle($image, $offset_left, 0, imagesx($image), imagesy($image), gd_bkg());
			
			imagettftext($image, $FLIR['size_pts'], 0, $bounds['xOffset'], $REAL_HEIGHT_BOUNDS['yOffset'], gd_color(), $FLIR['font'], $FLIR['text']);
			break;
	}
	
	if(false !== $image) {
		imagepng($image, $FLIR['cache']);
		imagedestroy($image);
	}
	
	output_file($FLIR['cache']);
} // if(file_exists($FLIR['cache'])) {

flush();

if(CACHE_CLEANUP_FREQ != -1 && rand(1, CACHE_CLEANUP_FREQ) == 1)
	@cleanup_cache();
?>