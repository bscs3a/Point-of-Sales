<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Product</title>
    <link href="./../../../../src/tailwind.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css">

</head>

<body>
    <?php include "components/sidebar.php" ?>

    <!-- Start: Dashboard -->
    <main id="mainContent" class="w-full md:w-[calc(100%-256px)] md:ml-64 min-h-screen transition-all main">

        <!-- Start: Header -->

        <div class="py-2 px-6 bg-white flex items-center shadow-md sticky top-0 left-0 z-30">

            <!-- Start: Active Menu -->

            <button type="button" class="text-lg sidebar-toggle">
                <i class="ri-menu-line"></i>
            </button>

            <ul class="flex items-center text-md ml-4">

                <li class="mr-2">
                    <p class="text-black font-medium">Sales / Return Product</p>
                </li>

            </ul>

            <!-- End: Active Menu -->

            <!-- Start: Profile -->

            <ul class="ml-auto flex items-center">

                <div class="relative inline-block text-left">
                    <div>
                        <a class="inline-flex justify-between w-full px-4 py-2 text-sm font-medium text-black bg-white rounded-md shadow-sm border-b-2 transition-all hover:bg-gray-200 focus:outline-none hover:cursor-pointer" id="options-menu" aria-haspopup="true" aria-expanded="true">
                            <div class="text-black font-medium mr-4 ">
                                <i class="ri-user-3-fill mx-1"></i> <?= $_SESSION['employee_name']; ?>
                            </div>
                            <i class="ri-arrow-down-s-line"></i>
                        </a>
                    </div>

                    <div class="origin-top-right absolute right-0 mt-4 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden" id="dropdown-menu" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                        <div class="py-1" role="none">
                            <a route="/sls/logout" class="block px-4 py-2 text-md text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                                <i class="ri-logout-box-line"></i>
                                Logout
                            </a>
                        </div>
                    </div>
                </div>

                <script>
                    document.getElementById('options-menu').addEventListener('click', function() {
                        var dropdownMenu = document.getElementById('dropdown-menu');
                        if (dropdownMenu.classList.contains('hidden')) {
                            dropdownMenu.classList.remove('hidden');
                        } else {
                            dropdownMenu.classList.add('hidden');
                        }
                    });
                </script>
            </ul>

            <!-- End: Profile -->
        </div>

        <!-- End: Header -->
        <div class="flex flex-row justify-center">

            <div class="mx-10 my-10 flex flex-col w-1/2 border-r border-gray-200">
                <h1 class="font-bold text-xl mx-8 text-gray-500 bg-white border-b shadow-md p-4 w-1/3">You're about to Return:</h1>
                <div class="flex flex-row">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="300" height="300" fill="currentColor">
                        <path d="M5 11.1005L7 9.1005L12.5 14.6005L16 11.1005L19 14.1005V5H5V11.1005ZM5 13.9289V19H8.1005L11.0858 16.0147L7 11.9289L5 13.9289ZM10.9289 19H19V16.9289L16 13.9289L10.9289 19ZM4 3H20C20.5523 3 21 3.44772 21 4V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V4C3 3.44772 3.44772 3 4 3ZM15.5 10C14.6716 10 14 9.32843 14 8.5C14 7.67157 14.6716 7 15.5 7C16.3284 7 17 7.67157 17 8.5C17 9.32843 16.3284 10 15.5 10Z"></path>
                    </svg>

                    <div class="flex flex-col justify-center text-xl gap-4">
                        <div>Product Name: <span class="font-bold">Name</span> </div>
                        <div>Product Category: <span class="font-bold">Tools</span> </div>
                        <div>Product Price: <span class="font-bold">123 (each)</span> </div>
                        <div>Quantity Bought: <span class="font-bold">123</span> </div>
                    </div>
                </div>
                <div class="mx-10 text-xl font-semibold flex flex-col">
                    Product Description:
                    <div class="font-normal bg-gray-100 rounded-md p-4">
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Assumenda accusantium et possimus porro mollitia eveniet.
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Assumenda accusantium et possimus porro mollitia eveniet.
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Assumenda accusantium et possimus porro mollitia eveniet.
                    </div>
                </div>

            </div>

            <div class="flex flex-col justify-center items-center w-full border max-w-md rounded-lg my-10 mr-20 shadow-md">
                <h1 class="text-2xl font-semibold p-4 text-center rounded-t-lg text-white bg-green-800 w-full">Return Product</h1>
                <form action="/returnProduct" method="post" class="w-full p-4">

                    <?php
                    // Database connection
                    $db = Database::getInstance();
                    $pdo = $db->connect();

                    // Get saleId from URL
                    $saleId = $_GET['sale'];
                    $saledetailId = $_GET['saledetails'];
                    $productId = $_GET['product'];

                    // Fetch product name
                    $sql = "SELECT ProductName FROM Products WHERE ProductID = :product_id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(":product_id", $productId);
                    $stmt->execute();
                    $productName = $stmt->fetch(PDO::FETCH_ASSOC)['ProductName'];

                    // Fetch product details, quantity, unit price, and tax
                    $sql = "SELECT p.ProductID, p.ProductName, sd.Quantity, sd.UnitPrice, sd.Tax 
                 FROM SaleDetails sd 
                 JOIN Products p ON sd.ProductID = p.ProductID 
                 WHERE sd.SaleID = :sale_id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(":sale_id", $saleId);
                    $stmt->execute();
                    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="product_id">
                            Product ID
                        </label>
                        <input readonly class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="product_id" type="text" name="product_id" value="<?php echo $productId; ?>">
                    </div>
                    <div class="mb-4">

                        <label class="block text-gray-700 text-sm font-bold mb-2" for="product_name">
                            Product Name
                        </label>
                        <input readonly class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="product_name" type="text" name="product_name" value="<?php echo $productName; ?>">
                    </div>
                    <div class="mb-4">
                        <?php
                        // Fetch quantity
                        $sql = "SELECT Quantity FROM SaleDetails WHERE SaleDetailID = :saledetails_id";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(":saledetails_id", $saledetailsId);
                        $stmt->execute();
                        $quantity = $stmt->fetch(PDO::FETCH_ASSOC)['Quantity'];
                        ?>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="quantity">
                            Quantity
                        </label>
                        <input required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="quantity" type="number" name="quantity" min="1" max="<?php echo $quantity; ?>" oninput="calculatePaymentReturned()">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="reason">
                            Reason
                        </label>
                        <textarea required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="reason" name="reason"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="product_status">
                            Product Status
                        </label>
                        <select required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="product_status" name="product_status">
                            <option value="">Select a status</option>
                            <option value="Defective">Defective</option>
                            <option value="Damaged">Damaged</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="payment_returned">
                            Payment to be Returned
                        </label>
                        <input readonly name="payment_returned" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="payment_returned" type="text">
                    </div>

                    <!-- Add hidden input field for saleId -->
                    <input type="hidden" name="sale" value="<?php echo $saleId; ?>">

                    <div class="flex items-center justify-end mt-4">
                        <button class="bg-green-800 hover:bg-green-900 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                            Submit
                        </button>
                    </div>
                </form>
            </div>

            <script>
                function calculatePaymentReturned() {
                    var quantity = document.getElementById('quantity').value;
                    var unitPrice = <?php echo $products[0]['UnitPrice']; ?>;
                    var tax = <?php echo $products[0]['Tax']; ?>;
                    var paymentReturned = (unitPrice + tax) * quantity;
                    document.getElementById('payment_returned').value = paymentReturned.toFixed(2);
                }
            </script>
    </main>

    <script src="./../../../../src/form.js"></script>
    <script src="./../../../../src/route.js"></script>

</body>

</html>