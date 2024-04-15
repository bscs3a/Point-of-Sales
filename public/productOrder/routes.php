<?php

$path = './public/productOrder/views';
$basePath = "$path/po.";

$po = [
    // Sample Routes
    '/po/login' => $basePath . "login.php",
    '/po/dashboard' => $basePath . "dashboard.php",
    '/po/requestOrder' => $basePath . "requestOrder.php",
    '/po/suppliers' => $basePath . "suppliers.php",
    '/po/addsupplier' => $basePath . "addsupplier.php",
    '/po/viewsupplier' => $basePath . "viewsupplier.php",
    '/po/viewsupplierproduct' => $basePath . "viewsupplierproduct.php",
    '/po/items' => $basePath . "items.php",
    '/po/addItem' => $basePath . "addItem.php",
    '/po/addbulk' => $basePath . "addbulk.php",
    '/po/orderDetail' => $basePath . "orderDetail.php",
    '/po/viewdetails' => $basePath . "viewdetails.php",
    '/po/transactionHistory' => $basePath . "transactionHistory.php",
    '/po/requestHistory' => $basePath . "requestHistory.php",
    '/po/updateRequestStatus' => $basePath . "updateRequestStatus.php",
    '/po/viewtransaction' => $basePath . "viewtransaction.php",
    '/po/editsupplier' => $basePath . "editsupplier.php",
    '/po/test' => $basePath . "test.php",
    '/po/test1' => $basePath . "test1.php",

    //umm idk what to say here view orders route
    '/po/viewdetails/Batch={id}' => function ($id) use ($basePath) {
        // $_SESSION['id'] = $id;
        $_GET['id'] = $id;
        include $basePath . "viewdetails.php";
    },
    //for viewing the transaction information based on the batch id
    '/po/viewtransaction/Batch={id}' => function ($id) use ($basePath) {
        // $_SESSION['id'] = $id;
        $_GET['id'] = $id;
        include $basePath . "viewtransaction.php";
    },
    // view supplier information route
    '/po/viewsupplier/Supplier={Supplier_ID}' => function ($id) use ($basePath) {
        // $_SESSION['id'] = $id;
        $_GET['Supplier_ID'] = $id;
        include $basePath . "viewsupplier.php";
    },
    // view supplier products route
    '/po/viewsupplierproduct/Supplier={Supplier_ID}' => function ($id) use ($basePath) {
        // $_SESSION['id'] = $id;
        $_GET['Supplier_ID'] = $id;
        include $basePath . "viewsupplierproduct.php";
    },
    // for adding bulk orders based on the supplier id
    '/po/addbulk/Supplier={Supplier_ID}' => function ($id) use ($basePath) {
        // $_SESSION['id'] = $id;
        $_GET['Supplier_ID'] = $id;
        include $basePath . "addbulk.php";
    },
    // for edditing the supplier information + products based on the Supplier_ID in the $GET
    '/po/editsupplier/Supplier={Supplier_ID}' => function ($id) use ($basePath) {
        // $_SESSION['id'] = $id;
        $_GET['Supplier_ID'] = $id;
        include $basePath . "editsupplier.php";
    },

    '/po/test1/pagenumber={page}' => function ($page) use ($basePath) {
        $_GET['page'] = $page; // Update the $_GET key to 'page' to match the parameter used in test.php
        include $basePath . "test1.php";
    },
];

Router::post('/login/user', function () {
    // Establish database connection
    $db = Database::getInstance();
    $conn = $db->connect();

    try {
        // Retrieve username from POST request
        $username = $_POST['username'];

        // Prepare SQL statement to fetch user record from the database
        $stmt = $conn->prepare("SELECT * FROM accounts WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the user exists
        if ($user) {
            // Authentication successful
            // Set a session variable to indicate the user is logged in

            $_SESSION['employee'] = $user['employee'];

            // Insert log entry for successful login audit log
            $user_id = $user['employee'];
            $action = "Logged In";
            $time_out = "00:00:00"; // Set the time_out value to '00:00:00'

            $sql = "INSERT INTO audit_log (user, action, time_out) VALUES (:user_id, :action, :time_out)";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':user_id', $user_id);
            $stmt->bindValue(':action', $action);
            $stmt->bindValue(':time_out', $time_out);
            $stmt->execute();

            $rootFolder = dirname($_SERVER['PHP_SELF']);
            // Redirect to the dashboard page after successful login
            header("Location: $rootFolder/po/dashboard");
            exit ();
        } else {
            // Authentication failed
            echo "Invalid username or password!";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
});


Router::post('/logout/user', function () {
    // Establish database connection
    $db = Database::getInstance();
    $conn = $db->connect();

    try {
        if (isset ($_SESSION['employee'])) {
            // Retrieve the last time_in from the audit_log table based on user
            $stmt = $conn->prepare("SELECT time_in FROM audit_log WHERE user = (SELECT employee FROM accounts WHERE employee = :employee) ORDER BY audit_ID DESC LIMIT 1");
            $stmt->bindParam(':employee', $_SESSION['employee']);
            $stmt->execute();
            $last_time_in = $stmt->fetchColumn();


        }

        // Insert logout action into audit_log table
        if (isset ($_SESSION['employee'])) {
            $employee = $_SESSION['employee'];
            $action = "Logged Out";
            // Use the last_time_in value obtained earlier as the time_in value when logging out
            $sql = "INSERT INTO audit_log (user, action, time_in) VALUES ((SELECT employee FROM accounts WHERE employee = :employee), :action, :last_time_in)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':employee', $employee);
            $stmt->bindParam(':action', $action);
            $stmt->bindParam(':last_time_in', $last_time_in);
            $stmt->execute();
        }

        // Unset all of the session variables
        $_SESSION = array ();

        // Destroy the session
        session_destroy();

        // Redirect the user to the login page after logout
        $rootFolder = dirname($_SERVER['PHP_SELF']);
        header("Location: $rootFolder/po/login");
        exit ();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
});

Router::post('/insert/addsupplier/', function () {
    // Establish database connection
    $db = Database::getInstance();
    $conn = $db->connect();

    try {
        // Retrieve form data directly from the $_POST superglobal
        $suppliername = $_POST["suppliername"];
        $contactname = $_POST["contactname"];
        $contactnum = $_POST["contactnum"];
        $status = $_POST["status"];
        $email = $_POST["email"];
        $address = $_POST["address"];
        $delivery = $_POST["delivery"];

        // Prepare SQL statement for inserting supplier data
        $supplierSql = "INSERT INTO suppliers (Supplier_Name, Contact_Name, Contact_Number, Status, Email, Address, Estimated_Delivery) 
                        VALUES (:suppliername, :contactname, :contactnum, :status, :email, :address, :delivery)";
        $supplierStmt = $conn->prepare($supplierSql);
        $supplierStmt->bindParam(':suppliername', $suppliername);
        $supplierStmt->bindParam(':contactname', $contactname);
        $supplierStmt->bindParam(':contactnum', $contactnum);
        $supplierStmt->bindParam(':status', $status);
        $supplierStmt->bindParam(':email', $email);
        $supplierStmt->bindParam(':address', $address);
        $supplierStmt->bindParam(':delivery', $delivery);

        // Execute the supplier SQL statement
        $supplierStmt->execute();

        // Retrieve the last inserted supplier ID
        $supplierId = $conn->lastInsertId();

        // Loop through each row of product data
        for ($i = 1; $i <= 5; $i++) { // Assuming there are 5 rows of product data
            $productName = $_POST["productName$i"];
            $categoryName = $_POST["category$i"];
            $price = $_POST["price$i"];
            $description = $_POST["description$i"];

            // Handle file upload for each row
            $fileFieldName = "productImage$i";
            $fileUploadPath = "uploads/"; // Adjust this path accordingly

            if ($_FILES[$fileFieldName]['error'] == UPLOAD_ERR_OK) {
                $fileName = basename($_FILES[$fileFieldName]['name']);
                $uploadPath = $fileUploadPath . $fileName;

                if (move_uploaded_file($_FILES[$fileFieldName]['tmp_name'], $uploadPath)) {
                    // File uploaded successfully, proceed with database insertion
                    // Prepare SQL statement for inserting product data
                    $productSql = "INSERT INTO products (Supplier_ID, Category_ID, ProductName, Description, Price, Category, ProductImage, Supplier) 
                                VALUES (:supplierId, :categoryId, :productName, :description, :price, :categoryName, :productImage, :suppliername)";
                    $productStmt = $conn->prepare($productSql);

                    // Retrieve the category_id based on the category name
                    $stmt = $conn->prepare("SELECT category_id FROM categories WHERE category_name = ?");
                    $stmt->bindParam(1, $categoryName, PDO::PARAM_STR);
                    $stmt->execute();
                    $category = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (!$category) {
                        echo "Category not found.";
                        return;
                    }

                    $categoryId = $category['category_id'];

                    // Bind parameters for product SQL statement
                    $productStmt->bindParam(':supplierId', $supplierId);
                    $productStmt->bindParam(':categoryId', $categoryId);
                    $productStmt->bindParam(':productName', $productName);
                    $productStmt->bindParam(':description', $description);
                    $productStmt->bindParam(':price', $price);
                    $productStmt->bindParam(':categoryName', $categoryName);
                    $productStmt->bindParam(':productImage', $uploadPath);
                    $productStmt->bindParam(':suppliername', $suppliername);

                    // Execute the product SQL statement
                    $productStmt->execute();
                } else {
                    // Failed to move the uploaded file, handle the error
                    echo "Error uploading file.";
                }
            } else {
                // No file uploaded for this row, handle accordingly
                echo "No file uploaded for row $i.";
            }
        }


        // Audit log for adding a supplier
        $user_id = $_SESSION['employee']; // Assuming you have a user session
        $action = "Added Supplier: $suppliername";
        $time_out = "00:00:00"; // Set the time_out value to '00:00:00'

        $auditSql = "INSERT INTO audit_log (user, action, time_out) VALUES (:user_id, :action, :time_out)";
        $auditStmt = $conn->prepare($auditSql);
        $auditStmt->bindParam(':user_id', $user_id);
        $auditStmt->bindParam(':action', $action);
        $auditStmt->bindParam(':time_out', $time_out);
        $auditStmt->execute();

        // Redirect to the supplier addition page upon successful insertion
        $rootFolder = dirname($_SERVER['PHP_SELF']);
        header("Location: $rootFolder/po/suppliers");
        exit; // Terminate script execution after redirect
    } catch (PDOException $e) {
        // Handle PDO exceptions
        echo "Error: " . $e->getMessage();
    } finally {
        // Close connection
        $conn = null;
    }
});


// Function for adding bulk items on a supplier
Router::post('/po/addbulk/', function () {
    // Establish database connection
    $db = Database::getInstance();
    $conn = $db->connect();

    try {
        // Retrieve the 'Supplier_ID' from the $_POST superglobal
        $supplierID = $_POST["supplierID"];

        // Loop through each row of product data
        for ($i = 1; $i <= 13; $i++) { // Assuming there are 13 rows of product data
            $productName = $_POST["productName$i"];
            $categoryName = $_POST["category$i"];
            $price = $_POST["price$i"];
            $description = $_POST["description$i"];

            // Handle file upload for each row
            $fileFieldName = "productImage$i";
            $fileUploadPath = "uploads/"; // Adjust this path accordingly

            if ($_FILES[$fileFieldName]['error'] == UPLOAD_ERR_OK) {
                $fileName = basename($_FILES[$fileFieldName]['name']);
                $uploadPath = $fileUploadPath . $fileName;

                if (move_uploaded_file($_FILES[$fileFieldName]['tmp_name'], $uploadPath)) {
                    // File uploaded successfully, proceed with database insertion
                    // Prepare SQL statement for inserting product data
                    $productSql = "INSERT INTO products (Supplier_ID, Category_ID, ProductName, Description, Price, Category, ProductImage, Supplier) 
                                SELECT s.Supplier_ID, c.category_id, :productName, :description, :price, :categoryName, :productImage, s.Supplier_Name 
                                FROM suppliers s 
                                INNER JOIN categories c ON c.category_name = :categoryName 
                                WHERE s.Supplier_ID = :supplierID";
                    $productStmt = $conn->prepare($productSql);

                    // Bind parameters for product SQL statement
                    $productStmt->bindParam(':supplierID', $supplierID);
                    $productStmt->bindParam(':categoryName', $categoryName);
                    $productStmt->bindParam(':productName', $productName);
                    $productStmt->bindParam(':description', $description);
                    $productStmt->bindParam(':price', $price);
                    $productStmt->bindParam(':productImage', $uploadPath);

                    // Execute the product SQL statement
                    $productStmt->execute();
                } else {
                    // Failed to move the uploaded file, handle the error
                    echo "Error uploading file.";
                }
            } else {
                // No file uploaded for this row, handle accordingly
                echo "No file uploaded for row $i.";
            }
        }

        // Audit log for adding bulk items on a supplier
        $user_id = $_SESSION['employee']; // Assuming you have a user session

        // Fetch Supplier_Name based on Supplier_ID
        $supplierNameQuery = "SELECT Supplier_Name FROM suppliers WHERE Supplier_ID = :supplierID";
        $supplierNameStmt = $conn->prepare($supplierNameQuery);
        $supplierNameStmt->bindParam(':supplierID', $supplierID);
        $supplierNameStmt->execute();
        $supplierName = $supplierNameStmt->fetchColumn();

        $action = "Added items for Supplier: $supplierName";
        $time_out = "00:00:00"; // Set the time_out value to '00:00:00'

        $auditSql = "INSERT INTO audit_log (user, action, time_out) VALUES (:user_id, :action, :time_out)";
        $auditStmt = $conn->prepare($auditSql);
        $auditStmt->bindParam(':user_id', $user_id);
        $auditStmt->bindParam(':action', $action);
        $auditStmt->bindParam(':time_out', $time_out);
        $auditStmt->execute();

        // Redirect to the products page upon successful insertion
        $rootFolder = dirname($_SERVER['PHP_SELF']);
        header("Location: $rootFolder/po/viewsupplierproduct/Supplier=$supplierID");
        exit; // Terminate script execution after redirect
    } catch (PDOException $e) {
        // Handle PDO exceptions
        echo "Error: " . $e->getMessage();
    } finally {
        // Close connection
        $conn = null;
    }
});


// Function to get the next available batch ID
function getNextBatchID($conn)
{
    $query = "SELECT MAX(Batch_ID) AS MaxBatchID FROM order_details";
    $statement = $conn->prepare($query);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return ($result['MaxBatchID'] ?? 0) + 1;
}

Router::post('/placeorder/supplier/', function () {
    if (!isset ($_POST['products']) || !is_array($_POST['products'])) {
        echo "No products selected for ordering.";
        return;
    }

    // Establish database connection
    $db = Database::getInstance();
    $conn = $db->connect();

    try {
        // Start a transaction
        $conn->beginTransaction();

        // Prepare SQL statement for inserting orders into order_details table
        $orderStmt = $conn->prepare("INSERT INTO order_details (Supplier_ID, Product_ID, Product_Quantity, Date_Ordered, Batch_ID) VALUES (:supplierID, :productID, :quantity, NOW(), :batchID)");

        // Prepare SQL statement for inserting batch into batch_orders table
        $batchOrderStmt = $conn->prepare("INSERT INTO batch_orders (Supplier_ID, Items_Subtotal, Total_Amount, Order_Status) VALUES (:supplierID, :itemsSubtotal, :totalAmount, 'to receive')");

        // Get Supplier_ID and Batch_ID from the form data
        $supplierID = $_POST['supplierID'];
        $batchID = getNextBatchID($conn); // Function to get the next available batch ID

        // Initialize total quantity and total amount
        $totalQuantity = 0;
        $totalAmount = 0;

        // Loop through each selected product
        foreach ($_POST['products'] as $productID) {
            $quantityField = 'quantity_' . $productID;
            $quantity = isset ($_POST[$quantityField]) ? intval($_POST[$quantityField]) : 0;

            // Ensure quantity is greater than 0 before processing
            if ($quantity > 0) {
                // Bind parameters for order details insertion
                $orderStmt->bindParam(':supplierID', $supplierID);
                $orderStmt->bindParam(':productID', $productID);
                $orderStmt->bindParam(':quantity', $quantity);
                $orderStmt->bindParam(':batchID', $batchID);

                // Execute the statement for order details insertion
                $orderStmt->execute();

                // Calculate subtotal quantity
                $totalQuantity += $quantity;

                // Retrieve product price from the database
                $productPriceQuery = "SELECT Price FROM products WHERE ProductID = :productID";
                $productPriceStmt = $conn->prepare($productPriceQuery);
                $productPriceStmt->bindParam(':productID', $productID);
                $productPriceStmt->execute();
                $productPrice = $productPriceStmt->fetchColumn();

                // Calculate total amount
                $totalAmount += $quantity * $productPrice;

                // Audit log for adding bulk items on a supplier
                $user_id = $_SESSION['employee']; // Assuming you have a user session

                // Fetch Supplier_Name based on Supplier_ID
                $supplierNameQuery = "SELECT Supplier_Name FROM suppliers WHERE Supplier_ID = :supplierID";
                $supplierNameStmt = $conn->prepare($supplierNameQuery);
                $supplierNameStmt->bindParam(':supplierID', $supplierID);
                $supplierNameStmt->execute();
                $supplierName = $supplierNameStmt->fetchColumn();

                $action = "Placed an Order for Supplier: $supplierName";
                $time_out = "00:00:00"; // Set the time_out value to '00:00:00'

                $auditSql = "INSERT INTO audit_log (user, action, time_out) VALUES (:user_id, :action, :time_out)";
                $auditStmt = $conn->prepare($auditSql);
                $auditStmt->bindParam(':user_id', $user_id);
                $auditStmt->bindParam(':action', $action);
                $auditStmt->bindParam(':time_out', $time_out);
                $auditStmt->execute();
            }
        }

        // If total quantity is greater than 0, proceed with batch order insertion
        if ($totalQuantity > 0) {
            // Bind parameters for batch order insertion
            $batchOrderStmt->bindParam(':supplierID', $supplierID);
            $batchOrderStmt->bindParam(':itemsSubtotal', $totalQuantity);
            $batchOrderStmt->bindParam(':totalAmount', $totalAmount);

            // Execute the statement for batch order insertion
            $batchOrderStmt->execute();

            // Commit the transaction
            $conn->commit();

            // Redirect the user after successful order placement
            $rootFolder = dirname($_SERVER['PHP_SELF']);
            header("Location: $rootFolder/po/orderDetail");
            exit (); // Ensure that script execution stops after redirection
        } else {
            // Rollback the transaction if no products were ordered
            $conn->rollBack();
            echo "No products were ordered.";
        }
    } catch (PDOException $e) {
        // Rollback the transaction on error
        $conn->rollBack();
        echo "Error placing order: " . $e->getMessage();
    } finally {
        // Close connection
        $conn = null;
    }
});


//function to delete view details
Router::post('/delete/viewdetails', function () {
    // Check if the delete request was submitted
    if (isset ($_POST['product_id']) && isset ($_POST['batch_id'])) {
        $productID = $_POST['product_id'];
        $batchID = $_POST['batch_id'];

        // Establish database connection
        $db = Database::getInstance();
        $conn = $db->connect();

        try {
            // Begin a transaction
            $conn->beginTransaction();

            // Get the Price and Quantity of the product being deleted
            $stmt = $conn->prepare("SELECT p.Price, od.Product_Quantity 
                                    FROM order_details od 
                                    INNER JOIN products p ON od.Product_ID = p.ProductID
                                    WHERE od.Product_ID = :productID AND od.Batch_ID = :batchID");
            $stmt->bindParam(':productID', $productID);
            $stmt->bindParam(':batchID', $batchID);
            $stmt->execute();
            $productData = $stmt->fetch(PDO::FETCH_ASSOC);

            // Delete the row from the order_details table
            $deleteStmt = $conn->prepare("DELETE FROM order_details WHERE Product_ID = :productID AND Batch_ID = :batchID");
            $deleteStmt->bindParam(':productID', $productID);
            $deleteStmt->bindParam(':batchID', $batchID);
            $deleteStmt->execute();

            // Subtract the Product_Quantity from batch_orders table
            $subtotal = $productData['Product_Quantity'];
            $totalAmount = $productData['Price'] * $subtotal;

            $updateStmt = $conn->prepare("UPDATE batch_orders SET Items_Subtotal = Items_Subtotal - :subtotal, Total_Amount = Total_Amount - :totalAmount WHERE Batch_ID = :batchID");
            $updateStmt->bindParam(':subtotal', $subtotal);
            $updateStmt->bindParam(':totalAmount', $totalAmount);
            $updateStmt->bindParam(':batchID', $batchID);
            $updateStmt->execute();

            // Audit log for deleting a product
            $user_id = $_SESSION['employee']; // Assuming you have a user session
            $action = "Deleted Product ID: $productID from Order #$batchID";
            $time_out = "00:00:00"; // Set the time_out value to '00:00:00'

            $auditSql = "INSERT INTO audit_log (user, action, time_out) VALUES (:user_id, :action, :time_out)";
            $auditStmt = $conn->prepare($auditSql);
            $auditStmt->bindParam(':user_id', $user_id);
            $auditStmt->bindParam(':action', $action);
            $auditStmt->bindParam(':time_out', $time_out);
            $auditStmt->execute();

            // Commit the transaction
            $conn->commit();

            // Redirect back to the view details page
            $rootFolder = dirname($_SERVER['PHP_SELF']);
            header("Location: $rootFolder/po/viewdetails/Batch=$batchID");
            exit ();
        } catch (PDOException $e) {
            // Rollback the transaction on error
            $conn->rollBack();
            echo "Error deleting row: " . $e->getMessage();
        } finally {
            // Close connection
            $conn = null;
        }
    }
});





// Router::post('/po/addItem', function () {
//     $db = Database::getInstance();
//     $conn = $db->connect();

//     $productName = $_POST['productname'];
//     $supplierName = $_POST['supplier'];
//     $description = $_POST['description'];
//     $categoryName = $_POST['category'];
//     $price = $_POST['price'];
//     $weight = $_POST['weight'];

//     // Check if all necessary data is provided
//     if (empty ($supplierName) || empty ($productName)) {
//         $rootFolder = dirname($_SERVER['PHP_SELF']);
//         header("Location: $rootFolder/po/items");
//         return;
//     }

//     // Retrieve the supplier_id based on the supplier name
//     $stmt = $conn->prepare("SELECT supplier_id FROM suppliers WHERE supplier_name = ?");
//     $stmt->bindParam(1, $supplierName, PDO::PARAM_STR);
//     $stmt->execute();
//     $supplier = $stmt->fetch(PDO::FETCH_ASSOC);

//     if (!$supplier) {
//         echo "Supplier not found.";
//         return;
//     }

//     $supplierId = $supplier['supplier_id'];

//     // Retrieve the category_id based on the category name
//     $stmt = $conn->prepare("SELECT category_id FROM categories WHERE category_name = ?");
//     $stmt->bindParam(1, $categoryName, PDO::PARAM_STR);
//     $stmt->execute();
//     $category = $stmt->fetch(PDO::FETCH_ASSOC);

//     if (!$category) {
//         echo "Category not found.";
//         return;
//     }

//     $categoryId = $category['category_id'];

//     // Handle image upload
//     if (isset ($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
//         $fileName = $_FILES['file']['name'];
//         $fileTmpName = $_FILES['file']['tmp_name'];
//         $fileDestination = 'uploads/' . $fileName;

//         if (move_uploaded_file($fileTmpName, $fileDestination)) {
//             // Insert data into products table with supplier_id and category_id
//             $stmt1 = $conn->prepare("INSERT INTO products (ProductImage, ProductName, supplier_id, category_id, Description, Supplier, Category, Price, ProductWeight) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
//             $stmt1->bindParam(1, $fileDestination, PDO::PARAM_STR);
//             $stmt1->bindParam(2, $productName, PDO::PARAM_STR);
//             $stmt1->bindParam(3, $supplierId, PDO::PARAM_INT);
//             $stmt1->bindParam(4, $categoryId, PDO::PARAM_INT);
//             $stmt1->bindParam(5, $description, PDO::PARAM_STR);
//             $stmt1->bindParam(6, $supplierName, PDO::PARAM_STR);
//             $stmt1->bindParam(7, $categoryName, PDO::PARAM_STR);
//             $stmt1->bindParam(8, $price, PDO::PARAM_INT);
//             $stmt1->bindParam(9, $weight, PDO::PARAM_INT);
//             $stmt1->execute();

//             // Redirect after successful insertion
//             $rootFolder = dirname($_SERVER['PHP_SELF']);
//             header("Location: $rootFolder/po/items");
//             exit ();
//         } else {
//             echo "Failed to move uploaded file.";
//             return;
//         }
//     } else {
//         echo "No file uploaded or an error occurred.";
//         return;
//     }
// });

//function to get all the categories in the addItem.php
function getAllCategories()
{
    $db = Database::getInstance();
    $conn = $db->connect();

    $categories = array();

    try {
        // Query to retrieve all category names
        $query = "SELECT category_name FROM categories";
        $statement = $conn->prepare($query);
        $statement->execute();

        // Fetch all category names and store them in an array
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = $row['category_name'];
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    return $categories;
}


//function to delete/remove requested orders of the Inventory Team 
Router::post('/delete/requestOrder', function () {
    try {
        $db = Database::getInstance();
        $conn = $db->connect();

        // Check if the requestID is provided in the POST data
        if (isset ($_POST['requestID'])) {
            $requestID = $_POST['requestID'];

            $stmt = $conn->prepare("DELETE FROM requests WHERE Request_ID = :requestID");
            $stmt->bindParam(':requestID', $requestID);

            // Execute the statement
            $stmt->execute();

            // Check if any rows were affected
            $rowsAffected = $stmt->rowCount();
            if ($rowsAffected > 0) {
                // Redirect back to the request order page after successful deletion
                $rootFolder = dirname($_SERVER['PHP_SELF']);
                header("Location: $rootFolder/po/requestOrder");
                exit (); // Ensure script execution stops after redirection
            } else {
                // No rows were affected, handle this case accordingly
                echo "No rows were deleted.";
            }
        } else {
            // Handle case where requestID is not provided
            echo "No requestID provided for deletion.";
        }
    } catch (PDOException $e) {
        // Handle any PDO exceptions
        echo "Database error: " . $e->getMessage();
    } catch (Exception $e) {
        // Handle any other exceptions
        echo "Error: " . $e->getMessage();
    }
});

// Function to add feedback
Router::post('/addfeedback/viewtransaction', function () {
    $db = Database::getInstance();
    $conn = $db->connect();

    try {
        // Retrieve data from the form submission
        $reviews = $_POST['reviews'];
        $supplierID = $_POST['supplierID'];
        $user = $_POST['user'];
        $batchID = $_POST['batchID']; // Retrieve the batchID from the form submission

        // Check if feedback has already been provided for this supplier and batch
        $checkStmt = $conn->prepare("SELECT COUNT(*) FROM feedbacks WHERE batch_ID = :batchID");
        $checkStmt->bindParam(':batchID', $batchID);
        $checkStmt->execute();
        $feedbackCount = $checkStmt->fetchColumn();

        // If feedback hasn't been provided yet, save the feedback and update the "Done" status
        if ($feedbackCount == 0) {
            // Prepare and execute the SQL query to insert feedback into the database
            $stmt = $conn->prepare("INSERT INTO feedbacks (reviews, supplier_id, user, batch_ID) VALUES (:reviews, :supplierID, :user, :batchID)");
            $stmt->bindParam(':reviews', $reviews);
            $stmt->bindParam(':supplierID', $supplierID);
            $stmt->bindParam(':user', $user);
            $stmt->bindParam(':batchID', $batchID);
            $stmt->execute();

            // Update the "Feedback" column in the transaction history table
            $updateStmt = $conn->prepare("UPDATE transaction_history SET Feedback = 'Done' WHERE supplier_id = :supplierID AND batch_ID = :batchID");
            $updateStmt->bindParam(':supplierID', $supplierID);
            $updateStmt->bindParam(':batchID', $batchID);
            $updateStmt->execute();

            // Audit log for adding feedback
            $user_id = $_SESSION['employee']; // Assuming you have a user session
            $action = "Added feedback a for Order #$batchID";
            $time_out = "00:00:00"; // Set the time_out value to '00:00:00'

            $auditSql = "INSERT INTO audit_log (user, action, time_out) VALUES (:user_id, :action, :time_out)";
            $auditStmt = $conn->prepare($auditSql);
            $auditStmt->bindParam(':user_id', $user_id);
            $auditStmt->bindParam(':action', $action);
            $auditStmt->bindParam(':time_out', $time_out);
            $auditStmt->execute();
        }

        // Close the database connection
        $conn = null;

        // Redirect back to the previous page after saving feedback
        header("Location: /master/po/transactionHistory", true, 303);
    } catch (PDOException $e) {
        // Handle PDO exceptions
        echo "Error: " . $e->getMessage();
    }
});


Router::post('/edit/editsupplier', function () {
    $db = Database::getInstance();
    $conn = $db->connect();

    // Update supplier information
    $supplierID = $_POST['supplierID'];
    $supplierName = $_POST['suppliername'];
    $contactName = $_POST['contactname'];
    $contactNum = $_POST['contactnum'];
    $email = $_POST['email'];
    $status = $_POST['status'];
    $location = $_POST['Address'];
    $estimatedDelivery = $_POST['estimated-delivery-date'];

    $stmt_supplier = $conn->prepare("UPDATE suppliers SET Supplier_Name = :supplierName, Contact_Name = :contactName, Contact_Number = :contactNum, Email = :email, Status = :status, Address = :location, Estimated_Delivery = :estimatedDelivery WHERE Supplier_ID = :supplierID");
    $stmt_supplier->bindParam(':supplierID', $supplierID);
    $stmt_supplier->bindParam(':supplierName', $supplierName);
    $stmt_supplier->bindParam(':contactName', $contactName);
    $stmt_supplier->bindParam(':contactNum', $contactNum);
    $stmt_supplier->bindParam(':email', $email);
    $stmt_supplier->bindParam(':status', $status);
    $stmt_supplier->bindParam(':location', $location);
    $stmt_supplier->bindParam(':estimatedDelivery', $estimatedDelivery);
    $stmt_supplier->execute();

    // Update product information
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'product_name_') !== false) {
            $productID = substr($key, strlen('product_name_'));
            $categoryKey = 'product_category_' . $productID;
            $priceKey = 'product_price_' . $productID;
            $descriptionKey = 'product_description_' . $productID;

            // Update product information
            $productName = $_POST[$key];
            $category = $_POST[$categoryKey];
            $price = $_POST[$priceKey];
            $description = $_POST[$descriptionKey];

            $stmt_product = $conn->prepare("UPDATE products SET ProductName = :productName, Category = :category, Price = :price, Description = :description WHERE ProductID = :productID");
            $stmt_product->bindParam(':productName', $productName);
            $stmt_product->bindParam(':category', $category);
            $stmt_product->bindParam(':price', $price);
            $stmt_product->bindParam(':description', $description);
            $stmt_product->bindParam(':productID', $productID);
            $stmt_product->execute();
        }
    }

    // Handle file uploads for product images
    foreach ($_FILES as $key => $file) {
        if (strpos($key, 'product_image_') !== false) {
            $productID = substr($key, strlen('product_image_'));
            $uploadDir = 'uploads/';
            $uploadFile = $uploadDir . basename($file['name']);

            if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
                // Update product image path in the database
                $stmt_product_image = $conn->prepare("UPDATE products SET ProductImage = :productImage WHERE ProductID = :productID");
                $stmt_product_image->bindParam(':productImage', $uploadFile);
                $stmt_product_image->bindParam(':productID', $productID);
                $stmt_product_image->execute();
            } else {
                echo "Failed to upload file.";
            }
        }
    }

    // Audit log for updating supplier and product information
    $user_id = $_SESSION['employee']; // Assuming you have a user session
    $action = "Updated the Supplier Information and Products on Supplier: $supplierName";
    $time_out = "00:00:00"; // Set the time_out value to '00:00:00'

    $auditSql = "INSERT INTO audit_log (user, action, time_out) VALUES (:user_id, :action, :time_out)";
    $auditStmt = $conn->prepare($auditSql);
    $auditStmt->bindParam(':user_id', $user_id);
    $auditStmt->bindParam(':action', $action);
    $auditStmt->bindParam(':time_out', $time_out);
    $auditStmt->execute();

    // Redirect back to the page
    $rootFolder = dirname($_SERVER['PHP_SELF']);
    header("Location: $rootFolder/po/suppliers");
});





// //function to show all the product details
// function getProductDetails($productID, $conn)
// {
//     try {
//         // Prepare the SQL statement to fetch product details including the image path
//         $query = "SELECT p.ProductImage, p.ProductName, p.Supplier, p.Category, p.Price, r.Product_Quantity, r.Product_Total_Price
//                   FROM products p
//                   INNER JOIN requests r ON p.ProductID = r.Product_ID
//                   WHERE p.ProductID = :product_id";
//         $statement = $conn->prepare($query);
//         $statement->bindParam(':product_id', $productID);
//         $statement->execute();

//         // Fetch the product details
//         $result = $statement->fetch(PDO::FETCH_ASSOC);

//         // Check if a result is returned
//         if ($result) {
//             return $result; // Return an associative array containing all product details
//         } else {
//             return false; // Return false if no result found
//         }
//     } catch (PDOException $e) {
//         // Handle the exception
//         echo "Error: " . $e->getMessage();
//         return false; // Return false in case of an error
//     }
// }


// // Function to update request status to 'Ok' this code is for the finance team
// function updateRequestStatusToOk()
// {
//     try {
//         $db = Database::getInstance();
//         $conn = $db->connect();

//         // Begin a transaction
//         $conn->beginTransaction();

//         // Update the request status in the requests table
//         $query = "UPDATE requests SET request_Status = 'Ready to order' WHERE request_Status = 'pending'";
//         $statement = $conn->prepare($query);
//         $statement->execute();

//         // Commit the transaction
//         $conn->commit();

//         echo "All pending requests have been updated to 'Ok' status.";
//         $rootFolder = dirname($_SERVER['PHP_SELF']);
//         header("Location: $rootFolder/po/requestOrder");

//     } catch (PDOException $e) {
//         // Rollback the transaction in case of error
//         $conn->rollBack();
//         echo "Error: " . $e->getMessage();
//     }
// }

// // Route to handle the update request status action
// Router::post('/accept/requestOrder', function () {
//     // Call the function to update request status
//     updateRequestStatusToOk();
// });




// //function to change the "pending" status of requested orders to "accepted" and it will insert on the
// //orders_details table while also having a data in the requests tables to use it as a request history
// function updateRequestStatusToAccepted()
// {
//     try {
//         $db = Database::getInstance();
//         $conn = $db->connect();

//         // Begin a transaction
//         $conn->beginTransaction();

//         // Retrieve pending requests
//         $pendingRequestsStmt = $conn->prepare("SELECT * FROM requests WHERE request_Status = 'Ready to order'");
//         $pendingRequestsStmt->execute();
//         $pendingRequests = $pendingRequestsStmt->fetchAll(PDO::FETCH_ASSOC);

//         // Prepare the SQL statement to insert into order_details
//         $insertStmt = $conn->prepare("INSERT INTO order_details (Request_ID, Product_ID, Category_ID, Supplier_ID, Order_Status) VALUES (:requestID, :productID, :categoryID, :supplierID, 'to receive')");

//         // Loop through each pending request and insert into order_details
//         foreach ($pendingRequests as $request) {
//             $requestID = $request['Request_ID'];
//             $productID = $request['Product_ID'];

//             // Retrieve Category_ID and Supplier_ID from products table
//             $productStmt = $conn->prepare("SELECT Category_ID, Supplier_ID FROM products WHERE ProductID = :productID");
//             $productStmt->bindParam(':productID', $productID);
//             $productStmt->execute();
//             $product = $productStmt->fetch(PDO::FETCH_ASSOC);
//             $categoryID = $product['Category_ID'];
//             $supplierID = $product['Supplier_ID'];

//             // Bind parameters and execute the insert statement
//             $insertStmt->bindParam(':requestID', $requestID);
//             $insertStmt->bindParam(':productID', $productID);
//             $insertStmt->bindParam(':categoryID', $categoryID);
//             $insertStmt->bindParam(':supplierID', $supplierID);
//             $insertStmt->execute();
//         }

//         // Commit the transaction
//         $conn->commit();

//         // Update the request status to 'accepted' after inserting into order_details
//         $updateStmt = $conn->prepare("UPDATE requests SET request_Status = 'accepted' WHERE request_Status = 'Ready to order'");
//         $updateStmt->execute();

//         echo "Request status updated to 'accepted' for all pending requests.";

//         $rootFolder = dirname($_SERVER['PHP_SELF']);
//         header("Location: $rootFolder/po/requestOrder");
//         exit(); // Stop script execution after redirection

//     } catch (PDOException $e) {
//         // Rollback the transaction in case of error
//         $conn->rollBack();
//         echo "Error: " . $e->getMessage();
//     }
// }



// // Route to handle the update request status action
// Router::post('/update/requestOrder', function () {
//     // Call the function to update request status
//     updateRequestStatusToAccepted();
// });



// Route to handle the update order status action
Router::post('/complete/orderDetail', function () {
    // Call the function to update order status
    updateOrderStatusToCompleted();
});

// Function to set the order status to complete and add data in the transaction history
function updateOrderStatusToCompleted()
{
    try {
        $db = Database::getInstance();
        $conn = $db->connect();

        if (isset($_POST['Batch_ID'])) {
            $batchID = $_POST['Batch_ID'];

            // Begin a transaction
            $conn->beginTransaction();

            // Update the order status in the batch_orders table
            $stmt = $conn->prepare("UPDATE batch_orders SET Order_Status = 'Completed' WHERE Batch_ID = :batchID");
            $stmt->bindParam(':batchID', $batchID);
            $stmt->execute();

            // Fetch supplier ID and order status from the batch_orders table based on Batch_ID
            $orderDetailsStmt = $conn->prepare("SELECT Supplier_ID, Order_Status FROM batch_orders WHERE Batch_ID = :batchID");
            $orderDetailsStmt->bindParam(':batchID', $batchID);
            $orderDetailsStmt->execute();
            $orderDetails = $orderDetailsStmt->fetch(PDO::FETCH_ASSOC);
            $supplierID = $orderDetails['Supplier_ID'];
            $orderStatus = $orderDetails['Order_Status'];

            // Insert data into transaction_history table
            $insertStmt = $conn->prepare("INSERT INTO transaction_history (Batch_ID, Supplier_ID, Order_Status) VALUES (:batchID, :supplierID, :orderStatus)");
            $insertStmt->bindParam(':batchID', $batchID);
            $insertStmt->bindParam(':supplierID', $supplierID);
            $insertStmt->bindParam(':orderStatus', $orderStatus);
            $insertStmt->execute();

            // Audit log for completing an order
            $user_id = $_SESSION['employee']; // Assuming you have a user session
            $action = "Completed Order #$batchID";
            $time_out = "00:00:00"; // Set the time_out value to '00:00:00'

            $auditSql = "INSERT INTO audit_log (user, action, time_out) VALUES (:user_id, :action, :time_out)";
            $auditStmt = $conn->prepare($auditSql);
            $auditStmt->bindParam(':user_id', $user_id);
            $auditStmt->bindParam(':action', $action);
            $auditStmt->bindParam(':time_out', $time_out);
            $auditStmt->execute();

            // Commit the transaction
            $conn->commit();

            echo "Order status updated to 'Completed' for Order ID: $batchID";

            $rootFolder = dirname($_SERVER['PHP_SELF']);
            header("Location: $rootFolder/po/orderDetail");
            exit(); // Stop script execution after redirection
        }
    } catch (PDOException $e) {
        // Rollback the transaction in case of error
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }
}







//function to set the order status of to complete and also add the data in the transaction history
// Route to handle the cancel order status action
Router::post('/cancel/orderDetail', function () {
    // Call the function to cancel order status
    updateOrderStatusToCancel();
});

function updateOrderStatusToCancel()
{
    try {
        $db = Database::getInstance();
        $conn = $db->connect();

        if (isset($_POST['Batch_ID'])) {
            $batchID = $_POST['Batch_ID'];

            // Begin a transaction
            $conn->beginTransaction();

            // Update the order status in the batch_orders table
            $stmt = $conn->prepare("UPDATE batch_orders SET Order_Status = 'Cancelled' WHERE Batch_ID = :batchID");
            $stmt->bindParam(':batchID', $batchID);
            $stmt->execute();

            // Fetch supplier ID and order status from the batch_orders table based on Batch_ID
            $orderDetailsStmt = $conn->prepare("SELECT Supplier_ID, Order_Status FROM batch_orders WHERE Batch_ID = :batchID");
            $orderDetailsStmt->bindParam(':batchID', $batchID);
            $orderDetailsStmt->execute();
            $orderDetails = $orderDetailsStmt->fetch(PDO::FETCH_ASSOC);
            $supplierID = $orderDetails['Supplier_ID'];
            $orderStatus = $orderDetails['Order_Status'];

            // Insert data into transaction_history table
            $insertStmt = $conn->prepare("INSERT INTO transaction_history (Batch_ID, Supplier_ID, Order_Status) VALUES (:batchID, :supplierID, :orderStatus)");
            $insertStmt->bindParam(':batchID', $batchID);
            $insertStmt->bindParam(':supplierID', $supplierID);
            $insertStmt->bindParam(':orderStatus', $orderStatus);
            $insertStmt->execute();

            // Audit log for cancelling an order
            $user_id = $_SESSION['employee']; // Assuming you have a user session
            $action = "Cancelled Order #$batchID";
            $time_out = "00:00:00"; // Set the time_out value to '00:00:00'

            $auditSql = "INSERT INTO audit_log (user, action, time_out) VALUES (:user_id, :action, :time_out)";
            $auditStmt = $conn->prepare($auditSql);
            $auditStmt->bindParam(':user_id', $user_id);
            $auditStmt->bindParam(':action', $action);
            $auditStmt->bindParam(':time_out', $time_out);
            $auditStmt->execute();

            // Commit the transaction
            $conn->commit();

            echo "Order status updated to 'Cancelled' for Order ID: $batchID";

            $rootFolder = dirname($_SERVER['PHP_SELF']);
            header("Location: $rootFolder/po/orderDetail");
            exit(); // Stop script execution after redirection
        }
    } catch (PDOException $e) {
        // Rollback the transaction in case of error
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }
}

Router::post('/delete/product', function () {
    $db = Database::getInstance();
    $conn = $db->connect();

    // Get the product ID and supplier ID to delete
    $productID = $_POST['product_id'];
    $supplierID = $_POST['supplier_id'];

    // Fetch the supplier name based on the supplier ID
    $stmt_supplier_name = $conn->prepare("SELECT Supplier_Name FROM suppliers WHERE Supplier_ID = :supplierID");
    $stmt_supplier_name->bindParam(':supplierID', $supplierID);
    $stmt_supplier_name->execute();
    $supplierName = $stmt_supplier_name->fetchColumn();

    // Prepare and execute the SQL statement to delete the product
    $stmt_delete_product = $conn->prepare("DELETE FROM products WHERE ProductID = :productID");
    $stmt_delete_product->bindParam(':productID', $productID);
    $stmt_delete_product->execute();

    // Audit log for cancelling an order
    $user_id = $_SESSION['employee']; // Assuming you have a user session
    $action = "Deleted a Product from Supplier: $supplierName";
    $time_out = "00:00:00"; // Set the time_out value to '00:00:00'

    $auditSql = "INSERT INTO audit_log (user, action, time_out) VALUES (:user_id, :action, :time_out)";
    $auditStmt = $conn->prepare($auditSql);
    $auditStmt->bindParam(':user_id', $user_id);
    $auditStmt->bindParam(':action', $action);
    $auditStmt->bindParam(':time_out', $time_out);
    $auditStmt->execute();

    // Redirect back to the page with the supplier ID
    $rootFolder = dirname($_SERVER['PHP_SELF']);
    header("Location: $rootFolder/po/editsupplier/Supplier=$supplierID");
});

//function to just fetch the data in the requestHistory
// function fetchAllRequestsData()
// {
//     try {
//         // Connect to the database
//         $db = Database::getInstance();
//         $conn = $db->connect();

//         // Prepare SQL query to fetch all requests data
//         $sql = "SELECT r.*, od.*, p.ProductName, p.Price 
//                     FROM requests r
//                     INNER JOIN order_details od ON r.Request_ID = od.Order_ID
//                     INNER JOIN products p ON od.Product_ID = p.ProductID
//                 WHERE r.Request_Status = 'accepted'
//                 ORDER BY r.Request_ID ASC"; // Order by Request_ID from lowest to highest

//         // Prepare the SQL statement
//         $stmt = $conn->prepare($sql);

//         // Execute the statement
//         $stmt->execute();

//         // Fetch all rows as an associative array
//         $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

//         return $requests;

//     } catch (PDOException $e) {
//         // Handle database errors
//         echo "Error: " . $e->getMessage();
//         return []; // Set requests to an empty array in case of error
//     }
// }


// // Function to search requests by date
// function searchByDate()
// {
//     try {
//         // Connect to the database
//         $db = Database::getInstance();
//         $conn = $db->connect();

//         if (isset($_POST['searchDate'])) {
//             $searchDate = $_POST['searchDate'];

//             // Prepare SQL query to fetch requests data based on the search date
//             $sql = "SELECT r.*, od.*, p.ProductName, p.Price 
//                     FROM requests r
//                     INNER JOIN order_details od ON r.Request_ID = od.Order_ID
//                     INNER JOIN products p ON od.Product_ID = p.ProductID
//                     WHERE DATE(od.Date_Ordered) = :searchDate AND r.Request_Status = 'accepted'
//                     ORDER BY r.Request_ID ASC"; // Order by Request_ID from lowest to highest

//             // Prepare the SQL statement
//             $stmt = $conn->prepare($sql);

//             // Bind parameters
//             $stmt->bindParam(':searchDate', $searchDate);

//             // Execute the statement
//             $stmt->execute();

//             // Fetch all rows as an associative array
//             $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

//             // Return the fetched data
//             return $result;
//         }
//     } catch (PDOException $e) {
//         // Handle database errors
//         echo "Error: " . $e->getMessage();
//         return []; // Return an empty array in case of error
//     }
// }
// // Route to handle the search request
// Router::post('/search/requestHistory', function () {
//     // Call the function to search requests by date
//     $searchedRequests = searchByDate();

//     // Include the requestHistory.php file to display the search results
//     include 'views/po.requestHistory.php';
// });

