<?php
session_start();

echo "<h1>Hodnota přijatá ve skriptu b.php</h1>";

// 1. Přijetí hodnoty přes GET
if (isset($_GET['method']) && $_GET['method'] === 'get' && isset($_GET['number'])) {
    echo "<h2>1. Hodnota přijatá pomocí GET:</h2>";
    echo "Hodnota je: " . htmlspecialchars($_GET['number']) . "<br>";
}

// 2. Přijetí hodnoty přes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['method']) && $_POST['method'] === 'post') {
    echo "<h2>2. Hodnota přijatá pomocí POST:</h2>";
    echo "Hodnota je: " . htmlspecialchars($_POST['number']) . "<br>";
}

// 3. Přijetí hodnoty přes Session
if (isset($_GET['method']) && $_GET['method'] === 'session' && isset($_SESSION['randomNumber'])) {
    echo "<h2>3. Hodnota přijatá pomocí Session:</h2>";
    echo "Hodnota je: " . htmlspecialchars($_SESSION['randomNumber']) . "<br>";
}

// 4. Přijetí hodnoty přes Cookies
if (isset($_GET['method']) && $_GET['method'] === 'cookie' && isset($_COOKIE['randomNumber'])) {
    echo "<h2>4. Hodnota přijatá pomocí Cookies:</h2>";
    echo "Hodnota je: " . htmlspecialchars($_COOKIE['randomNumber']) . "<br>";
}

// 5. Přijetí hodnoty přes HTTP přesměrování
if (isset($_GET['method']) && $_GET['method'] === 'redirect' && isset($_GET['number'])) {
    echo "<h2>5. Hodnota přijatá přes HTTP přesměrování:</h2>";
    echo "Hodnota je: " . htmlspecialchars($_GET['number']) . "<br>";
}
?>
