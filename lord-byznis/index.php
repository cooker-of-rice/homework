<?php
session_start();

// 1. KONFIGURACE
$apiKey = 'VASE_OPENAI_API_KEY_ZDE'; // Vložte svůj klíč
$model = 'gpt-3.5-turbo';

// Inicializace historie chatu v session, pokud neexistuje
if (!isset($_SESSION['chat_history'])) {
    $_SESSION['chat_history'] = [
        ['role' => 'system', 'content' => 'Jsi nápomocný asistent.']
    ];
}

// Funkce pro volání OpenAI API
function callOpenAI($messages, $apiKey, $model) {
    $curl = curl_init();
    
    $data = [
        'model' => $model,
        'messages' => $messages,
        'temperature' => 0.7
    ];

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.openai.com/v1/chat/completions",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "Authorization: Bearer " . $apiKey
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        return "Chyba cURL: " . $err;
    } else {
        $decoded = json_decode($response, true);
        if (isset($decoded['error'])) {
            return "Chyba API: " . $decoded['error']['message'];
        }
        return $decoded['choices'][0]['message']['content'];
    }
}

// 2. ZPRACOVÁNÍ FORMULÁŘE (Backend logika)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Pokud uživatel chce vymazat historii
    if (isset($_POST['clear'])) {
        session_destroy();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    // Pokud uživatel poslal zprávu
    if (!empty($_POST['message'])) {
        $userMessage = trim($_POST['message']);

        // Přidat zprávu uživatele do historie
        $_SESSION['chat_history'][] = ['role' => 'user', 'content' => $userMessage];

        // Získat odpověď od AI (posíláme celou historii pro kontext)
        $aiResponse = callOpenAI($_SESSION['chat_history'], $apiKey, $model);

        // Přidat odpověď AI do historie
        $_SESSION['chat_history'][] = ['role' => 'assistant', 'content' => $aiResponse];
        
        // Přesměrování (PRG pattern) aby se formulář neodeslal znovu při F5
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP OpenAI Chat</title>
    <style>
        /* 3. FRONTEND STYLY (přímo v PHP souboru) */
        body { font-family: sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; background: #f0f2f5; }
        .chat-container { background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); overflow: hidden; }
        
        .chat-box { height: 500px; overflow-y: auto; padding: 20px; display: flex; flex-direction: column; gap: 15px; }
        
        .message { padding: 10px 15px; border-radius: 15px; max-width: 75%; line-height: 1.4; word-wrap: break-word; }
        .user { align-self: flex-end; background-color: #0084ff; color: white; border-bottom-right-radius: 2px; }
        .assistant { align-self: flex-start; background-color: #e4e6eb; color: black; border-bottom-left-radius: 2px; }
        .system { display: none; } /* Systémové zprávy schováme */

        form { display: flex; padding: 20px; border-top: 1px solid #ddd; background: #fff; }
        input[type="text"] { flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 20px; margin-right: 10px; outline: none; }
        button { padding: 10px 20px; border: none; border-radius: 20px; cursor: pointer; font-weight: bold; }
        .btn-send { background-color: #0084ff; color: white; }
        .btn-send:hover { background-color: #006bcf; }
        .btn-clear { background-color: #ff4d4d; color: white; margin-left: 5px; }
        
        /* Loading stav (jednoduchý text) */
        .loading { text-align: center; color: #666; font-style: italic; display: none; }
    </style>
</head>
<body>

    <h1>Chat s AI</h1>

    <div class="chat-container">
        <div class="chat-box" id="chatBox">
            <?php foreach ($_SESSION['chat_history'] as $msg): ?>
                <?php if ($msg['role'] !== 'system'): ?>
                    <div class="message <?php echo $msg['role']; ?>">
                        <strong><?php echo $msg['role'] === 'user' ? 'Vy' : 'AI'; ?>:</strong><br>
                        <?php echo nl2br(htmlspecialchars($msg['content'])); ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <form method="POST" onsubmit="document.getElementById('loading').style.display='block'">
            <input type="text" name="message" placeholder="Napište zprávu..." required autofocus>
            <button type="submit" class="btn-send">Odeslat</button>
            <button type="submit" name="clear" value="1" class="btn-clear" formnovalidate>Smazat chat</button>
        </form>
        
        <div id="loading" class="loading">Čekám na odpověď od OpenAI... (stránka se obnoví)</div>
    </div>

    <script>
        // Malý JS helper, který po načtení stránky sjede v chatu dolů
        var chatBox = document.getElementById("chatBox");
        chatBox.scrollTop = chatBox.scrollHeight;
    </script>

</body>
</html> prosím upravit frontend