document.addEventListener('DOMContentLoaded', function () {
    setTimeout(initializeWishlist, 100);
    setupWishlistObserver();
    document.body.addEventListener('click', handleWishlistInteractions);
});

// Initialize wishlist state and UI
function initializeWishlist() {
    const wishlist = getWishlist();
    updateAllWishlistButtons(wishlist);

    if (isFavouritesPage()) {
        ensureEmptyStateDisplay(wishlist);
    }
}

// Set up mutation observer for dynamic content
function setupWishlistObserver() {
    const wishlistContainer = document.getElementById('wishlist-items');
    if (wishlistContainer) {
        const observer = new MutationObserver(function () {
            updateAllWishlistButtons(getWishlist());
        });
        observer.observe(wishlistContainer, {
            childList: true,
            subtree: true
        });
    }
}

// Handle click events for wishlist buttons
function handleWishlistInteractions(e) {
    const wishlistBtn = e.target.closest('.add-to-wishlist');
    const removeBtn = e.target.closest('.remove-from-wishlist');

    if (!wishlistBtn && !removeBtn) return;

    e.preventDefault();
    const button = wishlistBtn || removeBtn;
    handleWishlistToggle(button);
}

// Core wishlist toggle functionality
async function handleWishlistToggle(button) {
    const productId = button.dataset.productId;
    const wishlist = getWishlist();
    const currentInWishlist = wishlist.includes(productId);

    // Optimistic update
    button.classList.add('loading');
    const newWishlist = currentInWishlist
        ? wishlist.filter(id => id !== productId)
        : [...wishlist, productId];

    updateStorage(newWishlist);
    updateWishlistButton(button, !currentInWishlist);
    updateWishlistCount(newWishlist.length);

    // 🔥 Remove from display immediately on favourites page
    if (isFavouritesPage() && currentInWishlist) {
        removeProductFromDisplay(productId);
    }

    try {
        const response = await fetch(wishlistVars.ajaxurl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'twc_wishlist_toggle',
                product_id: productId,
                security: wishlistVars.nonce,
                is_favourites_page: isFavouritesPage() ? 1 : 0
            })
        });

        const data = await response.json();

        if (!data.success) {
            // Revert changes if server call fails
            updateStorage(wishlist);
            updateWishlistButton(button, currentInWishlist);
            updateWishlistCount(wishlist.length);
            showTemporaryMessage(data.data || 'Server update failed');
        } else if (data.wishlist) {
            updateStorage(data.wishlist);
            updateAllWishlistButtons(data.wishlist);
        }

    } catch (error) {
        console.error('Wishlist Error:', error);
        updateStorage(wishlist);
        updateWishlistButton(button, currentInWishlist);
        updateWishlistCount(wishlist.length);
        showTemporaryMessage(error.message || 'An error occurred. Please try again.');
    } finally {
        button.classList.remove('loading');
    }
}

// Helper Functions

function getWishlist() {
    try {
        const localValue = localStorage.getItem('twc_wishlist');
        if (localValue) return JSON.parse(localValue);

        const cookieValue = document.cookie
            .split('; ')
            .find(row => row.startsWith('twc_wishlist='))
            ?.split('=')[1];

        return cookieValue ? JSON.parse(decodeURIComponent(cookieValue)) : [];
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
        updateWishlistButton(btn, isActive);
    });

    updateWishlistCount(wishlist.length);
}

function updateWishlistButton(button, isActive) {
    button.classList.toggle('in-wishlist', isActive);
    const icon = button.querySelector('.heart-icon');
    if (icon) icon.textContent = isActive ? '♥' : '♡';
}

function updateWishlistCount(count) {
    document.querySelectorAll('.wishlist-count').forEach(el => {
        el.textContent = count;
    });
}

function removeProductFromDisplay(productId) {
    const productElement = document.querySelector(`.wishlist-product[data-product-id="${productId}"]`);
    if (productElement) {
        productElement.style.opacity = '0';
        productElement.style.transform = 'translateX(-20px)';
        setTimeout(() => {
            productElement.remove();
            ensureEmptyStateDisplay(getWishlist());
        }, 300);
    }
}

function ensureEmptyStateDisplay(wishlist) {
    const container = document.getElementById('wishlist-items');
    if (container && wishlist.length === 0 && !container.querySelector('.wishlist-empty')) {
        container.innerHTML = '<p class="wishlist-empty">You haven\'t saved any items yet.</p>';
    }
}

function isFavouritesPage() {
    return document.body.classList.contains('page-template-page-wishlist');
}

function showTemporaryMessage(message) {
    const msgElement = document.createElement('div');
    msgElement.className = 'wishlist-message';
    msgElement.textContent = message;
    document.body.appendChild(msgElement);

    setTimeout(() => {
        msgElement.classList.add('fade-out');
        setTimeout(() => msgElement.remove(), 500);
    }, 3000);
}
