<?php
/**
 * This file contains all the functionality for the additional meta boxes for the pages and posts.
 * It contains functions for loading the meta data into arrays, displaying the meta boxes and
 * saving the meta data.
 *
 */

/**
 * ADD THE ACTIONS
 */
add_action('admin_menu', 'londres_load_meta_boxes');
add_action('admin_menu', 'londres_create_meta_box');  
add_action('admin_menu', 'londres_create_meta_post_box');  
add_action('admin_menu', 'londres_create_meta_portfolio_box'); 
add_action('admin_menu', 'londres_create_meta_testimonials_box');  
add_action('admin_menu', 'londres_create_meta_partners_box');
add_action('admin_menu', 'londres_create_meta_team_box');
add_action('save_post', 'londres_save_postdata');  
add_action('save_post', 'londres_save_post_postdata');  
add_action('save_post', 'londres_save_portfolio_postdata'); 
add_action('save_post', 'londres_save_testimonials_postdata');
add_action('save_post', 'londres_save_partners_postdata');
add_action('save_post', 'londres_save_team_postdata');
add_action('admin_footer','londres_print_helper');

if (!defined('LONDRES_PORTFOLIO_POST_TYPE')){
	$portfolio_permalink = get_option("londres_portfolio_permalink");
	if (!get_option("londres_portfolio_permalink")) define("LONDRES_PORTFOLIO_POST_TYPE", "portfolio");
	else define("LONDRES_PORTFOLIO_POST_TYPE", get_option("londres_portfolio_permalink"));
}
if (!defined('LONDRES_TESTIMONIALS_POST_TYPE')){
	define("LONDRES_TESTIMONIALS_POST_TYPE", 'testimonials');
}
if (!defined('LONDRES_PARTNERS_POST_TYPE')){
	define("LONDRES_PARTNERS_POST_TYPE", 'partners');
}
if (!defined('LONDRES_TEAM_POST_TYPE')){
	define("LONDRES_TEAM_POST_TYPE", 'team');	
}

if (isset($_REQUEST['file'])) { 
    //check_admin_referer("londres_gallery_options");
    $options = get_option('londres_gallery_options', TRUE);
	if (isset($options['default_image'])) $options['default_image'] = absint($_REQUEST['file']) ? absint($_REQUEST['file']) : "";
    update_option('londres_gallery_options', $options);
}


function londres_load_meta_boxes(){
	//load the porftfolio categeories
	$sidebar_taxonomies=londres_get_custom_sidebars();
	$sidebar_categories=array(array('id'=>'none', 'name'=>'No Sidebar'), array('id'=>'sidebar-widgets', 'name'=>'Default Sidebar'));

	$sides = get_option('londres_sidebar_name_names');
	if (is_string($sides)) $sides = explode(LONDRES_SEPARATOR, $sides);
	$outputsidebars = array(array("id"=>"defaultblogsidebar", "name" => "Blog Sidebar"));
	if (!empty($sides)){
		foreach ($sides as $s){
			if ($s != ""){
				array_push($outputsidebars, array("id"=>$s, "name"=>$s));
			}
		}	
	}
	if (!count($outputsidebars)) array_push($outputsidebars, array("id"=>"", "name"=>"No Sidebars Found."));
	
	foreach($sidebar_taxonomies as $taxonomy){
		$sidebar_categories[]=array("name"=>$taxonomy, "id"=>londres_convert_to_class($taxonomy));
	}
	
	//load the porftfolio categeories
	$portf_categories=array(array('id'=>'all', 'name'=>'All Portfolios'));
	if (function_exists('londres_get_taxonomies')){
		$portf_taxonomies=londres_get_taxonomies('portfolio_type');
		foreach($portf_taxonomies as $taxonomy){
			$portf_categories[]=array("name"=>$taxonomy->name, "id"=>$taxonomy->slug);
		}		
	}
	
	//patterns
	$patterns=array();
	$patterns[0]=array('id'=>'none','name'=>'none');
	for($i=1; $i<=10; $i++){
		$patterns[]=array('id'=>'pattern'.$i, 'name'=>'pattern'.$i.'.jpg');
	}
	
	//post filtration
	global $wpdb;
	//post categories
	$post_categories = $wpdb->get_results( $wpdb->prepare("SELECT term_taxonomy_id FROM $wpdb->term_taxonomy WHERE taxonomy LIKE %s", "category"), ARRAY_A );
	
	$post_categories_output = array();
	if (count($post_categories) > 0){	
		foreach ($post_categories as $pcat){
			$post_taxonomy_name = $wpdb->get_results( $wpdb->prepare("SELECT name FROM $wpdb->terms WHERE term_id = %d", $pcat['term_taxonomy_id']), ARRAY_A ); 
			
			if (!empty($post_taxonomy_name)){
				$aux = array("id" => (string)$pcat['term_taxonomy_id'], "name" => (string)$post_taxonomy_name[0]['name']);
				array_push($post_categories_output, $aux);
			}
		}
	}
	//post tags
	$post_tags = $wpdb->get_results( $wpdb->prepare("SELECT term_taxonomy_id FROM $wpdb->term_taxonomy WHERE taxonomy LIKE %d", "post_tag"), ARRAY_A );
	$post_tags_output = array();
	if (count($post_tags) > 0){	
		foreach ($post_tags as $ptag){
			$post_taxonomy_name = $wpdb->get_results( $wpdb->prepare("SELECT name FROM $wpdb->terms WHERE term_id = %d", $ptag['term_taxonomy_id']), ARRAY_A );
			if (!empty($post_taxonomy_name)){
				$aux = array("id" => (string)$ptag['term_taxonomy_id'], "name" => (string)$post_taxonomy_name[0]['name']);
				array_push($post_tags_output, $aux);
			}
		}
	}
	//authors
	$post_authors = get_users('orderby=post_count&order=DESC');
	$usrs = array();
	foreach ($post_authors as $pauth){
		if (!in_array('subscriber', $pauth->roles)){
			$usrs[] = array("id" => $pauth->data->ID, "name" => $pauth->data->user_nicename);
		}
	}
	$post_authors = $usrs;

	global $londres_data, $londres_new_meta_boxes, $londres_new_meta_portfolio_boxes, $londres_new_meta_testimonials_boxes, $londres_new_meta_post_boxes, $londres_new_meta_partners_boxes, $londres_new_meta_team_boxes;
	
		/* ------------------------------------------------------------------------*
		 * META BOXES FOR THE PAGES
		 * ------------------------------------------------------------------------*/
	
	
		 if (get_option("londres_body_type") == "pattern") $varType = LONDRES_PATTERNS_URL.get_option("londres_body_pattern");
		 else $varType =  get_option("londres_header_body_pattern");
	
		//the meta data for pages
		$londres_new_meta_boxes =
		array(
		
		
		array(
			"title" => '<div class="ui-icon ui-icon-image no_show_hide_opts"></div>Blog Filter Options',
			"type" => "heading",
			"name" => "blogoptions"
		),
		
		array(
			"title" => '<p>Here you can narrow the Posts listing by choosing specific categories, tags or authors. If you want to select all of your posts as per usual deselect all the checkboxes. Either way, the ordering options will be applied.</p>',
			"type" => "heading_unformatted",
		),
		
		array(
			"title" => '<h4>Categories</h4>',
			"type" => "heading",
			"name" => "",
			"std" => "",
			"description" => ""
		),
		
		array(
			"title" => "",
			"type" => "multicheck",
			"name" => "posts_filter_categories",
			"options" => $post_categories_output
		),
		
		array(
			"title" => "Add Category Filter (Only for Masonry Template)",
			"type" => "select",
			"name" => "posts_add_category_filter",
			"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
			"std" => "no"
		),
		
		array(
			"title" => "Add Counter on Filters (Only for Masonry Template)",
			"type" => "select",
			"name" => "posts_add_category_filter_counter",
			"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
			"std" => "yes"
		),

		array(
			"title" => '<h4>Tags</h4>',
			"type" => "heading",
			"name" => "",
			"std" => "",
			"description" => ""
		),

		array(
			"title" => "",
			"type" => "multicheck",
			"name" => "posts_filter_tags",
			"options" => $post_tags_output
		),

		array(
			"title" => '<h4>Author</h4>',
			"type" => "heading",
			"name" => "",
			"std" => "",
			"description" => ""
		),

		array(
			"title" => "",
			"type" => "multicheck",
			"name" => "posts_filter_authors",
			"options" => $post_authors
		),

		array(
			"title" => '<h4>Order by</h4>',
			"type" => "heading",
			"name" => "",
			"std" => "",
			"description" => ""
		),
		
		array(
			"title" => 'Order by',
			"type" => "select",
			"name" => "posts_filter_orderby",
			"options" => array( array("id"=>"ID", "name"=>"ID"), array("id"=>"author", "name"=>"Author"), array("id"=>"title", "name"=>"Title"), array("id"=>"date","name"=>"Date"), array("id"=>"modified","name"=>"Modified"), array("id"=>"parent", "name"=>"Parent"), array("id"=>"rand","name"=>"Random"), array("id"=>"comment_count", "name"=>"Number of comments") ),
			"std" => "date"
		),

		array(
			"title" => '<h4>Order</h4>',
			"type" => "heading",
			"name" => "",
			"std" => "",
			"description" => ""
		),

		array(
			"title" => "Order",
			"name" => "posts_filter_order",
			"type" => "select",
			"options" => array(array("id"=>"desc","name"=>"Descendent"), array("id"=>"asc","name"=>"Ascendent")),
			"std" => "desc"
		),
		
		/* new meta options on blogs metas meta META METAS */
		array(
			"title" => '<h4>Metas</h4>',
			"type" => "heading",
			"name" => "",
			"std" => "",
			"description" => ""
		),

		array(
			"title" => "Display Metas ?",
			"name" => "upper_single_display_metas",
			"type" => "select",
			"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
		),
		
		array(
			"title" => "Metas to Display",
			"name" => "upper_single_metas",
			"type" => "multicheck",
			"sortable" => true,
			"options" => array(array("id"=>"date","name"=>"Date"),array("id"=>"author","name"=>"Author"),array("id"=>"tags","name"=>"Tags"),array("id"=>"categories","name"=>"Categories"),array("id"=>"comments","name"=>"Comments"),array("id"=>"customtext","name"=>"Custom Text")),
		),
		/* endof new metas on blogs */
		
		array(
			"title" => '<div class="ui-icon ui-icon-image no_show_hide_opts"></div>Page Title Options',
			"type" => "heading",
			"name" => "pagetitleoptions",
			"std" => "",
			"description" => ""
		),
		
		array(
			"title" => "Secondary Title",
			"name" => "secondaryTitle",
			"type" => "text",
			"description" => "If set, will display a second title below the main one. If you need to use classes use <strong>'</strong> instead of <strong>\"</strong>. You can also use <strong>br</strong> tags.",
			"extra_class" => 'hiddenoption_two'
		),
		
		array(
			"title" => "Enable Custom Options ?",
			"name" => "londres_enable_custom_header_options",
			"type" => "select",
			"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
			"std" => "no"
		),
		
		array(
			"title" => "Enable Page Loader ?",
			"name" => "londres_enable_website_loading",
			"type" => "select",
			"options" => array(array("id"=>"on","name"=>"Yes, please."), array("id"=>"off", "name"=>"No, thanks.")),
			"std" => get_option('londres_enable_website_loader'),
			"description" => "If set to YES, you'll need to activate the 'Enable Website Loading' options in <strong>Appearance</strong> > <strong>Londres Options</strong> > <strong>General</strong> > <strong>Main Settings</strong> to choose the Loader Style and Save the options. You can then deactive the option again."
		),
		
		array(
			"title" => "Page Content Starts...",
			"name" => "londres_content_to_the_top",
			"type" => "select",
			"options" => array(array("id"=>"off","name"=>"After the header"), array("id"=>"on","name"=>"Behind the header")),
			"std" => get_option('londres_content_to_the_top')
		),
		
		array(
			"title" => "Header Pre Scroll Style",
			"name" => "londres_custom_header_pre",
			"type" => "select",
			"options" => array(array("id"=>"light","name"=>"Light"), array("id"=>"dark", "name"=>"Dark")),
			"std" => get_option('londres_header_style_light_dark') != "" ? get_option('londres_header_style_light_dark') : "light"
		),
		
		array(
			"title" => "Header After Scroll Style",
			"name" => "londres_custom_header_after",
			"type" => "select",
			"options" => array(array("id"=>"light","name"=>"Light"), array("id"=>"dark", "name"=>"Dark")),
			"std" => get_option('londres_header_after_scroll_style_light_dark') != "" ? get_option('londres_header_after_scroll_style_light_dark') : "light"
		),
		
		array(
			"title" => "Enable Custom Page Title Options ?",
			"name" => "londres_enable_custom_pagetitle_options",
			"type" => "select",
			"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
			"std" => "no"
		),
			
		array(
			"title" => "Background Type",
			"name" => "londres_header_type",
			"type" => "select",
			"options" => array(array('id'=>'without', 'name'=>'Without Page Title'), array('id'=>'color','name'=>'Color'), array('id'=>'image','name'=>'Image'), array('id'=>'pattern','name'=>'Pattern'), array('id' => 'banner', 'name' => 'Banner Slider')),
			"std" => get_option('londres_header_type')
		),
		
		array(
			"title" => "Image",
			"name" => "londres_header_image",
			"type" => "mediaupload",
			"description" => 'Here you can choose the image for your header.'
		),
		
		// levar aqui as opções novas do pagetitle do painel para o caso das custom options numa page specific.
		array(
			"title" => "Parallax ?",
			"name" => "londres_pagetitle_image_parallax",
			"type" => "select",
			"options" => array(array("id"=>"on","name"=>"Yes, please."),array("id"=>"off","name"=>"No, thanks.")),
			"std" => "off",
		),
		
		array(
			"title" => "Overlay ?",
			"name" => "londres_pagetitle_image_overlay",
			"type" => "select",
			"options" => array(array("id"=>"on","name"=>"Yes, please."),array("id"=>"off","name"=>"No, thanks.")),
			"std" => "off"
		),
		
		array(
			"title" => "Overlay Type",
			"name" => "londres_pagetitle_overlay_type",
			"type" => "select",
			"options" => array(array('id'=>'color', 'name'=>'Color'), array('id'=>'pattern','name'=>'Pattern')),
			"std" => 'color',
		),
		
		array(
			"title" => "Overlay Color",
			"name" => "londres_pagetitle_overlay_color",
			"type" => "color",
			"std" => "333333"
		),
		
		array(
			"title" => "Overlay Pattern",
			"name" => "londres_pagetitle_overlay_pattern",
			"type" => "pattern",
			"options" => $patterns,
		),
		
		array(
			"title" => "Overlay Opacity",
			"name" => "londres_pagetitle_overlay_opacity",
			"type" => "slider",
			"std" => "100%"
		),
		// end of new options
		
		array(
			"title" => "Color",
			"name" => "londres_header_color",
			"type" => "color"
		),
		
		array(
			"title" => "Color Opacity",
			"name" => "londres_header_color_opacity",
			"type" => "slider",
			"std" => "100"
		),
		
		array(
			"title" => "Pattern",
			"name" => "londres_header_pattern",
			"type" => "pattern",
			"options" => $patterns,
			"description" => 'Here you can choose the pattern for your header.'
		),
		
		array(
			"title" => "Custom Pattern",
			"name" => "londres_header_custom_pattern",
			"type" => "mediaupload",
			"description" => 'Here you can choose the custom pattern for your header. It will replace the pattern you choose above.'
		),
		
		array(
			"title" => "Banner Slider",
			"name" => "londres_banner_slider",
			"type" => "select",
			"options" => londres_get_created_camera_sliders()
		),

		array(
			"title" => "Page Title Padding",
			"name"=> "londres_page_title_padding",
			"type" => "text",
			"std" => "50px"
		),
		
		array(
			"title"=>"Text Alignment",
			"name" => "londres_header_text_alignment",
			"type" => "select",
			"std" => "left",
			"options" => array(array("id"=>"left", "name"=>"Left"), array("id"=>"center", "name"=>"Center"), array("id"=>"right", "name"=>"Right"), array("id"=>"titlesleftcrumbsright", "name"=>"Left: Titles, Right: Breadcrumbs"), array("id"=>"titlesrightcrumbsleft", "name"=>"Left: Breadcrumbs, Right: Titles"))
		),
		
		array(
			"title" => '<h4>Primary Title Options</h4>',
			"type" => "heading",
			"name" => "primarytitleoptions",
			"std" => "",
			"description" => ""
		),


		array(
			"title" => "Display Title ?",
			"name" => "londres_hide_pagetitle",
			"type" => "select",
			"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
			"std" => "yes"
		),
		
		array(
			"title" => "Primary Title Font",
			"name" => "londres_header_text_font",
			"type" => "select",
			"options" => londres_fonts_array_builder(),
			"description" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
			"std" => 'Helvetica Neue'
		),
		
		array(
			"title" => "Primary Title Color",
			"name" => "londres_header_text_color",
			"type" => "color",
			"std" => "333333"
		),
		
		array(
			"title" => "Primary Title Size",
			"name" => "londres_header_text_size",
			"type" => "text",
			"std" => "16px"
		),
		
		array(
			"title" => "Primary Title Margin",
			"name" => "londres_header_text_margin_top",
			"type" => "text",
			"std" => "20px"
		),
		
		array(
			"title" => '<h4>Secondary Title Options</h4>',
			"type" => "heading",
			"name" => "secondarytitleoptions",
			"std" => "",
			"description" => ""
		),
		
		array(
			"title" => "Display Secondary Title ?",
			"name" => "londres_hide_sec_pagetitle",
			"type" => "select",
			"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
			"std" => "yes"
		),
		
		array(
			"title" => "Secondary Title Font",
			"name" => "londres_secondary_title_font",
			"type" => "select",
			"options" => londres_fonts_array_builder(),
			"description" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
			"std" => 'Helvetica Neue'
		),
		
		array(
			"title" => "Secondary Title Color",
			"name" => "londres_secondary_title_text_color",
			"type" => "color",
			"std" => "828282"
		),
		
		array(
			"title" => "Secondary Title Size",
			"name" => "londres_secondary_title_text_size",
			"type" => "text",
			"std" => "12px"
		),

		array(
			"title" => "Secondary Title Margin",
			"name" => "londres_header_secondary_text_margin_top",
			"type" => "text",
			"std" => "10px"
		),
		
		array(
			"title" => '<h4>Breadcrumbs Options</h4>',
			"type" => "heading",
			"name" => "breadcrumboptions",
			"std" => "",
			"description" => ""
		),
		
		array(
			"title" => "Display Breadcrumbs ?",
			"name" => "londres_enable_breadcrumbs",
			"type" => "select",
			"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
			"std" => "yes"
		),
		
		array(
			"title" => "Breadcrumbs Margin Top",
			"name" => "londres_breadcrumbs_margin_top",
			"type" => "text",
			"std" => "10px"
		),

			/* FLASH NEW STUFF */
			array(
				"title" => '<div class="ui-icon ui-icon-image no_show_hide_opts"></div>Under Construction Template Options',
				"type" => "heading",
				"name" => "underconstructionoptions",
				"std" => "",
				"description" => ""
			),
		
			array(
				"title" => "Choose the Revolution Slider",
				"name" => "underconstruction_rev",
				"type" => "select",
				"options" => londres_get_created_camera_sliders()
			),
			
			array(
				"title" => '<div class="ui-icon ui-icon-image no_show_hide_opts"></div>Homepage Style',
				"type" => "heading",
				"name" => "homepageoptions",
				"std" => "",
				"description" => ""
			),
		
			array(
				"title" => "Choose the Home Template Style.",
				"name" => "homeStyle",
				"type" => "selectHomeStyle",
				"options" => array(array("id"=>"slider","name"=>"Slider"), array("id"=>"image", "name"=>"Image"), array("id"=>"video", "name"=>"Video")),
			),
		
			array(
				"title" => "Homepage Slider",
				"name" => "homepageDefaultSlider",
				"type" => "select",
				"options" => londres_get_created_camera_sliders(),
				"description" => 'Choose one of your previously created sliders.'
			),
			
			array(
				"title" => "Parallax Effect ?",
				"name" => "parallaxEffect",
				"type" => "select",
				"options" => array(array("id"=>"yes","name"=>"YES"), array("id"=>"no","name"=>"NO")),
				"std" => "yes"
			),
			
			array(
				"title"=> "Select Background Media",
				"name"=> "homeParallaxMedia",
				"type"=> "mediauploadHome"
			),
			
			array(
				"title" => "Select the source of the video.",
				"name" => "homeVideoSource",
				"type" => "select",
				"options" => array(array("id"=>"youtube","name"=>"Youtube Video"), array("id"=>"media","name"=>"Media Library")),
				"description" => "Youtube Videos won't work on any mobile devices (iOs, Android, Windows, etc.) due to restrictions applied by the vendors on media controls via javascript."
			),
			
			array(
				"title"=> "Select Background Media",
				"name"=> "homeParallaxMedia_video",
				"type"=> "mediauploadHome_video"
			),
			
			array(
				"title" => "Youtube Video Link",
				"name" => "homeYoutubeLink",
				"type" => "text",
				"description"=> "Paste <strong> just the ID of the video</strong> (E.g. http://www.youtube.com/watch?v=<strong>8O72jXoMIkg</strong>) you want to show."
			),
			
			array(
				"title" => "Show Controls",
				"name" => "homeVideoControls",
				"type" => "select",
				"options" => array(array("id"=>"no","name"=>"NO"), array("id"=>"yes","name"=>"YES")),
				"std" => "no"
			),
			
			array(
				"title" => "Mute Video",
				"name" => "homeVideoMuted",
				"type" => "select",
				"options" => array(array("id"=>"no","name"=>"NO"), array("id"=>"yes","name"=>"YES")),
				"std" => "yes"
			),
			
			array(
				"title" => "Intro Logotype",
				"name" => "introLogo",
				"type" => "select",
				"options" => array(array("id"=>"image", "name"=>"Image"), array("id"=>"text","name"=>"Text"), array("id"=>"none","name"=>"None")),
				"std" => "text"
			),
			
			array(
				"title" => "Intro Logo Text",
				"name" => "introLogoText",
				"type" => "text",
				"std" => "LONDRES"
			),
			
			array(
				"title" => "Intro Logo Font",
				"name" => "introLogoFont",
				"type" => "select",
				"options" => londres_fonts_array_builder(),
				"std" => "Open Sans Semibold"
			),
			
			array(
				"title" => "Intro Logo Font Size",
				"name" => "introLogoFontSize",
				"type" => "text",
				"std" => "80px"
			),
				
			array(
				"title" => "Intro Logo Text Style",
				"name" => "introLogoTextStyle",
				"type" => "select",
				"options" => array(array("id"=>"dark","name"=>"Dark"),array("id"=>"light","name"=>"Light")),
				"std" => "dark"
			),
			
			array(
				"title" => "Intro Logo Border",
				"name" => "introLogoBorder",
				"type" => "select",
				"options" => array(array("id"=>"yes","name"=>"Yes"),array("id"=>"no","name"=>"No")),
				"std" => "no"
			),
			
			array(
				"title" => "Intro Logo Image URL",
				"name" => "introLogoImageURL",
				"type" => "introLogoUpload"
			),
			
			array(
				"title" => "Intro Logo Image Height",
				"name" => "introLogoImageHeight",
				"type" => "text",
				"std" => "130px"
			),
			
			array(
				"title" => "Intro Logo Link",
				"name" => "introLogoLink",
				"type" => "text",
				"desc" => "If empty the link will scroll to the content, skipping the intro screen."
			),
			
			array(
				"title" => "Show Captions?",
				"name" => "introCaptionsEnable",
				"type" => "select",
				"options" => array(array("id"=>"yes","name"=>"Yes"),array("id"=>"no","name"=>"No")),
				"std" => "yes"
			),
			
			array(
				"title" => "Captions List",
				"name" => "introCaptionsList",
				"type" => "textarea"
			),
			
			array(
				"title" => "Intro Captions Font",
				"name" => "introCaptionsFont",
				"type" => "select",
				"options" => londres_fonts_array_builder(),
				"std" => "Open Sans Semibold"
			),
			
			array(
				"title" => "Intro Captions Text Color",
				"name" => "introCaptionsTextStyle",
				"type" => "color",
				"std" => "FFFFFF"
			),
			
			array(
				"title" => "Intro \"Continue\" Button",
				"name" => "introContinueEnable",
				"type" => "select",
				"options" => array(array("id"=>"yes","name"=>"Yes"),array("id"=>"no","name"=>"No")),
				"description" => "If set to <strong>Yes</strong> it will display a button at the bottom of the intro to continue to the site's content."
			),
			
			array(
				"title" => "Intro \"Continue\" Button Type",
				"name" => "introContinueType",
				"type" => "select",
				"options" => array(array("id"=>"text","name"=>"Text"),array("id"=>"arrow","name"=>"Arrow"))
			),
			
			array(
				"title" => "Intro \"Continue\" Button Text",
				"name" => "introContinueText",
				"type" => "text",
				"std" => "Continue"
			),
			
			array(
				"title" => "Intro \"Continue\" Text Font",
				"name" => "introContinueFont",
				"type" => "select",
				"options" => londres_fonts_array_builder(),
				"std" => "Open Sans Semibold"
			),
			
			array(
				"title" => "Intro \"Continue\" Text Font Size",
				"name" => "introContinueSize",
				"type" => "text",
				"std" => "14px"
			),
			
			array(
				"title" => "Intro \"Continue\" Text Color",
				"name" => "introContinueColor",
				"type" => "color",
				"std" => "fafafa"
			),
			
			array(
				"title" => "Intro \"Continue\" Text Background Color",
				"name" => "introContinueBgColor",
				"type" => "color",
				"std" => "666666"
			),
		
			/* ENDOF FLASH NEW STUFF */
			
			array(
				"title" => "",
				"name" => "sidebar_for_default",
				"type" => "select",
				"options" => array(array("id"=>"none", "name" => "none"), array("id"=>"left", "name" => "left"), array("id"=>"right", "name" => "right")),
				"std" => "none"
			),
			
			array(
				"title" => "Choose your Sidebar",
				"name" => "sidebars_available",
				"type" => "select",
				"options" => $outputsidebars
			),
						
		);


		/* ------------------------------------------------------------------------*
		 * META BOXES FOR THE POSTS - POST_TYPES
		 * ------------------------------------------------------------------------*/

		$londres_new_meta_post_boxes =
		array(
			
			array(
				"title" => "",
				"name" => "enable_post_custom_sidebar_layout",
				"type" => "select",
				"options" => array(array("id"=>"false","name"=>"false"), array("id"=>"true","name"=>"true")),
				"std" => "false"
			),
			
			array(
				"title" => "",
				"name" => "sidebar_for_default",
				"type" => "select",
				"options" => array(array("id"=>"none", "name" => "none"), array("id"=>"left", "name" => "left"), array("id"=>"right", "name" => "right")),
				"std" => "none"
			),
			
			array(
				"title" => "Choose your Sidebar",
				"name" => "sidebars_available",
				"type" => "select",
				"options" => $outputsidebars
			),
		
			array(
				"title" => "Secondary Title",
				"name" => "secondaryTitle",
				"type" => "text",
				"std" => "",
				"description" => "If set, will display a second title below the main one.",
				"extra_class" => 'hiddenoption_two'
			),
				
			array(
				"title" => "Post Type",
				"name" => "posttype",
				"std" => "text",
				"type" => "select",
				"options" => array(array('id'=> 'image', 'name'=> 'Featured Image'), array('id'=>'slider', 'name'=>'Images Slider'), array('id'=>'gallery', 'name' => 'Gallery'), array('id'=>'video', 'name'=>'Video'), array('id'=>'audio', 'name'=>'Audio'), array('id'=>'text', 'name'=>'Text'), array('id'=>'quote', 'name'=>'Quote'), array('id'=>'link','name'=>'Link'), array('id'=>'none', 'name'=>'None')),
				"description" => 'You can choose from the following five post types: Featured Image, Slider, Video, Audio, Text or None.'
			),
			
			array(
				"title" => "Display Feature Image on Single",
				"name" => "londres_display_featured_image",
				"type" => "select",
				"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
				"std" => "yes"
			),
			
			array(
				"title" => "<div class='ui-icon ui-icon-image show_hide_opts'></div>Quote",
				"type" => "heading",
				"name" => "",
				"std" => "",
				"description" => "",
			),
			
			array(
				'title' => 'Quote text',
				'name' => 'quote_text',
				'type' => 'textarea'
			),
			
			array(
				'title' => 'Quote Author',
				'name' => 'quote_author',
				'type' => 'text'
			),
			
			array(
				"title" => "<div class='ui-icon ui-icon-image show_hide_opts'></div>Link",
				"type" => "heading",
				"name" => "",
				"std" => "",
				"description" => "",
			),
			
			array(
				'title' => 'Link Text',
				'name' => 'link_text',
				'type' => 'text'
			),
			
			array(
				'title' => 'Link URL',
				'name' => 'link_url',
				'type' => 'text'
			),
			
			array(
				"title" => "<div class='ui-icon ui-icon-image show_hide_opts'></div>Images Slider",
				"type" => "heading",
				"name" => "",
				"std" => "",
				"description" => "",
			),
			
			array(
				"title"=> "Add Images",
				"name"=> "sliderImages",
				"type"=> "mediaupload"
			),
			
			array(
				"title" => "<div class='ui-icon ui-icon-image show_hide_opts'></div>Video",
				"type" => "heading",
				"name" => "",
				"std" => "",
				"description" => "",
			),
			
			array(
				"title"=> "Video Source",
				"name"=> "videoSource",
				"type"=> "select",
				"options" => array(array("id"=>"youtube", "name"=>"Youtube"), array("id"=>"vimeo","name"=>"Vimeo"), array("id"=>"media","name"=>"Media Library"))
			),
			
			array(
				"title"=>"Video Code",
				"name"=>"videoCode",
				"type"=>"textarea",
				"description"=> "Paste <strong> just the ID of the video</strong> (E.g. http://www.youtube.com/watch?v=<strong>I83Xp7itj8c</strong> or http://vimeo.com/<strong>127909728</strong>) you want to show, or insert own Embed Code."
			),
			
			array(
				"title"=> "Select Video",
				"name"=> "videoMediaLibrary",
				"type"=> "mediauploadHome_video"
			),
			
			array(
				"title" => "<div class='ui-icon ui-icon-image show_hide_opts'></div>Gallery",
				"type" => "heading",
				"name" => "",
				"std" => "",
				"description" => "",
			),
			
			array(
				"title"=> "Choose Slider Gallery",
				"name"=> "gallery_slider",
				"type"=> "select",
				"options" => londres_get_created_camera_sliders()
			),
			
			array(
				"title" => "<div class='ui-icon ui-icon-image show_hide_opts'></div>Audio",
				"type" => "heading",
				"name" => "",
				"std" => "",
				"description" => "",
			),
			
			array(
				"title" => "Audio Source",
				"name" => "audioSource",
				"type" => "select",
				"options" => array( array("id"=>"embed","name"=>"Embed Code"), array("id"=>"media","name"=>"Media Library") )
			),
			
			array(
				"title"=> "Select Audio",
				"name"=> "audioMediaLibrary",
				"type"=> "mediaupload_audio"
			),
			
			array(
				"title"=>"Audio Code",
				"name"=>"audioCode",
				"type"=>"textarea",
				"description"=> "Paste the Embed Code. <br>"
			),
			
		/* NEW META OPTIONS SINGLE */
		
		array(
			"title" => "Display Metas ?",
			"name" => "upper_single_display_metas",
			"type" => "select",
			"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
			"std" => "yes"
		),
		
		array(
			"title" => "Metas to Display",
			"name" => "upper_single_metas",
			"type" => "multicheck",
			"sortable" => true,
			"options" => array(array("id"=>"date","name"=>"Date"),array("id"=>"author","name"=>"Author"),array("id"=>"tags","name"=>"Tags"),array("id"=>"categories","name"=>"Categories"),array("id"=>"comments","name"=>"Comments"),array("id"=>"customtext","name"=>"Custom Text")),
			"std" => "date,author,tags,categories"
		),
		
		array(
			"title" => "Meta Custom Text",
			"name" => "upper_single_meta_custom_text",
			"type" => "text"
		),
		
		/* ENDOF NEW META OPTIONS */
		
		
		array(
			"title" => "Enable Custom Header Options ?",
			"name" => "londres_enable_custom_header_options",
			"type" => "select",
			"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
			"std" => "no"
		),
		
		array(
			"title" => "Enable Page Loader ?",
			"name" => "londres_enable_website_loading",
			"type" => "select",
			"options" => array(array("id"=>"on","name"=>"Yes, please."), array("id"=>"off", "name"=>"No, thanks.")),
			"std" => get_option('londres_enable_website_loader'),
			"description" => "If set to YES, you'll need to activate the 'Enable Website Loading' options in <strong>Appearance</strong> > <strong>Londres Options</strong> > <strong>General</strong> > <strong>Main Settings</strong> to choose the Loader Style and Save the options. You can then deactive the option again."
		),
		
		array(
			"title" => "Page Content Starts...",
			"name" => "londres_content_to_the_top",
			"type" => "select",
			"options" => array(array("id"=>"off","name"=>"After the header"), array("id"=>"on","name"=>"Behind the header")),
			"std" => get_option('londres_content_to_the_top')
		),
		
		array(
			"title" => "Header Pre Scroll Style",
			"name" => "londres_custom_header_pre",
			"type" => "select",
			"options" => array(array("id"=>"light","name"=>"Light"), array("id"=>"dark", "name"=>"Dark")),
			"std" => get_option('londres_header_style_light_dark') != "" ? get_option('londres_header_style_light_dark') : "light"
		),
		
		array(
			"title" => "Header After Scroll Style",
			"name" => "londres_custom_header_after",
			"type" => "select",
			"options" => array(array("id"=>"light","name"=>"Light"), array("id"=>"dark", "name"=>"Dark")),
			"std" => get_option('londres_header_after_scroll_style_light_dark') != "" ? get_option('londres_header_after_scroll_style_light_dark') : "light"
		),	
						
		array(
			"title" => "Enable Custom Page Title Options ?",
			"name" => "londres_enable_custom_pagetitle_options",
			"type" => "select",
			"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
			"std" => "no"
		),
			
		array(
			"title" => "Background Type",
			"name" => "londres_header_type",
			"type" => "select",
			"options" => array(array('id'=>'without', 'name'=>'Without Page Title'), array('id'=>'color','name'=>'Color'), array('id'=>'image','name'=>'Image'), array('id'=>'pattern','name'=>'Pattern'), array('id' => 'banner', 'name' => 'Banner Slider')),
			"std" => get_option('londres_header_type')
		),
		
		array(
			"title" => "Image",
			"name" => "londres_header_image",
			"type" => "mediaupload",
			"description" => 'Here you can choose the image for your header.'
		),
		
		// levar aqui as opções novas do pagetitle do painel para o caso das custom options numa page specific.
		array(
			"title" => "Parallax ?",
			"name" => "londres_pagetitle_image_parallax",
			"type" => "select",
			"options" => array(array("id"=>"on","name"=>"Yes, please."),array("id"=>"off","name"=>"No, thanks.")),
			"std" => "off",
		),
		
		array(
			"title" => "Overlay ?",
			"name" => "londres_pagetitle_image_overlay",
			"type" => "select",
			"options" => array(array("id"=>"on","name"=>"Yes, please."),array("id"=>"off","name"=>"No, thanks.")),
			"std" => "off"
		),
		
		array(
			"title" => "Overlay Type",
			"name" => "londres_pagetitle_overlay_type",
			"type" => "select",
			"options" => array(array('id'=>'color', 'name'=>'Color'), array('id'=>'pattern','name'=>'Pattern')),
			"std" => 'color',
		),
		
		array(
			"title" => "Overlay Color",
			"name" => "londres_pagetitle_overlay_color",
			"type" => "color",
			"std" => "333333"
		),
		
		array(
			"title" => "Overlay Pattern",
			"name" => "londres_pagetitle_overlay_pattern",
			"type" => "pattern",
			"options" => $patterns,
		),
		
		array(
			"title" => "Overlay Opacity",
			"name" => "londres_pagetitle_overlay_opacity",
			"type" => "slider",
			"std" => "100%"
		),
		// end of new options
		
		array(
			"title" => "Color",
			"name" => "londres_header_color",
			"type" => "color"
		),
		
		array(
			"title" => "Color Opacity",
			"name" => "londres_header_color_opacity",
			"type" => "slider",
			"std" => "100"
		),
		
		array(
			"title" => "Pattern",
			"name" => "londres_header_pattern",
			"type" => "pattern",
			"options" => $patterns,
			"description" => 'Here you can choose the pattern for your header.'
		),
		
		array(
			"title" => "Custom Pattern",
			"name" => "londres_header_custom_pattern",
			"type" => "mediaupload",
			"description" => 'Here you can choose the custom pattern for your header. It will replace the pattern you choose above.'
		),
		
		array(
			"title" => "Banner Slider",
			"name" => "londres_banner_slider",
			"type" => "select",
			"options" => londres_get_created_camera_sliders()
		),

		array(
			"title" => "Page Title Padding",
			"name"=> "londres_page_title_padding",
			"type" => "text",
			"std" => "50px"
		),
		
		array(
			"title"=>"Text Alignment",
			"name" => "londres_header_text_alignment",
			"type" => "select",
			"std" => "left",
			"options" => array(array("id"=>"left", "name"=>"Left"), array("id"=>"center", "name"=>"Center"), array("id"=>"right", "name"=>"Right"), array("id"=>"titlesleftcrumbsright", "name"=>"Left: Titles, Right: Breadcrumbs"), array("id"=>"titlesrightcrumbsleft", "name"=>"Left: Breadcrumbs, Right: Titles"))
		),
		
		array(
			"title" => '<h4>Primary Title Options</h4>',
			"type" => "heading",
			"name" => "primarytitleoptions",
			"std" => "",
			"description" => ""
		),


		array(
			"title" => "Display Title ?",
			"name" => "londres_hide_pagetitle",
			"type" => "select",
			"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
			"std" => "yes"
		),
		
		array(
			"title" => "Primary Title Font",
			"name" => "londres_header_text_font",
			"type" => "select",
			"options" => londres_fonts_array_builder(),
			"description" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
			"std" => 'Helvetica Neue'
		),
		
		array(
			"title" => "Primary Title Color",
			"name" => "londres_header_text_color",
			"type" => "color",
			"std" => "333333"
		),
		
		array(
			"title" => "Primary Title Size",
			"name" => "londres_header_text_size",
			"type" => "text",
			"std" => "16px"
		),
		
		array(
			"title" => "Primary Title Margin",
			"name" => "londres_header_text_margin_top",
			"type" => "text",
			"std" => "20px"
		),
		
		array(
			"title" => '<h4>Secondary Title Options</h4>',
			"type" => "heading",
			"name" => "secondarytitleoptions",
			"std" => "",
			"description" => ""
		),
		
		array(
			"title" => "Display Secondary Title ?",
			"name" => "londres_hide_sec_pagetitle",
			"type" => "select",
			"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
			"std" => "yes"
		),
		
		array(
			"title" => "Secondary Title Font",
			"name" => "londres_secondary_title_font",
			"type" => "select",
			"options" => londres_fonts_array_builder(),
			"description" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
			"std" => 'Helvetica Neue'
		),
		
		array(
			"title" => "Secondary Title Color",
			"name" => "londres_secondary_title_text_color",
			"type" => "color",
			"std" => "828282"
		),
		
		array(
			"title" => "Secondary Title Size",
			"name" => "londres_secondary_title_text_size",
			"type" => "text",
			"std" => "12px"
		),

		array(
			"title" => "Secondary Title Margin",
			"name" => "londres_header_secondary_text_margin_top",
			"type" => "text",
			"std" => "10px"
		),
		
		array(
			"title" => '<h4>Breadcrumbs Options</h4>',
			"type" => "heading",
			"name" => "breadcrumboptions",
			"std" => "",
			"description" => ""
		),
		
		array(
			"title" => "Display Breadcrumbs ?",
			"name" => "londres_enable_breadcrumbs",
			"type" => "select",
			"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
			"std" => "yes"
		),
		
		array(
			"title" => "Breadcrumbs Margin Top",
			"name" => "londres_breadcrumbs_margin_top",
			"type" => "text",
			"std" => "10px"
		),

			
		);


		/* ------------------------------------------------------------------------*
		 * META BOXES FOR THE PORTFOLIO POSTS
		 * ------------------------------------------------------------------------*/

		$londres_new_meta_portfolio_boxes =
		array(
		
			array(
				"title" => "Secondary Title",
				"name" => "secondaryTitle",
				"type" => "text",
				"std" => "",
				"description" => "If set, will display a second title below the main one.",
				"extra_class" => 'hiddenoption_two'
			),
						
			array(
				"title" => "Project - Page Layout",
				"name" => "singleLayout",
				"type" => "select",
				"options" => array(array('id'=>'default','name'=>'Default'), array('id'=>'left_media', 'name'=>'Media on the Left'),array('id'=>'full_media', 'name'=>'Media occupies the container\'s full length'), array('id'=>'fullwidth_media', 'name'=>'Media occupies the window\'s length')),
				"std" => "default",
				"description"=>"If set to <strong>Default</strong> the Project will be displayed as defined on the <strong>Panel Options </strong>><strong> General </strong>><strong> Projects </strong>><strong> Project Single Layout Option</strong>."
			),
			
			array(
				"title" => "Portfolio Type",
				"name" => "portfolioType",
				"type" => "select",
				"options" => array(array("id"=>"image", "name"=>"Slider Images"),array("id"=>"video", "name"=>"Video"), array("id"=>"other", "name"=>"Page Builder Content"))
			),

			array(
				"title" => "<div class='ui-icon ui-icon-image show_hide_opts'></div>Slider Images",
				"type" => "heading",
				"name" => "",
				"std" => "",
				"description" => "",
			),
		
			array(
				"title"=> "Add Slider Image",
				"name"=> "sliderImages",
				"type"=> "mediaupload"
			),
			
			array(
				"title" => "Custom Flex Slider Options",
				"name" => "custom_slider_opts",
				"type" => "select",
				"options" => array(array("id"=>"on", "name"=>"ON"),array("id"=>"off","name"=>"OFF")),
				"description"=>"If set to <strong>ON</strong> this options will override the ones on the Panel Options > Slider Settings > Flex Slider > General > Projects.",
				"std" => "off"
			),
			
			array(
				"title" => "Show Direction Controls",
				"name" => "projs_flex_navigation",
				"type" => "select",
				"options" => array(array("name"=>"Yes", "id"=>"true"), array("name"=>"No", "id"=>"false")),
				"std" => get_option("londres_projs_flex_navigation"),
				"description" => ""
			),
		
			array(
				"title" => "Show Controls",
				"name" => "projs_flex_controls",
				"type" => "select",
				"options" => array(array("name"=>"Yes", "id"=>"true"), array("name"=>"No", "id"=>"false")),
				"std" => get_option("londres_projs_flex_controls"),
				"description" => ""
			),
			
			array(
				"title" => "Transition Effect",
				"name" => "projs_flex_transition",
				"type" => "select",
				"options" => array(array("name"=>"Slide", "id"=>"slide"), array("name"=>"Fade", "id"=>"fade")),
				"std" => get_option("londres_projs_flex_transition"),
				"description" => ""
			),
			
			array(
				"title" => "Transition Duration",
				"name" => "projs_flex_transition_duration",
				"type" => "text",
				"std" => get_option("londres_projs_flex_transition_duration"),
				"description" => "The duration of the transition between slides."
			),
			
			array(
				"title" => "Slide Duration",
				"name" => "projs_flex_slide_duration",
				"type" => "text",
				"std" => get_option("londres_projs_flex_slide_duration"),
				"description" => "The duration of each slide"
			),
			
			array(
				"title" => "Autoplay",
				"name" => "projs_flex_autoplay",
				"type" => "select",
				"options" => array(array("name"=>"Yes", "id"=>"true"), array("name"=>"No", "id"=>"false")),
				"std" => get_option("londres_projs_flex_autoplay"),
				"description" => ""
			),
			
			array(
				"title" => "Pause on Hover",
				"name" => "projs_flex_pause_hover",
				"type" => "select",
				"options" => array(array("name"=>"Yes", "id"=>"true"), array("name"=>"No", "id"=>"false")),
				"std" => get_option("londres_projs_flex_pause_hover"),
				"description" => "Play/Pause on mouse out/over"
			),
			
			array(
				"title" => "Slider Height",
				"name" => "projs_flex_height",
				"type" => "text",
				"std" => get_option("londres_projs_flex_height"),
				"description" => "The height of the slider."
			),
			
			array(
				"title" => "<div class='ui-icon ui-icon-image show_hide_opts'></div>Video",
				"type" => "heading",
				"name" => "",
				"std" => "",
				"description" => "",
			),
			
			array(
				"title"=> "Video Source",
				"name"=> "videoSource",
				"type"=> "select",
				"options" => array(array("id"=>"youtube", "name"=>"Youtube"), array("id"=>"vimeo", "name"=>"Vimeo"), array("id"=>"media","name"=>"Media Library"))
			),
			
			array(
				"title"=>"Video Code",
				"name"=>"videoCode",
				"type"=>"textarea",
				"description"=> "Paste <strong> just the ID of the video</strong> (E.g. http://www.youtube.com/watch?v=<strong>I83Xp7itj8c</strong> or http://vimeo.com/<strong>127909728</strong>) you want to show, or insert own Embed Code. <br>If you need to show more than one video just paste de IDs separated by comas [ <strong>,</strong> ].<br>"
			),
			
			array(
				"title"=> "Select Video",
				"name"=> "videoMediaLibrary",
				"type"=> "mediauploadHome_video"
			),
			
			
			array(
				"title" => "Enable Custom Header Options ?",
				"name" => "londres_enable_custom_header_options",
				"type" => "select",
				"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
				"std" => "no"
			),
			
			array(
				"title" => "Enable Page Loader ?",
				"name" => "londres_enable_website_loading",
				"type" => "select",
				"options" => array(array("id"=>"on","name"=>"Yes, please."), array("id"=>"off", "name"=>"No, thanks.")),
				"std" => get_option('londres_enable_website_loader'),
				"description" => "If set to YES, you'll need to activate the 'Enable Website Loading' options in <strong>Appearance</strong> > <strong>Londres Options</strong> > <strong>General</strong> > <strong>Main Settings</strong> to choose the Loader Style and Save the options. You can then deactive the option again."
			),
			
			array(
				"title" => "Page Content Starts...",
				"name" => "londres_content_to_the_top",
				"type" => "select",
				"options" => array(array("id"=>"off","name"=>"After the header"), array("id"=>"on","name"=>"Behind the header")),
				"std" => get_option('londres_content_to_the_top')
			),
			
			array(
				"title" => "Header Pre Scroll Style",
				"name" => "londres_custom_header_pre",
				"type" => "select",
				"options" => array(array("id"=>"light","name"=>"Light"), array("id"=>"dark", "name"=>"Dark")),
				"std" => get_option('londres_header_style_light_dark') != "" ? get_option('londres_header_style_light_dark') : "light"
			),
			
			array(
				"title" => "Header After Scroll Style",
				"name" => "londres_custom_header_after",
				"type" => "select",
				"options" => array(array("id"=>"light","name"=>"Light"), array("id"=>"dark", "name"=>"Dark")),
				"std" => get_option('londres_header_after_scroll_style_light_dark') != "" ? get_option('londres_header_after_scroll_style_light_dark') : "light"
			),
			
			array(
				"title" => "Enable Custom Page Title Options ?",
				"name" => "londres_enable_custom_pagetitle_options",
				"type" => "select",
				"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
				"std" => "no"
			),
				
			array(
				"title" => "Background Type",
				"name" => "londres_header_type",
				"type" => "select",
				"options" => array(array('id'=>'without', 'name'=>'Without Page Title'), array('id'=>'color','name'=>'Color'), array('id'=>'image','name'=>'Image'), array('id'=>'pattern','name'=>'Pattern'), array('id' => 'banner', 'name' => 'Banner Slider')),
				"std" => get_option('londres_header_type')
			),
			
			array(
				"title" => "Image",
				"name" => "londres_header_image",
				"type" => "mediaupload",
				"description" => 'Here you can choose the image for your header.'
			),
			
			// levar aqui as opções novas do pagetitle do painel para o caso das custom options numa page specific.
			array(
				"title" => "Parallax ?",
				"name" => "londres_pagetitle_image_parallax",
				"type" => "select",
				"options" => array(array("id"=>"on","name"=>"Yes, please."),array("id"=>"off","name"=>"No, thanks.")),
				"std" => "off",
			),
			
			array(
				"title" => "Overlay ?",
				"name" => "londres_pagetitle_image_overlay",
				"type" => "select",
				"options" => array(array("id"=>"on","name"=>"Yes, please."),array("id"=>"off","name"=>"No, thanks.")),
				"std" => "off"
			),
			
			array(
				"title" => "Overlay Type",
				"name" => "londres_pagetitle_overlay_type",
				"type" => "select",
				"options" => array(array('id'=>'color', 'name'=>'Color'), array('id'=>'pattern','name'=>'Pattern')),
				"std" => 'color',
			),
			
			array(
				"title" => "Overlay Color",
				"name" => "londres_pagetitle_overlay_color",
				"type" => "color",
				"std" => "333333"
			),
			
			array(
				"title" => "Overlay Pattern",
				"name" => "londres_pagetitle_overlay_pattern",
				"type" => "pattern",
				"options" => $patterns,
			),
			
			array(
				"title" => "Overlay Opacity",
				"name" => "londres_pagetitle_overlay_opacity",
				"type" => "slider",
				"std" => "100%"
			),
			// end of new options
			
			array(
				"title" => "Color",
				"name" => "londres_header_color",
				"type" => "color"
			),
			
			array(
				"title" => "Color Opacity",
				"name" => "londres_header_color_opacity",
				"type" => "slider",
				"std" => "100"
			),
			
			array(
				"title" => "Pattern",
				"name" => "londres_header_pattern",
				"type" => "pattern",
				"options" => $patterns,
				"description" => 'Here you can choose the pattern for your header.'
			),
			
			array(
				"title" => "Custom Pattern",
				"name" => "londres_header_custom_pattern",
				"type" => "mediaupload",
				"description" => 'Here you can choose the custom pattern for your header. It will replace the pattern you choose above.'
			),
			
			array(
				"title" => "Banner Slider",
				"name" => "londres_banner_slider",
				"type" => "select",
				"options" => londres_get_created_camera_sliders()
			),
			
			array(
				"title" => "Page Title Padding",
				"name"=> "londres_page_title_padding",
				"type" => "text",
				"std" => "150px"
			),
			
			array(
				"title"=>"Text Alignment",
				"name" => "londres_header_text_alignment",
				"type" => "select",
				"std" => "center",
				"options" => array(array("id"=>"left", "name"=>"Left"), array("id"=>"center", "name"=>"Center"), array("id"=>"right", "name"=>"Right"), array("id"=>"titlesleftcrumbsright", "name"=>"Left: Titles, Right: Breadcrumbs"), array("id"=>"titlesrightcrumbsleft", "name"=>"Left: Breadcrumbs, Right: Titles"))
			),
			
			array(
				"title" => '<h4>Primary Title Options</h4>',
				"type" => "heading",
				"name" => "primarytitleoptions",
				"std" => "",
				"description" => ""
			),
	
	
			array(
				"title" => "Display Title ?",
				"name" => "londres_hide_pagetitle",
				"type" => "select",
				"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
				"std" => "yes"
			),
			
			array(
				"title" => "Primary Title Font",
				"name" => "londres_header_text_font",
				"type" => "select",
				"options" => londres_fonts_array_builder(),
				"description" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
				"std" => 'Helvetica Neue'
			),
			
			array(
				"title" => "Primary Title Color",
				"name" => "londres_header_text_color",
				"type" => "color",
				"std" => "333333"
			),
			
			array(
				"title" => "Primary Title Size",
				"name" => "londres_header_text_size",
				"type" => "text",
				"std" => "36px"
			),
			
			array(
				"title" => "Primary Title Margin",
				"name" => "londres_header_text_margin_top",
				"type" => "text",
				"std" => "0px"
			),
			
			array(
				"title" => '<h4>Secondary Title Options</h4>',
				"type" => "heading",
				"name" => "secondarytitleoptions",
				"std" => "",
				"description" => ""
			),
			
			array(
				"title" => "Display Secondary Title ?",
				"name" => "londres_hide_sec_pagetitle",
				"type" => "select",
				"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
				"std" => "yes"
			),
			
			array(
				"title" => "Secondary Title Font",
				"name" => "londres_secondary_title_font",
				"type" => "select",
				"options" => londres_fonts_array_builder(),
				"description" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
				"std" => 'Helvetica Neue'
			),
			
			array(
				"title" => "Secondary Title Color",
				"name" => "londres_secondary_title_text_color",
				"type" => "color",
				"std" => "828282"
			),
			
			array(
				"title" => "Secondary Title Size",
				"name" => "londres_secondary_title_text_size",
				"type" => "text",
				"std" => "15px"
			),
	
			array(
				"title" => "Secondary Title Margin",
				"name" => "londres_header_secondary_text_margin_top",
				"type" => "text",
				"std" => "10px"
			),
			
			array(
				"title" => '<h4>Breadcrumbs Options</h4>',
				"type" => "heading",
				"name" => "breadcrumboptions",
				"std" => "",
				"description" => ""
			),
			
			array(
				"title" => "Display Breadcrumbs ?",
				"name" => "londres_enable_breadcrumbs",
				"type" => "select",
				"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
				"std" => "no"
			),
			
			array(
				"title" => "Breadcrumbs Margin Top",
				"name" => "londres_breadcrumbs_margin_top",
				"type" => "text",
				"std" => "10px"
			),
		
		);
		
		/* ------------------------------------------------------------------------*
		 * META BOXES FOR THE TESTIMONIALS POSTS
		 * ------------------------------------------------------------------------*/

		$londres_new_meta_testimonials_boxes =
		array(

			array(
				"title" => "Testimonial Author",
				"name" => "author",
				"std" => "",
				"type" => "text",
				"description" => 'Enter the name of the testimonial author.'
			),
			
			array(
				"title" => "Author HyperLink",
				"name" => "author_link",
				"std" => "",
				"type" => "text",
				"description" => 'Optional author hyperlink.'
			),


			array(
				"title" => "Testimonial Author Company",
				"name" => "company",
				"std" => "",
				"type" => "text",
				"description" => 'Enter the company\'s name of the testimonial author.'
			),

			array(
				"title" => "Company HyperLink",
				"name" => "company_link",
				"std" => "",
				"type" => "text",
				"description" => 'Optional company hyperlink.'
			),
		
		);
		
		/* ------------------------------------------------------------------------*
		 * META BOXES FOR THE PARTNERS POSTS
		 * ------------------------------------------------------------------------*/

		$londres_new_meta_partners_boxes =
		array(

			array(
				"title" => "Partners Hyperlink",
				"name" => "link",
				"std" => "",
				"type" => "text",
				"description" => 'Enter the Hyperlink to your Partner\'s website. Paste the entire URL \'http://\' included.'
			)
		
		);


		/* ------------------------------------------------------------------------*
		 * META BOXES FOR THE TEAM POSTS
		 * ------------------------------------------------------------------------*/

		$londres_new_meta_team_boxes = array();
}

/**
 * Creates a page meta box.
 */
function londres_create_meta_box() {
	if ( function_exists('add_meta_box') ) {
		add_meta_box( 'new-meta-boxes', '<div class="icon-small"></div> '."Londres".' PAGE SETTINGS', 'londres_new_meta_boxes', 'page', 'normal', 'high' );
	}
}

/**
 * Creates a post meta box.
 */
function londres_create_meta_post_box() {
	if ( function_exists('add_meta_box') ) {
		add_meta_box( 'new-meta-post-boxes', '<div class="icon-small"></div> '."Londres".' POST TYPE SETTINGS', 'londres_new_meta_post_boxes', 'post', 'normal', 'high' );
	}
}


/**
 * Creates a post meta box.
 */
function londres_create_meta_portfolio_box() {
	if ( function_exists('add_meta_box') && defined('LONDRES_PORTFOLIO_POST_TYPE')) {
		add_meta_box( 'new-meta-portfolio-boxes', '<div class="icon-small"></div> '."Londres".' PORTFOLIO ITEM SETTINGS', 'londres_new_meta_portfolio_boxes', LONDRES_PORTFOLIO_POST_TYPE, 'normal', 'high' );
	}
}

/**
 * Creates a testimonials meta box.
 */
function londres_create_meta_testimonials_box() {
	if ( function_exists('add_meta_box') && defined('LONDRES_TESTIMONIALS_POST_TYPE')) {
		add_meta_box( 'new-meta-testimonials-boxes', '<div class="icon-small"></div> '."Londres".' TESTIMONIALS ITEM SETTINGS', 'londres_new_meta_testimonials_boxes', LONDRES_TESTIMONIALS_POST_TYPE, 'normal', 'high' );
	}
}

/**
 * Creates a partners meta box.
 */
function londres_create_meta_partners_box() {
	if ( function_exists('add_meta_box') && defined('LONDRES_PARTNERS_POST_TYPE')) {
		add_meta_box( 'new-meta-partners-boxes', '<div class="icon-small"></div> '."Londres".' PARTNERS ITEM SETTINGS', 'londres_new_meta_partners_boxes', LONDRES_PARTNERS_POST_TYPE, 'normal', 'high' );
	}
}

function londres_create_meta_team_box() {
	if ( function_exists('add_meta_box') ) {
		//add_meta_box called somewhere else
	}
}


/**
 * Calls the print method for page meta boxes.
 */
function londres_new_meta_boxes() {
	global $post, $londres_new_meta_boxes;

	foreach($londres_new_meta_boxes as $meta_box) {
		londres_print_meta_box($meta_box, $post);
	}
}

/**
 * Calls the print method for post meta boxes.
 */
function londres_new_meta_post_boxes() {
	global $post, $londres_new_meta_post_boxes;

	foreach($londres_new_meta_post_boxes as $meta_box) {
		londres_print_meta_box($meta_box, $post);
	}
}

/**
 * Calls the print method for portfolio meta boxes.
 */
function londres_new_meta_portfolio_boxes() {
	global $post, $londres_new_meta_portfolio_boxes;

	foreach($londres_new_meta_portfolio_boxes as $meta_box) {
		londres_print_meta_box($meta_box, $post);
	}
}

/**
 * Calls the print method for portfolio meta boxes.
 */
function londres_new_meta_testimonials_boxes() {
	global $post, $londres_new_meta_testimonials_boxes;

	foreach($londres_new_meta_testimonials_boxes as $meta_box) {
		londres_print_meta_box($meta_box, $post);
	}
}

/**
 * Calls the print method for partners meta boxes.
 */
function londres_new_meta_partners_boxes() {
	global $post, $londres_new_meta_partners_boxes;

	foreach($londres_new_meta_partners_boxes as $meta_box) {
		londres_print_meta_box($meta_box, $post);
	}
}

/**
 * Calls the print method for partners meta boxes.
 */
function londres_new_meta_team_boxes() {
	global $post, $londres_new_meta_team_boxes;

	foreach($londres_new_meta_team_boxes as $meta_box) {
		londres_print_meta_box($meta_box, $post);
	}
}

/**
 * Prints the meta box
 * @param $meta_box the meta box to be printed
 * @param $post the post to contain the meta box
 */
function londres_print_meta_box($meta_box, $post){
	
	if (!isset($meta_box['name'])) $meta_box['name'] = "";
	$meta_box_value = get_post_meta($post->ID, $meta_box['name'].'_value', true);

	if($meta_box_value == ""){
		if (isset($meta_box['std']))
			$meta_box_value = $meta_box['std'];
		else $meta_box_value = "";
	}


	switch($meta_box['type']){
		
		case 'slider':
			echo '<div class="option-container">';
			
			echo'<input type="hidden" name="'.esc_attr($meta_box['name']).'_noncename" id="'.esc_attr($meta_box['name']).'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';

			echo'<h4 class="page-option-title">'.wp_kses_post($meta_box['title']).'</h4>';
			
			echo '<div class="slider_container"><div class="slider opacity-slider" id="'.esc_attr($meta_box['name']).'_slider" title="'.esc_attr($meta_box['name']).'_helper_input"></div><input class="option-input slider-input" name="'.esc_attr($meta_box['name']).'_helper_input" id="'.esc_attr($meta_box['name']).'_helper_input" type="text" value="'.esc_attr($meta_box_value).'" /></div>';

			if (isset($meta_box['description']) && $meta_box['description'] != "") echo'<span class="option-description">'.wp_kses_post($meta_box['description']).'</span>';
			
			echo'<input type="text" id="'.esc_attr($meta_box['name']).'_value" name="'.esc_attr($meta_box['name']).'_value" value="'.esc_attr($meta_box_value).'" class="option-input hidden" />';

			echo '</div>';
			
			$londres_admin_inline_script = (isset($londres_admin_inline_script)) ? $londres_admin_inline_script : "";
			$londres_admin_inline_script .= '
				jQuery(document).ready(function(){
					"use strict";
					jQuery("#'.esc_js($meta_box['name']).'_slider").each(function(){
						var value = parseInt(jQuery("#'.esc_js($meta_box['name']).'_value").val(), 10);
						if (typeof jQuery().slider == "function"){
							jQuery(this).slider({
								range: "min",
								value: value,
								min: 0,
								max: 100,
								slide: function( event, ui ) {
									jQuery("#'.esc_js($meta_box['name']).'_helper_input").val(ui.value+"%");
									jQuery("#'.esc_js($meta_box['name']).'_value").val( ui.value + " %" );
								}
							});
						}
					});
				});
			';
			wp_add_inline_script('londres-admin', $londres_admin_inline_script, 'after');
			
		break;
		
		case 'multicheck':
			if (sizeof($meta_box['options'])>1){
				
			}
			static $mcindex = 1;
			echo '<div class="option-container multicheck '.esc_attr($meta_box['name']).'" id="multicheck-'.esc_attr($mcindex).'">';			
			echo'<input type="hidden" name="'.esc_attr($meta_box['name']).'_noncename" id="'.esc_attr($meta_box['name']).'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
			echo'<h4 class="page-option-title '.esc_attr($meta_box['name']).'">'.wp_kses_post($meta_box['title']).'</h4>';
			$metavalues = explode(",", $meta_box_value);
			if (!is_array($metavalues) || empty($metavalues)) $metavalues = array();
			if(sizeof($meta_box['options'])>0){
				if(sizeof($meta_box['options'])>1) echo '<label for="'.esc_attr($meta_box['name']).'_all" class="button">Select All</label>';
				foreach ($meta_box['options'] as $option) { ?>
					<label for="<?php echo esc_attr($meta_box['name']); ?>_<?php echo esc_attr($option['id']); ?>"><input id="<?php echo esc_attr($meta_box['name']); ?>_<?php echo esc_attr($option['id']); ?>" type="checkbox"
					<?php if ( in_array($option['id'], $metavalues) ){
						echo ' checked="checked"';
					}
					?> value="<?php echo esc_attr($option['id']);?>"> <?php echo esc_html($option['name']); ?></label><?php
				}
				$londres_admin_inline_script = (isset($londres_admin_inline_script)) ? $londres_admin_inline_script : "";
				$londres_admin_inline_script .= '
					jQuery(document).ready(function(){
						"use strict";
						var allselected = true;
						for (var i = 0; i < jQuery("#multicheck-'.esc_js($mcindex).' label").not(".button").length; i++){
							if (jQuery("#multicheck-'.esc_js($mcindex).' > label").not(".button").eq(i).children("input").prop("checked") == false) allselected = false;
						}
						if (allselected) jQuery("label[for=\''.esc_js($meta_box['name']).'_all\']").text("Deselect All");
						function update_multicheck_'.esc_js($mcindex).'(){
							var multicheck_value = "";
							jQuery("#multicheck-'.esc_js($mcindex).'.multicheck > label").not(".button").each(function(){
								if (jQuery(this).find("input").is(":checked")) multicheck_value += jQuery(this).find("input").val()+",";
							});
							if (multicheck_value.substr(multicheck_value.length-1) === ",") 
								multicheck_value = multicheck_value.substr(0, multicheck_value.length-1);
							jQuery("#londres-multicheck-'.esc_js($mcindex).'").attr("value",multicheck_value);
							var allselected = true;
							for (var i = 0; i < jQuery("#multicheck-'.esc_js($mcindex).' > label").not(".button").length; i++){
								if (jQuery("#multicheck-'.esc_js($mcindex).' label").not(".button").eq(i).children("input").prop("checked") == false) allselected = false;
							}
							if (allselected) jQuery("label[for=\''.esc_js( $meta_box['name']).'_all\']").text("Deselect All");
							else jQuery("label[for=\''.esc_js($meta_box['name']).'_all\']").text("Select All");
						}
						jQuery("#multicheck-'.esc_js($mcindex).' label[for=\''.esc_js($meta_box['name']).'_all\']").on("click",function(){
							if (jQuery(this).text() === "Select All"){
								jQuery(this).siblings("label").find("input").attr("checked","checked");
								jQuery(this).text("Deselect All"); 
							} else {
								jQuery(this).siblings("label").find("input").attr("checked",false);
								jQuery(this).text("Select All");
							}
						});
						jQuery("#multicheck-'.esc_js($mcindex).' > label").on("click",function(){
							setTimeout(function(){
								update_multicheck_'.esc_js($mcindex).'();
								';
								
								if (isset($meta_box['sortable']) && $meta_box['sortable']){
									$londres_admin_inline_script .= '
									
								upper_multicheck_sortable_'.esc_js($mcindex).'();	
								
									
									';
								}
				$londres_admin_inline_script .= '
							
							}, 100);
						});
					});
				';
				
				
				/* NEW SORTABLE AWESOME FEATURE */
				if (isset($meta_box['sortable']) && $meta_box['sortable']){
					?>
					<h4 class="solid-sortable-h4">Order:</h4>
					<div class="multicheck-sorter" data-rel="londres-multicheck-<?php echo esc_attr($mcindex); ?>">
						<?php
							foreach ($meta_box['options'] as $option) { ?>
								<div name="<?php echo esc_attr($option['id']); ?>" class="multicheck-sorter-item button" for="<?php echo esc_attr($meta_box['name']); ?>_<?php echo esc_attr($option['id']); ?>"><?php echo esc_html($option['name']); ?></div><?php
							}
						?>
					</div>
					<?php
						
					$londres_admin_inline_script .= '
						function upper_multicheck_sortable_'.esc_js($mcindex).'(){
							jQuery(".multicheck-sorter[data-rel=\"londres-multicheck-'.esc_js($mcindex).'\"] .multicheck-sorter-item").removeClass("enable");
							var values = jQuery("#londres-multicheck-'.esc_js($mcindex).'").val().split(",");
							for (var i=0;i<values.length;i++){
								jQuery(".multicheck-sorter-item[for=\"'.esc_js($meta_box['name']).'_"+values[i]+"\"]").addClass("enable");
							}
						}

						jQuery(document).ready(function(){
							"use strict";
							upper_multicheck_sortable_'.esc_js($mcindex).'();
							
							var initialVals = jQuery("#londres-multicheck-'.esc_js($mcindex).'").val();
							if (initialVals != ""){
								initialVals = initialVals.split(",");
								initialVals.reverse();
	
								for (var i=0; i<initialVals.length; i++){
									jQuery(".multicheck-sorter[data-rel=\"londres-multicheck-'.esc_js($mcindex).'\"]").prepend( jQuery(".multicheck-sorter[data-rel=\"londres-multicheck-'.esc_js($mcindex).'\"] .multicheck-sorter-item[for=\"'.esc_js($meta_box['name']).'_"+initialVals[i]+"\"]") );
								}
							}
							
							jQuery(".multicheck-sorter[data-rel=\"londres-multicheck-'.esc_js($mcindex).'\"]").sortable({
								axis: "x",
								stop: function(event,ui){
									var newVal = "";
									jQuery(".multicheck-sorter[data-rel=\"londres-multicheck-'.esc_js($mcindex).'\"] .multicheck-sorter-item.enable").each(function(){
										if (newVal != "") newVal += ",";
										newVal += jQuery(this).attr("name");
									});
									jQuery("#londres-multicheck-'.esc_js($mcindex).'").val(newVal);
								}
							});
						});
					
					';
				}
				wp_add_inline_script('londres-admin', $londres_admin_inline_script, 'after');
				
			} else {
				echo "<br/><h4>You have no Post Categories defined.</h4><br/>";
			}
			echo'<input type="text" name="'.esc_attr($meta_box['name']).'_value" value="'.esc_attr($meta_box_value).'" id="londres-multicheck-'.esc_attr($mcindex).'" class="option-input hidden" />';
			echo '</div>';
			$mcindex++;
		break;
		case 'heading':
			echo'<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix '.esc_attr($meta_box['name']).'">
<h4>'.wp_kses_post($meta_box['title']).'</h4></div>';
			break;
			
		case 'heading_unformatted':
			if (!isset($meta_box['name'])) $meta_box['name'] = "";
			echo'<div class="'.esc_attr($meta_box['name']).'">'.wp_kses_post($meta_box['title']).'</div>';
			break;
			
		case 'text':
			if (!isset($meta_box['extra_class'])) $meta_box['extra_class'] = "";
			echo '<div class="option-container '. esc_attr($meta_box['extra_class']) .'">';
			echo'<input type="hidden" name="'.esc_attr($meta_box['name']).'_noncename" id="'.esc_attr($meta_box['name']).'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';

			echo'<h4 class="page-option-title">'.wp_kses_post($meta_box['title']).'</h4>';

			echo'<input type="text" name="'.esc_attr($meta_box['name']).'_value" value="'.esc_attr($meta_box_value).'" class="option-input"/><br />';
			
			if (!isset($meta_box['description'])) $meta_box['description'] = "";
			echo'<span class="option-description">'.wp_kses_post($meta_box['description']).'</span>';
			echo '</div>';
			break;
			
		case 'color':
			echo '<div class="option-container londres-color-option">';
			echo'<input type="hidden" name="'.esc_attr($meta_box['name']).'_noncename" id="'.esc_attr($meta_box['name']).'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';

			echo'<h4 class="page-option-title">'.wp_kses_post($meta_box['title']).'</h4>';

			echo'<label>#</label><input type="text" style'.'="background:#'.esc_attr($meta_box_value).';" id="'.esc_attr($meta_box['name']).'" name="'.esc_attr($meta_box['name']).'_value" value="'.esc_attr($meta_box_value).'" class="option-input"/><br />';

			if (!isset($meta_box['description'])) $meta_box['description'] = "";
			echo'<span class="option-description">'.wp_kses_post($meta_box['description']).'</span>';
			echo '</div>';
			
			$londres_admin_inline_script = (isset($londres_admin_inline_script)) ? $londres_admin_inline_script : "";
			$londres_admin_inline_script .= '
				jQuery(document).ready(function(){
					"use strict";
					
					jQuery("#'.esc_js($meta_box['name']).'").ColorPicker({
						onSubmit: function(hsb, hex, rgb, el) {
							jQuery(el).val(hex);
							jQuery(el).css("background", "#"+hex);
							jQuery(el).ColorPickerHide();
						},
						onBeforeShow: function () {
							jQuery(this).ColorPickerSetColor(this.value);
						},
						onHide: function (colpkr) {
							jQuery(colpkr).fadeOut(500);
							return false;
						}
					})
					.on("keyup", function(){
						jQuery(this).ColorPickerSetColor(this.value);
					});
				});
			';
			wp_add_inline_script('londres-admin', $londres_admin_inline_script, 'after'); 
			break;
		case 'upload':
			echo '<div class="option-container">';
			echo'<input type="hidden" name="'.esc_attr($meta_box['name']).'_noncename" id="'.esc_attr($meta_box['name']).'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';

			echo'<h4 class="page-option-title">'.wp_kses_post($meta_box['title']).'</h4>';

			echo'<input type="text" name="'.esc_attr($meta_box['name']).'_value" value="'.esc_attr($meta_box_value).'" id="londres-'.esc_attr($meta_box['name']).'" class="option-input upload"/>';

			echo '<div id="londres-'.esc_attr($meta_box['name']).'_button" class="upload-button upload-logo" ><a class="button button-upload"><span>Upload</span></a></div><br/>';

			$londres_admin_inline_script = (isset($londres_admin_inline_script)) ? $londres_admin_inline_script : "";
			$londres_admin_inline_script .= '
				jQuery(document).ready(function(){
					"use strict";
					londresOptions.loadUploader(jQuery("div#londres-'.esc_js($meta_box['name']).'_button"), "'.LONDRES_UTILS_URL.'upload-handler.php", "'.LONDRES_UPLOADS_URL.'");
				});
			';
			
			echo '<ul><li><img src="' . esc_url($meta_box_value) . '" width="200px"></li></ul>';
				
			echo'<span class="option-description">'.wp_kses_post($meta_box['description']).'</span>';
			echo '</div>';
			break;
			
		case 'textarea':
			echo '<div class="option-container">';
			echo'<input type="hidden" name="'.esc_attr($meta_box['name']).'_noncename" id="'.esc_attr($meta_box['name']).'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';

			echo'<h4 class="page-option-title">'.wp_kses_post($meta_box['title']).'</h4>';
			
			$output = wp_kses_no_null( $meta_box_value, array( 'slash_zero' => 'keep' ) );
			$output = wp_kses_normalize_entities($output);

			echo'<textarea name="'.esc_attr($meta_box['name']).'_value" class="option-textarea">'.wp_kses_hook($output, 'post', array()).'</textarea><br />';

			if (!isset($meta_box['description'])) $meta_box['description'] = "";
			echo'<span class="option-description">'.wp_kses_post($meta_box['description']).'</span>';
			echo '</div>';
		break;
		case 'select':
			echo '<div class="option-container'; 
			if ($meta_box['name'] == 'londres_enable_custom_header_options' || $meta_box['name'] == 'londres_enable_custom_pagetitle_options') echo ' londres_folding_options ';
			echo '">';
			echo'<input type="hidden" name="'.esc_attr($meta_box['name']).'_noncename" id="'.esc_attr($meta_box['name']).'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';

			echo'<h4 class="page-option-title">'.wp_kses_post($meta_box['title']).'</h4>';
			echo '<select name="'.esc_attr($meta_box['name']).'_value" id="'.esc_attr($meta_box['name']).'_value">';

				
			if(sizeof($meta_box['options'])>0){
				foreach ($meta_box['options'] as $option) { 
					if (isset($option['id'])){
				?>
					<option
					<?php if ( $meta_box_value == $option['id']) {
						echo ' selected="selected"';
					}
					if ($option['id']=='disabled') {
						echo ' disabled="disabled"';
					}
					
					if (isset($option['class'])){
						if ($option['class']!=null) {
							echo ' class="'.$option['class'].'"';
						}
					}
					?>
						value="<?php echo esc_attr($option['id']);?>"><?php echo esc_html($option['name']); ?></option>
					<?php
					}

				}
			}
			echo '</select>';
			if (isset($meta_box['description']))
				echo'<span class="option-description">'.wp_kses_post($meta_box['description']).'</span>';
			echo '</div>';
		break;
			
		case 'selectHomeStyle':
			echo '<div class="option-container">';
			echo'<input type="hidden" name="'.esc_attr($meta_box['name']).'_noncename" id="'.esc_attr($meta_box['name']).'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';

			echo'<h4 class="page-option-title">'.wp_kses_post($meta_box['title']).'</h4>';
			echo '<div hidden class="temppath upper_hidden">'.esc_url(get_template_directory_uri()).'</div>';
			echo '<select name="'.esc_attr($meta_box['name']).'_value" id="'.esc_attr($meta_box['name']).'_value">';


			if(sizeof($meta_box['options'])>0){
				foreach ($meta_box['options'] as $option) { 
				?> 
				<option
					<?php if ( $meta_box_value == $option['id']) {
						echo ' selected="selected"';
					}
					if ($option['id']=='disabled') {
						echo ' disabled="disabled"';
					}

					if (isset($option['class'])){
						if ($option['class']!=null) {
							echo ' class="'.esc_attr($option['class']).'"';
						}
					}
					?>
						value="<?php echo esc_attr($option['id']);?>"><?php echo esc_html($option['name']); ?></option>
					<?php

				}
			}
			echo '</select>';
			if (isset($meta_box['description']))
				echo'<span class="option-description">'.wp_kses_post($meta_box['description']).'</span>';
			echo '</div>';
		break;
			
		case 'textarea':
			echo '<div class="option-container">';
			echo'<input type="hidden" name="'.esc_attr($meta_box['name']).'_noncename" id="'.esc_attr($meta_box['name']).'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';

			echo'<h4 class="page-option-title">'.wp_kses_post($meta_box['title']).'</h4>';

			echo'<textarea name="'.esc_attr($meta_box['name']).'_value" class="option-textarea" />'.wp_kses_post($meta_box_value).'</textarea><br />';

			echo'<span class="option-description">'.wp_kses_post($meta_box['description']).'</span>';
			echo '</div>';
		break;	
		
		
		
		
		
		case 'pattern':
			echo '<div class="option-container patterns">';
			echo'<input type="hidden" name="'.esc_attr($meta_box['name']).'_noncename" id="'.esc_attr($meta_box['name']).'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';

			echo'<h4 class="page-option-title">'.wp_kses_post($meta_box['title']).'</h4>';
			
			echo '<select hidden class="upper_hidden" name="'.esc_attr($meta_box['name']).'_value" id="'.esc_attr($meta_box['name']).'_value">';
			if(sizeof($meta_box['options'])>0){
				foreach ($meta_box['options'] as $option) { 
				?> <option
					<?php if ( $meta_box_value == $option['id']) {
						echo ' selected="selected"';
					}
					if ($option['id']=='disabled') {
						echo ' disabled="disabled"';
					}
					
					if (isset($option['class'])){
						if ($option['class']!=null) {
							echo ' class="'.esc_attr($option['class']).'"';
						}
					}
					?>
						value="<?php echo esc_attr($option['id']);?>"><?php echo esc_html($option['name']); ?></option>
					<?php

				}
			} 
			echo '</select>';
			
			echo '<div class="patterns_list" name="'.esc_attr($meta_box['name']).'_value" id="'.esc_attr($meta_box['name']).'_value">';
			if(sizeof($meta_box['options'])>0){
				foreach ($meta_box['options'] as $option) { 
					if ($option['name'] != "none"){
						?> <div onclick="jQuery(this).addClass('selected').siblings().removeClass('selected');jQuery(this).parent().siblings('select').val('<?php echo esc_js($option['id']); ?>');" <?php echo ' style'.'="background-image:url('.esc_url(get_template_directory_uri()).'/images/londres_patterns/'.esc_attr($option['name']).');" '; ?> class="pattern_item
						<?php if ( $meta_box_value == $option['id']) {
							echo ' selected';
						}
						echo '"';
						?>
							value="<?php echo esc_attr($option['id']);?>"></div>
						<?php	
					}
				}
			} 
			echo '</div>';
			
			if (isset($meta_box['description']))
				echo'<span class="option-description">'.wp_kses_post($meta_box['description']).'</span>';
			echo '</div>';
		break;
			
			
		
		case 'mediaupload':
		
			static $muindex = 1;
		
			echo '<div class="option-container mediauploader-simple mediauploader-'.esc_attr($muindex).'">';
			?>
			<h4 class="page-option-title"><?php echo wp_kses_post($meta_box['title']); ?></h4>
			<div class="description margin-bottom-10px <?php echo esc_attr($meta_box['name']); ?>">
				<strong>Notice:</strong> The Preview Image will be the Image set as Featured Image.
			</div>
			<?php echo '<input type="hidden" name="'.esc_attr($meta_box['name']).'_noncename" id="'.esc_attr($meta_box['name']).'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />'; ?>
			<div class="thumb_slides_container"></div>
			<div class="uploader">
			  <textarea hidden class="upper_hidden" type="textarea" name="<?php echo esc_attr($meta_box['name'])."_value" ?>" id="_slider_images-<?php echo esc_attr($muindex); ?>"><?php echo wp_kses_post($meta_box_value); ?></textarea>
			  <input class="button buttonUploader text-align-center" name="_slider_images-<?php echo esc_attr($muindex); ?>_button" id="_slider_images-<?php echo esc_attr($muindex); ?>_button" value="Insert Images" />
			</div>
			
			<?php
				$londres_admin_inline_script = (isset($londres_admin_inline_script)) ? $londres_admin_inline_script : "";
				$londres_admin_inline_script .= '
					jQuery(document).ready(function(){
						"use strict";
						var _custom_media = true,
							_orig_send_attachment = wp.media.editor.send.attachment;

						var thumbs = jQuery(".mediauploader-'.esc_js($muindex).' #_slider_images-'.esc_js($muindex).'").val().split("|*|");
						for (var i = 0; i < thumbs.length; i++){
							if (thumbs[i] != ""){
								var url = thumbs[i].split("|!|")[1];
								var id = thumbs[i].split("|!|")[0];
								jQuery(".mediauploader-'.esc_js($muindex).' .thumb_slides_container").append("<div class=\'thumb_cont elem-"+id+"\' ><img src=\'"+url+"\' /><a href=\'post.php?post="+id+"&action=edit\' title=\'Edit Image\' class=\'editImage\' target=\'_blank\'></a><a title=\'Delete Image\' class=\'removeImage\' onclick=\'jQuery(this).parent(\".thumb_cont\").remove(); var newVal = jQuery(\"#_slider_images-'.esc_js($muindex).'\").val(); newVal = newVal.replace(\""+id+"|!|"+url+"|*|\", \"\"); jQuery(\"#_slider_images-'.esc_js($muindex).'\").val(newVal);\' ></a></div>");
							}
						}
						
						jQuery(".mediauploader-'.esc_js($muindex).' .thumb_slides_container").sortable({
							placeholder: ".mediauploader-'.esc_js($muindex).' .thumb_slides_container",
							dropOnEmpty: true,
							forceHelperSize: true,
							appendTo: "parent",
							start: function(event,ui){
								ui.item.css({
									"transition": "none",
									"-webkit-transition": "none",
									"-moz-transition": "none",
									"-ms-transition": "none",
									"-o-transition": "none"
								});
							},
							stop: function(event,ui){
								var newVal = "";
								jQuery(".mediauploader-'.esc_js($muindex).' .thumb_slides_container .thumb_cont").each(function(){
									newVal += jQuery(this).attr("class").split("thumb_cont elem-")[1] + "|!|" + jQuery(this).find("img").attr("src") + "|*|";
								});
								jQuery(".mediauploader-'.esc_js($muindex).' #_slider_images-'.esc_js($muindex).'").val(newVal);
							}
						});
						
						
						jQuery(".mediauploader-'.esc_js($muindex).' .buttonUploader").on("click",function(e) {
							e.stopPropagation();
							e.preventDefault();
							var send_attachment_bkp = wp.media.editor.send.attachment;
							var button = jQuery(this);
							var id = button.attr("id").replace("_button", "");
							_custom_media = true;
							wp.media.editor.send.attachment = function(props, attachment){
								jQuery(".mediauploader-'.esc_js($muindex).' .thumb_slides_container").append("<div class=\'thumb_cont elem-"+attachment.id+"\' ><img src=\'"+attachment.url+"\' /><a href=\'post.php?post="+attachment.id+"&action=edit\' title=\'Edit Image\' class=\'editImage\' target=\'_blank\'></a><a title=\'Delete Image\' class=\'removeImage\' onclick=\'jQuery(this).parent(\".thumb_cont\").remove(); var newVal = jQuery(\"#_slider_images\").val(); newVal = newVal.replace(\""+attachment.id+"|!|"+attachment.url+"|*|\", \"\"); jQuery(\"#_slider_images\").val(newVal);\' ></a></div>");
								if ( _custom_media ) {
									jQuery(".mediauploader-'.esc_js($muindex).' #"+id).val(jQuery(".mediauploader-'.esc_js($muindex).' #"+id).val() + attachment.id + "|!|" + attachment.url + "|*|");
								} else {
									return _orig_send_attachment.apply( this, [props, attachment] );
								};
							}
						
							wp.media.editor.open(button);
							return false;
						});
						
						jQuery(".mediauploader-'.esc_js($muindex).' .add_media").on("click", function(){
							_custom_media = false;
						});
					});
				';
				wp_add_inline_script('londres-admin', $londres_admin_inline_script, 'after');
				
				$muindex++;
			echo "</div>";
			break;
			
		case 'mediaupload_standard':
		
			static $muindex = 1;
		
			echo '<div class="option-container mediauploader-standard mediauploader-'.esc_attr($muindex).'">';
			?>
			<h4 class="page-option-title"><?php echo wp_kses_post($meta_box['title']); ?></h4>
			<?php echo '<input type="hidden" name="'.esc_attr($meta_box['name']).'_noncename" id="'.esc_attr($meta_box['name']).'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />'; ?>
			<div class="thumb_slides_container"></div>
			<div class="uploader">
			  <textarea hidden class="upper_hidden" type="textarea" name="<?php echo esc_attr($meta_box['name'])."_value" ?>" id="_slider_images-<?php echo esc_attr($muindex); ?>"><?php echo wp_kses_post($meta_box_value); ?></textarea>
			  <input type="button" class="button buttonUploader text-align-center" name="_slider_images-<?php echo esc_attr($muindex); ?>_button" id="_slider_images-<?php echo esc_attr($muindex); ?>_button" value="Insert Images" />
			</div>
			<?php
				if (isset($meta_box['description']) && $meta_box['description'] != ""){
					?>
			<span class="option-description"><?php echo esc_html($meta_box['description']); ?></span>
					<?php
				}
			?>
			<?php
				$londres_admin_inline_script = (isset($londres_admin_inline_script)) ? $londres_admin_inline_script : "";
				$londres_admin_inline_script .= '
					jQuery(document).ready(function(){
						"use strict";
						var _custom_media = true,
							_orig_send_attachment = wp.media.editor.send.attachment;

						var thumbs = jQuery(".mediauploader-'.esc_js($muindex).' #_slider_images-'.esc_js($muindex).'").val().split("|*|");
						for (var i = 0; i < thumbs.length; i++){
							if (thumbs[i] != ""){
								var url = thumbs[i].split("|!|")[1];
								var id = thumbs[i].split("|!|")[0];
								jQuery(".mediauploader-'.esc_js($muindex).' .thumb_slides_container").append("<div class=\'thumb_cont elem-"+id+"\' ><img src=\'"+url+"\' /><a href=\'post.php?post="+id+"&action=edit\' title=\'Edit Image\' class=\'editImage\' target=\'_blank\'></a><a title=\'Delete Image\' class=\'removeImage\' onclick=\'jQuery(this).parent(\".thumb_cont\").remove(); var newVal = jQuery(\"#_slider_images-'.esc_js($muindex).'\").val(); newVal = newVal.replace(\""+id+"|!|"+url+"|*|\", \"\"); jQuery(\"#_slider_images-'.esc_js($muindex).'\").val(newVal);\' ></a></div>");
							}
						}
						
						jQuery(".mediauploader-'.esc_js($muindex).' .buttonUploader").on("click",function(e) {
							var button = jQuery(this);
							var id = button.attr("id").replace("_button", "");
							var custom_uploader = wp.media({
								title: "Select Media",
								button: {
									text: "Select Media"
								},
								multiple: false
							})
							.on("select", function() {
								var attachment = custom_uploader.state().get("selection").first().toJSON();
								if (attachment){
									jQuery(".mediauploader-'.esc_js($muindex).' .thumb_slides_container").html("");
									jQuery(".mediauploader-'.esc_js($muindex).' .thumb_slides_container").append("<div class=\'thumb_cont elem-"+attachment.id+"\' ><img src=\'"+attachment.url+"\' /><a href=\'post.php?post="+attachment.id+"&action=edit\' title=\'Edit Image\' class=\'editImage\' target=\'_blank\'></a><a title=\'Delete Image\' class=\'removeImage\' onclick=\'jQuery(this).parent(\".thumb_cont\").remove(); var newVal = jQuery(\"#_logo_intro_images\").val(); newVal = newVal.replace(\""+attachment.id+"|!|"+attachment.url+"|*|\", \"\"); jQuery(\"#_logo_intro_images\").val(newVal);\' ></a></div>");
								}
								jQuery("#"+id).val(attachment.id + "|!|" + attachment.url + "|!|" + attachment.type);
							})
							.open(button);
							return false;
						});
					});
				';
				wp_add_inline_script('londres-admin', $londres_admin_inline_script, 'after');
				
				$muindex++;
			echo "</div>";
			break;
		
		case 'mediauploadHome':

			echo '<div class="option-container mediauploadHome">';
			?>
			<h4 class="page-option-title"><?php echo wp_kses_post($meta_box['title']); ?></h4>

			<?php echo '<input type="hidden" name="'.esc_attr($meta_box['name']).'_noncename" id="'.esc_attr($meta_box['name']).'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />'; ?>
			<div class="thumb_slides_container"></div>
			
			<div class="uploader" >
			  <textarea hidden class="upper_hidden" type="textarea" name="<?php echo esc_attr($meta_box['name'])."_value" ?>" id="_slider_images" ><?php echo wp_kses_post($meta_box_value); ?></textarea>
			  <input class="button buttonUploader text-align-center" name="_slider_images_button" id="_slider_images_button" value="Select Media" />
			</div>

			<?php
				$londres_admin_inline_script = (isset($londres_admin_inline_script)) ? $londres_admin_inline_script : "";
				$londres_admin_inline_script .= '
					jQuery(document).ready(function(){
						"use strict";
						var _custom_media = true,
							_orig_send_attachment = wp.media.editor.send.attachment;

						var thumbs = jQuery("#_slider_images").val().split("|*|");
						for (var i = 0; i < thumbs.length; i++){
							if (thumbs[i] != ""){
								var id = thumbs[i].split("|!|")[0];
								var url = thumbs[i].split("|!|")[1];
								var type = thumbs[i].split("|!|")[2];
								if (type === "video"){
									jQuery(".thumb_slides_container").addClass("thumb_slides_container_video").append("<div class=\'thumb_cont elem-"+id+"\' ><video controls><source src=\'"+url+"\' ></video><a href=\'post.php?post="+id+"&action=edit\' title=\'Edit Image\' class=\'editImage\' target=\'_blank\'></a><a title=\'Delete Image\' class=\'removeImage\' onclick=\'jQuery(this).parent(\".thumb_cont\").remove(); var newVal = jQuery(\"#_slider_images\").val(); newVal = newVal.replace(\""+id+"|!|"+url+"|*|\", \"\"); jQuery(\"#_slider_images\").val(newVal);\' ></a></div>");
								} else {
									jQuery(".thumb_slides_container").append("<div class=\'thumb_cont elem-"+id+"\' ><img src=\'"+url+"\' /><a href=\'post.php?post="+id+"&action=edit\' title=\'Edit Image\' class=\'editImage\' target=\'_blank\'></a><a title=\'Delete Image\' class=\'removeImage\' onclick=\'jQuery(this).parent(\".thumb_cont\").remove(); var newVal = jQuery(\"#_slider_images\").val(); newVal = newVal.replace(\""+id+"|!|"+url+"|*|\", \"\"); jQuery(\"#_slider_images\").val(newVal);\' ></a></div>");
								}
							}
						}
	
						jQuery(".mediauploadHome .buttonUploader").on("click",function(e) {
							var button = jQuery(this);
							var id = button.attr("id").replace("_button", "");
							var custom_uploader = wp.media({
								title: "Select Media",
								button: {
									text: "Select Media"
								},
								multiple: (jQuery("#homeStyle_value").val() === "video") ? true : false
							})
							.on("select", function() {
								var attachment = custom_uploader.state().get("selection").first().toJSON();
								var totalAttach = custom_uploader.state().get("selection").toJSON();
								if (attachment){
									jQuery(".thumb_slides_container").html("");
									if (attachment.type === "video"){
										jQuery(".thumb_slides_container").addClass("thumb_slides_container_video");
										var output = "<div class=\'thumb_cont elem-"+attachment.id+"\' ><video controls>";
										for (var i=0; i < totalAttach.length; i++){
											output += "<source src=\'"+totalAttach[i].url+"\' type=\'video/"+totalAttach[i].url.split(".").pop()+"\'>";
										}
										output += "</video><a href=\'post.php?post="+attachment.id+"&action=edit\' title=\'Edit Image\' class=\'editImage\' target=\'_blank\'></a><a title=\'Delete Image\' class=\'removeImage\' onclick=\'jQuery(this).parent(\".thumb_cont\").remove(); var newVal = jQuery(\"#_slider_images\").val(); newVal = newVal.replace(\""+attachment.id+"|!|"+attachment.url+"|*|\", \"\"); jQuery(\"#_slider_images\").val(newVal);\' ></a></div>";
										jQuery(".thumb_slides_container").append(output);
									} else {
										jQuery(".thumb_slides_container").append("<div class=\'thumb_cont elem-"+attachment.id+"\' ><img src=\'"+attachment.url+"\' /><a href=\'post.php?post="+attachment.id+"&action=edit\' title=\'Edit Image\' class=\'editImage\' target=\'_blank\'></a><a title=\'Delete Image\' class=\'removeImage\' onclick=\'jQuery(this).parent(\".thumb_cont\").remove(); var newVal = jQuery(\"#_slider_images\").val(); newVal = newVal.replace(\""+attachment.id+"|!|"+attachment.url+"|*|\", \"\"); jQuery(\"#_slider_images\").val(newVal);\' ></a></div>");
									}
								}
								if (totalAttach.length > 1){
									var newVal = "";
									for (var i=0; i < totalAttach.length; i++){
										newVal += totalAttach[i].id + "|!|" + totalAttach[i].url + "|!|" + totalAttach[i].type + "|*|";
									}
									jQuery("#"+id).val(newVal);
								} else jQuery("#"+id).val(attachment.id + "|!|" + attachment.url + "|!|" + attachment.type);
							})
							.open(button);
							return false;
						});
					});
				';
				wp_add_inline_script('londres-admin', $londres_admin_inline_script, 'after');
			?>
			</div>
			<?php
			break;
			
			case 'mediauploadHome_video':

				echo '<div class="option-container mediauploader-video">';
				?>
				<h4 class="page-option-title"><?php echo wp_kses_post($meta_box['title']); ?></h4>

				<?php echo '<input type="hidden" name="'.esc_attr($meta_box['name']).'_noncename" id="'.esc_attr($meta_box['name']).'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />'; ?>
				<div class="thumb_slides_container_video" ></div>

				<div class="uploader" >
				  <textarea hidden class="upper_hidden" type="textarea" name="<?php echo esc_attr($meta_box['name'])."_value" ?>" id="_slider_video" ><?php echo wp_kses_post($meta_box_value); ?></textarea>
					<span class="option-description videoHelper width-100-pc">In case you choose video from the Media Library, you can select them in multiple formats so it will be available cross browser.</span>
				  <input class="button buttonUploader_video text-align-center" name="_slider_video_button" id="_slider_video_button" value="Select Media" />
				</div>
				<?php
					$londres_admin_inline_script = (isset($londres_admin_inline_script)) ? $londres_admin_inline_script : "";
					$londres_admin_inline_script .= '
						jQuery(document).ready(function(){
							"use strict";
							var _custom_media = true,
								_orig_send_attachment = wp.media.editor.send.attachment;
	
							var thumbs = jQuery("#_slider_video").val().split("|*|");
							for (var i = 0; i < thumbs.length; i++){
								if (thumbs[i] != ""){
									var id = thumbs[i].split("|!|")[0];
									var url = thumbs[i].split("|!|")[1];
									var type = thumbs[i].split("|!|")[2];
									var output = "<div class=\'thumb_cont elem-"+id+"\'><video controls>";
									if (type === "video"){
										output += "<source src=\'"+url+"\'";
									}
									output += "</video><a href=\'post.php?post="+id+"&action=edit\' title=\'Edit Image\' class=\'editImage\' target=\'_blank\'></a><a title=\'Delete Image\' class=\'removeImage\' onclick=\'jQuery(this).parent(\".thumb_cont\").remove(); var newVal = jQuery(\"#_slider_video\").val(); newVal = newVal.replace(\""+id+"|!|"+url+"|*|\", \"\"); jQuery(\"#_slider_video\").val(newVal);\' ></a></div>";
								}
							}
							
							jQuery(".thumb_slides_container_video").append(output);
						
							jQuery(".buttonUploader_video").on("click",function(e) {
								var button = jQuery(this);
								var id = button.attr("id").replace("_button", "");
								var custom_uploader = wp.media({
									title: "Select Media",
									button: {
										text: "Select Media"
									},
									multiple: true,
									library: { type: "video" }
								})
								.on("select", function() {
									var attachment = custom_uploader.state().get("selection").first().toJSON();
									var totalAttach = custom_uploader.state().get("selection").toJSON();
									if (attachment){
										jQuery(".thumb_slides_container_video").html("");
										if (attachment.type === "video"){
											var output = "<div class=\'thumb_cont elem-"+attachment.id+"\' ><video controls>";
											for (var i=0; i < totalAttach.length; i++){
												output += "<source src=\'"+totalAttach[i].url+"\' type=\'video/"+totalAttach[i].url.split(".").pop()+"\'>";
											}
											output += "</video><a href=\'post.php?post="+attachment.id+"&action=edit\' title=\'Edit Image\' class=\'editImage\' target=\'_blank\'></a><a title=\'Delete Image\' class=\'removeImage\' onclick=\'jQuery(this).parent(\".thumb_cont\").remove(); var newVal = jQuery(\"#_slider_video\").val(); newVal = newVal.replace(\""+attachment.id+"|!|"+attachment.url+"|*|\", \"\"); jQuery(\"#_slider_video\").val(newVal);\' ></a></div>";
											jQuery(".thumb_slides_container_video").append(output);
										}
									}
									if (totalAttach.length > 1){
										var newVal = "";
										for (var i=0; i < totalAttach.length; i++){
											newVal += totalAttach[i].id + "|!|" + totalAttach[i].url + "|!|" + totalAttach[i].type + "|*|";
										}
										jQuery("#"+id).val(newVal);
									} else jQuery("#"+id).val(attachment.id + "|!|" + attachment.url + "|!|" + attachment.type);
								})
								.open(button);
								return false;
							});
						});
					';
					wp_add_inline_script('londres-admin', $londres_admin_inline_script, 'after');
				?>
				</div>
				<?php
				break;
				
		case 'mediaupload_audio':

			echo '<div class="option-container">';
			?>
			<h4 class="page-option-title"><?php echo esc_attr($meta_box['title']); ?></h4>

			<?php echo '<input type="hidden" name="'.esc_attr($meta_box['name']).'_noncename" id="'.esc_attr($meta_box['name']).'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />'; ?>
			<div class="thumb_slides_container_audio"></div>

			<div class="uploader uploader-audio" >
			  <textarea hidden class="upper_hidden" type="textarea" name="<?php echo esc_attr($meta_box['name'])."_value" ?>" id="_slider_audio"><?php echo wp_kses_post($meta_box_value); ?></textarea>
			  <input class="button buttonUploader_audio text-align-center" name="_slider_audio_button" id="_slider_audio_button" value="Select Media" />
			</div>
			<?php
				$londres_admin_inline_script = (isset($londres_admin_inline_script)) ? $londres_admin_inline_script : "";
				$londres_admin_inline_script .= '
					jQuery(document).ready(function(){
						"use strict";
						var _custom_media = true,
							_orig_send_attachment = wp.media.editor.send.attachment;

						var thumbs = jQuery("#_slider_audio").val().split("|*|");
						for (var i = 0; i < thumbs.length; i++){
							if (thumbs[i] != ""){
								var id = thumbs[i].split("|!|")[0];
								var url = thumbs[i].split("|!|")[1];
								var type = thumbs[i].split("|!|")[2];
								var output = "<div class=\'thumb_cont elem-"+id+"\' ><audio controls>";
								if (type === "audio"){
									output += "<source src=\'"+url+"\'";
								}
								output += "</audio><a href=\'post.php?post="+id+"&action=edit\' title=\'Edit Image\' class=\'editImage\' target=\'_blank\'></a><a title=\'Delete Image\' class=\'removeImage\' onclick=\'jQuery(this).parent(\".thumb_cont\").remove(); var newVal = jQuery(\"#_slider_audio\").val(); newVal = newVal.replace(\""+id+"|!|"+url+"|*|\", \"\"); jQuery(\"#_slider_audio\").val(newVal);\' ></a></div>";
							}
						}
						jQuery(".thumb_slides_container_audio").append(output);
					
						jQuery(".buttonUploader_audio").on("click",function(e) {
							var button = jQuery(this);
							var id = button.attr("id").replace("_button", "");
							var custom_uploader = wp.media({
								title: "Select Media",
								button: {
									text: "Select Audio File"
								},
								multiple: true,
								library : { type : "audio"}
							})
							.on("select", function() {
								var attachment = custom_uploader.state().get("selection").first().toJSON();
								var totalAttach = custom_uploader.state().get("selection").toJSON();
								if (attachment){
									jQuery(".thumb_slides_container_audio").html("");
									if (attachment.type === "audio"){
										var output = "<div class=\'thumb_cont elem-"+attachment.id+"\' ><audio controls>"; 
										for (var i=0; i < totalAttach.length; i++){
											output += "<source src=\'"+totalAttach[i].url+"\' type=\'audio/"+totalAttach[i].url.split(".").pop()+"\'>";
										}
										output += "</audio><a href=\'post.php?post="+attachment.id+"&action=edit\' title=\'Edit Image\' class=\'editImage\' target=\'_blank\'></a><a title=\'Delete Image\' class=\'removeImage\' onclick=\'jQuery(this).parent(\".thumb_cont\").remove(); var newVal = jQuery(\"#_slider_audio\").val(); newVal = newVal.replace(\""+attachment.id+"|!|"+attachment.url+"|*|\", \"\"); jQuery(\"#_slider_audio\").val(newVal);\' ></a></div>";
										jQuery(".thumb_slides_container_audio").append(output);
									}
								}
								if (totalAttach.length > 1){
									var newVal = "";
									for (var i=0; i < totalAttach.length; i++){
										newVal += totalAttach[i].id + "|!|" + totalAttach[i].url + "|!|" + totalAttach[i].type + "|*|";
									}
									jQuery("#"+id).val(newVal);
								} else jQuery("#"+id).val(attachment.id + "|!|" + attachment.url + "|!|" + attachment.type);
							})
							.open(button);
							return false;
						});
					});
				';
				wp_add_inline_script('londres-admin', $londres_admin_inline_script, 'after');
			?>
			</div>
			<?php
		break;
				

		case "introLogoUpload":
			echo '<div class="option-container">';
			?>
			<h4 class="page-option-title"><?php echo wp_kses_post($meta_box['title']); ?></h4>

			<?php echo '<input type="hidden" name="'.esc_attr($meta_box['name']).'_noncename" id="'.esc_attr($meta_box['name']).'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />'; ?>
			<div class="logo_intro_container"></div>
			<div class="uploader">
				<textarea hidden class="upper_hidden" type="textarea" name="<?php echo esc_attr($meta_box['name'])."_value" ?>" id="_logo_intro_images" ><?php echo wp_kses_post($meta_box_value); ?></textarea>
				<input class="button logoUploader text-align-center" name="_logo_intro_images_button" id="_logo_intro_images_button" value="Select Media" />
			</div>
			
			<?php
				$londres_admin_inline_script = (isset($londres_admin_inline_script)) ? $londres_admin_inline_script : "";
				$londres_admin_inline_script .= '
					jQuery(document).ready(function(){
						"use strict";
						var _custom_media = true,
							_orig_send_attachment = wp.media.editor.send.attachment;
	
						var thumbs = jQuery("#_logo_intro_images").val().split("|*|");
						for (var i = 0; i < thumbs.length; i++){
							if (thumbs[i] != ""){
								var id = thumbs[i].split("|!|")[0];
								var url = thumbs[i].split("|!|")[1];
								var type = thumbs[i].split("|!|")[2];
								jQuery(".logo_intro_container").append("<div class=\'thumb_cont elem-"+id+"\' ><img src=\'"+url+"\' /><a href=\'post.php?post="+id+"&action=edit\' title=\'Edit Image\' class=\'editImage\' target=\'_blank\'></a><a title=\'Delete Image\' class=\'removeImage\' onclick=\'jQuery(this).parent(\".thumb_cont\").remove(); var newVal = jQuery(\"#_logo_intro_images\").val(); newVal = newVal.replace(\""+id+"|!|"+url+"|*|\", \"\"); jQuery(\"#_logo_intro_images\").val(newVal);\' ></a></div>");
							}
						}
	
						jQuery(".logoUploader").on("click",function(e) {
							var button = jQuery(this);
							var id = button.attr("id").replace("_button", "");
							var custom_uploader = wp.media({
								title: "Select Media",
								button: {
									text: "Select Media"
								},
								multiple: false
							})
							.on("select", function() {
								var attachment = custom_uploader.state().get("selection").first().toJSON();
								if (attachment){
									jQuery(".logo_intro_container").html("");
									jQuery(".logo_intro_container").append("<div class=\'thumb_cont elem-"+attachment.id+"\' ><img src=\'"+attachment.url+"\' /><a href=\'post.php?post="+attachment.id+"&action=edit\' title=\'Edit Image\' class=\'editImage\' target=\'_blank\'></a><a title=\'Delete Image\' class=\'removeImage\' onclick=\'jQuery(this).parent(\".thumb_cont\").remove(); var newVal = jQuery(\"#_logo_intro_images\").val(); newVal = newVal.replace(\""+attachment.id+"|!|"+attachment.url+"|*|\", \"\"); jQuery(\"#_logo_intro_images\").val(newVal);\' ></a></div>");
								}
								jQuery("#"+id).val(attachment.id + "|!|" + attachment.url + "|!|" + attachment.type);
							})
							.open(button);
							return false;
						});
					});
				';
				wp_add_inline_script('londres-admin', $londres_admin_inline_script, 'after');
			?>
			</div>
			<?php
		break;
		
		case "opacity_slider":
			echo '<div class="option-container">';
			
			echo'<input type="hidden" name="'.esc_attr($meta_box['name']).'_noncename" id="'.esc_attr($meta_box['name']).'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';


			echo'<h4 class="page-option-title">'.wp_kses_post($meta_box['title']).'</h4>';
			
			echo '<div class="slider_container"><div class="slider opacity-slider" id="'.esc_attr($meta_box['name']).'_slider" title="'.esc_attr($meta_box['name']).'_helper_input"></div><input class="option-input slider-input" name="'.esc_attr($meta_box['name']).'_helper_input" id="'.esc_attr($meta_box['name']).'_helper_input" type="text" value="'.esc_attr($meta_box_value).'" /></div>';

			if (isset($meta_box['description']) && $meta_box['description'] != "") echo'<span class="option-description">'.wp_kses_post($meta_box['description']).'</span>';
			
			echo'<input type="text" id="'.esc_attr($meta_box['name']).'_value" name="'.esc_attr($meta_box['name']).'_value" value="'.esc_attr($meta_box_value).'" class="option-input hidden" />';

			echo '</div>';
			
			$londres_admin_inline_script = (isset($londres_admin_inline_script)) ? $londres_admin_inline_script : "";
			$londres_admin_inline_script .= '
				jQuery(document).ready(function(){
					"use strict";
					jQuery("#'.esc_js($meta_box['name']).'_slider").each(function(){
						var value = parseInt(jQuery("#'.esc_js($meta_box['name']).'_value").val(), 10);
						if (typeof jQuery().slider == "function"){
							jQuery(this).slider({
								range: "min",
								value: value,
								min: 0,
								max: 100,
								slide: function( event, ui ) {
									jQuery("#'.esc_js($meta_box['name']).'_helper_input").val(ui.value+"%");
									jQuery("#'.esc_js($meta_box['name']).'_value").val( ui.value + " %" );
								}
							});
						}
					});
				});
			';
			wp_add_inline_script('londres-admin', $londres_admin_inline_script, 'after');
			
		break;
	}
}


/**
 * Saves the meta box content of a page
 * @param $post_id the ID of the page that contains the meta box
 */
function londres_save_postdata( $post_id ) {
	global $post, $londres_new_meta_boxes;
	
	if ( $the_post = wp_is_post_revision($post_id) ) $post_id = $the_post;

	if(get_post($post_id)->post_type=='page'){
		$londres_new_meta_boxes=$GLOBALS['londres_new_meta_boxes'];
		londres_save_meta_data($londres_new_meta_boxes, $post_id);
	}
}

/**
 * Saves the meta box content of a post
 * @param $post_id the ID of the post that contains the meta box
 */
function londres_save_portfolio_postdata( $post_id ) {
	global $post, $londres_new_meta_portfolio_boxes;
	
	if ( $the_post = wp_is_post_revision($post_id) ) $post_id = $the_post;
	
	if(get_post($post_id)->post_type==LONDRES_PORTFOLIO_POST_TYPE){
		londres_save_meta_data($londres_new_meta_portfolio_boxes, $post_id);
	}
}

/**
 * Saves the meta box content of a post
 * @param $post_id the ID of the post that contains the meta box
 */
function londres_save_testimonials_postdata( $post_id ) {
	global $post, $londres_new_meta_testimonials_boxes;
	
	if ( $the_post = wp_is_post_revision($post_id) ) $post_id = $the_post;
	
	if(get_post($post_id)->post_type==LONDRES_TESTIMONIALS_POST_TYPE){
		londres_save_meta_data($londres_new_meta_testimonials_boxes, $post_id);
	}
}

/**
 * Saves the meta box content of a post
 * @param $post_id the ID of the post that contains the meta box
 */
function londres_save_partners_postdata( $post_id ) {
	global $post, $londres_new_meta_partners_boxes;
	
	if ( $the_post = wp_is_post_revision($post_id) ) $post_id = $the_post;
	
	if(get_post($post_id)->post_type==LONDRES_PARTNERS_POST_TYPE){
		londres_save_meta_data($londres_new_meta_partners_boxes, $post_id);
	}
}

/**
 * Saves the meta box content of a post
 * @param $post_id the ID of the post that contains the meta box
 */
function londres_save_team_postdata( $post_id ) {
	global $post, $londres_new_meta_team_boxes;
	
	if ( $the_post = wp_is_post_revision($post_id) ) $post_id = $the_post;
	
	if(get_post($post_id)->post_type==LONDRES_TEAM_POST_TYPE){
		londres_save_meta_data($londres_new_meta_team_boxes, $post_id);
	}
}

/**
 * Saves the meta box content of a post
 * @param $post_id the ID of the post that contains the meta box
 */
function londres_save_post_postdata( $post_id ) {
	global $post, $londres_new_meta_post_boxes;
	
	if ( $the_post = wp_is_post_revision($post_id) ) $post_id = $the_post;

	if(get_post($post_id)->post_type=='post'){
		londres_save_meta_data($londres_new_meta_post_boxes, $post_id);
	}
}

/**
 * Saves the post meta for all types of posts.
 * @param $londres_new_meta_boxes the meta data array
 * @param $post_id the ID of the post
 */
function londres_save_meta_data($londres_new_meta_boxes, $post_id){

	if (isset($londres_new_meta_boxes) && !empty($londres_new_meta_boxes)){
			foreach($londres_new_meta_boxes as $meta_box) {

			if( $meta_box['type']!='heading'){
				// Verify
				if (isset($meta_box['name']) && isset($_POST[$meta_box['name'].'_noncename'])){
					if ( !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) )) {
						return $post_id;
					}	
				}
				
				if (isset($_POST['post_type'])){
					if ( 'page' == $_POST['post_type'] ) {
						if ( !current_user_can( 'edit_page', $post_id ))
						return $post_id;
					} else {
						if ( !current_user_can( 'edit_post', $post_id ))
						return $post_id;
					}
	
				}
				
				if (isset($meta_box['name']) && isset($_POST[$meta_box['name'].'_value'])) $data = $_POST[$meta_box['name'].'_value'];
	
				if (isset($data)){
					if(get_post_meta($post_id, $meta_box['name'].'_value') == "")
					add_post_meta($post_id, $meta_box['name'].'_value', $data, true);
					elseif($data != get_post_meta($post_id, $meta_box['name'].'_value', true))
					update_post_meta($post_id, $meta_box['name'].'_value', $data);
					elseif($data == "")
					delete_post_meta($post_id, $meta_box['name'].'_value', get_post_meta($post_id, $meta_box['name'].'_value', true));		
				}
			
	
			}
		}	
	}
}

function londres_print_helper(){
	echo '<div hidden class="temppath upper_hidden">'.esc_url(get_template_directory_uri()).'</div>';
	echo '<div hidden id="homePATH" class="upper_hidden">'.esc_url(get_home_path("/")).'</div>';
	echo '<div hidden id="homePATH2" class="upper_hidden">'.str_replace("/","\\",ABSPATH).'</div>';
}