			<div id="poststuff" class="flir">
      	<div class="postbox close-me">
      	<h3><?php _e('FLIR Configuration',"FLIR"); ?>: </h3>
      	<div class="inside">
					<form action="?page=FLIR" method="post" id="flir_config" name="flir_config">
<?php 
					if (!empty($this->adminConfig)) {
  					$flir_config         		      = $this->getAdminOptions($this->adminConfigName);
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
					  <option value="6"<?php if ($flir_unknown_font_size=='6') echo ' selected="selected"'?>>6 pixels</option>
					  <option value="8"<?php if ($flir_unknown_font_size=='8') echo ' selected="selected"'?>>8 pixels</option>
					  <option value="9"<?php if ($flir_unknown_font_size=='9') echo ' selected="selected"'?>>9 pixels</option>
					  <option value="10"<?php if ($flir_unknown_font_size=='10') echo ' selected="selected"'?>>10 pixels</option>
					  <option value="11"<?php if ($flir_unknown_font_size=='11') echo ' selected="selected"'?>>11 pixels</option>
					  <option value="12"<?php if ($flir_unknown_font_size=='12') echo ' selected="selected"'?>>12 pixels</option>
					  <option value="14"<?php if ($flir_unknown_font_size=='14') echo ' selected="selected"'?>>14 pixels</option>
					  <option value="16"<?php if ($flir_unknown_font_size=='16') echo ' selected="selected"'?>>16 pixels</option>
					  <option value="18"<?php if ($flir_unknown_font_size=='18') echo ' selected="selected"'?>>18 pixels</option>
					  <option value="20"<?php if ($flir_unknown_font_size=='20') echo ' selected="selected"'?>>20 pixels</option>
					  <option value="24"<?php if ($flir_unknown_font_size=='24') echo ' selected="selected"'?>>24 pixels</option>
					  <option value="30"<?php if ($flir_unknown_font_size=='30') echo ' selected="selected"'?>>30 pixels</option>
					  <option value="36"<?php if ($flir_unknown_font_size=='36') echo ' selected="selected"'?>>36 pixels</option>
					  <option value="48"<?php if ($flir_unknown_font_size=='48') echo ' selected="selected"'?>>48 pixels</option>
					  <option value="60"<?php if ($flir_unknown_font_size=='60') echo ' selected="selected"'?>>60 pixels</option>
					  <option value="72"<?php if ($flir_unknown_font_size=='72') echo ' selected="selected"'?>>72 pixels</option>
					  <option value="84"<?php if ($flir_unknown_font_size=='84') echo ' selected="selected"'?>>84 pixels</option>
					  <option value="96"<?php if ($flir_unknown_font_size=='96') echo ' selected="selected"'?>>96 pixels</option>
					  <option value="108"<?php if ($flir_unknown_font_size=='108') echo ' selected="selected"'?>>108 pixels</option>
					  <option value="120"<?php if ($flir_unknown_font_size=='120') echo ' selected="selected"'?>>120 pixels</option>
					  <option value="132"<?php if ($flir_unknown_font_size=='132') echo ' selected="selected"'?>>132 pixels</option>
					  <option value="144"<?php if ($flir_unknown_font_size=='144') echo ' selected="selected"'?>>144 pixels</option>
					  <option value="156"<?php if ($flir_unknown_font_size=='156') echo ' selected="selected"'?>>156 pixels</option>
					  <option value="168"<?php if ($flir_unknown_font_size=='168') echo ' selected="selected"'?>>168 pixels</option>
					  <option value="180"<?php if ($flir_unknown_font_size=='180') echo ' selected="selected"'?>>180 pixels</option>
					</select>
						</td><td valign="top"><small><?php _e('If the font size cannot be determined automatically the font size will default to this (in pixels).<br /><strong><em>Default: 16</em></strong>',"FLIR"); ?></small></td>
					</tr>
					<tr><td valign="top"><strong><?php _e('Cache Cleanup Frequency',"FLIR"); ?>: </strong></td><td valign="top">
					<select name="cache_cleanup_frequency">
					  <option value="-1"<?php if ($flir_cache_cleanup_frequency=='-1') echo ' selected="selected"'?>>Never</option>
					  <option value="1"<?php if ($flir_cache_cleanup_frequency=='1') echo ' selected="selected"'?>>Every time</option>
					  <option value="2"<?php if ($flir_cache_cleanup_frequency=='2') echo ' selected="selected"'?>>Every other time</option>
					  <option value="5"<?php if ($flir_cache_cleanup_frequency=='5') echo ' selected="selected"'?>>Every 5 times</option>
					  <option value="10"<?php if ($flir_cache_cleanup_frequency=='10') echo ' selected="selected"'?>>Every 10 times</option>
					  <option value="20"<?php if ($flir_cache_cleanup_frequency=='20') echo ' selected="selected"'?>>Every 20 times</option>
					  <option value="50"<?php if ($flir_cache_cleanup_frequency=='50') echo ' selected="selected"'?>>Every 50 times</option>
					  <option value="100"<?php if ($flir_cache_cleanup_frequency=='100') echo ' selected="selected"'?>>Every 100 times</option>
					  <option value="250"<?php if ($flir_cache_cleanup_frequency=='250') echo ' selected="selected"'?>>Every 250 times</option>
					  <option value="500"<?php if ($flir_cache_cleanup_frequency=='500') echo ' selected="selected"'?>>Every 500 times</option>
					  <option value="1000"<?php if ($flir_cache_cleanup_frequency=='1000') echo ' selected="selected"'?>>Every 1000 times</option>
					  <option value="2500"<?php if ($flir_cache_cleanup_frequency=='2500') echo ' selected="selected"'?>>Every 2500 times</option>
					  <option value="5000"<?php if ($flir_cache_cleanup_frequency=='5000') echo ' selected="selected"'?>>Every 5000 times</option>
					  <option value="10000"<?php if ($flir_cache_cleanup_frequency=='10000') echo ' selected="selected"'?>>Every 10000 times</option>
					</select>
					</td><td valign="top"><small><?php _e('All generated images are cached. If you have a large site with many different bits of text being replaced, this may lead to a lot of old, outdated images in the cache.  This will allow you to specify how often to run the cache cleanup in relation to how often FLIR is executed.<br /><strong><em>Default: Never</em></strong>',"FLIR"); ?></small></td>
					</tr>
					<tr><td valign="top"><strong><?php _e('Cache Keep Time',"FLIR"); ?>: </strong></td><td valign="top">
					  <select name="cache_keep_time">
					    <option value="600"<?php if ($flir_cache_keep_time=='600') echo ' selected="selected"'?>>10 Minutes</option>
					    <option value="3600"<?php if ($flir_cache_keep_time=='3600') echo ' selected="selected"'?>>1 hour</option>
					    <option value="21600"<?php if ($flir_cache_keep_time=='21600') echo ' selected="selected"'?>>6 hours</option>
					    <option value="43200"<?php if ($flir_cache_keep_time=='43200') echo ' selected="selected"'?>>12 Hours</option>
					    <option value="86400"<?php if ($flir_cache_keep_time=='86400') echo ' selected="selected"'?>>1 Day</option>
					    <option value="172800"<?php if ($flir_cache_keep_time=='172800') echo ' selected="selected"'?>>2 Days</option>
					    <option value="259200"<?php if ($flir_cache_keep_time=='259200') echo ' selected="selected"'?>>3 Days</option>
					    <option value="604800"<?php if ($flir_cache_keep_time=='604800') echo ' selected="selected"'?>>1 Week</option>
					    <option value="1209600"<?php if ($flir_cache_keep_time=='1209600') echo ' selected="selected"'?>>2 Weeks</option>
					    <option value="2592000"<?php if ($flir_cache_keep_time=='2592000') echo ' selected="selected"'?>>1 Month</option>
					    <option value="15768000"<?php if ($flir_cache_keep_time=='15768000') echo ' selected="selected"'?>>6 Months</option>
					    <option value="31536000"<?php if ($flir_cache_keep_time=='31536000') echo ' selected="selected"'?>>1 Year</option>
					  </select>
					</td><td valign="top"><small><?php _e('When the cache cleanup runs, cached images that are older than the time provided here will be deleted (Unix timestamp).  This setting is irrelvent when Cache Cleanup Frequency is disabled.<br /><strong><em>Default: 1 Week</em></strong>',"FLIR"); ?></small></td>
					</tr>
					<tr>
						<td valign="top"><strong><?php _e('Horizontal Text Bounds',"FLIR"); ?>: </strong></td><td valign="top">
					  	<input name="horizontal_text_bounds" type="text" value="<?php if (empty($flir_horizontal_text_bounds)) { echo 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; } else {echo $flir_horizontal_text_bounds;}?>" size="38" maxlength="254" />
					  </td><td valign="top"><small><?php _e('This will only be used if some fonts have characters that will extend below the baseline. For example, p, q, or y all have tails that extend below the baseline.  The text will be used to attempt to figure out the lowest and highest point of all the characters. This will create a uniform height across all generated images for a particular font size.  You should not have to change this value unless you are working in a language that does not use the a-z alphabet or you are using a highly unusual font.<br /><strong><em>Default: A-Za-z</em></strong>',"FLIR"); ?></small></td>
					</tr>
<!--					<tr><td valign="top"><strong><?php// _e('Font Discovery',"FLIR"); ?>: </strong></td>
						<td valign="top">
							<input type="checkbox" name="font_discovery" value="1" />
						</td><td valign="top"><small><?php _e('If the font size cannot be determined automatically the size will default to this (in pixels).',"FLIR"); ?></small></td>
					</tr>  -->
					<tr><td valign="top"><strong><?php _e('JavaScript Method',"FLIR"); ?>: </strong></td><td valign="top">
						<select name="javascript_method">
					    <option value="automatic"<?php if ($flir_javascript_method=='automatic') echo ' selected="selected"'?>>Automatic</option>
					    <option value="jquery"<?php if ($flir_javascript_method=='jquery') echo ' selected="selected"'?>>jQuery</option>
					    <option value="prototype"<?php if ($flir_javascript_method=='prototype') echo ' selected="selected"'?>>Prototype</option>
					    <option value="scriptaculous"<?php if ($flir_javascript_method=='scriptaculous') echo ' selected="selected"'?>>Scriptaculous</option>
					  </select>
						</td><td valign="top"><small><?php _e('Choose <em>Automatic</em> or one of three JavaScript libraries to assist in the rendering.  <em>jQuery</em> seems to be the fastest but you may already be loading the <em>prototype</em> or <em>scriptaculous</em> librares and prefer one of those to minimize overhead.  <em>Automatic</em> does not use any JavaScript library but will automatically replace all <code>&lt;h1&gt;</code> to <code>&lt;h5&gt;</code> elements using the default font.<br /><strong><em>Default: jquery</em></strong>',"FLIR"); ?></small></td>
					</tr>
					<?php
		$fonts_list   = array();
		$pattern        = "/(\.otf)|(\.ttf)/i";
		$replacepattern = "/(\.otf)|(\.ttf)|(-*_*\d*\s*)/i";
		if ($handle = opendir($facelift_fonts_path)) {
		  while (false !== ($file = readdir($handle))) {
		    if (preg_match($pattern, $file)) {
		      $newkey = $this->keymaker($file);
		      $fonts_list[$newkey] = $file;
		    }
		  }
		  closedir($handle);
		}
					?>
					  <tr><td valign="top"><strong><?php _e('Fonts List',"FLIR"); ?>: </strong></td><td valign="top">
					  <select name="fonts_list[]" size="8" multiple="multiple" style="height:120px;">
					  <?php if (!empty($fonts_list)) {foreach ( $fonts_list as $key=>$value) {echo '<option ';if ($this->setSelected($value,$flir_fonts_list)) echo 'selected="selected" '; echo 'value="'.$value.'">'.ucfirst($key).' ('.$value.')</option>'.$this->eol;}}?>
					  </select>
						</td><td valign="top"><small><?php _e('This lists all the fonts in the <code>facelift/fonts</code> directory by font array key name and font name. If you ahve a lot of fonts you can use CTRL+Click to choose a smaller selection of fonts to use in the Elements to Replace section.<br /><strong><em>Default: All fonts in font directory</em></strong>',"FLIR"); ?></small></td>
					</tr>
					  <tr><td valign="top"><strong><?php _e('Default Font',"FLIR"); ?>: </strong></td><td valign="top">
					  <select name="font_default">
						<?php if (!empty($fonts_list)) {foreach ( $fonts_list as $key=>$value) {echo '<option ';if ($flir_font_default==$value) echo 'selected="selected" '; echo 'value="'.$value.'">'.ucfirst($key).' ('.$value.')</option>'.$this->eol;}}?>
						</select>
						</td><td valign="top"><small><?php _e('If the font cannot be determined automatically or is not specified in the Elements to Replace section the rendered font will default to the one selected here.<br /><strong><em>Default: First font in font directory</em></strong>',"FLIR"); ?></small></td>
					</tr>
					<tr>
						<td valign="top"><strong><?php _e('ImageMagick Path',"FLIR"); ?>: </strong></td><td valign="top">
					  	<input name="imagemagick_path" type="text" value="<?php if (empty($flir_horizontal_text_bounds)) { echo '/usr/bin/'; } else {echo $flir_imagemagick_path;}?>" size="38" maxlength="254" />
					  </td><td valign="top"><small><?php _e('Set this to the location of your ImageMagick binaries (with a trailing slash).  Required only if you are using Fancy Fonts or Quick Effects (see <a href="http://facelift.mawhorter.net/doc/plugins" title="Facelift Plugins" target="_blank">Facelift Plugins</a> for more details.)<br /><strong><em>Default: /usr/bin/</em></strong>',"FLIR"); ?></small></td>
					</tr>
					</table>
					<p class="submit"><input type="submit" class="btn" name="save" style="padding:5px 30px 5px 30px;" value="<?php _e('Save FLIR Configuration',"FLIR"); ?>" /></p>
					<input type="hidden" name="action" value="action" /><input type="hidden" name="sub" value="config" />
         </form>
			</div>
			</div>
			</div>