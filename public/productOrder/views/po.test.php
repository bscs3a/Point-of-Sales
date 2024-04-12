
<?php
$db = Database::getInstance();
$conn = $db->connect();

// Debug: Check database connection
if (!$conn) {
    echo "Database connection failed.";
    exit; // Stop execution if connection fails
} else {
    echo "Database connection successful.";
}

// Print GET parameters for debugging
print_r($_GET);
var_dump($_GET);

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize default month
$defaultMonth = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
// Define previous and next months
$prevMonth = date('Y-m', strtotime($defaultMonth . ' -1 month'));
$nextMonth = date('Y-m', strtotime($defaultMonth . ' +1 month'));

// Fetch data based on the selected month
try {
    $requests = fetchRequestsByMonth($conn, $defaultMonth);
} catch (Exception $e) {
    // Handle the exception (e.g., display an error message)
    echo "Error fetching requests: " . $e->getMessage();
    // You can also log the error to a file or database
}

// Function to fetch requests for a specific month
function fetchRequestsByMonth($conn, $month) {
    // Prepare the SQL statement with JOIN to retrieve ProductName, Price, and Date_Ordered
    $sql = "SELECT r.*, p.ProductName, p.Price, od.Date_Ordered
            FROM requests r
            INNER JOIN products p ON r.Product_ID = p.ProductID
            INNER JOIN order_details od ON r.Request_ID = od.Request_ID
            WHERE DATE_FORMAT(od.Date_Ordered, '%Y-%m') = :month";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind parameter
    $stmt->bindParam(':month', $month);

    // Execute the statement
    $stmt->execute();

    // Fetch all rows
    $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are any rows
    if ($stmt->rowCount() > 0) {
        return $requests;
    } else {
        return array();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Request History</title>

    <link href="./../src/tailwind.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css">

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>
<body>
<div class="flex h-screen bg-gray-100">
    <!-- sidebar -->
    <div id="sidebar" class="flex h-screen">
        <?php include "components/po.sidebar.php" ?>
    </div>

    <!-- Main Content -->
    <div class="flex flex-col flex-1 overflow-y-auto">
        <!-- header -->
        <div class="flex items-center justify-between h-16 bg-white shadow-md px-4">
            <div class="flex items-center gap-4">
                <button id="toggleSidebar" class="text-gray-500 focus:outline-none focus:text-gray-700">
                    <i class="ri-menu-line"></i>
                </button>
                <label class="text-black font-medium">Request History</label>
            </div>

            <!-- dropdown -->
            <div x-data="{ dropdownOpen: false }" class="relative my-32">
                <button @click="dropdownOpen = !dropdownOpen"
                        class="relative z-10 border border-gray-50 rounded-md bg-white p-2 focus:outline-none">
                    <div class="flex items-center gap-4">
                        <a class="flex-none text-sm dark:text-white" href="#">David, Marc</a>
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                </button>

                <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"></div>

                <div x-show="dropdownOpen" class="absolute right-0 mt-2 py-2 w-40 bg-white border border-gray-200 rounded-md shadow-lg z-20">
                    <a href="#" class="block px-8 py-1 text-sm capitalize text-gray-700">Log out</a>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('toggleSidebar').addEventListener('click', function () {
                var sidebar = document.getElementById('sidebar');
                sidebar.classList.toggle('hidden', !sidebar.classList.contains('hidden'));
            });
        </script>

       <!-- Pagination -->
<div class="m-5 flex justify-between items-center">
    <?php if ($prevMonth != ''): ?>
        <a href="/master/po/test/<?php echo $prevMonth; ?>" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md">
            Previous: <?php echo $prevMonth; ?>
        </a>
    <?php endif; ?>

    <span class="text-xl font-semibold"><?php echo date('F Y', strtotime($defaultMonth)); ?></span>

    <?php if ($nextMonth != ''): ?>
        <a href="/master/po/test/<?php echo $nextMonth; ?>" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md">
            Next: <?php echo $nextMonth; ?>
        </a>
    <?php endif; ?>
</div>

        <!-- Existing table -->
        <div class="overflow-overflow rounded-lg border border-gray-300 shadow-md m-5">
            <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                <thead class="bg-gray-200">
                <tr class="border-b border-y-gray-300">
                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Product</th>
                   

 <th scope="col" class="px-6 py-4 font-medium text-gray-900">Request ID</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Date</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Price</th>
                    <th scope="col" class="px-6 py-4 font-medium text-center text-gray-900">Quantity</th>
                    <th scope="col" class="px-6 py-4 font-medium text-center text-gray-900">Total</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 border-b border-gray-300">
                <?php foreach ($requests as $request): ?>
                    <tr class="hover:bg-gray-100">
                        <th class="flex gap-3 px-6 py-7 font-normal text-gray-900">
                            <div class="flex flex-col font-medium text-gray-700 text-sm">
                                <a><?php echo $request['ProductName']; ?></a>
                            </div>
                        </th>
                        <td class="px-6 py-7">
                            <div class="font-medium text-gray-700 text-sm">
                                <?php echo $request['Request_ID']; ?>
                            </div>
                        </td>
                        <td class="px-6 py-7">
                            <div class="font-medium text-gray-700 text-sm">
                                <?php echo $request['Date_Ordered']; ?>
                            </div>
                        </td>
                        <td class="px-6 py-7">
                            <div class="font-medium text-gray-700 text-sm">
                                <?php echo $request['Price']; ?>
                            </div>
                        </td>
                        <td class="px-6 py-7">
                            <div class="font-medium text-gray-700 text-sm">
                                <?php echo $request['Product_Quantity']; ?>
                            </div>
                        </td>
                        <td class="px-6 py-7">
                            <div class="font-medium text-center text-gray-700 text-sm">
                                <?php echo $request['Product_Total_Price']; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="./../src/route.js"></script>
<script src="./../src/form.js"></script>
</body>
</html>
