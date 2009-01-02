<?php 
if (!empty($this->adminConfig)) {
  $flirConfig           = $this->getAdminOptions($this->adminConfigName);
  $fontsList            = $flirConfig['fonts_list'];
  $elementList          = $flirConfig['element_types'];
  $javascriptMethod     = $flirConfig['javascript_method'];
}

if (!empty($this->adminOptions)) {
  $flirOptions          = $this->getAdminOptions($this->adminOptionsName);
  $elementsForFlir      = $flirOptions['elements'];
  $elementFonts         = $flirOptions['fonts'];
  $elementMode          = $flirOptions['mode'];
	$elementFancyFonts    = $flirOptions['fancyfonts'];
	$elementQuickEffect   = $flirOptions['quickeffect'];
  $defaultMode          = $flirOptions['defaultmode'];
  $defaultFancyFonts    = $flirOptions['defaultfancyfonts'];
}
?>
			<div id="poststuff" class="metabox-holder flir" <?php if (strtolower($javascriptMethod) == 'automatic') {echo '"style=display:none;"';}?>>
      	<div class="postbox close-me">
      	<h3><?php _e('Elements to Replace', "FLIR");?>: </h3>
      	<div class="inside">
      	<h4><?php _e('Only used with jQuery, Scriptaculous and Prototype', "FLIR");?>: </h4>
					<form action="?page=FLIR" method="post" id="flir_elements" name="flir_elements">

						<table class="widefat">
            	<thead>
            		<tr valign="top">
									<th scope="col"><?php _e('Element', "FLIR");?></th>
									<th scope="col"><?php _e('Use', "FLIR");?></th>
									<th scope="col"><?php _e('Font', "FLIR");?></th>
									<th scope="col"><?php _e('Mode', "FLIR");?></th>
									<th scope="col"><?php _e('FancyFonts*', "FLIR");?></th>
									<th scope="col"><?php _e('Quick Effects*', "FLIR");?></th>
								</tr>
            	</thead>
<?php
foreach ($elementList as $key => $value) {
  $element_key = $key;
  $element_value = $value?>
            <tr>
               <td><code>&lt;<?php echo $element_value;?>&gt;</code></td>
							 <td><input type="checkbox" name="flir_elements[]" value="<?php echo $element_value;?>"<?php if(!empty($elementsForFlir)) {foreach ($elementsForFlir as $key => $value) {if ($element_value == $value) echo ' checked="checked"';}}?> /></td>
							 <td>
							 	<select name="flir_element_fonts[]">
								 	<option value="">N/A</option><?php if (!empty($fontsList)) {
    foreach ($fontsList as $key => $value) {
      echo '<option ';
      if ($elementFonts[$element_key] == $key) 
        echo 'selected="selected" ';
      echo 'value="'.$key.'">'.ucfirst($key).'</option>';
    }
  }?>
								</select>
							</td>
               <td>
                  <select name="flir_mode[]">
                     <?php if (!empty($flirModes)) {
    foreach ($flirModes as $value) {
      echo '<option ';
      if ($elementMode[$element_key] == $value) 
        echo 'selected="selected" ';
      echo 'value="'.$value.'">'.ucfirst($value).'</option>';
    }
  }?>
                  </select>
               </td>
               <td><input type="checkbox" name="flir_elements_fancyfonts[]" value="<?php echo $element_value;?>"<?php if(!empty($elementFancyFonts)) {foreach ($elementFancyFonts as $key => $value) {if ($element_value == $value) echo ' checked="checked"';}}?> /></td>
               <td>Forthcoming</td>
            </tr>
<?php
}
?>
         </table>
         <h4><?php _e('Options for Default Mode', "FLIR");?>: </h4>
						<table class="widefat">
	           	<thead>
            		<tr valign="top">
									<th scope="col"><?php _e('Default Mode', "FLIR");?></th>
									<th scope="col"><?php _e('Use FancyFonts Plugin', "FLIR");?></th>
                </tr>
              </thead>
                <tr>
                  <td width="50%">
                    <select name="flir_default_mode">
                      <?php if (!empty($flirModes)) {
  foreach ($flirModes as $value) {
    echo '<option ';
    if ($defaultMode == $value) 
      echo 'selected="selected" ';
    echo 'value="'.$value.'">'.ucfirst($value).'</option>';
  }
}?>
                    </select>
                    <?php _e('<p><small>This selects the default rendering mode for FLIR to use when no other rendering mode is specified in the Elements to Replace section or you are using the Automatic Method as specified in the FLIR Configuraton section.</small></p>', "FLIR");?>
                  </td>
                  <td width="50%">
                    <input type="checkbox" name="flir_default_fancyfonts" value="small"<?php if ($defaultFancyFonts) 
  echo ' checked="checked"';?> /><?php _e('<p><small>Some fonts do not get drawn properly by the integrated Facelift image generator. This is due to a feature of PHP\'s GD. These fonts typically include characters with long tails that extend beyond their boundaries.  FanyFonts Uses <a href="http://www.imagemagick.org/script/index.php" title="ImageMagick" target="_blank">ImageMagick</a> to render images as an alternative to the GD Library. ImageMagick is required for FancyFonts and QuickEffects plugins. You must have ImageMagick installed and the correct path set in the FLIR Configuration section for ImageMagick to work with FLIR.</small></p>', "FLIR");?>
                  </td>
                </tr>
              </table>
         <p class="submit"><input type="submit" class="btn" name="save" style="padding:5px 30px 5px 30px;" value="<?php _e('Save Element Configuration', "FLIR");?>" /></p>
				<input type="hidden" name="action" value="action" /><input type="hidden" name="sub" value="elements" />
         </form>
			</div>
			</div>
			</div>