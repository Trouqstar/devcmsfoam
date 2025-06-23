document.addEventListener('DOMContentLoaded', function() {
    // 1. Initialize from storage
    const wishlist = getWishlist();
    updateAllWishlistButtons(wishlist);

    // 2. Handle all wishlist interactions
    document.body.addEventListener('click', async function(e) {
        const wishlistBtn = e.target.closest('.add-to-wishlist');
        const removeBtn = e.target.closest('.remove-from-wishlist');
        
        if (!wishlistBtn && !removeBtn) return;
        
        const button = wishlistBtn || removeBtn;
        const productId = button.dataset.productId;
        const isFavouritesPage = document.body.classList.contains('page-template-page-wishlist');
        
        button.classList.add('loading');

        try {
            // Optimistic update
            const currentInWishlist = wishlist.includes(productId);
            const newWishlist = currentInWishlist
                ? wishlist.filter(id => id !== productId)
                : [...wishlist, productId];
            
            updateStorage(newWishlist);
            updateAllWishlistButtons(newWishlist);
            
            // Sync with server
            const response = await fetch(wishlistVars.ajaxurl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'twc_wishlist_toggle',
                    product_id: productId,
                    security: wishlistVars.nonce,
                    is_favourites_page: isFavouritesPage ? 1 : 0
                })
            });
            
            const data = await response.json();
            
            if (!data.success) {
                // Revert if server failed
                updateStorage(wishlist);
                updateAllWishlistButtons(wishlist);
                throw new Error('Server update failed');
            }
            
            // Special handling for favourites page
            if (isFavouritesPage && currentInWishlist) {
                removeProductFromDisplay(productId);
            }
            
        } catch (error) {
            console.error('Error:', error);
        } finally {
            button.classList.remove('loading');
        }
    });

    // Helper functions
    function getWishlist() {
        try {
            const cookieValue = document.cookie
                .split('; ')
                .find(row => row.startsWith('twc_wishlist='))
                ?.split('=')[1];
            
            return cookieValue 
                ? JSON.parse(decodeURIComponent(cookieValue)) 
                : JSON.parse(localStorage.getItem('twc_wishlist') || '[]');
        } catch (e) {
            console.error('Error reading wishlist:', e);
            return [];
        }
    }

    function updateStorage(wishlist) {
        localStorage.setItem('twc_wishlist', JSON.stringify(wishlist));
        document.cookie = `twc_wishlist=${JSON.stringify(wishlist)}; path=/; max-age=${86400 * 30}; SameSite=Lax`;
    }

    function updateAllWishlistButtons(wishlist) {
        document.querySelectorAll('.add-to-wishlist').forEach(btn => {
            const productId = btn.dataset.productId;
            const isActive = wishlist.includes(productId);
            btn.classList.toggle('active', isActive);
            btn.querySelector('.heart-icon').textContent = isActive ? '♥' : '♡';
        });
        
        // Update counter
        const counters = document.querySelectorAll('.wishlist-count');
        counters.forEach(c => c.textContent = wishlist.length);
    }

    function removeProductFromDisplay(productId) {
        const productElement = document.querySelector(`.wishlist-product[data-product-id="${productId}"]`);
        if (productElement) {
            productElement.style.transition = 'opacity 0.3s, transform 0.3s';
            productElement.style.opacity = '0';
            productElement.style.transform = 'translateX(-20px)';
            
            setTimeout(() => {
                productElement.remove();
                
                // Show empty message if needed
                if (!document.querySelector('.wishlist-product')) {
                    document.getElementById('wishlist-items').innerHTML = 
                        '<p class="wishlist-empty">You haven\'t saved any items yet.</p>';
                }
            }, 300);
        }
    }
});