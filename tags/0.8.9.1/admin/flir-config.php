			<div id="poststuff" class="flir">
      	<div class="postbox">
      	<h3><?php _e('About FLIR for WordPress',"FLIR"); ?>: </h3>
      	<div class="inside">
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="float:right;"> <input name="cmd" type="hidden" value="_donations" /> <input name="business" type="hidden" value="dzappone@gmail.com" /> <input name="item_name" type="hidden" value="Dan Zappone" /> <input name="item_number" type="hidden" value="23SDONWP" /> <input name="no_shipping" type="hidden" value="0" /> <input name="no_note" type="hidden" value="1" /> <input name="currency_code" type="hidden" value="EUR" /> <input name="tax" type="hidden" value="0" /> <input name="lc" type="hidden" value="US" /> <input name="bn" type="hidden" value="PP-DonationsBF" /> <input alt="PayPal - The safer, easier way to pay online!" name="submit" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" type="image" /> <img src="https://www.paypal.com/en_US/i/scr/pixel.gif" border="0" alt="" width="1" height="1" />
</form>
 				<h5><?php _e( 'Thank you for downloading and installing FLIR for WordPress<br /><br /><a href="http://www.23systems.net/plugins/facelift-image-replacement-flir/">Visit plugin site</a> | <a href="http://www.23systems.net/plugins/facelift-image-replacement-flir/frequently-asked-questions/">FAQ</a> | <a href="http://www.23systems.net/bbpress/forum/facelift-image-replacement">Support</a> | <a href="http://twitter.com/23systems">Follow on Twitter</a> | <a href="http://www.facebook.com/pages/Austin-TX/23Systems-Web-Devsign/94195762502">Add Facebook Page</a>','FLIR' ); ?></h5>
					<?php _e( 'Like many developers I spend a lot of my spare time working on WordPress plugins and themes and any donation to the cause is appreciated.  I know a lot of other developers do the same and I try to donate to them whenever I can.  As a developer I greatly appreciate any donation you can make to help support further development of quality plugins and themes for WordPress.  <em>You have my sincere thanks and appreciation for using FLIR ofr WordPress</em>.','FLIR' ); ?>
						</div>
			</div>
			</div>                                                                


			<div id="poststuff" class="flir">
      	<div class="postbox">
      	<h3><?php _e('FLIR for WordPress Settings',"FLIR"); ?>: </h3>
      	<div class="inside">
					<form action="?page=FLIR" method="post" id="flir_config" name="flir_config">
<?php 
					if (!empty($this->adminConfig)) {
  					$flirConfig         		= $this->getAdminOptions($this->adminConfigName);
	          $unknownFontSize        = $flirConfig['unknown_font_size'];
	          $cacheCleanupFrequency  = $flirConfig['cache_cleanup_frequency'];
	          $cacheKeepTime          = $flirConfig['cache_keep_time'];
	          $cacheSingleDir         = $flirConfig['cache_single_dir'];
	          $horizontalTextBounds   = $flirConfig['horizontal_text_bounds'];
	          $javascriptMethod       = $flirConfig['javascript_method'];
	          $externalJavaScript     = $flirConfig['external_javascript'];
	          $fontsList              = $flirConfig['fonts_list'];
	          $fontDefault            = $flirConfig['font_default'];
	          $imagemagickPath        = $flirConfig['imagemagick_path'];
	          $dropIE                 = $flirConfig['drop_ie'];
	          $elementList            = $flirConfig['element_types'];
					}
?>
					<table class="form-table">
					<tr valign="top"><th scope="row"><strong><?php _e('Unknown Font Size',"FLIR"); ?>: 
            </strong></th><td valign="top">
  					<select name="unknown_font_size">
  					  <option value="6"<?php if ($unknownFontSize=='6') echo ' selected="selected"'?>>6 pixels</option>
  					  <option value="8"<?php if ($unknownFontSize=='8') echo ' selected="selected"'?>>8 pixels</option>
  					  <option value="9"<?php if ($unknownFontSize=='9') echo ' selected="selected"'?>>9 pixels</option>
  					  <option value="10"<?php if ($unknownFontSize=='10') echo ' selected="selected"'?>>10 pixels</option>
  					  <option value="11"<?php if ($unknownFontSize=='11') echo ' selected="selected"'?>>11 pixels</option>
  					  <option value="12"<?php if ($unknownFontSize=='12') echo ' selected="selected"'?>>12 pixels</option>
  					  <option value="14"<?php if ($unknownFontSize=='14') echo ' selected="selected"'?>>14 pixels</option>
  					  <option value="16"<?php if ($unknownFontSize=='16') echo ' selected="selected"'?>>16 pixels</option>
  					  <option value="18"<?php if ($unknownFontSize=='18') echo ' selected="selected"'?>>18 pixels</option>
  					  <option value="20"<?php if ($unknownFontSize=='20') echo ' selected="selected"'?>>20 pixels</option>
  					  <option value="24"<?php if ($unknownFontSize=='24') echo ' selected="selected"'?>>24 pixels</option>
  					  <option value="30"<?php if ($unknownFontSize=='30') echo ' selected="selected"'?>>30 pixels</option>
  					  <option value="36"<?php if ($unknownFontSize=='36') echo ' selected="selected"'?>>36 pixels</option>
  					  <option value="48"<?php if ($unknownFontSize=='48') echo ' selected="selected"'?>>48 pixels</option>
  					  <option value="60"<?php if ($unknownFontSize=='60') echo ' selected="selected"'?>>60 pixels</option>
  					  <option value="72"<?php if ($unknownFontSize=='72') echo ' selected="selected"'?>>72 pixels</option>
  					  <option value="84"<?php if ($unknownFontSize=='84') echo ' selected="selected"'?>>84 pixels</option>
  					  <option value="96"<?php if ($unknownFontSize=='96') echo ' selected="selected"'?>>96 pixels</option>
  					  <option value="108"<?php if ($unknownFontSize=='108') echo ' selected="selected"'?>>108 pixels</option>
  					  <option value="120"<?php if ($unknownFontSize=='120') echo ' selected="selected"'?>>120 pixels</option>
  					  <option value="132"<?php if ($unknownFontSize=='132') echo ' selected="selected"'?>>132 pixels</option>
  					  <option value="144"<?php if ($unknownFontSize=='144') echo ' selected="selected"'?>>144 pixels</option>
  					  <option value="156"<?php if ($unknownFontSize=='156') echo ' selected="selected"'?>>156 pixels</option>
  					  <option value="168"<?php if ($unknownFontSize=='168') echo ' selected="selected"'?>>168 pixels</option>
  					  <option value="180"<?php if ($unknownFontSize=='180') echo ' selected="selected"'?>>180 pixels</option>
  					</select>
  					<a class="flir-info" title="<?php _e('Click for Help!', 'FLIR')?>" onclick="toggleVisibility('flir_unknown_font_size_tip');"><img src="<?php echo $g_flir_url.'/css/information.png'?>" alt="<?php _e('Click for Help!', 'FLIR'); ?>" /></a>
						<div class="flir-tip" id="flir_unknown_font_size_tip">
              <?php _e('If the font size cannot be determined automatically the font size will default to this (in pixels).<br /><strong><em>Default: 16</em></strong>',"FLIR"); ?></div>
            </td>
					</tr>
					
          <tr valign="top"><th scope="row"><strong><?php _e('Cache Cleanup Frequency',"FLIR"); ?>: </strong></th><td valign="top">
					<select name="cache_cleanup_frequency">
					  <option value="-1"<?php if ($cacheCleanupFrequency=='-1') echo ' selected="selected"'?>>Never</option>
					  <option value="1"<?php if ($cacheCleanupFrequency=='1') echo ' selected="selected"'?>>Every time</option>
					  <option value="2"<?php if ($cacheCleanupFrequency=='2') echo ' selected="selected"'?>>Every other time</option>
					  <option value="5"<?php if ($cacheCleanupFrequency=='5') echo ' selected="selected"'?>>Every 5 times</option>
					  <option value="10"<?php if ($cacheCleanupFrequency=='10') echo ' selected="selected"'?>>Every 10 times</option>
					  <option value="20"<?php if ($cacheCleanupFrequency=='20') echo ' selected="selected"'?>>Every 20 times</option>
					  <option value="50"<?php if ($cacheCleanupFrequency=='50') echo ' selected="selected"'?>>Every 50 times</option>
					  <option value="100"<?php if ($cacheCleanupFrequency=='100') echo ' selected="selected"'?>>Every 100 times</option>
					  <option value="250"<?php if ($cacheCleanupFrequency=='250') echo ' selected="selected"'?>>Every 250 times</option>
					  <option value="500"<?php if ($cacheCleanupFrequency=='500') echo ' selected="selected"'?>>Every 500 times</option>
					  <option value="1000"<?php if ($cacheCleanupFrequency=='1000') echo ' selected="selected"'?>>Every 1000 times</option>
					  <option value="2500"<?php if ($cacheCleanupFrequency=='2500') echo ' selected="selected"'?>>Every 2500 times</option>
					  <option value="5000"<?php if ($cacheCleanupFrequency=='5000') echo ' selected="selected"'?>>Every 5000 times</option>
					  <option value="10000"<?php if ($cacheCleanupFrequency=='10000') echo ' selected="selected"'?>>Every 10000 times</option>
					</select>
					<a class="flir-info" title="<?php _e('Click for Help!', 'FLIR')?>" onclick="toggleVisibility('flir_cache_cleanup_frequency_tip');"><img src="<?php echo $g_flir_url.'/css/information.png'?>" alt="<?php _e('Click for Help!', 'FLIR'); ?>" /></a>
					<div class="flir-tip" id="flir_cache_cleanup_frequency_tip"><?php _e('All generated images are cached. If you have a large site with many different bits of text being replaced, this may lead to a lot of old, outdated images in the cache.  This will allow you to specify how often to run the cache cleanup in relation to how often FLIR is executed.<br /><strong><em>Default: Never</em></strong>',"FLIR"); ?></div></td>
					</tr>
					
          <tr valign="top"><th scope="row"><strong><?php _e('Cache Keep Time',"FLIR"); ?>: </strong></th><td valign="top">
					  <select name="cache_keep_time">
					    <option value="600"<?php if ($cacheKeepTime=='600') echo ' selected="selected"'?>>10 Minutes</option>
					    <option value="3600"<?php if ($cacheKeepTime=='3600') echo ' selected="selected"'?>>1 hour</option>
					    <option value="21600"<?php if ($cacheKeepTime=='21600') echo ' selected="selected"'?>>6 hours</option>
					    <option value="43200"<?php if ($cacheKeepTime=='43200') echo ' selected="selected"'?>>12 Hours</option>
					    <option value="86400"<?php if ($cacheKeepTime=='86400') echo ' selected="selected"'?>>1 Day</option>
					    <option value="172800"<?php if ($cacheKeepTime=='172800') echo ' selected="selected"'?>>2 Days</option>
					    <option value="259200"<?php if ($cacheKeepTime=='259200') echo ' selected="selected"'?>>3 Days</option>
					    <option value="604800"<?php if ($cacheKeepTime=='604800') echo ' selected="selected"'?>>1 Week</option>
					    <option value="1209600"<?php if ($cacheKeepTime=='1209600') echo ' selected="selected"'?>>2 Weeks</option>
					    <option value="2592000"<?php if ($cacheKeepTime=='2592000') echo ' selected="selected"'?>>1 Month</option>
					    <option value="15768000"<?php if ($cacheKeepTime=='15768000') echo ' selected="selected"'?>>6 Months</option>
					    <option value="31536000"<?php if ($cacheKeepTime=='31536000') echo ' selected="selected"'?>>1 Year</option>
					  </select>
					  <a class="flir-info" title="<?php _e('Click for Help!', 'FLIR')?>" onclick="toggleVisibility('flir_cache_keep_time_tip');"><img src="<?php echo $g_flir_url.'/css/information.png'?>" alt="<?php _e('Click for Help!', 'FLIR'); ?>" /></a>
					  <div class="flir-tip" id="flir_cache_keep_time_tip"><?php _e('When the cache cleanup runs, cached images that are older than the time provided here will be deleted (Unix timestamp).  This setting is irrelvent when Cache Cleanup Frequency is disabled.<br /><strong><em>Default: 1 Week</em></strong>',"FLIR"); ?></div></td>
					</tr>
					
          <tr valign="top"><th scope="row"><strong><?php _e('Single Directory Cache',"FLIR"); ?>: </strong></th><td valign="top">
					  <input type="checkbox" name="cache_single_dir" value="true"<?php if($cacheSingleDir == 'true') {echo ' checked="checked"';}?> />
					  <a class="flir-info" title="<?php _e('Click for Help!', 'FLIR')?>" onclick="toggleVisibility('flir_cache_single_dir_tip');"><img src="<?php echo $g_flir_url.'/css/information.png'?>" alt="<?php _e('Click for Help!', 'FLIR'); ?>" /></a>
					  <div class="flir-tip" id="flir_cache_single_dir_tip"><?php _e('Check this to not create sub-directories to store cached files (good for small sites)<br /><strong><em>Default: unchecked</em></strong>',"FLIR"); ?></div></td>
					</tr>
					
          <tr valign="top"><th scope="row"><strong><?php _e('Horizontal Text Bounds',"FLIR"); ?>: </strong></th><td valign="top">
					  <input name="horizontal_text_bounds" type="text" value="<?php if (empty($horizontalTextBounds)) { echo 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz[]{}()_'; } else {echo $horizontalTextBounds;}?>" size="32" maxlength="254" />
					  <a class="flir-info" title="<?php _e('Click for Help!', 'FLIR')?>" onclick="toggleVisibility('flir_horizontal_text_bounds_tip');"><img src="<?php echo $g_flir_url.'/css/information.png'?>" alt="<?php _e('Click for Help!', 'FLIR'); ?>" /></a>
					  <div class="flir-tip" id="flir_horizontal_text_bounds_tip"><?php _e('This will only be used if some fonts have characters that will extend below the baseline. For example, p, q, or y all have tails that extend below the baseline.  The text will be used to attempt to figure out the lowest and highest point of all the characters. This will create a uniform height across all generated images for a particular font size.  You should not have to change this value unless you are working in a language that does not use the a-z alphabet or you are using a highly unusual font.<br /><strong><em>Default: A-Za-z</em></strong>',"FLIR"); ?></div></td>
					</tr>
					
<!--			<tr valign="top"><th scope="row"><strong><?php// _e('Font Discovery',"FLIR"); ?>: </strong></th>
						<td valign="top">
							<input type="checkbox" name="font_discovery" value="1" />
						<br /><?php _e('If the font size cannot be determined automatically the size will default to this (in pixels).',"FLIR"); ?></td>
					</tr>  -->
					
          <tr valign="top"><th scope="row"><strong><?php _e('JavaScript Method',"FLIR"); ?>: </strong></th><td valign="top">
						<select name="javascript_method">
					    <option value="automatic"<?php if ($javascriptMethod=='automatic') echo ' selected="selected"'?>>Automatic</option>
					    <option value="jquery"<?php if ($javascriptMethod=='jquery') echo ' selected="selected"'?>>jQuery</option>
					    <option value="prototype"<?php if ($javascriptMethod=='prototype') echo ' selected="selected"'?>>Prototype</option>
					    <option value="scriptaculous"<?php if ($javascriptMethod=='scriptaculous') echo ' selected="selected"'?>>Scriptaculous</option>
					  </select>
					  <input type="checkbox" name="external_javascript" value="1"<?php if($externalJavaScript == 1) {echo ' checked="checked"';}?> /> Use external JavaScript library.
            <a class="flir-info" title="<?php _e('Click for Help!', 'FLIR')?>" onclick="toggleVisibility('flir_javascript_method_tip');"><img src="<?php echo $g_flir_url.'/css/information.png'?>" alt="<?php _e('Click for Help!', 'FLIR'); ?>" /></a> 
						<div class="flir-tip" id="flir_javascript_method_tip"><?php _e('Choose <em>Automatic</em> or one of three JavaScript libraries to assist in the rendering.  <em>jQuery</em> seems to be the fastest but you may already be loading the <em>prototype</em> or <em>scriptaculous</em> librares and prefer one of those to minimize overhead.  <em>Automatic</em> does not use any JavaScript library but will automatically replace all the elements specified in Element Types below using the default font.<br /><strong style="color:#900"><em>Note: if you wish to specify which elements to replace or use FancyFonts you must use a method other than Automatic.</em></strong><br /><strong><em>Default: Automatic</em></strong>',"FLIR"); ?></div></td>
					</tr>
					
					<?php
		$baseFontsList   = array();
		$pattern        = "/(\.otf)|(\.ttf)/i";
		$replacePattern = "/(\.otf)|(\.ttf)|(-*_*\d*\s*)/i";
		if ($handle = opendir($g_facelift_fonts_path)) {
		  while (false !== ($file = readdir($handle))) {
		    if (preg_match($pattern, $file)) {
		      $newKey = $this->keyMaker($file);
		      $baseFontsList[$newKey] = $file;
		    }
		  }
		  closedir($handle);
		}
					?>
					<tr valign="top"><th scope="row"><strong><?php _e('Fonts List',"FLIR"); ?>: </strong></th><td valign="top">
					  <select name="fonts_list[]" size="8" multiple="multiple" style="height:120px;">
					  <?php if (!empty($baseFontsList)) {foreach ( $baseFontsList as $key=>$value) {echo '<option ';if ($this->setSelected($value,$fontsList)) echo 'selected="selected" '; echo 'value="'.$value.'">'.ucfirst($key).' ('.$value.')</option>'.$this->eol;}}?>
					  </select>
					  <a class="flir-info" title="<?php _e('Click for Help!', 'FLIR')?>" onclick="toggleVisibility('flir_fonts_list_tip');"><img src="<?php echo $g_flir_url.'/css/information.png'?>" alt="<?php _e('Click for Help!', 'FLIR'); ?>" /></a>
						<div class="flir-tip" id="flir_fonts_list_tip"><?php _e('This lists all the fonts in the <code>facelift/fonts</code> directory by font array key name and font name. If you ahve a lot of fonts you can use CTRL+Click to choose a smaller selection of fonts to use in the Elements to Replace section.<br /><strong><em>Default: All fonts in font directory</em></strong>',"FLIR"); ?></div></td>
					</tr>
					
					<tr valign="top"><th scope="row"><strong><?php _e('Default Font',"FLIR"); ?>: </strong></th><td valign="top">
					  <select name="font_default">
						<?php if (!empty($baseFontsList)) {foreach ( $baseFontsList as $key=>$value) {echo '<option ';if ($fontDefault==$value) echo 'selected="selected" '; echo 'value="'.$value.'">'.ucfirst($key).' ('.$value.')</option>'.$this->eol;}}?>
						</select>
						<a class="flir-info" title="<?php _e('Click for Help!', 'FLIR')?>" onclick="toggleVisibility('flir_font_default_tip');"><img src="<?php echo $g_flir_url.'/css/information.png'?>" alt="<?php _e('Click for Help!', 'FLIR'); ?>" /></a>
						<div class="flir-tip" id="flir_font_default_tip"><?php _e('If the font cannot be determined automatically or is not specified in the Elements to Replace section the rendered font will default to the one selected here.<br /><strong><em>Default: First font in font directory</em></strong>',"FLIR"); ?></div></td>
					</tr>
					
					<tr valign="top"><th scope="row"><strong><?php _e('ImageMagick Path',"FLIR"); ?>: </strong></th><td valign="top">
					  <input name="imagemagick_path" type="text" value="<?php if (empty($imagemagickPath)) { echo '/usr/bin/'; } else {echo $imagemagickPath;}?>" size="32" maxlength="254" />
					  <a class="flir-info" title="<?php _e('Click for Help!', 'FLIR')?>" onclick="toggleVisibility('flir_imagemagick_path_tip');"><img src="<?php echo $g_flir_url.'/css/information.png'?>" alt="<?php _e('Click for Help!', 'FLIR'); ?>" /></a>
					  <div class="flir-tip" id="flir_imagemagick_path_tip"><?php _e('Set this to the location of your ImageMagick binaries (with a trailing slash).  Required only if you are using Fancy Fonts or Quick Effects (see <a href="http://facelift.mawhorter.net/doc/plugins" title="Facelift Plugins" target="_blank">Facelift Plugins</a> for more details.)<br /><strong><em>Default: /usr/bin/</em></strong>',"FLIR"); ?></div></td>
					</tr>
					
					<tr valign="top"><th scope="row"><strong><?php _e('Disable FLIR for IE 6',"FLIR"); ?>: </strong></th><td valign="top">
					  <input type="checkbox" name="drop_ie" value="1"<?php if($dropIE == 1) {echo ' checked="checked"';}?> />
					  <a class="flir-info" title="<?php _e('Click for Help!', 'FLIR')?>" onclick="toggleVisibility('flir_drop_ie_tip');"><img src="<?php echo $g_flir_url.'/css/information.png'?>" alt="<?php _e('Click for Help!', 'FLIR'); ?>" /></a>
					  <div class="flir-tip" id="flir_drop_ie_tip"><?php _e('Check this to disable for IE 6<br /><strong><em>Default: unchecked</em></strong>',"FLIR"); ?></div></td>
					</tr>
					
					<tr valign="top"><th scope="row"><strong><?php _e('Element Types to Replace',"FLIR"); ?>: </strong></th><td valign="top">
					  <input name="element_types" type="text" value="<?php if (empty($elementList)) { echo 'h1,h2,h3,h4,h5'; } else {echo implode(",", $elementList);}?>" size="32" maxlength="254" />
					  <a class="flir-info" title="<?php _e('Click for Help!', 'FLIR')?>" onclick="toggleVisibility('flir_element_types_tip');"><img src="<?php echo $g_flir_url.'/css/information.png'?>" alt="<?php _e('Click for Help!', 'FLIR'); ?>"  /></a>
					  <div class="flir-tip" id="flir_element_types_tip"><?php _e('This list the elements to replace. If using Automatic the default font will be used for all elements.  If using jQuery, Scriptaculous or Prototype you can specify specific fonts and modes in the <strong>Elements to Replace</strong> section, which will only appear if using a JavaScript method other than Automatic. You can also specify more granular elements to replace such as <code>div#sidebar a</code> to replace the links in your sidebar.<em>Remove elements you do not intend to replace.</em><br /><strong><em>Example: h1,h2,h3,h4,h5,h6,small,blockquote,div#postinfo,p.date,div#sidebar a</em></strong>',"FLIR"); ?></div></td>
					</tr>
					
					</table>
					<p class="submit"><input type="submit" class="btn" name="save" style="padding:5px 30px 5px 30px;" value="<?php _e('Save FLIR Configuration',"FLIR"); ?>" /></p>
					<input type="hidden" name="action" value="action" /><input type="hidden" name="sub" value="config" />
         </form>
						</div>
			</div>
			</div>