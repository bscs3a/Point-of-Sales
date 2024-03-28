<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Request History</title>
  <link href="./../src/tailwind.css" rel="stylesheet" />
</head>
<body>
  <div class="flex h-screen bg-gray-100">
    <!-- sidebar -->
    <?php include "components/po.sidebar.php" ?>
    
    <!-- Navbar -->
    <div class="flex flex-col flex-1 overflow-y-auto">
      <!-- Header -->
      <div
        class="flex items-center justify-between h-16 bg-zinc-200 border-b border-gray-200">
        <div class="flex items-center px-4">
          <button
            class="text-gray-500 focus:outline-none focus:text-gray-700">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-6 w-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
          <h1 class="text-2xl font-semibold px-5">Product Order / Request History</h1>
        </div>

        <div class="flex items-center pr-4 text-xl font-semibold">
          Sample User

          <span class="p-3">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              class="w-6 h-6">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="m19.5 8.25-7.5 7.5-7.5-7.5" />
            </svg>
          </span>
        </div>
      </div>

      <!-- Main Content -->
      <div class="p-4">
        <div class="m-5 flex justify-between items-center">
          <div class="flex flex-row">
            <input id="searchInput" placeholder="Search by Date"
              class="appearance-none rounded-l-lg border border-gray-400 border-b block pl-8 pr-6 py-2 bg-gray-300 text-sm placeholder-gray-400 text-black focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
            <button id="searchButton" class="border border-gray-400 border-b px-6 py-2 bg-gray-300 text-sm text-black focus:bg-white focus:text-gray-700 focus:outline-none">
              Search
            </button>
          </div>
          <div class="lg:ml-40 ml-10 space-x-8">
            <!-- Add any other buttons or elements here -->
          </div>
        </div>
        
      <nav class="mx-5">
        <ul class="flex items-center justify-between -space-x-px h-8 text-sm">
          <li>
            <a href="#" class="flex items-center justify-center px-3 h-8 font-bold text-lg text-gray-500 dark:text-gray-400"><</a>
          </li>
          <li>
            <a href="#" class="flex items-center justify-center px-3 h-8 font-bold text-2xl text-gray-500 dark:text-gray-400">March 2024</a>
          </li>
          <li>
            <a href="#" class="flex items-center justify-center px-3 h-8 font-bold text-lg text-gray-500 dark:text-gray-400">></a>
          </li>
        </ul>
      </nav>

      <!-- Table -->
      <div
        class="overflow-auto rounded-lg border border-gray-300 shadow-md m-5">
        <table
          class="w-full border-collapse bg-white text-left text-sm text-gray-500">
          <thead class="bg-gray-200">
            <tr class="border-b border-y-gray-300">
              <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                Product
              </th>
              <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                Request ID
              </th>
              <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                Date
              </th>
              <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                Price
              </th>
              <th scope="col" class="px-6 py-4 font-medium text-center text-gray-900">
                Quantity
              </th>
              <th scope="col" class="px-6 py-4 font-medium text-center text-gray-900">
                Total
              </th>
            </tr>
          </thead>

          <?php
        // Function to display request data
function displayRequestData()
{
    try {
        $conn = Database::getInstance()->connect(); 

        // Query to retrieve request data
        $query = "SELECT * FROM requests WHERE request_Status = 'accepted'";
        $statement = $conn->prepare($query);
        $statement->execute();
        $requests = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Loop through each request and display data in HTML table format
        foreach ($requests as $request) {
            echo '<tbody class="divide-y divide-gray-100 border-b border-gray-300">';
                      echo '<tr class="hover:bg-gray-100">';
                      echo '<th class="flex gap-3 px-6 py-7 font-normal text-gray-900">';
                      echo '<div class="flex flex-col font-medium text-gray-700 text-sm">';

                      // Fetch and display Product Name from the 'products' table
                      $productQuery = "SELECT ProductName FROM products WHERE ProductID = :productID";
                      $productStatement = $conn->prepare($productQuery);
                      $productStatement->bindParam(':productID', $request['Product_ID']);
                      $productStatement->execute();
                      $product = $productStatement->fetch(PDO::FETCH_ASSOC);
                      echo '<div class="font-medium text-gray-700 text-sm">' . $product['ProductName'] . '</div>';

                      echo '</div>';
                      echo '</th>';
                      echo '<td class="px-6 py-7">';
                      echo '<div class="font-medium text-gray-700 text-sm">' . $request['Request_ID'] . '</div>';
                      echo '</td>';
                      echo '<td class="px-6 py-7">';
                      
                      // Fetch and display Date from the 'order_details' table using 'Order_ID' from requests table
                      $dateQuery = "SELECT Date_Ordered FROM order_details WHERE Order_ID = :orderID";
                      $dateStatement = $conn->prepare($dateQuery);
                      $dateStatement->bindParam(':orderID', $request['Request_ID']); // Assuming 'Request_ID' in the requests table corresponds to 'Order_ID' in the order_details table
                      $dateStatement->execute();
                      $date = $dateStatement->fetch(PDO::FETCH_ASSOC);
                      echo '<div class="font-medium text-gray-700 text-sm">' . $date['Date_Ordered'] . '</div>';
                      
                      echo '</td>';
                      echo '<td class="px-6 py-7">';
                      
                      // Fetch and display Price from the 'products' table
                      $priceQuery = "SELECT Price FROM products WHERE ProductID = :productID";
                      $priceStatement = $conn->prepare($priceQuery);
                      $priceStatement->bindParam(':productID', $request['Product_ID']);
                      $priceStatement->execute();
                      $price = $priceStatement->fetch(PDO::FETCH_ASSOC);
                      echo '<div class="font-medium text-gray-700 text-sm">' . $price['Price'] . '</div>';
                      
                      echo '</td>';
                      echo '<td class="px-6 py-7">';
                      echo '<div class="font-medium text-gray-700 text-center">' . $request['Product_Quantity'] . '</div>';
                      echo '</td>';
                      echo '<td class="px-6 py-7">';
                      echo '<div class="font-medium text-gray-700 text-center">' . $request['Product_Total_Price'] . '</div>';
                      echo '</td>';
                      echo '</tr>';
                      echo '</tbody>';
                    }
                    // Call the function to display total items and amount
              } catch (PDOException $e) {
                  echo "Connection failed: " . $e->getMessage();
              }
          }

          // Call the function to display request data
          displayRequestData();
          ?>

          <tfoot class="bg-gray-200">
            <tr class="border-b border-y-gray-300">
              <th scope="col" class="px-6 py-4 font-medium text-gray-900">
              </th>
              <th scope="col" class="px-6 py-4 font-medium text-gray-900">
              </th>
              <th scope="col" class="px-6 py-4 font-medium text-gray-900">
              </th>
              <th scope="col" class="px-6 py-4 font-medium text-gray-900">
              </th>
              <th scope="col" class="px-6 py-4 font-medium text-gray-900">
              </th>
              <th scope="col" class="px-6 py-4 ml-3 font-medium text-gray-900">
                <div class="flex flex-col font-medium text-gray-700 gap-3">
                <?php
// Function to get the total count of items and the total amount of the accepted request
function getTotalItemsAndAmount($searchDate = null)
{
    try {
        $db = Database::getInstance();
        $conn = $db->connect();

        // Check if $conn is defined and not null
        if (!isset($conn) || $conn === null) {
            throw new Exception("Database connection is not established.");
        }

        // Construct the query to get the total count of items
        $itemCountQuery = "SELECT COALESCE(SUM(r.Product_Quantity), 0) AS totalItems 
                           FROM requests r
                           INNER JOIN order_details od ON r.Request_ID = od.Order_ID
                           WHERE r.request_Status = 'accepted'";
        
        // If a search date is provided, modify the query to filter by that date
        if ($searchDate) {
            $itemCountQuery .= " AND DATE(od.Date_Ordered) = :searchDate";
        }
        
        $itemCountStatement = $conn->prepare($itemCountQuery);
        
        // If a search date is provided, bind the parameter to the query
        if ($searchDate) {
            $itemCountStatement->bindParam(':searchDate', $searchDate);
        }
        
        $itemCountStatement->execute();
        $itemCountResult = $itemCountStatement->fetch(PDO::FETCH_ASSOC);

        // Query to get the total amount
        $totalAmountQuery = "SELECT COALESCE(SUM(r.Product_Total_Price), 0) AS totalAmount 
                             FROM requests r
                             INNER JOIN order_details od ON r.Request_ID = od.Order_ID";
        
        // If a search date is provided, modify the query to filter by that date
        if ($searchDate) {
            $totalAmountQuery .= " WHERE DATE(od.Date_Ordered) = :searchDate";
        }
        
        $totalAmountStatement = $conn->prepare($totalAmountQuery);
        
        // If a search date is provided, bind the parameter to the query
        if ($searchDate) {
            $totalAmountStatement->bindParam(':searchDate', $searchDate);
        }
        
        $totalAmountStatement->execute();
        $totalAmountResult = $totalAmountStatement->fetch(PDO::FETCH_ASSOC);

        // Display the total count of items
        echo '<a>Items Subtotal: ' . $itemCountResult['totalItems'] . '</a>';

        // Display the total amount
        echo '<a>Total Amount: Php ' . $totalAmountResult['totalAmount'] . '</a>';

    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Example usage:
// If you want to display totals for today's date, pass the date as 'YYYY-MM-DD' format
// $searchDate = date('Y-m-d');
getTotalItemsAndAmount(); // Call the function without providing a search date
?>

                </div>
              </th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>

  <script>
    // Search functionality
    document.getElementById("searchButton").addEventListener("click", function() {
      var searchValue = document.getElementById("searchInput").value.toLowerCase();
      var rows = document.querySelectorAll("tbody");

      rows.forEach(row => {
        var dateCell = row.querySelector("td:nth-child(3)");
        if (dateCell) {
          var dateText = dateCell.textContent.toLowerCase();
          if (dateText.includes(searchValue)) {
            row.style.display = "";
          } else {
            row.style.display = "none";
          }
        }
      });
    });
  </script>

  <script src="./../src/route.js"></script>
  <script src="./../src/form.js"></script>
</body>
</html>

