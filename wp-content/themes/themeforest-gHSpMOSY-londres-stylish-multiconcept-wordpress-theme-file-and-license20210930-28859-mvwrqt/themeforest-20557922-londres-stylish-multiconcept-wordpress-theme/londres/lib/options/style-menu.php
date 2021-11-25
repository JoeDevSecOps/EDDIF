<?php
	
	$londres_fonts_array = londres_fonts_array_builder();
	
	$londres_style_general_options= array( array(
		"name" => "Menus",
		"type" => "title",
	),
	
	array(
		"type" => "open",
		"subtitles"=>array(array("id"=>"light-top-menu", "name"=>"Top Menu Items Light"), array("id"=>"dark-top-menu", "name"=>"Top Menu Items Dark"), array("id"=>"sub-items", "name"=>"Sub Menu Items"))
	),
	
	/* ------------------------------------------------------------------------*
	 * MENU OPTIONS
	 * ------------------------------------------------------------------------*/
	
	
	
	array(
		"type" => "subtitle",
		"id"=>'light-top-menu'
	),
	
	array(
		"type" => "documentation",
		"text" => '<h3>Top Menu Items Light</h3>'
	),
	
	array(
		"type" => "documentation",
		"text" => '<h5>PRE-SCROLL</h5>'
	),
	
	array(
		"name" => "Font",
		"id" => "londres_menu_font_pre_light",
		"type" => "select",
		"options" => $londres_fonts_array,
		"desc" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
		"std" => "Helvetica Neue"
	),
	
	array(
		"name" => "Font Color",
		"id" => "londres_menu_color_pre_light",
		"type" => "color",
		"std" => "cfcfcf"
	),
	
	array(
		"name" => "Font Color Hover",
		"id" => "londres_menu_color_hover_pre_light",
		"type" => "color",
		"std" => "ffffff"
	),
	
	array(
		"name" => "Font Size",
		"id" => "londres_menu_font_size_pre_light",
		"type" => "slider",
		"std" => "10px",
		"desc" => "Change the size of your menu font."
	),
	
	array(
		"name" => "Text Uppercase",
		"id" => "londres_menu_uppercase_pre_light",
		"type" => "checkbox",
		"std" => "on"
	),
	
	array(
		"name" => "Letter Spacing",
		"id" => "londres_menu_letter_spacing_pre_light",
		"type" => "text",
		"std" => "4px"
	),
	
	array(
		"name" => "Add Border ?",
		"id" => "londres_menu_add_border_pre_light",
		"type" =>"checkbox",
		"std" => "off"
	),
	
	array(
		"name"=>"Border Color",
		"id" => "londres_menu_border_color_pre_light",
		"type" => "color",
		"std" => "000000"
	),
	
	array(
		"name" => "Menu Side Margin",
		"id" => "londres_menu_side_margin_pre_light",
		"type" => "slider",
		"std" => "15px"
	),
	
	array(
		"name" => "Menu Margin Top",
		"id" => "londres_menu_margin_top_pre_light",
		"type" => "text",
		"std" => "25px"
	),
	
	
	array(
		"name" => "Menu Padding Bottom",
		"id" => "londres_menu_padding_bottom_pre_light",
		"type" => "text",
		"std" => "25px"
	),
	
	array(
		"type" => "documentation",
		"text" => '<h5>AFTER-SCROLL</h5>'
	),
	
	array(
		"name" => "Font",
		"id" => "londres_menu_font_after_light",
		"type" => "select",
		"options" => $londres_fonts_array,
		"desc" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
		"std" => "Helvetica Neue"
	),
	
	array(
		"name" => "Font Color",
		"id" => "londres_menu_color_after_light",
		"type" => "color",
		"std" => "cfcfcf"
	),
	
	array(
		"name" => "Font Color Hover",
		"id" => "londres_menu_color_hover_after_light",
		"type" => "color",
		"std" => "ffffff"
	),
	
	array(
		"name" => "Font Size",
		"id" => "londres_menu_font_size_after_light",
		"type" => "slider",
		"std" => "10px",
		"desc" => "Change the size of your menu font."
	),
	
	array(
		"name" => "Text Uppercase",
		"id" => "londres_menu_uppercase_after_light",
		"type" => "checkbox",
		"std" => "on"
	),
	
	array(
		"name" => "Letter Spacing",
		"id" => "londres_menu_letter_spacing_after_light",
		"type" => "text",
		"std" => "4px"
	),
	
	array(
		"name" => "Add Border ?",
		"id" => "londres_menu_add_border_after_light",
		"type" =>"checkbox",
		"std" => "off"
	),
	
	array(
		"name"=>"Border Color",
		"id" => "londres_menu_border_color_after_light",
		"type" => "color",
		"std" => "000000"
	),
	
	array(
		"name" => "Menu Side Margin",
		"id" => "londres_menu_side_margin_after_light",
		"type" => "slider",
		"std" => "15px"
	),
	
	array(
		"name" => "Menu Margin Top",
		"id" => "londres_menu_margin_top_after_light",
		"type" => "text",
		"std" => "15px"
	),
	
	
	array(
		"name" => "Menu Padding Bottom",
		"id" => "londres_menu_padding_bottom_after_light",
		"type" => "text",
		"std" => "15px"
	),

	array("type"=>"close"),
	
	array(
		"type" => "subtitle",
		"id"=>'dark-top-menu'
	),
	
	array(
		"type" => "documentation",
		"text" => '<h3>Top Menu Items Dark</h3>'
	),
	
	array(
		"type" => "documentation",
		"text" => '<h5>PRE-SCROLL</h5>'
	),
	
	array(
		"name" => "Font",
		"id" => "londres_menu_font_pre_dark",
		"type" => "select",
		"options" => $londres_fonts_array,
		"desc" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
		"std" => "Helvetica Neue"
	),
	
	array(
		"name" => "Font Color",
		"id" => "londres_menu_color_pre_dark",
		"type" => "color",
		"std" => "525254"
	),
	
	array(
		"name" => "Font Color Hover",
		"id" => "londres_menu_color_hover_pre_dark",
		"type" => "color",
		"std" => "10b9b9"
	),
	
	array(
		"name" => "Font Size",
		"id" => "londres_menu_font_size_pre_dark",
		"type" => "slider",
		"std" => "12px",
		"desc" => "Change the size of your menu font."
	),
	
	array(
		"name" => "Text Uppercase",
		"id" => "londres_menu_uppercase_pre_dark",
		"type" => "checkbox",
		"std" => "on"
	),
	
	array(
		"name" => "Letter Spacing",
		"id" => "londres_menu_letter_spacing_pre_dark",
		"type" => "text",
		"std" => "1px"
	),
	
	array(
		"name" => "Add Border ?",
		"id" => "londres_menu_add_border_pre_dark",
		"type" =>"checkbox",
		"std" => "off"
	),
	
	array(
		"name"=>"Border Color",
		"id" => "londres_menu_border_color_pre_dark",
		"type" => "color",
		"std" => "000000"
	),
	
	array(
		"name" => "Menu Side Margin",
		"id" => "londres_menu_side_margin_pre_dark",
		"type" => "slider",
		"std" => "20px"
	),
	
	array(
		"name" => "Menu Margin Top",
		"id" => "londres_menu_margin_top_pre_dark",
		"type" => "text",
		"std" => "33px"
	),
	
	
	array(
		"name" => "Menu Padding Bottom",
		"id" => "londres_menu_padding_bottom_pre_dark",
		"type" => "text",
		"std" => "32px"
	),
	
	array(
		"type" => "documentation",
		"text" => '<h5>AFTER-SCROLL</h5>'
	),
	
	array(
		"name" => "Font",
		"id" => "londres_menu_font_after_dark",
		"type" => "select",
		"options" => $londres_fonts_array,
		"desc" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
		"std" => "Helvetica Neue"
	),
	
	array(
		"name" => "Font Color",
		"id" => "londres_menu_color_after_dark",
		"type" => "color",
		"std" => "525254"
	),
	
	array(
		"name" => "Font Color Hover",
		"id" => "londres_menu_color_hover_after_dark",
		"type" => "color",
		"std" => "10b9b9"
	),
	
	array(
		"name" => "Font Size",
		"id" => "londres_menu_font_size_after_dark",
		"type" => "slider",
		"std" => "12px",
		"desc" => "Change the size of your menu font."
	),
	
	array(
		"name" => "Text Uppercase",
		"id" => "londres_menu_uppercase_after_dark",
		"type" => "checkbox",
		"std" => "on"
	),
	
	array(
		"name" => "Letter Spacing",
		"id" => "londres_menu_letter_spacing_after_dark",
		"type" => "text",
		"std" => "1px"
	),
	
	array(
		"name" => "Add Border ?",
		"id" => "londres_menu_add_border_after_dark",
		"type" =>"checkbox",
		"std" => "off"
	),
	
	array(
		"name"=>"Border Color",
		"id" => "londres_menu_border_color_after_dark",
		"type" => "color",
		"std" => "000000"
	),
	
	array(
		"name" => "Menu Side Margin",
		"id" => "londres_menu_side_margin_after_dark",
		"type" => "slider",
		"std" => "20px"
	),
	
	array(
		"name" => "Menu Margin Top",
		"id" => "londres_menu_margin_top_after_dark",
		"type" => "text",
		"std" => "20px"
	),
	
	
	array(
		"name" => "Menu Padding Bottom",
		"id" => "londres_menu_padding_bottom_after_dark",
		"type" => "text",
		"std" => "20px"
	),
	
	array("type"=>"close"),
	
	array(
		"type" => "subtitle",
		"id"=>'sub-items'
	),
	
	array(
		"type" => "documentation",
		"text" => '<h3>Sub Menu Items</h3>'
	),
		
	array(
		"name" => "Font",
		"id" => "londres_sub_menu_font",
		"type" => "select",
		"options" => $londres_fonts_array,
		"desc" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
		"std" => "Helvetica Neue"
	),
	
	array(
		"name" => "Font Color",
		"id" => "londres_sub_menu_color",
		"type" => "color",
		"std" => "555555"
	),
	
	array(
		"name" => "Font Color Hover",
		"id" => "londres_sub_menu_color_hover",
		"type" => "color",
		"std" => "ffffff"
	),
	
	array(
		"name" => "Font Size",
		"id" => "londres_sub_menu_font_size",
		"type" => "slider",
		"std" => "11px",
		"desc" => "Change the size of your menu font."
	),
	
	array(
		"name" => "Text Uppercase",
		"id" => "londres_sub_menu_uppercase",
		"type" => "checkbox",
		"std" => "on"
	),
	
	array(
		"name" => "Letter Spacing",
		"id" => "londres_sub_menu_letter_spacing",
		"type" => "text",
		"std" => "1px"
	),
	
	
	array(
		"name" => "Background Color",
		"id" => "londres_sub_menu_bg_color",
		"type" => "color",
		"std" => "ffffff"
	),
	
	array(
		"name" => "Background Opacity",
		"id" => "londres_sub_menu_bg_opacity",
		"type" => "opacity_slider",
		"std" => "100"
	),
	
	array(
		"name" => "Background Color Hover",
		"id" => "londres_sub_menu_bg_color_hover",
		"type" => "color",
		"std" => "10b9b9"
	),
	
	array(
		"name"=>"Border Color",
		"id" => "londres_sub_menu_border_color",
		"type" => "color",
		"std" => "ededed"
	),
	
	
	array(
		"type" => "documentation",
		"text" => '<h3>Just Label (Without Link)</h3>'
	),
	
	array(
		"name" => "Font",
		"id" => "londres_label_menu_font",
		"type" => "select",
		"options" => $londres_fonts_array,
		"desc" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
		"std" => "Helvetica Neue"
	),
	
	array(
		"name" => "Font Color",
		"id" => "londres_label_menu_color",
		"type" => "color",
		"std" => "555555"
	),
	
	array(
		"name" => "Font Size",
		"id" => "londres_label_menu_font_size",
		"type" => "slider",
		"std" => "12px",
		"desc" => "Change the size of your menu font."
	),
	
	array(
		"name" => "Text Uppercase",
		"id" => "londres_label_menu_uppercase",
		"type" => "checkbox",
		"std" => "on"
	),
	
	array(
		"name" => "Letter Spacing",
		"id" => "londres_label_menu_letter_spacing",
		"type" => "text",
		"std" => "1px"
	),
	
	array("type"=>"close"),

	/*close array*/
	
	array(
		"type" => "close"
	));
	
	londres_add_style_options($londres_style_general_options);
	
?>