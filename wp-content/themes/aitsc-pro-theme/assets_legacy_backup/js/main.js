/**
 * AITSC Main JavaScript
 * Core functionality and interactive elements
 */

class AITSCMain {
    constructor() {
        this.isInitialized = false;
        this.init();
    }

    init() {
        if (this.isInitialized) return;

        document.addEventListener('DOMContentLoaded', () => {
            this.setupCoreFunctionality();
            this.setupAnimations();
            this.setupFormEnhancements();
            this.setupPerformanceOptimizations();
            this.isInitialized = true;
        });
    }

    setupCoreFunctionality() {
        this.setupExternalLinks();
        this.setupLazyLoading();
        this.setupFormValidation();
        this.setupClickTracking();
        this.setupErrorHandling();
    }

    setupExternalLinks() {
        // Open external links in new tab
        document.querySelectorAll('a[href^="http"]:not([href*="' + window.location.hostname + '"])').forEach(link => {
            link.setAttribute('target', '_blank');
            link.setAttribute('rel', 'noopener noreferrer');

            // Add external link icon
            if (!link.querySelector('.external-icon')) {
                const icon = document.createElement('span');
                icon.className = 'external-icon';
                icon.innerHTML = '↗';
                icon.setAttribute('aria-hidden', 'true');
                link.appendChild(icon);
            }
        });
    }

    setupLazyLoading() {
        // Native lazy loading for images
        document.querySelectorAll('img[data-src]').forEach(img => {
            img.classList.add('lazy-load');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy-load');
                        img.classList.add('loaded');
                        observer.unobserve(img);
                    }
                });
            });

            observer.observe(img);
        });

        // Lazy load background images
        document.querySelectorAll('[data-bg]').forEach(element => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        el.style.backgroundImage = `url(${el.dataset.bg})`;
                        el.classList.add('bg-loaded');
                        observer.unobserve(el);
                    }
                });
            });

            observer.observe(element);
        });
    }

    setupAnimations() {
        this.setupScrollAnimations();
        this.setupCounterAnimations();
        this.setupHoverEffects();
    }

    setupScrollAnimations() {
        const animatedElements = document.querySelectorAll('.animate-fade-in, .animate-slide-up, .animate-slide-left, .animate-slide-right');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const element = entry.target;
                    const delay = element.style.animationDelay || '0s';

                    setTimeout(() => {
                        element.style.opacity = '1';
                        element.style.transform = 'translateY(0)';
                        element.style.transform = 'translateX(0)';
                    }, parseFloat(delay) * 1000);

                    observer.unobserve(element);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '50px'
        });

        animatedElements.forEach(element => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(30px)';
            element.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            observer.observe(element);
        });
    }

    setupCounterAnimations() {
        const counters = document.querySelectorAll('[data-count]');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    const target = parseInt(counter.dataset.count);
                    const duration = 2000; // 2 seconds
                    const step = target / (duration / 16); // 60fps
                    let current = 0;

                    const updateCounter = () => {
                        current += step;
                        if (current < target) {
                            counter.textContent = Math.floor(current).toLocaleString();
                            requestAnimationFrame(updateCounter);
                        } else {
                            counter.textContent = target.toLocaleString();
                        }
                    };

                    updateCounter();
                    observer.unobserve(counter);
                }
            });
        }, {
            threshold: 1
        });

        counters.forEach(counter => observer.observe(counter));
    }

    setupHoverEffects() {
        // Enhanced button hover effects
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('mouseenter', (e) => {
                const rect = button.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                button.style.setProperty('--mouse-x', `${x}px`);
                button.style.setProperty('--mouse-y', `${y}px`);
            });
        });

        // Card hover effects
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                const centerX = rect.width / 2;
                const centerY = rect.height / 2;

                const rotateX = (y - centerY) / 10;
                const rotateY = (centerX - x) / 10;

                card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale(1)';
            });
        });
    }

    setupFormEnhancements() {
        // Enhanced form validation
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', (e) => {
                if (!this.validateForm(form)) {
                    e.preventDefault();
                    this.showFormErrors(form);
                }
            });
        });

        // Real-time validation feedback
        document.querySelectorAll('input, textarea, select').forEach(field => {
            field.addEventListener('blur', () => {
                this.validateField(field);
            });

            field.addEventListener('input', () => {
                if (field.classList.contains('error')) {
                    this.validateField(field);
                }
            });
        });
    }

    validateForm(form) {
        const fields = form.querySelectorAll('input[required], textarea[required], select[required]');
        let isValid = true;

        fields.forEach(field => {
            if (!this.validateField(field)) {
                isValid = false;
            }
        });

        return isValid;
    }

    validateField(field) {
        const value = field.value.trim();
        const isRequired = field.hasAttribute('required');
        const type = field.type;

        let isValid = true;
        let errorMessage = '';

        if (isRequired && !value) {
            isValid = false;
            errorMessage = 'This field is required';
        } else if (value) {
            switch (type) {
                case 'email':
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(value)) {
                        isValid = false;
                        errorMessage = 'Please enter a valid email address';
                    }
                    break;

                case 'tel':
                    const phoneRegex = /^[\d\s\-\+\(\)]+$/;
                    if (!phoneRegex.test(value)) {
                        isValid = false;
                        errorMessage = 'Please enter a valid phone number';
                    }
                    break;

                case 'url':
                    try {
                        new URL(value);
                    } catch {
                        isValid = false;
                        errorMessage = 'Please enter a valid URL';
                    }
                    break;
            }
        }

        this.updateFieldValidation(field, isValid, errorMessage);
        return isValid;
    }

    updateFieldValidation(field, isValid, errorMessage) {
        const formGroup = field.closest('.form-group') || field.parentElement;

        if (isValid) {
            field.classList.remove('error');
            field.classList.add('valid');
            formGroup.classList.remove('has-error');

            const errorElement = formGroup.querySelector('.field-error');
            if (errorElement) {
                errorElement.remove();
            }
        } else {
            field.classList.remove('valid');
            field.classList.add('error');
            formGroup.classList.add('has-error');

            let errorElement = formGroup.querySelector('.field-error');
            if (!errorElement) {
                errorElement = document.createElement('div');
                errorElement.className = 'field-error';
                formGroup.appendChild(errorElement);
            }

            errorElement.textContent = errorMessage;
        }
    }

    showFormErrors(form) {
        const firstError = form.querySelector('.error');
        if (firstError) {
            firstError.focus();
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    setupPerformanceOptimizations() {
        // Debounce resize events
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                this.handleResize();
            }, 250);
        });

        // Throttle scroll events
        let scrollTimeout;
        window.addEventListener('scroll', () => {
            if (!scrollTimeout) {
                scrollTimeout = setTimeout(() => {
                    this.handleScroll();
                    scrollTimeout = null;
                }, 100);
            }
        });

        // Preload critical resources
        this.preloadCriticalResources();
    }

    handleResize() {
        // Handle responsive behaviors
        document.body.classList.toggle('mobile-view', window.innerWidth <= 768);
        document.body.classList.toggle('tablet-view', window.innerWidth > 768 && window.innerWidth <= 1024);
        document.body.classList.toggle('desktop-view', window.innerWidth > 1024);
    }

    handleScroll() {
        const scrollY = window.pageYOffset;
        document.body.classList.toggle('scrolled', scrollY > 50);
    }

    preloadCriticalResources() {
        // Preload critical fonts
        const fontLinks = document.querySelectorAll('link[rel="preload"][as="font"]');
        fontLinks.forEach(link => {
            const font = new FontFace(link.getAttribute('href'), `url(${link.getAttribute('href')})`);
            document.fonts.add(font);
        });
    }

    setupClickTracking() {
        // Track button clicks for analytics
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', (e) => {
                const buttonText = button.textContent.trim();
                const buttonLocation = button.getAttribute('href') || 'no-link';

                // Send to analytics if available
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'button_click', {
                        button_text: buttonText,
                        button_location: buttonLocation
                    });
                }
            });
        });
    }

    setupErrorHandling() {
        // Global error handling
        window.addEventListener('error', (e) => {
            console.error('JavaScript Error:', e.error);
            this.logError('JavaScript Error', e.error.message, e.error.stack);
        });

        // Promise rejection handling
        window.addEventListener('unhandledrejection', (e) => {
            console.error('Unhandled Promise Rejection:', e.reason);
            this.logError('Promise Rejection', e.reason.message, e.reason.stack);
        });
    }

    logError(type, message, stack) {
        // Log errors to console for development
        console.error(`${type}: ${message}`);

        // In production, you might want to send this to a logging service
        if (window.location.hostname !== 'localhost') {
            // Example: Send to error tracking service
            // this.sendToErrorTracking(type, message, stack);
        }
    }

    // Utility methods
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

    throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }
}

// Initialize main application
window.aitscMain = new AITSCMain();

// Make utilities globally available
window.aitscUtils = {
    debounce: (func, wait) => window.aitscMain.debounce(func, wait),
    throttle: (func, limit) => window.aitscMain.throttle(func, limit)
};