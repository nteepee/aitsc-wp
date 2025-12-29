/**
 * Enhanced Dark Mode Manager
 * Advanced theme switching with Page Visibility API integration
 * Supports system preference detection, localStorage, and performance optimization
 */

(function() {
    'use strict';

    /**
     * Dark Mode Manager Class
     * Handles theme switching, system preference detection, and performance optimization
     */
    class DarkModeManager {
        constructor() {
            this.SSTORAGE_KEY = 'aitsc-theme';
            this.THEME_LIGHT = 'light';
            this.THEME_DARK = 'dark';
            this.isVisible = true;
            this.performanceMode = false;
            this.animationFrame = null;

            // Check for reduced motion preference
            this.prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            this.init();
        }

        /**
         * Initialize the dark mode manager
         */
        init() {
            this.setupSystemPreferenceDetection();
            this.applyInitialTheme();
            this.setupThemeToggle();
            this.setupVisibilityAPI();
            this.setupKeyboardNavigation();
            this.setupPerformanceMonitoring();
        }

        /**
         * Enhanced system preference detection with fallback
         */
        setupSystemPreferenceDetection() {
            if (window.matchMedia) {
                const darkModeQuery = window.matchMedia('(prefers-color-scheme: dark)');

                // Set up listener for system preference changes
                darkModeQuery.addEventListener('change', (e) => {
                    // Only auto-switch if user hasn't manually set preference
                    if (!localStorage.getItem(this.SSTORAGE_KEY) || this.performanceMode) {
                        this.applyTheme(e.matches ? this.THEME_DARK : this.THEME_LIGHT, false);
                    }
                });

                // Store system preference
                this.systemPrefersDark = darkModeQuery.matches;
            }
        }

        /**
         * Apply initial theme with performance optimization
         */
        applyInitialTheme() {
            // Get theme with enhanced fallback logic
            this.theme = this.getCurrentTheme();
            this.applyTheme(this.theme, true);
        }

        /**
         * Enhanced current theme detection
         */
        getCurrentTheme() {
            const stored = localStorage.getItem(this.SSTORAGE_KEY);

            if (stored && (stored === this.THEME_LIGHT || stored === this.THEME_DARK)) {
                return stored;
            }

            // Check system preference with fallback
            if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                return this.THEME_DARK;
            }

            return this.THEME_LIGHT;
        }

        /**
         * Apply theme with enhanced transitions and performance monitoring
         */
        applyTheme(theme, isInitial = false) {
            const previousTheme = this.theme;
            this.theme = theme;

            // Set performance mode for initial load
            if (isInitial) {
                document.documentElement.setAttribute('data-theme-loading', 'true');
            }

            // Apply theme with transition optimization
            this.applyThemeWithTransition(theme);

            // Update localStorage
            localStorage.setItem(this.SSTORAGE_KEY, theme);

            // Update toggle button
            this.updateToggleState(theme);

            // Emit custom event for other components
            this.emitThemeChangeEvent(theme, previousTheme);

            // Handle performance mode optimizations
            if (this.performanceMode || !this.isVisible) {
                this.optimizeForPerformance();
            }

            // Remove loading indicator after transition
            if (isInitial) {
                setTimeout(() => {
                    document.documentElement.removeAttribute('data-theme-loading');
                }, 100);
            }

            // Announce theme change for screen readers
            this.announceThemeChange(theme);
        }

        /**
         * Apply theme with optimized transitions
         */
        applyThemeWithTransition(theme) {
            const root = document.documentElement;

            // Add transition class for smooth theme switching
            root.classList.add('theme-transitioning');
            root.setAttribute('data-theme', theme);

            // Remove transition class after completion
            setTimeout(() => {
                root.classList.remove('theme-transitioning');
            }, 300);
        }

        /**
         * Setup theme toggle with enhanced accessibility
         */
        setupThemeToggle() {
            const toggleBtn = document.querySelector('[data-theme-toggle]');
            if (!toggleBtn) return;

            // Enhanced button setup
            this.setupToggleButtonAccessibility(toggleBtn);

            // Click handler
            toggleBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.toggleTheme();
            });

            // Touch optimization for mobile
            this.setupTouchOptimization(toggleBtn);
        }

        /**
         * Enhanced toggle button accessibility
         */
        setupToggleButtonAccessibility(button) {
            // Ensure minimum touch target (44px)
            const computedStyle = window.getComputedStyle(button);
            const width = parseInt(computedStyle.width);
            const height = parseInt(computedStyle.height);

            if (width < 44 || height < 44) {
                button.style.minWidth = '44px';
                button.style.minHeight = '44px';
            }

            // Enhanced ARIA attributes
            button.setAttribute('aria-label', `Toggle ${this.theme === this.THEME_DARK ? 'light' : 'dark'} mode`);
            button.setAttribute('role', 'switch');
            button.setAttribute('aria-checked', this.theme === this.THEME_DARK ? 'true' : 'false');
        }

        /**
         * Touch optimization for mobile devices
         */
        setupTouchOptimization(button) {
            // Add touch feedback
            button.addEventListener('touchstart', () => {
                button.classList.add('touch-active');
            });

            button.addEventListener('touchend', () => {
                setTimeout(() => {
                    button.classList.remove('touch-active');
                }, 150);
            });
        }

        /**
         * Enhanced toggle functionality
         */
        toggleTheme() {
            const next = this.theme === this.THEME_LIGHT ? this.THEME_DARK : this.THEME_LIGHT;
            this.applyTheme(next);
        }

        /**
         * Update toggle button state
         */
        updateToggleState(theme) {
            const toggleBtn = document.querySelector('[data-theme-toggle]');
            if (!toggleBtn) return;

            const icon = toggleBtn.querySelector('.theme-icon');
            if (!icon) return;

            // Update icon with enhanced accessibility
            if (theme === this.THEME_DARK) {
                icon.textContent = '☀️';
                toggleBtn.setAttribute('aria-label', 'Switch to light mode');
                toggleBtn.setAttribute('title', 'Switch to light mode');
            } else {
                icon.textContent = '🌙';
                toggleBtn.setAttribute('aria-label', 'Switch to dark mode');
                toggleBtn.setAttribute('title', 'Switch to dark mode');
            }

            toggleBtn.setAttribute('aria-checked', theme === this.THEME_DARK ? 'true' : 'false');
        }

        /**
         * Page Visibility API integration for performance
         */
        setupVisibilityAPI() {
            if (!document.hidden !== undefined) return;

            document.addEventListener('visibilitychange', () => {
                this.isVisible = !document.hidden;
                this.handleVisibilityChange();
            });
        }

        /**
         * Handle visibility changes for performance optimization
         */
        handleVisibilityChange() {
            if (this.isVisible) {
                // Page is visible - resume normal operations
                this.resumeAnimations();
                this.performanceMode = false;
            } else {
                // Page is hidden - enter performance mode
                this.pauseAnimations();
                this.performanceMode = true;
            }

            // Emit visibility change event
            window.dispatchEvent(new CustomEvent('darkModeVisibilityChange', {
                detail: { isVisible: this.isVisible, performanceMode: this.performanceMode }
            }));
        }

        /**
         * Pause animations when page is not visible
         */
        pauseAnimations() {
            // Pause CSS animations
            document.documentElement.style.setProperty('--animation-play-state', 'paused');

            // Cancel any ongoing animation frames
            if (this.animationFrame) {
                cancelAnimationFrame(this.animationFrame);
                this.animationFrame = null;
            }

            // Dispatch event for other components
            window.dispatchEvent(new CustomEvent('darkModePauseAnimations'));
        }

        /**
         * Resume animations when page becomes visible
         */
        resumeAnimations() {
            // Resume CSS animations
            document.documentElement.style.setProperty('--animation-play-state', 'running');

            // Dispatch event for other components
            window.dispatchEvent(new CustomEvent('darkModeResumeAnimations'));
        }

        /**
         * Setup enhanced keyboard navigation
         */
        setupKeyboardNavigation() {
            const toggleBtn = document.querySelector('[data-theme-toggle]');
            if (!toggleBtn) return;

            // Keyboard support
            toggleBtn.addEventListener('keydown', (e) => {
                switch (e.key) {
                    case 'Enter':
                    case ' ':
                        e.preventDefault();
                        this.toggleTheme();
                        break;
                    case 'ArrowRight':
                        e.preventDefault();
                        if (this.theme === this.THEME_LIGHT) {
                            this.applyTheme(this.THEME_DARK);
                        }
                        break;
                    case 'ArrowLeft':
                        e.preventDefault();
                        if (this.theme === this.THEME_DARK) {
                            this.applyTheme(this.THEME_LIGHT);
                        }
                        break;
                }
            });
        }

        /**
         * Setup performance monitoring
         */
        setupPerformanceMonitoring() {
            // Monitor animation performance
            if ('requestAnimationFrame' in window) {
                this.monitorPerformance();
            }
        }

        /**
         * Monitor animation performance and adjust accordingly
         */
        monitorPerformance() {
            let frameCount = 0;
            let lastTime = performance.now();

            const checkPerformance = (currentTime) => {
                frameCount++;

                if (currentTime - lastTime >= 1000) {
                    const fps = Math.round((frameCount * 1000) / (currentTime - lastTime));

                    // If performance is poor, reduce animations
                    if (fps < 30 && !this.prefersReducedMotion) {
                        this.enableLowPerformanceMode();
                    }

                    frameCount = 0;
                    lastTime = currentTime;
                }

                this.animationFrame = requestAnimationFrame(checkPerformance);
            };

            this.animationFrame = requestAnimationFrame(checkPerformance);
        }

        /**
         * Enable low performance mode
         */
        enableLowPerformanceMode() {
            document.documentElement.setAttribute('data-performance-mode', 'true');
            this.performanceMode = true;
        }

        /**
         * Optimize for performance mode
         */
        optimizeForPerformance() {
            // Reduce animation complexity
            if (this.performanceMode) {
                document.documentElement.style.setProperty('--animation-duration', '0.1s');
                document.documentElement.style.setProperty('--transition-duration', '0.1s');
            } else {
                // Reset to default values
                document.documentElement.style.removeProperty('--animation-duration');
                document.documentElement.style.removeProperty('--transition-duration');
            }
        }

        /**
         * Emit custom theme change event
         */
        emitThemeChangeEvent(newTheme, previousTheme) {
            const event = new CustomEvent('darkModeChange', {
                detail: {
                    newTheme,
                    previousTheme,
                    isSystemPreference: !localStorage.getItem(this.SSTORAGE_KEY),
                    performanceMode: this.performanceMode
                }
            });
            window.dispatchEvent(event);
        }

        /**
         * Announce theme change for screen readers
         */
        announceThemeChange(theme) {
            // Create or update live region
            let liveRegion = document.getElementById('theme-announcement');
            if (!liveRegion) {
                liveRegion = document.createElement('div');
                liveRegion.id = 'theme-announcement';
                liveRegion.setAttribute('aria-live', 'polite');
                liveRegion.setAttribute('aria-atomic', 'true');
                liveRegion.className = 'sr-only';
                document.body.appendChild(liveRegion);
            }

            liveRegion.textContent = `Theme changed to ${theme} mode`;

            // Clear after announcement
            setTimeout(() => {
                liveRegion.textContent = '';
            }, 1000);
        }

        /**
         * Get current theme state
         */
        getTheme() {
            return this.theme;
        }

        /**
         * Check if dark mode is active
         */
        isDarkMode() {
            return this.theme === this.THEME_DARK;
        }

        /**
         * Set theme programmatically
         */
        setTheme(theme) {
            if (theme === this.THEME_LIGHT || theme === this.THEME_DARK) {
                this.applyTheme(theme);
            }
        }

        /**
         * Reset to system preference
         */
        resetToSystemPreference() {
            localStorage.removeItem(this.SSTORAGE_KEY);
            const systemTheme = this.systemPrefersDark ? this.THEME_DARK : this.THEME_LIGHT;
            this.applyTheme(systemTheme);
        }

        /**
         * Cleanup method for SPA scenarios
         */
        destroy() {
            if (this.animationFrame) {
                cancelAnimationFrame(this.animationFrame);
            }

            // Remove event listeners
            document.removeEventListener('visibilitychange', this.handleVisibilityChange);

            // Remove live region
            const liveRegion = document.getElementById('theme-announcement');
            if (liveRegion) {
                liveRegion.remove();
            }
        }
    }

    /**
     * Initialize Dark Mode Manager
     */
    function initDarkModeManager() {
        // Create global instance
        window.AITSC_DarkMode = new DarkModeManager();

        // Add to window for external access
        window.darkModeManager = window.AITSC_DarkMode;

        return window.AITSC_DarkMode;
    }

    /**
     * Initialize on DOM ready
     */
    function onDOMReady() {
        initDarkModeManager();
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', onDOMReady);
    } else {
        onDOMReady();
    }

})();