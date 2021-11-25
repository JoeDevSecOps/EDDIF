<?php
/*
 *
 * Social Icon
 */
function metasoft_get_social_icon_default() {
	return apply_filters(
		'metasoft_get_social_icon_default', json_encode(
				 array(
				array(
					'icon_value'	  =>  esc_html__( 'fa-facebook', 'metasoft-pro' ),
					'link'	  =>  esc_html__( '#', 'metasoft-pro' ),
					'id'              => 'customizer_repeater_header_social_001',
				),
				array(
					'icon_value'	  =>  esc_html__( 'fa-google-plus', 'metasoft-pro' ),
					'link'	  =>  esc_html__( '#', 'metasoft-pro' ),
					'id'              => 'customizer_repeater_header_social_002',
				),
				array(
					'icon_value'	  =>  esc_html__( 'fa-twitter', 'metasoft-pro' ),
					'link'	  =>  esc_html__( '#', 'metasoft-pro' ),
					'id'              => 'customizer_repeater_header_social_003',
				),
				array(
					'icon_value'	  =>  esc_html__( 'fa-linkedin', 'metasoft-pro' ),
					'link'	  =>  esc_html__( '#', 'metasoft-pro' ),
					'id'              => 'customizer_repeater_header_social_004',
				),
			)
		)
	);
}

/*
 *
 * Slider Default
 */
 function metasoft_get_slider_default() {
	return apply_filters(
		'metasoft_get_slider_default', json_encode(
				 array(
				array(
					'image_url'       => CLEVERFOX_PLUGIN_URL .'inc/metasoft/images/slider/slider01.jpg',
					'title'           => esc_html__( '25 Years', 'metasoft-pro' ),
					'subtitle'         => esc_html__( 'Experience in the Finance Industry', 'metasoft-pro' ),
					'text'            => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ase ger et fringilla orci. Maecenas convallis nisl et massa enie are', 'metasoft-pro' ),
					'text2'	  =>  esc_html__( 'Get Started', 'metasoft-pro' ),
					'link'	  =>  esc_html__( '#', 'metasoft-pro' ),
					"slide_align" => "left", 
					'id'              => 'customizer_repeater_slider_001',
				),
				array(
					'image_url'       => CLEVERFOX_PLUGIN_URL .'inc/metasoft/images/slider/slider02.jpg',
					'title'           => esc_html__( '25 Years', 'metasoft-pro' ),
					'subtitle'         => esc_html__( 'Experience in the Finance Industry', 'metasoft-pro' ),
					'text'            => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ase ger et fringilla orci. Maecenas convallis nisl et massa enie are', 'metasoft-pro' ),
					'text2'	  =>  esc_html__( 'Get Started', 'metasoft-pro' ),
					'link'	  =>  esc_html__( '#', 'metasoft-pro' ),
					"slide_align" => "center", 
					'id'              => 'customizer_repeater_slider_002',
				),
				array(
					'image_url'       => CLEVERFOX_PLUGIN_URL .'inc/metasoft/images/slider/slider03.jpg',
					'title'           => esc_html__( '25 Years', 'metasoft-pro' ),
					'subtitle'         => esc_html__( 'Experience in the Finance Industry', 'metasoft-pro' ),
					'text'            => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ase ger et fringilla orci. Maecenas convallis nisl et massa enie are', 'metasoft-pro' ),
					'text2'	  =>  esc_html__( 'Get Started', 'metasoft-pro' ),
					'link'	  =>  esc_html__( '#', 'metasoft-pro' ),
					"slide_align" => "right", 
					'id'              => 'customizer_repeater_slider_003',
			
				),
			)
		)
	);
}

/*
 *
 * Info Default
 */
 function metasoft_get_info_default() {
	return apply_filters(
		'metasoft_get_info_default', json_encode(
				 array(
				array(
					'title'           => esc_html__( 'Consulting', 'metasoft-pro' ),
					'text'            => esc_html__( 'Do eiusmod tempor incididunt ut labore et dolore magna', 'metasoft-pro' ),
					'text2'            => esc_html__( 'Read More', 'metasoft-pro' ),
					'icon_value'       => 'fa-comments',
					'id'              => 'customizer_repeater_info_001',
					
				),
				array(
					'title'           => esc_html__( 'Architecture', 'metasoft-pro' ),
					'text'            => esc_html__( 'Do eiusmod tempor incididunt ut labore et dolore magna', 'metasoft-pro' ),
					'text2'            => esc_html__( 'Read More', 'metasoft-pro' ),
					'icon_value'       => 'fa-comments',
					'id'              => 'customizer_repeater_info_002',				
				),
				array(
					'title'           => esc_html__( 'Green buildings', 'metasoft-pro' ),
					'text'            => esc_html__( 'Do eiusmod tempor incididunt ut labore et dolore magna', 'metasoft-pro' ),
					'text2'            => esc_html__( 'Read More', 'metasoft-pro' ),
					'icon_value'       => 'fa-comments',
					'id'              => 'customizer_repeater_info_003',
				),
				array(
					'title'           => esc_html__( 'Flat share', 'metasoft-pro' ),
					'text'            => esc_html__( 'Do eiusmod tempor incididunt ut labore et dolore magna', 'metasoft-pro' ),
					'text2'            => esc_html__( 'Read More', 'metasoft-pro' ),
					'icon_value'       => 'fa-comments',
					'id'              => 'customizer_repeater_info_004',
				),
			)
		)
	);
}

/*
 *
 * Service Default
 */
 function metasoft_get_service_default() {
	return apply_filters(
		'metasoft_get_service_default', json_encode(
				 array(
				array(
					'title'           => esc_html__( 'Professional Consulting', 'metasoft-pro' ),
					'text'            => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam quos aperiam ipsam modi dolor suscipit asperiores perspiciatis.', 'metasoft-pro' ),
					'icon_value'       => 'fa-folder-open-o',
					'id'              => 'customizer_repeater_service_001',
					
				),
				array(
					'title'           => esc_html__( 'Valuable Ideas', 'metasoft-pro' ),
					'text'            => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam quos aperiam ipsam modi dolor suscipit asperiores perspiciatis.', 'metasoft-pro' ),
					'icon_value'       => 'fa-columns',
					'id'              => 'customizer_repeater_service_002',				
				),
				array(
					'title'           => esc_html__( 'Budget Friendly', 'metasoft-pro' ),
					'text'            => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam quos aperiam ipsam modi dolor suscipit asperiores perspiciatis.', 'metasoft-pro' ),
					'icon_value'       => 'fa-graduation-cap ',
					'id'              => 'customizer_repeater_service_003',
				),
			)
		)
	);
}



/*
 *
 * Expertise Default
 */
 function metasoft_get_expertise_default() {
	return apply_filters(
		'metasoft_get_expertise_default', json_encode(
				 array(
				array(
					'title'           => esc_html__( 'Strategy & Growth', 'metasoft-pro' ),
					'text'            => esc_html__( 'Defining your business goal and steps to achieve them.', 'metasoft-pro' ),
					'icon_value'       => 'fa-sun-o',
					'id'              => 'customizer_repeater_expertise_001',
				),
				array(
					'title'           => esc_html__( 'Global Expansion', 'metasoft-pro' ),
					'text'            => esc_html__( 'Defining your business goal and steps to achieve them.', 'metasoft-pro' ),
					'icon_value'       => 'fa-sun-o',
					'id'              => 'customizer_repeater_expertise_002',				
				),
				array(
					'title'           => esc_html__( 'Customer Strategy', 'metasoft-pro' ),
					'text'            => esc_html__( 'Defining your business goal and steps to achieve them.', 'metasoft-pro' ),
					'icon_value'       => 'fa-sun-o',
					'id'              => 'customizer_repeater_expertise_003',
				),
				array(
					'title'           => esc_html__( 'Tax Consulting', 'metasoft-pro' ),
					'text'            => esc_html__( 'Defining your business goal and steps to achieve them.', 'metasoft-pro' ),
					'icon_value'       => 'fa-sun-o',
					'id'              => 'customizer_repeater_expertise_004',
				),
				array(
					'title'           => esc_html__( 'Currencies', 'metasoft-pro' ),
					'text'            => esc_html__( 'Defining your business goal and steps to achieve them.', 'metasoft-pro' ),
					'icon_value'       => 'fa-sun-o',
					'id'              => 'customizer_repeater_expertise_005',
				),
				array(
					'title'           => esc_html__( 'Commodities', 'metasoft-pro' ),
					'text'            => esc_html__( 'Defining your business goal and steps to achieve them.', 'metasoft-pro' ),
					'icon_value'       => 'fa-sun-o',
					'id'              => 'customizer_repeater_expertise_006',
				),
			)
		)
	);
}