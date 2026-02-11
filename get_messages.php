<?php
if (file_exists("messages.txt")) {
    $lines = file("messages.txt", FILE_IGNORE_NEW_LINES);

    foreach ($lines as $line) {
        list($pseudo, $type, $content) = explode("|", $line);

        echo "<div class='message'>";
        echo "<span class='pseudo'>{$pseudo}:</span> ";

        if ($type === "[image]") {
            echo "<br><img src='{$content}' class='message-image' alt='Image partagée'>";
        } else {
            echo htmlspecialchars($content);
        }

        echo "</div>";
    }
}
?>
