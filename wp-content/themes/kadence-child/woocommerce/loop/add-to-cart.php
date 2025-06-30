<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.2.0
 */

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

// Build button class for simple products
$button_class = isset( $args['class'] ) ? $args['class'] : 'button add_to_cart_button';
if ( $in_cart ) {
	$button_class .= ' added';
}
?>

<div class="action-button-wrap">
	<?php if ( $product->is_type( 'variable' ) ) : ?>
		<!-- VARIABLE PRODUCT: Initial cart button -->
		<button type="button" class="show-variations-button button">
			<span class="cart-icon material-symbols-outlined">shopping_bag</span>
		</button>
		
		<!-- VARIABLE PRODUCT: Hidden attribute selection form -->
		<form class="variations_form cart" method="post" enctype='multipart/form-data'
			  action="<?php echo esc_url( $product->get_permalink() ); ?>"
			  data-product_id="<?php echo absint( $product->get_id() ); ?>"
			  data-product_variations="<?php echo esc_attr( wp_json_encode( $product->get_available_variations() ) ); ?>"
			  style="display: none;">

			<?php
			$attributes = $product->get_variation_attributes();
			foreach ( $attributes as $attribute_name => $options ) :
			?>
				<div class="variation-select">
					<select name="attribute_<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>">
						<option value=""><?php echo wc_attribute_label( $attribute_name ); ?></option>
						<?php foreach ( $options as $option ) : ?>
							<option value="<?php echo esc_attr( $option ); ?>"><?php echo esc_html( $option ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			<?php endforeach; ?>

			<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />
			<button type="submit" class="single_add_to_cart_button button alt">
				<?php echo esc_html( $product->single_add_to_cart_text() ); ?>
			</button>
		</form>

	<?php else : ?>
		<!-- SIMPLE PRODUCT: Direct Add to Cart -->
		<?php
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
	<?php endif; ?>

	<!-- View Cart Button -->
	<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="added_to_cart wc-forward">View cart</a>
</div>

<?php if ( isset( $args['aria-describedby_text'] ) ) : ?>
	<span id="woocommerce_loop_add_to_cart_link_describedby_<?php echo esc_attr( $product->get_id() ); ?>" class="screen-reader-text">
		<?php echo esc_html( $args['aria-describedby_text'] ); ?>
	</span>
<?php endif; ?>

<script>
jQuery(document).ready(function($) {
	$('.show-variations-button').on('click', function(e) {
		e.preventDefault();
		var $form = $(this).next('.variations_form');
		$(this).hide();
		$form.show();
	});
	
	// Optionally, add a way to cancel the variation selection
	$('.variations_form').on('click', '.cancel-variations', function(e) {
		e.preventDefault();
		$(this).closest('.variations_form').hide().prev('.show-variations-button').show();
	});
});
</script>