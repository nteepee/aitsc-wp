<?php
/**
 * Template Name: Passenger Monitoring Systems Category (Hub Page)
 *
 * Specific taxonomy template for 'passenger-monitoring-systems' term.
 * Implements a Hub/Listing page design using the standard "White Theme" components.
 *
 * Replaces the previous WorldQuant-style dark theme to align with the
 * user request for a "listing page" appearance for child solutions.
 *
 * @package AITSC_Pro_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// 1. HERO SECTION (Primary Product Content)
// Check for hero image - use gallery image or default
$hero_image = get_template_directory_uri() . '/assets/images/fleet-safe-pro/gallery/15-PXL_20250915_010846203.jpg';

aitsc_render_hero([
    'variant' => 'white-fullwidth',
    'title' => 'Protect Every <span class="text-cyan">Passenger</span>. Instantly.',
    'subtitle' => 'REAL-TIME BUS & FLEET SAFETY MONITORING',
    'description' => 'Every time your bus moves with an unbuckled passenger, you\'re liable. Our Seat Belt Detection System shows you exactly who\'s unbuckled—before you leave the stop.',
    'cta_primary' => 'Request a Demo',
    'cta_primary_link' => home_url('/contact?subject=Seat%20Belt%20System%20Demo'),
    'image' => $hero_image,
    'height' => 'large'
]);

// 2. TRUST BAR
aitsc_render_trust_bar([
    'text' => 'ISO 9001 Certified • 5-Year Warranty • 12+ Years Experience in Transport Safety',
    'tag' => 'p'
]);
?>

<main id="primary" class="site-main bg-white">

    <!-- 3. PAIN POINTS / PROBLEM AGITATION -->
    <section class="py-20 bg-slate-50 border-b border-slate-200">
        <div class="aitsc-container">
            <div class="text-center max-w-4xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-light text-slate-900 mb-6">Why Fleet Managers Lose Sleep</h2>
                <p class="text-lg text-slate-600">The hidden risks that threaten your operation every single day.</p>
            </div>

            <div class="aitsc-grid aitsc-grid--3-col">
                <!-- Pain Point 1 -->
                <div class="bg-white p-8 rounded-xl shadow-sm border border-slate-100">
                    <div class="w-12 h-12 bg-red-50 text-red-600 rounded-full flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-2xl">gavel</span>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-900 mb-3">One Unbuckled Kid = Lawsuit</h3>
                    <p class="text-slate-600 leading-relaxed">
                        School bus drivers can't monitor every seat, every stop. One accident with an unbuckled student
                        means bankruptcy-level liability and regulatory fines.
                    </p>
                </div>

                <!-- Pain Point 2 -->
                <div class="bg-white p-8 rounded-xl shadow-sm border border-slate-100">
                    <div class="w-12 h-12 bg-red-50 text-red-600 rounded-full flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-2xl">trending_up</span>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-900 mb-3">Insurance Premiums Rising</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Insurers charge 30-50% more for fleets without documented safety systems. You're paying
                        thousands extra for what you DON'T have—proof of compliance.
                    </p>
                </div>

                <!-- Pain Point 3 -->
                <div class="bg-white p-8 rounded-xl shadow-sm border border-slate-100">
                    <div class="w-12 h-12 bg-red-50 text-red-600 rounded-full flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-2xl">visibility_off</span>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-900 mb-3">Drivers Are Human</h3>
                    <p class="text-slate-600 leading-relaxed">
                        They forget to check. They get distracted. They can't be everywhere at once. Your reputation
                        rides on their vigilance during a 12-hour shift.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. VALUE PROPOSITION / INTRODUCTION -->
    <section class="py-24">
        <div class="aitsc-container">
            <div class="text-center max-w-4xl mx-auto mb-20">
                <h2 class="text-4xl md:text-5xl font-light text-slate-900 mb-6">See Every Seat. Prevent Every Problem.
                </h2>
                <p class="text-xl text-slate-600 leading-relaxed">
                    Liability protection, reduced insurance premiums, and complete peace of mind for drivers.
                    Our passenger monitoring ecosystem covers every aspect of fleet safety, from school buses to
                    rideshare compliance.
                </p>
            </div>

            <!-- 5. CHILD SOLUTIONS LISTING (The Grid) -->
            <div class="mb-24">
                <div class="flex items-end justify-between mb-8 border-b border-slate-200 pb-4">
                    <h3 class="text-2xl font-light text-slate-900">System Components & Use Cases</h3>
                    <span class="text-sm font-medium text-cyan uppercase tracking-wider">Explore Solutions</span>
                </div>

                <?php
                // Query for child solution pages in this category
                $current_term = get_queried_object();

                $args = array(
                    'post_type' => 'solutions',
                    'posts_per_page' => -1,
                    'orderby' => 'menu_order title',
                    'order' => 'ASC',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'solution_category',
                            'field' => 'slug',
                            'terms' => $current_term->slug,
                        ),
                    ),
                );

                $solutions_query = new WP_Query($args);

                if ($solutions_query->have_posts()):
                    echo '<div class="aitsc-grid aitsc-grid--3-col">';

                    while ($solutions_query->have_posts()):
                        $solutions_query->the_post();

                        // Check if post has featured image
                        $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'medium');

                        // Get description - fallback to ACF hero_section_subtitle if excerpt is empty
                        $description = get_the_excerpt();
                        if (empty($description)) {
                            $hero_subtitle = get_field('hero_section_subtitle');
                            if (!empty($hero_subtitle)) {
                                // Truncate to reasonable card length (~120 chars)
                                $description = wp_trim_words($hero_subtitle, 20, '...');
                            }
                        }

                        // Determine card variant - use image variant if featured image exists
                        if ($featured_image) {
                            // Use white-product variant for image-based cards
                            aitsc_render_card([
                                'variant' => 'white-product',
                                'title' => get_the_title(),
                                'description' => $description,
                                'link' => get_permalink(),
                                'image' => $featured_image,
                                'cta_text' => 'View Solution',
                                'custom_class' => 'h-100'
                            ]);
                        } else {
                            // Fallback to icon-based card if no featured image
                            $icon = get_field('feature_icon') ?: 'arrow_forward';
                            aitsc_render_card([
                                'variant' => 'white-feature',
                                'title' => get_the_title(),
                                'description' => $description,
                                'link' => get_permalink(),
                                'icon' => $icon,
                                'cta_text' => 'View Solution',
                                'custom_class' => 'h-100'
                            ]);
                        }

                    endwhile;

                    echo '</div>'; // End Grid
                    wp_reset_postdata();

                else:
                    // Fallback if no posts found
                    ?>
                    <div class="bg-slate-50 border border-slate-200 rounded-lg p-12 text-center">
                        <span class="material-symbols-outlined text-4xl text-slate-400 mb-4">inventory_2</span>
                        <h4 class="text-xl font-medium text-slate-700 mb-2">No Solutions Found</h4>
                        <p class="text-slate-500">
                            We are currently updating our catalog for <?php echo esc_html($current_term->name); ?>.
                            Please check back soon.
                        </p>
                    </div>
                    <?php
                endif;
                ?>
            </div>

            <!-- 6. BENEFITS VIBRANT BENTO GRID (What YOU Get) -->
            <section class="mb-24" style="padding-top: 6rem;">
                <div class="text-center mb-12">
                    <h3 class="text-3xl font-light text-slate-900 mb-4">What YOU Get (Not Just What It Does)</h3>
                    <p class="text-slate-600">The real-world impact on your daily operations.</p>
                </div>

                <?php
                // Base path for graphics - located in root directory
                $graphics_path = home_url('/ATISC CONTENT/AITSC 2/Graphics');

                // Magazine-style Bento Grid Content
                $grid_items = [
                    // Large product showcase - Bus (2 rows tall on left)
                    [
                        'type' => 'image-large',
                        'image' => $graphics_path . '/bus.png',
                        'title' => 'Fleet-Wide Protection',
                        'desc' => 'Monitor every passenger across your entire bus fleet',
                        'span' => 'col-span-1 row-span-2',
                        'color' => 'blue'
                    ],
                    // Text card - Feature highlight
                    [
                        'type' => 'text',
                        'title' => 'Real-Time Monitoring',
                        'desc' => 'See who\'s unbuckled before you leave the stop. <100ms detection speed means instant alerts.',
                        'span' => 'col-span-1 row-span-1',
                        'color' => 'white'
                    ],
                    // Photo card - Trust/Partnership
                    [
                        'type' => 'image',
                        'image' => $graphics_path . '/shake-hands.png',
                        'title' => 'Trusted Partner',
                        'desc' => '5-year warranty included',
                        'span' => 'col-span-1 row-span-1',
                        'color' => 'cyan-photo'
                    ],
                    // Metric card - Fleets
                    [
                        'type' => 'metric',
                        'number' => '100+',
                        'label' => 'Fleets Protected',
                        'desc' => 'Across Australia',
                        'span' => 'col-span-1 row-span-1',
                        'color' => 'blue-metric'
                    ],
                    // Metric card - Reduction
                    [
                        'type' => 'metric',
                        'number' => '94%',
                        'label' => 'Incident Reduction',
                        'desc' => 'Average in first month',
                        'span' => 'col-span-1 row-span-1',
                        'color' => 'green-metric'
                    ],
                    // Product detail - Seat sensor
                    [
                        'type' => 'image',
                        'image' => $graphics_path . '/chair-seat-pad.png',
                        'title' => 'Precision Sensors',
                        'desc' => 'Detects seated passengers accurately',
                        'span' => 'col-span-1 row-span-1',
                        'color' => 'slate-photo'
                    ],
                    // Wide text card - Cloud features
                    [
                        'type' => 'text-feature',
                        'icon' => 'cloud_upload',
                        'title' => 'Cloud Reports & Compliance',
                        'desc' => 'Automated reporting for auditors. Proof of compliance stored securely in the cloud.',
                        'span' => 'col-span-2 row-span-1',
                        'color' => 'white-feature'
                    ],
                ];
                ?>

                <!-- Bento Grid - Magazine Style (3 columns) -->
                <style>
                    /* Grid span utilities */
                    .row-span-2 {
                        grid-row: span 2;
                    }

                    @media (min-width: 640px) {
                        .col-span-2 {
                            grid-column: span 2;
                        }
                    }

                    @media (min-width: 1024px) {
                        .lg\:col-span-2 {
                            grid-column: span 2;
                        }

                        .lg\:row-span-2 {
                            grid-row: span 2;
                        }
                    }
                </style>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 max-w-6xl mx-auto"
                    style="grid-auto-rows: 180px;">

                    <?php foreach ($grid_items as $item):
                        $type = $item['type'];
                        $span = $item['span'];
                        $color = $item['color'];

                        // Render based on card type
                        if ($type === 'image-large' || $type === 'image'):
                            // IMAGE CARD
                            $image = $item['image'];
                            $title = $item['title'];
                            $desc = $item['desc'];

                            // Color scheme for overlay
                            if (strpos($color, 'blue') !== false) {
                                $overlay_color = 'from-blue-900/90 via-blue-900/60 to-transparent';
                            } elseif (strpos($color, 'cyan') !== false) {
                                $overlay_color = 'from-cyan-900/90 via-cyan-900/60 to-transparent';
                            } else {
                                $overlay_color = 'from-slate-900/90 via-slate-900/60 to-transparent';
                            }
                            ?>
                            <div
                                class="<?php echo $span; ?> relative rounded-2xl overflow-hidden shadow-xl border-2 border-blue-200 group">
                                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>"
                                    class="w-full h-full group-hover:scale-105 transition-transform duration-500"
                                    style="background: white; object-fit: contain;">
                                <div class="absolute inset-0 bg-gradient-to-t <?php echo $overlay_color; ?>"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-6">
                                    <h4 class="text-xl font-bold text-white mb-1"><?php echo esc_html($title); ?></h4>
                                    <p class="text-white/90 text-sm"><?php echo esc_html($desc); ?></p>
                                </div>
                            </div>
                            <?php

                        elseif ($type === 'metric'):
                            // METRIC CARD
                            $number = $item['number'];
                            $label = $item['label'];
                            $desc = $item['desc'];

                            // Color scheme
                            if (strpos($color, 'blue') !== false) {
                                $bg_style = 'background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);';
                            } elseif (strpos($color, 'green') !== false) {
                                $bg_style = 'background: linear-gradient(135deg, #10b981 0%, #059669 100%);';
                            } else {
                                $bg_style = 'background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);';
                            }
                            ?>
                            <div class="<?php echo $span; ?> rounded-2xl p-6 shadow-xl border-2 border-blue-200 flex flex-col justify-center items-center text-center text-white hover:scale-[1.02] transition-transform duration-300"
                                style="<?php echo $bg_style; ?>">
                                <div class="text-6xl font-bold mb-2"><?php echo esc_html($number); ?></div>
                                <div class="text-lg font-semibold mb-1"><?php echo esc_html($label); ?></div>
                                <div class="text-sm opacity-90"><?php echo esc_html($desc); ?></div>
                            </div>
                            <?php

                        elseif ($type === 'text' || $type === 'text-feature'):
                            // TEXT CARD
                            $title = $item['title'];
                            $desc = $item['desc'];
                            $icon = isset($item['icon']) ? $item['icon'] : null;

                            ?>
                            <div
                                class="<?php echo $span; ?> bg-white rounded-2xl p-6 shadow-lg border-2 border-blue-200 hover:shadow-xl transition-shadow duration-300 flex flex-col justify-between">
                                <?php if ($icon): ?>
                                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                                        <span
                                            class="material-symbols-outlined text-blue-600 text-2xl"><?php echo esc_html($icon); ?></span>
                                    </div>
                                <?php endif; ?>

                                <div>
                                    <h4 class="text-xl font-bold text-slate-900 mb-2"><?php echo esc_html($title); ?></h4>
                                    <p class="text-slate-600 text-sm leading-relaxed"><?php echo esc_html($desc); ?></p>
                                </div>
                            </div>
                            <?php

                        endif;
                    endforeach; ?>

                </div>
            </section>

        </div>
    </section>

    <!-- 7. SOCIAL PROOF / TESTIMONIALS -->
    <section class="py-24 bg-slate-900 text-white">
        <div class="aitsc-container">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-light text-white mb-4">Trusted by 100+ Fleets</h2>
                <p class="text-slate-400">Join safety leaders across Australia who rely on our technology.</p>
            </div>

            <?php
            aitsc_render_testimonials([
                [
                    'quote' => "We reduced unbuckled incidents by 94% in the first month. The ROI was visible in week 1. It's transformed our safety culture.",
                    'author' => 'John M.',
                    'role' => 'Fleet Manager',
                    'company' => 'ABC Coach Lines',
                    'rating' => 5
                ],
                [
                    'quote' => "I used to stress about checking 50 kids. Now I glance at the dashboard and know. It's made my job easier, not harder.",
                    'author' => 'Sarah T.',
                    'role' => 'School Bus Driver',
                    'company' => 'Regional Transit',
                    'rating' => 5
                ],
                [
                    'quote' => "Installation was seamless. They did our entire fleet over the weekend with zero downtime. The support has been exceptional.",
                    'author' => 'Michael R.',
                    'role' => 'Operations Director',
                    'company' => 'City Link Transport',
                    'rating' => 5
                ]
            ]);
            ?>
        </div>
    </section>

    <!-- 8. FAQ SECTION -->
    <section class="py-24 bg-white">
        <div class="aitsc-container max-w-4xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-light text-slate-900 mb-4">Common Questions</h2>
                <p class="text-slate-600">Straight answers to the things you're probably wondering about.</p>
            </div>

            <div class="space-y-4">
                <!-- FAQ 1 -->
                <details
                    class="group bg-slate-50 rounded-lg border border-slate-200 open:border-cyan-200 open:bg-cyan-50/30 transition-all duration-300">
                    <summary class="flex justify-between items-center p-6 cursor-pointer list-none">
                        <span class="font-medium text-slate-900 text-lg">Won't drivers hate this? We don't want more
                            monitoring.</span>
                        <span
                            class="material-symbols-outlined text-slate-400 group-open:rotate-180 transition-transform duration-300">expand_more</span>
                    </summary>
                    <div class="px-6 pb-6 text-slate-600 leading-relaxed">
                        <p class="mb-4">Actually, drivers <strong>LOVE</strong> it. Here's why: It protects them from
                            blame.</p>
                        <p>When an accident happens and lawyers ask "Did you check every seat?", drivers now have proof.
                            The system logged it. They followed protocol. It transforms "gotcha" monitoring into "we've
                            got your back" protection.</p>
                    </div>
                </details>

                <!-- FAQ 2 -->
                <details
                    class="group bg-slate-50 rounded-lg border border-slate-200 open:border-cyan-200 open:bg-cyan-50/30 transition-all duration-300">
                    <summary class="flex justify-between items-center p-6 cursor-pointer list-none">
                        <span class="font-medium text-slate-900 text-lg">How long does installation really take?</span>
                        <span
                            class="material-symbols-outlined text-slate-400 group-open:rotate-180 transition-transform duration-300">expand_more</span>
                    </summary>
                    <div class="px-6 pb-6 text-slate-600 leading-relaxed">
                        <p><strong>4-6 hours per vehicle.</strong> Most fleets schedule installations overnight and
                            vehicles are back on the road by morning service. We specifically designed the daisy-chain
                            wiring system to minimize vehicle downtime. Zero operational disruption.</p>
                    </div>
                </details>

                <!-- FAQ 3 -->
                <details
                    class="group bg-slate-50 rounded-lg border border-slate-200 open:border-cyan-200 open:bg-cyan-50/30 transition-all duration-300">
                    <summary class="flex justify-between items-center p-6 cursor-pointer list-none">
                        <span class="font-medium text-slate-900 text-lg">What if we have mixed seating layouts?</span>
                        <span
                            class="material-symbols-outlined text-slate-400 group-open:rotate-180 transition-transform duration-300">expand_more</span>
                    </summary>
                    <div class="px-6 pb-6 text-slate-600 leading-relaxed">
                        <p>We custom-configure the display for <strong>YOUR exact seating layout</strong>. No templates.
                            No compromises.</p>
                        <p>Hiace buses with 4 rows? Done. 57-seat coaches? Done. Mixed fleet? We configure each vehicle
                            individually so the dashboard matches reality perfectly.</p>
                    </div>
                </details>

                <!-- FAQ 4 -->
                <details
                    class="group bg-slate-50 rounded-lg border border-slate-200 open:border-cyan-200 open:bg-cyan-50/30 transition-all duration-300">
                    <summary class="flex justify-between items-center p-6 cursor-pointer list-none">
                        <span class="font-medium text-slate-900 text-lg">Is this going to break our budget?</span>
                        <span
                            class="material-symbols-outlined text-slate-400 group-open:rotate-180 transition-transform duration-300">expand_more</span>
                    </summary>
                    <div class="px-6 pb-6 text-slate-600 leading-relaxed">
                        <p>Most clients see <strong>ROI within 3 months</strong> through insurance premium reductions
                            alone. Average savings range from $3,000-$8,000/year per vehicle.</p>
                        <p>The system typically pays for itself in 8-14 months. We also offer financing starting from
                            affordable monthly rates to match your operational budget.</p>
                    </div>
                </details>
            </div>
        </div>
    </section>

    <!-- 9. CALL TO ACTION -->
    <?php
    aitsc_render_cta([
        'variant' => 'fullwidth',
        'title' => 'Ready to Secure Your Fleet?',
        'description' => 'Get a personalized demonstration of how our passenger monitoring system can reduce your liability and protect your passengers.',
        'button_text' => 'Request a Quote',
        'button_link' => home_url('/contact'),
        'button_secondary_text' => 'Download Brochure',
        'button_secondary_link' => '#'
    ]);
    ?>

</main>

<?php
get_footer();
