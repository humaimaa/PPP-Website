import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Alpine from 'alpinejs';

// Register GSAP plugins
gsap.registerPlugin(ScrollTrigger);

// ========== NAVBAR DROPDOWN COMPONENT ==========
function navbarDropdown() {
    return {
        dropdownOpen: null,
        mobileMenuOpen: false,
        isScrolled: false,
        
        toggleDropdown(dropdown) {
            // Close if clicking the same dropdown, otherwise open the new one
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
            
            // Initialize scroll detection
            this.checkScroll();
            window.addEventListener('scroll', () => this.checkScroll());
        },
        
        checkScroll() {
            this.isScrolled = window.scrollY > 50;
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
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        };
        
        window.addEventListener('scroll', handleScroll);
        handleScroll(); // Initial call
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

// ========== MOBILE DROPDOWN HANDLER ==========
function initializeMobileDropdowns() {
    // Handle closing other mobile dropdowns when one opens
    document.addEventListener('close-other-mobile', (e) => {
        document.querySelectorAll('[x-data]').forEach(el => {
            if (el.__x && el.__x.$data.open && el.__x.$data.open !== true) {
                el.__x.$data.open = false;
            }
        });
    });
}

// ========== STATS COUNTER ANIMATION ==========
function initializeStatsCounter() {
    const statNumbers = document.querySelectorAll('.stat-number');
    
    if (statNumbers.length > 0) {
        const animateNumber = (element) => {
            const target = parseInt(element.getAttribute('data-count'));
            let current = 0;
            const increment = target / 50;
            const updateNumber = () => {
                if (current < target) {
                    current += increment;
                    element.textContent = Math.round(current);
                    requestAnimationFrame(updateNumber);
                } else {
                    element.textContent = target;
                }
            };
            updateNumber();
        };
        
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateNumber(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);
        
        statNumbers.forEach(stat => observer.observe(stat));
    }
}

// ========== HERO OVERLAY FADE ON SCROLL ==========
function initializeHeroOverlay() {
    const heroOverlay = document.getElementById('heroOverlay');
    const arrow = document.getElementById('arrow');
    
    if (heroOverlay) {
        window.addEventListener('scroll', () => {
            const scrollPosition = window.scrollY;
            const opacity = Math.min(scrollPosition / 300, 0.8);
            heroOverlay.style.backgroundColor = `rgba(0, 0, 0, ${0.5 + opacity * 0.3})`;
            
            if (arrow) {
                if (scrollPosition > 100) {
                    arrow.style.opacity = '0';
                    arrow.style.visibility = 'hidden';
                } else {
                    arrow.style.opacity = '1';
                    arrow.style.visibility = 'visible';
                }
            }
        });
    }
}

// ========== PROJECT CATEGORY HOVER EFFECTS ==========
function initializeProjectCards() {
    const projectCards = document.querySelectorAll('.project-category-card');
    
    projectCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            const img = card.querySelector('img');
            if (img) {
                img.style.transform = 'scale(1.1)';
                img.style.opacity = '0.3';
            }
        });
        
        card.addEventListener('mouseleave', () => {
            const img = card.querySelector('img');
            if (img) {
                img.style.transform = 'scale(1)';
                img.style.opacity = '1';
            }
        });
    });
}

// ========== BUTTON POSITION AWARE EFFECT ==========
function initializePositionAwareButtons() {
    const buttons = document.querySelectorAll('.btn-position-aware');
    
    buttons.forEach(button => {
        const span = button.querySelector('.position-aware-span');
        
        if (span) {
            button.addEventListener('mousemove', (e) => {
                const rect = button.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                span.style.width = '300px';
                span.style.height = '300px';
                span.style.left = `${x}px`;
                span.style.top = `${y}px`;
            });
            
            button.addEventListener('mouseleave', () => {
                span.style.width = '0';
                span.style.height = '0';
            });
        }
    });
}

// ========== SMOOTH SCROLL FOR ANCHOR LINKS ==========
function initializeSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
}

// ========== SCROLL DOWN ARROW ==========
function initializeScrollArrow() {
    const arrow = document.getElementById('arrow');
    if (arrow) {
        arrow.addEventListener('click', () => {
            const aboutSection = document.getElementById('about-section');
            if (aboutSection) {
                aboutSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    }
}

// ========== ANIMATION ON SCROLL (GSAP) ==========
function initializeGSAPAnimations() {
    // Fade in animations for sections
    gsap.utils.toArray('section').forEach((section, i) => {
        gsap.from(section, {
            scrollTrigger: {
                trigger: section,
                start: 'top 80%',
                end: 'top 50%',
                scrub: 0.5
            },
            opacity: 0,
            y: 50,
            duration: 1
        });
    });
    
    // About section image animation
    const aboutImage = document.querySelector('#about-section img');
    if (aboutImage) {
        gsap.from(aboutImage, {
            scrollTrigger: {
                trigger: '#about-section',
                start: 'top 70%',
                end: 'top 50%',
                scrub: 0.5
            },
            opacity: 0,
            x: -50,
            duration: 1
        });
    }
}

// ========== INITIALIZE EVERYTHING ON DOM LOAD ==========
document.addEventListener('DOMContentLoaded', () => {
    initializeNavbarScroll();
    initializeLogoRotation();
    initializeMobileDropdowns();
    initializeStatsCounter();
    initializeHeroOverlay();
    initializeProjectCards();
    initializePositionAwareButtons();
    initializeSmoothScroll();
    initializeScrollArrow();
    
    // Initialize GSAP animations only if GSAP is available
    if (typeof gsap !== 'undefined') {
        initializeGSAPAnimations();
    }
});

// ========== WINDOW LOAD (for images and complete load) ==========
window.addEventListener('load', () => {
    // Additional initialization after all resources are loaded
    document.body.classList.add('loaded');
});

// Export for use in Blade templates
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;