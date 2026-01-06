/**
 * AITSC Particle Network System
 * WorldQuant-inspired particle background with connections
 *
 * @package AITSC_Pro_Theme
 * @since 3.0.2
 */

class AITSCParticleNetwork {
    constructor(options = {}) {
        // Configuration - Harrison AI styled (Clean, Network, Subtle)
        this.config = {
            particleCount: options.particleCount || 100, // Higher count for network effect
            connectionDistance: options.connectionDistance || 150,
            particleSpeed: options.particleSpeed || 0.2, // Slower, more fluid
            colors: {
                primary: options.primaryColor || '#1863F7',
                secondary: options.secondaryColor || '#1841C5',
                accent: options.accentColor || '#2222A0'
            },
            opacity: {
                particle: 0.6,
                connection: 0.15 // Very subtle connections
            },
            mouse: {
                enabled: true,
                radius: 200,
                repel: false // Gentle attraction or just subtle influence
            }
        };

        // Canvas setup
        this.canvas = document.createElement('canvas');
        this.canvas.id = 'aitsc-particle-canvas';
        this.canvas.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;z-index:1;pointer-events:none;';
        this.ctx = this.canvas.getContext('2d');

        // Particles array
        this.particles = [];
        this.mouse = { x: null, y: null };

        // Animation frame ID
        this.animationId = null;

        // Debounced resize
        this.resizeTimeout = null;

        this.init();
    }

    init() {
        // Insert canvas before global-background if exists, else at body start
        const globalBg = document.querySelector('.global-background');
        if (globalBg) {
            globalBg.parentNode.insertBefore(this.canvas, globalBg.nextSibling);
        } else {
            document.body.insertBefore(this.canvas, document.body.firstChild);
        }

        // Set canvas size
        this.resizeCanvas();

        // Create particles
        this.createParticles();

        // Event listeners
        window.addEventListener('resize', () => this.handleResize());

        if (this.config.mouse.enabled) {
            document.addEventListener('mousemove', (e) => this.handleMouseMove(e));
            document.addEventListener('mouseleave', () => this.handleMouseLeave());
        }

        // Start animation
        this.animate();
    }

    resizeCanvas() {
        this.canvas.width = window.innerWidth;
        this.canvas.height = window.innerHeight;
    }

    createParticles() {
        this.particles = [];

        // Adjust particle count based on viewport size
        const viewportArea = window.innerWidth * window.innerHeight;
        const isMobile = window.innerWidth < 768;
        const baseCount = isMobile ? 20 : 40; // Reduced from 100/40 (User requested "Lesser")
        const particleCount = Math.min(
            baseCount,
            Math.floor(viewportArea / 25000) // Lower density
        );

        for (let i = 0; i < particleCount; i++) {
            this.particles.push({
                x: Math.random() * this.canvas.width,
                y: Math.random() * this.canvas.height,
                vx: (Math.random() - 0.5) * this.config.particleSpeed,
                vy: (Math.random() - 0.5) * this.config.particleSpeed,
                size: Math.random() * 4 + 3, // Bigger size: 3-7px (User requested "Bigger")
                color: this.getRandomColor(),
                // No rotation needed for circles
            });
        }
    }

    getRandomColor() {
        const colors = [
            this.config.colors.primary,
            this.config.colors.secondary,
            this.config.colors.accent
        ];
        return colors[Math.floor(Math.random() * colors.length)];
    }

    handleResize() {
        clearTimeout(this.resizeTimeout);
        this.resizeTimeout = setTimeout(() => {
            this.resizeCanvas();
            this.createParticles();
        }, 250);
    }

    handleMouseMove(e) {
        this.mouse.x = e.clientX;
        this.mouse.y = e.clientY;
    }

    handleMouseLeave() {
        this.mouse.x = null;
        this.mouse.y = null;
    }

    updateParticles() {
        this.particles.forEach(particle => {
            // Update position
            particle.x += particle.vx;
            particle.y += particle.vy;

            // Boundary collision (bounce instead of wrap for a contained feel, or wrap? Let's stick to wrap for continuous flow)
            // Actually, for a "network" feel, wrapping works well.
            if (particle.x < 0) particle.x = this.canvas.width;
            if (particle.x > this.canvas.width) particle.x = 0;
            if (particle.y < 0) particle.y = this.canvas.height;
            if (particle.y > this.canvas.height) particle.y = 0;

            // Mouse interaction (gentle attraction)
            if (this.mouse.x !== null && this.mouse.y !== null) {
                const dx = this.mouse.x - particle.x;
                const dy = this.mouse.y - particle.y;
                const distance = Math.sqrt(dx * dx + dy * dy);

                if (distance < this.config.mouse.radius) {
                    const force = (this.config.mouse.radius - distance) / this.config.mouse.radius;
                    const angle = Math.atan2(dy, dx);

                    // Gentle attraction
                    const attractionStrength = 0.05;
                    particle.vx += Math.cos(angle) * force * attractionStrength;
                    particle.vy += Math.sin(angle) * force * attractionStrength;

                    // Damping to prevent out of control speed
                    particle.vx *= 0.99;
                    particle.vy *= 0.99;
                }
            }
        });
    }

    drawParticles() {
        this.particles.forEach(particle => {
            // Draw square particles instead of circles
            this.ctx.fillStyle = this.hexToRgba(particle.color, this.config.opacity.particle);
            this.ctx.fillRect(
                particle.x - particle.size / 2,
                particle.y - particle.size / 2,
                particle.size,
                particle.size
            );
        });
    }

    drawConnections() {
        const isMobile = window.innerWidth < 768;
        const connectionDistance = isMobile ? 100 : this.config.connectionDistance;

        for (let i = 0; i < this.particles.length; i++) {
            for (let j = i + 1; j < this.particles.length; j++) {
                const p1 = this.particles[i];
                const p2 = this.particles[j];

                const dx = p1.x - p2.x;
                const dy = p1.y - p2.y;
                const distance = Math.sqrt(dx * dx + dy * dy);

                if (distance < connectionDistance) {
                    // Opacity based on distance
                    const opacity = (1 - distance / connectionDistance) * this.config.opacity.connection;
                    this.ctx.beginPath();
                    this.ctx.strokeStyle = this.hexToRgba(this.config.colors.primary, opacity); // Use primary color for connections
                    this.ctx.lineWidth = 0.5;
                    this.ctx.moveTo(p1.x, p1.y);
                    this.ctx.lineTo(p2.x, p2.y);
                    this.ctx.stroke();
                }
            }
        }
    }

    hexToRgba(hex, alpha) {
        const r = parseInt(hex.slice(1, 3), 16);
        const g = parseInt(hex.slice(3, 5), 16);
        const b = parseInt(hex.slice(5, 7), 16);
        return `rgba(${r}, ${g}, ${b}, ${alpha})`;
    }

    animate() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

        this.updateParticles();
        this.drawConnections(); // Draw connections first so particles are on top
        this.drawParticles();

        this.animationId = requestAnimationFrame(() => this.animate());
    }

    destroy() {
        if (this.animationId) {
            cancelAnimationFrame(this.animationId);
        }
        window.removeEventListener('resize', this.handleResize);
        document.removeEventListener('mousemove', this.handleMouseMove);
        document.removeEventListener('mouseleave', this.handleMouseLeave);
        if (this.canvas && this.canvas.parentNode) {
            this.canvas.parentNode.removeChild(this.canvas);
        }
    }
}

// Auto-initialize on DOM ready (HOMEPAGE ONLY)
document.addEventListener('DOMContentLoaded', function () {
    // Only run on homepage
    const isHomepage = document.body.classList.contains('home');

    if (!isHomepage) {
        return; // Exit early if not homepage
    }

    // Check if user prefers reduced motion
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (!prefersReducedMotion) {
        // Initialize particle system
        window.aitscParticles = new AITSCParticleNetwork({
            particleCount: 70,
            connectionDistance: 120,
            particleSpeed: 0.3,
            primaryColor: '#1863F7',    // Manual vibrant blue (img-003.png)
            secondaryColor: '#1841C5', // Manual royal blue (img-001.png)
            accentColor: '#2222A0'       // Manual dark blue (img-002.png)
        });
    } else {
        // Fallback: Add CSS class for static gradient background
        document.body.classList.add('reduced-motion-bg');
    }
});
