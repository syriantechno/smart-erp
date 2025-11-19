// Lazy Loading Performance Optimization
document.addEventListener('DOMContentLoaded', function() {
    
    // Lazy load images
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });

    images.forEach(img => imageObserver.observe(img));

    // Lazy load DataTables
    const tables = document.querySelectorAll('[data-lazy-table]');
    const tableObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const table = entry.target;
                const initFunction = table.dataset.lazyTable;
                if (window[initFunction] && typeof window[initFunction] === 'function') {
                    window[initFunction]();
                    tableObserver.unobserve(table);
                }
            }
        });
    });

    tables.forEach(table => tableObserver.observe(table));

    // Preload critical resources
    const criticalResources = [
        '/vendor/lucide/lucide.umd.min.js',
        '/build/assets/app.css'
    ];

    criticalResources.forEach(resource => {
        const link = document.createElement('link');
        link.rel = 'preload';
        link.href = resource;
        link.as = resource.endsWith('.js') ? 'script' : 'style';
        document.head.appendChild(link);
    });

    // Optimize scroll performance
    let ticking = false;
    function updateScrollPosition() {
        // Throttle scroll events
        if (!ticking) {
            requestAnimationFrame(() => {
                // Handle scroll-based animations here
                ticking = false;
            });
            ticking = true;
        }
    }

    window.addEventListener('scroll', updateScrollPosition, { passive: true });

    console.log('✅ Performance optimizations loaded');
});
