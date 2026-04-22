// resources/js/admin.js
document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const mainHeader = document.getElementById('mainHeader');
    const body = document.body;
    
    // Storage key
    const STORAGE_KEY = 'sidebar_state';
    
    // Helper: Get current sidebar state (true = open)
    function getSidebarState() {
        const savedState = localStorage.getItem(STORAGE_KEY);
        if (savedState !== null) {
            return savedState === 'open';
        }
        // Default: closed
        return false;
    }
    
    // Helper: Update all UI elements based on sidebar state
    function updateSidebarUI(isOpen) {
        // Update sidebar width
        if (sidebar) {
            sidebar.style.width = isOpen ? '256px' : '72px';
            
            // Handle mobile transform
            if (window.innerWidth < 768) {
                if (isOpen) {
                    sidebar.style.transform = 'translateX(0)';
                    if (sidebarOverlay) sidebarOverlay.classList.remove('hidden');
                } else {
                    sidebar.style.transform = 'translateX(-100%)';
                    if (sidebarOverlay) sidebarOverlay.classList.add('hidden');
                }
            } else {
                sidebar.style.transform = '';
                if (sidebarOverlay) sidebarOverlay.classList.add('hidden');
            }
        }
        
        // Update body class for CSS targeting
        if (isOpen) {
            body.classList.add('sidebar-open');
        } else {
            body.classList.remove('sidebar-open');
        }
        
        // Update logo text visibility
        const logoText = sidebar?.querySelector('.logo-text');
        if (logoText) {
            logoText.style.opacity = isOpen ? '1' : '0';
            logoText.style.width = isOpen ? 'auto' : '0';
        }
        
        // Update all nav-text elements
        const navTexts = sidebar?.querySelectorAll('.nav-text');
        navTexts?.forEach(text => {
            text.style.opacity = isOpen ? '1' : '0';
            text.style.width = isOpen ? 'auto' : '0';
        });
        
        // Update dropdown icons visibility
        const dropdownIcons = sidebar?.querySelectorAll('.dropdown-icon');
        dropdownIcons?.forEach(icon => {
            icon.style.opacity = isOpen ? '1' : '0';
        });
        
        // Handle dropdown contents
        const dropdownContents = sidebar?.querySelectorAll('.dropdown-content');
        dropdownContents?.forEach(content => {
            if (isOpen) {
                content.style.display = '';
                if (content.classList.contains('open')) {
                    content.style.maxHeight = content.scrollHeight + 'px';
                }
            } else {
                content.style.display = 'none';
                content.style.maxHeight = '0';
            }
        });
        
        // Update pending badge visibility
        const pendingBadge = sidebar?.querySelector('.pending-badge');
        if (pendingBadge) {
            if (isOpen) {
                pendingBadge.classList.remove('hidden');
            } else {
                pendingBadge.classList.add('hidden');
            }
        }
        
        // Save state to localStorage
        localStorage.setItem(STORAGE_KEY, isOpen ? 'open' : 'closed');
    }
    
    // Toggle sidebar function
    function toggleSidebar() {
        const currentState = body.classList.contains('sidebar-open');
        updateSidebarUI(!currentState);
    }
    
    // Open sidebar function
    function openSidebar() {
        if (!body.classList.contains('sidebar-open')) {
            updateSidebarUI(true);
        }
    }
    
    // Close sidebar function
    function closeSidebar() {
        if (body.classList.contains('sidebar-open')) {
            updateSidebarUI(false);
        }
    }
    
    // Initialize sidebar
    function initSidebar() {
        const savedState = getSidebarState();
        updateSidebarUI(savedState);
    }
    
    // Dropdown functionality
    function initDropdowns() {
        const dropdownBtns = document.querySelectorAll('.dropdown-btn');
        
        function closeAllDropdowns() {
            document.querySelectorAll('.dropdown-content').forEach(content => {
                content.style.maxHeight = null;
                content.classList.remove('open');
            });
            document.querySelectorAll('.dropdown-icon').forEach(icon => {
                icon.style.transform = 'rotate(0deg)';
            });
        }
        
        function closeOtherDropdowns(currentBtn) {
            dropdownBtns.forEach(btn => {
                if (btn !== currentBtn) {
                    const content = btn.nextElementSibling;
                    const icon = btn.querySelector('.dropdown-icon');
                    if (content && content.style.maxHeight) {
                        content.style.maxHeight = null;
                        content.classList.remove('open');
                        if (icon) icon.style.transform = 'rotate(0deg)';
                    }
                }
            });
        }
        
        dropdownBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const isSidebarOpen = body.classList.contains('sidebar-open');
                if (!isSidebarOpen) {
                    openSidebar();
                    setTimeout(() => {
                        const content = this.nextElementSibling;
                        const icon = this.querySelector('.dropdown-icon');
                        if (content && content.style.maxHeight !== content.scrollHeight + 'px') {
                            closeOtherDropdowns(this);
                            content.style.maxHeight = content.scrollHeight + 'px';
                            content.classList.add('open');
                            if (icon) icon.style.transform = 'rotate(180deg)';
                        }
                    }, 300);
                    return;
                }
                
                const dropdownContent = this.nextElementSibling;
                const icon = this.querySelector('.dropdown-icon');
                
                closeOtherDropdowns(this);
                
                if (dropdownContent.style.maxHeight && dropdownContent.style.maxHeight !== '0px') {
                    dropdownContent.style.maxHeight = null;
                    dropdownContent.classList.remove('open');
                    if (icon) icon.style.transform = 'rotate(0deg)';
                } else {
                    dropdownContent.style.maxHeight = dropdownContent.scrollHeight + 'px';
                    dropdownContent.classList.add('open');
                    if (icon) icon.style.transform = 'rotate(180deg)';
                }
            });
        });
        
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown-btn')) {
                closeAllDropdowns();
            }
        });
    }
    
    // Handle nav-item clicks
    function initNavItems() {
        const navItems = document.querySelectorAll('.nav-item');
        navItems.forEach(item => {
            item.addEventListener('click', function(e) {
                const isSidebarOpen = body.classList.contains('sidebar-open');
                if (!isSidebarOpen && !this.classList.contains('dropdown-btn')) {
                    e.preventDefault();
                    openSidebar();
                    const href = this.getAttribute('href');
                    if (href && href !== '#') {
                        setTimeout(() => {
                            window.location.href = href;
                        }, 300);
                    }
                }
            });
        });
    }
    
    // User dropdown functionality
    function initUserDropdown() {
        const userMenuBtn = document.getElementById('userMenuButton');
        const userDropdown = document.getElementById('userDropdown');
        let dropdownIcon = null;
        
        if (userMenuBtn) {
            dropdownIcon = userMenuBtn.querySelector('.fa-chevron-down');
            
            userMenuBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                userDropdown.classList.toggle('hidden');
                if (dropdownIcon) {
                    dropdownIcon.style.transform = userDropdown.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
                }
            });
        }
        
        document.addEventListener('click', (e) => {
            if (userMenuBtn && userDropdown && !userMenuBtn.contains(e.target)) {
                if (!userDropdown.classList.contains('hidden')) {
                    userDropdown.classList.add('hidden');
                    if (dropdownIcon) dropdownIcon.style.transform = 'rotate(0deg)';
                }
            }
        });
    }
    
    // Active navigation highlighting
    function initActiveNav() {
        const currentPath = window.location.pathname;
        document.querySelectorAll('nav a[href]').forEach(link => {
            const linkPath = link.getAttribute('href');
            if (linkPath && linkPath !== '#' && currentPath === linkPath) {
                document.querySelectorAll('nav a').forEach(l => l.classList.remove('bg-emerald-700'));
                link.classList.add('bg-emerald-700');
            }
        });
    }
    
    // Event Listeners
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleSidebar();
        });
    }
    
    // Close sidebar when clicking overlay on mobile
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function(e) {
            e.preventDefault();
            closeSidebar();
        });
    }
    
    // Initialize all components
    initSidebar();
    initDropdowns();
    initNavItems();
    initUserDropdown();
    initActiveNav();
    
    // Handle window resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            // Recalculate dropdown heights
            const openDropdowns = document.querySelectorAll('.dropdown-content.open');
            openDropdowns.forEach(content => {
                content.style.maxHeight = content.scrollHeight + 'px';
            });
            
            // Update sidebar for current screen size
            const isOpen = body.classList.contains('sidebar-open');
            if (sidebar) {
                if (window.innerWidth < 768) {
                    if (isOpen) {
                        sidebar.style.transform = 'translateX(0)';
                        if (sidebarOverlay) sidebarOverlay.classList.remove('hidden');
                    } else {
                        sidebar.style.transform = 'translateX(-100%)';
                        if (sidebarOverlay) sidebarOverlay.classList.add('hidden');
                    }
                } else {
                    sidebar.style.transform = '';
                    if (sidebarOverlay) sidebarOverlay.classList.add('hidden');
                }
            }
        }, 100);
    });
});