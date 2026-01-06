/**
 * Multi-Step Contact Form Handler
 */
(function () {
    'use strict';

    let currentStep = 1;
    const totalSteps = 4;

    function init() {
        const form = document.querySelector('#aitsc-multi-step-form');
        if (!form) return;

        // Hide all steps except first
        showStep(1);

        // Next buttons
        document.querySelectorAll('.next-step').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const nextStep = parseInt(this.dataset.next);
                if (validateStep(currentStep)) {
                    showStep(nextStep);
                }
            });
        });

        // Previous buttons
        document.querySelectorAll('.previous-step').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const prevStep = parseInt(this.dataset.previous);
                showStep(prevStep);
            });
        });

        // Form submission
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (validateStep(currentStep)) {
                // Update review section
                updateReviewSection();
                console.log('Form submitted');
                // Here you would normally send the form data
            }
        });
    }

    function showStep(stepNumber) {
        // Hide all steps
        document.querySelectorAll('.form-step').forEach(step => {
            step.classList.remove('active');
        });

        // Show target step
        const targetStep = document.querySelector(`.form-step[data-step="${stepNumber}"]`);
        if (targetStep) {
            targetStep.classList.add('active');
            currentStep = stepNumber;

            // Update progress
            updateProgress(stepNumber);
        }
    }

    function updateProgress(stepNumber) {
        // Update progress bar
        const progressFill = document.querySelector('.progress-fill');
        if (progressFill) {
            const percentage = (stepNumber / totalSteps) * 100;
            progressFill.style.width = `${percentage}%`;
        }

        // Update progress steps
        document.querySelectorAll('.progress-step').forEach((step, index) => {
            if (index < stepNumber) {
                step.classList.add('completed');
                step.classList.remove('active');
            } else if (index === stepNumber - 1) {
                step.classList.add('active');
                step.classList.remove('completed');
            } else {
                step.classList.remove('active', 'completed');
            }
        });
    }

    function validateStep(stepNumber) {
        const step = document.querySelector(`.form-step[data-step="${stepNumber}"]`);
        if (!step) return true;

        const inputs = step.querySelectorAll('[required]');
        let isValid = true;

        inputs.forEach(input => {
            const errorSpan = input.parentElement.querySelector('.form-error');

            if (!input.value.trim()) {
                isValid = false;
                if (errorSpan) errorSpan.style.display = 'block';
                input.style.borderColor = '#ff4444';
            } else {
                if (errorSpan) errorSpan.style.display = 'none';
                input.style.borderColor = 'rgba(255, 255, 255, 0.1)';
            }
        });

        return isValid;
    }

    function updateReviewSection() {
        // Contact Info
        const contactReview = document.getElementById('review-contact');
        if (contactReview) {
            const firstName = document.getElementById('contact-first-name').value;
            const lastName = document.getElementById('contact-last-name').value;
            const email = document.getElementById('contact-email').value;
            const phone = document.getElementById('contact-phone').value;

            contactReview.innerHTML = `
                <p><strong>Name:</strong> ${firstName} ${lastName}</p>
                <p><strong>Email:</strong> ${email}</p>
                <p><strong>Phone:</strong> ${phone}</p>
            `;
        }

        // Business Info
        const businessReview = document.getElementById('review-business');
        if (businessReview) {
            const company = document.getElementById('company-name').value;
            const industry = document.getElementById('industry')?.value || 'N/A';
            const vehicles = document.getElementById('vehicle-count')?.value || 'N/A';

            businessReview.innerHTML = `
                <p><strong>Company:</strong> ${company}</p>
                <p><strong>Industry:</strong> ${industry}</p>
                <p><strong>Fleet Size:</strong> ${vehicles} vehicles</p>
            `;
        }

        // Services
        const servicesReview = document.getElementById('review-services');
        if (servicesReview) {
            const selectedServices = Array.from(document.querySelectorAll('input[name="services[]"]:checked'))
                .map(cb => cb.value);

            servicesReview.innerHTML = selectedServices.length > 0
                ? `<ul>${selectedServices.map(s => `<li>${s}</li>`).join('')}</ul>`
                : '<p>No services selected</p>';
        }
    }

    // Initialize on DOM ready
    console.log('AITSC Forms script loaded');

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            console.log('DOM Content Loaded - Initializing Form');
            init();
        });
    } else {
        console.log('DOM already loaded - Initializing Form immediately');
        init();
    }
})();
