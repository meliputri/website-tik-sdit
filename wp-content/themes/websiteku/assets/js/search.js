/**
 * Materi Search Functionality
 * 
 * @package Websiteku
 */

(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('materi-search-input');
        const searchClear = document.getElementById('materi-search-clear');
        const searchCount = document.getElementById('materi-search-count');
        const materiGrid = document.getElementById('materi-grid');
        
        if (!searchInput || !materiGrid) return;

        const materiCards = materiGrid.querySelectorAll('.materi-card');
        
        // Search function
        function filterMateri() {
            const query = searchInput.value.toLowerCase().trim();
            let visibleCount = 0;
            
            // Show/hide clear button
            if (query.length > 0) {
                searchClear.style.display = 'flex';
            } else {
                searchClear.style.display = 'none';
            }
            
            // Filter cards
            materiCards.forEach(function(card) {
                const title = card.querySelector('h3').textContent.toLowerCase();
                const description = card.querySelector('p').textContent.toLowerCase();
                const badge = card.querySelector('.materi-card-badge').textContent.toLowerCase();
                
                const matches = title.includes(query) || 
                               description.includes(query) || 
                               badge.includes(query);
                
                if (matches || query === '') {
                    card.style.display = '';
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                    card.classList.add('hidden');
                }
            });
            
            // Update count
            if (query.length > 0) {
                searchCount.textContent = `${visibleCount} materi ditemukan`;
                searchCount.style.display = 'block';
            } else {
                searchCount.style.display = 'none';
            }
            
            // Show "no results" message
            let noResults = materiGrid.querySelector('.no-results');
            if (visibleCount === 0 && query.length > 0) {
                if (!noResults) {
                    noResults = document.createElement('div');
                    noResults.className = 'no-results';
                    noResults.innerHTML = `
                        <i class="fas fa-search"></i>
                        <p>Tidak ada materi yang cocok dengan "<strong>${query}</strong>"</p>
                        <button onclick="document.getElementById('materi-search-input').value=''; document.getElementById('materi-search-input').dispatchEvent(new Event('input'));">Reset Pencarian</button>
                    `;
                    materiGrid.appendChild(noResults);
                }
            } else if (noResults) {
                noResults.remove();
            }
        }
        
        // Event listeners
        searchInput.addEventListener('input', filterMateri);
        
        searchClear.addEventListener('click', function() {
            searchInput.value = '';
            filterMateri();
            searchInput.focus();
        });
        
        // Keyboard shortcut - press "/" to focus search
        document.addEventListener('keydown', function(e) {
            if (e.key === '/' && document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA') {
                e.preventDefault();
                searchInput.focus();
            }
            // ESC to clear search
            if (e.key === 'Escape' && document.activeElement === searchInput) {
                searchInput.value = '';
                filterMateri();
                searchInput.blur();
            }
        });
    });
})();
