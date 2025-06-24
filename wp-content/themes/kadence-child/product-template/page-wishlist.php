<?php
/**
 * Template Name: Favourites
 */

get_header();
?>

<template id="wishlist-empty-template">
    <div class="wishlist-empty-state">
        <h2 class="wishlist-empty-title">My Saved Items</h2>
        <div class="wishlist-empty-icon">♡</div>
        <p class="wishlist-empty-message">You currently have no saved items.</p>
        <p class="wishlist-empty-instruction">
            Add to your saved items by clicking on the heart icon on any product.
        </p>
        <a href="/cart" class="wishlist-empty-button">Start Shopping</a>
    </div>
</template>

<main id="primary" class="site-main wishlist-page">

    <header class="wishlist-header">
        <h1 class="page-title"><?php the_title(); ?></h1>
    </header>

    <section id="wishlist-items" class="products-grid">
        <?php display_wishlist_products(); ?>
    </section>

</main>

<?php
get_footer();
