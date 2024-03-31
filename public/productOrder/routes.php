<?php

$path = './public/productOrder/views';
$basePath = "$path/po.";

$po = [
    // Sample Routes
    '/po/dashboard' => $basePath . "dashboard.php",
    '/po/requestOrder' => $basePath . "requestOrder.php",
    '/po/suppliers' => $basePath . "suppliers.php",
    '/po/addsupplier' => $basePath . "addsupplier.php",
    '/po/viewsupplier' => $basePath . "viewsupplier.php",
    '/po/items' => $basePath . "items.php",
    '/po/addItem' => $basePath . "addItem.php",
    '/po/orderDetail' => $basePath . "orderDetail.php",
    '/po/viewdetails' => $basePath . "viewdetails.php",
    '/po/transactionHistory' => $basePath . "transactionHistory.php",
    '/po/requestHistory' => $basePath . "requestHistory.php",

];

Router::post('/po/addItem', function () {
    $db = Database::getInstance();
    $conn = $db->connect();

    $productID = $_POST['productid']; // for product table
    $productName = $_POST['productname']; // for product table
    $supplierName = $_POST['supplier']; // for supplier table
    $description = $_POST['description']; // for product table
    $category = $_POST['category']; // for product table
    $price = $_POST['price']; // for product table 
    $weight = $_POST['weight']; // for product table

    // Check if all necessary data is provided
    if (empty ($productName) || empty ($supplierName)) {
        // Redirect if any required fields are empty
        $rootFolder = dirname($_SERVER['PHP_SELF']);
        header("Location: $rootFolder/po/items");
        return;
    }

    // Handle image upload
    if (isset ($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];

        // Define the relative path to the "uploads" directory
        $uploadDir = 'uploads/';

        // Ensure the upload directory exists and is writable
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
            // Set appropriate permissions if needed (not recommended for production)
// chmod($uploadDir, 0777);
        }

        // Define the file destination path
        $fileDestination = $uploadDir . $fileName;

        // Move the uploaded file to the destination folder
        if (move_uploaded_file($fileTmpName, $fileDestination)) {
            // File uploaded successfully, proceed with insertion

            // Insert data into product table
            $stmt1 = $conn->prepare("INSERT INTO products (ProductID, ProductImage, ProductName, Supplier, Description, Category, Price, ProductWeight) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt1->bindParam(1, $productID, PDO::PARAM_INT);
            $stmt1->bindParam(2, $fileDestination, PDO::PARAM_STR);
            $stmt1->bindParam(3, $productName, PDO::PARAM_STR);
            $stmt1->bindParam(4, $supplierName, PDO::PARAM_STR);
            $stmt1->bindParam(5, $description, PDO::PARAM_STR);
            $stmt1->bindParam(6, $category, PDO::PARAM_STR);
            $stmt1->bindParam(7, $price, PDO::PARAM_INT);
            $stmt1->bindParam(8, $weight, PDO::PARAM_INT);
            $stmt1->execute();

            // Redirect after successful insertion
            $rootFolder = dirname($_SERVER['PHP_SELF']);
            header("Location: $rootFolder/po/items");
            exit (); // Terminate script execution after redirection
        } else {
            // Failed to move uploaded file
            echo "Failed to move uploaded file.";
            return;
        }
    } else {
        // No file uploaded or an error occurred
        echo "File upload failed.";
        return;
    }
});
