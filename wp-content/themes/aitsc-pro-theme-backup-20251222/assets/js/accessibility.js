/**
 * Enhanced Accessibility Manager
 * Comprehensive keyboard navigation, ARIA support, and WCAG 2.1 AA compliance
 * Handles skip links, focus management, and screen reader optimizations
 */

(function() {
    'use strict';

    /**
     * Accessibility Manager Class
     */
    class AccessibilityManager {
        constructor() {
            this.options = {
                skipLinks: true,
                focusManagement: true,
                keyboardNavigation: true,
                screenReaderSupport: true,
                reducedMotion: false,
                highContrast: false
            };

            this.focusableElements = [
                'a[href]',
                'button:not([disabled])',
                'input:not([disabled])',
                'select:not([disabled])',
                'textarea:not([disabled])',
                '[tabindex]:not([tabindex="-1"])',
                '[contenteditable="true"]',
                'summary',
                'iframe',
                'embed',
                'object',
                '[role="button"]',
                '[role="link"]',
                '[role="tab"]',
                '[role="menuitem"]'
            ].join(',');

            this.currentFocus = null;
            this.focusHistory = [];
            this.trapActive = false;
            this.trapContainer = null;

            this.init();
        }

        /**
         * Initialize accessibility features
         */
        init() {
            try {
                this.setupSkipLinks();
                this.setupFocusManagement();
                this.setupKeyboardNavigation();
                this.setupScreenReaderSupport();
                this.setupReducedMotion();
                this.setupHighContrast();
                this.setupCarouselAccessibility();
                this.setupFormAccessibility();
                this.setupModalAccessibility();
            } catch (error) {
                console.error('AITSC Accessibility initialization failed:', error);
                // Fallback to basic functionality
                this.setupBasicAccessibility();
            }
        }

        /**
         * Setup basic accessibility as fallback
         */
        setupBasicAccessibility() {
            try {
                // Basic focus management
                const self = this;
                document.addEventListener('focusin', function(e) {
                    if (e.target && typeof e.target.classList !== 'undefined') {
                        e.target.classList.add('focus-visible');
                    }
                });

                document.addEventListener('focusout', function(e) {
                    if (e.target && typeof e.target.classList !== 'undefined') {
                        e.target.classList.remove('focus-visible');
                    }
                });

                console.log('AITSC Accessibility: Basic fallback mode activated');
            } catch (error) {
                console.error('AITSC Accessibility: Basic fallback failed:', error);
            }
        }

        /**
         * Setup skip navigation links
         */
        setupSkipLinks() {
            if (!this.options.skipLinks) return;

            this.createSkipLinks();
            this.setupSkipLinkHandlers();
        }

        /**
         * Create skip navigation links
         */
        createSkipLinks() {
            const skipLinksHTML = `
                <div id="skip-links" role="navigation" aria-label="Skip navigation">
                    <a href="#main-content" class="skip-link">Skip to main content</a>
                    <a href="#primary-menu" class="skip-link">Skip to navigation</a>
                    <a href="#search-form" class="skip-link">Skip to search</a>
                    <a href="#footer" class="skip-link">Skip to footer</a>
                </div>
            `;

            // Insert at the beginning of body
            document.body.insertAdjacentHTML('afterbegin', skipLinksHTML);
        }

        /**
         * Setup skip link handlers
         */
        setupSkipLinkHandlers() {
            const skipLinks = document.querySelectorAll('.skip-link');

            skipLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const targetId = link.getAttribute('href').substring(1);
                    const target = document.getElementById(targetId);

                    if (target) {
                        this.skipToElement(target);
                    }
                });

                // Make skip links visible on focus
                link.addEventListener('focus', () => {
                    link.classList.add('skip-link--focused');
                });

                link.addEventListener('blur', () => {
                    link.classList.remove('skip-link--focused');
                });
            });
        }

        /**
         * Skip to element with proper focus management
         */
        skipToElement(element) {
            // Ensure element is focusable
            if (!this.isFocusable(element)) {
                element.setAttribute('tabindex', '-1');
            }

            // Scroll element into view
            element.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

            // Set focus after scrolling
            setTimeout(() => {
                element.focus();
            }, 100);
        }

        /**
         * Setup enhanced focus management
         */
        setupFocusManagement() {
            if (!this.options.focusManagement) return;

            this.setupFocusIndicators();
            this.setupFocusTrapping();
            this.setupFocusRestoration();
            this.setupFocusHistory();
        }

        /**
         * Setup enhanced focus indicators
         */
        setupFocusIndicators() {
            const self = this;
            // Add focus event listeners
            document.addEventListener('focusin', function(e) {
                self.handleFocusIn(e);
            });

            document.addEventListener('focusout', function(e) {
                self.handleFocusOut(e);
            });

            // Enhanced focus for keyboard users
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Tab') {
                    document.body.classList.add('keyboard-navigation');
                }
            });

            document.addEventListener('mousedown', function() {
                document.body.classList.remove('keyboard-navigation');
            });
        }

        /**
         * Handle focus in events
         */
        handleFocusIn(e) {
            const element = e.target;
            this.currentFocus = element;
            this.addToFocusHistory(element);

            // Add focus indicator
            element.classList.add('focus-visible');

            // Announce focus to screen readers if needed
            this.announceFocusChange(element);
        }

        /**
         * Handle focus out events
         */
        handleFocusOut(e) {
            const element = e.target;
            element.classList.remove('focus-visible');
        }

        /**
         * Setup focus trapping for modals and overlays
         */
        setupFocusTrapping() {
            // Listen for custom events to trap/release focus
            document.addEventListener('accessibility:trapFocus', (e) => {
                this.trapFocus(e.detail.container);
            });

            document.addEventListener('accessibility:releaseFocus', () => {
                this.releaseFocus();
            });
        }

        /**
         * Trap focus within a container
         */
        trapFocus(container) {
            this.trapContainer = container;
            this.trapActive = true;

            // Get all focusable elements within container
            const focusableElements = container.querySelectorAll(this.focusableElements);
            const firstFocusable = focusableElements[0];
            const lastFocusable = focusableElements[focusableElements.length - 1];

            // Set initial focus
            if (firstFocusable) {
                firstFocusable.focus();
            }

            // Handle tab key
            const handleTabKey = (e) => {
                if (e.key !== 'Tab') return;

                if (e.shiftKey) {
                    // Shift + Tab
                    if (document.activeElement === firstFocusable) {
                        e.preventDefault();
                        lastFocusable.focus();
                    }
                } else {
                    // Tab
                    if (document.activeElement === lastFocusable) {
                        e.preventDefault();
                        firstFocusable.focus();
                    }
                }
            };

            // Add event listener
            container.addEventListener('keydown', handleTabKey);

            // Store handler for cleanup
            container._focusTrapHandler = handleTabKey;
        }

        /**
         * Release focus trap
         */
        releaseFocus() {
            if (!this.trapContainer) return;

            // Remove event listener
            if (this.trapContainer._focusTrapHandler) {
                this.trapContainer.removeEventListener('keydown', this.trapContainer._focusTrapHandler);
                delete this.trapContainer._focusTrapHandler;
            }

            this.trapContainer = null;
            this.trapActive = false;
        }

        /**
         * Setup focus restoration
         */
        setupFocusRestoration() {
            // Store focus before page unload
            window.addEventListener('beforeunload', () => {
                if (this.currentFocus) {
                    sessionStorage.setItem('lastFocus', this.getFocusSelector(this.currentFocus));
                }
            });

            // Restore focus after page load
            window.addEventListener('load', () => {
                const lastFocusSelector = sessionStorage.getItem('lastFocus');
                if (lastFocusSelector) {
                    const element = document.querySelector(lastFocusSelector);
                    if (element) {
                        setTimeout(() => {
                            element.focus();
                        }, 100);
                    }
                }
            });
        }

        /**
         * Setup focus history for navigation
         */
        setupFocusHistory() {
            this.focusHistory = [];
        }

        /**
         * Add element to focus history
         */
        addToFocusHistory(element) {
            const selector = this.getFocusSelector(element);
            this.focusHistory.push(selector);

            // Keep only last 10 elements
            if (this.focusHistory.length > 10) {
                this.focusHistory.shift();
            }
        }

        /**
         * Get focus selector for element
         */
        getFocusSelector(element) {
            if (element.id) {
                return `#${element.id}`;
            }
            if (element.className) {
                return `${element.tagName.toLowerCase()}.${element.className.split(' ').join('.')}`;
            }
            return element.tagName.toLowerCase();
        }

        /**
         * Setup enhanced keyboard navigation
         */
        setupKeyboardNavigation() {
            if (!this.options.keyboardNavigation) return;

            this.setupArrowKeyNavigation();
            this.setupEscapeKeyHandling();
            this.setupMenuKeyboardSupport();
            this.setupCarouselKeyboardSupport();
        }

        /**
         * Setup arrow key navigation for custom elements
         */
        setupArrowKeyNavigation() {
            document.addEventListener('keydown', (e) => {
                const element = document.activeElement;

                // Handle arrow keys for tabs, menus, etc.
                if (this.isArrowNavigationElement(element)) {
                    this.handleArrowNavigation(e, element);
                }
            });
        }

        /**
         * Check if element supports arrow navigation
         */
        isArrowNavigationElement(element) {
            const roles = ['tab', 'menuitem', 'menuitemradio', 'menuitemcheckbox', 'option'];
            const tagName = element.tagName.toLowerCase();

            return roles.includes(element.getAttribute('role')) ||
                   tagName === 'button' && element.getAttribute('aria-pressed') ||
                   element.classList.contains('carousel-slide') ||
                   element.classList.contains('pagination-item');
        }

        /**
         * Handle arrow key navigation
         */
        handleArrowNavigation(e, element) {
            const key = e.key;
            const container = this.getNavigationContainer(element);

            if (!container) return;

            const items = this.getNavigationItems(container);
            const currentIndex = items.indexOf(element);
            let newIndex = currentIndex;

            switch (key) {
                case 'ArrowRight':
                case 'ArrowDown':
                    e.preventDefault();
                    newIndex = (currentIndex + 1) % items.length;
                    break;
                case 'ArrowLeft':
                case 'ArrowUp':
                    e.preventDefault();
                    newIndex = (currentIndex - 1 + items.length) % items.length;
                    break;
                case 'Home':
                    e.preventDefault();
                    newIndex = 0;
                    break;
                case 'End':
                    e.preventDefault();
                    newIndex = items.length - 1;
                    break;
            }

            if (newIndex !== currentIndex) {
                items[newIndex].focus();
                this.handleNavigationActivation(items[newIndex]);
            }
        }

        /**
         * Get navigation container for element
         */
        getNavigationContainer(element) {
            return element.closest('[role="tablist"], [role="menu"], .carousel, .pagination');
        }

        /**
         * Get navigation items within container
         */
        getNavigationItems(container) {
            const selector = this.focusableElements + ', .carousel-slide, .pagination-item';
            return Array.from(container.querySelectorAll(selector)).filter(item => {
                return !item.hasAttribute('disabled') &&
                       !item.hasAttribute('aria-disabled') &&
                       getComputedStyle(item).display !== 'none';
            });
        }

        /**
         * Handle navigation activation (Enter/Space)
         */
        handleNavigationActivation(element) {
            const role = element.getAttribute('role');
            const tagName = element.tagName.toLowerCase();

            if (role === 'tab') {
                element.click();
            } else if (role === 'menuitem' || role === 'menuitemradio' || role === 'menuitemcheckbox') {
                element.click();
            } else if (tagName === 'button') {
                // Buttons are handled by default behavior
            }
        }

        /**
         * Setup escape key handling
         */
        setupEscapeKeyHandling() {
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    this.handleEscapeKey(e);
                }
            });
        }

        /**
         * Handle escape key press
         */
        handleEscapeKey(e) {
            // Close modals
            const openModal = document.querySelector('.modal.is-open');
            if (openModal) {
                const closeBtn = openModal.querySelector('[data-modal-close], .modal-close');
                if (closeBtn) {
                    closeBtn.click();
                }
                return;
            }

            // Close dropdowns
            const openDropdown = document.querySelector('.dropdown.is-open');
            if (openDropdown) {
                const trigger = openDropdown.querySelector('[aria-expanded="true"]');
                if (trigger) {
                    trigger.click();
                }
                return;
            }

            // Release focus trap
            if (this.trapActive) {
                this.releaseFocus();
            }
        }

        /**
         * Setup menu keyboard support
         */
        setupMenuKeyboardSupport() {
            document.addEventListener('keydown', (e) => {
                const element = document.activeElement;

                if (this.isMenuItem(element)) {
                    this.handleMenuKeyboard(e, element);
                }
            });
        }

        /**
         * Check if element is a menu item
         */
        isMenuItem(element) {
            return element.getAttribute('role') === 'menuitem' ||
                   element.classList.contains('menu-item') ||
                   element.closest('[role="menu"]');
        }

        /**
         * Handle menu keyboard navigation
         */
        handleMenuKeyboard(e, element) {
            const key = e.key;

            switch (key) {
                case 'Enter':
                case ' ':
                    e.preventDefault();
                    element.click();
                    break;
                case 'ArrowRight':
                case 'ArrowLeft':
                case 'ArrowUp':
                case 'ArrowDown':
                    // Handled by arrow navigation
                    break;
                case 'Escape':
                    // Close menu and return focus to trigger
                    const menu = element.closest('[role="menu"]');
                    if (menu) {
                        const trigger = menu.previousElementSibling;
                        if (trigger) {
                            trigger.focus();
                            trigger.setAttribute('aria-expanded', 'false');
                        }
                    }
                    break;
            }
        }

        /**
         * Setup carousel keyboard support
         */
        setupCarouselKeyboardSupport() {
            document.addEventListener('keydown', (e) => {
                const element = document.activeElement;

                if (this.isCarouselElement(element)) {
                    this.handleCarouselKeyboard(e, element);
                }
            });
        }

        /**
         * Check if element is in carousel
         */
        isCarouselElement(element) {
            return element.closest('.carousel');
        }

        /**
         * Handle carousel keyboard navigation
         */
        handleCarouselKeyboard(e, element) {
            const carousel = element.closest('.carousel');
            if (!carousel) return;

            const key = e.key;

            switch (key) {
                case 'ArrowLeft':
                    e.preventDefault();
                    this.carouselPrevious(carousel);
                    break;
                case 'ArrowRight':
                    e.preventDefault();
                    this.carouselNext(carousel);
                    break;
                case 'Home':
                    e.preventDefault();
                    this.carouselFirst(carousel);
                    break;
                case 'End':
                    e.preventDefault();
                    this.carouselLast(carousel);
                    break;
            }
        }

        /**
         * Navigate carousel to previous slide
         */
        carouselPrevious(carousel) {
            const prevBtn = carousel.querySelector('.carousel-prev, [data-carousel-prev]');
            if (prevBtn) {
                prevBtn.click();
            }
        }

        /**
         * Navigate carousel to next slide
         */
        carouselNext(carousel) {
            const nextBtn = carousel.querySelector('.carousel-next, [data-carousel-next]');
            if (nextBtn) {
                nextBtn.click();
            }
        }

        /**
         * Navigate carousel to first slide
         */
        carouselFirst(carousel) {
            const slides = carousel.querySelectorAll('.carousel-slide');
            if (slides.length > 0) {
                this.goToSlide(carousel, 0);
            }
        }

        /**
         * Navigate carousel to last slide
         */
        carouselLast(carousel) {
            const slides = carousel.querySelectorAll('.carousel-slide');
            if (slides.length > 0) {
                this.goToSlide(carousel, slides.length - 1);
            }
        }

        /**
         * Go to specific slide
         */
        goToSlide(carousel, index) {
            // Dispatch custom event for carousel implementation
            carousel.dispatchEvent(new CustomEvent('carousel:goToSlide', {
                detail: { index }
            }));
        }

        /**
         * Setup carousel accessibility enhancements
         */
        setupCarouselAccessibility() {
            const carousels = document.querySelectorAll('.carousel');

            carousels.forEach(carousel => {
                this.enhanceCarouselAccessibility(carousel);
            });
        }

        /**
         * Enhance individual carousel accessibility
         */
        enhanceCarouselAccessibility(carousel) {
            // Add proper ARIA attributes
            if (!carousel.hasAttribute('role')) {
                carousel.setAttribute('role', 'region');
            }

            if (!carousel.hasAttribute('aria-roledescription')) {
                carousel.setAttribute('aria-roledescription', 'carousel');
            }

            if (!carousel.hasAttribute('aria-label')) {
                carousel.setAttribute('aria-label', 'Content carousel');
            }

            // Enhance slides
            const slides = carousel.querySelectorAll('.carousel-slide');
            slides.forEach((slide, index) => {
                if (!slide.hasAttribute('role')) {
                    slide.setAttribute('role', 'group');
                }

                if (!slide.hasAttribute('aria-roledescription')) {
                    slide.setAttribute('aria-roledescription', 'slide');
                }

                if (!slide.hasAttribute('aria-label')) {
                    slide.setAttribute('aria-label', `${index + 1} of ${slides.length}`);
                }
            });

            // Enhance controls
            this.enhanceCarouselControls(carousel);
        }

        /**
         * Enhance carousel controls
         */
        enhanceCarouselControls(carousel) {
            const prevBtn = carousel.querySelector('.carousel-prev, [data-carousel-prev]');
            const nextBtn = carousel.querySelector('.carousel-next, [data-carousel-next]');

            if (prevBtn && !prevBtn.hasAttribute('aria-label')) {
                prevBtn.setAttribute('aria-label', 'Previous slide');
            }

            if (nextBtn && !nextBtn.hasAttribute('aria-label')) {
                nextBtn.setAttribute('aria-label', 'Next slide');
            }

            // Add pause/play button if auto-playing
            if (carousel.classList.contains('autoplay')) {
                this.addCarouselPlayPause(carousel);
            }
        }

        /**
         * Add play/pause button for auto-playing carousels
         */
        addCarouselPlayPause(carousel) {
            const existingBtn = carousel.querySelector('.carousel-play-pause');
            if (existingBtn) return;

            const playPauseBtn = document.createElement('button');
            playPauseBtn.className = 'carousel-play-pause';
            playPauseBtn.setAttribute('aria-label', 'Pause carousel');
            playPauseBtn.setAttribute('aria-pressed', 'false');
            playPauseBtn.innerHTML = '⏸';

            playPauseBtn.addEventListener('click', () => {
                const isPaused = playPauseBtn.getAttribute('aria-pressed') === 'true';
                playPauseBtn.setAttribute('aria-pressed', isPaused ? 'false' : 'true');
                playPauseBtn.setAttribute('aria-label', isPaused ? 'Pause carousel' : 'Play carousel');
                playPauseBtn.innerHTML = isPaused ? '⏸' : '▶';

                carousel.dispatchEvent(new CustomEvent('carousel:togglePlay', {
                    detail: { paused: isPaused }
                }));
            });

            carousel.appendChild(playPauseBtn);
        }

        /**
         * Setup form accessibility enhancements
         */
        setupFormAccessibility() {
            const forms = document.querySelectorAll('form');

            forms.forEach(form => {
                this.enhanceFormAccessibility(form);
            });
        }

        /**
         * Enhance individual form accessibility
         */
        enhanceFormAccessibility(form) {
            // Add form labeling
            if (!form.hasAttribute('aria-label') && !form.hasAttribute('aria-labelledby')) {
                const heading = form.querySelector('h1, h2, h3, h4, h5, h6, legend');
                if (heading) {
                    form.setAttribute('aria-labelledby', heading.id || this.generateId(heading));
                }
            }

            // Enhance form fields
            const fields = form.querySelectorAll('input, select, textarea');
            fields.forEach(field => {
                this.enhanceFormField(field);
            });
        }

        /**
         * Enhance individual form field
         */
        enhanceFormField(field) {
            // Ensure proper labeling
            if (!this.hasProperLabel(field)) {
                this.addMissingLabel(field);
            }

            // Add required attributes
            if (field.hasAttribute('required') && !field.hasAttribute('aria-required')) {
                field.setAttribute('aria-required', 'true');
            }

            // Add describedby for help text
            this.addDescribedBy(field);
        }

        /**
         * Check if field has proper label
         */
        hasProperLabel(field) {
            if (field.hasAttribute('aria-label') || field.hasAttribute('aria-labelledby')) {
                return true;
            }

            const id = field.id;
            if (id) {
                const label = document.querySelector(`label[for="${id}"]`);
                if (label) return true;
            }

            return false;
        }

        /**
         * Add missing label for field
         */
        addMissingLabel(field) {
            const id = field.id || this.generateId(field);
            field.id = id;

            // Look for nearby text to use as label
            const wrapper = field.closest('.form-group, .field-group');
            let labelText = '';

            if (wrapper) {
                const labelElement = wrapper.querySelector('label');
                if (labelElement && !labelElement.getAttribute('for')) {
                    labelElement.setAttribute('for', id);
                    return;
                }

                // Use placeholder or title as fallback
                labelText = field.placeholder || field.title || field.name;
            }

            // Create visual label if needed
            if (labelText && !document.querySelector(`label[for="${id}"]`)) {
                const label = document.createElement('label');
                label.setAttribute('for', id);
                label.textContent = this.formatLabelText(labelText);
                label.className = 'generated-label visually-hidden';

                field.parentNode.insertBefore(label, field);
            }
        }

        /**
         * Add describedby attribute for help text
         */
        addDescribedBy(field) {
            const wrapper = field.closest('.form-group, .field-group');
            if (!wrapper) return;

            // Look for help text
            const helpText = wrapper.querySelector('.help-text, .description, .field-description');
            if (helpText) {
                const helpId = helpText.id || this.generateId(helpText);
                helpText.id = helpId;

                const describedBy = field.getAttribute('aria-describedby') || '';
                const describedByList = describedBy ? describedBy.split(' ') : [];

                if (!describedByList.includes(helpId)) {
                    describedByList.push(helpId);
                    field.setAttribute('aria-describedby', describedByList.join(' '));
                }
            }

            // Look for error message container
            const errorContainer = wrapper.querySelector('.field-error, .error-message');
            if (errorContainer) {
                const errorId = errorContainer.id || this.generateId(errorContainer);
                errorContainer.id = errorId;

                const describedBy = field.getAttribute('aria-describedby') || '';
                const describedByList = describedBy ? describedBy.split(' ') : [];

                if (!describedByList.includes(errorId)) {
                    describedByList.push(errorId);
                    field.setAttribute('aria-describedby', describedByList.join(' '));
                }
            }
        }

        /**
         * Setup modal accessibility
         */
        setupModalAccessibility() {
            // Listen for modal open/close events
            document.addEventListener('modal:open', (e) => {
                this.enhanceModalAccessibility(e.detail.modal);
                this.trapFocus(e.detail.modal);
            });

            document.addEventListener('modal:close', () => {
                this.releaseFocus();
            });
        }

        /**
         * Enhance modal accessibility
         */
        enhanceModalAccessibility(modal) {
            // Add proper ARIA attributes
            if (!modal.hasAttribute('role')) {
                modal.setAttribute('role', 'dialog');
            }

            if (!modal.hasAttribute('aria-modal')) {
                modal.setAttribute('aria-modal', 'true');
            }

            // Add title if missing
            if (!modal.hasAttribute('aria-label') && !modal.hasAttribute('aria-labelledby')) {
                const heading = modal.querySelector('h1, h2, h3, h4, h5, h6');
                if (heading) {
                    heading.id = heading.id || this.generateId(heading);
                    modal.setAttribute('aria-labelledby', heading.id);
                }
            }

            // Add focus management
            this.setupModalFocusManagement(modal);
        }

        /**
         * Setup modal focus management
         */
        setupModalFocusManagement(modal) {
            // Store focus before opening
            modal._previousFocus = document.activeElement;

            // Set focus to first focusable element
            const focusableElements = modal.querySelectorAll(this.focusableElements);
            if (focusableElements.length > 0) {
                setTimeout(() => {
                    focusableElements[0].focus();
                }, 100);
            }
        }

        /**
         * Setup screen reader support
         */
        setupScreenReaderSupport() {
            if (!this.options.screenReaderSupport) return;

            this.setupLiveRegions();
            this.setupAnnouncements();
            this.setupScreenReaderOptimizations();
        }

        /**
         * Setup live regions for dynamic content
         */
        setupLiveRegions() {
            this.createLiveRegion('status', 'polite');
            this.createLiveRegion('alert', 'assertive');
            this.createLiveRegion('progress', 'polite');
        }

        /**
         * Create live region
         */
        createLiveRegion(name, politeness) {
            let region = document.getElementById(`live-region-${name}`);
            if (region) return region;

            region = document.createElement('div');
            region.id = `live-region-${name}`;
            region.setAttribute('aria-live', politeness);
            region.setAttribute('aria-atomic', 'true');
            region.className = 'sr-only live-region';
            document.body.appendChild(region);

            return region;
        }

        /**
         * Setup announcement system
         */
        setupAnnouncements() {
            // Listen for custom announcement events
            document.addEventListener('accessibility:announce', (e) => {
                this.announce(e.detail.message, e.detail.politeness || 'polite');
            });
        }

        /**
         * Announce message to screen readers
         */
        announce(message, politeness = 'polite') {
            const region = this.getLiveRegion(politeness);
            if (region) {
                region.textContent = message;

                // Clear after announcement
                setTimeout(() => {
                    region.textContent = '';
                }, 1000);
            }
        }

        /**
         * Get live region by politeness
         */
        getLiveRegion(politeness) {
            switch (politeness) {
                case 'assertive':
                    return document.getElementById('live-region-alert');
                case 'polite':
                default:
                    return document.getElementById('live-region-status');
            }
        }

        /**
         * Setup screen reader optimizations
         */
        setupScreenReaderOptimizations() {
            this.hideDecorativeElements();
            this.optimizeImagesForScreenReaders();
            this.optimizeLinksForScreenReaders();
        }

        /**
         * Hide decorative elements from screen readers
         */
        hideDecorativeElements() {
            const decorativeSelectors = [
                '[aria-hidden="true"]',
                '.sr-only',
                '.visually-hidden',
                'img[alt=""]',
                'img:not([alt])'
            ];

            decorativeSelectors.forEach(selector => {
                const elements = document.querySelectorAll(selector);
                elements.forEach(element => {
                    if (!element.hasAttribute('aria-hidden')) {
                        element.setAttribute('aria-hidden', 'true');
                    }
                });
            });
        }

        /**
         * Optimize images for screen readers
         */
        optimizeImagesForScreenReaders() {
            const images = document.querySelectorAll('img');
            images.forEach(img => {
                if (!img.hasAttribute('alt')) {
                    // Check if image is decorative
                    const isDecorative = img.classList.contains('decorative') ||
                                       img.closest('.icon') ||
                                       img.closest('.bg-image');

                    if (isDecorative) {
                        img.setAttribute('alt', '');
                        img.setAttribute('role', 'presentation');
                    } else {
                        // Generate alt text from nearby content
                        const altText = this.generateImageAltText(img);
                        if (altText) {
                            img.setAttribute('alt', altText);
                        }
                    }
                }
            });
        }

        /**
         * Generate alt text for image
         */
        generateImageAltText(img) {
            // Look for nearby text
            const parent = img.closest('figure, .card, .image-wrapper');
            if (parent) {
                const caption = parent.querySelector('figcaption, .caption, .title, h1, h2, h3, h4, h5, h6');
                if (caption && caption.textContent.trim()) {
                    return caption.textContent.trim();
                }
            }

            // Use filename as fallback
            const src = img.src;
            const filename = src.split('/').pop();
            const nameWithoutExt = filename.split('.')[0];
            return nameWithoutExt.replace(/[-_]/g, ' ').trim();
        }

        /**
         * Optimize links for screen readers
         */
        optimizeLinksForScreenReaders() {
            if (!document.querySelectorAll) return;
            const links = document.querySelectorAll('a');
            links.forEach(link => {
                // Add descriptive text for icon-only links
                if (link.textContent.trim() === '' || /^[\u2300-\u2BFF\s]+$/.test(link.textContent.trim())) {
                    // Icon-only link detected
                    const icon = link.textContent.trim();
                    if (icon.length <= 3) { // Likely an icon
                        const parent = link.closest('.nav-item, .menu-item, .social-icon');
                        if (parent) {
                            const text = parent.textContent.trim().replace(icon, '').trim();
                            if (text && !link.hasAttribute('aria-label')) {
                                link.setAttribute('aria-label', text);
                            }
                        }
                    }
                }

            // Add external link indicators
            if (link.hostname !== window.location.hostname && !link.hasAttribute('aria-label')) {
                link.setAttribute('aria-label', `${link.textContent || 'Link'} (opens in new window)`);
                if (!link.hasAttribute('target')) {
                    link.setAttribute('target', '_blank');
                }
                if (!link.hasAttribute('rel')) {
                    link.setAttribute('rel', 'noopener noreferrer');
                }
            }
        });
    }

    /**
     * Setup reduced motion support
     */
    setupReducedMotion() {
            if (window.matchMedia) {
                const reducedMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');

                this.options.reducedMotion = reducedMotionQuery.matches;

                reducedMotionQuery.addEventListener('change', (e) => {
                    this.options.reducedMotion = e.matches;
                    this.handleReducedMotionChange(e.matches);
                });

                // Apply reduced motion immediately if preferred
                if (this.options.reducedMotion) {
                    this.handleReducedMotionChange(true);
                }
            }
        }

        /**
         * Handle reduced motion preference changes
         */
        handleReducedMotionChange(prefersReduced) {
            document.documentElement.setAttribute('data-reduced-motion', prefersReduced ? 'true' : 'false');

            // Adjust animations
            if (prefersReduced) {
                document.documentElement.style.setProperty('--animation-duration', '0.01s');
                document.documentElement.style.setProperty('--transition-duration', '0.01s');
            } else {
                document.documentElement.style.removeProperty('--animation-duration');
                document.documentElement.style.removeProperty('--transition-duration');
            }

            // Announce to other components
            window.dispatchEvent(new CustomEvent('accessibility:reducedMotionChange', {
                detail: { prefersReduced }
            }));
        }

        /**
         * Setup high contrast mode support
         */
        setupHighContrast() {
            if (window.matchMedia) {
                const highContrastQuery = window.matchMedia('(prefers-contrast: high)');

                this.options.highContrast = highContrastQuery.matches;

                highContrastQuery.addEventListener('change', (e) => {
                    this.options.highContrast = e.matches;
                    this.handleHighContrastChange(e.matches);
                });

                // Apply high contrast immediately if preferred
                if (this.options.highContrast) {
                    this.handleHighContrastChange(true);
                }
            }
        }

        /**
         * Handle high contrast preference changes
         */
        handleHighContrastChange(prefersHighContrast) {
            document.documentElement.setAttribute('data-high-contrast', prefersHighContrast ? 'true' : 'false');

            // Announce to other components
            window.dispatchEvent(new CustomEvent('accessibility:highContrastChange', {
                detail: { prefersHighContrast }
            }));
        }

        /**
         * Announce focus change for screen readers
         */
        announceFocusChange(element) {
            const tagName = element.tagName.toLowerCase();
            const role = element.getAttribute('role');
            const label = element.getAttribute('aria-label') || element.getAttribute('title') || element.textContent.trim();

            if (label && (role || ['button', 'link', 'input', 'select', 'textarea'].includes(tagName))) {
                const announcement = `Focused on ${role || tagName}: ${label}`;
                this.announce(announcement, 'polite');
            }
        }

        /**
         * Check if element is focusable
         */
        isFocusable(element) {
            if (element.disabled || element.getAttribute('aria-disabled') === 'true') {
                return false;
            }

            if (element.tabIndex < 0) {
                return false;
            }

            const style = window.getComputedStyle(element);
            if (style.display === 'none' || style.visibility === 'hidden') {
                return false;
            }

            return element.matches(this.focusableElements);
        }

        /**
         * Generate unique ID for element
         */
        generateId(element) {
            if (element.id) return element.id;

            const tagName = element.tagName.toLowerCase();
            const className = element.className ? `-${element.className.split(' ').join('-')}` : '';
            const timestamp = Date.now();
            const random = Math.random().toString(36).substr(2, 5);

            return `${tagName}${className}-${timestamp}-${random}`;
        }

        /**
         * Format label text from field name
         */
        formatLabelText(fieldName) {
            return fieldName
                .replace(/[_-]/g, ' ')
                .replace(/\b\w/g, l => l.toUpperCase())
                .trim();
        }

        /**
         * Update theme for accessibility enhancements
         */
        updateTheme(theme) {
            // Update ARIA labels and indicators based on theme
            const toggleBtn = document.querySelector('[data-theme-toggle]');
            if (toggleBtn) {
                const isDark = theme === 'dark';
                toggleBtn.setAttribute('aria-label', `Current theme: ${theme}, click to switch to ${isDark ? 'light' : 'dark'} mode`);
            }

            // Update focus indicators for better contrast
            document.documentElement.setAttribute('data-accessibility-theme', theme);
        }

        /**
         * Get accessibility options
         */
        getOptions() {
            return { ...this.options };
        }

        /**
         * Set accessibility options
         */
        setOptions(options) {
            Object.assign(this.options, options);

            // Apply changes
            if (options.reducedMotion !== undefined) {
                this.handleReducedMotionChange(options.reducedMotion);
            }

            if (options.highContrast !== undefined) {
                this.handleHighContrastChange(options.highContrast);
            }
        }

        /**
         * Cleanup method
         */
        destroy() {
            this.releaseFocus();

            // Remove event listeners
            document.removeEventListener('focusin', this.handleFocusIn);
            document.removeEventListener('focusout', this.handleFocusOut);
            document.removeEventListener('keydown', this.handleArrowNavigation);
            document.removeEventListener('keydown', this.handleEscapeKey);

            // Remove live regions
            ['status', 'alert', 'progress'].forEach(type => {
                const region = document.getElementById(`live-region-${type}`);
                if (region) {
                    region.remove();
                }
            });
        }
    }

    /**
     * Initialize Accessibility Manager
     */
    function initAccessibilityManager() {
        // Create global instance
        window.AITSC_Accessibility = new AccessibilityManager();

        // Add to window for external access
        window.accessibilityManager = window.AITSC_Accessibility;

        // Listen for theme changes to update accessibility
        document.addEventListener('darkModeChange', (e) => {
            if (window.AITSC_Accessibility) {
                window.AITSC_Accessibility.updateTheme(e.detail.newTheme);
            }
        });

        // Listen for carousel events
        document.addEventListener('carousel:slideChanged', (e) => {
            if (window.AITSC_Accessibility) {
                const { slide, index, total } = e.detail;
                const announcement = `Slide ${index + 1} of ${total}: ${slide.textContent.trim()}`;
                window.AITSC_Accessibility.announce(announcement, 'polite');
            }
        });

        return window.AITSC_Accessibility;
    }

    /**
     * Initialize on DOM ready
     */
    function onDOMReady() {
        initAccessibilityManager();
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', onDOMReady);
    } else {
        onDOMReady();
    }

})();