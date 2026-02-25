<?php
if (file_exists("messages.txt")) {
    $lines = file("messages.txt", FILE_IGNORE_NEW_LINES);

    foreach ($lines as $line) {
        // Split the line by | delimiter
        $parts = explode("|", $line, 3); // Limit to 3 parts to handle messages with | inside
        
        if (count($parts) >= 3) {
            $pseudo = $parts[0];
            $type = $parts[1];
            $content = $parts[2];

            echo "<div class='message'>";
            echo "<span class='pseudo'>" . htmlspecialchars($pseudo) . ":</span> ";

            if ($type === "[image]") {
                echo "<br><img src='" . htmlspecialchars($content) . "' class='message-image' alt='Image partagée'>";
            } else {
                echo htmlspecialchars($content);
            }

            echo "</div>";
        }
    }
}
?>