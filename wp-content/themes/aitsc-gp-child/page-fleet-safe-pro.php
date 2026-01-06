<?php
/**
 * Template Name: Fleet Safe Pro Pillar Page
 *
 * Pillar page for Fleet Safe Pro - Passenger Monitoring System
 * Uses universal components from Phase 2 and extracted content from Phase 3A
 *
 * @package AITSC_Pro_Theme
 * @since 3.2.0
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// Image paths
$hero_image = get_template_directory_uri() . '/assets/images/fleet-safe-pro/hero/display-ui-main.png';
$gallery_dir = get_template_directory_uri() . '/assets/images/fleet-safe-pro/gallery/';

// Get all gallery images
$gallery_images = array();
if (file_exists(get_stylesheet_directory() . '/assets/images/fleet-safe-pro/gallery/')) {
    $gallery_files = scandir(get_stylesheet_directory() . '/assets/images/fleet-safe-pro/gallery/');
    foreach ($gallery_files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'jpg' || pathinfo($file, PATHINFO_EXTENSION) === 'png') {
            $gallery_images[] = $gallery_dir . $file;
        }
    }
}
?>

<!-- Global Background & Grid Lines -->
<?php get_template_part('template-parts/global-background'); ?>
<div class="grid-lines"></div>

<!-- 1. HERO SECTION (WorldQuant Style) -->
<section class="scroll-section hero-section fleet-safe-hero"
    style="padding-top: 15vh; padding-bottom: 10vh; min-height: 100vh; position: relative;">
    <div class="aitsc-container">
        <div style="max-width: 83.33%; margin: 0 auto; text-align: center;">
            <!-- Animated Title -->
            <h1 class="aitsc-hero__title animate-title" style="margin-bottom: 2rem;">
                FLEET SAFE PRO
            </h1>

            <!-- Subtitle -->
            <p class="aitsc-hero__subtitle animate-fade-in delay-1">
                ADVANCED SAFETY TECHNOLOGY
            </p>

            <!-- Description -->
            <p class="aitsc-hero__description mt-4 animate-fade-in delay-2"
                style="max-width: 56.25rem; margin-left: auto; margin-right: auto; font-size: 1.25rem; line-height: 1.8;">
                Real-time seat belt detection system that installs easily with seamless hardware integration and smart
                alerts
            </p>

            <!-- Hero CTAs -->
            <div class="hero-cta-group animate-fade-in delay-3"
                style="margin-top: 3rem; display: flex; gap: 1.5rem; justify-content: center; align-items: center; flex-wrap: wrap;">
                <a href="#contact" class="hero-cta-primary">
                    <span>Request Demo</span>
                    <span class="material-symbols-outlined">arrow_forward</span>
                </a>
                <a href="#technical-specs" class="hero-cta-secondary">
                    <span>View Technical Specs</span>
                    <span class="material-symbols-outlined">arrow_forward</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Bottom Data Ticker -->
    <div class="data-ticker-wrap"
        style="position: absolute; bottom: 0; left: 0; width: 100%; overflow: hidden; background: rgba(0, 0, 0, 0.5); border-top: 1px solid var(--aitsc-grid-line); padding: 0.75rem 0; backdrop-filter: blur(5px);">
        <div class="data-ticker" style="display: flex; white-space: nowrap; animation: ticker 35s linear infinite;">
            <span class="ticker-item">REAL-TIME MONITORING: <strong class="text-green">ACTIVE</strong></span>
            <span class="ticker-item">PLUG & PLAY SETUP: <strong class="text-blue">100%</strong></span>
            <span class="ticker-item">DEPLOYED WITH BUS4X4: <strong class="text-green">✓</strong></span>
            <span class="ticker-item">VEHICLE CONFIGURATIONS: <strong class="text-blue">4-7 ROWS</strong></span>
            <span class="ticker-item">AUTO-CONFIGURATION: <strong class="text-green">ZERO PROGRAMMING</strong></span>
            <span class="ticker-item">WARRANTY COVERAGE: <strong class="text-blue">12 MONTHS</strong></span>
            <!-- Duplicate for seamless loop -->
            <span class="ticker-item">REAL-TIME MONITORING: <strong class="text-green">ACTIVE</strong></span>
            <span class="ticker-item">PLUG & PLAY SETUP: <strong class="text-blue">100%</strong></span>
        </div>
    </div>
</section>

<style>
    /* Fleet Safe Pro Hero Styles - WorldQuant Design */
    .fleet-safe-hero {
        position: relative;
        overflow: visible;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .fleet-safe-hero .aitsc-hero__title {
        font-family: var(--aitsc-font-heading);
        font-weight: 400;
        font-size: clamp(2.5rem, 10vw, 8rem);
        line-height: 1.1;
        letter-spacing: -0.04em;
        color: #fff;
        text-shadow: 0 0 30px rgba(255, 255, 255, 0.1);
    }

    .fleet-safe-hero .aitsc-hero__subtitle {
        font-family: 'Inter', sans-serif;
        font-size: clamp(0.7rem, 1.5vw, 1.25rem);
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: var(--aitsc-primary);
        margin-bottom: 0;
    }

    .fleet-safe-hero .aitsc-hero__description {
        color: #000000ff;
        font-family: 'Inter', sans-serif;
    }

    /* Hero CTAs */
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

    /* Animations */
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

    .animate-title {
        animation: fadeIn 1s ease-out forwards;
        opacity: 0;
    }

    .delay-1 {
        animation-delay: 0.2s;
    }

    .delay-2 {
        animation-delay: 0.4s;
    }

    .delay-3 {
        animation-delay: 0.6s;
    }

    /* Data Ticker */
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

    /* Responsive Styles */
    @media (max-width: 61.9375rem) {
        .fleet-safe-hero {
            padding-bottom: 12vh !important;
        }

        .fleet-safe-hero .aitsc-hero__title {
            font-size: clamp(2.5rem, 8vw, 6rem);
        }
    }

    @media (max-width: 47.9375rem) {
        .fleet-safe-hero {
            padding-bottom: 13vh !important;
        }

        .fleet-safe-hero>.aitsc-container>div {
            max-width: 100%;
            padding: 0 1rem;
        }

        .fleet-safe-hero .aitsc-hero__title {
            font-size: clamp(2rem, 8vw, 4rem);
            letter-spacing: -0.02em;
        }

        .fleet-safe-hero .aitsc-hero__subtitle {
            font-size: clamp(0.65rem, 2vw, 0.9rem);
            letter-spacing: 0.15em;
        }

        .fleet-safe-hero .aitsc-hero__description {
            font-size: 1rem !important;
        }

        .hero-cta-group {
            flex-direction: column;
            gap: 0.75rem !important;
        }

        .hero-cta-primary,
        .hero-cta-secondary {
            width: 100%;
            max-width: 20rem;
            justify-content: center;
            padding: 1rem 1.5rem;
            font-size: 0.875rem;
        }

        .ticker-item {
            font-size: 0.65rem;
            margin-right: 2rem;
        }
    }

    @media (max-width: 35.9375rem) {
        .fleet-safe-hero {
            min-height: 100vh !important;
            padding-top: 3rem !important;
            padding-bottom: 3rem !important;
        }

        .fleet-safe-hero .aitsc-hero__title {
            font-size: clamp(1.75rem, 8vw, 2.5rem);
            margin-bottom: 1rem !important;
        }

        .fleet-safe-hero .aitsc-hero__subtitle {
            font-size: 0.65rem;
            letter-spacing: 0.08em;
            margin-bottom: 0.75rem;
        }

        .fleet-safe-hero .aitsc-hero__description {
            font-size: 0.95rem !important;
            margin-top: 1rem !important;
        }

        .hero-cta-group {
            margin-top: 2rem !important;
        }

        .hero-cta-primary,
        .hero-cta-secondary {
            padding: 0.875rem 1.25rem !important;
            font-size: 0.75rem;
        }

        .data-ticker-wrap {
            padding: 0.5rem 0 !important;
        }

        .ticker-item {
            font-size: 0.55rem;
            margin-right: 1.5rem;
        }
    }

    @media (max-width: 23.4375rem) {
        .fleet-safe-hero .aitsc-hero__title {
            font-size: 1.5rem;
        }

        .ticker-item {
            font-size: 0.5rem;
            margin-right: 1.25rem;
        }
    }
</style>
<!-- 3. SOLUTION OVERVIEW -->
<section class="aitsc-section" style="background-color: #ffffff;">
    <div class="aitsc-container">
        <div class="aitsc-section__header">
            <!-- Product Overview Badge -->
            <div style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; border-radius: 9999px; background-color: rgba(37, 99, 235, 0.1); color: #60a5fa; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1.5rem;">
                <span class="material-symbols-outlined" style="font-size: 0.875rem;">description</span> Product Overview
            </div>

            <!-- Title -->
            <h2 class="aitsc-section__title">The Solution</h2>
            
            <!-- Subtitle -->
            <p class="aitsc-section__subtitle">Intelligent passenger monitoring with plug-and-play simplicity</p>
        </div>

        <div class="aitsc-solution-overview">
            <!-- Description Text -->
            <p class="aitsc-solution-overview__text">
                Fleet Safe Pro monitors seat occupancy, seatbelt status, and door state in real-time on passenger
                transport vehicles. The system uses seat sensor pads and buckle sensors connected to row modules and a
                display to provide accurate audible and visual alerts when passengers are unbuckled or the door is open.
            </p>

            <p class="aitsc-solution-overview__text">
                Smart algorithms allow automatic recognition of vehicle layout changes and sensor configurations,
                supporting plug-and-play installation. The display shows buckled, unbuckled, and idle seats with
                color-coded indicators (red, white, or black). The vehicle outline turns red if any passenger is
                unbuckled or the door is open.
            </p>

            <!-- Highlight Box -->
            <div class="aitsc-highlight-box">
                <h4>
                    <span class="material-symbols-outlined" style="color: #60a5fa; vertical-align: middle; margin-right: 0.5rem;">business</span>
                    Designed for Bus4x4
                </h4>
                <p>
                    This system is a custom technology solution designed specifically for Bus4x4, addressing their unique
                    operational requirements in passenger transport. It tackles key issues like ensuring seatbelt
                    compliance across all seats and simplifying the monitoring process for fleet operators.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- 4. KEY FEATURES (10 features grid) -->
<section class="aitsc-section aitsc-section--features">
    <div class="aitsc-container">
        <div class="aitsc-section__header">
            <h2 class="aitsc-section__title">Key Features</h2>
            <p class="aitsc-section__subtitle">Comprehensive safety monitoring with intelligent automation</p>
        </div>

        <div class="aitsc-grid aitsc-grid--3-col">
            <?php
            $features = array(
                array(
                    'title' => 'Real-Time Seat Monitoring',
                    'description' => 'Continuous monitoring of seat occupancy across all passenger positions',
                    'icon' => 'event_seat'
                ),
                array(
                    'title' => 'Seatbelt Status Detection',
                    'description' => 'Instant detection of seatbelt engagement status for every passenger',
                    'icon' => 'check_circle'
                ),
                array(
                    'title' => 'Door State Monitoring',
                    'description' => 'Real-time tracking of door open/closed status for enhanced safety',
                    'icon' => 'sensor_door'
                ),
                array(
                    'title' => 'Audible & Visual Alerts',
                    'description' => 'Clear alerts through built-in buzzer and color-coded display indicators',
                    'icon' => 'notifications_active'
                ),
                array(
                    'title' => 'Plug-and-Play Installation',
                    'description' => 'No programming or setup required - install and the system auto-configures',
                    'icon' => 'power'
                ),
                array(
                    'title' => 'Smart Auto-Configuration',
                    'description' => 'Automatic recognition of vehicle layout changes and sensor configurations',
                    'icon' => 'settings_suggest'
                ),
                array(
                    'title' => '4-Row & 7-Row Support',
                    'description' => 'Flexible system supporting both 4-row and 7-row vehicle configurations',
                    'icon' => 'view_week'
                ),
                array(
                    'title' => 'LHD & RHD Compatibility',
                    'description' => 'Full support for left-hand and right-hand drive vehicle layouts',
                    'icon' => 'alt_route'
                ),
                array(
                    'title' => 'Color-Coded Indicators',
                    'description' => 'Red (unbuckled), White (buckled), Black (idle) for instant status recognition',
                    'icon' => 'palette'
                ),
                array(
                    'title' => 'Vehicle Safety Status',
                    'description' => 'Vehicle outline turns red when any passenger is unbuckled or door is open',
                    'icon' => 'shield'
                )
            );

            foreach ($features as $feature) {
                aitsc_render_card(array(
                    'variant' => 'icon',
                    'title' => $feature['title'],
                    'description' => $feature['description'],
                    'icon' => $feature['icon'],
                    'size' => 'medium'
                ));
            }
            ?>
        </div>
    </div>
</section>

<!-- 5. TECHNICAL SPECIFICATIONS -->
<section id="technical-specs" class="aitsc-section aitsc-section--specs">
    <div class="aitsc-container">
        <div class="aitsc-section__header">
            <h2 class="aitsc-section__title">Technical Specifications</h2>
            <p class="aitsc-section__subtitle">System components and hardware details</p>
        </div>

        <div class="aitsc-grid aitsc-grid--2-col">
            <!-- Display Unit -->
            <?php
            aitsc_render_card(array(
                'variant' => 'spec',
                'title' => 'Display Unit',
                'description' => 'Compact dashboard-mounted display providing real-time visual feedback for up to 60 seats simultaneously.',
                'icon' => 'monitor',
                'specs' => array(
                    '<strong>Screen:</strong> High-contrast LED Matrix display',
                    '<strong>Seating Capacity:</strong> Supports up to 60 seats (Configurable)',
                    '<strong>Alerts:</strong> Visual & Audible alarms for unbuckled passengers',
                    '<strong>Power Input:</strong> 12V/24V DC Vehicle Power',
                    '<strong>Mounting:</strong> Dashboard or Windshield mount included',
                    '<strong>Interface:</strong> Simple 3-button navigation'
                )
            ));

            aitsc_render_card(array(
                'variant' => 'spec',
                'title' => 'Row Module',
                'description' => 'The Row Module acts as the data aggregator for each row of seats, collecting sensor data and transmitting it to the Display Unit.',
                'icon' => 'memory',
                'specs' => array(
                    '<strong>Installation:</strong> One module per row (e.g., Row 1 → Module 1)',
                    '<strong>Sensor Interface:</strong> Multiple Molex connectors for seat/buckle sensors',
                    '<strong>Data Aggregation:</strong> Consolidates occupancy and buckle status',
                    '<strong>Local Alerts:</strong> Built-in buzzer for immediate feedback',
                    '<strong>LED Indicator:</strong> Green LED confirms power status',
                    '<strong>Configuration:</strong> DIP switches for row number (1-7) and active seats'
                )
            ));

            aitsc_render_card(array(
                'variant' => 'spec',
                'title' => 'Seat Sensor',
                'description' => 'Pressure-sensitive device installed beneath each passenger seat cushion to detect passenger presence.',
                'icon' => 'sensor_occupied',
                'specs' => array(
                    '<strong>Type:</strong> Pressure-sensitive pad',
                    '<strong>Installation:</strong> Underneath each seat cushion',
                    '<strong>Function:</strong> Detects when passenger is seated',
                    '<strong>Output:</strong> Sends occupancy signal to Row Module',
                    '<strong>Power:</strong> Powered through Row Module connection',
                    '<strong>Durability:</strong> Designed for repeated seating cycles'
                )
            ));

            aitsc_render_card(array(
                'variant' => 'spec',
                'title' => 'Buckle Sensor',
                'description' => 'Integrated safety sensor built into the seatbelt buckle that detects whether seatbelt is properly fastened.',
                'icon' => 'lock',
                'specs' => array(
                    '<strong>Type:</strong> Sensor-equipped buckle',
                    '<strong>Function:</strong> Detects latched/unlatched status',
                    '<strong>Output:</strong> Sends buckle status to Row Module',
                    '<strong>Real-Time:</strong> Continuous status updates while driving',
                    '<strong>Power:</strong> Powered through Row Module connection',
                    '<strong>Durability:</strong> Heavy-duty design for repeated use'
                )
            ));
            ?>
        </div>
    </div>
</section>

<!-- 6. DISPLAY UI CONFIGURATIONS -->
<section class="aitsc-section aitsc-section--display-ui bg-slate-50" style="padding: 100px 0;">
    <div class="aitsc-container">
        <div class="aitsc-section__header">
            <h2 class="aitsc-section__title">Display UI Configurations</h2>
            <p class="aitsc-section__subtitle">Adaptive interface supporting multiple vehicle layouts</p>
        </div>

        <!-- Vehicle Layout Support -->
        <h3 class="mb-4 text-2xl font-bold text-slate-900">Vehicle Configuration</h3>
        <div class="aitsc-grid aitsc-grid--3-col">
            <?php
            $vehicle_configs = array(
                array(
                    'title' => '7-Row Vehicle',
                    'description' => 'Default when >4 row modules detected. Shows all 7 rows of seats.',
                    'icon' => 'directions_bus'
                ),
                array(
                    'title' => '4-Row Vehicle',
                    'description' => 'Default when ≤4 row modules detected. Optimized for smaller buses.',
                    'icon' => 'airport_shuttle'
                ),
                array(
                    'title' => 'Dense Seating',
                    'description' => 'Supports 4 seats per row (7A, 7B, 7C, 7D) configuration.',
                    'icon' => 'grid_view'
                )
            );

            foreach ($vehicle_configs as $config) {
                aitsc_render_card(array(
                    'variant' => 'white-feature',
                    'title' => $config['title'],
                    'description' => $config['description'],
                    'icon' => $config['icon'],
                    'custom_class' => 'h-100'
                ));
            }
            ?>
        </div>

        <!-- Drive Layout Support -->
        <div class="mt-5">
            <h3 class="mb-4 text-2xl font-bold text-slate-900">Drive Layout</h3>
            <div class="aitsc-grid aitsc-grid--2-col">
                <?php
                $drive_layouts = array(
                    array(
                        'title' => 'Right-Hand Drive',
                        'description' => 'Inverted vehicle layout automatically displayed. Common in Australia, UK, Japan.',
                        'icon' => 'settings_backup_restore'
                    ),
                    array(
                        'title' => 'Left-Hand Drive',
                        'description' => 'Standard vehicle layout displayed. Common in USA, Europe, most regions.',
                        'icon' => 'settings'
                    )
                );

                foreach ($drive_layouts as $layout) {
                    aitsc_render_card(array(
                        'variant' => 'white-feature',
                        'title' => $layout['title'],
                        'description' => $layout['description'],
                        'icon' => $layout['icon'],
                        'custom_class' => 'h-100'
                    ));
                }
                ?>
            </div>
        </div>

        <!-- Color-Coded Indicators -->
        <div class="aitsc-color-indicators" style="margin-top: 5rem;">
            <h3 class="mb-4 text-2xl font-bold text-slate-900">Color-Coded Status Indicators</h3>
            <div class="aitsc-grid aitsc-grid--3-col">
                <!-- Red Indicator -->
                <div>
                    <div class="aitsc-card aitsc-card--white-feature h-100 position-relative overflow-hidden">
                        <div style="position: absolute; left: 0; top: 0; bottom: 0; width: 6px; background: #ef4444;">
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge"
                                style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid #ef4444; padding: 0.5em 1em; font-weight: bold;">RED</span>
                        </div>
                        <h3 class="aitsc-card__title">Unbuckled / Door Open</h3>
                        <p class="aitsc-card__description">Indicates non-compliance or safety issue. Vehicle outline
                            turns red for immediate alert.</p>
                    </div>
                </div>
                <!-- White Indicator -->
                <div>
                    <div class="aitsc-card aitsc-card--white-feature h-100 position-relative overflow-hidden">
                        <div style="position: absolute; left: 0; top: 0; bottom: 0; width: 6px; background: #e2e8f0;">
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge"
                                style="background: #f8fafc; color: #64748b; border: 1px solid #cbd5e1; padding: 0.5em 1em; font-weight: bold;">WHITE</span>
                        </div>
                        <h3 class="aitsc-card__title">Buckled / Door Closed</h3>
                        <p class="aitsc-card__description">Indicates compliance and safe status. All passengers buckled
                            and vehicle secure.</p>
                    </div>
                </div>
                <!-- Black Indicator -->
                <div>
                    <div class="aitsc-card aitsc-card--white-feature h-100 position-relative overflow-hidden">
                        <div style="position: absolute; left: 0; top: 0; bottom: 0; width: 6px; background: #334155;">
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge"
                                style="background: #f1f5f9; color: #334155; border: 1px solid #334155; padding: 0.5em 1em; font-weight: bold;">BLACK</span>
                        </div>
                        <h3 class="aitsc-card__title">Idle Seat</h3>
                        <p class="aitsc-card__description">Seat/buckle sensors connected but no passenger present.
                            System monitoring active.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Smart Features -->
        <div class="aitsc-smart-features" style="margin-top: 5rem;">
            <h3 class="mb-4 text-2xl font-bold text-slate-900">Plug-and-Play Features</h3>
            <div class="aitsc-grid aitsc-grid--4-col">
                <?php
                $smart_features = array(
                    array(
                        'title' => 'Automatic Configuration',
                        'icon' => 'check_circle'
                    ),
                    array(
                        'title' => 'Self-Recognition',
                        'icon' => 'check_circle'
                    ),
                    array(
                        'title' => 'Flexible Seating (4-48)',
                        'icon' => 'check_circle'
                    ),
                    array(
                        'title' => 'Modular Design',
                        'icon' => 'check_circle'
                    )
                );

                foreach ($smart_features as $feature) {
                    aitsc_render_card(array(
                        'variant' => 'white-feature', // Use same consistent style
                        'title' => $feature['title'],
                        'icon' => $feature['icon'],
                        'custom_class' => 'h-100 text-center flex-column justify-center items-center' // Force centering
                    ));
                }
                ?>
            </div>
        </div>
    </div>
</section>

<!-- 7. INSTALLATION GUIDE -->
<section class="aitsc-section aitsc-section--installation">
    <div class="aitsc-container">
        <div class="aitsc-section__header">
            <h2 class="aitsc-section__title">Installation Guide</h2>
            <p class="aitsc-section__subtitle">Quick 4-step setup with detailed procedures</p>
        </div>

        <!-- Quick Guide - Universal Component -->
        <?php
        $install_steps = array(
            array(
                'title' => 'Attach Sensors',
                'description' => 'Install seat sensor and buckle sensor onto each seat. Place sensors flat under cushions for optimal detection.',
                'icon' => 'sensors',
                'tags' => array('Seat Sensor', 'Buckle Sensor')
            ),
            array(
                'title' => 'Mount Row Modules',
                'description' => 'Install each row module at designated row positions. Pick flat spots under seats that won\'t hit rails or floor.',
                'icon' => 'memory',
                'tags' => array('Row Module', 'Mounting')
            ),
            array(
                'title' => 'Connect Sensors',
                'description' => 'Plug each seat sensor into matching plug on row module. Route cables safely along seat frames.',
                'icon' => 'cable',
                'tags' => array('Wiring', 'Molex Connectors')
            ),
            array(
                'title' => 'Connect to Display',
                'description' => 'Connect all row modules together and link to display unit. Power up and verify all seats show on display.',
                'icon' => 'monitor',
                'tags' => array('Display Unit', 'Final Test')
            )
        );

        aitsc_render_steps(array(
            'title' => '4-Step Quick Installation',
            'subtitle' => 'Scroll through each step',
            'variant' => 'slider',
            'steps' => $install_steps
        ));
        ?>

        <!-- Detailed Procedures (Universal Tabs Component) -->
        <div class="aitsc-install-tabs">
            <?php
            $detailed_procedures = array(
                array(
                    'id' => 'seat',
                    'label' => 'Seat Sensor',
                    'icon' => 'sensors',
                    'content' => '
                        <div class="aitsc-card aitsc-card--white-feature">
                            <h4 class="aitsc-card__title">Seat Sensor Installation</h4>
                            <ol class="aitsc-procedure-list">
                                <li>Lift the seat cushion</li>
                                <li>Place sensor flat under cushion, centred for best detection</li>
                                <li>Keep surface smooth - no folds or bumps</li>
                                <li>Point connector/wires toward seat rear or side</li>
                                <li>Plug into assigned Molex plug for specific seat</li>
                                <li>Run cable along seat frame</li>
                                <li>Tie up extra cable; keep clear of sliders and hinges</li>
                                <li>Reinstall cushion</li>
                            </ol>
                            <div class="aitsc-test-note">
                                <span class="material-symbols-outlined">check_circle</span>
                                <strong>Test:</strong> Power on, sit on seat, verify display shows "occupied"
                            </div>
                        </div>'
                ),
                array(
                    'id' => 'buckle',
                    'label' => 'Buckle Sensor',
                    'icon' => 'lock',
                    'content' => '
                        <div class="aitsc-card aitsc-card--white-feature">
                            <h4 class="aitsc-card__title">Buckle Sensor Installation</h4>
                            <ol class="aitsc-procedure-list">
                                <li>Mount buckle sensor securely</li>
                                <li>Route cable safely (avoid hinges/sharp edges)</li>
                                <li>Plug into assigned Molex plug for specific seat</li>
                                <li>Tie up extra cable; keep clear of seat movement</li>
                            </ol>
                            <div class="aitsc-test-note">
                                <span class="material-symbols-outlined">check_circle</span>
                                <strong>Test:</strong> Power on, move seat through full travel, buckle/unbuckle and verify display
                            </div>
                        </div>'
                ),
                array(
                    'id' => 'module',
                    'label' => 'Row Module',
                    'icon' => 'memory',
                    'content' => '
                        <div class="aitsc-card aitsc-card--white-feature">
                            <h4 class="aitsc-card__title">Row Module Installation</h4>
                            <ol class="aitsc-procedure-list">
                                <li>Pick flat spot under seat (won\'t hit rails/floor)</li>
                                <li>Mount bracket/module with screws or zip-ties</li>
                                <li>Connect sensors, power, and data harness</li>
                                <li>Route antenna away from large metal surfaces</li>
                                <li>Tidy cables along seat frame</li>
                                <li>Set row number using switch (1-7)</li>
                                <li>Set active seats using switch (A,B,C,D)</li>
                            </ol>
                            <div class="aitsc-test-note">
                                <span class="material-symbols-outlined">check_circle</span>
                                <strong>Test:</strong> Move seat through travel, sit/buckle and verify display shows correct status
                            </div>
                        </div>'
                ),
                array(
                    'id' => 'display',
                    'label' => 'Display Unit',
                    'icon' => 'monitor',
                    'content' => '
                        <div class="aitsc-card aitsc-card--white-feature">
                            <h4 class="aitsc-card__title">Display Unit Installation</h4>
                            <ol class="aitsc-procedure-list">
                                <li>Choose flat area on/near dash for driver visibility</li>
                                <li>Do not block airbags, vents, or windshield view</li>
                                <li>Fit ball mount (stick or screw base)</li>
                                <li>Attach arm and tighten lightly</li>
                                <li>Clip display onto ball and adjust angle</li>
                                <li>Route cable behind trim toward power/data</li>
                                <li>Avoid steering column and pedals</li>
                                <li>Power: Red → +12V ACC/IGN (fused), Black → Ground</li>
                                <li>Data: Plug into system display/COM port</li>
                                <li>Secure slack with zip ties</li>
                            </ol>
                            <div class="aitsc-test-note">
                                <span class="material-symbols-outlined">check_circle</span>
                                <strong>Test:</strong> Turn ignition on, verify display lights up and shows all rows/seats
                            </div>
                        </div>'
                )
            );

            aitsc_render_tabs(array(
                'title' => 'Detailed Installation Procedures',
                'id' => 'install-guide-tabs',
                'tabs' => $detailed_procedures
            ));
            ?>
        </div>
    </div>
</section>

<!-- 8. PRODUCT GALLERY -->
<section class="aitsc-section aitsc-section--gallery">
    <?php
    $gallery_images = array();
    $post_id = get_the_ID();

    // Try to get ACF gallery images first - use direct post meta retrieval
    $gallery_meta = get_post_meta($post_id, 'gallery_images', true);

    if ($gallery_meta) {
        // Handle both JSON string and array formats
        if (is_string($gallery_meta)) {
            $acf_gallery = json_decode($gallery_meta, true);
        } else {
            $acf_gallery = $gallery_meta;
        }

        if ($acf_gallery && is_array($acf_gallery)) {
            foreach ($acf_gallery as $image_data) {
                $attachment_id = isset($image_data['ID']) ? $image_data['ID'] : $image_data;
                if (is_numeric($attachment_id)) {
                    $image_url = wp_get_attachment_url($attachment_id);
                    if ($image_url) {
                        $gallery_images[] = $image_url;
                    }
                }
            }
        }
    }

    // Fallback to theme assets if no ACF images
    if (empty($gallery_images)) {
        $gallery_path = get_stylesheet_directory() . '/assets/images/fleet-safe-pro/gallery';
        $gallery_url = get_template_directory_uri() . '/assets/images/fleet-safe-pro/gallery';

        if (is_dir($gallery_path)) {
            $files = scandir($gallery_path);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..' && preg_match('/\.(jpg|jpeg|png|webp)$/i', $file)) {
                    $gallery_images[] = $gallery_url . '/' . $file;
                }
            }
        }
    }

    // Final fallback to placeholder images
    if (empty($gallery_images)) {
        $gallery_images = array(
            'https://placehold.co/600x400/003366/ffffff?text=Sensor+Detail',
            'https://placehold.co/600x400/003366/ffffff?text=Display+Unit',
            'https://placehold.co/600x400/003366/ffffff?text=Installation',
            'https://placehold.co/600x400/003366/ffffff?text=System+Overview'
        );
    }

    aitsc_render_gallery(array(
        'title' => 'Product Gallery',
        'subtitle' => 'Close-up views of system components and installation examples',
        'images' => $gallery_images
    ));
    ?>
</section>

<!-- 9. COMPLIANCE & SAFETY -->
<section class="aitsc-section aitsc-section--compliance">
    <div class="aitsc-container">
        <div class="aitsc-section__header">
            <h2 class="aitsc-section__title">Compliance & Warranty</h2>
            <p class="aitsc-section__subtitle">Peace of mind with comprehensive coverage</p>
        </div>

        <div class="aitsc-grid aitsc-grid--2-col">

            <?php
            aitsc_render_card(array(
                'variant' => 'white-feature',
                'title' => '12-Month Warranty',
                'description' => 'All components covered with 12-month warranty from purchase date. Return-to-base parts replacement with customer-paid shipping.',
                'icon' => 'verified_user',
                'custom_class' => 'h-100',
                'specs' => array(
                    'Comprehensive component coverage',
                    'Return-to-base replacement service',
                    'Serial number verification required',
                    'RMA (Return Merchandise Authorization) mandatory'
                )
            ));

            aitsc_render_card(array(
                'variant' => 'white-feature',
                'title' => 'Australian Consumer Law',
                'description' => 'Our goods come with guarantees that cannot be excluded under the Australian Consumer Law (ACL). You are entitled to a replacement or refund for major failures.',
                'icon' => 'gavel',
                'custom_class' => 'h-100',
                'specs' => array(
                    'ACL consumer guarantees apply',
                    'Replacement for major failures',
                    'Refund for significant non-compliance',
                    'Limited to purchase price liability'
                )
            ));

            aitsc_render_card(array(
                'variant' => 'white-feature',
                'title' => 'Claims Process',
                'description' => 'Contact <a href="mailto:support@aitsc.au">support@aitsc.au</a> with proof of purchase and serial number. RMA required before returning any components.',
                'icon' => 'support_agent',
                'custom_class' => 'h-100',
                'specs' => array(
                    'Proof of purchase required',
                    'Serial number verification',
                    'DOA: Report within 14 days',
                    'Customer pays return shipping'
                )
            ));

            aitsc_render_card(array(
                'variant' => 'white-feature',
                'title' => 'Installation Requirements',
                'description' => 'Ensure installation by competent personnel in accordance with AITSC documentation and applicable vehicle/OEM guidance.',
                'icon' => 'engineering',
                'custom_class' => 'h-100',
                'specs' => array(
                    'Professional installation required',
                    'Follow AITSC documentation',
                    'No hardware/software modification',
                    'No non-approved parts'
                )
            ));
            ?>
        </div>

        <!-- Exclusions -->
        <div class="aitsc-exclusions" style="margin-top: 3rem;">
            <h4>Warranty Exclusions</h4>
            <p>The following actions void warranty:</p>
            <div class="aitsc-grid aitsc-grid--4-col">
                <?php
                $exclusions = array(
                    array('icon' => 'block', 'title' => 'Removal of serial/void labels'),
                    array('icon' => 'block', 'title' => 'Misuse or modification'),
                    array('icon' => 'block', 'title' => 'Improper wiring'),
                    array('icon' => 'block', 'title' => 'Water ingress or accidents')
                );

                foreach ($exclusions as $exclusion) {
                    aitsc_render_card(array(
                        'variant' => 'white-feature',
                        'size' => 'small',
                        'title' => $exclusion['title'],
                        'icon' => $exclusion['icon'],
                        'custom_class' => 'h-100'
                    ));
                }
                ?>
            </div>
        </div>
    </div>
</section>

<!-- 10. CTA SECTION -->
<section id="contact" class="aitsc-section aitsc-section--cta">
    <div class="aitsc-container">
        <div class="aitsc-demo-cta">
            <div class="aitsc-demo-cta__content">
                <h2 class="aitsc-section__title">Request a Demo</h2>
                <p class="aitsc-demo-cta__description">See Fleet Safe Pro in action. Contact our team for a personalized
                    demonstration of how our passenger monitoring system can enhance your fleet safety.</p>

                <div class="aitsc-demo-cta__features">
                    <div class="aitsc-demo-feature">
                        <span class="material-symbols-outlined">videocam</span>
                        <span>Live Product Demo</span>
                    </div>
                    <div class="aitsc-demo-feature">
                        <span class="material-symbols-outlined">support_agent</span>
                        <span>Expert Consultation</span>
                    </div>
                    <div class="aitsc-demo-feature">
                        <span class="material-symbols-outlined">calculate</span>
                        <span>Custom Quote</span>
                    </div>
                </div>
            </div>

            <div class="aitsc-demo-cta__form">
                <form class="aitsc-contact-form" action="#" method="post">
                    <div class="aitsc-form-row aitsc-form-row--2col">
                        <div class="aitsc-form-group">
                            <label for="demo-name">Full Name *</label>
                            <input type="text" id="demo-name" name="name" placeholder="John Smith" required>
                        </div>
                        <div class="aitsc-form-group">
                            <label for="demo-email">Email Address *</label>
                            <input type="email" id="demo-email" name="email" placeholder="john@company.com" required>
                        </div>
                    </div>
                    <div class="aitsc-form-row aitsc-form-row--2col">
                        <div class="aitsc-form-group">
                            <label for="demo-company">Company Name</label>
                            <input type="text" id="demo-company" name="company" placeholder="Your Company">
                        </div>
                        <div class="aitsc-form-group">
                            <label for="demo-phone">Phone Number</label>
                            <input type="tel" id="demo-phone" name="phone" placeholder="+61 400 000 000">
                        </div>
                    </div>
                    <div class="aitsc-form-group">
                        <label for="demo-fleet">Fleet Size</label>
                        <select id="demo-fleet" name="fleet_size">
                            <option value="">Select fleet size</option>
                            <option value="1-10">1-10 vehicles</option>
                            <option value="11-50">11-50 vehicles</option>
                            <option value="51-100">51-100 vehicles</option>
                            <option value="100+">100+ vehicles</option>
                        </select>
                    </div>
                    <div class="aitsc-form-group">
                        <label for="demo-message">Message</label>
                        <textarea id="demo-message" name="message" rows="4"
                            placeholder="Tell us about your requirements..."></textarea>
                    </div>
                    <button type="submit" class="aitsc-form-submit">
                        <span>Request Demo</span>
                        <span class="material-symbols-outlined">send</span>
                    </button>
                    <p class="aitsc-form-note">
                        <span class="material-symbols-outlined">info</span>
                        We'll respond within 24 business hours.
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Footer Contact Info -->
<section class="aitsc-section aitsc-section--contact">
    <div class="aitsc-container">
        <div class="aitsc-contact-box">
            <h3>About AITSC</h3>
            <p>We solve your most expensive technology problems without spending more. AITSC is passionate about new
                technology and how to leverage it to make companies more efficient.</p>
            <p><strong>Our Mission:</strong> Solve the most critical technology gaps in multi-million-dollar industries
                and make a lasting difference for technology in Australia.</p>

            <div class="aitsc-contact-links">
                <div class="aitsc-contact-item">
                    <span class="material-symbols-outlined">language</span>
                    <a href="https://www.aitsc.au" target="_blank" rel="noopener">www.aitsc.au</a>
                </div>
                <div class="aitsc-contact-item">
                    <span class="material-symbols-outlined">email</span>
                    <a href="mailto:support@aitsc.au">support@aitsc.au</a>
                </div>
                <div class="aitsc-contact-item">
                    <span class="material-symbols-outlined">email</span>
                    <a href="mailto:contact@aitsc.au">contact@aitsc.au</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
