<?php

$server = 'localhost';
$username = 'id20803748_diego13';
$password = 'Hola1234.';
$database = 'id20803748_login_database';

try {
  $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch (PDOException $e) {
  die('Connection Failed: ' . $e->getMessage());
}

?>
