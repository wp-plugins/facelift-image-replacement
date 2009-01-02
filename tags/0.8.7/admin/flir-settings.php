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
			
			<div id="poststuff" class="flir">
      	<div class="postbox">
      	<h3><?php _e('About FLIR for WordPress',"FLIR"); ?>: </h3>
      	<div class="inside">
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="float:right;"> <input name="cmd" type="hidden" value="_donations" /> <input name="business" type="hidden" value="dzappone@gmail.com" /> <input name="item_name" type="hidden" value="Dan Zappone" /> <input name="item_number" type="hidden" value="23SDONWP" /> <input name="no_shipping" type="hidden" value="0" /> <input name="no_note" type="hidden" value="1" /> <input name="currency_code" type="hidden" value="EUR" /> <input name="tax" type="hidden" value="0" /> <input name="lc" type="hidden" value="US" /> <input name="bn" type="hidden" value="PP-DonationsBF" /> <input alt="PayPal - The safer, easier way to pay online!" name="submit" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" type="image" /> <img src="https://www.paypal.com/en_US/i/scr/pixel.gif" border="0" alt="" width="1" height="1" />
</form>
					<h4><?php _e('Thank you for downloading and installing FLIR for WordPress',"FLIR"); ?></h4>
					<?php _e('Like many developers I spend a lot of my spare time working on WordPress plugins and themes and any donation to the cause is appreciated.  I know a lot of other developers do the same and I try to donate to them whenever I can.  As a developer I greatly appreciate any donation you can make to help support further development of quality plugins and themes for WordPress.  In keeping with the name of this my site <a href="http://www.23systems.net">23Systems</a> a donation of &euro;2.30 to &euro;23.00 is encouraged but I\'ll gladly accept whatever you feel comfortable with.  <em>You have my sincere thanks and appreciation</em>.',"FLIR"); ?>
						</div>
			</div>
			</div>