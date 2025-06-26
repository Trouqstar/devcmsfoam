<?php
/**
 * Partial: Wishlist product block (non-empty)
 */
$product = $args['product'] ?? null;

if (!$product instanceof WC_Product) {
    return;
}
?>

<div class="wishlist-product" data-product-id="<?php echo esc_attr($product->get_id()); ?>">
    <div class="wishlist-product-content">
        <?php wc_get_template_part('content', 'product'); ?>
    </div>
</div>
