// home-animate.js
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { ScrollToPlugin } from 'gsap/ScrollToPlugin';

// Register GSAP plugins
gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);

// Wait for DOM to load
document.addEventListener('DOMContentLoaded', () => {
    initializeTextAnimations();
    initializeStatsCounter();
    initSmoothScrollArrow();
    initPositionAwareButton();
    initPartnerLogosAutoScroll();
});

function initializeTextAnimations() {
    // Hero section text animations
    const heroTitle = document.querySelector('.hero-video-section h1');
    const heroSubtitle = document.querySelector('.hero-video-section p');
    
    if (heroTitle) {
        gsap.fromTo(heroTitle, 
            { opacity: 0, y: 30 },
            { opacity: 1, y: 0, duration: 0.8, delay: 0.2 }
        );
    }
    
    if (heroSubtitle) {
        gsap.fromTo(heroSubtitle,
            { opacity: 0, y: 30 },
            { opacity: 1, y: 0, duration: 0.8, delay: 0.4 }
        );
    }

    // About section text animations
    const aboutHeading = document.querySelector('#about-section .order-first h2, #about-section .md\\:order-last h2');
    const aboutParagraphs = document.querySelectorAll('#about-section .order-first p, #about-section .md\\:order-last p');
    const aboutListItems = document.querySelectorAll('#about-section ul li');
    const aboutButton = document.querySelector('#about-section .btn-position-aware');
    
    if (aboutHeading) {
        gsap.fromTo(aboutHeading,
            { opacity: 0, x: -30 },
            {
                scrollTrigger: {
                    trigger: '#about-section',
                    start: 'top 80%',
                    toggleActions: 'play none none reverse'
                },
                opacity: 1,
                x: 0,
                duration: 0.6,
                ease: 'power2.out'
            }
        );
    }
    
    if (aboutParagraphs.length) {
        aboutParagraphs.forEach((paragraph, index) => {
            gsap.fromTo(paragraph,
                { opacity: 0, x: -20 },
                {
                    scrollTrigger: {
                        trigger: '#about-section',
                        start: 'top 80%',
                        toggleActions: 'play none none reverse'
                    },
                    opacity: 1,
                    x: 0,
                    duration: 0.6,
                    delay: index * 0.2,
                    ease: 'power2.out'
                }
            );
        });
    }
    
    if (aboutListItems.length) {
        aboutListItems.forEach((item, index) => {
            gsap.fromTo(item,
                { opacity: 0, x: -15 },
                {
                    scrollTrigger: {
                        trigger: '#about-section',
                        start: 'top 80%',
                        toggleActions: 'play none none reverse'
                    },
                    opacity: 1,
                    x: 0,
                    duration: 0.5,
                    delay: index * 0.1,
                    ease: 'power2.out'
                }
            );
        });
    }
    
    if (aboutButton) {
        gsap.fromTo(aboutButton,
            { opacity: 0, y: 20 },
            {
                scrollTrigger: {
                    trigger: '#about-section',
                    start: 'top 80%',
                    toggleActions: 'play none none reverse'
                },
                opacity: 1,
                y: 0,
                duration: 0.6,
                delay: 0.4,
                ease: 'power2.out'
            }
        );
    }

    // Departmental Leadership section animations
    const leadershipSection = document.querySelector('.bg-gradient-to-br');
    if (leadershipSection) {
        const leadershipTitle = leadershipSection.querySelector('h2');
        const leadershipImage = leadershipSection.querySelector('img');
        const leadershipContent = leadershipSection.querySelector('.lg\\:w-1\\/2');
        
        if (leadershipTitle) {
            gsap.fromTo(leadershipTitle,
                { opacity: 0, y: 20 },
                {
                    scrollTrigger: {
                        trigger: leadershipSection,
                        start: 'top 80%',
                        toggleActions: 'play none none reverse'
                    },
                    opacity: 1,
                    y: 0,
                    duration: 0.6,
                    ease: 'power2.out'
                }
            );
        }
        
        if (leadershipImage) {
            gsap.fromTo(leadershipImage,
                { opacity: 0, scale: 0.9 },
                {
                    scrollTrigger: {
                        trigger: leadershipSection,
                        start: 'top 80%',
                        toggleActions: 'play none none reverse'
                    },
                    opacity: 1,
                    scale: 1,
                    duration: 0.7,
                    delay: 0.2,
                    ease: 'power2.out'
                }
            );
        }
        
        if (leadershipContent) {
            gsap.fromTo(leadershipContent,
                { opacity: 0, x: 30 },
                {
                    scrollTrigger: {
                        trigger: leadershipSection,
                        start: 'top 80%',
                        toggleActions: 'play none none reverse'
                    },
                    opacity: 1,
                    x: 0,
                    duration: 0.6,
                    delay: 0.3,
                    ease: 'power2.out'
                }
            );
        }
    }

    // Section titles animations
    const sectionTitles = document.querySelectorAll('.animate-on-scroll-title');
    sectionTitles.forEach((title) => {
        gsap.fromTo(title,
            { opacity: 0, y: 20 },
            {
                scrollTrigger: {
                    trigger: title,
                    start: 'top 85%',
                    toggleActions: 'play none none reverse'
                },
                opacity: 1,
                y: 0,
                duration: 0.6,
                ease: 'power2.out'
            }
        );
    });

    // Text content animations
    const textContents = document.querySelectorAll('.animate-on-scroll-text');
    textContents.forEach((text) => {
        gsap.fromTo(text,
            { opacity: 0, y: 15 },
            {
                scrollTrigger: {
                    trigger: text,
                    start: 'top 85%',
                    toggleActions: 'play none none reverse'
                },
                opacity: 1,
                y: 0,
                duration: 0.5,
                delay: 0.2,
                ease: 'power2.out'
            }
        );
    });
}

function initializeStatsCounter() {
    const statNumbers = document.querySelectorAll('.stat-number');
    
    if (statNumbers.length === 0) return;
    
    const animateNumber = (element, target) => {
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;
        
        const updateNumber = () => {
            current += step;
            if (current < target) {
                element.textContent = Math.floor(current);
                requestAnimationFrame(updateNumber);
            } else {
                element.textContent = target;
            }
        };
        
        updateNumber();
    };
    
    const resetCounter = (element) => {
        element.textContent = '0';
    };
    
    statNumbers.forEach((stat) => {
        let hasAnimated = false;
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    if (!hasAnimated) {
                        const target = parseInt(entry.target.getAttribute('data-count')) || 0;
                        animateNumber(entry.target, target);
                        hasAnimated = true;
                    }
                } else {
                    if (hasAnimated) {
                        resetCounter(entry.target);
                        hasAnimated = false;
                    }
                }
            });
        }, { threshold: 0.3 });
        
        observer.observe(stat);
    });
}

// SMOOTH SCROLL ARROW
function initSmoothScrollArrow() {
    const arrow = document.getElementById('scroll-down-arrow');
    if (!arrow) return;
    
    arrow.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        window.scrollTo({
            top: document.documentElement.scrollHeight,
            behavior: 'smooth'
        });
    });
}

function initPositionAwareButton() {
    const buttons = document.querySelectorAll('.btn-position-aware');
    
    buttons.forEach(button => {
        const span = button.querySelector('.position-aware-span');
        if (!span) return;
        
        button.addEventListener('mouseenter', function(e) {
            const parentOffset = this.getBoundingClientRect();
            const relX = e.clientX - parentOffset.left;
            const relY = e.clientY - parentOffset.top;
            
            span.style.top = relY + 'px';
            span.style.left = relX + 'px';
            span.style.width = '225%';
            span.style.height = '225%';
        });
        
        button.addEventListener('mouseleave', function(e) {
            const parentOffset = this.getBoundingClientRect();
            const relX = e.clientX - parentOffset.left;
            const relY = e.clientY - parentOffset.top;
            
            span.style.top = relY + 'px';
            span.style.left = relX + 'px';
            span.style.width = '0';
            span.style.height = '0';
        });
    });
}

// PARTNER LOGOS AUTO-SCROLL (No Arrows)
function initPartnerLogosAutoScroll() {
    const track = document.getElementById('partner-track');
    const container = track?.closest('.logo-scroll-container');
    
    if (!track || !container) {
        return;
    }

    // Get logo items
    const logoItems = track.querySelectorAll('.partner-logo');
    if (logoItems.length === 0) return;

    let gap = 48; // gap-12 in rem = 3rem = 48px
    let logoWidth = 0;
    let totalWidth = 0;
    let halfTotalWidth = 0;
    let animation = null;

    // Calculate widths
    function calculateWidths() {
        // Get the width of the first logo including gap
        const firstLogo = logoItems[0];
        if (firstLogo) {
            logoWidth = firstLogo.offsetWidth + gap;
        } else {
            logoWidth = 200 + gap; // fallback
        }
        
        // Total width of all logos
        totalWidth = logoItems.length * logoWidth;
        halfTotalWidth = totalWidth / 2;
    }

    // Setup track with clones for seamless infinite scroll
    function setupClones() {
        // Remove existing clones if any
        const existingClones = track.querySelectorAll('.clone-logo');
        existingClones.forEach(clone => clone.remove());
        
        // Clone all logos and append
        logoItems.forEach(logo => {
            const clone = logo.cloneNode(true);
            clone.classList.add('clone-logo');
            track.appendChild(clone);
        });
    }

    // Start auto-scroll
    function startAutoScroll() {
        if (animation) {
            animation.kill();
            animation = null;
        }
        
        const scrollDistance = halfTotalWidth;
        
        animation = gsap.to(track, {
            x: -scrollDistance,
            duration: 25,
            ease: "none",
            repeat: -1,
            modifiers: {
                x: function(x) {
                    const currentX = parseFloat(x);
                    // Check if we need to loop seamlessly
                    if (currentX <= -halfTotalWidth) {
                        gsap.set(track, { x: currentX + halfTotalWidth });
                        return (currentX + halfTotalWidth) + "px";
                    }
                    return x;
                }
            }
        });
    }

    // Stop auto-scroll
    function stopAutoScroll() {
        if (animation) {
            animation.kill();
            animation = null;
        }
    }

    // Pause on hover
    container.addEventListener('mouseenter', stopAutoScroll);
    container.addEventListener('mouseleave', function() {
        startAutoScroll();
    });

    // Resize handler
    let resizeTimeout = null;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            stopAutoScroll();
            calculateWidths();
            gsap.set(track, { x: 0 });
            setTimeout(() => {
                startAutoScroll();
            }, 300);
        }, 300);
    });

    // Initialize everything
    function init() {
        calculateWidths();
        setupClones();
        gsap.set(track, { x: 0 });
        startAutoScroll();
    }

    // Initial setup with delay to ensure layout is complete
    setTimeout(init, 500);

    // Re-initialize on window load
    window.addEventListener('load', function() {
        stopAutoScroll();
        calculateWidths();
        gsap.set(track, { x: 0 });
        setTimeout(() => {
            startAutoScroll();
        }, 500);
    });
}

// Export for use in Blade templates
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;