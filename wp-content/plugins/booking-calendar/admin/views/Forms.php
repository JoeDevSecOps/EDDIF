<?php
class wpdevart_bc_Viewforms {
	public $model_obj;
    	
    public function __construct( $model ) {
		$this->model_obj = $model;
    }
	
    /*############  Forms function ################*/	
	
    public function display_forms($error_msg="",$delete=true) {
		$rows = $this->model_obj->get_forms_rows();
		$current_user = get_current_user_id();
		$current_user_info = get_userdata( $current_user ); 
		$current_user_info = $current_user_info->roles; 
		$role = isset($current_user_info[0]) ? $current_user_info[0] : "";
		$items_nav = $this->model_obj->items_nav();
		$asc_desc = ((isset($_POST['asc_desc']) && $_POST['asc_desc'] == 'asc') ? 'asc' : 'desc');
		$res_order_by = (isset($_POST['order_by']) ? sanitize_sql_orderby($_POST['order_by']) :  'id');
		$res_order_class = 'sorted ' . $asc_desc; ?>
		<div id="wpdevart_forms_container" class="wpdevart-list-container">
			<div id="action-buttons" class="div-for-clear">
				<div class="div-for-clear">
					<span class="admin_logo"></span>
					<h1><?php _e('Forms','booking-calendar'); ?> </h1>
				</div>
				<a href="" onclick="wpdevart_set_value('task','add'); wpdevart_form_submit(event, 'forms_form')" class="action-link"><?php _e('Add Form','booking-calendar'); ?></a>
				<a href="" onclick="wpdevart_set_value('task','delete_selected'); wpdevart_form_submit(event, 'forms_form')" class="action-link delete-link"><?php _e('Delete','booking-calendar'); ?></a>
			</div>
			<?php if(isset($error_msg) && $error_msg != "") {
				$class = "error";
				if($delete === true) {
					$class = "updated";
				} ?>
				<div id="message" class="<?php echo $class; ?> notice is-dismissible"><p><?php echo $error_msg; ?></p></div>
			<?php } ?>
			<form action="admin.php?page=wpdevart-forms" method="post" id="forms_form">
			<?php wpdevart_bc_Library::items_nav($items_nav['limit'],$items_nav['total'],'forms_form'); ?>
				<table class="wp-list-table widefat fixed pages wpdevart-table"> 
					<tr>
						<thead>
							<th class="check-column"><input type="checkbox" name="check_all" onclick="check_all_checkboxes(this,'check_for_action');"></th>
							<th class="small-column"><?php _e('ID','booking-calendar'); ?></th>
							<th><?php _e('Title','booking-calendar'); ?></th>
							<?php if($role == "administrator"){ ?>
								<th><?php _e('User','booking-calendar'); ?></th>
							<?php } ?>	
							<th class="action-column action-column-duplicate"><?php _e('Duplicate','booking-calendar'); ?></th>
							<th class="action-column"><?php _e('Edit','booking-calendar'); ?></th>
							<th class="action-column"><?php _e('Delete','booking-calendar'); ?></th>
						</thead>
					<tr>
					<?php
						foreach ( $rows as $row ) { ?>
							<tr>
								<td><input type="checkbox" name="check_for_action[]" class="check_for_action" value="<?php echo $row->id; ?>"></td>
								<td><?php echo $row->id; ?></td>
								<td><a href="<?php echo add_query_arg(array( 'page' => 'wpdevart-forms', 'task' => 'edit', 'id' => $row->id ), admin_url('admin.php')); ?>"><?php echo $row->title; ?></a></td>
								<?php if($role == "administrator"){
                                     $user = $row->user_id;
									 $user_info = get_userdata( $user ); ?>
									<td><a href="<?php echo get_edit_user_link( $user ) ?>"><?php echo ($user_info)? $user_info->user_login : ""; ?></a></td>
								<?php } ?>	
								<td><a href="<?php echo add_query_arg(array( 'page' => 'wpdevart-forms', 'task' => 'duplicate', 'id' => $row->id ), admin_url('admin.php')); ?>"><?php _e('Duplicate','booking-calendar'); ?></a></td>
								<td><a href="<?php echo add_query_arg(array( 'page' => 'wpdevart-forms', 'task' => 'edit', 'id' => $row->id ), admin_url('admin.php')); ?>"><?php _e('Edit','booking-calendar'); ?></a></td>
								<td><a href="" onclick="wpdevart_set_value('task','delete'); wpdevart_set_value('cur_id','<?php echo $row->id; ?>'); wpdevart_form_submit(event, 'forms_form')" ><?php _e('Delete','booking-calendar'); ?></a></td>
							<tr>
					<?php	}
					?>
				</table>
				<input type="hidden" name="task" id="task" value="">
				<input type="hidden" name="id" id="cur_id" value="">
				<?php wpdevart_bc_Library::items_nav($items_nav['limit'],$items_nav['total'],'forms_form'); ?>
			</form>
		</div>
    <?php }

    /*############  Form edit function ################*/
	
    public function edit_form( $id = 0 ) { 
	    
		$wpdevart_forms = array(
			'form_field1' => array(
				'name'   => 'form_field1',
				'label' => 'First Name',
				'type' => 'text',
				'default' => ''
			),
			'form_field2' => array(
				'name'   => 'form_field2',
				'label' => 'Last Name',
				'type' => 'text',
				'default' => ''
			),
			'form_field3' => array(
				'name'   => 'form_field3',
				'label' => 'Email',
				'type' => 'text',
				'isemail' => 'on',
				'default' => ''
			),
			'form_field4' => array(
				'name'   => 'form_field4',
				'label' => 'Phone',
				'type' => 'text',
				'default' => ''
			),
			'form_field5' => array(
				'name'   => 'form_field5',
				'label' => 'Message',
				'type' => 'textarea',
				'default' => ''
			)
		);
		if($id != 0){
			$form_rows = $this->model_obj->get_form_rows( $id );
			$value = json_decode( $form_rows->data, true );
			$wpdevart_forms = $value;
			$last_element = end($wpdevart_forms);
			$max_id = str_replace('form_field', '', $last_element['name']);
		} 
		else {
			$max_id = 5;
		}
		?>
		<div id="wpdevart_forms" class="wpdevart-item-container wpdevart-main-item-container">
			<div class="div-for-clear">
				<span class="admin_logo"></span>
				<h1> <?php
					if($id != 0){
						_e('Edit Form','booking-calendar');
					} else {
						_e('Add Form','booking-calendar');
					}  ?>
				</h1>
				<?php wpdevart_bc_Library::multi_lng();	?>
			</div>
			<form action="?page=wpdevart-forms" method="post">
				<div id="wpdevart_wpdevart-item_title">
					<span><?php _e('Form Name','booking-calendar'); ?></span> <input type="text" name="title" value="<?php if(isset($form_rows->title)) echo esc_attr($form_rows->title); ?>">
					<input type="submit" value="<?php _e('Save','booking-calendar'); ?>" class="action-link wpda-input" name="save">
					<input type="submit" value="<?php _e('Apply','booking-calendar'); ?>" class="action-link wpda-input" name="apply">
					<div id="add_field_container">
						<div id="add_field" class="action-link" ><?php _e('Add form field','booking-calendar'); ?></div>
						<div id="form_field_type" data-max="<?php echo $max_id; ?>">
							<span id="text_field"><?php _e('Text','booking-calendar'); ?></span>
							<span id="textarea_field"><?php _e('Textarea','booking-calendar'); ?></span>
							<span id="checkbox_field"><?php _e('Checkbox','booking-calendar'); ?></span>
							<!--<span id="radio_field">Radio</span>-->
							<span id="select_field"><?php _e('Drop down','booking-calendar'); ?></span>
							<span id="countries_field"><?php _e('Drop down(Countries)','booking-calendar'); ?></span>
							<span <?php echo WPDEVART_PRO != "extended" ? 'class="pro-field"' : 'id="recapthcha_field"'; ?>><?php _e('Google ReCapthcha','booking-calendar'); ?>
							<?php if (WPDEVART_PRO != "extended") : ?>
								<span class="pro-field pro_feature">(Extended)</span>
							<?php endif; ?>
							</span>
							<span <?php echo WPDEVART_PRO != "extended" ? 'class="pro-field"' : 'id="upload_field"'; ?>><?php _e('File Upload','booking-calendar'); ?>
							<?php if (WPDEVART_PRO != "extended") : ?>
								<span class="pro-field pro_feature">(Extended)</span>
							<?php endif; ?>
							</span>
						</div>
					</div>
				</div>
				<?php
				   ?>
					<div class="wpdevart-item-section"> 
						<h3><?php _e('Form fields','booking-calendar'); ?></h3>
						<div class="wpdevart-item-section-cont">
							<?php
							foreach( $wpdevart_forms as $key => $wpdevart_form ) {
								$sett_value = $wpdevart_forms[$key];
								if(isset($wpdevart_form['type'])) {
									$function_name = "wpdevart_form_" . $wpdevart_form['type'];
									if(method_exists("wpdevart_bc_Library",$function_name)) {
										wpdevart_bc_Library::$function_name($wpdevart_form, $sett_value);
									}
								}
							} ?>
							<div id="new_fieds">
							</div>	
						</div>	
					</div>	
				<input type="hidden" name="task" value="save">
				<input type="hidden" name="id" value="<?php echo $id; ?>">
				
			</form>
		</div>
	<?php	
	}
  

 
 
  
}

?>