<?php
/**
 * Loop Add to Cart
 *
 * Template overridden for AJAX variation add-to-cart functionality.
 * Save in yourtheme/woocommerce/loop/add-to-cart.php
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

$button_class = isset( $args['class'] ) ? $args['class'] : 'button add_to_cart_button';
if ( $in_cart ) {
	$button_class .= ' added';
}
?>

<div class="action-button-wrap">
	<?php if ( $product->is_type( 'variable' ) ) : ?>
		<?php
		$attributes = $product->get_variation_attributes();
		$available_variations = $product->get_available_variations();
		?>

		<div class="custom-variation-wrapper"
			 data-product_id="<?php echo esc_attr( $product->get_id() ); ?>"
			 data-product_variations='<?php echo wp_json_encode( $available_variations ); ?>'>

			<?php foreach ( $attributes as $attribute_name => $options ) : ?>
				<div class="variation-select">
					<select class="custom-attribute-select" data-attribute_name="attribute_<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>">
						<option value=""><?php echo esc_html( wc_attribute_label( $attribute_name ) ); ?></option>
						<?php foreach ( $options as $option ) : ?>
							<option value="<?php echo esc_attr( $option ); ?>"><?php echo esc_html( $option ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			<?php endforeach; ?>

			<button
				type="button"
				class="custom-add-to-cart-btn button"
				data-product-id="<?php echo esc_attr( $product->get_id() ); ?>"
				data-quantity="1"
				data-variation-id=""
				disabled
			>
				<?php echo '<span class="cart-icon material-symbols-outlined">shopping_bag</span>'; ?>
			</button>
		</div>

	<?php else : ?>
		<!-- Simple Product Add to Cart -->
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

	<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="added_to_cart wc-forward">View cart</a>
</div>

<?php if ( isset( $args['aria-describedby_text'] ) ) : ?>
	<span id="woocommerce_loop_add_to_cart_link_describedby_<?php echo esc_attr( $product->get_id() ); ?>" class="screen-reader-text">
		<?php echo esc_html( $args['aria-describedby_text'] ); ?>
	</span>
<?php endif; ?>

<script>
jQuery(document).ready(function($) {
	$('.custom-variation-wrapper').each(function() {
		const $wrapper = $(this);
		const $selects = $wrapper.find('.custom-attribute-select');
		const $button = $wrapper.find('.custom-add-to-cart-btn');
		const variations = $wrapper.data('product_variations');

		function findMatchingVariation() {
			const selected = {};
			$selects.each(function() {
				const attr = $(this).data('attribute_name');
				const val = $(this).val();
				if (val) selected[attr] = val;
			});

			const match = variations.find(v => {
				return Object.keys(selected).every(attr => {
					return v.attributes[attr] === selected[attr];
				});
			});

			if (match) {
				$button.prop('disabled', false).data('variation-id', match.variation_id);
			} else {
				$button.prop('disabled', true).data('variation-id', '');
			}
		}

		$selects.on('change', findMatchingVariation);

		$button.on('click', function(e) {
			e.preventDefault();

			const product_id = $(this).data('product-id');
			const variation_id = $(this).data('variation-id');
			const quantity = $(this).data('quantity');

			if (!variation_id) {
				alert('⚠️ Please select valid options before adding to cart.');
				return;
			}

			$.ajax({
				url: custom_ajax_cart.ajax_url,
				method: 'POST',
				data: {
					action: 'custom_ajax_add_to_cart',
					pid: product_id,
					vid: variation_id,
					qty: quantity
				},
			});
		});
	});
});
</script>
