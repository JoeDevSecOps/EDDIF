<?php

class wpdevart_bc_Widget extends WP_Widget {

    function __construct(){
		$widget = array('description' => __( 'Displays Booking Calendar WpDevArt', 'booking-calendar' ));
		$control = array('width' => 400, 'height' => 500);
		parent::__construct(false, $name = 'Booking Calendar WpDevArt', $widget, $control);
	}

    function widget($args, $instance) {
        extract($args);
		$title =  sanitize_text_field( $instance['title']);
		$id =  sanitize_text_field( $instance['id']);
        echo $before_widget;
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}	
		$calendar_class = new wpdevart_bc_calendar();
		$calendar = $calendar_class->wpdevart_booking_calendar($id, 0, "", false, array(),array(),"",true);
		echo $calendar;
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['id'] = sanitize_text_field($new_instance['id']);

        return $instance;
    }

    function form($instance) {
		global $wpdb;
        $title = ( isset($instance['title']) ) ? $instance['title'] : '';
        $ids = ( isset($instance['id']) ) ? $instance['id'] : '';
		$calendar_rows = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'wpdevart_calendars',ARRAY_A);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'booking-calendar'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('id'); ?>">
        <?php _e('Calendar to display', 'booking-calendar'); ?>
            </label>
        <?php
        if($calendar_rows) {?>
            <select id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>">
                <?php foreach ($calendar_rows as $calendar_row) { ?>
                    <option value="<?php echo $calendar_row["id"]; ?>" <?php selected($ids, $calendar_row["id"]); ?>><?php echo $calendar_row["title"]; ?></option>
                <?php } ?>
            </select>
        <?php } else {
			echo "There are no calendars.";
		} ?>
        </p>
<?php
    }

}
add_action('widgets_init', 'wpdevart_bc_register_widget');

function wpdevart_bc_register_widget(){
	return register_widget("wpdevart_bc_Widget");
}

