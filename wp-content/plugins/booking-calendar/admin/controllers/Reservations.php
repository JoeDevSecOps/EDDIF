<?php
class wpdevart_bc_ControllerReservations {
	private $model;	
	private $view;	
	  
	public function __construct() {
		require_once(WPDEVART_PLUGIN_DIR . "/admin/models/Reservations.php");
		$this->model = new wpdevart_bc_ModelReservations();
		require_once(WPDEVART_PLUGIN_DIR . "/admin/views/Reservations.php");
		$this->view = new wpdevart_bc_ViewReservations($this->model);
	}  	
	  
	public function perform() {
		$task = wpdevart_bc_Library::get_value('task');
		$id = wpdevart_bc_Library::get_value('id', 0);
		$action = wpdevart_bc_Library::get_value('action');
		if (method_exists($this, $task)) {
		  $this->$task($id);
		}
		else {
		  $this->display_reservations();
		}
	}
	
	private function display_reservations($id=0,$send_mail = array()){
		$this->view->display_reservations($id,$send_mail);
	}  
	
	private function display_month_reservations(){
		$this->view->display_month_reservations();
	}
  	
	private function edit( $id ){
		$this->view->edit( $id );
	}
	
	private function delete( $id ){
		global $wpdb; 
		$send_mail = array();
		$res_status = $this->model->get_reservation_row( $id );
		$delete_res = $wpdb->query($wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'wpdevart_reservations WHERE id="%d"',$id ));
		if($delete_res) {
			if($res_status["status"] == "approved") {
				$this->change_date_avail_count( $id, false, $res_status );
			}
			if($res_status["status"] != 'rejected'){
				$send_mail = $this->send_mail($id,"deleted", $res_status);
			}
		}
		$this->display_reservations(0,$send_mail);
	}
	
	private function add() {
		$this->view->add();
	}
	
	private function save($id){
		$calendar_id = wpdevart_bc_Library::get_value("calendar_id", 0);
		if(isset($_POST["wpdevart-submit".$id])){
			$booking_obg = new wpdevart_bc_calendar();
			$result = $booking_obg->wpdevart_booking_calendar($calendar_id);
			echo $result;
		}
		$this->display_reservations();
	}

	private function delete_selected(){
		global $wpdb; 
		$send_mail = array();
		$check_for_action = (isset($_POST['check_for_action']) ? ( $_POST['check_for_action']) : '');
		foreach($check_for_action as $check){
			$res_status = $this->model->get_reservation_row( $check );
			$delete_res = $wpdb->query($wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'wpdevart_reservations WHERE id="%d"',$check ));
			if($delete_res) {
				if($res_status["status"] == "approved") {
					$this->change_date_avail_count( $check, false, $res_status );
				}
				if($res_status["status"] != 'rejected'){
					$send_mail = $this->send_mail($check,"deleted", $res_status);
				}
			}
		}
		$this->display_reservations(0,$send_mail);
	}
	
	private function approve_selected(){
		global $wpdb; 
		$send_mail = array();
		$check_for_action = (isset($_POST['check_for_action']) ? ( $_POST['check_for_action']) : '');
		foreach($check_for_action as $check){
			$update_res = $wpdb->update($wpdb->prefix . 'wpdevart_reservations',
				array('status' => "approved",
					  'is_new' => 0	),
				array('id' => $check),
				array('%s')
			);
			if($update_res) {
				$this->change_date_avail_count( $check, true );
				$send_mail = $this->send_mail($check,"approved");
			}
		}

		$this->display_reservations(0,$send_mail);
	}
	
	private function canceled_selected(){
		global $wpdb; 
		$send_mail = array();
		$check_for_action = (isset($_POST['check_for_action']) ? ( $_POST['check_for_action']) : '');
		foreach($check_for_action as $check){
			$res_status = $this->model->get_reservation_row( $check );
			$update_res = $wpdb->update($wpdb->prefix . 'wpdevart_reservations',
				array('status' => "canceled",
					  'is_new' => 0),
				array('id' => $check),
				array('%s')
			);
			if($update_res) {
				if($res_status["status"] == "approved") {
					$this->change_date_avail_count( $check, false );
				}
				$send_mail = $this->send_mail($check,"canceled");
			}
		}
		$this->display_reservations(0,$send_mail);
	}
	
	private function reject_selected(){
		global $wpdb; 
		$send_mail = array();
		$check_for_action = (isset($_POST['check_for_action']) ? ( $_POST['check_for_action']) : '');
		foreach($check_for_action as $check){
			$res_status = $this->model->get_reservation_row( $check );
			$update_res = $wpdb->update($wpdb->prefix . 'wpdevart_reservations',
				array('status' => "rejected",
					  'is_new' => 0),
				array('id' => $check),
				array('%s')
			);
			if($update_res) {
				if($res_status["status"] == "approved") {
					$this->change_date_avail_count( $check, false );
				}
				$send_mail = $this->send_mail($check,"rejected");
			}
		}
		$this->display_reservations(0,$send_mail);
	}
	
	
	private function approve( $id ){
		global $wpdb; 
		$send_mail = array();
		$update_res = $wpdb->update($wpdb->prefix . 'wpdevart_reservations',
            array('status' => "approved",
				  'is_new' => 0),
            array('id' => $id),
            array('%s')
        );
		if($update_res) {
			$this->change_date_avail_count( $id, true );
			$send_mail = $this->send_mail($id,"approved");
		}
		
		$this->display_reservations(0,$send_mail);
	}
	
	private function canceled( $id ){
		global $wpdb; 
		$send_mail = array();  
		$res_status = $this->model->get_reservation_row( $id );
		$update_res = $wpdb->update($wpdb->prefix . 'wpdevart_reservations',
            array('status' => "canceled",
				  'is_new' => 0),
            array('id' => $id),
            array('%s')
        );
		if($update_res) {
			if($res_status["status"] == "approved") {
				$this->change_date_avail_count( $id, false );
			}
			$send_mail = $this->send_mail($id,"canceled");
		}
		$this->display_reservations(0,$send_mail);
	}
	private function reject( $id ){
		global $wpdb;
		$send_mail =  array();		
		$res_status = $this->model->get_reservation_row( $id );
		$update_res = $wpdb->update($wpdb->prefix . 'wpdevart_reservations',
            array('status' => "rejected",
				  'is_new' => 0),
            array('id' => $id),
            array('%s')
        );
		if($update_res) {
			if($res_status["status"] == "approved") {
				$this->change_date_avail_count( $id, false );
			}
			$send_mail = $this->send_mail($id,"rejected");
		}
		$this->display_reservations(0,$send_mail);
	}
	private function mark_read( $id ){
		global $wpdb;
		$update_res = $wpdb->update($wpdb->prefix . 'wpdevart_reservations',
            array('is_new' => 0),
            array('id' => $id),
            array('%s')
        );
		$this->display_reservations(0,array());
	}
	private function mark_read_selected( $id ){
		global $wpdb;
		if(isset($_POST['check_for_action'])){
			$check_for_action = (isset($_POST['check_for_action']) ? ( $_POST['check_for_action']) : '');
			$check_ids = implode(",",$check_for_action);
			$update_res = $wpdb->query('UPDATE '.$wpdb->prefix . 'wpdevart_reservations SET is_new=0 WHERE id IN ('.$check_ids.')');
		}
		$this->display_reservations(0,array());
	}
	public function export_as_csv(){
		global $wpdb;
		$calendar_id = wpdevart_bc_Library::get_value("calendar_id", 0);
		$reservations = $this->model->get_reservations_for_export();
		
		$form_id = $wpdb->get_var($wpdb->prepare('SELECT form_id FROM ' . $wpdb->prefix . 'wpdevart_calendars WHERE id="%d"', $calendar_id));
		$form_info = $wpdb->get_var($wpdb->prepare('SELECT data FROM ' . $wpdb->prefix . 'wpdevart_forms WHERE id="%d"', $form_id));
		$extra_id = $wpdb->get_var($wpdb->prepare('SELECT extra_id FROM ' . $wpdb->prefix . 'wpdevart_calendars WHERE id="%d"', $calendar_id));
		$extra_info = $wpdb->get_var($wpdb->prepare('SELECT data FROM ' . $wpdb->prefix . 'wpdevart_extras WHERE id="%d"', $extra_id));
		$theme_value = $this->model->get_theme_rows();
        $currency = (is_array($theme_value) && isset($theme_value['currency'])) ? $theme_value['currency'] : 'USD';
		$currency = wpdevart_bc_get_currency($currency);

		if ( !empty($reservations)) {
			$title = $this->model->get_calendar_title();
			$reservations = $this->model->get_form_data_new($reservations,$form_info);
			$reservations = $this->model->get_extra_data_new($reservations,$extra_info,$currency);
			
			$form_lables = $this->model->get_labels($form_info);
			$extra_lables = $this->model->get_labels($extra_info);
			$col_names = array_merge(array(
						  "id" => "ID",
						  "calendar_id" => "Calendar ID",
						  "single_day" => "Single Day",
						  "check_in" => "Check In",
						  "check_out" => "Check Out",
						  "start_hour" => "Start Hour",
						  "end_hour" => "End Hour",
						  "count_item" => "Count Item",
						  "price" => "Price",
						  "total_price" => "Total Price",
						  "extras_price" =>  "Extras Price",
						  "status" => "Status",
						  "payment_method" => "Payment Method",
						  "payment_status" => "Payment Status",
						  "date_created" => "Created Date"
						),$form_lables,$extra_lables);

			$upload_direct = wp_upload_dir();
			$booking_path = $upload_direct['basedir'] . '/booking_calendar';
			if ( !is_dir($booking_path) ) {
				mkdir($booking_path, 0777);
			}
			$temp = $booking_path . '/' . $title . '.txt';
			if ( file_exists($temp) ) {
				unlink($temp);
			}
			$output = fopen($temp, "a");

			foreach ($col_names as $i => $name) {
				$col_names[$i] = ltrim($name, '=+-@');
			}
			fputcsv($output, $col_names, ",");

			foreach ( $reservations as $index => $record ) {
				foreach ( $record as $i => $rec ) {
					$record[$i] = ltrim($rec, '=+-@');
				}
				fputcsv($output, $record, ",");
			}
			
			fclose($output); 
			$txtfile = fopen($temp, "r");
			$txtfilecontent = fread($txtfile, filesize($temp));
			fclose($txtfile);
			$filename = $title . "_" . date('Ymd') . ".csv";
			header('Content-Encoding: UTF-8');
			header('content-type: application/csv; charset=UTF-8');
			header("Content-Disposition: attachment; filename=\"$filename\"");
			echo "\xEF\xBB\xBF";
			echo $txtfilecontent;
			unlink($temp);
		
		}
	}
	
	public function change_date_avail_count( $id,$approve,$reserv_info_del="" ){
		global $wpdb;
		$theme_rows = $this->model->get_theme_rows();
		if($reserv_info_del == "") {
			$reserv_info = $this->model->get_reservation_row($id);
		} else {
			$reserv_info = $reserv_info_del;
		}		
		$cal_id = $reserv_info["calendar_id"]; 
		if(isset($reserv_info["count_item"])) {
			$count_item = $reserv_info["count_item"];
		} else {
			$count_item = 1;
		}
		if($reserv_info["single_day"] == "") {
			$start_date = $reserv_info["check_in"];
			$date_diff = abs($this->get_date_diff($reserv_info["check_in"],$reserv_info["check_out"]));
			for($i=0; $i <= $date_diff; $i++) {
				if(isset($theme_rows["price_for_night"]) && $theme_rows["price_for_night"] == "on"  && $i == $date_diff){
					continue;
				}
				$day = date( 'Y-m-d', strtotime($start_date. " +" . $i . " day" ));
				$unique_id = $cal_id."_".$day;
				$day_data = json_decode($this->model->get_date_data( $unique_id ),true);
				if($approve === true) {
					$day_data["available"] = $day_data["available"] - $count_item;
					if($day_data["available"] == 0) {
						$day_data["status"] = "booked";
					}
				} else {
					$day_data["available"] = $day_data["available"] + $count_item;
					$day_data["status"] = "available";
				}
				$day_info_jsone = json_encode($day_data);
				$update_in_db = $wpdb->update($wpdb->prefix . 'wpdevart_dates', array(
					'calendar_id' => $cal_id,
					'day' => $day,
					'data' => $day_info_jsone,
				  ), array('unique_id' => $unique_id));
				
			}
		} else {
			$unique_id = $cal_id."_".$reserv_info["single_day"];
			$day_data = json_decode($this->model->get_date_data( $unique_id ),true);
			if($approve === true) {
				if($reserv_info["end_hour"] == "" && $reserv_info["start_hour"] == "") {
					$day_data["available"] = $day_data["available"] - $count_item;
				} else {
					if(isset($day_data["hours"])){
						if($reserv_info["end_hour"] == "") {
							$day_data["hours"][$reserv_info["start_hour"]]["available"] =  $day_data["hours"][$reserv_info["start_hour"]]["available"] - $count_item;
							if($day_data["hours"][$reserv_info["start_hour"]]["available"] == 0) {
								$day_data["hours"][$reserv_info["start_hour"]]["status"] = "booked";
							}
							$count = 1;	
						} else {
							/*multihour here*/
							if(count($day_data["hours"])) {
								$start = 0;
								$count = 0;							
								foreach($day_data["hours"] as $key => $hour) {
									if($key == $reserv_info["start_hour"]) {
										$start = 1;
									} 
									if($start == 1) {
										$day_data["hours"][$key]["available"] =  $day_data["hours"][$key]["available"] - $count_item;
										$count += 1;
									}
									if($key == $reserv_info["end_hour"]) {
										$start = 0;
									}
									if($day_data["hours"][$key]["available"] == 0) {
										$day_data["hours"][$key]["status"] = "booked";
									}
								}
							}
						}
						$day_data["available"] = $day_data["available"] - ($count_item*$count);
					}
					
				}
				if($day_data["available"] == 0) {
					$day_data["status"] = "booked";
				}
			} else {
				if($reserv_info["end_hour"] == "" && $reserv_info["start_hour"] == "") {
					$day_data["available"] = $day_data["available"] + $count_item;
				} else {
					if($reserv_info["end_hour"] == "") {
						$day_data["hours"][$reserv_info["start_hour"]]["available"] =  $day_data["hours"][$reserv_info["start_hour"]]["available"] + $count_item;
						$day_data["hours"][$reserv_info["start_hour"]]["status"] = "available";
						$count = 1;	
					} else {
						/*multihour here*/
						if(count($day_data["hours"])) {
							$start = 0; 
							$count = 0;	
							foreach($day_data["hours"] as $key => $hour) {
								if($key == $reserv_info["start_hour"]) {
									$start = 1;
								}
								if($start == 1) {
									$day_data["hours"][$key]["available"] =  $day_data["hours"][$key]["available"] + $count_item;
									$count += 1;if($day_data["hours"][$key]["available"] != 0) {
										$day_data["hours"][$key]["status"] = "available";
									}
								}
								if($key == $reserv_info["end_hour"]) {
									$start = 0;
								}
								
							}
						}
					}
					$day_data["available"] = $day_data["available"] + ($count_item * $count);
				}
				$day_data["status"] = "available";
			}
			$day_info_jsone = json_encode($day_data);
			$update_in_db = $wpdb->update($wpdb->prefix . 'wpdevart_dates', array(
				'calendar_id' => $cal_id,
				'day' => $reserv_info["single_day"],
				'data' => $day_info_jsone,
			  ), array('unique_id' => $unique_id));
		}
	}
	
	private function send_mail($res_id, $type, $reserv_info_del=""){
		if($reserv_info_del == "") {
			$data = $this->model->get_reservation_row( $res_id );
		} else {
			$data = $reserv_info_del;
		}
		$theme_rows = $this->model->get_theme_rows($data["calendar_id"]);
		$lib = new wpdevart_bc_Library();
		return $lib->send_mail( $data, 'reservation', $theme_rows, $type );
	}

 
  	private function get_date_diff($date1, $date2) {
		$start = strtotime($date1);
		$end = strtotime($date2);
		$datediff = $start - $end;
		return floor($datediff/(60*60*24));
	}

}

?>