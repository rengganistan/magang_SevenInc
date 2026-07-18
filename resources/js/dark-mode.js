document.addEventListener('DOMContentLoaded', function () {

    const themeToggleDarkIcon  = document.getElementById('theme-toggle-dark-icon');
    const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
    const themeToggleBtn       = document.getElementById('theme-toggle');

    if (!themeToggleBtn || !themeToggleDarkIcon || !themeToggleLightIcon) return;

    // Set icon visibility based on current theme
    function syncIcons() {
        const isDark = document.documentElement.classList.contains('dark');
        if (isDark) {
            // Dark mode aktif → tampilkan ikon matahari (untuk switch ke light)
            themeToggleLightIcon.classList.remove('hidden');
            themeToggleDarkIcon.classList.add('hidden');
        } else {
            // Light mode aktif → tampilkan ikon bulan (untuk switch ke dark)
            themeToggleDarkIcon.classList.remove('hidden');
            themeToggleLightIcon.classList.add('hidden');
        }
    }

    syncIcons();

    themeToggleBtn.addEventListener('click', function () {
        const isDark = document.documentElement.classList.contains('dark');

        if (isDark) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        }

        syncIcons();
        document.dispatchEvent(new CustomEvent('dark-mode'));
    });

});
