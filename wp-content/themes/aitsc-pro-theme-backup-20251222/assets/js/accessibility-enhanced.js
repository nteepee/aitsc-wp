/**
 * AITSC Pro Theme - Enhanced Accessibility Features
 * WCAG 2.1 AAA compliance with advanced keyboard navigation and screen reader support
 *
 * @package AITSCProTheme
 * @since 3.0.0
 * @version 3.0.0
 */

class AITSCAccessibility {
    constructor() {
        this.focusableSelectors = [
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
            'audio[controls]',
            'video[controls]',
            '[role="button"]:not([disabled])',
            '[role="link"]',
            '[role="menuitem"]',
            '[role="option"]',
            '[role="tab"]',
            '[role="treeitem"]'
        ].join(',');

        this.focusVisibleSelectors = [
            ':focus',
            ':focus-visible'
        ].join(',');

        this.skipLinks = [];
        this.focusTrapElements = [];
        this.announcements = [];
        this.currentFocus = null;
        this.lastFocus = null;
        this.keyboardUser = false;

        this.init();
    }

    init() {
        this.setupKeyboardDetection();
        this.setupSkipLinks();
        this.setupFocusManagement();
        this.setupFocusTrap();
        this.setupARIALiveRegions();
        this.setupScreenReaderEnhancements();
        this.setupKeyboardNavigation();
        this.setupColorContrast();
        this.setupReducedMotion();
        this.setupTextSpacing();
        this.setupScreenReaderAnnouncements();
        this.setupAccessibilityMenu();
        this.bindAccessibilityEvents();
    }

    setupKeyboardDetection() {
        // Detect if user is navigating with keyboard
        const handleKeyDown = (e) => {
            if (e.key === 'Tab' || e.key === 'Shift') {
                this.keyboardUser = true;
                document.body.classList.add('keyboard-user');
            }

            // Handle Escape key for closing modals and menus
            if (e.key === 'Escape') {
                this.handleEscapeKey(e);
            }
        };

        const handleMouseDown = () => {
            this.keyboardUser = false;
            document.body.classList.remove('keyboard-user');
        };

        document.addEventListener('keydown', handleKeyDown, true);
        document.addEventListener('mousedown', handleMouseDown, true);
    }

    setupSkipLinks() {
        // Create skip links for keyboard users
        const skipLinksHTML = `
            <div class="skip-links" role="navigation" aria-label="<?php esc_attr_e('Skip navigation links', 'aitsc-pro'); ?>">
                <a href="#main-content" class="skip-link" tabindex="0">
                    <?php esc_html_e('Skip to main content', 'aitsc-pro'); ?>
                </a>
                <a href="#navigation" class="skip-link" tabindex="0">
                    <?php esc_html_e('Skip to navigation', 'aitsc-pro'); ?>
                </a>
                <a href="#search" class="skip-link" tabindex="0">
                    <?php esc_html_e('Skip to search', 'aitsc-pro'); ?>
                </a>
                <a href="#footer" class="skip-link" tabindex="0">
                    <?php esc_html_e('Skip to footer', 'aitsc-pro'); ?>
                </a>
            </div>
        `;

        // Insert skip links at the top of the body
        const skipLinksContainer = document.createElement('div');
        skipLinksContainer.innerHTML = skipLinksHTML;
        document.body.insertBefore(skipLinksContainer.firstElementChild, document.body.firstChild);

        // Store skip links
        this.skipLinks = document.querySelectorAll('.skip-link');

        // Add event listeners
        this.skipLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                this.handleSkipLink(e);
            });

            link.addEventListener('focus', () => {
                link.classList.add('focused');
            });

            link.addEventListener('blur', () => {
                link.classList.remove('focused');
            });
        });
    }

    setupFocusManagement() {
        // Enhanced focus styles
        const style = document.createElement('style');
        style.textContent = `
            /* Enhanced focus styles for keyboard users */
            .keyboard-user *:focus {
                outline: 3px solid var(--accent-primary) !important;
                outline-offset: 2px !important;
                border-radius: 2px !important;
                box-shadow: 0 0 0 6px rgba(0, 102, 255, 0.3) !important;
            }

            .keyboard-user *:focus-visible {
                outline: 3px solid var(--accent-primary) !important;
                outline-offset: 2px !important;
                border-radius: 2px !important;
                box-shadow: 0 0 0 6px rgba(0, 102, 255, 0.3) !important;
            }

            /* Hide focus styles for mouse users */
            .keyboard-user *:focus:not(:focus-visible) {
                outline: none !important;
            }

            /* Skip links styling */
            .skip-links {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                z-index: 9999;
            }

            .skip-link {
                position: absolute;
                top: -40px;
                left: 6px;
                background: var(--accent-primary);
                color: var(--text-primary);
                padding: 8px 16px;
                text-decoration: none;
                border-radius: 0 0 4px 4px;
                font-weight: 600;
                font-size: 14px;
                transition: top 0.3s ease;
                z-index: 9999;
            }

            .skip-link:hover,
            .skip-link:focus {
                top: 0;
                background: var(--accent-hover);
                outline: 2px solid var(--text-primary);
                outline-offset: 2px;
            }

            .skip-link.focused {
                top: 0;
            }

            /* Focus trap styles */
            .focus-trap-active {
                overflow: hidden;
            }

            .focus-trap-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 9998;
            }

            /* High contrast focus */
            @media (prefers-contrast: high) {
                .keyboard-user *:focus {
                    outline: 3px solid !important;
                    background: Highlight !important;
                    color: HighlightText !important;
                }
            }

            /* Windows high contrast mode */
            @media screen and (-ms-high-contrast: active) {
                .keyboard-user *:focus {
                    border: 3px solid windowText !important;
                    background: window !important;
                }
            }
        `;
        document.head.appendChild(style);

        // Store current focused element
        document.addEventListener('focusin', (e) => {
            this.lastFocus = this.currentFocus;
            this.currentFocus = e.target;
            this.announceFocusChange(e.target);
        }, true);

        document.addEventListener('focusout', (e) => {
            this.currentFocus = null;
        }, true);
    }

    setupFocusTrap() {
        // Find focusable elements within a container
        this.getFocusableElements = (container) => {
            return container.querySelectorAll(this.focusableSelectors);
        };

        // Trap focus within a container
        this.trapFocus = (container) => {
            const focusableElements = this.getFocusableElements(container);

            if (focusableElements.length === 0) return;

            const firstFocusable = focusableElements[0];
            const lastFocusable = focusableElements[focusableElements.length - 1];

            const handleKeyDown = (e) => {
                if (e.key === 'Tab') {
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
                } else if (e.key === 'Escape') {
                    this.handleEscapeKey(e);
                }
            };

            container.addEventListener('keydown', handleKeyDown, true);
            this.focusTrapElements.push({ container, handler: handleKeyDown });

            // Focus first element
            requestAnimationFrame(() => {
                firstFocusable.focus();
            });
        };

        // Release focus trap
        this.releaseFocusTrap = (container) => {
            const trap = this.focusTrapElements.find(t => t.container === container);
            if (trap) {
                container.removeEventListener('keydown', trap.handler, true);
                this.focusTrapElements = this.focusTrapElements.filter(t => t.container !== container);
            }

            // Restore focus to previous element
            if (this.lastFocus && this.lastFocus.focus) {
                requestAnimationFrame(() => {
                    this.lastFocus.focus();
                });
            }
        };
    }

    setupARIALiveRegions() {
        // Create live regions for dynamic content announcements
        const liveRegionsHTML = `
            <div aria-live="polite" aria-atomic="true" class="sr-only" id="polite-announcer"></div>
            <div aria-live="assertive" aria-atomic="true" class="sr-only" id="assertive-announcer"></div>
            <div aria-live="off" class="sr-only" id="status-announcer"></div>
        `;

        const liveRegionsContainer = document.createElement('div');
        liveRegionsContainer.innerHTML = liveRegionsHTML;
        document.body.appendChild(liveRegionsContainer.firstElementChild);

        // Store announcers
        this.announcers = {
            polite: document.getElementById('polite-announcer'),
            assertive: document.getElementById('assertive-announcer'),
            status: document.getElementById('status-announcer')
        };
    }

    setupScreenReaderEnhancements() {
        // Add screen reader only content styling
        const screenReaderStyles = `
            .sr-only,
            .visually-hidden {
                position: absolute !important;
                width: 1px !important;
                height: 1px !important;
                padding: 0 !important;
                margin: -1px !important;
                overflow: hidden !important;
                clip: rect(0, 0, 0, 0) !important;
                white-space: nowrap !important;
                border: 0 !important;
            }

            /* Hide elements from screen readers but keep visible */
            .sr-ignore {
                position: absolute;
                left: -10000px;
                top: auto;
                width: 1px;
                height: 1px;
                overflow: hidden;
            }

            /* Focus management for screen readers */
            .sr-focusable:focus {
                position: relative;
                width: auto;
                height: auto;
                clip: auto;
            }

            /* Reading order improvements */
            .reading-order {
                position: relative;
            }

            .reading-order > * {
                position: relative;
                z-index: 1;
            }
        `;

        const screenReaderStyle = document.createElement('style');
        screenReaderStyle.textContent = screenReaderStyles;
        document.head.appendChild(screenReaderStyle);

        // Enhance existing elements with better labels
        this.enhanceARIA();
    }

    enhanceARIA() {
        // Add better labels and descriptions
        const enhancements = [
            // Navigation menus
            {
                selector: '.main-navigation',
                attributes: {
                    'role': 'navigation',
                    'aria-label': 'Main navigation'
                }
            },
            // Breadcrumbs
            {
                selector: '.breadcrumb',
                attributes: {
                    'role': 'navigation',
                    'aria-label': 'Breadcrumb navigation'
                }
            },
            // Search forms
            {
                selector: '.search-form',
                attributes: {
                    'role': 'search'
                }
            },
            // Footer
            {
                selector: 'footer',
                attributes: {
                    'role': 'contentinfo'
                }
            },
            // Main content
            {
                selector: 'main',
                attributes: {
                    'role': 'main'
                }
            },
            // Sidebars
            {
                selector: '.sidebar',
                attributes: {
                    'role': 'complementary'
                }
            }
        ];

        enhancements.forEach(enhancement => {
            const elements = document.querySelectorAll(enhancement.selector);
            elements.forEach(element => {
                Object.entries(enhancement.attributes).forEach(([key, value]) => {
                    if (!element.hasAttribute(key)) {
                        element.setAttribute(key, value);
                    }
                });
            });
        });

        // Add proper heading structure
        this.enhanceHeadings();
    }

    enhanceHeadings() {
        const headings = document.querySelectorAll('h1, h2, h3, h4, h5, h6');
        let lastLevel = 0;

        headings.forEach(heading => {
            const currentLevel = parseInt(heading.tagName.substring(1));

            // Ensure proper heading hierarchy
            if (currentLevel > lastLevel + 1) {
                // Warning: heading level skipped
                console.warn('Heading level skipped:', {
                    element: heading,
                    currentLevel,
                    lastLevel,
                    text: heading.textContent.trim()
                });
            }

            lastLevel = currentLevel;

            // Add IDs if missing
            if (!heading.id) {
                const text = heading.textContent.trim().toLowerCase();
                const id = text.replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '') || `heading-${Math.random().toString(36).substr(2, 9)}`;
                heading.id = id;
            }
        });
    }

    setupKeyboardNavigation() {
        // Enhanced keyboard navigation for dropdowns and menus
        const setupMenuNavigation = () => {
            const menus = document.querySelectorAll('[role="menu"], .menu');

            menus.forEach(menu => {
                const menuItems = menu.querySelectorAll('[role="menuitem"], .menu-item');

                menuItems.forEach((item, index) => {
                    item.addEventListener('keydown', (e) => {
                        this.handleMenuKeydown(e, menuItems, index);
                    });
                });
            });
        };

        setupMenuNavigation();

        // Arrow key navigation for lists and grids
        const setupArrowNavigation = () => {
            const arrowNavigable = document.querySelectorAll('[role="listbox"], [role="grid"], [role="tablist"]');

            arrowNavigable.forEach(container => {
                const items = container.querySelectorAll('[role="option"], [role="gridcell"], [role="tab"]');

                container.addEventListener('keydown', (e) => {
                    this.handleArrowKeydown(e, items);
                });
            });
        };

        setupArrowNavigation();
    }

    handleMenuKeydown(e, menuItems, currentIndex) {
        const key = e.key;

        switch (key) {
            case 'ArrowDown':
                e.preventDefault();
                if (currentIndex < menuItems.length - 1) {
                    menuItems[currentIndex + 1].focus();
                }
                break;

            case 'ArrowUp':
                e.preventDefault();
                if (currentIndex > 0) {
                    menuItems[currentIndex - 1].focus();
                }
                break;

            case 'Home':
                e.preventDefault();
                menuItems[0].focus();
                break;

            case 'End':
                e.preventDefault();
                menuItems[menuItems.length - 1].focus();
                break;

            case 'Enter':
            case ' ':
                e.preventDefault();
                e.target.click();
                break;
        }
    }

    handleArrowKeydown(e, items) {
        const key = e.key;
        const currentIndex = Array.from(items).indexOf(e.target);

        if (currentIndex === -1) return;

        switch (key) {
            case 'ArrowRight':
            case 'ArrowDown':
                e.preventDefault();
                if (currentIndex < items.length - 1) {
                    items[currentIndex + 1].focus();
                }
                break;

            case 'ArrowLeft':
            case 'ArrowUp':
                e.preventDefault();
                if (currentIndex > 0) {
                    items[currentIndex - 1].focus();
                }
                break;

            case 'Home':
                e.preventDefault();
                items[0].focus();
                break;

            case 'End':
                e.preventDefault();
                items[items.length - 1].focus();
                break;
        }
    }

    setupColorContrast() {
        // Add color contrast adjustment controls
        const contrastControls = `
            <div class="accessibility-controls">
                <button class="accessibility-btn" id="high-contrast-toggle"
                        aria-label="<?php esc_attr_e('Toggle high contrast mode', 'aitsc-pro'); ?>"
                        aria-pressed="false">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle cx="12" cy="12" r="5"/>
                        <line x1="12" y1="1" x2="12" y2="3"/>
                        <line x1="12" y1="21" x2="12" y2="23"/>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                        <line x1="1" y1="12" x2="3" y2="12"/>
                        <line x1="21" y1="12" x2="23" y2="12"/>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                    </svg>
                </button>
            </div>
        `;

        // Add to page
        const controlsContainer = document.createElement('div');
        controlsContainer.innerHTML = contrastControls;
        document.body.appendChild(controlsContainer.firstElementChild);

        // Setup toggle functionality
        const highContrastToggle = document.getElementById('high-contrast-toggle');
        highContrastToggle.addEventListener('click', () => {
            this.toggleHighContrast();
        });

        // Check for saved preference
        if (localStorage.getItem('high-contrast') === 'true') {
            this.enableHighContrast();
            highContrastToggle.setAttribute('aria-pressed', 'true');
        }
    }

    toggleHighContrast() {
        const isEnabled = document.body.classList.contains('high-contrast');
        const toggle = document.getElementById('high-contrast-toggle');

        if (isEnabled) {
            this.disableHighContrast();
            toggle.setAttribute('aria-pressed', 'false');
            localStorage.setItem('high-contrast', 'false');
        } else {
            this.enableHighContrast();
            toggle.setAttribute('aria-pressed', 'true');
            localStorage.setItem('high-contrast', 'true');
        }
    }

    enableHighContrast() {
        document.body.classList.add('high-contrast');
        this.announceToScreenReader('High contrast mode enabled', 'polite');
    }

    disableHighContrast() {
        document.body.classList.remove('high-contrast');
        this.announceToScreenReader('High contrast mode disabled', 'polite');
    }

    setupReducedMotion() {
        // Enhanced reduced motion support
        const mediaQuery = window.matchMedia('(prefers-reduced-motion: reduce)');

        const handleReducedMotionChange = (e) => {
            if (e.matches) {
                document.body.classList.add('reduced-motion');
                this.disableAllAnimations();
            } else {
                document.body.classList.remove('reduced-motion');
                this.enableAnimations();
            }
        };

        mediaQuery.addListener(handleReducedMotionChange);
        handleReducedMotionChange(mediaQuery);

        // Manual reduced motion control
        const reducedMotionControls = `
            <button class="accessibility-btn" id="reduced-motion-toggle"
                    aria-label="<?php esc_attr_e('Toggle reduced motion', 'aitsc-pro'); ?>"
                    aria-pressed="false">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </button>
        `;

        const motionToggleContainer = document.createElement('div');
        motionToggleContainer.innerHTML = reducedMotionControls;
        document.querySelector('.accessibility-controls').appendChild(motionToggleContainer.firstElementChild);

        // Setup toggle
        const reducedMotionToggle = document.getElementById('reduced-motion-toggle');
        reducedMotionToggle.addEventListener('click', () => {
            this.toggleReducedMotion();
        });
    }

    toggleReducedMotion() {
        const isEnabled = document.body.classList.contains('reduced-motion-manual');
        const toggle = document.getElementById('reduced-motion-toggle');

        if (isEnabled) {
            document.body.classList.remove('reduced-motion-manual');
            this.enableAnimations();
            toggle.setAttribute('aria-pressed', 'false');
            localStorage.setItem('reduced-motion-manual', 'false');
        } else {
            document.body.classList.add('reduced-motion-manual');
            this.disableAllAnimations();
            toggle.setAttribute('aria-pressed', 'true');
            localStorage.setItem('reduced-motion-manual', 'true');
        }
    }

    setupTextSpacing() {
        // Add text spacing controls for readability
        const textSpacingControls = `
            <div class="text-spacing-controls">
                <label for="text-spacing-slider" class="text-spacing-label">
                    <?php esc_html_e('Text Spacing', 'aitsc-pro'); ?>
                </label>
                <input type="range" id="text-spacing-slider"
                       min="0" max="2" step="0.25" value="0"
                       aria-label="<?php esc_attr_e('Adjust text spacing', 'aitsc-pro'); ?>"
                       aria-valuemin="0" aria-valuemax="2" aria-valuenow="0">
            </div>
        `;

        const spacingContainer = document.createElement('div');
        spacingContainer.innerHTML = textSpacingControls;
        document.querySelector('.accessibility-controls').appendChild(spacingContainer.firstElementChild);

        // Setup slider functionality
        const textSpacingSlider = document.getElementById('text-spacing-slider');
        textSpacingSlider.addEventListener('input', (e) => {
            this.updateTextSpacing(e.target.value);
        });

        // Load saved preference
        const savedSpacing = localStorage.getItem('text-spacing');
        if (savedSpacing) {
            textSpacingSlider.value = savedSpacing;
            this.updateTextSpacing(savedSpacing);
        }
    }

    updateTextSpacing(value) {
        const root = document.documentElement;
        const spacing = parseFloat(value);

        // Update CSS custom properties
        root.style.setProperty('--text-spacing-multiplier', spacing);

        // Apply to text elements
        const textElements = document.querySelectorAll('p, li, dt, dd, td, th, caption, span, div');
        textElements.forEach(element => {
            element.style.letterSpacing = `${spacing * 0.05}em`;
            element.style.wordSpacing = `${spacing * 0.1}em`;
        });

        // Update ARIA attributes
        const slider = document.getElementById('text-spacing-slider');
        slider.setAttribute('aria-valuenow', value);

        // Save preference
        localStorage.setItem('text-spacing', value);
    }

    setupScreenReaderAnnouncements() {
        // Enhanced announcement system
        this.announceToScreenReader = (message, priority = 'polite') => {
            const announcer = this.announcers[priority];
            if (announcer) {
                announcer.textContent = '';
                announcer.textContent = message;

                // Clear after a delay
                setTimeout(() => {
                    announcer.textContent = '';
                }, 1000);
            }
        };

        // Announce page changes
        this.announcePageChanges();
    }

    announcePageChanges() {
        // Announce when main content changes
        const mainContent = document.querySelector('main, [role="main"]');
        if (mainContent) {
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                        // Content has been added
                        const newContent = Array.from(mutation.addedNodes)
                            .filter(node => node.nodeType === Node.ELEMENT_NODE)
                            .some(node => node.textContent.trim().length > 0);

                        if (newContent) {
                            this.announceToScreenReader('Content has been updated', 'polite');
                        }
                    }
                });
            });

            observer.observe(mainContent, {
                childList: true,
                subtree: true
            });
        }
    }

    announceFocusChange(element) {
        // Announce important focus changes
        if (!element) return;

        const tagName = element.tagName.toLowerCase();
        const role = element.getAttribute('role');
        const label = element.getAttribute('aria-label') || element.textContent.trim();

        let announcement = '';

        if (role === 'tab') {
            announcement = `Tab selected: ${label}`;
        } else if (role === 'menuitem') {
            announcement = `Menu item: ${label}`;
        } else if (tagName === 'button') {
            announcement = `Button: ${label}`;
        } else if (tagName === 'a') {
            announcement = `Link: ${label}`;
        }

        if (announcement) {
            this.announceToScreenReader(announcement, 'polite');
        }
    }

    setupAccessibilityMenu() {
        // Create accessibility menu
        const accessibilityMenu = `
            <div class="accessibility-menu" id="accessibility-menu" role="menu" aria-label="Accessibility options">
                <div class="accessibility-menu-header">
                    <h3><?php esc_html_e('Accessibility Options', 'aitsc-pro'); ?></h3>
                    <button class="accessibility-menu-close"
                            id="accessibility-menu-close"
                            aria-label="<?php esc_attr_e('Close accessibility menu', 'aitsc-pro'); ?>">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <line x1="18" y1="6" x2="6" y2="18"/>
                            <line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                    </button>
                </div>

                <div class="accessibility-menu-content">
                    <div class="accessibility-section">
                        <h4><?php esc_html_e('Visual', 'aitsc-pro'); ?></h4>
                        <div class="accessibility-options">
                            <label class="accessibility-option">
                                <input type="checkbox" id="large-text-toggle" aria-describedby="large-text-desc">
                                <span class="accessibility-label">
                                    <?php esc_html_e('Large Text', 'aitsc-pro'); ?>
                                </span>
                                <span id="large-text-desc" class="sr-only">
                                    <?php esc_html_e('Increase text size for better readability', 'aitsc-pro'); ?>
                                </span>
                            </label>

                            <label class="accessibility-option">
                                <input type="checkbox" id="cursor-focus-toggle" aria-describedby="cursor-focus-desc">
                                <span class="accessibility-label">
                                    <?php esc_html_e('Cursor Focus', 'aitsc-pro'); ?>
                                </span>
                                <span id="cursor-focus-desc" class="sr-only">
                                    <?php esc_html_e('Show a visible cursor when keyboard navigating', 'aitsc-pro'); ?>
                                </span>
                            </label>
                        </div>
                    </div>

                    <div class="accessibility-section">
                        <h4><?php esc_html_e('Motion', 'aitsc-pro'); ?></h4>
                        <div class="accessibility-options">
                            <label class="accessibility-option">
                                <input type="checkbox" id="pause-animations-toggle" aria-describedby="pause-animations-desc">
                                <span class="accessibility-label">
                                    <?php esc_html_e('Pause Animations', 'aitsc-pro'); ?>
                                </span>
                                <span id="pause-animations-desc" class="sr-only">
                                    <?php esc_html_e('Pause all animations and auto-playing content', 'aitsc-pro'); ?>
                                </span>
                            </label>
                        </div>
                    </div>

                    <div class="accessibility-section">
                        <h4><?php esc_html_e('Reading', 'aitsc-pro'); ?></h4>
                        <div class="accessibility-options">
                            <label class="accessibility-option">
                                <input type="checkbox" id="reading-guide-toggle" aria-describedby="reading-guide-desc">
                                <span class="accessibility-label">
                                    <?php esc_html_e('Reading Guide', 'aitsc-pro'); ?>
                                </span>
                                <span id="reading-guide-desc" class="sr-only">
                                    <?php esc_html_e('Highlight the current reading line', 'aitsc-pro'); ?>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Create menu toggle button
        const menuToggle = document.createElement('button');
        menuToggle.id = 'accessibility-menu-toggle';
        menuToggle.className = 'accessibility-menu-toggle';
        menuToggle.setAttribute('aria-label', 'Open accessibility options');
        menuToggle.setAttribute('aria-expanded', 'false');
        menuToggle.setAttribute('aria-controls', 'accessibility-menu');
        menuToggle.innerHTML = `
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M12 2v2m0 16v2m-9-11h18M5 12a7 7 0 100 14 7 7 0 000-14z"/>
            </svg>
            <span class="sr-only">Accessibility</span>
        `;

        // Add menu and toggle to page
        document.body.appendChild(menuToggle);

        const menuContainer = document.createElement('div');
        menuContainer.innerHTML = accessibilityMenu;
        document.body.appendChild(menuContainer.firstElementChild);

        // Setup menu functionality
        this.setupAccessibilityMenu(menuToggle);
        this.setupAccessibilityOptions();
    }

    setupAccessibilityMenu(toggle) {
        const menu = document.getElementById('accessibility-menu');
        const closeBtn = document.getElementById('accessibility-menu-close');

        // Toggle menu
        toggle.addEventListener('click', () => {
            const isOpen = menu.style.display === 'block';
            menu.style.display = isOpen ? 'none' : 'block';
            toggle.setAttribute('aria-expanded', !isOpen);

            if (!isOpen) {
                this.trapFocus(menu);
                this.announceToScreenReader('Accessibility menu opened', 'polite');
            }
        });

        // Close menu
        closeBtn.addEventListener('click', () => {
            menu.style.display = 'none';
            toggle.setAttribute('aria-expanded', 'false');
            this.releaseFocusTrap(menu);
            toggle.focus();
        });

        // Close on escape
        menu.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                menu.style.display = 'none';
                toggle.setAttribute('aria-expanded', 'false');
                this.releaseFocusTrap(menu);
                toggle.focus();
            }
        });
    }

    setupAccessibilityOptions() {
        // Large text toggle
        const largeTextToggle = document.getElementById('large-text-toggle');
        largeTextToggle.addEventListener('change', (e) => {
            this.toggleLargeText(e.target.checked);
        });

        // Cursor focus toggle
        const cursorFocusToggle = document.getElementById('cursor-focus-toggle');
        cursorFocusToggle.addEventListener('change', (e) => {
            this.toggleCursorFocus(e.target.checked);
        });

        // Pause animations toggle
        const pauseAnimationsToggle = document.getElementById('pause-animations-toggle');
        pauseAnimationsToggle.addEventListener('change', (e) => {
            this.toggleAnimations(e.target.checked);
        });

        // Reading guide toggle
        const readingGuideToggle = document.getElementById('reading-guide-toggle');
        readingGuideToggle.addEventListener('change', (e) => {
            this.toggleReadingGuide(e.target.checked);
        });

        // Load saved preferences
        this.loadAccessibilityPreferences();
    }

    toggleLargeText(enabled) {
        const root = document.documentElement;
        if (enabled) {
            root.style.setProperty('--font-size-multiplier', '1.2');
            document.body.classList.add('large-text');
        } else {
            root.style.setProperty('--font-size-multiplier', '1');
            document.body.classList.remove('large-text');
        }
        localStorage.setItem('large-text', enabled);
    }

    toggleCursorFocus(enabled) {
        if (enabled) {
            this.createCursorFocus();
        } else {
            this.removeCursorFocus();
        }
        localStorage.setItem('cursor-focus', enabled);
    }

    createCursorFocus() {
        const cursorFocus = document.createElement('div');
        cursorFocus.id = 'cursor-focus';
        cursorFocus.className = 'cursor-focus-indicator';
        document.body.appendChild(cursorFocus);

        // Update cursor position
        const updateCursorPosition = (e) => {
            if (this.keyboardUser) {
                const focused = document.activeElement;
                if (focused) {
                    const rect = focused.getBoundingClientRect();
                    cursorFocus.style.left = rect.left + 'px';
                    cursorFocus.style.top = rect.top + 'px';
                    cursorFocus.style.width = rect.width + 'px';
                    cursorFocus.style.height = rect.height + 'px';
                }
            }
        };

        document.addEventListener('focusin', updateCursorPosition, true);
        document.addEventListener('scroll', updateCursorPosition, true);
    }

    removeCursorFocus() {
        const cursorFocus = document.getElementById('cursor-focus');
        if (cursorFocus) {
            cursorFocus.remove();
        }
    }

    toggleReadingGuide(enabled) {
        if (enabled) {
            this.createReadingGuide();
        } else {
            this.removeReadingGuide();
        }
        localStorage.setItem('reading-guide', enabled);
    }

    createReadingGuide() {
        const readingGuide = document.createElement('div');
        readingGuide.id = 'reading-guide';
        readingGuide.className = 'reading-guide';
        document.body.appendChild(readingGuide);

        // Update guide position based on scroll
        const updateReadingGuide = () => {
            const scrollY = window.pageYOffset;
            const windowHeight = window.innerHeight;
            const lineHeight = 24; // Approximate line height
            const guidePosition = Math.floor(scrollY / lineHeight) * lineHeight;

            readingGuide.style.top = guidePosition + 'px';
        };

        window.addEventListener('scroll', updateReadingGuide);
        updateReadingGuide();
    }

    removeReadingGuide() {
        const readingGuide = document.getElementById('reading-guide');
        if (readingGuide) {
            readingGuide.remove();
        }
    }

    loadAccessibilityPreferences() {
        const preferences = {
            'large-text': 'large-text-toggle',
            'cursor-focus': 'cursor-focus-toggle',
            'pause-animations': 'pause-animations-toggle',
            'reading-guide': 'reading-guide-toggle',
            'high-contrast': 'high-contrast-toggle',
            'reduced-motion-manual': 'reduced-motion-toggle'
        };

        Object.entries(preferences).forEach(([preference, toggleId]) => {
            const value = localStorage.getItem(preference) === 'true';
            const toggle = document.getElementById(toggleId);

            if (toggle && value) {
                toggle.checked = value;
                toggle.dispatchEvent(new Event('change'));
            }
        });
    }

    handleSkipLink(e) {
        e.preventDefault();
        const targetId = e.target.getAttribute('href').substring(1);
        const target = document.getElementById(targetId);

        if (target) {
            // Remove target from URL
            e.target.blur();

            // Focus target element
            target.focus();

            // Scroll to target
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

            // Announce to screen reader
            const label = target.getAttribute('aria-label') || target.textContent.trim();
            this.announceToScreenReader(`Navigated to ${label}`, 'polite');
        }
    }

    handleEscapeKey(e) {
        // Handle escape key for various UI elements
        const activeElements = [
            '.modal.is-active',
            '.dropdown.is-open',
            '.navigation.is-open',
            '.search-form.is-active',
            '#accessibility-menu[style*="block"]'
        ];

        activeElements.forEach(selector => {
            const element = document.querySelector(selector);
            if (element) {
                // Trigger close action if available
                const closeBtn = element.querySelector('.close, [aria-label*="close"], .modal-close');
                if (closeBtn) {
                    closeBtn.click();
                } else {
                    element.style.display = 'none';
                }

                // Restore focus
                if (this.lastFocus) {
                    this.lastFocus.focus();
                }
            }
        });
    }

    bindAccessibilityEvents() {
        // Handle dynamic content updates
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'childList') {
                    this.enhanceNewElements(mutation.addedNodes);
                }
            });
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });

        // Handle page visibility changes
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                // Page is hidden, pause announcements
                this.pauseAnnouncements();
            } else {
                // Page is visible, resume announcements
                this.resumeAnnouncements();
            }
        });

        // Handle window resize for accessibility features
        window.addEventListener('resize', this.debounce(() => {
            this.updateAccessibilityForViewport();
        }, 250));
    }

    enhanceNewElements(nodes) {
        nodes.forEach((node) => {
            if (node.nodeType === Node.ELEMENT_NODE) {
                // Check if element needs ARIA enhancements
                this.enhanceARIAForElement(node);

                // Recursively check child elements
                const childElements = node.querySelectorAll('*');
                childElements.forEach(child => {
                    this.enhanceARIAForElement(child);
                });
            }
        });
    }

    enhanceARIAForElement(element) {
        // Add appropriate ARIA attributes based on element type and content
        const tagName = element.tagName.toLowerCase();

        switch (tagName) {
            case 'img':
                if (!element.hasAttribute('alt')) {
                    const src = element.getAttribute('src') || '';
                    element.setAttribute('alt', 'Image: ' + src.split('/').pop());
                }
                break;

            case 'button':
                if (!element.hasAttribute('aria-label') && !element.textContent.trim()) {
                    const icon = element.querySelector('svg, .icon');
                    if (icon) {
                        const iconClass = icon.className || icon.getAttribute('class') || '';
                        element.setAttribute('aria-label', `Button with ${iconClass} icon`);
                    }
                }
                break;

            case 'a':
                if (element.getAttribute('href') === '#' || element.getAttribute('href') === '') {
                    element.setAttribute('role', 'button');
                }
                if (!element.hasAttribute('aria-label') && !element.textContent.trim()) {
                    const href = element.getAttribute('href') || '';
                    element.setAttribute('aria-label', `Link to ${href}`);
                }
                break;
        }
    }

    updateAccessibilityForViewport() {
        // Update accessibility features based on viewport size
        const isMobile = window.innerWidth < 768;

        // Adjust touch target sizes for mobile
        if (isMobile) {
            const touchTargets = document.querySelectorAll('button, a, input, select, textarea');
            touchTargets.forEach(target => {
                const styles = window.getComputedStyle(target);
                const width = parseInt(styles.width);
                const height = parseInt(styles.height);

                if (width < 44 || height < 44) {
                    target.style.minWidth = '44px';
                    target.style.minHeight = '44px';
                }
            });
        }
    }

    pauseAnnouncements() {
        this.announcementsPaused = true;
    }

    resumeAnnouncements() {
        this.announcementsPaused = false;
    }

    disableAllAnimations() {
        document.body.classList.add('animations-disabled');

        // Pause all CSS animations
        const animatedElements = document.querySelectorAll('*');
        animatedElements.forEach(element => {
            const computedStyle = window.getComputedStyle(element);
            const animationDuration = computedStyle.animationDuration;
            const transitionDuration = computedStyle.transitionDuration;

            if (animationDuration && animationDuration !== '0s') {
                element.style.animationPlayState = 'paused';
            }

            if (transitionDuration && transitionDuration !== '0s') {
                element.style.transition = 'none';
            }
        });
    }

    enableAnimations() {
        document.body.classList.remove('animations-disabled');

        // Resume all CSS animations
        const animatedElements = document.querySelectorAll('*');
        animatedElements.forEach(element => {
            const computedStyle = window.getComputedStyle(element);
            const animationDuration = computedStyle.animationDuration;

            if (animationDuration && animationDuration !== '0s') {
                element.style.animationPlayState = 'running';
            }
        });
    }

    // Utility function for debouncing
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

    // Public API
    announce(message, priority = 'polite') {
        this.announceToScreenReader(message, priority);
    }

    trapFocus(container) {
        this.trapFocus(container);
    }

    releaseFocus(container) {
        this.releaseFocusTrap(container);
    }
}

// Initialize accessibility system
document.addEventListener('DOMContentLoaded', () => {
    window.aitscAccessibility = new AITSCAccessibility();

    // Make accessibility utilities globally available
    window.announceToScreenReader = (message, priority) => {
        window.aitscAccessibility.announce(message, priority);
    };

    window.trapFocus = (container) => {
        window.aitscAccessibility.trapFocus(container);
    };

    window.releaseFocus = (container) => {
        window.aitscAccessibility.releaseFocus(container);
    };
});

// Add accessibility CSS
const accessibilityStyles = `
    /* Accessibility Controls */
    .accessibility-controls {
        position: fixed;
        top: 50%;
        right: 0;
        transform: translateY(-50%);
        z-index: 9999;
        background: var(--background-primary);
        border: 1px solid var(--border-light);
        border-radius: 8px 0 0 8px;
        padding: var(--space-2);
        box-shadow: -2px 0 8px rgba(0, 0, 0, 0.1);
    }

    .accessibility-btn {
        display: block;
        width: 44px;
        height: 44px;
        background: var(--background-primary);
        border: 1px solid var(--border-light);
        border-radius: 6px;
        color: var(--text-primary);
        cursor: pointer;
        transition: all 0.2s ease;
        margin-bottom: var(--space-2);
        padding: var(--space-2);
        font-size: 18px;
    }

    .accessibility-btn:hover,
    .accessibility-btn:focus {
        background: var(--accent-primary);
        color: var(--text-primary);
        border-color: var(--accent-primary);
    }

    /* Accessibility Menu */
    .accessibility-menu-toggle {
        position: fixed;
        bottom: var(--space-6);
        left: var(--space-6);
        z-index: 9999;
        width: 60px;
        height: 60px;
        background: var(--accent-primary);
        border: none;
        border-radius: 50%;
        color: var(--text-primary);
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        transition: all 0.2s ease;
    }

    .accessibility-menu-toggle:hover,
    .accessibility-menu-toggle:focus {
        background: var(--accent-hover);
        transform: scale(1.05);
    }

    .accessibility-menu {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 10000;
        background: var(--background-primary);
        border: 1px solid var(--border-light);
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        max-width: 90vw;
        max-height: 90vh;
        overflow-y: auto;
        display: none;
        padding: var(--space-8);
    }

    .accessibility-menu-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--space-6);
    }

    .accessibility-menu-header h3 {
        margin: 0;
        font-size: var(--font-size-lg);
        font-weight: var(--font-weight-semibold);
        color: var(--text-primary);
    }

    .accessibility-menu-close {
        background: none;
        border: none;
        color: var(--text-secondary);
        cursor: pointer;
        padding: var(--space-2);
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .accessibility-menu-close:hover,
    .accessibility-menu-close:focus {
        background: var(--background-light);
        color: var(--text-primary);
    }

    .accessibility-section {
        margin-bottom: var(--space-6);
    }

    .accessibility-section h4 {
        margin: 0 0 var(--space-4) 0;
        font-size: var(--font-size-base);
        font-weight: var(--font-weight-semibold);
        color: var(--text-primary);
        border-bottom: 1px solid var(--border-light);
        padding-bottom: var(--space-2);
    }

    .accessibility-options {
        display: flex;
        flex-direction: column;
        gap: var(--space-3);
    }

    .accessibility-option {
        display: flex;
        align-items: center;
        gap: var(--space-3);
        cursor: pointer;
        padding: var(--space-3);
        border-radius: 6px;
        transition: background-color 0.2s ease;
    }

    .accessibility-option:hover,
    .accessibility-option:focus-within {
        background: var(--background-light);
    }

    .accessibility-option input[type="checkbox"] {
        width: 20px;
        height: 20px;
        accent-color: var(--accent-primary);
    }

    .accessibility-label {
        font-size: var(--font-size-sm);
        color: var(--text-primary);
        flex: 1;
    }

    /* Text Spacing Controls */
    .text-spacing-controls {
        margin-top: var(--space-6);
        padding-top: var(--space-6);
        border-top: 1px solid var(--border-light);
    }

    .text-spacing-label {
        display: block;
        font-size: var(--font-size-base);
        font-weight: var(--font-weight-semibold);
        color: var(--text-primary);
        margin-bottom: var(--space-3);
    }

    #text-spacing-slider {
        width: 100%;
        height: 6px;
        accent-color: var(--accent-primary);
        cursor: pointer;
    }

    /* High Contrast Mode */
    .high-contrast {
        --background-primary: #000000;
        --background-secondary: #1a1a1a;
        --background-light: #333333;
        --text-primary: #ffffff;
        --text-secondary: #cccccc;
        --accent-primary: #ffff00;
        --accent-hover: #ffcc00;
        --border-light: #666666;
        --border-medium: #999999;
    }

    /* Large Text Mode */
    .large-text {
        font-size: 120% !important;
        line-height: 1.6 !important;
    }

    /* Cursor Focus Indicator */
    .cursor-focus-indicator {
        position: fixed;
        border: 3px solid var(--accent-primary);
        border-radius: 4px;
        pointer-events: none;
        z-index: 9998;
        background: rgba(255, 255, 0, 0.1);
        transition: all 0.1s ease;
    }

    /* Reading Guide */
    .reading-guide {
        position: fixed;
        left: 0;
        width: 100%;
        height: 24px;
        background: rgba(0, 102, 255, 0.1);
        pointer-events: none;
        z-index: 9997;
        border-bottom: 2px solid var(--accent-primary);
    }

    /* Animations Disabled */
    .animations-disabled *,
    .animations-disabled *::before,
    .animations-disabled *::after {
        animation: none !important;
        transition: none !important;
        transform: none !important;
    }

    /* Text Spacing Variables */
    :root {
        --text-spacing-multiplier: 0;
        --font-size-multiplier: 1;
    }

    /* Responsive Accessibility Controls */
    @media (max-width: 768px) {
        .accessibility-controls {
            top: auto;
            bottom: var(--space-20);
            transform: none;
            border-radius: 8px 8px 0 0;
            padding: var(--space-1);
        }

        .accessibility-btn {
            width: 40px;
            height: 40px;
            font-size: 16px;
            margin-bottom: var(--space-1);
        }

        .accessibility-menu-toggle {
            width: 50px;
            height: 50px;
            bottom: var(--space-4);
            left: var(--space-4);
        }

        .accessibility-menu {
            width: 95vw;
            max-width: 400px;
        }
    }

    @media (max-width: 480px) {
        .accessibility-controls {
            right: var(--space-4);
        }

        .accessibility-menu {
            width: 90vw;
        }

        .accessibility-menu-header {
            flex-direction: column;
            gap: var(--space-3);
            text-align: center;
        }
    }

    /* Print Styles */
    @media print {
        .accessibility-controls,
        .accessibility-menu-toggle,
        .accessibility-menu,
        .cursor-focus-indicator,
        .reading-guide {
            display: none !important;
        }
    }
`;

const accessibilityStylesheet = document.createElement('style');
accessibilityStylesheet.textContent = accessibilityStyles;
document.head.appendChild(accessibilityStylesheet);