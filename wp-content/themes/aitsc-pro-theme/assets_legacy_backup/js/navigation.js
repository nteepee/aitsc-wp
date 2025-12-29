/**
 * AITSC Navigation Components
 * Enhanced navigation with WorldQuant-inspired interactions
 */

// Prevent class redeclaration
if (typeof AITSCNavigation === 'undefined') {
class AITSCNavigation {
    constructor() {
        this.siteHeader = document.getElementById('masthead');
        this.mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        this.mobileNavigation = document.getElementById('mobile-navigation');
        this.desktopNavigation = document.getElementById('desktop-navigation');
        this.isScrolling = false;
        this.lastScrollY = 0;
        this.scrollThreshold = 50;

        this.init();
    }

    init() {
        this.setupScrollEffects();
        this.setupMobileMenu();
        this.setupDesktopMenu();
        this.setupKeyboardNavigation();
        this.setupAccessibility();
        this.bindEvents();
    }

    setupScrollEffects() {
        // Sticky header with scroll effects
        window.addEventListener('scroll', () => {
            if (!this.isScrolling) {
                window.requestAnimationFrame(() => {
                    this.handleScroll();
                    this.isScrolling = false;
                });
                this.isScrolling = true;
            }
        });

        // Initial header state
        this.updateHeaderState();
    }

    handleScroll() {
        const currentScrollY = window.pageYOffset;
        const scrollDirection = currentScrollY > this.lastScrollY ? 'down' : 'up';

        this.lastScrollY = currentScrollY;
        this.updateHeaderState(scrollDirection);
    }

    updateHeaderState(scrollDirection = 'up') {
        const scrollY = window.pageYOffset;
        const isScrolled = scrollY > this.scrollThreshold;

        // Add scrolled class for styling
        if (isScrolled) {
            this.siteHeader.classList.add('header-scrolled');
        } else {
            this.siteHeader.classList.remove('header-scrolled');
        }

        // Auto-hide on scroll down (desktop only)
        if (window.innerWidth > 768) {
            if (scrollDirection === 'down' && scrollY > 200) {
                this.siteHeader.style.transform = 'translateY(-100%)';
            } else {
                this.siteHeader.style.transform = 'translateY(0)';
            }
        }
    }

    setupMobileMenu() {
        if (!this.mobileMenuToggle || !this.mobileNavigation) return;

        this.mobileMenuToggle.addEventListener('click', (e) => {
            e.preventDefault();
            this.toggleMobileMenu();
        });

        // Close menu on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.mobileNavigation.classList.contains('menu-open')) {
                this.closeMobileMenu();
            }
        });

        // Close menu on outside click
        document.addEventListener('click', (e) => {
            if (this.mobileNavigation.classList.contains('menu-open')) {
                const isClickInsideMenu = this.mobileNavigation.contains(e.target);
                const isClickOnToggle = this.mobileMenuToggle.contains(e.target);

                if (!isClickInsideMenu && !isClickOnToggle) {
                    this.closeMobileMenu();
                }
            }
        });
    }

    toggleMobileMenu() {
        const isOpen = this.mobileNavigation.classList.contains('menu-open');

        if (isOpen) {
            this.closeMobileMenu();
        } else {
            this.openMobileMenu();
        }
    }

    openMobileMenu() {
        this.mobileNavigation.classList.add('menu-open');
        this.mobileMenuToggle.classList.add('menu-open');
        this.mobileNavigation.setAttribute('aria-hidden', 'false');
        this.mobileMenuToggle.setAttribute('aria-expanded', 'true');

        // Prevent body scroll
        document.body.style.overflow = 'hidden';

        // Focus first menu item
        const firstMenuItem = this.mobileNavigation.querySelector('a');
        if (firstMenuItem) {
            setTimeout(() => firstMenuItem.focus(), 100);
        }
    }

    closeMobileMenu() {
        this.mobileNavigation.classList.remove('menu-open');
        this.mobileMenuToggle.classList.remove('menu-open');
        this.mobileNavigation.setAttribute('aria-hidden', 'true');
        this.mobileMenuToggle.setAttribute('aria-expanded', 'false');

        // Restore body scroll
        document.body.style.overflow = '';

        // Return focus to toggle button
        this.mobileMenuToggle.focus();
    }

    setupDesktopMenu() {
        if (!this.desktopNavigation) return;

        const menuItems = this.desktopNavigation.querySelectorAll('.menu-item-has-children');

        menuItems.forEach(item => {
            const link = item.querySelector('a');
            const submenu = item.querySelector('.sub-menu');

            if (!submenu) return;

            // Enhanced dropdown functionality
            let hoverTimeout;

            const showSubmenu = () => {
                clearTimeout(hoverTimeout);
                submenu.style.display = 'block';
                submenu.style.opacity = '0';
                submenu.style.transform = 'translateY(-10px)';

                // Trigger reflow
                submenu.offsetHeight;

                submenu.style.transition = 'all 0.3s ease';
                submenu.style.opacity = '1';
                submenu.style.transform = 'translateY(0)';

                item.classList.add('submenu-open');
            };

            const hideSubmenu = () => {
                hoverTimeout = setTimeout(() => {
                    submenu.style.opacity = '0';
                    submenu.style.transform = 'translateY(-10px)';

                    setTimeout(() => {
                        submenu.style.display = 'none';
                    }, 300);

                    item.classList.remove('submenu-open');
                }, 150);
            };

            // Mouse events
            item.addEventListener('mouseenter', showSubmenu);
            item.addEventListener('mouseleave', hideSubmenu);

            // Touch events for mobile/tablet
            link.addEventListener('touchstart', (e) => {
                if (window.innerWidth <= 1024) {
                    e.preventDefault();
                    showSubmenu();
                }
            });

            // Keyboard events
            link.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    const isVisible = submenu.style.display === 'block';
                    if (isVisible) {
                        hideSubmenu();
                    } else {
                        showSubmenu();
                        // Focus first submenu item
                        const firstSubmenuItem = submenu.querySelector('a');
                        if (firstSubmenuItem) {
                            setTimeout(() => firstSubmenuItem.focus(), 100);
                        }
                    }
                }
            });
        });
    }

    setupKeyboardNavigation() {
        // Add keyboard navigation for all menus
        const menuItems = document.querySelectorAll('.primary-menu li, .mobile-primary-menu li');

        menuItems.forEach((item, index) => {
            const link = item.querySelector('a');
            if (!link) return;

            link.addEventListener('keydown', (e) => {
                switch (e.key) {
                    case 'ArrowDown':
                        e.preventDefault();
                        const nextItem = menuItems[index + 1];
                        if (nextItem) {
                            nextItem.querySelector('a').focus();
                        }
                        break;

                    case 'ArrowUp':
                        e.preventDefault();
                        const prevItem = menuItems[index - 1];
                        if (prevItem) {
                            prevItem.querySelector('a').focus();
                        }
                        break;

                    case 'Home':
                        e.preventDefault();
                        menuItems[0].querySelector('a').focus();
                        break;

                    case 'End':
                        e.preventDefault();
                        menuItems[menuItems.length - 1].querySelector('a').focus();
                        break;
                }
            });
        });
    }

    setupAccessibility() {
        // Ensure proper ARIA attributes
        this.mobileNavigation?.setAttribute('role', 'navigation');
        this.desktopNavigation?.setAttribute('role', 'navigation');

        // Add role to menus
        const menus = document.querySelectorAll('.primary-menu, .mobile-primary-menu');
        menus.forEach(menu => {
            menu.setAttribute('role', 'menubar');

            const menuItems = menu.querySelectorAll('li');
            menuItems.forEach(item => {
                item.setAttribute('role', 'none');

                const link = item.querySelector('a');
                if (link) {
                    link.setAttribute('role', 'menuitem');
                }

                const submenu = item.querySelector('.sub-menu');
                if (submenu) {
                    submenu.setAttribute('role', 'menu');
                    submenu.setAttribute('aria-label', 'Submenu');
                }
            });
        });
    }

    bindEvents() {
        // Handle window resize
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                this.handleResize();
            }, 250);
        });

        // Handle orientation change
        window.addEventListener('orientationchange', () => {
            setTimeout(() => {
                this.handleResize();
            }, 500);
        });
    }

    handleResize() {
        // Close mobile menu on resize to desktop
        if (window.innerWidth > 768 && this.mobileNavigation.classList.contains('menu-open')) {
            this.closeMobileMenu();
        }

        // Update header state
        this.updateHeaderState();
    }

    // Public methods for external use
    smoothScrollTo(element, offset = 80) {
        const targetElement = typeof element === 'string' ? document.querySelector(element) : element;
        if (!targetElement) return;

        const targetPosition = targetElement.offsetTop - offset;
        const startPosition = window.pageYOffset;
        const distance = targetPosition - startPosition;
        const duration = 800;

        let start = null;

        const animation = (currentTime) => {
            if (start === null) start = currentTime;
            const timeElapsed = currentTime - start;
            const run = easeInOutCubic(timeElapsed, startPosition, distance, duration);

            window.scrollTo(0, run);

            if (timeElapsed < duration) {
                requestAnimationFrame(animation);
            }
        };

        requestAnimationFrame(animation);
    }

    setupSmoothScrolling() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', (e) => {
                const href = anchor.getAttribute('href');

                if (href === '#' || href === '') return;

                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();

                    // Close mobile menu if open
                    if (this.mobileNavigation.classList.contains('menu-open')) {
                        this.closeMobileMenu();
                    }

                    this.smoothScrollTo(target);

                    // Update URL
                    history.pushState(null, null, href);
                }
            });
        });
    }
}

// Easing function
function easeInOutCubic(t, b, c, d) {
    t /= d/2;
    if (t < 1) return c/2*t*t*t + b;
    t -= 2;
    return c/2*(t*t*t + 2) + b;
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    if (typeof AITSCNavigation !== 'undefined') {
        window.aitscNavigation = new AITSCNavigation();
        window.aitscNavigation.setupSmoothScrolling();
    }
});

} // End of conditional class declaration