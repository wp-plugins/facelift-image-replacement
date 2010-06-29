<?php
    if (!class_exists('init_flir')) {
        class init_flir extends utility_flir {
            /**
            * Initialize or re-initialize FLIR
            */
            /**
            * TODO -c rewrite, important -o Dan Zappone: Rewrite initialization as it doesn't work!
            * 
            */
            function flirInit(){
                global $g_facelift_fonts_path;

                if (!empty($this->adminConfig)) {
                    add_option('wp_flir_init', true);

                    $flirConfig             = $this->getAdminOptions($this->adminConfigName);
                    $unknownFontSize        = $flirConfig['unknown_font_size'];
                    $cacheCleanupFrequency  = $flirConfig['cache_cleanup_frequency'];
                    $cacheKeepTime          = $flirConfig['cache_keep_time'];
                    $cacheSingleDir         = $flirConfig['cache_single_dir'];
                    $cacheDir               = 'cache';
                    $fontDir                = 'fonts';
                    $pluginDir              = 'plugins';
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
                                $newKey                 = $this->keyMaker($file);
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
                    $cacheDir               = 'cache';
                    $fontDir                = 'fonts';
                    $pluginDir              = 'plugins';
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
                    $this->saveAdminOptions($this->adminConfigName, $configOptions);
                }
                require('admin/flir.write.php');

            }  

        }

    }
?>
