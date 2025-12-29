/**
 * Enhanced Animation Manager
 * Page Visibility API integration for performance optimization
 * Pauses/resumes animations based on tab visibility and system preferences
 */

(function() {
    'use strict';

    /**
     * Animation Manager Class
     */
    class AnimationManager {
        constructor() {
            this.animations = new Map();
            this.isVisible = true;
            this.performanceMode = false;
            this.reducedMotion = false;
            this.frameRate = 60;
            this.targetFrameRate = 60;
            this.lastFrameTime = performance.now();
            this.frameCount = 0;
            this.animationFrame = null;

            // Performance monitoring
            this.performanceMetrics = {
                frameDrops: 0,
                averageFrameTime: 0,
                maxFrameTime: 0,
                totalFrames: 0,
                startTime: performance.now()
            };

            this.init();
        }

        /**
         * Initialize animation manager
         */
        init() {
            this.setupVisibilityAPI();
            this.setupPerformanceMonitoring();
            this.setupReducedMotion();
            this.setupAnimationOptimizations();
            this.setupEventListeners();
        }

        /**
         * Setup Page Visibility API
         */
        setupVisibilityAPI() {
            // Check if visibilitychange is supported
            if (typeof document.hidden === 'undefined') {
                // Fallback for older browsers
                document.hidden = false;
                document.visibilityState = 'visible';
            }

            // Add visibility change listener
            document.addEventListener('visibilitychange', () => {
                this.handleVisibilityChange();
            });

            // Add pagehide/freeze listeners for better mobile support
            document.addEventListener('pagehide', () => {
                this.handlePageHide();
            });

            document.addEventListener('freeze', () => {
                this.handlePageFreeze();
            });

            document.addEventListener('resume', () => {
                this.handlePageResume();
            });

            // Add focus/blur listeners for window focus changes
            window.addEventListener('focus', () => {
                this.handleWindowFocus();
            });

            window.addEventListener('blur', () => {
                this.handleWindowBlur();
            });

            // Initial visibility state
            this.isVisible = !document.hidden;
            this.updatePerformanceMode();
        }

        /**
         * Handle visibility change
         */
        handleVisibilityChange() {
            const wasVisible = this.isVisible;
            this.isVisible = !document.hidden;

            if (wasVisible !== this.isVisible) {
                this.updatePerformanceMode();
                this.toggleAnimations();

                // Dispatch custom event
                window.dispatchEvent(new CustomEvent('animation:visibilityChange', {
                    detail: {
                        isVisible: this.isVisible,
                        performanceMode: this.performanceMode,
                        timestamp: performance.now()
                    }
                }));

                // Log visibility change for debugging
                if (window.console && window.console.debug) {
                    console.debug(`Animation Manager: Page ${this.isVisible ? 'visible' : 'hidden'}, Performance mode: ${this.performanceMode}`);
                }
            }
        }

        /**
         * Handle page hide (mobile/tab navigation)
         */
        handlePageHide() {
            this.pauseAllAnimations();
            this.isVisible = false;
            this.updatePerformanceMode();
        }

        /**
         * Handle page freeze (background tab)
         */
        handlePageFreeze() {
            this.pauseAllAnimations();
            this.isVisible = false;
            this.performanceMode = true;
        }

        /**
         * Handle page resume
         */
        handlePageResume() {
            this.isVisible = true;
            this.updatePerformanceMode();
            this.resumeAllAnimations();
        }

        /**
         * Handle window focus
         */
        handleWindowFocus() {
            if (!this.isVisible) {
                this.isVisible = true;
                this.updatePerformanceMode();
                this.resumeAllAnimations();
            }
        }

        /**
         * Handle window blur
         */
        handleWindowBlur() {
            // Only blur if document is still visible
            if (this.isVisible && !document.hasFocus()) {
                this.isVisible = false;
                this.updatePerformanceMode();
                this.pauseAllAnimations();
            }
        }

        /**
         * Setup performance monitoring
         */
        setupPerformanceMonitoring() {
            // Monitor frame rate
            this.startFrameRateMonitoring();

            // Monitor memory usage (if available)
            this.setupMemoryMonitoring();

            // Setup performance budget
            this.setupPerformanceBudget();
        }

        /**
         * Start frame rate monitoring
         */
        startFrameRateMonitoring() {
            const checkFrameRate = (currentTime) => {
                if (!this.isVisible) {
                    // Skip monitoring when page is hidden
                    this.animationFrame = requestAnimationFrame(checkFrameRate);
                    return;
                }

                const deltaTime = currentTime - this.lastFrameTime;
                this.lastFrameTime = currentTime;

                // Update performance metrics
                this.updatePerformanceMetrics(deltaTime);

                // Adjust performance based on metrics
                this.adjustPerformance();

                this.animationFrame = requestAnimationFrame(checkFrameRate);
            };

            this.animationFrame = requestAnimationFrame(checkFrameRate);
        }

        /**
         * Update performance metrics
         */
        updatePerformanceMetrics(deltaTime) {
            this.frameCount++;
            this.performanceMetrics.totalFrames++;

            // Calculate frame time in ms
            const frameTime = deltaTime;

            // Update max frame time
            if (frameTime > this.performanceMetrics.maxFrameTime) {
                this.performanceMetrics.maxFrameTime = frameTime;
            }

            // Calculate running average frame time
            this.performanceMetrics.averageFrameTime =
                (this.performanceMetrics.averageFrameTime * (this.frameCount - 1) + frameTime) / this.frameCount;

            // Detect frame drops
            if (frameTime > 1000 / this.targetFrameRate * 1.5) {
                this.performanceMetrics.frameDrops++;
            }

            // Calculate current frame rate
            this.frameRate = 1000 / frameTime;

            // Reset counters periodically
            if (this.frameCount >= 60) {
                this.frameCount = 0;
            }
        }

        /**
         * Setup memory monitoring
         */
        setupMemoryMonitoring() {
            if ('memory' in performance) {
                // Monitor memory usage every 5 seconds
                setInterval(() => {
                    if (!this.isVisible) return;

                    const memory = performance.memory;
                    const usedHeapSize = memory.usedJSHeapSize / 1024 / 1024; // MB
                    const totalHeapSize = memory.totalJSHeapSize / 1024 / 1024; // MB

                    // Enable performance mode if memory usage is high
                    if (usedHeapSize > totalHeapSize * 0.8) {
                        this.enablePerformanceMode();
                    }

                    // Dispatch memory event
                    window.dispatchEvent(new CustomEvent('animation:memoryUpdate', {
                        detail: {
                            used: usedHeapSize,
                            total: totalHeapSize,
                            percentage: (usedHeapSize / totalHeapSize) * 100
                        }
                    }));
                }, 5000);
            }
        }

        /**
         * Setup performance budget
         */
        setupPerformanceBudget() {
            // Define performance thresholds
            this.budget = {
                maxFrameTime: 1000 / this.targetFrameRate * 1.2, // 20% over target
                minFrameRate: this.targetFrameRate * 0.8, // 80% of target
                maxFrameDrops: 5, // per second
                maxMemoryUsage: 0.85 // 85% of available memory
            };
        }

        /**
         * Adjust performance based on metrics
         */
        adjustPerformance() {
            const metrics = this.performanceMetrics;
            const budget = this.budget;

            // Check if performance is poor
            if (metrics.averageFrameTime > budget.maxFrameTime ||
                this.frameRate < budget.minFrameRate ||
                metrics.frameDrops > budget.maxFrameDrops) {

                if (!this.performanceMode) {
                    this.enablePerformanceMode();
                }
            }
            // Check if performance has recovered
            else if (this.performanceMode &&
                     metrics.averageFrameTime < budget.maxFrameTime * 0.8 &&
                     this.frameRate > budget.minFrameRate * 1.1) {

                this.disablePerformanceMode();
            }
        }

        /**
         * Setup reduced motion detection
         */
        setupReducedMotion() {
            // Check for reduced motion preference
            const reducedMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
            this.reducedMotion = reducedMotionQuery.matches;

            // Listen for changes
            reducedMotionQuery.addEventListener('change', (e) => {
                this.reducedMotion = e.matches;
                this.handleReducedMotionChange();
            });

            // Apply initial reduced motion settings
            if (this.reducedMotion) {
                this.applyReducedMotion();
            }
        }

        /**
         * Handle reduced motion preference change
         */
        handleReducedMotionChange() {
            this.updatePerformanceMode();

            if (this.reducedMotion) {
                this.applyReducedMotion();
            } else {
                this.removeReducedMotion();
            }

            // Dispatch event
            window.dispatchEvent(new CustomEvent('animation:reducedMotionChange', {
                detail: { reduced: this.reducedMotion }
            }));
        }

        /**
         * Apply reduced motion settings
         */
        applyReducedMotion() {
            document.documentElement.setAttribute('data-reduced-motion', 'true');

            // Set CSS custom properties for reduced motion
            document.documentElement.style.setProperty('--animation-duration', '0.01s');
            document.documentElement.style.setProperty('--transition-duration', '0.01s');
            document.documentElement.style.setProperty('--animation-play-state', 'paused');
        }

        /**
         * Remove reduced motion settings
         */
        removeReducedMotion() {
            document.documentElement.removeAttribute('data-reduced-motion');

            // Reset CSS custom properties
            document.documentElement.style.removeProperty('--animation-duration');
            document.documentElement.style.removeProperty('--transition-duration');
            document.documentElement.style.removeProperty('--animation-play-state');
        }

        /**
         * Setup animation optimizations
         */
        setupAnimationOptimizations() {
            // Setup Intersection Observer for lazy loading animations
            this.setupIntersectionObserver();

            // Setup resize observer for responsive animations
            this.setupResizeObserver();

            // Setup device memory and CPU throttling
            this.setupDeviceCapabilities();
        }

        /**
         * Setup Intersection Observer for animation visibility
         */
        setupIntersectionObserver() {
            if ('IntersectionObserver' in window) {
                const options = {
                    root: null,
                    rootMargin: '50px',
                    threshold: [0, 0.1, 0.5, 1]
                };

                this.intersectionObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        const animation = this.animations.get(entry.target);
                        if (animation) {
                            this.handleAnimationVisibility(animation, entry.isIntersecting, entry.intersectionRatio);
                        }
                    });
                }, options);

                // Observe all animated elements
                this.observeAnimatedElements();
            }
        }

        /**
         * Setup Resize Observer for responsive animations
         */
        setupResizeObserver() {
            if ('ResizeObserver' in window) {
                this.resizeObserver = new ResizeObserver((entries) => {
                    entries.forEach(entry => {
                        const animation = this.animations.get(entry.target);
                        if (animation) {
                            this.handleAnimationResize(animation, entry.contentRect);
                        }
                    });
                });
            }
        }

        /**
         * Setup device capabilities detection
         */
        setupDeviceCapabilities() {
            // Detect device memory
            if ('deviceMemory' in navigator) {
                this.deviceMemory = navigator.deviceMemory;

                // Reduce animations on low-memory devices
                if (this.deviceMemory < 4) {
                    this.enablePerformanceMode();
                }
            }

            // Detect hardware concurrency
            if ('hardwareConcurrency' in navigator) {
                this.cpuCores = navigator.hardwareConcurrency;

                // Reduce animations on low-end devices
                if (this.cpuCores < 4) {
                    this.enablePerformanceMode();
                }
            }

            // Detect connection speed
            if ('connection' in navigator) {
                this.connection = navigator.connection;

                // Reduce animations on slow connections
                if (this.connection && this.connection.effectiveType &&
                    ['slow-2g', '2g', '3g'].includes(this.connection.effectiveType)) {
                    this.enablePerformanceMode();
                }
            }
        }

        /**
         * Setup event listeners
         */
        setupEventListeners() {
            // Listen for custom animation events
            document.addEventListener('animation:register', (e) => {
                this.registerAnimation(e.detail.element, e.detail.config);
            });

            document.addEventListener('animation:unregister', (e) => {
                this.unregisterAnimation(e.detail.element);
            });

            document.addEventListener('animation:play', (e) => {
                this.playAnimation(e.detail.element);
            });

            document.addEventListener('animation:pause', (e) => {
                this.pauseAnimation(e.detail.element);
            });

            // Listen for performance mode requests
            document.addEventListener('performance:enable', () => {
                this.enablePerformanceMode();
            });

            document.addEventListener('performance:disable', () => {
                this.disablePerformanceMode();
            });

            // Listen for user interaction to optimize for responsiveness
            ['mousedown', 'touchstart', 'keydown'].forEach(event => {
                document.addEventListener(event, () => {
                    this.handleUserInteraction();
                }, { passive: true });
            });
        }

        /**
         * Handle user interaction
         */
        handleUserInteraction() {
            // Temporarily boost performance during user interaction
            this.userInteraction = true;
            this.temporarilyDisablePerformanceMode();

            // Reset after interaction timeout
            clearTimeout(this.interactionTimeout);
            this.interactionTimeout = setTimeout(() => {
                this.userInteraction = false;
                this.updatePerformanceMode();
            }, 1000);
        }

        /**
         * Update performance mode
         */
        updatePerformanceMode() {
            const shouldBePerformanceMode =
                !this.isVisible ||
                this.reducedMotion ||
                this.userInteraction;

            if (shouldBePerformanceMode && !this.performanceMode) {
                this.enablePerformanceMode();
            } else if (!shouldBePerformanceMode && this.performanceMode) {
                this.disablePerformanceMode();
            }
        }

        /**
         * Enable performance mode
         */
        enablePerformanceMode() {
            this.performanceMode = true;

            // Update CSS for performance mode
            document.documentElement.setAttribute('data-performance-mode', 'true');

            // Pause all animations
            this.pauseAllAnimations();

            // Update CSS custom properties
            document.documentElement.style.setProperty('--animation-duration', '0.1s');
            document.documentElement.style.setProperty('--transition-duration', '0.1s');

            // Dispatch event
            window.dispatchEvent(new CustomEvent('animation:performanceModeEnabled'));
        }

        /**
         * Disable performance mode
         */
        disablePerformanceMode() {
            this.performanceMode = false;

            // Update CSS for normal mode
            document.documentElement.removeAttribute('data-performance-mode');

            // Resume all animations
            this.resumeAllAnimations();

            // Reset CSS custom properties
            document.documentElement.style.removeProperty('--animation-duration');
            document.documentElement.style.removeProperty('--transition-duration');

            // Dispatch event
            window.dispatchEvent(new CustomEvent('animation:performanceModeDisabled'));
        }

        /**
         * Temporarily disable performance mode
         */
        temporarilyDisablePerformanceMode() {
            if (this.performanceMode && this.isVisible && !this.reducedMotion) {
                document.documentElement.removeAttribute('data-performance-mode');
                document.documentElement.style.removeProperty('--animation-duration');
                document.documentElement.style.removeProperty('--transition-duration');
            }
        }

        /**
         * Toggle animations based on visibility
         */
        toggleAnimations() {
            if (this.isVisible && !this.performanceMode) {
                this.resumeAllAnimations();
            } else {
                this.pauseAllAnimations();
            }
        }

        /**
         * Register animation
         */
        registerAnimation(element, config = {}) {
            const animation = {
                element,
                config: {
                    autoPlay: config.autoPlay !== false,
                    loop: config.loop !== false,
                    duration: config.duration || 1000,
                    easing: config.easing || 'ease',
                    ...config
                },
                state: 'registered',
                isVisible: true,
                intersectionRatio: 0,
                lastPlayed: null,
                playCount: 0
            };

            this.animations.set(element, animation);

            // Add to intersection observer
            if (this.intersectionObserver) {
                this.intersectionObserver.observe(element);
            }

            // Add to resize observer
            if (this.resizeObserver) {
                this.resizeObserver.observe(element);
            }

            // Auto-play if requested
            if (animation.config.autoPlay && this.shouldAnimationPlay(animation)) {
                this.playAnimation(element);
            }

            // Dispatch event
            window.dispatchEvent(new CustomEvent('animation:registered', {
                detail: { element, animation }
            }));

            return animation;
        }

        /**
         * Unregister animation
         */
        unregisterAnimation(element) {
            const animation = this.animations.get(element);
            if (!animation) return;

            // Stop animation
            this.pauseAnimation(element);

            // Remove from observers
            if (this.intersectionObserver) {
                this.intersectionObserver.unobserve(element);
            }

            if (this.resizeObserver) {
                this.resizeObserver.unobserve(element);
            }

            // Remove from registry
            this.animations.delete(element);

            // Dispatch event
            window.dispatchEvent(new CustomEvent('animation:unregistered', {
                detail: { element, animation }
            }));
        }

        /**
         * Check if animation should play
         */
        shouldAnimationPlay(animation) {
            return this.isVisible &&
                   !this.performanceMode &&
                   !this.reducedMotion &&
                   animation.isVisible &&
                   (animation.config.playWhenVisible ? animation.intersectionRatio > 0.1 : true);
        }

        /**
         * Play animation
         */
        playAnimation(element) {
            const animation = this.animations.get(element);
            if (!animation) return;

            if (!this.shouldAnimationPlay(animation)) {
                return;
            }

            animation.state = 'playing';
            animation.lastPlayed = performance.now();
            animation.playCount++;

            // Apply animation styles
            this.applyAnimationStyles(element, animation);

            // Dispatch event
            window.dispatchEvent(new CustomEvent('animation:playing', {
                detail: { element, animation }
            }));
        }

        /**
         * Pause animation
         */
        pauseAnimation(element) {
            const animation = this.animations.get(element);
            if (!animation) return;

            if (animation.state !== 'playing') return;

            animation.state = 'paused';

            // Apply pause styles
            element.style.animationPlayState = 'paused';

            // Dispatch event
            window.dispatchEvent(new CustomEvent('animation:paused', {
                detail: { element, animation }
            }));
        }

        /**
         * Apply animation styles
         */
        applyAnimationStyles(element, animation) {
            const config = animation.config;

            // Set animation properties
            element.style.animationName = config.name || 'none';
            element.style.animationDuration = `${config.duration}ms`;
            element.style.animationTimingFunction = config.easing;
            element.style.animationIterationCount = config.loop ? 'infinite' : config.iterations || 1;
            element.style.animationDirection = config.direction || 'normal';
            element.style.animationDelay = `${config.delay || 0}ms`;
            element.style.animationFillMode = config.fillMode || 'both';
            element.style.animationPlayState = 'running';
        }

        /**
         * Handle animation visibility change
         */
        handleAnimationVisibility(animation, isVisible, intersectionRatio) {
            const wasVisible = animation.isVisible;
            animation.isVisible = isVisible;
            animation.intersectionRatio = intersectionRatio;

            if (wasVisible !== isVisible) {
                if (isVisible && this.shouldAnimationPlay(animation)) {
                    this.playAnimation(animation.element);
                } else if (!isVisible) {
                    this.pauseAnimation(animation.element);
                }
            }
        }

        /**
         * Handle animation resize
         */
        handleAnimationResize(animation, contentRect) {
            // Dispatch resize event for custom handling
            window.dispatchEvent(new CustomEvent('animation:resized', {
                detail: {
                    element: animation.element,
                    animation,
                    contentRect
                }
            }));
        }

        /**
         * Observe animated elements
         */
        observeAnimatedElements() {
            // Find elements with animation classes or attributes
            const animatedElements = document.querySelectorAll([
                '[data-animate]',
                '[data-animation]',
                '.animate',
                '.animated',
                '.fade-in',
                '.slide-in',
                '.zoom-in'
            ].join(','));

            animatedElements.forEach(element => {
                if (!this.animations.has(element)) {
                    const config = this.parseAnimationConfig(element);
                    this.registerAnimation(element, config);
                }
            });
        }

        /**
         * Parse animation configuration from element
         */
        parseAnimationConfig(element) {
            const config = {
                name: element.getAttribute('data-animation-name') || element.getAttribute('data-animate'),
                duration: parseInt(element.getAttribute('data-animation-duration')) ||
                         parseInt(element.style.animationDuration) || 1000,
                delay: parseInt(element.getAttribute('data-animation-delay')) || 0,
                easing: element.getAttribute('data-animation-easing') || 'ease',
                loop: element.getAttribute('data-animation-loop') === 'true',
                iterations: parseInt(element.getAttribute('data-animation-iterations')) || 1,
                direction: element.getAttribute('data-animation-direction') || 'normal',
                fillMode: element.getAttribute('data-animation-fill-mode') || 'both',
                autoPlay: element.getAttribute('data-animation-autoplay') !== 'false',
                playWhenVisible: element.getAttribute('data-animation-play-when-visible') === 'true'
            };

            return config;
        }

        /**
         * Pause all animations
         */
        pauseAllAnimations() {
            this.animations.forEach((animation, element) => {
                this.pauseAnimation(element);
            });
        }

        /**
         * Resume all animations
         */
        resumeAllAnimations() {
            this.animations.forEach((animation, element) => {
                if (this.shouldAnimationPlay(animation)) {
                    this.playAnimation(element);
                }
            });
        }

        /**
         * Get performance metrics
         */
        getPerformanceMetrics() {
            const runtime = performance.now() - this.performanceMetrics.startTime;
            const actualFrameRate = this.performanceMetrics.totalFrames / (runtime / 1000);

            return {
                ...this.performanceMetrics,
                actualFrameRate: Math.round(actualFrameRate),
                currentFrameRate: Math.round(this.frameRate),
                targetFrameRate: this.targetFrameRate,
                performanceMode: this.performanceMode,
                isVisible: this.isVisible,
                reducedMotion: this.reducedMotion,
                activeAnimations: this.animations.size,
                playingAnimations: Array.from(this.animations.values()).filter(a => a.state === 'playing').length,
                deviceMemory: this.deviceMemory,
                cpuCores: this.cpuCores,
                connectionType: this.connection ? this.connection.effectiveType : 'unknown',
                runtime: Math.round(runtime)
            };
        }

        /**
         * Get animation info
         */
        getAnimationInfo(element) {
            return this.animations.get(element);
        }

        /**
         * Get all animations
         */
        getAllAnimations() {
            return Array.from(this.animations.entries()).map(([element, animation]) => ({
                element,
                animation,
                isVisible: animation.isVisible,
                isPlaying: animation.state === 'playing'
            }));
        }

        /**
         * Update animation configuration
         */
        updateAnimationConfig(element, newConfig) {
            const animation = this.animations.get(element);
            if (!animation) return;

            Object.assign(animation.config, newConfig);

            // Re-apply animation if it's currently playing
            if (animation.state === 'playing') {
                this.applyAnimationStyles(element, animation);
            }
        }

        /**
         * Set global frame rate target
         */
        setTargetFrameRate(fps) {
            this.targetFrameRate = Math.max(1, Math.min(120, fps));
            this.budget.maxFrameTime = 1000 / this.targetFrameRate * 1.2;
            this.budget.minFrameRate = this.targetFrameRate * 0.8;
        }

        /**
         * Reset performance metrics
         */
        resetPerformanceMetrics() {
            this.performanceMetrics = {
                frameDrops: 0,
                averageFrameTime: 0,
                maxFrameTime: 0,
                totalFrames: 0,
                startTime: performance.now()
            };
            this.frameCount = 0;
        }

        /**
         * Destroy animation manager
         */
        destroy() {
            // Clear animation frame
            if (this.animationFrame) {
                cancelAnimationFrame(this.animationFrame);
            }

            // Disconnect observers
            if (this.intersectionObserver) {
                this.intersectionObserver.disconnect();
            }

            if (this.resizeObserver) {
                this.resizeObserver.disconnect();
            }

            // Clear timers
            clearTimeout(this.interactionTimeout);

            // Stop all animations
            this.animations.forEach((animation, element) => {
                this.unregisterAnimation(element);
            });

            // Remove event listeners
            document.removeEventListener('visibilitychange', this.handleVisibilityChange);
            document.removeEventListener('pagehide', this.handlePageHide);
            document.removeEventListener('freeze', this.handlePageFreeze);
            document.removeEventListener('resume', this.handlePageResume);
            window.removeEventListener('focus', this.handleWindowFocus);
            window.removeEventListener('blur', this.handleWindowBlur);
        }
    }

    /**
     * Initialize Animation Manager
     */
    function initAnimationManager() {
        // Create global instance
        window.AITSC_AnimationManager = new AnimationManager();

        // Add to window for external access
        window.animationManager = window.AITSC_AnimationManager;

        // Auto-detect and register existing animations
        setTimeout(() => {
            window.AITSC_AnimationManager.observeAnimatedElements();
        }, 100);

        // Expose API for external use
        window.animationAPI = {
            register: (element, config) => window.AITSC_AnimationManager.registerAnimation(element, config),
            unregister: (element) => window.AITSC_AnimationManager.unregisterAnimation(element),
            play: (element) => window.AITSC_AnimationManager.playAnimation(element),
            pause: (element) => window.AITSC_AnimationManager.pauseAnimation(element),
            getMetrics: () => window.AITSC_AnimationManager.getPerformanceMetrics(),
            setTargetFrameRate: (fps) => window.AITSC_AnimationManager.setTargetFrameRate(fps),
            enablePerformanceMode: () => window.AITSC_AnimationManager.enablePerformanceMode(),
            disablePerformanceMode: () => window.AITSC_AnimationManager.disablePerformanceMode()
        };

        return window.AITSC_AnimationManager;
    }

    /**
     * Initialize on DOM ready
     */
    function onDOMReady() {
        initAnimationManager();

        // Add CSS for animation states
        const style = document.createElement('style');
        style.textContent = `
            [data-performance-mode="true"] * {
                animation-duration: 0.1s !important;
                transition-duration: 0.1s !important;
                animation-iteration-count: 1 !important;
            }

            [data-reduced-motion="true"] * {
                animation-duration: 0.01s !important;
                transition-duration: 0.01s !important;
                animation-play-state: paused !important;
            }

            [data-animation-paused="true"] * {
                animation-play-state: paused !important;
                transition: none !important;
            }

            .animation-optimizing {
                will-change: auto;
                backface-visibility: hidden;
                perspective: 1000px;
                transform: translateZ(0);
            }
        `;
        document.head.appendChild(style);
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', onDOMReady);
    } else {
        onDOMReady();
    }

})();