# Karel Robot

Tento projekt implementuje dvě verze aplikace **Karel Robot**:

1. **Čistě klientská aplikace** pomocí HTML, CSS a JavaScriptu.
2. **Serverová aplikace** s využitím HTML, CSS a PHP.

Aplikace umožňuje ovládat jednoduchého robota Karla pomocí textových příkazů na 2D herním poli.

---

## Funkce a příkazy

- **KROK**: Karel se posune o zadaný počet kroků ve směru svého natočení. Pokud není uvedeno, provede jeden krok. Například:

  - `KROK 4` (4 kroky vpřed)
  - `KROK` (1 krok vpřed)

- **VLEVOBOK**: Karel se otočí doleva o 90° zadaný početkrát. Pokud není uvedeno, otočí se jednou. Například:

  - `VLEVOBOK 2` (otočení o 180°)
  - `VLEVOBOK` (otočení o 90°)

- **POLOZ**: Položí na aktuální pozici příkazu (např. písmeno nebo barvu). Například:

  - `POLOZ A` (položí písmeno "A" na aktuální pozici)

- **RESET**: Vyčistí herní pole a nastaví Karla do výchozí pozice (levý horní roh, natočen doprava).

### Ukázkový vstup:

```plaintext
KROK 3
VLEVOBOK 2
KROK 2
POLOZ A
RESET
KROK 5
POLOZ B
```

---

## HTML, CSS a JavaScript

### Popis

Aplikace běží kompletně na straně klienta v prohlížeči. Příkazy jsou zpracovány v JavaScriptu a herní pole je aktualizováno přímo v DOMu.

### Skript: karel_client.html

```html
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karel Robot (Client-side)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            padding: 20px;
        }
        #grid {
            display: grid;
            grid-template-columns: repeat(10, 40px);
            grid-template-rows: repeat(10, 40px);
            gap: 1px;
            margin-bottom: 20px;
        }
        .cell {
            width: 40px;
            height: 40px;
            background-color: #eee;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 18px;
        }
        .karel {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Karel Robot</h1>
    <textarea id="commands" rows="10" cols="30" placeholder="Zadejte příkazy..."></textarea>
    <br>
    <button onclick="executeCommands()">Proveď</button>
    <div id="grid"></div>

    <script>
        const gridSize = 10;
        let grid = Array.from({ length: gridSize }, () => Array(gridSize).fill(''));
        let karel = { x: 0, y: 0, direction: 0 }; // 0 = vpravo, 1 = dolů, 2 = vlevo, 3 = nahoru

        function drawGrid() {
            const gridDiv = document.getElementById('grid');
            gridDiv.innerHTML = '';
            for (let y = 0; y < gridSize; y++) {
                for (let x = 0; x < gridSize; x++) {
                    const cell = document.createElement('div');
                    cell.className = 'cell';
                    if (karel.x === x && karel.y === y) {
                        cell.classList.add('karel');
                    }
                    cell.textContent = grid[y][x];
                    gridDiv.appendChild(cell);
                }
            }
        }

        function executeCommands() {
            const commands = document.getElementById('commands').value.toUpperCase().split('\n');
            for (let line of commands) {
                const [command, param] = line.trim().split(/\s+/);
                switch (command) {
                    case 'KROK':
                        const steps = param ? parseInt(param, 10) : 1;
                        for (let i = 0; i < steps; i++) {
                            if (karel.direction === 0) karel.x = (karel.x + 1) % gridSize;
                            else if (karel.direction === 1) karel.y = (karel.y + 1) % gridSize;
                            else if (karel.direction === 2) karel.x = (karel.x - 1 + gridSize) % gridSize;
                            else if (karel.direction === 3) karel.y = (karel.y - 1 + gridSize) % gridSize;
                        }
                        break;
                    case 'VLEVOBOK':
                        const turns = param ? parseInt(param, 10) : 1;
                        karel.direction = (karel.direction - turns + 4) % 4;
                        break;
                    case 'POLOZ':
                        grid[karel.y][karel.x] = param || '';
                        break;
                    case 'RESET':
                        grid = Array.from({ length: gridSize }, () => Array(gridSize).fill(''));
                        karel = { x: 0, y: 0, direction: 0 };
                        break;
                }
            }
            drawGrid();
        }

        drawGrid();
    </script>
</body>
</html>
```

---

## HTML, CSS a PHP

### Popis

Aplikace funguje na principu klient-server. Zadané příkazy se odešlou na server pomocí HTTP POST. PHP server příkazy zpracuje, vygeneruje nové herní pole a vrátí jej zpět klientovi.

### Použití

1. Nahrajte soubor `karel_server.php` na server s podporou PHP.
2. Otevřete aplikaci v prohlížeči (např. `http://localhost/karel_server.php`).
3. Do textového pole zadejte příkazy a odešlete formulář.
4. Server zpracuje příkazy a zobrazí aktualizované herní pole.

### Skript: karel_server.php

```php
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karel Robot (PHP)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            padding: 20px;
        }
        #grid {
            display: grid;
            grid-template-columns: repeat(10, 40px);
            grid-template-rows: repeat(10, 40px);
            gap: 1px;
            margin-bottom: 20px;
        }
        .cell {
            width: 40px;
            height: 40px;
            background-color: #eee;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 18px;
        }
        .karel {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Karel Robot (PHP)</h1>
    <form method="post">
        <textarea name="commands" rows="10" cols="30" placeholder="Zadejte příkazy..."></textarea>
        <br>
        <button type="submit">Proveď</button>
    </form>

    <div id="grid">
        <?php
        $gridSize = 10;
        $grid = array_fill(0, $gridSize, array_fill(0, $gridSize, ''));

        $karel = ["x" => 0, "y" => 0, "direction" => 0]; // 0 = vpravo, 1 = dolů, 2 = vlevo, 3 = nahoru

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $commands = strtoupper(trim($_POST['commands'] ?? ''));
            $lines = explode("\n", $commands);

            foreach ($lines as $line) {
                $parts = preg_split('/\s+/', trim($line));
                $command = $parts[0];
                $param = $parts[1] ?? '';

                switch ($command) {
                    case 'KROK':
                        $steps = max(1, (int)$param);
                        for ($i = 0; $i < $steps; $i++) {
                            switch ($karel['direction']) {
                                case 0: $karel['x'] = ($karel['x'] + 1) % $gridSize; break;
                                case 1: $karel['y'] = ($karel['y'] + 1) % $gridSize; break;
                                case 2: $karel['x'] = ($karel['x'] - 1 + $gridSize) % $gridSize; break;
                                case 3: $karel['y'] = ($karel['y'] - 1 + $gridSize) % $gridSize; break;
                            }
                        }
                        break;
                    case 'VLEVOBOK':
                        $turns = max(1, (int)$param);
                        $karel['direction'] = ($karel['direction'] - $turns + 4) % 4;
                        break;
                    case 'POLOZ':
                        $grid[$karel['y']][$karel['x']] = $param;
                        break;
                    case 'RESET':
                        $grid = array_fill(0, $gridSize, array_fill(0, $gridSize, ''));
                        $karel = ["x" => 0, "y" => 0, "direction" => 0];
                        break;
                }
            }
        }

        for ($y = 0; $y < $gridSize; $y++) {
            for ($x = 0; $x < $gridSize; $x++) {
                $class = 'cell';
                if ($karel['x'] == $x && $karel['y'] == $y) {
                    $class .= ' karel';
                }
                echo "<div class='$class'>" . htmlspecialchars($grid[$y][$x]) . "</div>";
            }
        }
        ?>
    </div>
</body>
</html>
```
