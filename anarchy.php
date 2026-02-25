<div class="chat-footer">
    <button class="image-btn" onclick="document.getElementById('imageInput').click()">📎</button>
    <input type="file" id="imageInput" accept="image/*" onchange="handleImageUpload(event)">
    <input type="text" id="messageInput" class="message-input" placeholder="Écrire un message...">
    <button class="send-btn" onclick="sendMessage()">Send</button>
</div>

<script>
// Variables globales
let pseudo = localStorage.getItem('chatPseudo') || '';
let chat = document.getElementById('chat');

// Charger les messages
function loadMessages() {
    fetch('get_messages.php')
        .then(response => response.text())
        .then(data => {
            chat.innerHTML = data;
            chat.scrollTop = chat.scrollHeight;
        });
}

// Envoyer un message
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
            loadMessages(); // Recharger les messages pour afficher le nouveau
        }
    });
}

// Gestion de l'upload d'image
function handleImageUpload(event) {
    const file = event.target.files[0];
    if (!file) return;

    if (!pseudo) {
        alert('Veuillez d\'abord entrer un pseudo');
        return;
    }

    const formData = new FormData();
    formData.append("pseudo", pseudo);
    formData.append("image", file);

    fetch("send_image.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const messageDiv = document.createElement("div");
            messageDiv.classList.add("message");

            messageDiv.innerHTML = `
                <span class="pseudo">${pseudo}:</span>
                <br>
                <img src="${data.imagePath}" class="message-image" alt="Image partagée">
            `;

            chat.appendChild(messageDiv);
            chat.scrollTop = chat.scrollHeight;
        } else {
            alert("Erreur lors de l'envoi de l'image !");
        }
    });

    event.target.value = "";
}

// Permettre l'envoi avec la touche Entrée
document.getElementById('messageInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        sendMessage();
    }
});

// Charger les messages au démarrage
if (pseudo) {
    loadMessages();
    setInterval(loadMessages, 2000); // Rafraîchir toutes les 2 secondes
} else {
    // Rediriger vers la page de choix de pseudo si ce n'est pas défini
    window.location.href = 'index.php';
}
</script>