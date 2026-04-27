import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Alpine from 'alpinejs';

// Register GSAP plugins
gsap.registerPlugin(ScrollTrigger);

// Make Alpine available globally
window.Alpine = Alpine;
Alpine.start();

// Wait for DOM to load
document.addEventListener('DOMContentLoaded', () => {
    initializeNavbar();
    initializeContinuousLogoRotation();
});

function initializeNavbar() {
    const navbar = document.querySelector('.navbar');
    
    // Navbar scroll effect
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
                navbar.style.backgroundColor = '#0D2617';
                navbar.style.backdropFilter = 'blur(0px)';
                navbar.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.3)';
            } else {
                navbar.classList.remove('navbar-scrolled');
                navbar.style.backgroundColor = 'transparent';
                navbar.style.backdropFilter = '';
                navbar.style.boxShadow = '';
            }
        });
    }
}

function initializeContinuousLogoRotation() {
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

// Export for use in Blade templates
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;