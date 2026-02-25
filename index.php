<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anarchy Chat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            min-height: 100vh;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: white;
            box-shadow: 0 5px 25px rgba(0,0,0,0.2);
            height: 90vh;
            display: flex;
            flex-direction: column;
            margin-top: 10px;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .chat-header {
            background: linear-gradient(to right, #3498db, #2c3e50);
            color: white;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .chat-header h1 {
            margin: 0;
            font-size: 24px;
        }
        
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
        }
        
        .message {
            margin-bottom: 15px;
            padding: 12px 15px;
            border-radius: 10px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            max-width: 80%;
            word-wrap: break-word;
            animation: fadeIn 0.3s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .own-message {
            align-self: flex-end;
            background-color: #e3f2fd;
            border: 1px solid #bbdefb;
        }
        
        .other-message {
            align-self: flex-start;
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
        }
        
        .pseudo {
            font-weight: bold;
            color: #2c3e50;
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
        }
        
        .timestamp {
            font-size: 11px;
            color: #7f8c8d;
            float: right;
        }
        
        .message-image {
            max-width: 250px;
            max-height: 250px;
            margin-top: 8px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        
        .chat-footer {
            display: flex;
            padding: 15px;
            background-color: #ecf0f1;
            border-top: 1px solid #dcdfe0;
            gap: 10px;
        }
        
        .image-btn {
            background: linear-gradient(to bottom, #2ecc71, #27ae60);
            color: white;
            border: none;
            padding: 12px 15px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 18px;
            transition: all 0.3s;
            min-width: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .image-btn:hover {
            background: linear-gradient(to bottom, #27ae60, #219653);
            transform: scale(1.05);
        }
        
        .message-input {
            flex: 1;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .message-input:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
        }
        
        .send-btn {
            background: linear-gradient(to bottom, #3498db, #2980b9);
            color: white;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            transition: all 0.3s;
            min-width: 60px;
        }
        
        .send-btn:hover {
            background: linear-gradient(to bottom, #2980b9, #2573a7);
            transform: scale(1.05);
        }
        
        .username-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            backdrop-filter: blur(5px);
        }
        
        .username-form {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            width: 350px;
            color: white;
        }
        
        .username-form h2 {
            margin-top: 0;
            margin-bottom: 20px;
        }
        
        .username-form input {
            padding: 12px;
            margin: 10px;
            width: 250px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 5px;
            background: rgba(255,255,255,0.2);
            color: white;
            font-size: 16px;
        }
        
        .username-form input::placeholder {
            color: rgba(255,255,255,0.7);
        }
        
        .username-form input:focus {
            outline: none;
            border-color: white;
        }
        
        .username-form button {
            background: rgba(255,255,255,0.2);
            color: white;
            border: 2px solid white;
            padding: 12px 30px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            transition: all 0.3s;
            margin-top: 10px;
        }
        
        .username-form button:hover {
            background: rgba(255,255,255,0.3);
            transform: scale(1.05);
        }
        
        #imageInput {
            display: none;
        }
        
        /* Scrollbar styling */
        .chat-messages::-webkit-scrollbar {
            width: 8px;
        }
        
        .chat-messages::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .chat-messages::-webkit-scrollbar-thumb {
            background: #3498db;
            border-radius: 10px;
        }
        
        .chat-messages::-webkit-scrollbar-thumb:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <!-- Username Modal -->
    <div id="usernameModal" class="username-modal">
        <div class="username-form">
            <h2>Entrez votre pseudo</h2>
            <input type="text" id="usernameInput" placeholder="Votre pseudo" maxlength="20">
            <br>
            <button onclick="setUsername()">Rejoindre le chat</button>
        </div>
    </div>

    <div class="container">
        <div class="chat-header">
            <h1>Anarchy Chat</h1>
            <p style="margin: 5px 0 0 0; font-size: 14px; opacity: 0.9;">Partagez des messages et des images avec les autres utilisateurs</p>
        </div>
        
        <div class="chat-messages" id="chat">
            <!-- Messages will be loaded here -->
        </div>
        
        <div class="chat-footer">
            <button class="image-btn" onclick="document.getElementById('imageInput').click()" title="Envoyer une image">🖼️</button>
            <input type="file" id="imageInput" accept="image/*" onchange="handleImageUpload(event)">
            <input type="text" id="messageInput" class="message-input" placeholder="Tapez votre message ici...">
            <button class="send-btn" onclick="sendMessage()">Envoyer</button>
        </div>
    </div>

    <script>
        let pseudo = "";
        let chat = document.getElementById('chat');
        
        // Load messages when page loads
        function loadMessages() {
            fetch('get_messages.php')
                .then(response => response.text())
                .then(data => {
                    chat.innerHTML = data;
                    chat.scrollTop = chat.scrollHeight;
                    
                    // Add classes to distinguish own messages vs others
                    const messages = chat.querySelectorAll('.message');
                    messages.forEach(msg => {
                        const msgPseudo = msg.querySelector('.pseudo').textContent.replace(':', '');
                        if (msgPseudo === pseudo) {
                            msg.classList.add('own-message');
                        } else {
                            msg.classList.add('other-message');
                        }
                    });
                })
                .catch(error => console.error('Error loading messages:', error));
        }
        
        // Set username and hide modal
        function setUsername() {
            const username = document.getElementById('usernameInput').value.trim();
            if (username) {
                pseudo = username;
                document.getElementById('usernameModal').style.display = 'none';
                loadMessages();
                
                // Refresh messages every 2 seconds
                setInterval(loadMessages, 2000);
            } else {
                alert('Veuillez entrer un pseudo valide');
            }
        }
        
        // Send message function
        function sendMessage() {
            const messageInput = document.getElementById('messageInput');
            const message = messageInput.value.trim();
            
            if (!pseudo) {
                alert('Veuillez d\'abord entrer un pseudo');
                return;
            }
            
            if (!message) {
                alert('Veuillez entrer un message');
                return;
            }
            
            const formData = new FormData();
            formData.append('pseudo', pseudo);
            formData.append('message', message);
            
            fetch('send_messages.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    messageInput.value = '';
                    loadMessages(); // Reload messages to show the new one
                } else {
                    alert("Erreur lors de l'envoi du message !");
                }
            })
            .catch(error => {
                console.error('Error sending message:', error);
                alert("Erreur lors de l'envoi du message !");
            });
        }
        
        // Handle image upload
        function handleImageUpload(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            if (!pseudo) {
                alert('Veuillez d\'abord entrer un pseudo');
                return;
            }
            
            // Check file size (limit to 5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('L\'image est trop volumineuse (max 5MB)');
                event.target.value = "";
                return;
            }
            
            const formData = new FormData();
            formData.append('pseudo', pseudo);
            formData.append('image', file);
            
            fetch('send_images.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadMessages(); // Reload messages to show the new image
                } else {
                    alert("Erreur lors de l'envoi de l'image !");
                }
            })
            .catch(error => {
                console.error('Error uploading image:', error);
                alert("Erreur lors de l'envoi de l'image !");
            });
            
            event.target.value = ""; // Reset the file input
        }
        
        // Allow sending message with Enter key
        document.getElementById('messageInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
        
        // Prevent form submission on Enter in input field
        document.getElementById('messageInput').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                sendMessage();
            }
        });
    </script>
</body>
</html>