<?php
    function flir_init(){
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

          $flir_font_list               = array();
          $flir_unknown_font_size       = '16';
          $flir_cache_cleanup_frequency = '-1';
          $flir_cache_keep_time         = '604800';
          $flir_horizontal_text_bounds  = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
          $flir_javascript_method       = 'jquery';
          $flir_fonts_list              = $fonts_list;
          $flir_font_default            = $file;
          $flir_imagemagick_path        = '/usr/bin/';
          $flir_config_options = array(
            "unknown_font_size"       => $flir_unknown_font_size,
            "cache_cleanup_frequency" => $flir_cache_cleanup_frequency,
            "cache_keep_time"         => $flir_cache_keep_time,
            "horizontal_text_bounds"  => $flir_horizontal_text_bounds,
            "javascript_method"       => $flir_javascript_method,
            "fonts_list"              => $flir_fonts_list,
            "font_default"            => $flir_font_default,
            "imagemagick_path"        => $flir_imagemagick_path,
          );
          $this->saveAdminOptions($this->adminConfigName, $flir_config_options);

          $flir_config_data = '';
          $flir_config_data .= "<?php".$this->eol();
          $flir_config_data .= "/* Facelift Image Replacement v1.1.1".$this->eol().$this->eol();

          $flir_config_data .= "Facelift was written and is maintained by Cory Mawhorter.".$this->eol();
          $flir_config_data .= "It is available from http://facelift.mawhorter.net/  */".$this->eol().$this->eol();

          $flir_config_data .= "define('UNKNOWN_FONT_SIZE', ".$flir_unknown_font_size."); // in pixels".$this->eol().$this->eol();

          $flir_config_data .= "define('CACHE_CLEANUP_FREQ', ".$flir_cache_cleanup_frequency."); // -1 disable, 1 everytime, 10 would be about 1 in 10 times this script runs (higher number decreases frequency)".$this->eol();
          $flir_config_data .= "define('CACHE_KEEP_TIME', ".$flir_cache_keep_time."); // 604800: 7 days".$this->eol();
          $flir_config_data .= "define('CACHE_DIR', 'cache');".$this->eol();
          $flir_config_data .= "define('FONTS_DIR', 'fonts');".$this->eol();
          $flir_config_data .= "define('PLUGIN_DIR', 'plugins');".$this->eol().$this->eol();

          $flir_config_data .= "define('HBOUNDS_TEXT', '".$flir_horizontal_text_bounds."'); // see http://facelift.mawhorter.net/docs/".$this->eol().$this->eol();

          $flir_config_data .= "define('FONT_DISCOVERY', false);".$this->eol().$this->eol();

          $flir_config_data .= "define('IM_EXEC_PATH', '".$flir_imagemagick_path."');  // ImageMagick binaries path".$this->eol().$this->eol();

          $flir_config_data .= "// Each font you want to use should have an entry in the fonts array.".$this->eol();
          $flir_config_data .= '$fonts = array();'.$this->eol();

          if ($flir_fonts_list){
            foreach ($flir_fonts_list as $key=>$value){
              $flir_config_data .= '$fonts[\''.$this->keymaker($value).'\'] 	= \''.$value.'\';'.$this->eol();
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
        }
?>