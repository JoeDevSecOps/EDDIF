<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
?>

<div class="cookies-and-content-security-policy-help">
	<?php
	echo '<p>';
		_e( 'You don\'t have to fill out this form, the plugin comes with default colors. But if you want to change the colors, this is it.', 'cookies-and-content-security-policy' );
	echo '</p>';
	?>
</div>
<?php
$cacsp_option_color_backdrop = get_cacsp_options( 'cacsp_option_color_backdrop', false, '', true );
$cacsp_option_color_modal_bg = get_cacsp_options( 'cacsp_option_color_modal_bg', false, '', true );
$cacsp_option_color_modal_header_bg = get_cacsp_options( 'cacsp_option_color_modal_header_bg', false, '', true );
$cacsp_option_color_modal_list_border = get_cacsp_options( 'cacsp_option_color_modal_list_border', false, '', true );
$cacsp_option_color_modal_text_color = get_cacsp_options( 'cacsp_option_color_modal_text_color', false, '', true );
$cacsp_option_color_modal_header_text_color = get_cacsp_options( 'cacsp_option_color_modal_header_text_color', false, '', true );
$cacsp_option_color_text_on = get_cacsp_options( 'cacsp_option_color_text_on', false, '', true );
$cacsp_option_color_off = get_cacsp_options( 'cacsp_option_color_off', false, '', true );
$cacsp_option_color_on = get_cacsp_options( 'cacsp_option_color_on', false, '', true );
$cacsp_option_color_settings_button = get_cacsp_options( 'cacsp_option_color_settings_button', false, '', true );
$cacsp_option_color_settings_button_border = get_cacsp_options( 'cacsp_option_color_settings_button_border', false, '', true );
$cacsp_option_color_settings_button_text = get_cacsp_options( 'cacsp_option_color_settings_button_text', false, '', true );
$cacsp_option_color_refuse_button = get_cacsp_options( 'cacsp_option_color_refuse_button', false, '', true );
$cacsp_option_color_refuse_button_border = get_cacsp_options( 'cacsp_option_color_refuse_button_border', false, '', true );
$cacsp_option_color_refuse_button_text = get_cacsp_options( 'cacsp_option_color_refuse_button_text', false, '', true );
$cacsp_option_color_save_button = get_cacsp_options( 'cacsp_option_color_save_button', false, '', true );
$cacsp_option_color_save_button_border = get_cacsp_options( 'cacsp_option_color_save_button_border', false, '', true );
$cacsp_option_color_save_button_text = get_cacsp_options( 'cacsp_option_color_save_button_text', false, '', true );
$cacsp_option_color_accept_button = get_cacsp_options( 'cacsp_option_color_accept_button', false, '', true );
$cacsp_option_color_accept_button_border = get_cacsp_options( 'cacsp_option_color_accept_button_border', false, '', true );
$cacsp_option_color_accept_button_text = get_cacsp_options( 'cacsp_option_color_accept_button_text', false, '', true );
?>
<h2><?php _e( 'Colors', 'cookies-and-content-security-policy' ); ?></h2>
<p><?php _e( 'Use the default colors or pick you own here.', 'cookies-and-content-security-policy' ); ?></p>
<h3><?php _e( 'Backgrounds', 'cookies-and-content-security-policy' ); ?></h3>
<table class="form-table">
	<tr>
		<th scope="row">
			<?php _e( 'Backdrop', 'cookies-and-content-security-policy' ); ?>
		</th>
		<td>
			<input name="cacsp_option_color_backdrop" type="text" id="cacsp_option_color_backdrop" value="<?php echo $cacsp_option_color_backdrop; ?>" class="cacsp-color">
		</td>
	</tr>
	<tr>
		<th scope="row">
			<?php _e( 'Modal background', 'cookies-and-content-security-policy' ); ?>
		</th>
		<td>
			<input name="cacsp_option_color_modal_bg" type="text" id="cacsp_option_color_modal_bg" value="<?php echo $cacsp_option_color_modal_bg; ?>" class="cacsp-color">
		</td>
	</tr>
	<tr>
		<th scope="row">
			<?php _e( 'Modal header background', 'cookies-and-content-security-policy' ); ?>
		</th>
		<td>
			<input name="cacsp_option_color_modal_header_bg" type="text" id="cacsp_option_color_modal_header_bg" value="<?php echo $cacsp_option_color_modal_header_bg; ?>" class="cacsp-color">
		</td>
	</tr>
	<tr>
		<th scope="row">
			<?php _e( 'Modal list border', 'cookies-and-content-security-policy' ); ?>
		</th>
		<td>
			<input name="cacsp_option_color_modal_list_border" type="text" id="cacsp_option_color_modal_list_border" value="<?php echo $cacsp_option_color_modal_list_border; ?>" class="cacsp-color">
		</td>
	</tr>
</table>
<h3><?php _e( 'Texts', 'cookies-and-content-security-policy' ); ?></h3>
<table class="form-table">
	<tr>
		<th scope="row">
			<?php _e( 'Modal text color', 'cookies-and-content-security-policy' ); ?>
		</th>
		<td>
			<input name="cacsp_option_color_modal_text_color" type="text" id="cacsp_option_color_modal_text_color" value="<?php echo $cacsp_option_color_modal_text_color; ?>" class="cacsp-color">
		</td>
	</tr>
	<tr>
		<th scope="row">
			<?php _e( 'Modal text header color', 'cookies-and-content-security-policy' ); ?>
		</th>
		<td>
			<input name="cacsp_option_color_modal_header_text_color" type="text" id="cacsp_option_color_modal_header_text_color" value="<?php echo $cacsp_option_color_modal_header_text_color; ?>" class="cacsp-color">
		</td>
	</tr>
	<tr>
		<th scope="row">
			<?php _e( 'On switch, text color', 'cookies-and-content-security-policy' ); ?>
		</th>
		<td>
			<input name="cacsp_option_color_text_on" type="text" id="cacsp_option_color_text_on" value="<?php echo $cacsp_option_color_text_on; ?>" class="cacsp-color">
		</td>
	</tr>
</table>
<h3><?php _e( 'Buttons', 'cookies-and-content-security-policy' ); ?></h3>
<table class="form-table">
	<tr>
		<th scope="row">
			<?php _e( 'Off switch', 'cookies-and-content-security-policy' ); ?>
		</th>
		<td>
			<input name="cacsp_option_color_off" type="text" id="cacsp_option_color_off" value="<?php echo $cacsp_option_color_off; ?>" class="cacsp-color">
		</td>
	</tr>
	<tr>
		<th scope="row">
			<?php _e( 'On switch', 'cookies-and-content-security-policy' ); ?>
		</th>
		<td>
			<input name="cacsp_option_color_on" type="text" id="cacsp_option_color_on" value="<?php echo $cacsp_option_color_on; ?>" class="cacsp-color">
		</td>
	</tr>
	<tr>
		<th scope="row">
			<?php _e( 'Settings button color', 'cookies-and-content-security-policy' ); ?>
		</th>
		<td>
			<input name="cacsp_option_color_settings_button" type="text" id="cacsp_option_color_settings_button" value="<?php echo $cacsp_option_color_settings_button; ?>" class="cacsp-color">
		</td>
	</tr>
	<tr>
		<th scope="row">
			<?php _e( 'Settings button border', 'cookies-and-content-security-policy' ); ?>
		</th>
		<td>
			<input name="cacsp_option_color_settings_button_border" type="text" id="cacsp_option_color_settings_button_border" value="<?php echo $cacsp_option_color_settings_button_border; ?>" class="cacsp-color">
		</td>
	</tr>
	<tr>
		<th scope="row">
			<?php _e( 'Settings button text', 'cookies-and-content-security-policy' ); ?>
		</th>
		<td>
			<input name="cacsp_option_color_settings_button_text" type="text" id="cacsp_option_color_settings_button_text" value="<?php echo $cacsp_option_color_settings_button_text; ?>" class="cacsp-color">
		</td>
	</tr>
	<tr>
		<th scope="row">
			<?php _e( 'Refuse button color', 'cookies-and-content-security-policy' ); ?>
		</th>
		<td>
			<input name="cacsp_option_color_refuse_button" type="text" id="cacsp_option_color_refuse_button" value="<?php echo $cacsp_option_color_refuse_button; ?>" class="cacsp-color">
		</td>
	</tr>
	<tr>
		<th scope="row">
			<?php _e( 'Refuse button border', 'cookies-and-content-security-policy' ); ?>
		</th>
		<td>
			<input name="cacsp_option_color_refuse_button_border" type="text" id="cacsp_option_color_refuse_button_border" value="<?php echo $cacsp_option_color_refuse_button_border; ?>" class="cacsp-color">
		</td>
	</tr>
	<tr>
		<th scope="row">
			<?php _e( 'Refuse button text', 'cookies-and-content-security-policy' ); ?>
		</th>
		<td>
			<input name="cacsp_option_color_refuse_button_text" type="text" id="cacsp_option_color_refuse_button_text" value="<?php echo $cacsp_option_color_refuse_button_text; ?>" class="cacsp-color">
		</td>
	</tr>
	<tr>
		<th scope="row">
			<?php _e( 'Save button color', 'cookies-and-content-security-policy' ); ?>
		</th>
		<td>
			<input name="cacsp_option_color_save_button" type="text" id="cacsp_option_color_save_button" value="<?php echo $cacsp_option_color_save_button; ?>" class="cacsp-color">
		</td>
	</tr>
	<tr>
		<th scope="row">
			<?php _e( 'Save button border', 'cookies-and-content-security-policy' ); ?>
		</th>
		<td>
			<input name="cacsp_option_color_save_button_border" type="text" id="cacsp_option_color_save_button_border" value="<?php echo $cacsp_option_color_save_button_border; ?>" class="cacsp-color">
		</td>
	</tr>
	<tr>
		<th scope="row">
			<?php _e( 'Save button text', 'cookies-and-content-security-policy' ); ?>
		</th>
		<td>
			<input name="cacsp_option_color_save_button_text" type="text" id="cacsp_option_color_save_button_text" value="<?php echo $cacsp_option_color_save_button_text; ?>" class="cacsp-color">
		</td>
	</tr>
	<tr>
		<th scope="row">
			<?php _e( 'Accept button color', 'cookies-and-content-security-policy' ); ?>
		</th>
		<td>
			<input name="cacsp_option_color_accept_button" type="text" id="cacsp_option_color_accept_button" value="<?php echo $cacsp_option_color_accept_button; ?>" class="cacsp-color">
		</td>
	</tr>
	<tr>
		<th scope="row">
			<?php _e( 'Accept button border', 'cookies-and-content-security-policy' ); ?>
		</th>
		<td>
			<input name="cacsp_option_color_accept_button_border" type="text" id="cacsp_option_color_accept_button_border" value="<?php echo $cacsp_option_color_accept_button_border; ?>" class="cacsp-color">
		</td>
	</tr>
	<tr>
		<th scope="row">
			<?php _e( 'Accept button text', 'cookies-and-content-security-policy' ); ?>
		</th>
		<td>
			<input name="cacsp_option_color_accept_button_text" type="text" id="cacsp_option_color_accept_button_text" value="<?php echo $cacsp_option_color_accept_button_text; ?>" class="cacsp-color">
		</td>
	</tr>
</table>

<div class="submit">
	<input type="submit" name="save_cacsp_settings_colors" value="<?php _e( 'Save Settings' , 'cookies-and-content-security-policy' ); ?>" class="button-primary" />
</div>
