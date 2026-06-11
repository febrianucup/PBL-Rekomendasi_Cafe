import './bootstrap';

// import { Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm'; 
// Livewire.start();

document.addEventListener('DOMContentLoaded', () => {
    // Check if browser supports View Transition API (cross-document navigation: auto)
    const supportsViewTransitions = 'PageRevealEvent' in window || (typeof document.startViewTransition === 'function');

    if (supportsViewTransitions) {
        // Native View Transitions will handle page animations natively.
        // We do not intercept link clicks or delay standard navigation.
        return;
    }

    // JS-based Fallback for Firefox, Safari, and older browsers
    document.body.classList.add('js-fallback');

    // Trigger page slide/fade-in
    requestAnimationFrame(() => {
        document.body.classList.add('page-loaded');
    });

    // Intercept clicks on links for fade-out transition
    document.querySelectorAll('a').forEach(link => {
        if (
            link.target === '_blank' ||
            link.getAttribute('href') === null ||
            link.getAttribute('href').startsWith('#') ||
            link.getAttribute('href').startsWith('javascript:') ||
            link.hasAttribute('download')
        ) {
            return;
        }

        const href = link.getAttribute('href');
        const isInternal = href.startsWith('/') || href.startsWith(window.location.origin);

        if (isInternal) {
            link.addEventListener('click', e => {
                // Ignore modifier clicks (Ctrl+click, Cmd+click, Shift+click)
                if (e.metaKey || e.ctrlKey || e.shiftKey || e.button !== 0) {
                    return;
                }

                e.preventDefault();
                document.body.classList.remove('page-loaded');
                document.body.classList.add('page-fade-out');

                setTimeout(() => {
                    window.location.href = href;
                }, 250); // Matches transition duration (250ms delay)
            });
        }
    });
});

window.addEventListener('pageshow', (event) => {
    // Ensure back-forward cache pages fade in properly
    if (event.persisted) {
        const supportsViewTransitions = 'PageRevealEvent' in window || (typeof document.startViewTransition === 'function');
        if (!supportsViewTransitions) {
            document.body.classList.remove('page-fade-out');
            document.body.classList.add('page-loaded');
        }
    }
});