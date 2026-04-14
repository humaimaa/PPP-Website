import './bootstrap';

// Import JSZip and FileSaver
import JSZip from 'jszip';
import { saveAs } from 'file-saver';

// Make them globally available for use in Blade templates
window.JSZip = JSZip;
window.saveAs = saveAs;

// Import GSAP
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

// Register ScrollTrigger plugin
gsap.registerPlugin(ScrollTrigger);

// Make GSAP available globally
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;

// Header Navigation Functionality
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenu = document.getElementById('mobileMenu');
    const menuOverlay = document.getElementById('menuOverlay');
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const closeMenuBtn = document.getElementById('closeMenuBtn');

    function openMenu() {
        if (mobileMenu && menuOverlay) {
            mobileMenu.classList.remove('-translate-x-full');
            mobileMenu.classList.add('translate-x-0');
            menuOverlay.classList.remove('opacity-0', 'invisible');
            menuOverlay.classList.add('opacity-100', 'visible');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeMenu() {
        if (mobileMenu && menuOverlay) {
            mobileMenu.classList.remove('translate-x-0');
            mobileMenu.classList.add('-translate-x-full');
            menuOverlay.classList.remove('opacity-100', 'visible');
            menuOverlay.classList.add('opacity-0', 'invisible');
            document.body.style.overflow = '';
        }
    }

    // Event listeners for menu buttons
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', openMenu);
    }
    
    if (closeMenuBtn) {
        closeMenuBtn.addEventListener('click', closeMenu);
    }
    
    if (menuOverlay) {
        menuOverlay.addEventListener('click', closeMenu);
    }

    // Mobile dropdown toggles inside the offcanvas menu
    document.querySelectorAll('.mobile-dropdown-toggle').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Close all other dropdowns first
            document.querySelectorAll('.mobile-dropdown-menu').forEach(menu => {
                if (menu !== this.parentElement.querySelector('.mobile-dropdown-menu')) {
                    menu.classList.add('hidden');
                    const otherButton = menu.closest('.mobile-dropdown')?.querySelector('.mobile-dropdown-toggle');
                    if (otherButton) {
                        const otherArrow = otherButton.querySelector('.mobile-dropdown-arrow');
                        if (otherArrow) otherArrow.classList.remove('rotate-180');
                    }
                }
            });
            
            const parent = this.closest('.mobile-dropdown');
            const menu = parent.querySelector('.mobile-dropdown-menu');
            const arrow = this.querySelector('.mobile-dropdown-arrow');
            
            if (menu && arrow) {
                menu.classList.toggle('hidden');
                arrow.classList.toggle('rotate-180');
            }
        });
    });

    // Close menu on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileMenu && mobileMenu.classList.contains('translate-x-0')) {
            closeMenu();
        }
    });

    initHeroSlider();
});

// Hero Slider Initialization with Right-to-Left Slide Animation
function initHeroSlider() {
    const heroSlider = document.querySelector(".hero-slider");
    if (!heroSlider) return;
    
    const slides = document.querySelectorAll(".hero-slide");
    const dots = document.querySelectorAll(".slide-dot");
    const slideContents = document.querySelectorAll(".slide-content");
    
    if (slides.length === 0) return;
    
    let currentIndex = 0;
    let intervalId;
    let isAnimating = false;
    let isSlideContentHovered = false;
    const autoSlideDelay = 5000;
    
    // Function to animate slide content
    function animateSlideContent(element, direction = 'in') {
        if (!element) return;
        
        const heading = element.querySelector('.slide-heading');
        const text = element.querySelector('.slide-text');
        
        if (direction === 'in') {
            // Animate content in
            if (heading) {
                gsap.fromTo(heading, 
                    { y: 50, opacity: 0 },
                    { y: 0, opacity: 1, duration: 0.8, ease: "power2.out", delay: 0.2 }
                );
            }
            if (text) {
                gsap.fromTo(text,
                    { y: 30, opacity: 0 },
                    { y: 0, opacity: 1, duration: 0.8, ease: "power2.out", delay: 0.4 }
                );
            }
        } else {
            // Reset content
            if (heading) {
                gsap.set(heading, { y: 0, opacity: 1 });
            }
            if (text) {
                gsap.set(text, { y: 0, opacity: 1 });
            }
        }
    }
    
    // Initialize slider
    function initializeSlider() {
        slides.forEach((slide, index) => {
            gsap.set(slide, {
                opacity: 0,
                display: "none",
                x: 0
            });
        });
        
        gsap.set(slides[0], {
            display: "block",
            opacity: 1
        });
        
        // Animate content of first slide
        const firstSlideContent = slides[0].querySelector('.slide-content');
        if (firstSlideContent) {
            animateSlideContent(firstSlideContent, 'in');
        }
        
        if (dots[0]) {
            gsap.set(dots[0], {
                backgroundColor: "#28b960",
                scale: 1.2
            });
        }
    }
    
    function transitionToSlide(newIndex, direction = 'next') {
        if (isAnimating || newIndex === currentIndex) return;
        
        const oldSlide = slides[currentIndex];
        const newSlide = slides[newIndex];
        
        if (!newSlide) return;
        
        isAnimating = true;
        
        // Get content elements
        const oldContent = oldSlide.querySelector('.slide-content');
        const newContent = newSlide.querySelector('.slide-content');
        
        // Reset old content opacity
        if (oldContent) {
            gsap.set(oldContent, { opacity: 1 });
        }
        
        // Set initial position for new slide
        if (direction === 'next') {
            gsap.set(newSlide, { x: "100%", display: "block", opacity: 1 });
        } else {
            gsap.set(newSlide, { x: "-100%", display: "block", opacity: 1 });
        }
        
        // Set new content initial state
        if (newContent) {
            const heading = newContent.querySelector('.slide-heading');
            const text = newContent.querySelector('.slide-text');
            if (heading) gsap.set(heading, { y: 50, opacity: 0 });
            if (text) gsap.set(text, { y: 30, opacity: 0 });
        }
        
        // Animate old slide out
        if (direction === 'next') {
            gsap.to(oldSlide, {
                x: "-100%",
                duration: 0.6,
                ease: "power2.inOut",
                onComplete: () => {
                    gsap.set(oldSlide, { display: "none", x: 0 });
                }
            });
        } else {
            gsap.to(oldSlide, {
                x: "100%",
                duration: 0.6,
                ease: "power2.inOut",
                onComplete: () => {
                    gsap.set(oldSlide, { display: "none", x: 0 });
                }
            });
        }
        
        // Animate new slide in
        gsap.to(newSlide, {
            x: 0,
            duration: 0.6,
            ease: "power2.inOut",
            onComplete: () => {
                isAnimating = false;
                // Animate content of new slide
                if (newContent) {
                    animateSlideContent(newContent, 'in');
                }
            }
        });
        
        // Update dots
        if (dots[currentIndex]) {
            gsap.to(dots[currentIndex], {
                backgroundColor: "#ffffff",
                scale: 1,
                opacity: 0.5,
                duration: 0.3
            });
        }
        
        if (dots[newIndex]) {
            gsap.to(dots[newIndex], {
                backgroundColor: "#28b960",
                scale: 1.2,
                opacity: 1,
                duration: 0.5,
                ease: "elastic.out(1, 0.5)"
            });
        }
        
        currentIndex = newIndex;
    }
    
    // Next slide
    function nextSlide() {
        if (isAnimating) return;
        const nextIndex = (currentIndex + 1) % slides.length;
        transitionToSlide(nextIndex, 'next');
    }
    
    // Previous slide
    function prevSlide() {
        if (isAnimating) return;
        const prevIndex = (currentIndex - 1 + slides.length) % slides.length;
        transitionToSlide(prevIndex, 'prev');
    }
    
    // Start auto-sliding
    function startSlider() {
        if (intervalId) clearInterval(intervalId);
        intervalId = setInterval(() => {
            if (!isSlideContentHovered && !isAnimating) {
                nextSlide();
            }
        }, autoSlideDelay);
    }
    
    // Stop auto-sliding
    function stopSlider() {
        if (intervalId) {
            clearInterval(intervalId);
            intervalId = null;
        }
    }
    
    // Add navigation arrows if they exist
    const prevBtn = document.querySelector('.slider-prev');
    const nextBtn = document.querySelector('.slider-next');
    
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            stopSlider();
            prevSlide();
            startSlider();
        });
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            stopSlider();
            nextSlide();
            startSlider();
        });
    }
    
    // Dot click handlers
    dots.forEach((dot, index) => {
        dot.addEventListener("click", () => {
            if (isAnimating) return;
            stopSlider();
            const direction = index > currentIndex ? 'next' : 'prev';
            transitionToSlide(index, direction);
            startSlider();
        });
    });
    
    // Pause on hover for slide contents
    slideContents.forEach((content) => {
        content.addEventListener("mouseenter", () => {
            isSlideContentHovered = true;
            stopSlider();
        });
        
        content.addEventListener("mouseleave", () => {
            isSlideContentHovered = false;
            startSlider();
        });
    });
    
    // Keyboard navigation
    document.addEventListener("keydown", (e) => {
        if (isAnimating) return;
        if (e.key === "ArrowLeft") {
            stopSlider();
            prevSlide();
            startSlider();
        } else if (e.key === "ArrowRight") {
            stopSlider();
            nextSlide();
            startSlider();
        }
    });
    
    // Initialize
    initializeSlider();
    startSlider();
}