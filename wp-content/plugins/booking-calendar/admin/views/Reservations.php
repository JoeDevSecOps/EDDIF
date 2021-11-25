<?php
class wpdevart_bc_ViewReservations {
	public $model_obj;
    	
    public function __construct( $model ) {
		$this->model_obj = $model;
    }

    /*############  Reservations function ################*/
	
    public function display_reservations($id=0,$send_mails = array()) {
		$class = "";
		$calendar_id = wpdevart_bc_Library::get_value("calendar_id", 0);
		$theme_options = $this->model_obj->get_theme_rows($calendar_id);
		$themes_options = $this->model_obj->get_themes_rows();
		$days_for_new = $themes_options;
		if(isset($theme_options["days_for_new"])){
			$days_for_new = $theme_options["days_for_new"];
		}
		$new_res = $this->model_obj->get_new_res($calendar_id,$days_for_new);
		$countries = wpdevart_bc_Library::get_countries();
		$rows = $this->model_obj->get_reservations_rows($id);
		$calendar_rows = $this->model_obj->get_calendar_rows();
		$items_nav = $this->model_obj->items_nav($id);
		$asc_desc = ((isset($_POST['asc_desc']) && $_POST['asc_desc'] == 'asc') ? 'asc' : 'desc');
		$res_order_by = (isset($_POST['order_by']) ? sanitize_sql_orderby($_POST['order_by']) :  'id');
		$res_order_class = 'sorted ' . $asc_desc;
		$mail_error = array();
		$cur_pos = (isset($theme_options['currency_pos']) && $theme_options['currency_pos'] == "before") ? "before" : "after";
		if(count($send_mails)) {
			foreach($send_mails as $send_mail) {
				foreach($send_mail as $key=>$value) {
					if(isset($theme_options[$key."_error"]) && $theme_options[$key."_error"] == "on" && $value === false) {
						$mail_error[] = (isset($theme_options["for_".$key]) ? $theme_options["for_".$key] : "");
					}
				}		
			}
		}
		
		if((isset($theme_options["pay_in_cash"]) && $theme_options["pay_in_cash"] == "on") || (isset($theme_options["paypal"]) && $theme_options["paypal"] == "on")){
			$class = "with_paymants";
		}
		?>
		<div id="wpdevart_reservations_container" class="wpdevart-list-container list-view <?php echo $class; ?>">
			<form action="admin.php?page=wpdevart-reservations" method="get" id="reservations_form_cal">
				<input type="hidden" name="page" value="wpdevart-reservations">
				<div id="reservation_header" class="div-for-clear">
					<div class="div-for-clear">
						<span class="admin_logo"></span>
						<h1><?php _e('Reservations List View','booking-calendar'); ?> </h1>
					</div>
					<select name="calendar_id" onchange="this.form.submit()">
						<option value='0'><?php _e('Select Calendar','booking-calendar'); ?></option>
						<?php foreach($calendar_rows as $calendar_row) {
							echo "<option value='".$calendar_row["id"]."' ".selected($calendar_id, $calendar_row["id"], false).">".$calendar_row["title"]."</option>";
						} ?>
					</select>
					<span id="view_list"><span class="reservation-item-info"><?php _e('Reservation List View','booking-calendar'); ?></span></span>
					<?php if (WPDEVART_PRO == "free") : ?>
						<span id="view_calendar" class="pro-field"><span class="reservation-item-info"><?php _e('Reservation Month View','booking-calendar'); ?><span class="pro_feature">(Pro Feature!)</span></span></span>
					<?php else : ?>
						<a id="view_calendar" href="<?php echo add_query_arg(array( 'page' => 'wpdevart-reservations', 'calendar_id' => $calendar_id, 'task' => 'display_month_reservations' ), admin_url('admin.php')); ?>"><span class="reservation-item-info"><?php _e('Reservation Month View','booking-calendar'); ?></span></a>
					<?php endif; ?>
					<a id="add_reservation" href="<?php echo add_query_arg(array( 'page' => 'wpdevart-reservations', 'calendar_id' => $calendar_id,'task' => 'add' ), admin_url('admin.php')); ?>" class="add-reservation"><span class="plus">+</span><span class="reservation-item-info"><?php _e('Add Reservation','booking-calendar'); ?></span></a>
				</div>
			</form>
			<form action="admin.php?page=wpdevart-reservations" method="post" id="reservations_form">
				<div id="action-buttons" class="div-for-clear">
				<div id="resrv_action_filters">
					<div class="reserv_actions_filters_tabs div-for-clear">
						<div id="wpdevart_tab_1" class="wpdevart_tab show">
							<span><?php _e('Statistics','booking-calendar'); ?></span>
						</div>
						<div id="wpdevart_tab_2" class="wpdevart_tab">
							<span><?php _e('Actions','booking-calendar'); ?></span>
						</div>
						<div id="wpdevart_tab_3" class="wpdevart_tab">
							<span><?php _e('Filters','booking-calendar'); ?></span>
						</div>
					</div>
					<div class="wpdevart_action_filters_container">
						<div id="wpdevart_tab_1_container" class="wpdevart_container show">
							<?php if(count($new_res)) {
								if($calendar_id == 0){
									echo '<div class="new_reservation_info"><span class="form_info header_info"><span class="form_label">Calendar name</span> <span class="form_value">'.__("New reservations",'booking-calendar').'</span></span>';
									foreach($new_res as $res){
										if(is_array($res))
											echo '<span class="form_info"><span class="form_label">'.$res["title"].'</span> <span class="form_value"><span>'.$res["countRes"].'</span></span></span>';
									}
									echo '</div>';
								} else{
									echo '<div class="new_reservation_info">';
									foreach($new_res as $res){
										if(is_array($res))
											echo '<span class="form_info"><span class="form_label">'.__("New reservations",'booking-calendar').'</span> <span class="form_value"><span>'.$res["countRes"].'</span></span></span>';
									}
									echo '</div>';
								}
							} ?>
						</div>
						<div id="wpdevart_tab_2_container" class="wpdevart_container">
							<a href="" onclick="wpdevart_set_value('task','approve_selected'); wpdevart_form_submit(event, 'reservations_form')" class="action-button approve-button"><?php _e('Approve','booking-calendar'); ?></a>
							<a href="" onclick="wpdevart_set_value('task','reject_selected');wpdevart_form_submit(event, 'reservations_form')" class="action-button reject-button"><?php _e('Reject','booking-calendar'); ?></a>
							<a href="" onclick="wpdevart_set_value('task','canceled_selected');wpdevart_form_submit(event, 'reservations_form')" class="action-button cancel-button"><?php _e('Cancel','booking-calendar'); ?></a>
							<a href="" onclick="wpdevart_set_value('task','delete_selected'); wpdevart_form_submit(event, 'reservations_form')" class="action-button delete-button"><?php _e('Delete','booking-calendar'); ?></a>
							<a href="" onclick="wpdevart_set_value('task','mark_read_selected'); wpdevart_form_submit(event, 'reservations_form')" class="action-button default-button"><?php _e('Mark as read','booking-calendar'); ?></a>
							<a  id="wpdevart_export" class="action-button default-button" style="cursor:pointer"><?php _e('Export as excel','booking-calendar'); ?></a>
							<input type="checkbox" name="all_pages" id="all_pages" value="on"><label for="all_pages" class="label_switch"><?php _e('All Pages','booking-calendar'); ?></label>
							<br>
							<a  id="show_all_details" class="action-button default-button" style="cursor:pointer; margin-top: 8px;"><?php _e('Show all details','booking-calendar'); ?></a>
						</div>
						<div id="wpdevart_tab_3_container" class="wpdevart_container div-for-clear">
						    <div class="filter_item status_filter_item">
								<label class="filter_item_label"><?php _e('Select Status','booking-calendar'); ?></label>
								<div class="filter_fild_item stylesh-checkbox">
									<input type="checkbox" name="reserv_status[]" id="res_approved" value="approved" <?php checked(isset($_POST["reserv_status"]) && in_array("approved",$_POST["reserv_status"])); ?>><label for="res_approved" class="label_switch"><?php _e('Approved','booking-calendar'); ?></label>
								</div>	
								<div class="filter_fild_item stylesh-checkbox">
									<input type="checkbox" name="reserv_status[]" id="res_canceled" value="canceled" <?php checked(isset($_POST["reserv_status"]) && in_array("canceled",$_POST["reserv_status"])); ?>><label for="res_canceled" class="label_switch"><?php _e('Canceled','booking-calendar'); ?></label>
								</div>
								<div class="filter_fild_item stylesh-checkbox">
									<input type="checkbox" name="reserv_status[]" id="res_rejected" value="rejected" <?php checked(isset($_POST["reserv_status"]) && in_array("rejected",$_POST["reserv_status"])); ?>><label for="res_rejected" class="label_switch"><?php _e('Rejected','booking-calendar'); ?></label>
								</div>	
								<div class="filter_fild_item stylesh-checkbox">
									<input type="checkbox" name="reserv_status[]" id="res_pending" value="pending" <?php checked(isset($_POST["reserv_status"]) && in_array("pending",$_POST["reserv_status"])); ?>><label for="res_pending" class="label_switch"><?php _e('Pending','booking-calendar'); ?></label>
								</div>	
							</div>
							<div class="filter_item period_filter_item">
								<label class="filter_item_label"><?php _e('Period','booking-calendar'); ?></label>
								<div class="filter_fild_item">
									<input type="text" name="reserv_period_start" value="<?php echo (isset($_POST["reserv_period_start"])? esc_js($_POST["reserv_period_start"]) : ""); ?>" class="admin_datepicker" placeholder="<?php _e('Check in','booking-calendar'); ?>">
								</div>
								<div class="filter_fild_item">
									<input type="text" name="reserv_period_end" value="<?php echo (isset($_POST["reserv_period_end"])? esc_js($_POST["reserv_period_end"]) : ""); ?>" class="admin_datepicker" placeholder="<?php _e('Check out','booking-calendar'); ?>">
								</div>
							</div>
							<div class="filter_item searchs_filter_item">
								<label class="filter_item_label"><?php _e('Search','booking-calendar'); ?></label>
								<div class="filter_fild_item">
									<input type="text" name="wpdevart_serch" value="<?php echo (isset($_POST["wpdevart_serch"])? esc_js($_POST["wpdevart_serch"]) : ""); ?>">
								</div>
							</div>
							
							<input type="submit" value="<?php _e('Apply','booking-calendar'); ?>" class="action-link">
						</div>
					</div>
				</div>
			</div>
			<?php
			if(count($mail_error)) {
				$booking_calendar = '<div id="message" class="error_text_container div-for-clear email_error error notice is-dismissible"><p><span class="error_text">';
				foreach($mail_error as $error) {
					$booking_calendar .= $error. "</br>";
				}
				$booking_calendar .= '</span></p></div>';
				echo $booking_calendar;
			}
			
			if($calendar_id != 0) {
				wpdevart_bc_Library::items_nav($items_nav['limit'],$items_nav['total'],'reservations_form');
			}	?>			
			<table class="wp-list-table widefat fixed pages wpdevart-table wpdevart-reservations-table"> 
				<tr>
					<thead>
						<th class="check-column"><input type="checkbox" name="check_all" onclick="check_all_checkboxes(this,'check_for_action');"></th>
						<th class="small-column <?php echo (($res_order_by == 'id')? $res_order_class : ""); ?>"><a onclick="wpdevart_set_value('order_by', 'id'); wpdevart_set_value('asc_desc', '<?php echo (($res_order_by == 'id' && $asc_desc == 'asc') ? 'desc' : 'asc'); ?>');wpdevart_form_submit(event, 'reservations_form')" href=""><span><?php _e('ID','booking-calendar'); ?></span><span class="sorting-indicator"></span></a></th>
						<th class="average-column <?php echo (($res_order_by == 'status')? $res_order_class : ""); ?>"><a onclick="wpdevart_set_value('order_by', 'status'); wpdevart_set_value('asc_desc', '<?php echo (($res_order_by == 'status' && $asc_desc == 'asc') ? 'desc' : 'asc'); ?>');wpdevart_form_submit(event, 'reservations_form')" href=""><span><?php _e('Status','booking-calendar'); ?></span><span class="sorting-indicator"></span></a></th>
						<th class="res_info"><?php _e('Reservation information','booking-calendar'); ?></th>
						<?php if(WPDEVART_PRO == "extended" && $class != "") : ?>
							<th class="pay_info"><?php _e('Payment information','booking-calendar'); ?></th>
						<?php endif; ?>
						<th class="medium-column"><?php _e('Reservation dates','booking-calendar'); ?></th>
					</thead>
				</tr>
				<?php
				if($calendar_id != 0) {
					foreach ( $rows as $row ) {
						$check_in = "";
						$check_out = "";
						$single_day = "";
						$hour_html = "";
						$sale_percent_html = "";
						$pay_info = array();
						if(isset($row->pay_id)){
							$pay_info["payment_id"] = $row->pay_id;
							$pay_info["payment_price"] = $row->payment_price;
							$pay_info["tax"] = $row->tax;
							$pay_info["payment_address"] = $row->payment_address;
							$pay_info["payment_info"] = $row->payment_info;
							$pay_info["modified_date"] = $row->modified_date;
							$pay_info["ip"] = $row->ip;
						}
                        $form_data = $this->model_obj->get_form_data($row->form);
						if($row->address_billing){
							if(isset($theme_options["billing_address_form"]))
								$billing_data = $this->model_obj->get_form_data($row->address_billing,0,$theme_options["billing_address_form"],"billing_info_");
						}
						if($row->address_shipping){
							if(isset($theme_options["shipping_address_form"]))
								$shipping_data = $this->model_obj->get_form_data($row->address_shipping,0,$theme_options["shipping_address_form"],"shipping_info_");
						}
                        $extras_data = $this->model_obj->get_extra_data($row);
						if(isset($theme_options["date_format"]) && $theme_options["date_format"] != "") {
							$date_format = $theme_options["date_format"];
						} else {
							$date_format = "F d, Y";
						}
						if($row->check_in) {
							$check_in = date($date_format, strtotime($row->check_in));
							$check_out = date($date_format, strtotime($row->check_out));
						} else {
							$single_day = date($date_format, strtotime($row->single_day));
						}
						if(isset($single_day)) {
							$unique_id = $row->calendar_id."_".$row->single_day;
							$day_hours = $this->model_obj->get_date_data( $unique_id );
							$day_hours = json_decode($day_hours, true);
						}
						if(isset($row->start_hour) && $row->start_hour != "") {
							$hour_html = $row->start_hour;
						}
						if(isset($row->end_hour) && $row->end_hour != "") {
							$hour_html = $hour_html." - ".$row->end_hour;
						}
						if(isset($row->sale_percent) && !empty($row->sale_percent)){
							if($row->sale_type == "price"){
								$sale_percent = $row->total_price + $row->sale_percent;
								$sale_percent_html = ($cur_pos == "before" ? $row->currency : '') . $sale_percent . ($cur_pos == "after" ? $row->currency : '') . " - " . ($cur_pos == "before" ? $row->currency : '') . $row->sale_percent . ($cur_pos == "after" ? $row->currency : '') ." = ";
							}else{
								$sale_percent = $row->sale_percent != "100" ? ($row->total_price * 100) / (100 - $row->sale_percent) : $row->price;
								$sale_percent_html = ($cur_pos == "before" ? $row->currency : '') . $sale_percent . ($cur_pos == "after" ? $row->currency : '') . " - " . $row->sale_percent . "% = ";
							}
							
						}
						$status = __('Pending','booking-calendar');
						if ($row->status == 'approved')
							$status = __('Approved','booking-calendar');
						elseif ($row->status == 'rejected')
							$status = __('Rejected','booking-calendar');
						elseif ($row->status == 'canceled')
							$status = __('Canceled','booking-calendar');
						?>
						
						<tr id="id_<?php echo $row->id; ?>">
							<td><input type="checkbox" name="check_for_action[]" class="check_for_action" value="<?php echo $row->id; ?>"></td>
							<td><?php echo $row->id; ?></td>
							<td><span class="reserv_status reserv_status_<?php echo $row->status; ?>"><?php echo $status; ?><span></td>
							<td>
							<div class="reserv-info div-for-clear">
								<div class='reserv-info-container'>
									<h5  class="reserv-info-open-title"><?php _e('Details','booking-calendar'); ?><span class="reserv-info-open"><i class="fa fa-chevron-down" aria-hidden="true"></i></span></h5>
									<span class='form_info'><span class='form_label'><?php _e('Item Count','booking-calendar'); ?></span> <span class='form_value'><?php echo $row->count_item; ?></span></span>
									<?php if(!isset($theme_options['hide_price'])) { ?>
									<span class='form_info'><span class='form_label'><?php _e('Price','booking-calendar'); ?></span> <span class='form_value'><?php echo ($cur_pos == "before" ? $row->currency : '') . $row->price . (($cur_pos == "after") ? $row->currency : ''); ?></span></span>
									<span class='form_info'><span class='form_label'><?php _e('Total Price','booking-calendar'); ?></span> <span class='form_value'><?php echo $sale_percent_html . ($cur_pos == "before" ? $row->currency : '') . $row->total_price . ($cur_pos == "after" ? $row->currency : ''); ?></span></span>
									<?php } ?>
								</div>
								
							</div>
							<div class="reserv-info-items div-for-clear">
								<?php
								
								/*Hours info*/
								if(isset($day_hours["hours"]) && count($day_hours["hours"])){ ?>
									<div class='reserv-info-container hours_info'>
										<h5><?php _e('Hours','booking-calendar'); ?></h5>
										<?php  $start = 0;
										$count = 0;
										foreach($day_hours["hours"] as $key => $hour) {
											if($key == $row->start_hour) {
												$start = 1;
											} 
											if($start == 1 && (!($row->end_hour == "" && $count == 1))) { ?>
												<span class='form_info'><span class='form_label'><?php echo $key; ?></span> <span class='form_value'><?php echo ($cur_pos == "before" ? $row->currency : '').(isset($hour["price"]) ? $hour["price"] : "").($cur_pos == "after" ? $row->currency : ''); ?><span class="hour-info"><?php echo (isset($hour["info_users"])) ? $hour["info_users"] : ""; ?></span></span></span>
											<?php $count += 1;
											}
											if($key == $row->end_hour){ 
												$start = 0;
											}
										} ?>
									</div>
								<?php } 
								
								$reserv_info = "<div class='div-for-clear'>";
								/*Form data*/
								if(count($form_data)) {
									$reserv_info .= "<div class='reserv-info-container'>";
									$reserv_info .= "<h5>" .__("Contact Information",'booking-calendar')."</h5>";
									foreach($form_data as $form_fild_data) {
										if($form_fild_data['type'] == 'countries' && trim($form_fild_data['value']) != "") {
											$reserv_info .= "<span class='form_info'><span class='form_label'>". wpdevart_bc_Library::translated_text($form_fild_data["label"]) ."</span> <span class='form_value'>". $countries[$form_fild_data["value"]] ."</span></span>";
										}else {
											$value = $form_fild_data["value"];
											if(strpos($form_fild_data["value"], "|wpdev|") !== false){
												$value = explode("|wpdev|",$form_fild_data["value"]);
												$value = implode(", ",$value);
											}
											if($form_fild_data["type"] == "upload" && trim($value) != "")
												$value = "<a href='" . $value . "' target='_blank'>" . __("File", 'booking-calendar') . "</a>";
											$reserv_info .= "<span class='form_info'><span class='form_label'>". wpdevart_bc_Library::translated_text($form_fild_data["label"]) ."</span> <span class='form_value'>". $value ."</span></span>";
										}
									}
									$reserv_info .= "</div>";
								}
								/*Extras data*/
								if(count($extras_data)) {
									$reserv_info .= "<div class='reserv-info-container'>";
									$reserv_info .= "<h5>" .__("Extra Information",'booking-calendar')."</h5>";
									foreach($extras_data as $extra_data) {
										$reserv_info .= "<h6>".wpdevart_bc_Library::translated_text($extra_data["group_label"])."</h6>";
										$reserv_info .= "<span class='form_info'><span class='form_label'>". wpdevart_bc_Library::translated_text($extra_data["label"]) ."</span>"; 
										$reserv_info .= "<span class='form_value'>";
										if($extra_data["price_type"] == "percent") {
											$reserv_info .= "<span class='price-percent'>".$extra_data["operation"].$extra_data["price_percent"]."%</span>";
											$reserv_info .= "<span class='price'>".$extra_data["operation"] . (($cur_pos == "before" ? $row->currency : '') . (isset($extra_data["price"]) ? $extra_data["price"] : "") . (($cur_pos == "after") ? $row->currency : ''))."</span></span></span>";
										} else {
											$reserv_info .= "<span class='price'>".$extra_data["operation"] .(($cur_pos == "before" ? $row->currency : '') . $extra_data["price"] . ($cur_pos == "after" ? $row->currency : ''))."</span></span></span>";
										}
										
									}
									$reserv_info .= "<h6>" .__("Price change",'booking-calendar')."</h6>";
									$reserv_info .= "<span class='form_info'><span class='form_label'></span><span class='form_value'>".(($row->extras_price<0)? "" : "+").($cur_pos == "before" ? $row->currency : '') . $row->extras_price . ($cur_pos == "after" ? $row->currency : '')."</span>"; 
									$reserv_info .= "</div></div>";
								}
								/*Billing data*/
								if(isset($billing_data) && count($billing_data) && $row->address_billing != "[]") {
									$reserv_info .= "<div class='reserv-info-container'>";
									$reserv_info .= "<h5>" .__("Billing address",'booking-calendar')."</h5>";
									foreach($billing_data as $form_fild_data) {
										if($form_fild_data['type'] == 'countries' && trim($form_fild_data['value']) != "") {
											$reserv_info .= "<span class='form_info'><span class='form_label'>". wpdevart_bc_Library::translated_text($form_fild_data["label"]) ."</span> <span class='form_value'>". $countries[$form_fild_data["value"]] ."</span></span>";
										}else {
											$value = $form_fild_data["value"];
											if(strpos($form_fild_data["value"], "|wpdev|") !== false){
												$value = explode("|wpdev|",$form_fild_data["value"]);
												$value = implode(", ",$value);
											}
											$reserv_info .= "<span class='form_info'><span class='form_label'>". wpdevart_bc_Library::translated_text($form_fild_data["label"]) ."</span> <span class='form_value'>". $value ."</span></span>";
										}
									}
									$reserv_info .= "</div>";
								}
								/*Shipping data*/
								if(isset($shipping_data) && count($shipping_data) && $row->address_shipping != "[]") {
									$reserv_info .= "<div class='reserv-info-container'>";
									$reserv_info .= "<h5>" .__("Shipping address",'booking-calendar')."</h5>";
									foreach($shipping_data as $form_fild_data) {
										if($form_fild_data['type'] == 'countries' && trim($form_fild_data['value']) != "") {
											$reserv_info .= "<span class='form_info'><span class='form_label'>". wpdevart_bc_Library::translated_text($form_fild_data["label"]) ."</span> <span class='form_value'>". $countries[$form_fild_data["value"]] ."</span></span>";
										}else {
											$value = $form_fild_data["value"];
											if(strpos($form_fild_data["value"], "|wpdev|") !== false){
												$value = explode("|wpdev|",$form_fild_data["value"]);
												$value = implode(", ",$value);
											}
											$reserv_info .= "<span class='form_info'><span class='form_label'>". wpdevart_bc_Library::translated_text($form_fild_data["label"]) ."</span> <span class='form_value'>". $value ."</span></span>";
										}
									}
									$reserv_info .= "</div>";
								}
								echo $reserv_info;	?> 		
							  </div>
							</td>
							<?php if(WPDEVART_PRO == "extended" && $class != "") : ?>
								<td>
								<?php if(isset($theme_options["paypal"]) && $theme_options["paypal"] == "on" && $row->payment_method == "paypal") : ?>
									<div class="reserv-info div-for-clear">
										<div class='reserv-info-container'>
											<h5  class="reserv-info-open-title"><?php _e('Payment method - Paypal','booking-calendar'); ?>
											<?php if(count($pay_info)) { ?>
												<span class="reserv-info-open"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
											<?php } ?>
											</h5>
											<span class='form_info'><span class='form_label'><?php _e('Payment Status','booking-calendar'); ?></span> <span class='form_value'><span class="payment_status paypal"><?php echo $row->pay_status; ?></span></span></span>
										</div>
									</div>
									<div class="reserv-info-items div-for-clear paymant_div">
										<?php									
										$pay = "<div class='div-for-clear'>";
										/*Form data*/
										if(count($pay_info)) {
											$pay .= "<div class='reserv-info-container'>";
											$pay .= "<h5>" .__("Paymant Information",'booking-calendar')."</h5>";
											foreach($pay_info as $key=>$value) {
												$cur = "";
												if($key == "payment_price")
													$cur = $row->currency;
												$pay .= "<span class='form_info'><span class='form_label'>".str_replace("_"," ", ucfirst($key)) ."</span> <span class='form_value'>".((isset($theme_options['currency_pos']) && $theme_options['currency_pos'] == "before" && $cur != "") ? $cur : ""). $value .(((isset($theme_options['currency_pos']) && $theme_options['currency_pos'] == "after") || !isset($theme_options['currency_pos'])) ? $cur : '').($key == "tax" ? "%" : "")."</span></span>";
											}
											$pay .= "</div>";
										}
										echo $pay;	?> 		
										</div>
									  </div>
								  <?php endif; ?>
								  <?php if(isset($theme_options["pay_in_cash"]) && $theme_options["pay_in_cash"] == "on"&& $row->payment_method == "pay_in_cash") : ?>
									<div class="reserv-info div-for-clear">
										<div class='reserv-info-container'>
											<h5  class="reserv-info-open-title"><?php _e('Payment method - Pay in cash','booking-calendar'); ?></h5>
											<span class='form_info'><span class='form_label'><?php _e('Payment Status','booking-calendar'); ?></span> <span class='form_value'><span class="payment_status pay_in_cash"><?php echo $row->payment_status; ?></span></span></span>
										</div>
									</div>
								  <?php endif; ?>
								</td>
							<?php endif; ?>
							<td>
							<?php
								if($check_in != "" && $check_out != "") {
									echo $check_in. "-" .$check_out;
								} else {
									echo $single_day;
								} 
								if($hour_html != "") {
									echo "<div>".__("Hour","booking-calendar")." ".$hour_html."</div>";
								} 
								
								if(isset($row->is_new) && $row->is_new == 1){ ?>
									<a href=''  onclick="wpdevart_set_value('task','mark_read'); wpdevart_set_value('cur_id','<?php echo $row->id; ?>'); wpdevart_form_submit(event, 'reservations_form')" title="<?php _e("Mark as read","booking-calendar"); ?>"><span class='new_res'><?php _e("New","booking-calendar"); ?></span>
								<?php } ?>
						   </td>
						</tr>   
						<tr>   
							<td colspan="<?php echo (WPDEVART_PRO == "extended" && $class != "") ? "5" : "4"; ?>">
							<span class="buttons">
								<?php if($row->status == "pending" || $row->status == "canceled" || $row->status == "rejected") { ?>
									<a href="" onclick="wpdevart_set_value('task','approve'); wpdevart_set_value('cur_id','<?php echo $row->id; ?>'); wpdevart_form_submit(event, 'reservations_form')"  class="action-button approve-button" ><?php _e('Approve','booking-calendar'); ?></a>
									<?php if($row->status == "pending") { ?>
										<a href="" onclick="wpdevart_set_value('task','reject'); wpdevart_set_value('cur_id','<?php echo $row->id; ?>'); wpdevart_form_submit(event, 'reservations_form')" class="action-button reject-button" ><?php _e('Reject','booking-calendar'); ?></a>
									<?php  } ?>
								<?php } elseif($row->status == "approved") { ?>
									<a href="" onclick="wpdevart_set_value('task','canceled'); wpdevart_set_value('cur_id','<?php echo $row->id; ?>'); wpdevart_form_submit(event, 'reservations_form')" class="action-button cancel-button" ><?php _e('Cancel','booking-calendar'); ?></a>
								<?php  } ?>
								<a href="" onclick="wpdevart_set_value('task','delete'); wpdevart_set_value('cur_id','<?php echo $row->id; ?>'); wpdevart_form_submit(event, 'reservations_form')"  class="action-button delete-button"><?php _e('Delete','booking-calendar'); ?></a>
							</span>
							
							<span class="buttons">
								<a  <?php echo (WPDEVART_PRO == "extended" ) ? 'onclick="wpdevart_set_value(\'task\',\'edit\'); wpdevart_set_value(\'cur_id\',' . $row->id .'); wpdevart_form_submit(event, \'reservations_form\')"' : ""; ?>  class="action-button cal-edit-button wpdevart-button"><?php _e('Edit','booking-calendar'); ?>
								<?php if(WPDEVART_PRO != "extended" ) : ?>
									<span>(Extended)</span>
								<?php endif; ?>
								</a>	
							  <?php if(isset($row->payment_status) && $row->payment_status != "") :?>
								<a  onclick="quick_edit(this,'<?php echo $row->id; ?>');"  class="action-button quick-edit-button wpdevart-button"><?php _e('Payment Status Edit','booking-calendar'); ?></a>
							  <?php endif; ?>
								<a  onclick="cancel_edit(this,'<?php echo $row->id; ?>');"  class="action-button cancel-edit-button wpdevart-button cancel_<?php echo $row->id; ?>"><?php _e('Cancel','booking-calendar'); ?></a>
								<a  onclick="quick_update(this,'<?php echo $row->id; ?>');"  class="action-button update-edit-button wpdevart-button"><?php _e('Update','booking-calendar'); ?></a>
								<span class="spinner"></span>
							</span>
							</td>
							<td colspan="1">
								<div class="created_date"><?php _e('Created:','booking-calendar'); ?> <?php echo date($date_format. " H:i", strtotime($row->date_created)); ?></div>
							</td>
						</tr>
				<?php	}
				 } ?>
			</table>
			
			<input type="hidden" name="task" id="task" value="">
			<input type="hidden" name="id" id="cur_id" value="">
			<input type="hidden" name="calendar_id" value="<?php echo $calendar_id; ?>">
			<input type="hidden" name="order_by" id="order_by" value="<?php echo (isset($_POST['order_by']))? esc_html($_POST['order_by']) : ""; ?>"/>
			<input type="hidden" name="asc_desc" id="asc_desc" value="<?php echo (isset($_POST['asc_desc']))? esc_html($_POST['asc_desc']) : ""; ?>"/>
			<?php if($calendar_id != 0) {
				wpdevart_bc_Library::items_nav($items_nav['limit'],$items_nav['total'],'reservations_form');
			}	?>	
		</form>
	</div>
<?php
	}  
	
    public function display_month_reservations() {
		$calendar_id = wpdevart_bc_Library::get_value("calendar_id", 0);
		$calendar_rows = $this->model_obj->get_calendar_rows();  ?>
		<div id="wpdevart_reservations_container" class="wpdevart-list-container month-view">
		<form action="admin.php?page=wpdevart-reservations" method="get" id="reservations_form">
			<div id="action-buttons" class="div-for-clear">
				<div id="reservation_header" class="div-for-clear">
					<div class="div-for-clear">
						<span class="admin_logo"></span>
						<h1><?php _e('Reservations Month View','booking-calendar'); ?> </h1>
					</div>
					<select name="calendar_id" onchange="wpdevart_set_value('task','display_month_reservations');this.form.submit()">
						<option value='0'><?php _e('Select Calendar','booking-calendar'); ?></option>
						<?php foreach($calendar_rows as $calendar_row) {
							echo "<option value='".$calendar_row["id"]."' ".selected($calendar_id, $calendar_row["id"],false).">".$calendar_row["title"]."</option>";
						} ?>
					</select>
					<a id="view_list" href="<?php echo add_query_arg(array( 'page' => 'wpdevart-reservations', 'calendar_id' => $calendar_id,'task' => 'display_reservations' ), admin_url('admin.php')); ?>"><span class="reservation-item-info"><?php _e('Reservation List View','booking-calendar'); ?></span></a>
					<span id="view_calendar"><span class="reservation-item-info"><?php _e('Reservation Month View','booking-calendar'); ?></span></span>
					<a id="add_reservation" href="<?php echo add_query_arg(array( 'page' => 'wpdevart-reservations', 'calendar_id' => $calendar_id,'task' => 'add' ), admin_url('admin.php')); ?>" class="add-reservation"><span class="plus">+</span><span class="reservation-item-info"><?php _e('Add Reservation','booking-calendar'); ?></span></a>
				</div>
				
			</div>
			<div class="wpdevart_res_month_view">
				<?php
				if($calendar_id != 0) {
					$booking_obg = new wpdevart_bc_calendar();
					$result = $booking_obg->wpdevart_booking_calendar_res($calendar_id);			
					echo $result;
				} ?>
			</div>
			<input type="hidden" name="task" id="task" value="">
			<input type="hidden" name="page" id="page" value="wpdevart-reservations">
		</form>
	</div>
<?php
	}  
	
	public function add() {
		$calendar_id = wpdevart_bc_Library::get_value("calendar_id", 0);
		
		$calendar_rows = $this->model_obj->get_calendar_rows(); ?>
		<div id="wpdevart_add_reservations_container"  class="wpdevart-list-container">
			<form action="admin.php?page=wpdevart-reservations" method="get" id="reservations_form">
				<div id="action-buttons" class="div-for-clear">
					<div id="reservation_header" class="div-for-clear">
						<div class="div-for-clear">
							<span class="admin_logo"></span>
							<h1><?php _e('Add Reservation','booking-calendar'); ?> </h1>
						</div>
						<select name="calendar_id" onchange="wpdevart_set_value('task','add');this.form.submit()">
							<option value='0'><?php _e('Select Calendar','booking-calendar'); ?></option>
							<?php foreach($calendar_rows as $calendar_row) {
								echo "<option value='".$calendar_row["id"]."' ".selected($calendar_id, $calendar_row["id"],false).">".$calendar_row["title"]."</option>";
							} ?>
						</select>
						<a id="view_list" href="<?php echo add_query_arg(array( 'page' => 'wpdevart-reservations', 'calendar_id' => $calendar_id,'task' => 'display_reservations' ), admin_url('admin.php')); ?>"><span class="reservation-item-info"><?php _e('Reservation List View','booking-calendar'); ?></span></a>
						<?php if (WPDEVART_PRO == "free") : ?>
							<span id="view_calendar" class="pro-field"><span class="reservation-item-info"><?php _e('Reservation Month View','booking-calendar'); ?><span class="pro_feature">(Pro Feature!)</span></span></span>
						<?php else : ?>
							<a id="view_calendar" href="<?php echo add_query_arg(array( 'page' => 'wpdevart-reservations', 'calendar_id' => $calendar_id,'task' => 'display_month_reservations' ), admin_url('admin.php')); ?>"><span class="reservation-item-info"><?php _e('Reservation Month View','booking-calendar'); ?></span></a>
						<?php endif; ?>
						<span id="add_reservation" class="add-reservation"><span class="plus">+</span><span class="reservation-item-info"><?php _e('Add Reservation','booking-calendar'); ?></span></span>
					</div>
					<input type="hidden" name="task" id="task" value="add">
					<input type="hidden" name="page" id="page" value="wpdevart-reservations">
				</div>
			</form>
			<div class="wpdevart_add_res">
				<?php
				if($calendar_id != 0) {
					$booking_obg = new wpdevart_bc_calendar();
					$result = $booking_obg->wpdevart_booking_calendar($calendar_id);
					echo $result;
				} ?>
			</div>
				
		</div>
	<?php	
	}
	
	public function edit( $id ) {
		$calendar_id = wpdevart_bc_Library::get_value("calendar_id", 0);  ?>
		<div id="wpdevart_add_reservations_container"  class="wpdevart-list-container">
			<div class="div-for-clear">
				<span class="admin_logo"></span>
				<h1><?php _e('Edit Reservation','booking-calendar'); ?> </h1>
			</div>
			<div id="wpdevart_update_res" class="wpdevart_add_res">
				<?php
				if($calendar_id != 0) {
					$booking_obg = new wpdevart_bc_calendar();
					$result = $booking_obg->wpdevart_booking_calendar($calendar_id, $id);
					echo $result;
				} ?>
			</div>
		</div>
	<?php	
	}

	private function get_date_diff($date1, $date2) {
		$start = strtotime($date1);
		$end = strtotime($date2);
		$datediff = $start - $end;
		return floor($datediff/(60*60*24));
	}
 
  
}

?>