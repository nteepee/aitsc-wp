<?php
/**
 * Global Background Template Part
 * 
 * Renders the global tech background (particles, matrix, geometry)
 * used across the entire site for visual consistency.
 *
 * @package AITSC_Pro_Theme
 */
?>

<div class="global-tech-background">
    <!--WorldQuant-Style Particle Canvas -->
    <canvas id="wq-particle-canvas"></canvas>

    <!-- Pure CSS Background Effects -->
    <div class="hero-particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <div class="hero-geometry">
        <div class="geo-shape"></div>
        <div class="geo-shape"></div>
        <div class="geo-shape"></div>
    </div>

    <div class="ascii-overlay"></div>

    <div class="code-elements">
        <div class="code-line">function optimizeSafety() { return maximum; }</div>
        <div class="code-line">const compliance = 100%;</div>
        <div class="code-line">while (risk > 0) { reduce(); }</div>
        <div class="code-line">certification.active = true;</div>
    </div>

    <div class="matrix-rain">
        <div class="matrix-column">01001110</div>
        <div class="matrix-column">11010010</div>
        <div class="matrix-column">00110101</div>
        <div class="matrix-column">10101001</div>
        <div class="matrix-column">01101011</div>
        <div class="matrix-column">10010110</div>
        <div class="matrix-column">01001101</div>
        <div class="matrix-column">11010001</div>
        <div class="matrix-column">00101110</div>
    </div>

    <div class="chart-overlay">
        <div class="chart-line"></div>
    </div>
</div>

<style>
    /* Ensure the background stays behind content */
    .global-tech-background {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        pointer-events: none;
        background-color: #000;
        /* Fallback/Base */
        overflow: hidden;
    }

    /* WorldQuant Particle Canvas */
    #wq-particle-canvas {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
    }

    /* Adjust opacity for content readability on inner pages */
    body:not(.home) .global-tech-background .matrix-rain,
    body:not(.home) .global-tech-background .code-elements {
        opacity: 0.15;
        /* Dimmed on inner pages */
    }

    /* Position Code Elements */
    .code-elements {
        position: absolute;
        top: 20%;
        left: 5%;
        font-family: 'Courier New', monospace;
        color: rgba(0, 255, 0, 0.3);
        font-size: 14px;
        z-index: 0;
    }

    .matrix-rain {
        position: absolute;
        top: 0;
        right: 10%;
        display: flex;
        gap: 20px;
        z-index: 0;
    }

    .matrix-column {
        font-family: monospace;
        color: rgba(0, 255, 0, 0.2);
        writing-mode: vertical-rl;
        text-orientation: upright;
        font-size: 12px;
    }
</style>