/**
 * Materi Search — terintegrasi filter kelas
 *
 * @package Websiteku
 */

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    var searchInput = document.getElementById('materi-search-input');
    var searchClear = document.getElementById('materi-search-clear');

    if (!searchInput) return;

    function runFilter() {
      if (typeof window.websitekuFilterMateri === 'function') {
        window.websitekuFilterMateri();
        return;
      }
    }

    searchInput.addEventListener('input', function () {
      if (searchClear) {
        searchClear.style.display = searchInput.value.length > 0 ? 'flex' : 'none';
      }
      runFilter();
    });

    if (searchClear) {
      searchClear.addEventListener('click', function () {
        searchInput.value = '';
        searchClear.style.display = 'none';
        runFilter();
        searchInput.focus();
      });
    }

    document.addEventListener('keydown', function (e) {
      if (e.key === '/' && document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA') {
        e.preventDefault();
        searchInput.focus();
      }
      if (e.key === 'Escape' && document.activeElement === searchInput) {
        searchInput.value = '';
        if (searchClear) searchClear.style.display = 'none';
        runFilter();
        searchInput.blur();
      }
    });
  });
})();
