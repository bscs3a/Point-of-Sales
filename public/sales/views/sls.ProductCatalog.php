<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalog</title>

    <!-- External CSS -->
    <link href="./../src/tailwind.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />

    <!-- External JavaScript (Alpine.js) -->
    <script defer src="https://unpkg.com/alpinejs@3.10.2/dist/cdn.min.js"></script>

    
    <style>
        .sidebar-open {
            grid-template-columns: 1fr 300px;
        }

        .sidebar-closed {
            grid-template-columns: 1fr;
        }

        ::-webkit-scrollbar {
            display: none;
        }
    </style>

    <!-- Inline PHP -->
    <?php
    require_once 'function/getProducts.php';

    $data = getProductsAndCategories();
    $products = $data['products'];
    $categories = $data['categories'];
    ?>

</head>

<body x-data="{ sidebarOpen: true, cartOpen: false, isFullScreen: false }">
    <?php include "components/sidebar.php" ?>

    <!-- Main Content -->
    <main id="mainContent" class="w-full md:w-[calc(100%-256px)] md:ml-64 min-h-screen transition-all main">

        <!-- Header -->
        <div id="header" class="py-2 px-6 bg-white flex items-center shadow-md sticky top-0 left-0 z-30">
            <!-- Sidebar Toggle Button -->
            <button type="button" class="text-lg sidebar-toggle" @click="cartOpen = false; sidebarOpen = !sidebarOpen">
                <i class="ri-menu-line"></i>
            </button>

            <!-- Page Title -->
            <ul class="flex items-center text-md ml-4">
                <li class="mr-2">
                    <p class="text-black font-medium">Sales / Product Catalog</p>
                </li>
            </ul>

            <!-- User Profile -->
            <ul class="ml-auto flex items-center">
                <div class="text-black font-medium">Sample User</div>
                <li class="dropdown ml-3">
                    <i class="ri-arrow-down-s-line"></i>
                </li>
            </ul>
        </div>

        <!-- Search Form -->
        <div class="flex justify-between items-center w-full pt-10">
            <form class="max-w-lg ml-20 mb-3 w-2/5">
                <!-- Dropdown for Categories -->
                <div class="flex">
                    <label for="search-dropdown" class="mb-2 text-sm font-medium text-gray-900 sr-only">Your Email</label>
                    <button id="dropdown-button" data-dropdown-toggle="dropdown" class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100" type="button">All categories <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg></button>
                    <div id="dropdown" class="absolute z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 mt-10">
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdown-button">
                            <!-- Dropdown Options -->
                            <?php foreach ($categories as $category) : ?>
                                <li>
                                    <button type="button" class="inline-flex w-full px-4 py-2 hover:bg-gray-100"><?= $category ?></button>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <!-- Search Input -->
                    <div class="relative w-full">
                        <input type="search" id="search-dropdown" class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg border-s-gray-50 border-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Search Hardware, Tools, Supplies..." required /> <button type="submit" class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-green-800 rounded-e-lg border border-green-800 hover:bg-green-900 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                            <span class="sr-only">Search</span>
                        </button>
                    </div>
                </div>
            </form>

            <!-- JavaScript for Dropdown -->
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const dropdownButton = document.getElementById('dropdown-button');
                    const dropdown = document.getElementById('dropdown');

                    dropdownButton.addEventListener('click', function() {
                        dropdown.classList.toggle('hidden');
                    });

                    document.addEventListener('click', function(event) {
                        const isDropdownButton = event.target.matches('#dropdown-button');
                        const isDropdown = event.target.closest('#dropdown');
                        if (!isDropdownButton && !isDropdown) {
                            dropdown.classList.add('hidden');
                        }
                    });
                });
            </script>
        </div>

        <!-- Product Grid -->
        <div class="flex flex-col items-center min-h-screen w-full mb-10" :class="{ 'w-full': !cartOpen, 'w-9/12': cartOpen }">
            <!-- Loop through Categories -->
            <?php foreach ($categories as $category) : ?>
                <div class="text-xl font-bold divide-y ml-3 mt-5"><?= $category ?></div> <!-- Display category name -->
                <hr class="w-full border-gray-300 my-2"> <!-- Horizontal line -->
                <div id="grid" x-bind:class="cartOpen ? 'grid grid-cols-5 gap-4' : (!cartOpen && sidebarOpen) ? 'grid grid-cols-5 gap-4' : (!cartOpen && !sidebarOpen) ? 'grid grid-cols-6 gap-4' : 'grid grid-cols-5 gap-4'">
                    <!-- Loop through Products -->
                    <?php foreach ($products as $product) : ?>
                        <?php if ($product['Category'] === $category) : ?>
                            <button data-open-modal class="w-52 h-70 p-6 flex flex-col items-center justify-center border rounded-lg border-solid border-gray-300 shadow-lg focus:ring-4 active:scale-90 transform transition-transform ease-in-out" data-product='<?= json_encode($product) ?>'>
                                <div class="size-24 rounded-full shadow-md bg-yellow-200 mb-4">
                                    <!-- SVG icon -->
                                </div>
                                <hr class="w-full border-gray-300 my-2"> <!-- Horizontal line -->
                                <div class="font-bold text-lg text-gray-700 text-center"><?= $product['ProductName'] ?></div>
                                <div class="font-normal text-sm text-gray-500"><?= $product['Category'] ?></div>
                                <div class="mt-6 text-lg font-semibold text-gray-700"><?= $product['Price'] ?></div>
                                <div class="text-gray-500 text-sm">Stocks: <?= $product['Stocks'] ?></div>
                            </button>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Modal Section -->
        <dialog data-modal class="rounded-lg shadow-xl  w-1/4 max-h-full">
            <!-- Modal Header -->
            <div class="w-full bg-green-800 h-10 flex justify-end items-center">
                <button data-close-modal> <i class="ri-close-fill text-2xl font-bold text-white p-2"></i></button>
            </div>

            <!-- Modal Content -->
            <div class="relative p-4">
                <div class="relative bg-white">
                    <div class="flex justify-center">
                        <div class="size-64 rounded-full shadow-lg bg-yellow-200 mb-4"></div>
                    </div>
                    <div class="flex justify-between pt-4">
                        <h3 id="modal-product-name" class="mb-5 text-2xl font-semibold text-gray-800 dark:text-gray-800"></h3>
                        <h3 id="modal-product-price" class="mb-5 text-2xl font-semibold text-gray-800 dark:text-gray-800"></h3>
                    </div>

                    <div class="text-justify ">
                        <div id="modal-product-description" class="text-justify"></div>
                    </div>

                    <div class="flex justify-between pt-6">
                        <h3 id="modal-product-stocks" class="pt-3 text-xl text-gray-500 font-medium"></h3>
                        <button class="p-3 border border-green-900 bg-green-800 text-white rounded-lg font-medium">Add to Cart</button>
                    </div>
                </div>
            </div>
        </dialog>

        <!-- Modal Script -->
        <script>
            const openButtons = document.querySelectorAll('[data-open-modal]');
            const closeButtons = document.querySelector('[data-close-modal]');
            const modal = document.querySelector('[data-modal]');
            const modalProductName = document.getElementById('modal-product-name');
            const modalProductPrice = document.getElementById('modal-product-price');
            const modalProductDescription = document.getElementById('modal-product-description');
            const modalProductStocks = document.getElementById('modal-product-stocks');

            openButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const product = JSON.parse(button.dataset.product);
                    modalProductName.textContent = product.ProductName;
                    modalProductPrice.textContent = 'Php' + product.Price;
                    modalProductDescription.textContent = product.Description;
                    modalProductStocks.textContent = 'Stocks: ' + product.Quantity;
                    modal.showModal();
                });
            });

            closeButtons.addEventListener('click', () => {
                modal.close();
            });
        </script>

    </main>

    <!-- External JavaScript -->
    <script src="./../src/route.js"></script>

    <!-- Sidebar Toggle Script -->
    <script>
        document.querySelector('.sidebar-toggle').addEventListener('click', function() {
            document.getElementById('sidebar-menu').classList.toggle('hidden');
            document.getElementById('sidebar-menu').classList.toggle('transform');
            document.getElementById('sidebar-menu').classList.toggle('-translate-x-full');
            document.getElementById('mainContent').classList.toggle('md:w-full');
            document.getElementById('mainContent').classList.toggle('md:ml-64');

            var sidebarMenu = document.getElementById('sidebar-menu');
            var grid = document.querySelector('.grid');

            if (sidebarMenu.classList.contains('hidden')) {
                grid.classList.remove('grid-cols-5');
                grid.classList.add('grid-cols-6');
            } else {
                grid.classList.remove('grid-cols-6');
                grid.classList.add('grid-cols-5');
            }
        });
    </script>

</body>

</html>