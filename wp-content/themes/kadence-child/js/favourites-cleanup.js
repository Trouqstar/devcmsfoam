document.addEventListener('DOMContentLoaded', () => {
    if (!isFavouritesPage()) return;

    document.body.addEventListener('click', e => {
        const btn = e.target.closest('.add-to-wishlist');

        if (!btn) return;

        const productId = btn.dataset.productId;
        if (!productId) return;

        // Remove product from DOM
        const productElement = document.querySelector(`.wishlist-product[data-product-id="${productId}"]`);
        if (productElement) {
            productElement.style.opacity = '0';
            productElement.style.transform = 'translateX(-20px)';
            setTimeout(() => {
                productElement.remove();
                checkIfWishlistIsEmpty();
            }, 300);
        }
    });

    function checkIfWishlistIsEmpty() {
        const items = document.querySelectorAll('.wishlist-product');
        const container = document.getElementById('wishlist-items');
        if (items.length === 0 && container && !container.querySelector('.wishlist-empty')) {
            container.innerHTML = '<p class="wishlist-empty">You haven\'t saved any items yet.</p>';
        }
    }

    function isFavouritesPage() {
        return document.body.classList.contains('page-template-page-wishlist');
    }
});
