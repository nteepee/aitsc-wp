/**
 * Homepage Animations JavaScript
 *
 * Advanced animations and interactions for homepage sections:
 * - Hero section text animations and parallax
 * - Statistics counters and progress bars
 * - Ssolutions filtering and grid animations
 * - Ttestimonials carousel functionality
 * - CTA countdown timers
 * - Scroll animations and intersection observers
 *
 * WorldQuant-inspired smooth animations at 60fps
 * Mobile-first approach with touch support
 * Accessibility considerations (reduced motion, keyboard navigation)
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

(function($) {
    'use strict';

    /**
     * Homepage Animations Controller
     */
    class AITSC_Homepage_Animations {
        constructor() {
            this.init();
        }

        init() {
            this.setupVariables();
            this.bindEvents();
            this.initAnimations();
            this.initScrollAnimations();
            this.initHeroAnimations();
            this.initStatsAnimations();
            this.initSsolutionsFiltering();
            this.initTtestimonialsCarousel();
            this.initCTAAnimations();
            this.initParallaxEffects();
            this.initFloatingElements();
        }

        /**
         * Setup class variables and DOM references
         */
        setupVariables() {
            // Animation settings
            this.animationDuration = 2000; // 2 seconds default
            this.scrollThreshold = 0.1;
            this.isReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            // DOM elements
            this.window = $(window);
            this.document = $(document);
            this.body = $('body');

            // Performance monitoring
            this.lastScrollY = 0;
            this.ticking = false;
            this.animationFrameId = null;

            // Support detection
            this.supportsIntersectionObserver = 'IntersectionObserver' in window;
            this.supportsAnimationFrame = 'requestAnimationFrame' in window;

            // Debug mode
            this.debug = this.body.hasClass('debug-mode');
        }

        /**
         * Bind event listeners
         */
        bindEvents() {
            // Scroll events with throttling
            this.window.on('scroll', $.throttle(16, () => this.handleScroll()));

            // Resize events with debouncing
            this.window.on('resize', $.debounce(250, () => this.handleResize()));

            // Orientation change
            this.window.on('orientationchange', () => this.handleOrientationChange());

            // Page visibility changes
            this.document.on('visibilitychange', () => this.handleVisibilityChange());

            // Keyboard navigation
            this.document.on('keydown', (e) => this.handleKeyboard(e));

            // Touch events for mobile
            if ('ontouchstart' in window) {
                this.document.on('touchstart', (e) => this.handleTouchStart(e));
                this.document.on('touchmove', (e) => this.handleTouchMove(e));
                this.document.on('touchend', (e) => this.handleTouchEnd(e));
            }
        }

        /**
         * Initialize all animation systems
         */
        initAnimations() {
            if (this.isReducedMotion) {
                this.log('Reduced motion detected - disabling animations');
                return;
            }

            this.initElementAnimations();
            this.initButtonAnimations();
            this.initCardAnimations();
        }

        /**
         * Initialize scroll-triggered animations
         */
        initScrollAnimations() {
            if (!this.supportsIntersectionObserver) {
                this.log('Intersection Observer not supported - using fallback');
                this.initFallbackScrollAnimations();
                return;
            }

            // Create intersection observer with multiple options
            const observerOptions = {
                threshold: [0.1, 0.5, 0.8],
                rootMargin: '0px 0px -50px 0px'
            };

            this.scrollObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    this.handleIntersectionEntry(entry);
                });
            }, observerOptions);

            // Observe all animate elements
            $('.animate-slide-up, .animate-fade-in-up, .animate-fade-in, .scroll-animate').each((index, element) => {
                this.scrollObserver.observe(element);
            });
        }

        /**
         * Initialize hero section animations
         */
        initHeroAnimations() {
            const $hero = $('.hero-advanced');
            if ($hero.length === 0) return;

            // Text animation for hero headline
            this.initHeroTextAnimation($hero);

            // Scroll indicator animation
            this.initScrollIndicator($hero);

            // Parallax background effect
            if ($hero.data('parallax')) {
                this.initHeroParallax($hero);
            }

            // Video background handling
            this.initHeroVideo($hero);
        }

        /**
         * Initialize statistics section animations
         */
        initStatsAnimations() {
            const $statsSection = $('.stats-section');
            if ($statsSection.length === 0) return;

            // Counter animations
            this.initStatCounters($statsSection);

            // Progress bar animations
            this.initProgressBars($statsSection);

            // Number animation effects
            this.initNumberEffects($statsSection);
        }

        /**
         * Initialize ssolutions showcase filtering
         */
        initSsolutionsFiltering() {
            const $showcase = $('.ssolutions-showcase');
            if ($showcase.length === 0) return;

            this.ssolutionsFiltering = {
                $showcase: $showcase,
                $grid: $showcase.find('.filter-grid'),
                $filterButtons: $showcase.find('.filter-button'),
                $items: $showcase.find('.solution-item'),
                activeFilters: new Set(['*']),
                isAnimating: false
            };

            this.bindSsolutionsFilterEvents();
        }

        /**
         * Initialize ttestimonials carousel
         */
        initTtestimonialsCarousel() {
            const $carousel = $('.ttestimonials-carousel');
            if ($carousel.length === 0) return;

            this.ttestimonialsCarousel = {
                $carousel: $carousel,
                $slides: $carousel.find('.testimonial-slide'),
                $indicators: $('.ttestimonials-indicators .testimonial-indicator'),
                $prev: $('.testimonial-prev'),
                $next: $('.testimonial-next'),
                currentIndex: 0,
                autoplay: $carousel.data('autoplay'),
                speed: parseInt($carousel.data('speed')) || 5000,
                interval: null
            };

            this.initTtestimonialsControls();

            if (this.ttestimonialsCarousel.autoplay) {
                this.startTtestimonialsAutoplay();
            }
        }

        /**
         * Initialize CTA section animations
         */
        initCTAAnimations() {
            const $cta = $('.cta-advanced');
            if ($cta.length === 0) return;

            // Countdown timer
            this.initCountdownTimer($cta);

            // Form animations
            this.initCTAForm($cta);

            // Button hover effects
            this.initCTAButtonEffects($cta);
        }

        /**
         * Initialize parallax effects
         */
        initParallaxEffects() {
            const $parallaxElements = $('[data-parallax]');
            if ($parallaxElements.length === 0) return;

            this.parallaxElements = $parallaxElements.map((index, element) => {
                const $element = $(element);
                return {
                    $element: $element,
                    speed: parseFloat($element.data('speed')) || 0.5,
                    offset: $element.offset().top
                };
            });
        }

        /**
         * Initialize floating elements
         */
        initFloatingElements() {
            const $floatingElements = $('.floating-element');
            if ($floatingElements.length === 0) return;

            this.floatingElements = $floatingElements.map((index, element) => {
                const $element = $(element);
                return {
                    $element: $element,
                    speed: parseFloat($element.data('speed')) || 1,
                    amplitude: parseInt($element.data('amplitude')) || 20,
                    offset: Math.random() * Math.PI * 2
                };
            });
        }

        /**
         * Hero Text Animation
         */
        initHeroTextAnimation($hero) {
            const $headline = $hero.find('.hero-headline');
            const $animatedText = $headline.find('.animate-text');

            if ($animatedText.length > 0) {
                this.animateTextShimmer($animatedText);
            }
        }

        /**
         * Scroll Indicator Animation
         */
        initScrollIndicator($hero) {
            const $scrollIndicator = $hero.find('.hero-scroll-indicator');
            if ($scrollIndicator.length === 0) return;

            // Smooth scroll to next section
            $scrollIndicator.on('click', () => {
                const nextSection = $hero.next('.section');
                if (nextSection.length > 0) {
                    $('html, body').animate({
                        scrollTop: nextSection.offset().top
                    }, 800, 'easeInOutCubic');
                }
            });

            // Hide scroll indicator when scrolling down
            this.window.on('scroll', () => {
                const scrollTop = this.window.scrollTop();
                if (scrollTop > 100) {
                    $scrollIndicator.addClass('hidden');
                } else {
                    $scrollIndicator.removeClass('hidden');
                }
            });
        }

        /**
         * Hero Parallax Background
         */
        initHeroParallax($hero) {
            if (this.isReducedMotion) return;

            const $background = $hero.find('.hero-background');
            const $bgImage = $background.find('.hero-bg-image, .hero-bg-video');

            this.window.on('scroll', $.throttle(16, () => {
                const scrollTop = this.window.scrollTop();
                const heroTop = $hero.offset().top;
                const heroHeight = $hero.outerHeight();

                if (scrollTop < heroTop + heroHeight) {
                    const yPos = -(scrollTop * 0.5);
                    $bgImage.css('transform', `translateY(${yPos}px)`);
                }
            }));
        }

        /**
         * Hero Video Background
         */
        initHeroVideo($hero) {
            const $video = $hero.find('.hero-video');
            if ($video.length === 0) return;

            // Load video when visible
            const videoObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        $video[0].play().catch(e => {
                            this.log('Video autoplay failed:', e);
                        });
                    } else {
                        $video[0].pause();
                    }
                });
            }, { threshold: 0.1 });

            videoObserver.observe($video[0]);

            // Fallback for mobile
            if (this.window.width() <= 768) {
                $video.prop('muted', true);
            }
        }

        /**
         * Statistics Counters Animation
         */
        initStatCounters($statsSection) {
            const $counters = $statsSection.find('.stat-number');
            if ($counters.length === 0) return;

            $counters.each((index, element) => {
                const $counter = $(element);
                const target = parseInt($counter.data('count')) || 0;
                const duration = parseInt($counter.data('duration')) || this.animationDuration;
                const prefix = $counter.siblings('.stat-prefix').text() || '';
                const suffix = $counter.siblings('.stat-suffix').text() || '';

                // Observe counter element
                const counterObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting && !$counter.hasClass('animated')) {
                            $counter.addClass('animated');
                            this.animateCounter($counter, target, duration, prefix, suffix);
                        }
                    });
                }, { threshold: 0.5 });

                counterObserver.observe(element);
            });
        }

        /**
         * Animate Counter Number
         */
        animateCounter($counter, target, duration, prefix, suffix) {
            if (this.isReducedMotion) {
                $counter.text(prefix + target + suffix);
                return;
            }

            const start = 0;
            const increment = target / (duration / 16);
            let current = start;
            const startTime = Date.now();

            const animate = () => {
                const elapsed = Date.now() - startTime;
                const progress = Math.min(elapsed / duration, 1);

                // Easing function (ease-out cubic)
                const easeOut = 1 - Math.pow(1 - progress, 3);
                current = Math.floor(start + (target - start) * easeOut);

                $counter.text(prefix + current.toLocaleString() + suffix);

                if (progress < 1) {
                    this.animationFrameId = requestAnimationFrame(animate);
                }
            };

            animate();
        }

        /**
         * Progress Bars Animation
         */
        initProgressBars($statsSection) {
            const $progressBars = $statsSection.find('.progress-fill');
            if ($progressBars.length === 0) return;

            $progressBars.each((index, element) => {
                const $bar = $(element);
                const target = parseInt($bar.data('progress')) || 100;

                // Observe progress bar
                const barObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting && !$bar.hasClass('animated')) {
                            $bar.addClass('animated');
                            this.animateProgressBar($bar, target);
                        }
                    });
                }, { threshold: 0.5 });

                barObserver.observe(element);
            });
        }

        /**
         * Animate Progress Bar
         */
        animateProgressBar($bar, target) {
            if (this.isReducedMotion) {
                $bar.css('width', target + '%');
                return;
            }

            $bar.css('width', '0%');

            setTimeout(() => {
                $bar.css('width', target + '%');
            }, 100);
        }

        /**
         * Ssolutions Filtering Events
         */
        bindSsolutionsFilterEvents() {
            const { $filterButtons } = this.ssolutionsFiltering;

            $filterButtons.on('click', (e) => {
                e.preventDefault();
                const $button = $(e.currentTarget);
                const filter = $button.data('filter');
                const taxonomy = $button.data('taxonomy');

                this.filterSsolutions(filter, taxonomy, $button);
            });
        }

        /**
         * Filter Ssolutions Grid
         */
        filterSsolutions(filter, taxonomy, $button) {
            const { $grid, $items, $filterButtons, isAnimating, activeFilters } = this.ssolutionsFiltering;

            if (isAnimating) return;

            this.ssolutionsFiltering.isAnimating = true;

            // Update active button
            $filterButtons.removeClass('active');
            $button.addClass('active');

            // Update active filters
            if (filter === '*') {
                activeFilters.clear();
                activeFilters.add('*');
            } else {
                activeFilters.delete('*');
                activeFilters.add(filter);
            }

            // Filter items with animation
            $items.each((index, element) => {
                const $item = $(element);
                const itemClasses = $item.attr('class').split(' ');
                const shouldShow = activeFilters.has('*') ||
                               Array.from(activeFilters).some(filter => itemClasses.includes(filter));

                if (shouldShow) {
                    $item.removeClass('hidden');
                    $item.css('animation', 'fadeInUp 0.5s ease-out forwards');
                } else {
                    $item.css('animation', 'fadeOut 0.3s ease-out forwards');
                    setTimeout(() => {
                        $item.addClass('hidden');
                    }, 300);
                }
            });

            // Reset animation flag
            setTimeout(() => {
                this.ssolutionsFiltering.isAnimating = false;
            }, 500);
        }

        /**
         * Ttestimonials Controls
         */
        initTtestimonialsControls() {
            const { $prev, $next, $indicators } = this.ttestimonialsCarousel;

            // Previous button
            $prev.on('click', () => {
                this.goToTestimonial(this.ttestimonialsCarousel.currentIndex - 1);
            });

            // Next button
            $next.on('click', () => {
                this.goToTestimonial(this.ttestimonialsCarousel.currentIndex + 1);
            });

            // Indicator buttons
            $indicators.each((index, element) => {
                $(element).on('click', () => {
                    this.goToTestimonial(index);
                });
            });

            // Keyboard navigation
            this.document.on('keydown', (e) => {
                if (e.key === 'ArrowLeft') {
                    this.goToTestimonial(this.ttestimonialsCarousel.currentIndex - 1);
                } else if (e.key === 'ArrowRight') {
                    this.goToTestimonial(this.ttestimonialsCarousel.currentIndex + 1);
                }
            });
        }

        /**
         * Go to Specific Testimonial
         */
        goToTestimonial(index) {
            const { $carousel, $slides, $indicators, currentIndex, $slides: slidesArray } = this.ttestimonialsCarousel;

            // Calculate target index with wrap-around
            const targetIndex = (index + slidesArray.length) % slidesArray.length;

            // Update current index
            this.ttestimonialsCarousel.currentIndex = targetIndex;

            // Update slide position
            const offset = -targetIndex * 100;
            $carousel.css('transform', `translateX(${offset}%)`);

            // Update indicators
            $indicators.removeClass('active');
            $indicators.eq(targetIndex).addClass('active');

            // Reset autoplay if active
            if (this.ttestimonialsCarousel.autoplay) {
                this.resetTtestimonialsAutoplay();
            }
        }

        /**
         * Start Ttestimonials Autoplay
         */
        startTtestimonialsAutoplay() {
            this.ttestimonialsCarousel.interval = setInterval(() => {
                this.goToTestimonial(this.ttestimonialsCarousel.currentIndex + 1);
            }, this.ttestimonialsCarousel.speed);
        }

        /**
         * Reset Ttestimonials Autoplay
         */
        resetTtestimonialsAutoplay() {
            clearInterval(this.ttestimonialsCarousel.interval);
            this.startTtestimonialsAutoplay();
        }

        /**
         * Countdown Timer
         */
        initCountdownTimer($cta) {
            const $timer = $cta.find('.cta-countdown-timer');
            if ($timer.length === 0) return;

            const targetDate = new Date($timer.data('countdown'));
            if (isNaN(targetDate.getTime())) return;

            this.countdownTimer = {
                $timer: $timer,
                $days: $timer.find('.days'),
                $hours: $timer.find('.hours'),
                $minutes: $timer.find('.minutes'),
                $seconds: $timer.find('.seconds'),
                targetDate: targetDate,
                interval: null
            };

            this.startCountdown();
        }

        /**
         * Start Countdown Timer
         */
        startCountdown() {
            const updateCountdown = () => {
                const now = new Date().getTime();
                const distance = this.countdownTimer.targetDate - now;

                if (distance < 0) {
                    clearInterval(this.countdownTimer.interval);
                    this.onCountdownComplete();
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                this.countdownTimer.$days.text(this.padNumber(days));
                this.countdownTimer.$hours.text(this.padNumber(hours));
                this.countdownTimer.$minutes.text(this.padNumber(minutes));
                this.countdownTimer.$seconds.text(this.padNumber(seconds));
            };

            updateCountdown();
            this.countdownTimer.interval = setInterval(updateCountdown, 1000);
        }

        /**
         * Pad Numbers with Leading Zero
         */
        padNumber(num) {
            return num.toString().padStart(2, '0');
        }

        /**
         * Countdown Complete Handler
         */
        onCountdownComplete() {
            const $timer = this.countdownTimer.$timer;
            $timer.html('<div class="countdown-complete">Offer Expired</div>');

            // Show alternative CTA content
            $('.cta-countdown .cta-title').text('Stay Tuned for Our Next Offer!');
        }

        /**
         * Element Animations (general)
         */
        initElementAnimations() {
            // Add hover effects to interactive elements
            $('.btn, button, a').on('mouseenter', function() {
                $(this).addClass('hover');
            }).on('mouseleave', function() {
                $(this).removeClass('hover');
            });

            // Stagger animations for grid items
            $('.ssolutions-grid, .ttestimonials-grid').each(function() {
                const $items = $(this).children();
                $items.each(function(index) {
                    $(this).css('animation-delay', `${index * 0.1}s`);
                });
            });
        }

        /**
         * Button Animations
         */
        initButtonAnimations() {
            $('.btn').each((index, element) => {
                const $button = $(element);

                // Ripple effect
                $button.on('click', function(e) {
                    const ripple = $('<span class="ripple"></span>');
                    const offset = $(this).offset();
                    const x = e.pageX - offset.left;
                    const y = e.pageY - offset.top;

                    ripple.css({
                        left: x,
                        top: y
                    });

                    $(this).append(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        }

        /**
         * Card Animations
         */
        initCardAnimations() {
            const $cards = $('.solution-card, .case-study-card, .testimonial-card, .stat-item');

            $cards.each((index, element) => {
                const $card = $(element);

                // 3D tilt effect on mouse move
                $card.on('mousemove', function(e) {
                    if (this.window.width() <= 768) return; // Disable on mobile

                    const rect = this.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;

                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;

                    const rotateX = (y - centerY) / 20;
                    const rotateY = (centerX - x) / 20;

                    $(this).css('transform', `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.05)`);
                });

                $card.on('mouseleave', function() {
                    $(this).css('transform', 'perspective(1000px) rotateX(0) rotateY(0) scale(1)');
                });
            });
        }

        /**
         * Handle Intersection Observer Entry
         */
        handleIntersectionEntry(entry) {
            if (entry.isIntersecting) {
                const $element = $(entry.target);

                // Add animation class
                $element.addClass('in-view');

                // Handle different animation types
                if ($element.hasClass('stat-number')) {
                    this.handleStatCounter($element);
                }

                if ($element.hasClass('progress-fill')) {
                    this.handleProgressBar($element);
                }

                // Stop observing after animation
                setTimeout(() => {
                    this.scrollObserver.unobserve(entry.target);
                }, 2000);
            }
        }

        /**
         * Handle Scroll Event
         */
        handleScroll() {
            if (!this.supportsAnimationFrame) return;

            this.lastScrollY = this.window.scrollTop();

            if (!this.ticking) {
                this.ticking = true;

                requestAnimationFrame(() => {
                    this.updateScrollEffects();
                    this.ticking = false;
                });
            }
        }

        /**
         * Update Scroll Effects
         */
        updateScrollEffects() {
            // Parallax effects
            if (this.parallaxElements && this.parallaxElements.length > 0) {
                this.updateParallax();
            }

            // Floating elements
            if (this.floatingElements && this.floatingElements.length > 0) {
                this.updateFloatingElements();
            }

            // Header effects
            this.updateHeaderEffects();
        }

        /**
         * Update Parallax Elements
         */
        updateParallax() {
            const scrollTop = this.lastScrollY;
            const windowHeight = this.window.height();

            this.parallaxElements.each((index, parallaxElement) => {
                const element = parallaxElement.element;
                const speed = parallaxElement.speed;
                const elementTop = parallaxElement.offset;
                const elementHeight = $(element).outerHeight();

                // Check if element is in viewport
                if (scrollTop + windowHeight > elementTop && scrollTop < elementTop + elementHeight) {
                    const yPos = -(scrollTop * speed);
                    $(element).find('.parallax-layer').css('transform', `translateY(${yPos}px)`);
                }
            });
        }

        /**
         * Update Floating Elements
         */
        updateFloatingElements() {
            const currentTime = Date.now() / 1000;

            this.floatingElements.each((index, floatingElement) => {
                const element = floatingElement.element;
                const speed = floatingElement.speed;
                const amplitude = floatingElement.amplitude;
                const offset = floatingElement.offset;

                const yPos = Math.sin(currentTime * speed + offset) * amplitude;
                $(element).css('transform', `translateY(${yPos}px)`);
            });
        }

        /**
         * Update Header Effects
         */
        updateHeaderEffects() {
            const scrollTop = this.lastScrollY;
            const $header = $('.site-header');

            if ($header.length > 0) {
                if (scrollTop > 100) {
                    $header.addClass('scrolled');
                } else {
                    $header.removeClass('scrolled');
                }
            }
        }

        /**
         * Handle Resize Event
         */
        handleResize() {
            // Reinitialize layout-dependent animations
            this.initElementAnimations();

            // Update parallax elements
            if (this.parallaxElements) {
                this.updateParallaxOffsets();
            }
        }

        /**
         * Handle Orientation Change
         */
        handleOrientationChange() {
            // Debounced reinitialization
            setTimeout(() => {
                this.initAnimations();
            }, 100);
        }

        /**
         * Handle Visibility Change
         */
        handleVisibilityChange() {
            if (document.hidden) {
                // Pause animations when page is not visible
                this.pauseAnimations();
            } else {
                // Resume animations when page is visible
                this.resumeAnimations();
            }
        }

        /**
         * Handle Keyboard Events
         */
        handleKeyboard(e) {
            // Escape key to stop animations (for accessibility)
            if (e.key === 'Escape') {
                this.stopAnimations();
            }
        }

        /**
         * Handle Touch Events
         */
        handleTouchStart(e) {
            this.touchStartX = e.touches[0].clientX;
            this.touchStartY = e.touches[0].clientY;
        }

        handleTouchMove(e) {
            if (!this.touchStartX || !this.touchStartY) return;

            const touchEndX = e.touches[0].clientX;
            const touchEndY = e.touches[0].clientY;

            const dx = this.touchStartX - touchEndX;
            const dy = this.touchStartY - touchEndY;

            // Handle swipe gestures for ttestimonials carousel
            if (Math.abs(dx) > Math.abs(dy)) {
                if (dx > 50) {
                    // Swipe left - next testimonial
                    this.goToTestimonial(this.ttestimonialsCarousel.currentIndex + 1);
                } else if (dx < -50) {
                    // Swipe right - previous testimonial
                    this.goToTestimonial(this.ttestimonialsCarousel.currentIndex - 1);
                }
            }
        }

        handleTouchEnd(e) {
            this.touchStartX = null;
            this.touchStartY = null;
        }

        /**
         * Pause Animations
         */
        pauseAnimations() {
            if (this.ttestimonialsCarousel && this.ttestimonialsCarousel.interval) {
                clearInterval(this.ttestimonialsCarousel.interval);
            }

            if (this.countdownTimer && this.countdownTimer.interval) {
                clearInterval(this.countdownTimer.interval);
            }
        }

        /**
         * Resume Animations
         */
        resumeAnimations() {
            if (this.ttestimonialsCarousel && this.ttestimonialsCarousel.autoplay) {
                this.startTtestimonialsAutoplay();
            }

            if (this.countdownTimer) {
                this.startCountdown();
            }
        }

        /**
         * Stop Animations
         */
        stopAnimations() {
            this.pauseAnimations();

            // Cancel animation frames
            if (this.animationFrameId) {
                cancelAnimationFrame(this.animationFrameId);
            }
        }

        /**
         * Fallback Scroll Animations (no Intersection Observer)
         */
        initFallbackScrollAnimations() {
            this.window.on('scroll', $.throttle(100, () => {
                const scrollTop = this.window.scrollTop();
                const windowHeight = this.window.height();

                $('.scroll-animate').each((index, element) => {
                    const $element = $(element);
                    const elementTop = $element.offset().top;

                    if (scrollTop + windowHeight * 0.8 > elementTop) {
                        $element.addClass('in-view');
                    }
                });
            }));
        }

        /**
         * Update Parallax Offsets
         */
        updateParallaxOffsets() {
            this.parallaxElements.each((index, parallaxElement) => {
                parallaxElement.offset = $(parallaxElement.element).offset().top;
            });
        }

        /**
         * Animate Text Shimmer Effect
         */
        animateTextShimmer($element) {
            if (this.isReducedMotion) return;

            setInterval(() => {
                $element.addClass('shimmer');
                setTimeout(() => {
                    $element.removeClass('shimmer');
                }, 3000);
            }, 8000);
        }

        /**
         * Debug logging
         */
        log(message, data = null) {
            if (this.debug && console && console.log) {
                console.log('AITSC Homepage Animations:', message, data);
            }
        }

        /**
         * Performance monitoring
         */
        monitorPerformance() {
            if ('performance' in window) {
                window.addEventListener('load', () => {
                    setTimeout(() => {
                        const perfData = performance.getEntriesByType('navigation')[0];
                        this.log('Page load performance:', {
                            loadTime: perfData.loadEventEnd - perfData.loadEventStart,
                            domContentLoaded: perfData.domContentLoadedEventEnd - perfData.domContentLoadedEventStart
                        });
                    }, 0);
                });
            }
        }
    }

    /**
     * Additional Standalone Carousel Logic (Phase 04)
     * Simplified carousel for ttestimonials with fade transitions
     */
    (function() {
        const carousel = document.querySelector('.js-ttestimonials-carousel');
        if (!carousel) return;

        const slides = carousel.querySelectorAll('.testimonial-slide');
        const autoRotate = parseInt(carousel.dataset.autoRotate || 5000);
        let currentIndex = 0;
        let rotateInterval;

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.style.opacity = i === index ? '1' : '0';
                slide.style.pointerEvents = i === index ? 'auto' : 'none';
                slide.style.position = i === index ? 'relative' : 'absolute';
                slide.style.top = i === index ? 'auto' : '0';
            });
            currentIndex = index;
        }

        function nextSlide() {
            showSlide((currentIndex + 1) % slides.length);
        }

        function prevSlide() {
            showSlide((currentIndex - 1 + slides.length) % slides.length);
        }

        function startAutoRotate() {
            rotateInterval = setInterval(nextSlide, autoRotate);
        }

        function resetAutoRotate() {
            clearInterval(rotateInterval);
            startAutoRotate();
        }

        const nextBtn = document.querySelector('.js-ttestimonials-next');
        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                nextSlide();
                resetAutoRotate();
            });
        }

        const prevBtn = document.querySelector('.js-ttestimonials-prev');
        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                prevSlide();
                resetAutoRotate();
            });
        }

        carousel.addEventListener('mouseenter', () => clearInterval(rotateInterval));
        carousel.addEventListener('mouseleave', startAutoRotate);

        // Initialize first slide
        showSlide(0);
        startAutoRotate();
    })();

    /**
     * Additional Counter Logic (Phase 04)
     * Animated counters for stats with IntersectionObserver
     */
    (function() {
        const counters = document.querySelectorAll('.js-counter');
        if (counters.length === 0) return;

        const observerOptions = { threshold: 0.5 };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
                    animateCounter(entry.target);
                    entry.target.classList.add('counted');
                }
            });
        }, observerOptions);

        counters.forEach(counter => observer.observe(counter));

        function animateCounter(element) {
            const target = parseInt(element.dataset.target);
            const duration = 2000; // 2 seconds
            const increment = target / (duration / 16); // 60fps
            let current = 0;

            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    element.textContent = target.toLocaleString();
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current).toLocaleString();
                }
            }, 16);

            // Animate progress bar if present
            const statItem = element.closest('.stat-item');
            const progressBar = statItem ? statItem.querySelector('.stat-progress-bar') : null;
            if (progressBar) {
                const targetWidth = parseFloat(
                    getComputedStyle(progressBar).getPropertyValue('--target-width')
                );
                progressBar.style.transition = 'width 2s ease-out';
                progressBar.style.width = targetWidth + '%';
            }
        }
    })();

    /**
     * Initialize on document ready
     */
    $(document).ready(() => {
        // Check if we're on homepage
        if ($('body').hasClass('home') || $('body').hasClass('front-page')) {
            window.AITSC_Homepage_Animations = new AITSC_Homepage_Animations();

            // Initialize performance monitoring if debug mode
            if ($('body').hasClass('debug-mode')) {
                window.AITSC_Homepage_Animations.monitorPerformance();
            }
        }
    });

    /**
     * Cleanup on page unload
     */
    $(window).on('beforeunload', () => {
        if (window.AITSC_Homepage_Animations) {
            window.AITSC_Homepage_Animations.stopAnimations();
        }
    });

})(jQuery);