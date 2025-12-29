/**
 * AITSC Pro Theme - Animations JavaScript
 * Scroll animations and intersection observer functionality
 *
 * @package AITSCProTheme
 * @since 1.0.0
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // Check for reduced motion preference
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

    // Initialize animations if user prefers reduced motion is false
    if (!prefersReducedMotion.matches) {
        initScrollAnimations();
        initCounterAnimations();
        initParallaxEffects();
        initStaggerAnimations();
    }

    // Initialize loading animations
    initLoadingAnimations();

    // Initialize hover animations
    initHoverAnimations();

    /**
     * Scroll-triggered animations using Intersection Observer
     */
    function initScrollAnimations() {
        const animatedElements = document.querySelectorAll([
            '.observer-fadeIn',
            '.observer-fadeInLeft',
            '.observer-fadeInRight',
            '.observer-scaleIn',
            '.card',
            '.service-card',
            '.post-card',
            '.testimonial',
            '.team-member',
            '.portfolio-item'
        ].join(', '));

        if (animatedElements.length === 0) return;

        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const animationObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const element = entry.target;

                    // Add animation classes
                    if (element.classList.contains('observer-fadeIn')) {
                        element.classList.add('is-visible');
                    } else if (element.classList.contains('observer-fadeInLeft')) {
                        element.classList.add('is-visible');
                    } else if (element.classList.contains('observer-fadeInRight')) {
                        element.classList.add('is-visible');
                    } else if (element.classList.contains('observer-scaleIn')) {
                        element.classList.add('is-visible');
                    } else {
                        // Default animation for cards and other elements
                        element.classList.add('animate-fadeInUp');
                    }

                    // Stop observing the element after animation
                    animationObserver.unobserve(element);
                }
            });
        }, observerOptions);

        animatedElements.forEach(function(element) {
            animationObserver.observe(element);
        });
    }

    /**
     * Counter animations for statistics
     */
    function initCounterAnimations() {
        const counters = document.querySelectorAll('.counter');

        if (counters.length === 0) return;

        const counterObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    const target = parseInt(counter.getAttribute('data-target')) || 0;
                    const duration = parseInt(counter.getAttribute('data-duration')) || 2000;

                    animateCounter(counter, target, duration);
                    counterObserver.unobserve(counter);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(function(counter) {
            counterObserver.observe(counter);
        });
    }

    function animateCounter(element, target, duration) {
        const start = 0;
        const increment = target / (duration / 16);
        let current = start;

        const updateCounter = function() {
            current += increment;

            if (current < target) {
                element.textContent = Math.floor(current).toLocaleString();
                requestAnimationFrame(updateCounter);
            } else {
                element.textContent = target.toLocaleString();
            }
        };

        updateCounter();
    }

    /**
     * Parallax effects for hero sections and backgrounds
     */
    function initParallaxEffects() {
        const parallaxElements = document.querySelectorAll('.parallax, .hero-bg-video.parallax');

        if (parallaxElements.length === 0) return;

        let ticking = false;

        function updateParallax() {
            const scrolled = window.pageYOffset;

            parallaxElements.forEach(el => {
                // Different speeds for different elements
                const speed = el.dataset.parallaxSpeed || 0.5;
                const yPos = -(scrolled * parseFloat(speed));

                // Use transform for GPU acceleration
                el.style.transform = `translateY(${yPos}px)`;
            });

            ticking = false;
        }

        function requestTick() {
            if (!ticking) {
                window.requestAnimationFrame(updateParallax);
                ticking = true;
            }
        }

        window.addEventListener('scroll', requestTick, { passive: true });

        // Disable parallax on mobile
        if (window.matchMedia('(max-width: 768px)').matches) {
            parallaxElements.forEach(el => {
                el.style.transform = 'none';
            });
        }
    }

    /**
     * Staggered animations for multiple elements
     */
    function initStaggerAnimations() {
        const staggerContainers = document.querySelectorAll('.stagger-children');

        if (staggerContainers.length === 0) return;

        const staggerObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const container = entry.target;
                    const children = container.children;

                    Array.from(children).forEach(function(child, index) {
                        setTimeout(function() {
                            child.style.animationDelay = `${index * 0.1}s`;
                            child.classList.add('animate-fadeInUp');
                        }, index * 100);
                    });

                    staggerObserver.unobserve(container);
                }
            });
        }, { threshold: 0.1 });

        staggerContainers.forEach(function(container) {
            staggerObserver.observe(container);
        });
    }

    /**
     * Loading animations for page load
     */
    function initLoadingAnimations() {
        // Add page load animation class to body
        document.body.classList.add('page-load-animation');

        // Animate hero section on load
        const heroSection = document.querySelector('.hero-section');
        if (heroSection) {
            heroSection.classList.add('animate-fadeIn');
        }

        // Animate main content with delay
        const mainContent = document.querySelector('main, .content-area');
        if (mainContent) {
            setTimeout(function() {
                mainContent.classList.add('animate-fadeInUp');
            }, 300);
        }

        // Remove loading class after animations complete
        setTimeout(function() {
            document.body.classList.add('page-loaded');
        }, 1500);
    }

    /**
     * Hover animations for interactive elements
     */
    function initHoverAnimations() {
        // Card hover effects
        const cards = document.querySelectorAll('.card, .service-card, .post-card');

        cards.forEach(function(card) {
            card.addEventListener('mouseenter', function() {
                this.classList.add('animate-float');
            });

            card.addEventListener('mouseleave', function() {
                this.classList.remove('animate-float');
            });
        });

        // Button hover effects
        const buttons = document.querySelectorAll('.button, .btn');

        buttons.forEach(function(button) {
            button.addEventListener('mouseenter', function() {
                this.classList.add('animate-pulse');
            });

            button.addEventListener('mouseleave', function() {
                this.classList.remove('animate-pulse');
            });
        });

        // Image hover effects
        const images = document.querySelectorAll('.post-thumbnail img, .service-image img');

        images.forEach(function(img) {
            img.addEventListener('mouseenter', function() {
                this.classList.add('animate-zoom');
            });

            img.addEventListener('mouseleave', function() {
                this.classList.remove('animate-zoom');
            });
        });
    }

    /**
     * Smooth reveal for tab content
     */
    function initTabAnimations() {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabPanels = document.querySelectorAll('.tab-panel');

        if (tabButtons.length === 0) return;

        tabButtons.forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const targetId = button.getAttribute('href') || button.getAttribute('data-target');
                const targetPanel = document.querySelector(targetId);

                if (targetPanel) {
                    // Hide all panels with animation
                    tabPanels.forEach(function(panel) {
                        panel.classList.add('animate-fadeOut');
                        setTimeout(function() {
                            panel.style.display = 'none';
                            panel.classList.remove('animate-fadeOut');
                        }, 300);
                    });

                    // Show target panel with animation
                    setTimeout(function() {
                        targetPanel.style.display = 'block';
                        targetPanel.classList.add('animate-fadeIn');
                    }, 300);

                    // Update active states
                    tabButtons.forEach(function(btn) {
                        btn.classList.remove('active');
                        btn.setAttribute('aria-selected', 'false');
                    });

                    button.classList.add('active');
                    button.setAttribute('aria-selected', 'true');
                }
            });
        });
    }

    /**
     * Accordion animations
     */
    function initAccordionAnimations() {
        const accordionButtons = document.querySelectorAll('.accordion-button');

        accordionButtons.forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const content = button.nextElementSibling;
                const isExpanded = button.getAttribute('aria-expanded') === 'true';

                if (isExpanded) {
                    // Close accordion
                    content.style.maxHeight = null;
                    button.setAttribute('aria-expanded', 'false');
                    button.classList.remove('is-active');
                } else {
                    // Open accordion
                    content.style.maxHeight = content.scrollHeight + 'px';
                    button.setAttribute('aria-expanded', 'true');
                    button.classList.add('is-active');

                    // Close other accordions in the same group
                    const accordionGroup = button.closest('.accordion');
                    if (accordionGroup) {
                        const otherButtons = accordionGroup.querySelectorAll('.accordion-button');
                        otherButtons.forEach(function(otherButton) {
                            if (otherButton !== button) {
                                const otherContent = otherButton.nextElementSibling;
                                otherContent.style.maxHeight = null;
                                otherButton.setAttribute('aria-expanded', 'false');
                                otherButton.classList.remove('is-active');
                            }
                        });
                    }
                }
            });
        });
    }

    /**
     * Modal animations
     */
    function initModalAnimations() {
        const modalTriggers = document.querySelectorAll('[data-modal-trigger]');
        const modals = document.querySelectorAll('.modal');
        const closeButtons = document.querySelectorAll('.modal-close, [data-modal-close]');

        modalTriggers.forEach(function(trigger) {
            trigger.addEventListener('click', function(e) {
                e.preventDefault();

                const modalId = trigger.getAttribute('data-modal-trigger');
                const modal = document.querySelector(modalId);

                if (modal) {
                    modal.classList.add('is-active');
                    modal.classList.add('animate-fadeIn');
                    document.body.style.overflow = 'hidden';

                    // Focus management
                    const focusableElements = modal.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
                    if (focusableElements.length > 0) {
                        focusableElements[0].focus();
                    }
                }
            });
        });

        closeButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                closeModal(this.closest('.modal'));
            });
        });

        // Close modal on background click
        modals.forEach(function(modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal(modal);
                }
            });
        });

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const activeModal = document.querySelector('.modal.is-active');
                if (activeModal) {
                    closeModal(activeModal);
                }
            }
        });

        function closeModal(modal) {
            modal.classList.add('animate-fadeOut');
            setTimeout(function() {
                modal.classList.remove('is-active', 'animate-fadeIn', 'animate-fadeOut');
                document.body.style.overflow = '';
            }, 300);
        }
    }

    /**
     * Loading states for AJAX requests
     */
    function initLoadingStates() {
        const loadingElements = document.querySelectorAll('[data-loading]');

        loadingElements.forEach(function(element) {
            element.addEventListener('click', function() {
                const loadingText = element.getAttribute('data-loading');
                const originalText = element.textContent;

                // Show loading state
                element.disabled = true;
                element.classList.add('loading');

                if (loadingText) {
                    element.textContent = loadingText;
                } else {
                    element.innerHTML = '<span class="spinner"></span> Loading...';
                }

                // Reset after timeout (adjust as needed for actual AJAX)
                setTimeout(function() {
                    element.disabled = false;
                    element.classList.remove('loading');
                    element.textContent = originalText;
                }, 2000);
            });
        });
    }

    /**
     * Handle reduced motion preference changes
     */
    prefersReducedMotion.addEventListener('change', function() {
        if (prefersReducedMotion.matches) {
            // Disable animations
            document.body.classList.add('reduced-motion');

            // Remove animation classes
            document.querySelectorAll('[class*="animate-"]').forEach(function(element) {
                element.classList.remove.apply(element.classList, Array.from(element.classList).filter(c => c.startsWith('animate-')));
            });
        } else {
            // Re-enable animations
            document.body.classList.remove('reduced-motion');
            initScrollAnimations();
        }
    });

    // Initialize additional features
    initTabAnimations();
    initAccordionAnimations();
    initModalAnimations();
    initLoadingStates();

    // Add CSS for dynamically created elements
    const style = document.createElement('style');
    style.textContent = `
        .animate-fadeOut {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.3s ease-out, transform 0.3s ease-out;
        }

        .loading {
            opacity: 0.7;
            cursor: not-allowed !important;
            position: relative;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 16px;
            height: 16px;
            margin: -8px 0 0 -8px;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        .reduced-motion * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }

        .parallax {
            will-change: transform;
        }
    `;
    document.head.appendChild(style);
});