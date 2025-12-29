/**
 * AITSC Interactive JavaScript
 *
 * Enhanced functionality for contact forms, animations, and user interactions
 * WorldQuant-inspired interactive elements and smooth transitions
 *
 * @package AITSC_Pro_Theme
 * @since 2.0.1
 */

// Strict mode for better error handling
'use strict';

// Main AITSC Interactive Object
const AITSCInteractive = {
    // Configuration
    config: {
        animationDuration: 300,
        debounceDelay: 300,
        parallaxSpeed: 0.5,
        scrollThreshold: 100,
        formValidationDelay: 500
    },

    // State management
    state: {
        isFormSubmitting: false,
        currentFormStep: 1,
        scrollY: 0,
        isMobile: false,
        animationsEnabled: true
    },

    // Initialize all functionality
    init() {
        this.setupDeviceDetection();
        this.setupScrollEffects();
        this.setupAnimations();
        this.setupForms();
        this.setupNavigation();
        this.setupParallaxEffects();
        this.setupScrollReveal();
        this.setupLazyLoading();
        this.setupKeyboardNavigation();

        // Initialize AOS if available
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 800,
                once: true,
                offset: 100
            });
        }

        console.log('AITSC Interactive initialized');
    },

    // Device detection for responsive behavior
    setupDeviceDetection() {
        const checkDevice = () => {
            this.state.isMobile = window.innerWidth < 768;
            document.body.classList.toggle('mobile-device', this.state.isMobile);
            document.body.classList.toggle('desktop-device', !this.state.isMobile);
        };

        checkDevice();
        window.addEventListener('resize', this.debounce(checkDevice, this.config.debounceDelay));
    },

    // Enhanced scroll effects
    setupScrollEffects() {
        let ticking = false;

        const updateScrollEffects = () => {
            this.state.scrollY = window.pageYOffset;

            // Header scroll effects
            const header = document.querySelector('.site-header');
            if (header) {
                if (this.state.scrollY > this.config.scrollThreshold) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            }

            // Progress indicators
            this.updateProgressIndicators();

            ticking = false;
        };

        const onScroll = () => {
            if (!ticking) {
                requestAnimationFrame(updateScrollEffects);
                ticking = true;
            }
        };

        window.addEventListener('scroll', onScroll, { passive: true });
    },

    // Animation setup
    setupAnimations() {
        // Intersection Observer for scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '50px 0px -50px 0px'
        };

        const animationObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-visible');
                    animationObserver.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe elements with animation classes
        document.querySelectorAll('.animate-slide-up, .animate-fade-in-up, .animate-slide-left, .animate-slide-right').forEach(el => {
            animationObserver.observe(el);
        });
    },

    // Advanced form handling
    setupForms() {
        // Multi-step contact form
        const multiStepForm = document.getElementById('aitsc-multi-step-form');
        if (multiStepForm) {
            this.setupMultiStepForm(multiStepForm);
        }

        // Single contact form
        const singleForm = document.getElementById('aitsc-single-form');
        if (singleForm) {
            this.setupSingleForm(singleForm);
        }

        // Form validation
        document.addEventListener('blur', this.handleFieldValidation, true);
        document.addEventListener('input', this.handleFieldInput, true);
    },

    // Multi-step form functionality
    setupMultiStepForm(form) {
        const steps = form.querySelectorAll('.form-step');
        const progressSteps = form.querySelectorAll('.progress-step');
        const progressFill = form.querySelector('.progress-fill');
        const nextButtons = form.querySelectorAll('.next-step');
        const prevButtons = form.querySelectorAll('.previous-step');

        const updateProgress = () => {
            const progressPercentage = (this.state.currentFormStep / steps.length) * 100;
            progressFill.style.width = `${progressPercentage}%`;

            progressSteps.forEach((step, index) => {
                step.classList.toggle('active', index + 1 === this.state.currentFormStep);
                step.classList.toggle('completed', index + 1 < this.state.currentFormStep);
            });
        };

        const showStep = (stepNumber) => {
            steps.forEach((step, index) => {
                step.classList.toggle('active', index + 1 === stepNumber);
            });

            this.state.currentFormStep = stepNumber;
            updateProgress();

            // Scroll to form top
            form.scrollIntoView({ behavior: 'smooth', block: 'start' });
        };

        const validateStep = (stepNumber) => {
            const currentStepElement = form.querySelector(`.form-step[data-step="${stepNumber}"]`);
            const requiredFields = currentStepElement.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!this.validateField(field)) {
                    isValid = false;
                }
            });

            // Check service selection for step 3
            if (stepNumber === 3) {
                const checkedServices = form.querySelectorAll('input[name="services[]"]:checked');
                if (checkedServices.length === 0) {
                    this.showFieldError(form.querySelector('input[name="services[]"]'), 'Please select at least one service');
                    isValid = false;
                }
            }

            return isValid;
        };

        const populateReview = () => {
            const reviewContact = document.getElementById('review-contact');
            const reviewBusiness = document.getElementById('review-business');
            const reviewServices = document.getElementById('review-services');

            if (reviewContact) {
                const firstNameElement = form.querySelector('#contact-first-name');
                const firstName = firstNameElement ? firstNameElement.value : '';
                const lastNameElement = form.querySelector('#contact-last-name');
                const lastName = lastNameElement ? lastNameElement.value : '';
                const emailElement = form.querySelector('#contact-email');
                const email = emailElement ? emailElement.value : '';
                const phoneElement = form.querySelector('#contact-phone');
                const phone = phoneElement ? phoneElement.value : '';

                reviewContact.innerHTML = `
                    <p><strong>Name:</strong> ${firstName} ${lastName}</p>
                    <p><strong>Email:</strong> ${email}</p>
                    <p><strong>Phone:</strong> ${phone}</p>
                `;
            }

            if (reviewBusiness) {
                const companyElement = form.querySelector('#company-name');
                const company = companyElement ? companyElement.value : '';
                const sizeElement = form.querySelector('#company-size');
                const size = sizeElement ? sizeElement.value : '';
                const industryElement = form.querySelector('#industry');
                const industry = industryElement ? industryElement.value : '';
                const vehiclesElement = form.querySelector('#vehicle-count');
                const vehicles = vehiclesElement ? vehiclesElement.value : '';

                reviewBusiness.innerHTML = `
                    <p><strong>Company:</strong> ${company}</p>
                    <p><strong>Size:</strong> ${size}</p>
                    <p><strong>Industry:</strong> ${industry}</p>
                    <p><strong>Vehicles:</strong> ${vehicles}</p>
                `;
            }

            if (reviewServices) {
                const checkedServices = form.querySelectorAll('input[name="services[]"]:checked');
                if (checkedServices.length > 0) {
                    const servicesList = Array.from(checkedServices).map(input => {
                        const label = input.nextElementSibling.querySelector('strong')?.textContent || input.value;
                        return `<li>${label}</li>`;
                    }).join('');

                    reviewServices.innerHTML = `<ul>${servicesList}</ul>`;
                }
            }
        };

        // Next button handling
        nextButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const nextStep = parseInt(button.dataset.next);

                if (validateStep(this.state.currentFormStep)) {
                    if (nextStep === 4) {
                        populateReview();
                    }
                    showStep(nextStep);
                } else {
                    this.showFormError('Please complete all required fields before proceeding.');
                }
            });
        });

        // Previous button handling
        prevButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const prevStep = parseInt(button.dataset.previous);
                showStep(prevStep);
            });
        });

        // Form submission
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            this.submitForm(form);
        });
    },

    // Single form setup
    setupSingleForm(form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            this.submitForm(form);
        });
    },

    // Form field validation
    handleFieldValidation(e) {
        const field = e.target;
        if (field.classList.contains('form-input') || field.classList.contains('form-textarea') || field.classList.contains('form-select')) {
            this.validateField(field);
        }
    },

    // Handle field input with real-time validation
    handleFieldInput(e) {
        const field = e.target;
        if (field.classList.contains('form-input') || field.classList.contains('form-textarea') || field.classList.contains('form-select')) {
            // Clear error on input
            this.clearFieldError(field);
        }
    },

    // Validate individual field
    validateField(field) {
        const value = field.value.trim();
        let isValid = true;
        let errorMessage = '';

        // Required field validation
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = 'This field is required.';
        }

        // Email validation
        if (field.type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                errorMessage = 'Please enter a valid email address.';
            }
        }

        // Phone validation
        if (field.type === 'tel' && value) {
            const phoneRegex = /^[\d\s\-\+\(\)]+$/;
            if (!phoneRegex.test(value) || value.length < 10) {
                isValid = false;
                errorMessage = 'Please enter a valid phone number.';
            }
        }

        // Number validation
        if (field.type === 'number' && value) {
            const min = parseFloat(field.getAttribute('min'));
            const max = parseFloat(field.getAttribute('max'));
            const numValue = parseFloat(value);

            if (min && numValue < min) {
                isValid = false;
                errorMessage = `Value must be at least ${min}.`;
            }
            if (max && numValue > max) {
                isValid = false;
                errorMessage = `Value must be no more than ${max}.`;
            }
        }

        if (!isValid) {
            this.showFieldError(field, errorMessage);
        } else {
            this.clearFieldError(field);
        }

        return isValid;
    },

    // Show field error
    showFieldError(field, message) {
        this.clearFieldError(field);

        field.classList.add('error');

        let errorElement = field.parentNode.querySelector('.form-error');
        if (!errorElement) {
            errorElement = document.createElement('span');
            errorElement.className = 'form-error';
            field.parentNode.appendChild(errorElement);
        }

        errorElement.textContent = message;
        errorElement.style.display = 'block';
    },

    // Clear field error
    clearFieldError(field) {
        field.classList.remove('error');
        const errorElement = field.parentNode.querySelector('.form-error');
        if (errorElement) {
            errorElement.style.display = 'none';
        }
    },

    // Form submission
    async submitForm(form) {
        if (this.state.isFormSubmitting) {
            return;
        }

        const submitButton = form.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;

        try {
            this.state.isFormSubmitting = true;
            submitButton.disabled = true;
            submitButton.textContent = 'Submitting...';
            submitButton.classList.add('loading');

            const formData = new FormData(form);

            // Add custom headers
            const response = await fetch(aitsc_cpt_settings.ajax_url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const result = await response.json();

            if (result.success) {
                this.showFormSuccess(form);
                form.reset();

                // Reset multi-step form to first step
                if (form.id === 'aitsc-multi-step-form') {
                    this.state.currentFormStep = 1;
                    this.updateFormStepDisplay(form, 1);
                }
            } else {
                this.showFormError(result.message || 'Form submission failed. Please try again.');
            }
        } catch (error) {
            console.error('Form submission error:', error);
            this.showFormError('Network error. Please try again or contact us directly.');
        } finally {
            this.state.isFormSubmitting = false;
            submitButton.disabled = false;
            submitButton.textContent = originalText;
            submitButton.classList.remove('loading');
        }
    },

    // Show form success message
    showFormSuccess(form) {
        const successMessage = document.getElementById('form-success');
        if (successMessage) {
            form.style.display = 'none';
            successMessage.style.display = 'flex';

            // Scroll to success message
            successMessage.scrollIntoView({ behavior: 'smooth', block: 'start' });

            // Hide success message after 10 seconds
            setTimeout(() => {
                successMessage.style.display = 'none';
                form.style.display = 'block';
            }, 10000);
        }
    },

    // Show form error
    showFormError(message) {
        const errorMessage = document.getElementById('form-error');
        if (errorMessage) {
            errorMessage.querySelector('.message-text').textContent = message;
            errorMessage.style.display = 'flex';

            // Scroll to error message
            errorMessage.scrollIntoView({ behavior: 'smooth', block: 'start' });

            // Hide error message after 5 seconds
            setTimeout(() => {
                errorMessage.style.display = 'none';
            }, 5000);
        }
    },

    // Update form step display
    updateFormStepDisplay(form, stepNumber) {
        const steps = form.querySelectorAll('.form-step');
        const progressSteps = form.querySelectorAll('.progress-step');
        const progressFill = form.querySelector('.progress-fill');

        steps.forEach((step, index) => {
            step.classList.toggle('active', index + 1 === stepNumber);
        });

        progressSteps.forEach((step, index) => {
            step.classList.toggle('active', index + 1 === stepNumber);
            step.classList.toggle('completed', index + 1 < stepNumber);
        });

        const progressPercentage = (stepNumber / steps.length) * 100;
        progressFill.style.width = `${progressPercentage}%`;
    },

    // Navigation enhancements
    setupNavigation() {
        // Mobile menu toggle
        const mobileToggle = document.querySelector('.mobile-menu-toggle');
        const mobileMenu = document.querySelector('.mobile-menu');
        const mobileClose = document.querySelector('.mobile-menu-close');

        if (mobileToggle && mobileMenu) {
            mobileToggle.addEventListener('click', () => {
                mobileMenu.classList.add('active');
                document.body.style.overflow = 'hidden';
            });

            const closeMenu = () => {
                mobileMenu.classList.remove('active');
                document.body.style.overflow = '';
            };

            if (mobileClose) {
                mobileClose.addEventListener('click', closeMenu);
            }

            // Close on outside click
            mobileMenu.addEventListener('click', (e) => {
                if (e.target === mobileMenu) {
                    closeMenu();
                }
            });
        }

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', (e) => {
                e.preventDefault();
                const target = document.querySelector(anchor.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    },

    // Parallax effects
    setupParallaxEffects() {
        const parallaxElements = document.querySelectorAll('[data-parallax="true"]');

        if (parallaxElements.length === 0) {
            return;
        }

        const updateParallax = () => {
            const scrolled = window.pageYOffset;

            parallaxElements.forEach(element => {
                const speed = parseFloat(element.dataset.speed) || this.config.parallaxSpeed;
                const yPos = -(scrolled * speed);
                element.style.transform = `translateY(${yPos}px)`;
            });
        };

        const onParallaxScroll = () => {
            requestAnimationFrame(updateParallax);
        };

        window.addEventListener('scroll', onParallaxScroll, { passive: true });
    },

    // Scroll reveal animations
    setupScrollReveal() {
        const revealElements = document.querySelectorAll('.animate-stagger > *');

        if (revealElements.length === 0) {
            return;
        }

        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('animate-visible');
                    }, index * 100);
                    revealObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        revealElements.forEach(element => {
            revealObserver.observe(element);
        });
    },

    // Lazy loading for images
    setupLazyLoading() {
        const images = document.querySelectorAll('img[data-src]');

        if (images.length === 0 || 'loading' in HTMLImageElement.prototype) {
            return;
        }

        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        images.forEach(img => {
            img.classList.add('lazy');
            imageObserver.observe(img);
        });
    },

    // Keyboard navigation
    setupKeyboardNavigation() {
        document.addEventListener('keydown', (e) => {
            // Escape key to close modals/menus
            if (e.key === 'Escape') {
                const mobileMenu = document.querySelector('.mobile-menu.active');
                if (mobileMenu) {
                    mobileMenu.classList.remove('active');
                    document.body.style.overflow = '';
                }
            }

            // Tab key focus management
            if (e.key === 'Tab') {
                this.handleTabNavigation(e);
            }
        });
    },

    // Handle tab navigation for accessibility
    handleTabNavigation(e) {
        const focusableElements = document.querySelectorAll(
            'a[href], button:not([disabled]), textarea, input[type="text"], input[type="email"], input[type="tel"], input[type="number"], select, [tabindex]:not([tabindex="-1"])'
        );

        const firstElement = focusableElements[0];
        const lastElement = focusableElements[focusableElements.length - 1];

        if (e.shiftKey) {
            if (document.activeElement === firstElement) {
                e.preventDefault();
                lastElement.focus();
            }
        } else {
            if (document.activeElement === lastElement) {
                e.preventDefault();
                firstElement.focus();
            }
        }
    },

    // Update progress indicators
    updateProgressIndicators() {
        const windowHeight = window.innerHeight;
        const documentHeight = document.documentElement.scrollHeight - windowHeight;
        const scrollProgress = (this.state.scrollY / documentHeight) * 100;

        // Update any progress bars
        const progressBars = document.querySelectorAll('.scroll-progress');
        progressBars.forEach(bar => {
            bar.style.width = `${scrollProgress}%`;
        });
    },

    // Debounce utility
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
};

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    AITSCInteractive.init();
});

// Initialize on page load (for back/forward cache)
window.addEventListener('load', () => {
    AITSCInteractive.init();
});

// Export for global access if needed
window.AITSCInteractive = AITSCInteractive;