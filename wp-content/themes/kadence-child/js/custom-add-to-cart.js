jQuery(function($) {
    $(document.body).on('added_to_cart', function(event, fragments, cart_hash, $button) {
        // Find the wrapper based on the button's position
        var $wrapper = $button.closest('.action-button-wrap');
        $button.hide();
        $wrapper.find('.added_to_cart').fadeIn();
        
        // Update the button class if needed
        $button.addClass('added');
    });
    
    // You might also want to add this to handle initial page load for items already in cart
    $(document).ready(function() {
        $('.action-button-wrap').each(function() {
            var $wrap = $(this);
            if ($wrap.find('.add_to_cart_button').hasClass('added')) {
                $wrap.find('.add_to_cart_button').hide();
                $wrap.find('.added_to_cart').show();
            }
        });
    });
});