import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { ScrollToPlugin } from 'gsap/ScrollToPlugin';

// Register GSAP plugins
gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);

// Wait for DOM to load
document.addEventListener('DOMContentLoaded', () => {
    initializeHomeAnimations();
    initializeStatsCounter();
    initScrollArrow();
    initPositionAwareButton();
    initProjectCards();
});

function initializeHomeAnimations() {
    // Hero section fade out on scroll
    const heroSection = document.querySelector('.hero-video-section');
    if (heroSection) {
        gsap.to(heroSection, {
            scrollTrigger: {
                trigger: heroSection,
                start: 'top top',
                end: 'bottom top',
                scrub: 1.5,
                onUpdate: (self) => {
                    const opacity = 1 - (self.progress * 0.8);
                    heroSection.style.opacity = opacity;
                }
            }
        });
    }

    // About section animations
    const aboutSection = document.querySelector('#about-section');
    if (aboutSection) {
        const aboutImage = aboutSection.querySelector('img');
        if (aboutImage) {
            gsap.from(aboutImage, {
                scrollTrigger: {
                    trigger: aboutSection,
                    start: 'top 80%',
                    end: 'bottom 20%',
                    toggleActions: 'play none none reverse'
                },
                duration: 1,
                scale: 0.9,
                opacity: 0,
                ease: 'power2.out'
            });
        }

        const aboutContent = aboutSection.querySelector('.w-full:not(#about-section .w-full:first-child)');
        if (aboutContent && aboutContent.classList.contains('about-content')) {
            gsap.from(aboutContent, {
                scrollTrigger: {
                    trigger: aboutSection,
                    start: 'top 70%',
                    end: 'bottom 20%',
                    toggleActions: 'play none none reverse'
                },
                duration: 1,
                x: -50,
                opacity: 0,
                ease: 'power2.out'
            });
        }

        const listItems = aboutSection.querySelectorAll('ul li');
        listItems.forEach((item, index) => {
            gsap.from(item, {
                scrollTrigger: {
                    trigger: aboutSection,
                    start: 'top 70%',
                },
                duration: 0.5,
                x: -20,
                opacity: 0,
                delay: index * 0.1,
                ease: 'power2.out'
            });
        });
    }

    // Stats section animations
    const statsSection = document.querySelector('#stats-section');
    if (statsSection) {
        gsap.from(statsSection.querySelector('.container'), {
            scrollTrigger: {
                trigger: statsSection,
                start: 'top 80%',
                toggleActions: 'play none none reverse'
            },
            duration: 1,
            opacity: 0,
            y: 30,
            ease: 'power2.out'
        });
    }

    // Stat cards stagger animation
    gsap.from('.stat-card', {
        scrollTrigger: {
            trigger: '#stats-section',
            start: 'top 80%',
            toggleActions: 'play none none reverse'
        },
        duration: 0.8,
        y: 30,
        opacity: 0,
        stagger: 0.15,
        ease: 'power2.out'
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

// Smooth scroll arrow function
function initScrollArrow() {
    const arrow = document.getElementById('arrow');
    if (!arrow) return;
    
    arrow.addEventListener('click', function(e) {
        e.preventDefault();
        
        let footer = document.querySelector('footer');
        if (!footer) {
            footer = document.querySelector('.footer');
        }
        
        if (!footer) return;
        
        const targetPosition = footer.offsetTop;
        const startPosition = window.scrollY;
        const distance = targetPosition - startPosition;
        
        if (Math.abs(distance) < 10) return;
        
        const duration = 3500;
        const startTime = performance.now();
        
        const linearInterpolation = (start, end, progress) => {
            return start + (end - start) * progress;
        };
        
        const smoothEasing = (t) => {
            return t < 0.5 
                ? 2 * t * t 
                : 1 - Math.pow(-2 * t + 2, 2) / 2;
        };
        
        function animateScroll(currentTime) {
            const elapsed = currentTime - startTime;
            let progress = Math.min(1, elapsed / duration);
            const easedProgress = smoothEasing(progress);
            const newPosition = linearInterpolation(startPosition, targetPosition, easedProgress);
            
            window.scrollTo(0, newPosition);
            
            if (progress < 1) {
                requestAnimationFrame(animateScroll);
            } else {
                window.scrollTo(0, targetPosition);
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

// Initialize Project Cards
function initProjectCards() {
    const projectCards = document.querySelectorAll('.project-category-card');
    
    projectCards.forEach(card => {
        card.addEventListener('click', () => {
            const category = card.getAttribute('data-category');
            if (category) {
                window.location.href = `/projects/category/${category}`;
            }
        });
    });
}

// Export for use in Blade templates
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;