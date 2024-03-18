<?php

$path = './public/sales/views';

$sls = [
    '/sls/sample' => "$path/sls.sample.php",
    '/sls/link' => "$path/sls.test-link.php",
    '/sls/Product-Catalog' => "$path/sls.ProductCatalog.php",
    '/sls/Transaction-History' => "$path/sls.TransactionHistory.php",
    '/sls/Transaction-Details' => "$path/sls.TransactionDetails.php",
    '/sls/Dashboard' => "$path/sls.Dashboard.php",
    '/sls/POS' => "$path/sls.POS.php",
    '/sls/POS2' => "$path/sls.POS2.php",
    '/sls/POS/Checkout' => "$path/sls.checkout.php",
    '/sls/POS/Receipt' => "$path/sls.Receipt.php",
    '/sls/Audit-Trail' => "$path/sls.AuditTrail.php",
    // ... other routes ...
];



// START: Add Sales
class Customer {
    public function create($firstName, $lastName, $phone, $email) {
        $db = Database::getInstance();
        $conn = $db->connect();

        $stmt = $conn->prepare("INSERT INTO Customers (FirstName, LastName, Phone, Email) VALUES (:firstName, :lastName, :phone, :email)");
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $conn->lastInsertId();
    }
}

class Sale {
    public function create($saleDate, $salePreference, $paymentMode, $totalAmount, $employeeId, $customerId, $cardNumber, $expiryDate, $cvv) {
        $db = Database::getInstance();
        $conn = $db->connect();

        $stmt = $conn->prepare("INSERT INTO Sales (SaleDate, SalePreference, PaymentMode, TotalAmount, CustomerID, CardNumber, ExpiryDate, CVV) VALUES (:saleDate, :salePreference, :paymentMode, :totalAmount, :customerId, :cardNumber, :expiryDate, :cvv)");
        $stmt->bindParam(':saleDate', $saleDate);
        $stmt->bindParam(':salePreference', $salePreference);
        $stmt->bindParam(':paymentMode', $paymentMode);
        $stmt->bindParam(':totalAmount', $totalAmount);
        $stmt->bindParam(':customerId', $customerId);
        $stmt->bindParam(':cardNumber', $cardNumber);
        $stmt->bindParam(':expiryDate', $expiryDate);
        $stmt->bindParam(':cvv', $cvv);
        $stmt->execute();

        return $conn->lastInsertId();
    }
}

class SaleDetail {
    public function create($saleId, $productId, $quantity, $unitPrice) {
        $db = Database::getInstance();
        $conn = $db->connect();

        $stmt = $conn->prepare("INSERT INTO SaleDetails (SaleID, ProductID, Quantity, UnitPrice) VALUES (:saleId, :productId, :quantity, :unitPrice)");
        $stmt->bindParam(':saleId', $saleId);
        $stmt->bindParam(':productId', $productId);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':unitPrice', $unitPrice);
        $stmt->execute();
    }
}

class DeliveryOrder {
    public function create($saleId, $productId, $quantity, $deliveryAddress, $deliveryDate) {
        $db = Database::getInstance();
        $conn = $db->connect();

        $stmt = $conn->prepare("INSERT INTO DeliveryOrders (SaleID, ProductID, Quantity, DeliveryAddress, DeliveryDate, DeliveryStatus) VALUES (:saleId, :productId, :quantity, :deliveryAddress, :deliveryDate, 'Pending')");
        $stmt->bindParam(':saleId', $saleId);
        $stmt->bindParam(':productId', $productId);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':deliveryAddress', $deliveryAddress);
        $stmt->bindParam(':deliveryDate', $deliveryDate);
        $stmt->execute();
    }
}

class Product {
    public function decreaseQuantity($productId, $quantity) {
        $db = Database::getInstance();
        $conn = $db->connect();

        $stmt = $conn->prepare("UPDATE Products SET Stocks = Stocks - :quantity WHERE ProductID = :productId");
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();
    }
}

Router::post('/addSales', function () {
    $customer = new Customer();
    $customerId = $customer->create($_POST['customerFirstName'], $_POST['customerLastName'], $_POST['customerPhone'], $_POST['customerEmail']);

    $sale = new Sale();
    $saleId = $sale->create(date('Y-m-d H:i:s'), $_POST['SalePreference'], $_POST['payment-mode'], $_POST['totalAmount'], '1', $customerId, $_POST['cardNumber'], $_POST['expiryDate'], $_POST['cvv']);

    $saleDetail = new SaleDetail();
    $deliveryOrder = new DeliveryOrder();
    $product = new Product();
    $cart = json_decode($_POST['cartData'], true);
    foreach ($cart as $item) {
        $saleDetail->create($saleId, $item['id'], $item['quantity'], $item['price']);
        $product->decreaseQuantity($item['id'], $item['quantity']); // Decrease product quantity
        if ($_POST['SalePreference'] === 'delivery') {
            $deliveryOrder->create($saleId, $item['id'], $item['quantity'], $_POST['deliveryAddress'], $_POST['deliveryDate']);
        }
    }

    $rootFolder = dirname($_SERVER['PHP_SELF']);
    header("Location: $rootFolder/sls/POS/Receipt");
});
// END: Add Sales

Router::post('/remove', function () {
    $db = Database::getInstance();
    $conn = $db->connect();

    $name = $_POST['name'];

    $stmt = $conn->prepare("DELETE FROM name WHERE name = :name");
    $stmt->bindParam(':name', $name);

    // Execute the statement
    $stmt->execute();

    $rootFolder = dirname($_SERVER['PHP_SELF']);
    header("Location: $rootFolder/fin/test");
});
