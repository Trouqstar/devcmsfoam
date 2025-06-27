<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

// Check if product is in cart
$in_cart = false;
if ( WC()->cart && ! WC()->cart->is_empty() ) {
	foreach ( WC()->cart->get_cart() as $cart_item ) {
		if ( $cart_item['product_id'] == $product->get_id() ) {
			$in_cart = true;
			break;
		}
	}
}

$aria_describedby = isset( $args['aria-describedby_text'] )
	? sprintf( 'aria-describedby="woocommerce_loop_add_to_cart_link_describedby_%s"', esc_attr( $product->get_id() ) )
	: '';

// Build classes for add to cart button
$button_class = isset( $args['class'] ) ? $args['class'] : 'button add_to_cart_button';
if ( $in_cart ) {
	$button_class .= ' added'; // <-- Add class if in cart
}
?>

<div class="action-button-wrap">
	<?php
	// Output Add to Cart button
	echo apply_filters(
		'woocommerce_loop_add_to_cart_link',
		sprintf(
			'<a href="%s" %s data-quantity="%s" class="%s" %s>%s</a>',
			esc_url( $product->add_to_cart_url() ),
			$aria_describedby,
			esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
			esc_attr( $button_class ),
			isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
			'<span class="cart-icon material-symbols-outlined">shopping_bag</span>'
		),
		$product,
		$args
	);
	?>

	<!-- View Cart Button -->
	<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="added_to_cart wc-forward">View cart</a>
</div>

<?php if ( isset( $args['aria-describedby_text'] ) ) : ?>
	<span id="woocommerce_loop_add_to_cart_link_describedby_<?php echo esc_attr( $product->get_id() ); ?>" class="screen-reader-text">
		<?php echo esc_html( $args['aria-describedby_text'] ); ?>
	</span>
<?php endif; ?>
