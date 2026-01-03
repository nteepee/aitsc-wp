<?php
/**
 * The front page template - White Theme Migration (Phase 5)
 *
 * @package AITSCProTheme
 */

get_header();
?>

<main id="primary" class="site-main">

    <!-- Hero Section - White Fullwidth Variant -->
    <?php
    aitsc_render_hero([
        'variant' => 'white-fullwidth',
        'title' => 'Custom Electronics & <span class="text-cyan">Safety</span> Engineering',
        'subtitle' => 'FROM CONCEPT TO DEPLOYMENT. AUTOMOTIVE GRADE.',
        'description' => 'Transform your fleet safety vision into reality with end-to-end electronics engineering, from PCB design to ISO 26262 functional safety compliance.',
        'cta_primary' => 'Explore Fleet Safe Pro',
        'cta_primary_link' => home_url('/solutions/fleet-safe-pro'),
        'cta_secondary' => 'Start Your Project',
        'cta_secondary_link' => home_url('/contact'),
        'height' => 'large'
    ]);
    ?>

    <!-- Trust Bar Component -->
    <?php
    aitsc_render_trust_bar([
        'text' => 'Trusted by leading transport safety organizations across Australia',
        'tag' => 'p'
    ]);
    ?>

    <!-- Engineering Services Section - White Feature Cards -->
    <section class="py-24 bg-white" id="solutions">
        <div class="aitsc-container">
            <div class="mb-12 text-center">
                <h2 class="text-4xl md:text-5xl font-light text-slate-900 mb-4">Full-Stack Engineering Services</h2>
                <p class="text-lg text-cyan-600 uppercase tracking-wider">From PCB Design to Functional Safety Compliance</p>
            </div>

            <div class="aitsc-grid aitsc-grid--4-col">

                <!-- 1. Passenger Monitoring Systems -->
                <div>
                    <?php
                    aitsc_render_card([
                        'variant' => 'white-feature',
                        'title' => 'Passenger Monitoring Systems',
                        'description' => 'Real-time seatbelt detection, compliance monitoring, and safety solutions for passenger transport.',
                        'link' => home_url('/solutions/passenger-monitoring-systems'),
                        'icon' => 'airline_seat_recline_normal',
                        'cta_text' => 'Explore Solutions',
                        'custom_class' => 'h-100'
                    ]);
                    ?>
                </div>

                <!-- 2. Custom PCB Design -->
                <div>
                    <?php
                    aitsc_render_card([
                        'variant' => 'white-feature',
                        'title' => 'Custom PCB Design',
                        'description' => 'End-to-end PCB design from schematic to production-ready layouts.',
                        'link' => home_url('/solutions/custom-pcb-design'),
                        'icon' => 'memory',
                        'cta_text' => 'Explore Solutions',
                        'custom_class' => 'h-100'
                    ]);
                    ?>
                </div>

                <!-- 3. Embedded Systems -->
                <div>
                    <?php
                    aitsc_render_card([
                        'variant' => 'white-feature',
                        'title' => 'Embedded Systems',
                        'description' => 'Firmware development for microcontrollers and system-on-chip solutions.',
                        'link' => home_url('/solutions/embedded-systems'),
                        'icon' => 'developer_board',
                        'cta_text' => 'Explore Solutions',
                        'custom_class' => 'h-100'
                    ]);
                    ?>
                </div>

                <!-- 4. Automotive Electronics -->
                <div>
                    <?php
                    aitsc_render_card([
                        'variant' => 'white-feature',
                        'title' => 'Automotive Electronics',
                        'description' => 'CAN bus systems, diagnostics, and ISO 26262 functional safety.',
                        'link' => home_url('/solutions/automotive-electronics'),
                        'icon' => 'directions_car',
                        'cta_text' => 'Explore Solutions',
                        'custom_class' => 'h-100'
                    ]);
                    ?>
                </div>

            </div>
        </div>
    </section>

    <!-- Why Choose Us Section - White Minimal Cards -->
    <section class="py-24 bg-slate-50" id="why-us">
        <div class="aitsc-container">
            <div class="mb-12 text-center">
                <h2 class="text-4xl md:text-5xl font-light text-slate-900 mb-4">Engineering Expertise Meets Real-World Deployment</h2>
                <p class="text-lg text-cyan-600 uppercase tracking-wider">Why Choose AITSC</p>
            </div>

            <div class="aitsc-grid aitsc-grid--3-col">
                <!-- Feature 1 -->
                <div>
                    <?php
                    aitsc_render_card([
                        'variant' => 'white-minimal',
                        'icon' => 'precision_manufacturing',
                        'title' => 'Custom Design Capability',
                        'description' => 'Every project starts with your unique requirements. We design, prototype, and deliver custom electronics solutions tailored to your operational needs.',
                        'custom_class' => 'h-100'
                    ]);
                    ?>
                </div>

                <!-- Feature 2 -->
                <div>
                    <?php
                    aitsc_render_card([
                        'variant' => 'white-minimal',
                        'icon' => 'verified_user',
                        'title' => 'Automotive-Grade Standards',
                        'description' => 'ISO 26262 functional safety compliance, CAN bus expertise, and automotive-grade component selection ensure your solution meets industry standards.',
                        'custom_class' => 'h-100'
                    ]);
                    ?>
                </div>

                <!-- Feature 3 -->
                <div>
                    <?php
                    aitsc_render_card([
                        'variant' => 'white-minimal',
                        'icon' => 'layers',
                        'title' => 'Full-Stack Integration',
                        'description' => 'From PCB layout to firmware development to sensor calibration - we handle every technical layer so you get a complete, tested, ready-to-deploy solution.',
                        'custom_class' => 'h-100'
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Insights Section - Blog Cards -->
    <section class="py-24 bg-white" id="insights">
        <div class="aitsc-container">
            <div class="mb-12 text-center">
                <h2 class="text-4xl md:text-5xl font-light text-slate-900 mb-4">Latest Perspectives</h2>
                <p class="text-lg text-cyan-600 uppercase tracking-wider">Insights from the forefront of transport tech</p>
            </div>

            <div class="aitsc-grid aitsc-grid--3-col">
                <?php
                $homepage_query = new WP_Query(array(
                    'post_type' => 'post',
                    'posts_per_page' => 3,
                    'ignore_sticky_posts' => 1
                ));

                if ($homepage_query->have_posts()):
                    while ($homepage_query->have_posts()):
                        $homepage_query->the_post();
                        ?>
                        <div>
                            <?php
                            aitsc_render_card([
                                'variant' => 'blog',
                                'title' => get_the_title(),
                                'description' => get_the_excerpt(),
                                'link' => get_permalink(),
                                'image' => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
                                'cta_text' => 'Read Article',
                                'meta' => [
                                    'date' => get_the_date(),
                                    'read_time' => '5 min read',
                                    'category' => wp_kses_post(get_the_category_list(', '))
                                ]
                            ]);
                            ?>
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>

            <div class="mt-8 text-center">
                <a href="<?php echo esc_url(home_url('/blog')); ?>"
                        class="inline-flex items-center gap-2 text-cyan-600 hover:text-cyan-700 font-semibold transition-colors"
                        aria-label="View all insights and blog articles about electronics engineering and automotive safety">
                        <span>View All Insights</span>
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
            </div>
        </div>
    </section>

    <!-- Final CTA Section -->
    <?php
    aitsc_render_cta([
        'variant' => 'fullwidth',
        'title' => 'Ready to Start Your Project?',
        'description' => 'Whether you need a custom electronics solution or want to deploy Fleet Safe Pro in your fleet, our engineering team is ready to help.',
        'button_text' => 'Get Started',
        'button_link' => home_url('/contact'),
        'button_secondary_text' => 'Learn More',
        'button_secondary_link' => home_url('/solutions')
    ]);
    ?>

</main>

<?php
get_footer();