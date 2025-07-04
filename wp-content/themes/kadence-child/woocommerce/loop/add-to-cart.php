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


<!-- ✅ Button & wishlist wrap -->
<div class="action-button-wrap">
	<?php if ( $product->is_type( 'variable' ) ) : ?>
		<button
			type="button"
			class="custom-add-to-cart-btn button"
			data-product-id="<?php echo esc_attr( $product->get_id() ); ?>"
			data-quantity="1"
			data-variation-id=""
			disabled
		>
			<span class="cart-icon material-symbols-outlined">shopping_bag</span>
		</button>
	<?php else : ?>
		<!-- Simple product -->
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

	<?php echo get_wishlist_button_html( $product->get_id() ); ?>
</div>

<?php if ( isset( $args['aria-describedby_text'] ) ) : ?>
	<span id="woocommerce_loop_add_to_cart_link_describedby_<?php echo esc_attr( $product->get_id() ); ?>" class="screen-reader-text">
		<?php echo esc_html( $args['aria-describedby_text'] ); ?>
	</span>
<?php endif; ?>


<script>
jQuery(document).ready(function($) {
  $('.custom-variation-wrapper').hide();

  $(document).on('click', '.custom-overlay-icon', function(e) {
    e.preventDefault();
    e.stopImmediatePropagation(); // ✅ prevents duplicate events
    const productId = $(this).data('product-id');

    // Find the exact wrapper
    const $wrapper = $('.custom-variation-wrapper[data-product_id="' + productId + '"]');

    // Slide toggle safely
    if (!$wrapper.is(':animated')) {
      $wrapper.stop(true, true).slideToggle(200);
    }
  });


  $('.custom-variation-wrapper').each(function() {
    const $wrapper = $(this);
    const $selects = $wrapper.find('.custom-attribute-select');
    const productId = $wrapper.data('product_id');
    const $button = $('.custom-add-to-cart-btn[data-product-id="' + productId + '"]');
    const variations = $wrapper.data('product_variations');

    function findMatchingVariation() {
      const selected = {};
      $selects.each(function() {
        const attr = $(this).data('attribute_name');
        const val = $(this).val();
        if (val) selected[attr] = val;
      });

      const match = variations.find(v =>
        Object.keys(selected).every(attr => v.attributes[attr] === selected[attr])
      );

      if (match) {
        $button.prop('disabled', false).data('variation-id', match.variation_id);
      } else {
        $button.prop('disabled', true).data('variation-id', '');
      }
    }

    $selects.on('change', findMatchingVariation);

    $button.on('click', function(e) {
      e.preventDefault();
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
          pid: productId,
          vid: variation_id,
          qty: quantity
        },
        success: function(response) {
          $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $button]);
        }
      });
    });
  });
});
</script>
