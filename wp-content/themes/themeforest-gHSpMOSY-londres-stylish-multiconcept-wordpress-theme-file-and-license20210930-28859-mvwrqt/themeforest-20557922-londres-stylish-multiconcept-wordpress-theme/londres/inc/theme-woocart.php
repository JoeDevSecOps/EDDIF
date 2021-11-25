<?php

function londres_print_woocommerce_button(){
	global $woocommerce;
	if (isset($woocommerce) && get_option("londres_woocommerce_cart") == "on"){ ?>
		<div class="londres_dynamic_shopping_bag">
			<div class="londres_little_shopping_bag_wrapper">
				<div class="londres_little_shopping_bag">
					<div class="title">
						<i class="ion-bag"></i>
					</div>
					<div class="overview">
						<span class="minicart_items"><?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'londres'), $woocommerce->cart->cart_contents_count); ?></span>
					</div>
				</div>
				<div class="londres_minicart_wrapper">
					<div class="londres_minicart">
					<?php
						if (sizeof($woocommerce->cart->cart_contents)>0){
							echo '<ul class="cart_list">';
							foreach ($woocommerce->cart->cart_contents as $cart_item_key => $cart_item){
								$_product = $cart_item['data'];
								if ($_product->exists() && $cart_item['quantity']>0){
									echo '<li class="cart_list_product">';
										echo '<a class="cart_list_product_img" href="'.esc_url(get_permalink($cart_item['product_id'])).'">' . $_product->get_image().'</a>';
										echo '<div class="cart_list_product_title">';
											$londres_product_title = $_product->get_title();
											$londres_short_product_title = (strlen($londres_product_title) > 28) ? substr($londres_product_title, 0, 25) . '...' : $londres_product_title;
											echo '<a href="'.esc_url(get_permalink($cart_item['product_id'])).'">' . apply_filters('woocommerce_cart_widget_product_title', $londres_short_product_title, $_product) . '</a>';
											echo '<div class="cart_list_product_quantity">'.$cart_item['quantity'].'x</div>';
										echo '</div>';
										echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s">x</a>', esc_url( wc_get_cart_remove_url( $cart_item_key ) ), esc_html__('Remove this item', 'londres') ), $cart_item_key );
										echo '<div class="cart_list_product_price">'.wc_price($_product->get_price()).'</div>';
										echo '<div class="clr"></div>';
									echo '</li>';
								}
							}
							echo '</ul>';
							?>
							<div class="minicart_total_checkout">
							<?php esc_html_e('Cart subtotal', 'londres'); ?><span><?php echo wp_kses_post($woocommerce->cart->get_cart_total()); ?></span>
							</div>
							<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="button londres_minicart_cart_but"><?php esc_html_e('View Bag', 'londres'); ?></a>
							<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="button londres_minicart_checkout_but"><?php esc_html_e('Checkout', 'londres'); ?></a>
							<?php
						} else {
							echo '<ul class="cart_list"><li class="empty">'.esc_html__('No products in the cart.','londres').'</li></ul>';
						}
						?>
					</div>
				</div>
			</div>
			<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="londres_little_shopping_bag_wrapper_mobiles"><span><?php echo wp_kses_post($woocommerce->cart->cart_contents_count); ?></span></a>
		</div>
	<?php
	}
}

function londres_woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	if (isset($woocommerce) && get_option("londres_woocommerce_cart") == "on"){
		$londres_woo_output = '
		<div class="londres_dynamic_shopping_bag" >
			<div class="londres_little_shopping_bag_wrapper">
				<div class="londres_little_shopping_bag">
					<div class="title">
						<i class="ion-bag"></i>
					</div>
					<div class="overview">
						<span class="minicart_items">'.sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'londres'), $woocommerce->cart->cart_contents_count).'</span>
					</div>
				</div>
				<div class="londres_minicart_wrapper">
					<div class="londres_minicart">';
						if (sizeof($woocommerce->cart->cart_contents)>0){
							$londres_woo_output .= '<ul class="cart_list">';
							foreach ($woocommerce->cart->cart_contents as $cart_item_key => $cart_item){
								$_product = $cart_item['data'];
								if ($_product->exists() && $cart_item['quantity']>0){
									$londres_woo_output .= '<li class="cart_list_product">';
										$londres_woo_output .= '<a class="cart_list_product_img" href="'.esc_url(get_permalink($cart_item['product_id'])).'">' . $_product->get_image().'</a>';
										$londres_woo_output .= '<div class="cart_list_product_title">';
											$londres_product_title = $_product->get_title();
											$londres_short_product_title = (strlen($londres_product_title) > 28) ? substr($londres_product_title, 0, 25) . '...' : $londres_product_title;
											$londres_woo_output .= '<a href="'.esc_url(get_permalink($cart_item['product_id'])).'">' . apply_filters('woocommerce_cart_widget_product_title', $londres_short_product_title, $_product) . '</a>';
											$londres_woo_output .= '<div class="cart_list_product_quantity">'.$cart_item['quantity'].'x</div>';
										$londres_woo_output .= '</div>';
										$londres_woo_output .= apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s">x</a>', esc_url( wc_get_cart_remove_url( $cart_item_key ) ), esc_html__('Remove this item', 'londres') ), $cart_item_key );
										$londres_woo_output .= '<div class="cart_list_product_price">'.wc_price($_product->get_price()).'</div>';
										$londres_woo_output .= '<div class="clr"></div>';
									$londres_woo_output .= '</li>';
								}
							}
							$londres_woo_output .= '</ul>';
							$londres_woo_output .= '
							<div class="minicart_total_checkout">
								'.esc_html__('Cart subtotal', 'londres').'<span>'.wp_kses_post($woocommerce->cart->get_cart_total()).'</span>
						</div>
						<a href="'.esc_url( wc_get_cart_url() ).'" class="button londres_minicart_cart_but">'.esc_html__('View Bag', 'londres').'</a>
						<a href="'.esc_url( wc_get_checkout_url() ).'" class="button londres_minicart_checkout_but">'. esc_html__('Checkout', 'londres').'</a>';
						} else {
							$londres_woo_output .= '<ul class="cart_list"><li class="empty">'.esc_html__('No products in the cart.','londres').'</li></ul>';
						}
						$londres_woo_output .= '
					</div>
				</div>
			</div>
			<a href="'.esc_url( wc_get_cart_url() ).'" class="londres_little_shopping_bag_wrapper_mobiles"><span>'. wp_kses_post($woocommerce->cart->cart_contents_count).'</span></a>
		</div>';
		$fragments['div.londres_dynamic_shopping_bag'] = $londres_woo_output;
		return $fragments;
	} else return "";
}

?>