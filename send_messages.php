<?php
$pseudo = htmlspecialchars($_POST['pseudo']);
$message = htmlspecialchars($_POST['message']);

// Vérifier si un fichier image est envoyé
$imagePath = "";
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

    $filename = uniqid() . "_" . basename($_FILES['image']['name']);
    $targetFile = $targetDir . $filename;

    move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
    $imagePath = $targetFile;
}

// Stocker le message avec le bon format (pseudo|type|contenu)
$file = fopen("messages.txt", "a");

if ($imagePath) {
    // Si c'est une image
    fwrite($file, $pseudo . "|[image]|" . $imagePath . "\n");
} else {
    // Si c'est un message texte
    fwrite($file, $pseudo . "|[text]|" . $message . "\n");
}
fclose($file);
?>