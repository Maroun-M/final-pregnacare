// Mock current user IDs for demonstration purposes
const currentUser = parseInt(document.querySelector(".user-id").innerHTML.trim());
const receiverId = parseInt(document.querySelector(".receiver-id").innerHTML.trim());

// Function to send a message
const sendMessage = async (senderId, receiverId, messageText) => {
    try {
        const response = await fetch('chat.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                action: 'send',
                senderId: senderId,
                receiverId: receiverId,
                messageText: messageText
            })
        });
        const result = await response.json();
        console.log('Message sent: ', result);
    } catch (e) {
        console.error('Error sending message: ', e);
    }
};

// Function to get messages between two users
const getMessages = async (userId1, userId2) => {
    console.log(userId1, userId2);
    try {
        const response = await fetch('chat.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                action: 'get',
                userId1: userId1,
                userId2: userId2
            })
        });
        const messages = await response.json();
        return messages;
    } catch (e) {
        console.error('Error getting messages: ', e);
        return [];
    }
};

// Function to render messages in the chat window
const renderMessages = (messages) => {
    const messagingWindow = document.getElementById('messaging-window');
    messagingWindow.innerHTML = ''; // Clear existing messages

    messages.forEach(msg => {
        const messageElement = document.createElement('div');
        messageElement.classList.add('message');
        messageElement.classList.add(parseInt(msg.sender_id) === currentUser ? 'message-sent' : 'message-received');
        messageElement.textContent = msg.message_text;
        messagingWindow.appendChild(messageElement);
    });

    messagingWindow.scrollTop = messagingWindow.scrollHeight; // Scroll to bottom
};

// Function to handle sending messages
const handleSendMessage = async () => {
    const messageInput = document.getElementById('messaging-input');
    const messageText = messageInput.value;

    if (messageText.trim()) {
        await sendMessage(currentUser, receiverId, messageText);
        messageInput.value = ''; // Clear the input
        const messages = await getMessages(currentUser, receiverId);
        renderMessages(messages);
    }
};

// Event listener for the send button
document.getElementById('send-button').addEventListener('click', handleSendMessage);

// Event listener for pressing Enter key in the input field
document.getElementById('messaging-input').addEventListener('keypress', (event) => {
    if (event.key === 'Enter') {
        handleSendMessage();
    }
});

// Initial load of messages
window.addEventListener('load', async () => {
    const messages = await getMessages(currentUser, receiverId);
    console.log(messages);
    renderMessages(messages);

    // Set interval to load new messages every 3 seconds
    setInterval(async () => {
        const newMessages = await getMessages(currentUser, receiverId);
        renderMessages(newMessages);
    }, 3000);
});
