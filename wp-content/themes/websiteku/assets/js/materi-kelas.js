/**
 * Filter materi per kelas, TP info, modal video
 * @package Websiteku
 */

(function () {
  'use strict';

  function getEmbedHtml(url) {
    if (!url) return '';
    var yt = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/);
    if (yt) {
      return '<div class="video-embed-wrap"><iframe src="https://www.youtube.com/embed/' + yt[1] + '?rel=0" allowfullscreen loading="lazy"></iframe></div>';
    }
    var vimeo = url.match(/vimeo\.com\/(\d+)/);
    if (vimeo) {
      return '<div class="video-embed-wrap"><iframe src="https://player.vimeo.com/video/' + vimeo[1] + '" allowfullscreen loading="lazy"></iframe></div>';
    }
    return '';
  }

  function filterMateri() {
    var activeKelas = document.querySelector('.kelas-tab.active');
    var kelas = activeKelas ? activeKelas.getAttribute('data-kelas') : 'all';
    var searchInput = document.getElementById('materi-search-input');
    var query = searchInput ? searchInput.value.toLowerCase().trim() : '';
    var grid = document.getElementById('materi-grid');
    if (!grid) return;

    var cards = grid.querySelectorAll('.materi-card');
    var visible = 0;

    cards.forEach(function (card) {
      var cardKelas = card.getAttribute('data-kelas') || '';
      var title = (card.getAttribute('data-title') || card.querySelector('h3').textContent).toLowerCase();
      var tp = (card.getAttribute('data-tp') || '').toLowerCase();
      var text = card.textContent.toLowerCase();

      var kelasMatch = kelas === 'all' || cardKelas === kelas;
      var searchMatch = !query || title.includes(query) || tp.includes(query) || text.includes(query);

      if (kelasMatch && searchMatch) {
        card.style.display = '';
        visible++;
      } else {
        card.style.display = 'none';
      }
    });

    var countEl = document.getElementById('materi-search-count');
    if (countEl) {
      if (query || kelas !== 'all') {
        countEl.textContent = visible + ' materi ditampilkan';
        countEl.style.display = 'block';
      } else {
        countEl.style.display = 'none';
      }
    }
  }

  function updateTpKelasInfo(kelas) {
    var box = document.getElementById('materi-tp-kelas-info');
    if (!box || typeof websitekuMateriContext === 'undefined') return;

    if (kelas === 'all' || !websitekuMateriContext.tp_referensi || !websitekuMateriContext.tp_referensi[kelas]) {
      box.classList.remove('visible');
      box.innerHTML = '';
      return;
    }

    var list = websitekuMateriContext.tp_referensi[kelas];
    var html = '<h4><i class="fas fa-bullseye"></i> TP Informatika/TIK — Kelas ' + kelas + ' (referensi)</h4><ul>';
    list.forEach(function (tp) {
      html += '<li>' + tp + '</li>';
    });
    html += '</ul>';
    box.innerHTML = html;
    box.classList.add('visible');
  }

  function initKelasTabs() {
    var tabs = document.querySelectorAll('.kelas-tab');
    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        tabs.forEach(function (t) { t.classList.remove('active'); });
        tab.classList.add('active');
        var kelas = tab.getAttribute('data-kelas');
        updateTpKelasInfo(kelas);
        try {
          localStorage.setItem('websiteku_kelas', kelas);
        } catch (e) {}
        filterMateri();
      });
    });

    try {
      var saved = localStorage.getItem('websiteku_kelas');
      if (saved) {
        var match = document.querySelector('.kelas-tab[data-kelas="' + saved + '"]');
        if (match) {
          tabs.forEach(function (t) { t.classList.remove('active'); });
          match.classList.add('active');
          updateTpKelasInfo(saved);
        }
      }
    } catch (e) {}
  }

  function initVideoModal() {
    var modal = document.getElementById('materi-video-modal');
    if (!modal) return;

    var embedEl = document.getElementById('materi-video-modal-embed');
    var titleEl = document.getElementById('materi-video-modal-title');
    var backdrop = modal.querySelector('.materi-video-modal-backdrop');
    var closeBtn = modal.querySelector('.materi-video-close');

    function closeModal() {
      modal.classList.remove('active');
      modal.setAttribute('aria-hidden', 'true');
      if (embedEl) embedEl.innerHTML = '';
    }

    document.addEventListener('click', function (e) {
      var btn = e.target.closest('.btn-video-materi');
      if (!btn) return;
      var url = btn.getAttribute('data-video-url');
      var title = btn.getAttribute('data-title') || 'Video Pembelajaran';
      var html = getEmbedHtml(url);
      if (!html) return;
      if (titleEl) titleEl.textContent = title;
      if (embedEl) embedEl.innerHTML = html;
      modal.classList.add('active');
      modal.setAttribute('aria-hidden', 'false');
    });

    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (backdrop) backdrop.addEventListener('click', closeModal);
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') closeModal();
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    initKelasTabs();
    initVideoModal();

    var searchInput = document.getElementById('materi-search-input');
    if (searchInput) {
      searchInput.addEventListener('input', filterMateri);
    }

    var active = document.querySelector('.kelas-tab.active');
    if (active) {
      updateTpKelasInfo(active.getAttribute('data-kelas'));
    }
    filterMateri();
  });

  window.websitekuFilterMateri = filterMateri;
})();
