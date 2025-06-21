document.addEventListener('DOMContentLoaded', function () {
    if (typeof twcMenuData === 'undefined' || !twcMenuData.length) return;

    const navContainer = document.querySelector('.twc-primary-nav-wrapper');
    if (!navContainer) return;

    // Build the menu
    const menuHTML = buildMenuHTML(twcMenuData);
    navContainer.innerHTML = `<ul class="twc-primary-nav">${menuHTML}</ul>`;

    // Initialize submenu toggles
    initSubmenuToggles();
});

function buildMenuHTML(menuData, parentId = '0', level = 0) {
    return menuData
        .filter(item => String(item.menu_item_parent) === String(parentId))
        .map(item => {
            const hasChildren = menuData.some(child => String(child.menu_item_parent) === String(item.ID));
            const childrenHTML = hasChildren ? buildMenuHTML(menuData, item.ID, level + 1) : '';
            const hasImage = !!item.image;

            // Determine submenu class based on level
            const subMenuClass = level === 0 ? 'sub-menu' : `sub-menu sub-menu--level-${level}`;

            return `
                <li class="menu-item ${hasChildren ? 'has-submenu' : ''}" data-item-id="${item.ID}">
                    <a href="${item.url}">${item.title}</a>
                    ${hasChildren ? `
                        <!--
                        <button class="submenu-toggle" aria-expanded="false">
                            <span class="screen-reader-text">Toggle submenu</span>
                        </button>
                        -->
                        <div class="${subMenuClass}">
                            <ul class="sub-menu-list">
                                ${childrenHTML}
                            </ul>
                            ${hasImage ? `
                                <div class="sub-menu-image-panel">
                                    <img src="${item.image}" alt="${item.title}">
                                    <div class="image-panel-textbox">${item.image_text || ''}</div>
                                </div>
                            ` : ''}
                        </div>
                    ` : ''}
                </li>
            `;
        })
        .join('');
}

// Initialize submenu toggles
function initSubmenuToggles() {
    document.querySelectorAll('.submenu-toggle').forEach(toggle => {
        toggle.addEventListener('click', function () {
            const expanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !expanded);
            this.nextElementSibling.classList.toggle('visible');
        });
    });
}


// Optional: Handle resize debounce
function debounce(fn, wait) {
    let timeout;
    return function () {
        clearTimeout(timeout);
        timeout = setTimeout(fn, wait);
    };
}
window.addEventListener('resize', debounce(function () {
    // Responsive handling if needed
}, 100));
