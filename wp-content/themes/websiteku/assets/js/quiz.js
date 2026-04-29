/**
 * Quiz System - Logic & UI
 * 
 * Supports both REST API (wp-admin managed) and fallback to QuizData (hardcoded)
 * 
 * @package Websiteku
 */

(function() {
    'use strict';
    
    let currentQuiz = null;
    let currentQuestion = 0;
    let score = 0;
    let answers = [];
    
    // API base URL - will be set dynamically
    const apiBase = (typeof websiteku_vars !== 'undefined') 
        ? websiteku_vars.rest_url + 'websiteku/v1/quiz/' 
        : '/wp-json/websiteku/v1/quiz/';
    
    // ========== Create Quiz Modal ==========
    function createQuizModal() {
        const modalHTML = `
            <div id="quiz-modal" class="quiz-modal">
                <div class="quiz-modal-content">
                    <button class="quiz-close" onclick="closeQuiz()">&times;</button>
                    
                    <!-- Quiz Loading -->
                    <div id="quiz-loading" class="quiz-screen" style="display: none;">
                        <div class="quiz-loading-spinner"></div>
                        <p>Memuat quiz...</p>
                    </div>
                    
                    <!-- Quiz Error -->
                    <div id="quiz-error" class="quiz-screen" style="display: none;">
                        <div class="quiz-error-icon"><i class="fas fa-exclamation-triangle"></i></div>
                        <h3>Quiz Tidak Ditemukan</h3>
                        <p class="quiz-error-message"></p>
                        <button class="btn btn-outline" onclick="closeQuiz()">Tutup</button>
                    </div>
                    
                    <!-- Quiz Start Screen -->
                    <div id="quiz-start" class="quiz-screen" style="display: none;">
                        <div class="quiz-start-icon"><i class="fas fa-clipboard-list"></i></div>
                        <h2 class="quiz-title"></h2>
                        <p class="quiz-description"></p>
                        <div class="quiz-info">
                            <span><i class="fas fa-list-ol"></i> <strong class="quiz-total-questions">5</strong> Soal</span>
                            <span><i class="fas fa-clock"></i> <strong class="quiz-time-limit">30</strong> detik/soal</span>
                        </div>
                        <button class="btn btn-primary" onclick="startQuiz()"><i class="fas fa-play"></i> Mulai Quiz</button>
                    </div>
                    
                    <!-- Quiz Question Screen -->
                    <div id="quiz-question" class="quiz-screen" style="display: none;">
                        <div class="quiz-progress">
                            <div class="quiz-progress-bar">
                                <div class="quiz-progress-fill"></div>
                            </div>
                            <span class="quiz-progress-text">Soal 1 dari 5</span>
                        </div>
                        
                        <div class="quiz-question-content">
                            <h3 class="quiz-question-text"></h3>
                            <div class="quiz-options"></div>
                        </div>
                        
                        <div class="quiz-feedback" style="display: none;">
                            <div class="quiz-feedback-icon"></div>
                            <p class="quiz-feedback-text"></p>
                            <p class="quiz-explanation"></p>
                            <button class="btn btn-primary" onclick="nextQuestion()">Lanjut</button>
                        </div>
                    </div>
                    
                    <!-- Quiz Result Screen -->
                    <div id="quiz-result" class="quiz-screen" style="display: none;">
                        <div class="quiz-result-icon"></div>
                        <h2 class="quiz-result-title"></h2>
                        <div class="quiz-score">
                            <span class="quiz-score-number"></span>
                            <span class="quiz-score-label">dari 5 soal benar</span>
                        </div>
                        <p class="quiz-result-message"></p>
                        <div class="quiz-result-actions">
                            <button class="btn btn-outline" onclick="closeQuiz()">Kembali</button>
                            <button class="btn btn-primary" onclick="retryQuiz()"><i class="fas fa-redo"></i> Ulangi Quiz</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', modalHTML);
    }
    
    // ========== Open Quiz ==========
    window.openQuiz = async function(quizId) {
        // Show modal with loading
        document.getElementById('quiz-modal').classList.add('active');
        hideAllScreens();
        document.getElementById('quiz-loading').style.display = 'block';
        document.body.style.overflow = 'hidden';
        
        try {
            // Try to fetch from REST API first
            const response = await fetch(apiBase + quizId);
            
            if (response.ok) {
                const quizData = await response.json();
                currentQuiz = {
                    id: quizData.id,
                    title: quizData.title,
                    description: 'Uji pemahaman kamu tentang materi ini',
                    timeLimit: quizData.timeLimit || 30,
                    passScore: quizData.passScore || 70,
                    questions: quizData.questions.map(q => ({
                        question: q.question,
                        options: q.options,
                        correct: parseInt(q.correct),
                        explanation: 'Jawaban yang benar adalah: ' + q.options[q.correct]
                    }))
                };
            } else {
                // Fallback to hardcoded QuizData
                if (typeof QuizData !== 'undefined' && QuizData[quizId]) {
                    currentQuiz = QuizData[quizId];
                    currentQuiz.id = quizId;
                } else {
                    throw new Error('Quiz tidak ditemukan');
                }
            }
        } catch (error) {
            // Fallback to hardcoded QuizData
            if (typeof QuizData !== 'undefined' && QuizData[quizId]) {
                currentQuiz = QuizData[quizId];
                currentQuiz.id = quizId;
            } else {
                console.error('Quiz error:', error);
                hideAllScreens();
                document.getElementById('quiz-error').style.display = 'block';
                document.querySelector('.quiz-error-message').textContent = 
                    'Quiz "' + quizId + '" belum tersedia. Silakan hubungi admin.';
                return;
            }
        }
        
        // Reset state
        currentQuestion = 0;
        score = 0;
        answers = [];
        
        // Set start screen content
        hideAllScreens();
        document.querySelector('.quiz-title').textContent = 'Quiz: ' + currentQuiz.title;
        document.querySelector('.quiz-description').textContent = currentQuiz.description || 'Uji pemahaman kamu tentang materi ini';
        document.querySelector('.quiz-total-questions').textContent = currentQuiz.questions.length;
        document.querySelector('.quiz-time-limit').textContent = currentQuiz.timeLimit || 30;
        
        document.getElementById('quiz-start').style.display = 'block';
    };
    
    function hideAllScreens() {
        document.getElementById('quiz-loading').style.display = 'none';
        document.getElementById('quiz-error').style.display = 'none';
        document.getElementById('quiz-start').style.display = 'none';
        document.getElementById('quiz-question').style.display = 'none';
        document.getElementById('quiz-result').style.display = 'none';
    }
    
    // ========== Start Quiz ==========
    window.startQuiz = function() {
        hideAllScreens();
        document.getElementById('quiz-question').style.display = 'block';
        showQuestion();
    };
    
    // ========== Show Question ==========
    function showQuestion() {
        const question = currentQuiz.questions[currentQuestion];
        const totalQuestions = currentQuiz.questions.length;
        
        // Update progress
        const progress = ((currentQuestion) / totalQuestions) * 100;
        document.querySelector('.quiz-progress-fill').style.width = progress + '%';
        document.querySelector('.quiz-progress-text').textContent = 
            `Soal ${currentQuestion + 1} dari ${totalQuestions}`;
        
        // Show question
        document.querySelector('.quiz-question-text').textContent = question.question;
        
        // Show options
        const optionsContainer = document.querySelector('.quiz-options');
        optionsContainer.innerHTML = '';
        
        const labels = ['A', 'B', 'C', 'D'];
        question.options.forEach((option, index) => {
            const optionBtn = document.createElement('button');
            optionBtn.className = 'quiz-option';
            optionBtn.innerHTML = `<span class="option-label">${labels[index]}</span> ${option}`;
            optionBtn.onclick = () => selectAnswer(index);
            optionsContainer.appendChild(optionBtn);
        });
        
        // Hide feedback
        document.querySelector('.quiz-feedback').style.display = 'none';
        document.querySelector('.quiz-question-content').style.display = 'block';
    }
    
    // ========== Select Answer ==========
    function selectAnswer(index) {
        const question = currentQuiz.questions[currentQuestion];
        const isCorrect = index === question.correct;
        
        answers.push({
            question: currentQuestion,
            selected: index,
            correct: question.correct,
            isCorrect: isCorrect
        });
        
        if (isCorrect) {
            score++;
        }
        
        // Highlight options
        const options = document.querySelectorAll('.quiz-option');
        options.forEach((opt, i) => {
            opt.disabled = true;
            opt.style.pointerEvents = 'none';
            if (i === question.correct) {
                opt.classList.add('correct');
            } else if (i === index && !isCorrect) {
                opt.classList.add('wrong');
            }
        });
        
        // Show feedback
        const feedback = document.querySelector('.quiz-feedback');
        const feedbackIcon = document.querySelector('.quiz-feedback-icon');
        const feedbackText = document.querySelector('.quiz-feedback-text');
        const explanation = document.querySelector('.quiz-explanation');
        
        feedbackIcon.innerHTML = isCorrect ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-times-circle"></i>';
        feedbackText.textContent = isCorrect ? 'Benar!' : 'Salah!';
        explanation.textContent = question.explanation || ('Jawaban yang benar: ' + question.options[question.correct]);
        
        feedback.className = 'quiz-feedback ' + (isCorrect ? 'correct' : 'wrong');
        feedback.style.display = 'block';
        
        // Update button text if last question
        const nextBtn = feedback.querySelector('.btn');
        if (currentQuestion >= currentQuiz.questions.length - 1) {
            nextBtn.innerHTML = '<i class="fas fa-trophy"></i> Lihat Hasil';
        } else {
            nextBtn.innerHTML = 'Lanjut <i class="fas fa-arrow-right"></i>';
        }
    }
    
    // ========== Next Question ==========
    window.nextQuestion = function() {
        currentQuestion++;
        
        if (currentQuestion >= currentQuiz.questions.length) {
            showResult();
        } else {
            showQuestion();
        }
    };
    
    // ========== Show Result ==========
    function showResult() {
        hideAllScreens();
        document.getElementById('quiz-result').style.display = 'block';
        
        const totalQuestions = currentQuiz.questions.length;
        const percentage = (score / totalQuestions) * 100;
        const passScore = currentQuiz.passScore || 70;
        
        // Determine result
        let icon, title, message;
        if (percentage >= 80) {
            icon = '<i class="fas fa-trophy" style="color: gold;"></i>';
            title = 'Luar Biasa!';
            message = 'Kamu sangat memahami materi ini. Pertahankan!';
        } else if (percentage >= 60) {
            icon = '<i class="fas fa-thumbs-up" style="color: #4CAF50;"></i>';
            title = 'Bagus!';
            message = 'Pemahaman kamu sudah baik. Terus belajar ya!';
        } else if (percentage >= 40) {
            icon = '<i class="fas fa-book" style="color: #FF9800;"></i>';
            title = 'Cukup';
            message = 'Kamu perlu belajar lagi. Jangan menyerah!';
        } else {
            icon = '<i class="fas fa-fist-raised" style="color: #2196F3;"></i>';
            title = 'Semangat!';
            message = 'Ayo pelajari lagi materinya dan coba lagi!';
        }
        
        document.querySelector('.quiz-result-icon').innerHTML = icon;
        document.querySelector('.quiz-result-title').textContent = title;
        document.querySelector('.quiz-score-number').textContent = score;
        document.querySelector('.quiz-score-label').textContent = `dari ${totalQuestions} soal benar`;
        document.querySelector('.quiz-result-message').textContent = message;
    }
    
    // ========== Retry Quiz ==========
    window.retryQuiz = function() {
        currentQuestion = 0;
        score = 0;
        answers = [];
        
        hideAllScreens();
        document.getElementById('quiz-question').style.display = 'block';
        showQuestion();
    };
    
    // ========== Close Quiz ==========
    window.closeQuiz = function() {
        document.getElementById('quiz-modal').classList.remove('active');
        document.body.style.overflow = '';
    };
    
    // ========== Initialize ==========
    document.addEventListener('DOMContentLoaded', function() {
        createQuizModal();
        
        // Close on outside click
        document.getElementById('quiz-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeQuiz();
            }
        });
        
        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeQuiz();
            }
        });
    });
    
})();
