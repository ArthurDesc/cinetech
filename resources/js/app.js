import './bootstrap';
import Alpine from 'alpinejs';

// Définition du composant carousel
Alpine.data('carousel', () => ({
    embla: null,
    currentSlide: 0,
    slides: [],

    async init() {
        try {
            const emblaModule = await import('embla-carousel');
            this.embla = emblaModule.default(this.$refs.viewport, {
                loop: true,
                skipSnaps: false,
                dragFree: false
            });

            // Initialiser les slides
            this.slides = [...Array(5)];

            // Mettre à jour le slide actif
            this.embla.on('select', () => {
                this.currentSlide = this.embla.selectedScrollSnap();
            });

            // Démarrer l'autoplay
            const autoplay = setInterval(() => {
                if (!this.embla.canScrollNext()) {
                    this.embla.scrollTo(0);
                } else {
                    this.embla.scrollNext();
                }
            }, 5000);

            // Nettoyer l'autoplay quand le composant est détruit
            this.$cleanup = () => clearInterval(autoplay);
        } catch (error) {
            console.error('Erreur lors du chargement d\'Embla:', error);
        }
    },

    scrollPrev() {
        if (this.embla) this.embla.scrollPrev();
    },

    scrollNext() {
        if (this.embla) this.embla.scrollNext();
    },

    scrollTo(index) {
        if (this.embla) this.embla.scrollTo(index);
    }
}));

window.Alpine = Alpine;
Alpine.start();

// Theme toggle
const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
const themeToggleBtn = document.getElementById('theme-toggle');

// Vérifier si les éléments existent avant d'accéder à leurs propriétés
if (themeToggleDarkIcon && themeToggleLightIcon && themeToggleBtn) {
    // Change the icons inside the button based on previous settings
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        themeToggleLightIcon.classList.remove('hidden');
    } else {
        themeToggleDarkIcon.classList.remove('hidden');
    }

    themeToggleBtn.addEventListener('click', function() {
        // toggle icons
        themeToggleDarkIcon.classList.toggle('hidden');
        themeToggleLightIcon.classList.toggle('hidden');

        // if is set in localStorage
        if (localStorage.getItem('color-theme')) {
            if (localStorage.getItem('color-theme') === 'light') {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            }
        } else {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        }
    });
}
