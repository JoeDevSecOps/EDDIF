<?php
class wpdevart_bc_ModelThemes {
  private $user_id = 1;	
  private $user_role = "";	
  private $permission = false;	
	
  public function __construct() {
	$current_user = get_current_user_id();
	$current_user_info = get_userdata( $current_user ); 
	if($current_user_info){
		$current_user_info = $current_user_info->roles; 
	}
	$role = isset($current_user_info[0]) ? $current_user_info[0] : "";
	$this->user_id = $current_user;
	$this->user_role = $role;
	$this->permission = wpdevart_bc_Library::page_access('theme_page');
  }
  
  public function get_themes_rows() {
    global $wpdb;
	
    $limit = (isset($_POST['wpdevart_page']) && $_POST['wpdevart_page'])? (((int) $_POST['wpdevart_page'] - 1) * 20) : 0;
    $order_by = ((isset($_POST['order_by']) && $_POST['order_by'] != "") ? sanitize_sql_orderby($_POST['order_by']) :  'id');
	$order = ((isset($_POST['asc_desc']) && $_POST['asc_desc'] == 'asc') ? 'asc' : 'desc');
    $order_by = ' ORDER BY `' . $order_by . '` ' . $order;
    $where = ((isset($_POST['search_value']) && (sanitize_text_field($_POST['search_value']) != '')) ? 'WHERE title LIKE "%' . sanitize_text_field($_POST['search_value']) . '%"' : '');
if($this->user_role != "administrator" && !$this->permission){
		if($where == "")
			$where = 'WHERE user_id=' . $this->user_id;
		else
			$where .= ' AND user_id=' . $this->user_id;
	}	
    $query = "SELECT * FROM " . $wpdb->prefix . "wpdevart_themes " . $where . " ".$order_by." LIMIT " . $limit . ",20";
    $rows = $wpdb->get_results($query);
   
    return $rows;
  }	
  
  public function get_setting_rows( $id = 1 ) {
    global $wpdb;
	$id = is_null($id) ? 1 : $id;
	$row = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'wpdevart_themes WHERE id="%d"', $id));  
    return $row;
  } 
  
  public function get_form_rows() {
    global $wpdb;
	
	$where = '';
	if($this->user_role != "administrator" && !$this->permission){
		$where = ' WHERE user_id=' . $this->user_id;
	}
	$form_array = array();
    $rows = $wpdb->get_results('SELECT id,title FROM ' . $wpdb->prefix . 'wpdevart_forms ' . $where,ARRAY_A);
    foreach($rows as $row) {
		$form_array[$row['id']] = $row['title'];
	}
    return $form_array;
  } 
  
  public function get_payment_info($id) {
    global $wpdb;
	$address = array();
    $rows = $wpdb->get_var($wpdb->prepare('SELECT value FROM ' . $wpdb->prefix . 'wpdevart_themes WHERE id="%d"', $id));
    $rows = json_decode($rows,true);
	if(isset($rows['enable_billing_address']) && $rows['enable_billing_address'] == "on" && isset($rows['billing_address_form']) && $rows['billing_address_form']){
		$address['billing_info'] = $wpdb->get_row($wpdb->prepare('SELECT title,data FROM ' . $wpdb->prefix . 'wpdevart_forms WHERE id="%d"', $rows['billing_address_form']),ARRAY_A);
	}
	if(isset($rows['enable_shipping_address']) && $rows['enable_shipping_address'] == "on" && isset($rows['shipping_address_form']) && $rows['shipping_address_form']){
		$address['shipping_info'] = $wpdb->get_row($wpdb->prepare('SELECT title,data FROM ' . $wpdb->prefix . 'wpdevart_forms WHERE id="%d"', $rows['shipping_address_form']),ARRAY_A);
	}
    $address['theme_option'] = $rows;
    return $address;
  } 
  
  public function items_nav() {
    global $wpdb;
    $where = ((isset($_POST['search_value']) && (sanitize_text_field($_POST['search_value']) != '')) ? 'WHERE title LIKE "%' . sanitize_text_field($_POST['search_value']) . '%"'  : '');
    	if($this->user_role != "administrator" && !$this->permission){
		if($where == "")
			$where = 'WHERE user_id=' . $this->user_id;
		else
			$where .= ' AND user_id=' . $this->user_id;
	}
    $total = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."wpdevart_themes " .$where);
    $items_nav['total'] = $total;
    if (isset($_POST['wpdevart_page']) && $_POST['wpdevart_page']) {
      $limit = ((int)$_POST['wpdevart_page'] - 1) * 20;
    }
    else {
      $limit = 0;
    }
    $items_nav['limit'] = (int)($limit / 20 + 1);
    return $items_nav;
  }
  
  public function check_exists( $theme_id ) {
    global $wpdb;
	$exists = false;
    $rows = $wpdb->get_results('SELECT theme_id FROM ' . $wpdb->prefix . 'wpdevart_calendars',ARRAY_A);
    foreach($rows as $row) {
		if(in_array($theme_id,$row)){
			$exists = true;
			break;
		}
	}

    return $exists;
  } 
 
  
}

?>