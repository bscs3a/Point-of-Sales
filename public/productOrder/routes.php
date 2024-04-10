<?php

$path = './public/productOrder/views';
$basePath = "$path/po.";

$po = [
    // Sample Routes
    '/po/dashboard' => $basePath . "dashboard.php",
    '/po/suppliers' => $basePath . "suppliers.php",
    '/po/items' => $basePath . "items.php",
    '/po/addItem' => $basePath . "addItem.php",
    '/po/orderRequest' => $basePath . "orderRequest.php",
    '/po/transactionHistory' => $basePath . "transactionHistory.php",



];


// add items
Router::post('/po/addItem', function () {
    $db = Database::getInstance();
    $conn = $db->connect();

    $productName = $_POST['productname']; // for product table
    $productID = $_POST['productid']; // for product table
    $supplierName = $_POST['supplier']; // for supplier table
    $category = $_POST['category']; // for category table
    $weight = $_POST['weight']; // for product table
    $price = $_POST['price']; // for product table 
    $description = $_POST['description']; // for product table

    // Check if all necessary data is provided
    if (empty($productName) || empty($supplierName)) {
        // Redirect if any required fields are empty
        $rootFolder = dirname($_SERVER['PHP_SELF']);
        header("Location: $rootFolder/po/items");
        return;
    }

    // Handle file upload
    $fileDestination = '';
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];+
        $fileDestination = 'uploads/' . $fileName;
        move_uploaded_file($fileTmpName, $fileDestination);
    }

    // Insert data into product table
    $stmt1 = $conn->prepare("INSERT INTO products (Product_Name, Product_ID, Product_Weight, Product_Price, Product_Description, Product_Image, p_supplier, p_category) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt1->bindParam(1, $productName, PDO::PARAM_STR);
    $stmt1->bindParam(2, $productID, PDO::PARAM_STR);
    $stmt1->bindParam(3, $weight, PDO::PARAM_INT);
    $stmt1->bindParam(4, $price, PDO::PARAM_INT);
    $stmt1->bindParam(5, $description, PDO::PARAM_STR);
    $stmt1->bindParam(6, $fileDestination, PDO::PARAM_STR); // Assuming you're storing the file path in the database
    $stmt1->bindParam(7, $supplierName, PDO::PARAM_STR);
    $stmt1->bindParam(8, $category, PDO::PARAM_STR);
    $stmt1->execute();

    // // Insert data into supplier table
    // $stmt2 = $conn->prepare("INSERT INTO suppliers (Supplier_Name) VALUES (?)");
    // $stmt2->bindParam(1, $supplierName, PDO::PARAM_STR);
    // $stmt2->execute();

    // // Insert data into category table
    // $stmt3 = $conn->prepare("INSERT INTO categories (Category_Name) VALUES (?)");
    // $stmt3->bindParam(1, $category, PDO::PARAM_STR);
    // $stmt3->execute();

    // Redirect after successful insertion
    $rootFolder = dirname($_SERVER['PHP_SELF']);
    header("Location: $rootFolder/po/items");
});
