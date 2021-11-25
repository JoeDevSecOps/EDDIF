<?php
/**
 * @package WordPress
 * @subpackage Londres
 */
	
	add_action( 'after_setup_theme', 'londres_setup' );
	
	//body class
	function londres_custom_body_class($classes, $class){
		if (is_singular() && get_post_meta(get_the_ID(), 'londres_enable_custom_header_options_value', true)=='yes'){
			if (get_post_meta(get_the_ID(), 'londres_content_to_the_top_value', true) == "off") $classes[] = "content_after_header";
		}
		else {
			if (get_option('londres_content_to_the_top') == "off") $classes[] = "content_after_header";
		}
		return $classes;
	}
	
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	
	add_filter( 'body_class', 'londres_custom_body_class', 10, 2 );
	
	//under construction feature.
	function londres_under_construction(){
		$londres_uc_id = get_option('londres_under_construction_page');
		require_once(get_template_directory().'/template-under-construction.php');
		exit;
	}
	
	function londres_setup(){
		
		//remove notifications
		add_action( 'vc_before_init', 'londres_vcSetAsTheme' );
		function londres_vcSetAsTheme() {
		    vc_set_as_theme(true);
			update_option('wpb_js_gutenberg_disable',1);
		}
		if (function_exists( 'set_revslider_as_theme' )){
			add_action( 'init', 'londres_set_revslider_as_theme' );
			function londres_set_revslider_as_theme() {
				set_revslider_as_theme();
			}
		}
	
		/** 
		 * Add default posts and comments RSS feed links to head
		 */
		add_theme_support( 'automatic-feed-links' );
		
		/* Add theme-supported features. */
		add_theme_support( 'title-tag' );
			
		/**
		 * This theme uses post thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		
		/**
		 *	This theme supports woocommerce
		 */
		add_theme_support( 'woocommerce' );
		
		
		/* new gutenberg features */
		add_theme_support( 'align-wide' );	
		/**
		 *	This theme supports editor styles
		 */
		add_editor_style("/css/layout-style.css");
		
		/* Add custom actions. */
		/**
		 * Make theme available for translation
		 * Translations can be filed in the /languages/ directory
		 */
		load_theme_textdomain( 'londres', get_template_directory() . '/languages' );
			
		$locale = get_locale();
		$locale_file = get_template_directory() . "/languages/$locale.php";
		if ( is_readable( $locale_file ) )
			require_once( $locale_file );
		/*
	
		/**
		 * Set the content width based on the theme's design and stylesheet.
		 */
		if ( ! isset( $content_width ) )
			$content_width = 900;
		
		//WMPL
		/**
		 * register panel strings for translation
		 */
		if (function_exists ( 'icl_register_string' )){
			require_once (get_template_directory().'/inc/theme-wpml.php');
		}
		//\WMPL
		
		//declare some global variables that will be used everywhere
		global $londres_new_meta_boxes,
		$londres_new_meta_post_boxes,
		$londres_new_meta_portfolio_boxes,
		$londres_buttons,
		$londres_data;
		$londres_new_meta_boxes=array();
		$londres_new_meta_post_boxes=array();
		$londres_new_meta_portfolio_boxes=array();
		$londres_buttons=array();
		$londres_data=new stdClass();
		
		
		/*----------------------------------------------------------------
		 *  DEFINE THE MAIN CONSTANTS
		 *---------------------------------------------------------------*/
		//main theme info constants
		
		$my_theme = wp_get_theme();
		define("LONDRES_VERSION", $my_theme->Version);
		//define the main paths and URLs
		define("LONDRES_LIB_PATH", get_template_directory() . '/lib/');
		define("LONDRES_LIB_URL", get_template_directory_uri().'/lib/');
		define("LONDRES_JS_PATH", get_template_directory_uri().'/js/');
		define("LONDRES_CSS_PATH", get_template_directory_uri().'/css/');
	
		define("LONDRES_FUNCTIONS_PATH", LONDRES_LIB_PATH . 'functions/');
		define("LONDRES_FUNCTIONS_URL", LONDRES_LIB_URL.'functions/');
		define("LONDRES_CLASSES_PATH", LONDRES_LIB_PATH.'classes/');
		define("LONDRES_OPTIONS_PATH", LONDRES_LIB_PATH.'options/');
		define("LONDRES_WIDGETS_PATH", LONDRES_LIB_PATH.'widgets/');
		define("LONDRES_SHORTCODES_PATH", LONDRES_LIB_PATH.'shortcodes/');
		define("LONDRES_PLUGINS_PATH", LONDRES_LIB_PATH.'plugins/');
		define("LONDRES_UTILS_URL", LONDRES_LIB_URL.'utils/');
		
		define("LONDRES_IMAGES_URL", LONDRES_LIB_URL.'images/');
		define("LONDRES_CSS_URL", LONDRES_LIB_URL.'css/');
		define("LONDRES_SCRIPT_URL", LONDRES_LIB_URL.'script/');
		define("LONDRES_PATTERNS_URL", get_template_directory_uri().'/images/londres_patterns/');
		$uploadsdir=wp_upload_dir();
		define("LONDRES_UPLOADS_URL", $uploadsdir['url']);
		define("LONDRES_SEPARATOR", '|*|');
		define("LONDRES_OPTIONS_PAGE", 'londres_options');
		define("LONDRES_STYLE_OPTIONS_PAGE", 'londres_style_options');
		define("LONDRES_DEMOS_PAGE", 'londres_demos');
	
		/*----------------------------------------------------------------
		 *  INCLUDE THE FUNCTIONS FILES
		 *---------------------------------------------------------------*/
				
		require_once (LONDRES_FUNCTIONS_PATH.'general.php');  //some main common functions
		require_once (LONDRES_FUNCTIONS_PATH.'stylesheet.php');  //some main common functions
		add_action('wp_enqueue_scripts', 'londres_style', 1);
		add_action('wp_enqueue_scripts', 'londres_scripts', 10);
	
		
		require_once (LONDRES_FUNCTIONS_PATH.'sidebars.php');  //the sidebar functionality
		if ( isset($_GET['page']) && $_GET['page'] == LONDRES_OPTIONS_PAGE ){
			require_once (LONDRES_CLASSES_PATH.'upper-options-manager.php');  //the theme options manager functionality
		}
		if ( isset($_GET['page']) && $_GET['page'] == LONDRES_STYLE_OPTIONS_PAGE ){
			require_once (LONDRES_CLASSES_PATH.'upper-style-options-manager.php');  //the theme options manager functionality
		}
		if ( isset($_GET['page']) && $_GET['page'] == LONDRES_DEMOS_PAGE ){
			require_once (LONDRES_CLASSES_PATH.'upper-demos-manager.php');  //the theme options manager functionality
		}
			
		require_once (LONDRES_CLASSES_PATH.'upper-templater.php');  
		require_once (LONDRES_CLASSES_PATH.'upper-custom-data-manager.php');  
		require_once (LONDRES_CLASSES_PATH.'upper-custom-page.php');  
		require_once (LONDRES_CLASSES_PATH.'upper-custom-page-manager.php');  
		require_once (LONDRES_FUNCTIONS_PATH.'custom-pages.php');  //the comments functionality
		require_once (LONDRES_FUNCTIONS_PATH.'comments.php');  //the comments functionality

		do_action( 'londres_plugin_widgets_init' ); // the londres-plugin-widgets functionality

		require_once (LONDRES_FUNCTIONS_PATH.'options.php');  //the theme options functionality
		
		if (is_admin()){
			require_once (LONDRES_FUNCTIONS_PATH. 'meta.php');  //adds the custom meta fields to the posts and pages
			add_action('admin_enqueue_scripts','londres_admin_style');
		}
		$functions_path = get_template_directory() . '/functions/';
		
		add_filter('woocommerce_add_to_cart_fragments' , 'londres_woocommerce_header_add_to_cart_fragment' );
		
		// Declare sidebar widget zone
		if (function_exists('register_sidebar')) {
			register_sidebar(array(
				'name' => esc_html__( 'Blog Sidebar', 'londres' ),
				'id'   => 'sidebar-widgets',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2>',
				'after_title'   => '</h2>'
			));
		}
		
		if (!function_exists('londres_wp_pagenavi')){ 
			$including = $functions_path. 'wp-pagenavi.php';
		    require_once($including);
		}
		
		/* ------------------------------------------------------------------------ */
		/* Misc
		/* ------------------------------------------------------------------------ */
		// Post Thumbnail Sizes
		if ( function_exists( 'add_image_size' ) ) add_theme_support( 'post-thumbnails' );
		
		if ( function_exists( 'add_image_size' ) ) {
			add_image_size( 'londres_blog', 1000, 563, true );				// Standard Blog Image
			add_image_size( 'londres_mini', 80, 80, true ); 				// used for widget thumbnail
			add_image_size( 'londres_portfolio', 600, 400, true );			// also for blog-medium
			add_image_size( 'londres_regular', 500, 500, true ); 
			add_image_size( 'londres_wide', 1000, 500, true ); 
			add_image_size( 'londres_tall', 500, 1000, true );
			add_image_size( 'londres_widetall', 1000, 1000, true ); 
		}
		
		/* tgm plugin activator */
		/**
		 * Include the TGM_Plugin_Activation class.
		 */
		require_once get_template_directory() . '/lib/functions/class-tgm-plugin-activation.php';
		
		add_action( 'tgmpa_register', 'londres_register_required_plugins' );	
		
		if ( class_exists('VCExtendAddonClass')){
			// Finally initialize code
			new VCExtendAddonClass();
		}
		
		if (get_option("londres_enable_smooth_scroll") == "on"){
			update_option('ultimate_smooth_scroll','enable');
		} else update_option('ultimate_smooth_scroll','disable');
		add_filter( 'woocommerce_enqueue_styles', '__return_false' );
	}
	
	function londres_admin_style(){
		wp_enqueue_style('londres-fa-painel', LONDRES_CSS_PATH .'font-awesome-painel.min.css');
		wp_enqueue_script( 'londres-admin', LONDRES_JS_PATH .'londres-admin.js', array(), '1',$in_footer = true);
	}
	
	
	
	function londres_wpml_filter_langs( $languages ) {
		foreach ( $languages as $k => $language ) {                                       
			$lang_code = explode ( '-' , $languages[$k]['language_code'] );
			$languages[$k]['native_name']     = ucfirst( $lang_code[0] );
			$languages[$k]['translated_name'] = ucfirst( $lang_code[0] );
		}	
		return $languages;
	}
	add_filter( 'icl_ls_languages', 'londres_wpml_filter_langs' );
	add_filter('wpml_add_language_selector', 'londres_wpml_filter_langs');
	

	/*-----------------------------------------------------------------------------------*/
	/*  THEME REQUIRES
	/*-----------------------------------------------------------------------------------*/
	require_once (get_template_directory().'/inc/theme-styles.php');
	
	function londres_style() {
	  	wp_enqueue_style('londres_js_composer_front');
		wp_style_add_data( 'londres_js_composer_front', 'conditional', 'lt IE 9' );
		
		$theme = wp_get_theme();
		wp_enqueue_style( 'londres-style', get_template_directory_uri().'/style.css', array(), $theme->Version );
	}
	
	function londres_slug_post_classes( $classes, $class, $post_id ) {
		$londres_is_portfolio = array_search( 'type-portfolio', $classes );
		if ( is_single( $post_id ) && false !== $londres_is_portfolio ) {
			$classes[] = 'container';
		}
		if (is_sticky( $post_id )) $classes[] = 'sticky';	 
		return $classes;
	}
	add_filter( 'post_class', 'londres_slug_post_classes', 10, 3 );
	
	/*-----------------------------------------------------------------------------------*/
	/*  LOAD THEME SCRIPTS
	/*-----------------------------------------------------------------------------------*/
	function londres_scripts(){
	
		if (!is_admin()){
			global $vc_addons_url, $wp_query, $post;
			
			if ( is_singular() ) wp_enqueue_script( 'comment-reply' );

			wp_enqueue_script( 'londres-upper-modernizr', LONDRES_JS_PATH .'utils/upper-modernizr.js', array('jquery'),'1.0',$in_footer = true);
			wp_enqueue_script( 'londres-upper-waypoints', LONDRES_JS_PATH .'utils/upper-waypoints.js', array('jquery'),'1.0',$in_footer = true);
			wp_enqueue_script( 'londres-upper-stellar', LONDRES_JS_PATH .'utils/upper-stellar.js', array('jquery'),'1.0',$in_footer = true);
			wp_enqueue_script( 'londres-upper-flex', LONDRES_JS_PATH .'utils/upper-flex.js', array('jquery'),'1.0',$in_footer = true);
			wp_enqueue_script( 'londres-upper-iso', LONDRES_JS_PATH .'utils/upper-iso.js', array('jquery'),'1.0',$in_footer = true);
			wp_enqueue_script( 'londres-upper-qloader', LONDRES_JS_PATH .'utils/upper-qloader.js', array('jquery'),'1.0',$in_footer = true);
			wp_enqueue_script( 'londres-upper-tweet', LONDRES_JS_PATH .'utils/upper-tweet.js', array('jquery'),'1.0',$in_footer = true);
			wp_enqueue_script( 'londres-upper-bootstrap', LONDRES_JS_PATH .'utils/upper-bootstrap.js', array('jquery'),'1.0',$in_footer = true);
			wp_enqueue_script( 'londres-upper-dlmenu', LONDRES_JS_PATH .'utils/upper-dlmenu.js', array('jquery'),'1.0',$in_footer = true);
			wp_enqueue_script( 'londres-upper-simpleselect', LONDRES_JS_PATH .'utils/upper-simpleselect.js', array('jquery'),'1.0',$in_footer = true);
			wp_enqueue_script( 'londres-upper-greyscale', LONDRES_JS_PATH .'utils/upper-greyscale.js', array('jquery'),'1.0',$in_footer = true);
	  	    wp_enqueue_script( 'jquery-effects-core', array('jquery') );
	  	    wp_register_script( 'londres-global', LONDRES_JS_PATH .'global.js', array('jquery'), '1',$in_footer = true);
			
			if (is_archive() || is_single() || is_search() || is_page_template('blog-template.php') || is_page_template('blog-masonry-template.php') || is_page_template('blog-masonry-grid-template.php') || is_front_page()) {

				$nposts = get_option('posts_per_page'); $londres_more = 0; $londres_pag = 0; $max = 0; $orderby=""; $category=""; $nposts = ""; $order = "";
				$londres_pag = $wp_query->query_vars['paged'];
				if (!is_numeric($londres_pag)) $londres_pag = 1;
				
				$londres_reading_option = get_option('londres_blog_reading_type');

				switch ($londres_reading_option){
					case "scrollauto": 
							// Add code to index pages.
							if( !is_singular() ) {	
								if (is_search()){
									$se = get_option("londres_enable_search_everything");
									$nposts = get_option('posts_per_page');
									$londres_pag = $wp_query->query_vars['paged'];
									if (!is_numeric($londres_pag)) $londres_pag = 1;

									if ($se == "on"){
										$args = array( 'showposts' => get_option('posts_per_page'), 'post_status' => 'publish', 'paged' => $londres_pag, 's' => esc_html($_GET['s']));
									    $londres_the_query = new WP_Query( $args );
									    $args2 = array( 'showposts' => -1, 'post_status' => 'publish', 'paged' => $londres_pag, 's' => esc_html($_GET['s']) );
										$counter = new WP_Query($args2);
									} else {
										$args = array('showposts' => get_option('posts_per_page'),'post_status' => 'publish','paged' => $londres_pag,'post_type' => 'post','s' => esc_html($_GET['s']));
									    $londres_the_query = new WP_Query( $args );
									    $args2 = array('showposts' => -1,'post_status' => 'publish','paged' => $londres_pag,'post_type' => 'post','s' => esc_html($_GET['s']));
										$counter = new WP_Query($args2);
									}
									$max = ceil($counter->post_count / $nposts);
									$londres_paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;
								} else {
									$max = $wp_query->max_num_pages;
									$londres_paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;
								}
								$londres_inline_script = '
									jQuery(document).ready(function($){
										"use strict";
										if (window.londresOptions.reading_option === "scrollauto" && !jQuery("body").hasClass("single") && typeof londres_monitorScrollTop == "function"){ 
											window.londres_loadingPoint = 0;
											//monitor page scroll to fire up more posts loader
											window.clearInterval(window.londres_interval);
											window.londres_interval = setInterval("londres_monitorScrollTop()", 1000 );
										}
									});
								';
								wp_add_inline_script('londres-global', $londres_inline_script, 'after');
							} else {
							    $args = array('showposts' => $nposts,'orderby' => $orderby,'order' => $order,'cat' => $category,'paged' => $londres_pag,'post_status' => 'publish');
				    		    $londres_the_query = new WP_Query( $args );
					    		$max = $londres_the_query->max_num_pages;
					    		$londres_paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;
					    		$londres_inline_script = '
									jQuery(document).ready(function($){
										"use strict";
										if (window.londresOptions.reading_option === "scrollauto" && !jQuery("body").hasClass("single") && typeof londres_monitorScrollTop == "function"){ 
											window.londres_loadingPoint = 0;
											//monitor page scroll to fire up more posts loader
											window.clearInterval(window.londres_interval);
											window.londres_interval = setInterval("londres_monitorScrollTop()", 1000 );
										}
									});
								';
								wp_add_inline_script('londres-global', $londres_inline_script, 'after');

				    		}
						break;
					case "scroll": 
							if( !is_singular() ) {	
								if (is_search()){
									$nposts = get_option('posts_per_page');
									$se = get_option("londres_enable_search_everything");
									if ($se == "on"){
										$args = array('showposts' => get_option('posts_per_page'),'post_status' => 'publish','paged' => $londres_pag,'s' => esc_html($_GET['s']));
									    $londres_the_query = new WP_Query( $args );
									    $args2 = array('showposts' => -1,'post_status' => 'publish','paged' => $londres_pag,'s' => esc_html($_GET['s']));
										$counter = new WP_Query($args2);
									} else {
										$args = array('showposts' => get_option('posts_per_page'),'post_status' => 'publish','paged' => $londres_pag,'post_type' => 'post','s' => esc_html($_GET['s']));
									    $londres_the_query = new WP_Query( $args );
									    $args2 = array('showposts' => -1,'post_status' => 'publish','paged' => $londres_pag,'post_type' => 'post','s' => esc_html($_GET['s']));
										$counter = new WP_Query($args2);
									}
									$max = ceil($counter->post_count / $nposts);
									$londres_pag = 1;
									$londres_pag = $wp_query->query_vars['paged'];
									if (!is_numeric($londres_pag)) $londres_pag = 1;
								} else {
									$max = $wp_query->max_num_pages;
									$londres_paged = $londres_pag;
								}
							} else {
								$orderby = ""; $category = "";
							    $args = array('showposts' => $nposts,'orderby' => $orderby,'order' => $order,'cat' => $category,'post_status' => 'publish');
				    		    $londres_the_query = new WP_Query( $args );
					    		$max = $londres_the_query->max_num_pages;
					    		$londres_pag = 1;
								$londres_pag = $wp_query->query_vars['paged'];
								if (!is_numeric($londres_pag)) $londres_pag = 1;
				    		}
						break;
				}
			} 
			
			/* pass needed options values to JS */
			$londresOptions = array(
				"templatepath" => esc_url(get_template_directory_uri())."/",
				"homePATH" => ABSPATH,
				"styleColor" => "#".esc_html(get_option("londres_style_color")),
				"londres_no_more_posts_text" => function_exists('icl_t') ? sprintf(esc_html__("%s", "londres"), icl_t( 'londres', 'No more posts to load.', get_option('londres_no_more_posts_text'))) : sprintf(esc_html__("%s", "londres"), get_option('londres_no_more_posts_text')),
				"londres_load_more_posts_text" => function_exists('icl_t') ? sprintf(esc_html__("%s", "londres"), icl_t( 'londres', 'Load More Posts', get_option('londres_load_more_posts_text'))) : sprintf(esc_html__("%s", "londres"), get_option('londres_load_more_posts_text')),
				"londres_loading_posts_text" => function_exists('icl_t') ? sprintf(esc_html__("%s", "londres"), icl_t( 'londres', 'Loading posts.', get_option('londres_loading_posts_text'))) : sprintf(esc_html__("%s", "londres"), get_option('londres_loading_posts_text')),
				"searcheverything" => get_option("londres_enable_search_everything"),
				"londres_header_shrink" => get_option('londres_fixed_menu') == 'on' && get_option('londres_header_after_scroll') == 'on' && get_option('londres_header_shrink_effect') == 'on' ? 'yes' : 'no',
				"londres_header_after_scroll" => get_option('londres_fixed_menu') == 'on' && get_option('londres_header_after_scroll') == 'on' ? 'yes' : 'no',
				"londres__portfolio_grayscale_effect" => get_option("londres_enable_portfolio_grayscale"),
				"londres__instagram_grayscale_effect" => get_option("londres_enable_instagram_grayscale"),
				"londres_enable_ajax_search" => get_option("londres_enable_ajax_search"),
				"londres_newsletter_input_text" => function_exists('icl_t') ? esc_html(icl_t( 'londres', 'Enter your email here', get_option('londres_newsletter_input_text'))) : esc_html(get_option('londres_newsletter_input_text')),
				"londres_update_section_titles" => get_option('londres_update_section_titles'),
				"londres_wpml_current_lang" => function_exists('icl_t') ? ICL_LANGUAGE_CODE : "",
				"reading_option" => isset($londres_reading_option) ? $londres_reading_option : "paged",
				"loader_startPage" => isset($londres_pag) ? $londres_pag : 0,
				"loader_maxPages" => isset($max) ? $max : 0,
				
				"londres_grayscale_effect" => get_option("londres_enable_grayscale")
			);
			
			wp_localize_script( 'londres-global', 'londresOptions', $londresOptions );
			wp_enqueue_script( 'londres-global' );
			add_action( 'wp_footer', 'londres_set_import_fonts' );
			
	  	    wp_enqueue_script( 'londres-jquery-twitter', LONDRES_JS_PATH .'twitter/jquery.tweet.js', array(),'1.0',$in_footer = true);
			
	  		wp_enqueue_script('cubeportfolio-jquery-js',$in_footer = false);
			wp_enqueue_style('cubeportfolio-jquery-css',$in_footer = false);
			
			if (class_exists('Ultimate_VC_Addons')) {
				wp_enqueue_script('ultimate', plugins_url().'/Ultimate_VC_Addons/assets/min-js/ultimate.min.js', array('jquery'),'3.19.11');
				wp_enqueue_style('ultimate-style-min', plugins_url().'/Ultimate_VC_Addons/assets/min-css/ultimate.min.css', '3.19.11');
			}
				
			if (is_single()){
				wp_enqueue_style( 'prettyphoto'); wp_enqueue_script( 'prettyphoto'); 
			}
			if (isset($post->ID)) $template = get_post_meta( $post->ID, '_wp_page_template' ,true );
						
			if (isset($template) && ( $template == 'template-blank.php' || $template == 'template-under-construction.php' || $template == 'template-home.php' ) || is_404()){
				if (class_exists('Ultimate_VC_Addons')) {
					wp_enqueue_script('ultimate', plugins_url().'/Ultimate_VC_Addons/assets/min-js/ultimate.min.js', array('jquery'),'3.19.11');
					wp_enqueue_style('ultimate-style-min', plugins_url().'/Ultimate_VC_Addons/assets/min-css/ultimate.min.css','3.19.11');
					wp_enqueue_script('ultimate-script');
					wp_enqueue_script('ultimate-vc-params');
				}
			}
			
			if (isset($template) && ($template == 'one-page-template.php' || $template == 'template-home.php')){
				wp_enqueue_script('googleapis');
			}
			
			if ((isset($template) && ($template == 'blog-masonry-template.php' || $template == 'blog-template.php')) || is_archive() || is_front_page()){
				wp_enqueue_script( 'londres-blog', LONDRES_JS_PATH .'blog.js', array('jquery'), '1',$in_footer = true);
			}
	  	   
		}
	}


	/*-----------------------------------------------------------------------------------*/
	/*  FUNCTION FOR INSTALL AND REGISTER THEME PLUGINS
	/*-----------------------------------------------------------------------------------*/
	function londres_register_required_plugins() {
	
		$plugins = array(
	
			array(
				'name'      => 'Contact Form 7',
				'slug'      => 'contact-form-7',
				'required'  => true,
			),
			array(
				'name'      => 'Widget Importer & Exporter',
				'slug'      => 'widget-importer-exporter',
				'required'  => false,
			),
			array(
				'name'      => 'Really Simple CAPTCHA',
				'slug'      => 'really-simple-captcha',
				'required'  => false,
			),
			array(
				'name'      => 'Classic Widgets',
				'slug'      => 'classic-widgets',
				'required'  => false,
			),
			array(
				'name'      => 'Classic Editor',
				'slug'      => 'classic-editor',
				'required'  => false,
			),
			array(
				'name'          => 'WPBakery Visual Composer',
				'slug'          => 'js_composer',
				'source'        => 'http://paulomoreira.org/plugins/londres/js_composer.zip',
				'required'      => true,
				'version'       => '6.7.0'
			),
			array(
				'name'      	=> 'Revolution Slider',
				'slug'     	 	=> 'revslider',
				'source'        => 'http://paulomoreira.org/plugins/londres/revslider.zip',
				'required'  	=> true,
				'version'       => '6.5.5'
			),
			array(
				'name'          => 'Ultimate Addons for Visual Composer',
				'slug'          => 'Ultimate_VC_Addons',
				'source'        => 'http://paulomoreira.org/plugins/londres/Ultimate_VC_Addons.zip',
				'required'      => true,
				'version'       => '3.19.11'
			),
			
			array(
				'name'      	=> 'Londres Custom Post Types',
				'slug'     	 	=> 'londres_custom_post_types',
				'source'        => 'http://paulomoreira.org/plugins/londres/londres_custom_post_types.zip',
				'required'  	=> true,
				'version'       => '2.6'
			),
			array(
				'name'          => 'Cube Portfolio',
				'slug'          => 'cubeportfolio',
				'source'        => 'http://paulomoreira.org/plugins/londres/cubeportfolio.zip',
				'required'      => true,
				'version'       => '4.4'
			),
			
			array(
				'name'      	=> 'Master Slider',
				'slug'     	 	=> 'masterslider',
				'source'        => 'http://paulomoreira.org/plugins/londres/masterslider.zip',
				'required'  	=> true,
				'version'       => '3.5.5'
			),
			
			array(
				'name'      	=> 'Envato Market',
				'slug'     	 	=> 'envato-market',
				'source'        => 'http://paulomoreira.org/plugins/londres/envato-market.zip',
				'required'  	=> true,
				'version'       => '2.0.6'
			)
				
				
		);
	
		// Change this to your theme text domain, used for internationalising strings
		$config = array(
			'domain'       		=> 'londres',         	// Text domain - likely want to be the same as your theme.
			'default_path' 		=> '',
			'parent_slug'  => 'themes.php',            			// Parent menu slug.
			'menu'         		=> 'install-required-plugins', 	// Menu slug
			'has_notices'      	=> true,                       	// Show admin notices or not
			'is_automatic'    	=> false,					   	// Automatically activate plugins after installation or not
			'message' 			=> '',							// Message to output right before the plugins table
			'strings'      		=> array(
				'page_title'                       			=> esc_html__( 'Install Required Plugins', 'londres' ),
				'menu_title'                       			=> esc_html__( 'Install Plugins', 'londres' ),
				'installing'                       			=> esc_html__( 'Installing Plugin: %s', 'londres' ), // %1$s = plugin name
				'oops'                             			=> esc_html__( 'Something went wrong with the plugin API.', 'londres' ),
				'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'londres' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'londres' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'londres' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'londres' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'londres' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'londres' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'londres' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'londres' ), // %1$s = plugin name(s)
				'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'londres' ),
				'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'londres' ),
				'return'                           			=> esc_html__( 'Return to Required Plugins Installer', 'londres' ),
				'plugin_activated'                 			=> esc_html__( 'Plugin activated successfully.', 'londres' ),
				'complete' 									=> esc_html__( 'All plugins installed and activated successfully. %s', 'londres' ), // %1$s = dashboard link
				'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
			)
		);
	
		tgmpa( $plugins, $config );
	
	}
	

	
	/*-----------------------------------------------------------------------------------*/
	/*  THEME REQUIRES
	/*-----------------------------------------------------------------------------------*/
 	if (file_exists(get_stylesheet_directory().'/inc/theme-intro.php')) require_once (get_stylesheet_directory().'/inc/theme-intro.php');
 	else require_once (get_template_directory().'/inc/theme-intro.php');
 	
 	if (file_exists(get_stylesheet_directory().'/inc/theme-header.php')) require_once (get_stylesheet_directory().'/inc/theme-header.php');
 	else require_once (get_template_directory().'/inc/theme-header.php');
 	
 	if (file_exists(get_stylesheet_directory().'/inc/theme-walker-menu.php')) require_once (get_stylesheet_directory().'/inc/theme-walker-menu.php');
 	else require_once (get_template_directory().'/inc/theme-walker-menu.php');
 	
 	if (file_exists(get_stylesheet_directory().'/inc/theme-homeslider.php')) require_once (get_stylesheet_directory().'/inc/theme-homeslider.php');
 	else require_once (get_template_directory().'/inc/theme-homeslider.php');
 	
 	if (file_exists(get_stylesheet_directory().'/inc/theme-breadcrumb.php')) require_once (get_stylesheet_directory().'/inc/theme-breadcrumb.php');
 	else require_once (get_template_directory().'/inc/theme-breadcrumb.php');
 	
 	if (file_exists(get_stylesheet_directory().'/inc/theme-menu.php')) require_once (get_stylesheet_directory().'/inc/theme-menu.php');
 	else require_once (get_template_directory().'/inc/theme-menu.php');
 	
 	if (file_exists(get_stylesheet_directory().'/inc/theme-woocart.php')) require_once (get_stylesheet_directory().'/inc/theme-woocart.php');
 	else require_once (get_template_directory().'/inc/theme-woocart.php');
 	
	
	/*-----------------------------------------------------------------------------------*/
	/*  FUNCTION FOR ONE CLICK FEATURE
	/*-----------------------------------------------------------------------------------*/
	function londres_autoimport($url, $demo) {
		
		$os = ((strpos(strtolower(PHP_OS), 'win') === 0) || (strpos(strtolower(PHP_OS), 'cygwin') !== false)) ? 'win' : 'other';
		if (!function_exists('WP_Filesystem')){
			$abspath = ($os === "win") ? "\wp-admin\includes\file.php" : "/wp-admin/includes/file.php";
			require_once(ABSPATH.$abspath);
		}
		WP_Filesystem();
		global $wpdb, $wp_filesystem;
		
	    // get the file
	    require_once get_template_directory() . '/lib/classes/upper-content-import.php';
	
	    if ( ! class_exists( 'londres_Auto_Importer' ) )
	        die( 'londres_Auto_Importer not found' );
	
	    // call the function
		$upload_dir = wp_upload_dir();
		$demo_file = $url.$demo."/contents.xml";
		$tempfile = $upload_dir['basedir'] . '/temp.xml' ;
		$data = $wp_filesystem->get_contents($demo_file);
		if (!$data) $data = wp_remote_fopen($demo_file);
		$result = $wp_filesystem->put_contents($tempfile, $data, FS_CHMOD_FILE);
		
		if ($result){
			$args = array(
	            'file'        => $tempfile,
	            'map_user_id' => 0
	        );
	        londres_auto_import( $args );
		}
	
	}


	/*-----------------------------------------------------------------------------------*/
	/*  HEX TO RGB
	/*-----------------------------------------------------------------------------------*/
	function londres_hex2rgb($hex = "000000") {
		if (is_array($hex)) $hex = "000000";
		$hex = str_replace("#", "", $hex);
		
		if(strlen($hex) == 3) {
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} else {
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}
		$rgb = array($r, $g, $b);
		//return implode(",", $rgb); // returns the rgb values separated by commas
		return $rgb; // returns an array with the rgb values
	}



	function londres_get_string_between($string, $start, $end){
	    $string = " ".$string;
	    $ini = strpos($string,$start);
	    if ($ini == 0) return "";
	    $ini += strlen($start);
	    $len = strpos($string,$end,$ini) - $ini;
	    return substr($string,$ini,$len);
	}
	
	/* Remove VC Modules */
	if (function_exists('vc_remove_element')){
		vc_remove_element('vc_carousel');
		vc_remove_element('vc_posts_slider');
		vc_remove_element('vc_gallery');
		vc_remove_element('vc_images_carousel');
		vc_remove_element('vc_button');
		vc_remove_element('vc_cta_button');
	}
	
	
	/*-----------------------------------------------------------------------------------*/
	/*  INCLUDE ADDONS IN LONDRES THEME
	/*-----------------------------------------------------------------------------------*/
	function londres_content_shortcoder($post_content, $loadglobally = false){
		
		$dependancy = array('jquery');
		global $vc_addons_url;

			
		if (isset($vc_addons_url) && $vc_addons_url != ""){
			
			$js_path = 'assets/min-js/';
			$css_path = 'assets/min-css/';
			$ext = '.min';
			$isAjax = true;
			$ultimate_smooth_scroll = get_option('ultimate_smooth_scroll');
	
			// register js
			wp_register_script('ultimate-script',$vc_addons_url.'assets/min-js/ultimate.min.js',array('jquery', 'jquery-ui-core' ), '3.19.11', false);
			wp_register_script('ultimate-appear',$vc_addons_url.$js_path.'jquery-appear'.$ext.'.js',array('jquery'), '3.19.11');
			wp_register_script('ultimate-custom',$vc_addons_url.$js_path.'custom'.$ext.'.js',array('jquery'), '3.19.11');
			wp_register_script('ultimate-vc-params',$vc_addons_url.$js_path.'ultimate-params'.$ext.'.js',array('jquery'), '3.19.11');
			if($ultimate_smooth_scroll === 'enable') {
				$smoothScroll = 'SmoothScroll-compatible.min.js';
			}
			else {
				$smoothScroll = 'SmoothScroll.min.js';
			}
			wp_register_script('ultimate-smooth-scroll',$vc_addons_url.'assets/min-js/'.$smoothScroll,array('jquery'),'3.19.11',true);
			wp_register_script("ultimate-modernizr",$vc_addons_url.$js_path.'modernizr-custom'.$ext.'.js',array('jquery'),'3.19.11');
			wp_register_script("ultimate-tooltip",$vc_addons_url.$js_path.'tooltip'.$ext.'.js',array('jquery'),'3.19.11');
	
			// register css
			wp_register_style('ultimate-animate',$vc_addons_url.$css_path.'animate'.$ext.'.css',array(),'3.19.11');
			wp_register_style('ultimate-style',$vc_addons_url.$css_path.'style'.$ext.'.css',array(),'3.19.11');
			wp_register_style('ultimate-style-min',$vc_addons_url.'assets/min-css/ultimate.min.css',array(),'3.19.11');
			wp_register_style('ultimate-tooltip',$vc_addons_url.$css_path.'tooltip'.$ext.'.css',array(),'3.19.11');
	
			$ultimate_smooth_scroll = get_option('ultimate_smooth_scroll');
			if($ultimate_smooth_scroll == "enable" || $ultimate_smooth_scroll === 'enable') {
				wp_enqueue_script('ultimate-smooth-scroll');
			}
	
			if(function_exists('vc_is_editor')){
				if(vc_is_editor()){
					wp_enqueue_style('vc-fronteditor',$vc_addons_url.'assets/min-css/vc-fronteditor.min.css');
				}
			}
	
			$ultimate_global_scripts = ($loadglobally) ? 'enable' : bsf_get_option('ultimate_global_scripts');

			if($ultimate_global_scripts === 'enable') {
				
				wp_enqueue_script('ultimate-modernizr');
				wp_enqueue_script('jquery_ui');
				wp_enqueue_script('masonry');
				if(defined('DISABLE_ULTIMATE_GOOGLE_MAP_API') && (DISABLE_ULTIMATE_GOOGLE_MAP_API == true || DISABLE_ULTIMATE_GOOGLE_MAP_API == 'true'))
					$load_map_api = false;
				else
					$load_map_api = true;
				if($load_map_api)
					wp_enqueue_script('googleapis');
				wp_enqueue_script('ultimate-script');
				wp_enqueue_script('ultimate-modal-all');
				wp_enqueue_script('jquery.shake',$vc_addons_url.$js_path.'jparallax'.$ext.'.js');
				wp_enqueue_script('jquery.vhparallax',$vc_addons_url.$js_path.'vhparallax'.$ext.'.js');
	
				wp_enqueue_style('ultimate-style-min');
				wp_enqueue_style("ult-icons");
				wp_enqueue_style('ultimate-vidcons',$vc_addons_url.'assets/fonts/vidcons.css');
				wp_enqueue_script('jquery.ytplayer',$vc_addons_url.$js_path.'mb-YTPlayer'.$ext.'.js');
	
				$Ultimate_Google_Font_Manager = new Ultimate_Google_Font_Manager;
				$Ultimate_Google_Font_Manager->enqueue_selected_ultimate_google_fonts();
	
				return false;
			}
	
			if(!is_404() && !is_search()){
	
				if(stripos($post_content, 'font_call:'))
				{
					preg_match_all('/font_call:(.*?)"/',$post_content, $display);
					if (function_exists('enquque_ultimate_google_fonts_optimzed')) enquque_ultimate_google_fonts_optimzed($display[1]);
				}
				
				if( stripos( $post_content, '[swatch_container') || 
				    stripos( $post_content, '[ultimate_modal'))
				{
					wp_enqueue_script('ultimate-modernizr');
				}

				if( stripos( $post_content, '[ultimate_exp_section') ||
					stripos( $post_content, '[info_circle') ) {
					wp_enqueue_script('jquery_ui');
				}

				if( stripos( $post_content, '[icon_timeline') ) {
					wp_enqueue_script('masonry');
				}

				if($isAjax == true) { // if ajax site load all js
					wp_enqueue_script('masonry');
				}

				if( stripos( $post_content, '[ultimate_google_map') ) {
					if(defined('DISABLE_ULTIMATE_GOOGLE_MAP_API') && (DISABLE_ULTIMATE_GOOGLE_MAP_API == true || DISABLE_ULTIMATE_GOOGLE_MAP_API == 'true'))
						$load_map_api = false;
					else
						$load_map_api = true;
					if($load_map_api)
						wp_enqueue_script('googleapis');
				}

				if( stripos( $post_content, '[ult_range_slider') ) {
					wp_enqueue_script('jquery-ui-mouse');
					wp_enqueue_script('jquery-ui-widget');
					wp_enqueue_script('jquery-ui-slider');
					wp_enqueue_script('ult_range_tick');
					wp_enqueue_script('ult_ui_touch_punch');
				}

				wp_enqueue_script('ultimate-script');

				if( stripos( $post_content, '[ultimate_modal') ) {
					wp_enqueue_script('ultimate-modal-all');
				}
				
				$ultimate_css = "enable";
	
				if ($ultimate_css == "enable"){
					wp_enqueue_style('ultimate-style-min');
					if( stripos( $post_content, '[ultimate_carousel') ) {
						wp_enqueue_style("ult-icons");
					}
				} 
				
				wp_enqueue_script( 'ultimate-row-bg', $vc_addons_url.$js_path . 'ultimate_bg' . $ext . '.js' );
			}
		}
	}	

	/*-----------------------------------------------------------------------------------*/
	/*  REQUIRED FOR WOOCOMMERCE CART
	/*-----------------------------------------------------------------------------------*/
	require_once (get_template_directory().'/inc/theme-woocart.php');
	
	
	function londres_allowed_tags() {
		global $allowedtags, $allowedposttags;
		$allowedtags['option'] = array('style'=>array(), 'id'=>array(), 'name'=>array(), 'class'=>array(), 'value'=>array(), 'selected'=>array());
		$allowedtags['input'] = array('style'=>array(), 'id'=>array(), 'name'=>array(), 'class'=>array(), 'value'=>array(), 'selected'=>array(), 'type'=>array(), 'onchange'=>array(), 'placeholder'=>array());
		$allowedtags['label'] = array('for'=>array());
		$allowedtags['iframe'] = array('style'=>array(), 'src'=>array(), 'allowfullscreen'=>array());
		$allowedposttags['div']['aria-hidden'] = array();
		$allowedposttags['div']['style'] = array();
		$allowedtags = array_merge($allowedtags, $allowedposttags);
	}
	add_action('init', 'londres_allowed_tags', 10);

	function londres_get_the_woo(){
		global $woocommerce;
		return isset($woocommerce) ? $woocommerce : array(); 
	}

	/*-----------------------------------------------------------------------------------*/
	/*  LOAD GOOGLE FONTS
	/*-----------------------------------------------------------------------------------*/
	function londres_fonts_url() {
		global $londres_import_fonts;
		
		$londres_import_fonts = londres_get_import_fonts();
		if (!is_array($londres_import_fonts) && is_string($londres_import_fonts)) $londres_import_fonts = explode("|",$londres_import_fonts);
		
		$aux = array();
		foreach ($londres_import_fonts as $font){
			$aux[] = str_replace("|", ":", str_replace(" ", "+", $font));
		}
		
		$aux = array_unique($aux);
		
		$http = (is_ssl( )) ? "https:" : "http:";
		
		$keys = array("Arial","Arial+Black","Helvetica+Neue","Helvetica","Courier+New","Georgia","Impact","Lucida+Sans","Times+New+Roman","Trebuchet+MS","Verdana");
		
		foreach ($keys as $key){
			if (($key_search = array_search($key, $aux)) !== false) {
			    unset($aux[$key_search]);
			}
		}
		
		$londres_import_fonts = implode("|", $aux);
	    $font_url = '';
	    /*
	    Translators: If there are characters in your language that are not supported
	    by chosen font(s), translate this to 'off'. Do not translate into your own language.
	     */
	    if ( 'off' !== _x( 'on', 'Google font: on or off', 'londres' ) ) {
	        $font_url = add_query_arg( 'family', $londres_import_fonts, $http."//fonts.googleapis.com/css", array(), null, 'all' );
	    }
	    return $font_url;
	}
	
	function londres_google_fonts_scripts() {
	    wp_enqueue_style( 'londres-google-fonts', londres_fonts_url(), '' );
	}
	
	function londres_get_custom_inline_css(){
		global $londres_inline_css;
		wp_enqueue_style('londres-custom-style', LONDRES_CSS_PATH .'londres-custom.css',99);
		if (!$londres_inline_css) $londres_inline_css = "";
		$londres_inline_css .= "body{visibility:visible;}";
		wp_add_inline_style('londres-custom-style', $londres_inline_css);
	}
	
	function londres_set_custom_inline_css($css){
		global $londres_inline_css;
		$upper_theme_main_color = "#".get_option('londres_style_color');
		$londres_inline_css .= str_replace( '__USE_THEME_MAIN_COLOR__', $upper_theme_main_color, $css );
	}
	
	function londres_set_team_profiles_content($content){
		global $londres_team_profiles;
		if (!isset($londres_team_profiles)) $londres_team_profiles = '';
		$londres_team_profiles .= $content;
	}
	
	function londres_get_team_profiles_content(){
		global $londres_team_profiles;
		if (isset($londres_team_profiles)){
			$londres_team_profiles = wp_kses_no_null( $londres_team_profiles, array( 'slash_zero' => 'keep' ) );
			$londres_team_profiles = wp_kses_normalize_entities($londres_team_profiles);
			echo wp_kses_hook($londres_team_profiles, 'post', array());
		}
	}
	
	if (!function_exists('upper_images_only')){
		function upper_images_only( $media_item ) {
			if ( $media_item['type'] == 'image' )
				return true;
			return false;
		}
	}
	
	// ajax workers
	//front
	if (get_option('londres_enable_search')=="on" && get_option('londres_enable_ajax_search')=="on"){
		include_once get_template_directory() . '/ajaxsearch.php';
	}
	include_once get_template_directory() . '/js/twitter/index.php';
	//back
	if ( is_admin() && current_user_can( 'manage_options' ) ) {
		require_once get_template_directory() . '/lib/script/loadSettings.php';
		require_once get_template_directory() . '/lib/functions/londres_demo_installer.php';
		require_once get_template_directory() . '/lib/utils/upload-handler.php';
		require_once get_template_directory() . '/lib/functions/queryprojectsforcube.php';
		$londres_imported_ids = get_option('londres_imported_ids');
		if (!$londres_imported_ids){
			$londres_imported_ids = array();
			update_option('londres_imported_ids', $londres_imported_ids);
		}
		$londres_imported_ids;
	}

	if (!function_exists('londres_get_imported_ids')){
		function londres_get_imported_ids(){
			global $londres_imported_ids;
			return $londres_imported_ids;
		}
	}

	if (!function_exists('londres_set_imported_ids')){
		function londres_set_imported_ids($ids){
			global $londres_imported_ids;
			$londres_imported_ids = $ids;
			update_option('londres_imported_ids', $londres_imported_ids);
		}
	}

	if (!function_exists('londres_add_imported_id')){
		function londres_add_imported_id( $id, $revs = false ){
			$aux = get_option('londres_imported_ids');
			$output = "";
			if ($revs){
				if ( !array_search( $id, $aux ) ){
					array_push( $aux, $id );
					londres_set_imported_ids($aux);
					return true;
				} else {
					return false;
				}
			} else {
				if ( !array_search( intval($id), $aux ) ){
					array_push( $aux, (int)$id );
					londres_set_imported_ids($aux);
					return true;
				} else {
					return false;
				}
			}
		}
	}