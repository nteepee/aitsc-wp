<?php
/**
 * Template Part: Fleet Safe Pro Hero (WorldQuant Style)
 *
 * Matches homepage and category page design with:
 * - Centered animated title
 * - Data ticker at bottom
 * - Dark theme with particle background
 */
?>

<!-- Global Background & Grid Lines -->
<?php get_template_part('template-parts/global-background'); ?>
<div class="grid-lines"></div>

<!-- HERO SECTION (WorldQuant Style) -->
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
                <p class="aitsc-hero__description mt-4 animate-fade-in delay-2" style="max-width: 900px; margin-left: auto; margin-right: auto; font-size: 1.25rem; line-height: 1.8;">
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
/* Fleet Safe Pro Hero Styles - Harrison.ai Design */
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
        max-width: 320px;
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