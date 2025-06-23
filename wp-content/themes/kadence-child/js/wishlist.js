document.addEventListener('DOMContentLoaded', function() {
    // Wishlist toggle functionality
    document.body.addEventListener('click', function(e) {
        const wishlistBtn = e.target.closest('.add-to-wishlist');
        const removeBtn = e.target.closest('.remove-from-wishlist');
        
        if (wishlistBtn) {
            const productId = wishlistBtn.dataset.productId;
            toggleWishlistItem(productId);
        }
        
        if (removeBtn) {
            const productItem = removeBtn.closest('.wishlist-product');
            const productId = productItem.dataset.productId;
            toggleWishlistItem(productId);
            productItem.remove();
            
            // Check if wishlist is now empty
            if (!document.querySelector('.wishlist-product')) {
                document.getElementById('wishlist-items').innerHTML = 
                    '<p class="wishlist-empty">You haven\'t saved any items yet.</p>';
            }
        }
    });
    
    function toggleWishlistItem(productId) {
        let wishlist = JSON.parse(localStorage.getItem('twc_wishlist') || '[]');
        const index = wishlist.indexOf(productId);
        
        if (index > -1) {
            wishlist.splice(index, 1);
        } else {
            wishlist.push(productId);
        }
        
        // Update storage
        localStorage.setItem('twc_wishlist', JSON.stringify(wishlist));
        document.cookie = `twc_wishlist=${JSON.stringify(wishlist)}; path=/; max-age=${86400 * 30}; SameSite=Lax`;
        
        // Update UI without full reload if possible
        const allWishlistBtns = document.querySelectorAll(`.add-to-wishlist[data-product-id="${productId}"]`);
        allWishlistBtns.forEach(btn => {
            btn.classList.toggle('in-wishlist', wishlist.includes(productId));
            btn.querySelector('.heart-icon').textContent = 
                wishlist.includes(productId) ? '♥' : '♡';
        });
    }
    
    // Initialize button states
    const wishlist = JSON.parse(localStorage.getItem('twc_wishlist') || '[]');
    wishlist.forEach(id => {
        document.querySelectorAll(`.add-to-wishlist[data-product-id="${id}"]`).forEach(btn => {
            btn.classList.add('in-wishlist');
            btn.querySelector('.heart-icon').textContent = '♥';
        });
    });
});