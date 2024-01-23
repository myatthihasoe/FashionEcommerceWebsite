<?php
require_once("../Database/Connect.php");

$id = $_GET['id'];
echo $id;
$delete_sql = "DELETE FROM products WHERE product_id = '$id'";

try {
    $pdo->exec($delete_sql);
    // echo"product deleted";
    header("Location: ViewProducts.php");
} catch (Exception $e) {
    echo $e->getMessage();
}