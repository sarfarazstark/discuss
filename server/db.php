<?php
$host = 'localhost'; // or your PostgreSQL server address
$port = '5432'; // default PostgreSQL port
$dbname = 'discuss';
$username = 'postgres';
$password = '';


$dsn = "pgsql:host=$host;port=$port;dbname=$dbname";


try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage());
}