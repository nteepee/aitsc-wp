/**
 * AITSC Pro Theme - Customizer Live Preview
 * Handles real-time preview updates using postMessage transport
 * Complete CSS variable integration for Phase 2
 *
 * @package AITSCProTheme
 */

(function($) {
  'use strict';

  // Primary Color
  wp.customize('aitsc_primary_color', function(value) {
    value.bind(function(newval) {
      $(':root').css('--aitsc-color-primary', newval);
    });
  });

  // Accent Neon
  wp.customize('aitsc_accent_neon', function(value) {
    value.bind(function(newval) {
      $(':root').css('--aitsc-color-accent-neon', newval);
    });
  });

  // Accent Orange
  wp.customize('aitsc_accent_orange', function(value) {
    value.bind(function(newval) {
      $(':root').css('--aitsc-color-accent-orange', newval);
    });
  });

  // Accent Blue
  wp.customize('aitsc_accent_blue', function(value) {
    value.bind(function(newval) {
      $(':root').css('--aitsc-color-accent-blue', newval);
    });
  });

  // Font Family
  wp.customize('aitsc_font_family', function(value) {
    value.bind(function(newval) {
      let fontStack;
      switch(newval) {
        case 'inter':
          fontStack = "'Inter', -apple-system, sans-serif";
          break;
        case 'manrope':
          fontStack = "'Manrope', -apple-system, sans-serif";
          break;
        case 'dm-sans':
          fontStack = "'DM Sans', -apple-system, sans-serif";
          break;
        default:
          fontStack = "-apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif";
      }
      $(':root').css('--aitsc-font-primary', fontStack);
      $(':root').css('--aitsc-font-heading', fontStack);
    });
  });

  // Base Font Size
  wp.customize('aitsc_base_font_size', function(value) {
    value.bind(function(newval) {
      $(':root').css('--aitsc-font-base', newval + 'px');

      // Update related font sizes proportionally
      const baseSize = parseFloat(newval);
      $(':root').css('--aitsc-font-xs', (baseSize * 0.75) + 'px');
      $(':root').css('--aitsc-font-sm', (baseSize * 0.875) + 'px');
      $(':root').css('--aitsc-font-lg', (baseSize * 1.125) + 'px');
      $(':root').css('--aitsc-font-xl', (baseSize * 1.25) + 'px');
    });
  });

  // Heading Weight
  wp.customize('aitsc_heading_weight', function(value) {
    value.bind(function(newval) {
      $(':root').css('--aitsc-weight-light', newval);
      $(':root').css('--aitsc-weight-bold', newval);
    });
  });

  // Body Weight
  wp.customize('aitsc_body_weight', function(value) {
    value.bind(function(newval) {
      $(':root').css('--aitsc-weight-normal', newval);
      $(':root').css('--aitsc-weight-regular', newval);
    });
  });

  // Container Width
  wp.customize('aitsc_container_width', function(value) {
    value.bind(function(newval) {
      $(':root').css('--aitsc-container-width', newval + 'px');
    });
  });

  // Section Padding
  wp.customize('aitsc_section_padding', function(value) {
    value.bind(function(newval) {
      $(':root').css('--aitsc-section-padding-desktop', newval + 'px');
      // Update mobile padding proportionally
      $(':root').css('--aitsc-section-padding-mobile', (newval * 0.6) + 'px');
    });
  });

  // Grid Gap
  wp.customize('aitsc_grid_gap', function(value) {
    value.bind(function(newval) {
      $(':root').css('--aitsc-grid-gap-md', newval + 'px');
      // Update related grid gaps
      $(':root').css('--aitsc-grid-gap-sm', (newval * 0.5) + 'px');
      $(':root').css('--aitsc-grid-gap-lg', (newval * 1.5) + 'px');
    });
  });

  // Border Radius
  wp.customize('aitsc_border_radius', function(value) {
    value.bind(function(newval) {
      $(':root').css('--aitsc-radius-md', newval + 'px');
      // Update related radii
      $(':root').css('--aitsc-radius-sm', (newval * 0.5) + 'px');
      $(':root').css('--aitsc-radius-lg', (newval * 1.5) + 'px');
    });
  });

  // Logo Width
  wp.customize('aitsc_logo_width', function(value) {
    value.bind(function(newval) {
      $('.site-logo, .custom-logo').css('max-width', newval + 'px');
    });
  });

  // Sticky Header
  wp.customize('aitsc_sticky_header', function(value) {
    value.bind(function(newval) {
      if (newval) {
        $('body').addClass('has-sticky-header');
      } else {
        $('body').removeClass('has-sticky-header');
      }
    });
  });

  // Header Background Color
  wp.customize('aitsc_header_bg_color', function(value) {
    value.bind(function(newval) {
      $('.site-header').css('background-color', newval);
    });
  });

  // Header Transparency
  wp.customize('aitsc_header_transparency', function(value) {
    value.bind(function(newval) {
      $('.site-header').css('opacity', newval / 100);
    });
  });

  // Footer Layout
  wp.customize('aitsc_footer_layout', function(value) {
    value.bind(function(newval) {
      $('.footer-grid').removeClass('grid-cols-1 grid-cols-2 grid-cols-3 grid-cols-4');
      $('.footer-grid').addClass('grid-cols-' + newval);
    });
  });

  // Footer Background Color
  wp.customize('aitsc_footer_bg_color', function(value) {
    value.bind(function(newval) {
      $('.site-footer').css('background-color', newval);
    });
  });

  // Copyright Text
  wp.customize('aitsc_copyright_text', function(value) {
    value.bind(function(newval) {
      $('.site-info').html(newval);
    });
  });

  // Hero Headline
  wp.customize('aitsc_hero_headline', function(value) {
    value.bind(function(newval) {
      $('.hero-headline').text(newval);
    });
  });

  // Hero Subheadline
  wp.customize('aitsc_hero_subheadline', function(value) {
    value.bind(function(newval) {
      $('.hero-subheadline').html(newval.replace(/\n/g, '<br>'));
    });
  });

  // Hero Background Image
  wp.customize('aitsc_hero_bg_image', function(value) {
    value.bind(function(newval) {
      if (newval) {
        $('.hero-section').css('background-image', 'url(' + newval + ')');
      } else {
        $('.hero-section').css('background-image', 'none');
      }
    });
  });

  // Hero CTA Text
  wp.customize('aitsc_hero_cta_text', function(value) {
    value.bind(function(newval) {
      $('.hero-cta .btn').text(newval);
    });
  });

  // Hero CTA URL
  wp.customize('aitsc_hero_cta_url', function(value) {
    value.bind(function(newval) {
      $('.hero-cta .btn').attr('href', newval);
    });
  });

  // Display Solutions Section
  wp.customize('aitsc_display_solutions', function(value) {
    value.bind(function(newval) {
      if (newval) {
        $('.solutions-section').show();
      } else {
        $('.solutions-section').hide();
      }
    });
  });

  // Hero Background Color
  wp.customize('aitsc_hero_bg_color', function(value) {
    value.bind(function(newval) {
      $('.hero-section').css('background-color', newval);
    });
  });

  // Hero Text Color
  wp.customize('aitsc_hero_text_color', function(value) {
    value.bind(function(newval) {
      $('.hero-section').css('color', newval);
      $('.hero-section h1, .hero-section h2, .hero-section h3, .hero-section h4, .hero-section h5, .hero-section h6, .hero-section p').css('color', newval);
    });
  });

  // Button Border Radius
  wp.customize('aitsc_button_border_radius', function(value) {
    value.bind(function(newval) {
      $('.btn').css('border-radius', newval + 'px');
    });
  });

  // Card Shadow Intensity
  wp.customize('aitsc_card_shadow', function(value) {
    value.bind(function(newval) {
      const intensity = value / 100;
      // Update shadow variables based on intensity
      $(':root').css('--aitsc-shadow-sm', `0 1px 2px rgba(0, 0, 0, ${0.05 * intensity})`);
      $(':root').css('--aitsc-shadow-md', `0 4px 6px rgba(0, 0, 0, ${0.1 * intensity})`);
      $(':root').css('--aitsc-shadow-lg', `0 10px 15px rgba(0, 0, 0, ${0.1 * intensity})`);
      $(':root').css('--aitsc-shadow-xl', `0 20px 25px rgba(0, 0, 0, ${0.15 * intensity})`);
    });
  });

  // Animation Speed
  wp.customize('aitsc_animation_speed', function(value) {
    value.bind(function(newval) {
      const speed = value / 100; // Convert to multiplier
      $(':root').css('--aitsc-transition-fast', (0.15 * speed) + 's cubic-bezier(0.25, 0.46, 0.45, 0.94)');
      $(':root').css('--aitsc-transition-base', (0.25 * speed) + 's cubic-bezier(0.25, 0.46, 0.45, 0.94)');
      $(':root').css('--aitsc-transition-slow', (0.3 * speed) + 's cubic-bezier(0.4, 0, 0.2, 1)');
    });
  });

  // Utility function to update CSS variables dynamically
  function updateCSSVariable(variable, value) {
    document.documentElement.style.setProperty(variable, value);
  }

  // Initialize CSS variables on load
  $(document).ready(function() {
    // Set initial CSS variables from current theme mods
    const primaryColor = wp.customize('aitsc_primary_color')();
    const neonColor = wp.customize('aitsc_accent_neon')();
    const orangeColor = wp.customize('aitsc_accent_orange')();
    const blueColor = wp.customize('aitsc_accent_blue')();
    const baseFontSize = wp.customize('aitsc_base_font_size')();
    const containerWidth = wp.customize('aitsc_container_width')();
    const sectionPadding = wp.customize('aitsc_section_padding')();

    if (primaryColor) updateCSSVariable('--aitsc-color-primary', primaryColor);
    if (neonColor) updateCSSVariable('--aitsc-color-accent-neon', neonColor);
    if (orangeColor) updateCSSVariable('--aitsc-color-accent-orange', orangeColor);
    if (blueColor) updateCSSVariable('--aitsc-color-accent-blue', blueColor);
    if (baseFontSize) updateCSSVariable('--aitsc-font-base', baseFontSize + 'px');
    if (containerWidth) updateCSSVariable('--aitsc-container-width', containerWidth + 'px');
    if (sectionPadding) updateCSSVariable('--aitsc-section-padding-desktop', sectionPadding + 'px');

    // Add page load animation class if enabled
    const enableAnimations = wp.customize('aitsc_enable_animations')();
    if (enableAnimations) {
      $('body').addClass('page-load-animation');
    }

    // Initialize scroll animations if enabled
    const enableScrollAnimations = wp.customize('aitsc_enable_scroll_animations')();
    if (enableScrollAnimations) {
      // Trigger scroll animation initialization
      $(window).trigger('scroll');
    }
  });

  // Advanced: Watch for CSS variable changes and apply transformations
  function watchColorChanges() {
    const observer = new MutationObserver(function(mutations) {
      mutations.forEach(function(mutation) {
        if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
          // Trigger any dependent updates when colors change
          $(document.body).trigger('aitsc-color-change');
        }
      });
    });

    observer.observe(document.documentElement, {
      attributes: true,
      attributeFilter: ['style']
    });
  }

  // Initialize color watching
  watchColorChanges();

  // Log customizer preview initialization
  console.log('AITSC Pro Theme Customizer Preview initialized');

  // Performance optimization: Debounce rapid changes
  function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
      const later = () => {
        clearTimeout(timeout);
        func(...args);
      };
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
    };
  }

  // Apply debouncing to performance-critical customizer settings
  const debouncedContainerUpdate = debounce(function(value) {
    updateCSSVariable('--aitsc-container-width', value + 'px');
  }, 100);

  const debouncedPaddingUpdate = debounce(function(value) {
    updateCSSVariable('--aitsc-section-padding-desktop', value + 'px');
  }, 100);

})(jQuery);