<?php
	      $flir_config_data = '';
	      $flir_config_data .= "<?php".$this->eol();
	      $flir_config_data .= "/* Facelift Image Replacement v1.2.b2".$this->eol().$this->eol();
	      $flir_config_data .= "Auto-Generated by FLIR for WordPress at ". current_time('mysql').$this->eol().$this->eol();
	
	      $flir_config_data .= "Facelift was written and is maintained by Cory Mawhorter.".$this->eol();
	      $flir_config_data .= "It is available from http://facelift.mawhorter.net/  */".$this->eol().$this->eol();
	
	      $flir_config_data .= "define('UNKNOWN_FONT_SIZE', ".$flir_unknown_font_size."); // in pixels".$this->eol().$this->eol();
	
	      $flir_config_data .= "define('CACHE_CLEANUP_FREQ', ".$flir_cache_cleanup_frequency."); // -1 disable, 1 everytime, 10 would be about 1 in 10 times this script runs (higher number decreases frequency)".$this->eol();
	      $flir_config_data .= "define('CACHE_KEEP_TIME', ".$flir_cache_keep_time."); // 604800: 7 days".$this->eol();
        $flir_config_data .= "define('CACHE_DIR', '".$flir_cache_dir."');".$this->eol();
        $flir_config_data .= "define('FONTS_DIR', '".$flir_font_dir."');".$this->eol();
        $flir_config_data .= "define('PLUGIN_DIR', '".$flir_plugin_dir."');".$this->eol().$this->eol();
	
	      $flir_config_data .= "define('HBOUNDS_TEXT', '".$flir_horizontal_text_bounds."'); // see http://facelift.mawhorter.net/docs/".$this->eol().$this->eol();
	
	      $flir_config_data .= "define('ALLOWED_DOMAIN', false); // ex: 'example.com', 'subdomain.domain.com', '.allsubdomains.com', false disabled".$this->eol();
	      $flir_config_data .= "define('FONT_DISCOVERY', false);".$this->eol().$this->eol();
	
	      $flir_config_data .= "define('IM_EXEC_PATH', '".$flir_imagemagick_path."');  // ImageMagick binaries path".$this->eol().$this->eol();
	
	      $flir_config_data .= "// Each font you want to use should have an entry in the fonts array.".$this->eol();
	      $flir_config_data .= '$fonts = array();'.$this->eol();
	
	      if ($flir_fonts_list){
	        foreach ($flir_fonts_list as $key=>$value){
	          $flir_config_data .= '$fonts[\''.$this->keymaker($value).'\'] 	= \''.$value.'\'; // '.$key.' '.$this->eol();
	          }
	      }
	      $flir_config_data .= $this->eol().'// The font will default to the following (put your most common font here).'.$this->eol();
	      $flir_config_data .= '$fonts[\'default\'] 	= \''.$flir_font_default.'\';'.$this->eol().$this->eol();
	
	      $flir_config_data .= '// Set replacement for "web fonts" here'.$this->eol();
	      $flir_config_data .= '//$fonts[\'arial\'] = $fonts[\'helvetica\'] = $fonts[\'sans-serif\'] 		= $fonts[\'puritan\'];'.$this->eol();
	      $flir_config_data .= '//$fonts[\'times new roman\'] = $fonts[\'times\'] = $fonts[\'serif\'] 		= $fonts[\'bentham\'];'.$this->eol();
	      $flir_config_data .= '//$fonts[\'courier new\'] = $fonts[\'courier\'] = $fonts[\'monospace\'] 	= $fonts[\'geo\'];'.$this->eol();
	      $flir_config_data .= '?'.'>'.$this->eol();

	      $this->writeConfig($flir_config_data);
?>