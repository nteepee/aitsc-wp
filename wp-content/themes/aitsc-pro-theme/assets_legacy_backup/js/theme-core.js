/**
 * Theme Core JS
 * Handles Particle Animations and Global Interactions
 */

(function ($) {
    'use strict';

    class ParticleNetwork {
        constructor(canvasId) {
            this.canvas = document.getElementById(canvasId);
            if (!this.canvas) return;

            this.ctx = this.canvas.getContext('2d');
            this.particles = [];
            this.width = window.innerWidth;
            this.height = window.innerHeight;

            // Configuration
            this.options = {
                particleColor: 'rgba(255, 255, 255, 0.5)',
                lineColor: 'rgba(255, 76, 0, 0.2)', // WorldQuant Orange tint
                particleAmount: 80, // Number of particles
                defaultSpeed: 0.5,
                variantSpeed: 1,
                linkRadius: 150 // Distance to connect particles
            };

            this.init();
        }

        init() {
            this.resize();
            this.createParticles();
            this.animate();

            // Event Listeners
            window.addEventListener('resize', () => this.resize());
        }

        resize() {
            this.width = window.innerWidth;
            this.height = window.innerHeight;
            this.canvas.width = this.width;
            this.canvas.height = this.height;
        }

        createParticles() {
            this.particles = [];
            for (let i = 0; i < this.options.particleAmount; i++) {
                this.particles.push({
                    x: Math.random() * this.width,
                    y: Math.random() * this.height,
                    speedX: (Math.random() - 0.5) * this.options.variantSpeed,
                    speedY: (Math.random() - 0.5) * this.options.variantSpeed,
                    size: Math.random() * 2 + 0.5 // Random size between 0.5 and 2.5
                });
            }
        }

        draw() {
            this.ctx.clearRect(0, 0, this.width, this.height);

            for (let i = 0; i < this.particles.length; i++) {
                let p = this.particles[i];

                // Move
                p.x += p.speedX;
                p.y += p.speedY;

                // Bounce
                if (p.x < 0 || p.x > this.width) p.speedX *= -1;
                if (p.y < 0 || p.y > this.height) p.speedY *= -1;

                // Draw Particle
                this.ctx.fillStyle = this.options.particleColor;
                this.ctx.beginPath();
                this.ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
                this.ctx.fill();

                // Draw Connections
                for (let j = i + 1; j < this.particles.length; j++) {
                    let p2 = this.particles[j];
                    let distance = Math.sqrt(Math.pow(p.x - p2.x, 2) + Math.pow(p.y - p2.y, 2));

                    if (distance < this.options.linkRadius) {
                        this.ctx.strokeStyle = this.options.lineColor;
                        this.ctx.lineWidth = 0.5;
                        this.ctx.beginPath();
                        this.ctx.moveTo(p.x, p.y);
                        this.ctx.lineTo(p2.x, p2.y);
                        this.ctx.stroke();
                    }
                }
            }
        }

        animate() {
            this.draw();
            requestAnimationFrame(() => this.animate());
        }
    }

    // Initialize on ready
    $(document).ready(function () {
        const heroParticles = new ParticleNetwork('hero-canvas');

        // Init AOS if available
        if (typeof AOS !== 'undefined') {
            AOS.init({
                once: true,
                offset: 50,
                duration: 800,
                easing: 'ease-out-cubic'
            });
        }
    });

})(jQuery);
