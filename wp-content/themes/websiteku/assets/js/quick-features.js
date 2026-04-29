/**
 * Quick Win Features
 * - Dark Mode Toggle
 * - Back to Top Button
 * 
 * @package Websiteku
 */

(function() {
    'use strict';

    // ========== Dark Mode Toggle ==========
    const darkModeKey = 'websiteku_darkmode';
    
    function createDarkModeToggle() {
        // Create toggle button
        const toggle = document.createElement('button');
        toggle.className = 'dark-mode-toggle';
        toggle.setAttribute('aria-label', 'Toggle Dark Mode');
        toggle.innerHTML = '<i class="fas fa-moon"></i>';
        document.body.appendChild(toggle);

        // Check saved preference
        const savedMode = localStorage.getItem(darkModeKey);
        if (savedMode === 'dark' || (!savedMode && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            enableDarkMode();
        }

        // Toggle event
        toggle.addEventListener('click', function() {
            if (document.body.classList.contains('dark-mode')) {
                disableDarkMode();
            } else {
                enableDarkMode();
            }
        });
    }

    function enableDarkMode() {
        document.body.classList.add('dark-mode');
        document.querySelector('.dark-mode-toggle').innerHTML = '<i class="fas fa-sun"></i>';
        localStorage.setItem(darkModeKey, 'dark');
    }

    function disableDarkMode() {
        document.body.classList.remove('dark-mode');
        document.querySelector('.dark-mode-toggle').innerHTML = '<i class="fas fa-moon"></i>';
        localStorage.setItem(darkModeKey, 'light');
    }

    // ========== Back to Top Button ==========
    function createBackToTop() {
        // Create button
        const btn = document.createElement('button');
        btn.className = 'back-to-top';
        btn.setAttribute('aria-label', 'Back to Top');
        btn.innerHTML = '<i class="fas fa-chevron-up"></i>';
        document.body.appendChild(btn);

        // Show/hide on scroll
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                btn.classList.add('visible');
            } else {
                btn.classList.remove('visible');
            }
        });

        // Scroll to top on click
        btn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // ========== Initialize ==========
    document.addEventListener('DOMContentLoaded', function() {
        createDarkModeToggle();
        createBackToTop();
    });

})();
