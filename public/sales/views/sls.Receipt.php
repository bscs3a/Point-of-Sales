<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link href="./../src/tailwind.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css">

    <?php
    // Database connection
    $host = 'localhost';
    $db   = 'sales';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $pdo = new PDO($dsn, $user, $pass);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form data from the POST request
        $customerFirstName = $_POST["customerFirstName"];
        $customerLastName = $_POST["customerLastName"];
        $customerEmail = $_POST["customerEmail"];
        $customerPhone = $_POST["customerPhone"];
        $address = $_POST["address"];

        // Insert data into the Customers table
        $sql = "INSERT INTO Customers (FirstName, LastName, Email, Phone, Address) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$customerFirstName, $customerLastName, $customerEmail, $customerPhone, $address]);

        // Redirect to the receipt page
        header('Location: sls.Receipt.php');
        exit;
    }
    ?>

<style>
        ::-webkit-scrollbar{
            display: none;
        }
    </style>

</head>

<body>
    <?php include "components/sidebar.php" ?>

    <main id="mainContent" class="w-full md:w-[calc(100%-256px)] md:ml-64 min-h-screen transition-all main">
        <div class="py-2 px-6 bg-white flex items-center shadow-md sticky top-0 left-0 z-30">
            <button type="button" class="text-lg sidebar-toggle">
                <i class="ri-menu-line"></i>
            </button>
            <ul class="flex items-center text-md ml-4">
                <li class="mr-2">
                    <p class="text-black font-medium">Sales / Receipt</p>
                </li>
            </ul>
        </div>

        <!-- receipt -->
        <div class="flex flex-col items-center min-h-screen">
            <div class="w-1/2 mt-10">
             
                <!-- Add receipt details here -->
                <div id="receipt" class="bg-white rounded-xl shadow-md">
                    <div class=" bg-green-800 text-white p-10">
                    <div class="flex justify-between">
                    <h2 class="text-6xl font-medium">Receipt</h2>
                    <h2 class="text-6xl font-medium">₱123</h2>
                    </div>
                    
                    <div class="flex justify-between mt-8 text-gray-300">
                        <span>March 3 , 2016</span>
                        <span>Order ID: 1234567</span>
                        <span>Payment Method: Card</span>
                    </div>

                    </div>

                    <div class="p-10">
                    <ul id="cart-items" class="">
                        <!-- Cart items will be added here by JavaScript -->
                    </ul>


                    <div class="grid grid-cols-2 gap-6 mt-6">
                        <div class="grid grid-rows-4">
                        <div class="border-b text-gray-400 text-xl font-bold pb-2 mb-2">Billing Address</div>
                            <div>Billing Address</div>
                            <div>Block Number</div>
                            <div>Locale / Municipality</div>
                        </div>

                        <div>
                            <div class="flex justify-between border-b text-lg pb-4 mb-2 text-gray-400">
                                <span>Subtotal</span>
                                <span>₱123456</span>
                            </div>   
                              <div class="flex justify-between border-b text-lg pb-2 mt-4 text-gray-400">
                                <span>Taxes</span>
                                <span>₱123456</span>
                            </div>  
                            <div class="flex justify-between font-semibold border-b text-xl pb-2 text-gray-400 mt-4">
                                <span>Total</span>
                                <span class="text-green-800 font-semibold">₱123456</span>
                            </div>
                        </div>
                    </div>


                    </div>
                    <button class="print-button mt-4 w-full text-black text-xl py-4 px-4 hover:bg-gray-200 hover:font-bold transition-all ease-in-out">
                    <i class="ri-import-line font-medium text-2xl"></i>
                     Print Receipt</button>
                    </div>
                
            </div>
        </div>

        <script>
            // Get the cart items from localStorage
            var cart = JSON.parse(localStorage.getItem('cart')) || [];

            // Get the cart items element
            var cartItemsElement = document.getElementById('cart-items');

            // Add each cart item to the cart items element
            for (var i = 0; i < cart.length; i++) {
                var item = cart[i];
                var li = document.createElement('li');
                li.textContent = item.quantity + ' x ' + item.name + ': ₱' + item.price * item.quantity;
                cartItemsElement.appendChild(li);
            }

            // Calculate the total price
            var total = cart.reduce(function(total, item) {
                return total + item.price * item.quantity;
            }, 0);

            // Display the total price
            document.getElementById('total').textContent = 'Total: ₱' + total;
        </script>
    </main>

    <script>
        document.querySelector('.sidebar-toggle').addEventListener('click', function() {
            document.getElementById('sidebar-menu').classList.toggle('hidden');
            document.getElementById('sidebar-menu').classList.toggle('transform');
            document.getElementById('sidebar-menu').classList.toggle('-translate-x-full');
            document.getElementById('mainContent').classList.toggle('md:w-full');
            document.getElementById('mainContent').classList.toggle('md:ml-64');
        });
    </script>

    <script>
        function printReceipt() {
            var receipt = document.getElementById('receipt').innerHTML;
            var originalContent = document.body.innerHTML;

            document.body.innerHTML = receipt;

            window.print();

            document.body.innerHTML = originalContent;
        }

        document.querySelector('.print-button').addEventListener('click', printReceipt);
    </script>

    <script src="./../src/route.js"></script>
</body>

</html>