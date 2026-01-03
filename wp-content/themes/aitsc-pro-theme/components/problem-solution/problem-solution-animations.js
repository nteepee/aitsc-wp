/**
 * Problem-Solution Component Animations
 *
 * Scroll-triggered animations for problem cards and solution sections
 *
 * @package AITSC_Pro_Theme
 * @subpackage Components
 * @since 3.3.0
 */

(function() {
    'use strict';

    /**
     * Intersection Observer for scroll-triggered animations
     */
    function initScrollAnimations() {
        const sections = document.querySelectorAll('[data-scroll-trigger]');

        if (!sections.length) return;

        const observerOptions = {
            root: null,
            rootMargin: '0px 0px -100px 0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    // Optionally unobserve after animation
                    // observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        sections.forEach(section => {
            observer.observe(section);
        });
    }

    /**
     * Add micro-interactions to problem cards
     */
    function initProblemCardInteractions() {
        const cards = document.querySelectorAll('.aitsc-problem-card');

        cards.forEach(card => {
            // Add tilt effect on mouse move
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                const centerX = rect.width / 2;
                const centerY = rect.height / 2;

                const rotateX = ((y - centerY) / centerY) * 5;
                const rotateY = ((centerX - x) / centerX) * 5;

                card.style.transform = `
                    perspective(1000px)
                    rotateX(${rotateX}deg)
                    rotateY(${rotateY}deg)
                    translateY(-8px)
                    scale(1.02)
                `;
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateY(0) scale(1)';
            });
        });
    }

    /**
     * Highlight box glow effect on scroll
     */
    function initHighlightBoxEffects() {
        const highlightBoxes = document.querySelectorAll('.aitsc-highlight-box');

        highlightBoxes.forEach(box => {
            box.addEventListener('mouseenter', () => {
                box.style.background = 'linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.1) 100%)';
            });

            box.addEventListener('mouseleave', () => {
                box.style.background = 'linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.05) 100%)';
            });
        });
    }

    /**
     * Initialize all animations when DOM is ready
     */
    function init() {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                initScrollAnimations();
                initProblemCardInteractions();
                initHighlightBoxEffects();
            });
        } else {
            initScrollAnimations();
            initProblemCardInteractions();
            initHighlightBoxEffects();
        }
    }

    init();
})();
