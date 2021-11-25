<?php
	
function londres_print_menu($ispagephp = true, $isfirstpage = false){
	global $londres_header_bgstyle_pre, $londres_header_bgstyle_after;
	$header_shrink = "";
	if (get_option('londres_fixed_menu') == 'on'){
		if (get_option('londres_header_after_scroll') == 'on'){
			if (get_option('londres_header_shrink_effect') == 'on'){
				$header_shrink = " header_shrink";
			}
		}
	}
	$header_after_scroll = false;
	if (get_option('londres_fixed_menu') == 'on'){
		if (get_option('londres_header_after_scroll') == 'on'){
			$header_after_scroll = true;
		}
	}
	$typeofheader = get_option("londres_header_style_type");
	?>
	
	<header class="navbar navbar-default navbar-fixed-top <?php echo esc_attr($typeofheader); ?> <?php if (get_option('londres_fixed_menu') == 'off') echo " header_not_fixed"; else if (get_option('londres_header_hide_on_start') == "on" && !$ispagephp) echo " hide-on-start"; ?><?php if (get_option("londres_header_full_width") == "on") echo " header-full-width"; ?><?php if (get_option("londres_header_full_width") == "off") echo " header-with-container"; ?><?php if (get_option("londres_header_menu_itens_style") == "rounded") echo " menu-rounded"; ?><?php if (get_option("londres_header_menu_itens_style") == "simple") echo " menu-simple"; ?><?php if (get_option("londres_header_menu_itens_style") == "square") echo " menu-square"; ?><?php echo " ".esc_attr($londres_header_bgstyle_pre); ?>" data-rel="<?php echo esc_attr($londres_header_bgstyle_pre."|".$londres_header_bgstyle_after); ?>">
		
		<?php

		if (get_option("londres_info_above_menu") == "on"){
			?>
			<div class="top-bar">
				<div class="top-bar-bg">
					<div class="container clearfix">
						<div class="slidedown">
						    <div class="col-xs-12 col-sm-12">
							<?php
								// social icons 
								if (get_option("londres_enable_socials") == "on"){
									?>
										<div class="social-icons-fa">
									        <ul>
											<?php
												$icons = array(array("facebook","Facebook"),array("twitter","Twitter"),array("tumblr","Tumblr"),array("stumbleupon","Stumble Upon"),array("flickr","Flickr"),array("linkedin","LinkedIn"),array("delicious","Delicious"),array("skype","Skype"),array("digg","Digg"),array("google-plus","Google+"),array("vimeo-square","Vimeo"),array("deviantart","DeviantArt"),array("behance","Behance"),array("instagram","Instagram"),array("wordpress","WordPress"),array("youtube","Youtube"),array("reddit","Reddit"),array("rss","RSS"),array("soundcloud","SoundCloud"),array("pinterest","Pinterest"),array("dribbble","Dribbble"),array("vk","Vk"),array("yelp","Yelp"),array("twitch","Twitch"),array("houzz","Houzz"),array("foursquare","Foursquare"),array("slack","Slack"),array("whatsapp","Whatsapp"));
												foreach ($icons as $i){
													if (is_string(get_option("londres_icon-".$i[0])) && get_option("londres_icon-".$i[0]) != ""){
													?>
													<li>
														<a href="<?php echo esc_url(get_option("londres_icon-".$i[0])); ?>" target="_blank" class="<?php echo esc_attr(strtolower($i[0])); ?>" title="<?php echo esc_attr($i[1]); ?>"><i class="fa fa-<?php echo esc_attr(strtolower($i[0])); ?>"></i></a>
													</li>
													<?php
													}
												}
											?>
										    </ul>
										</div>
									<?php	
								}
								// company infos 
								if ( get_option("londres_telephone_menu") != "" || get_option("londres_email_menu") != "" || get_option("londres_address_menu") != "" || get_option("londres_text_field_menu") != "" ){
									?>
									<ul class="phone-mail">
										<?php if ( is_string(get_option("londres_telephone_menu")) && get_option("londres_telephone_menu") != "" ){ ?>
											<li><i class="fa fa-phone"></i><?php printf(esc_html__("%s", "londres"), get_option("londres_telephone_menu")); ?></li>
										<?php } ?>
										<?php if ( is_string(get_option("londres_email_menu")) && get_option("londres_email_menu") != "" ){ ?>
											<li><i class="fa fa-envelope"></i><a href="mailto:<?php echo esc_attr(get_option("londres_email_menu")); ?>"><?php echo esc_html(get_option("londres_email_menu")); ?></a></li>
										<?php } ?>
										<?php if ( is_string(get_option("londres_address_menu")) && get_option("londres_address_menu") != "" ){ ?>
											<li><i class="fa fa-map-marker"></i><?php echo wp_kses_post(get_option("londres_address_menu")); ?></li>
										<?php } ?>
										<?php if ( is_string(get_option("londres_text_field_menu")) && get_option("londres_text_field_menu") != "" ){ ?>
											<li><i class="fa fa-info-circle"></i><?php echo wp_kses_post(get_option("londres_text_field_menu")); ?></li>
										<?php } ?>
									</ul>
									<?php
								}
								
								// wpml menu
								if (get_option("londres_wpml_menu_widget") == "on") {
									if (function_exists('icl_object_id')) { ?>
										<div class="menu_wpml_widget">	
											<?php do_action('icl_language_selector'); ?>
										</div>
									<?php 
									}
								}
								// topbar menu 
								if (get_option("londres_top_bar_menu") == "on"){
									?>
									<div class="top-bar-menu">
										<?php wp_nav_menu( array( 'theme_location' => 'topbarnav', 'container' => false, 'menu_class' => 'sf-menu', 'menu_id' => 'menu_top_bar', 'fallback_cb' => false )); ?>
									</div>
									<?php
								}
							?>
							</div>
						</div>
					</div>
				</div>
				<a href="#" class="down-button"><i class="fa fa-plus"></i></a><!-- this appear on small devices -->
			</div>
			<?php
			$londres_inline_script = '
				jQuery(document).ready(function(){
					"use strict";
					if (jQuery(this).width() > 768) {
						jQuery("a.down-button").removeClass("current");
						jQuery(".slidedown").removeAttr("style");
					}
					jQuery("a.down-button").on("click", function () {
					  if (jQuery(this).hasClass("current")) {
						  jQuery(this).removeClass("current");
						  jQuery(this).parent().parent().find(".slidedown").slideUp("slow", function(){ jQuery(this).closest(".top-bar").removeClass("opened"); });
						  return false;
					  } else {
						  jQuery(this).addClass("current").closest(".top-bar").addClass("opened");
						  jQuery(this).parent().parent().find(".slidedown").slideDown("slow");
						  return false;
					  }
					});
				});
				jQuery(window).resize(function(){
					if (jQuery(this).width() > 768) {
						jQuery("a.down-button").removeClass("current");
						jQuery(".slidedown").removeAttr("style");
					}
				});
			';
			wp_add_inline_script('londres-global', $londres_inline_script, 'after');
		}
		?>
		
		<div class="nav-container <?php if (get_option("londres_header_full_width") == "off") echo " container"; ?>">
			<div class="navbar-header">
			    <a class="navbar-brand nav-to" href="<?php echo esc_url(home_url("/")); ?>" tabindex="-1">
	        	<?php 
					$londres_header_style_pre = $londres_header_bgstyle_pre == 'dark' ? 'light' : 'dark';
					$londres_header_style_after = $londres_header_bgstyle_after == 'dark' ? 'light' : 'dark';
					
					$alone = true;
    				if (get_option("londres_logo_retina_image_url_".$londres_header_style_pre) != ""){
	    				$alone = false;
    				}
					?>
					<img class="logo_normal <?php if (!$alone) echo "notalone"; ?>" src="<?php echo esc_url(get_option("londres_logo_image_url_".$londres_header_style_pre)); ?>" alt="<?php esc_attr_e("", "londres"); ?>" title="<?php esc_attr_e("", "londres"); ?>">
    					
    				<?php 
    				if (get_option("londres_logo_retina_image_url_".$londres_header_style_pre) != ""){
    				?>
	    				<img class="logo_retina" src="<?php echo esc_url(get_option("londres_logo_retina_image_url_".$londres_header_style_pre)); ?>" alt="<?php esc_attr_e("", "londres"); ?>" title="<?php esc_attr_e("", "londres"); ?>">
    				<?php
					}
					/* londres_header_after_scroll option */
	    			if ($header_after_scroll || get_option('londres_header_hide_on_start') == 'on'){
		    			$alone = true;
	    				if (get_option("londres_logo_retina_image_url_".$londres_header_style_after) != ""){
		    				$alone = false;
	    				}
    					?>
    					<img class="logo_normal logo_after_scroll <?php if (!$alone) echo "notalone"; ?>" alt="<?php esc_attr_e("", "londres"); ?>" title="<?php esc_attr_e("", "londres"); ?>" src="<?php echo esc_url(get_option("londres_logo_image_url_".$londres_header_style_after)); ?>">
	    					
	    				<?php 
	    				if (get_option("londres_logo_retina_image_url_".$londres_header_style_after) != ""){
	    				?>
		    				<img class="logo_retina logo_after_scroll" src="<?php echo esc_url(get_option("londres_logo_retina_image_url_".$londres_header_style_after)); ?>" alt="<?php esc_attr_e("", "londres"); ?>" title="<?php esc_attr_e("", "londres"); ?>">
	    				<?php
    					}
	    			}
	    		?>
				</a>
			</div>
			
			<div class="navbar-collapse collapse">
				<div class="header_style2_menu">
				<?php 
					
					if (!$isfirstpage){
						if ($ispagephp){
							wp_nav_menu( array( 'theme_location' => 'PrimaryNavigation', 'container' => false, 'menu_class' => 'nav navbar-nav navbar-right', 'walker' => new londres_walker_nav_menu_outsider, 'fallback_cb' => esc_html__('You need to assign a Menu to the Main Navigation Location.','londres') ) );
						} 
						else {
							global $homes;
							$homes = 0;
							wp_nav_menu( array( 'theme_location' => 'PrimaryNavigation', 'container' => false, 'menu_class' => 'nav navbar-nav navbar-right', 'walker' => new londres_walker_nav_menu, 'fallback_cb' => esc_html__('You need to assign a Menu to the Main Navigation Location.','londres') ) );
						} 	
					}
					?>
					
					<div class="londres_right_header_icons">
					<?php
					//search trigger
					if (get_option("londres_enable_search") == "on" && $typeofheader != "style4"){
						?>
						<div class="search_trigger"><i class="ion-ios-search-strong"></i></div>
						<?php
					}
					
					londres_print_woocommerce_button();
					
					if (get_option("londres_sliding_panel") == "on"){
						?>					
							<div class="menu-controls sliderbar-menu-controller" title="Sidebar Menu Controller">
								<div class="font-icon custom-font-icon">
									<i class="ion-grid"></i>
									<i class="ion-ios-close-empty"></i>
								</div>
							</div>
						<?php
					}
					?>
					</div>
				</div>
			</div>
			
			<?php
				if (!$isfirstpage){
					?>
					<div id="dl-menu" class="dl-menuwrapper">
						<div class="dl-trigger-wrapper">
							<button class="dl-trigger"></button>
						</div>
						<?php 
							if ($ispagephp){
								wp_nav_menu( array( 'theme_location' => 'PrimaryNavigation', 'container' => false, 'menu_class' => 'dl-menu', 'walker' => new londres_walker_nav_menu_outsider, 'fallback_cb' => esc_html__('You need to assign a Menu to the Main Navigation Location.','londres') ) );
							} 
							else {
								global $homes;
								$homes = 0;
								wp_nav_menu( array( 'theme_location' => 'PrimaryNavigation', 'container' => false, 'menu_class' => 'dl-menu', 'walker' => new londres_walker_nav_menu, 'fallback_cb' => esc_html__('You need to assign a Menu to the Main Navigation Location.','londres') ) );
							} 
						?>
					</div>
					<?php
				}
			?>
			
			<?php
			//the search input
			if (get_option("londres_enable_search") == "on"){
			?>
				<form autocomplete="off" role="search" method="get" class="search_input <?php echo esc_attr(get_option("londres_search_open_effect")); ?>" action="<?php echo esc_url(home_url("/")); ?>">
					<?php
					if ( function_exists('wp_nonce_field') ){
						wp_nonce_field('londres-theme-search','londres-theme-search');
					}
					?>
					<div class="search_close">
						<i class="fa fa-times"></i>
					</div>
					<div class="container">
						<input value="" name="s" class="search_input_value" type="text" placeholder="<?php
							if (function_exists('icl_t')){
						        echo sprintf(esc_attr__("%s", "londres"), icl_t( 'londres', 'Type your search and hit enter...', get_option('londres_search_box_text'))); 
					        } else {
						        echo sprintf(esc_attr__("%s", "londres"), get_option("londres_search_box_text")); 
					        }
						?>" />
						<input class="hidden" type="submit" id="searchsubmit" value="Search" />
						<div class="ajax_search_results"><ul></ul></div>
					</div>
					<?php
						if (function_exists('icl_t')){
							?>
							<input class="hidden" name="lang" type="text" value="<?php echo ICL_LANGUAGE_CODE; ?>" />
							<?php
						}
					?>
				</form>	
				<?php
			}
			?>
			
			<div class="header_style2_contact_info">
				<?php
					if (get_option('londres_style4_email_menu') != ""){
						?>
						<div class="email-contact">
							<div class="icon"><i class="ion-at"></i></div>
							<div class="details">
								<?php
									if (get_option('londres_style4_email_slogan') != ""){
										?>
										<div class="slogan"><?php echo esc_html(get_option('londres_style4_email_slogan')); ?></div>
										<?php
									}
								?>
								<div class="email"><?php echo esc_html(get_option('londres_style4_email_menu')); ?></div>
							</div>
						</div>
						<?php
					}
					if (get_option('londres_style4_telephone_menu') != ""){
						?>
						<div class="telephone-contact">
							<div class="icon"><i class="ion-ios-telephone"></i></div>
							<div class="details">
								<?php
									if (get_option('londres_style4_telephone_slogan') != ""){
										?>
										<div class="slogan"><?php echo esc_html(get_option('londres_style4_telephone_slogan')); ?></div>
										<?php
									}
								?>
								<div class="email"><?php echo esc_html(get_option('londres_style4_telephone_menu')); ?></div>
							</div>
						</div>
						<?php
					}
				?>
			</div>
		</div>
		
	</header>
	<?php
}
	
?>