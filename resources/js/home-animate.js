import cgsap from 'gsap';
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
    initPartnerLogosScroll();
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

// Smooth scroll arrow to bottom of page
function initSmoothScrollArrow() {
    const arrow = document.getElementById('scroll-down-arrow');
    if (!arrow) return;
    
    arrow.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Get the bottom of the page
        const targetPosition = document.body.scrollHeight;
        const startPosition = window.scrollY;
        const distance = targetPosition - startPosition;
        
        if (Math.abs(distance) < 10) return;
        
        const duration = 2000; // 2 seconds for smooth slow scroll
        const startTime = performance.now();
        
        // Easing function for smooth deceleration
        const easeOutCubic = (t) => {
            return 1 - Math.pow(1 - t, 3);
        };
        
        function animateScroll(currentTime) {
            const elapsed = currentTime - startTime;
            let progress = Math.min(1, elapsed / duration);
            const easedProgress = easeOutCubic(progress);
            const newPosition = startPosition + (distance * easedProgress);
            
            window.scrollTo(0, newPosition);
            
            if (progress < 1) {
                requestAnimationFrame(animateScroll);
            }
        }
        
        requestAnimationFrame(animateScroll);
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

// Alternative: Using GSAP's built-in repeat functionality
function initPartnerLogosScroll() {
    const logoContainer = document.querySelector('.logo-scroll-container');
    const logoTrack = document.querySelector('.logo-track');
    
    if (!logoContainer || !logoTrack) return;
    
    // First, duplicate the content enough times for smooth infinite scroll
    const trackWidth = logoTrack.scrollWidth;
    const containerWidth = logoContainer.clientWidth;
    
    // Calculate how many copies we need (at least 3 copies for smooth loop)
    const copiesNeeded = Math.ceil((containerWidth * 2) / trackWidth) + 2;
    
    for (let i = 0; i < copiesNeeded; i++) {
        const logos = Array.from(logoTrack.querySelectorAll('.partner-logo'));
        logos.forEach(logo => {
            const clone = logo.cloneNode(true);
            logoTrack.appendChild(clone);
        });
    }
    
    // Get the width of one set (original width before duplication)
    const originalSetWidth = trackWidth;
    const totalWidth = logoTrack.scrollWidth;
    
    // Create the seamless infinite scroll animation
    const tl = gsap.timeline({
        repeat: -1,
        onRepeat: function() {
            // When we reach the end, instantly jump back to the start
            gsap.set(logoTrack, { x: 0 });
        }
    });
    
    // Animate from 0 to -originalSetWidth
    tl.to(logoTrack, {
        x: -originalSetWidth,
        duration: 30,
        ease: "none"
    });
    
    // Pause on hover
    logoContainer.addEventListener('mouseenter', () => {
        tl.pause();
    });
    
    // Resume on leave
    logoContainer.addEventListener('mouseleave', () => {
        tl.resume();
    });
    
    // Add hover effects for individual logos
    const logos = document.querySelectorAll('.partner-logo');
    logos.forEach(logo => {
        logo.addEventListener('mouseenter', () => {
            gsap.to(logo, {
                scale: 1.05,
                duration: 0.3,
                ease: "power2.out"
            });
        });
        
        logo.addEventListener('mouseleave', () => {
            gsap.to(logo, {
                scale: 1,
                duration: 0.3,
                ease: "power2.out"
            });
        });
    });
}

// Export for use in Blade templates
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;