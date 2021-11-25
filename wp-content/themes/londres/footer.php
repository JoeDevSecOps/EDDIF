<?php
/**
 * @package WordPress
 * @subpackage Londres
 */
?>
	
	<div id="big_footer" <?php if (get_option("londres_footer_full_width") == "on") echo " class='footer-full-width'"; ?>>

		<?php
		if (get_option("londres_show_primary_footer") == "on"){
			?>
			<div id="primary_footer">
			    	<?php
			    	/* Show Newsletter in Footer */
					if (get_option("londres_newsletter_enabled") == "on"){
						$code = get_option("londres_mailchimp_code");
						if (!empty($code)){
						    $output = '<div class="footer_newsletter"><div class="mail-box"><div class="mail-news container"><div class="news-l"><div class="banner"><h3>'.sprintf(esc_html("%s", "londres"), get_option("londres_newsletter_text")).'</h3><p>'.sprintf(esc_html("%s", "londres"), get_option("londres_newsletter_stext")).'</p></div><div class="form">';
						    if (function_exists('icl_t')){
							    $output = '<div class=""><div class="mail-box"><div class="mail-news"><div class="news-l"><div class="banner"><h3>'.wp_kses_post(icl_t( 'londres', 'Subscribe our <span>Newsletter</span>', get_option('londres_newsletter_text'))).'</h3><p>'.wp_kses_post(icl_t( 'londres', 'Subscribe to our newsletter to receive news, cool free stuff updates and new released products (no spam!)', get_option('londres_newsletter_stext'))).'</p></div><div class="form">';
						    }
							$output .= stripslashes($code);
							$output .= '</div></div></div></div></div>';			
						} else {
							$output = '<div class="">'.esc_html__('You need to fill the inputs on the Appearance > Londres Options > Newsletter panel in order to work.','londres').'</div>';
						}			
						$output = wp_kses_no_null( $output, array( 'slash_zero' => 'keep' ) );
						$output = wp_kses_normalize_entities($output);
						echo wp_kses_hook($output, 'post', array()); // WP changed the order of these funcs and added args to wp_kses_hook		
					
					}?>
			    	<div class="<?php if (get_option("londres_footer_full_width") == "off") echo "container"; ?> no-fcontainer">
			    		
	    		<?php
	    		
					if(get_option("londres_footer_number_cols") == "one"){ ?>
						<div class="footer_sidebar col-xs-12 col-md-12"><?php londres_print_sidebar('footer-one-column'); ?></div>
					<?php }
					if(get_option("londres_footer_number_cols") == "two"){ ?>
						<div class="footer_sidebar col-xs-12 col-md-6"><?php londres_print_sidebar('footer-two-column-left'); ?></div>
						<div class="footer_sidebar col-xs-12 col-md-6"><?php londres_print_sidebar('footer-two-column-right'); ?></div>
					<?php }
					if(get_option("londres_footer_number_cols") == "three"){
						if(get_option("londres_footer_columns_order") == "one_three"){ ?>
							<div class="footer_sidebar col-xs-12 col-md-4"><?php londres_print_sidebar('footer-three-column-left'); ?></div>
							<div class="footer_sidebar col-xs-12 col-md-4"><?php londres_print_sidebar('footer-three-column-center'); ?></div>
							<div class="footer_sidebar col-xs-12 col-md-4"><?php londres_print_sidebar('footer-three-column-right'); ?></div>
						<?php }
						if(get_option("londres_footer_columns_order") == "one_two_three"){ ?>
							<div class="footer_sidebar col-xs-12 col-md-4"><?php londres_print_sidebar('footer-three-column-left-1_3'); ?></div>
							<div class="footer_sidebar col-xs-12 col-md-8"><?php londres_print_sidebar('footer-three-column-right-2_3'); ?></div>
						<?php }
						if(get_option("londres_footer_columns_order") == "two_one_three"){ ?>
							<div class="footer_sidebar col-xs-12 col-md-8"><?php londres_print_sidebar('footer-three-column-left-2_3'); ?></div>
							<div class="footer_sidebar col-xs-12 col-md-4"><?php londres_print_sidebar('footer-three-column-right-1_3'); ?></div>
						<?php }
					}
					if(get_option("londres_footer_number_cols") == "four"){
						if(get_option("londres_footer_columns_order_four") == "one_four"){ ?>
							<div class="footer_sidebar col-xs-12 col-md-3"><?php londres_print_sidebar('footer-four-column-left'); ?></div>
							<div class="footer_sidebar col-xs-12 col-md-3"><?php londres_print_sidebar('footer-four-column-center-left'); ?></div>
							<div class="footer_sidebar col-xs-12 col-md-3"><?php londres_print_sidebar('footer-four-column-center-right'); ?></div>
							<div class="footer_sidebar col-xs-12 col-md-3"><?php londres_print_sidebar('footer-four-column-right'); ?></div>
						<?php }
						if(get_option("londres_footer_columns_order_four") == "two_one_two_four"){ ?>
							<div class="footer_sidebar col-xs-12 col-md-3"><?php londres_print_sidebar('footer-four-column-left-1_2_4'); ?></div>
							<div class="footer_sidebar col-xs-12 col-md-6"><?php londres_print_sidebar('footer-four-column-center-2_2_4'); ?></div>
							<div class="footer_sidebar col-xs-12 col-md-3"><?php londres_print_sidebar('footer-four-column-right-1_2_4'); ?></div>
						<?php }
						if(get_option("londres_footer_columns_order_four") == "three_one_four"){ ?>
							<div class="footer_sidebar col-xs-12 col-md-8"><?php londres_print_sidebar('footer-four-column-left-3_4'); ?></div>
							<div class="footer_sidebar col-xs-12 col-md-4"><?php londres_print_sidebar('footer-four-column-right-1_4'); ?></div>
						<?php }
						if(get_option("londres_footer_columns_order_four") == "one_three_four"){ ?>
							<div class="footer_sidebar col-xs-12 col-md-4"><?php londres_print_sidebar('footer-four-column-left-1_4'); ?></div>
							<div class="footer_sidebar col-xs-12 col-md-8"><?php londres_print_sidebar('footer-four-column-right-3_4'); ?></div>
						<?php }
					}
				?>
				</div>
		    </div>
		    
		    <?php
			if ( get_option('londres_display_instagram_footer') == 'on' && defined('LONDRES_PLG_ACTIVE') === true ){
				?>
				<div id="footer-instagram">
					<?php
					if (get_option('londres_instagram_title') != "" || get_option('londres_instagram_title')!=" ") echo "<h4>" . wp_kses_post( get_option('londres_instagram_title') ) . "</h4>";
					if (function_exists('upper_scrape_instagram')) upper_scrape_instagram();
					?>
				</div>
				<?php
		    }
		}
	?>
    
    <?php
	    if (get_option("londres_show_sec_footer") == "on"){
		    $londres_is_only_custom_text = (get_option("londres_footer_display_logo") != 'on' && get_option("londres_footer_display_social_icons") != "on") ? true : false;
		    ?>
		    <div id="secondary_footer">
				<div class="container <?php if ($londres_is_only_custom_text) echo "only_custom_text"; ?>">
					
					<?php
						/* FOOTER LOGOTYPE */
						if (get_option("londres_footer_display_logo") == 'on'){
						?>
						<a class="footer_logo align-<?php echo esc_attr(get_option("londres_footer_logo_alignment")); ?>" href="<?php echo esc_url(home_url("/")); ?>" tabindex="-1">
				        	<?php
				    			$alone = true;
			    				if (get_option("londres_footer_logo_retina_image_url") != ""){
				    				$alone = false;
			    				}
		    					?>
		    					<img class="footer_logo_normal <?php if (!$alone) echo "notalone"; ?>" src="<?php echo esc_url(get_option("londres_footer_logo_image_url")); ?>" alt="<?php esc_attr_e("", "londres"); ?>" title="<?php esc_attr_e("", "londres"); ?>">
			    					
			    				<?php 
			    				if (get_option("londres_footer_logo_retina_image_url") != ""){
			    				?>
				    				<img class="footer_logo_retina" src="<?php echo esc_url(get_option("londres_footer_logo_retina_image_url")); ?>" alt="<?php esc_attr_e("", "londres"); ?>" title="<?php esc_attr_e("", "londres"); ?>">
			    				<?php
		    					}
			    			?>
				        </a>
						<?php
						}
						
						
						
						/* FOOTER SOCIAL ICONS */
						if (get_option("londres_footer_display_social_icons") == "on"){
						?>
						<div class="social-icons-fa align-<?php echo esc_attr(get_option("londres_footer_social_icons_alignment")); ?>">
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
						/* FOOTER CUSTOM TEXT */
						if (get_option("londres_footer_display_custom_text") == "on"){
						?>
						<div class="footer_custom_text <?php if ($londres_is_only_custom_text) echo "wide"; else echo esc_attr(get_option("londres_footer_custom_text_alignment")); ?>"><?php echo do_shortcode(stripslashes(get_option("londres_footer_custom_text"))); ?></div>
						<?php
						}
						
					?>
				</div>
			</div>
		    <?php
	    }
    ?>
	</div>
</div> <!-- END OF MAIN -->
<?php
	if (get_option("londres_enable_gotop") == "on"){
		?>
		<p id="back-top"><a href="#home"><i class="ion-chevron-up"></i></a></p>
		<?php
	}
	
	londres_get_team_profiles_content();
	londres_get_custom_inline_css();

	if (get_option("londres_body_type") == "body_boxed"){
		?>
		</div>
		<?php
	}
	
	wp_footer(); 
?>
</body>
</html>