document.addEventListener('DOMContentLoaded', function() {
    appendMessage('bot-message', 'Hello! How can I assist you today?');
});

document.getElementById('send-button').addEventListener('click', sendMessage);
document.getElementById('chat-input').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        sendMessage();
    }
});

function sendMessage() {
    const input = document.getElementById('chat-input');
    const message = input.value.trim();
    if (message) {
        appendMessage('user-message', message);
        input.value = '';

        // Make API call to get bot response
        fetch('./src/chatbot/gpt.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => response.json())
        .then(data => {
            appendMessage('bot-message', data.reply);
        })
        .catch(error => {
            console.error('Error:', error);
            appendMessage('bot-message', 'Sorry, something went wrong.');
        });
    }
}

function appendMessage(type, message) {
    const chatWindow = document.getElementById('chat-window');
    const messageElement = document.createElement('div');
    messageElement.className = `chat-message ${type}`;
    messageElement.textContent = message;
    chatWindow.appendChild(messageElement);
    chatWindow.scrollTop = chatWindow.scrollHeight;
}
