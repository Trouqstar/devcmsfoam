jQuery(function($) {
  $(document.body).on('added_to_cart', function(event, fragments, cart_hash, $button) {
    var $wrapper = $button.closest('.action-button-wrap');
    $button.hide();
    $wrapper.find('.added_to_cart').fadeIn();
  });
});
