<?php 

/*############  Booking calendar Admin Menu Class ################*/

class wpdevart_bc_admin_menu{
	
	private $menu_name;

	function __construct($param){
		$this->menu_name = $param['menu_name'];
	}

    /*############  Create menu function ################*/
	
	public function create_menu(){
		if ( get_option( 'wpdevart_permissions' ) !== false ) {
			$permissions = get_option( 'wpdevart_permissions' );
			$permissions = json_decode($permissions,true);
		}
		$wpdevart_pages = array('calendar_page','reservation_page','form_page','extra_page','theme_page','global_settings_page');
		foreach($wpdevart_pages as $wpdevart_page) {
			if(!isset($permissions[$wpdevart_page])){
				$permissions[$wpdevart_page] = "publish_pages";
			}
		}
		global $wpdb;
		global $submenu;
		$count = 0;
		$version = get_option("wpdevart_booking_version");
		if ($version) {
			$count = $wpdb->get_var('SELECT COUNT(*) FROM ' . $wpdb->prefix . 'wpdevart_reservations WHERE is_new=1');
		}
        $count_res = $count > 0 ? ' <span class="update-plugins count-' . $count . '"><span class="resrvation-count">' . $count . '</span></span>' : '';
	
		
		$main_page = add_menu_page( $this->menu_name, $this->menu_name . $count_res, $permissions['calendar_page'], 'wpdevart-calendars', array($this, 'admin_functions'),WPDEVART_URL.'css/images/menu_icon.png');
		$page_bookings =	add_submenu_page('wpdevart-calendars',  "Calendars",  "Calendars", $permissions['calendar_page'], 'wpdevart-calendars', array($this, 'admin_functions'));
		$page_reservation = add_submenu_page( 'wpdevart-calendars', 'Reservations', 'Reservations' . $count_res, $permissions['reservation_page'], 'wpdevart-reservations', array($this, 'admin_functions'));
		$page_forms = add_submenu_page( 'wpdevart-calendars', 'Forms', 'Forms', $permissions['form_page'], 'wpdevart-forms', array($this, 'admin_functions'));
		$page_extra = add_submenu_page( 'wpdevart-calendars', 'Extras', 'Extras', $permissions['extra_page'], 'wpdevart-extras', array($this, 'admin_functions'));
		$page_themes = add_submenu_page( 'wpdevart-calendars', 'Themes', 'Themes', $permissions['theme_page'], 'wpdevart-themes', array($this, 'admin_functions'));
		$page_global = add_submenu_page( 'wpdevart-calendars', 'Global Settings', 'Global Settings', $permissions['global_settings_page'], 'wpdevart-global-settings', array($this, 'admin_functions'));
		$page_manage = add_submenu_page( 'wpdevart-calendars', 'User Permissions', 'User Permissions', 'manage_options', 'wpdevart-user-permissions', array($this, 'admin_functions'));
		$page_uninstall = add_submenu_page( 'wpdevart-calendars', 'Uninstall'  , 'Uninstall', 'manage_options', 'wpdevart-booking-uninstall', array($this, 'uninstall_booking'));
		$page_featured = add_submenu_page( 'wpdevart-calendars', 'Featured plugins', 'Featured plugins', 'manage_options', 'wpdevart-add-booking', array($this, 'featured_plugins'));
		add_action('admin_print_styles-' .$main_page, array($this,'calendar_requeried_scripts'));
		add_action('admin_print_styles-' .$page_bookings, array($this,'calendar_requeried_scripts'));	
		add_action('admin_print_styles-' .$page_reservation, array($this,'menu_requeried_scripts'));	
		add_action('admin_print_styles-' .$page_themes, array($this,'menu_requeried_scripts'));
		add_action('admin_print_styles-' .$page_global, array($this,'menu_requeried_scripts'));
		add_action('admin_print_styles-' .$page_manage, array($this,'menu_requeried_scripts'));
		add_action('admin_print_styles-' .$page_uninstall, array($this,'menu_requeried_scripts'));
		add_action('admin_print_styles-' .$page_forms, array($this,'menu_requeried_scripts'));
		add_action('admin_print_styles-' .$page_extra, array($this,'menu_requeried_scripts'));
		add_action('admin_print_styles-' .$page_featured, array($this,'menu_requeried_scripts'));
		if(isset($submenu['wpdevart-calendars']))
			add_submenu_page( 'wpdevart-calendars', "Support or Any Ideas?", "<span style='color:#00ff66' >Support or Any Ideas?</span>", 'manage_options',"wpdevart_booking_calendar_any_idea",array($this, 'any_ideas'),155);
		if(isset($submenu['wpdevart-calendars']))
			$submenu['wpdevart-calendars'][9][2]=wpdevart_booking_support_url;
	}
	public function any_ideas(){
		
	}

    /*############  Menu Requeried Scripts function ################*/
	
	public function menu_requeried_scripts(){
		wp_enqueue_script('wp-color-picker');		
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_media(); 
		wp_enqueue_style(WPDEVART_PLUGIN_PREFIX.'-admin-style', WPDEVART_URL.'css/admin_style.css',array(),WPDEVART_VERSION);
		wp_enqueue_style(WPDEVART_PLUGIN_PREFIX.'calendar-style', WPDEVART_URL.'css/booking.css',array(),WPDEVART_VERSION);
		wp_register_script( WPDEVART_PLUGIN_PREFIX.'-admin-script', WPDEVART_URL.'js/admin_script.js', array("jquery"),WPDEVART_VERSION );
		wp_localize_script( WPDEVART_PLUGIN_PREFIX.'-admin-script', WPDEVART_PLUGIN_PREFIX."_admin", array(
			'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
			'ajaxNonce'   => wp_create_nonce( WPDEVART_PLUGIN_PREFIX . '_ajax_nonce' ),
			'required' => __("is required.",'booking-calendar'),
			'emailValid' => __("Enter the valid email address.",'booking-calendar'),
			'hour' => __("Hour",'booking-calendar'),
			'price' => __("Price",'booking-calendar'),
			'marked_price' => __("Marked Price",'booking-calendar'),
			'available' => __("Available",'booking-calendar'),
			'booked' => __("Booked",'booking-calendar'),
			'unavailable' => __("Unavailable",'booking-calendar'),
			'number_availability' => __("Number Availabile",'booking-calendar'),
			'h_info' => __("Hour Information",'booking-calendar'),
			'date' => __("Date",'booking-calendar')
		) );
		wp_enqueue_script( WPDEVART_PLUGIN_PREFIX.'-admin-script' );
		wp_register_script( 'wpdevart-booking-script', WPDEVART_URL.'js/booking.js', array("jquery"),WPDEVART_VERSION);
		wp_localize_script( 'wpdevart-booking-script', WPDEVART_PLUGIN_PREFIX, array(
			'ajaxUrl'         => admin_url( 'admin-ajax.php' ),
			'ajaxNonce'       => wp_create_nonce( 'wpdevart_ajax_nonce' ),
			'required' => __("is required.",'booking-calendar'),
			'emailValid' => __("Enter the valid email address.",'booking-calendar'),
			'date' => __("Date",'booking-calendar'),
			'hour' => __("Hour",'booking-calendar')
		) );
		wp_enqueue_script( 'wpdevart-booking-script' );
		if (function_exists('add_thickbox')) add_thickbox();
	}
	public function calendar_requeried_scripts(){
		wp_enqueue_style('wpdevart-font-awesome', WPDEVART_URL . 'css/font-awesome/font-awesome.css',array(),WPDEVART_VERSION);
		wp_enqueue_style(WPDEVART_PLUGIN_PREFIX.'-admin-style', WPDEVART_URL.'css/admin_style.css',array(),WPDEVART_VERSION);
		wp_enqueue_style(WPDEVART_PLUGIN_PREFIX.'calendar-style', WPDEVART_URL.'css/booking.css',array(),WPDEVART_VERSION);
		wp_register_script( WPDEVART_PLUGIN_PREFIX.'-admin-calendar', WPDEVART_URL.'js/admin_calendar.js', array("jquery"),WPDEVART_VERSION );
		wp_localize_script( WPDEVART_PLUGIN_PREFIX.'-admin-calendar', WPDEVART_PLUGIN_PREFIX, array(
			'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
			'ajaxNonce'   => wp_create_nonce( WPDEVART_PLUGIN_PREFIX . '_ajax_nonce' ),
			'hour' => __("Hour",'booking-calendar'),
			'price' => __("Price",'booking-calendar'),
			'marked_price' => __("Marked Price",'booking-calendar'),
			'available' => __("Available",'booking-calendar'),
			'booked' => __("Booked",'booking-calendar'),
			'unavailable' => __("Unavailable",'booking-calendar'),
			'number_availability' => __("Number Availabile",'booking-calendar'),
			'h_info' => __("Hour Information",'booking-calendar'),
		) );
		wp_enqueue_script( WPDEVART_PLUGIN_PREFIX.'-admin-calendar' );
	}	
			
	public function admin_functions(){
		$name = WPDEVART_PRO == 'pro' ? 'Extended' : 'Premium';
		$header_args = array('title' => 'WpDevArt Booking Calendar ' . $name, 'desc' => 'Powerful and Customizable Booking System'); 
		wpdevart_bc_Library::wpdevart_header($header_args);
		$page = wpdevart_bc_Library::get_value('page', 'wpdevart-calendars');
		$page = ucfirst(str_replace(array('wpdevart-','-'), '', $page));
		$page = $page == "Globalsettings" ? "GlobalSettings" : ($page == "Userpermissions" ? "UserPermissions" : $page);
		if(file_exists(WPDEVART_PLUGIN_DIR . 'admin/controllers/' . $page . '.php')) {
			require_once(WPDEVART_PLUGIN_DIR . 'admin/controllers/' . $page . '.php');
			$controller_name = 'wpdevart_bc_Controller' . $page;
			$controller = new $controller_name;
			$controller->perform();
		}	
	}
	
	
	
	/*################################## FEATURED PLUGINS #########################################*/
	public function featured_plugins(){
		$plugins_array=array(
			'pricing_table'=>array(
						'image_url'		=>	WPDEVART_URL.'css/images/featured_plugins/pricing_table.png',
						'site_url'		=>	'https://wpdevart.com/wordpress-pricing-table-plugin/',
						'title'			=>	'Pricing Table',
						'description'	=>	'WordPress Pricing Table plugin is a unique and awesome tool for creating responsive and nice pricing tables on your WordPress website.'
						),
			'coming_soon'=>array(
						'image_url'		=>	WPDEVART_URL.'css/images/featured_plugins/coming_soon.png',
						'site_url'		=>	'https://wpdevart.com/wordpress-coming-soon-plugin/',
						'title'			=>	'Coming soon and Maintenance mode',
						'description'	=>	'Coming soon and Maintenance mode plugin is an awesome tool to show your visitors that you are working on your website to make it better.'
						),
			'countdown_extendet'=>array(
						'image_url'		=>	WPDEVART_URL.'css/images/featured_plugins/countdown_extendet.png',
						'site_url'		=>	'https://wordpress.org/plugins/countdown-wpdevart-extended/',
						'title'			=>	'Countdown Timer – Extended version, Popup Countdown',
						'description'	=>	'The most functional and beautiful Countdown Timer plugin for WordPress.'
						),
			'Contact forms'=>array(
						'image_url'		=>	WPDEVART_URL.'css/images/featured_plugins/contact_forms.png',
						'site_url'		=>	'https://wpdevart.com/wordpress-contact-form-plugin/',
						'title'			=>	'Contact Form',
						'description'	=>	'Contact Form plugin is an nice and handy tool for creating different types of contact forms on your WordPress websites.'
						),	
			 'gallery_album'=>array(
						'image_url'	=>	WPDEVART_URL.'css/images/featured_plugins/gallery.png',
						'site_url'	=>	'https://wpdevart.com/wordpress-gallery-plugin',
						'title'	=>	'WordPress Gallery plugin',
						'description'	=>	'Gallery plugin is an useful tool that will help you to create Galleries and Albums. Try our nice Gallery views and awesome animations.'
						),			
			'youtube'=>array(
						'image_url'		=>	WPDEVART_URL.'css/images/featured_plugins/youtube.png',
						'site_url'		=>	'https://wpdevart.com/wordpress-youtube-embed-plugin',
						'title'			=>	'WordPress YouTube Embed',
						'description'	=>	'YouTube Embed plugin is an convenient tool for adding video to your website. Use YouTube Embed plugin to add YouTube videos in posts/pages, widgets.'
						),
			'lightbox'=>array(
						'image_url'		=>	WPDEVART_URL.'css/images/featured_plugins/lightbox.png',
						'site_url'		=>	'https://wpdevart.com/wordpress-lightbox-plugin',
						'title'			=>	'WordPress Lightbox plugin',
						'description'	=>	'WordPress lightbox plugin is an high customizable and responsive product for displaying images and videos in popup.'
						),
			'countdown'=>array(
						'image_url'		=>	WPDEVART_URL.'css/images/featured_plugins/countdown.jpg',
						'site_url'		=>	'https://wpdevart.com/wordpress-countdown-plugin/',
						'title'			=>	'WordPress Countdown plugin',
						'description'	=>	'WordPress Countdown plugin is an nice tool to create and insert countdown timers into your posts/pages and widgets.'
						),
            'facebook-comments'=>array(
						'image_url'		=>	WPDEVART_URL.'css/images/featured_plugins/facebook-comments-icon.png',
						'site_url'		=>	'https://wpdevart.com/wordpress-facebook-comments-plugin/',
						'title'			=>	'WordPress Facebook comments',
						'description'	=>	'Our Facebook comments plugin will help you to display Facebook Comments on your website. You can use Facebook Comments on your pages/posts.'
						),						
			'facebook'=>array(
						'image_url'		=>	WPDEVART_URL.'css/images/featured_plugins/facebook.png',
						'site_url'		=>	'https://wpdevart.com/wordpress-facebook-like-box-plugin',
						'title'			=>	'Facebook Like Box',
						'description'	=>	'Our Facebook like box plugin will help you to display Facebook like box on your wesite, just add Facebook Like box widget to your sidebar and use it..'
						),
			'poll'=>array(
						'image_url'		=>	WPDEVART_URL.'css/images/featured_plugins/poll.png',
						'site_url'		=>	'https://wpdevart.com/wordpress-polls-plugin',
						'title'			=>	'Poll',
						'description'	=>	'WordPress Polls plugin is an wonderful tool for creating polls and survey forms for your visitors. You can use our polls on widgets, posts and pages.'
						),		
			'vertical_menu'=>array(
						'image_url'		=>	WPDEVART_URL.'css/images/featured_plugins/vertical-menu.png',
						'site_url'		=>	'https://wpdevart.com/wordpress-vertical-menu-plugin/',
						'title'			=>	'WordPress Vertical Menu',
						'description'	=>	'WordPress Vertical Menu is a handy tool for adding nice vertical menus. You can add icons for your website vertical menus using our plugin.'
						),						
			'chart'=>array(
						'image_url'		=>	WPDEVART_URL.'css/images/featured_plugins/chart-featured.png',
						'site_url'		=>	'https://wpdevart.com/wordpress-organization-chart-plugin/',
						'title'			=>	'WordPress Organization Chart',
						'description'	=>	'WordPress organization chart plugin is a great tool for adding organizational charts to your WordPress websites.'
						),
			'duplicate_page'=>array(
						'image_url'		=>	WPDEVART_URL.'css/images/featured_plugins/featured-duplicate.png',
						'site_url'		=>	'https://wpdevart.com/wordpress-duplicate-page-plugin-easily-clone-posts-and-pages/',
						'title'			=>	'WordPress Duplicate page',
						'description'	=>	'Duplicate Page or Post is a great tool that allows duplicating pages and posts. Now you can do it with one click.'
						),						
			
		);
		?>
		<h1 style="text-align: center;font-size: 50px;font-weight: 700;color: #2b2350;margin: 20px auto 25px;line-height: 1.2;">Featured Plugins</h1>
		<?php foreach($plugins_array as $key=>$plugin) { ?>
		<div class="featured_plugin_main">
			<div class="featured_plugin_image"><a target="_blank" href="<?php echo $plugin['site_url'] ?>"><img src="<?php echo $plugin['image_url'] ?>"></a></div>
			<div class="featured_plugin_information">
				<div class="featured_plugin_title"><h4><a target="_blank" href="<?php echo $plugin['site_url'] ?>"><?php echo $plugin['title'] ?></a></h4></div>
				<p class="featured_plugin_description"><?php echo $plugin['description'] ?></p>
				<a target="_blank" href="<?php echo $plugin['site_url'] ?>" class="blue_button">Learn More</a>
			</div>
			<div style="clear:both"></div>                
		</div>
		<?php } 
	}
	
	public function uninstall_booking() {
		global $wpdb;
		if(isset( $_POST['uninstall_booking_data'] )   && wp_verify_nonce( $_POST['uninstall_booking_data'], 'uninstall_booking')){
			$wpdb->query("DROP TABLE `" . $wpdb->prefix . "wpdevart_calendars`");
			$wpdb->query("DROP TABLE `" . $wpdb->prefix . "wpdevart_dates`");
			$wpdb->query("DROP TABLE `" . $wpdb->prefix . "wpdevart_forms`");
			$wpdb->query("DROP TABLE `" . $wpdb->prefix . "wpdevart_extras`");
			$wpdb->query("DROP TABLE `" . $wpdb->prefix . "wpdevart_themes`");
			$wpdb->query("DROP TABLE `" . $wpdb->prefix . "wpdevart_reservations`");
			$wpdb->query("DROP TABLE `" . $wpdb->prefix . "wpdevart_payments`");
			delete_option("wpdevart_booking_version");
			?>
			<div id="message" class="updated fade">
			  <p><?php _e('The following Database Tables successfully deleted:','booking-calendar'); ?></p>
			  <p><?php echo $wpdb->prefix; ?>wpdevart_calendars,</p>
			  <p><?php echo $wpdb->prefix; ?>wpdevart_dates,</p>
			  <p><?php echo $wpdb->prefix; ?>wpdevart_forms,</p>
			  <p><?php echo $wpdb->prefix; ?>wpdevart_extras,</p>
			  <p><?php echo $wpdb->prefix; ?>wpdevart_themes,</p>
			  <p><?php echo $wpdb->prefix; ?>wpdevart_reservations,</p>
			  <p><?php echo $wpdb->prefix; ?>wpdevart_payments,</p>
			</div>
			<div class="wrap">
			  <h1><?php _e('Uninstall Booking Calendar','booking-calendar'); ?></h1>
			  <p><strong><a href="<?php echo wp_nonce_url('plugins.php?action=deactivate&amp;plugin=booking-calendar-pro/booking_calendar.php', 'deactivate-plugin_booking-calendar-pro/booking_calendar.php'); ?>"><?php _e('Click Here','booking-calendar'); ?></a><?php _e(' To Finish the Uninstallation','booking-calendar'); ?></strong></p>
			</div>
		  <?php
			return;
		}
		?>
		<div id="wpdevart_uninstal_container" class="wpdevart-list-container">
			<form method="post" action="admin.php?page=wpdevart-booking-uninstall" style="width:99%;">
			 <?php wp_nonce_field('uninstall_booking','uninstall_booking_data'); ?>
			    <div class="div-for-clear">
					<span class="admin_logo"></span>
					<h1><?php _e('Uninstall Booking calendar','booking-calendar'); ?></h1>
				</div>
				<p><?php _e('Deactivating Booking calendar plugin does not remove any data that may have been created. To completely remove this plugin, you can uninstall it here.','booking-calendar'); ?></p>
				<p style="color: #7052fb;"><strong><?php _e('WARNING:','booking-calendar'); ?></strong><?php _e('Once uninstalled, this can\'t be undone. You should use a Database Backup plugin of WordPress to back up all the data first.','booking-calendar'); ?></p>
				<p style="color: #7052fb"><strong><?php _e('The following Database Tables will be deleted:','booking-calendar'); ?></strong></p>
				<table class="widefat">
				  <thead>
					<tr>
					  <th>Database Tables</th>
					</tr>
				  </thead>
				  <tr>
					<td valign="top">
					  <ol>
						  <li><?php echo $wpdb->prefix; ?>wpdevart_calendars</li>
						  <li><?php echo $wpdb->prefix; ?>wpdevart_dates</li>
						  <li><?php echo $wpdb->prefix; ?>wpdevart_forms</li>
						  <li><?php echo $wpdb->prefix; ?>wpdevart_extras</li>
						  <li><?php echo $wpdb->prefix; ?>wpdevart_themes</li>
						  <li><?php echo $wpdb->prefix; ?>wpdevart_reservations</li>
					  </ol>
					</td>
				  </tr>
				</table>
				<p style="text-align: center;">
				  <?php _e('Do you really want to uninstall Booking Calendar?','booking-calendar'); ?>
				</p>
				<p style="text-align: center;">
				  <input type="checkbox" id="check_yes" value="yes" />&nbsp;<label for="check_yes"><?php _e('Yes','booking-calendar'); ?></label>
				</p>
				<p style="text-align: center;">
				  <input type="submit" value="UNINSTALL" class="button-primary" onclick="if (check_yes.checked) {	if (!confirm('You are About to Uninstall booking calendar.\nThis Action Is Not Reversible.')) {return false; } } else { return false; }" />
				</p>
			</form>
		</div>
  <?php    
	}
	
	
}