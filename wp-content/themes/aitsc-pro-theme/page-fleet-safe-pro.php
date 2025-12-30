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
if (file_exists(get_template_directory() . '/assets/images/fleet-safe-pro/gallery/')) {
    $gallery_files = scandir(get_template_directory() . '/assets/images/fleet-safe-pro/gallery/');
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
<section class="scroll-section hero-section fleet-safe-hero" style="padding-top: 15vh; padding-bottom: 10vh; min-height: 100vh; position: relative; display: flex; align-items: center;">
    <div class="container h-100 d-flex flex-column justify-content-center">
        <div class="row justify-content-center text-center">
            <div class="col-lg-10">
                <!-- Animated Title -->
                <h1 class="aitsc-hero__title animate-title" style="margin-bottom: 2rem;">
                    FLEET SAFE PRO
                </h1>

                <!-- Subtitle -->
                <p class="aitsc-hero__subtitle animate-fade-in delay-1">
                    ADVANCED SAFETY TECHNOLOGY
                </p>

                <!-- Description -->
                <p class="aitsc-hero__description mt-4 animate-fade-in delay-2" style="max-width: 56.25rem; margin-left: auto; margin-right: auto; font-size: 1.25rem; line-height: 1.8;">
                    Real-time seat belt detection system that installs easily with seamless hardware integration and smart alerts
                </p>

                <!-- Hero CTAs -->
                <div class="hero-cta-group animate-fade-in delay-3" style="margin-top: 3rem; display: flex; gap: 1.5rem; justify-content: center; align-items: center; flex-wrap: wrap;">
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
    </div>

    <!-- Bottom Data Ticker -->
    <div class="data-ticker-wrap" style="position: absolute; bottom: 0; left: 0; width: 100%; overflow: hidden; background: rgba(0, 0, 0, 0.5); border-top: 1px solid var(--aitsc-grid-line); padding: 0.75rem 0; backdrop-filter: blur(5px);">
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
}

.fleet-safe-hero .aitsc-hero__title {
    font-family: var(--aitsc-font-heading);
    font-weight: 200;
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
    color: #dfdfdf;
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

.delay-1 { animation-delay: 0.2s; }
.delay-2 { animation-delay: 0.4s; }
.delay-3 { animation-delay: 0.6s; }

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
    0% { transform: translate3d(0, 0, 0); }
    100% { transform: translate3d(-50%, 0, 0); }
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

<!-- 2. PROBLEM DEFINITION -->
<section class="aitsc-section aitsc-section--problem fade-in-section">
    <div class="aitsc-container">
        <div class="aitsc-section__header">
            <h2 class="aitsc-section__title">The Challenge</h2>
            <p class="aitsc-section__subtitle">Ensuring passenger safety compliance in modern transport fleets</p>
        </div>

        <div class="aitsc-grid aitsc-grid--2-col">
            <div class="aitsc-problem-card">
                <div class="aitsc-problem-card__icon">
                    <span class="material-symbols-outlined">warning</span>
                </div>
                <h3>Compliance Monitoring</h3>
                <p>Ensuring seatbelt compliance across all passenger seats without constant manual checking creates
                    operational challenges for fleet operators.</p>
            </div>

            <div class="aitsc-problem-card">
                <div class="aitsc-problem-card__icon">
                    <span class="material-symbols-outlined">schedule</span>
                </div>
                <h3>Installation Efficiency</h3>
                <p>Traditional safety systems require complex programming and lengthy installation processes, increasing
                    vehicle downtime and labour costs.</p>
            </div>

            <div class="aitsc-problem-card">
                <div class="aitsc-problem-card__icon">
                    <span class="material-symbols-outlined">build</span>
                </div>
                <h3>Maintenance Costs</h3>
                <p>When components fail, entire systems often need replacement, resulting in unnecessary expenses and
                    extended fleet downtime.</p>
            </div>

            <div class="aitsc-problem-card">
                <div class="aitsc-problem-card__icon">
                    <span class="material-symbols-outlined">visibility</span>
                </div>
                <h3>Driver Visibility</h3>
                <p>Drivers need clear, real-time visibility of passenger safety status without distraction from their
                    primary driving responsibilities.</p>
            </div>
        </div>
    </div>
</section>

<!-- 3. SOLUTION OVERVIEW -->
<section class="aitsc-section aitsc-section--solution fade-in-section">
    <div class="aitsc-container">
        <div class="aitsc-section__header">
            <h2 class="aitsc-section__title">The Solution</h2>
            <p class="aitsc-section__subtitle">Intelligent passenger monitoring with plug-and-play simplicity</p>
        </div>

        <div class="aitsc-solution-overview">
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

            <div class="aitsc-highlight-box">
                <h4>Designed for Bus4x4</h4>
                <p>This system is a custom technology solution designed specifically for Bus4x4, addressing their unique
                    operational requirements in passenger transport. It tackles key issues like ensuring seatbelt
                    compliance across all seats and simplifying the monitoring process for fleet operators.</p>
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
            <div class="aitsc-spec-card">
                <div class="aitsc-spec-card__header">
                    <div class="aitsc-spec-card__icon">
                        <span class="material-symbols-outlined">monitor</span>
                    </div>
                    <h3>Display Unit</h3>
                </div>
                <div class="aitsc-spec-card__body">
                    <p>The Display Unit serves as the visual interface and central hub of the Seat Belt Detection
                        System. It houses the Receiver Module and provides real-time feedback on safety status.</p>
                    <ul class="aitsc-spec-list">
                        <li><strong>Screen:</strong> 5-inch display with 800x480 resolution</li>
                        <li><strong>Real-Time Metrics:</strong> Buckled/unbuckled counts, door status, loading bar</li>
                        <li><strong>Visual Alerts:</strong> Color-coded indicators for instant status recognition</li>
                        <li><strong>Audible Alerts:</strong> Built-in buzzer for safety notifications</li>
                        <li><strong>Plug & Play:</strong> Auto-initializes without programming</li>
                        <li><strong>Mounting:</strong> Adjustable ball mount for optimal driver visibility</li>
                    </ul>
                </div>
            </div>

            <!-- Row Module -->
            <div class="aitsc-spec-card">
                <div class="aitsc-spec-card__header">
                    <div class="aitsc-spec-card__icon">
                        <span class="material-symbols-outlined">memory</span>
                    </div>
                    <h3>Row Module</h3>
                </div>
                <div class="aitsc-spec-card__body">
                    <p>The Row Module acts as the data aggregator for each row of seats, collecting sensor data and
                        transmitting it to the Display Unit.</p>
                    <ul class="aitsc-spec-list">
                        <li><strong>Installation:</strong> One module per row (e.g., Row 1 → Module 1)</li>
                        <li><strong>Sensor Interface:</strong> Multiple Molex connectors for seat/buckle sensors</li>
                        <li><strong>Data Aggregation:</strong> Consolidates occupancy and buckle status</li>
                        <li><strong>Local Alerts:</strong> Built-in buzzer for immediate feedback</li>
                        <li><strong>LED Indicator:</strong> Green LED confirms power status</li>
                        <li><strong>Configuration:</strong> DIP switches for row number (1-7) and active seats</li>
                    </ul>
                </div>
            </div>

            <!-- Seat Sensor -->
            <div class="aitsc-spec-card">
                <div class="aitsc-spec-card__header">
                    <div class="aitsc-spec-card__icon">
                        <span class="material-symbols-outlined">sensor_occupied</span>
                    </div>
                    <h3>Seat Sensor</h3>
                </div>
                <div class="aitsc-spec-card__body">
                    <p>Pressure-sensitive device installed beneath each passenger seat cushion to detect passenger
                        presence.</p>
                    <ul class="aitsc-spec-list">
                        <li><strong>Type:</strong> Pressure-sensitive pad</li>
                        <li><strong>Installation:</strong> Underneath each seat cushion</li>
                        <li><strong>Function:</strong> Detects when passenger is seated</li>
                        <li><strong>Output:</strong> Sends occupancy signal to Row Module</li>
                        <li><strong>Power:</strong> Powered through Row Module connection</li>
                        <li><strong>Durability:</strong> Designed for repeated seating cycles</li>
                    </ul>
                </div>
            </div>

            <!-- Buckle Sensor -->
            <div class="aitsc-spec-card">
                <div class="aitsc-spec-card__header">
                    <div class="aitsc-spec-card__icon">
                        <span class="material-symbols-outlined">lock</span>
                    </div>
                    <h3>Buckle Sensor</h3>
                </div>
                <div class="aitsc-spec-card__body">
                    <p>Integrated safety sensor built into the seatbelt buckle that detects whether seatbelt is properly
                        fastened.</p>
                    <ul class="aitsc-spec-list">
                        <li><strong>Type:</strong> Sensor-equipped buckle</li>
                        <li><strong>Function:</strong> Detects latched/unlatched status</li>
                        <li><strong>Output:</strong> Sends buckle status to Row Module</li>
                        <li><strong>Real-Time:</strong> Continuous status updates while driving</li>
                        <li><strong>Power:</strong> Powered through Row Module connection</li>
                        <li><strong>Durability:</strong> Heavy-duty design for repeated use</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 6. DISPLAY UI CONFIGURATIONS -->
<section class="aitsc-section aitsc-section--display-ui">
    <div class="aitsc-container">
        <div class="aitsc-section__header">
            <h2 class="aitsc-section__title">Display UI Configurations</h2>
            <p class="aitsc-section__subtitle">Adaptive interface supporting multiple vehicle layouts</p>
        </div>

        <!-- Vehicle Layout Support -->
        <div class="aitsc-grid aitsc-grid--3-col">
            <div class="aitsc-ui-config">
                <h4>7-Row Vehicle</h4>
                <p>Default when >4 row modules detected. Shows all 7 rows of seats.</p>
            </div>
            <div class="aitsc-ui-config">
                <h4>4-Row Vehicle</h4>
                <p>Default when ≤4 row modules detected. Optimized for smaller buses.</p>
            </div>
            <div class="aitsc-ui-config">
                <h4>Dense Seating</h4>
                <p>Supports 4 seats per row (7A, 7B, 7C, 7D) configuration.</p>
            </div>
        </div>

        <!-- Drive Layout Support -->
        <div class="aitsc-grid aitsc-grid--2-col" style="margin-top: 3rem;">
            <div class="aitsc-ui-config">
                <h4>Right-Hand Drive</h4>
                <p>Inverted vehicle layout automatically displayed. Common in Australia, UK, Japan.</p>
            </div>
            <div class="aitsc-ui-config">
                <h4>Left-Hand Drive</h4>
                <p>Standard vehicle layout displayed. Common in USA, Europe, most regions.</p>
            </div>
        </div>

        <!-- Color-Coded Indicators -->
        <div class="aitsc-color-indicators" style="margin-top: 4rem;">
            <h3>Color-Coded Status Indicators</h3>
            <div class="aitsc-grid aitsc-grid--3-col">
                <div class="aitsc-indicator-card" style="border-left: 4px solid #dc3545;">
                    <div class="aitsc-indicator-badge" style="background: #dc3545;">RED</div>
                    <h4>Unbuckled / Door Open</h4>
                    <p>Indicates non-compliance or safety issue. Vehicle outline turns red for immediate alert.</p>
                </div>
                <div class="aitsc-indicator-card" style="border-left: 4px solid #fff;">
                    <div class="aitsc-indicator-badge" style="background: #fff; color: #000;">WHITE</div>
                    <h4>Buckled / Door Closed</h4>
                    <p>Indicates compliance and safe status. All passengers buckled and vehicle secure.</p>
                </div>
                <div class="aitsc-indicator-card" style="border-left: 4px solid #000;">
                    <div class="aitsc-indicator-badge" style="background: #000;">BLACK</div>
                    <h4>Idle Seat</h4>
                    <p>Seat/buckle sensors connected but no passenger present. System monitoring active.</p>
                </div>
            </div>
        </div>

        <!-- Smart Features -->
        <div class="aitsc-smart-features" style="margin-top: 4rem;">
            <h3>Plug-and-Play Features</h3>
            <div class="aitsc-grid aitsc-grid--4-col">
                <div class="aitsc-feature-item">
                    <span class="material-symbols-outlined">check_circle</span>
                    <p>Automatic Configuration</p>
                </div>
                <div class="aitsc-feature-item">
                    <span class="material-symbols-outlined">check_circle</span>
                    <p>Self-Recognition</p>
                </div>
                <div class="aitsc-feature-item">
                    <span class="material-symbols-outlined">check_circle</span>
                    <p>Flexible Seating (4-48)</p>
                </div>
                <div class="aitsc-feature-item">
                    <span class="material-symbols-outlined">check_circle</span>
                    <p>Modular Design</p>
                </div>
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

        <!-- Quick Guide -->
        <div class="aitsc-quick-guide">
            <h3>4-Step Quick Installation</h3>
            <div class="aitsc-steps">
                <div class="aitsc-step">
                    <div class="aitsc-step__number">1</div>
                    <div class="aitsc-step__content">
                        <h4>Attach Sensors</h4>
                        <p>Install seat sensor and buckle sensor onto each seat.</p>
                    </div>
                </div>
                <div class="aitsc-step">
                    <div class="aitsc-step__number">2</div>
                    <div class="aitsc-step__content">
                        <h4>Mount Row Modules</h4>
                        <p>Install each row module at designated row positions.</p>
                    </div>
                </div>
                <div class="aitsc-step">
                    <div class="aitsc-step__number">3</div>
                    <div class="aitsc-step__content">
                        <h4>Connect Sensors</h4>
                        <p>Plug each seat sensor into matching plug on row module.</p>
                    </div>
                </div>
                <div class="aitsc-step">
                    <div class="aitsc-step__number">4</div>
                    <div class="aitsc-step__content">
                        <h4>Connect to Display</h4>
                        <p>Connect all row modules together and link to display unit.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Procedures -->
        <div class="aitsc-detailed-install">
            <h3>Detailed Installation Procedures</h3>

            <!-- Seat Sensor -->
            <div class="aitsc-procedure">
                <h4>Seat Sensor Installation</h4>
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
                    <strong>Test:</strong> Power on, sit on seat, verify display shows "occupied"
                </div>
            </div>

            <!-- Buckle Sensor -->
            <div class="aitsc-procedure">
                <h4>Buckle Sensor Installation</h4>
                <ol class="aitsc-procedure-list">
                    <li>Mount buckle sensor securely</li>
                    <li>Route cable safely (avoid hinges/sharp edges)</li>
                    <li>Plug into assigned Molex plug for specific seat</li>
                    <li>Tie up extra cable; keep clear of seat movement</li>
                </ol>
                <div class="aitsc-test-note">
                    <strong>Test:</strong> Power on, move seat through full travel, buckle/unbuckle and verify display
                </div>
            </div>

            <!-- Row Module -->
            <div class="aitsc-procedure">
                <h4>Row Module Installation</h4>
                <ol class="aitsc-procedure-list">
                    <li>Pick flat spot under seat (won't hit rails/floor)</li>
                    <li>Mount bracket/module with screws or zip-ties</li>
                    <li>Connect sensors, power, and data harness</li>
                    <li>Route antenna away from large metal surfaces</li>
                    <li>Tidy cables along seat frame</li>
                    <li>Set row number using switch (1-7)</li>
                    <li>Set active seats using switch (A,B,C,D)</li>
                </ol>
                <div class="aitsc-test-note">
                    <strong>Test:</strong> Move seat through travel, sit/buckle and verify display shows correct status
                </div>
            </div>

            <!-- Display Unit -->
            <div class="aitsc-procedure">
                <h4>Display Unit Installation</h4>
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
                    <strong>Test:</strong> Turn ignition on, verify display lights up and shows all rows/seats
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 8. VISUAL GALLERY -->
<section class="aitsc-section aitsc-section--gallery">
    <div class="aitsc-container">
        <div class="aitsc-section__header">
            <h2 class="aitsc-section__title">Product Gallery</h2>
            <p class="aitsc-section__subtitle">Real installation photos and system components</p>
        </div>

        <div class="aitsc-gallery-slider-container">
            <div class="aitsc-gallery-track">
                <?php
                // Display first 24 gallery images
                $display_count = min(24, count($gallery_images));
                for ($i = 0; $i < $display_count; $i++) {
                    $image_path = $gallery_images[$i];
                    $image_name = basename($image_path);
                    $image_title = ucwords(str_replace(array('-', '_', '.'), ' ', pathinfo($image_name, PATHINFO_FILENAME)));

                    // Manually render card for better control over slider classes
                    ?>
                    <div class="aitsc-card aitsc-card--image aitsc-card--gallery aitsc-gallery-slide">
                        <div class="aitsc-card__image-wrapper">
                            <img src="<?php echo esc_url($image_path); ?>" alt="<?php echo esc_attr($image_title); ?>"
                                loading="lazy">
                        </div>
                        <div class="aitsc-card__content">
                            <h3 class="aitsc-card__title"><?php echo esc_html($image_title); ?></h3>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>

            <!-- Slider Controls -->
            <?php if ($display_count > 3): ?>
                <div class="aitsc-slider-controls">
                    <button class="aitsc-slider-btn aitsc-slider-btn--prev" aria-label="Previous slide">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </button>
                    <button class="aitsc-slider-btn aitsc-slider-btn--next" aria-label="Next slide">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </button>
                </div>
            <?php endif; ?>
        </div>

        <?php if (count($gallery_images) > 24): ?>
            <div class="aitsc-gallery-more">
                <p>Showing 1-<?php echo min(24, count($gallery_images)); ?> of <?php echo count($gallery_images); ?> photos
                </p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- 9. COMPLIANCE & SAFETY -->
<section class="aitsc-section aitsc-section--compliance">
    <div class="aitsc-container">
        <div class="aitsc-section__header">
            <h2 class="aitsc-section__title">Compliance & Warranty</h2>
            <p class="aitsc-section__subtitle">Peace of mind with comprehensive coverage</p>
        </div>

        <div class="aitsc-grid aitsc-grid--2-col">
            <!-- Warranty -->
            <div class="aitsc-compliance-card">
                <div class="aitsc-compliance-card__icon">
                    <span class="material-symbols-outlined">verified_user</span>
                </div>
                <h3>12-Month Warranty</h3>
                <p>All components covered with 12-month warranty from purchase date. Return-to-base parts replacement
                    with customer-paid shipping.</p>
                <ul class="aitsc-compliance-list">
                    <li>Comprehensive component coverage</li>
                    <li>Return-to-base replacement service</li>
                    <li>Serial number verification required</li>
                    <li>RMA (Return Merchandise Authorization) mandatory</li>
                </ul>
            </div>

            <!-- ACL Compliance -->
            <div class="aitsc-compliance-card">
                <div class="aitsc-compliance-card__icon">
                    <span class="material-symbols-outlined">gavel</span>
                </div>
                <h3>Australian Consumer Law</h3>
                <p>Our goods come with guarantees that cannot be excluded under the Australian Consumer Law (ACL). You
                    are entitled to a replacement or refund for major failures.</p>
                <ul class="aitsc-compliance-list">
                    <li>ACL consumer guarantees apply</li>
                    <li>Replacement for major failures</li>
                    <li>Refund for significant non-compliance</li>
                    <li>Limited to purchase price liability</li>
                </ul>
            </div>

            <!-- Claims Process -->
            <div class="aitsc-compliance-card">
                <div class="aitsc-compliance-card__icon">
                    <span class="material-symbols-outlined">support_agent</span>
                </div>
                <h3>Claims Process</h3>
                <p>Contact <a href="mailto:support@aitsc.au">support@aitsc.au</a> with proof of purchase and serial
                    number. RMA required before returning any components.</p>
                <ul class="aitsc-compliance-list">
                    <li>Proof of purchase required</li>
                    <li>Serial number verification</li>
                    <li>DOA: Report within 14 days</li>
                    <li>Customer pays return shipping</li>
                </ul>
            </div>

            <!-- Installation Requirements -->
            <div class="aitsc-compliance-card">
                <div class="aitsc-compliance-card__icon">
                    <span class="material-symbols-outlined">engineering</span>
                </div>
                <h3>Installation Requirements</h3>
                <p>Ensure installation by competent personnel in accordance with AITSC documentation and applicable
                    vehicle/OEM guidance.</p>
                <ul class="aitsc-compliance-list">
                    <li>Professional installation required</li>
                    <li>Follow AITSC documentation</li>
                    <li>No hardware/software modification</li>
                    <li>No non-approved parts</li>
                </ul>
            </div>
        </div>

        <!-- Exclusions -->
        <div class="aitsc-exclusions" style="margin-top: 3rem;">
            <h4>Warranty Exclusions</h4>
            <p>The following actions void warranty:</p>
            <div class="aitsc-grid aitsc-grid--4-col">
                <div class="aitsc-exclusion-item">
                    <span class="material-symbols-outlined">block</span>
                    <p>Removal of serial/void labels</p>
                </div>
                <div class="aitsc-exclusion-item">
                    <span class="material-symbols-outlined">block</span>
                    <p>Misuse or modification</p>
                </div>
                <div class="aitsc-exclusion-item">
                    <span class="material-symbols-outlined">block</span>
                    <p>Improper wiring</p>
                </div>
                <div class="aitsc-exclusion-item">
                    <span class="material-symbols-outlined">block</span>
                    <p>Water ingress or accidents</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 10. CTA SECTION -->
<section id="contact" class="aitsc-section aitsc-section--cta">
    <div class="aitsc-container">
        <?php
        aitsc_render_cta(array(
            'variant' => 'form',
            'title' => 'Request a Demo',
            'description' => 'See Fleet Safe Pro in action. Contact our team for a personalized demonstration of how our passenger monitoring system can enhance your fleet safety.',
            'form_id' => '', // Add Contact Form 7 ID when available
            'custom_class' => 'aitsc-cta--demo'
        ));
        ?>
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
