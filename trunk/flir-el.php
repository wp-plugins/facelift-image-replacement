			<div id="poststuff" class="actionable">
      	<div class="postbox close-me">
      	<h3><?php _e('Elements to Replace',"FLIR"); ?>: </h3>
      	<div class="inside">
					<form action="?page=FLIR" method="post" id="flir_elements" name="flir_elements">
<?php 
					if (!empty($this->adminOptions)) {
  					$flir_options        = $this->getAdminOptions($this->adminOptionsName);
  					$flir_elements       = $flir_options['elements'];
					  $flir_elements_fonts = $flir_options['fonts'];
					  $flir_elements_mode  = $flir_options['mode'];
					  $flir_default_mode   = $flir_options['defaultmode'];
					}
?>
						<table class="widefat">
            	<thead>
            		<tr valign="top">
									<th scope="col">Element</th>
									<th scope="col">Use</th>
									<th scope="col">Font</th>
									<th scope="col">Mode</th>
									<th scope="col">Effect</th>
								</tr>
            	</thead>
            <tr>
               <td>Heading 1 <code>&lt;h1&gt;</code></td><td><input type="checkbox" name="flir_elements[1]" value="h1"<?php if ($flir_elements[1]) echo ' checked="checked"';?> /></td><td><select name="flir_element_fonts[1]"><option value="">N/A</option><?php if (!empty($flir_fonts)) {foreach ( $flir_fonts as $key=>$value) {echo '<option ';if ($flir_elements_fonts[1]==$key) echo 'selected="selected" ';echo 'value="'.$key.'">'.ucfirst($key).'</option>';}}?></select></td>
               <td>
                  <select name="flir_mode[1]">
                     <?php if (!empty($flir_modes)) {foreach ( $flir_modes as $value) {echo '<option ';if ($flir_elements_mode[1]==$value) echo 'selected="selected" ';echo 'value="'.$value.'">'.ucfirst($value).'</option>';}}?>
                  </select>
               </td>
               <td>Forthcoming</td>
            </tr>
            <tr>
               <td>Heading 2 <code>&lt;h2&gt;</code></td><td><input type="checkbox" name="flir_elements[2]" value="h2"<?php if ($flir_elements[2]) echo ' checked="checked"';?> /></td><td><select name="flir_element_fonts[2]"><option value="">N/A</option><?php if (!empty($flir_fonts)) {foreach ( $flir_fonts as $key=>$value) {echo '<option ';if ($flir_elements_fonts[2]==$key) echo 'selected="selected" ';echo 'value="'.$key.'">'.ucfirst($key).'</option>';}}?></select></td>
               <td>
                  <select name="flir_mode[2]">
                     <?php if (!empty($flir_modes)) {foreach ( $flir_modes as $value) {echo '<option ';if ($flir_elements_mode[2]==$value) echo 'selected="selected" ';echo 'value="'.$value.'">'.ucfirst($value).'</option>';}}?>
                  </select>
               </td>
               <td>&nbsp;</td>
            </tr>
            <tr>
               <td>Heading 3 <code>&lt;h3&gt;</code></td><td><input type="checkbox" name="flir_elements[3]" value="h3"<?php if ($flir_elements[3]) echo ' checked="checked"';?> /></td><td><select name="flir_element_fonts[3]"><option value="">N/A</option><?php if (!empty($flir_fonts)) {foreach ( $flir_fonts as $key=>$value) {echo '<option ';if ($flir_elements_fonts[3]==$key) echo 'selected="selected" ';echo 'value="'.$key.'">'.ucfirst($key).'</option>';}}?></select></td>
               <td>
                  <select name="flir_mode[3]">
                     <?php if (!empty($flir_modes)) {foreach ( $flir_modes as $value) {echo '<option ';if ($flir_elements_mode[3]==$value) echo 'selected="selected" ';echo 'value="'.$value.'">'.ucfirst($value).'</option>';}}?>
                  </select>
               </td>
               <td>&nbsp;</td>
            </tr>
            <tr>
               <td>Heading 4 <code>&lt;h4&gt;</code></td><td><input type="checkbox" name="flir_elements[4]" value="h4"<?php if ($flir_elements[4]) echo ' checked="checked"';?> /></td><td><select name="flir_element_fonts[4]"><option value="">N/A</option><?php if (!empty($flir_fonts)) {foreach ( $flir_fonts as $key=>$value) {echo '<option ';if ($flir_elements_fonts[4]==$key) echo 'selected="selected" ';echo 'value="'.$key.'">'.ucfirst($key).'</option>';}}?></select></td>
               <td>
                  <select name="flir_mode[4]">
                     <?php if (!empty($flir_modes)) {foreach ( $flir_modes as $value) {echo '<option ';if ($flir_elements_mode[4]==$value) echo 'selected="selected" ';echo 'value="'.$value.'">'.ucfirst($value).'</option>';}}?>
                  </select>
               </td>
               <td>&nbsp;</td>
            </tr>
            <tr>
               <td>Heading 5 <code>&lt;h5&gt;</code></td><td><input type="checkbox" name="flir_elements[5]" value="h5"<?php if ($flir_elements[5]) echo ' checked="checked"';?> /></td><td><select name="flir_element_fonts[5]"><option value="">N/A</option><?php if (!empty($flir_fonts)) {foreach ( $flir_fonts as $key=>$value) {echo '<option ';if ($flir_elements_fonts[5]==$key) echo 'selected="selected" ';echo 'value="'.$key.'">'.ucfirst($key).'</option>';}}?></select></td>
               <td>
                  <select name="flir_mode[5]">
                     <?php if (!empty($flir_modes)) {foreach ( $flir_modes as $value) {echo '<option ';if ($flir_elements_mode[5]==$value) echo 'selected="selected" ';echo 'value="'.$value.'">'.ucfirst($value).'</option>';}}?>
                  </select>
               </td>               
               <td>&nbsp;</td>
            </tr>
            <tr>
               <td>Heading 6 <code>&lt;h6&gt;</code></td><td><input type="checkbox" name="flir_elements[6]" value="h6"<?php if ($flir_elements[6]) echo ' checked="checked"';?> /></td><td><select name="flir_element_fonts[6]"><option value="">N/A</option><?php if (!empty($flir_fonts)) {foreach ( $flir_fonts as $key=>$value) {echo '<option ';if ($flir_elements_fonts[6]==$key) echo 'selected="selected" ';echo 'value="'.$key.'">'.ucfirst($key).'</option>';}}?></select></td>
               <td>
                  <select name="flir_mode[6]">
                     <?php if (!empty($flir_modes)) {foreach ( $flir_modes as $value) {echo '<option ';if ($flir_elements_mode[6]==$value) echo 'selected="selected" ';echo 'value="'.$value.'">'.ucfirst($value).'</option>';}}?>
                  </select>
               </td>
               <td>&nbsp;</td>
            </tr>
            <tr>
               <td>Small <code>&lt;small&gt;</code></td><td><input type="checkbox" name="flir_elements[7]" value="small"<?php if ($flir_elements[7]) echo ' checked="checked"';?> /></td><td><select name="flir_element_fonts[7]"><option value="">N/A</option><?php if (!empty($flir_fonts)) {foreach ( $flir_fonts as $key=>$value) {echo '<option ';if ($flir_elements_fonts[7]==$key) echo 'selected="selected" ';echo 'value="'.$key.'">'.ucfirst($key).'</option>';}}?></select></td>
               <td>
                  <select name="flir_mode[7]">
                     <?php if (!empty($flir_modes)) {foreach ( $flir_modes as $value) {echo '<option ';if ($flir_elements_mode[7]==$value) echo 'selected="selected" ';echo 'value="'.$value.'">'.ucfirst($value).'</option>';}}?>
                  </select>
               </td>
               <td>&nbsp;</td>
            </tr>
            <tr>
               <td>Strong / Bold <code>&lt;strong&gt;</code></td><td><input type="checkbox" name="flir_elements[8]" value="strong"<?php if ($flir_elements[8]) echo ' checked="checked"';?> /></td><td><select name="flir_element_fonts[8]"><option value="">N/A</option><?php if (!empty($flir_fonts)) {foreach ( $flir_fonts as $key=>$value) {echo '<option ';if ($flir_elements_fonts[8]==$key) echo 'selected="selected" ';echo 'value="'.$key.'">'.ucfirst($key).'</option>';}}?></select></td>
               <td>
                  <select name="flir_mode[8]">
                     <?php if (!empty($flir_modes)) {foreach ( $flir_modes as $value) {echo '<option ';if ($flir_elements_mode[8]==$value) echo 'selected="selected" ';echo 'value="'.$value.'">'.ucfirst($value).'</option>';}}?>
                  </select>
               </td>
               <td>&nbsp;</td>
            </tr>
            <tr>
               <td>Emphasis / Italic <code>&lt;em&gt;</code></td><td><input type="checkbox" name="flir_elements[9]" value="em"<?php if ($flir_elements[9]) echo ' checked="checked"';?> /></td><td><select name="flir_element_fonts[9]"><option value="">N/A</option><?php if (!empty($flir_fonts)) {foreach ( $flir_fonts as $key=>$value) {echo '<option ';if ($flir_elements_fonts[9]==$key) echo 'selected="selected" ';echo 'value="'.$key.'">'.ucfirst($key).'</option>';}}?></select></td>
               <td>
                  <select name="flir_mode[9]">
                     <?php if (!empty($flir_modes)) {foreach ( $flir_modes as $value) {echo '<option ';if ($flir_elements_mode[9]==$value) echo 'selected="selected" ';echo 'value="'.$value.'">'.ucfirst($value).'</option>';}}?>
                  </select>
               </td>
               <td>&nbsp;</td>
            </tr>
         </table>
         <h4><?php _e('Default Mode',"FLIR"); ?>: </h4>
                  <select name="flir_default_mode">
                     <?php if (!empty($flir_modes)) {foreach ( $flir_modes as $value) {echo '<option ';if ($flir_default_mode==$value) echo 'selected="selected" ';echo 'value="'.$value.'">'.ucfirst($value).'</option>';}}?>
                  </select>
         <p class="submit"><input type="submit" class="btn" name="save" style="padding:5px 30px 5px 30px;" value="<?php _e('Save Element Configuration',"FLIR"); ?>" /></p>
				<input type="hidden" name="action" value="action" /><input type="hidden" name="sub" value="elements" />
         </form>
			</div>
			</div>
			</div>