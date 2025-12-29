<?php
/**
 * Template Name: AITSC About Page
 *
 * @package AITSC_Pro_Theme
 */

get_header();
?>

<main id="primary" class="site-main">

    <!-- HERO SECTION -->
    <section class="page-hero full-width"
        style="padding: 12rem 0 8rem; background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.9)), url('<?php echo get_template_directory_uri(); ?>/assets/images/brand/hero-texture.jpg'); background-size: cover; background-position: center;">
        <div class="container">
            <h1 class="hero-title text-center max-w-4xl mx-auto">
                Custom Electronics Engineering for <span class="text-blue">Automotive & Transport</span>
            </h1>
            <p class="hero-subtitle text-center mx-auto mt-6 text-xl text-gray-300 max-w-3xl">
                We solve your most expensive technology problems without spending more.
            </p>
        </div>
    </section>

    <!-- MISSION & VISION -->
    <section class="section full-width bg-black">
        <div class="container">
            <div class="mb-12">
                <h2 class="text-4xl font-bold text-white mb-4">Our Mission</h2>
                <p class="text-xl text-gray-400 max-w-2xl">To solve the most critical technology gaps in multi-million-dollar industries and make a lasting difference for technology in Australia.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- What We Do -->
                <div class="card bg-panel p-8 border border-gray-800 rounded-xl">
                    <div class="icon text-blue mb-6">
                        <span class="material-symbols-outlined text-5xl">precision_manufacturing</span>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">What We Do</h3>
                    <p class="text-gray-400">We solve your most expensive technology problems without spending more. From custom PCB design to embedded firmware, we deliver complete electronics solutions tailored to your operational needs.</p>
                </div>

                <!-- What Drives Us -->
                <div class="card bg-panel p-8 border border-gray-800 rounded-xl">
                    <div class="icon text-blue mb-6">
                        <span class="material-symbols-outlined text-5xl">bolt</span>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">What Drives Us</h3>
                    <p class="text-gray-400">AITSC is PASSIONATE about new technology and how to leverage it to make companies more efficient. We're KNOWN for our ability to identify and maximize opportunities and for our relentless execution skills.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CORE VALUES -->
    <section class="section full-width bg-panel">
        <div class="container">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-white">Our Core Values</h2>
                <p class="text-gray-400 mt-4">The principles that guide our work and partnerships.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6">
                    <div
                        class="w-16 h-16 bg-blue-900/20 text-blue rounded-lg flex items-center justify-center mx-auto mb-6">
                        <span class="material-symbols-outlined text-3xl">precision_manufacturing</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Custom Design</h3>
                    <p class="text-gray-400">Every project starts with your unique requirements. We don't do off-the-shelf - we design custom solutions.
                    </p>
                </div>

                <div class="text-center p-6">
                    <div
                        class="w-16 h-16 bg-blue-900/20 text-blue rounded-lg flex items-center justify-center mx-auto mb-6">
                        <span class="material-symbols-outlined text-3xl">verified_user</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Automotive-Grade Standards</h3>
                    <p class="text-gray-400">ISO 26262 functional safety compliance, CAN bus expertise, and automotive-grade engineering.</p>
                </div>

                <div class="text-center p-6">
                    <div
                        class="w-16 h-16 bg-blue-900/20 text-blue rounded-lg flex items-center justify-center mx-auto mb-6">
                        <span class="material-symbols-outlined text-3xl">layers</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Full-Stack Integration</h3>
                    <p class="text-gray-400">From PCB layout to firmware development to sensor calibration - we handle every technical layer.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section id="contact" class="contact-cta section full-width bg-black">
        <div class="container">
            <div class="cta-content text-center">
                <h2 class="text-4xl font-bold text-white mb-6">Ready to Start Your Project?</h2>
                <p class="text-xl text-gray-400 mb-8 max-w-3xl mx-auto">Whether you need a custom electronics solution or want to deploy Fleet Safe Pro in your fleet, our engineering team is ready to help.</p>
                <div class="flex gap-4 justify-center mt-8">
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold">Start a Conversation</a>
                    <a href="<?php echo esc_url(home_url('/solutions/fleet-safe-pro')); ?>" class="btn btn-outline px-8 py-4 border-2 border-blue-600 text-blue-400 hover:bg-blue-600/10 rounded-lg font-semibold">Explore Fleet Safe Pro →</a>
                </div>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>