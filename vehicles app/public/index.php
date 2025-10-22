<?php
require_once __DIR__ . '/../src/bootstrap.php';

use App\Entity\Model;

// Nastavení hlavičky pro UTF-8
header('Content-Type: text/html; charset=utf-8');

// Funkce pro zobrazení chyby
function displayError($message) {
    echo "<div style='color: red; padding: 10px; background-color: #ffeeee; border: 1px solid #ffcccc; margin: 10px 0;'>";
    echo $message;
    echo "</div>";
    exit;
}

// Zachycení chyb při připojení k databázi
try {
    $modelRepository = $entityManager->getRepository(Model::class);

    // Zpracování filtrů
    $manufacturer = $_GET['manufacturer'] ?? null;
    $modelName = $_GET['model'] ?? null;
    $showWithOwners = isset($_GET['with_owners']);

    // Aplikace filtrů
    if ($manufacturer) {
        $models = $modelRepository->findByManufacturerName($manufacturer);
        $title = "Modely výrobce: $manufacturer";
    } elseif ($modelName) {
        $models = $modelRepository->findByModelName($modelName);
        $title = "Modely obsahující: $modelName";
    } elseif ($showWithOwners) {
        $models = $modelRepository->findModelsWithOwners();
        $title = "Modely s informacemi o majitelích";
    } else {
        $models = $modelRepository->findAllWithManufacturers();
        $title = "Všechny modely vozidel";
    }
} catch (Exception $e) {
    displayError("Chyba při připojení k databázi: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Databáze vozidel - <?php echo htmlspecialchars($title); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        h1 {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }
        .filters {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }
        .filters form {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        .filters label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        button:hover {
            background-color: #2980b9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e9f7fe;
        }
        .empty-result {
            padding: 20px;
            text-align: center;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 20px;
        }
        .owner {
            background-color: #e8f4ea;
            padding: 5px;
            border-radius: 3px;
            margin: 2px 0;
        }
    </style>
</head>
<body>
    <h1>Databáze vozidel</h1>

    <div class="filters">
        <form method="get">
            <div>
                <label for="manufacturer">Výrobce:</label>
                <input type="text" id="manufacturer" name="manufacturer" 
                    value="<?php echo htmlspecialchars($manufacturer ?? ''); ?>">
            </div>
            <div>
                <label for="model">Model:</label>
                <input type="text" id="model" name="model"
                    value="<?php echo htmlspecialchars($modelName ?? ''); ?>">
            </div>
            <div>
                <label for="with_owners">S majiteli:</label>
                <input type="checkbox" id="with_owners" name="with_owners" 
                    <?php echo $showWithOwners ? 'checked' : ''; ?>>
            </div>
            <div style="align-self: flex-end;">
                <button type="submit">Filtrovat</button>
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>" style="margin-left: 10px; color: #777;">Zrušit filtry</a>
            </div>
        </form>
    </div>

    <h2><?php echo htmlspecialchars($title); ?></h2>

    <?php if (empty($models)): ?>
        <div class="empty-result">
            Nebyla nalezena žádná data odpovídající zadaným kritériím.
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Model</th>
                    <th>Výrobce</th>
                    <?php if ($showWithOwners): ?>
                        <th>Majitelé</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($models as $model): ?>
                    <tr>
                        <td><?php echo $model->getId(); ?></td>
                        <td><?php echo htmlspecialchars($model->getModelName()); ?></td>
                        <td><?php echo htmlspecialchars($model->getManufacturer()->getManufacturerName()); ?></td>
                        <?php if ($showWithOwners): ?>
                            <td>
                                <?php 
                                $cars = $model->getCars();
                                if ($cars->count() > 0) {
                                    foreach ($cars as $car) {
                                        $owner = $car->getOwner();
                                        if ($owner) {
                                            echo '<div class="owner">';
                                            echo 'VIN: ' . htmlspecialchars($car->getVinCode()) . '<br>';
                                            echo 'Majitel: ' . htmlspecialchars($owner->getFullName()) . '<br>';
                                            echo 'Email: ' . htmlspecialchars($owner->getEmail());
                                            echo '</div>';
                                        } else {
                                            echo '<div class="owner">VIN: ' . htmlspecialchars($car->getVinCode()) . ' - Bez majitele</div>';
                                        }
                                    }
                                } else {
                                    echo "Žádná registrovaná vozidla";
                                }
                                ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>