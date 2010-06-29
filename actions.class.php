<?php
    if (!class_exists('actions_flir')) {
        class actions_flir {

            /**
            * Add new panel to WordPress under the Appearance category
            */
            function addAdminPages() {
                add_theme_page( "FLIR for WordPress", "FLIR for WordPress", 'manage_options', "FLIR", array( &$this, "outputSubAdminPage" ) );
            }

            /**
            *  Add CSS styles to Admin Panel page headers to display FLIR panel correctly
            */
            function addAdminHeader() {
                echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('wpurl').'/wp-content/plugins/facelift-image-replacement/css/admin.css" />'.$this->eol();
            }

            /**
            * load JavaScripts scripts for FLIR to work and if admin panel load additional JavaScript for jQueryUI
            */
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
                if (is_admin()) {
                    wp_enqueue_script( 'lightbox', $g_lightbox_plus_url.'/js/jquery.colorbox-min.js', array( 'jquery','jquery-ui-core','jquery-ui-dialog' ), '1.4.2', true);
                }
            }

            /**
            * Add addtional elements to the footer for FLIR to work
            * 
            */
            function flirAddFooter() {
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
                            foreach ($elementsForFlir as $key => $value) {
                                if ($elementFancyFonts[$key] == $value) { $fancyFonts = ", mode:'fancyfonts'"; } else { $fancyFonts = ""; }
                                echo '    $("'.$value.'").each( function() { FLIR.replace(this, new FLIRStyle({mode:\''.$elementMode[$key].'\',cFont:\''.$elementFonts[$key].'\''.$fancyFonts.'}));});'.$this->eol();
                            }
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
                            $flirConfig                 = $this->getAdminOptions($this->adminConfigName);
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

        }
    }

?>
