<?php
header('Content-Type: application/json');

$pseudo = htmlspecialchars($_POST['pseudo']);
$imagePath = "";

if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

    $filename = uniqid() . "_" . basename($_FILES['image']['name']);
    $targetFile = $targetDir . $filename;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        $imagePath = $targetFile;

        // Sauvegarde dans messages.txt pour persistance avec le bon format
        $file = fopen("messages.txt", "a");
        fwrite($file, $pseudo . "|[image]|" . $imagePath . "\n");
        fclose($file);

        echo json_encode(["success" => true, "imagePath" => $imagePath]);
        exit;
    }
}

echo json_encode(["success" => false]);
?>