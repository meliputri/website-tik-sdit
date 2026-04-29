/**
 * Loading & Progress System
 * 
 * @package Websiteku
 */

(function() {
    'use strict';
    
    // ========== Skeleton Loading ==========
    function createPageLoader() {
        const loaderHTML = `
            <div id="page-loader" class="page-loader">
                <div class="loader-content">
                    <div class="loader-logo">🖥️</div>
                    <div class="loader-text">Memuat...</div>
                    <div class="loader-bar">
                        <div class="loader-bar-fill"></div>
                    </div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('afterbegin', loaderHTML);
    }
    
    function hidePageLoader() {
        const loader = document.getElementById('page-loader');
        if (loader) {
            loader.classList.add('loaded');
            setTimeout(() => {
                loader.remove();
            }, 500);
        }
    }
    
    // ========== Progress System ==========
    const STORAGE_KEY = 'websiteku_progress';
    
    function getProgress() {
        const data = localStorage.getItem(STORAGE_KEY);
        return data ? JSON.parse(data) : {};
    }
    
    function saveProgress(materiId, progress) {
        const data = getProgress();
        data[materiId] = {
            progress: progress,
            lastUpdated: new Date().toISOString()
        };
        localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
    }
    
    function updateProgressFromQuiz(materiId, score, total) {
        const percentage = Math.round((score / total) * 100);
        const currentProgress = getProgress()[materiId]?.progress || 0;
        // Only update if new score is higher
        if (percentage > currentProgress) {
            saveProgress(materiId, percentage);
        }
        renderProgressBars();
    }
    
    function renderProgressBars() {
        const progressData = getProgress();
        
        document.querySelectorAll('.materi-card').forEach(card => {
            const quizBtn = card.querySelector('[onclick*="openQuiz"]');
            if (!quizBtn) return;
            
            // Extract materi ID from onclick
            const match = quizBtn.getAttribute('onclick').match(/openQuiz\(['"](.+?)['"]\)/);
            if (!match) return;
            
            const materiId = match[1];
            const progress = progressData[materiId]?.progress || 0;
            
            // Check if progress bar already exists
            let progressBar = card.querySelector('.materi-progress');
            if (!progressBar) {
                // Create progress bar
                const progressHTML = `
                    <div class="materi-progress">
                        <div class="materi-progress-header">
                            <span>Progress Belajar</span>
                            <span class="materi-progress-value">${progress}%</span>
                        </div>
                        <div class="materi-progress-bar">
                            <div class="materi-progress-fill" style="width: ${progress}%"></div>
                        </div>
                    </div>
                `;
                const cardContent = card.querySelector('.materi-card-content');
                const badge = cardContent.querySelector('.materi-card-badge');
                if (badge) {
                    badge.insertAdjacentHTML('afterend', progressHTML);
                }
            } else {
                // Update existing progress bar
                const fill = progressBar.querySelector('.materi-progress-fill');
                const value = progressBar.querySelector('.materi-progress-value');
                if (fill) fill.style.width = progress + '%';
                if (value) value.textContent = progress + '%';
            }
        });
    }
    
    // ========== Skeleton Cards ==========
    function showSkeletonCards() {
        const grid = document.querySelector('.materi-grid');
        if (!grid) return;
        
        // Add skeleton class to cards initially
        grid.querySelectorAll('.materi-card').forEach((card, index) => {
            card.classList.add('skeleton-loading');
            card.style.animationDelay = (index * 0.1) + 's';
        });
    }
    
    function removeSkeletonCards() {
        document.querySelectorAll('.materi-card.skeleton-loading').forEach((card, index) => {
            setTimeout(() => {
                card.classList.remove('skeleton-loading');
                card.classList.add('skeleton-loaded');
            }, index * 100);
        });
    }
    
    // ========== Extend Quiz to save progress ==========
    function extendQuizSystem() {
        // Override the result display to save progress
        const originalShowResult = window.showQuizResult;
        
        // Listen for quiz completion
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'attributes' && 
                    mutation.target.id === 'quiz-result' &&
                    mutation.target.style.display !== 'none') {
                    
                    // Get quiz data from current quiz
                    const scoreEl = document.querySelector('.quiz-score-number');
                    if (scoreEl && window.currentQuizId) {
                        const score = parseInt(scoreEl.textContent);
                        updateProgressFromQuiz(window.currentQuizId, score, 5);
                    }
                }
            });
        });
        
        // Wait for quiz modal to be created
        setTimeout(() => {
            const quizResult = document.getElementById('quiz-result');
            if (quizResult) {
                observer.observe(quizResult, { attributes: true, attributeFilter: ['style'] });
            }
        }, 1000);
    }
    
    // Store current quiz ID
    const originalOpenQuiz = window.openQuiz;
    window.openQuiz = function(quizId) {
        window.currentQuizId = quizId;
        if (originalOpenQuiz) {
            originalOpenQuiz(quizId);
        }
    };
    
    // ========== Initialize ==========
    document.addEventListener('DOMContentLoaded', function() {
        // Show loader
        createPageLoader();
        showSkeletonCards();
        
        // Hide loader after page load
        window.addEventListener('load', function() {
            setTimeout(() => {
                hidePageLoader();
                removeSkeletonCards();
                renderProgressBars();
            }, 300);
        });
        
        // Extend quiz system
        extendQuizSystem();
    });
    
    // If page already loaded
    if (document.readyState === 'complete') {
        setTimeout(() => {
            hidePageLoader();
            removeSkeletonCards();
            renderProgressBars();
        }, 100);
    }
    
})();
