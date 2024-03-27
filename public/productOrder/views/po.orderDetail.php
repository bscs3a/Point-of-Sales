<!DOCTYPE html>
<html lang="en">

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
              $query = "SELECT COUNT(DISTINCT Supplier_ID) AS DeliveredCount FROM order_details WHERE Order_Status = 'Complete'";
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
          function countSuppliers($conn)
          {
            try {
              // Query to count the number of unique suppliers
              $query = "SELECT COUNT(DISTINCT Supplier_ID) AS SupplierCount FROM order_details WHERE Order_Status = 'to receive'";
              $statement = $conn->prepare($query);
              $statement->execute();

              // Fetch the count
              $row = $statement->fetch(PDO::FETCH_ASSOC);
              $supplierCount = $row['SupplierCount'];

              return $supplierCount;
            } catch (PDOException $e) {
              echo "Connection failed: " . $e->getMessage();
            }
          }

          // Call the countSuppliers function to get the count
          $db = Database::getInstance();
          $conn = $db->connect();
          $supplierCount = countSuppliers($conn);
          ?>
          <div class="flex flex-col pl-3 border-2 border-gray-400 rounded-md w-80 h-40 justify-center">
            <a class="text-3xl">
              <?php echo $supplierCount; ?> Order/s
            </a>
            <a class="text-lg">To Receive</a>
          </div>
          
        </div>
        <a class="text-3xl ml-5">Order Details</a>
        <!-- table -->
        <div class="overflow-hidden rounded-lg border border-gray-300 shadow-md m-5">
          <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
            <thead class="bg-gray-200">
              <tr class="border-b border-y-gray-300">
                <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                  Supplier ID
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
function displayRequestData()
{
    try {
        require_once 'dbconn.php';
        $conn = Database::getInstance()->connect(); // Assuming this is how you establish a database connection

        // Query to retrieve distinct supplier IDs along with their latest date and time
        $query = "SELECT od.Supplier_ID, s.Supplier_Name, MAX(od.Date_Ordered) AS LatestDate, MAX(od.Time_Ordered) AS LatestTime
                            FROM order_details od
                            JOIN suppliers s ON od.Supplier_ID = s.Supplier_ID
                            WHERE od.Order_Status = 'to receive'
                            GROUP BY od.Supplier_ID";
        $statement = $conn->prepare($query);
        $statement->execute();

        // Fetch all rows as associative array
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Loop through each row and display data in HTML table format
        foreach ($rows as $row) {
            echo '<tbody class="divide-y divide-gray-100 border-b border-gray-300">';
            echo '<tr class="hover:bg-gray-50">';
            echo '<th class="px-6 py-4 font-normal text-gray-900">';
            echo '<div class="font-medium text-gray-700 text-sm">' . $row['Supplier_ID'] . '</div>';
            echo '</th>';
            echo '<td class="px-6 py-4">';
            echo '<div class="font-medium text-gray-700 text-sm">' . $row['Supplier_Name'] . '</div>'; // Display supplier name
            echo '</td>';
            echo '<td class="px-6 py-4">';
            echo '<div class="font-medium text-gray-700 text-sm">' . $row['LatestDate'] . '</div>';
            echo '</td>';
            echo '<td class="px-6 py-4">';
            echo '<div class="font-medium text-gray-700 text-sm">' . $row['LatestTime'] . '</div>';
            echo '</td>';
            echo '<td class="px-6 py-4">';
            // Form for Completed status
            echo '<form action="/master/complete/orderDetail" method="POST" enctype="multipart/form-data">';
            echo '<input type="hidden" name="Supplier_ID" value="' . $row['Supplier_ID'] . '">';
            echo '<input type="hidden" name="status" value="Completed">';
            echo '<button type="submit" class="rounded-lg border border-gray-400 border-b block px-3 py-1 bg-gray-300 text-sm text-black focus:bg-white focus:text-gray-700 focus:outline-none">Complete</button>';
            echo '</form>';
            
            // Form for Cancel status
            echo '<form action="/master/cancel/orderDetail" method="POST" enctype="multipart/form-data">';
            echo '<input type="hidden" name="Supplier_ID" value="' . $row['Supplier_ID'] . '">';
            echo '<input type="hidden" name="status" value="Cancel">';
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

// Call the function to display request data
displayRequestData();
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