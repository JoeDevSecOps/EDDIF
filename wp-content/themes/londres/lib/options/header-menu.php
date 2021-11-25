<?php

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

$londres_info_options= array( array(
"name" => "Header Layout",
"type" => "title",
"img" => LONDRES_IMAGES_URL."icon_home.png"
),

array(
"type" => "open",
"subtitles"=>array(array("id"=>"header_layout", "name"=>"Header"), array("id"=>"header_style2_options", "name"=>"Header Style 2 Contact Info"), array("id"=>"logotype", "name" =>"Logotype"), array("id"=>"top_panel", "name"=>"Top Bar"), array("id"=>"search", "name"=>"Search"))
),

array(
"type" => "subtitle",
"id"=>'header_layout'
),

array(
	'type' => 'goto',
	'name' => 'header',
	'desc' => 'Style this Element'
),

array(
	"type" => "documentation",
	"text" => '<h3>Header Style</h3>'
),

array(
	"name" => "Header Style",
	"id" => "londres_header_style_light_dark",
	"type" => "select",
	"options" => array(array("id"=>"light","name"=>"Light"), array("id"=>"dark","name"=>"Dark")),
	"desc" => "If you choose the <strong>Light Style</strong> the theme will apply the <strong>Dark</strong> logo and menu settings.<br/> If you choose the <strong>Dark Style</strong> the theme will apply the <strong>Light</strong> logo and menu settings. ",
	"std" => "light"
),

array(
	"name" => "Full width header ?",
	"id" => "londres_header_full_width",
	"type" => "checkbox",
	"std" => "on",
	"desc" => "If set to <strong>ON</strong> the header will occupy the entire width of the browser's window."
),

array(
	"name" => "Header Menu Itens Style",
	"id" => "londres_header_menu_itens_style",
	"type" => "select",
	"options" => array(array("id"=>"simple","name"=>"Simple"), array("id"=>"rounded","name"=>"Rounded"), array("id"=>"square","name"=>"Square")),
	"std" => "square"
),

array(
"type" => "documentation",
"text" => '<h3>Fixed Header</h3>'
),

array(
"name" => "Fixed Header?",
"id" => "londres_fixed_menu",
"type" => "checkbox",
"std" => "on",
"desc" => "If set to <strong>ON</strong> the header will be always visible, not only at the top of the page."
),

array(
"name" => "Hide on Start?",
"id" => "londres_header_hide_on_start",
"type" => "checkbox",
"std" => "off",
"desc" => "If set to <strong>ON</strong> the header will appear from the top of the page after scrolling."
),

array(
	"name" => "Page Content (on multipage templates)",
	"id" => "londres_content_to_the_top",
	"type" => "select",
	"options" => array(array("id"=>"off","name"=>"Content starts after the header"), array("id"=>"on","name"=>"Content behind the header")),
	"std" => "off"
),

array(
"type" => "documentation",
"text" => '<h3>Header After Scroll</h3>'
),

array(
"name" => "Header After Scroll?",
"id" => "londres_header_after_scroll",
"type" => "checkbox",
"std" => "on",
"desc" => "If set to <strong>ON</strong> you will have options to style a second header to display different from the one appearing in the top of the page."
),

array(
	"name" => "Header After Scroll Style",
	"id" => "londres_header_after_scroll_style_light_dark",
	"type" => "select",
	"options" => array(array("id"=>"light","name"=>"Light"), array("id"=>"dark","name"=>"Dark")),
	"desc" => "If you choose the <strong>Light Style</strong> the theme will apply the <strong>Dark</strong> logo and menu settings.<br/> If you choose the <strong>Dark Style</strong> the theme will apply the <strong>Light</strong> logo and menu settings. ",
	"std" => "light"
),

array(
"type" => "documentation",
"text" => '<h3>Header Shrink Effect</h3>'
),

array(
"name" => "Header Shrink Effect?",
"id" => "londres_header_shrink_effect",
"type" => "checkbox",
"std" => "on",
"desc" => "If set to <strong>ON</strong> you will be able to change the sizes of the contents (header included)."
),

array(
	"type" => "documentation",
	"text" => "<h3>Enable / Disable Woocommerce Cart</h3>"
),

array(
	"name" => "Woocommerce Cart",
	"id" => "londres_woocommerce_cart",
	"type" => "checkbox",
	"std" => 'off',
	"desc" => "Displays the Woocommerce Cart."
),

array(
	"type" => "documentation",
	"text" => "<h3>Enable / Disable Right Panel (Sidebar)</h3>"
),

array(
	"name" => "Sliding Panel",
	"id" => "londres_sliding_panel",
	"type" => "checkbox",
	"std" => 'off',
	"desc" => "Displays the Icon to open right Panel  icons."
),

array(
	"type" => "documentation",
	"text" => "<h3>Enable / Disable Social Icons</h3>"
),

array(
	"name" => "Social Icons",
	"id" => "londres_social_icons_menu",
	"type" => "checkbox",
	"std" => 'off',
	"desc" => "Displays the social icons."
),

array(
"type" => "documentation",
"text" => '<h3>Header Layout</h3>'
),

array(
	"type" => "documentation",
	"text" => '<p><b>Note:</b> After choose the header style, go to the next tab <b>Top Bar</b> and add your contents.</p>'
),

array(
	"name" => "Header Style Type",
	"id" => "londres_header_style_type",
	"type" => "select",
	"options" => array(array('id'=>'style1', 'name'=>'Style 1'), array('id'=>'style2','name'=>'Style 2'), array('id'=>'style3','name'=>'Style 3'), array('id'=>'style4','name'=>'Style 4'), array('id'=>'style5','name'=>'Style 5')),
	"std" => 'style1'
),

array(
	"type" => "close"
),

array(
	"type" => "subtitle",
	"id" => "header_style2_options"
),
	
	array(
		"type" => "documentation",
		"text" => '<h3>Header Style 2 Contact Info</h3>'
	),
	
	array(
		"name" => "Telephone Slogan",
		"id" => "londres_style2_telephone_slogan",
		"type" => "text",
		"desc" => "The slogan will appear a little smaller above the info.",
		"std" => ""
	),
	
	array(
		"name" => "Telephone",
		"id" => "londres_style2_telephone_menu",
		"type" => "text",
		"desc" => "Insert number to display above the menu. <br/>NOTE: If you add links, span or class <b>do not use quotes or double quotes</b>.<br/> ex: < span class=text_color >",
		"std" => ""
	),
	
	array(
		"name" => "Email Slogan",
		"id" => "londres_style2_email_slogan",
		"type" => "text",
		"desc" => "The slogan will appear a little smaller above the info.",
		"std" => ""
	),
	
	array(
		"name" => "Email",
		"id" => "londres_style2_email_menu",
		"type" => "text",
		"desc" => "Insert email to display above the menu.<br/>NOTE: If you add links, span or class <b>do not use quotes or double quotes</b>.<br/> ex: < span class=text_color >",
		"std" => "m"
	),

array(
	"type" => "close"
),

/* logotype new place */
array(
"type" => "subtitle",
"id"=>'logotype'
),

array(
	'type' => 'goto',
	'name' => 'logotype',
	'desc' => 'Style this Element'
),

array(
	"type" => "documentation",
	"text" => "<h3>Logo</h3>"
),

array(
	"name" => "Logo <strong>Light</strong> URL",
	"id" => "londres_logo_image_url_light",
	"type" => "upload_from_media",
	"desc" => "Upload your logo image - with png/jpg/gif extension.",
	"std" => "http://paulomoreira.org/themes/londres/wp-content/uploads/2017/11/logo-light.png"
),

array(
	"name" => "Logo <strong>Light</strong> Retina URL",
	"id" => "londres_logo_retina_image_url_light",
	"type" => "upload_from_media",
	"desc" => "Upload your logo image - with png/jpg/gif extension.",
	"std" => "http://paulomoreira.org/themes/londres/wp-content/uploads/2017/11/logo-light@2x.png"
),

array(
	"name" => "Logo <strong>Dark</strong> URL",
	"id" => "londres_logo_image_url_dark",
	"type" => "upload_from_media",
	"desc" => "Upload your logo image - with png/jpg/gif extension.",
	"std" => "http://paulomoreira.org/themes/londres/wp-content/uploads/2017/11/logo.png"
),

array(
	"name" => "Logo <strong>Dark</strong> Retina URL",
	"id" => "londres_logo_retina_image_url_dark",
	"type" => "upload_from_media",
	"desc" => "Upload your logo image - with png/jpg/gif extension.",
	"std" => "http://paulomoreira.org/themes/londres/wp-content/uploads/2017/11/logo@2x.png"
),

array(
	"type" => "close"
),


/* ------------------------------------------------------------------------*
 * Top Contents
 * ------------------------------------------------------------------------*/

array(
"type" => "subtitle",
"id"=>'top_panel'
),

	array(
		"type" => "documentation",
		"text" => "<h3>Top Bar Contents</h3>"
	),
	
	array(
		"name" => "Enable Top Info Bar",
		"id" => "londres_info_above_menu",
		"type" => "checkbox",
		"std" => 'on',
		"desc" => "Displays an above menu information container."
	),
	
	array(
		"name" => "WPML Widget",
		"id" => "londres_wpml_menu_widget",
		"type" => "checkbox",
		"std" => 'off',
		"desc" => "Displays the WPML widget if available."
	),
	
	array(
		"name" => "Display Top Bar Menu",
		"id" => "londres_top_bar_menu",
		"type" => "checkbox",
		"std" => 'off',
		"desc" => "Displays the Top Bar Menu. You need to assign a Menu to the Top Bar Location in <strong>Appearance > Menus</strong>."
	),
	
	array(
		"name" => "Telephone",
		"id" => "londres_telephone_menu",
		"type" => "text",
		"desc" => "Insert number to display above the menu. <br/>NOTE: If you add links, span or class <b>do not use quotes or double quotes</b>.<br/> ex: < span class=text_color >",
		"std" => ""
	),
	
	array(
		"name" => "Email",
		"id" => "londres_email_menu",
		"type" => "text",
		"desc" => "Insert email to display above the menu.<br/>NOTE: If you add links, span or class <b>do not use quotes or double quotes</b>.<br/> ex: < span class=text_color >",
		"std" => "hello@example.com"
	),
	
	array(
		"name" => "Address",
		"id" => "londres_address_menu",
		"type" => "text",
		"desc" => "Insert address to display above the menu.<br/>NOTE: If you add links, span or class <b>do not use quotes or double quotes</b>.<br/> ex: < span class=text_color >",
		"std" => ""
	),
	
	array(
		"name" => "Text Field",
		"id" => "londres_text_field_menu",
		"type" => "text",
		"desc" => "Insert a custom text line.<br/>NOTE: If you add links, span or class <b>do not use quotes or double quotes</b>.<br/> ex: < span class=text_color >",
		"std" => ""
	),
	
	array(
		"name" => "Enable Social Icons",
		"id" => "londres_enable_socials",
		"type" => "checkbox",
		"std" => 'off'
	),
	
	array(
		"type" => "close"
	),
	
	array(
		"type" => "subtitle",
		"id"=>'search'
	),
	
	array(
		"type" => "documentation",
		"text" => "<h3>Search Options</h3>"
	),
	
	array(
		"name" => "Enable Search",
		"id" => "londres_enable_search",
		"type" => "checkbox",
		"std" => 'on'
	),
	
	array(
		"name" => "Enable Ajax Search",
		"id" => "londres_enable_ajax_search",
		"type" => "checkbox",
		"std" => 'off',
		"desc" => "If enabled, displays search results on typing."
	),
	
	array(
		"name" => "Search all contents ?",
		"id" => "londres_enable_search_everything",
		"type" => "checkbox",
		"std" => 'on',
		"desc" => "If enabled the search will go through not only posts and pages, but all of the website's content."
	),
	
	array(
		"type" => "documentation",
		"text" => "<h3>Search Page Results</h3>"
	),
	
	array(
		"name" => "Secondary Title",
		"id" => "londres_search_secondary_title",
		"type" => "text",
		"desc" => "If set, will display this as a secondary title."
	),
	
	array(
		"name" => "Sidebar ?",
		"id" => "londres_search_archive_sidebar",
		"type" => "select",
		"options" => array(array("id"=>"none", "name"=>"None"), array("id"=>"left", "name"=>"Left"), array("id"=>"right", "name"=>"Right")),
		"std"=>"right"
	),
	
	array(
		"name" => "Choose your Sidebar",
		"id" => "londres_search_sidebars_available",
		"type" => "select",
		"options" => $outputsidebars
	),
	
	array(
		"type" => "documentation",
		"text" => "<h3>Search Results Ajax Details</h3>"
	),
	
	array(
		"name" => "Show Author ?",
		"id" => "londres_search_show_author",
		"type" => "checkbox",
		"std" => 'on'
	),
	
	array(
		"name" => "Show Date ?",
		"id" => "londres_search_show_date",
		"type" => "checkbox",
		"std" => 'on'
	),
	
	array(
		"name" => "Show Tags ?",
		"id" => "londres_search_show_tags",
		"type" => "checkbox",
		"std" => 'off'
	),
	
	array(
		"name" => "Show Categories ?",
		"id" => "londres_search_show_categories",
		"type" => "checkbox",
		"std" => 'off'
	),

	array(
		"type" => "close"
	),	
	
	
	array(
	"type" => "close"));

londres_add_options($londres_info_options);