<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
?>

<div class="cookies-and-content-security-policy-help">
<?php
$save_cacsp_settings_texts = get_cacsp_options( 'save_cacsp_settings_texts', false, '', true );
if ( !$save_cacsp_settings_texts ) {
	echo '<p>';
		_e( 'If you are using a translation plugin (like Polylang or WPML) you have to save this form to make the texts below appear in your translation plugin. If you are happy with the default texts, and the plugins is already available in your language, you can skip saving this form and everything is already set up for you.', 'cookies-and-content-security-policy' );
		echo '<br><a href="' . __( 'https://wordpress.org/plugins/cookies-and-content-security-policy/#how%20do%20i%20translate%20in%20wpml%3F', 'cookies-and-content-security-policy' ) . '" target="_blank" rel="noopener noreferrer">';
			_e( 'Read in the FAQ how to translate with WPML.', 'cookies-and-content-security-policy' );
		echo '</a>';
		echo '<br><a href="' . __( 'https://wordpress.org/plugins/cookies-and-content-security-policy/#how%20do%20i%20translate%20in%20polylang%3F', 'cookies-and-content-security-policy' ) . '" target="_blank" rel="noopener noreferrer">';
			_e( 'Read in the FAQ how to translate with Polylang.', 'cookies-and-content-security-policy' );
		echo '</a>';
	echo '</p>';
	echo '<p>';
		_e( 'If you\'re not using a translation plugin you just need to save this form if you want to change any of the texts.', 'cookies-and-content-security-policy' );
	echo '</p>';
} else {
	echo '<p>';
		_e( 'If you are using a translation plugin (like Polylang or WPML) only your sites default language can be edited here, translations are edited in your translation plugins string translation area.', 'cookies-and-content-security-policy' );
		echo '<br><a href="' . __( 'https://wordpress.org/plugins/cookies-and-content-security-policy/#how%20do%20i%20translate%20in%20wpml%3F', 'cookies-and-content-security-policy' ) . '" target="_blank" rel="noopener noreferrer">';
			_e( 'Read in the FAQ how to translate with WPML.', 'cookies-and-content-security-policy' );
		echo '</a>';
		echo '<br><a href="' . __( 'https://wordpress.org/plugins/cookies-and-content-security-policy/#how%20do%20i%20translate%20in%20polylang%3F', 'cookies-and-content-security-policy' ) . '" target="_blank" rel="noopener noreferrer">';
			_e( 'Read in the FAQ how to translate with Polylang.', 'cookies-and-content-security-policy' );
		echo '</a>';
	echo '</p>';
}
?>
</div>

<?php
$cacsp_option_text_header = get_cacsp_options( 'cacsp_option_text_header', false, '', true );
$cacsp_option_text_info = get_cacsp_options( 'cacsp_option_text_info', false, '', true );
$cacsp_option_text_link_text = get_cacsp_options( 'cacsp_option_text_link_text', false, '', true );
$cacsp_option_text_settings = get_cacsp_options( 'cacsp_option_text_settings', false, '', true );
$cacsp_option_text_always_allow_header = get_cacsp_options( 'cacsp_option_text_always_allow_header', false, '', true );
$cacsp_option_text_always_allow_description = get_cacsp_options( 'cacsp_option_text_always_allow_description', false, '', true );
$cacsp_option_text_statistics_header = get_cacsp_options( 'cacsp_option_text_statistics_header', false, '', true );
$cacsp_option_text_statistics_description = get_cacsp_options( 'cacsp_option_text_statistics_description', false, '', true );
$cacsp_option_text_experience_header = get_cacsp_options( 'cacsp_option_text_experience_header', false, '', true );
$cacsp_option_text_experience_description = get_cacsp_options( 'cacsp_option_text_experience_description', false, '', true );
$cacsp_option_text_marketing_header = get_cacsp_options( 'cacsp_option_text_marketing_header', false, '', true );
$cacsp_option_text_marketing_description = get_cacsp_options( 'cacsp_option_text_marketing_description', false, '', true );
$cacsp_option_settings_button = get_cacsp_options( 'cacsp_option_settings_button', false, '', true );
$cacsp_option_refuse_button = get_cacsp_options( 'cacsp_option_refuse_button', false, '', true );
$cacsp_option_accept_all_button = get_cacsp_options( 'cacsp_option_accept_all_button', false, '', true );
$cacsp_option_save_button = get_cacsp_options( 'cacsp_option_save_button', false, '', true );
$cacsp_review_settings_description = get_cacsp_options( 'cacsp_review_settings_description', false, '', true );
$cacsp_review_settings_button = get_cacsp_options( 'cacsp_review_settings_button', false, '', true );
$cacsp_not_allowed_description = get_cacsp_options( 'cacsp_not_allowed_description', false, '', true );
$cacsp_not_allowed_button = get_cacsp_options( 'cacsp_not_allowed_button', false, '', true );
?>
<h2><?php _e( 'Texts', 'cookies-and-content-security-policy' ); ?></h2>
<table class="form-table">
	<?php echo cacsp_settings_input_row( __('Modal header', 'cookies-and-content-security-policy', false ), 'cacsp_option_text_header', $cacsp_option_text_header, false, '', __( 'Cookies', 'cookies-and-content-security-policy' ) ); ?>
	<?php echo cacsp_settings_textarea_row( __('Info', 'cookies-and-content-security-policy', false ), 'cacsp_option_text_info', $cacsp_option_text_info, false, '', __( 'We serve cookies. If you think that\'s ok, just click "Accept all". You can also choose what kind of cookies you want by clicking "Settings".', 'cookies-and-content-security-policy' ) ); ?>
	<?php echo cacsp_settings_input_row( __('Cookie policy link text', 'cookies-and-content-security-policy', false ), 'cacsp_option_text_link_text', $cacsp_option_text_link_text, false, '', __( 'Read our cookie policy', 'cookies-and-content-security-policy' ) ); ?>
	<?php echo cacsp_settings_textarea_row( __('Settings text', 'cookies-and-content-security-policy', false ), 'cacsp_option_text_settings', $cacsp_option_text_settings, false, '', __( 'Choose what kind of cookies to accept. Your choice will be saved for one year.', 'cookies-and-content-security-policy' ) ); ?>
	<?php echo cacsp_settings_input_row( __('Always allow, header', 'cookies-and-content-security-policy', false ), 'cacsp_option_text_always_allow_header', $cacsp_option_text_always_allow_header, false, '', __( 'Necessary', 'cookies-and-content-security-policy' ) ); ?>
	<?php echo cacsp_settings_textarea_row( __('Always allow, description', 'cookies-and-content-security-policy', false ), 'cacsp_option_text_always_allow_description', $cacsp_option_text_always_allow_description, false, '', __( 'These cookies are not optional. They are needed for the website to function.', 'cookies-and-content-security-policy' ) ); ?>
	<?php echo cacsp_settings_input_row( __('Statistics, header', 'cookies-and-content-security-policy', false ), 'cacsp_option_text_statistics_header', $cacsp_option_text_statistics_header, false, '', __( 'Statistics', 'cookies-and-content-security-policy' ) ); ?>
	<?php echo cacsp_settings_textarea_row( __('Statistics, description', 'cookies-and-content-security-policy', false ), 'cacsp_option_text_statistics_description', $cacsp_option_text_statistics_description, false, '', __( 'In order for us to improve the website\'s functionality and structure, based on how the website is used.', 'cookies-and-content-security-policy' ) ); ?>
	<?php echo cacsp_settings_input_row( __('Experience, header', 'cookies-and-content-security-policy', false ), 'cacsp_option_text_experience_header', $cacsp_option_text_experience_header, false, '', __( 'Experience', 'cookies-and-content-security-policy' ) ); ?>
	<?php echo cacsp_settings_textarea_row( __('Experience, description', 'cookies-and-content-security-policy', false ), 'cacsp_option_text_experience_description', $cacsp_option_text_experience_description, false, '', __( 'In order for our website to perform as well as possible during your visit. If you refuse these cookies, some functionality will disappear from the website.', 'cookies-and-content-security-policy' ) ); ?>
	<?php echo cacsp_settings_input_row( __('Marketing, header', 'cookies-and-content-security-policy', false ), 'cacsp_option_text_marketing_header', $cacsp_option_text_marketing_header, false, '', __( 'Marketing', 'cookies-and-content-security-policy' ) ); ?>
	<?php echo cacsp_settings_textarea_row( __('Marketing, description', 'cookies-and-content-security-policy', false ), 'cacsp_option_text_marketing_description', $cacsp_option_text_marketing_description, false, '', __( 'By sharing your interests and behavior as you visit our site, you increase the chance of seeing personalized content and offers.', 'cookies-and-content-security-policy' ) ); ?>
	<?php echo cacsp_settings_input_row( __('Settings button', 'cookies-and-content-security-policy', false ), 'cacsp_option_settings_button', $cacsp_option_settings_button, false, '', __( 'Settings', 'cookies-and-content-security-policy' ) ); ?>
	<?php echo cacsp_settings_input_row( __('Refuse button', 'cookies-and-content-security-policy', false ), 'cacsp_option_refuse_button', $cacsp_option_refuse_button, false, '', __( 'Refuse all', 'cookies-and-content-security-policy' ) ); ?>
	<?php echo cacsp_settings_input_row( __('Accept all button', 'cookies-and-content-security-policy', false ), 'cacsp_option_accept_all_button', $cacsp_option_accept_all_button, false, '', __( 'Accept all', 'cookies-and-content-security-policy' ) ); ?>
	<?php echo cacsp_settings_input_row( __('Save button', 'cookies-and-content-security-policy', false ), 'cacsp_option_save_button', $cacsp_option_save_button, false, '', __( 'Save', 'cookies-and-content-security-policy' ) ); ?>
	<?php echo cacsp_settings_textarea_row( __('Review your settings text', 'cookies-and-content-security-policy', false ), 'cacsp_review_settings_description', $cacsp_review_settings_description, false, '', __( 'Your settings may be preventing you from seeing this content. Most likely you have Experience turned off.', 'cookies-and-content-security-policy' ) ); ?>
	<?php echo cacsp_settings_input_row( __('Review your settings button', 'cookies-and-content-security-policy', false ), 'cacsp_review_settings_button', $cacsp_review_settings_button, false, '', __( 'Review your settings', 'cookies-and-content-security-policy' ) ); ?>
	<?php echo cacsp_settings_textarea_row( __('Content not allowed text', 'cookies-and-content-security-policy', false ), 'cacsp_not_allowed_description', $cacsp_not_allowed_description, false, '', __( 'The content can\'t be loaded, since it is not allowed on the site.', 'cookies-and-content-security-policy' ) ); ?>
	<?php echo cacsp_settings_input_row( __('Content not allowed button', 'cookies-and-content-security-policy', false ), 'cacsp_not_allowed_button', $cacsp_not_allowed_button, false, '', __( 'Contact the administrator', 'cookies-and-content-security-policy' ) ); ?>
</table>

<div class="submit">
	<input type="submit" name="save_cacsp_settings_texts" value="<?php _e( 'Save Settings' , 'cookies-and-content-security-policy' ); ?>" class="button-primary" />
</div>
