<div class="chat-footer">
    <button class="image-btn" onclick="document.getElementById('imageInput').click()">📎</button>
    <input type="file" id="imageInput" accept="image/*" onchange="handleImageUpload(event)">
    <input type="text" id="messageInput" class="message-input" placeholder="Écrire un message...">
    <button class="send-btn" onclick="sendMessage()">Send</button>
</div>

<script>
//... ton code pseudo / loadMessages / sendMessage ici ...

function handleImageUpload(event) {
    const file = event.target.files[0];
    if (!file) return;

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
</script>
