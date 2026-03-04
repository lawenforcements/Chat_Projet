<?php
// Database connection
$pdo = new PDO(
    "mysql:host=127.0.0.1;dbname=anarchy;charset=utf8",
    "root",
    ""
);

// Sanitize input
$pseudo = htmlspecialchars($_POST['pseudo']);
$message = htmlspecialchars($_POST['message']);

// Default = no image
$imagePath = "";

// If an image is uploaded
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

    $filename = uniqid() . "_" . basename($_FILES['image']['name']);
    $targetFile = $targetDir . $filename;

    move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
    $imagePath = $targetFile;
}

// Insert into database
if ($imagePath) {
    // Image message
    $stmt = $pdo->prepare("INSERT INTO messages (username, type, content) VALUES (?, 'image', ?)");
    $stmt->execute([$pseudo, $imagePath]);
} else {
    // Text message
    $stmt = $pdo->prepare("INSERT INTO messages(username,type,content,created_at) values (?, 'text', ?,now())");
    $stmt->execute([$pseudo, $message]);
}

echo "OK";
?>