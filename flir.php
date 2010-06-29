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

    if (!function_exists('wp_flir_deactivation')) {
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
    }

    register_deactivation_hook(__FILE__, 'wp_flir_deactivation');

    require_once('actions.class.php');
    require_once('utility.class.php');
    require_once('init.class.php');

    if (!class_exists('wp_flir')) {
        class wp_flir extends init_flir {

            /**
            * The name the options are saved under in the database
            * 
            * @var mixed
            */
            var $adminOptionsName = "wp_flir_options";
            var $adminConfigName = "wp_flir_config";
            var $adminInitName = "wp_flir_init";

            /**
            * PHP 4 Compatible Constructor
            */
            function wp_flir() {
                $this->__construct();
            }

            /**
            * PHP 5 Constructor
            */
            function __construct() {
                add_filter( 'plugin_row_meta',array( &$this, 'RegisterFLIRLinks'),10,2);
                add_action("admin_menu", array(&$this, "addAdminPages"));
                add_action("admin_head", array(&$this, "addAdminHeader"));
                $this->adminOptions = $this->getAdminOptions($this->adminOptionsName);
                $this->adminConfig = $this->getAdminOptions($this->adminConfigName);
                if (!($this->detect_ie())) {
                    add_action("init", array(&$this, "addScripts"));
                    add_action("wp_footer", array(&$this, 'flirAddFooter'));
                }
                add_action( 'admin_footer', array( &$this, 'flirAddFooter' ) );
                $this->adminInit = get_option($this->adminInitName);

                if (!$this->adminInit) {
                    $this->flirInit();
                }
            }

            /**
            * Retrieves the options from the database.
            * 
            * @param mixed $optionsname
            * @return array
            */
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

            /**
            * Saves the admin options to the database using the name of option and the options as params
            * 
            * @param mixed $optionsname
            * @param mixed $options
            */
            function saveAdminOptions($optionsname, $options) {
                update_option($optionsname, $options);
            }

            function RegisterFLIRLinks($links, $file) {
                $base = plugin_basename(__FILE__);
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

            /**
            * Outputs the HTML for the admin sub page.
            */
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
                        $cacheDir               = 'cache';
                        $fontDir                = 'fonts';
                        $pluginDir              = 'plugins';
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
                        "cache_single_dir"        => $cacheSingleDir,
                        "cache_dir"               => $cacheDir,
                        "font_dir"                => $fontDir,
                        "plugin_dir"              => $pluginDir,
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

                        require('admin/flir.write.php');
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
                /**
                * Notify FLIR status
                * 
                * @var mixed
                */
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
                <h2><?php _e('FLIR for WordPress Configuration v0.9 (Facelift v2.0b3)', 'FLIR');?></h2>
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
                jQuery('.postbox .close-me').each(function() {
                    jQuery(this).addClass("closed");
                });

                jQuery('#lbp_message').each(function() {
                    jQuery(this).fadeOut(5000);
                });

                jQuery('.postbox h3').click( function() {
                    jQuery(this).next('.toggle').slideToggle('fast');
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

    }
}

/**
* Instantiate the class
*/
if (class_exists('wp_flir')) {
    $wp_flir = new wp_flir();
}
