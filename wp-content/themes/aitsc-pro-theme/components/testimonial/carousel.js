/**
 * Testimonial Carousel
 *
 * Vanilla JavaScript carousel with navigation and auto-play
 *
 * @package AITSC_Pro_Theme
 * @subpackage Components
 * @since 3.1.0
 */

(function() {
    'use strict';

    const AITSC_Testimonial_Carousel = {

        /**
         * Initialize testimonial carousel
         */
        init: function() {
            this.carousels = document.querySelectorAll('.aitsc-testimonials__carousel');

            if (this.carousels.length === 0) {
                return;
            }

            this.carousels.forEach(carousel => {
                this.setupCarousel(carousel);
            });
        },

        /**
         * Setup individual carousel
         */
        setupCarousel: function(carousel) {
            const track = carousel.querySelector('.aitsc-testimonials__track');
            const slides = carousel.querySelectorAll('.aitsc-testimonials__slide');
            const prevBtn = carousel.querySelector('.aitsc-testimonials__nav--prev');
            const nextBtn = carousel.querySelector('.aitsc-testimonials__nav--next');
            const dots = carousel.querySelectorAll('.aitsc-testimonials__dot');
            const autoplay = carousel.dataset.autoplay === 'true';
            const autoplayDelay = parseInt(carousel.dataset.autoplayDelay, 10) || 5000;

            let currentIndex = 0;
            let autoplayTimer = null;
            let isTransitioning = false;

            // Go to specific slide
            const goToSlide = (index) => {
                if (isTransitioning) return;

                isTransitioning = true;

                // Handle wrap-around
                if (index >= slides.length) {
                    index = 0;
                } else if (index < 0) {
                    index = slides.length - 1;
                }

                // Update current index
                currentIndex = index;

                // Animate track
                track.style.transform = `translateX(-${currentIndex * 100}%)`;

                // Update dots
                dots.forEach((dot, i) => {
                    dot.classList.toggle('is-active', i === currentIndex);
                });

                // Update ARIA attributes
                slides.forEach((slide, i) => {
                    slide.setAttribute('aria-hidden', i !== currentIndex);
                });

                // Reset transition lock after animation
                setTimeout(() => {
                    isTransitioning = false;
                }, 500);
            };

            // Next slide
            const nextSlide = () => {
                goToSlide(currentIndex + 1);
            };

            // Previous slide
            const prevSlide = () => {
                goToSlide(currentIndex - 1);
            };

            // Event listeners
            prevBtn.addEventListener('click', () => {
                prevSlide();
                resetAutoplay();
            });

            nextBtn.addEventListener('click', () => {
                nextSlide();
                resetAutoplay();
            });

            // Dot navigation
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    goToSlide(index);
                    resetAutoplay();
                });
            });

            // Keyboard navigation
            carousel.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') {
                    prevSlide();
                    resetAutoplay();
                } else if (e.key === 'ArrowRight') {
                    nextSlide();
                    resetAutoplay();
                }
            });

            // Autoplay
            const startAutoplay = () => {
                if (autoplay) {
                    autoplayTimer = setInterval(nextSlide, autoplayDelay);
                }
            };

            const stopAutoplay = () => {
                if (autoplayTimer) {
                    clearInterval(autoplayTimer);
                    autoplayTimer = null;
                }
            };

            const resetAutoplay = () => {
                stopAutoplay();
                startAutoplay();
            };

            // Pause on hover
            carousel.addEventListener('mouseenter', stopAutoplay);
            carousel.addEventListener('mouseleave', startAutoplay);

            // Pause when page is hidden
            document.addEventListener('visibilitychange', () => {
                if (document.hidden) {
                    stopAutoplay();
                } else {
                    startAutoplay();
                }
            });

            // Touch/swipe support
            let touchStartX = 0;
            let touchEndX = 0;

            track.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
                stopAutoplay();
            }, { passive: true });

            track.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
                startAutoplay();
            }, { passive: true });

            const handleSwipe = () => {
                const swipeThreshold = 50;
                const diff = touchStartX - touchEndX;

                if (Math.abs(diff) > swipeThreshold) {
                    if (diff > 0) {
                        nextSlide();
                    } else {
                        prevSlide();
                    }
                }
            };

            // Initialize
            goToSlide(0);
            startAutoplay();
        }
    };

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            AITSC_Testimonial_Carousel.init();
        });
    } else {
        AITSC_Testimonial_Carousel.init();
    }

    // Export for potential external use
    window.AITSC_Testimonial_Carousel = AITSC_Testimonial_Carousel;

})();
