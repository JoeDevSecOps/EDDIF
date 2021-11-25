<?php
/**
 * @package WordPress
 * @subpackage Londres
 */
?>
<div id="secondary" class="widget-area four columns alpha">
	<?php if (function_exists('dynamic_sidebar') && is_active_sidebar('sidebar-widgets') && dynamic_sidebar('sidebar-widgets')) : else : ?>
	<?php endif; // end sidebar widget area ?>
</div><!-- #secondary .widget-area -->