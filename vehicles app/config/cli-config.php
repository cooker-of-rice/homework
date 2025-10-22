<?php
require_once __DIR__ . '/../src/bootstrap.php';

// Vrácení EntityManageru pro použití s Doctrine CLI
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);