<?php
/*
Template Name: Homepage Template
*/

get_header(); if (function_exists('londres_print_menu')) londres_print_menu(false);

	$this_page_id = get_the_ID();

	$homeType = get_post_meta($this_page_id, 'homeStyle_value', true);
	switch($homeType){
		case "slider":
			if (get_post_meta($this_page_id, 'parallaxEffect_value', true) == 'yes') londres_print_slider($this_page_id, true);
			else londres_print_slider($this_page_id);
		break;
		case "image": case "video":
			?>
			<section id="home" class="homepage_parallax <?php echo esc_attr($homeType); if (get_post_meta($this_page_id, 'parallaxEffect_value', true) == 'yes') echo " parallax"; ?>">
				<?php
					if ($homeType == "image"){
						$media = get_post_meta($this_page_id, 'homeParallaxMedia_value', true);
						$media = explode("|!|",$media);
						?>
						<div id="parallax-home" <?php if (get_post_meta($this_page_id, 'parallaxEffect_value', true) == 'yes') echo 'class="parallax" data-stellar-background-ratio="0.5" '; ?> >
							<div class="parallax-overlay parallax-overlay-pattern"></div>
							<?php 
								londres_print_intro($this_page_id); 
								$londres_output = "#home #parallax-home{background-image: url(".esc_url($media[1]).");background-size:cover;text-align:center;}";
								londres_set_custom_inline_css($londres_output);
							?>
						</div>
						<?php
					} else {
						?>
						<div id="parallax-home" <?php if (get_post_meta($this_page_id, 'parallaxEffect_value', true) == 'yes') echo 'class="parallax" data-stellar-ratio="0.5"'; ?>>	
							<?php
								if (get_post_meta($this_page_id, 'homeVideoSource_value', true) != 'youtube'){
									?>
									<div class="video-container <?php if (get_post_meta($this_page_id, 'parallaxEffect_value', true) == 'yes') echo 'parallax'; ?>" >
									<?php
									$media = get_post_meta($this_page_id, 'homeParallaxMedia_video_value', true);
									$media = explode("|!|",$media);
									$controls = (get_post_meta($this_page_id, 'homeVideoControls_value', true) == 'yes') ? "controls=true " : "";
									$muted = (get_post_meta($this_page_id, 'homeVideoMuted_value', true) == 'yes') ? "muted" : "";
									?>
										<video class="wp-video-shortcode" controls="<?php echo esc_attr( $controls ); ?>" muted="muted" loop="true" autoplay="true" preload="true" src="<?php echo esc_url( $media[1] ); ?>" >
											<source type="video/mp4" src="<?php echo esc_url( $media[1] ); ?>"><a href="<?php echo esc_url( $media[1] ); ?>"><?php echo esc_url( $media[1] ); ?></a>
										</video>
									</div>
									<?php
								}
								
								londres_print_intro($this_page_id, true); 
							?>
						</div>
						<?php
						if (get_post_meta($this_page_id, 'homeVideoSource_value', true) == 'youtube'){
							$controls = (get_post_meta($this_page_id, 'homeVideoControls_value', true) == 'yes') ? "true" : "false";
							?>
							<div class="player" data-property="{videoURL:'<?php echo esc_html(get_post_meta($this_page_id, 'homeYoutubeLink_value', true)); ?>',  optimizeDisplay:true, showControls:<?php echo esc_attr($controls); ?>,containment:'#parallax-home',startAt:0,mute:<?php echo (get_post_meta($this_page_id,'homeVideoMuted_value', true) == 'yes') ? "true" : "false"; ?>,autoPlay:true,player:true,loop:true,opacity:1,stopMovieOnBlur:true}"></div>

							<?php
						}
					}
				
				$londres_inline_script = '
					jQuery(document).ready(function(){
						"use strict";
						if (jQuery(".homepage_parallax #home-slider").length){
							jQuery(".home-slide").each(function(){
							    var contentSize = jQuery(this).find(".home-slide-content");
						        contentSize.fitText(1);
							});
							jQuery("#home-slider.flexslider").flexslider({
								animation: "swing",
								direction: "vertical",
								slideshow: true,
								slideshowSpeed: 3500,
								animationDuration: 1000,
								directionNav: false,
								controlNav: true,
								smootheHeight: true
							});
						}
					});
				';
				wp_add_inline_script('londres-global', $londres_inline_script, 'after');
				?>
			</section>
			<div class="clear"></div>
			<?php
		break;
	}
	
	$thepost = get_post($this_page_id);
	?>
	<section class="page_content section_page-<?php echo esc_attr($this_page_id); ?> content_from_homepage_template" id="section_page-<?php echo esc_attr($this_page_id); ?>" data-section-title="<?php echo esc_attr($thepost->post_title); ?>">
		<div class="container">
		<?php
			if ((function_exists('vc_is_inline') && vc_is_inline()) || is_preview()){
				wp_reset_postdata();
				the_content();
			} else {
				$content_post = get_post($this_page_id);
				if(stripos($content_post->post_content, 'font_call:')){
					preg_match_all('/font_call:(.*?)"/',$content_post->post_content, $display);
					if (function_exists('enquque_ultimate_google_fonts_optimzed')) enquque_ultimate_google_fonts_optimzed($display[1]);
				}
				
				$content = $content_post->post_content;
				$upper_theme_main_color = "#".get_option('londres_style_color');
				$content = str_replace( '__USE_THEME_MAIN_COLOR__', $upper_theme_main_color, $content );
				londres_content_shortcoder($content);
				$content = apply_filters('the_content', $content);
				if (function_exists('wpb_js_remove_wpautop') == true)
					echo wpb_js_remove_wpautop($content);
				else echo wp_kses_post($content); 
				
				$shortcodes_custom_css = get_post_meta( $this_page_id, '_wpb_shortcodes_custom_css', true );
				if ( ! empty( $shortcodes_custom_css ) ) {
					londres_set_custom_inline_css($shortcodes_custom_css);
				}
				$post_custom_css = get_post_meta( $this_page_id, '_wpb_post_custom_css', true );
				if ( ! empty( $post_custom_css ) ) {
					$post_custom_css = strip_tags( $post_custom_css );
					londres_set_custom_inline_css($post_custom_css);
				}
			}
		?>
		</div>
	</section>
	<?php
		
	$menuLocations = get_nav_menu_locations();
	
	$menuID = 0;
	if (isset($menuLocations['PrimaryNavigation'])){
		$menuID = $menuLocations['PrimaryNavigation'];
	}
	
	if (function_exists('icl_object_id')){
		global $sitepress;
		$current_lang = $sitepress->get_current_language();
		$default_lang = $sitepress->get_default_language();
		if ($current_lang!=$default_lang){
			$table_name = $wpdb->base_prefix."icl_translations";
			$q = "SELECT trid FROM {$table_name} WHERE element_type LIKE 'tax_nav_menu' AND element_id=%d";
			$res = $wpdb->get_results($wpdb->prepare($q, $menuID), OBJECT);
			if (!empty($res)){			
				$trid = (int) $res[0]->trid;
				$q = "SELECT element_id FROM {$table_name} WHERE language_code LIKE '".$current_lang."' AND trid=%d";
				$res = $wpdb->get_results($wpdb->prepare($q, $trid), OBJECT);
				if (!empty($res)) $menuID = (int) $res[0]->element_id;
			}
		}
	}
	
	$theMenus = wp_get_nav_menus($menuID);
	$theMenu = array();
	
	for ($idx = 0; $idx < count($theMenus); $idx++){
		if ($theMenus[$idx]->term_id == $menuID){
			$theMenu = $theMenus[$idx];
		}
	}
	
	if (!empty($theMenu)){
		$args = array(
	        'order'                  => 'ASC',
	        'orderby'                => 'menu_order',
	        'post_type'              => 'nav_menu_item',
	        'post_status'            => 'publish',
	        'output'                 => ARRAY_A,
	        'output_key'             => 'menu_order',
	        'nopaging'               => true,
	        'update_post_term_cache' => false 
	    );
		$items = wp_get_nav_menu_items( $theMenu->slug, $args );
		
		$outsiders = array();
		foreach ($items as $i){
			$thisID = $i->object_id;
			$template = get_post_meta($thisID, '_wp_page_template', true);
			
			if ($this_page_id != $thisID){
				if ($template === "one-page-template.php"){
					$thepost = get_post($thisID);
					?>
					<section class="page_content section_page-<?php echo esc_attr($thisID); ?>" id="section_page-<?php echo esc_attr($thisID); ?>" data-section-title="<?php echo esc_attr($thepost->post_title); ?>">
						<div class="container">
						<?php
							$content = $thepost->post_content;
							if(stripos($content, 'font_call:')){
								preg_match_all('/font_call:(.*?)"/',$content, $display);
								if (function_exists('enquque_ultimate_google_fonts_optimzed')) enquque_ultimate_google_fonts_optimzed($display[1]);
							}
							$upper_theme_main_color = "#".get_option('londres_style_color');
							$content = str_replace( '__USE_THEME_MAIN_COLOR__', $upper_theme_main_color, $content );
							londres_content_shortcoder($content);
							$content = apply_filters('the_content', $content);
							if (function_exists('wpb_js_remove_wpautop') == true)
								echo wpb_js_remove_wpautop($content);
							else echo wp_kses_post($content); 
							
							/* custom element css */
							$shortcodes_custom_css = get_post_meta( $thisID, '_wpb_shortcodes_custom_css', true );
							if ( ! empty( $shortcodes_custom_css ) ) {
								londres_set_custom_inline_css($shortcodes_custom_css);
							}
							$post_custom_css = get_post_meta( $thisID, '_wpb_post_custom_css', true );
							if ( ! empty( $post_custom_css ) ) {
								$post_custom_css = strip_tags( $post_custom_css );
								londres_set_custom_inline_css($post_custom_css);
							}
						?>
						</div>
					</section>
					<?php
				} else {
					array_push($outsiders, $thisID);
				}	
			}
			
		}
	}
		
	?>
	
		    		
<?php get_footer(); ?>