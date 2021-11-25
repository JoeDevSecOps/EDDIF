<?php
/**
 * This file contain some general functions:
 * -enqueuing CSS and JS files
 * -inserting the JavaScript init code into the head
 * -set the default thumbnail size
 * -print pagination function
 * -register navigation menus function
 *
 */


/**
 * ADD THE ACTIONS
 */
add_action('admin_enqueue_scripts', 'londres_admin_init');
add_action('admin_head', 'londres_admin_head_add');
add_action('init', 'londres_menus' );
add_action('admin_menu', 'londres_add_theme_menu');
add_filter('nav_menu_css_class' , 'londres_special_nav_class' , 10 , 2);

add_theme_support('automatic-feed-links');


/**
 * Enqueues the JavaScript files needed depending on the current section.
 */
function londres_admin_init(){
	global $current_screen, $londres_data, $wp_version, $londres_met, $londres_import_fonts, $post;
	
	wp_enqueue_media();
	wp_enqueue_script( 'gallery' );
	
	wp_register_script('londres-page-options',LONDRES_SCRIPT_URL.'page-options.js', array('jquery'));
	$_wpb_vc_js_status = isset($_GET['post']) ? get_post_meta( $_GET['post'], '_wpb_vc_js_status', true ) : false;
	if ($_wpb_vc_js_status == "false") $_wpb_vc_js_status = false;
	$isGuten = ( ( defined('GUTENBERG_VERSION') || intval($wp_version) > 4 ) && !isset($_GET['classic-editor']) && !$_wpb_vc_js_status ) ? true : false;
	wp_localize_script( 'londres-page-options', "isGuten", array($isGuten) );
	
	wp_register_script('londres-options',LONDRES_SCRIPT_URL.'options.js', array('jquery'));
	$londres_met = array('max_execution_time' => ini_get('max_execution_time'));
	wp_localize_script( 'londres-options', 'max_execution_time', $londres_met );
	
	if($current_screen->base=='post'){
		//enqueue the script and CSS files for the TinyMCE editor formatting buttons
		wp_enqueue_script('jquery-ui-dialog', array('jquery'));
		wp_enqueue_script('londres-page-options');
		wp_enqueue_script('londres-colorpicker',LONDRES_SCRIPT_URL.'colorpicker.js', array('jquery'));

		//set the style files
		add_editor_style('lib/formatting-buttons/custom-editor-style.css');
		wp_enqueue_style('londres-page-style',LONDRES_CSS_URL.'page_style.css');
		wp_enqueue_style('londres-colorpicker-style',LONDRES_CSS_URL.'colorpicker.css');
		wp_enqueue_script('londres-ajaxupload',LONDRES_SCRIPT_URL.'ajaxupload.js', array('jquery'));
		wp_enqueue_script('londres-options');
		wp_enqueue_script('londres-options-des',LONDRES_SCRIPT_URL.'options_upper.js', array('jquery'));
		
		if ($isGuten && isset($post->ID)){
			$londres_styleColor = "#".get_option("londres_style_color");
			if ("#".get_option("londres_style_color") != $londres_styleColor) $londres_styleColor = "#".get_option("londres_style_color");
			$londres_color_code = substr($londres_styleColor,1);
			
			if (get_post_meta($post->ID, "londres_enable_custom_pagetitle_options_value", true) == "no" || !get_post_meta($post->ID, "londres_enable_custom_pagetitle_options_value", true)){
				$tcolor = get_option("londres_header_text_color");
				$tsize = intval(str_replace(" ", "", get_option("londres_header_text_size")),10)."px";
				$tfont = get_option("londres_header_text_font");
				$type = get_option("londres_header_type");
				$originalalign = get_option("londres_header_text_alignment");
				$thecolor = londres_hex2rgb(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_header_color"))); 
				$opacity = intval(str_replace("%","",get_option("londres_header_opacity")))/100;
				$color = "rgba(".$thecolor[0].",".$thecolor[1].",".$thecolor[2].",".$opacity.")";
				$image = get_option("londres_header_image"); 
				$pattern = LONDRES_PATTERNS_URL.get_option("londres_header_pattern"); 
				$custompattern = get_option("londres_header_custom_pattern");
				$pagetitlepadding = get_option('londres_page_title_padding');
				$pt_overlay = get_option("londres_pagetitle_image_overlay") == "on" ? true : false;
				$pt_overlay_type = get_option("londres_pagetitle_overlay_type");
				$pt_overlay_the_color = londres_hex2rgb(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_pagetitle_overlay_color")));
				$pt_overlay_pattern = (is_string(get_option("londres_pagetitle_overlay_pattern"))) ? LONDRES_PATTERNS_URL.get_option("londres_pagetitle_overlay_pattern") : "";
				$pt_overlay_opacity = intval(str_replace("%","",get_option("londres_pagetitle_overlay_opacity")))/100;
				$pt_overlay_color = "rgba(".$pt_overlay_the_color[0].",".$pt_overlay_the_color[1].",".$pt_overlay_the_color[2].",".$pt_overlay_opacity.")";
			} else {
				$tcolor = get_post_meta($post->ID, "londres_header_text_color_value", true);
				$tsize = intval(str_replace(" ", "", get_post_meta($post->ID, "londres_header_text_size_value", true)),10)."px";
				$tfont = get_post_meta($post->ID, "londres_header_text_font_value", true);
				$type = get_post_meta($post->ID, "londres_header_type_value", true);
				$originalalign = get_post_meta($post->ID, "londres_header_text_alignment_value", true);
				$thecolor = londres_hex2rgb(get_post_meta($post->ID, "londres_header_color_value", true)); 
				$opacity = intval(str_replace("%","",get_post_meta($post->ID, "londres_header_color_opacity_value", true)))/100;
				$color = "rgba(".$thecolor[0].",".$thecolor[1].",".$thecolor[2].",".$opacity.")";
				$image = get_post_meta($post->ID, "londres_header_image_value", true);
				$image = explode('|!|',$image);
				if (isset($image[1])) $image = explode('|*|',$image[1]);
				$image = $image[0];
				$pattern = LONDRES_PATTERNS_URL.get_post_meta($post->ID, "londres_header_pattern_value", true).".jpg";
				$custompattern = get_option("londres_header_custom_pattern_value"); 
				$pagetitlepadding = intval(str_replace(" ", "", get_post_meta($post->ID, "londres_page_title_padding_value", true)),10)."px";
				$pt_overlay = get_post_meta($post->ID, "londres_pagetitle_image_overlay_value", true) == "on" ? true : false;
				$pt_overlay_type = get_post_meta($post->ID, "londres_pagetitle_overlay_type_value", true);
				$pt_overlay_the_color = londres_hex2rgb(get_post_meta($post->ID, "londres_pagetitle_overlay_color_value", true));
				$pt_overlay_pattern = LONDRES_PATTERNS_URL.get_post_meta($post->ID, "londres_pagetitle_overlay_pattern_value", true).".jpg";
				$pt_overlay_opacity = intval(str_replace("%","",get_post_meta($post->ID, "londres_pagetitle_overlay_opacity_value", true)))/100;
				$pt_overlay_color = "rgba(".$pt_overlay_the_color[0].",".$pt_overlay_the_color[1].",".$pt_overlay_the_color[2].",".$pt_overlay_opacity.")";
			}
			$londres_import_fonts[] = $tfont; $tfont = explode("|",$tfont); $tfont[0] = $tfont[0]."', 'Arial', 'sans-serif"; if (!isset($tfont[1])) $tfont[1] = "" ;
			$textalign = $originalalign;
			if ($originalalign == "titlesleftcrumbsright") $textalign = "left";
			if ($originalalign == "titlesrightcrumbsleft") $textalign = "right";
			
			
			
			$londres_style_data = "
				
				.editor-block-list__layout * { -webkit-font-smoothing: antialiased; }
				
				.editor-post-title { padding: 0; }
				
				.editor-post-title__block {";
					if ($type == "none") $londres_style_data .= "background: none;"; 
					if ($type == "color") $londres_style_data .= "background: " . esc_html($color) . ";";
					if ($type == "image") $londres_style_data .= "background: url(" . esc_url($image) . ") no-repeat; background-size: 100% auto;";  
		 			if ($type == "pattern") $londres_style_data .= "background: url('" . esc_url($pattern) . "') 0 0 repeat;";
					$londres_style_data .= "
					padding: ".esc_html($pagetitlepadding)." 15px;
					max-width: none !important;
				}";
				
			if ($pt_overlay){
				$londres_style_data .= "
				.editor-post-title__block::before {
					content: '';
					position: absolute;
					top: 0;
					right: 0;
					bottom: 0;
					left: 0;
					pointer-events: none;
					background: ". ($pt_overlay_type == "color" ? esc_html($pt_overlay_color) : esc_html( 'url('. $pt_overlay_pattern .') repeat; opacity: '. $pt_overlay_opacity )) . ";
				}";
			}
				
			$londres_style_data .= "
				.editor-post-title__block textarea {
					font-family: '".wp_kses_post($tfont[0])."' ,sans-serif !important;
					font-weight: ".esc_html( $tfont[1] != "" ? $tfont[1] : 300 )."  !important;
					font-size: ".esc_html(intval($tsize))."px  !important;
					text-align: ".esc_html($textalign).";
					color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, $tcolor))." !important;";
					$londres_style_data .= "
						margin-bottom: 0;
						line-height: 1.3em;
						text-transform: uppercase;
						font-weight: 300;
						letter-spacing: 10px;
						-moz-transform: translateZ(1px); -webkit-transform: translateZ(1px); transform: translateZ(1px);
				}
				
				.editor-block-list__layout p, .editor-block-list__layout span, .editor-block-list__layout ul, .editor-block-list__layout ol, .editor-block-list__layout li, .editor-block-list__layout .wp-block-button__link, .editor-block-list__layout .wp-block-table__cell-content, .editor-block-list__layout figcaption { ";
					$font = get_option('londres_p_font'); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "" ;
					$londres_style_data .= "
					font-family: '".wp_kses_post($font[0])."' ,sans-serif;
					font-weight: ".esc_html($font[1]).";
					font-size: ".esc_html(intval(get_option('londres_p_size'), 10))."px !important;
					color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_p_color"))).";
				}
				
				.editor-block-list__layout p.wp-block-cover-text{ font-size: 2em !important; }
				
				.editor-block-list__layout ul, .editor-block-list__layout ol { 
					margin: 0 !important; padding: 0 !important; 
				}
				
				.editor-block-list__layout ul, .editor-block-list__layout li {
					list-style: disc;
					padding-left: 0 !important;
					line-height: 1.5em;
				}
				
				.editor-block-list__layout ul.wp-block-categories__list{ text-align: left; }
				
				.editor-block-list__layout ul li {
					margin-left: 20px;
					margin-top: .8em;
					margin-bottom: .8em;
					width: auto;
				}
				
				.editor-block-list__layout ol li {
					line-height: 1.5em;
					margin-left: 20px;
					list-style-type: decimal;
					margin-top: 1%;
				}
				
				.editor-block-list__layout .is-grid li{ list-style: none; }
				
				.editor-block-list__layout a { ";
					$font = get_option('londres_links_font'); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "" ;
					$londres_style_data .= "
					font-family: '".wp_kses_post($font[0])."' ,sans-serif;
					font-weight: ".esc_html($font[1]).";
					font-size: ".esc_html(intval(get_option('londres_links_size'), 10))."px;
					color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_links_color"))).";
					text-decoration: none;
				}
				
				.editor-block-list__layout a:hover, .editor-block-list__layout div.wp-block-button__link:hover{
					color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_links_color_hover"))).";
				}
				
				.editor-block-list__layout pre {
					background: #f2f2f2;
					padding: 10px;
					border: 1px solid #ededed;
					font-family: Menlo, Monaco, Consolas, 'Courier New', monospace;
					font-size: 14px !important;
				}
				
				.editor-block-list__layout blockquote {
					border: none !important;
					padding: 0 !important;
				}
				
				.editor-block-list__layout .wp-block-pullquote{ border:none !important; }
				
				.editor-block-list__layout blockquote > div{ margin-left: 40px; }
				
				.editor-block-list__layout blockquote > div:first-child {
					background: #f7f7f7;
					border-left: 3px solid #a9a7a7 !important;
					margin: 60px 40px 0px 40px !important;
				}
				.editor-block-list__layout blockquote p {
					color: #a9a7a7 !important;
					margin: 20px 0px !important;
					font-size: 1.05em !important;
					font-family: Roboto Slab, Georgia;
					padding: 40px 40px 40px 30px !important;
					font-style: italic;
					line-height: 1.6;
				}
				.editor-block-list__layout blockquote .editor-rich-text, .editor-block-list__layout blockquote .wp-block-quote__citation, .editor-block-list__layout .wp-block-pullquote__citation{
					font-family: Roboto Slab, Georgia;
					font-size: 1.05em !important;
					color: #a9a7a7 !important;
				}
				
				.editor-block-list__layout .wp-block-audio figcaption {
					margin-top: -.5em !important;
					margin-bottom: 1em !important;
					color: #555d66 !important;
					text-align: center !important;
					font-size: 13px !important;
				}
				
				.editor-block-list__layout hr:not(.is-style-dots) {
					border: 1px solid #f2f2f2 !important;
					height: 0 !important;
					margin-top: 20px !important;
					margin-bottom: 20px !important;
					max-width: none !important;
					width: 100%;
				}
				
				.editor-block-list__layout table {
					border-collapse: collapse;
					border-spacing: 0;
				}

				.editor-block-list__layout table thead th {
					background: #f2f2f2;
					font-weight: 700;
				}

				.editor-block-list__layout table td,table th {
					padding: 5px 14px;
					border: 1px solid #ddd !important;
					text-align: left;
				}

				.editor-block-list__layout table tbody tr:nth-child(even) {
					background: #f5f5f5;
				}

				.editor-block-list__layout tbody tr:last-child {
					border-bottom: 1px solid #ddd;
					border-right: 1px solid #ddd;
				}
				
				.editor-block-list__layout h1{";
					$font = get_option('londres_h1_font'); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
					$londres_style_data .= "
					font-family: '".wp_kses_post($font[0])."';
					font-weight: ".esc_html($font[1]).";
					font-size: ".esc_html(intval(get_option('londres_h1_size'), 10))."px;
					color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_h1_color"))).";
				}
	
				.editor-block-list__layout h2{";
					$font = get_option('londres_h2_font'); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
					$londres_style_data .= "
					font-family: '".wp_kses_post($font[0])."';
					font-weight: ".esc_html($font[1]).";
					font-size: ".esc_html(intval(get_option('londres_h2_size'), 10))."px;
					color: #".esc_html(get_option('londres_h2_color')).";
				}
	
				.editor-block-list__layout h3{";
					$font = get_option('londres_h3_font'); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
					$londres_style_data .= "
					font-family: '".wp_kses_post($font[0])."';
					font-weight: ".esc_html($font[1]).";
					font-size: ".esc_html(intval(get_option('londres_h3_size'), 10))."px;
					color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_h3_color"))).";
				}
	
				.editor-block-list__layout h4{";
					$font = get_option('londres_h4_font'); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
					$londres_style_data .= "
					font-family: '".wp_kses_post($font[0])."';
					font-weight: ".esc_html($font[1]).";
					font-size: ".esc_html(intval(get_option('londres_h4_size'), 10))."px;
					color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_h4_color"))).";
				}
				
				.editor-block-list__layout h5{";
					$font = get_option('londres_h5_font'); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
					$londres_style_data .= "
					font-family: '".wp_kses_post($font[0])."';
					font-weight: ".esc_html($font[1]).";
					font-size: ".esc_html(intval(get_option('londres_h5_size'), 10))."px;
					color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_h5_color"))).";
				}
	
				.editor-block-list__layout h6{";
					$font = get_option('londres_h6_font'); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
					$londres_style_data .= "
					font-family: '".wp_kses_post($font[0])."';
					font-weight: ".esc_html($font[1]).";
					font-size: ".esc_html(intval(get_option('londres_h6_size'), 10))."px;
					color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_h6_color"))).";
				}
				
				.wp-block {
				  max-width: 1200px;
				}
				
				.wp-block-pullquote cite, .wp-block-pullquote footer, .wp-block-pullquote__citation{ text-transform: none; }
			";
			
			wp_add_inline_style('londres-page-style', $londres_style_data);
		}
	}

	if(isset($_GET['page']) && ( $_GET['page']==LONDRES_OPTIONS_PAGE || $_GET['page']==LONDRES_STYLE_OPTIONS_PAGE || $_GET['page']==LONDRES_DEMOS_PAGE)){
		//enqueue the scripts for the Options page
		wp_enqueue_script('jquery-ui-sortable', array('jquery'));
		wp_enqueue_script('jquery-ui-dialog', array('jquery'));
		wp_enqueue_script('londres-jquery-co',LONDRES_SCRIPT_URL.'jquery-co.js', array('jquery'));
		wp_enqueue_script('londres-ajaxupload',LONDRES_SCRIPT_URL.'ajaxupload.js', array('jquery'));
		wp_enqueue_script('londres-colorpicker',LONDRES_SCRIPT_URL.'colorpicker.js', array('jquery'));
		wp_enqueue_script('londres-options');
		wp_enqueue_script('londres-options-des',LONDRES_SCRIPT_URL.'options_upper.js', array('jquery'));
		wp_enqueue_script('londres-jquery-ui',LONDRES_SCRIPT_URL.'jquery-ui-1.8.17.custom.min.js', array('jquery'));

		//enqueue the styles for the Options page
		wp_enqueue_style('londres-admin-style',LONDRES_CSS_URL.'admin_style.css');
		wp_enqueue_style('londres-colorpicker-style',LONDRES_CSS_URL.'colorpicker.css');
		wp_enqueue_style('londres-jqueryui-style',LONDRES_CSS_URL.'cupertino/jquery-ui-1.8.17.custom.css');
		
		echo "<div hidden class='londres_fixed_menu hidden'>".esc_html(get_option('londres_fixed_menu'))."</div>";
		echo "<div hidden class='londres_header_after_scroll hidden'>".esc_html(get_option('londres_header_after_scroll'))."</div>";
		echo "<div hidden class='londres_header_shrink_effect hidden'>".esc_html(get_option('londres_header_shrink_effect'))."</div>";

		if (get_option("londres_show_sec_footer") == "on"){
			if (get_option("londres_footer_display_logo") == "on"){
				echo "<div hidden class='londres_footer_logo_type hidden'>".esc_html(get_option('londres_footer_logo_type'))."</div>";	
			}
			if (get_option("londres_footer_display_social_icons") == "on"){
				echo "<div hidden class='londres_footer_display_social_icons hidden'>".get_option('londres_footer_display_social_icons')."</div>";	
			}
		}
	}

	if(defined('LONDRES_PORTFOLIO_POST_TYPE') && $current_screen->id==LONDRES_PORTFOLIO_POST_TYPE){
		//enqueue the scripts needed for the add/edit portfolio post
		wp_enqueue_script('londres-ajaxupload',LONDRES_SCRIPT_URL.'ajaxupload.js', array('jquery'));
		wp_enqueue_script('londres-options');
		wp_enqueue_media();
		wp_enqueue_script( 'custom-header' );
	}

	if($current_screen->id=='page'){
		//enqueue the scripts needed for the add/edit page page
		wp_enqueue_script('londres-page-options');
		wp_enqueue_script('londres-options');
		wp_enqueue_script('londres-ajaxupload',LONDRES_SCRIPT_URL.'ajaxupload.js', array('jquery'));
	}

	if(isset($_GET['page']) && defined('LONDRES_PORTFOLIO_POST_TYPE') && $_GET['page']==LONDRES_PORTFOLIO_POST_TYPE){
		//wp_enqueue_script('jquery-ui-core', array('jquery'));
		wp_enqueue_script('jquery-ui-widget', array('jquery'));
		wp_enqueue_script('jquery-ui-sortable', array('jquery'));
		wp_enqueue_script('jquery-ui-dialog', array('jquery'));
		wp_enqueue_script('londres-ajaxupload',LONDRES_SCRIPT_URL.'ajaxupload.js', array('jquery'));
		wp_enqueue_script('londres-options');
		wp_enqueue_script('londres-custom-page',LONDRES_SCRIPT_URL.'custom-page.js', array('jquery'));
		//enqueue the styles for the Options page
		wp_enqueue_style('londres-admin-style',LONDRES_CSS_URL.'custom_page.css');
		wp_enqueue_style('jquery-ui-dialog');
	}

}

global $pagenow;
if (is_admin() && isset($_GET['activated']) && $pagenow == "themes.php" ) {
    //Do redirect
    header( 'Location: '.esc_url(admin_url()).'admin.php?page='.LONDRES_DEMOS_PAGE.'&activated=true' ) ;
}


/**
 * Inserts scripts for initializing the JavaScript functionality for the relevant section.
 */
function londres_admin_head_add(){

	if(isset($_GET['page']) && $_GET['page']==LONDRES_OPTIONS_PAGE){
		//init the options js functionality
		$londres_admin_inline_script = (isset($londres_admin_inline_script)) ? $londres_admin_inline_script : "";
		$londres_admin_inline_script .= '
			jQuery(document).ready(function(){
				"use strict";
				jQuery(".slider").each(function(){
					var value = parseInt(jQuery(this).siblings(".slider-input").val());
					jQuery(this).empty().slider({
						range: "min",
						value: value,
						min: 0,
						max: 100,
						slide: function( event, ui ) {
							jQuery( "#"+jQuery(this).attr("title") ).val( ui.value + " px" );
						}
					});
				});
				londresOptions.init({cookie:true});
			});
		';
		wp_add_inline_script('londres-admin', $londres_admin_inline_script, 'after');
	}
	
	if(isset($_GET['page']) && $_GET['page']==LONDRES_STYLE_OPTIONS_PAGE){
		//init the options js functionality
		
		$londres_admin_inline_script = (isset($londres_admin_inline_script)) ? $londres_admin_inline_script : "";
		$londres_admin_inline_script .= '
			jQuery(document).ready(function(){
				"use strict";
				jQuery(".slider").each(function(){
					var value = parseInt(jQuery(this).siblings(".slider-input").val());
					jQuery(this).empty().slider({
						range: "min",
						value: value,
						min: 0,
						max: 100,
						slide: function( event, ui ) {
							if (jQuery(this).hasClass("opacity-slider")){
								jQuery( "#"+jQuery(this).attr("title") ).val( ui.value + "%" );
							} else {
								jQuery( "#"+jQuery(this).attr("title") ).val( ui.value + " px" );	
							}
						}
					});
				});
				londres_StyleOptionsManager.init({cookie:true});
			});
		';
		if (isset($_GET['dgtt'])){
			$londres_admin_inline_script .= '
				jQuery(window).on("load", function(){
					jQuery("a[href=\'#tab_navigation-1-'.esc_js(esc_html($_GET['dgtt'])).'\']").trigger("click");
				});
			';
		}
		wp_add_inline_script('londres-admin', $londres_admin_inline_script, 'after');
	}
}

/**
 * Add the main setting menu for the theme.
 */
function londres_add_theme_menu(){
	add_theme_page( "Londres", "Londres Options", 'delete_pages', LONDRES_OPTIONS_PAGE, 'londres_theme_admin', null);
	add_theme_page( "Londres", "Londres Style Options", 'delete_pages', LONDRES_STYLE_OPTIONS_PAGE, 'londres_theme_style_options_admin', null);
	add_theme_page( "Londres", "Londres Demos", 'delete_pages', LONDRES_DEMOS_PAGE, 'londres_theme_demos_admin', null);
}

/* ------------------------------------------------------------------------*
 * LOCALE AND TRANSLATION
 * ------------------------------------------------------------------------*/

load_theme_textdomain( 'londres', get_template_directory() . '/lang' );

/**
 * Returns a text depending on the settings set. By default the theme gets uses
 * the texts set in the Translation section of the Options page. If multiple languages enabled,
 * the default language texts are used from the Translation section and the additional language
 * texts are used from the added .mo files within the lang folder.
 * @param $textid the ID of the text
 */
function londres_text($textid){

	$locale=get_locale();
	$int_enabled=get_option("londres_enable_translation")=='on'?true:false;
	$default_locale=get_option("londres_def_locale");

	if($int_enabled && $locale!=$default_locale){
		//use translation - extract the text from a defined .mo file
		return $textid;
	}else{
		//use the default text settings
		return stripslashes(get_option("londres".$textid));
	}
}

/**
 * Register the main menu for the theme.
 */
function londres_menus() {
	register_nav_menu('PrimaryNavigation', 'Main Navigation');
	register_nav_menu('woonav', 'WooCommerce Menu');
	register_nav_menu('topbarnav', 'Top Bar Navigation');
}

function londres_special_nav_class($classes, $item){
    $classes[] = $item->object . "-" . $item->object_id;
    return $classes;
}

/**
 * Removes an item from an array by specifying its value
 * @param $array the array from witch to remove the item
 * @param $val the value to be removed
 * @return returns the initial array without the removed item
 */
function londres_remove_item_by_value($array, $val = '') {
	if (empty($array) || !is_array($array)) return false;
	if (!in_array($val, $array)) return $array;

	foreach($array as $key => $value) {
		if ($value == $val) unset($array[$key]);
	}

	return array_values($array);
}

