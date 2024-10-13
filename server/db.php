<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$host = $_ENV['DB_HOST']; // or your PostgreSQL server address
$port = $_ENV['DB_PORT']; // default PostgreSQL port
$dbname = $_ENV['DB_DATABASE']; // your database name
$username = $_ENV['DB_USERNAME']; // your database username
$password = $_ENV['DB_PASSWORD']; // your database password


$dsn = "pgsql:host=$host;port=$port;dbname=$dbname";


try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage());
}
