import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Alpine from 'alpinejs';

// Register GSAP plugins
gsap.registerPlugin(ScrollTrigger);

/**
 * Check if a function exists globally
 */
if (!window.function_exists) {
    window.function_exists = function(functionName) {
        return typeof window[functionName] === 'function';
    };
}

/**
 * Format title with uppercase keywords
 */
if (!window.formatTitle) {
    window.formatTitle = function(text) {
        if (!text) return text;
        
        const keywords = ['ppp', 'kp'];
        let formattedText = text;
        keywords.forEach(keyword => {
            const regex = new RegExp(keyword, 'gi');
            formattedText = formattedText.replace(regex, keyword.toUpperCase());
        });
        return formattedText;
    };
}

// ========== NAVBAR DROPDOWN COMPONENT ==========
function navbarDropdown() {
    return {
        dropdownOpen: null,
        mobileMenuOpen: false,
        
        toggleDropdown(dropdown) {
            if (this.dropdownOpen === dropdown) {
                this.dropdownOpen = null;
            } else {
                this.dropdownOpen = dropdown;
            }
        },
        
        closeAllDropdowns() {
            this.dropdownOpen = null;
        },
        
        toggleMobileMenu() {
            this.mobileMenuOpen = !this.mobileMenuOpen;
            if (this.mobileMenuOpen) {
                document.body.classList.add('mobile-menu-open');
            } else {
                document.body.classList.remove('mobile-menu-open');
            }
        },
        
        closeMobileMenu() {
            this.mobileMenuOpen = false;
            document.body.classList.remove('mobile-menu-open');
        },
        
        init() {
            // Handle ESC key to close dropdowns
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    this.closeAllDropdowns();
                    if (this.mobileMenuOpen) {
                        this.closeMobileMenu();
                    }
                }
            });
            
            // Close dropdowns when clicking outside
            document.addEventListener('click', (e) => {
                const navbar = document.querySelector('.navbar');
                if (navbar && !navbar.contains(e.target)) {
                    this.closeAllDropdowns();
                }
            });
        }
    };
}

// Make Alpine component available globally
window.navbarDropdown = navbarDropdown;

// Start Alpine
window.Alpine = Alpine;
Alpine.start();

// ========== NAVBAR SCROLL EFFECT ==========
function initializeNavbarScroll() {
    const navbar = document.querySelector('.navbar');
    
    if (navbar) {
        const handleScroll = () => {
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
                navbar.classList.remove('navbar-transparent');
            } else {
                navbar.classList.remove('navbar-scrolled');
                navbar.classList.add('navbar-transparent');
            }
        };
        
        window.addEventListener('scroll', handleScroll);
        // Initial call to set correct state
        handleScroll();
    }
}

// ========== LOGO ROTATION ANIMATION ==========
function initializeLogoRotation() {
    const logo = document.querySelector('.navbar-logo');
    if (logo) {
        const parent = logo.parentElement;
        if (parent) {
            parent.style.perspective = '1000px';
            parent.style.transformStyle = 'preserve-3d';
        }
        
        logo.addEventListener('mouseenter', () => {
            logo.style.animationPlayState = 'paused';
        });
        
        logo.addEventListener('mouseleave', () => {
            logo.style.animationPlayState = 'running';
        });
    }
}

// ========== FOOTER INITIALIZATION ==========
function initializeFooter() {
    const copyrightElement = document.querySelector('footer .border-t p:first-child');
    if (copyrightElement) {
        const year = new Date().getFullYear();
        const text = copyrightElement.innerHTML;
        if (!text.includes(year.toString())) {
            copyrightElement.innerHTML = '<i class="far fa-copyright mr-1"></i> ' + year + ' PPP Department Khyber Pakhtunkhwa. All rights reserved.';
        }
    }
}

// ========== INITIALIZE EVERYTHING ON DOM LOAD ==========
document.addEventListener('DOMContentLoaded', () => {
    initializeNavbarScroll();
    initializeLogoRotation();
    initializeFooter();
});

// ========== WINDOW LOAD ==========
window.addEventListener('load', () => {
    document.body.classList.add('loaded');
});

// Export for use in Blade templates
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;