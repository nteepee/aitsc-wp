/**
 * AITSC Advanced Animation Framework
 * WorldQuant-inspired micro-interactions and scroll animations
 *
 * @package AITSCProTheme
 * @since 1.0.0
 * @version 3.0.0
 */

class AITSCAnimations {
    constructor() {
        this.observerOptions = {
            root: null,
            rootMargin: '50px',
            threshold: [0, 0.1, 0.25, 0.5, 0.75, 1]
        };

        this.animationPresets = {
            fadeInUp: {
                initial: { opacity: 0, transform: 'translateY(40px)' },
                animate: { opacity: 1, transform: 'translateY(0)' },
                duration: 800,
                easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)'
            },
            fadeInLeft: {
                initial: { opacity: 0, transform: 'translateX(-40px)' },
                animate: { opacity: 1, transform: 'translateX(0)' },
                duration: 800,
                easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)'
            },
            fadeInRight: {
                initial: { opacity: 0, transform: 'translateX(40px)' },
                animate: { opacity: 1, transform: 'translateX(0)' },
                duration: 800,
                easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)'
            },
            scaleIn: {
                initial: { opacity: 0, transform: 'scale(0.9)' },
                animate: { opacity: 1, transform: 'scale(1)' },
                duration: 600,
                easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)'
            },
            slideInFromTop: {
                initial: { opacity: 0, transform: 'translateY(-30px)' },
                animate: { opacity: 1, transform: 'translateY(0)' },
                duration: 700,
                easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)'
            },
            textReveal: {
                initial: { opacity: 0, transform: 'translateY(20px)' },
                animate: { opacity: 1, transform: 'translateY(0)' },
                duration: 1000,
                stagger: 100,
                easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)'
            }
        };

        this.prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
        this.init();
    }

    init() {
        if (!this.prefersReducedMotion.matches) {
            this.setupIntersectionObserver();
            this.setupScrollAnimations();
            this.setupTextAnimations();
            this.setupParallaxEffects();
            this.setupCounterAnimations();
            this.setupScrollIndicators();
            this.setupFilterAnimations();
            this.setupAdvancedInteractions();
        }
        this.bindEvents();
    }

    setupIntersectionObserver() {
        // Main intersection observer for scroll animations
        this.intersectionObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const element = entry.target;
                const animationType = element.dataset.animation || 'fadeInUp';
                const delay = parseFloat(element.dataset.delay || 0);
                const threshold = parseFloat(element.dataset.threshold || 0.1);

                if (entry.isIntersecting && entry.intersectionRatio >= threshold) {
                    setTimeout(() => {
                        this.animateElement(element, animationType);
                    }, delay);

                    this.intersectionObserver.unobserve(element);
                }
            });
        }, this.observerOptions);

        // Initialize animation observers
        this.initializeAnimatedElements();
    }

    initializeAnimatedElements() {
        // Find all elements with animation data attributes
        const animatedElements = document.querySelectorAll('[data-animation]');
        animatedElements.forEach(element => {
            const animationType = element.dataset.animation;
            const preset = this.animationPresets[animationType];

            if (preset) {
                // Set initial state
                Object.assign(element.style, {
                    ...preset.initial,
                    transition: 'none'
                });

                // Start observing
                this.intersectionObserver.observe(element);
            }
        });

        // Setup word-by-word text animations
        const textElements = document.querySelectorAll('[data-text-animation]');
        textElements.forEach(element => this.setupTextAnimation(element));
    }

    animateElement(element, animationType) {
        const preset = this.animationPresets[animationType];
        if (!preset) return;

        // Add active class for CSS transitions
        element.classList.add('animation-active');

        // Apply animated styles
        Object.assign(element.style, {
            ...preset.animate,
            transition: `all ${preset.duration}ms ${preset.easing}`
        });

        // Trigger reflow for immediate animation
        element.offsetHeight;

        // Remove active class after animation completes
        setTimeout(() => {
            element.classList.remove('animation-active');
            element.classList.add('animation-complete');
        }, preset.duration);
    }

    setupTextAnimations() {
        // Hero text word animations
        const heroTitle = document.querySelector('.hero-title');
        if (heroTitle) {
            this.animateHeroTitle(heroTitle);
        }

        // Subtitle letter animations
        const subtitle = document.querySelector('.hero-subtitle');
        if (subtitle) {
            this.animateSubtitle(subtitle);
        }

        // Staggered list animations
        const staggeredLists = document.querySelectorAll('[data-stagger]');
        staggeredLists.forEach(list => this.setupStaggeredList(list));
    }

    animateHeroTitle(element) {
        const text = element.textContent;
        const words = text.split(' ');
        const delay = 150; // milliseconds between words

        element.innerHTML = words.map((word, index) => {
            return `<span class="hero-word" style="transition-delay: ${index * delay}ms">${word}</span>`;
        }).join(' ');

        // Animate each word
        const wordElements = element.querySelectorAll('.hero-word');
        wordElements.forEach((wordElement, index) => {
            setTimeout(() => {
                wordElement.classList.add('word-revealed');
            }, index * delay);
        });
    }

    animateSubtitle(element) {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        element.style.transition = 'all 1000ms cubic-bezier(0.25, 0.46, 0.45, 0.94)';

        setTimeout(() => {
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }, 500);
    }

    setupStaggeredList(list) {
        const items = list.children;
        const delay = parseFloat(list.dataset.delay || 100);

        Array.from(items).forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = `all 600ms cubic-bezier(0.25, 0.46, 0.45, 0.94) ${index * delay}ms`;
        });

        // Start animation when list becomes visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const list = entry.target;
                    const items = list.children;

                    Array.from(items).forEach((item, index) => {
                        setTimeout(() => {
                            item.style.opacity = '1';
                            item.style.transform = 'translateY(0)';
                        }, index * delay);
                    });

                    observer.unobserve(list);
                }
            });
        }, { threshold: 0.1 });

        observer.observe(list);
    }

    setupTextAnimation(element) {
        const animationType = element.dataset.textAnimation;
        const text = element.textContent;

        if (animationType === 'chars') {
            this.animateByChars(element, text);
        } else if (animationType === 'words') {
            this.animateByWords(element, text);
        }
    }

    animateByChars(element, text) {
        const chars = text.split('');
        const delay = parseFloat(element.dataset.charDelay || 50);

        element.innerHTML = chars.map((char, index) => {
            return `<span class="char" style="transition-delay: ${index * delay}ms">${char === ' ' ? '&nbsp;' : char}</span>`;
        }).join('');

        // Trigger animation
        setTimeout(() => {
            const charElements = element.querySelectorAll('.char');
            charElements.forEach(charElement => {
                charElement.classList.add('char-revealed');
            });
        }, 100);
    }

    animateByWords(element, text) {
        const words = text.split(' ');
        const delay = parseFloat(element.dataset.wordDelay || 150);

        element.innerHTML = words.map((word, index) => {
            return `<span class="word" style="transition-delay: ${index * delay}ms">${word}</span>`;
        }).join(' ');

        // Trigger animation
        setTimeout(() => {
            const wordElements = element.querySelectorAll('.word');
            wordElements.forEach((wordElement, index) => {
                setTimeout(() => {
                    wordElement.classList.add('word-revealed');
                }, index * delay);
            });
        }, 100);
    }

    setupScrollAnimations() {
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', (e) => {
                e.preventDefault();
                const target = document.querySelector(anchor.getAttribute('href'));
                if (target) {
                    this.smoothScrollTo(target);
                }
            });
        });

        // Progress indicator
        this.setupScrollIndicator();

        // Scroll-based parallax
        this.setupScrollParallax();
    }

    smoothScrollTo(target, offset = 80) {
        const targetPosition = target.offsetTop - offset;
        const startPosition = window.pageYOffset;
        const distance = targetPosition - startPosition;
        const duration = 800;

        let start = null;

        const animation = (currentTime) => {
            if (start === null) start = currentTime;
            const timeElapsed = currentTime - start;
            const progress = Math.min(timeElapsed / duration, 1);

            const easeProgress = this.easeInOutCubic(progress);
            window.scrollTo(0, startPosition + (distance * easeProgress));

            if (timeElapsed < duration) {
                requestAnimationFrame(animation);
            }
        };

        requestAnimationFrame(animation);
    }

    setupScrollIndicator() {
        const indicator = document.querySelector('.scroll-indicator');
        if (!indicator) return;

        window.addEventListener('scroll', () => {
            const scrollHeight = document.documentElement.scrollHeight - window.innerHeight;
            const scrollPosition = window.pageYOffset;
            const progress = (scrollPosition / scrollHeight) * 100;

            indicator.style.width = `${progress}%`;
        });
    }

    setupParallaxEffects() {
        // Parallax scrolling for background elements
        const parallaxElements = document.querySelectorAll('[data-parallax]');

        if (parallaxElements.length === 0) return;

        const handleParallax = () => {
            const scrolled = window.pageYOffset;

            parallaxElements.forEach(element => {
                const speed = parseFloat(element.dataset.parallax || 0.5);
                const yPos = -(scrolled * speed);

                element.style.transform = `translateY(${yPos}px)`;
            });
        };

        // Use throttled scroll handler for performance
        let ticking = false;
        const requestTick = () => {
            if (!ticking) {
                requestAnimationFrame(handleParallax);
                ticking = true;
                setTimeout(() => { ticking = false; }, 16); // ~60fps
            }
        };

        window.addEventListener('scroll', requestTick, { passive: true });
    }

    setupScrollParallax() {
        // Mouse-based parallax for hero sections
        const heroSection = document.querySelector('.hero-section');
        if (!heroSection) return;

        const handleMouseMove = (e) => {
            const { clientX, clientY } = e;
            const { innerWidth, innerHeight } = window;
            const mouseX = (clientX - innerWidth / 2) / innerWidth;
            const mouseY = (clientY - innerHeight / 2) / innerHeight;

            const parallaxElements = heroSection.querySelectorAll('[data-mouse-parallax]');

            parallaxElements.forEach(element => {
                const speed = parseFloat(element.dataset.mouseParallax || 10);
                const x = mouseX * speed;
                const y = mouseY * speed;

                element.style.transform = `translate(${x}px, ${y}px)`;
            });
        };

        heroSection.addEventListener('mousemove', handleMouseMove);
    }

    setupCounterAnimations() {
        const counters = document.querySelectorAll('[data-count]');

        const observerOptions = {
            threshold: 1,
            rootMargin: '0px'
        };

        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    const target = parseInt(counter.dataset.count);
                    const duration = parseInt(counter.dataset.duration || 2000);
                    const prefix = counter.dataset.prefix || '';
                    const suffix = counter.dataset.suffix || '';

                    this.animateCounter(counter, target, duration, prefix, suffix);
                    counterObserver.unobserve(counter);
                }
            });
        }, observerOptions);

        counters.forEach(counter => counterObserver.observe(counter));
    }

    animateCounter(element, target, duration, prefix = '', suffix = '') {
        const start = 0;
        const increment = target / (duration / 16); // 60fps
        let current = start;

        const updateCounter = () => {
            current += increment;
            if (current < target) {
                element.textContent = prefix + Math.floor(current).toLocaleString() + suffix;
                requestAnimationFrame(updateCounter);
            } else {
                element.textContent = prefix + target.toLocaleString() + suffix;
            }
        };

        updateCounter();
    }

    setupScrollIndicators() {
        // Scroll progress bar
        const progressBar = document.createElement('div');
        progressBar.className = 'scroll-progress';
        progressBar.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent-primary), var(--accent-hover));
            z-index: 10000;
            transition: width 0.1s ease;
        `;

        document.body.appendChild(progressBar);

        window.addEventListener('scroll', () => {
            const scrollHeight = document.documentElement.scrollHeight - window.innerHeight;
            const scrollPosition = window.pageYOffset;
            const progress = (scrollPosition / scrollHeight) * 100;

            progressBar.style.width = `${progress}%`;
        });

        // Scroll to top button
        const scrollToTop = document.createElement('button');
        scrollToTop.className = 'scroll-to-top';
        scrollToTop.innerHTML = `
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M18 15l-6-6-6 6"/>
            </svg>
            <span class="sr-only">Scroll to top</span>
        `;
        scrollToTop.setAttribute('aria-label', 'Scroll to top');

        document.body.appendChild(scrollToTop);

        // Show/hide scroll to top button
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                scrollToTop.classList.add('visible');
            } else {
                scrollToTop.classList.remove('visible');
            }
        });

        // Scroll to top functionality
        scrollToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    setupFilterAnimations() {
        // Case study and solution filters
        const filterButtons = document.querySelectorAll('.filter-btn');
        const filterItems = document.querySelectorAll('[data-category]');

        if (filterButtons.length === 0) return;

        filterButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();

                // Update active button
                filterButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');

                const filter = button.dataset.filter;

                // Animate items
                filterItems.forEach((item, index) => {
                    const category = item.dataset.category;
                    const shouldShow = filter === 'all' || category === filter;

                    if (shouldShow) {
                        // Fade in with stagger
                        setTimeout(() => {
                            item.style.display = '';
                            item.style.opacity = '0';
                            item.style.transform = 'translateY(20px)';

                            requestAnimationFrame(() => {
                                item.style.transition = 'all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
                                item.style.opacity = '1';
                                item.style.transform = 'translateY(0)';
                            });
                        }, index * 100);
                    } else {
                        // Fade out
                        item.style.transition = 'all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
                        item.style.opacity = '0';
                        item.style.transform = 'translateY(20px)';

                        setTimeout(() => {
                            item.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });
    }

    setupAdvancedInteractions() {
        // Magnetic buttons
        const magneticButtons = document.querySelectorAll('.magnetic-btn');

        magneticButtons.forEach(button => {
            button.addEventListener('mousemove', (e) => {
                const rect = button.getBoundingClientRect();
                const x = e.clientX - rect.left - rect.width / 2;
                const y = e.clientY - rect.top - rect.height / 2;

                const distance = Math.sqrt(x * x + y * y);
                const maxDistance = 50;

                if (distance < maxDistance) {
                    const strength = (maxDistance - distance) / maxDistance;
                    const moveX = (x / maxDistance) * strength * 10;
                    const moveY = (y / maxDistance) * strength * 10;

                    button.style.transform = `translate(${moveX}px, ${moveY}px) scale(${1 + strength * 0.05})`;
                }
            });

            button.addEventListener('mouseleave', () => {
                button.style.transform = '';
            });
        });

        // Image tilt effects
        const tiltImages = document.querySelectorAll('.tilt-image');

        tiltImages.forEach(image => {
            image.addEventListener('mousemove', (e) => {
                const rect = image.getBoundingClientRect();
                const x = (e.clientX - rect.left) / rect.width;
                const y = (e.clientY - rect.top) / rect.height;

                const rotateX = (y - 0.5) * 20;
                const rotateY = (x - 0.5) * -20;

                image.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.05, 1.05, 1.05)`;
            });

            image.addEventListener('mouseleave', () => {
                image.style.transform = '';
            });
        });

        // Ripple effects
        const rippleButtons = document.querySelectorAll('.ripple-btn');

        rippleButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                const ripple = document.createElement('span');
                const rect = button.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');

                button.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    }

    bindEvents() {
        // Handle resize events
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                this.handleResize();
            }, 250);
        });

        // Handle visibility change
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                this.pauseAnimations();
            } else {
                this.resumeAnimations();
            }
        });

        // Handle reduced motion changes
        this.prefersReducedMotion.addEventListener('change', () => {
            if (this.prefersReducedMotion.matches) {
                this.disableAnimations();
            } else {
                this.enableAnimations();
            }
        });
    }

    handleResize() {
        // Recalculate element positions and states
        const animatedElements = document.querySelectorAll('[data-animation]');
        animatedElements.forEach(element => {
            // Reset animations for responsive behavior
            if (element.classList.contains('animation-complete')) {
                this.intersectionObserver.observe(element);
            }
        });
    }

    pauseAnimations() {
        // Pause ongoing animations when page is hidden
        document.querySelectorAll('.animation-active').forEach(element => {
            element.style.animationPlayState = 'paused';
        });
    }

    resumeAnimations() {
        // Resume animations when page becomes visible
        document.querySelectorAll('.animation-active').forEach(element => {
            element.style.animationPlayState = 'running';
        });
    }

    disableAnimations() {
        document.body.classList.add('reduced-motion');

        // Remove all animation classes
        document.querySelectorAll('[class*="animate-"], .animation-active, .animation-complete').forEach(element => {
            element.style.transition = 'none';
            element.style.animation = 'none';
            element.style.transform = 'none';
            element.style.opacity = '1';
        });
    }

    enableAnimations() {
        document.body.classList.remove('reduced-motion');
        this.init();
    }

    // Utility methods
    easeInOutCubic(t) {
        return t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;
    }

    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Public API for external use
    animateElement(element, animationType, delay = 0) {
        setTimeout(() => {
            this.animateElement(element, animationType);
        }, delay);
    }

    createAnimation(type, options = {}) {
        const preset = this.animationPresets[type];
        if (!preset) return null;

        return {
            ...preset,
            ...options
        };
    }
}

// Initialize animation system
document.addEventListener('DOMContentLoaded', () => {
    window.aitscAnimations = new AITSCAnimations();

    // Make animation utilities globally available
    window.animateElement = (element, type, delay = 0) => {
        window.aitscAnimations.animateElement(element, type, delay);
    };
});

// Add CSS for advanced animations
const advancedAnimationStyles = `
    /* Word Animation Support */
    .hero-word {
        display: inline-block;
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .hero-word.word-revealed {
        opacity: 1;
        transform: translateY(0);
    }

    /* Character Animation Support */
    .char {
        display: inline-block;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .char.char-revealed {
        opacity: 1;
        transform: translateY(0);
    }

    /* Word Animation Support */
    .word {
        display: inline-block;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .word.word-revealed {
        opacity: 1;
        transform: translateY(0);
    }

    /* Parallax Support */
    [data-parallax] {
        will-change: transform;
    }

    [data-mouse-parallax] {
        will-change: transform;
        transition: transform 0.1s ease-out;
    }

    /* Scroll to Top Button */
    .scroll-to-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        background-color: var(--accent-primary);
        color: var(--text-primary);
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.3s ease;
        z-index: 1000;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .scroll-to-top.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .scroll-to-top:hover {
        background-color: var(--accent-hover);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }

    .scroll-to-top:focus {
        outline: 2px solid var(--accent-primary);
        outline-offset: 2px;
    }

    /* Magnetic Buttons */
    .magnetic-btn {
        transition: transform 0.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    /* Tilt Images */
    .tilt-image {
        transition: transform 0.1s ease-out;
        transform-style: preserve-3d;
    }

    /* Ripple Effects */
    .ripple-btn {
        position: relative;
        overflow: hidden;
    }

    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.6);
        transform: scale(0);
        animation: ripple-animation 0.6s ease-out;
        pointer-events: none;
    }

    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

    /* Reduced Motion Support */
    @media (prefers-reduced-motion: reduce) {
        [data-animation],
        .hero-word,
        .char,
        .word,
        .scroll-progress,
        .scroll-to-top {
            animation: none !important;
            transition: none !important;
            opacity: 1 !important;
            transform: none !important;
        }

        [data-parallax],
        [data-mouse-parallax] {
            transform: none !important;
        }

        .magnetic-btn,
        .tilt-image {
            transform: none !important;
        }

        .ripple {
            display: none !important;
        }
    }

    /* Animation Delays */
    .delay-100 { transition-delay: 100ms; }
    .delay-200 { transition-delay: 200ms; }
    .delay-300 { transition-delay: 300ms; }
    .delay-400 { transition-delay: 400ms; }
    .delay-500 { transition-delay: 500ms; }
    .delay-600 { transition-delay: 600ms; }
    .delay-700 { transition-delay: 700ms; }
    .delay-800 { transition-delay: 800ms; }
    .delay-900 { transition-delay: 900ms; }
    .delay-1000 { transition-delay: 1000ms; }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .scroll-to-top {
            bottom: 20px;
            right: 20px;
            width: 45px;
            height: 45px;
        }

        .tilt-image,
        .magnetic-btn {
            transform: none !important;
        }
    }
`;

// Inject styles
const style = document.createElement('style');
style.textContent = advancedAnimationStyles;
document.head.appendChild(style);