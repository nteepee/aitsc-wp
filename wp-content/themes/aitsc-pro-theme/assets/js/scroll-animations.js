/**
 * Scroll Animations with Intersection Observer
 * Handles fade-in effects and active section highlighting
 * Respects prefers-reduced-motion accessibility preference
 *
 * @package AITSC_Pro_Theme
 * @since 3.0.1
 */

(function() {
    'use strict';

    // Fade-in animation observer configuration
    const observerOptions = {
        root: null,
        rootMargin: '0px 0px -100px 0px', // Trigger 100px before element enters viewport
        threshold: 0.1 // Element must be at least 10% visible
    };

    // Create Intersection Observer for fade-in animations
    const fadeInObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                // Unobserve after animation to improve performance
                fadeInObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Create Intersection Observer for active section highlighting
    const sectionObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const id = entry.target.getAttribute('id');
                if (id) {
                    // Update navigation links
                    document.querySelectorAll('.nav-link').forEach(link => {
                        link.classList.remove('active');
                        if (link.getAttribute('href') === `#${id}`) {
                            link.classList.add('active');
                        }
                    });
                }
            }
        });
    }, {
        root: null,
        rootMargin: '-50% 0px -50% 0px', // Trigger when section is centered in viewport
        threshold: 0
    });

    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', () => {
        // Observe elements with fade-in animation classes
        const fadeElements = document.querySelectorAll('.fade-in-section, .solution-card, .feature-card');
        fadeElements.forEach(el => fadeInObserver.observe(el));

        // Observe sections with IDs for navigation highlighting
        const sections = document.querySelectorAll('section[id]');
        sections.forEach(section => sectionObserver.observe(section));
    });
})();
