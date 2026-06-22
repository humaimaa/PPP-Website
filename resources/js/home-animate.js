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
    initPartnerLogosWithArrows();
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

// PARTNER LOGOS WITH ARROW NAVIGATION
function initPartnerLogosWithArrows() {
    const track = document.getElementById('partner-track');
    const container = track?.closest('.logo-scroll-container');
    const leftBtn = document.getElementById('partner-scroll-left');
    const rightBtn = document.getElementById('partner-scroll-right');
    
    if (!track || !container || !leftBtn || !rightBtn) {
        return;
    }

    // Get logo items
    const logoItems = track.querySelectorAll('.partner-logo');
    if (logoItems.length === 0) return;

    // Store logo widths
    let logoWidths = [];
    let totalOriginalWidth = 0;
    const gap = 48; // gap-12 in rem = 3rem = 48px

    // Calculate logo widths
    function calculateLogoWidths() {
        logoWidths = [];
        const items = track.querySelectorAll('.partner-logo');
        const originalCount = items.length / 2; // Only original items
        let tempWidth = 0;
        
        for (let i = 0; i < originalCount; i++) {
            const width = items[i].offsetWidth + gap;
            logoWidths.push(width);
            tempWidth += width;
        }
        totalOriginalWidth = tempWidth;
    }

    // Clone logos for infinite scroll
    const logos = Array.from(logoItems);
    logos.forEach(logo => {
        const clone = logo.cloneNode(true);
        track.appendChild(clone);
    });

    // Initial calculation
    setTimeout(calculateLogoWidths, 100);

    let isAnimating = false;
    let animation = null;
    let currentIndex = 0;
    let totalLogos = logoItems.length;

    // Start continuous scroll
    function startContinuousScroll() {
        if (isAnimating) return;
        
        if (logoWidths.length === 0) {
            calculateLogoWidths();
        }
        
        const scrollDistance = totalOriginalWidth;
        
        if (animation) {
            animation.kill();
            animation = null;
        }

        isAnimating = true;
        
        animation = gsap.to(track, {
            x: -scrollDistance,
            duration: 20,
            ease: "none",
            repeat: -1,
            modifiers: {
                x: function(x) {
                    const currentX = parseFloat(x);
                    if (currentX <= -scrollDistance) {
                        gsap.set(track, { x: 0 });
                        currentIndex = 0;
                        updateArrowVisibility();
                        return "0px";
                    }
                    return x;
                }
            },
            onUpdate: function() {
                updateArrowVisibility();
            }
        });
    }

    // Stop continuous scroll
    function stopContinuousScroll() {
        if (animation) {
            animation.kill();
            animation = null;
        }
        isAnimating = false;
    }

    // Update arrow visibility
    function updateArrowVisibility() {
        const currentX = parseFloat(gsap.getProperty(track, "x"));
        const maxScroll = totalOriginalWidth - container.clientWidth;
        
        // Left arrow: can scroll if not at the beginning
        if (currentX < -1) {
            leftBtn.disabled = false;
        } else {
            leftBtn.disabled = true;
        }

        // Right arrow: can scroll if not at the end
        if (currentX > -maxScroll + 1) {
            rightBtn.disabled = false;
        } else {
            rightBtn.disabled = true;
        }
    }

    // Get logo width
    function getLogoWidth() {
        if (logoWidths.length > 0) {
            return logoWidths[0] || (logoItems[0]?.offsetWidth + gap || 200);
        }
        return logoItems[0]?.offsetWidth + gap || 200;
    }

    // Scroll by one logo
    function scrollByOneLogo(direction) {
        stopContinuousScroll();
        
        const currentX = parseFloat(gsap.getProperty(track, "x"));
        const logoWidth = getLogoWidth();
        const maxScroll = totalOriginalWidth - container.clientWidth;
        
        let targetX;
        
        if (direction === 'left') {
            targetX = Math.min(currentX + logoWidth, 0);
        } else {
            targetX = Math.max(currentX - logoWidth, -maxScroll);
        }
        
        if (Math.abs(targetX - currentX) < 1) {
            setTimeout(() => startContinuousScroll(), 500);
            return;
        }
        
        gsap.to(track, {
            x: targetX,
            duration: 0.5,
            ease: "power2.inOut",
            onComplete: function() {
                updateCurrentIndex();
                setTimeout(() => startContinuousScroll(), 1000);
            },
            onUpdate: function() {
                updateArrowVisibility();
            }
        });
    }

    // Update current index
    function updateCurrentIndex() {
        const currentX = parseFloat(gsap.getProperty(track, "x"));
        const logoWidth = getLogoWidth();
        
        if (logoWidth > 0) {
            const index = Math.round(Math.abs(currentX) / logoWidth);
            currentIndex = Math.min(index, totalLogos - 1);
        }
    }

    // Arrow click handlers
    leftBtn.addEventListener('click', function() {
        if (this.disabled) return;
        scrollByOneLogo('left');
    });

    rightBtn.addEventListener('click', function() {
        if (this.disabled) return;
        scrollByOneLogo('right');
    });

    // Mouse wheel support
    let wheelTimeout = null;
    container.addEventListener('wheel', function(e) {
        e.preventDefault();
        
        if (wheelTimeout) return;
        
        wheelTimeout = setTimeout(() => {
            wheelTimeout = null;
        }, 500);
        
        stopContinuousScroll();
        
        if (e.deltaY > 0) {
            scrollByOneLogo('right');
        } else {
            scrollByOneLogo('left');
        }
    }, { passive: false });

    // Touch support
    let touchStartX = 0;
    
    container.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
        stopContinuousScroll();
    }, { passive: true });
    
    container.addEventListener('touchend', function(e) {
        const touchEndX = e.changedTouches[0].screenX;
        const diff = touchStartX - touchEndX;
        const threshold = 30;
        
        if (Math.abs(diff) > threshold) {
            if (diff > 0) {
                scrollByOneLogo('right');
            } else {
                scrollByOneLogo('left');
            }
        } else {
            setTimeout(() => startContinuousScroll(), 500);
        }
    }, { passive: true });

    // Pause on hover
    container.addEventListener('mouseenter', stopContinuousScroll);
    container.addEventListener('mouseleave', startContinuousScroll);

    // Resize handler
    let resizeTimeout = null;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            calculateLogoWidths();
            stopContinuousScroll();
            gsap.set(track, { x: 0 });
            currentIndex = 0;
            updateArrowVisibility();
            setTimeout(() => startContinuousScroll(), 500);
        }, 300);
    });

    // Initialize
    setTimeout(() => {
        startContinuousScroll();
        updateArrowVisibility();
    }, 1000);
}

// Export for use in Blade templates
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;