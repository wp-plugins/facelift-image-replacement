<?php
/*
Sprites v1.0
*/
$SPRITE_MAP = array();

function append_image($src, $img_append) {
	global $SPRITE_MAP, $FLIR, $FStyle;
	
	$img_src = imagecreatefrompng($src);
//	$img_append = imagecreatefrompng($append);
	
	$src_w = imagesx($img_src);
	$src_h = imagesy($img_src);
	$app_w = imagesx($img_append);
	$app_h = imagesy($img_append);
	
	if(isset($_POST['sprites']))
		$height = $src_h+$app_h+10;
	else
		$height = $src_h+$FStyle['mSH'];
	
	$SPRITE_MAP[] = array($src_h, $app_w, $app_h);
	
	$image = imagecreatetruecolor(max($src_w, $app_w), $height);
	
	gd_alpha($image);
	imagefilledrectangle($image, 0, 0, imagesx($image), imagesy($image), imagecolorallocatealpha($image, $FLIR['bkgcolor']['red'], $FLIR['bkgcolor']['green'], $FLIR['bkgcolor']['blue'], 127));
	
	imagecopy($image, $img_src, 		0, 0, 			0, 0, $src_w, $src_h);
	imagecopy($image, $img_append, 	0, $src_h, 	0, 0, $app_w, $app_h);
	
	switch($FLIR['output']) {
		default:
		case 'png':
			 imagepng($image, $src);
			 break;
		case 'gif':
			 imagegif($image, $src);
			 break;
	}

	imagedestroy($img_src);
	imagedestroy($img_append);
	imagedestroy($image);
}

$SPRITE_CACHE = str_replace('.', '-complete.', $FLIR['cache']);
$SPRITE_MAP_CACHE = str_replace('.'.$FLIR['output'], '.txt', $FLIR['cache']);

if(file_exists($SPRITE_CACHE) && file_exists($SPRITE_MAP_CACHE) && !DEBUG) {
	header('X-FLIR-SpriteMap: '.file_get_contents($SPRITE_MAP_CACHE));
	output_file($SPRITE_CACHE);
	exit;
}

if(file_exists($SPRITE_CACHE)) {
	unlink($SPRITE_CACHE);
	$size = $FStyle['mSH'];
	$image = imagecreatetruecolor($size, $size);
	gd_alpha($image);
	imagefilledrectangle($image, 0, 0, imagesx($image), imagesy($image), imagecolorallocatealpha($image, $FLIR['bkgcolor']['red'], $FLIR['bkgcolor']['green'], $FLIR['bkgcolor']['blue'], 127));    
	imagepng($image, $SPRITE_CACHE);	
	imagedestroy($image);
}

$orig_fstyle = $FStyle;
$orig_css = explode('|', $_GET['c']);
$XHRREQ = isset($_POST['sprites']);
$styles = json_decode(($XHRREQ?$_POST['sprites']:$_GET['t']), true);
$mode = 'static';

/*
echo '<pre>';
print_r($_POST);
print_r($styles);
exit;
*/

foreach($styles as $style) {
	$_GET['text'] = urlencode($style['T']);
	unset($style['text']);
	$style['F']['mode'] = $mode;
	$targcss = implode('|',array_merge($CSS, parse_css_codes($style['C'])));

	$url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']).'/generate.php?t='.$_GET['text'].'&c='.$targcss.'&f='.json_encode($style['F']);

	$data  = file_get_contents($url);
	$image = imagecreatefromstring($data);
	append_image($SPRITE_CACHE, $image);
}

// generate hover state
//if($FStyle['hC'] != '') {
	foreach($styles as $style) {
		$_GET['text'] = urlencode($style['T']);
		unset($style['text']);
		$style['F']['mode'] = $mode;
		$targparsedcss = parse_css_codes($style['C']);
		$targparsedcss['color'] = convert_color($style['F']['hC'], true);
		$targcss = implode('|',array_merge($CSS, $targparsedcss));		
	
		$url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']).'/generate.php?t='.$_GET['text'].'&c='.$targcss.'&f='.json_encode($style['F']);
	
		$data  = file_get_contents($url);
		$image = imagecreatefromstring($data);
		append_image($SPRITE_CACHE, $image);
	}
//}

$json = json_encode($SPRITE_MAP);
file_put_contents($SPRITE_MAP_CACHE, $json);
header('X-FLIR-SpriteMap: '.$json);
if($XHRREQ)
	echo $SPRITE_CACHE;
else
	output_file($SPRITE_CACHE);

exit;
?>