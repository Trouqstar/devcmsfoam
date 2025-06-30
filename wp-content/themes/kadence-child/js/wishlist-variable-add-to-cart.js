jQuery(function($) {
  // Handle clicking the cart icon on variable product
  $('.wishlist-product .cart-icon').on('click', function(e) {
    var $wrap = $(this).closest('.wishlist-product');
    var $form = $wrap.find('.variations_form');

    // Only for variable products
    if ($form.length) {
      e.preventDefault();

      // Hide main content, show variation form
      $wrap.find('.wishlist-product-content').hide();
      $wrap.find('.product-action-wrap').addClass('show-variation-form');
    }
  });

  // After variable product is added to cart
  $(document.body).on('added_to_cart', function(event, fragments, cart_hash, $button) {
    var $wrap = $button.closest('.wishlist-product');

    // Hide form, restore product card layout
    $wrap.find('.product-action-wrap').removeClass('show-variation-form');
    $wrap.find('.wishlist-product-content').fadeIn();

    // Update UI
    $button.hide();
    $wrap.find('.added_to_cart').fadeIn();
    $wrap.find('.cart-icon').addClass('added');
  });
});
