jQuery(function($) {
    $(document).on('click', '.custom-add-to-cart-btn', function(e) {
        e.preventDefault();

        const $btn = $(this);
        const pid = $btn.data('product-id');
        const vid = $btn.data('variation-id') || 0;
        const qty = $btn.data('quantity') || 1;

        $.post(custom_ajax_cart.ajax_url, {
            action: 'custom_ajax_add_to_cart',
            pid: pid,
            vid: vid,
            qty: qty
        }, function(response) {
            if (response.success) {
                $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $btn]);
                alert('✅ Product added to cart!');
            } else {
                alert('⚠️ Failed to add product: ' + response.data);
            }
        });
    });
});
