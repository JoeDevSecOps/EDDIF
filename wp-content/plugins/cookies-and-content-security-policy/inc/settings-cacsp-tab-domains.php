<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
?>

<div class="cookies-and-content-security-policy-help">
	<?php
	echo '<p>';
	_e( 'Fill the forms with domains that should be allowed in each box. The groups are:', 'cookies-and-content-security-policy' );
		echo '<ol>';
			echo '<li>' . __('Always allowed, resources that the visitor can\'t opt out of.', 'cookies-and-content-security-policy' ) . '</li>';
			echo '<li>' . __('Statistics, resources for gathering data about the visitor for statistics etc.', 'cookies-and-content-security-policy' ) . '</li>';
			echo '<li>' . __('Experience, resources for displaying external videos etc.', 'cookies-and-content-security-policy' ) . '</li>';
			echo '<li>' . __('Marketing, resources for gathering data about the visitor for remarketing etc.', 'cookies-and-content-security-policy' ) . '</li>';
		echo '</ol>';
	echo '</p>';
	echo '<p>' . __('Separate domains by new line.<br>Example:<br>https://www.googleadservices.com<br>https://www.googletagmanager.com', 'cookies-and-content-security-policy' ) . '</p>';
	echo '<p>' . __('Wildcard domains can be used.<br>Example:<br>https://*.youtube.com', 'cookies-and-content-security-policy' ) . '</p>';
	?>
</div>
<?php
	// Always allowed
	$cacsp_option_always_scripts = get_cacsp_options( 'cacsp_option_always_scripts', false, '', true );
	$cacsp_option_always_images = get_cacsp_options( 'cacsp_option_always_images', false, '', true );
	$cacsp_option_always_frames = get_cacsp_options( 'cacsp_option_always_frames', false, '', true );
	if ( $cacsp_option_forms ) {
		$cacsp_option_always_forms = get_cacsp_options( 'cacsp_option_always_forms', false, '', true );
	}
	if ( $cacsp_option_worker ) {
		$cacsp_option_always_worker = get_cacsp_options( 'cacsp_option_always_worker', false, '', true );
	}
	// Statistics
	$cacsp_option_statistics_scripts = get_cacsp_options( 'cacsp_option_statistics_scripts', false, '', true );
	$cacsp_option_statistics_images = get_cacsp_options( 'cacsp_option_statistics_images', false, '', true );
	$cacsp_option_statistics_frames = get_cacsp_options( 'cacsp_option_statistics_frames', false, '', true );
	if ( $cacsp_option_forms ) {
		$cacsp_option_statistics_forms = get_cacsp_options( 'cacsp_option_statistics_forms', false, '', true );
	}
	if ( $cacsp_option_worker ) {
		$cacsp_option_statistics_worker = get_cacsp_options( 'cacsp_option_statistics_worker', false, '', true );
	}
	// Experience
	$cacsp_option_experience_scripts = get_cacsp_options( 'cacsp_option_experience_scripts', false, '', true );
	$cacsp_option_experience_images = get_cacsp_options( 'cacsp_option_experience_images', false, '', true );
	$cacsp_option_experience_frames = get_cacsp_options( 'cacsp_option_experience_frames', false, '', true );
	if ( $cacsp_option_forms ) {
		$cacsp_option_experience_forms = get_cacsp_options( 'cacsp_option_experience_forms', false, '', true );
	}
	if ( $cacsp_option_worker ) {
		$cacsp_option_experience_worker = get_cacsp_options( 'cacsp_option_experience_worker', false, '', true );
	}
	// Marketing
	$cacsp_option_markerting_scripts = get_cacsp_options( 'cacsp_option_markerting_scripts', false, '', true );
	$cacsp_option_markerting_images = get_cacsp_options( 'cacsp_option_markerting_images', false, '', true );
	$cacsp_option_markerting_frames = get_cacsp_options( 'cacsp_option_markerting_frames', false, '', true );
	if ( $cacsp_option_forms ) {
		$cacsp_option_markerting_forms = get_cacsp_options( 'cacsp_option_markerting_forms', false, '', true );
	}
	if ( $cacsp_option_worker ) {
		$cacsp_option_markerting_worker = get_cacsp_options( 'cacsp_option_markerting_worker', false, '', true );
	}
	?>
<h2><?php _e( 'Always allow', 'cookies-and-content-security-policy' ); ?></h2>
<table class="form-table">
	<?php echo cacsp_settings_textarea_row( __('Scripts', 'cookies-and-content-security-policy' ), 'cacsp_option_always_scripts', $cacsp_option_always_scripts, true, __('Your CDN, like https://media.yourdomain.com/', 'cookies-and-content-security-policy' ) ); ?>
	<?php echo cacsp_settings_textarea_row( __('Images', 'cookies-and-content-security-policy' ), 'cacsp_option_always_images', $cacsp_option_always_images, true, __('Your CDN, like https://media.yourdomain.com/', 'cookies-and-content-security-policy' ) ); ?>
	<?php echo cacsp_settings_textarea_row( __('Frames', 'cookies-and-content-security-policy' ), 'cacsp_option_always_frames', $cacsp_option_always_frames, true, __('Your CDN, like https://media.yourdomain.com/', 'cookies-and-content-security-policy' ) ); ?>
	<?php if ( $cacsp_option_forms ) {
		echo cacsp_settings_textarea_row( __('Forms', 'cookies-and-content-security-policy' ), 'cacsp_option_always_forms', $cacsp_option_always_forms, true, __('Use this to allow posting data to other sites, like subscribing to a MailChimp newsletter would need https://*.list-manage.com/', 'cookies-and-content-security-policy' ) );
	} ?>
	<?php if ( $cacsp_option_worker ) {
		echo cacsp_settings_textarea_row( __('Worker', 'cookies-and-content-security-policy' ), 'cacsp_option_always_worker', $cacsp_option_always_worker, true, __('Allow background scripts via Worker', 'cookies-and-content-security-policy' ) );
	} ?>
</table>
<h2><?php _e( 'Statistics', 'cookies-and-content-security-policy' ); ?></h2>
<table class="form-table">
	<?php echo cacsp_settings_textarea_row( __('Scripts', 'cookies-and-content-security-policy' ), 'cacsp_option_statistics_scripts', $cacsp_option_statistics_scripts, true, 'https://www.google-analytics.com/' ); ?>
	<?php echo cacsp_settings_textarea_row( __('Images', 'cookies-and-content-security-policy' ), 'cacsp_option_statistics_images', $cacsp_option_statistics_images, true, 'https://www.google-analytics.com/' ); ?>
	<?php echo cacsp_settings_textarea_row( __('Frames', 'cookies-and-content-security-policy' ), 'cacsp_option_statistics_frames', $cacsp_option_statistics_frames, true, __('No idea :)', 'cookies-and-content-security-policy' ) ); ?>
	<?php if ( $cacsp_option_forms ) {
		echo cacsp_settings_textarea_row( __('Forms', 'cookies-and-content-security-policy' ), 'cacsp_option_statistics_forms', $cacsp_option_statistics_forms, true, __('Use this to allow posting data to other sites, like subscribing to a MailChimp newsletter would need https://*.list-manage.com/', 'cookies-and-content-security-policy' ) ); 
	} ?>
	<?php if ( $cacsp_option_worker ) {
		echo cacsp_settings_textarea_row( __('Worker', 'cookies-and-content-security-policy' ), 'cacsp_option_statistics_worker', $cacsp_option_statistics_worker, true, __('Allow background scripts via Worker', 'cookies-and-content-security-policy' ) );
	} ?>
</table>
<h2><?php _e( 'Experience', 'cookies-and-content-security-policy' ); ?></h2>
<table class="form-table">
	<?php echo cacsp_settings_textarea_row( __('Scripts', 'cookies-and-content-security-policy' ), 'cacsp_option_experience_scripts', $cacsp_option_experience_scripts, true, 'https://ajax.googleapis.com/' ); ?>
	<?php echo cacsp_settings_textarea_row( __('Images', 'cookies-and-content-security-policy' ), 'cacsp_option_experience_images', $cacsp_option_experience_images, true, 'https://secure.gravatar.com/' ); ?>
	<?php echo cacsp_settings_textarea_row( __('Frames', 'cookies-and-content-security-policy' ), 'cacsp_option_experience_frames', $cacsp_option_experience_frames, true, 'https://*.youtube.com/<br>https://*.vimeo.com/<br>https://www.google.com/' ); ?>
	<?php if ( $cacsp_option_forms ) {
		echo cacsp_settings_textarea_row( __('Forms', 'cookies-and-content-security-policy' ), 'cacsp_option_experience_forms', $cacsp_option_experience_forms, true, __('Use this to allow posting data to other sites, like subscribing to a MailChimp newsletter would need https://*.list-manage.com/', 'cookies-and-content-security-policy' ) );
	} ?>
	<?php if ( $cacsp_option_worker ) {
		echo cacsp_settings_textarea_row( __('Worker', 'cookies-and-content-security-policy' ), 'cacsp_option_experience_worker', $cacsp_option_experience_worker, true, __('Allow background scripts via Worker', 'cookies-and-content-security-policy' ) );
	} ?>
</table>
<h2><?php _e( 'Marketing', 'cookies-and-content-security-policy' ); ?></h2>
<table class="form-table">
	<?php echo cacsp_settings_textarea_row( __('Scripts', 'cookies-and-content-security-policy' ), 'cacsp_option_markerting_scripts', $cacsp_option_markerting_scripts, true, 'https://*.facebook.net/<br>https://tagmanager.google.com/<br>https://www.googletagmanager.com/<br>https://www.googleadservices.com/' ); ?>
	<?php echo cacsp_settings_textarea_row( __('Images', 'cookies-and-content-security-policy' ), 'cacsp_option_markerting_images', $cacsp_option_markerting_images, true, 'https://*.facebook.net/<br>https://*.facebook.com/<br>https://*.google.com/<br>https://*.google.se/<br>https://*.linkedin.com/' ); ?>
	<?php echo cacsp_settings_textarea_row( __('Frames', 'cookies-and-content-security-policy' ), 'cacsp_option_markerting_frames', $cacsp_option_markerting_frames, true, __('No idea :)', 'cookies-and-content-security-policy' ) ); ?>
	<?php if ( $cacsp_option_forms ) {
		echo cacsp_settings_textarea_row( __('Forms', 'cookies-and-content-security-policy' ), 'cacsp_option_markerting_forms', $cacsp_option_markerting_forms, true, __('Use this to allow posting data to other sites, like subscribing to a MailChimp newsletter would need https://*.list-manage.com/', 'cookies-and-content-security-policy' ) );
	} ?>
	<?php if ( $cacsp_option_worker ) {
		echo cacsp_settings_textarea_row( __('Worker', 'cookies-and-content-security-policy' ), 'cacsp_option_markerting_worker', $cacsp_option_markerting_worker, true, __('Allow background scripts via Worker', 'cookies-and-content-security-policy' ) );
	} ?>
</table>

<div class="submit">
	<input type="submit" name="save_cacsp_settings_domains" value="<?php _e( 'Save Settings' , 'cookies-and-content-security-policy' ); ?>" class="button-primary" />
</div>
