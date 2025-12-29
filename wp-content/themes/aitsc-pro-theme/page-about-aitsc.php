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
                Pioneering the Future of <span class="text-blue">Fleet Safety</span> and Efficiency
            </h1>
            <p class="hero-subtitle text-center mx-auto mt-6 text-xl text-gray-300 max-w-3xl">
                AITS Consulting is dedicated to providing innovative solutions that protect your drivers, assets, and
                bottom line. Discover the minds and mission driving our commitment to excellence.
            </p>
        </div>
    </section>

    <!-- MISSION & VISION -->
    <section class="section full-width bg-black" data-aos="fade-up" data-aos-duration="1000">
        <div class="container">
            <div class="mb-12">
                <h2 class="text-4xl font-bold text-white mb-4">Defining Our Purpose</h2>
                <p class="text-xl text-gray-400 max-w-2xl">At the core of AITS Consulting is a clear mission to enhance
                    road safety through technology.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Mission -->
                <div class="card bg-panel p-8 border border-gray-800 rounded-xl">
                    <div class="icon text-blue mb-6">
                        <span class="material-symbols-outlined text-5xl">track_changes</span>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Our Mission</h3>
                    <p class="text-gray-400">To empower fleets with intelligent, data-driven safety solutions that
                        prevent accidents, reduce risk, and save lives.</p>
                </div>

                <!-- Vision -->
                <div class="card bg-panel p-8 border border-gray-800 rounded-xl">
                    <div class="icon text-blue mb-6">
                        <span class="material-symbols-outlined text-5xl">visibility</span>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Our Vision</h3>
                    <p class="text-gray-400">To create a world where every commercial journey is safe, efficient, and
                        sustainable through technological innovation.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CORE VALUES -->
    <section class="section full-width bg-panel" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
        <div class="container">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-white">Our Core Values</h2>
                <p class="text-gray-400 mt-4">The principles that guide our work and partnerships.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6">
                    <div
                        class="w-16 h-16 bg-blue-900/20 text-blue rounded-lg flex items-center justify-center mx-auto mb-6">
                        <span class="material-symbols-outlined text-3xl">shield</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Safety First</h3>
                    <p class="text-gray-400">Our unwavering commitment is to the well-being of drivers and the public.
                    </p>
                </div>

                <div class="text-center p-6">
                    <div
                        class="w-16 h-16 bg-blue-900/20 text-blue rounded-lg flex items-center justify-center mx-auto mb-6">
                        <span class="material-symbols-outlined text-3xl">lightbulb</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Innovation</h3>
                    <p class="text-gray-400">We continuously push the boundaries of technology to create smarter
                        solutions.</p>
                </div>

                <div class="text-center p-6">
                    <div
                        class="w-16 h-16 bg-blue-900/20 text-blue rounded-lg flex items-center justify-center mx-auto mb-6">
                        <span class="material-symbols-outlined text-3xl">verified</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Integrity</h3>
                    <p class="text-gray-400">We operate with transparency, honesty, and a strong sense of ethical
                        responsibility.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- TEAM -->
    <section class="section full-width bg-black" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
        <div class="container">
            <h2 class="text-3xl font-bold text-white text-center mb-16">Meet the Team</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 text-center">
                <!-- Member 1 -->
                <div class="team-member">
                    <div class="w-40 h-40 bg-gray-800 rounded-full mx-auto mb-6 overflow-hidden">
                        <!-- Placeholder -->
                    </div>
                    <h3 class="text-lg font-bold text-white">Johnathan Doe</h3>
                    <p class="text-blue text-sm font-bold uppercase">Founder & CEO</p>
                </div>

                <!-- Member 2 -->
                <div class="team-member">
                    <div class="w-40 h-40 bg-gray-800 rounded-full mx-auto mb-6 overflow-hidden"></div>
                    <h3 class="text-lg font-bold text-white">Jane Smith</h3>
                    <p class="text-blue text-sm font-bold uppercase">CTO</p>
                </div>

                <!-- Member 3 -->
                <div class="team-member">
                    <div class="w-40 h-40 bg-gray-800 rounded-full mx-auto mb-6 overflow-hidden"></div>
                    <h3 class="text-lg font-bold text-white">David Chen</h3>
                    <p class="text-blue text-sm font-bold uppercase">Head of Product</p>
                </div>

                <!-- Member 4 -->
                <div class="team-member">
                    <div class="w-40 h-40 bg-gray-800 rounded-full mx-auto mb-6 overflow-hidden"></div>
                    <h3 class="text-lg font-bold text-white">Michael Brown</h3>
                    <p class="text-blue text-sm font-bold uppercase">Lead Consultant</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section id="contact" class="contact-cta section full-width">
        <div class="container">
            <div class="cta-content">
                <h2>Ready to enhance your fleet's safety?</h2>
                <div class="flex gap-4 justify-center mt-8">
                    <a href="/contact" class="btn btn-primary">Work With Us</a>
                    <a href="/about" class="btn btn-outline">Learn More →</a>
                </div>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>