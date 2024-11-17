<?php
$randomValue = rand(1, 100);

echo "<h1>Generovaná hodnota: $randomValue</h1>";
echo "<p>Odkazy na b.php s různými metodami:</p>";

echo "<a href='b.php?value=$randomValue'>Předání pomocí GET</a><br>";

echo "
    <form action='b.php' method='post'>
        <input type='hidden' name='value' value='$randomValue'>
        <button type='submit'>Předání pomocí POST</button>
    </form>
";

session_start();
$_SESSION['value'] = $randomValue;
echo "<a href='b.php?method=session'>Předání pomocí SESSION</a><br>";

setcookie('value', $randomValue, time() + 3600, '/');
echo "<a href='b.php?method=cookie'>Předání pomocí COOKIE</a><br>";
?>
