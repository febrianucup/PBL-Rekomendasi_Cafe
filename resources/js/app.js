import './bootstrap';

// import { Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm'; 
// Livewire.start();

document.addEventListener('DOMContentLoaded', () => {
    // Fade-in page
    document.body.classList.add('page-loaded');

    // Intercept clicks on links for fade-out transition
    document.querySelectorAll('a').forEach(link => {
        // Skip if link opens in new tab, has javascript:, starts with #, or has download attribute
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
        // Check if it's an internal link
        const isInternal = href.startsWith('/') || href.startsWith(window.location.origin);

        if (isInternal) {
            link.addEventListener('click', e => {
                // If it is a modifier click (Ctrl+click, Cmd+click, Shift+click), let the browser handle it (opens new tab/window)
                if (e.metaKey || e.ctrlKey || e.shiftKey || e.button !== 0) {
                    return;
                }

                e.preventDefault();
                document.body.classList.remove('page-loaded');
                document.body.classList.add('page-fade-out');

                setTimeout(() => {
                    window.location.href = href;
                }, 300); // matches CSS transition duration (0.3s)
            });
        }
    });
});

window.addEventListener('pageshow', (event) => {
    if (event.persisted) {
        document.body.classList.remove('page-fade-out');
        document.body.classList.add('page-loaded');
    }
});