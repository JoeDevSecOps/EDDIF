<?php
	
	$londres_fonts_array = londres_fonts_array_builder();
	
	$londres_style_general_options= array( array(
		"name" => "Search",
		"type" => "title",
	),
	
	array(
		"type" => "open",
		"subtitles"=>array(array("id"=>"search", "name"=>"Search"))
	),
	
	/* ------------------------------------------------------------------------*
	 * Search
	 * ------------------------------------------------------------------------*/
	
	array(
		"type" => "subtitle",
		"id"=>"search"
	),
	
	array(
		"type" => "documentation",
		"text" => '<h3>Search Input</h3>'
	),
	
	array(
		"name" => "Opening Effect",
		"id" => "londres_search_open_effect",
		"type" => "select",
		"options" => array(array("id"=>"slide_left", "name"=>"Slide from Left"), array("id"=>"slide_right", "name"=>"Slide from Right"), array("id"=>"slide_top", "name"=>"Slide from Top"), array("id"=>"slide_bottom", "name"=>"Slide from Bottom"), array("id"=>"unfold_horizontal", "name"=>"Unfold Horizontally"), array("id"=>"unfold_vertical", "name"=>"Unfold Vertically"), array("id"=>"unfold_center", "name" => "Unfold from Center"), array("id"=>"unfold_top_left", "name" => "Unfold from Top Left"), array("id"=>"unfold_top_right", "name"=>"Unfold from Top Right"), array("id"=>"unfold_bottom_left", "name"=>"Unfold from Bottom Left"), array("id"=>"unfold_bottom_right", "name"=>"Unfold from Bottom Right"), array("id"=>"fade", "name"=>"Fade"), array("id"=>"none", "name"=>"None")),
		"std" => "fade"
	),
	
	array(
		"name" => "Background Color",
		"id" => "londres_search_input_background_color",
		"type" => "color",
		"std" => "ffffff"
	),
	
	array(
		"name" => "Background Opacity",
		"id" => "londres_search_input_background_opacity",
		"type" => "opacity_slider",
		"std" => "98"
	),
	
	array(
		"name" => "Font",
		"id" => "londres_search_input_font",
		"type" => "select",
		"options" => $londres_fonts_array,
		"std" => "Helvetica Neue"
	),
	
	array(
		"name" => "Font Size",
		"id" => "londres_search_input_font_size",
		"type" => "slider",
		"std" => "42px"
	),
	
	array(
		"name" => "Font Color",
		"id" => "londres_search_input_font_color",
		"type" => "color",
		"std" => "e0e0e0"
	),
	
	array(
		"type" => "documentation",
		"text" => '<h3>Search Results</h3>'
	),
	
	array(
		"name" => "Background Color",
		"id" => "londres_search_result_background_color",
		"type" => "color",
		"std" => "ffffff"
	),
	
	array(
		"name" => "Selected Result Background Color",
		"id" => "londres_search_selected_result_background_color",
		"type" => "color",
		"std" => "f2f2f2"
	),
	
	array(
		"name" => "Background Opacity",
		"id" => "londres_search_result_background_opacity",
		"type" => "opacity_slider",
		"std" => "98"
	),
	
	array(
		"name" => "Borders",
		"id" => "londres_search_result_borders",
		"type" => "color",
		"std" => "dedede"
	),
	
	array(
		"name" => "Font",
		"id" => "londres_search_result_font",
		"type" => "select",
		"options" => $londres_fonts_array,
		"std" => "Helvetica Neue"
	),
	
	array(
		"name" => "Font Size",
		"id" => "londres_search_result_font_size",
		"type" => "slider",
		"std" => "14px"
	),
	
	array(
		"name" => "Font Color",
		"id" => "londres_search_result_font_color",
		"type" => "color",
		"std" => "696969"
	),
	
	array(
		"name" => "Selected Result Font Color",
		"id" => "londres_search_selected_result_font_color",
		"type" => "color",
		"std" => "3d3d3d"
	),
	
	array(
		"type" => "documentation",
		"text" => '<h5>Search Results Details</h5>'
	),
	
	array(
		"name" => "Font",
		"id" => "londres_search_result_details_font",
		"type" => "select",
		"options" => $londres_fonts_array,
		"std" => "Helvetica Neue"
	),
	
	array(
		"name" => "Font Size",
		"id" => "londres_search_result_details_font_size",
		"type" => "slider",
		"std" => "12px"
	),
	
	array(
		"name" => "Font Color",
		"id" => "londres_search_result_details_font_color",
		"type" => "color",
		"std" => "c2c2c2"
	),
	
	array(
		"name" => "Select Result Font Color",
		"id" => "londres_search_selected_result_details_font_color",
		"type" => "color",
		"std" => "c2c2c2"
	),
	
	array(
		"type" => "close"
	),
	
	/*close array*/
	
	array(
		"type" => "close"
	));
	
	londres_add_style_options($londres_style_general_options);
	
?>