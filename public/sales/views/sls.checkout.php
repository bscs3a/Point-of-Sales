<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="./../../src/tailwind.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css">
    <script defer src="https://unpkg.com/alpinejs@3.10.2/dist/cdn.min.js"></script>



    <style>
        ::-webkit-scrollbar {
            display: none;
        }
    </style>
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
                    <p class="text-black font-medium">Sales / Point Of Sale(POS) / Checkout</p>
                </li>

            </ul>

            <!-- End: Active Menu -->

            <!-- Start: Profile -->

            <ul class="ml-auto flex items-center">
                <div class="text-black font-medium">Sample User</div>
                <li class="dropdown ml-3">
                    <i class="ri-arrow-down-s-line"></i>
                </li>
            </ul>

            <!-- End: Profile -->

        </div>

        <!-- End: Header -->
        <div class="flex flex-col items-center min-h-screen">
            <div class="w-full max-w-6xl">
                <!-- <div class="flex justify-between items-center">
                    <h1 class="mb-3 text-xl font-bold text-black">Checkout</h1>
                </div> -->
                <!-- Checkout form -->

                <div class="flex flex-row gap-6 mt-10">
                    <div class="bg-white rounded-lg p-6 w-1/2">
                        <!-- Order summary -->
                        <div class="mb-4">
                            <h2 class="text-xl font-medium mb-6 text-gray-500">Order Summary</h2>
                            <div class="text-6xl font-medium mb-10">₱123</div>
                            <!-- Replace with dynamic content -->
                            <ul id="order-summary" x-data="{ cart: JSON.parse(localStorage.getItem('cart')) || [], taxRate: 0.10 }" class="text-gray-700">
                                <!-- Cart item rows -->
                                <template x-for="(item, index) in cart" :key="index">
                                    <li class="py-4 flex justify-between items-center">
                                        <div class="flex">
                                            <img class="h-10 w-10 mr-6" :src="" :alt="item.name">
                                            <span x-text="item.quantity + ' x ' + item.name"></span>
                                        </div>
                                        <span x-text="'₱' + (item.priceWithTax * item.quantity).toFixed(2)"></span>
                                    </li>
                                </template>
                                <div class="ml-16">
                                    <li class="mt-4 pb-4 pt-6 font-semibold border-t border-b mb-4 flex justify-between">
                                        <span x-text="'Subtotal:'"></span>
                                        <span x-text="'₱' + cart.reduce((total, item) => total + item.price * item.quantity, 0).toFixed(2) "></span>

                                    </li>
                                    <li class="py-2 pb-4 text-gray-500 font-medium border-b mb-4 flex justify-between">
                                        <span x-text="'Tax:'"></span>
                                        <span x-text="'₱' + (cart.reduce((total, item) => total + item.price * item.quantity, 0) * taxRate).toFixed(2)"></span>

                                    </li>
                                    <li class="py-4 font-semibold  text-green-800 flex justify-between">
                                        <span x-text="'Total:'"></span>
                                        <span x-text="'₱' + cart.reduce((total, item) => total + item.priceWithTax * item.quantity, 0).toFixed(2)"></span>
                                    </li>
                                </div>
                            </ul>
                        </div>
                    </div>


                    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 w-1/2 h-full mb-10">
                        <form action="/addSales" method="POST" onsubmit="clearCart()">
                            <div class="font-medium text-xl mb-4 text-gray-500 border-b pb-2">Shipping Information</div>
                            <!-- Form for delivery address and date -->
                            <div>
                                <label for="customerFirstName" class="block mb-2">Customer First Name:</label>
                                <input type="text" id="customerFirstName" name="customerFirstName" class="w-full p-2 border border-gray-300 rounded mb-4" required>
                            </div>
                            <div>
                                <label for="customerLastName" class="block mb-2">Customer Last Name:</label>
                                <input type="text" id="customerLastName" name="customerLastName" class="w-full p-2 border border-gray-300 rounded mb-4" required>
                            </div>
                            <div>
                                <label for="customerEmail" class="block mb-2">Customer Email:</label>
                                <input type="email" id="customerEmail" name="customerEmail" class="w-full p-2 border border-gray-300 rounded mb-4" required>
                            </div>
                            <div>
                                <label for="customerPhone" class="block mb-2">Customer Phone:</label>
                                <input type="tel" id="customerPhone" name="customerPhone" class="w-full p-2 border border-gray-300 rounded mb-4" required>
                            </div>

                            <!-- Option for delivery or pick-up -->
                            <div class="mb-4">
                                <label class="block mb-2 font-semibold">Delivery or Pick-up:</label>
                                <select name="SalePreference" id="SalePreference" class="cursor-pointer w-full p-2 border border-gray-300 rounded" onchange="toggleSaleDetails(this.value)">
                                    <option value="delivery">Delivery</option>
                                    <option value="pick-up" selected>Pick-up</option>
                                </select>
                            </div>

                            <div id="sale-details">
                                <label for="address" class="block mb-2">Delivery Address:</label>
                                <input type="text" id="deliveryAddress" name="deliveryAddress" class="w-full p-2 border border-gray-300 rounded mb-4">

                                <label for="deliveryDate" class="block mb-2">Delivery Date:</label>
                                <input type="date" id="deliveryDate" name="deliveryDate" class="w-full p-2 border border-gray-300 rounded mb-4" min="<?php echo date('Y-m-d'); ?>">
                            </div>

                            <script>
                                // Get cart from local storage
                                const cart = JSON.parse(localStorage.getItem('cart') || '[]');

                                // Check if any product requires delivery
                                const deliveryRequired = cart.some(item => item.deliveryRequired === 'Yes');

                                const salePreference = document.getElementById('SalePreference');
                                if (deliveryRequired) {
                                    salePreference.value = 'delivery';
                                    const pickupOption = salePreference.querySelector('option[value="pick-up"]');
                                    pickupOption.disabled = true;
                                } else {
                                    salePreference.value = 'pick-up';
                                }
                                toggleSaleDetails(salePreference.value);

                                function toggleSaleDetails(salePreference) {
                                    const saleDetails = document.getElementById('sale-details');

                                    if (salePreference == 'delivery') {
                                        saleDetails.style.display = 'block';
                                    } else {
                                        saleDetails.style.display = 'none';
                                    }
                                }

                                // Call the function on page load to set the initial state
                                document.addEventListener('DOMContentLoaded', () => {
                                    toggleSaleDetails(document.getElementById('SalePreference').value);
                                });
                            </script>

                            <!-- Mode of payment -->
                            <div class="mb-4">
                                <label class="block mb-2 font-semibold">Mode of Payment:</label>
                                <select name="payment-mode" id="payment-mode" class="w-full p-2 border border-gray-300 rounded" onchange="togglePaymentDetails(this.value)">
                                    <option value="card">Card</option>
                                    <option value="cash">Cash</option>
                                </select>
                            </div>

                            <div id="payment-details" class="grid grid-rows-2 p-4 rounded-md shadow-inner bg-gray-200">
                                <div class="w-full">
                                    <input type="text" id="cardNumber" name="cardNumber" placeholder="Card Number" class="w-full p-4 border border-gray-300 rounded">
                                </div>
                                <div class="grid grid-cols-2">
                                    <div>
                                        <input type="text" id="expiryDate" name="expiryDate" placeholder="Expiry Date" class=" w-full p-4 border border-gray-300 rounded">
                                    </div>
                                    <div>
                                        <input type="number" id="cvv" name="cvv" placeholder="CVC" class="w-full p-4 border border-gray-300 rounded">
                                    </div>
                                </div>
                            </div>

                            <script>
                                function togglePaymentDetails(paymentMode) {
                                    const cardNumberInput = document.getElementById('cardNumber');
                                    const expiryDateInput = document.getElementById('expiryDate');
                                    const cvvInput = document.getElementById('cvv');

                                    if (paymentMode == 'card') {
                                        cardNumberInput.required = true;
                                        expiryDateInput.required = true;
                                        cvvInput.required = true;
                                    } else {
                                        cardNumberInput.required = false;
                                        expiryDateInput.required = false;
                                        cvvInput.required = false;
                                        cardNumberInput.value = '';
                                        expiryDateInput.value = '';
                                        cvvInput.value = '';
                                    }
                                }

                                // Call the function on page load to set the initial state
                                document.addEventListener('DOMContentLoaded', () => {
                                    togglePaymentDetails(document.getElementById('payment-mode').value);
                                });
                            </script>

                            <input type="hidden" id="totalAmount" name="totalAmount">
                            <input type="hidden" id="cartData" name="cartData">

                            <button type="submit" value="Submit" class="bg-green-800 text-white rounded px-4 py-2 mt-4 w-full hover:bg-gray-200 hover:text-green-800 hover:font-bold transition-colors ease-in-out">Complete Sale</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Get the cart from localStorage
            const cart = JSON.parse(localStorage.getItem('cart')) || [];

            // Calculate the total amount
            const totalAmount = cart.reduce((total, item) => total + item.priceWithTax * item.quantity, 0);

            // Set the value of the hidden input field
            document.getElementById('totalAmount').value = totalAmount.toFixed(2);

            // Set the value of the hidden input field
            document.getElementById('cartData').value = JSON.stringify(cart);

            // Assign the cart to a global variable
            window.cart = cart;
        });

        window.onload = function() {
            // Get the delivery option select element
            var deliveryOption = document.getElementById('SalePreference');
            // Get the delivery details element
            var deliveryDetails = document.getElementById('sale-details');

            // Add an event listener for the change event
            deliveryOption.addEventListener('change', function() {
                // If the selected value is 'delivery', show the delivery details
                // Otherwise, hide the delivery details
                if (this.value === 'delivery') {
                    deliveryDetails.style.display = 'block';
                } else {
                    deliveryDetails.style.display = 'none';
                }
            });

            // Get the payment option select element
            var paymentOption = document.getElementById('payment-mode');
            // Get the payment details element
            var paymentDetails = document.getElementById('payment-details');

            // Add an event listener for the change event
            paymentOption.addEventListener('change', function() {
                // If the selected value is 'card', show the payment details
                // Otherwise, hide the payment details
                if (this.value === 'card') {
                    paymentDetails.style.display = 'block';
                } else {
                    paymentDetails.style.display = 'none';
                }
            });
        };

        // Add an event listener for the click event
        document.querySelector('.sidebar-toggle').addEventListener('click', function() {
            // Toggle the hidden, transform, and -translate-x-full classes
            document.getElementById('sidebar-menu').classList.toggle('hidden');
            document.getElementById('sidebar-menu').classList.toggle('transform');
            document.getElementById('sidebar-menu').classList.toggle('-translate-x-full');

            // Toggle the md:w-full and md:ml-64 classes
            document.getElementById('mainContent').classList.toggle('md:w-full');
            document.getElementById('mainContent').classList.toggle('md:ml-64');
        });
    </script>

    <script src="./../../src/form.js"></script>
    <script src="./../../src/route.js"></script>
</body>

</html>