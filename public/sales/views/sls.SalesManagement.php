<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Management</title>
    <link href="./../src/tailwind.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css">

    <!-- Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <?php
    require_once './src/dbconn.php';
    require_once 'function/fetchSalesData.php';

    // Get PDO instance
    $database = Database::getInstance();
    $pdo = $database->connect();

    // Query for years
    $sqlYears = "SELECT DISTINCT YEAR(MonthYear) AS Year FROM TargetSales ORDER BY Year DESC";
    $stmtYears = $pdo->query($sqlYears);
    $years = $stmtYears->fetchAll(PDO::FETCH_ASSOC);

    // Query for target sales
    $sqlTargetSales = "SELECT MonthYear, TargetAmount FROM TargetSales ORDER BY MonthYear";
    $stmtTargetSales = $pdo->query($sqlTargetSales);
    $targetSales = $stmtTargetSales->fetchAll(PDO::FETCH_ASSOC);

    // Prepare the labels and data for the chart
    $labels = [];
    $data = [];
    foreach ($targetSales as $targetSale) {
        $labels[] = date('Y-F', strtotime($targetSale['MonthYear']));  // Format the date as 'Year-MonthName'
        $data[] = $targetSale['TargetAmount'];
    }

    // Query for total sales
    $sqlTotalSales = "
    SELECT DATE_FORMAT(SaleDate, '%Y-%m-01') AS MonthYear, SUM(TotalAmount) AS TotalSales 
    FROM Sales 
    GROUP BY MonthYear 
    ORDER BY MonthYear
";
    $stmtTotalSales = $pdo->query($sqlTotalSales);
    $totalSales = $stmtTotalSales->fetchAll(PDO::FETCH_ASSOC);

    // Prepare the data for the chart
    $totalSalesData = [];
    foreach ($totalSales as $totalSale) {
        $totalSalesData[] = $totalSale['TotalSales'];
    }
    ?>

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
                    <p class="text-black font-medium">Sales / Sales Management</p>
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

        <div class="flex flex-col items-center min-h-screen mb-10 mt-14">
            <!-- Title -->


            <!-- Sales Chart Card -->
            <div class="flex flex-row w-full items-center px-20 justify-center gap-8">
                <div class="w-full bg-white rounded-md border border-gray-200 p-6 shadow-md">
                    <!-- Card header -->
                    <div class="flex justify-between items-center mb-6">
                        <!-- Card title -->
                        <h2 class="text-lg font-semibold text-gray-800">
                            <i class="ri-funds-box-fill ri-fw" style="color: #262261;"></i> Sales Overview
                        </h2>
                        <!-- Year Select -->
                        <div>
                            <select id="yearSelect" class="border rounded-md px-2 py-1">
                                <?php foreach ($years as $year) : ?>
                                    <option value="<?php echo $year['Year']; ?>"><?php echo $year['Year']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Sales Chart -->
                    <div class="h-60">
                        <canvas id="myChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!-- Target Sales Form -->
                <section id="target-sales-form" class="w-1/3 h-full">
                    <div class="bg-white shadow-md border rounded px-8 py-10">
                        <h2 class="mb-4 text-lg font-bold text-gray-700">Set Target Sales for This Month</h2>
                        <form action="/AddTarget" method="POST">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="month-year">Month and Year:</label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="month" id="month-year" name="month_year" value="<?php echo date('Y-m'); ?>" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="target-sales">Target Sales:</label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" id="target-sales" name="target_sales" required>
                            </div>
                            <div class="flex items-center justify-center pt-4">
                                <button class="bg-green-800 w-full hover:bg-green-900 hover:font-bold text-white font-semibold transition-all py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Set Target</button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>

            <!-- Start: Sales Summary -->
            <section id="sales-summary" class="w-full px-20 py-10 justify-center">
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 border">
                    <h2 class="mb-4 text-lg font-bold text-gray-700">Sales Summary</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-md font-semibold mb-2">Total Sales</h3>
                            <p class="text-lg text-gray-800">₱<?php echo number_format(array_sum($totalSalesData), 2); ?></p>
                        </div>
                        <div>
                            <h3 class="text-md font-semibold mb-2">Average Sales per Month</h3>
                            <p class="text-lg text-gray-800">₱<?php echo number_format(array_sum($totalSalesData) / count($totalSalesData), 2); ?></p>
                        </div>
                        <!-- You can add more metrics here -->
                    </div>
                </div>
            </section>
            <!-- End: Sales Summary -->

                <!-- Dropdown Bar -->
                <div class="flex justify-end w-full mr-40 z-10">
                    <div class="relative">
                        <button class="bg-gray-200 hover:bg-gray-400 transition-colors text-gray-700 font-semibold py-2 px-4 rounded inline-flex items-center" onclick="toggleDropdown()">
                            <span class="mr-1">Select Summary of Sales by:</span>
                        </button>
                        <ul id="dropdownMenu" class="absolute justify-end  w-full shadow-lg font-medium hidden text-gray-700 pt-1">
                        <li><a id="SelectAll" class=" bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap cursor-pointer active:bg-green-800 active:text-white" onclick="showAll()">Show All</a></li>
                            <li><a id="SelectDaily" class=" bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap cursor-pointer active:bg-green-800 active:text-white" onclick="showDailySales()">Daily Sales</a></li>
                            <li><a id="SelectMonthly" class="bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap cursor-pointer active:bg-green-800 active:text-white" onclick="showMonthlySales()">Monthly Sales</a></li>
                            <li><a id="SelectYearly" class=" bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap cursor-pointer active:bg-green-800 active:text-white" onclick="showYearlySales()">Yearly</a></li>
                        </ul>
                    </div>
                </div>

                <script>
                    
                    function initializeSelectAll() {
                        var selectAll = document.getElementById("SelectAll");
                        selectAll.classList.add("bg-green-800");
                        selectAll.classList.add("text-white");
                        selectAll.classList.remove("hover:bg-gray-400");
                    }

                    window.addEventListener("load", initializeSelectAll);

                    function toggleDropdown() {
                        var dropdownMenu = document.getElementById("dropdownMenu");
                        if (dropdownMenu.classList.contains("hidden")) {
                            dropdownMenu.classList.remove("hidden");
                        } else {
                            dropdownMenu.classList.add("hidden");
                        }
                    }
                    
                    document.addEventListener("click", function(event) {
                        var dropdownMenu = document.getElementById("dropdownMenu");
                        if (!event.target.closest("#dropdownMenu") && !event.target.closest(".bg-gray-200")) {
                            dropdownMenu.classList.add("hidden");
                        }
                    });

                    function showDailySales() {
                        var dailySales = document.getElementById("daily-sales");
                        var monthlySales = document.getElementById("monthly-sales");
                        var yearlySales = document.getElementById("yearly-sales");
                        var previousTargetSales = document.getElementById("previous-target-sales");

                        var SelectDaily = document.getElementById("SelectDaily");
                        var SelectMonthly = document.getElementById("SelectMonthly");
                        var SelectYearly = document.getElementById("SelectYearly");


                        dailySales.style.display = "block";
                        monthlySales.style.display = "none";
                        yearlySales.style.display = "none";
                        previousTargetSales.style.display = "none";

                        SelectDaily.classList.add("bg-green-800");
                        SelectDaily.classList.add("text-white");
                        SelectDaily.classList.remove("hover:bg-gray-400");

                        SelectMonthly.classList.remove("bg-green-800");
                        SelectMonthly.classList.remove("text-white");
                        SelectMonthly.classList.add("hover:bg-gray-400");

                        SelectYearly.classList.remove("bg-green-800");
                        SelectYearly.classList.remove("text-white");
                        SelectYearly.classList.add("hover:bg-gray-400");

                        SelectAll.classList.remove("bg-green-800");
                        SelectAll.classList.remove("text-white");
                        SelectAll.classList.add("hover:bg-gray-400");

                    }

                    function showMonthlySales() {
                        var dailySales = document.getElementById("daily-sales");
                        var monthlySales = document.getElementById("monthly-sales");
                        var yearlySales = document.getElementById("yearly-sales");
                        var previousTargetSales = document.getElementById("previous-target-sales");

                        dailySales.style.display = "none";
                        monthlySales.style.display = "block";
                        yearlySales.style.display = "none";
                        previousTargetSales.style.display = "none";

                        SelectDaily.classList.remove("bg-green-800");
                        SelectDaily.classList.remove("text-white");
                        SelectDaily.classList.add("hover:bg-gray-400");

                        SelectMonthly.classList.add("bg-green-800");
                        SelectMonthly.classList.add("text-white");
                        SelectMonthly.classList.remove("hover:bg-gray-400");

                        SelectYearly.classList.remove("bg-green-800");
                        SelectYearly.classList.remove("text-white");
                        SelectYearly.classList.add("hover:bg-gray-400");
                
                        SelectAll.classList.remove("bg-green-800");
                        SelectAll.classList.remove("text-white");
                        SelectAll.classList.add("hover:bg-gray-400");


                    }

                    function showYearlySales() {
                        var dailySales = document.getElementById("daily-sales");
                        var monthlySales = document.getElementById("monthly-sales");
                        var yearlySales = document.getElementById("yearly-sales");
                        var previousTargetSales = document.getElementById("previous-target-sales");

                        dailySales.style.display = "none";
                        monthlySales.style.display = "none";
                        yearlySales.style.display = "block";
                        previousTargetSales.style.display = "none";


                        SelectDaily.classList.remove("bg-green-800");
                        SelectDaily.classList.remove("text-white");
                        SelectDaily.classList.add("hover:bg-gray-400");

                        SelectMonthly.classList.remove("bg-green-800");
                        SelectMonthly.classList.remove("text-white");
                        SelectMonthly.classList.add("hover:bg-gray-400");

                        SelectYearly.classList.add("bg-green-800");
                        SelectYearly.classList.add("text-white");
                        SelectYearly.classList.remove("hover:bg-gray-400");

                        SelectAll.classList.remove("bg-green-800");
                        SelectAll.classList.remove("text-white");
                        SelectAll.classList.add("hover:bg-gray-400");
                    }

                    function showAll(){
                        var dailySales = document.getElementById("daily-sales");
                        var monthlySales = document.getElementById("monthly-sales");
                        var yearlySales = document.getElementById("yearly-sales");
                        var previousTargetSales = document.getElementById("previous-target-sales");

                        dailySales.style.display = "block";
                        monthlySales.style.display = "block";
                        yearlySales.style.display = "block";
                        previousTargetSales.style.display = "block";

                        SelectDaily.classList.remove("bg-green-800");
                        SelectDaily.classList.remove("text-white");
                        SelectDaily.classList.add("hover:bg-gray-400");

                        SelectMonthly.classList.remove("bg-green-800");
                        SelectMonthly.classList.remove("text-white");
                        SelectMonthly.classList.add("hover:bg-gray-400");

                        SelectYearly.classList.remove("bg-green-800");
                        SelectYearly.classList.remove("text-white");
                        SelectYearly.classList.add("hover:bg-gray-400");

                        SelectAll.classList.add("bg-green-800");
                        SelectAll.classList.add("text-white");
                        SelectAll.classList.remove("hover:bg-gray-400");

                    }
                </script>

                </script>


            <!-- Start: Daily Sales Table -->
            <section id="daily-sales" class="w-full px-20 py-10 justify-center">
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 border">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-bold text-gray-700">Daily Sales</h2>
                        <!-- Styled date picker button -->
                        <div class="relative">
                            <label for="searchInput" class="text-gray-700">Search by Date:</label>
                            <input type="date" id="searchInput" onchange="searchTable()" class="border pl-8 pr-4 py-2 rounded-md border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <!-- End of styled date picker button -->
                    </div>
                    <div style="max-height: 300px; overflow-y: auto;">
                        <table class="w-full" id="salesTable">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 w-1/2">Date</th>
                                    <th class="px-4 py-2 w-1/2">Total Sales</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sqlDailySales = "SELECT DATE(SaleDate) AS Date, SUM(TotalAmount) AS TotalSales FROM Sales GROUP BY DATE(SaleDate)";
                                $stmtDailySales = $pdo->query($sqlDailySales);
                                while ($row = $stmtDailySales->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td class='border px-4 py-2 w-1/2' data-date='" . $row['Date'] . "'>" . date("F j, Y", strtotime($row['Date'])) . "</td>";
                                    echo "<td class='border px-4 py-2 w-1/2'>₱" . number_format($row['TotalSales'], 2) . "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            <!-- End: Daily Sales Table -->

            <script>
                function searchTable() {
                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById("searchInput");
                    filter = input.value;
                    table = document.getElementById("salesTable");
                    tr = table.getElementsByTagName("tr");

                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[0];
                        if (td) {
                            txtValue = td.getAttribute('data-date');
                            if (txtValue.indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                }
            </script>


            <!-- Start: Monthly Sales Table -->
            <section id="monthly-sales" class="w-full px-20 py-10 justify-center">
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 border">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-bold text-gray-700">Monthly Sales</h2>
                        <div>
                            <label for="searchInputMonthly" class="mr-2">Search by Month:</label>
                            <input type="month" id="searchInputMonthly" onchange="searchTableMonthly()" class="border pl-8 pr-4 py-2 rounded-md border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                    </div>
                    <div style="max-height: 300px; overflow-y: auto;">
                        <table class="w-full" id="salesTableMonthly">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 w-1/2">Month</th>
                                    <th class="px-4 py-2 w-1/2">Total Sales</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sqlMonthlySales = "SELECT DATE_FORMAT(SaleDate, '%Y-%m') AS Month, SUM(TotalAmount) AS TotalSales FROM Sales GROUP BY DATE_FORMAT(SaleDate, '%Y-%m')";
                                $stmtMonthlySales = $pdo->query($sqlMonthlySales);
                                while ($row = $stmtMonthlySales->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td class='border px-4 py-2 w-1/2' data-month='" . $row['Month'] . "'>" . date("F Y", strtotime($row['Month'])) . "</td>";
                                    echo "<td class='border px-4 py-2 w-1/2'>₱" . number_format($row['TotalSales'], 2) . "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            <!-- End: Monthly Sales Table -->

            <script>
                function searchTableMonthly() {
                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById("searchInputMonthly");
                    filter = input.value;
                    table = document.getElementById("salesTableMonthly");
                    tr = table.getElementsByTagName("tr");

                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[0];
                        if (td) {
                            txtValue = td.getAttribute('data-month');
                            if (txtValue.indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                }
            </script>

            <!-- Start: Yearly Sales Table -->
            <section id="yearly-sales" class="w-full px-20 py-10 justify-center">
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 border">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-bold text-gray-700">Yearly Sales</h2>
                        <div>
                            <label for="searchInputYearly" class="text-gray-700 mr-2">Search by Year:</label>
                            <input type="year" id="searchInputYearly" onchange="searchTableYearly()" class="border pl-2 pr-2 py-2 rounded-md border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                    </div>
                    <div style="max-height: 300px; overflow-y: auto;">
                        <table class="w-full" id="salesTableYearly">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 w-1/2">Year</th>
                                    <th class="px-4 py-2 w-1/2">Total Sales</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sqlYearlySales = "SELECT YEAR(SaleDate) AS Year, SUM(TotalAmount) AS TotalSales FROM Sales GROUP BY YEAR(SaleDate)";
                                $stmtYearlySales = $pdo->query($sqlYearlySales);
                                while ($row = $stmtYearlySales->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td class='border px-4 py-2 w-1/2' data-year='" . $row['Year'] . "'>" . $row['Year'] . "</td>";
                                    echo "<td class='border px-4 py-2 w-1/2'>₱" . number_format($row['TotalSales'], 2) . "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            <!-- End: Yearly Sales Table -->

            <script>
                function searchTableYearly() {
                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById("searchInputYearly");
                    filter = input.value;
                    table = document.getElementById("salesTableYearly");
                    tr = table.getElementsByTagName("tr");

                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[0];
                        if (td) {
                            txtValue = td.getAttribute('data-year');
                            if (txtValue.indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                }
            </script>



            <!-- Previous Target Sales Table -->
            <section id="previous-target-sales" class="w-full px-20 py-10 justify-center">
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 border">
                    <div class="flex justify-between border-b py-2 mb-4">
                        <h2 class="mb-4 text-lg font-bold text-gray-700">Previous Target Sales</h2>
                        <!-- <div class="relative mb-3">
                            <input type="month" id="searchInputPrevTarget" class="h-10 px-2 py-2 pl-5 pr-5 border rounded-lg" onkeyup="searchPrevTargetSales()">
                        </div> -->
                    </div>
                    <div style="max-height: 300px; overflow-y: auto;">
                        <table class="w-full" id="prevTargetSalesTable">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Month and Year</th>
                                    <th class="px-4 py-2">Target Sales</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sqlYearlySales = "SELECT DATE_FORMAT(SaleDate, '%Y-%m') AS MonthYear, SUM(TotalAmount) AS TotalSales FROM Sales GROUP BY DATE_FORMAT(SaleDate, '%Y-%m')";
                                $stmtYearlySales = $pdo->query($sqlYearlySales);
                                while ($row = $stmtYearlySales->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td class='border px-4 py-2 w-1/2' data-month-year='" . $row['MonthYear'] . "'>" . date("F Y", strtotime($row['MonthYear'])) . "</td>";
                                    echo "<td class='border px-4 py-2 w-1/2'>₱" . number_format($row['TotalSales'], 2) . "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- <script>
                function searchPrevTargetSales() {
                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById("searchInputPrevTarget");
                    filter = input.value;
                    // Convert the filter to the format "yyyy-mm"
                    if (filter) {
                        var parts = filter.split("-");
                        var year = parts[0];
                        var month = parts[1];
                        filter = year + "-" + ("0" + month).slice(-2);
                    }
                    table = document.getElementById("prevTargetSalesTable");
                    tr = table.getElementsByTagName("tr");

                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[0];
                        if (td) {
                            txtValue = td.getAttribute('data-month-year').substring(0, 7);
                            if (txtValue === filter) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                }
            </script> -->


            <script>
                document.querySelector('.sidebar-toggle').addEventListener('click', function() {
                    document.getElementById('sidebar-menu').classList.toggle('hidden');
                    document.getElementById('sidebar-menu').classList.toggle('transform');
                    document.getElementById('sidebar-menu').classList.toggle('-translate-x-full');
                    document.getElementById('mainContent').classList.toggle('md:w-full');
                    document.getElementById('mainContent').classList.toggle('md:ml-64');
                });
            </script>



        </div>


    </main>

    <script src="./../src/form.js"></script>
    <script src="./../src/route.js"></script>
    <script>
        // Trigger the change event for the year select element on page load
        window.onload = function() {
            var event = new Event('change');
            document.getElementById('yearSelect').dispatchEvent(event);
        };

        document.getElementById('yearSelect').addEventListener('change', function() {
            // Get the selected year
            var selectedYear = this.value;

            // Get the original labels and data
            var originalLabels = <?php echo json_encode($labels); ?>;
            var originalData = <?php echo json_encode($data); ?>;
            var originalTotalSalesData = <?php echo json_encode($totalSalesData); ?>;

            // Filter the labels and data based on the selected year
            var labels = [];
            var data = [];
            var totalSalesData = [];
            for (var i = 0; i < originalLabels.length; i++) {
                if (originalLabels[i].startsWith(selectedYear)) {
                    labels.push(originalLabels[i]);
                    data.push(originalData[i]);
                    totalSalesData.push(originalTotalSalesData[i]);
                }
            }

            // Update the chart labels and data
            myChart.data.labels = labels;
            myChart.data.datasets[0].data = data;
            myChart.data.datasets[1].data = totalSalesData;
            myChart.update();
        });
    </script>

    <!-- Chart.js configurations -->
    <script>
        // Line Chart for Sales
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels); ?>, // Pass the labels
                datasets: [{
                    label: 'Target',
                    data: <?php echo json_encode($data); ?>, // Pass the target sales data
                    backgroundColor: 'transparent',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2
                }, {
                    label: 'Total Sales',
                    data: <?php echo json_encode($totalSalesData); ?>, // Pass the total sales data
                    backgroundColor: 'transparent',
                    borderColor: 'rgba(255, 99, 132, 1)',
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

</body>

</html>