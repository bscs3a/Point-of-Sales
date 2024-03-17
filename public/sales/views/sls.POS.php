<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Point of Sale (POS)</title>

    <link href="./../src/tailwind.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />

    <script defer src="https://unpkg.com/alpinejs@3.10.2/dist/cdn.min.js"></script>

    <style>
        .sidebar-open {
            grid-template-columns: 1fr 300px;
        }

        .sidebar-closed {
            grid-template-columns: 1fr;
        }

        ::-webkit-scrollbar{
            display: none;
        }

    </style>

    <?php
    // Database connection
    $host = 'localhost';
    $db   = 'sales';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $pdo = new PDO($dsn, $user, $pass);

    // Query
    $sql = "SELECT * FROM products";
    $stmt = $pdo->query($sql);

    // Fetch all products
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Query for categories
    $sql = "SELECT DISTINCT Category FROM products";
    $stmt = $pdo->query($sql);

    // Fetch all categories
    $categories = $stmt->fetchAll(PDO::FETCH_COLUMN);
    ?>

    <script src="js/app.js" defer></script>
</head>

<body x-data="main">
    <?php include "components/sidebar.php" ?>

    <main id="mainContent" class="w-full md:w-[calc(100%-256px)] md:ml-64 min-h-screen transition-all main">

        <div id="header" class="py-2 px-6 bg-white flex items-center shadow-md sticky top-0 left-0 z-30">

            <!-- Sidebar toggle button -->
            <button type="button" class="text-lg sidebar-toggle" @click="cartOpen = false; sidebarOpen = true">
                <i class="ri-menu-line"></i>
            </button>

            <!-- Main title or heading -->
            <ul class="flex items-center text-md ml-4">
                <li class="mr-2">
                    <p class="text-black font-medium">Sales / Point of Sale(POS)</p>
                </li>
            </ul>

            <!-- User information -->
            <ul class="ml-auto flex items-center">
                <!-- User name or identifier -->
                <div class="text-black font-medium">Sample User</div>

                <!-- Dropdown for user options -->
                <li class="dropdown ml-3">
                    <i class="ri-arrow-down-s-line"></i>
                </li>
            </ul>
        </div>


        <!-- Start: Full Screen Icon -->
        <div class="absolute top-0 right-0">
            <i id="fullscreenIcon" class="fas fa-expand" @click="isFullScreen = !isFullScreen; sidebarOpen = false;" :class="{ 'p-3 text-lg': isFullScreen, 'pt-14 pr-3 text-lg': !isFullScreen }"></i>
        </div>
        <!-- End: Full Screen Icon -->

        <div class="flex justify-between items-center w-full pt-10 pl-10">

            <form class="max-w-lg ml-20 mb-3 w-2/5 pl-10">

                <!-- Dropdown for selecting categories -->
                <div class="flex">
                    <label for="search-dropdown" class="mb-2 text-sm font-medium text-gray-900 sr-only">Your Email</label>
                    <!-- Button to toggle the dropdown -->
                    <button id="dropdown-button" data-dropdown-toggle="dropdown" class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100" type="button">
                        All categories <!-- Dropdown indicator icon -->
                        <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg>
                    </button>

                    <!-- Dropdown menu for categories -->
                    <div id="dropdown" class="absolute z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 mt-10">
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdown-button">
                            <?php foreach ($categories as $category) : ?>
                                <li>
                                    <!-- Button for each category -->
                                    <button type="button" class="inline-flex w-full px-4 py-2 hover:bg-gray-100"><?= $category ?></button>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Search input field -->
                    <div class="relative w-full">
                        <input type="search" id="search-dropdown" class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg border-s-gray-50 border-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Search Hardware, Tools, Supplies..." required />

                        <!-- Search button -->
                        <button type="submit" class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-green-800 rounded-e-lg border border-green-800 hover:bg-green-900 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                            <!-- Search button label -->
                            <span class="sr-only">Search</span>
                        </button>
                    </div>
                </div>
            </form>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    // Get references to the dropdown button and the dropdown menu
                    const dropdownButton = document.getElementById('dropdown-button');
                    const dropdown = document.getElementById('dropdown');

                    // Toggle the visibility of the dropdown menu when the dropdown button is clicked
                    dropdownButton.addEventListener('click', function() {
                        dropdown.classList.toggle('hidden');
                    });

                    // Close the dropdown menu when a click occurs outside of the dropdown button or the dropdown menu
                    document.addEventListener('click', function(event) {
                        // Check if the clicked element is the dropdown button or inside the dropdown menu
                        const isDropdownButton = event.target.matches('#dropdown-button');
                        const isDropdown = event.target.closest('#dropdown');

                        // If the click is neither on the dropdown button nor inside the dropdown menu, hide the dropdown menu
                        if (!isDropdownButton && !isDropdown) {
                            dropdown.classList.add('hidden');
                        }
                    });
                });
            </script>

            <div class="right-0 fixed flex items-center border-2 rounded-l-md bg-gray-200">
                <div class="flex items-center">
                    <!-- Button to toggle the cart view -->
                    <button type="button" @click="if (sidebarOpen) { sidebarOpen = false; cartOpen = !cartOpen; } else { cartOpen = !cartOpen; }" x-show="!cartOpen" class="items-center flex bg-gray-200 border-gray-300 border py-2 w-full justify-between sidebar-toggle2 hover:bg-green-800 hover:border-white hover:text-white hover:font-bold ease-in-out transition-all">
                        <!-- Icon indicating going back to the previous view -->
                        <i class="ri-arrow-left-s-line ml-5 mr-5 text-xl"></i>
                        <!-- Vertical separator line -->
                        <div class="border-r border-gray-400 h-6"></div>
                        <!-- Cart icon and text -->
                        <div class="px-5">
                            <i class="ri-shopping-cart-2-fill text-xl mr-2"></i>
                            <span>View Cart</span>
                        </div>
                    </button>
                </div>
            </div>

        </div>



        <!-- Cart -->
        <div id="cart" x-show="cartOpen" class="fixed right-0 top-10 w-96 overflow-auto rounded-l-lg border-2 border-gray-300 bg-white shadow" x-bind:style="isFullScreen ? 'height: 94vh;' : 'height: 88vh;'" :class="{ '': isFullScreen, 'mt-12': !isFullScreen }">
            <!-- Close Sidebar Button -->
            <div @click="sidebarOpen = false; cartOpen = !cartOpen" class="flex items-center py-2 text-black no-underline bg-gray-200 border-b hover:bg-green-800 hover:text-white border-gray-300 cursor-pointer">
                <i class="ri-arrow-right-s-line text-xl ml-5 mr-5"></i>
                <div class="border-r border-gray-400 h-6"></div>
                <div class="mx-3">
                    <i class="ri-shopping-cart-2-fill text-xl mr-2"></i>
                    <span>Cart</span>
                </div>
            </div>

            <!-- Add Order and Delete buttons -->
            <div class="flex justify-between px-3 py-2">
                <!-- <button class="py-1 px-4 rounded bg-gray-100 border-2 border-gray-300">
                    <i class="ri-add-circle-fill text-xl"></i> Add Order
                </button> -->
                <button></button>
                <button data-open-modal class="py-1 px-3 rounded bg-gray-100 border-2 border-gray-300 hover:bg-red-400 hover:border-red-600 active:scale-75 transition-all transform ease-in-out" >
                    <i class="ri-delete-bin-7-fill text-xl"></i>
                </button>


            <!-- MODAL SECTION -->
                <dialog data-modal class="rounded-lg shadow-xl">
                <div class="relative p-4 w-full max-w-md max-h-full">
                 <div class="relative bg-white">
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-red-500 w-12 h-12 dark:text-white-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-semibold text-gray-800 dark:text-gray-800">Are you sure you want to delete this cart order?</h3>
                    <button data-close-modal type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center"
                    @click="clearCart()"
                    >
                        Yes, I'm sure
                    </button>
                    <button data-close-modal2 type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
                </div>
                </div>
                </div>
                    </dialog>


                <!-- MODAL SCRIPT -->
                <script>
                    const openButtons = document.querySelector('[data-open-modal]');
                    const closeButtons = document.querySelector('[data-close-modal]');
                    const closeButton2 = document.querySelector('[data-close-modal2]');
                    const modal = document.querySelector('[data-modal]');

                    openButtons.addEventListener('click', () => {
                        modal.showModal();
                    });

                    closeButtons.addEventListener('click', () => {
                        modal.close();
                    });

                    closeButton2.addEventListener('click', () => {
                        modal.close();
                    });
                </script>

            </div>

            <!-- Cart items -->
            <style>
                tr:nth-child(even) {
                    background: #EEEEEE
                }

                tr:nth-child(odd) {
                    background: #FFF
                }
            </style>
            <div class="flex justify-between px-3 py-2 overflow-y-auto " style="max-height: 26rem;">
                <table class="w-full text-right p-3">
                    <tbody>
                        <!-- Cart item rows -->
                        <template x-for="(item, index) in cart" :key="index">
                            <tr class="bg-gray-100">
                                <td class="text-left px-3 py-2 rounded-l-lg max-w-36" x-text="item.quantity + ' x ' + item.name"></td>
                                <td class="text-left border-l border-gray-400 pl-2 px-3 py-2" x-text="'₱' + item.price"></td>
                                <td class="px-3 py-2 rounded-r-lg">
                                    <i class="ri-close-circle-fill cursor-pointer" @click="removeFromCart(index)"></i>
                                </td>
                            </tr>
                        </template>
                        <!-- Add more item rows as needed -->
                    </tbody>
                </table>
            </div>

            <!-- Order details -->
            <div class="absolute bottom-0 w-full">
                <div class="py-2 px-1 ml-2 border-t">
                    <!-- Order detail rows -->
                    <div class="grid-cols-2 gap-4 items-center mb-2 bg-gray-100 p-4 rounded-lg shadow-md" style="display: grid;">
                        <span class="font-bold text-base">Order Total:</span>
                        <span class="text-base" x-text="'&#8369;' + cart.reduce((total, item) => total + (item.price * item.quantity), 0).toFixed(2)"></span>
                    </div>
                    <!-- Add more order detail rows as needed -->
                </div>

                <!-- Hold and Proceed buttons -->
                <style>
                    .custom-button {
                        background-color: #FFC955;
                        transition: background-color 0.3s ease;
                    }

                    .custom-button:hover {
                        background-color: #FFA500;
                    }
                </style>
                <div class="flex justify-between px-5 py-1 mb-1 space-x-4">
                    <button class="flex items-center justify-center font-bold py-1 px-4 rounded w-1/2 border border-black shadow custom-button">
                        <i class="ri-pause-line text-lg mr-2"></i>
                        Hold
                    </button>
                    <button route='/sls/POS/Checkout' class="flex items-center justify-center font-bold py-1 px-4 rounded w-1/2 border border-black shadow custom-button">
                        <i class="ri-shopping-basket-2-fill mr-2"></i>
                        Proceed
                    </button>
                </div>
            </div>
        </div>


        <div class="flex flex-col items-center min-h-screen w-full sidebar-toggle3" :class="{ 'w-full': !cartOpen, 'w-9/12': cartOpen }">
            <?php
            // Assuming $products is an array of arrays where each inner array contains the product details including category
            $categories = array_unique(array_column($products, 'Category')); // Extracting unique categories from products
            ?>
            <?php foreach ($categories as $category) : ?>
                <!-- Display category name -->
                <div class="text-xl font-bold divide-y ml-3 mt-5"><?= $category ?></div>
                <!-- Horizontal line -->
                <hr class="w-full border-gray-300 my-2">
                <div id="grid" class="mb-10" x-bind:class="cartOpen ? ' grid-cols-5 gap-4' : (!cartOpen && sidebarOpen) ? ' grid-cols-6 gap-4' : (!cartOpen && !sidebarOpen) ? ' grid-cols-6 gap-4' : ' grid-cols-5 gap-4'" style="display: grid;">
                    <?php foreach ($products as $product) : ?>
                        <?php if ($product['Category'] === $category) : ?> <!-- Show products only for the current category -->
                            <button type="button" class="product-item w-52 h-70 p-6 flex flex-col items-center justify-center border rounded-lg border-solid border-gray-300 shadow-lg focus:ring-4 active:scale-90 transform transition-transform ease-in-out"
                             @click="addToCart({ id: <?= $product['ProductID'] ?>, name: '<?= $product['ProductName'] ?>', price: <?= $product['Price'] ?> }); 
                        cartOpen = true;">
                                <div class="size-24 rounded-full shadow-md bg-yellow-200 mb-4">
                                    <!-- SVG icon -->
                                </div>
                                <!-- Horizontal line -->
                                <hr class="w-full border-gray-300 my-2">
                                <div class="font-bold text-lg text-gray-700 text-center"><?= $product['ProductName'] ?></div>
                                <div class="font-normal text-sm text-gray-500"><?= $product['Category'] ?></div>
                                <div class="mt-6 text-lg font-semibold text-gray-700">&#8369;<?= $product['Price'] ?></div>
                                <div class="text-gray-500 text-sm">Stocks: <?= $product['Quantity'] ?></div>
                        </button>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>

    </main>

    <script src="./../src/route.js"></script>
</body>

<script>

    // Initialize Alpine.js data
    document.addEventListener('alpine:init', () => {
        Alpine.data('main', () => ({
            sidebarOpen: true,
            cartOpen: false,
            isFullScreen: false,

            // Load the cart items from localStorage when the page loads
            init() {
                let savedCart = localStorage.getItem('cart');
                if (savedCart) {
                    this.cart = JSON.parse(savedCart);
                }
            },

            cart: [],
            // Function to add product to cart
            addToCart(product) {
                let item = this.cart.find(i => i.id === product.id);
                if (item) {
                    item.quantity++;
                } else {
                    this.cart.push({
                        ...product,
                        quantity: 1
                    });
                }

                // Save the cart items to localStorage
                localStorage.setItem('cart', JSON.stringify(this.cart));
            },
            // Function to remove product from cart
            removeFromCart(index) {
                this.cart.splice(index, 1);
                localStorage.setItem('cart', JSON.stringify(this.cart));
            },
            // Function to clear the cart
            clearCart() {
                this.cart = [];
                localStorage.setItem('cart', JSON.stringify(this.cart));
            }
        }));
    });

    // Toggle sidebar visibility and adjust grid columns
    document.querySelector('.sidebar-toggle').addEventListener('click', function() {
        // Toggle sidebar visibility and transformation
        document.getElementById('sidebar-menu').classList.toggle('hidden');
        document.getElementById('sidebar-menu').classList.toggle('transform');
        document.getElementById('sidebar-menu').classList.toggle('-translate-x-full');
        // Toggle main content width and margin
        document.getElementById('mainContent').classList.toggle('md:w-full');
        document.getElementById('mainContent').classList.toggle('md:ml-64');

        // Adjust grid columns based on sidebar visibility
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

    // Toggle sidebar visibility and adjust grid columns (alternative method)
    document.querySelector('.sidebar-toggle2').addEventListener('click', function() {
        var sidebarMenu = document.getElementById('sidebar-menu');
        var grid = document.querySelector('.grid');

        // Check if sidebar is not hidden
        if (!sidebarMenu.classList.contains('hidden')) {
            // Toggle sidebar visibility and transformation
            sidebarMenu.classList.toggle('hidden');
            sidebarMenu.classList.toggle('transform');
            sidebarMenu.classList.toggle('-translate-x-full');
            // Toggle main content width and margin
            document.getElementById('mainContent').classList.toggle('md:w-full');
            document.getElementById('mainContent').classList.toggle('md:ml-64');

            // Adjust grid columns based on sidebar visibility
            if (!sidebarMenu.classList.contains('hidden')) {
                grid.classList.remove('grid-cols-6');
                grid.classList.add('grid-cols-5');
            } else {
                grid.classList.remove('grid-cols-5');
                grid.classList.add('grid-cols-6');
            }
        }
    });

    // Toggle sidebar visibility and adjust grid columns (alternative method)
    document.querySelector('.sidebar-toggle3').addEventListener('click', function() {
        // Adjust grid columns based on sidebar visibility
        var sidebarMenu = document.getElementById('sidebar-menu');
        var grid = document.querySelector('.grid');
        if (sidebarMenu.classList.contains('hidden')) {
            grid.classList.remove('grid-cols-5');
            grid.classList.add('grid-cols-6');
            // Toggle sidebar visibility and transformation
            document.getElementById('sidebar-menu').classList.toggle('hidden');
            document.getElementById('sidebar-menu').classList.toggle('transform');
            document.getElementById('sidebar-menu').classList.toggle('-translate-x-full');
            // Toggle main content width and margin
            document.getElementById('mainContent').classList.toggle('md:w-full');
            document.getElementById('mainContent').classList.toggle('md:ml-64');
        } else {
            // Toggle sidebar visibility and transformation
            document.getElementById('sidebar-menu').classList.toggle('hidden');
            document.getElementById('sidebar-menu').classList.toggle('transform');
            document.getElementById('sidebar-menu').classList.toggle('-translate-x-full');
            // Toggle main content width and margin
            document.getElementById('mainContent').classList.toggle('md:w-full');
            document.getElementById('mainContent').classList.toggle('md:ml-64');
            grid.classList.remove('grid-cols-6');
            grid.classList.add('grid-cols-5');
        }
    });

    // Toggle fullscreen mode
    document.getElementById('fullscreenIcon').addEventListener('click', function() {
        var header = document.getElementById('header');
        var sidebarMenu = document.getElementById('sidebar-menu');

        // Check if header is visible
        if (header.style.display === 'none') {
            // Show header
            header.style.display = 'flex';
            // Hide sidebar if it's not hidden
            if (!sidebarMenu.classList.contains('hidden')) {
                sidebarMenu.classList.toggle('hidden');
                sidebarMenu.classList.toggle('transform');
                sidebarMenu.classList.toggle('-translate-x-full');
                document.getElementById('mainContent').classList.toggle('md:w-full');
                document.getElementById('mainContent').classList.toggle('md:ml-64');
            }
        } else {
            // Hide header
            header.style.display = 'none';
            // Hide sidebar if it's not hidden
            if (!sidebarMenu.classList.contains('hidden')) {
                sidebarMenu.classList.toggle('hidden');
                sidebarMenu.classList.toggle('transform');
                sidebarMenu.classList.toggle('-translate-x-full');
                document.getElementById('mainContent').classList.toggle('md:w-full');
                document.getElementById('mainContent').classList.toggle('md:ml-64');
            }
        }
    });
</script>


</html>