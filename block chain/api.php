<?php
require_once 'blockchain.php';
session_start();

header("Content-Type: application/json");

// Inicializace blockchainu do session, pokud neexistuje
if (!isset($_SESSION['blockchain'])) {
    $_SESSION['blockchain'] = new Blockchain();
}

$bc = $_SESSION['blockchain'];
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Vrátí celý blockchain a informaci o validitě
        echo json_encode([
            "status" => "success",
            "is_valid" => $bc->isValid(),
            "chain" => $bc->chain
        ], JSON_PRETTY_PRINT);
        break;

    case 'POST':
        // Přidání nového bloku
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (isset($input['data'])) {
            $bc->addBlock($input['data']);
            $_SESSION['blockchain'] = $bc; // Uložení změny
            
            echo json_encode([
                "message" => "Block added successfully",
                "block" => $bc->getLatestBlock()
            ]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Missing 'data' field"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Method not allowed"]);
        break;
}