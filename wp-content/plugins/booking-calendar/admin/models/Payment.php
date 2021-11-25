<?php
class wpdevart_bc_ModelPayments {
	
  public function get_payment( $res_id ) {
    global $wpdb;
    $row = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'wpdevart_payments WHERE 	res_id="%d"', $res_id),ARRAY_A);
   
    return $row;
  }	
  public function get_reservation_row( $id ) {
    global $wpdb;
    $row = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'wpdevart_reservations WHERE id="%d"', $id),ARRAY_A);
   
    return $row;
  }
 
    /*############  Settings row function ################*/
	
  public function get_setting_rows( $id ) {
    global $wpdb;
	$row = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'wpdevart_themes WHERE id="%d"', $id));
    if($row) {
		$theme_option = json_decode($row->value, true);	
	} else {
		$theme_option = array();
	}
    return $theme_option;
  } 
 
    /*############  Form data function ################*/
	
	public function get_form_data($form,$cal_id) {
		global $wpdb;
		if($form) {
			$form_value = json_decode($form, true);
			$form_id = $wpdb->get_var($wpdb->prepare('SELECT form_id FROM ' . $wpdb->prefix . 'wpdevart_calendars WHERE id="%d"', $cal_id));
			$form_info = $wpdb->get_var($wpdb->prepare('SELECT data FROM ' . $wpdb->prefix . 'wpdevart_forms WHERE id="%d"', $form_id));
			$form_info = json_decode($form_info, true);
			if(isset($form_info['apply']) || isset($form_info['save']))	{
				array_shift($form_info);
			}
			foreach($form_info as $key=>$form_fild_info) { 
				if(isset($form_value["wpdevart_".$key])) {
					$form_info[$key]["value"] = $form_value["wpdevart_".$key];
				}
				else {
					$form_info[$key]["value"] = "";
				}
			}
		} else {
			$form_info = array();
		}
		return $form_info;
	} 
	
	public function get_extra_data($extra,$price,$cal_id) {
		global $wpdb;
		if($price !== false) {
			$price = $price;
			$extra = $extra;
		} else  {
			$price = $extra["price"];
			$extra = $extra["extras"];
		}
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
	
	public function get_calendar_title($cal_id) {
		global $wpdb;
		$row = $wpdb->get_var($wpdb->prepare('SELECT title FROM ' . $wpdb->prefix . 'wpdevart_calendars WHERE id="%d"', $cal_id));
	   
		return $row;
	  }
  
}

?>