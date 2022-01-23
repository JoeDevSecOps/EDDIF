<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
?>

<div class="cookies-and-content-security-policy-help">
	<?php
	echo '<p>';
		_e( 'Choose which external resources the site uses to automatically save them to Domains. These are recommended settings for each resource.', 'cookies-and-content-security-policy' );
	echo '</p>';
	echo '<p>';
		echo __( 'If i missed some common resource or if some resource is missing any setting for domain', 'cookies-and-content-security-policy') . ', ' . '<a href="mailto:jonk@followmedarling.se?subject=Quickstart&amp;body=Your URL:%0d%0a%0d%0aResource:%0d%0a%0d%0aProblem:">' . __( 'drop me a line', 'cookies-and-content-security-policy' ) . '</a>.';
	echo '</p>';
	?>
</div>
<?php
$cacsp_option_quickstart_google_analytics = intval( isset( $_POST['cacsp_option_quickstart_google_analytics'] ) );
$cacsp_option_quickstart_google_tag_manager = intval( isset( $_POST['cacsp_option_quickstart_google_tag_manager'] ) );
$cacsp_option_quickstart_google_optimize = intval( isset( $_POST['cacsp_option_quickstart_google_optimize'] ) );
$cacsp_option_quickstart_google_ads_conversion = intval( isset( $_POST['cacsp_option_quickstart_google_ads_conversion'] ) );
$cacsp_option_quickstart_google_ads_remarketing = intval( isset( $_POST['cacsp_option_quickstart_google_ads_remarketing'] ) );
$cacsp_option_quickstart_linkedin_insight_tag = intval( isset( $_POST['cacsp_option_quickstart_linkedin_insight_tag'] ) );
$cacsp_option_quickstart_facebook_pixel = intval( isset( $_POST['cacsp_option_quickstart_facebook_pixel'] ) );
$cacsp_option_quickstart_hubspot = intval( isset( $_POST['cacsp_option_quickstart_hubspot'] ) );
$cacsp_option_quickstart_hotjar = intval( isset( $_POST['cacsp_option_quickstart_hotjar'] ) );
$cacsp_option_quickstart_google_maps = intval( isset( $_POST['cacsp_option_quickstart_google_maps'] ) );
$cacsp_option_quickstart_google_translate = intval( isset( $_POST['cacsp_option_quickstart_google_translate'] ) );
$cacsp_option_quickstart_youtube = intval( isset( $_POST['cacsp_option_quickstart_youtube'] ) );
$cacsp_option_quickstart_vimeo = intval( isset( $_POST['cacsp_option_quickstart_vimeo'] ) );
$cacsp_option_quickstart_spotify = intval( isset( $_POST['cacsp_option_quickstart_spotify'] ) );
$cacsp_option_quickstart_issuu = intval( isset( $_POST['cacsp_option_quickstart_issuu'] ) );
$cacsp_option_quickstart_twitter = intval( isset( $_POST['cacsp_option_quickstart_twitter'] ) );
$cacsp_option_quickstart_stripe = intval( isset( $_POST['cacsp_option_quickstart_stripe'] ) );
$cacsp_option_quickstart_paypal = intval( isset( $_POST['cacsp_option_quickstart_paypal'] ) );
$cacsp_option_quickstart_recaptcha = intval( isset( $_POST['cacsp_option_quickstart_recaptcha'] ) );
$cacsp_option_quickstart_gravatar = intval( isset( $_POST['cacsp_option_quickstart_gravatar'] ) );
$cacsp_option_quickstart_soundcloud = intval( isset( $_POST['cacsp_option_quickstart_soundcloud'] ) );
$cacsp_option_quickstart_calendly = intval( isset( $_POST['cacsp_option_quickstart_calendly'] ) );
$cacsp_option_quickstart_jetpack = intval( isset( $_POST['cacsp_option_quickstart_jetpack'] ) );
$cacsp_option_quickstart_mailchimp = intval( isset( $_POST['cacsp_option_quickstart_mailchimp'] ) );
$cacsp_option_quickstart_overwrite = intval( isset( $_POST['cacsp_option_quickstart_overwrite'] ) );
?>
<h2><?php _e( 'Quickstart', 'cookies-and-content-security-policy' ); ?></h2>
<ul>
	<li>
		<h4><?php _e( 'Google', 'cookies-and-content-security-policy' ); ?></h4>
	</li>
	<li>
		<label for="cacsp_option_quickstart_google_analytics">
			<?php if ( $cacsp_option_quickstart_google_analytics ) {
				$checked = ' checked';
			} else {
				$checked = '';
			} ?>
			<input type="checkbox" name="cacsp_option_quickstart_google_analytics" id="cacsp_option_quickstart_google_analytics" value="1"<?php echo $checked; ?>> 
				<?php _e( 'Google Analytics', 'cookies-and-content-security-policy' ); ?>
		</label>
	</li>
	<li>
		<label for="cacsp_option_quickstart_google_tag_manager">
			<?php if ( $cacsp_option_quickstart_google_tag_manager ) {
				$checked = ' checked';
			} else {
				$checked = '';
			} ?>
			<input type="checkbox" name="cacsp_option_quickstart_google_tag_manager" id="cacsp_option_quickstart_google_tag_manager" value="1"<?php echo $checked; ?>> 
				<?php _e( 'Google Tag Manager', 'cookies-and-content-security-policy' ); ?>
		</label>
	</li>
	<li>
		<label for="cacsp_option_quickstart_google_optimize">
			<?php if ( $cacsp_option_quickstart_google_optimize ) {
				$checked = ' checked';
			} else {
				$checked = '';
			} ?>
			<input type="checkbox" name="cacsp_option_quickstart_google_optimize" id="cacsp_option_quickstart_google_optimize" value="1"<?php echo $checked; ?>> 
				<?php _e( 'Google Optimize', 'cookies-and-content-security-policy' ); ?>
		</label>
	</li>
	<li>
		<label for="cacsp_option_quickstart_google_ads_conversion">
			<?php if ( $cacsp_option_quickstart_google_ads_conversion ) {
				$checked = ' checked';
			} else {
				$checked = '';
			} ?>
			<input type="checkbox" name="cacsp_option_quickstart_google_ads_conversion" id="cacsp_option_quickstart_google_ads_conversion" value="1"<?php echo $checked; ?>> 
				<?php _e( 'Google Ads conversions', 'cookies-and-content-security-policy' ); ?>
		</label>
	</li>
	<li>
		<label for="cacsp_option_quickstart_google_ads_remarketing">
			<?php if ( $cacsp_option_quickstart_google_ads_remarketing ) {
				$checked = ' checked';
			} else {
				$checked = '';
			} ?>
			<input type="checkbox" name="cacsp_option_quickstart_google_ads_remarketing" id="cacsp_option_quickstart_google_ads_remarketing" value="1"<?php echo $checked; ?>> 
				<?php _e( 'Google Ads remarketing', 'cookies-and-content-security-policy' ); ?>
		</label>
	</li>
	<li>
		<label for="cacsp_option_quickstart_google_maps">
			<?php if ( $cacsp_option_quickstart_google_maps ) {
				$checked = ' checked';
			} else {
				$checked = '';
			} ?>
			<input type="checkbox" name="cacsp_option_quickstart_google_maps" id="cacsp_option_quickstart_google_maps" value="1"<?php echo $checked; ?>> 
				<?php _e( 'Google Maps', 'cookies-and-content-security-policy' ); ?>
		</label>
	</li>
	<li>
		<label for="cacsp_option_quickstart_google_translate">
			<?php if ( $cacsp_option_quickstart_google_translate ) {
				$checked = ' checked';
			} else {
				$checked = '';
			} ?>
			<input type="checkbox" name="cacsp_option_quickstart_google_translate" id="cacsp_option_quickstart_google_translate" value="1"<?php echo $checked; ?>> 
				<?php _e( 'Google Translate', 'cookies-and-content-security-policy' ); ?>
		</label>
	</li>
	<li>
		<h4><?php _e( 'Social networks', 'cookies-and-content-security-policy' ); ?></h4>
	</li>
	<li>
		<label for="cacsp_option_quickstart_linkedin_insight_tag">
			<?php if ( $cacsp_option_quickstart_linkedin_insight_tag ) {
				$checked = ' checked';
			} else {
				$checked = '';
			} ?>
			<input type="checkbox" name="cacsp_option_quickstart_linkedin_insight_tag" id="cacsp_option_quickstart_linkedin_insight_tag" value="1"<?php echo $checked; ?>> 
				<?php _e( 'LinkedIn Insight Tag/LinkedIn Pixel', 'cookies-and-content-security-policy' ); ?>
		</label>
	</li>
	<li>
		<label for="cacsp_option_quickstart_facebook_pixel">
			<?php if ( $cacsp_option_quickstart_facebook_pixel ) {
				$checked = ' checked';
			} else {
				$checked = '';
			} ?>
			<input type="checkbox" name="cacsp_option_quickstart_facebook_pixel" id="cacsp_option_quickstart_facebook_pixel" value="1"<?php echo $checked; ?>> 
				<?php _e( 'Facebook Pixel', 'cookies-and-content-security-policy' ); ?>
		</label>
	</li>
	<li>
		<label for="cacsp_option_quickstart_twitter">
			<?php if ( $cacsp_option_quickstart_twitter ) {
				$checked = ' checked';
			} else {
				$checked = '';
			} ?>
			<input type="checkbox" name="cacsp_option_quickstart_twitter" id="cacsp_option_quickstart_twitter" value="1"<?php echo $checked; ?>> 
				<?php _e( 'Twitter', 'cookies-and-content-security-policy' ); ?>
		</label>
	</li>
	<li>
		<h4><?php _e( 'CRM', 'cookies-and-content-security-policy' ); ?></h4>
	</li>
	<li>
		<label for="cacsp_option_quickstart_hubspot">
			<?php if ( $cacsp_option_quickstart_hubspot ) {
				$checked = ' checked';
			} else {
				$checked = '';
			} ?>
			<input type="checkbox" name="cacsp_option_quickstart_hubspot" id="cacsp_option_quickstart_hubspot" value="1"<?php echo $checked; ?>> 
				<?php _e( 'Hubspot', 'cookies-and-content-security-policy' ); ?>
		</label>
	</li>
	<li>
		<h4><?php _e( 'Analytics', 'cookies-and-content-security-policy' ); ?></h4>
	</li>
	<li>
		<label for="cacsp_option_quickstart_hotjar">
			<?php if ( $cacsp_option_quickstart_hotjar ) {
				$checked = ' checked';
			} else {
				$checked = '';
			} ?>
			<input type="checkbox" name="cacsp_option_quickstart_hotjar" id="cacsp_option_quickstart_hotjar" value="1"<?php echo $checked; ?>> 
				<?php _e( 'Hotjar', 'cookies-and-content-security-policy' ); ?>
		</label>
	</li>
	<li>
		<label for="cacsp_option_quickstart_jetpack">
			<?php if ( $cacsp_option_quickstart_hotjar ) {
				$checked = ' checked';
			} else {
				$checked = '';
			} ?>
			<input type="checkbox" name="cacsp_option_quickstart_jetpack" id="cacsp_option_quickstart_jetpack" value="1"<?php echo $checked; ?>> 
				<?php _e( 'Jetpack', 'cookies-and-content-security-policy' ); ?>
		</label>
	</li>
	<li>
		<small><?php _e( 'Google Analytics is under "Google"', 'cookies-and-content-security-policy' ); ?></small>
	</li>
	<li>
		<h4><?php _e( 'Media', 'cookies-and-content-security-policy' ); ?></h4>
	</li>
	<li>
		<label for="cacsp_option_quickstart_youtube">
			<?php if ( $cacsp_option_quickstart_youtube ) {
				$checked = ' checked';
			} else {
				$checked = '';
			} ?>
			<input type="checkbox" name="cacsp_option_quickstart_youtube" id="cacsp_option_quickstart_youtube" value="1"<?php echo $checked; ?>> 
				<?php _e( 'YouTube', 'cookies-and-content-security-policy' ); ?>
		</label>
	</li>
	<li>
		<label for="cacsp_option_quickstart_vimeo">
			<?php if ( $cacsp_option_quickstart_vimeo ) {
				$checked = ' checked';
			} else {
				$checked = '';
			} ?>
			<input type="checkbox" name="cacsp_option_quickstart_vimeo" id="cacsp_option_quickstart_vimeo" value="1"<?php echo $checked; ?>> 
				<?php _e( 'Vimeo', 'cookies-and-content-security-policy' ); ?>
		</label>
	</li>
	<li>
		<label for="cacsp_option_quickstart_spotify">
			<?php if ( $cacsp_option_quickstart_spotify ) {
				$checked = ' checked';
			} else {
				$checked = '';
			} ?>
			<input type="checkbox" name="cacsp_option_quickstart_spotify" id="cacsp_option_quickstart_spotify" value="1"<?php echo $checked; ?>> 
				<?php _e( 'Spotify', 'cookies-and-content-security-policy' ); ?>
		</label>
	</li>
	<li>
		<label for="cacsp_option_quickstart_issuu">
			<?php if ( $cacsp_option_quickstart_issuu ) {
				$checked = ' checked';
			} else {
				$checked = '';
			} ?>
			<input type="checkbox" name="cacsp_option_quickstart_issuu" id="cacsp_option_quickstart_issuu" value="1"<?php echo $checked; ?>> 
				<?php _e( 'Issuu', 'cookies-and-content-security-policy' ); ?>
		</label>
	</li>
	<li>
		<label for="cacsp_option_quickstart_soundcloud">
			<?php if ( $cacsp_option_quickstart_soundcloud ) {
				$checked = ' checked';
			} else {
				$checked = '';
			} ?>
			<input type="checkbox" name="cacsp_option_quickstart_soundcloud" id="cacsp_option_quickstart_soundcloud" value="1"<?php echo $checked; ?>> 
				<?php _e( 'SoundCloud', 'cookies-and-content-security-policy' ); ?>
		</label>
	</li>
	<li>
		<label for="cacsp_option_quickstart_gravatar">
			<?php if ( $cacsp_option_quickstart_gravatar ) {
				$checked = ' checked';
			} else {
				$checked = '';
			} ?>
			<input type="checkbox" name="cacsp_option_quickstart_gravatar" id="cacsp_option_quickstart_gravatar" value="1"<?php echo $checked; ?>> 
				<?php _e( 'Gravatar', 'cookies-and-content-security-policy' ); ?>
		</label>
	</li>
	<li>
		<h4><?php _e( 'Payment', 'cookies-and-content-security-policy' ); ?></h4>
	</li>
	<li>
		<label for="cacsp_option_quickstart_paypal">
			<?php if ( $cacsp_option_quickstart_paypal ) {
				$checked = ' checked';
			} else {
				$checked = '';
			} ?>
			<input type="checkbox" name="cacsp_option_quickstart_paypal" id="cacsp_option_quickstart_paypal" value="1"<?php echo $checked; ?>> 
				<?php _e( 'PayPal', 'cookies-and-content-security-policy' ); ?>
		</label>
	</li>
	<li>
		<label for="cacsp_option_quickstart_stripe">
			<?php if ( $cacsp_option_quickstart_stripe ) {
				$checked = ' checked';
			} else {
				$checked = '';
			} ?>
			<input type="checkbox" name="cacsp_option_quickstart_stripe" id="cacsp_option_quickstart_stripe" value="1"<?php echo $checked; ?>> 
				<?php _e( 'Stripe', 'cookies-and-content-security-policy' ); ?>
		</label>
	</li>
	<li>
		<h4><?php _e( 'Misc', 'cookies-and-content-security-policy' ); ?></h4>
	</li>
	<li>
		<label for="cacsp_option_quickstart_recaptcha">
			<?php if ( $cacsp_option_quickstart_recaptcha ) {
				$checked = ' checked';
			} else {
				$checked = '';
			} ?>
			<input type="checkbox" name="cacsp_option_quickstart_recaptcha" id="cacsp_option_quickstart_recaptcha" value="1"<?php echo $checked; ?>> 
				<?php _e( 'reCAPTCHA v3', 'cookies-and-content-security-policy' ); ?>
		</label>
	</li>
	<li>
		<label for="cacsp_option_quickstart_calendly">
			<?php if ( $cacsp_option_quickstart_calendly ) {
				$checked = ' checked';
			} else {
				$checked = '';
			} ?>
			<input type="checkbox" name="cacsp_option_quickstart_calendly" id="cacsp_option_quickstart_calendly" value="1"<?php echo $checked; ?>> 
				<?php _e( 'Calendly', 'cookies-and-content-security-policy' ); ?>
		</label>
	</li>
	<li>
		<label for="cacsp_option_quickstart_mailchimp">
			<?php if ( $cacsp_option_quickstart_mailchimp ) {
				$checked = ' checked';
			} else {
				$checked = '';
			} ?>
			<input type="checkbox" name="cacsp_option_quickstart_mailchimp" id="cacsp_option_quickstart_mailchimp" value="1"<?php echo $checked; ?>> 
				<?php _e( 'Mailchimp', 'cookies-and-content-security-policy' ); ?>
		</label>
	</li>
</ul>

<div class="submit">
	<label for="cacsp_option_quickstart_overwrite">
		<?php if ( $cacsp_option_quickstart_overwrite ) {
			$checked = ' checked';
		} else {
			$checked = '';
		} ?>
		<input type="checkbox" name="cacsp_option_quickstart_overwrite" id="cacsp_option_quickstart_overwrite" value="1"<?php echo $checked; ?>> 
			<?php _e( 'Overwrite all settings in Domains', 'cookies-and-content-security-policy' ); ?>
	</label>
	<br><br>
	<input type="submit" name="save_cacsp_settings_quickstart" value="<?php _e( 'Save Settings' , 'cookies-and-content-security-policy' ); ?>" class="button-primary" />
</div>
