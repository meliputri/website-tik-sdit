/**
 * Chatbot System - Rule Based with Suggested Questions
 * 
 * @package Websiteku
 */

(function() {
    'use strict';
    
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
                            <a id="chatbot-newtab" class="chatbot-newtab" href="#" target="_blank" title="Buka di tab baru" aria-label="Buka di tab baru">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                            <button id="chatbot-close" class="chatbot-close" aria-label="Tutup">✕</button>
                        </div>
                    </div>
                    
                    <!-- Messages -->
                    <div id="chatbot-messages" class="chatbot-messages">
                        <div class="chatbot-message bot">
                            <div class="chatbot-message-content">
                                Halo! 👋 Saya Asisten TIK SDIT Global Insan Madani. 
                                <br><br>
                                Silakan tanyakan apa saja tentang materi TIK, atau klik salah satu pertanyaan di bawah:
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
        
        // New tab button - set href from n8n config
        const newTabBtn = document.getElementById('chatbot-newtab');
        if (newTabBtn && typeof websitekuN8nConfig !== 'undefined' && websitekuN8nConfig.webhook_url) {
            newTabBtn.href = websitekuN8nConfig.webhook_url;
        } else if (newTabBtn) {
            newTabBtn.style.display = 'none'; // Hide if no n8n URL
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
            
            if (message === '') return;
            
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
                    getBotResponse(message, function(response) {
                        removeTyping(typingId);
                        addMessage(response, 'bot');
                    });
                }, 800 + Math.random() * 500);
            } else {
                // Use synchronous rule-based response
                setTimeout(function() {
                    removeTyping(typingId);
                    const response = getRuleBasedResponse(message.toLowerCase().trim());
                    addMessage(response, 'bot');
                }, 800 + Math.random() * 500);
            }
        }
        
        // Make sendMessage accessible
        window.sendChatMessage = sendMessage;
        
        // Add message to chat
        function addMessage(text, sender) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `chatbot-message ${sender}`;
            messageDiv.innerHTML = `<div class="chatbot-message-content">${text.replace(/\n/g, '<br>')}</div>`;
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
                        callback(n8nAnswer);
                    } else {
                        // Fallback to rule-based
                        const ruleBasedAnswer = getRuleBasedResponse(message);
                        callback(ruleBasedAnswer);
                    }
                });
            } else {
                // Use rule-based directly
                const answer = getRuleBasedResponse(message);
                if (callback) {
                    callback(answer);
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
                    callback(result.data.answer);
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
    
    // ========== Initialize on DOM ready ==========
    document.addEventListener('DOMContentLoaded', function() {
        createChatbotUI();
        initChatbot();
    });
    
})();
