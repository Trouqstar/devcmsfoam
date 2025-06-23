<?php
/**
 * Template Name: Wishlist
 * Description: Displays the user's saved wishlist items
 */

get_header(); ?>

<div class="wishlist-page container">
    <h1 class="page-title"><?php the_title(); ?></h1>
    
    <div id="wishlist-items" class="products-grid">
        <?php
        if (function_exists('display_wishlist_products')) {
            display_wishlist_products();
        } else {
            echo '<p class="wishlist-empty">Wishlist functionality is currently unavailable.</p>';
        }
        ?>
    </div>
</div>

<?php get_footer(); ?>