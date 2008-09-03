<?php
/*
Plugin Name: FLIR for WordPress
Plugin URI: http://www.23systems.net/plugins/facelift-image-replacement-flir/
Description: Facelift Image Replacment for WordPress is a plugin and script is a script that generates image representations of text on your web page in fonts that visitors would not be able to see.  It is based on Facelift Image Replacement by <a href="http://facelift.mawhorter.net/">Cory Mawhorter</a>.
Author: Dan Zappone
Version: 0.7.7
Author URI: http://www.23systems.net/
*/
global $flir_url, $facelift_url;
global $facelift_config_path, $facelift_path, $facelift_cache_path, $facelift_fonts_path;
global $flir_method, $flir_fonts;

$flir_url     = WP_PLUGIN_URL.'/facelift-image-replacement';
$facelift_url = $flir_url.'/facelift/';
$facelift_path = dirname(__FILE__)."/facelift/";
$facelift_cache_path = $facelift_path.'cache';
$facelift_fonts_path = $facelift_path.'fonts';
$facelift_config_path = $facelift_path.'config-flir.php';

if (!function_exists("flir_reload")) {
	function flir_reload($update) {
		$location = get_option('siteurl').'/wp-admin/themes.php?page=FLIR';
		echo '<script>'."\r\n";
		echo '<!--'."\r\n";
  	echo 'window.location="'.$location.'&updated='.$update.'"'."\r\n";
  	echo '//-->'."\r\n";
  	echo '</script>'."\r\n";
  	}
}

if (!class_exists('wp_flir')) {
  class wp_flir {

    /*---- The name the options are saved under in the database ----*/
    var $adminOptionsName = "wp_flir_options";
    var $adminConfigName = "wp_flir_config";
    var $adminInitName = "wp_flir_init";

    /*---- PHP 4 Compatible Constructor ----*/
    function wp_flir() {
      $this->__construct();
    }

    /*---- PHP 5 Constructor ----*/
    function __construct() {
    	
      add_action("admin_menu", array(&$this, "add_admin_pages"));
      add_action("admin_head", array(&$this, "add_admin_css"));
      add_action("init", array(&$this, "add_scripts"));
      add_action("wp_footer", array(&$this, 'wp_footer_intercept'));
//      add_action("wp_head", array(&$this, "add_css"));
      $this->adminOptions = $this->getAdminOptions($this->adminOptionsName);
      $this->adminConfig = $this->getAdminOptions($this->adminConfigName);
      $this->adminInit = get_option($this->adminInitName);
			if (!$this->adminInit) {
		  	$this->flir_init();
			}
    }

	    function flir_init(){
	    	global $facelift_fonts_path;
	      add_option('wp_flir_init', true);
	    
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

	      $flir_font_list               = array();
	      $flir_unknown_font_size       = '16';
	      $flir_cache_cleanup_frequency = '-1';
	      $flir_cache_keep_time         = '604800';
        $flir_cache_dir			          = 'cache';
        $flir_font_dir                = 'fonts';
        $flir_plugin_dir 		          = 'plugins';
	      $flir_horizontal_text_bounds  = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	      $flir_javascript_method       = 'jquery';
	      $flir_fonts_list              = $fonts_list;
	      $flir_font_default            = $file;
	      $flir_imagemagick_path        = '/usr/bin/';
	      $flir_config_options = array(
	        "unknown_font_size"       => $flir_unknown_font_size,
	        "cache_cleanup_frequency" => $flir_cache_cleanup_frequency,
	        "cache_keep_time"         => $flir_cache_keep_time,
          "cache_dir"								=> $flir_cache_dir,
          "font_dir"								=> $flir_font_dir,
          "plugin_dir"							=> $flir_plugin_dir,
	        "horizontal_text_bounds"  => $flir_horizontal_text_bounds,
	        "javascript_method"       => $flir_javascript_method,
	        "fonts_list"              => $flir_fonts_list,
	        "font_default"            => $flir_font_default,
	        "imagemagick_path"        => $flir_imagemagick_path,
	      );

	      $this->saveAdminOptions($this->adminConfigName, $flir_config_options);
	
				require('admin/flir-write-config.php');
	      
      }

    /*---- Retrieves the options from the database.  @return array ----*/
    function getAdminOptions($optionsname) {
      $savedOptions = get_option($optionsname);
      if (!empty($savedOptions)) {
        foreach ($savedOptions as $key => $option) {
          $theOptions[$key] = $option;
        }
      }
      update_option($optionsname, $theOptions);
      return $theOptions;
    }

    /*---- Saves the admin options to the database. ----*/
    function saveAdminOptions($optionsname, $options) {
      update_option($optionsname, $options);
    }

    function add_admin_pages() {
      add_submenu_page('themes.php', "FLIR", "FLIR", 10, "FLIR", array(&$this, "output_sub_admin_page_0"));
    }

    /*---- Outputs the HTML for the admin sub page. ----*/
    function output_sub_admin_page_0() {
      global $flir_url, $facelift_url, $flir_fonts, $facelift_path, $facelift_cache_path, $facelift_fonts_path;
      $flir_modes    = array();
      $flir_modes[1] = 'static';
      $flir_modes[2] = 'progressive';
      $flir_modes[3] = 'wrap';
      if ($_POST['action']) {
        if ($_POST['sub'] == 'elements') {
          $flir_elements       = $_POST[flir_elements];
          $flir_elements_fonts = $_POST[flir_element_fonts];
          $flir_elements_mode  = $_POST[flir_mode];
          $flir_default_mode   = $_POST[flir_default_mode];
          $flir_fancy_font     = $_POST[flir_fancy_font];
          $flir_elements_options = array(
            "elements"    => $flir_elements,
            "fonts"       => $flir_elements_fonts,
            "mode"        => $flir_elements_mode,
            "defaultmode" => $flir_default_mode,
            "fancyfont"   => $flir_fancy_font,
          );
          $this->saveAdminOptions($this->adminOptionsName, $flir_elements_options);

		    	flir_reload('elements');
        }
        elseif ($_POST['sub'] == 'config') {
          $flir_font_list               = array();
          $flir_unknown_font_size       = $_POST[unknown_font_size];
          $flir_cache_cleanup_frequency = $_POST[cache_cleanup_frequency];
          $flir_cache_keep_time         = $_POST[cache_keep_time];
          $flir_cache_dir			          = 'cache';
          $flir_font_dir                = 'fonts';
          $flir_plugin_dir 		          = 'plugins';
          $flir_horizontal_text_bounds  = $_POST[horizontal_text_bounds];
          $flir_javascript_method       = $_POST[javascript_method];
          $flir_fonts_post              = $_POST[fonts_list];
          foreach ($flir_fonts_post as $value) {
						$flir_fonts_list[$this->keymaker($value)] = $value;
					}
          $flir_font_default            = $_POST[font_default];
          $flir_imagemagick_path        = $_POST[imagemagick_path];
          $flir_config_options = array(
            "unknown_font_size"       => $flir_unknown_font_size,
            "cache_cleanup_frequency" => $flir_cache_cleanup_frequency,
            "cache_keep_time"         => $flir_cache_keep_time,
            "cache_dir"								=> $flir_cache_dir,
            "font_dir"								=> $flir_font_dir,
            "plugin_dir"							=> $flir_plugin_dir,
            "horizontal_text_bounds"  => $flir_horizontal_text_bounds,
            "javascript_method"       => $flir_javascript_method,
            "fonts_list"              => $flir_fonts_list,
            "font_default"            => $flir_font_default,
            "imagemagick_path"        => $flir_imagemagick_path,
          );
          $this->configSet = true;
          $this->saveAdminOptions($this->adminConfigName, $flir_config_options);

					require('admin/flir-write-config.php');
					flir_reload('config');
        }
        elseif ($_POST['sub'] == 'settings') {
        	$flir_clear_cache      = $_POST[clear_cache];
        	$flir_reinitialize     = $_POST[reinit_flir];
        	
        	if (!empty($flir_clear_cache)) {
						$this->clearCache($facelift_cache_path);
						flir_reload('cache');
					}
        
        	if (!empty($flir_reinitialize)) {
						$this->clearCache($facelift_cache_path);
						delete_option($this->adminOptionsName);
						delete_option($this->adminConfigName);
						delete_option($this->adminInitName);
						$this->flir-init;
						flir_reload('reinit');
					}
        }
      }
      /*---- Notify FLIR status ----*/
      $flir_status     = $_GET[updated];
      if ($flir_status) {
      switch ($flir_status)
				{
				case 'elements':
				  echo '<div id="message" class="updated fade">';
		    	_e('<p><strong>FLIR Elements Saved</strong></p></div>',"FLIR");
				  break;  
				case 'config':
				  echo '<div id="message" class="updated fade">';
		    	_e('<p><strong>FLIR Configuration Saved</strong></p></div>',"FLIR");
				  break;
				case 'cache':
				  echo '<div id="message" class="updated fade">';
		    	_e('<p><strong>FLIR Cache Cleared</strong></p></div>',"FLIR");
				  break;
				case 'reinit':
				  echo '<div id="message" class="updated fade">';
		    	_e('<p><strong>FLIR Reinitialized</strong></p></div>',"FLIR");
				  break;
				default:
				  break;
				}
      }
      ?>
		<div class="wrap alternate">
			<h2><?php _e('FLIR for WordPress Configuration (v0.7.5 / Facelift v1.2b2)', 'FLIR');?></h2>
			<br style="clear:both;" />
<?php
			require('admin/flir-config.php');
			require('admin/flir-el.php');
			require('admin/flir-settings.php');
      ?>
			<br style="clear:both;" />
		</div>
        <script type="text/javascript">
		<!--
		jQuery('.postbox h3').prepend('<a class="togbox">+</a> ');
		jQuery('.postbox h3').click( function() { jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); } );
		jQuery('.postbox.close-me').each(function(){
		jQuery(this).addClass("closed");
		});
		//-->
	</script>
			<?php
    }

    /*---- load JavaScripts scripts ----*/
    function add_scripts() {
      global $facelift_url, $flir_method;

      
				if (!empty($this->adminConfig)) {
  				$flir_config  = $this->getAdminOptions($this->adminConfigName);
	        $flir_method  = $flir_config['javascript_method'];
				}
      	if ($flir_method == 'jquery') {      
      		wp_enqueue_script('flir_script', $facelift_url.'flir.js', array("jquery"), 0.1);
      	}
      	elseif  ($flir_method == 'scriptaculous') {
      		wp_enqueue_script('flir_script', $facelift_url.'flir.js', array("scriptaculous"), 0.1);
      	}
      	elseif  ($flir_method == 'prototype') {
      		wp_enqueue_script('flir_script', $facelift_url.'flir.js', array("prototype"), 0.1);
      	}
      	else {
      		wp_enqueue_script('flir_script', $facelift_url.'flir.js');				
				}
    }

    /*---- Called by the action wp_footer ----*/
    function wp_footer_intercept() {
      global $facelift_url, $flir_method;
				if (!empty($this->adminOptions)) {
					$flir_options        = $this->getAdminOptions($this->adminOptionsName);
					$flir_elements       = $flir_options['elements'];
					$flir_elements_fonts = $flir_options['fonts'];
					$flir_elements_mode  = $flir_options['mode'];
					$flir_default_mode   = $flir_options['defaultmode'];
					$flir_fancy_fonts   = $flir_options['fancyfont'];
					if ($flir_fancy_fonts) {
            $setFancyFonts = ", mode:'fancyfonts'";
          }
          else {
            $setFancyFonts = "";
          }
				}
				if (!empty($this->adminConfig)) {
  				$flir_config  = $this->getAdminOptions($this->adminConfigName);
	        $flir_method  = $flir_config['javascript_method'];
				}
				if ($flir_method == 'jquery') {
					echo '<script type="text/javascript">'.$this->eol();
					echo "FLIR.init({path:'$facelift_url'},new FLIRStyle({mode:'".$flir_default_mode."'".$setFancyFonts."}));".$this->eol();
					if (!empty($flir_elements)) {
						echo 'jQuery(function($){'.$this->eol();
						echo '    $(document).ready(function(){'.$this->eol();
							foreach ($flir_elements as $key => $value) {
								echo '    $("'.$value.'").each( function() { FLIR.replace(this, new FLIRStyle({mode:\''.$flir_elements_mode[$key].'\',cFont:\''.$flir_elements_fonts[$key].'\''.$setFancyFonts.'}));});'.$this->eol();
							}
						echo '    });'.$this->eol();
						echo '});'.$this->eol();
					}
					else {
						echo "FLIR.auto();".$this->eol();
					}
					echo '</script>'.$this->eol();
				}
				elseif  ($flir_method == 'prototype' || $flir_method == 'scriptaculous') {
					echo '<script type="text/javascript">'.$this->eol();
   				echo "FLIR.init({path:'$facelift_url'},new FLIRStyle({mode:'".$flir_default_mode."'".$setFancyFonts."}));".$this->eol();
	      	if (!empty($flir_elements)) {
		      	foreach ($flir_elements as $key => $value) {
							echo '$$("'.$value.'").each( function(el) { FLIR.replace(el, new FLIRStyle({mode:\''.$flir_elements_mode[$key].'\',cFont:\''.$flir_elements_fonts[$key].'\''.$setFancyFonts.'})); } );'.$this->eol();
			    	}
		    	}
		    	else {
   					echo "FLIR.auto();".$this->eol();
   				}
   				echo '</script>'.$this->eol();
   			}
				else {
					echo '<script type="text/javascript">'.$this->eol();
   				echo "FLIR.init({path:'$facelift_url'},new FLIRStyle({mode:'".$flir_default_mode."'".$setFancyFonts."}));".$this->eol();
 					echo "FLIR.auto();".$this->eol();
 					echo '</script>'.$this->eol();
   			}
		}

    /*---- Adds a link to the stylesheet to the header ----*/
    function add_css() {
      echo '<link rel="stylesheet" href="'.get_bloginfo('wpurl').'/wp-content/plugins/facelift-image-replacement/css/style.css" type="text/css" media="screen" />'.$this->eol();
    }

    function add_admin_css() {
      echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('wpurl').'/wp-content/plugins/facelift-image-replacement/css/admin.css" />'.$this->eol();
    }

    /*---- UTILITY FUNCTIONS ----*/
    /*---- Create clean eols for source ----*/
    function eol() {
      if (strtoupper(substr(PHP_OS, 0, 3) == 'WIN')) {
        $eol = "\r\n";
      }
      elseif (strtoupper(substr(PHP_OS, 0, 3) == 'MAC')) {
        $eol = "\r";
      }
      else {
        $eol = "\n";
      }
      return $eol;
    }

    /*---- Create clean eols for source ----*/
    function winPath($pathname) {
      if (strtoupper(substr(PHP_OS, 0, 3) == 'WIN')) {
        $path = str_replace('/', '\\', $pathname);
      }
      return $path;
    }
    
    /*---- sets selected array items in multi select form field to selected ----*/
    function setSelected($theitem,$thearray) {
      $ret_value = false;
	    if (!empty($thearray)) {
		    foreach ($thearray as $key=>$value) {
			   if ($value == $theitem) { $ret_value = true; }
		    }
	    }
	   return $ret_value;
    }
    
    /*---- Reduce filename to acceptable array key ----*/
    function keymaker($filename) {
      $replacepattern = "/(\.otf)|(\.ttf)|(-*_*\d*\s*)/i";
      $keyname = strtolower(preg_replace($replacepattern, '', $filename));
      return $keyname;
    }
    
    /*---- Writes facelift config file to facelift directory ----*/
    function writeConfig($configdata) {
      global $facelift_config_path;
      $handle = fopen($facelift_config_path, 'wb');
      fwrite($handle, $configdata);
      fclose($handle);
    }

    /*---- Clears facelift cache - and them some ----*/
    function clearCache($dirname) {
    	global $facelift_cache_path;
  		if(is_dir($dirname)){
				$dir_handle = opendir($dirname);
			} 
  		while($file = readdir($dir_handle)) { 
    		if($file != "." && $file != "..") { 
      		if(!is_dir($dirname."/".$file)){
						unlink ($dirname."/".$file);
					} 
      		else {
						$this->clearCache($dirname."/".$file);
					} 
    		} 
			} 
  		closedir($dir_handle);
			if ($dirname != $facelift_cache_path){ 
  			rmdir($dirname);
  		}
			return true; 
    }
    
  }
}

/*---- instantiate the class ----*/
if (class_exists('wp_flir')) {
  $wp_flir = new wp_flir();
}
