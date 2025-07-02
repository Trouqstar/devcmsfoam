<?php
/**
 * The template for displaying product content within loops
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! is_a( $product, WC_Product::class ) || ! $product->is_visible() ) {
	return;
}
?>

<li <?php wc_product_class( '', $product ); ?>>

	<?php
	// Open the product link wrapper
	do_action( 'woocommerce_before_shop_loop_item' );

	// Output the product image / sale badge
	do_action( 'woocommerce_before_shop_loop_item_title' );
	?>

	<?php if ( $product->is_type( 'variable' ) ) :
		$attributes = $product->get_variation_attributes();
		$available_variations = $product->get_available_variations();
		?>
		<!-- ✅ Variation dropdowns now OUTSIDE the button wrap -->
		<div class="custom-variation-wrapper"
		     data-product_id="<?php echo esc_attr( $product->get_id() ); ?>"
		     data-product_variations='<?php echo wp_json_encode( $available_variations ); ?>'>
			<?php foreach ( $attributes as $attribute_name => $options ) : ?>
				<div class="variation-select">
					<select class="custom-attribute-select"
					        data-attribute_name="attribute_<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>">
						<option value=""><?php echo esc_html( wc_attribute_label( $attribute_name ) ); ?></option>
						<?php foreach ( $options as $option ) : ?>
							<option value="<?php echo esc_attr( $option ); ?>"><?php echo esc_html( $option ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php
	// Product title
	do_action( 'woocommerce_shop_loop_item_title' );

	// Rating and price
	do_action( 'woocommerce_after_shop_loop_item_title' );

	// Close product link
	do_action( 'woocommerce_template_loop_product_link_close' );

	// Directly include the custom add-to-cart.php template
	wc_get_template_part( 'loop/add-to-cart' );
	?>

</li>
