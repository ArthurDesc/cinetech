class DotPattern {
    constructor(options = {}) {
        this.dotSize = options.dotSize || 4;
        this.dotSpacing = options.dotSpacing || 30;
        this.dotColor = options.dotColor || 'rgba(100, 100, 255, 0.8)';
        this.glowColor = options.glowColor || 'rgba(100, 100, 255, 0.8)';
        this.waveIntensity = options.waveIntensity || 30;
        this.waveRadius = options.waveRadius || 200;
        this.canvas = null;
        this.ctx = null;
        this.mousePos = { x: 0, y: 0 };
        this.time = 0;
    }

    init(containerId) {
        // Create canvas
        this.canvas = document.createElement('canvas');
        this.ctx = this.canvas.getContext('2d');
        this.canvas.className = 'absolute inset-0 w-full h-full bg-black/50 mix-blend-multiply';
        
        // Get container and append canvas
        const container = document.getElementById(containerId);
        if (!container) return;
        container.appendChild(this.canvas);

        // Set initial size
        this.resize();

        // Event listeners
        window.addEventListener('resize', () => this.resize());
        window.addEventListener('mousemove', (e) => this.handleMouseMove(e));

        // Start animation
        this.animate();
    }

    resize() {
        if (!this.canvas) return;
        this.canvas.width = window.innerWidth;
        this.canvas.height = window.innerHeight;
    }

    handleMouseMove(event) {
        const rect = this.canvas.getBoundingClientRect();
        this.mousePos = {
            x: event.clientX - rect.left,
            y: event.clientY - rect.top
        };
    }

    drawDots() {
        const { width, height } = this.canvas;
        this.ctx.clearRect(0, 0, width, height);

        const cols = Math.ceil(width / this.dotSpacing);
        const rows = Math.ceil(height / this.dotSpacing);

        for (let i = 0; i < cols; i++) {
            for (let j = 0; j < rows; j++) {
                let x = i * this.dotSpacing;
                let y = j * this.dotSpacing;

                const distanceX = x - this.mousePos.x;
                const distanceY = y - this.mousePos.y;
                const distance = Math.sqrt(distanceX * distanceX + distanceY * distanceY);

                if (distance < this.waveRadius) {
                    const waveStrength = Math.pow(1 - distance / this.waveRadius, 2);
                    const angle = Math.atan2(distanceY, distanceX);
                    const waveOffset = Math.sin(distance * 0.05 - this.time * 0.005) * this.waveIntensity * waveStrength;
                    
                    x += Math.cos(angle) * waveOffset;
                    y += Math.sin(angle) * waveOffset;

                    // Glow effect
                    const gradient = this.ctx.createRadialGradient(x, y, 0, x, y, this.dotSize * 2);
                    gradient.addColorStop(0, this.glowColor);
                    gradient.addColorStop(1, 'rgba(100, 100, 255, 0)');
                    this.ctx.fillStyle = gradient;
                } else {
                    this.ctx.fillStyle = this.dotColor;
                }

                this.ctx.beginPath();
                this.ctx.arc(x, y, this.dotSize / 2, 0, Math.PI * 2);
                this.ctx.fill();
            }
        }
    }

    animate() {
        this.time++;
        this.drawDots();
        requestAnimationFrame(() => this.animate());
    }
} 