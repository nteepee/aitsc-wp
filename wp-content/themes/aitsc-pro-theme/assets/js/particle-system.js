/**
 * AITSC Particle Network System
 * WorldQuant-inspired particle background with connections
 *
 * @package AITSC_Pro_Theme
 * @since 3.0.2
 */

class AITSCParticleNetwork {
    constructor(options = {}) {
        // Configuration - Updated to match Fleet Safe Pro manual colors
        this.config = {
            particleCount: options.particleCount || 70,
            connectionDistance: options.connectionDistance || 120,
            particleSpeed: options.particleSpeed || 0.3,
            colors: {
                primary: options.primaryColor || '#1863F7',    // Manual vibrant blue (img-003.png)
                secondary: options.secondaryColor || '#1841C5', // Manual royal blue (img-001.png)
                accent: options.accentColor || '#2222A0'       // Manual dark blue (img-002.png)
            },
            opacity: {
                particle: 0.8,
                connection: 0.4
            },
            mouse: {
                enabled: true,
                radius: 150,
                repel: false
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

        // Adjust particle count based on viewport size (reduce on mobile)
        const viewportArea = window.innerWidth * window.innerHeight;
        const isMobile = window.innerWidth < 768;
        const baseCount = isMobile ? 30 : this.config.particleCount;
        const particleCount = Math.min(
            baseCount,
            Math.floor(viewportArea / 15000) // ~1 particle per 15000px²
        );

        for (let i = 0; i < particleCount; i++) {
            this.particles.push({
                x: Math.random() * this.canvas.width,
                y: Math.random() * this.canvas.height,
                vx: (Math.random() - 0.5) * this.config.particleSpeed,
                vy: (Math.random() - 0.5) * this.config.particleSpeed,
                size: Math.random() * 3 + 2, // Mini-square size: 2-5px
                color: this.getRandomColor(),
                rotation: Math.random() * Math.PI * 2 // Random rotation
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

            // Boundary collision (wrap around)
            if (particle.x < 0) particle.x = this.canvas.width;
            if (particle.x > this.canvas.width) particle.x = 0;
            if (particle.y < 0) particle.y = this.canvas.height;
            if (particle.y > this.canvas.height) particle.y = 0;

            // Mouse interaction (repel or attract)
            if (this.mouse.x !== null && this.mouse.y !== null) {
                const dx = this.mouse.x - particle.x;
                const dy = this.mouse.y - particle.y;
                const distance = Math.sqrt(dx * dx + dy * dy);

                if (distance < this.config.mouse.radius) {
                    const force = (this.config.mouse.radius - distance) / this.config.mouse.radius;
                    const angle = Math.atan2(dy, dx);

                    if (this.config.mouse.repel) {
                        particle.x -= Math.cos(angle) * force * 2;
                        particle.y -= Math.sin(angle) * force * 2;
                    } else {
                        particle.x += Math.cos(angle) * force * 0.5;
                        particle.y += Math.sin(angle) * force * 0.5;
                    }
                }
            }
        });
    }

    drawParticles() {
        this.particles.forEach(particle => {
            this.ctx.save();
            this.ctx.translate(particle.x, particle.y);
            this.ctx.rotate(particle.rotation);

            // Draw mini-square instead of circle
            this.ctx.fillStyle = this.hexToRgba(particle.color, this.config.opacity.particle);
            this.ctx.fillRect(-particle.size / 2, -particle.size / 2, particle.size, particle.size);

            this.ctx.restore();

            // Slowly rotate squares for subtle animation
            particle.rotation += 0.001;
        });
    }

    drawConnections() {
        // Adjust connection distance on mobile
        const isMobile = window.innerWidth < 768;
        const connectionDistance = isMobile ? 80 : this.config.connectionDistance;

        for (let i = 0; i < this.particles.length; i++) {
            for (let j = i + 1; j < this.particles.length; j++) {
                const p1 = this.particles[i];
                const p2 = this.particles[j];

                const dx = p1.x - p2.x;
                const dy = p1.y - p2.y;
                const distance = Math.sqrt(dx * dx + dy * dy);

                if (distance < connectionDistance) {
                    const opacity = (1 - distance / connectionDistance) * this.config.opacity.connection;

                    this.ctx.beginPath();
                    this.ctx.strokeStyle = this.hexToRgba(this.config.colors.primary, opacity);
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
        // Clear canvas
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

        // Update and draw (NO CONNECTIONS - just floating squares)
        this.updateParticles();
        this.drawParticles();

        // Continue animation
        this.animationId = requestAnimationFrame(() => this.animate());
    }

    destroy() {
        // Stop animation
        if (this.animationId) {
            cancelAnimationFrame(this.animationId);
        }

        // Remove event listeners
        window.removeEventListener('resize', this.handleResize);
        document.removeEventListener('mousemove', this.handleMouseMove);
        document.removeEventListener('mouseleave', this.handleMouseLeave);

        // Remove canvas
        if (this.canvas && this.canvas.parentNode) {
            this.canvas.parentNode.removeChild(this.canvas);
        }
    }
}

// Auto-initialize on DOM ready
document.addEventListener('DOMContentLoaded', function() {
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
