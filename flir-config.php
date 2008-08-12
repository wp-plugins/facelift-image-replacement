			<div id="poststuff" class="actionable">
      	<div class="postbox close-me">
      	<h3><?php _e('FLIR Configuration',"FLIR"); ?>: </h3>
      	<div class="inside">
					<form action="?page=FLIR" method="post" id="flir_config" name="flir_config">
					<table>
					<tr><td><h4>Unknown Font Size</h4></td><td>
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
					</td></tr>
					<tr><td><h4>Cache Cleanup Frequency</h4></td><td>
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
					</td></tr>
					  <tr><td><h4>Cache Keep Time</h4></td><td>
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
					</td></tr>
					  <tr><td><h4>Horizontal Text Bounds</td><td>
					  <input name="horizontal_text_bounds" type="text" value="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz" size="60" maxlength="254" />
					</td></tr>
					  <tr><td><h4>Font Discovery</h4></td><td>
					  <input type="checkbox" name="font_discovery" value="1" />
					</td></tr>
					  <tr><td><h4>JavaScript Method</h4></td><td>
					  <select name="javascript_method">
					    <option value="native">Native</option>
					    <option value="jquery" selected="selected">jQuery</option>
					    <option value="prototype">Prototype</option>
					    <option value="scriptalicious">Scriptalicious</option>
					  </select>
					</td></tr>
					<?php
		$fonts_list = array();

    $flir_font_dir = (dirname(__FILE__)."/facelift/".FONTS_DIR);
		$pattern = "/(\.otf)|(\.ttf)/i";
		$replacepattern = "/(\.otf)|(\.ttf)|(-*_*\d*\s*)/i";
    if ($handle = opendir($flir_font_dir)) {
        while (false !== ($file = readdir($handle))) {
            if (preg_match($pattern, $file)) {
								$newkey = strtolower(preg_replace($replacepattern,'',$file));
                $fonts_list[$newkey] = $file;
            }
        }
        closedir($handle);
    }
					?>
					  <tr><td><h4>Fonts List</h4></td><td>
					  <select name="fonts_list" size="1" multiple="multiple" style="height:150px;">
					  <?php if (!empty($fonts_list)) {foreach ( $fonts_list as $key=>$value) {echo '<option ';/*if ($flir_elements_fonts[7]==$key) echo 'selected="selected" '; */echo 'value="'.$key.'">'.ucfirst($key).' ('.$value.')</option>';}}?>
					  </select>
					</td></tr>
					  <tr><td><h4>Default Font</h4></td><td>
					  <select name="font_default">
						<?php if (!empty($fonts_list)) {foreach ( $fonts_list as $key=>$value) {echo '<option ';/*if ($flir_elements_fonts[7]==$key) echo 'selected="selected" '; */echo 'value="'.$key.'">'.ucfirst($key).' ('.$value.')</option>';}}?>
						</select>
					</td></tr>
					</table>
					<p class="submit"><input type="submit" class="btn" name="save" style="padding:5px 30px 5px 30px;" value="<?php _e('Save FLIR Configuration',"FLIR"); ?>" /></p>
					<input type="hidden" name="action" value="action" /><input type="hidden" name="sub" value="config" />
         </form>
			</div>
			</div>
			</div>