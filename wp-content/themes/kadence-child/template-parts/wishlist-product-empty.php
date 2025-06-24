<?php
/**
 * Partial: Empty Wishlist State
 */
?>

<div class="wishlist-empty-wrapper">
    <div class="wishlist-empty-content">
        <h2 class="wishlist-empty-title"><?php esc_html_e('My Saved Items', 'your-textdomain'); ?></h2>
        <div class="wishlist-empty-icon">♡</div>
        <p class="wishlist-empty-message">
            <?php esc_html_e('You currently have no saved items.', 'your-textdomain'); ?>
        </p>
        <p class="wishlist-empty-instruction">
            <?php esc_html_e('Add to your saved items by clicking on the heart icon through our website, from the basket or sign in to retrieve your previously saved items.', 'your-textdomain'); ?>
        </p>
        <a href="<?php echo esc_url(home_url('/shop')); ?>" class="wishlist-empty-button">
            <?php esc_html_e('Start Shopping', 'your-textdomain'); ?>
        </a>
    </div>

    <div class="wishlist-empty-benefits">
        <div class="benefit-item">
            <div class="benefit-icon">🚚</div>
            <p class="benefit-title"><?php esc_html_e('Free Standard Delivery', 'your-textdomain'); ?></p>
            <p class="benefit-desc"><?php esc_html_e('On orders over £60', 'your-textdomain'); ?></p>
        </div>
        <div class="benefit-item">
            <div class="benefit-icon">🎁</div>
            <p class="benefit-title"><?php esc_html_e('Premium Gift-Box Service', 'your-textdomain'); ?></p>
            <p class="benefit-desc"><?php esc_html_e('A chic finishing touch', 'your-textdomain'); ?></p>
        </div>
        <div class="benefit-item">
            <div class="benefit-icon">🎀</div>
            <p class="benefit-title"><?php esc_html_e('Gift Cards & E-Gift Cards', 'your-textdomain'); ?></p>
            <p class="benefit-desc"><?php esc_html_e('Give the gift of choice', 'your-textdomain'); ?></p>
        </div>
        <div class="benefit-item">
            <div class="benefit-icon">💬</div>
            <p class="benefit-title"><?php esc_html_e('Live Expert Product Advice', 'your-textdomain'); ?></p>
            <p class="benefit-desc"><?php esc_html_e('Available Monday–Sunday', 'your-textdomain'); ?></p>
        </div>
    </div>
</div>
