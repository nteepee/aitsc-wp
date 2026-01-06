<?php
/**
 * Template Part: Call-to-Action Section
 *
 * Displays CTA with form or button.
 *
 * @package AITSC_Pro_Theme
 */

// Try to get group field first, fallback to individual fields
$cta = get_field('cta');
if ($cta && is_array($cta)) {
    $title = $cta['cta_section_title'] ?? 'Ready to Get Started?';
    $description = $cta['cta_section_description'] ?? '';
    $button_text = $cta['cta_button_text'] ?? 'Request Quote';
    $button_link = $cta['cta_button_link'] ?? '#contact';
} else {
    // Access sub-fields directly
    $title = get_field('cta_cta_section_title') ?: 'Ready to Get Started?';
    $description = get_field('cta_cta_section_description') ?: '';
    $button_text = get_field('cta_cta_button_text') ?: 'Request Quote';
    $button_link = get_field('cta_cta_button_link') ?: '#contact';
}

// Show CTA section even if just title exists
if (!$title) {
    return;
}
?>

<!-- CALL-TO-ACTION SECTION -->
<section id="contact"
    class="relative py-24 md:py-32 bg-gradient-to-b from-black via-slate-950 to-black overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/10 via-purple-600/10 to-blue-600/10 opacity-30">
        </div>
        <div class="absolute inset-0"
            style="background-image: radial-gradient(circle at 50% 50%, rgba(59, 130, 246, 0.1) 1px, transparent 1px); background-size: 30px 30px;">
        </div>
    </div>

    <div class="container relative max-w-7xl mx-auto px-4 md:px-8">
        <!-- Main CTA Container -->
        <div class="bg-gradient-to-br from-slate-900/80 to-slate-800/50 backdrop-blur-xl
                    border border-blue-600/30 rounded-3xl overflow-hidden
                    shadow-2xl shadow-blue-600/20" data-aos="fade-up">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                <!-- Left Column: Content -->
                <div class="p-8 md:p-12 lg:p-16 flex flex-col justify-center">
                    <!-- Badge -->
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600/10 border border-blue-600/20 rounded-full mb-6 self-start">
                        <span class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></span>
                        <span class="text-sm font-medium text-blue-300">Get In Touch</span>
                    </div>

                    <!-- Title -->
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6 leading-tight">
                        <?php echo esc_html($title); ?>
                    </h2>

                    <!-- Description -->
                    <?php if ($description): ?>
                        <div class="text-lg text-slate-300 mb-8 leading-relaxed">
                            <?php echo wp_kses_post($description); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Trust Indicators -->
                    <div class="space-y-4 mb-8">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-600/20 rounded-lg flex items-center justify-center">
                                <span class="material-symbols-outlined text-blue-400">check_circle</span>
                            </div>
                            <span class="text-slate-300">Trusted by leading transport operators</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-600/20 rounded-lg flex items-center justify-center">
                                <span class="material-symbols-outlined text-blue-400">support_agent</span>
                            </div>
                            <span class="text-slate-300">Expert technical support included</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-600/20 rounded-lg flex items-center justify-center">
                                <span class="material-symbols-outlined text-blue-400">schedule</span>
                            </div>
                            <span class="text-slate-300">Quick response within 24 hours</span>
                        </div>
                    </div>

                    <!-- Quick Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="mailto:info@aitsc.com.au" class="aitsc-cta-btn aitsc-cta-btn-primary">
                            <span class="material-symbols-outlined">email</span>
                            <span>Email Us</span>
                        </a>
                        <a href="tel:+61XXXXXXXXX" class="aitsc-cta-btn aitsc-cta-btn-secondary">
                            <span class="material-symbols-outlined">call</span>
                            <span>Call Us</span>
                        </a>
                    </div>
                </div>

                <!-- Right Column: Form -->
                <div
                    class="bg-gradient-to-br from-blue-600/5 to-purple-600/5 p-8 md:p-12 lg:p-16 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-white mb-6">Request a Demo</h3>

                    <!-- HubSpot Form Container -->
                    <div id="hubspot-form-container" class="space-y-6">
                        <!-- HubSpot form will render here -->
                        <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2.js"></script>
                        <script>
                            // TODO: Replace with actual HubSpot Portal ID and Form ID
                            // hbspt.forms.create({
                            //     region: "na1",
                            //     portalId: "YOUR_PORTAL_ID",
                            //     formId: "YOUR_FORM_ID",
                            //     target: '#hubspot-form-container'
                            // });
                        </script>

                        <!-- Placeholder Form (Remove when HubSpot form is configured) -->
                        <form class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">Full Name*</label>
                                <input type="text" required class="w-full px-4 py-3 bg-black/40 border border-blue-600/20 rounded-lg
                                              text-white placeholder-slate-500 focus:border-blue-600 focus:outline-none
                                              transition-colors duration-200" placeholder="John Smith">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">Email Address*</label>
                                <input type="email" required class="w-full px-4 py-3 bg-black/40 border border-blue-600/20 rounded-lg
                                              text-white placeholder-slate-500 focus:border-blue-600 focus:outline-none
                                              transition-colors duration-200" placeholder="john@company.com">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">Company Name</label>
                                <input type="text" class="w-full px-4 py-3 bg-black/40 border border-blue-600/20 rounded-lg
                                              text-white placeholder-slate-500 focus:border-blue-600 focus:outline-none
                                              transition-colors duration-200" placeholder="Your Company">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">Message</label>
                                <textarea rows="4" class="w-full px-4 py-3 bg-black/40 border border-blue-600/20 rounded-lg
                                                 text-white placeholder-slate-500 focus:border-blue-600 focus:outline-none
                                                 transition-colors duration-200 resize-none"
                                    placeholder="Tell us about your fleet..."></textarea>
                            </div>
                            <button type="submit" class="w-full group px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold
                                           rounded-xl transition-all duration-200 shadow-lg shadow-blue-600/30 hover:shadow-blue-600/50
                                           flex items-center justify-center gap-2">
                                <span>Send Request</span>
                                <span
                                    class="material-symbols-outlined group-hover:translate-x-1 transition-transform">send</span>
                            </button>
                        </form>
                    </div>

                    <!-- Privacy Note -->
                    <p class="text-xs text-slate-500 mt-6 text-center">
                        We respect your privacy. Your information will only be used to contact you about Fleet Safe Pro.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>