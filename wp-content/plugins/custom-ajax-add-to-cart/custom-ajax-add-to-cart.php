<?php
/*
Plugin Name: Custom AJAX Add to Cart
Description: A simplified variation product add-to-cart handler using AJAX for shop/archive pages.
Version: 1.0
Author: Your Name
*/

defined('ABSPATH') || exit;

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script(
        'custom-ajax-cart',
        plugin_dir_url(__FILE__) . 'assets/js/custom-ajax-cart.js',
        ['jquery'],
        null,
        true
    );

    wp_localize_script('custom-ajax-cart', 'custom_ajax_cart', [
        'ajax_url' => admin_url('admin-ajax.php')
    ]);
});

add_action('wp_ajax_custom_ajax_add_to_cart', 'custom_ajax_add_to_cart_handler');
add_action('wp_ajax_nopriv_custom_ajax_add_to_cart', 'custom_ajax_add_to_cart_handler');

function custom_ajax_add_to_cart_handler() {
    if (!isset($_POST['pid']) || !isset($_POST['qty'])) {
        wp_send_json_error('Missing parameters.');
    }

    $product_id = intval($_POST['pid']);
    $variation_id = isset($_POST['vid']) ? intval($_POST['vid']) : 0;
    $quantity = max(1, intval($_POST['qty']));

    if ($variation_id > 0) {
        $result = WC()->cart->add_to_cart($product_id, $quantity, $variation_id);
    } else {
        $result = WC()->cart->add_to_cart($product_id, $quantity);
    }

    if ($result) {
        WC_AJAX::get_refreshed_fragments();
    } else {
        wp_send_json_error('Failed to add product to cart.');
    }

    wp_die();
}
?>
