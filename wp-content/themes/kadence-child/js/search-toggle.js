document.addEventListener('DOMContentLoaded', function () {
    const wrapper = document.querySelector('.header-search');
    const toggle = wrapper?.querySelector('.search-toggle');
    const icon = toggle?.querySelector('.material-symbols-outlined');
    const input = wrapper?.querySelector('.search-field');

    if (!wrapper || !toggle || !icon) return;

    toggle.addEventListener('click', function (e) {
        e.preventDefault();

        const isActive = wrapper.classList.contains('active');
        wrapper.classList.toggle('active');
        icon.textContent = isActive ? 'search' : 'close';

        if (!isActive && input) {
            input.focus();
        } else if (input) {
            input.value = '';
        }
    });
});
