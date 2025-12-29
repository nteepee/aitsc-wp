<?php
/**
 * CTA Form Placeholder
 *
 * Native WordPress contact form placeholder component.
 * Ready for HubSpot integration when available.
 *
 * @package AITSC_Pro_Theme
 * @subpackage Components
 * @since 3.1.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// NOTE: This is a placeholder form structure for future integration with HubSpot
// Current implementation uses a basic WordPress form structure
// TODO: Replace with HubSpot embed form when available

?>

<!-- Native WordPress Contact Form Placeholder -->
<!-- Ready for HubSpot Integration -->

<form class="aitsc-form" action="#" method="post" novalidate>
    <div class="aitsc-form__group">
        <label for="cta-name" class="aitsc-form__label">
            <?php esc_html_e('Name', 'aitsc-pro-theme'); ?>
            <span class="required">*</span>
        </label>
        <input
            type="text"
            id="cta-name"
            name="name"
            class="aitsc-form__input"
            required
            aria-required="true"
            placeholder="<?php esc_attr_e('Your full name', 'aitsc-pro-theme'); ?>"
        />
    </div>

    <div class="aitsc-form__group">
        <label for="cta-email" class="aitsc-form__label">
            <?php esc_html_e('Email', 'aitsc-pro-theme'); ?>
            <span class="required">*</span>
        </label>
        <input
            type="email"
            id="cta-email"
            name="email"
            class="aitsc-form__input"
            required
            aria-required="true"
            placeholder="<?php esc_attr_e('your@email.com', 'aitsc-pro-theme'); ?>"
        />
    </div>

    <div class="aitsc-form__group">
        <label for="cta-phone" class="aitsc-form__label">
            <?php esc_html_e('Phone', 'aitsc-pro-theme'); ?>
        </label>
        <input
            type="tel"
            id="cta-phone"
            name="phone"
            class="aitsc-form__input"
            placeholder="<?php esc_attr_e('(optional)', 'aitsc-pro-theme'); ?>"
        />
    </div>

    <div class="aitsc-form__group">
        <label for="cta-message" class="aitsc-form__label">
            <?php esc_html_e('Message', 'aitsc-pro-theme'); ?>
            <span class="required">*</span>
        </label>
        <textarea
            id="cta-message"
            name="message"
            class="aitsc-form__textarea"
            rows="4"
            required
            aria-required="true"
            placeholder="<?php esc_attr_e('How can we help you?', 'aitsc-pro-theme'); ?>"
        ></textarea>
    </div>

    <!-- Honeypot for bot protection -->
    <div style="display: none;">
        <label for="cta-website"><?php esc_html_e('Website', 'aitsc-pro-theme'); ?></label>
        <input type="text" id="cta-website" name="website" tabindex="-1" autocomplete="off" />
    </div>

    <div class="aitsc-form__actions">
        <button type="submit" class="aitsc-form__submit">
            <?php esc_html_e('Send Message', 'aitsc-pro-theme'); ?>
            <span class="material-symbols-outlined">send</span>
        </button>
    </div>

    <!-- Form feedback messages -->
    <div class="aitsc-form__feedback" role="status" aria-live="polite"></div>
</form>

<!-- TODO: HubSpot Integration
     When HubSpot is available, replace the form above with:

     [hubspot type="form" portal="YOUR_PORTAL_ID" id="YOUR_FORM_ID"]

     Or use HubSpot embed code:
     <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/embed/v2.js"></script>
     <script>
       hbspt.forms.create({
         region: "na1",
         portalId: "YOUR_PORTAL_ID",
         formId: "YOUR_FORM_ID"
       });
     </script>
-->

<noscript>
    <div class="aitsc-form__noscript">
        <p><?php esc_html_e('Please enable JavaScript to use this form.', 'aitsc-pro-theme'); ?></p>
    </div>
</noscript>
