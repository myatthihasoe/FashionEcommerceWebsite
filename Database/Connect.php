<?php
require_once("Connection.php");
$host = "localhost"; //127.0.0.1
$dbname = "mysql";
$username = "root";
$password = "nelson*123";
$ecommerce = "ecommerce";

$connect = new Connection($host, $dbname, $username, $password);
$pdo = $connect->getConnection();

//Use try catch if create database
try {
    $create_database = "CREATE DATABASE IF NOT EXISTS $ecommerce";
    $pdo->exec($create_database);
    $pdo->exec("USE $ecommerce");
} catch (PDOException $e) {
    echo $e->getMessage();
}

