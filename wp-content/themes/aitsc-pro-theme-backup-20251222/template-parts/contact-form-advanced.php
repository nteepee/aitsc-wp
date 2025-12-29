<?php
/**
 * Advanced Contact Form Template Part
 *
 * Professional contact and quote request forms with validation
 * WorldQuant-inspired design with multi-step functionality
 *
 * @package AITSC_Pro_Theme
 * @since 2.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Get customizer settings
$form_title = get_theme_mod('aitsc_contact_title', 'Get Your Transport Safety Assessment');
$form_subtitle = get_theme_mod('aitsc_contact_subtitle', 'Contact our expert team for a comprehensive safety assessment and customized solution for your transport operations.');
$form_type = get_theme_mod('aitsc_contact_form_type', 'multi-step'); // single, multi-step
$show_services = get_theme_mod('aitsc_contact_show_services', true);
$show_urgency = get_theme_mod('aitsc_contact_show_urgency', true);
$show_company_size = get_theme_mod('aitsc_contact_show_company_size', true);
$show_industry = get_theme_mod('aitsc_contact_show_industry', true);

// Get AITSC content
$service_categories = aitsc_get_service_categories();
$industries_served = aitsc_get_industries_served();
$contact_info = aitsc_get_contact_info();
?>

<section class="contact-form-section section">
    <div class="container">
        <!-- Section Header -->
        <div class="contact-header text-center">
            <h2 class="section-title animate-slide-up">
                <?php echo esc_html($form_title); ?>
            </h2>
            <?php if ($form_subtitle) : ?>
            <p class="section-subtitle animate-slide-up delay-1">
                <?php echo esc_html($form_subtitle); ?>
            </p>
            <?php endif; ?>
        </div>

        <div class="contact-form-container animate-fade-in-up delay-2">
            <div class="contact-form-wrapper">
                <?php if ($form_type === 'multi-step') : ?>
                    <!-- Multi-step Contact Form -->
                    <form id="aitsc-multi-step-form" class="multi-step-form" novalidate>
                        <!-- Progress Bar -->
                        <div class="form-progress">
                            <div class="progress-steps">
                                <div class="progress-step active" data-step="1">
                                    <span class="step-number">1</span>
                                    <span class="step-title">Contact Details</span>
                                </div>
                                <div class="progress-step" data-step="2">
                                    <span class="step-number">2</span>
                                    <span class="step-title">Business Info</span>
                                </div>
                                <div class="progress-step" data-step="3">
                                    <span class="step-number">3</span>
                                    <span class="step-title">Services</span>
                                </div>
                                <div class="progress-step" data-step="4">
                                    <span class="step-number">4</span>
                                    <span class="step-title">Review</span>
                                </div>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 25%;"></div>
                            </div>
                        </div>

                        <!-- Step 1: Contact Details -->
                        <div class="form-step active" data-step="1">
                            <div class="step-header">
                                <h3 class="step-title">Your Contact Information</h3>
                                <p class="step-description">Let us know how to reach you to discuss your transport safety requirements.</p>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="contact-first-name" class="form-label">First Name *</label>
                                    <input type="text" id="contact-first-name" name="first_name" class="form-input" required>
                                    <span class="form-error">Please enter your first name</span>
                                </div>
                                <div class="form-group">
                                    <label for="contact-last-name" class="form-label">Last Name *</label>
                                    <input type="text" id="contact-last-name" name="last_name" class="form-input" required>
                                    <span class="form-error">Please enter your last name</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="contact-email" class="form-label">Email Address *</label>
                                <input type="email" id="contact-email" name="email" class="form-input" required>
                                <span class="form-error">Please enter a valid email address</span>
                            </div>

                            <div class="form-group">
                                <label for="contact-phone" class="form-label">Phone Number *</label>
                                <input type="tel" id="contact-phone" name="phone" class="form-input" required>
                                <span class="form-error">Please enter your phone number</span>
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn btn-primary next-step" data-next="2">
                                    Next Step
                                    <span class="btn-arrow">→</span>
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Business Information -->
                        <div class="form-step" data-step="2">
                            <div class="step-header">
                                <h3 class="step-title">Business Information</h3>
                                <p class="step-description">Tell us about your business and transport operations.</p>
                            </div>

                            <div class="form-group">
                                <label for="company-name" class="form-label">Company Name *</label>
                                <input type="text" id="company-name" name="company_name" class="form-input" required>
                                <span class="form-error">Please enter your company name</span>
                            </div>

                            <?php if ($show_company_size) : ?>
                            <div class="form-group">
                                <label for="company-size" class="form-label">Company Size *</label>
                                <select id="company-size" name="company_size" class="form-select" required>
                                    <option value="">Please select company size</option>
                                    <option value="1-10">1-10 employees</option>
                                    <option value="11-50">11-50 employees</option>
                                    <option value="51-100">51-100 employees</option>
                                    <option value="101-500">101-500 employees</option>
                                    <option value="500+">500+ employees</option>
                                </select>
                                <span class="form-error">Please select your company size</span>
                            </div>
                            <?php endif; ?>

                            <?php if ($show_industry) : ?>
                            <div class="form-group">
                                <label for="industry" class="form-label">Industry *</label>
                                <select id="industry" name="industry" class="form-select" required>
                                    <option value="">Please select your industry</option>
                                    <?php foreach ($industries_served as $industry => $description) : ?>
                                    <option value="<?php echo esc_attr($industry); ?>">
                                        <?php echo esc_html($industry); ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <option value="Other">Other</option>
                                </select>
                                <span class="form-error">Please select your industry</span>
                            </div>
                            <?php endif; ?>

                            <div class="form-group">
                                <label for="vehicle-count" class="form-label">Number of Vehicles in Fleet *</label>
                                <input type="number" id="vehicle-count" name="vehicle_count" class="form-input" min="1" required>
                                <span class="form-error">Please enter the number of vehicles</span>
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn btn-outline previous-step" data-previous="1">
                                    <span class="btn-arrow">←</span>
                                    Previous
                                </button>
                                <button type="button" class="btn btn-primary next-step" data-next="3">
                                    Next Step
                                    <span class="btn-arrow">→</span>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Services -->
                        <div class="form-step" data-step="3">
                            <div class="step-header">
                                <h3 class="step-title">Services Required</h3>
                                <p class="step-description">Select the services you're interested in for your transport safety program.</p>
                            </div>

                            <?php if ($show_services) : ?>
                            <div class="form-group">
                                <label class="form-label">Select Services *</label>
                                <div class="checkbox-group">
                                    <?php foreach ($service_categories as $category_key => $category) : ?>
                                    <div class="service-category">
                                        <h4 class="category-title"><?php echo esc_html($category['title']); ?></h4>
                                        <?php foreach ($category['services'] as $service_key => $service) : ?>
                                        <div class="checkbox-item">
                                            <input type="checkbox" id="service-<?php echo esc_attr($service_key); ?>"
                                                   name="services[]" value="<?php echo esc_attr($service_key); ?>" class="form-checkbox">
                                            <label for="service-<?php echo esc_attr($service_key); ?>" class="checkbox-label">
                                                <span class="checkbox-text">
                                                    <strong><?php echo esc_html($service['title']); ?></strong>
                                                    <span class="service-description">
                                                        <?php echo esc_html(wp_trim_words($service['description'], 15, '...')); ?>
                                                    </span>
                                                    <?php if (isset($service['pricing'])) : ?>
                                                    <span class="service-price"><?php echo esc_html($service['pricing']); ?></span>
                                                    <?php endif; ?>
                                                </span>
                                            </label>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <span class="form-error">Please select at least one service</span>
                            </div>
                            <?php endif; ?>

                            <div class="form-group">
                                <label for="message" class="form-label">Additional Information</label>
                                <textarea id="message" name="message" class="form-textarea" rows="4"
                                          placeholder="Tell us more about your specific requirements or challenges..."></textarea>
                            </div>

                            <?php if ($show_urgency) : ?>
                            <div class="form-group">
                                <label for="urgency" class="form-label">Urgency</label>
                                <select id="urgency" name="urgency" class="form-select">
                                    <option value="low">Low - Planning for future implementation</option>
                                    <option value="medium" selected>Medium - Implementation within 3 months</option>
                                    <option value="high">High - Urgent compliance requirements</option>
                                    <option value="critical">Critical - Immediate assistance needed</option>
                                </select>
                            </div>
                            <?php endif; ?>

                            <div class="form-actions">
                                <button type="button" class="btn btn-outline previous-step" data-previous="2">
                                    <span class="btn-arrow">←</span>
                                    Previous
                                </button>
                                <button type="button" class="btn btn-primary next-step" data-next="4">
                                    Review Request
                                    <span class="btn-arrow">→</span>
                                </button>
                            </div>
                        </div>

                        <!-- Step 4: Review -->
                        <div class="form-step" data-step="4">
                            <div class="step-header">
                                <h3 class="step-title">Review Your Request</h3>
                                <p class="step-description">Please review your information and submit your transport safety assessment request.</p>
                            </div>

                            <div class="review-summary">
                                <div class="summary-section">
                                    <h4 class="summary-title">Contact Information</h4>
                                    <div class="summary-content" id="review-contact">
                                        <!-- Populated by JavaScript -->
                                    </div>
                                </div>

                                <div class="summary-section">
                                    <h4 class="summary-title">Business Details</h4>
                                    <div class="summary-content" id="review-business">
                                        <!-- Populated by JavaScript -->
                                    </div>
                                </div>

                                <div class="summary-section">
                                    <h4 class="summary-title">Services Selected</h4>
                                    <div class="summary-content" id="review-services">
                                        <!-- Populated by JavaScript -->
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" id="consent" name="consent" class="form-checkbox" required>
                                    <span class="checkbox-text">
                                        I agree to be contacted by AITSC regarding my transport safety requirements and understand that my information will be handled according to the Privacy Policy.
                                    </span>
                                </label>
                                <span class="form-error">Please accept the terms to continue</span>
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn btn-outline previous-step" data-previous="3">
                                    <span class="btn-arrow">←</span>
                                    Previous
                                </button>
                                <button type="submit" class="btn btn-neon btn-lg">
                                    Submit Assessment Request
                                    <span class="btn-arrow">→</span>
                                </button>
                            </div>
                        </div>

                        <!-- Hidden fields -->
                        <input type="hidden" name="form_type" value="multi_step_contact">
                        <input type="hidden" name="form_id" value="aitsc_contact_form">
                        <?php wp_nonce_field('aitsc_contact_form_submit', 'aitsc_nonce'); ?>
                    </form>

                <?php else : ?>
                    <!-- Single Step Contact Form -->
                    <form id="aitsc-single-form" class="single-form" novalidate>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="single-first-name" class="form-label">First Name *</label>
                                <input type="text" id="single-first-name" name="first_name" class="form-input" required>
                                <span class="form-error">Please enter your first name</span>
                            </div>
                            <div class="form-group">
                                <label for="single-last-name" class="form-label">Last Name *</label>
                                <input type="text" id="single-last-name" name="last_name" class="form-input" required>
                                <span class="form-error">Please enter your last name</span>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="single-email" class="form-label">Email Address *</label>
                                <input type="email" id="single-email" name="email" class="form-input" required>
                                <span class="form-error">Please enter a valid email address</span>
                            </div>
                            <div class="form-group">
                                <label for="single-phone" class="form-label">Phone Number *</label>
                                <input type="tel" id="single-phone" name="phone" class="form-input" required>
                                <span class="form-error">Please enter your phone number</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="single-company" class="form-label">Company Name *</label>
                            <input type="text" id="single-company" name="company_name" class="form-input" required>
                            <span class="form-error">Please enter your company name</span>
                        </div>

                        <div class="form-group">
                            <label for="single-subject" class="form-label">Subject *</label>
                            <select id="single-subject" name="subject" class="form-select" required>
                                <option value="">Please select a subject</option>
                                <option value="nhvas-accreditation">NHVAS Accreditation</option>
                                <option value="cor-compliance">Chain of Responsibility</option>
                                <option value="safety-consulting">Safety Consulting</option>
                                <option value="driver-training">Driver Training</option>
                                <option value="general-inquiry">General Inquiry</option>
                            </select>
                            <span class="form-error">Please select a subject</span>
                        </div>

                        <div class="form-group">
                            <label for="single-message" class="form-label">Message *</label>
                            <textarea id="single-message" name="message" class="form-textarea" rows="6" required
                                      placeholder="Please describe your transport safety requirements or questions..."></textarea>
                            <span class="form-error">Please enter your message</span>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-neon btn-lg">
                                Send Message
                                <span class="btn-arrow">→</span>
                            </button>
                        </div>

                        <!-- Hidden fields -->
                        <input type="hidden" name="form_type" value="single_contact">
                        <input type="hidden" name="form_id" value="aitsc_contact_form">
                        <?php wp_nonce_field('aitsc_contact_form_submit', 'aitsc_nonce'); ?>
                    </form>
                <?php endif; ?>

                <!-- Form Success Message -->
                <div id="form-success" class="form-message success" style="display: none;">
                    <div class="message-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="message-content">
                        <h3 class="message-title">Thank You!</h3>
                        <p class="message-text">Your transport safety assessment request has been submitted successfully. Our team will contact you within 24 hours to discuss your requirements.</p>
                    </div>
                </div>

                <!-- Form Error Message -->
                <div id="form-error" class="form-message error" style="display: none;">
                    <div class="message-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 8V12M12 16H12.01M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="message-content">
                        <h3 class="message-title">Submission Error</h3>
                        <p class="message-text">There was an error submitting your request. Please try again or contact us directly at <?php echo esc_html($contact_info['phone']); ?>.</p>
                    </div>
                </div>
            </div>

            <!-- Contact Information Sidebar -->
            <div class="contact-info-sidebar">
                <div class="info-card">
                    <div class="info-header">
                        <h3 class="info-title">Contact Information</h3>
                        <p class="info-subtitle">Reach out to our expert team</p>
                    </div>

                    <div class="info-items">
                        <div class="info-item">
                            <div class="info-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.5 19.5 0 01-6 6 19.5 19.5 0 01-8.63 3.07A2 2 0 012 19.93V16.92a2 2 0 011.84-2 8.6 8.6 0 016.13 3.7 8.6 8.6 0 016.13-3.7A2 2 0 0122 16.92z"/>
                                    <path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Phone</div>
                                <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9]/', '', $contact_info['phone'])); ?>" class="info-value">
                                    <?php echo esc_html($contact_info['phone_display']); ?>
                                </a>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                    <polyline points="22,6 12,13 2,9"/>
                                </svg>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Email</div>
                                <a href="mailto:<?php echo esc_attr($contact_info['email']); ?>" class="info-value">
                                    <?php echo esc_html($contact_info['email']); ?>
                                </a>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12,6 12,12 16,14"/>
                                </svg>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Business Hours</div>
                                <div class="info-value"><?php echo esc_html($contact_info['business_hours']); ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-header">
                        <h3 class="info-title">Service Areas</h3>
                        <p class="info-subtitle">Nationally accredited consultant</p>
                    </div>

                    <div class="service-areas">
                        <ul class="areas-list">
                            <?php foreach ($contact_info['service_areas'] as $area) : ?>
                            <li class="area-item">
                                <span class="area-marker"></span>
                                <?php echo esc_html($area); ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-header">
                        <h3 class="info-title">Emergency Support</h3>
                        <p class="info-subtitle">Available 24/7 for urgent matters</p>
                    </div>

                    <div class="emergency-contact">
                        <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9]/', '', $contact_info['emergency_contact'])); ?>"
                           class="emergency-number">
                            <?php echo esc_html($contact_info['emergency_contact']); ?>
                        </a>
                        <p class="emergency-note">For urgent compliance and safety matters</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
/**
 * Inline styles for the contact form
 */
$contact_form_styles = '
/* Multi-step form progress */
.form-progress {
    margin-bottom: 3rem;
}

.progress-steps {
    display: flex;
    justify-content: space-between;
    position: relative;
    margin-bottom: 1rem;
}

.progress-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    z-index: 2;
}

.step-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: var(--aitsc-bg-secondary);
    color: var(--aitsc-text-muted);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    transition: all var(--aitsc-transition-fast);
    margin-bottom: 0.5rem;
}

.step-title {
    font-size: var(--aitsc-font-sm);
    color: var(--aitsc-text-muted);
    text-align: center;
    transition: all var(--aitsc-transition-fast);
}

.progress-step.active .step-number {
    background-color: var(--aitsc-primary);
    color: var(--aitsc-text-light);
    transform: scale(1.1);
}

.progress-step.active .step-title {
    color: var(--aitsc-primary);
    font-weight: 500;
}

.progress-step.completed .step-number {
    background-color: var(--aitsc-success);
    color: var(--aitsc-text-light);
}

.progress-bar {
    position: relative;
    height: 4px;
    background-color: var(--aitsc-bg-secondary);
    border-radius: 2px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: var(--aitsc-gradient-primary);
    transition: width var(--aitsc-transition-normal);
}

/* Form steps */
.form-step {
    display: none;
    animation: fadeInUp 0.5s ease-out;
}

.form-step.active {
    display: block;
}

.step-header {
    text-align: center;
    margin-bottom: 2rem;
}

.step-title {
    font-size: var(--aitsc-font-2xl);
    font-weight: 600;
    color: var(--aitsc-text-primary);
    margin-bottom: 0.5rem;
}

.step-description {
    color: var(--aitsc-text-secondary);
    font-size: var(--aitsc-font-lg);
    max-width: 600px;
    margin: 0 auto;
}

/* Service categories */
.service-category {
    margin-bottom: 2rem;
    background-color: var(--aitsc-bg-card);
    border-radius: var(--aitsc-radius-lg);
    padding: 1.5rem;
    border: 1px solid var(--aitsc-bg-secondary);
    transition: all var(--aitsc-transition-fast);
}

.service-category:hover {
    border-color: var(--aitsc-primary);
    box-shadow: var(--aitsc-shadow-md);
}

.category-title {
    font-size: var(--aitsc-font-lg);
    font-weight: 600;
    color: var(--aitsc-primary);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.category-title::before {
    content: "▶";
    font-size: var(--aitsc-font-sm);
    color: var(--aitsc-primary);
}

/* Checkbox styling */
.checkbox-group {
    display: grid;
    gap: 1rem;
}

.checkbox-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.form-checkbox {
    margin-top: 0.25rem;
    flex-shrink: 0;
}

.checkbox-label {
    cursor: pointer;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.checkbox-text {
    display: block;
}

.service-description {
    font-size: var(--aitsc-font-sm);
    color: var(--aitsc-text-muted);
    line-height: 1.4;
}

.service-price {
    font-weight: 600;
    color: var(--aitsc-primary);
    font-size: var(--aitsc-font-sm);
}

/* Review summary */
.review-summary {
    background-color: var(--aitsc-bg-secondary);
    border-radius: var(--aitsc-radius-lg);
    padding: 2rem;
    margin-bottom: 2rem;
}

.summary-section {
    margin-bottom: 1.5rem;
}

.summary-section:last-child {
    margin-bottom: 0;
}

.summary-title {
    font-size: var(--aitsc-font-lg);
    font-weight: 600;
    color: var(--aitsc-text-primary);
    margin-bottom: 0.75rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--aitsc-primary);
}

.summary-content {
    color: var(--aitsc-text-secondary);
    line-height: 1.6;
}

/* Form messages */
.form-message {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1.5rem;
    border-radius: var(--aitsc-radius-lg);
    margin-top: 2rem;
    animation: fadeInUp 0.5s ease-out;
}

.form-message.success {
    background-color: rgba(0, 204, 102, 0.1);
    border: 1px solid var(--aitsc-success);
    color: var(--aitsc-success);
}

.form-message.error {
    background-color: rgba(255, 68, 68, 0.1);
    border: 1px solid var(--aitsc-danger);
    color: var(--aitsc-danger);
}

.message-icon {
    flex-shrink: 0;
    margin-top: 0.25rem;
}

.message-title {
    font-size: var(--aitsc-font-lg);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.message-text {
    line-height: 1.6;
}

/* Contact sidebar */
.contact-form-container {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 3rem;
}

.contact-info-sidebar {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.info-card {
    background-color: var(--aitsc-bg-card);
    border-radius: var(--aitsc-radius-lg);
    padding: 1.5rem;
    border: 1px solid var(--aitsc-bg-secondary);
    transition: all var(--aitsc-transition-fast);
}

.info-card:hover {
    box-shadow: var(--aitsc-shadow-md);
    transform: translateY(-2px);
}

.info-header {
    margin-bottom: 1rem;
}

.info-title {
    font-size: var(--aitsc-font-lg);
    font-weight: 600;
    color: var(--aitsc-text-primary);
    margin-bottom: 0.25rem;
}

.info-subtitle {
    font-size: var(--aitsc-font-sm);
    color: var(--aitsc-text-muted);
}

.info-items {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.info-icon {
    width: 40px;
    height: 40px;
    background-color: rgba(0, 102, 204, 0.1);
    border-radius: var(--aitsc-radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--aitsc-primary);
    flex-shrink: 0;
}

.info-content {
    flex: 1;
}

.info-label {
    font-size: var(--aitsc-font-xs);
    color: var(--aitsc-text-muted);
    margin-bottom: 0.25rem;
}

.info-value {
    font-weight: 500;
    color: var(--aitsc-text-primary);
    text-decoration: none;
    transition: color var(--aitsc-transition-fast);
}

.info-value:hover {
    color: var(--aitsc-primary);
}

/* Service areas */
.areas-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.5rem;
}

.area-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: var(--aitsc-font-sm);
    color: var(--aitsc-text-secondary);
}

.area-marker {
    width: 8px;
    height: 8px;
    background-color: var(--aitsc-primary);
    border-radius: 50%;
    flex-shrink: 0;
}

/* Emergency contact */
.emergency-contact {
    text-align: center;
}

.emergency-number {
    display: block;
    font-size: var(--aitsc-font-xl);
    font-weight: 700;
    color: var(--aitsc-danger);
    text-decoration: none;
    margin-bottom: 0.5rem;
    transition: all var(--aitsc-transition-fast);
}

.emergency-number:hover {
    color: var(--aitsc-primary-dark);
    transform: scale(1.05);
}

.emergency-note {
    font-size: var(--aitsc-font-sm);
    color: var(--aitsc-text-muted);
}

/* Mobile responsive */
@media (max-width: 992px) {
    .contact-form-container {
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    .progress-steps {
        flex-wrap: wrap;
        gap: 1rem;
    }

    .step-title {
        font-size: var(--aitsc-font-xs);
    }
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }

    .areas-list {
        grid-template-columns: 1fr;
    }

    .service-category {
        padding: 1rem;
    }
}
';

wp_add_inline_style('aitsc-contact-form', $contact_form_styles);
?>