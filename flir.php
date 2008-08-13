<?php
/*
Plugin Name: FLIR for WordPress
Plugin URI: http://www.23systems.net/plugins/facelift-image-replacement-flir/
Description: Facelift Image Replacment for WordPress is a plugin and script is a script that generates image representations of text on your web page in fonts that visitors would not be able to see.  It is based on Facelift Image Replacement by <a href="http://facelift.mawhorter.net/">Cory Mawhorter</a>.
Author: Dan Zappone
Version: 0.5.7
Author URI: http://www.23systems.net/
*/
global $flir_path, $facelift_path, $flir_fonts, $fonts;
require('facelift/config-flir.php');
$flir_path     = WP_PLUGIN_URL.'/facelift-image-replacement';
$facelift_path = $flir_path.'/facelift/';
$flir_fonts    = $fonts;
if (!class_exists('wp_flir')) {

  class wp_flir {

    /*---- The name the options are saved under in the database ----*/
    var $adminOptionsName = "wp_flir_options";
    var $adminConfigName = "wp_flir_config";

    /*---- PHP 4 Compatible Constructor ----*/
    function wp_flir() {
      $this->__construct();
    }

    /*---- PHP 5 Constructor ----*/
    function __construct() {
      add_action("admin_menu", array(&$this, "add_admin_pages"));
      add_action("admin_head", array(&$this, "add_admin_css"));
      add_action("init", array(&$this, "add_scripts"));
      add_action('wp_footer', array(&$this, 'wp_footer_intercept'));
      add_action("wp_head", array(&$this, "add_css"));
      $this->adminOptions = $this->getAdminOptions($this->adminOptionsName);
      $this->adminConfig = $this->getAdminOptions($this->adminConfigName);
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
      global $flir_path, $facelift_path, $flir_fonts;
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
          $flir_elements_options = array(
            "elements"    => $flir_elements,
            "fonts"       => $flir_elements_fonts,
            "mode"        => $flir_elements_mode,
            "defaultmode" => $flir_default_mode,
          );
          $this->saveAdminOptions($this->adminOptionsName, $flir_elements_options);
        }
        elseif ($_POST['sub'] == 'config') {
          $flir_font_list               = array();
          $flir_unknown_font_size       = $_POST[unknown_font_size];
          $flir_cache_cleanup_frequency = $_POST[cache_cleanup_frequency];
          $flir_cache_keep_time         = $_POST[cache_keep_time];
          $flir_horizontal_text_bounds  = $_POST[horizontal_text_bounds];
          $flir_javascript_method       = $_POST[javascript_method];
          $flir_fonts_list              = $_POST[fonts_list];
          $flir_font_default            = $_POST[font_default];
          $flir_imagemagick_path        = $_POST[imagemagick_path];
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

          /*	        echo "unknown_font_size: ".$unknown_font_size."<br />";
                    echo "cache_cleanup_frequency: ".$cache_cleanup_frequency."<br />";
                    echo "cache_keep_time: ".$cache_keep_time."<br />";
          	        echo "horizontal_text_bounds: ".$horizontal_text_bounds."<br />";
                    echo "javascript_method: ".$javascript_method."<br />";
                    echo "fonts_list: ".$fonts_list."<br />";
                    if ($fonts_list){
          	 					foreach ($fonts_list as $f){echo "fonts_list: ".$f."<br />";}
          					}
          	        echo "font_default: ".$font_default."<br />";
                    echo "imagemagick_path: ".$imagemagick_path."<br />";
          */
        }
      }
      ?>
		<div class="wrap alternate">
			<h2><?php _e('FLIR for WordPress Configuration (v0.5.5 / Facelift v1.2b)', 'FLIR');?></h2>
			<br style="clear:both;" />
<?php
require('flir-config.php');
      require('flir-el.php');
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
      global $facelift_path;
      wp_enqueue_script("jquery");
      wp_enqueue_script('flir_script', $facelift_path.'flir.js', array("jquery"), 0.1);
    }

    /*---- Called by the action wp_footer ----*/
    function wp_footer_intercept() {
      global $facelift_path;
      if (!empty($this->adminOptions)) {
        $flir_options        = $this->getAdminOptions($this->adminOptionsName);
        $flir_elements       = $flir_options['elements'];
        $flir_elements_fonts = $flir_options['fonts'];
        $flir_elements_mode  = $flir_options['mode'];
        $flir_default_mode   = $flir_options['defaultmode'];
      }
      echo '<script type="text/javascript">'.$this->eol();
      echo "FLIR.init({path:'$facelift_path'},new FLIRStyle({mode:'".$flir_default_mode."'}));".$this->eol();
      if (!empty($flir_elements)) {
        echo 'jQuery(function($){'.$this->eol();
        echo '    $(document).ready(function(){'.$this->eol();
        foreach ($flir_elements as $key => $value) {
          echo '    $("'.$value.'").each( function() { FLIR.replace(this, new FLIRStyle({mode:\''.$flir_elements_mode[$key].'\',cFont:\''.$flir_elements_fonts[$key].'\'}));});'.$this->eol();
        }
        echo '    });'.$this->eol();
        echo '});'.$this->eol();
      }
      else {
        echo "FLIR.auto();".$this->eol();
      }
      echo '</script>;'.$this->eol();
    }

    /*---- Adds a link to the stylesheet to the header ----*/
    function add_css() {
      echo '<link rel="stylesheet" href="'.get_bloginfo('wpurl').'/wp-content/plugins/facelift-image-replacement/css/style.css" type="text/css" media="screen" />'.$this->eol();
    }

    function add_admin_css() {
      echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('wpurl').'/wp-content/plugins/facelift-image-replacement/css/admin.css" />'.$this->eol();
    }

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
  }
}

/*---- instantiate the class ----*/
if (class_exists('wp_flir')) {
  $wp_flir = new wp_flir();
}
