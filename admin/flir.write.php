<?php
    $flirConfig_data = '';
    $flirConfig_data .= "<?php".$this->eol();
    
    $flirConfig_data .= "/**".$this->eol();
    $flirConfig_data .= "* Facelift Image Replacement v2.0b3".$this->eol();
    $flirConfig_data .= "* Auto-Generated by FLIR for WordPress at 2010-06-29 19:28:56".$this->eol();
    $flirConfig_data .= "* ".$this->eol();
    $flirConfig_data .= "* Facelift was written and is maintained by Cory Mawhorter.".$this->eol();
    $flirConfig_data .= "* It is available from http://facelift.mawhorter.net/".$this->eol();
    $flirConfig_data .= "*/".$this->eol();

    $flirConfig_data .= "define('ALLOWED_DOMAIN', false); // ex: 'example.com', 'subdomain.domain.com', '.allsubdomains.com', false disabled".$this->eol();
    $flirConfig_data .= "define('UNKNOWN_FONT_SIZE', ".$unknownFontSize."); // in pixels".$this->eol().$this->eol();

    $flirConfig_data .= "define('CACHE_CLEANUP_FREQ', ".$cacheCleanupFrequency."); // -1 disable, 1 everytime, 10 would be about 1 in 10 times this script runs (higher number decreases frequency)".$this->eol();
    $flirConfig_data .= "define('CACHE_KEEP_TIME', ".$cacheKeepTime."); // 604800: 7 days".$this->eol();
    $flirConfig_data .= "define('CACHE_SINGLE_DIR', ".$cacheSingleDir."); // don't create subdirs to store cached files (good for small sites)".$this->eol().$this->eol();

    $flirConfig_data .= "define('FONT_DISCOVERY', false);".$this->eol().$this->eol();	      

    $flirConfig_data .= "define('CACHE_DIR', '".$cacheDir."');".$this->eol();
    $flirConfig_data .= "define('FONTS_DIR', '".$fontDir."');".$this->eol();
    $flirConfig_data .= "define('PLUGIN_DIR', '".$pluginDir."');".$this->eol();
    
    $flirConfig_data .= "define('RENDER_PLUGIN_DIR', PLUGIN_DIR.'/render');".$this->eol();
    $flirConfig_data .= "define('PREPROC_PLUGIN_DIR', PLUGIN_DIR.'/pre');".$this->eol();
    $flirConfig_data .= "define('POSTPROC_AUTORUN', 'supercache');".$this->eol();
    $flirConfig_data .= "define('POSTPROC_PLUGIN_DIR', PLUGIN_DIR.'/post');".$this->eol().$this->eol();

    $flirConfig_data .= "define('HBOUNDS_TEXT', '".$horizontalTextBounds."'); // see http://facelift.mawhorter.net/docs/".$this->eol().$this->eol();

    $flirConfig_data .= "define('IM_EXEC_PATH', '".$imagemagickPath."');  // ImageMagick binaries path".$this->eol().$this->eol();

    $flirConfig_data .= "/**".$this->eol();
    $flirConfig_data .= "* Each font you want to use should have an entry in the fonts array.".$this->eol();
    $flirConfig_data .= "* FLIR for WordPress should generate this based on the fonts in your".$this->eol();
    $flirConfig_data .= "* wp-content/plugins/facelift-image-replacement/facelift/fonts dir".$this->eol();
    $flirConfig_data .= "* ".$this->eol();
    $flirConfig_data .= "* @var mixed".$this->eol();
    $flirConfig_data .= "*/".$this->eol();
    $flirConfig_data .= '$fonts = array();'.$this->eol();

    if ($fontsList){
        foreach ($fontsList as $key=>$value){
            $flirConfig_data .= '$fonts[\''.$this->keyMaker($value).'\'] 	= \''.$value.'\'; // '.$key.' '.$this->eol();
        }
    }

    $flirConfig_data .= "/**".$this->eol();
    $flirConfig_data .= "* The font will default to the following (put your most common font here).".$this->eol();
    $flirConfig_data .= "* ".$this->eol();
    $flirConfig_data .= "* @var mixed".$this->eol();
    $flirConfig_data .= "*/".$this->eol();
    $flirConfig_data .= '$fonts[\'default\'] 	= \''.$fontDefault.'\';'.$this->eol().$this->eol();

    /**
    * XXX -c hold, re-implement -o Dan Zappone: May need to be re-implemented later.  Leaving commented for now.
    * 
    * @var mixed
    */
    /*
    $flirConfig_data .= '// Set replacement for "web fonts" here'.$this->eol();
    $flirConfig_data .= '//$fonts[\'arial\'] = $fonts[\'helvetica\'] = $fonts[\'sans-serif\'] 		= $fonts[\'puritan\'];'.$this->eol();
    $flirConfig_data .= '//$fonts[\'times new roman\'] = $fonts[\'times\'] = $fonts[\'serif\'] 		= $fonts[\'bentham\'];'.$this->eol();
    $flirConfig_data .= '//$fonts[\'courier new\'] = $fonts[\'courier\'] = $fonts[\'monospace\'] 	= $fonts[\'geo\'];'.$this->eol().$this->eol();
    */
    
    $flirConfig_data .= '// pipe-separated list of processing plugins to autorun'.$this->eol();
    $flirConfig_data .= '// modify settings by including them in querystring style'.$this->eol();
    $flirConfig_data .= "define('PREPROC_AUTORUN', false);".$this->eol();
    $flirConfig_data .= "define('POSTPROC_AUTORUN', false);".$this->eol();

    $flirConfig_data .= '?'.'>'.$this->eol();

    $this->writeConfig($flirConfig_data);
?>