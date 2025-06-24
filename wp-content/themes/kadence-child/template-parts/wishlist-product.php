<?php
/**
 * Partial: Wishlist product block
 *
 * @param WC_Product $product Passed from get_template_part()
 */
$product = $args['product'] ?? null;

if (!$product instanceof WC_Product) {
    return;
}
?>

<div class="wishlist-product" data-product-id="<?php echo esc_attr($product->get_id()); ?>">
    <div class="wishlist-product-inner">

        <!-- Wishlist remove button -->
        <button class="remove-from-wishlist" aria-label="<?php esc_attr_e('Remove from wishlist', 'your-textdomain'); ?>">
            &times;
        </button>

        <!-- WooCommerce product template -->
        <div class="wishlist-product-content">
            <?php wc_get_template_part('content', 'product'); ?>
        </div>

    </div>
</div>
