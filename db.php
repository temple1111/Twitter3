<?php
require_once 'config.php';
$URL = $_ENV['APP_URL'];
$DB_NAME = $_ENV['DB_NAME'];
$DB_USERNAME = $_ENV['DB_USERNAME'];
$DB_PASSWORD = $_ENV['DB_PASSWORD'];
$DB_CONNECTION = $_ENV['DB_CONNECTION'];
try {
    $pdo = new PDO('mysql:dbname='.$DB_NAME.';host='.$URL.';charset=utf8',
    ''.$DB_USERNAME.'',''.$DB_PASSWORD.'');
} catch(PDOException $e) {
    echo 'DB接続エラー: ' . $e->getMessage();
}
?>
