<?php

$httpHost = $_SERVER['HTTP_HOST'] ?? '';
$isProductionHost = (strpos($httpHost, 'djerbavoyage.tn') !== false);

$host     = $_ENV['DB_HOST']     ?? getenv('DB_HOST')     ?: '127.0.0.1';
$port     = (int)($_ENV['DB_PORT'] ?? getenv('DB_PORT')   ?: 3306);
$dbname   = $_ENV['DB_NAME']     ?? getenv('DB_NAME')     ?: ($isProductionHost ? 'dveuvwkq_djerbavoyage' : 'djerba_voyage');
$username = $_ENV['DB_USER']     ?? getenv('DB_USER')     ?: ($isProductionHost ? 'dveuvwkq_djerbavoyage' : 'root');
$password = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ?: ($isProductionHost ? 'Djerba_Voyage_2026' : '');

return [
    'host'     => $host,
    'port'     => $port,
    'dbname'   => $dbname,
    'username' => $username,
    'password' => $password,
    'charset'  => 'utf8mb4'
];
