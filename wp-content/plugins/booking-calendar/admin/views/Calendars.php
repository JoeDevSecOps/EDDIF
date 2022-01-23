<?php
class wpdevart_bc_ViewCalendars {
	public $model_obj;
    	
    public function __construct( $model ) {
		$this->model_obj = $model;
    }	
	
    /*############  Display calendars function ################*/	
	
    public function display_calendars() {
		$rows = $this->model_obj->get_calendars_rows();
		$current_user = get_current_user_id();
		$current_user_info = get_userdata( $current_user ); 
		$current_user_info = $current_user_info->roles; 
		$role = isset($current_user_info[0]) ? $current_user_info[0] : "";
		$items_nav = $this->model_obj->items_nav();
		$asc_desc = ((isset($_POST['asc_desc']) && $_POST['asc_desc'] == 'asc') ? 'asc' : 'desc');
		$res_order_by = (isset($_POST['order_by']) ? sanitize_sql_orderby($_POST['order_by']) :  'id');
		$res_order_class = 'sorted ' . $asc_desc; ?>
		<div id="wpdevart_calendars_container" class="wpdevart-list-container">
			<div id="action-buttons" class="div-for-clear">
				<div class="div-for-clear">
					<span class="admin_logo"></span>
					<h1><?php _e('Calendars','booking-calendar'); ?></h1>
				</div>
				<a href="" onclick="wpdevart_set_value('task','add'); wpdevart_form_submit(event, 'calendars_form')" class="action-link"><?php _e('Add Calendar','booking-calendar'); ?></a>
				<a href="" onclick="wpdevart_set_value('task','delete_selected'); wpdevart_form_submit(event, 'calendars_form')" class="action-link delete-link"><?php _e('Delete','booking-calendar'); ?></a>
			</div>	
			<form action="admin.php?page=wpdevart-calendars" method="post" id="calendars_form">
			<?php wpdevart_bc_Library::items_nav($items_nav['limit'],$items_nav['total'],'calendars_form'); ?>
				<table class="wp-list-table widefat fixed pages wpdevart-table"> 
					<tr>
						<thead>
							<th class="check-column"><input type="checkbox" name="check_all" onclick="check_all_checkboxes(this,'check_for_action');"></th>
							<th class="small-column"><?php _e('ID','booking-calendar'); ?></th>
							<th><?php _e('Title','booking-calendar'); ?></th>
							<th><?php _e('Shortcode','booking-calendar'); ?></th>
							<?php if($role == "administrator"){ ?>
								<th><?php _e('User','booking-calendar'); ?></th>
							<?php } ?>	
							<th class="action-column"><?php _e('Edit','booking-calendar'); ?></th>
							<th class="action-column"><?php _e('Delete','booking-calendar'); ?></th>
						</thead>
					<tr>
					<?php
						foreach ( $rows as $row ) { 
							$user = $row->user_id;
							$user_info = get_userdata( $user );						?>
							<tr>
								<td><input type="checkbox" name="check_for_action[]" class="check_for_action" value="<?php echo $row->id; ?>"></td>
								<td><?php echo $row->id; ?></td>
								<td><a href="<?php echo add_query_arg(array( 'page' => 'wpdevart-calendars', 'task' => 'edit', 'id' => $row->id ), admin_url('admin.php')); ?>"><?php echo $row->title; ?></a></td>
								<td><input type="text" value="[wpdevart_booking_calendar id=&quot;<?php echo $row->id; ?>&quot;]" onclick="this.focus();this.select();" readonly="readonly" size="32"></td>
								<?php if($role == "administrator"){
                                      ?>
									<td><a href="<?php echo get_edit_user_link( $user ) ?>"><?php echo ($user_info)? $user_info->user_login : ""; ?></a></td>
								<?php } ?>	
								<td><a href="<?php echo add_query_arg(array( 'page' => 'wpdevart-calendars', 'task' => 'edit', 'id' => $row->id ), admin_url('admin.php')); ?>"><?php _e('Edit','booking-calendar'); ?></a></td>
								<td><a href="" onclick="wpdevart_set_value('task','delete'); wpdevart_set_value('cur_id','<?php echo $row->id; ?>'); wpdevart_form_submit(event, 'calendars_form')" ><?php _e('Delete','booking-calendar'); ?></a></td>
							<tr>
					<?php	}
					?>
				</table>
				<input type="hidden" name="task" id="task" value="">
				<input type="hidden" name="id" id="cur_id" value="">
				<?php wpdevart_bc_Library::items_nav($items_nav['limit'],$items_nav['total'],'calendars_form'); ?>
			</form>
		</div>
    <?php }
	
    public function edit_calendars( $id = 0, $current_date = "" ) { 
	    $themes = array();
	    $forms = array("0"=>"None");
	    $extras = array("0"=>"None");
	    $themes_arr = $this->model_obj->get_setting_rows();
	    $forms_arr = $this->model_obj->get_form_rows();
	    $extras_arr = $this->model_obj->get_extra_rows();
		foreach ($themes_arr as $theme) {
			$themes[$theme['id']] = $theme['title'];
		}
		foreach ($forms_arr as $form) {
			$forms[$form['id']] = $form['title'];
		}
		foreach ($extras_arr as $extra) {
			$extras[$extra['id']] = $extra['title'];
		}
		if($id != 0){
			$calendar_rows = $this->model_obj->get_calendar_rows( $id );
			$theme_info = $this->model_obj->get_setting_row($calendar_rows['theme_id']);
		}				
		$wpdevart_calendars = array(
	
			'general' => array(
				'title' => 'General',
				'value' => array(
					'title' => array(
						'id'   => 'title',
						'title' => __('Calendar Title','booking-calendar'),
						'description' => '',
						'type' => 'text',
						'default' => ''
					),
					'theme_id' => array(
						'id'   => 'theme_id',
						'title' => __('Theme','booking-calendar'),
						'description' => '',
						'valid_options' => $themes,
						'onchange' => "submit_form('apply')",
						'type' => 'select',
						'default' => ''
					),
					'form_id' => array(
						'id'   => 'form_id',
						'title' => __('Form','booking-calendar'),
						'description' => '',
						'valid_options' => $forms,
						'type' => 'select',
						'default' => ''
					),
					'extra_id' => array(
						'id'   => 'extra_id',
						'title' => __('Extra','booking-calendar'),
						'description' =>  '',
						'valid_options' => $extras,
						'type' => 'select',
						'default' => ''
					)
				)	
			)
		);
		
		if(isset($theme_info["hours_enabled"]) && $theme_info["hours_enabled"] == "on"){
			$wpdevart_calendar_form = array(
				'set_days_availability' => array(
					'title' => 'Set days availability',
					'value' => array(
						'selection_type' => array(
							'id'   => 'selection_type',
							'title' => 'Different values for different days of week',
							'description' => '',
							'valid_options' => array(
												   "overall" => "Disable",
												   "custom" => "Enable"
												),
							'type' => 'radio_enable',
							'pro' => 'extended',
							'enable' => array('overall'=>array('days_availability','info_users','info_admin','day_hours'),'custom'=>array('monday_info','days_availability_monday','info_users_monday','info_admin_monday','day_hours_monday','tuesday_hour_info','wednesday_hour_info','thursday_hour_info','friday_hour_info','saturday_hour_info','sunday_hour_info','monday_hour_info','tuesday_info','days_availability_tuesday','info_users_tuesday','info_admin_tuesday','day_hours_tuesday','wednesday_info','days_availability_wednesday','info_users_wednesday','info_admin_wednesday','day_hours_wednesday','thursday_info','days_availability_thursday','info_users_thursday','info_admin_thursday','day_hours_thursday','friday_info','days_availability_friday','info_users_friday','info_admin_friday','day_hours_friday','saturday_info','days_availability_saturday','info_users_saturday','info_admin_saturday','day_hours_saturday','sunday_info','days_availability_sunday','info_users_sunday','info_admin_sunday','day_hours_sunday')),
							'default' => 'overall'
						),
						'days_availability' => array(
							'id'   => 'days_availability',
							'title' => 'Set days availability',
							'description' => '',
							'valid_options' => array(
												   "available" => "Available",
												   "booked" => "Booked",
												   "unavailable" => "Unavailable",
												),
							'type' => 'select',
							'default' => ''
						),
						'info_users' => array(
							'id'   => 'info_users',
							'title' => 'Information for users',
							'description' => '',
							'pro' => 'pro',	
							'type' => 'textarea',
							'default' => ''
						),
						'info_admin' => array(
							'id'   => 'info_admin',
							'title' => 'Information for administrators',
							'description' => '',
							'pro' => 'pro',	
							'type' => 'textarea',
							'default' => ''
						),
						/*monday*/
						'monday_info' => array(
							'id'   => 'monday_info',
							'title' => 'Monday',
							'description' =>'',
							'type' => 'info',
							'class' => 'week_days',
							'default' => ''
						),
						'days_availability_monday' => array(
							'id'   => 'days_availability_monday',
							'title' => 'Set days availability',
							'description' => '',
							'valid_options' => array(
												   "available" => "Available",
												   "booked" => "Booked",
												   "unavailable" => "Unavailable",
												),
							'type' => 'select',
							'default' => ''
						),
						'info_users_monday' => array(
							'id'   => 'info_users_monday',
							'title' => 'Information for users',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						),
						'info_admin_monday' => array(
							'id'   => 'info_admin_monday',
							'title' => 'Information for administrators',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						),
						/*Tuesday*/
						'tuesday_info' => array(
							'id'   => 'tuesday_info',
							'title' => 'Tuesday',
							'description' =>'',
							'type' => 'info',
							'class' => 'week_days',
							'default' => ''
						),
						'days_availability_tuesday' => array(
							'id'   => 'days_availability_tuesday',
							'title' => 'Set days availability',
							'description' => '',
							'valid_options' => array(
												   "available" => "Available",
												   "booked" => "Booked",
												   "unavailable" => "Unavailable",
												),
							'type' => 'select',
							'default' => ''
						),
						'info_users_tuesday' => array(
							'id'   => 'info_users_tuesday',
							'title' => 'Information for users',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						),
						'info_admin_tuesday' => array(
							'id'   => 'info_admin_tuesday',
							'title' => 'Information for administrators',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						),
						/*Wednesday*/
						'wednesday_info' => array(
							'id'   => 'wednesday_info',
							'title' => 'Wednesday',
							'description' =>'',
							'type' => 'info',
							'class' => 'week_days',
							'default' => ''
						),
						'days_availability_wednesday' => array(
							'id'   => 'days_availability_wednesday',
							'title' => 'Set days availability',
							'description' => '',
							'valid_options' => array(
												   "available" => "Available",
												   "booked" => "Booked",
												   "unavailable" => "Unavailable",
												),
							'type' => 'select',
							'default' => ''
						),
						'info_users_wednesday' => array(
							'id'   => 'info_users_wednesday',
							'title' => 'Information for users',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						),
						'info_admin_wednesday' => array(
							'id'   => 'info_admin_wednesday',
							'title' => 'Information for administrators',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						),
						/*Thursday*/
						'thursday_info' => array(
							'id'   => 'thursday_info',
							'title' => 'Thursday',
							'description' =>'',
							'type' => 'info',
							'class' => 'week_days',
							'default' => ''
						),
						'days_availability_thursday' => array(
							'id'   => 'days_availability_thursday',
							'title' => 'Set days availability',
							'description' => '',
							'valid_options' => array(
												   "available" => "Available",
												   "booked" => "Booked",
												   "unavailable" => "Unavailable",
												),
							'type' => 'select',
							'default' => ''
						),
						'info_users_thursday' => array(
							'id'   => 'info_users_thursday',
							'title' => 'Information for users',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						),
						'info_admin_thursday' => array(
							'id'   => 'info_admin_thursday',
							'title' => 'Information for administrators',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						),
						/*Friday*/
						'friday_info' => array(
							'id'   => 'friday_info',
							'title' => 'Friday',
							'description' =>'',
							'type' => 'info',
							'class' => 'week_days',
							'default' => ''
						),
						'days_availability_friday' => array(
							'id'   => 'days_availability_friday',
							'title' => 'Set days availability',
							'description' => '',
							'valid_options' => array(
												   "available" => "Available",
												   "booked" => "Booked",
												   "unavailable" => "Unavailable",
												),
							'type' => 'select',
							'default' => ''
						),
						'info_users_friday' => array(
							'id'   => 'info_users_friday',
							'title' => 'Information for users',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						),
						'info_admin_friday' => array(
							'id'   => 'info_admin_friday',
							'title' => 'Information for administrators',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						),
						/*Saturday*/
						'saturday_info' => array(
							'id'   => 'saturday_info',
							'title' => 'Saturday',
							'description' =>'',
							'type' => 'info',
							'class' => 'week_days',
							'default' => ''
						),
						'days_availability_saturday' => array(
							'id'   => 'days_availability_saturday',
							'title' => 'Set days availability',
							'description' => '',
							'valid_options' => array(
												   "available" => "Available",
												   "booked" => "Booked",
												   "unavailable" => "Unavailable",
												),
							'type' => 'select',
							'default' => ''
						),
						'info_users_saturday' => array(
							'id'   => 'info_users_saturday',
							'title' => 'Information for users',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						),
						'info_admin_saturday' => array(
							'id'   => 'info_admin_saturday',
							'title' => 'Information for administrators',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						),
						/*Sunday*/
						'sunday_info' => array(
							'id'   => 'sunday_info',
							'title' => 'Sunday',
							'description' =>'',
							'type' => 'info',
							'class' => 'week_days',
							'default' => ''
						),
						'days_availability_sunday' => array(
							'id'   => 'days_availability_sunday',
							'title' => 'Set days availability',
							'description' => '',
							'valid_options' => array(
												   "available" => "Available",
												   "booked" => "Booked",
												   "unavailable" => "Unavailable",
												),
							'type' => 'select',
							'default' => ''
						),
						'info_users_sunday' => array(
							'id'   => 'info_users_sunday',
							'title' => 'Information for users',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						),
						'info_admin_sunday' => array(
							'id'   => 'info_admin_sunday',
							'title' => 'Information for administrators',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						),
					)	
				),
				'set_hours_availability' => array(
					'title' => 'Set hours availability',
					'value' => array(
						'day_hours' => array(
							'id'   => 'day_hours',
							'title' => 'Days hours',
							'description' =>'This will overwrite hours data in theme. Add one per line(hh:mm). Use 24 hours format.',
							'type' => 'hours_element',
							'default' => $theme_info["hours"]
						),
						'monday_hour_info' => array(
							'id'   => 'monday_hour_info',
							'title' => 'Monday',
							'description' =>'',
							'type' => 'info',
							'class' => 'week_days',
							'default' => ''
						),
						'day_hours_monday' => array(
							'id'   => 'day_hours_monday',
							'title' => 'Days hours',
							'description' =>'This will overwrite hours data in theme. Add one per line(hh:mm). Use 24 hours format.',
							'type' => 'hours_element',
							'default' => $theme_info["hours"]
						),
						'tuesday_hour_info' => array(
							'id'   => 'tuesday_hour_info',
							'title' => 'Tuesday',
							'description' =>'',
							'type' => 'info',
							'class' => 'week_days',
							'default' => ''
						),
						'day_hours_tuesday' => array(
							'id'   => 'day_hours_tuesday',
							'title' => 'Days hours',
							'description' =>'This will overwrite hours data in theme. Add one per line(hh:mm). Use 24 hours format.',
							'type' => 'hours_element',
							'default' => $theme_info["hours"]
						),
						'wednesday_hour_info' => array(
							'id'   => 'wednesday_hour_info',
							'title' => 'Wednesday',
							'description' =>'',
							'type' => 'info',
							'class' => 'week_days',
							'default' => ''
						),
						'day_hours_wednesday' => array(
							'id'   => 'day_hours_wednesday',
							'title' => 'Days hours',
							'description' =>'This will overwrite hours data in theme. Add one per line(hh:mm). Use 24 hours format.',
							'type' => 'hours_element',
							'default' => $theme_info["hours"]
						),
						'thursday_hour_info' => array(
							'id'   => 'thursday_hour_info',
							'title' => 'Thursday',
							'description' =>'',
							'type' => 'info',
							'class' => 'week_days',
							'default' => ''
						),
						'day_hours_thursday' => array(
							'id'   => 'day_hours_thursday',
							'title' => 'Days hours',
							'description' =>'This will overwrite hours data in theme. Add one per line(hh:mm). Use 24 hours format.',
							'type' => 'hours_element',
							'default' => $theme_info["hours"]
						),
						'friday_hour_info' => array(
							'id'   => 'friday_hour_info',
							'title' => 'Friday',
							'description' =>'',
							'type' => 'info',
							'class' => 'week_days',
							'default' => ''
						),
						'day_hours_friday' => array(
							'id'   => 'day_hours_friday',
							'title' => 'Days hours',
							'description' =>'This will overwrite hours data in theme. Add one per line(hh:mm). Use 24 hours format.',
							'type' => 'hours_element',
							'default' => $theme_info["hours"]
						),
						'saturday_hour_info' => array(
							'id'   => 'saturday_hour_info',
							'title' => 'Saturday',
							'description' =>'',
							'type' => 'info',
							'class' => 'week_days',
							'default' => ''
						),
						'day_hours_saturday' => array(
							'id'   => 'day_hours_saturday',
							'title' => 'Days hours',
							'description' =>'This will overwrite hours data in theme. Add one per line(hh:mm). Use 24 hours format.',
							'type' => 'hours_element',
							'default' => $theme_info["hours"]
						),
						'sunday_hour_info' => array(
							'id'   => 'sunday_hour_info',
							'title' => 'Sunday',
							'description' =>'',
							'type' => 'info',
							'class' => 'week_days',
							'default' => ''
						),
						'day_hours_sunday' => array(
							'id'   => 'day_hours_sunday',
							'title' => 'Days hours',
							'description' =>'This will overwrite hours data in theme. Add one per line(hh:mm). Use 24 hours format.',
							'type' => 'hours_element',
							'default' => $theme_info["hours"]
						)
					)	
				)
			);
		} else {
			$wpdevart_calendar_form = array(
				'set_days_availability' => array(
					'title' => 'Set days availability',
					'value' => array(
						'selection_type' => array(
							'id'   => 'selection_type',
							'title' => 'Different values for different days of week',
							'description' => '',
							'valid_options' => array(
												   "overall" => "Disable",
												   "custom" => "Enable"
												),
							'pro' => 'extended',
							'type' => 'radio_enable',
							'enable' => array('overall'=>array('days_availability','number_availability','price','marked_price','info_users','info_admin'),'custom'=>array('monday_info','days_availability_monday','number_availability_monday','price_monday','marked_price_monday','info_users_monday','info_admin_monday','tuesday_info','days_availability_tuesday','number_availability_tuesday','price_tuesday','marked_price_tuesday','info_users_tuesday','info_admin_tuesday','wednesday_info','days_availability_wednesday','number_availability_wednesday','price_wednesday','marked_price_wednesday','info_users_wednesday','info_admin_wednesday','thursday_info','days_availability_thursday','number_availability_thursday','price_thursday','marked_price_thursday','info_users_thursday','info_admin_thursday','friday_info','days_availability_friday','number_availability_friday','price_friday','marked_price_friday','info_users_friday','info_admin_friday','saturday_info','days_availability_saturday','number_availability_saturday','price_saturday','marked_price_saturday','info_users_saturday','info_admin_saturday','sunday_info','days_availability_sunday','number_availability_sunday','price_sunday','marked_price_sunday','info_users_sunday','info_admin_sunday')),
							'default' => 'overall'
						),
						'days_availability' => array(
							'id'   => 'days_availability',
							'title' => 'Set days availability',
							'description' => '',
							'valid_options' => array(
												   "available" => "Available",
												   "booked" => "Booked",
												   "unavailable" => "Unavailable",
												),
							'type' => 'select',
							'default' => ''
						),
						'number_availability' => array(
							'id'   => 'number_availability',
							'title' => 'Number Availabile',
							'description' =>'',
							'type' => 'text',
							'default' => '1'
						),
						'price' => array(
							'id'   => 'price',
							'title' => 'Price',
							'description' => '',
							'type' => 'text',
							'default' => ''
						),
						'marked_price' => array(
							'id'   => 'marked_price',
							'title' => 'Marked Price',
							'description' =>'',
							'type' => 'text',
							'pro' => 'pro',
							'default' => ''
						),
						'info_users' => array(
							'id'   => 'info_users',
							'title' => 'Information for users',
							'description' => '',
							'type' => 'textarea',
							'pro' => 'pro',
							'default' => ''
						),
						'info_admin' => array(
							'id'   => 'info_admin',
							'title' => 'Information for administrators',
							'description' => '',
							'type' => 'textarea',
							'pro' => 'pro',
							'default' => ''
						),
						/*monday*/
						'monday_info' => array(
							'id'   => 'monday_info',
							'title' => 'Monday',
							'description' =>'',
							'type' => 'info',
							'class' => 'week_days',
							'default' => ''
						),
						'days_availability_monday' => array(
							'id'   => 'days_availability_monday',
							'title' => 'Set days availability',
							'description' => '',
							'valid_options' => array(
												   "available" => "Available",
												   "booked" => "Booked",
												   "unavailable" => "Unavailable",
												),
							'type' => 'select',
							'default' => ''
						),
						'number_availability_monday' => array(
							'id'   => 'number_availability_monday',
							'title' => 'Number Availabile',
							'description' =>'',
							'type' => 'text',
							'default' => '1'
						),
						'price_monday' => array(
							'id'   => 'price_monday',
							'title' => 'Price',
							'description' => '',
							'type' => 'text',
							'default' => ''
						),
						'marked_price_monday' => array(
							'id'   => 'marked_price_monday',
							'title' => 'Marked Price',
							'description' =>'',
							'type' => 'text',
							'default' => ''
						),
						'info_users_monday' => array(
							'id'   => 'info_users_monday',
							'title' => 'Information for users',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						),
						'info_admin_monday' => array(
							'id'   => 'info_admin_monday',
							'title' => 'Information for administrators',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						),
						/*Tuesday*/
						'tuesday_info' => array(
							'id'   => 'tuesday_info',
							'title' => 'Tuesday',
							'description' =>'',
							'type' => 'info',
							'class' => 'week_days',
							'default' => ''
						),
						'days_availability_tuesday' => array(
							'id'   => 'days_availability_tuesday',
							'title' => 'Set days availability',
							'description' => '',
							'valid_options' => array(
												   "available" => "Available",
												   "booked" => "Booked",
												   "unavailable" => "Unavailable",
												),
							'type' => 'select',
							'default' => ''
						),
						'number_availability_tuesday' => array(
							'id'   => 'number_availability_tuesday',
							'title' => 'Number Availabile',
							'description' =>'',
							'type' => 'text',
							'default' => '1'
						),
						'price_tuesday' => array(
							'id'   => 'price_tuesday',
							'title' => 'Price',
							'description' => '',
							'type' => 'text',
							'default' => ''
						),
						'marked_price_tuesday' => array(
							'id'   => 'marked_price_tuesday',
							'title' => 'Marked Price',
							'description' =>'',
							'type' => 'text',
							'default' => ''
						),
						'info_users_tuesday' => array(
							'id'   => 'info_users_tuesday',
							'title' => 'Information for users',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						),
						'info_admin_tuesday' => array(
							'id'   => 'info_admin_tuesday',
							'title' => 'Information for administrators',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						),
						/*Wednesday*/
						'wednesday_info' => array(
							'id'   => 'wednesday_info',
							'title' => 'Wednesday',
							'description' =>'',
							'type' => 'info',
							'class' => 'week_days',
							'default' => ''
						),
						'days_availability_wednesday' => array(
							'id'   => 'days_availability_wednesday',
							'title' => 'Set days availability',
							'description' => '',
							'valid_options' => array(
												   "available" => "Available",
												   "booked" => "Booked",
												   "unavailable" => "Unavailable",
												),
							'type' => 'select',
							'default' => ''
						),
						'number_availability_wednesday' => array(
							'id'   => 'number_availability_wednesday',
							'title' => 'Number Availabile',
							'description' =>'',
							'type' => 'text',
							'default' => '1'
						),
						'price_wednesday' => array(
							'id'   => 'price_wednesday',
							'title' => 'Price',
							'description' => '',
							'type' => 'text',
							'default' => ''
						),
						'marked_price_wednesday' => array(
							'id'   => 'marked_price_wednesday',
							'title' => 'Marked Price',
							'description' =>'',
							'type' => 'text',
							'default' => ''
						),
						'info_users_wednesday' => array(
							'id'   => 'info_users_wednesday',
							'title' => 'Information for users',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						),
						'info_admin_wednesday' => array(
							'id'   => 'info_admin_wednesday',
							'title' => 'Information for administrators',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						),
						/*Thursday*/
						'thursday_info' => array(
							'id'   => 'thursday_info',
							'title' => 'Thursday',
							'description' =>'',
							'type' => 'info',
							'class' => 'week_days',
							'default' => ''
						),
						'days_availability_thursday' => array(
							'id'   => 'days_availability_thursday',
							'title' => 'Set days availability',
							'description' => '',
							'valid_options' => array(
												   "available" => "Available",
												   "booked" => "Booked",
												   "unavailable" => "Unavailable",
												),
							'type' => 'select',
							'default' => ''
						),
						'number_availability_thursday' => array(
							'id'   => 'number_availability_thursday',
							'title' => 'Number Availabile',
							'description' =>'',
							'type' => 'text',
							'default' => '1'
						),
						'price_thursday' => array(
							'id'   => 'price_thursday',
							'title' => 'Price',
							'description' => '',
							'type' => 'text',
							'default' => ''
						),
						'marked_price_thursday' => array(
							'id'   => 'marked_price_thursday',
							'title' => 'Marked Price',
							'description' =>'',
							'type' => 'text',
							'default' => ''
						),
						'info_users_thursday' => array(
							'id'   => 'info_users_thursday',
							'title' => 'Information for users',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						),
						'info_admin_thursday' => array(
							'id'   => 'info_admin_thursday',
							'title' => 'Information for administrators',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						),
						/*Friday*/
						'friday_info' => array(
							'id'   => 'friday_info',
							'title' => 'Friday',
							'description' =>'',
							'type' => 'info',
							'class' => 'week_days',
							'default' => ''
						),
						'days_availability_friday' => array(
							'id'   => 'days_availability_friday',
							'title' => 'Set days availability',
							'description' => '',
							'valid_options' => array(
												   "available" => "Available",
												   "booked" => "Booked",
												   "unavailable" => "Unavailable",
												),
							'type' => 'select',
							'default' => ''
						),
						'number_availability_friday' => array(
							'id'   => 'number_availability_friday',
							'title' => 'Number Availabile',
							'description' =>'',
							'type' => 'text',
							'default' => '1'
						),
						'price_friday' => array(
							'id'   => 'price_friday',
							'title' => 'Price',
							'description' => '',
							'type' => 'text',
							'default' => ''
						),
						'marked_price_friday' => array(
							'id'   => 'marked_price_friday',
							'title' => 'Marked Price',
							'description' =>'',
							'type' => 'text',
							'default' => ''
						),
						'info_users_friday' => array(
							'id'   => 'info_users_friday',
							'title' => 'Information for users',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						),
						'info_admin_friday' => array(
							'id'   => 'info_admin_friday',
							'title' => 'Information for administrators',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						),
						/*Saturday*/
						'saturday_info' => array(
							'id'   => 'saturday_info',
							'title' => 'Saturday',
							'description' =>'',
							'type' => 'info',
							'class' => 'week_days',
							'default' => ''
						),
						'days_availability_saturday' => array(
							'id'   => 'days_availability_saturday',
							'title' => 'Set days availability',
							'description' => '',
							'valid_options' => array(
												   "available" => "Available",
												   "booked" => "Booked",
												   "unavailable" => "Unavailable",
												),
							'type' => 'select',
							'default' => ''
						),
						'number_availability_saturday' => array(
							'id'   => 'number_availability_saturday',
							'title' => 'Number Availabile',
							'description' =>'',
							'type' => 'text',
							'default' => '1'
						),
						'price_saturday' => array(
							'id'   => 'price_saturday',
							'title' => 'Price',
							'description' => '',
							'type' => 'text',
							'default' => ''
						),
						'marked_price_saturday' => array(
							'id'   => 'marked_price_saturday',
							'title' => 'Marked Price',
							'description' =>'',
							'type' => 'text',
							'default' => ''
						),
						'info_users_saturday' => array(
							'id'   => 'info_users_saturday',
							'title' => 'Information for users',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						),
						'info_admin_saturday' => array(
							'id'   => 'info_admin_saturday',
							'title' => 'Information for administrators',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						),
						/*Sunday*/
						'sunday_info' => array(
							'id'   => 'sunday_info',
							'title' => 'Sunday',
							'description' =>'',
							'type' => 'info',
							'class' => 'week_days',
							'default' => ''
						),
						'days_availability_sunday' => array(
							'id'   => 'days_availability_sunday',
							'title' => 'Set days availability',
							'description' => '',
							'valid_options' => array(
												   "available" => "Available",
												   "booked" => "Booked",
												   "unavailable" => "Unavailable",
												),
							'type' => 'select',
							'default' => ''
						),
						'number_availability_sunday' => array(
							'id'   => 'number_availability_sunday',
							'title' => 'Number Availabile',
							'description' =>'',
							'type' => 'text',
							'default' => '1'
						),
						'price_sunday' => array(
							'id'   => 'price_sunday',
							'title' => 'Price',
							'description' => '',
							'type' => 'text',
							'default' => ''
						),
						'marked_price_sunday' => array(
							'id'   => 'marked_price_sunday',
							'title' => 'Marked Price',
							'description' =>'',
							'type' => 'text',
							'default' => ''
						),
						'info_users_sunday' => array(
							'id'   => 'info_users_sunday',
							'title' => 'Information for users',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						),
						'info_admin_sunday' => array(
							'id'   => 'info_admin_sunday',
							'title' => 'Information for administrators',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						)
					)	
				)
			);
		}
	

		$wpdevart_calendar_form ["set_days_availability"]["value"] = array("start_date" => array(
			'id'   => 'start_date',
			'title' => __('Start Date','booking-calendar'),
			'description' => '',
			'type' => 'text',
			'readonly' => true,
			'default' => ''
		)) + array("end_date" => array(
			'id'   => 'end_date',
			'title' => __('End Date','booking-calendar'),
			'description' => '',
			'type' => 'text',
			'readonly' => true,
			'default' => ''
		)) + $wpdevart_calendar_form ["set_days_availability"]["value"];
			
		
		?>
		<div id="wpdevart_calendars" class="wpdevart-item-container wpdevart-main-item-container">
			<div class="div-for-clear">
				<span class="admin_logo"></span>
				<h1>
			        <?php if($id != 0){
						_e('Edit Calendar','booking-calendar');
					} else {
						_e('Add Calendar','booking-calendar');
				    }  ?>
				</h1>
			</div>
			<form action="?page=wpdevart-calendars" method="post" id="add_edit_form">
				<input type="submit" value="<?php _e('Save','booking-calendar'); ?>" class="action-link wpda-input" name="save" onclick="if(!jQuery('#theme_id option').length){alert('Add Theme'); return false;}">
				<input type="submit" value="<?php _e('Apply','booking-calendar'); ?>" class="action-link wpda-input" name="apply" id="apply"  onclick="if(!jQuery('#theme_id option').length){alert('Add Theme'); return false;}">
				<input type="hidden" name="task" value="save">
				<input type="hidden" name="id" value="<?php echo $id; ?>">
				<input type="hidden" name="current_date" value="<?php echo $current_date; ?>">
				<?php
				  foreach( $wpdevart_calendars as $wpdevart_calendar ) { ?>
					<div class="wpdevart-item-section"> 
					    <h3><?php echo $wpdevart_calendar['title']; ?></h3>
						<div class="wpdevart-item-section-cont">
							<?php foreach( $wpdevart_calendar['value'] as $key => $wpdevart_calendars_value ) {
								if ( !isset($calendar_rows) ) {
									$sett_value = $wpdevart_calendars_value['default'];
								} else {
									if(isset($calendar_rows[$key]))
										$sett_value = $calendar_rows[$key];
									else
										$sett_value = "";
								}
								$function_name = "wpdevart_callback_" . $wpdevart_calendars_value['type'];
								wpdevart_bc_Library::$function_name($wpdevart_calendars_value, $sett_value);
							} ?>
						</div>	
					</div>	
				<?php  }
				$booking_obg = new wpdevart_bc_calendar();
				$result = $booking_obg->wpdevart_booking_calendar($id, 0, $current_date); ?>
				<div class="admin-calendar div-for-clear">
					<?php echo $result;
					  foreach( $wpdevart_calendar_form as $form_item ) {
						$sett_value_cal = 0;			?>
						<div class="wpdevart-item-section form-section"> 
							<h3><?php echo $form_item['title']; ?></h3>
							<div class="wpdevart-item-section-cont">
								<?php foreach( $form_item['value'] as $key => $value ) {
									$sett_value_cal = $value['default'];
									$function_name = "wpdevart_callback_" . $value['type'];
									wpdevart_bc_Library::$function_name($value, $sett_value_cal);
								} ?>
							</div>	
						</div>	
					<?php  } ?>
				</div>	
				<input type="submit" value="<?php _e('Save','booking-calendar'); ?>" class="action-link wpda-input" name="save" onclick="if(!jQuery('#theme_id option').length){alert('Add Theme'); return false;}">
				<input type="submit" value="<?php _e('Apply','booking-calendar'); ?>" class="action-link wpda-input" name="apply" id="apply"  onclick="if(!jQuery('#theme_id option').length){alert('Add Theme'); return false;}">
				<input type="submit" value="Delete day data" class="action-link button wpda-input" name="dalete_data" id="dalete_data">
			</form>
		</div>
	<?php	
	}
  
	private function get_month() {
		$month = array(
		    '0'  => __('Current','booking-calendar'),
		    '01' => __('January','booking-calendar'),
			'02' => __('February','booking-calendar'),
			'03' => __('March','booking-calendar'),
			'04' => __('April','booking-calendar'),
			'05' => __('May','booking-calendar'),
			'06' => __('June','booking-calendar'),
			'07' => __('July','booking-calendar'),
			'08' => __('August','booking-calendar'),
			'09' => __('September','booking-calendar'),
			'10' => __('October','booking-calendar'),
			'11' => __('November','booking-calendar'),
			'12' => __('December','booking-calendar')
		);
		return $month;
	}
 
 
  
}

?>