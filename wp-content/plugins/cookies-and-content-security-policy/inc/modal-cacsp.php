<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if ( !get_cacsp_options( 'cacsp_option_only_csp' ) && !is_admin() ) {
	add_action( 'wp_footer', 'modal_content_security_policy' );
	function modal_content_security_policy(){
		if ( cacsp_option_actived() ) {
			$cacsp_option_banner = get_cacsp_options( 'cacsp_option_banner' );
			$cacsp_option_banner_class = '';
			if ( $cacsp_option_banner ) {
				$cacsp_option_banner_class = ' modal-cacsp-box-bottom';
			}
			?>
			<!--googleoff: index-->
			<div class="modal-cacsp-backdrop"></div>
			<div class="modal-cacsp-position">
				<div class="modal-cacsp-box modal-cacsp-box-info<?php echo $cacsp_option_banner_class; ?>">
					<div class="modal-cacsp-box-header">
						<?php echo get_cacsp_options( 'cacsp_option_text_header', false, __( 'Cookies', 'cookies-and-content-security-policy' ) ); ?>
					</div>
					<div class="modal-cacsp-box-content">
						<?php echo get_cacsp_options( 'cacsp_option_text_info', false, __( 'We serve cookies. If you think that\'s ok, just click "Accept all". You can also choose what kind of cookies you want by clicking "Settings".', 'cookies-and-content-security-policy' ) ); ?>
						<?php 
						$cacsp_option_settings_policy_link_target = '';
						if ( get_cacsp_options( 'cacsp_option_settings_policy_link_target' ) ) {
							$cacsp_option_settings_policy_link_target = ' target="_blank" rel="noopener noreferrer"';
						}
						if ( get_cacsp_options( 'cacsp_option_settings_policy_link_url' ) ) { ?>
							<a href="<?php echo get_cacsp_options( 'cacsp_option_settings_policy_link_url' ); ?>"<?php echo $cacsp_option_settings_policy_link_target?>>
								<?php echo get_cacsp_options( 'cacsp_option_text_link_text', false, __( 'Read our cookie policy', 'cookies-and-content-security-policy' ) ); ?>
							</a>
						<?php } else if ( get_cacsp_options( 'cacsp_option_settings_policy_link' ) ) { ?>
							<a href="<?php echo get_permalink( get_cacsp_options( 'cacsp_option_settings_policy_link' ) ); ?>"<?php echo $cacsp_option_settings_policy_link_target?>>
								<?php echo get_cacsp_options( 'cacsp_option_text_link_text', false, __( 'Read our cookie policy', 'cookies-and-content-security-policy' ) ); ?>
							</a>
						<?php } ?>
					</div>
					<div class="modal-cacsp-btns">
						<a href="#" class="modal-cacsp-btn modal-cacsp-btn-settings">
							<?php echo get_cacsp_options( 'cacsp_option_settings_button', false, __( 'Settings', 'cookies-and-content-security-policy' ) ); ?>
						</a>
						<?php 
						$cacsp_option_show_refuse_button = get_cacsp_options( 'cacsp_option_show_refuse_button' );
						if ( $cacsp_option_show_refuse_button ) { ?>
						<a href="#" class="modal-cacsp-btn modal-cacsp-btn-refuse">
							<?php echo get_cacsp_options( 'cacsp_option_refuse_button', false, __( 'Refuse all', 'cookies-and-content-security-policy' ) ); ?>
						</a>
						<?php } ?>
						<a href="#" class="modal-cacsp-btn modal-cacsp-btn-accept">
							<?php echo get_cacsp_options( 'cacsp_option_accept_all_button', false, __( 'Accept all', 'cookies-and-content-security-policy' ) ); ?>
						</a>
					</div>
				</div>
				<div class="modal-cacsp-box modal-cacsp-box-settings">
					<div class="modal-cacsp-box-header">
						<?php echo get_cacsp_options( 'cacsp_option_text_header', false, __( 'Cookies', 'cookies-and-content-security-policy' ) ); ?>
					</div>
					<div class="modal-cacsp-box-content">
						<?php echo get_cacsp_options( 'cacsp_option_text_settings', false, __( 'Choose what kind of cookies to accept. Your choice will be saved for one year.', 'cookies-and-content-security-policy' ) ); ?>
						<?php 
						if ( get_cacsp_options( 'cacsp_option_settings_policy_link_url' ) ) { ?>
							<a href="<?php echo get_cacsp_options( 'cacsp_option_settings_policy_link_url' ); ?>"<?php echo $cacsp_option_settings_policy_link_target?>>
								<?php echo get_cacsp_options( 'cacsp_option_text_link_text', false, __( 'Read our cookie policy', 'cookies-and-content-security-policy' ) ); ?>
							</a>
						<?php } else if ( get_cacsp_options( 'cacsp_option_settings_policy_link' ) ) { ?>
							<a href="<?php echo get_permalink( get_cacsp_options( 'cacsp_option_settings_policy_link' ) ); ?>"<?php echo $cacsp_option_settings_policy_link_target?>>
								<?php echo get_cacsp_options( 'cacsp_option_text_link_text', false, __( 'Read our cookie policy', 'cookies-and-content-security-policy' ) ); ?>
							</a>
						<?php } ?>
					</div>
					<div class="modal-cacsp-box-settings-list">
						<?php
						$cacsp_option_hide_unused_settings_row = false;
						if ( get_cacsp_options( 'cacsp_option_hide_unused_settings_row' ) ) {
							 $cacsp_option_hide_unused_settings_row = true;
						}
						?>
						<ul>
							<li>
								<span class="modal-cacsp-toggle-switch modal-cacsp-toggle-switch-active disabled" data-accepted-cookie="necessary">
									<span><?php echo get_cacsp_options( 'cacsp_option_text_always_allow_header', false, __( 'Necessary', 'cookies-and-content-security-policy' ) ); ?><br>
										<span><?php echo get_cacsp_options( 'cacsp_option_text_always_allow_description', false, __( 'These cookies are not optional. They are needed for the website to function.', 'cookies-and-content-security-policy' ) ); ?></span>
									</span>
									<span>
										<span class="modal-cacsp-toggle">
											<span class="modal-cacsp-toggle-switch-handle"></span>
										</span>
									</span>
								</span>
							</li>
							<?php
							$li_style = '';
							if ( $cacsp_option_hide_unused_settings_row && !get_cacsp_options( 'cacsp_option_statistics_scripts', true ) && !get_cacsp_options( 'cacsp_option_statistics_images', true ) && !get_cacsp_options( 'cacsp_option_statistics_frames', true ) && !get_cacsp_options( 'cacsp_option_statistics_forms', true ) ) {
									$li_style = ' style="display: none;"';
							}
							?>
							<li<?php echo $li_style; ?>>
								<a href="#statistics" class="modal-cacsp-toggle-switch" data-accepted-cookie="statistics">
									<span><?php echo get_cacsp_options( 'cacsp_option_text_statistics_header', false, __( 'Statistics', 'cookies-and-content-security-policy' ) ); ?><br>
										<span><?php echo get_cacsp_options( 'cacsp_option_text_statistics_description', false, __( 'In order for us to improve the website\'s functionality and structure, based on how the website is used.', 'cookies-and-content-security-policy' ) ); ?></span>
									</span>
									<span>
										<span class="modal-cacsp-toggle">
											<span class="modal-cacsp-toggle-switch-handle"></span>
										</span>
									</span>
								</a>
							</li>
							<?php
							$li_style = '';
							if ( $cacsp_option_hide_unused_settings_row && !get_cacsp_options( 'cacsp_option_experience_scripts', true ) && !get_cacsp_options( 'cacsp_option_experience_images', true ) && !get_cacsp_options( 'cacsp_option_experience_frames', true ) && !get_cacsp_options( 'cacsp_option_experience_forms', true ) ) {
									$li_style = ' style="display: none;"';
							}
							?>
							<li<?php echo $li_style; ?>>
								<a href="#experience" class="modal-cacsp-toggle-switch" data-accepted-cookie="experience">
									<span><?php echo get_cacsp_options( 'cacsp_option_text_experience_header', false, __( 'Experience', 'cookies-and-content-security-policy' ) ); ?><br>
										<span><?php echo get_cacsp_options( 'cacsp_option_text_experience_description', false, __( 'In order for our website to perform as well as possible during your visit. If you refuse these cookies, some functionality will disappear from the website.', 'cookies-and-content-security-policy' ) ); ?></span>
									</span>
									<span>
										<span class="modal-cacsp-toggle">
											<span class="modal-cacsp-toggle-switch-handle"></span>
										</span>
									</span>
								</a>
							</li>
							<?php
							$li_style = '';
							if ( $cacsp_option_hide_unused_settings_row && !get_cacsp_options( 'cacsp_option_markerting_scripts', true ) && !get_cacsp_options( 'cacsp_option_markerting_images', true ) && !get_cacsp_options( 'cacsp_option_markerting_frames', true ) && !get_cacsp_options( 'cacsp_option_markerting_forms', true ) ) {
									$li_style = ' style="display: none;"';
							}
							?>
							<li<?php echo $li_style; ?>>
								<a href="#markerting" class="modal-cacsp-toggle-switch" data-accepted-cookie="markerting">
									<span><?php echo get_cacsp_options( 'cacsp_option_text_marketing_header', false, __( 'Marketing', 'cookies-and-content-security-policy' ) ); ?><br>
										<span><?php echo get_cacsp_options( 'cacsp_option_text_marketing_description', false, __( 'By sharing your interests and behavior as you visit our site, you increase the chance of seeing personalized content and offers.', 'cookies-and-content-security-policy' ) ); ?></span>
									</span>
									<span>
										<span class="modal-cacsp-toggle">
											<span class="modal-cacsp-toggle-switch-handle"></span>
										</span>
									</span>
								</a>
							</li>
						</ul>
					</div>
					<div class="modal-cacsp-btns">
						<a href="#" class="modal-cacsp-btn modal-cacsp-btn-save">
							<?php echo get_cacsp_options( 'cacsp_option_save_button', false, __( 'Save', 'cookies-and-content-security-policy' ) ); ?>
						</a>
						<?php 
						$cacsp_option_show_refuse_button = get_cacsp_options( 'cacsp_option_show_refuse_button' );
						if ( $cacsp_option_show_refuse_button ) { ?>
						<a href="#" class="modal-cacsp-btn modal-cacsp-btn-refuse-all">
							<?php echo get_cacsp_options( 'cacsp_option_refuse_button', false, __( 'Refuse all', 'cookies-and-content-security-policy' ) ); ?>
						</a>
						<?php } ?>
						<a href="#" class="modal-cacsp-btn modal-cacsp-btn-accept-all">
							<?php echo get_cacsp_options( 'cacsp_option_accept_all_button', false, __( 'Accept all', 'cookies-and-content-security-policy' ) ); ?>
						</a>
					</div>
				</div>
			</div>
			<!--googleon: index-->
			<?php
		};
	}
}
