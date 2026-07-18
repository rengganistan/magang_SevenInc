document.addEventListener('DOMContentLoaded', function () {

    const sidebar                    = document.getElementById('sidebar');
    const sidebarBackdrop            = document.getElementById('sidebarBackdrop');
    const toggleSidebarMobileEl      = document.getElementById('toggleSidebarMobile');
    const toggleSidebarMobileHamburger = document.getElementById('toggleSidebarMobileHamburger');
    const toggleSidebarMobileClose   = document.getElementById('toggleSidebarMobileClose');

    if (!sidebar) return;

    // ── Sidebar toggle ───────────────────────────────────────────
    function openSidebar() {
        sidebar.classList.remove('hidden');
        sidebarBackdrop.classList.remove('hidden');
        toggleSidebarMobileHamburger.classList.add('hidden');
        toggleSidebarMobileClose.classList.remove('hidden');
    }

    function closeSidebar() {
        sidebar.classList.add('hidden');
        sidebarBackdrop.classList.add('hidden');
        toggleSidebarMobileHamburger.classList.remove('hidden');
        toggleSidebarMobileClose.classList.add('hidden');
    }

    function toggleSidebar() {
        if (sidebar.classList.contains('hidden')) {
            openSidebar();
        } else {
            closeSidebar();
        }
    }

    if (toggleSidebarMobileEl) {
        toggleSidebarMobileEl.addEventListener('click', toggleSidebar);
    }

    if (sidebarBackdrop) {
        sidebarBackdrop.addEventListener('click', closeSidebar);
    }

    // Close sidebar when a menu link is clicked on mobile
    sidebar.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            if (window.innerWidth < 1024) {
                closeSidebar();
            }
        });
    });

    // Close sidebar on resize to desktop
    window.addEventListener('resize', function () {
        if (window.innerWidth >= 1024) {
            sidebar.classList.remove('hidden');
            sidebarBackdrop.classList.add('hidden');
        }
    });

});
