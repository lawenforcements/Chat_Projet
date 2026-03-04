<?php
// Connect to database
$pdo = new PDO(
    "mysql:host=127.0.0.1;dbname=anarchy;charset=utf8",
    "root",
    ""
);

$stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at ASC");

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $pseudo = htmlspecialchars($row['username']);
    $type   = $row['type'];
    $content = htmlspecialchars($row['content']);

    echo "<div class='message'>";
    echo "<span class='pseudo'>{$pseudo}:</span> ";

    if ($type === "image") {
        echo "<br><img src='{$content}' class='message-image' alt='Image partagée'>";
    } else {
        echo $content;
    }

    echo "</div>";
}
?>