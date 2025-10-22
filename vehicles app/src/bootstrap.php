<?php
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once __DIR__ . '/../vendor/autoload.php';

// Cesty k adresářům s entitami
$paths = [__DIR__ . '/Entity'];
$isDevMode = true;

// Konfigurace připojení k databázi
$dbParams = [
    'driver'   => 'pdo_mysql',
    'host'     => 'localhost',
    'user'     => 'root',
    'password' => '',
    'dbname'   => 'vehicles',
    'charset'  => 'utf8mb4'
];

// Nastavení konfigurace
$config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);

// Vytvoření EntityManageru
$entityManager = EntityManager::create($dbParams, $config);

return $entityManager;