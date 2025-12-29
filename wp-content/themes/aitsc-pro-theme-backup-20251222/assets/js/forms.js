/**
 * AITSC Pro Theme - Forms JavaScript
 * Form validation, submission, and enhanced UX
 *
 * @package AITSCProTheme
 * @since 1.0.0
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // Initialize all form enhancements
    initContactForm();
    initFormValidation();
    initFileUpload();
    initAutoResize();
    initCharacterCount();
    initFormTooltips();
    initLoadingStates();

    /**
     * Contact form handling with AJAX
     */
    function initContactForm() {
        const contactForms = document.querySelectorAll('.contact-form, #contact-form');

        contactForms.forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
                const formData = new FormData(form);

                // Add loading state
                if (submitButton) {
                    setButtonLoading(submitButton, true);
                }

                // Validate form before submission
                if (!validateForm(form)) {
                    if (submitButton) {
                        setButtonLoading(submitButton, false);
                    }
                    return;
                }

                // AJAX submission
                fetch(aitscData.ajaxurl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(function(response) {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(function(data) {
                    handleFormResponse(form, data);
                })
                .catch(function(error) {
                    console.error('Error:', error);
                    showFormMessage(form, 'An error occurred. Please try again.', 'error');
                })
                .finally(function() {
                    if (submitButton) {
                        setButtonLoading(submitButton, false);
                    }
                });
            });
        });
    }

    function setButtonLoading(button, isLoading) {
        const originalText = button.textContent;

        if (isLoading) {
            button.disabled = true;
            button.classList.add('loading');
            button.setAttribute('data-original-text', originalText);
            button.innerHTML = '<span class="spinner"></span> Sending...';
        } else {
            button.disabled = false;
            button.classList.remove('loading');
            button.textContent = button.getAttribute('data-original-text') || originalText;
        }
    }

    function validateForm(form) {
        let isValid = true;
        const fields = form.querySelectorAll('input[required], textarea[required], select[required]');

        fields.forEach(function(field) {
            if (!validateField(field)) {
                isValid = false;
            }
        });

        return isValid;
    }

    function validateField(field) {
        const value = field.value.trim();
        const fieldType = field.type;
        const fieldName = field.name;
        let isValid = true;
        let errorMessage = '';

        // Remove previous error states
        removeFieldError(field);

        // Required field validation
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = 'This field is required.';
        }

        // Email validation
        if (fieldType === 'email' && value && !isValidEmail(value)) {
            isValid = false;
            errorMessage = 'Please enter a valid email address.';
        }

        // Phone validation
        if ((fieldType === 'tel' || fieldName.includes('phone')) && value && !isValidPhone(value)) {
            isValid = false;
            errorMessage = 'Please enter a valid phone number.';
        }

        // URL validation
        if (fieldType === 'url' && value && !isValidUrl(value)) {
            isValid = false;
            errorMessage = 'Please enter a valid URL.';
        }

        // Min/Max length validation
        if (field.getAttribute('minlength') && value.length < parseInt(field.getAttribute('minlength'))) {
            isValid = false;
            errorMessage = `Minimum ${field.getAttribute('minlength')} characters required.`;
        }

        if (field.getAttribute('maxlength') && value.length > parseInt(field.getAttribute('maxlength'))) {
            isValid = false;
            errorMessage = `Maximum ${field.getAttribute('maxlength')} characters allowed.`;
        }

        // Pattern validation
        if (field.getAttribute('pattern') && value && !new RegExp(field.getAttribute('pattern')).test(value)) {
            isValid = false;
            errorMessage = field.getAttribute('data-pattern-error') || 'Please enter a valid format.';
        }

        if (!isValid) {
            showFieldError(field, errorMessage);
        }

        return isValid;
    }

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function isValidPhone(phone) {
        const phoneRegex = /^[\d\s\-\+\(\)]+$/;
        return phoneRegex.test(phone) && phone.replace(/\D/g, '').length >= 10;
    }

    function isValidUrl(url) {
        try {
            new URL(url);
            return true;
        } catch (_) {
            return false;
        }
    }

    function showFieldError(field, message) {
        field.classList.add('error');

        // Create or update error message
        let errorElement = field.parentNode.querySelector('.error-message');
        if (!errorElement) {
            errorElement = document.createElement('div');
            errorElement.className = 'error-message';
            errorElement.setAttribute('aria-live', 'polite');
            field.parentNode.appendChild(errorElement);
        }

        errorElement.textContent = message;
        errorElement.style.display = 'block';

        // Set aria attributes for accessibility
        field.setAttribute('aria-invalid', 'true');
        field.setAttribute('aria-describedby', errorElement.id || `error-${field.name}`);

        // Focus the field
        field.focus();
    }

    function removeFieldError(field) {
        field.classList.remove('error', 'success');

        const errorElement = field.parentNode.querySelector('.error-message');
        if (errorElement) {
            errorElement.style.display = 'none';
            errorElement.textContent = '';
        }

        field.removeAttribute('aria-invalid');
        field.removeAttribute('aria-describedby');
    }

    function handleFormResponse(form, data) {
        if (data.success) {
            showFormMessage(form, data.message || 'Message sent successfully!', 'success');
            form.reset();

            // Reset character counters
            const counters = form.querySelectorAll('.character-count');
            counters.forEach(function(counter) {
                const textarea = counter.previousElementSibling;
                if (textarea && textarea.tagName === 'TEXTAREA') {
                    updateCharacterCount(textarea);
                }
            });

        } else {
            showFormMessage(form, data.message || 'An error occurred. Please try again.', 'error');
        }
    }

    function showFormMessage(form, message, type) {
        // Remove existing messages
        const existingMessage = form.querySelector('.form-message');
        if (existingMessage) {
            existingMessage.remove();
        }

        // Create message element
        const messageElement = document.createElement('div');
        messageElement.className = `form-message alert alert-${type}`;
        messageElement.setAttribute('role', 'alert');
        messageElement.textContent = message;

        // Insert message at the beginning of the form
        form.insertBefore(messageElement, form.firstChild);

        // Scroll to message
        messageElement.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

        // Auto-remove success messages
        if (type === 'success') {
            setTimeout(function() {
                if (messageElement.parentNode) {
                    messageElement.remove();
                }
            }, 5000);
        }
    }

    /**
     * Real-time form validation
     */
    function initFormValidation() {
        const formFields = document.querySelectorAll('input, textarea, select');

        formFields.forEach(function(field) {
            // Validate on blur
            field.addEventListener('blur', function() {
                if (field.hasAttribute('required') || field.value.trim()) {
                    validateField(field);
                }
            });

            // Validate on input (with debouncing)
            let validateTimeout;
            field.addEventListener('input', function() {
                clearTimeout(validateTimeout);
                validateTimeout = setTimeout(function() {
                    if (field.classList.contains('error')) {
                        validateField(field);
                    }
                }, 500);
            });

            // Remove error on focus
            field.addEventListener('focus', function() {
                if (field.classList.contains('error')) {
                    removeFieldError(field);
                }
            });
        });
    }

    /**
     * File upload enhancements
     */
    function initFileUpload() {
        const fileInputs = document.querySelectorAll('input[type="file"]');

        fileInputs.forEach(function(input) {
            const wrapper = document.createElement('div');
            wrapper.className = 'file-upload-wrapper';

            input.parentNode.insertBefore(wrapper, input);
            wrapper.appendChild(input);

            // Create file info display
            const fileInfo = document.createElement('div');
            fileInfo.className = 'file-info';
            wrapper.appendChild(fileInfo);

            input.addEventListener('change', function() {
                updateFileInfo(input, fileInfo);
            });
        });
    }

    function updateFileInfo(input, infoElement) {
        const files = input.files;

        if (files.length > 0) {
            let fileNames = [];
            let totalSize = 0;

            Array.from(files).forEach(function(file) {
                fileNames.push(file.name);
                totalSize += file.size;
            });

            infoElement.innerHTML = `
                <div class="file-list">
                    <strong>Selected files:</strong>
                    <ul>
                        ${fileNames.map(name => `<li>${name}</li>`).join('')}
                    </ul>
                    <div class="file-size">Total size: ${formatFileSize(totalSize)}</div>
                </div>
            `;
        } else {
            infoElement.innerHTML = '';
        }
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';

        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));

        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    /**
     * Auto-resize textareas
     */
    function initAutoResize() {
        const textareas = document.querySelectorAll('textarea[data-auto-resize]');

        textareas.forEach(function(textarea) {
            textarea.style.resize = 'none';
            textarea.style.overflow = 'hidden';

            // Initial resize
            autoResize(textarea);

            // Resize on input
            textarea.addEventListener('input', function() {
                autoResize(textarea);
            });
        });
    }

    function autoResize(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    }

    /**
     * Character count for textareas
     */
    function initCharacterCount() {
        const textareas = document.querySelectorAll('textarea[maxlength]');

        textareas.forEach(function(textarea) {
            const maxLength = textarea.getAttribute('maxlength');
            if (maxLength) {
                const counter = document.createElement('div');
                counter.className = 'character-count';
                counter.setAttribute('aria-live', 'polite');

                textarea.parentNode.appendChild(counter);
                updateCharacterCount(textarea);

                textarea.addEventListener('input', function() {
                    updateCharacterCount(textarea);
                });
            }
        });
    }

    function updateCharacterCount(textarea) {
        const maxLength = parseInt(textarea.getAttribute('maxlength'));
        const currentLength = textarea.value.length;
        const counter = textarea.nextElementSibling;

        if (counter && counter.classList.contains('character-count')) {
            counter.textContent = `${currentLength} / ${maxLength}`;

            // Update styling based on remaining characters
            const remaining = maxLength - currentLength;
            counter.classList.remove('warning', 'error');

            if (remaining <= 10 && remaining > 0) {
                counter.classList.add('warning');
            } else if (remaining <= 0) {
                counter.classList.add('error');
            }
        }
    }

    /**
     * Form tooltips and help text
     */
    function initFormTooltips() {
        const helpIcons = document.querySelectorAll('.form-help, [data-tooltip]');

        helpIcons.forEach(function(icon) {
            icon.addEventListener('click', function(e) {
                e.preventDefault();
                toggleTooltip(icon);
            });

            icon.addEventListener('mouseenter', function() {
                showTooltip(icon);
            });

            icon.addEventListener('mouseleave', function() {
                hideTooltip(icon);
            });
        });
    }

    function showTooltip(trigger) {
        const tooltipText = trigger.getAttribute('data-tooltip') ||
                           (trigger.nextElementSibling ? trigger.nextElementSibling.textContent : '') || '';

        if (!tooltipText) return;

        let tooltip = trigger.querySelector('.tooltip');
        if (!tooltip) {
            tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = tooltipText;
            trigger.style.position = 'relative';
            trigger.appendChild(tooltip);
        }

        tooltip.classList.add('visible');
    }

    function hideTooltip(trigger) {
        const tooltip = trigger.querySelector('.tooltip');
        if (tooltip) {
            tooltip.classList.remove('visible');
        }
    }

    function toggleTooltip(trigger) {
        const tooltip = trigger.querySelector('.tooltip');
        if (tooltip) {
            tooltip.classList.toggle('visible');
        } else {
            showTooltip(trigger);
        }
    }

    /**
     * Loading states for forms
     */
    function initLoadingStates() {
        const loadingButtons = document.querySelectorAll('[data-loading]');

        loadingButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const loadingText = button.getAttribute('data-loading');
                const originalText = button.textContent;

                setButtonLoading(button, true);

                // Simulate loading (replace with actual async operation)
                setTimeout(function() {
                    setButtonLoading(button, false);
                }, 2000);
            });
        });
    }

    /**
     * Form progress indicators
     */
    function initFormProgress() {
        const progressBars = document.querySelectorAll('.form-progress');

        progressBars.forEach(function(progressBar) {
            const form = progressBar.closest('form');
            if (!form) return;

            updateProgress(form, progressBar);

            // Update progress on field changes
            const fields = form.querySelectorAll('input, textarea, select');
            fields.forEach(function(field) {
                field.addEventListener('change', function() {
                    updateProgress(form, progressBar);
                });
            });
        });
    }

    function updateProgress(form, progressBar) {
        const fields = form.querySelectorAll('input[required], textarea[required], select[required]');
        let filledFields = 0;

        fields.forEach(function(field) {
            if (field.value.trim()) {
                filledFields++;
            }
        });

        const progress = fields.length > 0 ? (filledFields / fields.length) * 100 : 0;

        progressBar.style.width = progress + '%';
        progressBar.setAttribute('aria-valuenow', Math.round(progress));

        const progressText = progressBar.querySelector('.progress-text');
        if (progressText) {
            progressText.textContent = `${Math.round(progress)}% Complete`;
        }
    }

    /**
     * Add CSS for form enhancements
     */
    const formStyles = document.createElement('style');
    formStyles.textContent = `
        .file-upload-wrapper {
            position: relative;
        }

        .file-info {
            margin-top: 0.5rem;
            padding: 0.5rem;
            background: var(--aitsc-gray-50);
            border-radius: var(--aitsc-border-radius-sm);
            font-size: var(--aitsc-font-size-sm);
        }

        .file-list ul {
            margin: 0.25rem 0 0 0;
            padding-left: 1rem;
        }

        .file-size {
            margin-top: 0.25rem;
            color: var(--aitsc-gray-600);
        }

        .character-count {
            font-size: var(--aitsc-font-size-xs);
            color: var(--aitsc-gray-500);
            text-align: right;
            margin-top: 0.25rem;
        }

        .character-count.warning {
            color: var(--aitsc-orange);
        }

        .character-count.error {
            color: var(--aitsc-red);
        }

        .form-help {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 16px;
            height: 16px;
            background: var(--aitsc-gray-300);
            color: var(--aitsc-gray-700);
            border-radius: 50%;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
            margin-left: 0.5rem;
        }

        .tooltip {
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: var(--aitsc-gray-900);
            color: var(--aitsc-white);
            padding: 0.5rem 0.75rem;
            border-radius: var(--aitsc-border-radius-sm);
            font-size: var(--aitsc-font-size-sm);
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
            z-index: 1000;
            margin-bottom: 0.25rem;
        }

        .tooltip.visible {
            opacity: 1;
            visibility: visible;
        }

        .tooltip::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border: 4px solid transparent;
            border-top-color: var(--aitsc-gray-900);
        }

        .form-message {
            margin-bottom: 1rem;
            padding: 1rem;
            border-radius: var(--aitsc-border-radius-md);
            animation: fadeIn 0.3s ease;
        }

        .error-message {
            color: var(--aitsc-red);
            font-size: var(--aitsc-font-size-sm);
            margin-top: 0.25rem;
            display: none;
        }

        .form-progress {
            height: 4px;
            background: var(--aitsc-gray-200);
            border-radius: var(--aitsc-border-radius-sm);
            overflow: hidden;
            margin: 1rem 0;
        }

        .form-progress .progress-bar {
            height: 100%;
            background: var(--aitsc-primary);
            transition: width 0.3s ease;
        }

        .form-progress .progress-text {
            font-size: var(--aitsc-font-size-sm);
            text-align: center;
            margin-top: 0.5rem;
            color: var(--aitsc-gray-600);
        }

        @media (prefers-reduced-motion: reduce) {
            .form-message,
            .tooltip,
            .form-progress .progress-bar {
                animation: none;
                transition: none;
            }
        }
    `;
    document.head.appendChild(formStyles);

    // Initialize form progress
    initFormProgress();
});