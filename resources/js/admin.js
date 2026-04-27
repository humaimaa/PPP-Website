// resources/js/admin.js

document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const body = document.body;
    const STORAGE_KEY = 'sidebar_state';

    // ─── Sidebar State ───────────────────────────────────────────────────────

    function isSidebarOpen() {
        return body.classList.contains('sidebar-open');
    }

    function getSavedState() {
        return localStorage.getItem(STORAGE_KEY) === 'open';
    }

    function updateSidebarUI(open) {
        const isMobile = window.innerWidth < 768;

        if (isMobile) {
            sidebar.style.width = '280px';
            sidebar.style.transform = open ? 'translateX(0)' : 'translateX(-100%)';
            sidebarOverlay?.classList.toggle('hidden', !open);
            body.style.overflow = open ? 'hidden' : '';
        } else {
            sidebar.style.width = open ? '256px' : '72px';
            sidebar.style.transform = '';
            sidebarOverlay?.classList.add('hidden');
            body.style.overflow = '';
        }

        body.classList.toggle('sidebar-open', open);

        // Logo text
        const logoText = sidebar?.querySelector('.logo-text');
        if (logoText) {
            logoText.style.opacity = open ? '1' : '0';
            logoText.style.maxWidth = open ? '200px' : '0';
        }

        // Nav texts
        sidebar?.querySelectorAll('.nav-text').forEach(el => {
            el.style.opacity = open ? '1' : '0';
            el.style.maxWidth = open ? '200px' : '0';
        });

        // Dropdown chevron icons
        sidebar?.querySelectorAll('.dropdown-icon').forEach(el => {
            el.style.opacity = open ? '1' : '0';
        });

        // Tooltips — show only when sidebar is closed
        sidebar?.querySelectorAll('[data-dropdown] button > span:last-child, .nav-item > span:last-child').forEach(el => {
            el.classList.toggle('hidden', open);
        });

        // Close all dropdowns when collapsing sidebar
        if (!open) closeAllDropdowns();

        localStorage.setItem(STORAGE_KEY, open ? 'open' : 'closed');
    }

    function openSidebar() { updateSidebarUI(true); }
    function closeSidebar() { updateSidebarUI(false); }
    function toggleSidebar() { updateSidebarUI(!isSidebarOpen()); }

    // ─── Dropdowns ───────────────────────────────────────────────────────────
    //
    // KEY FIX: We use [data-dropdown] on the wrapper div and find
    // .dropdown-content *within* that wrapper — not via nextElementSibling,
    // which broke when the tooltip <span> was inserted between the button
    // and the dropdown-content div.

    function getDropdownContent(btn) {
        return btn.closest('[data-dropdown]')?.querySelector('.dropdown-content') ?? null;
    }

    function openDropdown(btn) {
        const content = getDropdownContent(btn);
        const icon = btn.querySelector('.dropdown-icon');
        if (!content || !content.classList.contains('hidden')) return;

        content.classList.remove('hidden');
        // Animate height
        content.style.maxHeight = '0';
        content.style.overflow = 'hidden';
        content.style.transition = 'max-height 0.3s ease';
        // Force reflow then expand
        requestAnimationFrame(() => {
            content.style.maxHeight = content.scrollHeight + 'px';
        });
        content.dataset.open = 'true';
        if (icon) icon.style.transform = 'rotate(180deg)';
    }

    function closeDropdown(btn) {
        const content = getDropdownContent(btn);
        const icon = btn.querySelector('.dropdown-icon');
        if (!content || content.classList.contains('hidden')) return;

        content.style.maxHeight = '0';
        content.dataset.open = '';
        if (icon) icon.style.transform = 'rotate(0deg)';

        // After transition, hide with display:none (Tailwind hidden)
        setTimeout(() => {
            if (!content.dataset.open) {
                content.classList.add('hidden');
                content.style.maxHeight = '';
            }
        }, 300);
    }

    function closeAllDropdowns() {
        document.querySelectorAll('[data-dropdown] .dropdown-btn').forEach(closeDropdown);
    }

    function closeOtherDropdowns(currentBtn) {
        document.querySelectorAll('[data-dropdown] .dropdown-btn').forEach(btn => {
            if (btn !== currentBtn) closeDropdown(btn);
        });
    }

    function initDropdowns() {
        document.querySelectorAll('[data-dropdown] .dropdown-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                // If sidebar is collapsed, open it first then show dropdown
                if (!isSidebarOpen()) {
                    openSidebar();
                    setTimeout(() => {
                        closeOtherDropdowns(this);
                        openDropdown(this);
                    }, 320);
                    return;
                }

                const content = getDropdownContent(this);
                if (content && !content.classList.contains('hidden') && content.dataset.open) {
                    closeDropdown(this);
                } else {
                    closeOtherDropdowns(this);
                    openDropdown(this);
                }
            });
        });

        // Close dropdowns when clicking outside the sidebar
        document.addEventListener('click', function (e) {
            if (!e.target.closest('#sidebar')) {
                closeAllDropdowns();
            }
        });
    }

    // ─── User Dropdown ───────────────────────────────────────────────────────

    function initUserDropdown() {
        const userMenuBtn = document.getElementById('userMenuButton');
        const userDropdown = document.getElementById('userDropdown');
        if (!userMenuBtn || !userDropdown) return;

        const chevron = userMenuBtn.querySelector('.fa-chevron-down');

        userMenuBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            const hidden = userDropdown.classList.toggle('hidden');
            if (chevron) chevron.style.transform = hidden ? 'rotate(0deg)' : 'rotate(180deg)';
        });

        document.addEventListener('click', function (e) {
            if (!userMenuBtn.contains(e.target)) {
                userDropdown.classList.add('hidden');
                if (chevron) chevron.style.transform = 'rotate(0deg)';
            }
        });
    }

    // ─── Active Nav Highlighting ──────────────────────────────────────────────

    function initActiveNav() {
        const currentPath = window.location.pathname;
        document.querySelectorAll('nav a[href]').forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('bg-emerald-700');
                // Auto-open parent dropdown
                const parentContent = link.closest('.dropdown-content');
                if (parentContent) {
                    const btn = parentContent.closest('[data-dropdown]')?.querySelector('.dropdown-btn');
                    if (btn) openDropdown(btn);
                }
            }
        });
    }

    // ─── Toggle Button ───────────────────────────────────────────────────────

    toggleBtn?.addEventListener('click', function (e) {
        e.stopPropagation();
        toggleSidebar();
    });

    sidebarOverlay?.addEventListener('click', closeSidebar);

    // ─── Resize Handling ─────────────────────────────────────────────────────

    let resizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            updateSidebarUI(isSidebarOpen());
            // Recalculate open dropdown heights
            document.querySelectorAll('.dropdown-content:not(.hidden)').forEach(content => {
                content.style.maxHeight = content.scrollHeight + 'px';
            });
        }, 100);
    });

    // ─── Init ─────────────────────────────────────────────────────────────────

    updateSidebarUI(getSavedState());
    initDropdowns();
    initUserDropdown();
    initActiveNav();
});