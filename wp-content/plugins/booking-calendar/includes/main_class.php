<?php
class wpdevart_Main {
	
	private $reservation_model;
	private $theme_model;
	private $calendar_model;
	private $form_model;
	private $extra_model;
	private $theme_option;
	private $calendar_data;
	private $extra_field;
	private $form_option;
	private $booking_id;
	private $id;
	private $ids;
	private $widget;
	
	public function __construct($id = 0, $widget = false){
		$this->id = $id;
		$this->widget = $widget;
		$this->require_files();
		$this->reservation_model = new wpdevart_bc_ModelReservations();
		$this->theme_model = new wpdevart_bc_ModelThemes();
		$this->calendar_model = new wpdevart_bc_ModelCalendars();
		$this->form_model = new wpdevart_bc_ModelForms();
		$this->extra_model = new wpdevart_bc_ModelExtras();
		$this->ids = $this->calendar_model->get_ids($this->id);
		$this->theme_option = $this->theme_model->get_setting_rows($this->ids["theme_id"]);
		$this->calendar_data = $this->calendar_model->get_db_days_data($this->id);
		$this->extra_field = $this->extra_model->get_extra_rows($this->ids["extra_id"]);
		$this->form_option = $this->form_model->get_form_rows($this->ids["form_id"]);
		if($this->widget == true) {
			$this->booking_id = wpdevart_bc_calendar::$booking_count + 1000;
		} else {
			$this->booking_id = wpdevart_bc_calendar::$booking_count;
		}
		if(isset($this->theme_option)) {
			$this->theme_option = json_decode($this->theme_option->value, true);	
		} else {
			$this->theme_option = array();
		}
	}
	
	/**
	* Require files
	**/
	private function require_files() {
		wp_enqueue_script( 'wpdevart-script' );
		wp_localize_script( 'wpdevart-script', WPDEVART_PLUGIN_PREFIX, array(
			'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
			'ajaxNonce'   => wp_create_nonce( 'wpdevart_ajax_nonce' )
		) );
		require_once(WPDEVART_PLUGIN_DIR . "/admin/models/Reservations.php");
		require_once(WPDEVART_PLUGIN_DIR . "/admin/models/Themes.php");
		require_once(WPDEVART_PLUGIN_DIR . "/admin/models/Calendars.php");
		require_once(WPDEVART_PLUGIN_DIR . "/admin/models/Forms.php");
		require_once(WPDEVART_PLUGIN_DIR . "/admin/models/Extras.php");
	}

    /*############  Main booking function ################*/
	
	public function main_booking_calendar($id, $res_id = 0, $date='', $ajax = false, $selected = array(),$data = array(),$submit = "",$hours = array()){
		global $wpdb;
		$payments = array();
		$result = array();
		$mail_error = array();	
		$request_message = "";	
		$submit_message = "";	
		$booking_calendar = "";
		if(isset($_POST["resid_".$this->booking_id]))
			$res_id = $_POST["resid_".$this->booking_id];
		$res = $this->reservation_model->get_reservation_row($res_id);
		$cal_name = $this->calendar_model->get_calendar_rows($id);
		if(isset($_POST["payment_type_".$this->booking_id])) { 
		    $this->update_reservation($_POST,$this->booking_id);
            if($_POST["payment_type_".$this->booking_id] == "pay_in_cash"){ 
			
				wpdevart_bc_Library::wpdevart_redirect(esc_url($this->theme_option["redirect_url_successful"]));
				
			} elseif($_POST["payment_type_".$this->booking_id] == "paypal") {
				//require_once(WPDEVART_PLUGIN_DIR.'includes/payments.php');
				new WpdevartPayments($this->theme_option,$this->booking_id,$id,$res,$cal_name["title"]);
				//wpdevart_bc_Library::wpdevart_redirect($url);
			}
		}		
		if(isset($this->theme_option['delete_prev_date']) && $this->theme_option['delete_prev_date'] == "on") {
			$day = date( 'Y-m-d', strtotime("last day"));
			$wpdb->query("DELETE FROM ".$wpdb->prefix . "wpdevart_dates WHERE calendar_id=".$id." AND  day BETWEEN '1970-01-01' AND '".$day."'" );
			$wpdb->query("DELETE FROM ".$wpdb->prefix . "wpdevart_reservations WHERE calendar_id=".$id." AND  (single_day BETWEEN '1970-01-01' AND '".$day."' OR (check_in BETWEEN '1970-01-01' AND '".$day."' AND  check_out BETWEEN '1970-01-01' AND '".$day."'))" );
		}
		$for_trarray = $this->text_for_tr();	
			
		
		if ($date == '' && !isset( $_REQUEST['date'] )) {
			$date = date( 'Y-m-d' );
		}
		if (isset( $_REQUEST['date'] ) && $_REQUEST['date'] != '') {
			$date = $_REQUEST['date'];
		}
		/* Default year and month */
		if(isset($this->theme_option["default_month"]) && $this->theme_option["default_month"] != 0 && ($ajax == false || isset($data["wpdevart-submit".$submit]))) {
			$date_m = substr_replace($date,$this->theme_option["default_month"],5,2);
		}
		if(isset($this->theme_option["default_year"]) && $this->theme_option["default_year"] != "" && ($ajax == false || isset($data["wpdevart-submit".$submit]))) {
			if(isset($date_m )){
				$date_y = substr_replace($date_m,$this->theme_option["default_year"],0,4);
			} else{
				$date_y = substr_replace($date,$this->theme_option["default_year"],0,4);
			}
		}
		if(isset($date_m) && strtotime( $date ) < strtotime( $date_m )) {
			$date = $date_m;
		}
		if(isset($date_y) && strtotime( $date ) < strtotime( $date_y )) {
			$date = $date_y;
		}
		if ($date != '') {
			$date = $date;
		}
		$date  = date('Y-m-d', strtotime( $date ));
		$calendar_start = new wpdevart_bc_BookingCalendar($date, $res, $id, $this->theme_option, $this->calendar_data, $this->form_option, $this->extra_field,array(),false,$this->widget,$for_trarray);
		
		if(isset($hours['hours']) && $hours['hours'] == "true") {
			echo $calendar_start->booking_calendar_hours($hours['date']); 
			die();
		}
		if(isset($data["wpdevart-submit".$submit])){
			$result = $calendar_start->save_reserv($data,$submit);
			$save= $result[0];
			$send_mails = $result[1];
			if(isset($result[2]))
				$form_data = $result[2];
			
			if(isset($form_data) &&  $form_data['total_price'] !== false){
				if(isset($this->theme_option['paypal']) && $this->theme_option['paypal'] == "on"){
					$payments['paypal'] = "on";
					if(isset($this->theme_option["go_paypal"]) && $this->theme_option["go_paypal"] == 'on') { 
						$save_in_db = $wpdb->update($wpdb->prefix . 'wpdevart_reservations', array(
							'payment_method' => 'paypal',         
							'payment_status' => 'pending',
						 ), array('id' => $form_data['id']));
						new WpdevartPayments($this->theme_option,$this->booking_id,$id,$form_data,$cal_name["title"]);
					}
				}	
				if(isset($this->theme_option['pay_in_cash']) && isset($this->theme_option['pay_in_cash']) == "on") {
					$payments['pay_in_cash'] = "on";
				}
			}
			if(!is_admin() || count($data)) {
				if($save && isset($this->theme_option["enable_instant_approval"]) && $this->theme_option["enable_instant_approval"] == "on") {
					$request_message = $for_trarray["for_request_successfully_received"];
				} elseif($save) {
					$request_message = $for_trarray["for_request_successfully_sent"];
				}
				foreach($send_mails as $send_mail) {
					foreach($send_mail as $key=>$value) {
						if(isset($this->theme_option[$key."_error"]) && $this->theme_option[$key."_error"] == "on" && $value === false) {
							$mail_error[] = (isset($for_trarray["for_".$key]) ? $for_trarray["for_".$key] : "");
						}
					}		
				}
				if(isset($this->theme_option["action_after_submit"]) && $this->theme_option["action_after_submit"] == "stay_on_calendar") {
					$submit_message = wpdevart_bc_Library::translated_text($this->theme_option["message_text"]);
				}
				else { 
					if(count($payments) == 0) {
						$redirect_url = wpdevart_bc_Library::translated_text($this->theme_option["redirect_url"]);
						wpdevart_bc_Library::wpdevart_redirect(esc_url($redirect_url));
					}
				}
			} else {
				return;
			}
		}
		elseif(isset($data["wpdevart-update".$submit])){
			$result = $calendar_start->save_reserv($data,$submit,"update");
			$save= $result[0];
			$send_mails = $result[1];
			if(isset($result[2]))
				$form_data = $result[2];
			if(!is_admin() || count($data)) {
				if($save && isset($this->theme_option["enable_instant_approval"]) && $this->theme_option["enable_instant_approval"] == "on") {
					$request_message = $for_trarray["for_request_successfully_received"];
				} elseif($save) {
					$request_message = $for_trarray["for_request_successfully_sent"];
				}
				foreach($send_mails as $send_mail) {
					foreach($send_mail as $key=>$value) {
						if(isset($this->theme_option[$key."_error"]) && $this->theme_option[$key."_error"] == "on" && $value === false) {
							$mail_error[] = (isset($for_trarray["for_".$key]) ? $for_trarray["for_".$key] : "");
						}
					}		
				}
				if(isset($this->theme_option["action_after_submit"]) && $this->theme_option["action_after_submit"] == "stay_on_calendar") {
					$submit_message = wpdevart_bc_Library::translated_text($this->theme_option["message_text"]);
				}
			} else {
				return;
			}
		}
		$calendar_data_after_save = $this->calendar_model->get_db_days_data($id);
		$calendar = new wpdevart_bc_BookingCalendar($date, $res, $id, $this->theme_option, $calendar_data_after_save, $this->form_option,$this->extra_field, $selected,$ajax,$this->widget,$for_trarray);
		
		if(isset($this->theme_option) && !$ajax) {
			$booking_calendar .= $calendar->get_styles();
		}
		if(isset($form_data) &&  $form_data['total_price'] !== false){
			if(isset($this->theme_option['paypal']) && $this->theme_option['paypal'] == "on"){
				$payments['paypal'] = "on";
			}	
			if(isset($this->theme_option['pay_in_cash']) && isset($this->theme_option['pay_in_cash']) == "on") {
				$payments['pay_in_cash'] = "on";
			}
		}
		if (!$ajax) { 
			$min = (isset($this->theme_option["min_days"]) && $this->theme_option["min_days"] != '') ? $this->theme_option["min_days"] : 1;
			$max = (isset($this->theme_option["max_days"]) && $this->theme_option["max_days"] != '') ? $this->theme_option["max_days"] : 1000;
			$min_hour = (isset($this->theme_option["min_hours"]) && $this->theme_option["min_hours"] != '') ? $this->theme_option["min_hours"] : 1;
			$max_hour = (isset($this->theme_option["max_hours"]) && $this->theme_option["max_hours"] != '') ? $this->theme_option["max_hours"] : 1000;
		?>
		<script>
			var wpdevartBooking<?php echo $this->booking_id; ?> = {
				booking_id : <?php echo $this->booking_id; ?>,
				hours_enabled : <?php echo ((isset($this->theme_option['hours_enabled']) && $this->theme_option['hours_enabled'] == "on") ? 1 : 0 ); ?>,
				booking_widget : <?php echo ((isset($this->widget) && $this->widget == true) ? 1 : 0 ); ?>,
				show_day_info_on_hover : <?php echo ((isset($this->theme_option['show_day_info_on_hover']) && $this->theme_option['show_day_info_on_hover'] == 'on') ? 1 : 0 ); ?>,
				cal_animation_type : "<?php echo ((isset($this->theme_option['cal_animation_type']) && $this->theme_option['cal_animation_type'] != 'none') ? "animation_calendar" : "" ); ?>",
				booking_widget : <?php echo ((isset($this->widget) && $this->widget == true) ? 1 : 0 ); ?>,
				total : "<?php echo $for_trarray["for_total"]; ?>",
				price : "<?php echo $for_trarray["for_price"]; ?>",
				offset : <?php echo ((isset($this->theme_option["scroll_offset"]) && $this->theme_option["scroll_offset"] != '') ? $this->theme_option["scroll_offset"] : 0); ?>,
				position : "<?php echo ((isset($this->theme_option["currency_pos"]) && $this->theme_option["currency_pos"] == 'before') ? "before" : "after"); ?>",
				night : <?php echo ((isset($this->theme_option["price_for_night"]) && $this->theme_option["price_for_night"] == 'on') ? 1 : 0); ?>,
				id : <?php echo $id; ?>,
				capcha_error : "<?php echo $for_trarray["for_capcha"]; ?>",
				conditions : '<?php echo ((isset($this->theme_option["sale_conditions"]) && $this->theme_option["sale_conditions"] != '') ? json_encode($this->theme_option["sale_conditions"]) : ""); ?>',
				hours_conditions : '<?php echo ((isset($this->theme_option["hours_sale_conditions"]) && $this->theme_option["hours_sale_conditions"] != '') ? json_encode($this->theme_option["hours_sale_conditions"]) : ""); ?>',
				hide_price : <?php echo ((isset($this->theme_option['hide_price']) && $this->theme_option['hide_price'] == "on") ? 1 : 0 ); ?>,
				max_item : "<?php echo ((isset($this->theme_option['max_item'])) ? $this->theme_option['max_item'] : "" ); ?>",
				min_item : "<?php echo ((isset($this->theme_option['min_item'])) ? $this->theme_option['min_item'] : "" ); ?>",
				error_days : "<?php echo $for_trarray["for_error_multi"]; ?>",
				error_night : "<?php echo $for_trarray["for_night"]; ?>",
				min : "<?php echo $min; ?>",
				max : "<?php echo $max; ?>",
				min_hour : "<?php echo $min_hour; ?>",
				max_hour : "<?php echo $max_hour; ?>",
				error_min_day : "<?php echo str_replace("[min]", $min, $for_trarray["for_min"]); ?>",
				error_max_day : "<?php echo str_replace("[max]", $max, $for_trarray["for_max"]); ?>",
				error_min_hour : "<?php echo str_replace("[min]", $min_hour, $for_trarray["for_min_hour"]); ?>",
				error_max_hour : "<?php echo str_replace("[max]", $max_hour, $for_trarray["for_max_hour"]); ?>",
				error_day : "<?php echo $for_trarray["for_error_single"]; ?>"
			};
		</script>
		<?php
		    $class = "booking_calendar_main_container";
		    $class .= (isset($this->theme_option['hours_enabled']) && $this->theme_option['hours_enabled'] == "on") ? " hours_enabled" : "";
		    $class .= (isset($this->widget) && $this->widget == true) ? " booking_widget" : "";
		    $class .= (isset($this->theme_option['show_day_info_on_hover']) && $this->theme_option['show_day_info_on_hover'] == 'on') ? " show_day_info_on_hover" : "";
		    $class .= (isset($this->theme_option['cal_animation_type']) && $this->theme_option['cal_animation_type'] != 'none') ? " animation_calendar" : "";
		    
			$booking_calendar .= "<div id='booking_calendar_main_container_" . $this->booking_id  . "' class='" . $class . "' data-total='".$for_trarray["for_total"]."' data-price='".$for_trarray["for_price"]."' data-offset='".((isset($this->theme_option["scroll_offset"]) && $this->theme_option["scroll_offset"] != '') ? $this->theme_option["scroll_offset"] : 0)."' data-position='".((isset($this->theme_option["currency_pos"]) && $this->theme_option["currency_pos"] == 'before') ? "before" : "after")."' data-night='".((isset($this->theme_option["price_for_night"]) && $this->theme_option["price_for_night"] == 'on') ? "1" : "0")."' data-id='" . $id . "' data-booking_id='" . $this->booking_id . "'>";
			$booking_calendar .= "<div class='booking_calendar_container' id='booking_calendar_container_" . $this->booking_id  . "'><div class='wpdevart-load-overlay'><div class='wpdevart-load-image'><i class='fa fa-spinner fa-spin'></i></div></div>";
		}	
		if ((isset($this->theme_option['messages_pos']) && $this->theme_option['messages_pos'] == "top") || !isset($this->theme_option['messages_pos'])) {
			if (isset($submit_message) && $submit_message != "") {
				$booking_calendar .= "<div class='booking_calendar_message successfully_text_container'>".$submit_message."<span class='notice_text_close'><i class='fa fa-close'></i></span></div>";
			}
			if($request_message != "") {
				$booking_calendar .= "<div class='successfully_text_container div-for-clear'>".$request_message."<span class='notice_text_close'><i class='fa fa-close'></i></span></div>";
			}
			if(count($mail_error)) {
				$booking_calendar .= '<div class="error_text_container div-for-clear email_error" style="display: block;"><span class="error_text">';
				foreach($mail_error as $error) {
					$booking_calendar .= $error. "</br>";
				}
				$booking_calendar .= '</span><span class="notice_text_close"><i class="fa fa-close"></i></span></div>';
			}
			if (!$ajax) {
				$booking_calendar .= "<div class='error_text_container div-for-clear'><span class='error_text'></span><span class='notice_text_close'><i class='fa fa-close'></i></span></div>";
			}	
		}	
		$booking_calendar .= "<div class='booking_calendar_main'>";
		if( isset($data["wpdevart-submit".$submit]) ){ 
			if( isset($this->theme_option["show_booking_info"]) && $this->theme_option["show_booking_info"] == "on") {
				$booking_calendar .= $this->show_reservation_info($form_data);
			}
			if(count($payments)) {
				$booking_calendar .= '<div class="wpdevart_order"><form method="post" id="wpdevart_order_'.$submit.'" class="div-for-clear">';
				
				$class	= (!isset($this->theme_option["enable_billing_address"]) && !isset($this->theme_option["enable_shipping_address"])) ? "payment_submit" : "";
				foreach($payments as $key=>$payment){
					$button_cl = "";
					if($key == "paypal" && isset($this->theme_option["paypal_image"]) && $this->theme_option["paypal_image"] != ""){
						$button_content = "<img src='" . esc_url($this->theme_option["paypal_image"]) . "'>";
						$button_cl = "with_image";
					} else{
						$button_content = $for_trarray["for_".$key];
					}
					$booking_calendar .= '<button type="button" class="wpdevart-payment-button ' . $button_cl . ' ' . $class . '" id="'.$key.'" name="wpdevart-payment'.$submit.'" data-id="'.$submit.'" data-resid="'.(isset($form_data)? $form_data['id'] : "").'" data-themeid="'.$this->ids["theme_id"].'">'.$button_content .'</button>';
				}
				$booking_calendar .= '<div class="wpdevart_order_wrap"></div>';
				$booking_calendar .= '<div class="wpdevart_order_content" id="wpdevart_booking_form_'.$submit.'"></div>';
				$booking_calendar .= '<input type="hidden" name="resid_'.$submit.'" value="'.(isset($form_data)? $form_data['id'] : "").'">
									  <input type="hidden" name="payment_type_'.$submit.'" value="">
									  <input type="hidden" name="view" id="add" value="add">';
				$booking_calendar .= '</form></div>';
			}
		}
		if( (!(isset($data["wpdevart-submit".$submit]) && count($payments))) || isset($data["wpdevart-update".$submit])) {
			$booking_calendar .= $calendar->booking_calendar();
			if (!$ajax) {
				$booking_calendar .= "</div>";
			}
			
			
		    if (isset($this->theme_option['messages_pos']) && $this->theme_option['messages_pos'] == "bottom") {
				if (isset($submit_message) && $submit_message != "") {
					$booking_calendar .= "<div class='booking_calendar_message successfully_text_container'>".$submit_message."<span class='notice_text_close'><i class='fa fa-close'></i></span></div>";
				}
				if($request_message != "") {
					$booking_calendar .= "<div class='successfully_text_container div-for-clear'>".$request_message."<span class='notice_text_close'><i class='fa fa-close'></i></span></div>";
				}
				if(count($mail_error)) {
					$booking_calendar .= '<div class="error_text_container div-for-clear email_error" style="display: block;"><span class="error_text">';
					foreach($mail_error as $error) {
						$booking_calendar .= $error. "</br>";
					}
					$booking_calendar .= '</span><span class="notice_text_close"><i class="fa fa-close"></i></span></div>';
				}
				if (!$ajax) {
					$booking_calendar .= "<div class='error_text_container div-for-clear'><span class='error_text'></span><span class='notice_text_close'><i class='fa fa-close'></i></span></div>";
				}	
			}	
			
			
			$booking_calendar .= "</div>";
			if((!is_admin() || (isset($_GET["page"]) && $_GET["page"] == "wpdevart-reservations"))) {
				$class = "";
				if(!isset($data["wpdevart-update".$submit])){
					if(!isset($this->theme_option["show_form"])) {
						$class = "hide_form";
					}
					if(count($payments)) {
						$class .= " cal_width_pay";
					}
				}
				$class .= (isset($this->theme_option['form_layout']) && $this->theme_option['form_layout'] == "one_col") ? " one_col" : "";
				$booking_calendar .= $calendar->booking_form($class);
			}
			if (!$ajax) {
				$booking_calendar .= "</div>";
			}
		}else{
			$booking_calendar .= "</div>";
		}
		return $booking_calendar;
	}
	
	public function main_booking_calendar_res($date='', $ajax = false){
		$calendar = new wpdevart_bc_BookingCalendar($date, 0, $this->id, $this->theme_option, $this->calendar_data, $this->form_option, $this->extra_field, array());
		$booking_calendar = "";
				
		if (!$ajax) {
			$booking_calendar .= "<div class='booking_calendar_container' id='booking_calendar_container_" . wpdevart_bc_calendar::$booking_count . "'><div class='wpdevart-load-overlay'><div class='wpdevart-load-image'><i class='fa fa-spinner fa-spin'></i></div></div>";
		}	
			
		$booking_calendar .= "<div class='booking_calendar_main'>";
		$booking_calendar .= $calendar->booking_calendar("reservation");
		if (!$ajax) {
			$booking_calendar .= "</div>";
		}
		$booking_calendar .= "</div>";		
		return $booking_calendar;
	}
	
	public function main_ajax(){
		$selected = array();
		$res_id = 0;
		if(isset($_POST['wpdevart_link'])) {
			$link = esc_html( $_POST['wpdevart_link'] );
			parse_str( $link, $link_arr );
			$date = $link_arr['?date'];
		}
		
		if(isset($_POST['wpdevart_id'])) {
			$id = esc_html($_POST['wpdevart_id']);
		}
		if(isset($_POST['wpdevart_reserv'])) {
			$reserv = esc_html($_POST['wpdevart_reserv']);
		}
		if(isset($_POST['wpdevart_selected'])) {
			$selected["index"] = esc_html($_POST['wpdevart_selected']);
		}
		if(isset($_POST['wpdevart_selected_date'])) {
			$selected["date"] = esc_html($_POST['wpdevart_selected_date']);
		}
		if(isset($_POST['wpdevart_hours'])) {
			$selected['hours'] = esc_html($_POST['wpdevart_hours']);
		}
		if(isset($_POST['wpdevart_reserv_id'])) {
			$res_id = esc_html($_POST['wpdevart_reserv_id']);
		}

		if(isset($reserv) && $reserv == "true") {
			echo $this->main_booking_calendar_res($date,true);
		} elseif(isset($selected['hours']) && $selected['hours'] == "true") {
			echo $this->main_booking_calendar($id, $res_id,'',false,array(),array(),"",$selected);
		} else {
			echo $this->main_booking_calendar($id,0,$date,true,$selected);
		}
	}
	
	public function main_form_ajax(){
		$id = 0;
		$data = array();
		$submit = "";
		if(isset($_POST['wpdevart_id'])) {
			$id = esc_html($_POST['wpdevart_id']);
		}
		if(isset($_POST['wpdevart_data'])) {
			$data = json_decode(stripcslashes($_POST['wpdevart_data']),true);
		}
		if(isset($_POST['wpdevart_submit'])) {
			$submit = esc_html($_POST['wpdevart_submit']);
		}
		echo $this->main_booking_calendar($id,0,"",true,array(),$data,$submit);
	}
	
	
	public function  wpdevart_get_interval_dates(){
		global $wpdb;
		$start_date = "1970-01-01";
		$end_date = "1970-01-01";
		$id = 0;
		$selected_dates = array(); // main genereted days
		$avaible_days_array = array();
		if(isset($_GET['wpdevart_start_date']))
			$start_date = date( 'Y-m-d', strtotime($_GET['wpdevart_start_date']));
		else
			die('0');
		
		if(isset($_GET['wpdevart_end_date']))
			$end_date = date( 'Y-m-d', strtotime($_GET['wpdevart_end_date']));
		else
			die('0');
		
		if(isset($_GET['wpdevart_id']))
			$id = $_GET['wpdevart_id'];
		else
			die('0');
		
		$ids = $this->calendar_model->get_ids($id);
		$theme_option = $this->theme_model->get_setting_rows($ids["theme_id"]);
		$theme_option = json_decode($theme_option->value,true);
		$date_diff = abs($this->get_date_diff($start_date,$end_date));
		if($date_diff > 3500){
			die("0");
		}
		$get_cur_call_all_dates = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'wpdevart_dates WHERE calendar_id="%d"', $id),ARRAY_A);
		
		foreach($get_cur_call_all_dates as $key => $value){
			$jsoned_value = json_decode($value['data'],true);
			if($jsoned_value['status'] == 'available' || (isset($theme_option['price_for_night']) && $theme_option['price_for_night'] == "on")){
				$avaible_days_array[$key] = $value['day'];				
			}
		}
		
		for($i=0; $i <= $date_diff; $i++) {
			$day = date( 'Y-m-d', strtotime($start_date. " +" . $i . " day" ));
			$week_day = date('w', strtotime($start_date. " +" . $i . " day" ));
			if(!(isset($theme_option['unavailable_week_days']) && in_array($week_day,$theme_option['unavailable_week_days']))) {
				if(false !== $key = array_search($day,$avaible_days_array)){
					$selected_dates[] = $get_cur_call_all_dates[$key];
				}else{
					if(isset($theme_option['price_for_night']) && $theme_option['price_for_night'] == "on" && $date_diff == $i) {
						continue;
					}
					die('0');
				}
			}
		}
		echo json_encode($selected_dates);
		die();
		
	}
	
	public function main_payment_ajax(){
		$resid = 0;
		$themeid = 0;
		$id = 0;
		$type = "";
		if(isset($_POST['wpdevart_data'])) {
			$type = esc_html($_POST['wpdevart_data']);
		}
		if(isset($_POST['wpdevart_id'])) {
			$id = esc_html($_POST['wpdevart_id']);
		}
		if(isset($_POST['wpdevart_resid'])) {
			$resid = esc_html($_POST['wpdevart_resid']);
		}
		if(isset($_POST['wpdevart_themeid'])) {
			$themeid = esc_html($_POST['wpdevart_themeid']);
		}
		$cal_name = $this->calendar_model->get_calendar_rows($id);
		$addresses = $this->theme_model->get_payment_info($themeid);
		$for_trarray = $this->text_for_tr();
		$reserv = self::wpdevart_payment($id,$type,$addresses,$for_trarray,$resid,$cal_name["title"]);
		echo $reserv[0];
	}
	
	public function main_quick_update(){
		global $wpdb;
		$id = 0;
		$data = "";
		if(isset($_POST['wpdevart_data'])) {
			$data = esc_html($_POST['wpdevart_data']);
		}
		if(isset($_POST['wpdevart_id'])) {
			$id = esc_html($_POST['wpdevart_id']);
		}
		$update_res = $wpdb->update($wpdb->prefix . 'wpdevart_reservations',
			array('payment_status' => $data,
				  'is_new' => 0),
			array('id' => $id),
			array('%s')
		);
		$update_res = $wpdb->update($wpdb->prefix . 'wpdevart_payments',
			array('pay_status' => $data),
			array('res_id' => $id),
			array('%s')
		);
	}
	
	private function update_reservation($data,$submit){
		global $wpdb;
		$save = false;
		$billing_form = array();
		$shipping_form = array();
		foreach($data as $key=>$item) {
			if(strrpos($key,"billing_info_form_field") !== false) {
				$billing_form[$key] = esc_html($item);		
			}
			if(strrpos($key,"shipping_info_form_field") !== false) {
				$shipping_form[$key] = esc_html($item);		
			}
		}
		$billing_form = json_encode($billing_form);
		$shipping_form = json_encode($shipping_form);
		
		$payment_type = wpdevart_bc_Library::getData($data, 'payment_type_'.$submit, 'text', '');
		$resid = wpdevart_bc_Library::getData($data, 'resid_'.$submit, 'text', '');
		
		$save_in_db = $wpdb->update($wpdb->prefix . 'wpdevart_reservations', array(
		    'address_billing' => $billing_form,         
			'address_shipping' => $shipping_form, 
			'payment_method' => $payment_type,         
			'payment_status' => 'pending',
		 ), array('id' => $resid));
 
		$result = $save_in_db; 
		return $result;	
	}
	private function show_reservation_info($data) {
		$form_data = $this->reservation_model->get_form_data($data['form'],$this->id);
        $extras_data = $this->reservation_model->get_extra_data($data,"front",0,$this->id);
		$countries = wpdevart_bc_Library::get_countries();
		$reserv_info = '<div class="wpdevart_reservation_info">';
		$cur_pos = (isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "before") ? "before" : "after";
		if(count($data)) {
			$hour_html = "";
			if(isset($this->theme_option["date_format"]) && $this->theme_option["date_format"] != "") {
				$date_format = $this->theme_option["date_format"];
			} else {
				$date_format = "F d, Y";
			}
			if($data['check_in']) {
				$check_in = date($date_format, strtotime($data['check_in']));
				$check_out = date($date_format, strtotime($data['check_out']));
			} else {
				$single_day = date($date_format, strtotime($data['single_day']));
			}
			if(isset($single_day)) {
				$unique_id = $data['calendar_id']."_".$data['single_day'];
				$day_hours = self::get_date_data( $unique_id );
				$day_hours = json_decode($day_hours, true);
			}
			if(isset($data['start_hour']) && $data['start_hour'] != "") {
				$hour_html = $data['start_hour'];
			}
			if(isset($data['end_hour']) && $data['end_hour'] != "") {
				$hour_html = $hour_html." - ".$data['end_hour'];
			}
			if(isset($check_in) && isset($check_out)) {
				$date = $check_in. " - " .$check_out;
			} else {
				$date = $single_day;
			} 
			$sale_percent_html = "";
			if(isset($data["sale_percent"]) && !empty($data["sale_percent"])){
				if($data["sale_type"] == "percent"){
					$sale_percent = $data["sale_percent"] != "100" ? (($data["total_price"]  * 100) / (100 - $data["sale_percent"])) : $data["price"];
					$sale_percent_html = (($cur_pos == "before" ? $data["currency"] : '') . $sale_percent . ($cur_pos == "after" ? $data["currency"] : '')) . " - " . $data["sale_percent"] . "% = ";
				} else{
					$sale_percent = $data["total_price"] + $data["sale_percent"];
					$sale_percent_html = (($cur_pos == "before" ? $data["currency"] : '') . $sale_percent . ($cur_pos == "after" ? $data["currency"] : '')) . " - " . ($cur_pos == "before" ? $data["currency"] : '') . $data["sale_percent"] . ($cur_pos == "after" ? $data["currency"] : '') . " = ";

				}
			}
			if($hour_html != "") {
				$date .= "<div>".__("Hour","booking-calendar")." ".$hour_html."</div>";
			}
			$reserv_info .= self::reservation_item(__('Reservation ID','booking-calendar'),$data["id"]);
			$reserv_info .= self::reservation_item(__('Reservation date','booking-calendar'),$date);
			if($data["count_item"] != "" && $data["count_item"] != 0){
				$reserv_info .= self::reservation_item(__('Item Count','booking-calendar'),$data["count_item"]);
			}
			$reserv_info .= self::reservation_item(__('Price','booking-calendar'),($cur_pos == "before" ? $data["currency"] : '') . $data["price"] . ($cur_pos == "after" ? $data["currency"] : ''));
			$reserv_info .= self::reservation_item(__('Total','booking-calendar'),$sale_percent_html . (($cur_pos == "before" ? $data["currency"] : '') . $data["total_price"] . ($cur_pos == "after" ? $data["currency"] : '')));
			if(count($extras_data)) {
				foreach($extras_data as $extra_data) {
					$reserv_info .= self::reservation_item(wpdevart_bc_Library::translated_text($extra_data["group_label"]),"");
					if($extra_data["price_type"] == "percent") {
						$extra_value = "<span class='price-percent'>".$extra_data["operation"].$extra_data["price_percent"]."% </span>";
						$extra_value .= "<span class='price'>".$extra_data["operation"] . ($cur_pos == "before" ? $data['currency'] : '') . (isset($extra_data["price"]) ? $extra_data["price"] : "") . ($cur_pos == "after" ? $data['currency'] : '')."</span></span></span>";
					} else {
						$extra_value = "<span class='price'>".$extra_data["operation"] .(($cur_pos == "before" ? $data['currency'] : '') . $extra_data["price"] . ($cur_pos == "after" ? $data['currency'] : ''))."</span></span></span>";
					}	
					$reserv_info .= self::reservation_item(wpdevart_bc_Library::translated_text($extra_data["label"]),$extra_value); 
				}
				$reserv_info .= self::reservation_item(__("Price change",'booking-calendar'),("<span class='form_info'><span class='form_label'></span><span class='form_value'>".(($data['extras_price']<0)? "" : "+").(($cur_pos == "before" ? $data['currency'] : '') . $data['extras_price'] . ($cur_pos == "after" ? $data['currency'] : ''))."</span>"));
			}
			if(count($form_data)) {
				foreach($form_data as $form_fild_data) {
					if($form_fild_data['type'] == 'countries' && trim($form_fild_data['value']) != "") {
						$reserv_info .= self::reservation_item(wpdevart_bc_Library::translated_text($form_fild_data["label"]),$countries[$form_fild_data["value"]]);					
					}elseif($form_fild_data['type'] == 'checkbox') {
						if($form_fild_data['value'] == "on") {
							$reserv_info .= self::reservation_item(wpdevart_bc_Library::translated_text($form_fild_data["label"]),"<i title='Close' class='fa fa-check'></i>");
						} else {
							$reserv_info .= self::reservation_item(wpdevart_bc_Library::translated_text($form_fild_data["label"]),"");
						}
					}else {
						$reserv_info .= self::reservation_item(wpdevart_bc_Library::translated_text($form_fild_data["label"]),$form_fild_data["value"]);					
					}
				}
			}
		}
		$reserv_info .= '</div>';
		return $reserv_info;
	}
	
 	private static function reservation_item($label,$value) {
		if(strpos($value, "|wpdev|") !== false){
			$value = explode("|wpdev|",$value);
			$value = implode(", ",$value);
		}
		$reserv_info = '<div class="div-for-clear res-item-container">
							<div class="section-title">
								<span class="wpdevart-title">'.$label.'</span>
							</div>
							<div class="res-item-value">
								<span class="wpdevart-title">'.$value.'</span>
							</div>
						</div>';
		return $reserv_info;
	}
	
	private static function get_date_data( $unique_id ) {
		global $wpdb;
		$date_info = "";
		$row = $wpdb->get_row($wpdb->prepare('SELECT data FROM ' . $wpdb->prefix . 'wpdevart_dates WHERE unique_id="%s"', $unique_id),ARRAY_A);
		if(is_array($row) &&  isset($row["data"]))
			$date_info = $row["data"];
		return $date_info;
	}
	
		
	public function get_extra_data($extras,$cal_id) {
		global $wpdb;
		$extra = $extras->extras;
		$price = $extras->price;
		if($extra) {
			$extras_value = json_decode($extra, true);
			$extra_id = $wpdb->get_var($wpdb->prepare('SELECT extra_id FROM ' . $wpdb->prefix . 'wpdevart_calendars WHERE id="%d"', $cal_id));
			$extra_info = $wpdb->get_var($wpdb->prepare('SELECT data FROM ' . $wpdb->prefix . 'wpdevart_extras WHERE id="%d"', $extra_id));
			$extra_info = json_decode($extra_info, true);
			
			if(isset($extra_info['apply']) || isset($extra_info['save']))	{
				array_shift($extra_info);
			}
			foreach($extras_value as $key=>$extra_value) { 
				if(isset($extra_info[$key])) {
					$extras_value[$key]["group_label"] = $extra_info[$key]["label"];
					if($extra_value['price_type'] == "percent") {
						$extras_value[$key]["price"] = ($price*$extra_value['price_percent'])/100;
					} else {
						$extras_value[$key]["price"] = $extra_value['price_percent'];
					}
				}
				else {
					$extras_value[$key]["group_label"] = "";
				}
			}
		} else {
			$extras_value = array();
		}
		return $extras_value;
	} 
	
	public static function wpdevart_payment($id,$type,$addresses,$for_trarray,$resid,$cal_name) {
		
		$payment_form = '<div class="wpdevart_order_content visible"  id="wpdevart_booking_form_'.$id.'">';
		$payment_form .= '<h4 class="form_title order_title">'.$for_trarray['for_'.$type].'<span class="wpdevart_close_popup"><i class="fa fa-close"></i></span></h4>';
		$payment_form .= '<div class="wpdevart_order_container wpdevart-booking-form">';
		if(count($addresses)){
			foreach($addresses as $key => $form_item) {
				if($key != 'theme_option'){
					$payment_form .= "<div class='address_item'>";
					$payment_form .= "<h4 class='form_title'>".$form_item["title"]."</h4>";
					if($key == "shipping_info") {
						$payment_form .= '<div class="wpdevart-fild-item-container"><label for="wpdevart_form_field9">'.$for_trarray['for_shipping_info'].'</label><div class="wpdevart-elem-container div-for-clear" id="wpdevart_wrap_form_field_'.$id.'"><input type="checkbox" id="wpdevart_form_field_'.$id.'" name="wpdevart_form_field_'.$id.'" class="wpdevart_shipping"></div></div>';
					}
					$form_array = json_decode($form_item["data"],true);
					foreach($form_array as $key2 => $form_field) {
						if(isset($form_field['type'])) {
							$func_name = "form_field_" . $form_field['type'];
							if(method_exists("wpdevart_Main",$func_name)) {
								$payment_form .= self::$func_name($form_field,$key);
							}
						}
					}
					$payment_form .= "</div>";
				}
			}
		}
		$payment_form .= '<button type="submit" name="payment_submit_'.$id.'" id="payment_submit_'.$id.'" class="wpdevart-submit order-submit">'.$for_trarray['for_submit_button'].'</button>';
		$payment_form .= '</div></div>';
		return array($payment_form,$resid);
	}
 	private static function form_field_checkbox($form_field,$type){
		$input_class = '';
		$field_html = '';
		$field_html .= '<div class="wpdevart-fild-item-container">';
		$field_html .= '<label for="wpdevart_'.$form_field['name'].'">'.esc_html($form_field['label']);

		if(isset($form_field['required'])) {
			$field_html .= '<span class="wpdevart-required">*</span>';
			$input_class = 'class="wpdevart-required"';
		}		
		$field_html .= '</label>';
		$field_html .= '<div class="wpdevart-elem-container div-for-clear" id="wpdevart_wrap_'.$form_field['name'].'">
				  <input type="checkbox" id="wpdevart_'.$form_field['name'].'" name="wpdevart_'.$type."_".$form_field['name'].'" '.$input_class.'>
			    </div>
		     </div>';
		return $field_html;
	}
	private static function form_field_text($form_field,$type){
		$input_class = array();
		$field_html = '';
		$readonly = '';
		$required = '';
		if(isset($form_field['required'])) {
			$required .= '<span class="wpdevart-required">*</span>';
			$input_class[] = 'wpdevart-required';
		}		
		if(isset($form_field['isemail']) && $form_field['isemail'] == "on" ) {
			$input_class[] = 'wpdevart-email';
		}		
		if(isset($form_field['confirm_email']) && $form_field['confirm_email'] == "on" ) {
			$input_class[] = 'confirm_email';
		}			
		if(isset($form_field['class']) && $form_field['class'] != "" ) {
			$input_class[] = $form_field['class'];
		}		
		if(isset($form_field['readonly']) && $form_field['readonly'] == "true" ) {
			$readonly = "readonly";
		}	
		if(count($input_class)) {
			$input_class = implode(" ",$input_class);
			$class = "class='".$input_class."'";
		} else {
			$class = "";
		}
		$field_html .= '<div class="wpdevart-fild-item-container">
							<label for="wpdevart_'.$form_field['name'].'" '.$class.'>'.esc_html($form_field['label']).$required. '</label>';
		$field_html .= '<div class="wpdevart-elem-container div-for-clear" id="wpdevart_wrap_'.$form_field['name'].'">
				  <input type="text" id="wpdevart_'.$form_field['name'].'" name="wpdevart_'.$type."_".$form_field['name'].'" '.$class.' ' .$readonly. '>
			    </div>
		     </div>';
		return $field_html;
	}
	
	private static function form_field_textarea($form_field,$type){
		$input_class = '';
		$field_html = '';
		$field_html .= '<div class="wpdevart-fild-item-container">
							<label for="wpdevart_'.$form_field['name'].'">'.esc_html($form_field['label']).'</label>';
		if(isset($form_field['required'])) {
			$field_html .= '<span class="wpdevart-required">*</span>';
			$input_class = 'class="wpdevart-required"';
		}		
		$field_html .= '<div class="wpdevart-elem-container div-for-clear" id="wpdevart_wrap_'.$form_field['name'].'">
				  <textarea id="wpdevart_'.$form_field['name'].'" name="wpdevart_'.$type."_".$form_field['name'].'" '.$input_class.'></textarea>
			    </div>
		     </div>';
		return $field_html;
	}
	
	private static function form_field_select($form_field,$type){
		$select_options = explode(PHP_EOL, $form_field['options']);
		$input_class = '';
		$field_html = '';
		if(count($select_options)){
			$field_html .= '<div class="wpdevart-fild-item-container">
								<label for="wpdevart_'.$form_field['name'].'">'.esc_html($form_field['label']).'</label>';
			if(isset($form_field['required'])) {
				$field_html .= '<span class="wpdevart-required">*</span>';
				$input_class = 'wpdevart-required ';
			}	
			if(isset($form_field['class']) && $form_field['class'] != "" ) {
				$input_class .= $form_field['class'];
			}			
			$field_html .= '<div class="wpdevart-elem-container div-for-clear" id="wpdevart_wrap_'.$form_field['name'].'"><select id="wpdevart_'.$form_field['name'].'" name="wpdevart_'.$type."_".$form_field['name'].'"';
			if(isset($form_field['multi'])) {
				$field_html .= 'multiple="multiple"';
			}
			if(isset($form_field['onchange'])) {
				$field_html .= 'onchange="'.$form_field['onchange'].'"';
			}
			$field_html .= ' class="'.$input_class.'">';
			foreach($select_options as $select_option) {
				if(trim($select_option) != '') {
					$field_html .= '<option value="'.esc_html($select_option).'">'.esc_html($select_option).'</option>';
				}
			}		  
			$field_html .= '</select>
					</div>
				 </div>';
		}
		else {
			$field_html .= 'No options';
		}		
		return $field_html;
	}
	
	private static function form_field_countries($form_field,$type){
		$select_options = wpdevart_bc_Library::get_countries();
		$input_class = '';
		$field_html = '';
		$field_html .= '<div class="wpdevart-fild-item-container">
							<label for="wpdevart_'.$form_field['name'].'">'.esc_html($form_field['label']).'</label>';
		if(isset($form_field['required'])) {
			$field_html .= '<span class="wpdevart-required">*</span>';
			$input_class = 'wpdevart-required ';
		}	
		if(isset($form_field['class']) && $form_field['class'] != "" ) {
			$input_class .= $form_field['class'];
		}			
		$field_html .= '<div class="wpdevart-elem-container div-for-clear" id="wpdevart_wrap_'.$form_field['name'].'"><select id="wpdevart_'.$form_field['name'].'" name="wpdevart_'.$type."_".$form_field['name'].'"';
		$field_html .= ' class="'.$input_class.'">';
		foreach($select_options as $code => $select_option) {
			$field_html .= '<option value="'.esc_html($code).'">'.esc_html($select_option).'</option>';
		}		  
		$field_html .= '</select>
				</div>
			 </div>';		
		return $field_html;
	}
	
	private static function form_field_recapthcha($form_field,$type){
		$select_options = wpdevart_bc_Library::get_countries();
		$input_class = '';
		$field_html = '';
		$field_html .= '<div class="wpdevart-fild-item-container">
							<label for="wpdevart_'.$form_field['name'].'">'.esc_html($form_field['label']).'</label>';
		if(isset($form_field['required'])) {
			$field_html .= '<span class="wpdevart-required">*</span>';
			$input_class = 'wpdevart-required ';
		}	
		if(isset($form_field['class']) && $form_field['class'] != "" ) {
			$input_class .= $form_field['class'];
		}			
		$field_html .= '<div class="wpdevart-elem-container div-for-clear" id="wpdevart_wrap_'.$form_field['name'].'"><select id="wpdevart_'.$form_field['name'].'" name="wpdevart_'.$type."_".$form_field['name'].'"';
		$field_html .= ' class="'.$input_class.'">';
		foreach($select_options as $code => $select_option) {
			$field_html .= '<option value="'.esc_html($code).'">'.esc_html($select_option).'</option>';
		}		  
		$field_html .= '</select>
				</div>
			 </div>';		
		return $field_html;
	}
		
	private function get_date_diff($date1, $date2) {
		$start = strtotime($date1);
		$end = strtotime($date2);
		$datediff = $end - $start;
		return round($datediff/(60*60*24));
	}
	
	private function text_for_tr() {
		$for_tr = array(
			"for_available" => "available",
			"for_booked" => "Booked",
			"for_unavailable" => "Unavailable",
			"for_check_in" => "Check in",
			"for_check_out" => "Check out",
			"for_night_count" => "Number of nights",
			"for_date" => "Date",
			"for_no_hour" => "No hour available.",
			"for_start_hour" => "Start hour",
			"for_end_hour" => "End hour",
			"for_hour" => "Hour",
			"for_item_count" => "Item count",
			"for_termscond" => "I accept to agree to the Terms & Conditions.",
			"for_reservation" => "Reservation",
			"for_select_days" => "Please select the days from calendar.",
			"for_price" => "Price",
			"for_total" => "Total",
			"for_submit_button" => "Book Now",
			"for_request_successfully_sent" => "Your request has been successfully sent. Please wait for approval.",
			"for_request_successfully_received" => "Your request has been successfully received. We are waiting you!",
			"for_error_single" => "There are no services available for this day.",
			"for_night" => "You must select at least two days",
			"for_min" => "You must select at least [min] days",
			"for_max" => "You must select  more than [max] days",
			"for_min_hour" => "You must select at least [min] hour",
			"for_max_hour" => "You must select  more than [max] hour",
			"for_capcha" => "Was not verified by recaptcha",
			"for_error_multi" => "There are no services available for the period you selected.",
			"for_notify_admin_on_book" => "Email on book to administrator doesn't send",
			"for_notify_admin_on_approved" => "Email on approved to administrator doesn't send",
			"for_notify_user_on_book" => "Email on book to user doesn't send",
			"for_notify_user_on_approved" => "Email on approved to user doesn't send",
			"for_notify_user_canceled" => "Email on canceled to user doesn't send",
			"for_notify_user_deleted" => "Email on delete to user doesn't send",
			"for_pay_in_cash" => "Pay in cash",
			"for_paypal" => "Pay with PayPal",
			"for_shipping_info" => "Same as billing info"
		);
		
		foreach($for_tr as $key => $for) {
			if(isset($this->theme_option['use_mo']) && $this->theme_option['use_mo'] == "on") {
				$for_trarray[$key] = __($for,'booking-calendar');
			} elseif(isset($this->theme_option[$key])){
				$for_trarray[$key] = wpdevart_bc_Library::translated_text($this->theme_option[$key]);
			} else {
				$for_trarray[$key] = __($for,'booking-calendar');
			}
		}
		
		return $for_trarray;
	}

}
