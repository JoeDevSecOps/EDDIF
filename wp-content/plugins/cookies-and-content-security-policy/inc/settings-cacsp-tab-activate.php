<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
?>

<div class="cookies-and-content-security-policy-help">
	<?php
	echo '<p>' . __('Activate the plugin to use it.', 'cookies-and-content-security-policy' ) . '</p>';
	?>
</div>
<?php
$cacsp_option_actived = get_cacsp_options( 'cacsp_option_actived' );
?>
<table class="form-table">
	<tr>
		<td>
			<fieldset>
				<label for="cacsp_active_false">
					<?php if ( $cacsp_option_actived == 'false' ) {
						$checked = ' checked';
					} else {
						$checked = '';
					} ?>
					<input type="radio" name="cacsp_option_actived" id="cacsp_active_false" value="false"<?php echo $checked; ?>> 
						<strong><?php _e( 'Deactivated', 'cookies-and-content-security-policy' ); ?></strong>
						<small><?php _e( 'Do your settings without disturbing anyone. No modal or Content Security Policy will be used at all.', 'cookies-and-content-security-policy' ); ?></small>
				</label>
				<br>
				<label for="cacsp_active_admin">
					<?php if ( $cacsp_option_actived == 'admin' ) {
						$checked = ' checked';
					} else {
						$checked = '';
					} ?>
					<input type="radio" name="cacsp_option_actived" id="cacsp_active_admin" value="admin"<?php echo $checked; ?>> 
						<strong><?php _e( 'Admin', 'cookies-and-content-security-policy' ); ?></strong>
						<small><?php _e( 'Test your settings without disturbing your visitors. Modal and Content Security Policy will be used only for logged in users with Administrator role.', 'cookies-and-content-security-policy' ); ?></small>
				</label>
				<br>
				<label for="cacsp_active_true">
					<?php if ( $cacsp_option_actived == 'true' || $cacsp_option_actived == null ) {
						$checked = ' checked';
					} else {
						$checked = '';
					} ?>
					<input type="radio" name="cacsp_option_actived" id="cacsp_active_true" value="true"<?php echo $checked; ?>> 
						<strong><?php _e( 'Active', 'cookies-and-content-security-policy' ); ?></strong>
						<small><?php _e( 'We are live!', 'cookies-and-content-security-policy' ); ?></small>
				</label>
				<div class="submit">
					<input type="submit" name="save_cacsp_settings_activate" value="<?php _e( 'Save Settings' , 'cookies-and-content-security-policy' ); ?>" class="button-primary" />
				</div>
			</fieldset>
		</td>
	</tr>
</table>
