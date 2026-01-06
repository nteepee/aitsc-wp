/**
 * Theme Core JS
 * Handles Global Interactions (Particle system moved to particle-system.js)
 */

(function ($) {
    'use strict';

    // REMOVED: Duplicate ParticleNetwork class (lines 9-102)
    // Particle system now handled by assets/js/particle-system.js
    // This prevents code duplication and maintains single source of truth

    // Initialize on ready
    $(document).ready(function () {
        // Particle system initialized by particle-system.js

        // --- 2. Initialize AOS (Animate On Scroll) ---
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 1000,
                easing: 'ease-out-cubic',
                once: true,
                offset: 50,
                anchorPlacement: 'top-bottom',
            });
        }

        // --- 3. WorldQuant Parallax Effect ---
        const heroSection = document.querySelector('.hero-section');
        const heroCanvas = document.getElementById('hero-canvas');
        const heroContent = document.querySelector('.hero-content');

        if (heroSection && heroCanvas) {
            window.addEventListener('scroll', () => {
                const scrolled = window.scrollY;
                if (scrolled < window.innerHeight) {
                    // Parallax for Canvas
                    heroCanvas.style.transform = `translateY(${scrolled * 0.4}px)`;

                    // Parallax for Content (Foreground)
                    if (heroContent) {
                        heroContent.style.transform = `translateY(${scrolled * 0.1}px)`;
                        heroContent.style.opacity = 1 - (scrolled / 700);
                    }
                }
            });
        }

        // --- 4. Sticky Header State ---
        const header = document.querySelector('.site-header');
        if (header) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            });
        }
    });

})(jQuery);
