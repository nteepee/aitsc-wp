/**
 * Enhanced Dark Mode Toggle (Legacy Support)
 * Enhanced fallback for systems where the main dark-mode.js might not load
 * Provides backward compatibility with enhanced functionality
 */

(function() {
  'use strict';

  const STORAGE_KEY = 'aitsc-theme';
  const THEME_LIGHT = 'light';
  const THEME_DARK = 'dark';

  /**
   * Enhanced theme detection with better fallback
   */
  function getCurrentTheme() {
    // Check if enhanced dark mode manager is available
    if (window.AITSC_DarkMode) {
      return window.AITSC_DarkMode.getTheme();
    }

    const stored = localStorage.getItem(STORAGE_KEY);
    if (stored && (stored === THEME_LIGHT || stored === THEME_DARK)) {
      return stored;
    }

    // Enhanced system preference check
    if (window.matchMedia) {
      const prefersDark = window.matchMedia('(prefers-color-scheme: dark)');
      return prefersDark.matches ? THEME_DARK : THEME_LIGHT;
    }

    return THEME_LIGHT;
  }

  /**
   * Enhanced theme application with transition support
   */
  function applyTheme(theme, updateStorage = true) {
    const root = document.documentElement;

    // Add transition class for smooth switching
    root.classList.add('theme-transitioning');
    root.setAttribute('data-theme', theme);

    // Update localStorage if requested
    if (updateStorage) {
      localStorage.setItem(STORAGE_KEY, theme);
    }

    // Update toggle button
    updateToggleIcon(theme);

    // Announce change for accessibility
    announceThemeChange(theme);

    // Remove transition class after completion
    setTimeout(() => {
      root.classList.remove('theme-transitioning');
    }, 300);

    // Emit custom event for other components
    window.dispatchEvent(new CustomEvent('themeChanged', {
      detail: { theme, source: 'legacy-toggle' }
    }));
  }

  /**
   * Enhanced toggle button update
   */
  function updateToggleIcon(theme) {
    const toggleBtn = document.querySelector('[data-theme-toggle]');
    if (!toggleBtn) return;

    const icon = toggleBtn.querySelector('.theme-icon');
    if (!icon) return;

    // Enhanced icon and accessibility
    if (theme === THEME_DARK) {
      icon.textContent = '☀️';
      icon.setAttribute('aria-label', 'Switch to light mode');
      icon.setAttribute('title', 'Switch to light mode');
    } else {
      icon.textContent = '🌙';
      icon.setAttribute('aria-label', 'Switch to dark mode');
      icon.setAttribute('title', 'Switch to dark mode');
    }

    // Update button ARIA attributes
    toggleBtn.setAttribute('aria-checked', theme === THEME_DARK ? 'true' : 'false');
    toggleBtn.setAttribute('aria-label', `Theme: ${theme}, click to toggle`);

    // Ensure minimum touch target
    const computedStyle = window.getComputedStyle(toggleBtn);
    if (parseInt(computedStyle.width) < 44 || parseInt(computedStyle.height) < 44) {
      toggleBtn.style.minWidth = '44px';
      toggleBtn.style.minHeight = '44px';
    }
  }

  /**
   * Enhanced theme toggle with fallback
   */
  function toggleTheme() {
    // Check if enhanced manager is available
    if (window.AITSC_DarkMode) {
      window.AITSC_DarkMode.toggleTheme();
      return;
    }

    const current = getCurrentTheme();
    const next = current === THEME_LIGHT ? THEME_DARK : THEME_LIGHT;
    applyTheme(next, true);
  }

  /**
   * Set theme programmatically
   */
  function setTheme(theme) {
    if (window.AITSC_DarkMode) {
      window.AITSC_DarkMode.setTheme(theme);
      return;
    }

    if (theme === THEME_LIGHT || theme === THEME_DARK) {
      applyTheme(theme, true);
    }
  }

  /**
   * Announce theme change for screen readers
   */
  function announceThemeChange(theme) {
    let liveRegion = document.getElementById('theme-announcement');
    if (!liveRegion) {
      liveRegion = document.createElement('div');
      liveRegion.id = 'theme-announcement';
      liveRegion.setAttribute('aria-live', 'polite');
      liveRegion.setAttribute('aria-atomic', 'true');
      liveRegion.className = 'sr-only';
      document.body.appendChild(liveRegion);
    }

    liveRegion.textContent = `Theme changed to ${theme} mode`;

    setTimeout(() => {
      liveRegion.textContent = '';
    }, 1000);
  }

  /**
   * Enhanced keyboard navigation
   */
  function setupKeyboardNavigation() {
    const toggleBtn = document.querySelector('[data-theme-toggle]');
    if (!toggleBtn) return;

    toggleBtn.addEventListener('keydown', (e) => {
      switch (e.key) {
        case 'Enter':
        case ' ':
          e.preventDefault();
          toggleTheme();
          break;
        case 'ArrowRight':
          e.preventDefault();
          setTheme(THEME_DARK);
          break;
        case 'ArrowLeft':
          e.preventDefault();
          setTheme(THEME_LIGHT);
          break;
      }
    });
  }

  /**
   * Enhanced touch optimization
   */
  function setupTouchOptimization() {
    const toggleBtn = document.querySelector('[data-theme-toggle]');
    if (!toggleBtn) return;

    // Add touch feedback
    toggleBtn.addEventListener('touchstart', (e) => {
      toggleBtn.classList.add('touch-active');
    }, { passive: true });

    toggleBtn.addEventListener('touchend', () => {
      setTimeout(() => {
        toggleBtn.classList.remove('touch-active');
      }, 150);
    });
  }

  /**
   * Enhanced system preference listening
   */
  function setupSystemPreferenceListener() {
    if (!window.matchMedia) return;

    const darkModeQuery = window.matchMedia('(prefers-color-scheme: dark)');

    darkModeQuery.addEventListener('change', (e) => {
      // Only auto-switch if user hasn't manually set preference
      if (!localStorage.getItem(STORAGE_KEY)) {
        applyTheme(e.matches ? THEME_DARK : THEME_LIGHT, false);
      }
    });
  }

  /**
   * Enhanced initialization
   */
  function init() {
    // Apply initial theme without transition for page load
    const theme = getCurrentTheme();
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem(STORAGE_KEY, theme);

    // Update toggle button
    updateToggleIcon(theme);

    // Setup enhanced features
    const toggleBtn = document.querySelector('[data-theme-toggle]');
    if (toggleBtn) {
      // Click handler
      toggleBtn.addEventListener('click', toggleTheme);

      // Enhanced features
      setupKeyboardNavigation();
      setupTouchOptimization();
    }

    // System preference listener
    setupSystemPreferenceListener();

    // Wait for page to fully load before enabling transitions
    window.addEventListener('load', () => {
      document.documentElement.setAttribute('data-theme-loaded', 'true');
    });

    // Global API for external access
    window.themeToggle = {
      toggle: toggleTheme,
      set: setTheme,
      get: getCurrentTheme,
      isDark: () => getCurrentTheme() === THEME_DARK
    };
  }

  // Run on DOM ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();
