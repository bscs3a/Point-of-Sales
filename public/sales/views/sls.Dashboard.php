<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Dashboard</title>

    <!-- Stylesheets -->
    <link href="./../src/tailwind.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css">

    <!-- Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?php include "components/sidebar.php" ?>

    <!-- Main container -->
    <main id="mainContent" class="w-full md:w-[calc(100%-256px)] md:ml-64 min-h-screen transition-all main">

        <!-- Start: Header -->

        <div class="py-2 px-6 bg-white flex items-center shadow-md sticky top-0 left-0 z-30">

            <!-- Start: Active Menu -->

            <button type="button" class="text-lg sidebar-toggle">
                <i class="ri-menu-line"></i>
            </button>

            <ul class="flex items-center text-md ml-4">

                <li class="mr-2">
                    <p class="text-black font-medium">Sales / Dashboard</p>
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

        <div class="min-h-screen p-6">
            <!-- Dashboard Analytics -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <!-- Target Sales Card -->
                <div class="md:col-span-2 bg-white rounded-md border border-gray-200 p-6 shadow-md shadow-black/5">
                    <!-- Card header -->
                    <div class="flex justify-between">
                        <!-- Card title -->
                        <div>
                            <div class="text-lg font-semibold text-gray-800" style="color: #262261;">
                                <i class="ri-funds-box-fill ri-fw" style="font-size: 1.2em;"></i> Target Sales for This Month
                            </div>
                            <!-- Card data -->
                            <div class="text-4xl font-semibold ml-5 mt-4" style="color: #262261;">Php 52,580 <span style="color: gray;">/ Php 32,000</span></div>
                            <!-- Additional data -->
                            <div class="text-sm font-semibold ml-5 mt-2" style="color: #5DD783;">+10% more than average</div>
                        </div>
                        <!-- Card options -->
                        <div>
                            <button type="button" class="dropdown-toggle text-gray-800 hover:text-gray-600"><i class="ri-more-fill"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Transaction Rate Card -->
                <div class="bg-white rounded-md border p-6 shadow-md shadow-black/5">
                    <!-- Card header -->
                    <div class="flex justify-between">
                        <!-- Card title -->
                        <div>
                            <div class="text-lg font-semibold text-gray-800" style="color: #262261;">
                                <i class="ri-shake-hands-fill" style="font-size: 1.2em;"></i> Transaction Rate
                            </div>
                            <!-- Card data -->
                            <div class="text-4xl font-semibold ml-5 mt-4" style="color: #262261;">53</div>
                            <!-- Additional data -->
                            <div class="text-sm font-semibold ml-5 mt-2" style="color: #5DD783;">+10% more than average</div>
                        </div>
                        <!-- Card options -->
                        <div>
                            <button type="button" class="dropdown-toggle text-gray-800 hover:text-gray-600"><i class="ri-more-fill"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sales and Stocks Analytics -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <!-- Sales Chart Card -->
                <div class="md:col-span-2 bg-white rounded-md border border-gray-200 p-6 shadow-md shadow-black/5">
                    <!-- Card header -->
                    <div class="flex justify-between">
                        <!-- Card title -->
                        <div>
                            <div class="text-lg font-semibold text-gray-800" style="color: #262261;">
                                <i class="ri-funds-box-fill ri-fw" style="font-size: 1.2em;"></i> Sales
                            </div>
                        </div>
                        <!-- Card options -->
                        <div>
                            <button type="button" class="dropdown-toggle text-gray-800 hover:text-gray-600"><i class="ri-more-fill"></i></button>
                        </div>
                    </div>

                    <!-- Sales Chart -->
                    <div class="h-60">
                        <canvas id="myChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!-- Stocks Chart Card -->
                <div class="bg-white rounded-md border p-6 shadow-md shadow-black/5 h-full">
                    <!-- Card header -->
                    <div class="flex justify-between mb-2">
                        <!-- Card title -->
                        <div class="">
                            <div class="text-lg font-semibold text-gray-800" style="color: #262261;">
                                <i class="ri-box-3-fill" style="font-size: 1.2em;"></i> Stocks: <span class="font-bold text-gray-400">200/500</span>
                            </div>

                        </div>
                        <!-- Card options -->
                        <div>
                            <button type="button" class="dropdown-toggle text-gray-800 hover:text-gray-600"><i class="ri-more-fill"></i></button>
                        </div>
                    </div>
                    <!-- Stocks Chart -->
                    <div class="border border-dashed p-2 py-5 px-5 mt-10">
                        <canvas id="stocksChart" class="w-full h-96"></canvas>
                    </div>
                </div>

            </div>

            <div>
                <div class="flex justify-between items-center">
                    <h1 class="mb-3 text-xl font-bold text-black">Product Transactions</h1>
                    <div class="relative mb-3">
                        <select id="searchType" class="px-3 py-2 border rounded-lg mr-2">
                            <option value="product">Product</option>
                            <option value="orderId">Order ID</option>
                            <option value="customer">Customer</option>
                        </select>
                        <input type="text" id="productSearchInput" placeholder="Search..." class="px-3 py-2 pl-5 pr-10 border rounded-lg">
                        <!-- ... -->
                    </div>
                </div>

                <?php
                // Get PDO instance
                $database = Database::getInstance();
                $pdo = $database->connect();

                // Query for sale details
                $sqlSaleDetails = "
                    SELECT SaleDetails.*, Sales.SaleDate, Sales.CustomerID, Products.ProductName, Customers.FirstName, Customers.LastName 
                    FROM SaleDetails 
                    JOIN Sales ON SaleDetails.SaleID = Sales.SaleID 
                    JOIN Products ON SaleDetails.ProductID = Products.ProductID 
                    JOIN Customers ON Sales.CustomerID = Customers.CustomerID
                ";
                $stmtSaleDetails = $pdo->query($sqlSaleDetails);
                $saleDetails = $stmtSaleDetails->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <table id="productTransactionsTable" class="table-auto w-full mx-auto text-left rounded-lg overflow-hidden shadow-lg">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 font-semibold">Product</th>
                            <th class="px-4 py-2 font-semibold">Order ID</th>
                            <th class="px-4 py-2 font-semibold">Date and Time</th>
                            <th class="px-4 py-2 font-semibold">Customer</th>
                            <th class="px-4 py-2 font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($saleDetails as $saleDetail) : ?>
                            <tr class="border border-gray-200 bg-white">
                                <td class="px-4 py-2 flex items-start">
                                    <img src="https://via.placeholder.com/150" alt="Product Image" class="w-20 h-20 object-cover mr-4">
                                    <div>
                                        <div><?= $saleDetail["ProductName"] ?></div>
                                        <div>Quantity: <?= $saleDetail["Quantity"] ?></div>
                                        <div>Price: $<?= $saleDetail["UnitPrice"] ?></div>
                                    </div>
                                </td>
                                <td class="px-4 py-2"><?= $saleDetail["SaleID"] ?></td>
                                <td class="px-4 py-2"><?= date("F j, Y, g:i a", strtotime($saleDetail["SaleDate"])) ?></td>
                                <td class="px-4 py-2"><?= $saleDetail["FirstName"] . " " . $saleDetail["LastName"] ?></td>
                                <td class="px-4 py-2">View</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </main>

    <script>
        document.getElementById('productSearchInput').addEventListener('keyup', function() {
            // Get the search input value
            var searchValue = this.value.toLowerCase();

            // Get the selected search type
            var searchType = document.getElementById('searchType').value;

            // Get all table rows
            var rows = document.querySelectorAll('#productTransactionsTable tbody tr');

            // Loop through the rows
            rows.forEach(function(row) {
                // Get the cell based on the search type
                var cell;
                switch (searchType) {
                    case 'product':
                        cell = row.querySelector('td:nth-child(1)');
                        break;
                    case 'orderId':
                        cell = row.querySelector('td:nth-child(2)');
                        break;
                    case 'customer':
                        cell = row.querySelector('td:nth-child(4)');
                        break;
                }

                // If the cell includes the search value, show the row, otherwise hide it
                if (cell.textContent.toLowerCase().includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>

    <!-- Chart.js configurations -->
    <script>
        // Line Chart for Sales
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                    label: 'Sales',
                    data: [60, 30, 25, 90, 60, 100, 150, 200, 500, 300, 350, 400],
                    backgroundColor: 'transparent',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2
                }, {
                    label: 'Target',
                    data: [50, 100, 150, 200, 250, 300, 350, 400, 450, 500, 550, 400],
                    backgroundColor: 'transparent',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Bar Chart for Stocks
        var ctx = document.getElementById('stocksChart').getContext('2d');
        var stocksChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Stocks'],
                datasets: [{
                        label: 'Sold',
                        data: [300],
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2
                    },
                    {
                        label: 'Remaining',
                        data: [200],
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 500 // Set the maximum value of the y-axis to 500
                    }
                }
            }
        });
    </script>

    <script>
        document.querySelector('.sidebar-toggle').addEventListener('click', function() {
            document.getElementById('sidebar-menu').classList.toggle('hidden');
            document.getElementById('sidebar-menu').classList.toggle('transform');
            document.getElementById('sidebar-menu').classList.toggle('-translate-x-full');
            document.getElementById('mainContent').classList.toggle('md:w-full');
            document.getElementById('mainContent').classList.toggle('md:ml-64');
        });
    </script>
    <script src="./../src/route.js"></script>
</body>

</html>