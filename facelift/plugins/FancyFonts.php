<?php
// JavaScript Document

/*
FancyFonts v0.2.1

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


$PLUGIN_ERROR = false;
define('FULL_CACHE_PATH', fix_path(getcwd().'/'.$FLIR['cache']));
define('CONVERT', IM_EXEC_PATH.'convert');

if(DEBUG && file_exists(FULL_CACHE_PATH))
	unlink(FULL_CACHE_PATH);

$image = false;

if($FLIR['text'][0] == '@') $FLIR['text'] = '\\'.$FLIR['text'];

$bounds = convertBoundingBox(imagettfbbox($FLIR['size_pts'], 0, $FLIR['font'], $FLIR['text']));

$fulltrim = '';
if($FStyle['realFontHeight']!='true') {
	$bounds['height'] += 200;
	$REAL_HEIGHT_BOUNDS = $bounds;	
	$fulltrim = '-trim +repage';
}
	
$fore_hex = dec2hex($FLIR['color']['red'], $FLIR['color']['green'], $FLIR['color']['blue']);
$bkg_hex = dec2hex(abs($FLIR['color']['red']-100), abs($FLIR['color']['green']-100), abs($FLIR['color']['blue']-100));

$opacity = '';
if($FLIR['opacity'] < 100 && $FLIR['opacity'] >= 0)
	$opacity = strlen($FLIR['opacity']) == 1 ? '0'.$FLIR['opacity'] : (strlen($FLIR['opacity'])>2?substr($FLIR['opacity'], 0, 2) : $FLIR['opacity']);

switch($FStyle['cAlign']) {
	default:
		$align = 'east';
		break;
	case '':
		$align = 'west';
		break;
	case '':
		$align = 'center';
		break;
}

$cmd = CONVERT.' -size '.($bounds['width']+500).'x'.$REAL_HEIGHT_BOUNDS['height'].' xc:transparent '
					.' -fill '.escapeshellarg('#'.$fore_hex.$opacity)
					.' -font '.escapeshellarg(fix_path($FLIR['font']))
					.' -density '.$FLIR['dpi'].' -pointsize '.$FLIR['size_pts'].' -gravity '.$align
					.' caption:'.escapeshellarg($FLIR['text'])
					.' -flatten '.$fulltrim.' '.escapeshellarg(FULL_CACHE_PATH); 

//die($cmd);
exec($cmd);

if($FStyle['ff_BlurEdges']=='true') {
	$cmd2 = CONVERT.' '.escapeshellarg(FULL_CACHE_PATH).' -matte -virtual-pixel transparent -channel A -blur 0x0.4  -level 0,50%  '.escapeshellarg(FULL_CACHE_PATH);	
	exec($cmd2);
}


if($FStyle['realFontHeight']=='true') { // trim sides
	/*
		 [0] => PNG 207x71 274x113+4+32
		 [1] => 207
		 [2] => 71
		 [3] => 274
		 [4] => 113
		 [5] => +4
		 [6] => +32
	*/
	
	$info = shell_exec(IM_EXEC_PATH.'convert "'.FULL_CACHE_PATH.'" -trim info:');
	preg_match('#PNG ([0-9]+)x([0-9]+) ([0-9]+)x([0-9]+)([+-][0-9]+)([+-][0-9]+)#', $info, $m);
	
	exec(IM_EXEC_PATH.'convert '.escapeshellarg(FULL_CACHE_PATH).' -crop '.$m[1].'x'.$m[4].$m[5].'+0 +repage '.escapeshellarg(FULL_CACHE_PATH));
}
?>