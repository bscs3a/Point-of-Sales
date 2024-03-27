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

        <!-- Calender Button -->
        <div class="m-5 flex justify-between items-center">
          <div class="flex flex-col">
              <button class="border border-gray-400 border-b px-6 py-2 bg-gray-300 text-sm placeholder-gray-400 text-black focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none">
                Sort by Date
              </button>
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

        <!-- table -->
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
function displayRequestData()
{
    try {
        require_once 'dbconn.php';
        $conn = Database::getInstance()->connect(); 

        // Query to retrieve request data
        $query = "SELECT * FROM requests WHERE request_Status = 'accepted'"; //query to show in the requestHistory the data that was accepted
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
function getTotalItemsAndAmount()
{
    try {
      $db = Database::getInstance();
      $conn = $db->connect();

        // Check if $conn is defined and not null
        if (!isset($conn) || $conn === null) {
            throw new Exception("Database connection is not established.");
        }

        // Query to get the total count of items
        $itemCountQuery = "SELECT COUNT(*) AS totalItems FROM requests WHERE request_Status = 'accepted'"; 
        $itemCountStatement = $conn->prepare($itemCountQuery);
        $itemCountStatement->execute();
        $itemCountResult = $itemCountStatement->fetch(PDO::FETCH_ASSOC);

        // Query to get the total amount
        $totalAmountQuery = "SELECT SUM(Product_Total_Price) AS totalAmount FROM requests"; 
        $totalAmountStatement = $conn->prepare($totalAmountQuery);
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

// Call the function to display total items and amount
getTotalItemsAndAmount();
?>
            </div>
        </th>
    </tr>
</tfoot>

          </table>
        </div>

        <!-- View All Button -->
        <div class="flex justify-end border-none">
          <button class="mr-5 py-3 px-4 border-2 border-black text-sm rounded-md bg-[#FFC955]">
            view all
          </button>
        </div>
        
      </div>
    </div>
  </body>
  <script src="./../src/route.js"></script>
  <script src="./../src/form.js"></script>
</html>