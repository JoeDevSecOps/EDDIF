<?php
class wpdevart_bc_ControllerPayments {
	private $model;	
	private $theme_option;	
	private $res_edit;
	  
	public function __construct() {
		require_once(WPDEVART_PLUGIN_DIR . "/admin/models/Payment.php");
		$this->model = new wpdevart_bc_ModelPayments();
		$theme_id = isset($_GET['theme_id']) ? esc_html(stripslashes($_GET['theme_id'])) : 0;
		$this->theme_option = $this->model->get_setting_rows($theme_id);
		require_once(WPDEVART_PLUGIN_DIR . "/admin/controllers/Reservations.php");
		$this->res_edit = new wpdevart_bc_ControllerReservations();
	}  	
	  
	public function perform() {
		$task = wpdevart_bc_Library::get_value('task');
		$id = wpdevart_bc_Library::get_value('id', 0);
		if (method_exists($this, $task)) {
		  $this->$task();
		}
		else {
		  $this->paypal_notify();
		}
	}
	
	private function paypal_notify(){
		global $wpdb;
		$sandbox = (isset($this->theme_option["payment_mode"]) && $this->theme_option["payment_mode"] == 'live') ? "live" : "sandbox";
		$res_id = isset($_GET['res_id']) ? (int)stripslashes($_GET['res_id']) : 0;
		$cal_id = isset($_GET['cal_id']) ? (int)stripslashes($_GET['cal_id']) : 0;
		
		$url_paypal = ($sandbox == "sandbox") ? 'https://www.sandbox.paypal.com/webscr?' : 'https://www.paypal.com/cgi-bin/webscr?';
		
		$ipnData = array();
        foreach ($_POST as $key => $value) {
          $ipnData[$key] = $value;
        }
        $requestData = array('cmd' => '_notify-validate') + $ipnData;
        $request = http_build_query($requestData);

        $curl = curl_init();
        curl_setopt_array($curl, array(
		  CURLOPT_URL => $url_paypal,
		  CURLOPT_HEADER => 0,
		  CURLOPT_POST => 1,
		  CURLOPT_POSTFIELDS => $request,
		  CURLOPT_SSL_VERIFYPEER => true,
		  CURLOPT_SSLVERSION => 1,
		  CURLOPT_RETURNTRANSFER => 1));
		  
        $response = curl_exec($curl);
		if(!$response){
			$response = "";
		}
        curl_close($curl);
		$date = date('Y-m-d H:i:s');		
		$ip = $_SERVER['REMOTE_ADDR'];
		$total = isset($_POST['mc_gross']) ? esc_html($_POST['mc_gross']) : "";
		$tax_value = isset($_POST['tax']) ? esc_html($_POST['tax']) : "";
		$payment_status = isset($_POST['payment_status']) ? esc_html($_POST['payment_status']) : "";

		$payment_address = isset($_POST['address_country']) ? "Country: " . esc_html($_POST['address_country']) . "<br>" : "";
		$payment_address .= isset($_POST['address_state']) ? "State: " . esc_html($_POST['address_state']) . "<br>" : '';
		$payment_address .= isset($_POST['address_city']) ? "City: " . esc_html($_POST['address_city']) . "<br>" : '';
		$payment_address .= isset($_POST['address_street']) ? "Street: " . esc_html($_POST['address_street']) . "<br>" : '';
		$payment_address .= isset($_POST['address_zip']) ? "Zip Code: " . esc_html($_POST['address_zip']) . "<br>" : '';
		$payment_address .= isset($_POST['address_status']) ? "Address Status: " . esc_html($_POST['address_status']) . "<br>" : '';
		$payment_address .= isset($_POST['address_name']) ? "Name: " . esc_html($_POST['address_name']) . "<br>" : '';
		$paypal_info = "";
		$paypal_info .= isset($_POST['payer_status']) ? "Payer Status - " . esc_html($_POST['payer_status']) . "<br>" : '';
		$paypal_info .= isset($_POST['payer_email']) ? "Payer Email - " . esc_html($_POST['payer_email']) . "<br>" : '';
		$paypal_info .= isset($_POST['first_name']) ? "Payer Name - " . esc_html($_POST['first_name']) : '';
		$paypal_info .= isset($_POST['last_name']) ? " " . esc_html($_POST['last_name']) . "<br>" : '';
		$paypal_info .= isset($_POST['txn_id']) ? "Transaction - " . esc_html($_POST['txn_id']) . "<br>" : '';
		$paypal_info .= isset($_POST['payment_type']) ? "Payment Type - " . esc_html($_POST['payment_type']) . "<br>" : '';
		$id = $wpdb->get_var($wpdb->prepare('SELECT pay_id FROM ' . $wpdb->prefix . 'wpdevart_payments WHERE res_id="%d"', $res_id));
		
		if(!is_null($id) && $id){
		  $save_db = $wpdb->update($wpdb->prefix . 'wpdevart_payments', array(
			'payment_price' => $total,
			'tax' => $tax_value,
			'pay_status' => $payment_status,
			'ip' => $ip,
			'ipn' => $response,
			'payment_address' => $payment_address,
			'payment_info' => $paypal_info,
			'modified_date' => $date      
		  ), array('res_id' => $res_id));
		} else {
		  $save_db = $wpdb->insert($wpdb->prefix . 'wpdevart_payments', array(
			'res_id' => $res_id,
			'payment_price' => $total,
			'tax' => $tax_value,
			'pay_status' => $payment_status,
			'ip' => $ip,
			'ipn' => $response,
			'payment_address' => $payment_address,
			'payment_info' => $paypal_info,
			'modified_date' => $date      
		  ), array(
			'%d',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s'
		  ));
		} 
		  
		if($save_db)  {
			if($payment_status == "Completed" || $payment_status == 'Pending'){
				$this->send_mail($res_id,'payment',  "completed");
				if(isset($this->theme_option['enable_psuccess_approval']) && $this->theme_option['enable_psuccess_approval'] == "on") {
					$change_status = $wpdb->update($wpdb->prefix . 'wpdevart_reservations', array('status' => "approved"), array('id' => $res_id));
					$this->res_edit->change_date_avail_count( $res_id,true);
					$this->send_mail($res_id, 'reservation', "approved");
					
				}
			}
			else if($payment_status == 'Failed' || $payment_status == 'Denied' || $payment_status == 'Expired' || $payment_status == 'Voided' || $payment_status == 'Refunded' || $payment_status == 'Processed'){
				$this->send_mail($res_id,'payment',  "failed");
			}
		}
	}
	private function paypal_cancel(){
        global $wpdb;
		$res_id = isset($_GET['res_id']) ? (int)stripslashes($_GET['res_id']) : 0;
		  $save_db = $wpdb->insert($wpdb->prefix . 'wpdevart_payments', array(
		    'res_id' => $res_id,
			'pay_status' => "cancelled"  
		  ), array(
			'%d',
			'%s'
		  ));
	}
	
	private function send_mail($res_id, $from, $type){
		$data = $this->model->get_reservation_row($res_id);
		$lib = new wpdevart_bc_Library();
		return $lib->send_mail( $data, $from, $this->theme_option, $type );
		
	}	
}

?>