<?php
/*
Plugin Name: FLIR for WordPress
Plugin URI: http://www.23systems.net/plugins/facelift-image-replacement-flir/
Description: Facelift Image Replacment for WordPress is a plugin and script is a script that generates image representations of text on your web page in fonts that visitors would not be able to see.  It is based on Facelift Image Replacement by <a href="http://facelift.mawhorter.net/">Cory Mawhorter</a>.
Author: Dan Zappone
Version: 0.5.5
Author URI: http://www.23systems.net/
*/
global $flir_path, $facelift_path, $flir_fonts,$fonts;

require('facelift/config-flir.php');

$flir_path = 'wp-content/plugins/facelift-image-replacement';
$facelift_path = '/wp-content/plugins/facelift-image-replacement/facelift/';
$flir_fonts = $fonts;

if (!class_exists('wp_flir')) {
   class wp_flir	{

/*---- Admin Header ----*/

		/*---- The name the options are saved under in the database ----*/
		var $adminOptionsName = "wp_flir_options";

   	/*---- PHP 4 Compatible Constructor ----*/
   	function wp_flir(){
         $this->__construct();
      }
   
   	/*---- PHP 5 Constructor ----*/
   	function __construct(){
         add_action("admin_menu", array(&$this,"add_admin_pages"));
         add_action("admin_head", array(&$this,"add_admin_css"));
         add_action("init", array(&$this,"add_scripts"));
         add_action('wp_footer', array(&$this,'wp_footer_intercept'));
         add_action("wp_head", array(&$this,"add_css"));
         
         $this->adminOptions = $this->getAdminOptions();
   	}
   
		/*---- Retrieves the options from the database.  @return array ----*/
		function getAdminOptions() {

		    $savedOptions = get_option($this->adminOptionsName);
		    if (!empty($savedOptions)) {
		       foreach ($savedOptions as $key => $option) {
               $adminOptions[$key] = $option;
			    }
		    }
		    update_option($this->adminOptionsName, $adminOptions);
		    return $adminOptions;
		}
		
		/*---- Saves the admin options to the database. ----*/
		function saveAdminOptions(){
		    update_option($this->adminOptionsName, $this->adminOptions);
		}
		
		function add_admin_pages(){
			add_submenu_page('themes.php', "FLIR", "FLIR", 10, "FLIR", array(&$this,"output_sub_admin_page_0"));
		}
		
		/*---- Outputs the HTML for the admin sub page. ----*/
		function output_sub_admin_page_0(){
		global $flir_path, $facelift_path, $flir_fonts;
		
		$flir_modes = array();
		$flir_modes[1] = 'static';
		$flir_modes[2] = 'progressive';
		$flir_modes[3] = 'wrap';
		
		if ( $_POST['action'] ) {
		 $flir_elements = $_POST[flir_elements];
		 $flir_elements_fonts = $_POST[flir_element_fonts];
		 $flir_elements_mode = $_POST[flir_mode];
		 $flir_default_mode = $_POST[flir_default_mode];
		
/*   	 echo "Elements: ".$flir_elements."<br />";
		 echo "Fonts: ".$flir_elements_fonts."<br />";
		 echo "Mode: ".$flir_elements_mode."<br />"; */
	
		 $this->adminOptions = array("elements" =>  $flir_elements, "fonts" => $flir_elements_fonts,"mode" => $flir_elements_mode,"defaultmode" =>$flir_default_mode);
		 $this->saveAdminOptions();
		}
		
			?>
			<div class="wrap alternate">
			<h2><?php _e('FLIR for WordPress Configuration (v0.5.5 / Facelift v1.2b)','FLIR'); ?></h2>
			<form action="?page=FLIR" method="post" id="flir_options" name="flir_options">
<!--            <h3><?php // _e('Default Font',"FLIR"); ?>: </h3>
               <select name="flir_fonts">
                  <option value="default">Default</option><?php //if (!empty($flir_fonts)) {foreach ( $flir_fonts as $key=>$value) {echo '<option ';/*if ($_POST['actionable_category']==$f->actionable_id) echo 'selected="selected"';*/echo 'value="'.$value.'">'.ucfirst($key).'</option>';}}?></select>
                  <br /><?php //_e('Blah blah blach.',"FLIR"); ?> -->
                  <?php 
         if (!empty($this->adminOptions)) {
   		   $flir_options = $this->getAdminOptions();
            $flir_elements = $flir_options['elements'];
   		   $flir_elements_fonts = $flir_options['fonts'];
            $flir_elements_mode = $flir_options['mode'];
            $flir_default_mode = $flir_options['defaultmode'];
		   }
                  ?>
            <h3><?php _e('Elements to Replace',"FLIR"); ?>: </h3>
           <table class="widefat">
            <thead>
            <tr valign="top">
               <th scope="col">Element</th>
               <th scope="col">Use</th>
               <th scope="col">Font</th>
               <th scope="col">Mode</th>
               <th scope="col">Effect</th>
            </tr>
            </thead>
            <tr>
               <td>Heading 1</td><td><input type="checkbox" name="flir_elements[1]" value="h1"<?php if ($flir_elements[1]) echo ' checked="checked"';?> /></td><td><select name="flir_element_fonts[1]"><option value="">N/A</option><?php if (!empty($flir_fonts)) {foreach ( $flir_fonts as $key=>$value) {echo '<option ';if ($flir_elements_fonts[1]==$key) echo 'selected="selected" ';echo 'value="'.$key.'">'.ucfirst($key).'</option>';}}?></select></td>
               <td>
                  <select name="flir_mode[1]">
                     <?php if (!empty($flir_modes)) {foreach ( $flir_modes as $value) {echo '<option ';if ($flir_elements_mode[1]==$value) echo 'selected="selected" ';echo 'value="'.$value.'">'.ucfirst($value).'</option>';}}?>
                  </select>
               </td>
               <td>Forthcoming</td>
            </tr>
            <tr>
               <td>Heading 2</td><td><input type="checkbox" name="flir_elements[2]" value="h2"<?php if ($flir_elements[2]) echo ' checked="checked"';?> /></td><td><select name="flir_element_fonts[2]"><option value="">N/A</option><?php if (!empty($flir_fonts)) {foreach ( $flir_fonts as $key=>$value) {echo '<option ';if ($flir_elements_fonts[2]==$key) echo 'selected="selected" ';echo 'value="'.$key.'">'.ucfirst($key).'</option>';}}?></select></td>
               <td>
                  <select name="flir_mode[2]">
                     <?php if (!empty($flir_modes)) {foreach ( $flir_modes as $value) {echo '<option ';if ($flir_elements_mode[2]==$value) echo 'selected="selected" ';echo 'value="'.$value.'">'.ucfirst($value).'</option>';}}?>
                  </select>
               </td>
               <td>&nbsp;</td>
            </tr>
            <tr>
               <td>Heading 3</td><td><input type="checkbox" name="flir_elements[3]" value="h3"<?php if ($flir_elements[3]) echo ' checked="checked"';?> /></td><td><select name="flir_element_fonts[3]"><option value="">N/A</option><?php if (!empty($flir_fonts)) {foreach ( $flir_fonts as $key=>$value) {echo '<option ';if ($flir_elements_fonts[3]==$key) echo 'selected="selected" ';echo 'value="'.$key.'">'.ucfirst($key).'</option>';}}?></select></td>
               <td>
                  <select name="flir_mode[3]">
                     <?php if (!empty($flir_modes)) {foreach ( $flir_modes as $value) {echo '<option ';if ($flir_elements_mode[3]==$value) echo 'selected="selected" ';echo 'value="'.$value.'">'.ucfirst($value).'</option>';}}?>
                  </select>
               </td>
               <td>&nbsp;</td>
            </tr>
            <tr>
               <td>Heading 4</td><td><input type="checkbox" name="flir_elements[4]" value="h4"<?php if ($flir_elements[4]) echo ' checked="checked"';?> /></td><td><select name="flir_element_fonts[4]"><option value="">N/A</option><?php if (!empty($flir_fonts)) {foreach ( $flir_fonts as $key=>$value) {echo '<option ';if ($flir_elements_fonts[4]==$key) echo 'selected="selected" ';echo 'value="'.$key.'">'.ucfirst($key).'</option>';}}?></select></td>
               <td>
                  <select name="flir_mode[4]">
                     <?php if (!empty($flir_modes)) {foreach ( $flir_modes as $value) {echo '<option ';if ($flir_elements_mode[4]==$value) echo 'selected="selected" ';echo 'value="'.$value.'">'.ucfirst($value).'</option>';}}?>
                  </select>
               </td>
               <td>&nbsp;</td>
            </tr>
            <tr>
               <td>Heading 5</td><td><input type="checkbox" name="flir_elements[5]" value="h5"<?php if ($flir_elements[5]) echo ' checked="checked"';?> /></td><td><select name="flir_element_fonts[5]"><option value="">N/A</option><?php if (!empty($flir_fonts)) {foreach ( $flir_fonts as $key=>$value) {echo '<option ';if ($flir_elements_fonts[5]==$key) echo 'selected="selected" ';echo 'value="'.$key.'">'.ucfirst($key).'</option>';}}?></select></td>
               <td>
                  <select name="flir_mode[5]">
                     <?php if (!empty($flir_modes)) {foreach ( $flir_modes as $value) {echo '<option ';if ($flir_elements_mode[5]==$value) echo 'selected="selected" ';echo 'value="'.$value.'">'.ucfirst($value).'</option>';}}?>
                  </select>
               </td>               
               <td>&nbsp;</td>
            </tr>
            <tr>
               <td>Heading 6</td><td><input type="checkbox" name="flir_elements[6]" value="h6"<?php if ($flir_elements[6]) echo ' checked="checked"';?> /></td><td><select name="flir_element_fonts[6]"><option value="">N/A</option><?php if (!empty($flir_fonts)) {foreach ( $flir_fonts as $key=>$value) {echo '<option ';if ($flir_elements_fonts[6]==$key) echo 'selected="selected" ';echo 'value="'.$key.'">'.ucfirst($key).'</option>';}}?></select></td>
               <td>
                  <select name="flir_mode[6]">
                     <?php if (!empty($flir_modes)) {foreach ( $flir_modes as $value) {echo '<option ';if ($flir_elements_mode[6]==$value) echo 'selected="selected" ';echo 'value="'.$value.'">'.ucfirst($value).'</option>';}}?>
                  </select>
               </td>
               <td>&nbsp;</td>
            </tr>
            <tr>
               <td>Small</td><td><input type="checkbox" name="flir_elements[7]" value="small"<?php if ($flir_elements[7]) echo ' checked="checked"';?> /></td><td><select name="flir_element_fonts[7]"><option value="">N/A</option><?php if (!empty($flir_fonts)) {foreach ( $flir_fonts as $key=>$value) {echo '<option ';if ($flir_elements_fonts[7]==$key) echo 'selected="selected" ';echo 'value="'.$key.'">'.ucfirst($key).'</option>';}}?></select></td>
               <td>
                  <select name="flir_mode[7]">
                     <?php if (!empty($flir_modes)) {foreach ( $flir_modes as $value) {echo '<option ';if ($flir_elements_mode[7]==$value) echo 'selected="selected" ';echo 'value="'.$value.'">'.ucfirst($value).'</option>';}}?>
                  </select>
               </td>
               <td>&nbsp;</td>
            </tr>
            <tr>
               <td>Strong / Bold </td><td><input type="checkbox" name="flir_elements[8]" value="strong"<?php if ($flir_elements[8]) echo ' checked="checked"';?> /></td><td><select name="flir_element_fonts[8]"><option value="">N/A</option><?php if (!empty($flir_fonts)) {foreach ( $flir_fonts as $key=>$value) {echo '<option ';if ($flir_elements_fonts[8]==$key) echo 'selected="selected" ';echo 'value="'.$key.'">'.ucfirst($key).'</option>';}}?></select></td>
               <td>
                  <select name="flir_mode[8]">
                     <?php if (!empty($flir_modes)) {foreach ( $flir_modes as $value) {echo '<option ';if ($flir_elements_mode[8]==$value) echo 'selected="selected" ';echo 'value="'.$value.'">'.ucfirst($value).'</option>';}}?>
                  </select>
               </td>
               <td>&nbsp;</td>
            </tr>
            <tr>
               <td>Emphasis / Italic </td><td><input type="checkbox" name="flir_elements[9]" value="em"<?php if ($flir_elements[9]) echo ' checked="checked"';?> /></td><td><select name="flir_element_fonts[9]"><option value="">N/A</option><?php if (!empty($flir_fonts)) {foreach ( $flir_fonts as $key=>$value) {echo '<option ';if ($flir_elements_fonts[9]==$key) echo 'selected="selected" ';echo 'value="'.$key.'">'.ucfirst($key).'</option>';}}?></select></td>
               <td>
                  <select name="flir_mode[9]">
                     <?php if (!empty($flir_modes)) {foreach ( $flir_modes as $value) {echo '<option ';if ($flir_elements_mode[9]==$value) echo 'selected="selected" ';echo 'value="'.$value.'">'.ucfirst($value).'</option>';}}?>
                  </select>
               </td>
               <td>&nbsp;</td>
            </tr>
         </table>
         <h3><?php _e('Default Mode',"FLIR"); ?>: </h3>
                  <select name="flir_default_mode">
                     <?php if (!empty($flir_modes)) {foreach ( $flir_modes as $value) {echo '<option ';if ($flir_default_mode==$value) echo 'selected="selected" ';echo 'value="'.$value.'">'.ucfirst($value).'</option>';}}?>
                  </select>
         <p class="submit"><input type="submit" class="btn" name="save" style="padding:5px 30px 5px 30px;" value="<?php _e('Save Configuration',"FLIR"); ?>" /></p>
				<input type="hidden" name="action" value="action" />
         </form>
			</div>
			<?php
		} 
   
   	/*---- load JavaScripts scripts ----*/
        function add_scripts(){
            global $facelift_path;
            wp_enqueue_script("jquery");
            wp_enqueue_script('flir_script', $facelift_path.'flir.js', array("jquery") , 0.1);
   	}
   
   	/*---- Called by the action wp_footer ----*/
        function wp_footer_intercept(){
            global $facelift_path;

            if (!empty($this->adminOptions)) {
                $flir_options = $this->getAdminOptions();
                $flir_elements = $flir_options['elements'];
                $flir_elements_fonts = $flir_options['fonts'];
                $flir_elements_mode = $flir_options['mode'];
                $flir_default_mode = $flir_options['defaultmode'];
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
            echo "</script>;".$this->eol();
        }
   	
   	/*---- Adds a link to the stylesheet to the header ----*/
		function add_css(){
            echo '<link rel="stylesheet" href="'.get_bloginfo('wpurl').'/wp-content/plugins/facelift-image-replacement/css/style.css" type="text/css" media="screen" />'.$this->eol();
		}
		
        function add_admin_css() {
            echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('wpurl').'/wp-content/plugins/facelift-image-replacement/css/admin.css" />'.$this->eol();
      }
      
      /*---- Create clean eols for source ----*/
      function eol() {
         if (strtoupper(substr(PHP_OS,0,3)=='WIN')) {
            $eol="\r\n";
         } elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) {
            $eol="\r";
         } else {
            $eol="\n";
         }
         return $eol;
      }
   }
}

/*---- instantiate the class ----*/
if (class_exists('wp_flir')) {
	$wp_flir = new wp_flir();
}
?>