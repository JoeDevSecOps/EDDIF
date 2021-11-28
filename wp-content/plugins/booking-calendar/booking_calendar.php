<?php
/**
 * Plugin Name: Booking Calendar WpDevArt
 * Plugin URI: https://wpdevart.com/wordpress-booking-calendar-plugin
 * Author URI: https://wpdevart.com 
 * Description: WordPress Booking Calendar plugin is an awesome tool to create a booking system for your website. Create booking calendars in a few minutes.
 * Version: 3.1.0
 * Author: WpDevArt
 * License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: booking-calendar
 */
 
defined('ABSPATH') || die('Access Denied');
class wpdevart_bc_calendar{
	
	protected $version = "10.12";
	protected $prefix = 'wpdevart';
	public $options;
	public static $booking_count = 1;
	
	
	function __construct(){
		$this->setup_constants();		//Setup constants
		$this->require_files();
		$this->call_base_filters();		//Function for the main filters (hooks)
		$this->create_admin_menu();		//Function for creating admin menu
		add_shortcode(WPDEVART_PLUGIN_PREFIX."_booking_calendar", array($this,'shortcodes'));
	}
	
	/**
	* Setup constants
	**/
	private function setup_constants() {
		$upload_dir = wp_upload_dir();
		if ( ! defined( 'WPDEVART_PLUGIN_DIR' ) ) {
			define( 'WPDEVART_PLUGIN_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
		}
		if ( ! defined( 'WPDEVART_PLUGIN_PREFIX' ) ) {
			define( 'WPDEVART_PLUGIN_PREFIX', $this->prefix );
		}
		if(! defined( 'WPDEVART_URL' ) ){
			define ('WPDEVART_URL', trailingslashit( plugins_url('', __FILE__ ) ) );
		}
		if(! defined( 'WPDEVART_VERSION' ) ){
			define ('WPDEVART_VERSION', $this->version);
		}
		if(!defined('WPDEVART_PRO')){
			define('WPDEVART_PRO', "free");
		}
		if(!defined('wpdevart_booking_support_url')){
			define('wpdevart_booking_support_url', "https://wordpress.org/support/plugin/booking-calendar/#new-post");
		}
		if(!defined('WPDEVART_UPLOADS')){
			define( 'WPDEVART_UPLOADS', $upload_dir['basedir'] . '/booking_calendar/' );
		}
		if(!defined('WPDEVART_UPLOADS_URL')){
			define( 'WPDEVART_UPLOADS_URL', $upload_dir['baseurl'] . '/booking_calendar/' );
		}
		if(!defined('WPDEVART_PLUGIN_URL')){
			define( 'WPDEVART_PLUGIN_URL', "http://wpdevart.com/wordpress-booking-calendar-plugin" );
		}
	}

	/**
	* Require files
	**/
	private function require_files() {
		require_once(WPDEVART_PLUGIN_DIR.'includes/currency_list.php');
		require_once(WPDEVART_PLUGIN_DIR.'includes/wpdevart_lib.php');
		require_once(WPDEVART_PLUGIN_DIR.'includes/booking_class.php');
		require_once(WPDEVART_PLUGIN_DIR.'includes/widgets/widget-booking_calendar.php');
		require_once(WPDEVART_PLUGIN_DIR.'includes/payments.php');
		require_once(WPDEVART_PLUGIN_DIR.'includes/main_class.php');
	}
	
	private function create_admin_menu(){
		// Registration of file that is responsible for admin menu
		require_once(WPDEVART_PLUGIN_DIR.'includes/admin_menu.php');
		// Creation of admin menu object type 
		$wpdevart_admin_menu = new wpdevart_bc_admin_menu(array('menu_name' => 'Booking'));
		//Hook that will connect admin menu with class
		add_action('admin_menu', array($wpdevart_admin_menu,'create_menu'));
		
	}
	
    /*############  Shortcodes function ################*/	
	
	public function shortcodes($attr) {
		extract(shortcode_atts(array(
			'id' => null
		), $attr, WPDEVART_PLUGIN_PREFIX));
		if (empty($id)) {
			return;
		}
		$result = $this->wpdevart_booking_calendar($id);
		self::$booking_count += 1;
		return  $result;
	}
	
	
	public function install_databese(){
		require_once(WPDEVART_PLUGIN_DIR.'includes/install_database.php');
		$wpdevart_bc_install_database = new wpdevart_bc_install_database();
		$version = get_option("wpdevart_booking_version_new");
        $new_version = $this->version;
		$recreate_db = (isset($_GET['task']) && $_GET['task'] == 'recreate_db') ? true : false;
		if (!$version && !get_option("wpdevart_booking_version")) {
			$wpdevart_bc_install_database->install_databese();
			add_option("wpdevart_booking_version_new", $new_version, '', 'no');
		} 
		elseif (($version && version_compare($version, $new_version, '<')) || get_option("wpdevart_booking_version") != "0" || $recreate_db ) {
			$version = !$version ? "10.10" : get_option("wpdevart_booking_version_new");
			$wpdevart_bc_install_database->update_databese($version,$recreate_db);
			update_option("wpdevart_booking_version_new", $new_version, "", "no");
			update_option("wpdevart_booking_version", "0");
		}
		if (!is_dir(WPDEVART_UPLOADS)) {
			mkdir(WPDEVART_UPLOADS, 0777);
		}
		
	}

    /*############  Required scripts function ################*/
	
	public function registr_requeried_scripts(){
		load_plugin_textdomain( 'booking-calendar', FALSE, basename(dirname(__FILE__)).'/languages' );
		wp_enqueue_script( 'jquery-ui-datepicker', array('jquery') ); 
		if(!is_admin()){
			$scheme = is_ssl()? "https" : "http";
			wp_register_script( 'wpdevart-booking-script', WPDEVART_URL.'js/booking.js', array("jquery"),WPDEVART_VERSION);
			wp_localize_script( 'wpdevart-booking-script', WPDEVART_PLUGIN_PREFIX, array(
				'ajaxUrl'         => admin_url( 'admin-ajax.php', $scheme ),
				'ajaxNonce'       => wp_create_nonce( 'wpdevart_ajax_nonce' ),
				'required' => __("is required.",'booking-calendar'),
				'confirm_email' => __("do not match.",'booking-calendar'),
				'file_size' => __(" The file size is too large!",'booking-calendar'),
				'file_type' => __(" The file type not allowed!",'booking-calendar'),
				'emailValid' => __("Enter the valid email address.",'booking-calendar'),
				'date' => __("Date",'booking-calendar'),
				'hour' => __("Hour",'booking-calendar')
			) );
			wp_enqueue_script( 'wpdevart-booking-script' );
			wp_enqueue_script( 'wpdevart-script', WPDEVART_URL.'js/script.js', array("jquery"),WPDEVART_VERSION );
			wp_enqueue_script("wpdevart-recaptcha", "https://www.google.com/recaptcha/api.js?onload=wpdevartRecaptchaInit&render=explicit", array("jquery"), WPDEVART_VERSION );
		}
		wp_enqueue_script( 'scrollto', WPDEVART_URL.'js/jquery.scrollTo-min.js', array("jquery"),WPDEVART_VERSION );
		wp_enqueue_style( 'jquery-ui',  WPDEVART_URL.'css/jquery-ui.css',array(),WPDEVART_VERSION);
		wp_enqueue_style( 'wpdevart-font-awesome', WPDEVART_URL . 'css/font-awesome/font-awesome.css',array(),WPDEVART_VERSION);
		wp_enqueue_style( 'wpdevart-style', WPDEVART_URL.'css/style.css',array(),WPDEVART_VERSION);
		wp_enqueue_style( 'wpdevart-effects', WPDEVART_URL.'css/effects.css',array(),WPDEVART_VERSION);
		wp_enqueue_style( 'wpdevartcalendar-style', WPDEVART_URL.'css/booking.css',array(),WPDEVART_VERSION);
	}
	
    /*############  Call filters function ################*/
	
	public function call_base_filters(){
		
		add_action( 'init',  array($this,'registr_requeried_scripts') );
		//if (!isset($_GET['action']) || $_GET['action'] != 'deactivate') {
		  add_action('admin_init', array($this,'install_databese'));
		//}
		add_action('wp_loaded', array($this,'wpdevart_time_zone'));
		/*GDPR*/
		add_filter('admin_init', array($this,'wpdevart_privacy_policy'));
		add_filter('wp_privacy_personal_data_exporters', array($this,'wpdevart_plugin_exporter'), 10);
		add_filter('wp_privacy_personal_data_erasers', array($this,'wpdevart_plugin_eraser'), 10);
		
		add_action( 'wp_ajax_nopriv_wpdevart_add_field', array($this,'wpdevart_add_field') );
		add_action( 'wp_ajax_wpdevart_add_field', array($this,'wpdevart_add_field') );
		add_action( 'wp_ajax_nopriv_wpdevart_add_extra_field', array($this,'wpdevart_add_extra_field') );
		add_action( 'wp_ajax_wpdevart_add_extra_field', array($this,'wpdevart_add_extra_field') );
		add_action( 'wp_ajax_nopriv_wpdevart_add_extra_field_item', array($this,'wpdevart_add_extra_field') );
		add_action( 'wp_ajax_wpdevart_add_extra_field_item', array($this,'wpdevart_add_extra_field_item') );
		add_action( 'wp_ajax_nopriv_wpdevart_ajax', array($this,'wpdevart_ajax') );
		add_action( 'wp_ajax_wpdevart_ajax', array($this,'wpdevart_ajax') );
		add_action( 'wp_ajax_nopriv_wpdevart_get_interval_dates', array($this,'wpdevart_get_interval_dates') );
		add_action( 'wp_ajax_wpdevart_get_interval_dates', array($this,'wpdevart_get_interval_dates') );
		add_action( 'wp_ajax_nopriv_wpdevart_form_ajax', array($this,'wpdevart_form_ajax') );
		add_action( 'wp_ajax_wpdevart_form_ajax', array($this,'wpdevart_form_ajax') );
		add_action( 'wp_ajax_nopriv_wpdevart_payment_ajax', array($this,'wpdevart_payment_ajax') );
		add_action( 'wp_ajax_wpdevart_payment_ajax', array($this,'wpdevart_payment_ajax') );
		add_action( 'wp_ajax_nopriv_wpdevart_payment', array($this,'wpdevart_payment') );
		add_action( 'wp_ajax_wpdevart_payment', array($this,'wpdevart_payment') );
		add_action( 'wp_ajax_nopriv_wpdevart_quick_update', array($this,'wpdevart_quick_update') );
		add_action( 'wp_ajax_wpdevart_quick_update', array($this,'wpdevart_quick_update') );
		add_action( 'wp_ajax_nopriv_wpdevart_captcha', array($this,'wpdevart_captcha') );
		add_action( 'wp_ajax_wpdevart_captcha', array($this,'wpdevart_captcha') );
		add_action( 'wp_ajax_nopriv_wpdevart_export', array($this,'wpdevart_export') );
		add_action( 'wp_ajax_wpdevart_export', array($this,'wpdevart_export') );
	}
	
	public function wpdevart_time_zone(){
		if (get_option('timezone_string')) {
			date_default_timezone_set(get_option('timezone_string'));
		}
	}
	
	/*GDPR*/
	public function wpdevart_plugin_exporter( $exporters ) {
		$exporters['wpdevart-booking-calendar'] = array(
		  'exporter_friendly_name' => __( 'Booking Calendar WpDevArt', 'booking-calendar' ),
		  'callback' => array($this,'wpdevart_exporter'),
		);
		return $exporters;
	}
	
	public function wpdevart_exporter( $email_address, $page = 1 ) {
		global $wpdb;
		$done = false;
		$export_items = array();
		$limit = 500;
		$prop_to_export = array(
			'single_day'       => __( 'Reservation Day', 'booking-calendar' ),
			'check_in' => __( 'Reservation Check In', 'booking-calendar' ),
			'check_out'   => __( 'Reservation Check Out', 'booking-calendar' ),
			'start_hour'    => __( 'Start Hour', 'booking-calendar' ),
			'end_hour'        => __( 'End Hour', 'booking-calendar' ),
			'total_price'         => __( 'Total Price', 'booking-calendar' ),
			'form'      => __( 'Reservation Form Information', 'booking-calendar' ),
			'address_billing'      => __( 'Billing Form Information', 'booking-calendar' ),
			'address_shipping'      => __( 'Shipping Form Information', 'booking-calendar' ),
			'payment_price'      => __( 'Payment Price', 'booking-calendar' ),
			'ip'      => __( 'Ip', 'booking-calendar' ),
			'payment_address'      => __( 'Payment Address', 'booking-calendar' ),
			'payment_info'      => __( 'Payment Info', 'booking-calendar' ),
			'modified_date'      => __( 'Payment Date', 'booking-calendar' ),
			'date_created'      => __( 'Reservation Created Date', 'booking-calendar' )
		);
		$query = "SELECT " . $wpdb->prefix . "wpdevart_reservations.*, " . $wpdb->prefix . "wpdevart_payments.* FROM " . $wpdb->prefix . "wpdevart_reservations LEFT JOIN " . $wpdb->prefix . "wpdevart_payments ON " . $wpdb->prefix . "wpdevart_reservations.id=" . $wpdb->prefix . "wpdevart_payments.res_id WHERE  " . $wpdb->prefix . "wpdevart_reservations.email LIKE '%" . $email_address . "%' LIMIT 0,".$limit;
		$rows = $wpdb->get_results($query);


        $cals = array();
		foreach ($rows as $row){
		  $data_to_export = array();
		  $group_id = 'reservation';
		  $item_id = $row->id;
		  
		  if(!isset($cals[$row->calendar_id])){
			  $cals[$row->calendar_id] = array();
			  $cals[$row->calendar_id]["ids"] = $wpdb->get_row($wpdb->prepare('SELECT theme_id,form_id FROM ' . $wpdb->prefix . 'wpdevart_calendars WHERE id="%d"', $row->calendar_id));
			  $theme_id = $wpdb->get_var($wpdb->prepare('SELECT theme_id FROM ' . $wpdb->prefix . 'wpdevart_calendars WHERE id="%d"', $row->calendar_id));
			  $theme_rows = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'wpdevart_themes WHERE id="%d"', $theme_id),ARRAY_A);
			  if(isset($theme_rows[0])) {
				 $cals[$row->calendar_id]["theme_options"] = json_decode($theme_rows[0]["value"],true);
			  } else {
				 $cals[$row->calendar_id]["theme_options"] = array();
			  }
		  }
		  
		  foreach ( $prop_to_export as $key => $name ) {
			  $value = '';
 
			switch ( $key ) {
				case 'single_day':
				case 'check_in':
				case 'check_out':
				case 'start_hour':
				case 'end_hour':
				case 'total_price':
				case 'payment_price':
				case 'ip':
				case 'payment_address':
				case 'payment_info':
				case 'modified_date':
				case 'date_created':
					$value = $row->{$key};
					break;
				case 'form':
					$value = $this->get_form_data($row->form, $row->calendar_id,$cals[$row->calendar_id]["ids"]->form_id);
					break;
				case 'address_billing':
					$value = $this->get_form_data($row->address_billing, $row->calendar_id,$cals[$row->calendar_id]["theme_options"]["billing_address_form"], "billing_info_");
					break;
				case 'address_shipping':
					$value = $this->get_form_data($row->address_shipping, $row->calendar_id,$cals[$row->calendar_id]["theme_options"]["shipping_address_form"], "shipping_info_");
					break;
			}
			
			if ( ! empty( $value ) ) {
				$data_to_export[] = array(
					'name'  => $name,
					'value' => $value,
				);
			}
		  }
		  
		  if(!empty($data_to_export)){
			$done = true;
			$export_items[] = array(
			  'group_id' => $group_id,
			  'group_label' => __('Booking Calendar Reservation Data', 'booking-calendar'),
			  'item_id' => $item_id,
			  'data' => $data_to_export,
			);
		  }
		}


		$prop_to_export = array(
			'notify_admin_on_book_to'       => __( 'Notify on book request to', 'booking-calendar' ),
			'notify_admin_on_book_from' => __( 'Notify on book request from', 'booking-calendar' ),
			'notify_admin_on_book_fromname'   => __( 'Notify on book request fromname', 'booking-calendar' ),
			'notify_admin_on_book_subject'    => __( 'Notify on book request subject', 'booking-calendar' ),
			'notify_admin_on_book_content'        => __( 'Notify on book request content', 'booking-calendar' ),
			'notify_admin_on_approved_to'       => __( 'Notify on approved request to', 'booking-calendar' ),
			'notify_admin_on_approved_from' => __( 'Notify on approved request from', 'booking-calendar' ),
			'notify_admin_on_approved_fromname'   => __( 'Notify on approved request fromname', 'booking-calendar' ),
			'notify_admin_on_approved_subject'    => __( 'Notify on approved request subject', 'booking-calendar' ),
			'notify_admin_on_approved_content'        => __( 'Notify on approved request content', 'booking-calendar' ),
			'notify_admin_paypal_to'       => __( 'Notify on paypal request to', 'booking-calendar' ),
			'notify_admin_paypal_from' => __( 'Notify on paypal request from', 'booking-calendar' ),
			'notify_admin_paypal_fromname'   => __( 'Notify on paypal request fromname', 'booking-calendar' ),
			'notify_admin_paypal_subject'    => __( 'Notify on paypal request subject', 'booking-calendar' ),
			'notify_admin_paypal_content'        => __( 'Notify on paypal request content', 'booking-calendar' ),
			'notify_user_on_book_from' => __( 'Notify user on book request from', 'booking-calendar' ),
			'notify_user_on_book_fromname'   => __( 'Notify user on book request fromname', 'booking-calendar' ),
			'notify_user_on_book_subject'    => __( 'Notify user on book request subject', 'booking-calendar' ),
			'notify_user_on_book_content'        => __( 'Notify user on book request content', 'booking-calendar' ),
			'notify_user_on_approved_from' => __( 'Notify user on approved request from', 'booking-calendar' ),
			'notify_user_on_approved_fromname'   => __( 'Notify user on approved request fromname', 'booking-calendar' ),
			'notify_user_on_approved_subject'    => __( 'Notify user on approved request subject', 'booking-calendar' ),
			'notify_user_on_approved_content'        => __( 'Notify user on approved request content', 'booking-calendar' ),
			'notify_user_canceled_from' => __( 'Notify user on canceled request from', 'booking-calendar' ),
			'notify_user_canceled_fromname'   => __( 'Notify user on canceled request fromname', 'booking-calendar' ),
			'notify_user_canceled_subject'    => __( 'Notify user on canceled request subject', 'booking-calendar' ),
			'notify_user_canceled_content'        => __( 'Notify user on canceled request content', 'booking-calendar' ),
			'notify_user_deleted_from' => __( 'Notify user on deleted request from', 'booking-calendar' ),
			'notify_user_deleted_fromname'   => __( 'Notify user on deleted request fromname', 'booking-calendar' ),
			'notify_user_deleted_subject'    => __( 'Notify user on deleted request subject', 'booking-calendar' ),
			'notify_user_deleted_content'        => __( 'Notify user on deleted request content', 'booking-calendar' ),
			'notify_user_paypal_from' => __( 'Notify user on paypal request from', 'booking-calendar' ),
			'notify_user_paypal_fromname'   => __( 'Notify user on paypal request fromname', 'booking-calendar' ),
			'notify_user_paypal_subject'    => __( 'Notify user on paypal request subject', 'booking-calendar' ),
			'notify_user_paypal_content'        => __( 'Notify user on paypal request content', 'booking-calendar' ),
			'notify_user_paypal_failed_from' => __( 'Notify user on paypal failed request from', 'booking-calendar' ),
			'notify_user_paypal_failed_fromname'   => __( 'Notify user on paypal failed request fromname', 'booking-calendar' ),
			'notify_user_paypal_failed_subject'    => __( 'Notify user on paypal failed request subject', 'booking-calendar' ),
			'notify_user_paypal_failed_content'        => __( 'Notify user on paypal failed request content', 'booking-calendar' ),
		);
        $query = 'SELECT * FROM ' . $wpdb->prefix . 'wpdevart_themes WHERE  value LIKE "%' . $email_address . '%"   LIMIT 0,'.$limit;
		$rows = $wpdb->get_results($query);

		foreach ($rows as $row){
		  $data_to_export = array();
		  $group_id = 'theme';
		  $item_id = $row->id;
		  $options = json_decode($row->value);
		  
		  foreach ( $prop_to_export as $key => $name ) {
				$value = $options->{$key};
			
			if ( ! empty( $value ) ) {
				$data_to_export[] = array(
					'name'  => $name,
					'value' => $value,
				);
			}
		  }
		  
		  if(!empty($data_to_export)){
			$done = true;
			$export_items[] = array(
			  'group_id' => $group_id,
			  'group_label' => __('Booking Calendar Themes Data', 'booking-calendar'),
			  'item_id' => $item_id,
			  'data' => $data_to_export,
			);
		  }
		}

		return array(
		  'data' => $export_items,
		  'done' => $done,
		);
	}
	
	public function wpdevart_plugin_eraser( $erasers ) {
		$erasers['wpdevart-booking-calendar'] = array(
		  'eraser_friendly_name' => __( 'Booking Calendar WpDevArt', 'booking-calendar' ),
		  'callback'             => array($this,'wpdevart_eraser'),
		);
		return $erasers;
	}
	
	public function wpdevart_eraser( $email_address, $page = 1 ) {
		global $wpdb;
		if ( empty( $email_address ) ) {
			return array(
				'items_removed'  => false,
				'items_retained' => false,
				'messages'       => array(),
				'done'           => true,
			);
		}
		$items_removed = false;
		$count = 0;
		
		
		$pay_id = $wpdb->get_var("SELECT " . $wpdb->prefix . "wpdevart_payments.pay_id FROM " . $wpdb->prefix . "wpdevart_reservations LEFT JOIN " . $wpdb->prefix . "wpdevart_payments ON " . $wpdb->prefix . "wpdevart_reservations.id=" . $wpdb->prefix . "wpdevart_payments.res_id WHERE  " . $wpdb->prefix . "wpdevart_reservations.email LIKE '%" . $email_address . "%'");
		if($pay_id){
			$query = $wpdb->query($wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'wpdevart_payments WHERE pay_id="%d"',$pay_id ));
			$count += $query ? 1 : 0;
		}
		$query = $wpdb->query( 'DELETE FROM ' . $wpdb->prefix . 'wpdevart_reservations WHERE email LIKE "%' . $email_address . '%"');
		$count += $query ? 1 : 0;
		
		$query = $wpdb->query( 'DELETE FROM ' . $wpdb->prefix . 'wpdevart_themes WHERE value LIKE "%' . $email_address . '%"');
		$count += $query ? 1 : 0;
		$items_removed = ($count == 0) ? false : true;

		return array(
		  'items_removed' => $items_removed,
		  'items_retained' => false,
		  'messages' => array(),
		  'done' => true,
		);
	}
	
	public function wpdevart_privacy_policy() {
		$title = __('Booking Calendar WpDevArt', "booking-calendar");

	    $text = __('Booking Calendar WpDevArt(free and premium versions) has the opportunity for submitting forms and extras. When users submit forms or extras, they can also provide personal information, such as name, email, addresses, phone number and so on. All this data will be saved in WordPress database, so you need to receive user agreement when they submit booking forms(or extras). Also, you need to get the user agreement when you delete or export their data upon their request. In accordance with GDPR, you need to be sure that all information is protected and the other services that you are using also observe data protection. In this case, you have liability, so check other services privacy policy as well and tell them to follow to the GDPR.', "booking-calendar");

	    if ( ! function_exists( 'wp_add_privacy_policy_content' ) ) {
			return;
		}
		wp_add_privacy_policy_content(
			'Booking Calendar WpDevArt', // section name
			'<h3>' . $title . '</h3>' . '<p class="wp-policy-help">' . $text . '</p>' // content
		);

	}
	
	public function get_form_data($form, $cal_id, $form_id, $type = "") {
		global $wpdb;
		if($form) {
			$form_value = json_decode($form, true);
			$form_info = $wpdb->get_var($wpdb->prepare('SELECT data FROM ' . $wpdb->prefix . 'wpdevart_forms WHERE id="%d"', $form_id));
			if($form_info) {
				$form_info = json_decode($form_info, true);
				if(isset($form_info['apply']) || isset($form_info['save']))	{
					array_shift($form_info);
				}
				foreach($form_info as $key=>$form_fild_info) { 
					if(isset($form_value["wpdevart_".$type.$key])) {
						$form_info[$key]["value"] = $form_value["wpdevart_".$type.$key];
					}
					else {
						$form_info[$key]["value"] = "";
					}
				}
			} else {
				$form_info = array();
			}
		} else {
			$form_info = array();
		}
		$value = "";
		if(count($form_info)){
			foreach($form_info as $form_fild_data) {
				$field_val = $form_fild_data["value"];
				if(strpos($form_fild_data["value"], "|wpdev|") !== false){
					$field_val = explode("|wpdev|",$form_fild_data["value"]);
					$field_val = implode(", ",$field_val);
				}
				if($form_fild_data["type"] == "upload" && trim($field_val) != "")
					$field_val = "<a href='" . $field_val . "' target='_blank'>" . __("File", 'booking-calendar') . "</a>";
				$value .= "<strong>". $form_fild_data["label"] .":</strong> ". $field_val ."<br />";
			}
		}
		
		return $value;
	  } 
	/*GDPR*/
	
	public function wpdevart_captcha() {
		if(!check_ajax_referer('wpdevart_ajax_nonce', 'wpdevart_nonce')) {
			die('Request has failed.');
		}
		$response = isset($_POST['wpdevart_captcha']) ? esc_html($_POST['wpdevart_captcha']) : "";
        $global_settings = get_option("wpdevartec_settings") === false ? array() :  json_decode(get_option("wpdevartec_settings"), true);
		$secret = isset($global_settings["recaptcha_private_key"]) ? $global_settings["recaptcha_private_key"] : "";
		$verify = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$response}");
		if ( is_array( $verify ) && ! is_wp_error( $verify ) ) {
			$body    = $verify['body']; 
			$captcha_success = json_decode($body);
			if ($captcha_success->success == false) {
			  echo 0;
			}
			else if ($captcha_success->success==true) {
			  echo 1;
			}

		} else {
			echo 0;
		}
		
		wp_die();
	}
	
	/*Export*/
 	public function wpdevart_export() {
		if(!check_ajax_referer('wpdevart_ajax_nonce', 'wpdevart_nonce')) {
			die('Request has failed.');
		}
		require_once(WPDEVART_PLUGIN_DIR . 'admin/controllers/Reservations.php');
		$controller = new wpdevart_bc_ControllerReservations();
		$controller->export_as_csv();
		wp_die();
	}
	
	public function wpdevart_booking_calendar($id=0, $res_id=0, $date='', $ajax = false, $selected = array(),$data = array(),$submit = "",$widget = false,$hours = array()) {
		$main_class = new wpdevart_Main($id, $widget);
		ob_start();
		echo $main_class->main_booking_calendar($id,$res_id, $date, $ajax, $selected,$data,$submit,$hours);
		return ob_get_clean();
	}
	
	public function wpdevart_booking_calendar_res($id=0, $date='', $ajax = false) {
		$main_class = new wpdevart_Main($id);
		echo $main_class->main_booking_calendar_res($date, $ajax);
	}
	
	public function  wpdevart_get_interval_dates(){
		$main_class = new wpdevart_Main();
		$main_class->wpdevart_get_interval_dates();
	}
	
	public function wpdevart_ajax() {
		if(!check_ajax_referer('wpdevart_ajax_nonce', 'wpdevart_nonce')) {
			die('Request has failed.');
		}
		$id = isset($_POST['wpdevart_id']) ? sanitize_text_field($_POST['wpdevart_id']) : 0;
		$main_class = new wpdevart_Main($id, false);
		$main_class->main_ajax();
		wp_die();
	}
	
	public function wpdevart_form_ajax() {
		if(!check_ajax_referer('wpdevart_ajax_nonce', 'wpdevart_nonce')) {
			die('Request has failed.');
		}
		$id = isset($_POST['wpdevart_id']) ? sanitize_text_field($_POST['wpdevart_id']) : 0;
		$main_class = new wpdevart_Main($id, false);
		$main_class->main_form_ajax();
		wp_die();
	}
	
	public function wpdevart_payment_ajax() {
		if(!check_ajax_referer('wpdevart_ajax_nonce', 'wpdevart_nonce')) {
			die('Request has failed.');
		}
		$main_class = new wpdevart_Main();
		$main_class->main_payment_ajax();
		wp_die();
	}
	
	public function wpdevart_payment() {
		require_once(WPDEVART_PLUGIN_DIR . 'admin/controllers/Payment.php');
		$controller = new wpdevart_bc_ControllerPayments();
		$controller->perform();
	}
	
	public function wpdevart_quick_update() {
		if(!check_ajax_referer('wpdevart_ajax_nonce', 'wpdevart_nonce')) {
			die('Request has failed.');
		}
		$main_class = new wpdevart_Main();
		$main_class->main_quick_update();
		wp_die();
	}
	
	public function wpdevart_add_field() {
		if ( isset( $_POST['wpdevart_field_type'] ) ) {
			$type = str_replace('_field', '', sanitize_text_field( $_POST['wpdevart_field_type']));
		}
		$max_id = isset( $_POST['wpdevart_field_max'] ) ? sanitize_text_field( $_POST['wpdevart_field_max']) : 0;
		$count =  isset( $_POST['wpdevart_field_count'] )  ? sanitize_text_field( $_POST['wpdevart_field_count']) : 0;
		$args =  array(
			'name'   => 'form_field' . ($max_id + 1 + $count),
			'label' => __( 'New ' . $type . ' Field', 'booking-calendar' ),
			'type' => $type,
			'default' => ''
		);
		$function_name = "wpdevart_form_" . $type;
		wpdevart_bc_Library::$function_name($args, array('label' => __( 'New ' . $type . ' Field', 'booking-calendar' )));
		wp_die();
	}
	
	public function wpdevart_add_extra_field() {
		$max_id =  isset( $_POST['wpdevart_extra_field_max'] )  ? sanitize_text_field( $_POST['wpdevart_extra_field_max']) : 0;
		$count = isset( $_POST['wpdevart_extra_field_count'] )  ? sanitize_text_field( $_POST['wpdevart_extra_field_count']) : 0;
		$args =  array(
			'name'   => 'extra_field' . ($max_id + 1 + $count),
			'label' => __( 'New Extra', 'booking-calendar' ),
			'type' => 'extras_field',
			'items' => array(
				'field_item1' => array('name'=>'field_item1',
									'label' => '1',
									'operation' => '+',
									'price_type' => 'price',
									'price_percent' => '0',
									'order' => '1'
								),
				'field_item2' => array('name'=>'field_item2',
									'label' => '2',
									'operation' => '+',
									'price_type' => 'price',
									'price_percent' => '0',
									'order' => '2'
								),
				'field_item3' => array('name'=>'field_item3',
									'label' => '3',
									'operation' => '+',
									'price_type' => 'price',
									'price_percent' => '0',
									'order' => '3'
								)
			),
			'default' => ''
		);
		wpdevart_bc_Library::wpdevart_extras_field($args,$args);
		wp_die();
	}	
	
	public function wpdevart_add_extra_field_item() {
		$max_id = isset( $_POST['wpdevart_extra_field_item_max'] ) ? sanitize_text_field( $_POST['wpdevart_extra_field_item_max']) : 0;
		if ( isset( $_POST['wpdevart_extra_field'] ) ) {
			$extra_field = sanitize_text_field( $_POST['wpdevart_extra_field']);
		}
		$count = isset( $_POST['wpdevart_extra_field_item_count'] ) ? sanitize_text_field( $_POST['wpdevart_extra_field_item_count']) : 0;
		$args =  array('name'=>'field_item'. ($max_id + 1 + $count),
			'label' => ($max_id + 1),
			'operation' => '+',
			'price_type' => 'price',
			'price_percent' => '0',
			'order' => ($max_id + 1)
		);
		wpdevart_bc_Library::wpdevart_extras_field_item($extra_field,$args);
		wp_die();
	}
	
}
$wpdevart_booking = new wpdevart_bc_calendar(); // Creation of the main object

?>