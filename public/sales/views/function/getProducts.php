<?php
require_once './src/dbconn.php';

function getProductsAndCategories() {
    // Get PDO instance
    $database = Database::getInstance();
    $pdo = $database->connect();

    // Query for products
    $sqlProducts = "SELECT * FROM products";
    $stmtProducts = $pdo->query($sqlProducts);
    $products = $stmtProducts->fetchAll(PDO::FETCH_ASSOC);

    // Query for categories
    $sqlCategories = "SELECT DISTINCT Category FROM products";
    $stmtCategories = $pdo->query($sqlCategories);
    $categories = $stmtCategories->fetchAll(PDO::FETCH_COLUMN);

    return ['products' => $products, 'categories' => $categories];
}
?>