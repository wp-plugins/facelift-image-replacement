<?php
    /**
    * UTILITY FUNCTIONS
    */
    if (!class_exists('utility_flir')) {
        class utility_flir extends actions_flir {

            /**
            * Create clean eols for source
            * 
            * @return string
            */
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

            /**
            * Create clean eols for source
            * 
            * @param mixed $pathname
            * @return mixed
            */
            function winPath($pathname) {
                if (strtoupper(substr(PHP_OS, 0, 3) == 'WIN')) {
                    $path = str_replace('/', '\\', $pathname);
                }
                return $path;
            }

            /**
            * Sets selected array items in multi select form field to selected
            * 
            * @param mixed $theItem
            */
            function setSelected($theItem,$theArray) {
                $returnValue = false;
                if (!empty($theArray)) {
                    foreach ($theArray as $key=>$value) {
                        if ($value == $theItem) { $returnValue = true; }
                    }
                }
                return $returnValue;
            }

            /**
            * Sets selected array items in single select form field to selected
            * 
            * @param mixed $theItem
            */
            function setItemSelected($theItem) {
                if (!empty($theItem)) {
                    $returnValue = 'true';
                }
                else {
                    $returnValue = 'false';
                }
                return $returnValue;
            }

            /**
            * Reduce filename to acceptable array key
            * 
            * @param mixed $filename
            * @return string
            */
            function keyMaker($filename) {
                $replacePattern = "/(\.otf)|(\.ttf)|(-*_*\d*\s*)/i";
                $keyname = strtolower(preg_replace($replacePattern, '', $filename));
                return $keyname;
            }

            /**
            * Writes facelift config file to facelift directory
            * 
            * @param mixed $dirname
            */
            function writeConfig($configdata) {
                global $g_facelift_config_path;
                $handle = fopen($g_facelift_config_path, 'wb');
                fwrite($handle, $configdata);
                fclose($handle);
            }

            /**
            * Clears facelift cache - and them some
            * 
            * @param mixed $dirname
            */
            function clearCache($dirname) {
                global $g_facelift_cache_path;
                if(is_dir($dirname)){
                    $dir_handle = opendir($dirname);
                } 
                while($file = readdir($dir_handle)) { 
                    if($file != "." && $file != ".." && $file != '.svn' && $file != 'index.html') { 
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

            /**
            * Allow user to load external JavaScript library instead of WP built in versions
            */
            function external_js() {
                if (!empty($this->adminConfig)) {
                    $flirConfig             = $this->getAdminOptions($this->adminConfigName);
                    $externalJavaScript     = $flirConfig['external_javascript'];
                }
                if ($externalJavaScript == 1) {
                    return true;
                }
                else {
                    return false;
                }
            }

            /**
            * Detect if IE v6 to disable FLIR is option is selected
            */
            function detect_ie() {
                if (!empty($this->adminConfig)) {
                    $flirConfig  = $this->getAdminOptions($this->adminConfigName);
                    $dropIE      = $flirConfig['drop_ie'];
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
?>
