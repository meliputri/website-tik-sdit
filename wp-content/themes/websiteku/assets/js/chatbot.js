/**
 * Chatbot System - Rule Based with Suggested Questions
 * 
 * @package Websiteku
 */

(function() {
    'use strict';

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function getSelectedKelas() {
        const sel = document.getElementById('chatbot-kelas-select');
        if (!sel) return '';
        return sel.value || '';
    }

    function findMateriResponse(message) {
        if (typeof websitekuMateriContext === 'undefined' || !websitekuMateriContext.items) {
            return null;
        }
        const msg = message.toLowerCase().trim();
        const kelas = getSelectedKelas();
        let best = null;
        let bestScore = 0;

        websitekuMateriContext.items.forEach(function (item) {
            if (kelas && kelas !== 'all' && String(item.kelas) !== String(kelas)) {
                return;
            }
            let score = 0;
            if (msg.includes(item.title.toLowerCase())) score += 5;
            if (item.keywords) {
                item.keywords.forEach(function (kw) {
                    if (kw && msg.includes(kw)) score += 2;
                });
            }
            if (msg.includes('kelas ' + item.kelas) || msg.includes('kls ' + item.kelas)) score += 3;
            if (msg.includes('tp') || msg.includes('tujuan pembelajaran')) score += 1;
            if (score > bestScore) {
                bestScore = score;
                best = item;
            }
        });

        if (best && bestScore >= 2) {
            return best.answer;
        }
        return null;
    }

    function logChatInteraction(userMessage, botAnswer, source) {
        if (!userMessage || !botAnswer || typeof websitekuN8nConfig === 'undefined') {
            return;
        }
        if (!websitekuN8nConfig.chat_log_nonce || !websitekuN8nConfig.api_url) {
            return;
        }
        const formData = new FormData();
        formData.append('action', 'websiteku_log_chat');
        formData.append('nonce', websitekuN8nConfig.chat_log_nonce);
        formData.append('message', userMessage);
        formData.append('answer', botAnswer);
        formData.append('source', source || 'rule');
        formData.append('kelas', getSelectedKelas());
        fetch(websitekuN8nConfig.api_url, { method: 'POST', body: formData }).catch(function () {});
    }

    function detectResponseSource(message) {
        if (getTpKelasResponse(message)) return 'tp';
        if (findMateriResponse(message)) return 'materi';
        return 'rule';
    }

    function getTpKelasResponse(message) {
        const msg = message.toLowerCase();
        const kelasMatch = msg.match(/kelas\s*(\d)/) || msg.match(/kls\s*(\d)/) || msg.match(/tp\s*kelas\s*(\d)/);
        if (!kelasMatch || typeof websitekuMateriContext === 'undefined' || !websitekuMateriContext.tp_referensi) {
            return null;
        }
        const k = kelasMatch[1];
        const list = websitekuMateriContext.tp_referensi[k];
        if (!list || !list.length) return null;
        let answer = '📋 **TP Informatika/TIK Kelas ' + k + ':**\n\n';
        list.forEach(function (tp, i) {
            answer += (i + 1) + '. ' + tp + '\n';
        });
        answer += '\nPilih materi Kelas ' + k + ' di halaman beranda atau tanyakan judul materinya.';
        return answer;
    }
    
    // ========== Suggested Questions ==========
    const suggestedQuestions = [
        "Apa itu komputer?",
        "Apa itu hardware?",
        "Apa itu software?",
        "Apa itu internet?",
        "Apa itu CPU?",
        "Apa itu RAM?",
        "Apa itu browser?",
        "Apa itu password?"
    ];
    
    // ========== Create Chatbot UI ==========
    function createChatbotUI() {
        const chatbotHTML = `
            <div id="chatbot-container" class="chatbot-container">
                <!-- Toggle Button -->
                <button id="chatbot-toggle" class="chatbot-toggle" aria-label="Buka Chatbot">
                    <span class="chatbot-toggle-icon">💬</span>
                    <span class="chatbot-toggle-close">✕</span>
                </button>
                
                <!-- Chat Window -->
                <div id="chatbot-window" class="chatbot-window">
                    <!-- Header -->
                    <div class="chatbot-header">
                        <div class="chatbot-header-info">
                            <div class="chatbot-avatar">🤖</div>
                            <div>
                                <h4>Asisten TIK</h4>
                                <span class="chatbot-status">Online</span>
                            </div>
                        </div>
                        <div class="chatbot-header-actions">
                            <select id="chatbot-kelas-select" class="chatbot-kelas-select" title="Pilih kelas">
                                <option value="">Semua Kelas</option>
                            </select>
                            <button id="chatbot-close" class="chatbot-close" aria-label="Tutup">✕</button>
                        </div>
                    </div>
                    
                    <!-- Messages -->
                    <div id="chatbot-messages" class="chatbot-messages">
                        <div class="chatbot-message bot">
                            <div class="chatbot-message-content">
                                Halo! 👋 Saya Asisten TIK. Pilih <strong>kelas</strong> di atas agar jawaban sesuai TP dan materi kelasmu.
                                <br><br>
                                Tanyakan materi, TP, atau video pembelajaran — contoh: &quot;TP kelas 4&quot; atau &quot;materi internet&quot;
                            </div>
                        </div>
                        
                        <!-- Suggested Questions -->
                        <div class="chatbot-suggestions" id="chatbot-suggestions">
                            ${suggestedQuestions.slice(0, 4).map(q => 
                                `<button class="chatbot-suggestion" onclick="askSuggestion('${q}')">${q}</button>`
                            ).join('')}
                            <button class="chatbot-suggestion-more" onclick="showMoreSuggestions()">Lihat lainnya...</button>
                        </div>
                    </div>
                    
                    <!-- Input -->
                    <div class="chatbot-input-wrapper">
                        <input 
                            type="text" 
                            id="chatbot-input" 
                            class="chatbot-input" 
                            placeholder="Ketik pertanyaan..."
                            autocomplete="off"
                        >
                        <button id="chatbot-send" class="chatbot-send" aria-label="Kirim">
                            ➤
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', chatbotHTML);
    }
    
    // ========== Initialize Chatbot ==========
    function initChatbot() {
        const toggle = document.getElementById('chatbot-toggle');
        const chatWindow = document.getElementById('chatbot-window');
        const closeBtn = document.getElementById('chatbot-close');
        const input = document.getElementById('chatbot-input');
        const sendBtn = document.getElementById('chatbot-send');
        const messagesContainer = document.getElementById('chatbot-messages');
        
        // Toggle chatbot window
        toggle.addEventListener('click', function() {
            chatWindow.classList.toggle('active');
            toggle.classList.toggle('active');
            if (chatWindow.classList.contains('active')) {
                input.focus();
            }
        });
        
        // Close button
        closeBtn.addEventListener('click', function() {
            chatWindow.classList.remove('active');
            toggle.classList.remove('active');
        });
        
        const kelasSelect = document.getElementById('chatbot-kelas-select');
        if (kelasSelect && typeof websitekuN8nConfig !== 'undefined' && websitekuN8nConfig.kelas_options) {
            Object.keys(websitekuN8nConfig.kelas_options).forEach(function (key) {
                const opt = document.createElement('option');
                opt.value = key;
                opt.textContent = websitekuN8nConfig.kelas_options[key];
                kelasSelect.appendChild(opt);
            });
            try {
                const saved = localStorage.getItem('websiteku_kelas');
                if (saved && saved !== 'all') kelasSelect.value = saved;
            } catch (e) {}
            kelasSelect.addEventListener('change', function () {
                try {
                    localStorage.setItem('websiteku_kelas', kelasSelect.value || 'all');
                } catch (e) {}
            });
        }
        
        // Send message on button click
        sendBtn.addEventListener('click', sendMessage);
        
        // Send message on Enter key
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
        
        // Send message function
        function sendMessage(customMessage) {
            const message = customMessage || input.value.trim();
            
            if (message === '') {
                addMessage('Silakan ketik pertanyaan terlebih dahulu. 😊', 'bot');
                return;
            }
            
            // Hide suggestions after first message
            const suggestions = document.getElementById('chatbot-suggestions');
            if (suggestions) {
                suggestions.style.display = 'none';
            }
            
            // Add user message
            addMessage(message, 'user');
            input.value = '';
            
            // Show typing indicator
            const typingId = showTyping();
            
            // Get bot response
            // Check if n8n is enabled (async callback)
            if (typeof websitekuN8nConfig !== 'undefined' && websitekuN8nConfig.enabled) {
                // Use callback for async n8n response
                setTimeout(function() {
                    getBotResponse(message, function(response, source) {
                        removeTyping(typingId);
                        addMessage(response, 'bot');
                        if (source !== 'n8n') {
                            logChatInteraction(message, response, source || 'fallback');
                        }
                    });
                }, 800 + Math.random() * 500);
            } else {
                setTimeout(function() {
                    removeTyping(typingId);
                    const msgLower = message.toLowerCase().trim();
                    const response = getRuleBasedResponse(msgLower);
                    const source = detectResponseSource(msgLower);
                    addMessage(response, 'bot');
                    logChatInteraction(message, response, source);
                }, 800 + Math.random() * 500);
            }
        }
        
        // Make sendMessage accessible
        window.sendChatMessage = sendMessage;
        
        // Add message to chat
        function addMessage(text, sender) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `chatbot-message ${sender}`;
            const safe = escapeHtml(text).replace(/\n/g, '<br>');
            messageDiv.innerHTML = '<div class="chatbot-message-content">' + safe + '</div>';
            messagesContainer.appendChild(messageDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
        
        // Show typing indicator
        function showTyping() {
            const id = 'typing-' + Date.now();
            const typingDiv = document.createElement('div');
            typingDiv.id = id;
            typingDiv.className = 'chatbot-message bot typing';
            typingDiv.innerHTML = `
                <div class="chatbot-message-content">
                    <span class="typing-dot"></span>
                    <span class="typing-dot"></span>
                    <span class="typing-dot"></span>
                </div>
            `;
            messagesContainer.appendChild(typingDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            return id;
        }
        
        // Remove typing indicator
        function removeTyping(id) {
            const typingDiv = document.getElementById(id);
            if (typingDiv) {
                typingDiv.remove();
            }
        }
        
        // Get bot response (with n8n support)
        function getBotResponse(userMessage, callback) {
            const message = userMessage.toLowerCase().trim();
            
            // Check if n8n is enabled
            if (typeof websitekuN8nConfig !== 'undefined' && websitekuN8nConfig.enabled && websitekuN8nConfig.webhook_url) {
                // Try n8n first
                fetchN8nResponse(userMessage, function(n8nAnswer) {
                    if (n8nAnswer) {
                        callback(n8nAnswer, 'n8n');
                    } else {
                        const ruleBasedAnswer = getRuleBasedResponse(message);
                        callback(ruleBasedAnswer, detectResponseSource(message));
                    }
                });
            } else {
                const answer = getRuleBasedResponse(message);
                if (callback) {
                    callback(answer, detectResponseSource(message));
                } else {
                    return answer;
                }
            }
        }
        
        // Fetch response from n8n via WordPress proxy
        function fetchN8nResponse(userMessage, callback) {
            if (typeof websitekuN8nConfig === 'undefined') {
                callback(null);
                return;
            }
            
            const formData = new FormData();
            formData.append('action', 'websiteku_chatbot_n8n');
            formData.append('nonce', websitekuN8nConfig.nonce);
            formData.append('message', userMessage);
            formData.append('kelas', getSelectedKelas());
            
            // Create timeout promise
            const timeoutPromise = new Promise(function(resolve) {
                setTimeout(function() {
                    resolve({ timeout: true });
                }, websitekuN8nConfig.timeout || 5000);
            });
            
            // Create fetch promise
            const fetchPromise = fetch(websitekuN8nConfig.api_url, {
                method: 'POST',
                body: formData
            }).then(function(response) {
                return response.json();
            });
            
            // Race between fetch and timeout
            Promise.race([fetchPromise, timeoutPromise]).then(function(result) {
                if (result.timeout) {
                    console.warn('⏱️ n8n request timeout, using fallback');
                    callback(null);
                } else if (result.success && result.data && result.data.answer) {
                    console.log('✅ n8n response received:', result.data.answer);
                    callback(result.data.answer, 'n8n');
                } else {
                    // Log detailed error for debugging
                    const errorMsg = result.data ? result.data.message : 'Unknown error';
                    const statusCode = result.data ? result.data.status_code : 'N/A';
                    const responseBody = result.data ? result.data.response_body : '';
                    
                    console.error('❌ n8n request failed:', {
                        message: errorMsg,
                        status_code: statusCode,
                        response_body: responseBody,
                        fullResponse: result
                    });
                    
                    // Show user-friendly error in console
                    if (statusCode === 500) {
                        console.error('💡 TIP: Error di n8n workflow. Cek execution logs di n8n dashboard untuk detail error.');
                    }
                    
                    callback(null);
                }
            }).catch(function(error) {
                console.error('❌ n8n request error:', error);
                callback(null);
            });
        }
        
        // Get rule-based response (fallback)
        function getRuleBasedResponse(message) {
            const tpAnswer = getTpKelasResponse(message);
            if (tpAnswer) return tpAnswer;

            const materiAnswer = findMateriResponse(message);
            if (materiAnswer) return materiAnswer;

            if (typeof ChatbotData !== 'undefined') {
                // First, try exact match
                if (ChatbotData[message]) {
                    return ChatbotData[message].answer;
                }
                
                // Then, search by keywords
                for (const key in ChatbotData) {
                    if (key === 'default') continue;
                    
                    const data = ChatbotData[key];
                    
                    if (message.includes(key)) {
                        return data.answer;
                    }
                    
                    if (data.kelas && getSelectedKelas() && String(data.kelas) !== String(getSelectedKelas())) {
                        continue;
                    }

                    if (data.keywords && data.keywords.length > 0) {
                        for (const keyword of data.keywords) {
                            if (message.includes(keyword)) {
                                return data.answer;
                            }
                        }
                    }
                }
                
                return ChatbotData['default'].answer;
            }
            
            return "Maaf, sistem chatbot sedang tidak tersedia. Silakan coba lagi nanti.";
        }
    }
    
    // ========== Ask Suggestion ==========
    window.askSuggestion = function(question) {
        window.sendChatMessage(question);
    };
    
    // ========== Expose getRuleBasedResponse globally (for external use) ==========
    // Note: This is a wrapper, actual function is inside initChatbot scope
    window.getRuleBasedResponse = function(message) {
        const msg = (message || '').toLowerCase().trim();
        const tpAnswer = getTpKelasResponse(msg);
        if (tpAnswer) return tpAnswer;
        const materiAnswer = findMateriResponse(msg);
        if (materiAnswer) return materiAnswer;
        if (typeof ChatbotData !== 'undefined') {
            if (ChatbotData[msg]) {
                return ChatbotData[msg].answer;
            }
            for (const key in ChatbotData) {
                if (key === 'default') continue;
                const data = ChatbotData[key];
                if (msg.includes(key)) {
                    return data.answer;
                }
                if (data.kelas && getSelectedKelas() && String(data.kelas) !== String(getSelectedKelas())) {
                    continue;
                }
                if (data.keywords && data.keywords.length > 0) {
                    for (const keyword of data.keywords) {
                        if (msg.includes(keyword)) {
                            return data.answer;
                        }
                    }
                }
            }
            return ChatbotData['default'].answer;
        }
        return "Maaf, sistem chatbot sedang tidak tersedia.";
    };
    
    // ========== Show More Suggestions ==========
    window.showMoreSuggestions = function() {
        const container = document.getElementById('chatbot-suggestions');
        container.innerHTML = suggestedQuestions.map(q => 
            `<button class="chatbot-suggestion" onclick="askSuggestion('${q}')">${q}</button>`
        ).join('');
    };
    
    // ========== Global function to open chatbot ==========
    window.openChatbot = function() {
        const chatWindow = document.getElementById('chatbot-window');
        const toggle = document.getElementById('chatbot-toggle');
        const input = document.getElementById('chatbot-input');
        
        if (chatWindow && toggle) {
            chatWindow.classList.add('active');
            toggle.classList.add('active');
            if (input) {
                input.focus();
            }
        }
    };

    window.openChatbotWithKelas = function(kelas) {
        const sel = document.getElementById('chatbot-kelas-select');
        if (sel && kelas) {
            sel.value = String(kelas);
            try {
                localStorage.setItem('websiteku_kelas', String(kelas));
            } catch (e) {}
        }
        window.openChatbot();
    };
    
    // ========== Initialize on DOM ready ==========
    document.addEventListener('DOMContentLoaded', function() {
        createChatbotUI();
        initChatbot();
    });
    
})();
