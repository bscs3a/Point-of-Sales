<!DOCTYPE html>
<html lang="en">
  
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Order Details</title>

    <link href="./../src/tailwind.css" rel="stylesheet" />
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
              <button id="toggleSidebar" class="text-gray-900 focus:outline-none focus:text-gray-700">
                <i class="ri-menu-line"></i>
              </button>
              <label class="text-black font-medium">Order Detail</label>
            </div>

            <!-- dropdown -->
            <div x-data="{ dropdownOpen: false }" class="relative my-32">
              <button @click="dropdownOpen = !dropdownOpen" class="relative z-10 border border-gray-50 rounded-md bg-white p-2 focus:outline-none">
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
            document.getElementById('toggleSidebar').addEventListener('click', function() {
                var sidebar = document.getElementById('sidebar');
                sidebar.classList.toggle('hidden', !sidebar.classList.contains('hidden'));
            });
          </script>

        <!-- Main Content -->
        <div class="h-screen px-10">
          <div class="flex flex-row gap-10 drop-shadow-md my-8">
              <div class="flex flex-col pl-8 border border-gray-300 bg-white rounded-lg w-64 h-40 justify-center">
                <a class="text-6xl ">5350</a>
                <a class="text-lg">Total Delivery</a>
              </div>
              <div class="flex flex-col pl-8 border border-gray-300 bg-white rounded-lg w-64 h-40 justify-center">
                <a class="text-6xl">1214</a>
                <a class="text-lg">To Receive</a>
              </div>
            </div>
          
          <!-- NEW Table -->
            <div class="overflow-x-auto rounded-lg border border-gray-400">
                <table class="min-w-full text-left mx-auto bg-white">
                    <thead class="bg-gray-200 border-b border-gray-400">
                        <tr>
                            <th class="px-4 py-2 font-semibold">Supplier ID</th>
                            <th class="px-4 py-2 font-semibold">Supplier Name</th>
                            <th class="px-4 py-2 font-semibold">Order Date</th>
                            <th class="px-4 py-2 font-semibold">Time</th>
                            <th class="px-4 py-2 font-semibold">Status</th>
                            <th class="px-4 py-2 font-semibold"></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td class="px-4 py-10">12</td>
                            <td class="px-4 py-10">marc</td>
                            <td class="px-4 py-10">03/12/2024</td>
                            <td class="px-4 py-10">09:23:43 AM</td>
                            <td class="px-4 py-10">
                              <select class="rounded-lg border border-gray-400 border-b block px-3 py-1 bg-gray-300 text-sm placeholder-gray-400 text-black focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none">
                              <option value="id">Pending</option>
                              <option value="name">Completed</option>
                              <option value="name">To Receive</option>
                              </select>
                            </td>
                            <td route='/po/viewdetails' class="px-4 py-4">
                              <div>
                                <button route='/po/viewdetails'>view</button>
                              </div>
                            </td>
                        </tr>    
                    </tbody>
                </table>
            </div>

          <!-- table -->
          <div class="overflow-hidden rounded-lg border border-gray-300 shadow-md m-5">
=======

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Details</title>
  <link href="./../src/tailwind.css" rel="stylesheet">
</head>

<body>
  <div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <?php include "components/po.sidebar.php" ?>

    <!-- Main Content -->
    <div class="flex flex-col flex-1 overflow-y-auto">
      <!-- header -->
      <div class="flex items-center justify-between h-16 bg-zinc-200 border-b border-gray-200">
        <div class="flex items-center px-4">
          <button class="text-gray-500 focus:outline-none focus:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
          <h1 class="text-2xl font-semibold px-5">Product Order / Order Details</h1>
        </div>

        <div class="flex items-center pr-4 text-xl font-semibold">
          Sample User
          <span class="p-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
            </svg>
          </span>
        </div>
      </div>

      <!-- Main Content -->
      <div class="h-screen">
        <div class="flex flex-row gap-16 drop-shadow-md ml-5 my-8">
        <?php
          // Include your database connection file
          require_once 'dbconn.php';

          // Function to count the number of unique suppliers
          function countDelivered($conn)
          {
            try {
              // Query to count the number of unique suppliers
              $query = "SELECT COUNT(DISTINCT Transaction_ID) AS DeliveredCount FROM transaction_history WHERE Order_Status = 'Completed'";
              $statement = $conn->prepare($query);
              $statement->execute();

              // Fetch the count
              $row = $statement->fetch(PDO::FETCH_ASSOC);
              $deliveredCount = $row['DeliveredCount'];

              return $deliveredCount;
            } catch (PDOException $e) {
              echo "Connection failed: " . $e->getMessage();
            }
          }

          // Call the countSuppliers function to get the count
          $db = Database::getInstance();
          $conn = $db->connect();
          $deliveredCount = countDelivered($conn);
          ?>
          <div class="flex flex-col pl-3 border-2 border-gray-400 rounded-md w-80 h-40 justify-center">
            <a class="text-3xl">
              <?php echo $deliveredCount; ?> Order/s
            </a>
            <a class="text-lg">Total Delivered</a>
          </div>
          <?php
          // Include your database connection file
          require_once 'dbconn.php';

          // Function to count the number of unique suppliers
          function countOrders($conn)
          {
            try {
              // Query to count the number of ordered items
              $query = "SELECT COUNT(DISTINCT Order_ID) AS OrderCount FROM order_details WHERE Order_Status = 'to receive'";
              $statement = $conn->prepare($query);
              $statement->execute();
              
              // Fetch the count
              $row = $statement->fetch(PDO::FETCH_ASSOC);
              $orderCount = $row['OrderCount'];

              return $orderCount;
            } catch (PDOException $e) {
              echo "Connection failed: " . $e->getMessage();
            }
          }

          // Call the countSuppliers function to get the count
          $db = Database::getInstance();
          $conn = $db->connect();
          $orderCount = countOrders($conn);
          ?>
          <div class="flex flex-col pl-3 border-2 border-gray-400 rounded-md w-80 h-40 justify-center">
            <a class="text-3xl">
              <?php echo $orderCount; ?> Order/s
            </a>
            <a class="text-lg">To Receive</a>
          </div>
          
        </div>
        <a class="text-3xl ml-5">Order/s To Receive</a>
        <!-- table -->
        <div class="overflow-hidden rounded-lg border border-gray-300 shadow-md m-5">
          <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
            <thead class="bg-gray-200">
              <tr class="border-b border-y-gray-300">
                <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                  Order ID
                </th>
                <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                  Supplier Name
                </th>
                <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                  Date Order
                </th>
                <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                  Time
                </th>
                <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                  Actions
                </th>
                <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
              </tr>
            </thead>
            <?php
 function displayPendingOrders()
 {
     try {
         require_once 'dbconn.php'; // Include your database connection file
         $conn = Database::getInstance()->connect(); // Assuming this is how you establish a database connection
 
         // Query to retrieve order IDs with status "pending"
         $query = "SELECT od.Order_ID, od.Supplier_ID, s.Supplier_Name, od.Date_Ordered, od.Time_Ordered
                             FROM order_details od
                             JOIN suppliers s ON od.Supplier_ID = s.Supplier_ID
                             WHERE od.Order_Status = 'to receive'
                             GROUP BY od.Order_ID"; // Group by Order_ID to show each unique order
 
         $statement = $conn->prepare($query);
         $statement->execute();
 
         // Fetch all rows as associative array
         $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
 
         // Loop through each row and display data in HTML table format
         foreach ($rows as $row) {
             echo '<tbody class="divide-y divide-gray-100 border-b border-gray-300">';
             echo '<tr class="hover:bg-gray-50">';
             echo '<th class="px-6 py-4 font-normal text-gray-900">';
             echo '<div class="font-medium text-gray-700 text-sm">' . $row['Order_ID'] . '</div>';
             echo '</th>';
             echo '<td class="px-6 py-4">';
             echo '<div class="font-medium text-gray-700 text-sm">' . $row['Supplier_Name'] . '</div>'; // Display supplier name
             echo '</td>';
             echo '<td class="px-6 py-4">';
             echo '<div class="font-medium text-gray-700 text-sm">' . $row['Date_Ordered'] . '</div>';
             echo '</td>';
             echo '<td class="px-6 py-4">';
             echo '<div class="font-medium text-gray-700 text-sm">' . $row['Time_Ordered'] . '</div>';
             echo '</td>';
             echo '<td class="px-6 py-4">';
             // Form for Completed status
             echo '<form action="/master/complete/orderDetail" method="POST" enctype="multipart/form-data">';
             echo '<input type="hidden" name="Order_ID" value="' . $row['Order_ID'] . '">';
             echo '<button type="submit" class="rounded-lg border border-gray-400 border-b block px-3 py-1 bg-gray-300 text-sm text-black focus:bg-white focus:text-gray-700 focus:outline-none">Complete</button>';
             echo '</form>';
             
             // Form for Cancel status
             echo '<form action="/master/cancel/orderDetail" method="POST" enctype="multipart/form-data">';
             echo '<input type="hidden" name="Order_ID" value="' . $row['Order_ID'] . '">';
             echo '<button type="submit" class="rounded-lg border border-gray-400 border-b block px-3 py-1 bg-gray-300 text-sm text-black focus:bg-white focus:text-gray-700 focus:outline-none">Cancel</button>';
             echo '</form>';
             echo '</td>';
             echo '<td class="px-6 py-4">';
             echo '<div class="font-medium text-gray-700 text-sm">View</div>';
             echo '</td>';
             echo '</tr>';
             echo '</tbody>';
         }
     } catch (PDOException $e) {
         echo "Connection failed: " . $e->getMessage();
     }
 }
 
 // Call the function to display pending orders
 displayPendingOrders();
 ?>
          </table>
        </div>
      </div>
    </div>
  </div>
  <script src="./../src/route.js"></script>
<script src="./../src/form.js"></script>
</body>

</html>