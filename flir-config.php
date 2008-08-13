			<div id="poststuff" class="actionable">
      	<div class="postbox close-me">
      	<h3><?php _e('FLIR Configuration',"FLIR"); ?>: </h3>
      	<div class="inside">
					<form action="?page=FLIR" method="post" id="flir_config" name="flir_config">
<?php 
					if (!empty($this->adminConfig)) {
  					$flir_config         		 = $this->getAdminOptions($this->adminConfigName);
	          $flir_unknown_font_size       = $flir_config['unknown_font_size'];
	          $flir_cache_cleanup_frequency = $flir_config['cache_cleanup_frequency'];
	          $flir_cache_keep_time         = $flir_config['cache_keep_time'];
	          $flir_horizontal_text_bounds  = $flir_config['horizontal_text_bounds'];
	          $flir_javascript_method       = $flir_config['javascript_method'];
	          $flir_fonts_list              = $flir_config['fonts_list'];
	          $flir_font_default            = $flir_config['font_default'];
	          $flir_imagemagick_path        = $flir_config['imagemagick_path'];
					}
?>
					<table>
					<tr><td valign="top"><strong><?php _e('Unknown Font Size',"FLIR"); ?>: </strong></td><td valign="top">
					<select name="unknown_font_size">
					  <option value="6">6</option>
					  <option value="8">8</option>
					  <option value="9">9</option>
					  <option value="10">10</option>
					  <option value="11">11</option>
					  <option value="12">12</option>
					  <option value="14">14</option>
					  <option value="16" selected="selected">16</option>
					  <option value="18">18</option>
					  <option value="20">20</option>
					  <option value="24">24</option>
					  <option value="30">30</option>
					  <option value="36">36</option>
					  <option value="48">48</option>
					  <option value="60">60</option>
					  <option value="72">72</option>
					</select>
						</td><td valign="top"><small><?php _e('If the font size cannot be determined automatically the size will default to this (in pixels).',"FLIR"); ?></small></td>
					</tr>
					<tr><td valign="top"><strong><?php _e('Cache Cleanup Frequency',"FLIR"); ?>: </strong></td><td valign="top">
					<select name="cache_cleanup_frequency">
					  <option value="-1" selected="selected">Never</option>
					  <option value="1">Every time</option>
					  <option value="2">Every other time</option>
					  <option value="5">Every 5 times</option>
					  <option value="10">Every 10 times</option>
					  <option value="20">Every 20 times</option>
					  <option value="50">Every 50 times</option>
					  <option value="100">Every 100 times</option>
					  <option value="250">Every 250 times</option>
					  <option value="500">Every 500 times</option>
					  <option value="1000">Every 1000 times</option>
					  <option value="2500">Every 2500 times</option>
					  <option value="5000">Every 5000 times</option>
					  <option value="10000">Every 10000 times</option>
					</select>
					</td><td valign="top"><small><?php _e('All generated images are cached. If you have a large site with many different bits of text being replaced, this may lead to a lot of old, outdated images in the cache.',"FLIR"); ?></small></td>
					</tr>
					<tr><td valign="top"><strong><?php _e('Cache Keep Time',"FLIR"); ?>: </strong></td><td valign="top">
					  <select name="cache_keep_time">
					    <option value="600">10 Minutes</option>
					    <option value="3600">1 hour</option>
					    <option value="21600">6 hours</option>
					    <option value="43200">12 Hours</option>
					    <option value="86400">1 Day</option>
					    <option value="172800">2 Days</option>
					    <option value="259200">3 Days</option>
					    <option value="604800" selected="selected">1 Week</option>
					    <option value="1209600">2 Weeks</option>
					    <option value="2592000">1 Month</option>
					    <option value="15768000">6 Months</option>
					    <option value="31536000">1 Year</option>
					  </select>
					</td><td valign="top"><small><?php _e('When the cache cleanup runs, cached images that are older than the time provided here will be deleted (Unix timestamp).  This value is not used if Cache Cleanup Frequency is disabled.',"FLIR"); ?></small></td>
					</tr>
					<tr>
						<td valign="top"><strong><?php _e('Horizontal Text Bounds',"FLIR"); ?>: </strong></td><td valign="top">
					  	<input name="horizontal_text_bounds" type="text" value="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz" size="60" maxlength="254" />
					  </td><td valign="top"><small><?php _e('This will only be used if some fonts have characters that will extend below the baseline. For example, p, q, or y all have tails that extend below the baseline.  The text will be used to attempt to figure out the lowest and highest point of all the characters. This will create a uniform height across all generated images for a particular font size.  You should not have to change this value unless you are working in a language that does not use the a-z alphabet.',"FLIR"); ?></small></td>
					</tr>
<!--					<tr><td valign="top"><strong><?php// _e('Font Discovery',"FLIR"); ?>: </strong></td>
						<td valign="top">
							<input type="checkbox" name="font_discovery" value="1" />
						</td><td valign="top"><small><?php _e('If the font size cannot be determined automatically the size will default to this (in pixels).',"FLIR"); ?></small></td>
					</tr>  -->
					<tr><td valign="top"><strong><?php _e('JavaScript Method',"FLIR"); ?>: </strong></td><td valign="top">
						<select name="javascript_method">
					    <option value="native">Native</option>
					    <option value="jquery" selected="selected">jQuery</option>
					    <option value="prototype">Prototype</option>
					    <option value="scriptalicious">Scriptalicious</option>
					  </select>
						</td><td valign="top"><small><?php _e('Choose a JavaScript library to assist in the rendering.  jQuery seems to be the fastest but you may alreay be loading a particular library and prefer that one.',"FLIR"); ?></small></td>
					</tr>
					<?php
		$fonts_list   = array();
		$flir_font_dir  = (dirname(__FILE__)."/facelift/".FONTS_DIR);
		$pattern        = "/(\.otf)|(\.ttf)/i";
		$replacepattern = "/(\.otf)|(\.ttf)|(-*_*\d*\s*)/i";
		if ($handle = opendir($flir_font_dir)) {
		  while (false !== ($file = readdir($handle))) {
		    if (preg_match($pattern, $file)) {
		      $newkey = strtolower(preg_replace($replacepattern, '', $file));
		      $fonts_list[$newkey] = $file;
		    }
		  }
		  closedir($handle);
		}
					?>
					  <tr><td valign="top"><strong><?php _e('Fonts List',"FLIR"); ?>: </strong></td><td valign="top">
					  <select name="fonts_list[]" size="8" multiple="multiple" style="height:120px;">
					  <?php if (!empty($fonts_list)) {foreach ( $fonts_list as $key=>$value) {echo '<option ';if ($flir_fonts_list['comt'] == $key) echo 'selected="selected" '; echo 'value="'.$key.'">'.ucfirst($key).' ('.$value.')</option>';}}?>
					  </select>
						</td><td valign="top"><small><?php _e('All the fonts you have in the fonts directory should be listed here.  Use CTRL+Click to choose which fonts to use.',"FLIR"); ?></small></td>
					</tr>
					  <tr><td valign="top"><strong><?php _e('Default Font',"FLIR"); ?>: </strong></td><td valign="top">
					  <select name="font_default">
						<?php if (!empty($fonts_list)) {foreach ( $fonts_list as $key=>$value) {echo '<option ';/*if ($flir_elements_fonts[7]==$key) echo 'selected="selected" '; */echo 'value="'.$key.'">'.ucfirst($key).' ('.$value.')</option>';}}?>
						</select>
						</td><td valign="top"><small><?php _e('If the font cannot be determined automatically the font will default to this.',"FLIR"); ?></small></td>
					</tr>
					<tr>
						<td valign="top"><strong><?php _e('ImageMagick Path',"FLIR"); ?>: </strong></td><td valign="top">
					  	<input name="imagemagick_path" type="text" value="/usr/bin/" size="60" maxlength="254" />
					  </td><td valign="top"><small><?php _e('Set this to the location of your ImageMagick binaries (with a trailing slash).  Required only if you are using Facelift plugins',"FLIR"); ?></small></td>
					</tr>
					</table>
					<p class="submit"><input type="submit" class="btn" name="save" style="padding:5px 30px 5px 30px;" value="<?php _e('Save FLIR Configuration',"FLIR"); ?>" /></p>
					<input type="hidden" name="action" value="action" /><input type="hidden" name="sub" value="config" />
         </form>
			</div>
			</div>
			</div>
<?php
function select_font_list($thefont,$fontlist) {
	if (!empty($fontlist)) {
		foreach ($fontlist as $key=>$value) {
			if ($key == $thefont) {
				 $ret_value = 'selected="selected"';
			}
			else {
				 $ret_value = '';
			}
		}
	}
	return $ret_value;
}		
?>