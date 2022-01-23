<?php
class wpdevart_bc_ViewExtras {
	public $model_obj;
    	
    public function __construct( $model ) {
		$this->model_obj = $model;
    }	
    public function display_extras($error_msg="",$delete=true) {
		$rows = $this->model_obj->get_extras_rows();
		$current_user = get_current_user_id();
		$current_user_info = get_userdata( $current_user ); 
		$current_user_info = $current_user_info->roles; 
		$role = isset($current_user_info[0]) ? $current_user_info[0] : "";
		$items_nav = $this->model_obj->items_nav();
		$asc_desc = ((isset($_POST['asc_desc']) && $_POST['asc_desc'] == 'asc') ? 'asc' : 'desc');
		$res_order_by = (isset($_POST['order_by']) ? sanitize_sql_orderby($_POST['order_by']) :  'id');
		$res_order_class = 'sorted ' . $asc_desc; ?>
		<div id="wpdevart_extras_container" class="wpdevart-list-container">
			<div id="action-buttons" class="div-for-clear">
				<div class="div-for-clear">
					<span class="admin_logo"></span>
					<h1><?php _e('Extras','booking-calendar'); ?> </h1>
				</div>
				<a href="" onclick="wpdevart_set_value('task','add'); wpdevart_form_submit(event, 'extras_form')" class="action-link"><?php _e('Add Extra','booking-calendar'); ?></a>
				<a href="" onclick="wpdevart_set_value('task','delete_selected'); wpdevart_form_submit(event, 'extras_form')" class="action-link delete-link"><?php _e('Delete','booking-calendar'); ?></a>
			</div>
			<?php if(isset($error_msg) && $error_msg != "") {
				$class = "error";
				if($delete === true) {
					$class = "updated";
				} ?>
				<div id="message" class="<?php echo $class; ?> notice is-dismissible"><p><?php echo $error_msg; ?></p></div>
			<?php } ?>
			<form action="admin.php?page=wpdevart-extras" method="post" id="extras_form">
			<?php wpdevart_bc_Library::items_nav($items_nav['limit'],$items_nav['total'],'extras_form'); ?>
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
								<td><a href="<?php echo add_query_arg(array( 'page' => 'wpdevart-extras', 'task' => 'edit', 'id' => $row->id ), admin_url('admin.php')); ?>"><?php echo $row->title; ?></a></td>
								<?php if($role == "administrator"){
                                     $user = $row->user_id;
									 $user_info = get_userdata( $user ); ?>
									<td><a href="<?php echo get_edit_user_link( $user ) ?>"><?php echo ($user_info)? $user_info->user_login : ""; ?></a></td>
								<?php } ?>	
								<td><a href="<?php echo add_query_arg(array( 'page' => 'wpdevart-extras', 'task' => 'duplicate', 'id' => $row->id ), admin_url('admin.php')); ?>"><?php _e('Duplicate','booking-calendar'); ?></a></td>
								<td><a href="<?php echo add_query_arg(array( 'page' => 'wpdevart-extras', 'task' => 'edit', 'id' => $row->id ), admin_url('admin.php')); ?>"><?php _e('Edit','booking-calendar'); ?></a></td>
								<td><a href="" onclick="wpdevart_set_value('task','delete'); wpdevart_set_value('cur_id','<?php echo $row->id; ?>'); wpdevart_form_submit(event, 'extras_form')" ><?php _e('Delete','booking-calendar'); ?></a></td>
							<tr>
					<?php	}
					?>
				</table>
				<input type="hidden" name="task" id="task" value="">
				<input type="hidden" name="id" id="cur_id" value="">
				<?php wpdevart_bc_Library::items_nav($items_nav['limit'],$items_nav['total'],'extras_form'); ?>
			</form>
		</div>
    <?php }

    /*############  Edit Extra function ################*/
	
    public function edit_extra( $id = 0 ) { 
	    
		$wpdevart_extras = array(
			'extra_field1' => array(
				'name'   => 'extra_field1',
				'label' => 'Adults',
				'type' => 'extras_field',
				'items' => array(
					'field_item1' => array('name'=>'field_item1',
					                    'label' => '1',
										'operation' => '+',
										'price_type' => 'price',
										'price_percent' => '0',
										'order' => '1'
									),
					'field_item2' => array('name'=>'field_item2',
					                    'label' => '2',
										'operation' => '+',
										'price_type' => 'price',
										'price_percent' => '0',
										'order' => '2'
									),
					'field_item3' => array('name'=>'field_item3',
					                    'label' => '3',
										'operation' => '+',
										'price_type' => 'price',
										'price_percent' => '0',
										'order' => '3'
									),
					'field_item4' => array('name'=>'field_item4',
					                    'label' => '4',
										'operation' => '+',
										'price_type' => 'price',
										'price_percent' => '0',
										'order' => '4'
									)
				),
				'default' => ''
			),
			'extra_field2' => array(
				'name'   => 'extra_field2',
				'label' => 'Children ',
				'type' => 'extras_field',
				'items' => array(
					'field_item1' => array('name'=>'field_item1',
					                    'label' => '1',
										'operation' => '+',
										'price_type' => 'price',
										'price_percent' => '0',
										'order' => '1'
									),
					'field_item2' => array('name'=>'field_item2',
					                    'label' => '2',
										'operation' => '+',
										'price_type' => 'price',
										'price_percent' => '0',
										'order' => '2'
									),
					'field_item3' => array('name'=>'field_item3',
					                    'label' => '3',
										'operation' => '+',
										'price_type' => 'price',
										'price_percent' => '0',
										'order' => '3'
									),
					'field_item4' => array('name'=>'field_item4',
					                    'label' => '4',
										'operation' => '+',
										'price_type' => 'price',
										'price_percent' => '0',
										'order' => '4'
									)
				),
				'default' => ''
			)
		);
		if($id != 0){
			$extra_rows = $this->model_obj->get_extra_rows( $id );
			$value = json_decode( $extra_rows->data, true );
			$wpdevart_extras = $value;
			$last_element = end($wpdevart_extras);
			$max_id = str_replace('extra_field', '', $last_element['name']);
		} 
		else {
			$max_id = 2;
		}
	
		?>
		<div id="wpdevart_extras" class="wpdevart-item-container wpdevart-main-item-container">
			<div class="div-for-clear">
				<span class="admin_logo"></span>
				<h1>
					<?php if($id != 0){
						_e('Edit Extra','booking-calendar');
					} else {
						_e('Add Extra','booking-calendar');
					}  ?>
				</h1>
				<?php wpdevart_bc_Library::multi_lng();	?>
			</div>
			<form action="?page=wpdevart-extras" method="post">
				<div id="wpdevart_wpdevart-item_title">
					<span><?php _e('Extra Name','booking-calendar'); ?></span> <input type="text" name="title" value="<?php if(isset($extra_rows->title)) echo esc_attr($extra_rows->title); ?>">
					<input type="submit" value="<?php _e('Save','booking-calendar'); ?>" class="action-link wpda-input" name="save">
					<input type="submit" value="<?php _e('Apply','booking-calendar'); ?>" class="action-link wpda-input" name="apply">
					<div id="add_field_container">
						<div id="add_extra_field" class="action-link" data-max="<?php echo $max_id; ?>"><?php _e('Add extra field','booking-calendar'); ?></div>
					</div>
				</div>
				<?php
				   ?>
					<div class="wpdevart-item-section"> 
						<h3><?php _e('Extras fields','booking-calendar'); ?></h3>
						<div class="wpdevart-item-section-cont">
							<?php
							foreach( $wpdevart_extras as $key => $wpdevart_extra ) {
								$sett_value = $wpdevart_extras[$key];
								wpdevart_bc_Library::wpdevart_extras_field($wpdevart_extra, $sett_value);
							} ?>
							<div id="new_extra_fields">
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