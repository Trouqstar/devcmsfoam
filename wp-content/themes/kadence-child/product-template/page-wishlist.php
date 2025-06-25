<?php
/**
 * Template Name: Favourites
 */

get_header();
?>

<template id="wishlist-empty-template">
    <?php
    ob_start();
    get_template_part('template-parts/wishlist-product-empty');
    echo ob_get_clean();
    ?>
</template>

<main id="primary" class="site-main wishlist-page">
    <div class="wishlist-info-banner-container">
        <div class="wishlist-info-banner">
            <p><span class="info-icon">ℹ️</span>
                <?php esc_html_e('We will keep your saved items for 14 days. Sign in or register to ensure your saved items are always available.', 'your-textdomain'); ?>
            </p>
            <button class="wishlist-share-button"><?php esc_html_e('Share', 'your-textdomain'); ?></button>
        </div>
    </div>

    <div class="bbc">
        <h1 class="wishlist-title"><?php esc_html_e('Your Wishlist', 'your-textdomain'); ?></h1>
        <p class="wishlist-description"><?php esc_html_e('Here are your saved items. You can share your wishlist with friends or keep it for later.', 'your-textdomain'); ?></p>
    </div>    

    <section id="wishlist-items" class="wishlist-products-gridwish">
        <?php display_wishlist_products(); ?>
    </section>
</main>

<?php get_footer(); ?>
