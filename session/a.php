<?php
// Generování náhodné hodnoty
$randomNumber = rand(1, 100);

// Spuštění session pro použití session proměnných
session_start();
$_SESSION['randomNumber'] = $randomNumber;

// Nastavení cookie s hodnotou
setcookie('randomNumber', $randomNumber, time() + 3600, "/");

echo "<h1>Přenos hodnoty mezi a.php a b.php různými způsoby</h1>";
echo "<p>Generovaná hodnota je: <strong>$randomNumber</strong></p>";

// 1. Přenos pomocí GET metody
echo "<h2>1. Přenos pomocí GET</h2>";
echo "<a href='b.php?method=get&number=$randomNumber'>Otevřít b.php s GET metodou</a><br>";

// 2. Přenos pomocí POST metody (formulář)
echo "<h2>2. Přenos pomocí POST</h2>";
echo "
<form action='b.php' method='POST'>
    <input type='hidden' name='method' value='post'>
    <input type='hidden' name='number' value='$randomNumber'>
    <button type='submit'>Odeslat číslo pomocí POST</button>
</form>
";

// 3. Přenos pomocí Session
echo "<h2>3. Přenos pomocí Session</h2>";
echo "<a href='b.php?method=session'>Otevřít b.php s použitím Session</a><br>";

// 4. Přenos pomocí Cookies
echo "<h2>4. Přenos pomocí Cookies</h2>";
echo "<a href='b.php?method=cookie'>Otevřít b.php s použitím Cookies</a><br>";

// 5. Přenos pomocí přesměrování (HTTP 302)
echo "<h2>5. Přenos pomocí HTTP přesměrování</h2>";
echo "<form action='b.php' method='GET'>
    <input type='hidden' name='number' value='$randomNumber'>
    <input type='hidden' name='method' value='redirect'>
    <button type='submit'>Přesměrovat na b.php s číslem</button>
</form>";
?>
