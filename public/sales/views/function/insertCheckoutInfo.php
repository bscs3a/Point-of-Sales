<?php
require_once './src/dbconn.php';

function insertCheckoutInfo($customerInfo, $orderInfo, $orderDetails) {
    // Get PDO instance
    $database = Database::getInstance();
    $pdo = $database->connect();

    try {
        // Start transaction
        $pdo->beginTransaction();

        // Insert into Customers table
        $sql = "INSERT INTO Customers (FirstName, LastName, Address, Phone, Email) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$customerInfo['firstName'], $customerInfo['lastName'], $customerInfo['address'], $customerInfo['phone'], $customerInfo['email']]);
        $customerId = $pdo->lastInsertId();

        // Insert into Orders table
        $sql = "INSERT INTO Orders (OrderDate, DeliveryDate, TotalAmount, EmployeeID, CustomerID) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$orderInfo['orderDate'], $orderInfo['deliveryDate'], $orderInfo['totalAmount'], $orderInfo['employeeId'], $customerId]);
        $orderId = $pdo->lastInsertId();

        // Insert into OrderDetails table
        $sql = "INSERT INTO OrderDetails (OrderID, ProductID, Quantity, UnitPrice) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        foreach ($orderDetails as $detail) {
            $stmt->execute([$orderId, $detail['productId'], $detail['quantity'], $detail['unitPrice']]);
        }

        // Commit transaction
        $pdo->commit();
    } catch (Exception $e) {
        // Rollback transaction if something fails
        $pdo->rollback();
        throw $e;
    }
}
?>