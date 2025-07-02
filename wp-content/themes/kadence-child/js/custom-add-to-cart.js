jQuery(function($) {
  $(document.body).on('added_to_cart', function(event, fragments, cart_hash, $button) {
    var $wrapper = $button.closest('.action-button-wrap');
    $button.hide();
    $wrapper.find('.added_to_cart').fadeIn();
    $button.addClass('added');
  });

  $(document).ready(function() {
    $('.action-button-wrap').each(function() {
      var $wrap = $(this);
      var $btn = $wrap.find('.custom-add-to-cart-btn, .add_to_cart_button');
      
      if ($btn.hasClass('added')) {
        $btn.hide();
        $wrap.find('.added_to_cart').show();
      }
    });
  });
});
