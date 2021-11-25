<?php 
/*
*	Class for payments
*/

class WpdevartPayments{
	
	private $options;
	private $res;
	private $resId;
	private $bookingId;
	private $calendarId;
	private $name;
	
	public function __construct($options,$bookingId,$calendarId,$res,$name){
		$this->options = $options;
		$this->res = $res;
		$this->resId = $res["id"];
		$this->bookingId = $bookingId;
		$this->calendarId = $calendarId;
		$this->name = ($name == "") ? "Booking" : $name;
		$payment_method = (isset($_POST["payment_type_".$this->bookingId])) ? $_POST["payment_type_".$this->bookingId] : 'paypal';
		
		if ($payment_method == 'paypal'){
			$this->expresspaypal();
		}
		
	}

    /*############  Expresspaypal function ################*/	
	
	public function expresspaypal(){
        $http = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") ? "https://" : "http://";		
		$sandbox = (isset($this->options["payment_mode"]) && $this->options["payment_mode"] == 'live') ? "live" : "sandbox";
		$_username = (isset($this->options["paypal_username"])) ? $this->options["paypal_username"] : "";
		$_email = (isset($this->options["paypal_email"])) ? $this->options["paypal_email"] : "";
		$_password = (isset($this->options["paypal_password"])) ? $this->options["paypal_password"] : "";
		$_signature = (isset($this->options["paypal_signature"])) ? $this->options["paypal_signature"] : "";
		/*$url_cancel = (isset($this->options["redirect_url_failed"])) ? $this->options["redirect_url_failed"] : "";*/
		$url_return = (isset($this->options["redirect_url_successful"])) ? $this->options["redirect_url_successful"] : "";
		$currency = (isset($this->options['currency']))? $this->options['currency'] : "";
		
		
		$total_price = (isset($this->res["total_price"]))? $this->res["total_price"] : 0;
		$tax = (isset($this->options["tax"]))? $this->options["tax"] : 0;
		
		$user = (is_user_logged_in()) ? get_current_user_id() : 0;
		$url_paypal = ($sandbox == "sandbox") ? 'https://www.sandbox.paypal.com/webscr?' : 'https://www.paypal.com/cgi-bin/webscr?';
		
		$params = array();
		$params["cmd"] = "_cart";
		$params["business"] = $_email;
        $params["upload"] = "1";
        $params["charset"] = "UTF-8";
        $params["currency_code"] = $currency;
		$params["item_name_1"] = $this->name;
		$params["amount_1"] = $total_price;
		$params["tax_rate_1"] = $tax;
		$params["quantity_1"] = 1;
        $params["notify_url"] = add_query_arg(array("action" => "wpdevart_payment", "task" => "paypal_notify","cal_id"=>$this->calendarId,"res_id"=>$this->resId,"theme_id"=>$this->options["id"], "user_id"=> $user , "payment_method" => "paypal_standart"), admin_url('admin-ajax.php'));
        $params["return"] = ($url_return != "" ? $url_return : site_url());
        $params["cancel_url"] = add_query_arg(array("action" => "wpdevart_payment", "task" => "paypal_cancel", 'cal_id'=>$this->calendarId, 'res_id'=>$this->resId, "theme_id"=>$this->options["id"]), admin_url('admin-ajax.php'));
        $str_request = http_build_query($params);
		
        wpdevart_bc_Library::wpdevart_redirect( $url_paypal . $str_request );	
	
		
	}
	
	
}
