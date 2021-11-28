<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

$can_change_all = false;
$cacsp_nonce_set = false;
$cacsp_nonce_name = '';
if ( isset( $_POST['cacsp_nonce_name'] ) ) {
	$cacsp_nonce_set = isset( $_POST['cacsp_nonce_name'] );
	$cacsp_nonce_name = $_POST['cacsp_nonce_name'];
}
$cacsp_nonce_verify = wp_verify_nonce( $cacsp_nonce_name, 'cacsp_nonce_action' );
$cacsp_option_forms = get_cacsp_options( 'cacsp_option_forms' );
$cacsp_option_worker = get_cacsp_options( 'cacsp_option_worker' );
if ( current_user_can( 'manage_options' ) && $cacsp_nonce_set && $cacsp_nonce_verify ) {
	$can_change_all = true;
	update_option( 'cacsp_option_active', intval( 1 ) );
}
// Activate
if ( isset( $_POST['save_cacsp_settings_activate'] ) && $can_change_all ) {
	update_option( 'cacsp_option_actived', sanitize_text_field( $_POST['cacsp_option_actived'] ) );
	echo '<div id="message" class="updated fade">
		<p>' . __( 'Your settings are now updated', 'cookies-and-content-security-policy' ) . '</p>
	</div>';
}
// Update Quickstart
elseif ( isset( $_POST['save_cacsp_settings_quickstart'] ) && $can_change_all ) {

	$cacsp_option_quickstart_overwrite = isset( $_POST['cacsp_option_quickstart_overwrite'] );
	if ( $cacsp_option_quickstart_overwrite ) {
		update_option( 'cacsp_option_always_scripts', '' );
		update_option( 'cacsp_option_always_images', '' );
		update_option( 'cacsp_option_always_frames', '' );
		update_option( 'cacsp_option_always_forms', '' );
		update_option( 'cacsp_option_always_worker', '' );
		update_option( 'cacsp_option_statistics_scripts', '' );
		update_option( 'cacsp_option_statistics_images', '' );
		update_option( 'cacsp_option_statistics_frames', '' );
		update_option( 'cacsp_option_statistics_forms', '' );
		update_option( 'cacsp_option_statistics_worker', '' );
		update_option( 'cacsp_option_experience_scripts', '' );
		update_option( 'cacsp_option_experience_images', '' );
		update_option( 'cacsp_option_experience_frames', '' );
		update_option( 'cacsp_option_experience_form', '' );
		update_option( 'cacsp_option_experience_worker', '' );
		update_option( 'cacsp_option_markerting_scripts', '' );
		update_option( 'cacsp_option_markerting_images', '' );
		update_option( 'cacsp_option_markerting_frames', '' );
		update_option( 'cacsp_option_markerting_forms', '' );
		update_option( 'cacsp_option_markerting_worker', '' );
	}

	// Google Analytics
    if ( intval( isset( $_POST['cacsp_option_quickstart_google_analytics'] ) ) ) {
    	$cacsp_option_old = get_option( 'cacsp_option_statistics_scripts' );
		update_option( 'cacsp_option_statistics_scripts', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://google-analytics.com/', 'cacsp_option_statistics_scripts' ) . 
			cacsp_check_existing_domain( 'https://*.google-analytics.com/', 'cacsp_option_statistics_scripts' ) . 
			cacsp_check_existing_domain( 'https://googletagmanager.com/', 'cacsp_option_statistics_scripts' )  . 
			cacsp_check_existing_domain( 'https://*.googletagmanager.com/', 'cacsp_option_statistics_scripts' ) 
		), false );
		$cacsp_option_old = get_option( 'cacsp_option_statistics_images' );
    	update_option( 'cacsp_option_statistics_images', cacsp_sanitize_domains( 
    		$cacsp_option_old . 
    		cacsp_check_existing_domain( 'https://google-analytics.com/', 'cacsp_option_statistics_images' ) . 
    		cacsp_check_existing_domain( 'https://*.google-analytics.com/', 'cacsp_option_statistics_images' ) 
    	), false );
    }

    // Google Tag Manager
    if ( intval( isset( $_POST['cacsp_option_quickstart_google_tag_manager'] ) ) ) {
    	$cacsp_option_old = get_option( 'cacsp_option_markerting_scripts' );
		update_option( 'cacsp_option_markerting_scripts', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://googletagmanager.com/', 'cacsp_option_markerting_scripts' ) . 
			cacsp_check_existing_domain( 'https://*.googletagmanager.com/', 'cacsp_option_markerting_scripts' ) . 
			cacsp_check_existing_domain( 'https://tagmanager.google.com/', 'cacsp_option_markerting_scripts' ) 

		), false );
		$cacsp_option_old = get_option( 'cacsp_option_markerting_images' );
		update_option( 'cacsp_option_markerting_images', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://googletagmanager.com/', 'cacsp_option_markerting_images' ) . 
			cacsp_check_existing_domain( 'https://*.googletagmanager.com/', 'cacsp_option_markerting_images' ) . 
			cacsp_check_existing_domain( 'https://gstatic.com/', 'cacsp_option_markerting_images' ) . 
			cacsp_check_existing_domain( 'https://*.gstatic.com/', 'cacsp_option_markerting_images' ) 
		), false );
    }

    // Google Optimize
    if ( intval( isset( $_POST['cacsp_option_quickstart_google_optimize'] ) ) && !intval( isset( $_POST['cacsp_option_quickstart_google_analytics'] ) ) ) {
    	$cacsp_option_old = get_option( 'cacsp_option_markerting_scripts' );
		update_option( 'cacsp_option_markerting_scripts', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://google-analytics.com/', 'cacsp_option_markerting_scripts' ) . 
			cacsp_check_existing_domain( 'https://*.google-analytics.com/', 'cacsp_option_markerting_scripts' ) 
		), false );
    }

    // Google Ads conversions
    if ( intval( isset( $_POST['cacsp_option_quickstart_google_ads_conversion'] ) ) ) {
    	$cacsp_option_old = get_option( 'cacsp_option_markerting_scripts' );
		update_option( 'cacsp_option_markerting_scripts', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://google-analytics.com/', 'cacsp_option_statistics_scripts' ) . 
			cacsp_check_existing_domain( 'https://*.google-analytics.com/', 'cacsp_option_statistics_scripts' ) . 
			cacsp_check_existing_domain( 'https://google.com/', 'cacsp_option_markerting_scripts' ) . 
			cacsp_check_existing_domain( 'https://*.google.com/', 'cacsp_option_markerting_scripts' )
		), false );
		$cacsp_option_old = get_option( 'cacsp_option_markerting_images' );
		update_option( 'cacsp_option_markerting_images', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://googleads.g.doubleclick.net/', 'cacsp_option_markerting_images' ) . 
			cacsp_check_existing_domain( 'https://google.com/', 'cacsp_option_markerting_images' ) . 
			cacsp_check_existing_domain( 'https://*.google.com/', 'cacsp_option_markerting_images' )
		), false );
    }

    // Google Ads remarketing
    if ( intval( isset( $_POST['cacsp_option_quickstart_google_ads_remarketing'] ) ) ) {
    	$cacsp_option_old = get_option( 'cacsp_option_markerting_scripts' );
		update_option( 'cacsp_option_markerting_scripts', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://googleadservices.com/', 'cacsp_option_markerting_scripts' ) . 
			cacsp_check_existing_domain( 'https://*.googleadservices.com/', 'cacsp_option_markerting_scripts' ) . 
			cacsp_check_existing_domain( 'https://googleads.g.doubleclick.net/', 'cacsp_option_markerting_scripts' ) . 
			cacsp_check_existing_domain( 'https://google.com/', 'cacsp_option_markerting_scripts' ) . 
			cacsp_check_existing_domain( 'https://*.google.com/', 'cacsp_option_markerting_scripts' )
		), false );
		$cacsp_option_old = get_option( 'cacsp_option_markerting_images' );
		update_option( 'cacsp_option_markerting_images', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://google.com/', 'cacsp_option_markerting_images' ) . 
			cacsp_check_existing_domain( 'https://*.google.com/', 'cacsp_option_markerting_images' ) 
		), false );
		$cacsp_option_old = get_option( 'cacsp_option_markerting_frames' );
		update_option( 'cacsp_option_markerting_frames', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://*.doubleclick.net/', 'cacsp_option_markerting_frames' ) 
		), false );
    }

    // LinkedIn Insight Tag/LinkedIn Pixel
    if ( intval( isset( $_POST['cacsp_option_quickstart_linkedin_insight_tag'] ) ) ) {
    	$cacsp_option_old = get_option( 'cacsp_option_markerting_scripts' );
		update_option( 'cacsp_option_markerting_scripts', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://snap.licdn.com/', 'cacsp_option_markerting_scripts' ) 
		), false );
		$cacsp_option_old = get_option( 'cacsp_option_markerting_images' );
		update_option( 'cacsp_option_markerting_images', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://px.ads.linkedin.com/', 'cacsp_option_markerting_images' ), 
			cacsp_check_existing_domain( 'https://www.linkedin.com/', 'cacsp_option_markerting_images' ) 
		), false );
    }

    // Facebook Pixel
    if ( intval( isset( $_POST['cacsp_option_quickstart_facebook_pixel'] ) ) ) {
    	$cacsp_option_old = get_option( 'cacsp_option_markerting_scripts' );
		update_option( 'cacsp_option_markerting_scripts', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://connect.facebook.net/', 'cacsp_option_markerting_scripts' ) 
		), false );
		$cacsp_option_old = get_option( 'cacsp_option_markerting_images' );
		update_option( 'cacsp_option_markerting_images', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://www.facebook.com/', 'cacsp_option_markerting_images' ) 
		), false );
    }

    // Hubspot
    if ( intval( isset( $_POST['cacsp_option_quickstart_hubspot'] ) ) ) {
    	$cacsp_option_old = get_option( 'cacsp_option_statistics_frames' );
		update_option( 'cacsp_option_statistics_frames', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://track.hubspot.com/', 'cacsp_option_statistics_frames' ) . 
			cacsp_check_existing_domain( 'https://static.hsappstatic.net/', 'cacsp_option_statistics_frames' ) . 
			cacsp_check_existing_domain( 'https://forms.hsforms.com/', 'cacsp_option_statistics_frames' ) 
		), false );
    	$cacsp_option_old = get_option( 'cacsp_option_statistics_scripts' );
		update_option( 'cacsp_option_statistics_scripts', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://js.hs-analytics.net/', 'cacsp_option_statistics_scripts' ) . 
			cacsp_check_existing_domain( 'https://static.hsappstatic.net/', 'cacsp_option_statistics_scripts' ) . 
			cacsp_check_existing_domain( 'https://js.hs-scripts.com/', 'cacsp_option_statistics_scripts' ) 
		), false );
		$cacsp_option_old = get_option( 'cacsp_option_statistics_images' );
		update_option( 'cacsp_option_statistics_images', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://track.hubspot.com/', 'cacsp_option_statistics_images' ) . 
			cacsp_check_existing_domain( 'https://static.hsappstatic.net/', 'cacsp_option_statistics_images' ) 
		), false );
		$cacsp_option_old = get_option( 'cacsp_option_markerting_frames' );
		update_option( 'cacsp_option_markerting_frames', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://app.hubspot.com/', 'cacsp_option_markerting_frames' ) 
		), false );
    	$cacsp_option_old = get_option( 'cacsp_option_markerting_scripts' );
		update_option( 'cacsp_option_markerting_scripts', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://js.hscollectedforms.net/', 'cacsp_option_markerting_scripts' ) . 
			cacsp_check_existing_domain( 'https://js.usemessages.com/', 'cacsp_option_markerting_scripts' ) . 
			cacsp_check_existing_domain( 'https://js.hs-banner.com/', 'cacsp_option_markerting_scripts' ) 
		), false );	
    }

    // Hotjar
    if ( intval( isset( $_POST['cacsp_option_quickstart_hotjar'] ) ) ) {
		$cacsp_option_old = get_option( 'cacsp_option_statistics_scripts' );
		update_option( 'cacsp_option_statistics_scripts', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://*.hotjar.com/', 'cacsp_option_statistics_scripts' ) 
		), false );
		$cacsp_option_old = get_option( 'cacsp_option_statistics_frames' );
		update_option( 'cacsp_option_statistics_frames', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://*.hotjar.com/', 'cacsp_option_statistics_frames') 
		), false );
    }

    // Jetpack
    if ( intval( isset( $_POST['cacsp_option_quickstart_jetpack'] ) ) ) {
		$cacsp_option_old = get_option( 'cacsp_option_statistics_scripts' );
		update_option( 'cacsp_option_statistics_scripts', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://stats.wp.com/', 'cacsp_option_statistics_scripts' ) 
		), false );
		$cacsp_option_old = get_option( 'cacsp_option_statistics_images' );
		update_option( 'cacsp_option_statistics_images', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://pixel.wp.com/', 'cacsp_option_statistics_images') 
		), false );
    }

    // Google Maps
    if ( intval( isset( $_POST['cacsp_option_quickstart_google_maps'] ) ) ) {
		$cacsp_option_old = get_option( 'cacsp_option_experience_frames' );
		update_option( 'cacsp_option_experience_frames', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://www.google.com/', 'cacsp_option_experience_frames' ) . 
			cacsp_check_existing_domain( 'https://maps.google.com/', 'cacsp_option_experience_frames' )
		), false );
		$cacsp_option_old = get_option( 'cacsp_option_experience_scripts' );
		update_option( 'cacsp_option_experience_scripts', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://maps.googleapis.com/', 'cacsp_option_experience_scripts' ) . 
			cacsp_check_existing_domain( 'https://maps.google.com/', 'cacsp_option_experience_scripts' ) 
		), false );
		$cacsp_option_old = get_option( 'cacsp_option_experience_images' );
		update_option( 'cacsp_option_experience_images', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://maps.gstatic.com/', 'cacsp_option_experience_images' ) . 
			cacsp_check_existing_domain( 'https://maps.google.com/', 'cacsp_option_experience_images' ) . 
			cacsp_check_existing_domain( 'https://maps.googleapis.com/', 'cacsp_option_experience_images' ) 
		), false );
    }
    
    // Google Translate
    if ( intval( isset( $_POST['cacsp_option_quickstart_google_translate'] ) ) ) {
		$cacsp_option_old = get_option( 'cacsp_option_experience_scripts' );
		update_option( 'cacsp_option_experience_scripts', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://translate.google.com/', 'cacsp_option_experience_scripts' ) . 
			cacsp_check_existing_domain( 'https://translate.googleapis.com/', 'cacsp_option_experience_scripts' ) 
		), false );
		$cacsp_option_old = get_option( 'cacsp_option_experience_images' );
		update_option( 'cacsp_option_experience_images', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://translate.googleapis.com/', 'cacsp_option_experience_images' ) 
		), false );
    }

    // YouTube
    if ( intval( isset( $_POST['cacsp_option_quickstart_youtube'] ) ) ) {
    	$cacsp_option_old = get_option( 'cacsp_option_experience_images' );
		update_option( 'cacsp_option_experience_images', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://*.ytimg.com/', 'cacsp_option_experience_images' ) 
		), false );
		$cacsp_option_old = get_option( 'cacsp_option_experience_frames' );
		update_option( 'cacsp_option_experience_frames', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://*.youtube.com/', 'cacsp_option_experience_frames' ) . 
			cacsp_check_existing_domain( 'https://*.youtube-nocookie.com/', 'cacsp_option_experience_frames' ) . 
			cacsp_check_existing_domain( 'https://youtu.be/', 'cacsp_option_experience_frames' )
		), false );
    }

    // Vimeo
    if ( intval( isset( $_POST['cacsp_option_quickstart_vimeo'] ) ) ) {
		$cacsp_option_old = get_option( 'cacsp_option_experience_frames' );
		update_option( 'cacsp_option_experience_frames', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://*.vimeo.com/', 'cacsp_option_experience_frames' ) 
		), false );
    }

    // Spotify
    if ( intval( isset( $_POST['cacsp_option_quickstart_spotify'] ) ) ) {
		$cacsp_option_old = get_option( 'cacsp_option_experience_frames' );
		update_option( 'cacsp_option_experience_frames', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://*.spotify.com/', 'cacsp_option_experience_frames' ) 
		), false );
    }

    // Issuu
    if ( intval( isset( $_POST['cacsp_option_quickstart_issuu'] ) ) ) {
		$cacsp_option_old = get_option( 'cacsp_option_experience_scripts' );
		update_option( 'cacsp_option_experience_scripts', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://*.issuu.com/', 'cacsp_option_experience_scripts' ) 
		), false );
		$cacsp_option_old = get_option( 'cacsp_option_experience_frames' );
		update_option( 'cacsp_option_experience_frames', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://*.issuu.com/', 'cacsp_option_experience_frames' ) 
		), false );
    }

    // Twitter
    if ( intval( isset( $_POST['cacsp_option_quickstart_twitter'] ) ) ) {
		$cacsp_option_old = get_option( 'cacsp_option_experience_scripts' );
		update_option( 'cacsp_option_experience_scripts', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://platform.twitter.com/', 'cacsp_option_experience_scripts' ) . 
			cacsp_check_existing_domain( 'https://cdn.syndication.twimg.com/', 'cacsp_option_experience_scripts' )
		), false );
		$cacsp_option_old = get_option( 'cacsp_option_experience_images' );
		update_option( 'cacsp_option_experience_images', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://*.twimg.com/', 'cacsp_option_experience_images' ) . 
			cacsp_check_existing_domain( 'https://platform.twitter.com/', 'cacsp_option_experience_images' )
		), false );
		$cacsp_option_old = get_option( 'cacsp_option_experience_frames' );
		update_option( 'cacsp_option_experience_frames', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://platform.twitter.com/', 'cacsp_option_experience_frames' ) . 
			cacsp_check_existing_domain( 'https://syndication.twitter.com/', 'cacsp_option_experience_frames' )
		), false );
    }

    // PayPal
	if ( intval( isset( $_POST['cacsp_option_quickstart_paypal'] ) ) ) {
		$cacsp_option_old = get_option( 'cacsp_option_always_scripts' );
		update_option( 'cacsp_option_always_scripts', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://www.paypalobjects.com/', 'cacsp_option_always_scripts' ) 
		), false );
		$cacsp_option_old = get_option( 'cacsp_option_always_images' );
		update_option( 'cacsp_option_always_images', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://www.paypalobjects.com/', 'cacsp_option_always_images' ) 
		), false );
		$cacsp_option_old = get_option( 'cacsp_option_always_frames' );
		update_option( 'cacsp_option_always_frames', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://*.paypal.com/', 'cacsp_option_always_frames' ) 
		), false );
    }

    // Stripe
    if ( intval( isset( $_POST['cacsp_option_quickstart_stripe'] ) ) ) {
		$cacsp_option_old = get_option( 'cacsp_option_always_scripts' );
		update_option( 'cacsp_option_always_scripts', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://s3.amazonaws.com/', 'cacsp_option_always_scripts' ) . 
			cacsp_check_existing_domain( 'https://*.stripe.com/', 'cacsp_option_always_scripts' ) 
		), false );
		$cacsp_option_old = get_option( 'cacsp_option_always_frames' );
		update_option( 'cacsp_option_always_frames', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://*.stripe.com/', 'cacsp_option_always_frames' ) 
		), false );
    }

    // reCAPTCHA
    if ( intval( isset( $_POST['cacsp_option_quickstart_recaptcha'] ) ) ) {
		$cacsp_option_old = get_option( 'cacsp_option_experience_scripts' );
		update_option( 'cacsp_option_experience_scripts', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://www.recaptcha.net/', 'cacsp_option_experience_scripts' ) . 
			cacsp_check_existing_domain( 'https://www.gstatic.com/', 'cacsp_option_experience_scripts' ) . 
			cacsp_check_existing_domain( 'https://www.google.com/', 'cacsp_option_experience_scripts' ) 
		), false );
		$cacsp_option_old = get_option( 'cacsp_option_experience_frames' );
		update_option( 'cacsp_option_experience_frames', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://www.google.com/', 'cacsp_option_experience_frames' )
		), false );
    }

    // Gravatar
    if ( intval( isset( $_POST['cacsp_option_quickstart_gravatar'] ) ) ) {
		$cacsp_option_old = get_option( 'cacsp_option_experience_images' );
		update_option( 'cacsp_option_experience_images', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://secure.gravatar.com/', 'cacsp_option_experience_images' ) 
		), false );
    }

    // SoundCloud
    if ( intval( isset( $_POST['cacsp_option_quickstart_soundcloud'] ) ) ) {
		$cacsp_option_old = get_option( 'cacsp_option_experience_frames' );
		update_option( 'cacsp_option_experience_frames', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://*.soundcloud.com/', 'cacsp_option_experience_frames' ) 
		), false );
    }

    // Calendly
    if ( intval( isset( $_POST['cacsp_option_quickstart_calendly'] ) ) ) {
    	$cacsp_option_old = get_option( 'cacsp_option_experience_scripts' );
		update_option( 'cacsp_option_experience_scripts', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://*.calendly.com/', 'cacsp_option_experience_scripts' ) . 
			cacsp_check_existing_domain( 'https://calendly.com/', 'cacsp_option_experience_scripts' )
		), false );
		$cacsp_option_old = get_option( 'cacsp_option_experience_frames' );
		update_option( 'cacsp_option_experience_frames', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://*.calendly.com/', 'cacsp_option_experience_frames' ) . 
			cacsp_check_existing_domain( 'https://calendly.com/', 'cacsp_option_experience_frames' )
		), false );
    }

    // Mailchimp
    if ( intval( isset( $_POST['cacsp_option_quickstart_mailchimp'] ) ) ) {
		$cacsp_option_old = get_option( 'cacsp_option_always_scripts' );
		update_option( 'cacsp_option_always_scripts', cacsp_sanitize_domains( 
			$cacsp_option_old . 
			cacsp_check_existing_domain( 'https://s3.amazonaws.com/', 'cacsp_option_always_scripts' ) . 
			cacsp_check_existing_domain( 'https://*.list-manage.com/', 'cacsp_option_always_scripts' ) 
		), false );
    }

	echo '<div id="message" class="updated fade">
		<p>' . __( 'Your settings are now updated in <a href="?page=cacsp_settings&tab=domains">Domains</a>', 'cookies-and-content-security-policy' ) . '</p>
	</div>';
// Update domain options
} elseif ( isset( $_POST['save_cacsp_settings_domains'] ) && $can_change_all ) {
	// Always allowed
    update_option( 'cacsp_option_always_scripts', cacsp_sanitize_domains( $_POST['cacsp_option_always_scripts'] ) );
    update_option( 'cacsp_option_always_images', cacsp_sanitize_domains( $_POST['cacsp_option_always_images'] ) );
    update_option( 'cacsp_option_always_frames', cacsp_sanitize_domains( $_POST['cacsp_option_always_frames'] ) );
    if ( $cacsp_option_forms ) {
        update_option( 'cacsp_option_always_forms', cacsp_sanitize_domains( $_POST['cacsp_option_always_forms'] ) );
    }
    if ( $cacsp_option_worker ) {
        update_option( 'cacsp_option_always_worker', cacsp_sanitize_domains( $_POST['cacsp_option_always_worker'] ) );
    }
	// Statistics
    update_option( 'cacsp_option_statistics_scripts', cacsp_sanitize_domains( $_POST['cacsp_option_statistics_scripts'] ) );
    update_option( 'cacsp_option_statistics_images', cacsp_sanitize_domains( $_POST['cacsp_option_statistics_images'] ) );
    update_option( 'cacsp_option_statistics_frames', cacsp_sanitize_domains( $_POST['cacsp_option_statistics_frames'] ) );
    if ( $cacsp_option_forms ) {
        update_option( 'cacsp_option_statistics_forms', cacsp_sanitize_domains( $_POST['cacsp_option_statistics_forms'] ) );
    }
    if ( $cacsp_option_worker ) {
        update_option( 'cacsp_option_statistics_worker', cacsp_sanitize_domains( $_POST['cacsp_option_statistics_worker'] ) );
    }
    // Experience
    update_option( 'cacsp_option_experience_scripts', cacsp_sanitize_domains( $_POST['cacsp_option_experience_scripts'] ) );
    update_option( 'cacsp_option_experience_images', cacsp_sanitize_domains( $_POST['cacsp_option_experience_images'] ) );
    update_option( 'cacsp_option_experience_frames', cacsp_sanitize_domains( $_POST['cacsp_option_experience_frames'] ) );
    if ( $cacsp_option_forms ) {
        update_option( 'cacsp_option_experience_forms', cacsp_sanitize_domains( $_POST['cacsp_option_experience_forms'] ) );
    }
    if ( $cacsp_option_worker ) {
        update_option( 'cacsp_option_experience_worker', cacsp_sanitize_domains( $_POST['cacsp_option_experience_worker'] ) );
    }
    // Marketing
    update_option( 'cacsp_option_markerting_scripts', cacsp_sanitize_domains( $_POST['cacsp_option_markerting_scripts'] ) );
    update_option( 'cacsp_option_markerting_images', cacsp_sanitize_domains( $_POST['cacsp_option_markerting_images'] ) );
    update_option( 'cacsp_option_markerting_frames', cacsp_sanitize_domains( $_POST['cacsp_option_markerting_frames'] ) );
    if ( $cacsp_option_forms ) {
        update_option( 'cacsp_option_markerting_forms', cacsp_sanitize_domains( $_POST['cacsp_option_markerting_forms'] ) );
    }
    if ( $cacsp_option_worker ) {
        update_option( 'cacsp_option_markerting_worker', cacsp_sanitize_domains( $_POST['cacsp_option_markerting_worker'] ) );
    }

	echo '<div id="message" class="updated fade">
		<p>' . __( 'Your settings are now updated', 'cookies-and-content-security-policy' ) . '</p>
	</div>';
} elseif ( isset( $_POST['save_cacsp_settings_texts'] ) && $can_change_all ) {
	update_option( 'cacsp_option_text_header', cacsp_sanitize_text_field_with_html( $_POST['cacsp_option_text_header'] ) );
	update_option( 'cacsp_option_text_info', cacsp_sanitize_text_field_with_html( $_POST['cacsp_option_text_info'] ) );
	update_option( 'cacsp_option_text_link_text', cacsp_sanitize_text_field_with_html( $_POST['cacsp_option_text_link_text'] ) );
	update_option( 'cacsp_option_text_settings', cacsp_sanitize_text_field_with_html( $_POST['cacsp_option_text_settings'] ) );
	update_option( 'cacsp_option_text_always_allow_header', cacsp_sanitize_text_field_with_html( $_POST['cacsp_option_text_always_allow_header'] ) );
	update_option( 'cacsp_option_text_always_allow_description', cacsp_sanitize_text_field_with_html( $_POST['cacsp_option_text_always_allow_description'] ) );
	update_option( 'cacsp_option_text_statistics_header', cacsp_sanitize_text_field_with_html( $_POST['cacsp_option_text_statistics_header'] ) );
	update_option( 'cacsp_option_text_statistics_description', cacsp_sanitize_text_field_with_html( $_POST['cacsp_option_text_statistics_description'] ) );
	update_option( 'cacsp_option_text_experience_header', cacsp_sanitize_text_field_with_html( $_POST['cacsp_option_text_experience_header'] ) );
	update_option( 'cacsp_option_text_experience_description', cacsp_sanitize_text_field_with_html( $_POST['cacsp_option_text_experience_description'] ) );
	update_option( 'cacsp_option_text_marketing_header', cacsp_sanitize_text_field_with_html( $_POST['cacsp_option_text_marketing_header'] ) );
	update_option( 'cacsp_option_text_marketing_description', cacsp_sanitize_text_field_with_html( $_POST['cacsp_option_text_marketing_description'] ) );
	update_option( 'cacsp_option_settings_button', cacsp_sanitize_text_field_with_html( $_POST['cacsp_option_settings_button'] ) );
	update_option( 'cacsp_option_refuse_button', cacsp_sanitize_text_field_with_html( $_POST['cacsp_option_refuse_button'] ) );
	update_option( 'cacsp_option_accept_all_button', cacsp_sanitize_text_field_with_html( $_POST['cacsp_option_accept_all_button'] ) );
	update_option( 'cacsp_option_save_button', cacsp_sanitize_text_field_with_html( $_POST['cacsp_option_save_button'] ) );
	update_option( 'cacsp_review_settings_description', cacsp_sanitize_text_field_with_html( $_POST['cacsp_review_settings_description'] ) );
	update_option( 'cacsp_review_settings_button', cacsp_sanitize_text_field_with_html( $_POST['cacsp_review_settings_button'] ) );
	update_option( 'cacsp_not_allowed_description', cacsp_sanitize_text_field_with_html( $_POST['cacsp_not_allowed_description'] ) );
	update_option( 'cacsp_not_allowed_button', cacsp_sanitize_text_field_with_html( $_POST['cacsp_not_allowed_button'] ) );
	update_option( 'save_cacsp_settings_texts', cacsp_sanitize_text_field_with_html( $_POST['save_cacsp_settings_texts'] ) );
	echo '<div id="message" class="updated fade">
		<p>' . __( 'Your settings are now updated', 'cookies-and-content-security-policy' ) . '</p>
	</div>';
} elseif ( isset( $_POST['save_cacsp_settings_settings'] ) && $can_change_all ) {
	update_option( 'cacsp_option_only_csp', intval( isset( $_POST['cacsp_option_only_csp'] ) ) );
	update_option( 'cacsp_option_own_style', intval( isset( $_POST['cacsp_option_own_style'] ) ) );
	update_option( 'cacsp_option_own_js', intval( isset( $_POST['cacsp_option_own_js'] ) ) );
	update_option( 'cacsp_option_banner', intval( isset( $_POST['cacsp_option_banner'] ) ) );
	update_option( 'cacsp_option_allow_use_site', intval( isset( $_POST['cacsp_option_allow_use_site'] ) ) );
	update_option( 'cacsp_option_grandma', intval( isset( $_POST['cacsp_option_grandma'] ) ) );
	update_option( 'cacsp_option_hide_unused_settings_row', intval( isset( $_POST['cacsp_option_hide_unused_settings_row'] ) ) );
	update_option( 'cacsp_option_show_refuse_button', intval( isset( $_POST['cacsp_option_show_refuse_button'] ) ) );
	update_option( 'cacsp_option_forms', intval( isset( $_POST['cacsp_option_forms'] ) ) );
	update_option( 'cacsp_option_worker', intval( isset( $_POST['cacsp_option_worker'] ) ) );
	update_option( 'cacsp_option_blob', intval( isset( $_POST['cacsp_option_blob'] ) ) );
	update_option( 'cacsp_option_disable_unsafe_inline', intval( isset( $_POST['cacsp_option_disable_unsafe_inline'] ) ) );
	update_option( 'cacsp_option_disable_unsafe_eval', intval( isset( $_POST['cacsp_option_disable_unsafe_eval'] ) ) );
	update_option( 'cacsp_option_meta', intval( isset( $_POST['cacsp_option_meta'] ) ) );
	update_option( 'cacsp_option_debug', intval( isset( $_POST['cacsp_option_debug'] ) ) );
	update_option( 'cacsp_option_no_x_csp', intval( isset( $_POST['cacsp_option_no_x_csp'] ) ) );
	update_option( 'cacsp_option_settings_policy_link', intval( $_POST['cacsp_option_settings_policy_link'] ) );
	update_option( 'cacsp_option_settings_policy_link_url', cacsp_sanitize_domains( $_POST['cacsp_option_settings_policy_link_url'], false ) );
	update_option( 'cacsp_option_settings_policy_link_target', intval( isset( $_POST['cacsp_option_settings_policy_link_target'] ) ) );
	echo '<div id="message" class="updated fade">
		<p>' . __( 'Your settings are now updated', 'cookies-and-content-security-policy' ) . '</p>
	</div>';
} elseif ( isset( $_POST['save_cacsp_settings_colors'] ) && $can_change_all ) {
	update_option( 'cacsp_option_color_backdrop', sanitize_hex_color( $_POST['cacsp_option_color_backdrop'] ) );
	update_option( 'cacsp_option_color_modal_bg', sanitize_hex_color( $_POST['cacsp_option_color_modal_bg'] ) );
	update_option( 'cacsp_option_color_modal_header_bg', sanitize_hex_color( $_POST['cacsp_option_color_modal_header_bg'] ) );
	update_option( 'cacsp_option_color_modal_list_border', sanitize_hex_color( $_POST['cacsp_option_color_modal_list_border'] ) );
	update_option( 'cacsp_option_color_modal_text_color', sanitize_hex_color( $_POST['cacsp_option_color_modal_text_color'] ) );
	update_option( 'cacsp_option_color_modal_header_text_color', sanitize_hex_color( $_POST['cacsp_option_color_modal_header_text_color'] ) );
	update_option( 'cacsp_option_color_text_on', sanitize_hex_color( $_POST['cacsp_option_color_text_on'] ) );
	update_option( 'cacsp_option_color_off', sanitize_hex_color( $_POST['cacsp_option_color_off'] ) );
	update_option( 'cacsp_option_color_on', sanitize_hex_color( $_POST['cacsp_option_color_on'] ) );
	update_option( 'cacsp_option_color_settings_button', sanitize_hex_color( $_POST['cacsp_option_color_settings_button'] ) );
	update_option( 'cacsp_option_color_settings_button_border', sanitize_hex_color( $_POST['cacsp_option_color_settings_button_border'] ) );
	update_option( 'cacsp_option_color_settings_button_text', sanitize_hex_color( $_POST['cacsp_option_color_settings_button_text'] ) );
	update_option( 'cacsp_option_color_refuse_button', sanitize_hex_color( $_POST['cacsp_option_color_refuse_button'] ) );
	update_option( 'cacsp_option_color_refuse_button_border', sanitize_hex_color( $_POST['cacsp_option_color_refuse_button_border'] ) );
	update_option( 'cacsp_option_color_refuse_button_text', sanitize_hex_color( $_POST['cacsp_option_color_refuse_button_text'] ) );
	update_option( 'cacsp_option_color_save_button', sanitize_hex_color( $_POST['cacsp_option_color_save_button'] ) );
	update_option( 'cacsp_option_color_save_button_border', sanitize_hex_color( $_POST['cacsp_option_color_save_button_border'] ) );
	update_option( 'cacsp_option_color_save_button_text', sanitize_hex_color( $_POST['cacsp_option_color_save_button_text'] ) );
	update_option( 'cacsp_option_color_accept_button', sanitize_hex_color( $_POST['cacsp_option_color_accept_button'] ) );
	update_option( 'cacsp_option_color_accept_button_border', sanitize_hex_color( $_POST['cacsp_option_color_accept_button_border'] ) );
	update_option( 'cacsp_option_color_accept_button_text', sanitize_hex_color( $_POST['cacsp_option_color_accept_button_text'] ) );
	echo '<div id="message" class="updated fade">
		<p>' . __( 'Your settings are now updated', 'cookies-and-content-security-policy' ) . '</p>
	</div>';
}
