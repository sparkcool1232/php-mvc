// Basic interactivity for the filter pills
document.addEventListener('DOMContentLoaded', () => {
    const filterPills = document.querySelectorAll('.filter-pill');

    filterPills.forEach(pill => {
        pill.addEventListener('click', () => {
            filterPills.forEach(p => p.classList.remove('active'));
            pill.classList.add('active');
        });
    });

    // Chat Widget Logic
    const chatBubble = document.getElementById('chat-bubble');
    const chatWindow = document.getElementById('chat-window');
    const chatClose = document.getElementById('chat-close');
    const chatContainer = document.getElementById('chat-messages');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    
    let chatInterval = null;

    if(chatBubble && chatWindow && chatClose && chatContainer && chatForm) {
        
        chatBubble.addEventListener('click', () => {
            chatWindow.style.display = 'flex';
            chatBubble.style.transform = 'scale(0)';
            fetchMessages();
            chatInterval = setInterval(fetchMessages, 3000);
        });

        chatClose.addEventListener('click', () => {
            chatWindow.style.display = 'none';
            chatBubble.style.transform = 'scale(1)';
            clearInterval(chatInterval);
        });

        function fetchMessages() {
            fetch('/chat/fetch')
                .then(res => res.json())
                .then(data => {
                    chatContainer.innerHTML = '';
                    data.forEach(msg => {
                        const div = document.createElement('div');
                        div.style.marginBottom = '5px';
                        const strong = document.createElement('strong');
                        strong.textContent = msg.user_name + ': ';
                        strong.style.color = 'var(--primary-dark)';
                        const span = document.createElement('span');
                        span.textContent = msg.message;
                        div.appendChild(strong);
                        div.appendChild(span);
                        chatContainer.appendChild(div);
                    });
                    chatContainer.scrollTop = chatContainer.scrollHeight;
                }).catch(err => console.log('Chat not initialized'));
        }

        chatForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const text = chatInput.value.trim();
            if(!text) return;

            fetch('/chat/send', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({message: text})
            }).then(() => {
                chatInput.value = '';
                fetchMessages();
            });
        });
    }
});
