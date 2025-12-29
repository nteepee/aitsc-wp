<?php
/**
 * The front page template - WorldQuant Style Redesign
 *
 * @package AITSCProTheme
 */

get_header();
?>

<div class="grid-lines"></div>

<main id="primary" class="site-main">

    <!-- SLIDE 1: INTRO HERO -->
    <section class="scroll-section hero-slide" id="hero">
        <div class="container-fluid h-100 p-0">
            <div class="row h-100 align-items-center m-0">
                <div class="col-12 p-0 relative">

                    <!-- Main Centered Content -->
                    <div class="hero-center-content text-center">
                        <h1 class="wq-hero-title wq-hero-title--display animate-title">
                            CUSTOM ELECTRONICS<br>& <span style="color: #3b82f6;">SAFETY</span> ENGINEERING
                        </h1>
                        <p class="wq-subtitle animate-fade-in delay-1">
                            From Concept to Deployment. Automotive Grade.
                        </p>

                        <!-- Hero CTAs -->
                        <div class="hero-cta-group animate-fade-in delay-2">
                            <a href="<?php echo esc_url(home_url('/solutions/fleet-safe-pro')); ?>"
                                class="hero-cta-primary"
                                aria-label="Explore Fleet Safe Pro solution for automotive electronics and safety compliance">
                                <span>Explore Fleet Safe Pro</span>
                                <span class="material-symbols-outlined">arrow_forward</span>
                            </a>
                            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="hero-cta-secondary"
                                aria-label="Start your custom electronics and safety engineering project with our engineering team">
                                <span>Start Your Project</span>
                                <span class="material-symbols-outlined">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    <!-- Bottom Ticker -->
                    <div class="data-ticker-wrap">
                        <div class="data-ticker">
                            <span class="ticker-item">ISO 26262 COMPLIANT: <strong class="text-green">✓</strong></span>
                            <span class="ticker-item">DEPLOYED WITH BUS4X4: <strong
                                    class="text-blue">ACTIVE</strong></span>
                            <span class="ticker-item">ENGINEERING SERVICES: <strong class="text-green">7</strong></span>
                            <span class="ticker-item">PCB TO FIRMWARE: <strong
                                    class="text-blue">FULL-STACK</strong></span>
                            <span class="ticker-item">CUSTOM SOLUTIONS: <strong class="text-green">100%</strong></span>
                            <!-- Duplicate for loop -->
                            <span class="ticker-item">ISO 26262 COMPLIANT: <strong class="text-green">✓</strong></span>
                            <span class="ticker-item">DEPLOYED WITH BUS4X4: <strong
                                    class="text-blue">ACTIVE</strong></span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- SLIDE 2: ENGINEERING SERVICES -->
    <section class="scroll-section solutions-slide" id="solutions">
        <div class="container h-100 d-flex flex-column justify-content-center">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="wq-section-title">Full-Stack Engineering Services</h2>
                    <p class="wq-subtitle">From PCB Design to Functional Safety Compliance</p>
                </div>
            </div>

            <div class="row justify-content-center solutions-grid">

                <!-- 1. Passenger Monitoring Systems -->
                <div class="col-md-3 col-sm-6 mb-4">
                    <?php
                    aitsc_render_card([
                        'variant' => 'solution',
                        'title' => 'Passenger<br>Monitoring Systems',
                        'description' => 'Real-time seatbelt detection, compliance monitoring, and safety solutions for passenger transport.',
                        'link' => home_url('/solutions/passenger-monitoring-systems'),
                        'icon' => 'airline_seat_recline_normal',
                        'cta_text' => 'Explore',
                        'custom_class' => 'h-100 text-purple'
                    ]);
                    ?>
                </div>

                <!-- 2. Custom PCB Design -->
                <div class="col-md-3 col-sm-6 mb-4">
                    <?php
                    aitsc_render_card([
                        'variant' => 'solution',
                        'title' => 'Custom PCB<br>Design',
                        'description' => 'End-to-end PCB design from schematic to production-ready layouts.',
                        'link' => home_url('/solutions/custom-pcb-design'),
                        'icon' => 'memory',
                        'cta_text' => 'Explore',
                        'custom_class' => 'h-100 text-cyan'
                    ]);
                    ?>
                </div>

                <!-- 3. Embedded Systems -->
                <div class="col-md-3 col-sm-6 mb-4">
                    <?php
                    aitsc_render_card([
                        'variant' => 'solution',
                        'title' => 'Embedded<br>Systems',
                        'description' => 'Firmware development for microcontrollers and system-on-chip solutions.',
                        'link' => home_url('/solutions/embedded-systems'),
                        'icon' => 'developer_board',
                        'cta_text' => 'Explore',
                        'custom_class' => 'h-100 text-green'
                    ]);
                    ?>
                </div>

                <!-- 4. Automotive Electronics -->
                <div class="col-md-3 col-sm-6 mb-4">
                    <?php
                    aitsc_render_card([
                        'variant' => 'solution',
                        'title' => 'Automotive<br>Electronics',
                        'description' => 'CAN bus systems, diagnostics, and ISO 26262 functional safety.',
                        'link' => home_url('/solutions/automotive-electronics'),
                        'icon' => 'directions_car',
                        'cta_text' => 'Explore',
                        'custom_class' => 'h-100 text-cyan'
                    ]);
                    ?>
                </div>

            </div>
        </div>
    </section>

    <!-- SLIDE 3: WHY CHOOSE US (The Science of Safety) -->
    <section class="scroll-section why-us-slide" id="why-us">
        <div class="container h-100 d-flex flex-column justify-content-center">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="wq-section-title">Engineering Expertise Meets Real-World Deployment</h2>
                    <p class="wq-subtitle">Why Choose AITSC</p>
                </div>
            </div>

            <div class="row">
                <!-- Feature 1 -->
                <div class="col-md-4 mb-4">
                    <div class="glass-panel feature-card p-5 h-100">
                        <span
                            class="material-symbols-outlined icon-display mb-4 text-blue">precision_manufacturing</span>
                        <h3 class="feature-title mb-3">Custom Design Capability</h3>
                        <p class="wq-body-text mb-0">Every project starts with your unique requirements. We design,
                            prototype, and deliver custom electronics solutions tailored to your operational needs.</p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="col-md-4 mb-4">
                    <div class="glass-panel feature-card p-5 h-100">
                        <span class="material-symbols-outlined icon-display mb-4 text-green">verified_user</span>
                        <h3 class="feature-title mb-3">Automotive-Grade Standards</h3>
                        <p class="wq-body-text mb-0">ISO 26262 functional safety compliance, CAN bus expertise, and
                            automotive-grade component selection ensure your solution meets industry standards.</p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="col-md-4 mb-4">
                    <div class="glass-panel feature-card p-5 h-100">
                        <span class="material-symbols-outlined icon-display mb-4 text-orange">layers</span>
                        <h3 class="feature-title mb-3">Full-Stack Integration</h3>
                        <p class="wq-body-text mb-0">From PCB layout to firmware development to sensor calibration - we
                            handle every technical layer so you get a complete, tested, ready-to-deploy solution.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SLIDE 4: LATEST INSIGHTS (Blog Feed) -->
    <section class="scroll-section insights-slide" id="insights">
        <div class="container h-100 d-flex flex-column justify-content-center">
            <div class="row mb-5 align-items-end">
                <div class="col-12">
                    <h2 class="wq-section-title">Latest Perspectives</h2>
                    <p class="wq-subtitle">Insights from the forefront of transport tech.</p>
                </div>
            </div>

            <div class="row">
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
                        <div class="col-md-4 mb-4">
                            <?php get_template_part('template-parts/content'); // Reusing the glass card template ?>
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>

            <div class="row mt-4">
                <div class="col-12 text-center">
                    <a href="<?php echo esc_url(home_url('/blog')); ?>" class="wq-read-more"
                        aria-label="View all insights and blog articles about electronics engineering and automotive safety">
                        <span>View All Insights</span>
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- SLIDE 5: FINAL CTA -->
    <section class="scroll-section cta-slide" id="cta">
        <div class="container h-100 d-flex flex-column justify-content-center text-center">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="wq-huge-title mb-4" style="font-size: clamp(3rem, 6vw, 6rem);">Ready to Start Your
                        Project?
                    </h2>
                    <p class="wq-body-text mb-5" style="font-size: 1.5rem;">Whether you need a custom electronics
                        solution or want to deploy Fleet Safe Pro in your fleet, our engineering team is ready to help.
                    </p>
                    <a href="<?php echo esc_url(home_url('/contact')); ?>"
                        class="submit-btn d-inline-block w-auto px-5 py-3" style="font-size: 1.25rem;"
                        aria-label="Get started with a consultation for custom electronics solutions and engineering services">
                        Get Started
                    </a>
                </div>
            </div>
        </div>
    </section>

</main>

<style>
    /* Homepage Specific Styles */

    /* Hero Slide Base */
    .hero-slide {
        min-height: 100vh;
        height: auto;
        position: relative;
        display: flex;
        align-items: center;
        overflow: visible;
        width: 100%;
    }

    .hero-slide .container-fluid {
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .hero-slide .row {
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
    }

    .hero-slide .col-12 {
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    /* Hero Center Content */
    .hero-center-content {
        margin: 0 auto;
        padding: 0 1rem;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    /* Hero Title - Massive - DEPRECATED: Use .wq-hero-title--display in style.css */

    .wq-subtitle {
        font-family: 'Inter', sans-serif;
        font-size: clamp(0.7rem, 1.5vw, 1.25rem);
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: var(--aitsc-primary);
        margin-bottom: 2.5rem;
    }

    /* Hero CTA Buttons */
    .hero-cta-group {
        display: flex;
        gap: 1.5rem;
        justify-content: center;
        align-items: center;
        margin-bottom: 8rem;
        flex-wrap: wrap;
    }

    .hero-cta-primary,
    .hero-cta-secondary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 2rem;
        font-family: 'Inter', sans-serif;
        font-size: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-radius: 8px;
        transition: all 0.3s ease;
        text-decoration: none;
        cursor: pointer;
    }

    .hero-cta-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #fff;
        border: 2px solid transparent;
        box-shadow: 0 4px 20px rgba(59, 130, 246, 0.4);
    }

    .hero-cta-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(59, 130, 246, 0.6);
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #fff;
    }

    .hero-cta-secondary {
        background: transparent;
        color: #10b981;
        border: 2px solid #10b981;
        box-shadow: 0 4px 20px rgba(16, 185, 129, 0.2);
    }

    .hero-cta-secondary:hover {
        background: rgba(16, 185, 129, 0.1);
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(16, 185, 129, 0.4);
        border-color: #34d399;
        color: #34d399;
    }

    .hero-cta-primary .material-symbols-outlined,
    .hero-cta-secondary .material-symbols-outlined {
        font-size: 1.25rem;
        transition: transform 0.3s ease;
    }

    .hero-cta-primary:hover .material-symbols-outlined,
    .hero-cta-secondary:hover .material-symbols-outlined {
        transform: translateX(4px);
    }

    /* Animation Delays */
    .delay-1 {
        animation-delay: 0.2s;
    }

    .delay-2 {
        animation-delay: 0.4s;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.8s ease-out forwards;
        opacity: 0;
    }

    /* Ticker */
    .data-ticker-wrap {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        overflow: hidden;
        background: rgba(0, 0, 0, 0.5);
        border-top: 1px solid var(--aitsc-grid-line);
        padding: 0.75rem 0;
        backdrop-filter: blur(5px);
    }

    .data-ticker {
        display: flex;
        white-space: nowrap;
        animation: ticker 35s linear infinite;
        will-change: transform;
        /* Optimized for performance */
    }

    .ticker-item {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.8rem;
        color: #fff;
        margin-right: 3rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .text-green {
        color: var(--aitsc-accent);
    }

    .text-blue {
        color: var(--aitsc-secondary);
    }

    @keyframes ticker {
        0% {
            transform: translate3d(0, 0, 0);
        }

        100% {
            transform: translate3d(-50%, 0, 0);
        }
    }

    /* Phase 5: Accessibility - Respect user motion preferences */
    @media (prefers-reduced-motion: reduce) {
        .data-ticker {
            animation: none;
        }

        .data-ticker-wrap {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    }

    /* Metrics */
    .metric-block {
        border-left: 1px solid var(--aitsc-primary);
        padding-left: 1.5rem;
        margin-bottom: 2rem;
    }

    .metric-value {
        display: block;
        font-size: clamp(3rem, 5vw, 5rem);
        font-weight: 300;
        line-height: 1;
        margin: 0.5rem 0;
        color: #fff;
    }

    .metric-label {
        font-size: 0.75rem;
        letter-spacing: 0.15em;
        color: #888;
        text-transform: uppercase;
    }

    .metric-bar {
        width: 100%;
        height: 1px;
        background: #333;
        margin-top: 1rem;
        position: relative;
    }

    .metric-bar .fill {
        height: 100%;
        background: var(--aitsc-primary);
        box-shadow: 0 0 8px var(--aitsc-primary);
        position: absolute;
        top: 0;
        left: 0;
    }

    /* Solutions */
    .glass-panel {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 4px;
    }

    .feature-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .feature-list li {
        font-size: 1.25rem;
        font-weight: 300;
        color: #dfdfdf;
        padding: 1rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .feature-list li:last-child {
        border-bottom: none;
    }

    .feature-list .icon {
        font-size: 1.5rem;
        color: var(--aitsc-primary);
    }

    .wq-section-title {
        font-size: clamp(2rem, 3vw, 3.5rem);
        font-weight: 300;
        margin-bottom: 1.5rem;
    }

    /* Homepage Content Expansion Styles */
    .icon-display {
        font-size: 4rem;
        display: block;
    }

    .feature-title {
        font-family: var(--aitsc-font-heading);
        font-size: 1.75rem;
        color: #fff;
        font-weight: 300;
        letter-spacing: -0.02em;
    }

    .wq-body-text {
        font-size: 1.1rem;
        color: #aaa;
        line-height: 1.7;
        margin-bottom: 2rem;
    }

    /* Logo Strip */
    .logo-strip {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 2rem;
        text-align: center;
    }

    .logo-item {
        font-family: 'JetBrains Mono', monospace;
        /* Tech feel */
        font-size: 1.5rem;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease;
        cursor: default;
        letter-spacing: -0.05em;
    }

    .logo-item:hover {
        color: #fff;
        text-shadow: 0 0 15px var(--aitsc-primary);
    }

    .text-orange {
        color: var(--wq-orange);
    }

    /* Responsive Styles */
    @media (max-width: 61.9375rem) {
        .hero-center-content {
            padding-bottom: 8rem !important;
        }

        .wq-huge-title {
            font-size: clamp(2.5rem, 8vw, 6rem);
            line-height: 1.15;
        }

        .hero-cta-group {
            margin-bottom: 0;
        }
    }

    @media (max-width: 47.9375rem) {
        .hero-center-content {
            padding-bottom: 9rem !important;
        }

        .wq-huge-title {
            font-size: clamp(2rem, 8vw, 4rem);
            line-height: 1.2;
            letter-spacing: -0.02em;
            margin-bottom: 1.25rem;
        }

        .wq-subtitle {
            font-size: clamp(0.65rem, 2vw, 0.9rem);
            letter-spacing: 0.15em;
            margin-bottom: 1.25rem;
        }

        .hero-cta-group {
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 0;
        }

        .hero-cta-primary,
        .hero-cta-secondary {
            width: 100%;
            max-width: 320px;
            justify-content: center;
            padding: 1rem 1.5rem;
            font-size: 0.875rem;
        }

        .data-ticker-wrap {
            bottom: 0;
            padding: 0.6rem 0;
        }

        .ticker-item {
            font-size: 0.65rem;
            margin-right: 2rem;
        }

        /* Services Grid */
        .solutions-grid {
            /* Bootstrap flex row - use flex-basis for 2 columns */
        }

        .solutions-grid>div {
            flex: 0 0 calc(50% - 1rem) !important;
            max-width: calc(50% - 1rem) !important;
        }

        .solution-card {
            padding: 1.5rem !important;
        }

        .icon-large {
            font-size: 2.5rem !important;
        }

        .card-title {
            font-size: 1rem !important;
        }

        .card-desc {
            font-size: 0.85rem !important;
        }

        /* Fix scroll-section overflow on mobile */
        .scroll-section {
            height: auto !important;
            min-height: auto !important;
            padding-top: 2rem !important;
            padding-bottom: 2rem !important;
        }
    }

    @media (max-width: 35.9375rem) {
        .hero-slide {
            min-height: 100vh !important;
            height: auto !important;
            padding: 3rem 0 3rem 0 !important;
            overflow: visible !important;
            position: relative !important;
        }

        .hero-center-content {
            padding: 1rem 1rem 10rem 1rem !important;
            margin: 0 auto !important;
            max-width: 100% !important;
            width: 100% !important;
            box-sizing: border-box !important;
            overflow: visible !important;
            word-wrap: break-word !important;
        }

        .wq-huge-title {
            font-size: clamp(1.5rem, 8vw, 2.5rem);
            line-height: 1.2;
            letter-spacing: -0.01em;
            margin-bottom: 0.75rem;
        }

        .wq-subtitle {
            font-size: 0.65rem;
            letter-spacing: 0.08em;
            margin-bottom: 1rem;
        }

        .hero-cta-group {
            gap: 0.5rem;
            margin-bottom: 0;
            flex-direction: column;
        }

        .hero-cta-primary,
        .hero-cta-secondary {
            width: 100% !important;
            max-width: 100% !important;
            padding: 0.75rem 0.75rem !important;
            font-size: 0.7rem;
            letter-spacing: 0.02em;
            white-space: normal !important;
            overflow: visible !important;
        }

        .data-ticker-wrap {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 0.5rem 0;
        }

        .ticker-item {
            font-size: 0.55rem;
            margin-right: 1.25rem;
        }

        /* Services Grid - Single Column */
        .solutions-grid>div.col-sm-6,
        .solutions-grid>div {
            flex: 0 0 100% !important;
            max-width: 100% !important;
            width: 100% !important;
        }

        .wq-section-title {
            font-size: clamp(1.5rem, 5vw, 2.5rem) !important;
        }

        .wq-body-text {
            font-size: 0.95rem !important;
        }

        /* Fix scroll-section overflow on mobile */
        .scroll-section {
            height: auto !important;
            min-height: auto !important;
            padding-top: 2rem !important;
            padding-bottom: 2rem !important;
        }
    }

    @media (max-width: 23.4375rem) {
        .wq-huge-title {
            font-size: 1.5rem;
            line-height: 1.3;
        }

        .wq-subtitle {
            font-size: 0.55rem;
            letter-spacing: 0.08em;
        }

        .hero-cta-primary,
        .hero-cta-secondary {
            font-size: 0.7rem;
            padding: 0.75rem 1rem;
        }

        .ticker-item {
            font-size: 0.55rem;
            margin-right: 1.25rem;
        }
    }
</style>

<?php
get_footer();