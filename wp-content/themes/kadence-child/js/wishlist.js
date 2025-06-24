document.addEventListener('DOMContentLoaded', function () {
    // Initialize from cookie/localStorage
    const wishlist = getWishlist();
    updateAllWishlistButtons(wishlist);

    // Wishlist button click handler
    document.body.addEventListener('click', async function (e) {
        const wishlistBtn = e.target.closest('.add-to-wishlist');
        const removeBtn = e.target.closest('.remove-from-wishlist');
        if (!wishlistBtn && !removeBtn) return;

        const button = wishlistBtn || removeBtn;
        const productId = button.dataset.productId;
        const isFavouritesPage = document.body.classList.contains('page-template-page-wishlist');

        button.classList.add('loading');

        try {
            const currentInWishlist = wishlist.includes(productId);
            const newWishlist = currentInWishlist
                ? wishlist.filter(id => id !== productId)
                : [...wishlist, productId];

            updateStorage(newWishlist);
            updateAllWishlistButtons(newWishlist);

            const response = await fetch(wishlistVars.ajaxurl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    action: 'twc_wishlist_toggle',
                    product_id: productId,
                    security: wishlistVars.nonce,
                    is_favourites_page: isFavouritesPage ? 1 : 0
                })
            });

            const data = await response.json();

            if (!data.success) {
                updateStorage(wishlist);
                updateAllWishlistButtons(wishlist);
                throw new Error('Server update failed');
            }

            // Remove product visually if we're on the favourites page and it was unfavourited
            if (isFavouritesPage && currentInWishlist) {
                removeProductFromDisplay(productId);
            }

        } catch (error) {
            console.error('Wishlist error:', error);
        } finally {
            button.classList.remove('loading');
        }
    });

    // Helpers
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
            btn.setAttribute('aria-pressed', isActive);
            btn.querySelector('.heart-icon').textContent = isActive ? '♥' : '♡'; // You can switch to a class if preferred
        });

        document.querySelectorAll('.wishlist-count').forEach(el => {
            el.textContent = wishlist.length;
        });
    }

    function removeProductFromDisplay(productId) {
        const productElement = document.querySelector(`.wishlist-product[data-product-id="${productId}"]`);
        if (!productElement) return;

        productElement.style.transition = 'opacity 0.3s, transform 0.3s';
        productElement.style.opacity = '0';
        productElement.style.transform = 'translateX(-20px)';

        setTimeout(() => {
            productElement.remove();

            if (!document.querySelector('.wishlist-product')) {
                const container = document.getElementById('wishlist-items');
                const template = document.getElementById('wishlist-empty-template');

                if (container && template) {
                    container.innerHTML = '';
                    container.appendChild(template.content.cloneNode(true));
                }
            }
        }, 300);
    }
});
