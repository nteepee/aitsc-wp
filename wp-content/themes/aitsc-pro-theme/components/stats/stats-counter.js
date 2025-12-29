/**
 * Stats Counter Animation
 *
 * Count-up animation triggered by Intersection Observer
 * when stats come into viewport.
 *
 * @package AITSC_Pro_Theme
 * @subpackage Components
 * @since 3.1.0
 */

(function() {
    'use strict';

    const AITSC_Stats_Counter = {

        /**
         * Initialize stats counter
         */
        init: function() {
            this.statsItems = document.querySelectorAll('.aitsc-stats__count');
            this.animated = new Set();

            if (this.statsItems.length === 0) {
                return;
            }

            this.setupIntersectionObserver();
        },

        /**
         * Setup Intersection Observer for scroll-triggered animation
         */
        setupIntersectionObserver: function() {
            const options = {
                root: null,
                rootMargin: '0px',
                threshold: 0.3 // Trigger when 30% visible
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const target = entry.target;
                        const index = target.closest('.aitsc-stats__item').dataset.index;

                        if (!this.animated.has(index)) {
                            this.animateCounter(target);
                            this.animated.add(index);
                            observer.unobserve(target);
                        }
                    }
                });
            }, options);

            this.statsItems.forEach(item => {
                observer.observe(item);
            });
        },

        /**
         * Animate counter from 0 to target number
         */
        animateCounter: function(element) {
            const target = parseInt(element.dataset.target, 10);
            const duration = 2000; // 2 seconds
            const frameDuration = 1000 / 60; // 60fps
            const totalFrames = Math.round(duration / frameDuration);
            const frame = 0;

            const counter = setInterval(() => {
                frame++;

                // Ease out cubic function for smooth animation
                const progress = frame / totalFrames;
                const easeProgress = 1 - Math.pow(1 - progress, 3);
                const current = Math.floor(target * easeProgress);

                element.textContent = current;

                if (frame === totalFrames) {
                    clearInterval(counter);
                    element.textContent = target;
                }
            }, frameDuration);
        }
    };

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            AITSC_Stats_Counter.init();
        });
    } else {
        AITSC_Stats_Counter.init();
    }

    // Export for potential external use
    window.AITSC_Stats_Counter = AITSC_Stats_Counter;

})();
