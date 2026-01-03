/**
 * Paper Stack Scroll Effect - Intersection Observer
 * Adds is-visible class to sections as they scroll into view
 *
 * @package AITSC_Pro_Theme
 * @version 1.0.2
 */

(function() {
    'use strict';

    /**
     * Check if CSS Scroll-Driven Animations are actually working
     */
    function testCssSupport() {
        if (!CSS.supports('animation-timeline: view()')) {
            return false;
        }

        // Check if it actually works by testing a known issue
        // Some browsers report support but don't work correctly
        const userAgent = navigator.userAgent.toLowerCase();
        const isChrome = /chrome/.test(userAgent) && !/edge|edg/.test(userAgent);
        const isSafari = /safari/.test(userAgent) && !/chrome/.test(userAgent);

        // For now, always use JS for reliability
        // CSS scroll-driven animations are too experimental
        return false;
    }

    /**
     * Paper Stack Observer Class
     */
    class PaperStackObserver {
        constructor(options = {}) {
            this.options = {
                rootMargin: '0px 0px -10% 0px',
                threshold: 0.1,
                ...options
            };

            this.observer = null;
            this.sections = [];
            this.initialized = false;
        }

        /**
         * Initialize the observer
         */
        init() {
            // Skip if Intersection Observer is not available
            if (!('IntersectionObserver' in window)) {
                console.warn('Paper Stack: Intersection Observer not supported');
                // Fallback: make all sections visible immediately
                this.makeAllVisible();
                return;
            }

            // Find all paper stack wrapper sections
            this.sections = document.querySelectorAll('.paper-stack-wrapper > section');

            if (this.sections.length === 0) {
                console.log('Paper Stack: No sections found');
                return;
            }

            console.log('Paper Stack: Found ' + this.sections.length + ' sections to animate');

            // Create observer
            this.observer = new IntersectionObserver(
                this.handleIntersection.bind(this),
                {
                    rootMargin: this.options.rootMargin,
                    threshold: this.options.threshold
                }
            );

            // Observe all sections
            this.sections.forEach((section, index) => {
                this.observer.observe(section);
            });

            this.initialized = true;
            console.log('Paper Stack: Initialized with Intersection Observer');
        }

        /**
         * Handle intersection changes
         */
        handleIntersection(entries) {
            entries.forEach(entry => {
                const section = entry.target;

                if (entry.isIntersecting) {
                    // Add visible class
                    section.classList.add('is-visible');
                    console.log('Paper Stack: Section became visible');
                }
            });
        }

        /**
         * Fallback: Make all sections visible immediately
         */
        makeAllVisible() {
            const sections = document.querySelectorAll('.paper-stack-wrapper > section');
            sections.forEach(section => {
                section.classList.add('is-visible');
            });
            console.log('Paper Stack: Made ' + sections.length + ' sections visible (fallback)');
        }

        /**
         * Destroy the observer
         */
        destroy() {
            if (this.observer) {
                this.observer.disconnect();
                this.observer = null;
            }
            this.sections = [];
            this.initialized = false;
        }

        /**
         * Refresh/reinitialize the observer
         */
        refresh() {
            this.destroy();
            this.init();
        }
    }

    /**
     * Global instance
     */
    let paperStackInstance = null;

    /**
     * Initialize when DOM is ready
     */
    function initPaperStack() {
        if (paperStackInstance) {
            return;
        }

        console.log('Paper Stack: Initializing...');
        paperStackInstance = new PaperStackObserver();
        paperStackInstance.init();
    }

    /**
     * Initialize on DOM ready
     */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPaperStack);
    } else {
        // DOM already ready
        initPaperStack();
    }

    /**
     * Re-initialize after AJAX/navigation
     */
    document.addEventListener('paperStackRefresh', function() {
        if (paperStackInstance) {
            paperStackInstance.refresh();
        } else {
            initPaperStack();
        }
    });

    /**
     * Export to global scope for external access
     */
    window.AITSCPaperStack = {
        init: initPaperStack,
        refresh: function() {
            document.dispatchEvent(new CustomEvent('paperStackRefresh'));
        },
        destroy: function() {
            if (paperStackInstance) {
                paperStackInstance.destroy();
                paperStackInstance = null;
            }
        },
        getInstance: function() {
            return paperStackInstance;
        }
    };

    console.log('Paper Stack: Script loaded (Intersection Observer mode)');

})();
