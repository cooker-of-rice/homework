<?php
session_start();

echo "<h1>Zobrazení hodnoty přijaté z a.php</h1>";

if (isset($_GET['value'])) {
    echo "<p>Hodnota předaná přes GET: " . htmlspecialchars($_GET['value']) . "</p>";
}

if (isset($_POST['value'])) {
    echo "<p>Hodnota předaná přes POST: " . htmlspecialchars($_POST['value']) . "</p>";
}

if (isset($_GET['method']) && $_GET['method'] === 'session' && isset($_SESSION['value'])) {
    echo "<p>Hodnota předaná přes SESSION: " . htmlspecialchars($_SESSION['value']) . "</p>";
}

if (isset($_GET['method']) && $_GET['method'] === 'cookie' && isset($_COOKIE['value'])) {
    echo "<p>Hodnota předaná přes COOKIE: " . htmlspecialchars($_COOKIE['value']) . "</p>";
}

echo "<a href='a.php'>Zpět na a.php</a>";
?>
