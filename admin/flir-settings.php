			<div id="poststuff" class="flir">
      	<div class="postbox close-me">
      	<h3><?php _e('FLIR for WordPress Utilities',"FLIR"); ?>: </h3>
      	<div class="inside">
					<form action="?page=FLIR" method="post" id="flir_settings" name="flir_settings">
					<table>
					<tr><td valign="top"><strong><?php _e('Clear Cache',"FLIR"); ?>: </strong></td><td valign="top">
							<input type="checkbox" name="clear_cache" value="1" />
						</td><td valign="top"><small><?php _e('This will immediately clear the FLIR cache',"FLIR"); ?></small></td>
					</tr>
					<tr><td valign="top"><strong><?php _e('Reinitialize FLIR',"FLIR"); ?>: </strong></td><td valign="top">
							<input type="checkbox" name="reinit_flir" value="1" />
						</td><td valign="top"><small><?php _e('This will immediately clear the FLIR cache, and reinitialize the plugin deleting all existing settings',"FLIR"); ?></small></td>
					</tr>
					</table>
					<p class="submit"><input type="submit" class="btn" name="save" style="padding:5px 30px 5px 30px;" value="<?php _e('Update FLIR Settings',"FLIR"); ?>" /></p>
					<input type="hidden" name="action" value="action" /><input type="hidden" name="sub" value="settings" />
         </form>
			</div>
			</div>
			</div>
			