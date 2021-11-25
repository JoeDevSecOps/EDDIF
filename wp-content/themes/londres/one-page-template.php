<?php
/*
Template Name: One Page Template
*/

/**
 * @package WordPress
 * @subpackage Londres
 */
	get_header();
	
	$londres_reading_option = get_option("londres_blog_reading_type");
	$londres_more = 0; 
	
		$menuLocations = get_nav_menu_locations();
		$this_page_id = get_the_ID();
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
		
		if (is_front_page() && function_exists('vc_is_inline') && !vc_is_inline()){
			wp_enqueue_style('js_composer_front');
			$fonts = get_option('smile_fonts');
			if(is_array($fonts)){
				foreach($fonts as $font => $info){
					if(strpos($info['style'], 'http://' ) !== false) {
						wp_enqueue_style('bsf-'.$font,$info['style']);
					} else {
						$uploadsdir = wp_upload_dir();
						wp_enqueue_style('bsf-'.$font,trailingslashit(set_url_scheme(trailingslashit($uploadsdir['baseurl'])."smile_fonts")).$info['style']);
					}
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
				londres_print_menu(false);
				
				$outsiders = array();
				$firstHome = true;
				ob_start();
				foreach ($items as $i){
					$thisID = $i->object_id;
					$template = get_post_meta($thisID, '_wp_page_template', true);
					
					if ($template === "template-home.php" && $firstHome){
						$firstHome = false;
						$homeType = get_post_meta($thisID, 'homeStyle_value', true);
						switch($homeType){
							case "slider":
								$prlx = (get_post_meta($thisID, 'parallaxEffect_value', true) == 'yes') ? true : false ;
								londres_print_slider($thisID, $prlx);
							break;
							case "image": case "video":
								?>
								<section id="home" class="homepage_parallax <?php echo esc_attr($homeType); if (get_post_meta($thisID, 'parallaxEffect_value', true) == 'yes') echo esc_attr(" parallax"); ?>">
									<?php
										if ($homeType == "image"){
											$media = get_post_meta($thisID, 'homeParallaxMedia_value', true);
											$media = explode("|!|",$media);
											?>
											<div id="parallax-home" <?php if (get_post_meta($thisID, 'parallaxEffect_value', true) == 'yes') echo 'class="parallax" data-stellar-ratio="0.5" '; ?>>
												<?php londres_print_intro($thisID); ?>
											</div>
											<?php
											$londres_output = "#parallax-home{ background-image: url(".esc_url($media[1]).");background-size:cover;text-align:center; }";
											londres_set_custom_inline_css($londres_output);
										} else {
											?>
											<div id="parallax-home" <?php if (get_post_meta($thisID, 'parallaxEffect_value', true) == 'yes') echo 'class="parallax" data-stellar-ratio="0.5"'; ?>>
												<?php londres_print_intro($thisID, true); ?>
												
												<?php
													if (get_post_meta($thisID, 'homeVideoSource_value', true) != 'youtube'){
														?>
														<div class="video-container <?php if (get_post_meta($thisID, 'parallaxEffect_value', true) == 'yes') echo 'parallax'; ?>">
														<?php
														$media = get_post_meta($thisID, 'homeParallaxMedia_video_value', true);
														$media = explode("|!|",$media);
														$controls = (get_post_meta($thisID, 'homeVideoControls_value', true) == 'yes') ? "true" : "false";
														echo do_shortcode("[video src='".esc_url($media[1])."' preload='true' autoplay='true' loop='true' controls='".esc_attr($controls)."']");
														?>
														</div>
														<?php
													}
												?>
											</div>
											<?php
											if (get_post_meta($thisID, 'homeVideoSource_value', true) == 'youtube'){
												$controls = (get_post_meta($thisID, 'homeVideoControls_value', true) == 'yes') ? "true" : "false";
												?>
												<div class="player" data-property="{videoURL:'<?php echo esc_url(get_post_meta($thisID, 'homeYoutubeLink_value', true)); ?>',  optimizeDisplay:true, showControls:<?php echo esc_attr($controls); ?>,containment:'#parallax-home',startAt:0,mute:<?php echo (get_post_meta($thisID,'homeVideoMuted_value', true) == 'yes') ? "true" : "false"; ?>,autoPlay:true,player:true,loop:true,opacity:1,stopMovieOnBlur:true}"></div>
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
						?>
						<section class="page_content" id="section_page-<?php echo esc_attr($thisID); ?>">
							<div class="container">
							<?php echo apply_filters('the_content', get_post_field('post_content', $thisID)); 
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
						if ($template === "one-page-template.php"){
							$thepost = get_post($thisID);
							?>
							<section class="page_content section_page-<?php echo esc_attr($thisID); ?>" id="section_page-<?php echo esc_attr($thisID); ?>" data-section-title="<?php echo esc_attr($thepost->post_title); ?>">
								<div class="container">
								<?php
									$content = function_exists('wpb_js_remove_wpautop') ? wpb_js_remove_wpautop($thepost->post_content, true) : $thepost->post_content;
									if(stripos($thepost->post_content, 'font_call:')){
										preg_match_all('/font_call:(.*?)"/',$thepost->post_content, $display);
										if (function_exists('enquque_ultimate_google_fonts_optimzed')) enquque_ultimate_google_fonts_optimzed($display[1]);
									}
									
									$upper_theme_main_color = "#".get_option('londres_style_color');
									$content = str_replace( '__USE_THEME_MAIN_COLOR__', $upper_theme_main_color, $content );
									
									echo do_shortcode($content);
									/* check the content for ultimate addons shortcodes */
									londres_content_shortcoder($content);
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
			} else {
				echo "You need to assign one Menu to the Main Navigation.";
			}
		} else {
			
			londres_print_menu(true); $londres_color_code = get_option("londres_style_color");
			
			if (get_post_meta($this_page_id, "londres_enable_custom_pagetitle_options_value", true) == "no" || !get_post_meta($this_page_id, "londres_enable_custom_pagetitle_options_value", true)){
				$type = get_option("londres_header_type");
				$thecolor = londres_hex2rgb(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_header_color"))); 
				$opacity = intval(str_replace("%","",get_option("londres_header_opacity")))/100;
				$color = "rgba(".$thecolor[0].",".$thecolor[1].",".$thecolor[2].",".$opacity.")";
				$image = get_option("londres_header_image"); 
				$pattern = is_string(get_option("londres_header_pattern")) ? LONDRES_PATTERNS_URL.get_option("londres_header_pattern") : ""; 
				$custompattern = get_option("londres_header_custom_pattern"); 
				$margintop = get_option("londres_header_text_margin_top");	
				$banner = get_option("londres_banner_slider");
				$showtitle = get_option("londres_hide_pagetitle") == "on" ? true : false;
				$showsectitle = get_option("londres_hide_sec_pagetitle") == "on" ? true : false;
				$tcolor = get_option("londres".'_header_text_color');
				$tsize = intval(str_replace(" ", "", get_option("londres".'_header_text_size')),10)."px";
				$tfont = get_option("londres".'_header_text_font');
				$stcolor = get_option("londres".'_secondary_title_text_color');
				$stsize = intval(str_replace(" ", "", get_option("londres".'_secondary_title_text_size')),10)."px";
				$stfont = get_option("londres".'_secondary_title_font');
				$stmargin = intval(str_replace(" ", "", get_option("londres".'_header_sec_text_margin_top')),10)."px";
				$originalalign = get_option("londres_header_text_alignment");
				$pt_parallax = get_option("londres_pagetitle_image_parallax") == "on" ? true : false;
				$pt_overlay = get_option("londres_pagetitle_image_overlay") == "on" ? true : false;
				$pt_overlay_type = get_option("londres_pagetitle_overlay_type");
				$pt_overlay_the_color = londres_hex2rgb(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_pagetitle_overlay_color")));
				$pt_overlay_pattern = is_string(get_option("londres_pagetitle_overlay_pattern")) ? LONDRES_PATTERNS_URL.get_option("londres_pagetitle_overlay_pattern") : "";
				$pt_overlay_opacity = intval(str_replace("%","",get_option("londres_pagetitle_overlay_opacity")))/100;
				$pt_overlay_color = "rgba(".$pt_overlay_the_color[0].",".$pt_overlay_the_color[1].",".$pt_overlay_the_color[2].",".$pt_overlay_opacity.")";
				$breadcrumbs = get_option("londres_breadcrumbs");
				$breadcrumbs_margintop = get_option('londres_breadcrumbs_text_margin_top');
				$pagetitlepadding = get_option('londres_page_title_padding');
			} else {
				$type = get_post_meta($this_page_id, "londres_header_type_value", true);
				$thecolor = londres_hex2rgb(get_post_meta($this_page_id, "londres_header_color_value", true)); 
				$opacity = intval(str_replace("%","",get_post_meta($this_page_id, "londres_header_color_opacity_value", true)))/100;
				$color = "rgba(".$thecolor[0].",".$thecolor[1].",".$thecolor[2].",".$opacity.")";
				$image = get_post_meta($this_page_id, "londres_header_image_value", true);
				$image = explode('|!|',$image);
				if (isset($image[1])) $image = explode('|*|',$image[1]);
				$image = $image[0];
				$pattern = LONDRES_PATTERNS_URL.get_post_meta($this_page_id, "londres_header_pattern_value", true).".jpg";
				$custompattern = get_option("londres_header_custom_pattern_value"); 
				$margintop = get_post_meta($this_page_id, "londres_header_text_margin_top_value", true);
				$banner = get_post_meta($this_page_id, "londres_banner_slider_value", true);
				$showtitle = get_post_meta($this_page_id, "londres_hide_pagetitle_value", true) == "yes" ? true : false;
				$showsectitle = get_post_meta($this_page_id, "londres_hide_sec_pagetitle_value", true) == "yes" ? true : false;
				$tcolor = get_post_meta($this_page_id, "londres_header_text_color_value", true);
				$tsize = intval(str_replace(" ", "", get_post_meta($this_page_id, "londres_header_text_size_value", true)),10)."px";
				$tfont = get_post_meta($this_page_id, "londres_header_text_font_value", true);
				$stcolor = get_post_meta($this_page_id, "londres_secondary_title_text_color_value", true);
				$stsize = intval(str_replace(" ", "", get_post_meta($this_page_id, "londres_secondary_title_text_size_value", true)),10)."px";
				$stfont = get_post_meta($this_page_id, "londres_secondary_title_font_value", true);
				$stmargin = intval(str_replace(" ", "", get_post_meta($this_page_id, "londres_header_secondary_text_margin_top_value", true)),10)."px";
				$originalalign = get_post_meta($this_page_id, "londres_header_text_alignment_value", true);
				$pt_parallax = get_post_meta($this_page_id, "londres_pagetitle_image_parallax_value", true) == "on" ? true : false;
				$pt_overlay = get_post_meta($this_page_id, "londres_pagetitle_image_overlay_value", true) == "on" ? true : false;
				$pt_overlay_type = get_post_meta($this_page_id, "londres_pagetitle_overlay_type_value", true);
				$pt_overlay_the_color = londres_hex2rgb(get_post_meta($this_page_id, "londres_pagetitle_overlay_color_value", true));
				$pt_overlay_pattern = LONDRES_PATTERNS_URL.get_post_meta($this_page_id, "londres_pagetitle_overlay_pattern_value", true);
				$pt_overlay_opacity = intval(str_replace("%","",get_post_meta($this_page_id, "londres_pagetitle_overlay_opacity_value", true)))/100;
				$pt_overlay_color = "rgba(".$pt_overlay_the_color[0].",".$pt_overlay_the_color[1].",".$pt_overlay_the_color[2].",".$pt_overlay_opacity.")";
				$breadcrumbs = get_post_meta($this_page_id, "londres_enable_breadcrumbs_value", true) == "yes" ? "on" : "off";
				$breadcrumbs_margintop = intval(str_replace(" ", "", get_post_meta($this_page_id, "londres_breadcrumbs_margin_top_value", true)),10)."px";
				$pagetitlepadding = intval(str_replace(" ", "", get_post_meta($this_page_id, "londres_page_title_padding_value", true)),10)."px";
			}
			$height = "auto";
		
			$textalign = $originalalign;
			if ($originalalign == "titlesleftcrumbsright") $textalign = "left";
			if ($originalalign == "titlesrightcrumbsleft") $textalign = "right";
			
			$londres_import_fonts[] = $tfont;
			$principalfont = explode("|",$tfont);
			if ($principalfont[0] == "Helvetica" || $principalfont[0] == "Helvetica Neue") $principalfont[0] = $principalfont[0]."', 'Arial', 'sans-serif";
			if (!isset($principalfont[1])) $principalfont[1] = "";
				
			$londres_import_fonts[] = $stfont;
			$secondaryfont = explode("|",$stfont);
			if ($secondaryfont[0] == "Helvetica" || $secondaryfont[0] == "Helvetica Neue") $secondaryfont[0] = $secondaryfont[0]."', 'Arial', 'sans-serif";
			if (!isset($secondaryfont[1])) $secondaryfont[1] = "";
				
			if ($type != "without"){
				
				$ptitleaux = $bcaux = "";
				if ($originalalign == "titlesleftcrumbsright" || $originalalign == "titlesrightcrumbsleft"){
		    		$ptitleaux .= "max-width: 50%;";
		    		$bcaux .= "max-width: 50%;";
		    		if ($originalalign == "titlesleftcrumbsright"){
						$ptitleaux .= "float:left;";
						$bcaux .= "float:right;";
					} else {
						$ptitleaux .= "float:right;";
						$bcaux .= "float:left;";
					}
				}
				$bcaux .= "margin-top:".intval($breadcrumbs_margintop,10)."px;";
				switch($originalalign){
					case "left": case "titlesrightcrumbsleft":
						$bcaux .= "text-align: left;";
					break;
					case "right": case "titlesleftcrumbsright":
						$bcaux .= "text-align:right;";
					break;
					case "center": 
						$bcaux .= "text-align:center;";
					break;
				}
				?>
				<div class="fullwidth-container <?php if ($type == "pattern") echo "bg-pattern"; ?> <?php if ($pt_parallax) echo "parallax"; ?><?php if (($type == "image" || $type == "pattern") && get_option('londres_enable_grayscale') == 'on') echo " londres_grayscale "; ?>" <?php if ($pt_parallax) echo 'data-stellar-ratio="0.5"'; ?> 
			    	<?php
				    	$londres_output = ".fullwidth-container{";
				 		if ($height != "") $londres_output.= "height: ". $height . ";";
						if ($type == "none") $londres_output.= "background: none;"; 
						if ($type == "color") $londres_output.= "background: " . $color . ";";
						if ($type == "image") $londres_output.= "background: url(" . $image . ") no-repeat; background-size: 100% auto;";  
			 			if ($type == "pattern") $londres_output.= "background: url('" . $pattern . "') 0 0 repeat;";
						$londres_output .= "}";
						londres_set_custom_inline_css($londres_output);
		
			    	?> <?php if ($type == "image" && !$pt_parallax) echo ' data-background-alignment="center" '; ?>>
			    	<?php
				    	if ($type == "image" && $pt_overlay){
					    	$londres_output = ".pagetitle_overlay{";
					    	echo '<div class="pagetitle_overlay"></div> '; 
					    	if ($pt_overlay_type == "color") $londres_output.= 'background-color:'.$pt_overlay_color.' !important';
					    	else $londres_output.= 'background:url('.$pt_overlay_pattern.') repeat;opacity:'.$pt_overlay_opacity.' !important;';
					    	$londres_output .= "}";
							londres_set_custom_inline_css($londres_output);
				    	}
				    	if ($type === "banner"){
					    	?> 
					    	<div class="revBanner">
						    	<?php
							    	if (substr($banner, 0, 10) === "revSlider_"){
										if (!function_exists('putRevSlider')){
											echo esc_html__('Please install the missing plugin - Revolution Slider.', 'londres');
										} else {
											putRevSlider(substr($banner, 10));
										}
									} 
									if (substr($banner, 0, 13) === "masterSlider_"){
										if (!function_exists('masterslider')){
											echo esc_html__('Please install the missing plugin - MasterSlider.', 'londres');
										} else {
											echo do_shortcode( '[masterslider alias="'.substr($banner, 13).'"]' );
										}
									}
						    	?>
						    </div> 
						    <?php
				    	} else {
				    	?>
						<div class="container present-container <?php echo esc_attr($originalalign); ?>">
							<?php
								$londres_output = ".present-container{padding: ".esc_attr($pagetitlepadding)." 15px;}";
								londres_set_custom_inline_css($londres_output);
							?>
							<div class="pageTitle">
							<?php
								$londres_output = ".present-container .pageTitle{text-align: ".esc_attr($textalign).";".esc_attr($ptitleaux)."}";
								londres_set_custom_inline_css($londres_output);
								if ($showtitle){
									?>
									<h1 class="page_title">
										<?php if (is_front_page() && is_home()) echo wp_kses_post(get_option('londres_blog_single_primary_title')); else echo wp_kses_post(get_the_title($this_page_id)); ?>
									</h1>
									<?php
									$londres_output = ".present-container h1.page_title{color: #$tcolor; font-size: $tsize; font-family: '{$principalfont[0]}';font-weight: {$principalfont[1]};";
									if ($margintop != "") $londres_output .= esc_attr("margin-top: ".intval($margintop,10)."px;");
									$londres_output .= "}";
									londres_set_custom_inline_css($londres_output);
								}
				    			if ($showsectitle){
					    			if (get_post_meta($post->ID, 'secondaryTitle_value', true) != "" || get_option('londres_blog_secondary_title') != ""){
								    	?>
									    <h2 class="secondaryTitle">
									    	<?php echo wp_kses_post(get_post_meta($post->ID, 'secondaryTitle_value', true)); ?>
									    </h2>
							    		<?php
								    	$londres_output = ".present-container .secondaryTitle{color: #$stcolor; font-size: $stsize; line-height: $stsize; font-family: '{$secondaryfont[0]}';font-weight:{$secondaryfont[1]}; margin-top:{$stmargin};}";
										londres_set_custom_inline_css($londres_output);
							    	}
				    			}
				    		?>

				    		</div>
				    		<?php
				    		if ($breadcrumbs == "on"){
					    		?>
					    		<div class="londres_breadcrumbs">
									<?php 
										londres_the_breadcrumb(); 
										$londres_output = ".londres_breadcrumbs{".esc_attr($bcaux)."}";
										londres_set_custom_inline_css($londres_output);
									?>
					    		</div>
					    		<?php
							}
							?>
						</div>
				<?php }
				?>
				</div>	
				<?php
			}
			
			
			?>
			<div class="master_container master_container_bgwhite">
				<section class="page_content" id="section-<?php echo esc_attr($this_page_id); ?>">
					<div class="container">
					<?php
						if ((function_exists('vc_is_inline') && vc_is_inline()) || is_preview()){
							wp_reset_postdata();
							the_content();
						} else {
							$thepost = get_post($this_page_id);
							$content = function_exists('wpb_js_remove_wpautop') ? wpb_js_remove_wpautop($thepost->post_content, true) : $thepost->post_content;
							if(stripos($thepost->post_content, 'font_call:')){
								preg_match_all('/font_call:(.*?)"/',$thepost->post_content, $display);
								if (function_exists('enquque_ultimate_google_fonts_optimzed')) enquque_ultimate_google_fonts_optimzed($display[1]);
							}
							
							$upper_theme_main_color = "#".get_option('londres_style_color');
							$content = str_replace( '__USE_THEME_MAIN_COLOR__', $upper_theme_main_color, $content );
							
							echo do_shortcode($content);
							/* check the content for ultimate addons shortcodes */
							londres_content_shortcoder($content);
							/* custom element css */
							$shortcodes_custom_css = get_post_meta( $this_page_id, '_wpb_shortcodes_custom_css', true );
							if ( ! empty( $shortcodes_custom_css ) ) {
								londres_set_custom_inline_css($shortcodes_custom_css);
							}
							$post_custom_css = get_post_meta( $this_page_id, '_wpb_post_custom_css', true );
							if ( ! empty( $post_custom_css ) ) {
								londres_set_custom_inline_css($post_custom_css);
							}
						}
						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'londres' ),
							'after'  => '</div>',
						) );
					?>
					</div>
				</section>
			</div>
			<?php

		}	
?>

<div class="clear"></div>
	
	
<?php get_footer(); ?>