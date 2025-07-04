document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.auth-tab');
    const sections = document.querySelectorAll('.auth-section');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            sections.forEach(s => s.style.display = 'none');

            tab.classList.add('active');
            document.getElementById('auth-' + tab.dataset.tab).style.display = 'block';
        });
    });

    // Set default tab to login
    if (tabs.length > 0) {
        tabs[0].click();
    }
});
