<?php
/*
Plugin Name: FLIR for WordPress
Plugin URI: http://www.23systems.net/plugins/facelift-image-replacement-flir/
Description: Facelift Image Replacment for WordPress is a plugin and script is a script that generates image representations of text on your web page in fonts that visitors would not be able to see.  It is based on Facelift Image Replacement by <a href="http://facelift.mawhorter.net/">Cory Mawhorter</a>.
Author: Dan Zappone
Version: 0.8.9.2
Author URI: http://www.23systems.net/
*/
global $g_flir_url, $g_facelift_url;
global $g_facelift_config_path, $g_facelift_path, $g_facelift_cache_path, $g_facelift_fonts_path;
global $g_flir_method, $g_flir_fonts;

$g_flir_url     = WP_PLUGIN_URL.'/facelift-image-replacement';
$g_facelift_url = $g_flir_url.'/facelift/';
$g_facelift_path = dirname(__FILE__)."/facelift/";
$g_facelift_cache_path = $g_facelift_path.'cache';
$g_facelift_fonts_path = $g_facelift_path.'fonts';
$g_facelift_config_path = $g_facelift_path.'config-flir.php';

if (!function_exists("flirReload")) {
	function flirReload($update) {
		$location = get_option('siteurl').'/wp-admin/themes.php?page=FLIR';
		echo '<script>'."\r\n";
		echo '<!--'."\r\n";
  	echo 'window.location="'.$location.'&updated='.$update.'"'."\r\n";
  	echo '//-->'."\r\n";
  	echo '</script>'."\r\n";
  	}
}

function wp_flir_deactivation() {
    global $g_facelift_cache_path;
    
    $options = get_option('wp_flir_init');
    delete_option('wp_flir_init');

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
		if ($dirname != $g_facelift_cache_path){ 
			rmdir($dirname);
		}
		return true; 
}

register_deactivation_hook(__FILE__, 'wp_flir_deactivation');

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
  	
      add_action("admin_menu", array(&$this, "addAdminPages"));
      add_action("admin_head", array(&$this, "addAdminHeader"));
//      add_action("wp_head", array(&$this, "add_css"));
      
      $this->adminOptions = $this->getAdminOptions($this->adminOptionsName);
      $this->adminConfig = $this->getAdminOptions($this->adminConfigName);
      if (!($this->detect_ie())) {
        add_action("init", array(&$this, "addScripts"));
        add_action("wp_footer", array(&$this, 'wpFooterIntercept'));
      }
      $this->adminInit = get_option($this->adminInitName);
			add_filter( 'plugin_row_meta',array( &$this, 'RegisterFLIRLinks'),10,2);
      if (!$this->adminInit) {
		  	$this->flirInit();
			}
    }

	    function flirInit(){
	    	global $g_facelift_fonts_path;
	    	
        if (!empty($this->adminConfig)) {
        	add_option('wp_flir_init', true);
        	
          $flirConfig         		= $this->getAdminOptions($this->adminConfigName);
          $unknownFontSize        = $flirConfig['unknown_font_size'];
          $cacheCleanupFrequency  = $flirConfig['cache_cleanup_frequency'];
          $cacheKeepTime          = $flirConfig['cache_keep_time'];
          $cacheSingleDir         = $flirConfig['cache_single_dir'];
          $cacheDir			          = 'cache';
          $fontDir                = 'fonts';
          $pluginDir 		          = 'plugins';
          $horizontalTextBounds   = $flirConfig['horizontal_text_bounds'];
          $javascriptMethod       = $flirConfig['javascript_method'];
	        $externalJavaScript     = $flirConfig['external_javascript'];
          $fontsList              = $flirConfig['fonts_list'];
          $fontDefault            = $flirConfig['font_default'];
          $imagemagickPath        = $flirConfig['imagemagick_path'];
          $dropIE                 = $flirConfig['drop_ie'];
          $elementList            = $flirConfig['element_types'];
        }
        else {
  	      add_option('wp_flir_init', true);
  	    
  				$baseFontsList   = array();
  				$pattern        = "/(\.otf)|(\.ttf)/i";
  				$replacePattern = "/(\.otf)|(\.ttf)|(-*_*\d*\s*)/i";
  				if ($handle = opendir($g_facelift_fonts_path)) {
  				  while (false !== ($file = readdir($handle))) {
  				    if (preg_match($pattern, $file)) {
  				      $newKey = $this->keyMaker($file);
  				      $baseFontsList[$newKey] = $file;
  				      $fontDefault            = $file;
  				    }
  				  }
  				  closedir($handle);
  				}
  
  	      $fontList               = array();
  	      $elementList            = array();
  	      $unknownFontSize        = '16';
  	      $cacheCleanupFrequency  = '-1';
  	      $cacheKeepTime          = '604800';
  	      $cacheSingleDir         = 'false';
          $cacheDir			          = 'cache';
          $fontDir                = 'fonts';
          $pluginDir 		          = 'plugins';
  	      $horizontalTextBounds   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz[]{}()_';
  	      $javascriptMethod       = 'automatic';
  	      $externalJavaScript     = '0';
  	      $fontsList              = $baseFontsList;
  	      $fontDefault            = $fontDefault;
  	      $imagemagickPath        = '/usr/bin/';
  	      $dropIE                 = '0';
  	      $elementList            = explode(",","h1,h2,h3,h4,h5");
  	      $configOptions = array(
  	        "unknown_font_size"       => $unknownFontSize,
  	        "cache_cleanup_frequency" => $cacheCleanupFrequency,
  	        "cache_keep_time"         => $cacheKeepTime,
            "cache_single_dir"				=> $cacheSingleDir,
            "cache_dir"								=> $cacheDir,
            "font_dir"								=> $fontDir,
            "plugin_dir"							=> $pluginDir,
  	        "horizontal_text_bounds"  => $horizontalTextBounds,
  	        "javascript_method"       => $javascriptMethod,
  	        "external_javascript"     => $externalJavaScript,
  	        "fonts_list"              => $fontsList,
  	        "font_default"            => $fontDefault,
  	        "imagemagick_path"        => $imagemagickPath,
  	        "drop_ie"                 => $dropIE,
  	        "element_types"           => $elementList,
  	      );
  			  $this->saveAdminOptions($this->adminConfigName, $configOptions);
       	}
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

    function addAdminPages() {
      add_submenu_page('themes.php', "FLIR", "FLIR", 10, "FLIR", array(&$this, "outputSubAdminPage"));
    }

    function getBaseName() {
		  return plugin_basename(__FILE__);
	  }

    function RegisterFLIRLinks($links, $file) {
    	$base = wp_flir::getBaseName();
    	if ($file == $base) {
    		$links[] = '<a href="themes.php?page=FLIR">' . __('Settings') . '</a>';
    		$links[] = '<a href="http://www.23systems.net/plugins/facelift-image-replacement-flir/frequently-asked-questions/">' . __('FAQ') . '</a>';
    		$links[] = '<a href="http://www.23systems.net/bbpress/forum/facelift-image-replacement">' . __('Support') . '</a>';
    		$links[] = '<a href="http://www.23systems.net/donate/">' . __('Donate') . '</a>';
    		$links[] = '<a href="http://twitter.com/23systems">' . __('Follow on Twitter') . '</a>';
    		$links[] = '<a href="http://www.facebook.com/pages/Austin-TX/23Systems-Web-Devsign/94195762502">' . __('Facebook Page') . '</a>';
    	}
    	return $links;
    }

    /*---- Outputs the HTML for the admin sub page. ----*/
    function outputSubAdminPage() {
      global $g_flir_url, $g_facelift_url, $g_flir_fonts, $g_facelift_path, $g_facelift_cache_path, $g_facelift_fonts_path;
      $flirModes    = array();
      $flirModes[1] = 'static';
      $flirModes[2] = 'progressive';
      $flirModes[3] = 'wrap';
      if ($_POST['action']) {
        if ($_POST['sub'] == 'elements') {
          $elementsForFlir    = $_POST[flir_elements];
          $elementFonts       = $_POST[flir_element_fonts];
          $elementMode        = $_POST[flir_mode];
          $elementFancyFonts  = $_POST[flir_elements_fancyfonts];
          $elementQuickEffect = $_POST[flir_elements_quickeffect];
          $defaultMode        = $_POST[flir_default_mode];
          $defaultFancyFonts  = $_POST[flir_default_fancyfonts];
          $elementOptions     = array(
            "elements"           => $elementsForFlir,
            "fonts"              => $elementFonts,
            "mode"               => $elementMode,
            "fancyfonts"         => $elementFancyFonts,
            "quickeffect"        => $elementQuickEffect,
            "defaultmode"        => $defaultMode,
            "defaultfancyfonts"  => $defaultFancyFonts,
          );
          $this->saveAdminOptions($this->adminOptionsName, $elementOptions);

		    	flirReload('elements');
        }
        elseif ($_POST['sub'] == 'config') {
          $fontList               = array();
          $elementList            = array();
          $unknownFontSize        = $_POST[unknown_font_size];
          $cacheCleanupFrequency  = $_POST[cache_cleanup_frequency];
          $cacheKeepTime          = $_POST[cache_keep_time];
          $cacheSingleDir         = $this->setItemSelected($_POST[cache_single_dir]);
          $cacheDir			          = 'cache';
          $fontDir                = 'fonts';
          $pluginDir 		          = 'plugins';
          $horizontalTextBounds   = $_POST[horizontal_text_bounds];
          $javascriptMethod       = $_POST[javascript_method];
	        $externalJavaScript     = $_POST[external_javascript];
          $fontsPost              = $_POST[fonts_list];
          foreach ($fontsPost as $value) {
						$fontsList[$this->keyMaker($value)] = $value;
					}
          $fontDefault            = $_POST[font_default];
          $imagemagickPath        = $_POST[imagemagick_path];
          $dropIE                 = $_POST[drop_ie];
          $elementTypes           = $_POST[element_types];
          $elementList            = explode(",", $elementTypes);
          $configOptions = array(
            "unknown_font_size"       => $unknownFontSize,
            "cache_cleanup_frequency" => $cacheCleanupFrequency,
            "cache_keep_time"         => $cacheKeepTime,
            "cache_single_dir"				=> $cacheSingleDir,
            "cache_dir"								=> $cacheDir,
            "font_dir"								=> $fontDir,
            "plugin_dir"							=> $pluginDir,
            "horizontal_text_bounds"  => $horizontalTextBounds,
            "javascript_method"       => $javascriptMethod,
            "external_javascript"     => $externalJavaScript,
            "fonts_list"              => $fontsList,
            "font_default"            => $fontDefault,
            "imagemagick_path"        => $imagemagickPath,
            "drop_ie"                 => $dropIE,
            "element_types"           => $elementList,
          );
          $this->configSet = true;
          $this->saveAdminOptions($this->adminConfigName, $configOptions);

					require('admin/flir-write-config.php');
					flirReload('config');
        }
        elseif ($_POST['sub'] == 'settings') {
        	$clearCache      = $_POST[clear_cache];
        	$reInitialize     = $_POST[reinit_flir];
        	
        	if (!empty($clearCache)) {
						$this->clearCache($g_facelift_cache_path);
						flirReload('cache');
					}
        
        	if (!empty($reInitialize)) {
						$this->clearCache($g_facelift_cache_path);
						delete_option($this->adminOptionsName);
						delete_option($this->adminConfigName);
						delete_option($this->adminInitName);
						$this->flir-init;
						flirReload('reinit');
					}
        }
      }
      /*---- Notify FLIR status ----*/
      $flirStatus     = $_GET[updated];
      if ($flirStatus) {
      switch ($flirStatus)
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
		<div class="wrap">
			<h2><?php _e('FLIR for WordPress Configuration v0.8.9.1 (Facelift v2.0b3)', 'FLIR');?></h2>
			<br style="clear:both;" />
<?php
			require('admin/flir-config.php');

      ?>
			<br style="clear:both;" />
		</div>
	<?php
			require('admin/flir-el.php');
			require('admin/flir-settings.php');
  ?>
      <script type="text/javascript">
  		<!--
  		jQuery('.postbox h3').click( function() { jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); } );
  		jQuery('.postbox.close-me').each(function(){
  		jQuery(this).addClass("closed");
  		});
		
      function toggleVisibility(id) {
      var elmt = document.getElementById(id);
        if(elmt.style.display == 'block')
          elmt.style.display = 'none';
      else
        elmt.style.display = 'block';
      }
		  //-->
    	</script>      
			<?php
    }

    /*---- load JavaScripts scripts ----*/
    function addScripts() {
      global $g_facelift_url, $g_flir_method;
				if (!empty($this->adminConfig)) {
  				$flirConfig     = $this->getAdminOptions($this->adminConfigName);
	        $g_flir_method  = $flirConfig['javascript_method'];
				}
				switch ($g_flir_method) {
          case 'jquery':
            if (!($this->external_js())) {
          		wp_enqueue_script('flir_script', $g_facelift_url.'flirmin.js', array("jquery"), '2.0.0', true);
          	}
          	else {
            	wp_enqueue_script('flir_script', $g_facelift_url.'flirmin.js','', '2.0.0', true);
            }
            break;
          case 'scriptaculous':
        	  if (!($this->external_js())) {
        		  wp_enqueue_script('flir_script', $g_facelift_url.'flirmin.js', array("scriptaculous"), '2.0.0', true);
        		}
        		else {
            	wp_enqueue_script('flir_script', $g_facelift_url.'flirmin.js','', '2.0.0', true);
            }
            break;
          case 'prototype':
        	  if (!($this->external_js())) {
        		  wp_enqueue_script('flir_script', $g_facelift_url.'flirmin.js', array("prototype"), '2.0.0', true);
        		}
        		else {
            	wp_enqueue_script('flir_script', $g_facelift_url.'flirmin.js','', '2.0.0', true);
            }
            break;
          default:
            wp_enqueue_script('flir_script', $g_facelift_url.'flirmin.js','', '2.0.0', true);
        }
    }

    /*---- Called by the action wp_footer ----*/
    function wpFooterIntercept() {
      global $g_facelift_url, $g_flir_method;
				if (!empty($this->adminOptions)) {
					$flirOptions          = $this->getAdminOptions($this->adminOptionsName);
					$elementsForFlir      = $flirOptions['elements'];
					$elementFonts         = $flirOptions['fonts'];
					$elementMode          = $flirOptions['mode'];
					$elementFancyFonts    = $flirOptions['fancyfonts'];
					$elementQuickEffect   = $flirOptions['quickeffect'];
					$defaultMode          = $flirOptions['defaultmode'];
					$defaultFancyFonts    = $flirOptions['defaultfancyfonts'];
					if ($defaultFancyFonts) { $setDefaultFancyFonts = ", mode:'fancyfonts'"; } else { $setDefaultFancyFonts = ""; }
				}
				if (!empty($this->adminConfig)) {
  				$flirConfig     = $this->getAdminOptions($this->adminConfigName);
	        $g_flir_method  = $flirConfig['javascript_method'];
				}
				
				switch ($g_flir_method) {
          case 'jquery':
  					echo '<script type="text/javascript">'.$this->eol();
  					echo "FLIR.init({path:'$g_facelift_url'},new FLIRStyle({mode:'".$defaultMode."'".$setDefaultFancyFonts."}));".$this->eol();
  					if (!empty($elementsForFlir)) {
  						echo 'jQuery(document).ready(function($){'.$this->eol();
//  						echo '    $(document).ready(function(){'.$this->eol();
  							foreach ($elementsForFlir as $key => $value) {
  							  if ($elementFancyFonts[$key] == $value) { $fancyFonts = ", mode:'fancyfonts'"; } else { $fancyFonts = ""; }
  								echo '    $("'.$value.'").each( function() { FLIR.replace(this, new FLIRStyle({mode:\''.$elementMode[$key].'\',cFont:\''.$elementFonts[$key].'\''.$fancyFonts.'}));});'.$this->eol();
  							}
//  						echo '    });'.$this->eol();
  						echo '});'.$this->eol();
  					}
  					else {
  						echo "FLIR.auto();".$this->eol();
  					}
  					echo '</script>'.$this->eol();
            break;
          case 'scriptaculous':
          case 'prototype':
  					echo '<script type="text/javascript">'.$this->eol();
     				echo "FLIR.init({path:'$g_facelift_url'},new FLIRStyle({mode:'".$defaultMode."'".$setDefaultFancyFonts."}));".$this->eol();
  	      	if (!empty($elementsForFlir)) {
  		      	foreach ($elementsForFlir as $key => $value) {
  							if ($elementFancyFonts[$key] == $value) { $fancyFonts = ", mode:'fancyfonts'"; } else { $fancyFonts = ""; }
  							echo '$$("'.$value.'").each( function(el) { FLIR.replace(el, new FLIRStyle({mode:\''.$elementMode[$key].'\',cFont:\''.$elementFonts[$key].'\''.$fancyFonts.'})); } );'.$this->eol();
  			    	}
  		    	}
  		    	else {
     					echo "FLIR.auto();".$this->eol();
     				}
     				echo '</script>'.$this->eol();
            break;
          default:
  					echo '<script type="text/javascript">'.$this->eol();
     				echo "FLIR.init({path:'$g_facelift_url'},new FLIRStyle({mode:'".$defaultMode."'".$setDefaultFancyFonts."}));".$this->eol();
     				if (!empty($this->adminConfig)) {
    					$flirConfig         		= $this->getAdminOptions($this->adminConfigName);
  	          $elementList            = $flirConfig['element_types'];
  	        }
  	        if (!empty($elementList)) {
  	          $autoElements = '';
  		      	foreach ($elementList as $key => $value) {
  							$autoElements .= "'".$value."',";
  			    	}
  			    	$autoElements = rtrim($autoElements, ',');
  			    	$autoElements = '['.$autoElements.']';
  		    	}
   					echo "FLIR.auto(".$autoElements.");".$this->eol();
   					echo '</script>'.$this->eol();
        }
		}

    /*---- Adds a link to the stylesheet to the header ----*/
    function add_css() {
      echo '<link rel="stylesheet" href="'.get_bloginfo('wpurl').'/wp-content/plugins/facelift-image-replacement/css/style.css" type="text/css" media="screen" />'.$this->eol();
    }

    function addAdminHeader() {
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
    function setSelected($theItem,$theArray) {
      $returnValue = false;
	    if (!empty($theArray)) {
		    foreach ($theArray as $key=>$value) {
			   if ($value == $theItem) { $returnValue = true; }
		    }
	    }
	   return $returnValue;
    }

    /*---- sets selected array items in multi select form field to selected ----*/
    function setItemSelected($theItem) {
	    if (!empty($theItem)) {
        $returnValue = 'true';
		  }
		  else {
        $returnValue = 'false';
      }
	   return $returnValue;
    }
    
    /*---- Reduce filename to acceptable array key ----*/
    function keyMaker($filename) {
      $replacePattern = "/(\.otf)|(\.ttf)|(-*_*\d*\s*)/i";
      $keyname = strtolower(preg_replace($replacePattern, '', $filename));
      return $keyname;
    }
    
    /*---- Writes facelift config file to facelift directory ----*/
    function writeConfig($configdata) {
      global $g_facelift_config_path;
      $handle = fopen($g_facelift_config_path, 'wb');
      fwrite($handle, $configdata);
      fclose($handle);
    }

    /*---- Clears facelift cache - and them some ----*/
    function clearCache($dirname) {
    	global $g_facelift_cache_path;
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
			if ($dirname != $g_facelift_cache_path){ 
  			rmdir($dirname);
  		}
			return true; 
    }
    
    function external_js() {
   		if (!empty($this->adminConfig)) {
    		$flirConfig         		= $this->getAdminOptions($this->adminConfigName);
	      $externalJavaScript     = $flirConfig['external_javascript'];
			}
			if ($externalJavaScript == 1) {
        return true;
      }
      else {
        return false;
      }
    }

    function detect_ie() {
   		if (!empty($this->adminConfig)) {
    		$flirConfig         		= $this->getAdminOptions($this->adminConfigName);
	      $dropIE                 = $flirConfig['drop_ie'];
			}
			if ($dropIE == 1) {
        $browser = get_browser();
        if ($browser->browser == "IE") {
          if ($browser->majorver <= 6) {
            return true;
          }
          else {
            return false;
          }
        }
        else {
          return false;        
        }
      }
    }
    
    
  }
}

/*---- instantiate the class ----*/
if (class_exists('wp_flir')) {
  $wp_flir = new wp_flir();
}
