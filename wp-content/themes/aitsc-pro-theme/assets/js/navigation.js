/**
 * Navigation Functionality
 * Handles mobile menu toggle, dropdown menus, and smooth scroll
 * 
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

(function ($) {
    'use strict';

    $(document).ready(function () {
        // Mobile Menu Toggle
        const mobileToggle = $('.menu-toggle');
        const primaryNav = $('.main-navigation');

        if (mobileToggle.length && primaryNav.length) {
            mobileToggle.on('click', function (e) {
                e.preventDefault();
                const isExpanded = $(this).attr('aria-expanded') === 'true';
                $(this).attr('aria-expanded', !isExpanded);
                $(this).toggleClass('active');
                primaryNav.toggleClass('active');
                $('body').toggleClass('menu-open');
            });
        }

        // Dropdown Menu Toggle (Mobile)
        $('.menu-item-has-children > a').on('click', function (e) {
            if ($(window).width() < 992) {
                e.preventDefault();
                $(this).parent().toggleClass('open');
                $(this).next('.sub-menu').slideToggle(300);
            }
        });

        // Close mobile menu when clicking outside
        $(document).on('click', function (e) {
            if (!$(e.target).closest('.site-header').length) {
                if (primaryNav.hasClass('active')) {
                    mobileToggle.attr('aria-expanded', 'false');
                    mobileToggle.removeClass('active');
                    primaryNav.removeClass('active');
                    $('body').removeClass('menu-open');
                }
            }
        });

        // Smooth scroll for anchor links
        $('a[href*="#"]:not([href="#"])').on('click', function (e) {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
                let target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');

                if (target.length) {
                    e.preventDefault();
                    const offsetTop = target.offset().top - 80; // Account for sticky header

                    $('html, body').animate({
                        scrollTop: offsetTop
                    }, 800, 'swing');

                    // Close mobile menu if open
                    if (primaryNav.hasClass('active')) {
                        mobileToggle.attr('aria-expanded', 'false');
                        mobileToggle.removeClass('active');
                        primaryNav.removeClass('active');
                        $('body').removeClass('menu-open');
                    }
                }
            }
        });
    });

})(jQuery);
