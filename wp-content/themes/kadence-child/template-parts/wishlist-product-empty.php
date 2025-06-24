<?php
/**
 * Partial: Empty Wishlist State
 */
?>

<div class="wishlist-empty-state">
    <h2 class="wishlist-empty-title"><?php esc_html_e('My Saved Items', 'your-textdomain'); ?></h2>
    <div class="wishlist-empty-icon">♡</div>
    <p class="wishlist-empty-message">
        <?php esc_html_e('You currently have no saved items.', 'your-textdomain'); ?>
    </p>
    <p class="wishlist-empty-instruction">
        <?php esc_html_e('Add to your saved items by clicking on the heart icon on any product.', 'your-textdomain'); ?>
    </p>
    <a href="<?php echo esc_url(home_url('/shop')); ?>" class="wishlist-empty-button">
        <?php esc_html_e('Start Shopping', 'your-textdomain'); ?>
    </a>
</div>
