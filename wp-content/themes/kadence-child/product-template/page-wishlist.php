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
    $template_output = ob_get_clean();
    echo $template_output;
    ?>
</template>

<main id="primary" class="site-main wishlist-page">

    <header class="wishlist-header">
    </header>

    <section id="wishlist-items" class="products-grid">
        <?php display_wishlist_products(); ?>
    </section>

</main>

<?php
get_footer();
