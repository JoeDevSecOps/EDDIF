<?php 

/// class for install databese

class wpdevart_bc_install_database{

	function __construct(){
		
	}

    /*############  Update database function ################*/	
	
	public function update_databese($version,$recreate_db){
		global $wpdb;
		$this->install_databese();
		if(version_compare("10.1", $version, '>') || $recreate_db){
			$wpdb->query("ALTER TABLE `" . $wpdb->prefix . "wpdevart_reservations` ADD `is_new` int(1) NOT NULL");
			$wpdevart_payments = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "wpdevart_payments` (
				`pay_id` int(11) NOT NULL AUTO_INCREMENT,
				`res_id` int(11) NOT NULL,
				`payment_price` float NOT NULL,
				`tax` float NOT NULL,
				`pay_status` varchar(20) NOT NULL,
				`ip` varchar(32) NOT NULL,
				`ipn` varchar(32) NOT NULL,
				`payment_address` varchar(350) NOT NULL,
				`payment_info` text NOT NULL,
				`modified_date` varchar(20) NOT NULL,
				PRIMARY KEY (`pay_id`)
			  ) DEFAULT CHARSET=utf8;";
			$wpdb->query($wpdevart_payments);
		}
		if(version_compare("10.8", $version, '>') || $recreate_db){
			if(is_null($wpdb->get_row(  "SHOW COLUMNS FROM `" . $wpdb->prefix . "wpdevart_reservations` LIKE 'salfe_percent'" ) )){
				$wpdb->query("ALTER TABLE `" . $wpdb->prefix . "wpdevart_reservations` ADD COLUMN `sale_percent` varchar(16) NOT NULL");
			}
			if(is_null($wpdb->get_row(  "SHOW COLUMNS FROM `" . $wpdb->prefix . "wpdevart_forms` LIKE 'user_id'" ) )){
				$wpdb->query("ALTER TABLE `" . $wpdb->prefix . "wpdevart_forms` ADD COLUMN `user_id` int(11) NOT NULL");
				$wpdb->query("ALTER TABLE `" . $wpdb->prefix . "wpdevart_extras` ADD COLUMN `user_id` int(11) NOT NULL");
				$wpdb->query("ALTER TABLE `" . $wpdb->prefix . "wpdevart_themes` ADD COLUMN `user_id` int(11) NOT NULL");
			}
			if(is_null($wpdb->get_row(  "SHOW COLUMNS FROM `" . $wpdb->prefix . "wpdevart_reservations` LIKE 'sale_type'" ) )){
				$wpdb->query("ALTER TABLE `" . $wpdb->prefix . "wpdevart_reservations` ADD COLUMN `sale_type` varchar(16) NOT NULL");
			}
			$wpdb->query("ALTER TABLE `" . $wpdb->prefix . "wpdevart_forms` CHANGE `title` `title` varchar(128) NOT NULL");
			$wpdb->query("ALTER TABLE `" . $wpdb->prefix . "wpdevart_extras` CHANGE `title` `title` varchar(128) NOT NULL");
			$wpdb->query("ALTER TABLE `" . $wpdb->prefix . "wpdevart_themes` CHANGE `title` `title` varchar(128) NOT NULL");
		}
		if(version_compare("10.11", $version, '>') || $recreate_db){ 
			$wpdb->query("ALTER TABLE `" . $wpdb->prefix . "wpdevart_reservations` ADD COLUMN `name` varchar(128) NOT NULL AFTER `email`");
		}
		if(version_compare("10.12", $version, '>') || $recreate_db){ 
			$wpdb->query("ALTER TABLE `" . $wpdb->prefix . "wpdevart_reservations` ADD COLUMN `lang` varchar(16) NOT NULL");
		}
	}	
	public function install_databese(){
		global $wpdb;
		/* Create */
		$wpdevartbooking = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "wpdevart_calendars` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`user_id` int(11) NOT NULL,
			`title` varchar(128) NOT NULL,
			`hours_enabled` varchar(3) NOT NULL,
			`hours_interval_enabled` varchar(3) NOT NULL,
			`theme_id` int(11) NOT NULL,
			`form_id` int(11) NOT NULL,
			`extra_id` int(11) NOT NULL,
			PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8;";
		$wpdb->query($wpdevartbooking);
		
		$wpdevartbooking_dates = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "wpdevart_dates` (
			`unique_id` varchar(32) NOT NULL,
			`calendar_id` int(11) NOT NULL,
			`day` varchar(16) NOT NULL,
			`data` text NOT NULL,
			PRIMARY KEY (`unique_id`)
		  ) DEFAULT CHARSET=utf8;";
		$wpdb->query($wpdevartbooking_dates);
		
		$wpdevartbooking_forms = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "wpdevart_forms` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`title` varchar(128) NOT NULL,
			`data` text NOT NULL,
			`user_id` int(11) NOT NULL,
			PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8;";
		$wpdb->query($wpdevartbooking_forms);
		
		$wpdevartbooking_extras = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "wpdevart_extras` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`title` varchar(128) NOT NULL,
			`data` text NOT NULL,
			`user_id` int(11) NOT NULL,
			PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8;";
		$wpdb->query($wpdevartbooking_extras);
		
		$wpdevartbooking_themes = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "wpdevart_themes` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`title` varchar(128) NOT NULL,
			`value` longtext NOT NULL,
			`user_id` int(11) NOT NULL,
			PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8;";
		$wpdb->query($wpdevartbooking_themes);
		
		$wpdevartbooking_reservations = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "wpdevart_reservations` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`calendar_id` int(11) NOT NULL,
			`single_day` varchar(16) NOT NULL,
			`check_in` varchar(16) NOT NULL,
			`check_out` varchar(16) NOT NULL,
			`start_hour` varchar(16) NOT NULL,
			`end_hour` varchar(16) NOT NULL,
			`currency` varchar(32) NOT NULL,
			`count_item` int(10) NOT NULL,
			`price` float NOT NULL,
			`total_price` float NOT NULL,
			`extras` text NOT NULL,
			`extras_price` float NOT NULL,
			`form` text NOT NULL,
			`address_billing` text NOT NULL,
			`address_shipping` text NOT NULL,
			`email` varchar(128) NOT NULL,
			`name` varchar(128) NOT NULL,
			`status` varchar(16) NOT NULL,
			`payment_method` varchar(32) NOT NULL,
			`payment_status` varchar(32) NOT NULL,
			`date_created` varchar(64) NOT NULL,
			`is_new` int(1) NOT NULL,
			`sale_percent` varchar(16) NOT NULL,
			`sale_type` varchar(16) NOT NULL,
			`lang` varchar(16) NOT NULL,
			PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8;";
		$wpdb->query($wpdevartbooking_reservations);
		
		$wpdevart_payments = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "wpdevart_payments` (
			`pay_id` int(11) NOT NULL AUTO_INCREMENT,
			`res_id` int(11) NOT NULL,
			`payment_price` float NOT NULL,
			`tax` float NOT NULL,
			`pay_status` varchar(20) NOT NULL,
			`ip` varchar(32) NOT NULL,
			`ipn` varchar(32) NOT NULL,
			`payment_address` varchar(350) NOT NULL,
			`payment_info` text NOT NULL,
			`modified_date` varchar(20) NOT NULL,
			PRIMARY KEY (`pay_id`)
		  ) DEFAULT CHARSET=utf8;";
		$wpdb->query($wpdevart_payments);
		
		/* Insert */
		$wpdevart_calendar = $wpdb->get_var("SELECT id FROM ".$wpdb->prefix."wpdevart_calendars");
		if(!$wpdevart_calendar) {
			$wpdb->query( "INSERT INTO ".$wpdb->prefix."wpdevart_calendars (`id`, `user_id`, `title`, `hours_enabled`, `hours_interval_enabled`, `theme_id`, `form_id`, `extra_id`) VALUES(1, 1, 'Calendar', '', '', 1, 1, 0)" );
		}
		$wpdevart_extra = $wpdb->get_var("SELECT id FROM ".$wpdb->prefix."wpdevart_extras");
		if(!$wpdevart_extra) {
			$wpdb->query( 'INSERT INTO '.$wpdb->prefix.'wpdevart_extras (`id`, `title`, `data`, `user_id`) VALUES(1, \'Extra\', \'{"extra_field1":{"name":"extra_field1","label":"Adults","required":"on","items":{"field_item1":{"name":"field_item1","label":"1","operation":"+","price_type":"price","price_percent":"0"},"field_item2":{"name":"field_item2","label":"2","operation":"+","price_type":"price","price_percent":"0"},"field_item3":{"name":"field_item3","label":"3","operation":"+","price_type":"price","price_percent":"0"},"field_item4":{"name":"field_item4","label":"4","operation":"+","price_type":"price","price_percent":"0"}}},"extra_field2":{"name":"extra_field2","label":"Children ","items":{"field_item1":{"name":"field_item1","label":"1","operation":"+","price_type":"price","price_percent":"0"},"field_item2":{"name":"field_item2","label":"2","operation":"+","price_type":"price","price_percent":"0"},"field_item3":{"name":"field_item3","label":"3","operation":"+","price_type":"price","price_percent":"0"},"field_item4":{"name":"field_item4","label":"4","operation":"+","price_type":"price","price_percent":"0"}}}}\', 1)' );
		}
		$wpdevart_form = $wpdb->get_var("SELECT id FROM ".$wpdb->prefix."wpdevart_forms");
		if(!$wpdevart_form) {
			$wpdb->query( 'INSERT INTO '.$wpdb->prefix.'wpdevart_forms (`id`, `title`, `data`, `user_id`) VALUES(1, \'Form\', \'{"apply":"Apply","form_field1":{"type":"text","name":"form_field1","label":"First Name","required":"on","isname":"on"},"form_field2":{"type":"text","name":"form_field2","label":"Last Name","isname":"on"},"form_field3":{"type":"text","name":"form_field3","label":"Email","required":"on","isemail":"on"},"form_field4":{"type":"text","name":"form_field4","label":"Phone","required":"on"},"form_field5":{"type":"textarea","name":"form_field5","label":"Message","required":"on"}}\', 1)' );
		}
		$wpdevart_theme = $wpdb->get_var("SELECT id FROM ".$wpdb->prefix."wpdevart_themes");
		if(!$wpdevart_theme) {
			$wpdb->query( 'INSERT INTO '.$wpdb->prefix.'wpdevart_themes (`id`, `title`, `value`, `user_id`) VALUES(1,\'Theme\', \'{"title":"Theme","date_format":"F j, Y","week_days":"0","day_start":"1","default_year":"","default_month":"0","cal_animation_type":"none","scroll_offset":"","show_form":"on","type_days_selection":"multiple_days","sale_conditions":{"count":[""],"percent":[""]},"min_days":"","max_days":"","enable_checkinout":"on","enable_number_items":"on","terms_cond_link":"","enable_form_title":"on","enable_extras_title":"on","legend_enable":"on","legend_available_enable":"on","legend_available":"Available","legend_booked_enable":"on","legend_booked":"Booked","legend_unavailable_enable":"on","legend_unavailable":"Unavailable","action_after_submit":"stay_on_calendar","message_text":"Thanks :)","redirect_url":"","custom_css":"","currency":"USD","currency_pos":"after","type_hours_selection":"multiple_hours","hours_sale_conditions":{"count":[""],"percent":[""]},"min_hours":"","max_hours":"","show_hours_info":"on","hours":{"hour_value":[""],"hour_price":[""],"hours_marked_price":[""],"hours_availability":["available"],"hours_number_availability":[""],"hour_info":[""]},"show_day_info_on_hover":"on","days_for_new":"30","calendar_max_width":"680","calendar_header_font_weight":"normal","calendar_header_font_style":"normal","calendar_header_padding":"10","next_prev_month_size":"15","current_month_size":"19","current_year_size":"19","week_days_font_weight":"normal","week_days_font_style":"normal","week_days_size":"13","day_number_font_weight":"normal","day_number_font_style":"normal","day_number_size":"13","day_availability_font_weight":"normal","day_availability_font_style":"normal","day_availability_size":"13","day_price_font_weight":"normal","day_price_font_style":"normal","day_price_size":"12","days_min_height":"65","hours_width":"95","hours_height":"125","info_font_weight":"normal","info_font_style":"normal","info_size":"13","info_border_radius":"","form_title_weight":"normal","form_title_style":"italic","form_title_size":"21","form_labels_weight":"normal","form_labels_style":"italic","form_labels_size":"15","form_fields_weight":"normal","form_fields_style":"normal","form_fields_size":"15","form_submit_weight":"normal","form_style_style":"normal","reserv_info_weight":"normal","reserv_info_style":"normal","reserv_info_size":"14","widget_day_info_weight":"normal","widget_day_info_style":"normal","widget_day_info_size":"14","load_spinner_color":"#464646","calendar_header_bg":"#FFFFFF","next_prev_month":"#636363","current_month":"#636363","current_year":"#636363","week_days_bg":"#ECECEC","week_days_color":"#656565","calendar_bg":"#FFFFFF","calendar_border":"#ddd","day_bg":"#FFFFFF","day_number_bg":"#ECECEC","day_color":"#464646","day_availability_color":"#848484","day_price_color":"#848484","available_day_bg":"#FFFFFF","available_day_number_bg":"#85B70B","available_day_color":"#FFFFFF","selected_day_bg":"#FFFFFF","selected_day_number_bg":"#373740","selected_day_color":"#FFFFFF","selected_day_availability_color":"#848484","selected_day_price_color":"#848484","unavailable_day_bg":"#FFFFFF","unavailable_day_number_bg":"#464646","unavailable_day_color":"#ECECEC","unavailable_day_availability_color":"#848484","booked_day_bg":"#FFFFFF","booked_day_number_bg":"#FD7C93","booked_day_color":"#FFFFFF","booked_day_availability_color":"#848484","info_icon_color":"#FFFFFF","info_bg":"#FFFFFF","info_color":"#4E4E4E","form_bg":"#FDFDFD","form_border":"#ddd","form_title_color":"#636363","form_title_bg":"#FDFDFD","form_labels_color":"#636363","form_fields_color":"#636363","reserv_info_color":"#545454","total_bg":"#545454","total_color":"#F7F7F7","required_star_color":"#FD7C93","submit_button_bg":"#FD7C93","submit_button_color":"#FFFFFF","error_info_bg":"#FFFFFF","error_info_color":"#C11212","error_info_border":"#C11212","error_info_close_bg":"#C11212","error_info_close_color":"#FFFFFF","successfully_info_bg":"#FFFFFF","successfully_info_color":"#7FAD16","successfully_info_border":"#7FAD16","successfully_info_close_bg":"#7FAD16","successfully_info_close_color":"#FFFFFF","widget_day_info_bg":"#FFFFFF","widget_day_info_color":"#6B6B6B","widget_day_info_border_color":"#C7C7C7","use_phpmailer":"on","mail_bg":"#f3f3f3","mail_content_bg":"#FFFFFF","mail_color":"#5A5A5A","mail_header_img":"","mail_footer_text":"Copyright\u00a9 2016","mail_footer_text_color":"#a7a7a7","notify_admin_on_book":"on","notify_admin_on_book_to":"info@info.com","notify_admin_on_book_from":"[useremail]","notify_admin_on_book_fromname":"","notify_admin_on_book_subject":"You received a booking request.","notify_admin_on_book_content":"You received a payment. For more details, visit: [moderatelink]","notify_admin_on_approved":"on","notify_admin_on_approved_to":"info@info.com","notify_admin_on_approved_from":"[useremail]","notify_admin_on_approved_fromname":"","notify_admin_on_approved_subject":"Booking request has been approved.","notify_admin_on_approved_content":"Booking request has been approved. For more details, visit: [moderatelink]","notify_admin_paypal_to":"sadas@dsd.sd","notify_admin_paypal_from":"[useremail]","notify_admin_paypal_fromname":"","notify_admin_paypal_subject":"You received a booking request.","notify_admin_paypal_content":"You received a payment. For more details, visit: [moderatelink]","notify_user_on_book":"on","notify_user_on_book_from":"info@info.com","notify_user_on_book_fromname":"","notify_user_on_book_subject":"Your booking request has been sent.","notify_user_on_book_content":"Your booking request has been sent.","notify_user_on_approved":"on","notify_user_on_approved_from":"info@info.com","notify_user_on_approved_fromname":"","notify_user_on_approved_subject":"Your booking request has been approved","notify_user_on_approved_content":"Your booking request has been approved","notify_user_canceled":"on","notify_user_canceled_from":"info@info.com","notify_user_canceled_fromname":"","notify_user_canceled_subject":"Your booking request has been canceled","notify_user_canceled_content":"Your booking request has been canceled","notify_user_deleted_from":"info@info.com","notify_user_deleted_fromname":"","notify_user_deleted_subject":"Your booking request has been rejected","notify_user_deleted_content":"","notify_user_paypal_from":"info@info.com","notify_user_paypal_fromname":"","notify_user_paypal_subject":"Thank you for your purchase","notify_user_paypal_content":"Your order has been received. Thank you for your purchase! You will receive an order confirmation by email.","notify_user_paypal_failed_from":"info@info.com","notify_user_paypal_failed_fromname":"","notify_user_paypal_failed_subject":"Payment failed","notify_user_paypal_failed_content":"Your payment failed.","for_available":"available","for_booked":"Booked","for_unavailable":"Unavailable","for_check_in":"Check in","for_check_out":"Check out","for_date":"Date","for_no_hour":"No hour available.","for_start_hour":"Start hour","for_end_hour":"End hour","for_hour":"Hour","for_item_count":"Item count","for_termscond":"I accept to agree to the Terms & Conditions.","for_reservation":"Reservation","for_select_days":"Please select the days from calendar.","for_price":"Price","for_total":"Total","for_submit_button":"Book Now","for_request_successfully_sent":"Your request has been successfully sent. Please wait for approval.","for_request_successfully_received":"Your request has been successfully received. We are waiting you!","for_error_single":"There are no services available for this day.","for_error_multi":"There are no services available for the period you selected.","for_night":"You must select at least two days","for_min":"You must select at least [min] days","for_max":"You must select  lower than [max] days","for_min_hour":"You must select at least [min] hours","for_max_hour":"You must select  lower than [max] hours","for_capcha":"Was not verified by recaptcha","for_pay_in_cash":"Pay in cash","for_paypal":"Pay with PayPal","for_shipping_info":"Same as billing info","for_notify_admin_on_book":"Email on book to administrator does not send","for_notify_admin_on_approved":"Email on approved to administrator does not send","for_notify_user_on_book":"Email on book to user does not send","for_notify_user_on_approved":"Email on approved to user does not send","for_notify_user_canceled":"Email on canceled to user does not send","for_notify_user_deleted":"Email on delete to user does not send","billing_address_form":"1","shipping_address_form":"1","redirect_url_successful":"","tax":"","payment_mode":"sandbox","paypal_email":"","paypal_image":"' . WPDEVART_URL . '/css\/images\/paynow.png","button_action":"apply","task":"save","id":"0"}\', 1)' );
		}
	}
}
