/**
 * INTAKE - Sistema de Menú Responsive
 * JavaScript para control de sidebar colapsable y navegación móvil
 * @version 2.0
 * @author Cesar Gomez
 */

(function () {
    'use strict';

    // Configuración
    const config = {
        breakpoint: 768,
        animationDuration: 300,
        enableSwipeGestures: true,
        swipeThreshold: 50
    };

    // Elementos DOM
    let menuToggle, sidebar, overlay, body;
    let touchStartX = 0;
    let touchEndX = 0;

    /**
     * Inicialización del sistema
     */
    function inicializar() {
        crearElementosResponsive();
        configurarEventListeners();
        manejarRedimensionamiento();
        marcarMenuActivo();

        console.log('✓ Sistema de menú responsive inicializado');
    }

    /**
     * Crear elementos necesarios para responsive
     */
    function crearElementosResponsive() {
        // Botón hamburguesa
        menuToggle = document.createElement('button');
        menuToggle.className = 'menu-toggle';
        menuToggle.setAttribute('aria-label', 'Abrir menú de navegación');
        menuToggle.setAttribute('aria-expanded', 'false');
        menuToggle.innerHTML = `
            <span></span>
            <span></span>
            <span></span>
        `;
        document.body.appendChild(menuToggle);

        // Overlay
        overlay = document.createElement('div');
        overlay.className = 'menu-overlay';
        overlay.setAttribute('aria-hidden', 'true');
        document.body.appendChild(overlay);

        // Referencias
        sidebar = document.querySelector('.layout-col.menu');
        body = document.body;
    }

    /**
     * Configurar todos los event listeners
     */
    function configurarEventListeners() {
        // Click en botón hamburguesa
        menuToggle.addEventListener('click', toggleMenu);

        // Click en overlay para cerrar
        overlay.addEventListener('click', cerrarMenu);

        // Click en enlaces del menú para cerrar en móvil
        const menuLinks = sidebar.querySelectorAll('.menu-link');
        menuLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= config.breakpoint) {
                    cerrarMenu();
                }
            });
        });

        // Tecla ESC para cerrar menú
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape' && sidebar.classList.contains('active')) {
                cerrarMenu();
            }
        });

        // Redimensionamiento de ventana
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(manejarRedimensionamiento, 150);
        });

        // Gestos de swipe si están habilitados
        if (config.enableSwipeGestures) {
            configurarGestosSwipe();
        }
    }

    /**
     * Toggle del menú (abrir/cerrar)
     */
    function toggleMenu() {
        const estaAbierto = sidebar.classList.contains('active');

        if (estaAbierto) {
            cerrarMenu();
        } else {
            abrirMenu();
        }
    }

    /**
     * Abrir menú
     */
    function abrirMenu() {
        sidebar.classList.add('active');
        overlay.classList.add('active');
        menuToggle.classList.add('active');
        body.style.overflow = 'hidden'; // Prevenir scroll en body

        // Actualizar ARIA
        menuToggle.setAttribute('aria-expanded', 'true');
        overlay.setAttribute('aria-hidden', 'false');

        // Focus en primer enlace del menú para accesibilidad
        const primerLink = sidebar.querySelector('.menu-link');
        if (primerLink) {
            setTimeout(() => primerLink.focus(), config.animationDuration);
        }
    }

    /**
     * Cerrar menú
     */
    function cerrarMenu() {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
        menuToggle.classList.remove('active');
        body.style.overflow = '';

        // Actualizar ARIA
        menuToggle.setAttribute('aria-expanded', 'false');
        overlay.setAttribute('aria-hidden', 'true');

        // Devolver focus al botón hamburguesa
        menuToggle.focus();
    }

    /**
     * Manejar cambios de tamaño de ventana
     */
    function manejarRedimensionamiento() {
        const ancho = window.innerWidth;

        if (ancho > config.breakpoint) {
            // Desktop: asegurar que el menú esté visible
            cerrarMenu();
            sidebar.classList.remove('active');
            body.style.overflow = '';
        }
    }

    /**
     * Marcar enlace activo del menú según URL actual
     */
    function marcarMenuActivo() {
        const rutaActual = window.location.pathname;
        const links = sidebar.querySelectorAll('.menu-link');

        links.forEach(link => {
            const rutaLink = link.getAttribute('data-menu') || link.getAttribute('href');

            // Quitar clase active de todos
            link.classList.remove('active');

            // Comparar rutas
            if (rutaLink && (rutaActual === rutaLink || rutaActual.startsWith(rutaLink + '/'))) {
                link.classList.add('active');
            }

            // Caso especial para inicio
            if (rutaLink === '/' && rutaActual === baseUrl) {
                link.classList.add('active');
            }
        });
    }

    /**
     * Configurar gestos de swipe para abrir/cerrar menú
     */
    function configurarGestosSwipe() {
        // Touch start
        document.addEventListener(
            'touchstart',
            e => {
                touchStartX = e.changedTouches[0].screenX;
            },
            { passive: true }
        );

        // Touch end
        document.addEventListener(
            'touchend',
            e => {
                touchEndX = e.changedTouches[0].screenX;
                manejarGestoSwipe();
            },
            { passive: true }
        );
    }

    /**
     * Procesar gesto de swipe
     */
    function manejarGestoSwipe() {
        const diferencia = touchEndX - touchStartX;
        const estaAbierto = sidebar.classList.contains('active');

        // Swipe derecha (abrir) desde el borde izquierdo
        if (diferencia > config.swipeThreshold && touchStartX < 50 && !estaAbierto) {
            abrirMenu();
        }

        // Swipe izquierda (cerrar)
        if (diferencia < -config.swipeThreshold && estaAbierto) {
            cerrarMenu();
        }
    }

    /**
     * Función pública para abrir menú (si se necesita desde fuera)
     */
    window.abrirMenuSidebar = abrirMenu;

    /**
     * Función pública para cerrar menú (si se necesita desde fuera)
     */
    window.cerrarMenuSidebar = cerrarMenu;

    /**
     * Iniciar cuando el DOM esté listo
     */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', inicializar);
    } else {
        inicializar();
    }
})();

/**
 * Mejora adicional: Smooth scroll para anclas
 */
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href !== '#' && href !== '') {
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    });
});

/**
 * Utilidad: Detectar si es dispositivo táctil
 */
function esDispositivoTactil() {
    return 'ontouchstart' in window || navigator.maxTouchPoints > 0;
}

if (esDispositivoTactil()) {
    document.body.classList.add('touch-device');
} else {
    document.body.classList.add('no-touch-device');
}
