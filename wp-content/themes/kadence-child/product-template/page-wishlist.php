<?php
/**
 * Template Name: Favourites
 */

get_header();
?>

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
