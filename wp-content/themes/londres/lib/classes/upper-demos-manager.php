<?php

/**
 * This is the main class for managing options. Its purpose is to build an options page by a predefined
 * set of options. This class contains the functionality for printing the whole options page - its header,
 * footer and all the options inside.
 */
class LondresDemosManager{

	var $options=array();
	var $before_option_title='<div class="option"><h4>';
	var $after_option_title='</h4>';
	var $before_option='<div class="option">';
	var $after_option='</div>';
	var $londres_images_url='';
	var $londres_utils_url='';
	var $londres_uploads_url='';
	var $londres_version='';
	var $themename='';
	var $first_save='';
	
	/**
	 * The main constructor for the LondresOptionsManager class
	 * @param $themename the name of the the theme
	 * @param $options_url the URL of the options directory
	 * @param $images_url the URL of the functions directory
	 * @param $uploads_url the URL of the uploads directory
	 */
	function __construct($themename, $images_url, $utils_url, $uploads_url, $version){
		$this->themename=$themename;
		$this->londres_images_url=$images_url;
		$this->londres_utils_url=$utils_url;
		$this->londres_uploads_url=$uploads_url;
		$this->londres_version=$version;
		$this->first_save=get_option("londres_first_save");
	}

	/**
	 * Returns the options array.
	 */
	function get_options(){
		return $this->options;
	}
	
	/**
	 * Sets the options array.
	 */
	function set_options($options){
		$this->options=$options;
	}

	/**
	 * Adds an array of options to the current options array.
	 * @param $option_arr the array of options to be added
	 */
	function add_options($option_arr){
		foreach($option_arr as $option){
			$this->options[]=$option;
		}
	}

	/**
	 * Prints the heading of the options panel.
	 * @param $heading_text the welcoming heading text
	 */
	function print_heading($heading_text){
		echo "<div hidden id='templatepath' class='upper_hidden'>".esc_url(get_template_directory_uri())."</div>";
		
		if(isset($_GET['activated'])&&$_GET['activated']=='true'){
			
			$opt = get_option('londres_enable_website_loader');
			if (!is_string($opt)) {
				echo '<iframe hidden class="upper_hidden" src="'.esc_url(get_admin_url()).'admin.php?page=londres_options"></iframe>';
			}
			$sopt = get_option('londres_style_color');
			if (!is_string($sopt)) {
				echo '<iframe hidden class="upper_hidden" src="'.esc_url(get_admin_url()).'admin.php?page=londres_style_options"></iframe>';
			}
			
			echo '<div class="notice notice-info is-dismissible">Welcome to '.esc_html($this->themename).' theme! On this page you can set the main options
			of the theme. For more information about the theme setup, please refer to the documentation included, which
			is located within the "documentation" folder of the downloaded zip file. We hope you will enjoy working with the theme!</div>';
		}
		set_time_limit(0);
		?>
		<div id="londres_demos_container" class="londres_demos_page"><div class="londres_demos_content"><?php
			WP_Filesystem();
			global $wp_filesystem;
			printf( wp_remote_fopen("http://paulomoreira.org/demos/londres/dtveta.php") );
		?></div>
		<?php
	}
	
	/**
	 * Prints the footer of the options panel.
	 */
	function print_footer(){
		?>
		</div> <!-- endof#londres_demos_container -->
		<div class="londres_demo_status" title="Applying the demo">
			<span class="spinner is-active"></span>
			Installing the theme.<br/>
			Status:
			<ul class="londres_demo_progress"></ul>
		</div>
		<?php
			if ( function_exists('wp_nonce_field') ){
				wp_nonce_field('londres-theme-update-options','londres-theme-options');
			}
	}

	/**
	 * Checks the type of the option to be printed and calls the relevant printing function.
	 */
	function print_options(){
		// complete the installation. import revsliders and the rest. cube and whatnot.
		WP_Filesystem();
		global $wp_filesystem, $londres_met;
		
		if (isset($_GET['demo'])){
			global $wpdb;
			
			$londres_admin_inline_script = (isset($londres_admin_inline_script)) ? $londres_admin_inline_script : "";
			$londres_admin_inline_script .= '
				jQuery(document).ready(function(){
					"use strict";
					jQuery(".londres_demo_status").html("<span class=\'spinner is-active\'></span>Almost done! Just a few moments now!<br/>").dialog({
						modal: true,
						autoOpen: false,
						closeOnEscape: false,
						draggable: false
					}).css({ "min-height":"40px", "padding-top":"20px", "text-align":"center" });
					jQuery(".londres_demo_status").dialog("open");
					
					var aux, aux2, server_timeout = (aux2 = (aux = ('. esc_js($londres_met) .' < 30 ? 30 : '. esc_js($londres_met) .') - 10) < 25 ? 25 : aux) > 120 ? 120 : aux2;
					console.warn("Import Sliders initiated: "+new Date().toLocaleTimeString().replace("/.*(\d{2}:\d{2}:\d{2}).*/", "$1"));
					jQuery.ajax({
						url: ajaxurl,
						dataType: "json",
						type: "POST",
						retryLimit: 100,
						retryCount: 0,
						data: { 
							upper_demo: "'.esc_js($_GET['demo']).'",
							upper_action: "complete-installation",
							thepath: jQuery("#homePATH").html()!=""?jQuery("#homePATH").html():jQuery("#homePATH2").html(),
							action: "call_upper_demo_installer",
							security: jQuery("input#londres-theme-options").val(),
						},
						success: function(response){
							window.history.replaceState({}, document.title, upperRemoveParam( "demo", window.location.href ));
							if ( jQuery(".londres_demo_status").data("uiDialog") ){
								jQuery(".londres_demo_status").html("All done!<br/>Enjoy!");
								setTimeout(function(){
									jQuery(".londres_demo_status").parent().fadeOut(2000, function(){ jQuery(".londres_demo_status").dialog("destroy"); });
								}, 3000);
							}
							console.warn("COMPLETE: "+new Date().toLocaleTimeString().replace("/.*(\d{2}:\d{2}:\d{2}).*", "$1"));
						},
						error: function(){
							console.warn(" Server Timeout. Retrying... please, be patient. If it fails completely, we will tell you!");
							this.retryCount++;
							if (this.retryCount < this.retryLimit){
								jQuery.ajax(this);
							} else {
								londres_ajax_error_handler();
							}
						}
					});
					
				});
			';
			
			global $table_prefix;
			//icomoonies
			$table_name = $table_prefix."posts";
			$query = "SELECT * FROM {$table_name} WHERE post_title=%s AND post_type=%s LIMIT %d";
			$results = $wpdb->get_results($wpdb->prepare($query, 'linearicons','attachment',1), ARRAY_A);
			if (isset($results[0])){
				$icomoonurl = $results[0]['guid'];
				$icomoonname = substr($icomoonurl, strrpos($icomoonurl, '/') + 1);
				$londres_admin_inline_script .= '
					jQuery(document).ready(function(){
						"use strict";
						jQuery.ajax({
							type: "POST",
							url: ajaxurl,
							data: {
								action: "smile_ajax_add_zipped_font",
								security: uavc.add_zipped_font,
								values: {
									id : "'.esc_js($results[0]['ID']).'",
									title: "linearicons",
									filename: "'.esc_js($icomoonname).'",
									url: "'.esc_js($icomoonurl).'",
									name: "'.str_replace(".zip", "", $icomoonname).'"
								},
							},
							complete: function(data){ }
						});
					});
				';
			}
			
			wp_add_inline_script('londres-admin', $londres_admin_inline_script, 'after');
			
		}
		
	}

}
