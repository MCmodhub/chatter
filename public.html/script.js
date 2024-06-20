// Global variable for username
let username = '';

// Function to fetch and display messages
function fetchMessages() {
    fetch('chat/chat.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                displayMessages(data.messages);
            } else {
                console.error('Failed to fetch messages:', data.message);
            }
        })
        .catch(error => console.error('Error fetching messages:', error));
}

// Function to display messages in the chat interface
function displayMessages(messages) {
    let messagesDiv = document.getElementById('messages');
    messagesDiv.innerHTML = ''; // Clear existing messages

    messages.forEach(message => {
        let messageDiv = document.createElement('div');
        messageDiv.innerHTML = '<strong>' + message.username + ':</strong> ' + message.message;
        messagesDiv.appendChild(messageDiv);
    });

    messagesDiv.scrollTop = messagesDiv.scrollHeight; // Scroll to bottom
}

// Function to send message
function sendMessage(message) {
    fetch('chat/chat.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'message=' + encodeURIComponent(message),
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // Optional: Notify user that message was sent successfully
        } else {
            console.error('Failed to send message:', data.message);
        }
    })
    .catch(error => console.error('Error sending message:', error));
}

// Function to handle sending message from UI
function handleSendMessage() {
    let messageInput = document.getElementById('message-input');
    let message = messageInput.value.trim();

    if (message !== '') {
        sendMessage(message);
        messageInput.value = ''; // Clear message input
    }
}

// Function to set username (similar to before)
function setUsername() {
    let usernameInput = document.getElementById('username-input');

    username = usernameInput.value.trim();

    if (username !== '') {
        usernameInput.disabled = true; // Disable username input after setting
        fetchMessages(); // Fetch initial messages after setting username
    }
}

// Set up polling to fetch messages periodically (optional)
setInterval(fetchMessages, 5000); // Fetch messages every 5 seconds (adjust as needed)
