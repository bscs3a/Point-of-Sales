<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Request Order</title>
  <link href="./../src/tailwind.css" rel="stylesheet">
</head>

<body>
  <div class="flex h-screen bg-gray-100">
    <!-- sidebar -->
    <?php include "components/po.sidebar.php" ?>

    <!-- Navbar -->
    <div class="flex flex-col flex-1 overflow-y-auto">
      <!-- Header -->
      <div class="flex items-center justify-between h-16 bg-zinc-200 border-b border-gray-200">
        <div class="flex items-center px-4">
          <button class="text-gray-500 focus:outline-none focus:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
          <h1 class="text-2xl font-semibold px-5">Product Order / Request Order</h1>
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

      <!-- table -->
      <div class="overflow-auto rounded-lg border border-gray-300 shadow-md m-5">
        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
          <thead class="bg-gray-200">
            <tr class="border-b border-y-gray-300">
              <th scope="col" class="px-6 py-4 font-medium text-gray-900">Product ID</th>
              <th scope="col" class="px-6 py-4 font-medium text-gray-900">Product Name</th>
              <th scope="col" class="px-6 py-4 font-medium text-gray-900">Supplier Name</th>
              <th scope="col" class="px-6 py-4 font-medium text-gray-900">Category</th>
              <th scope="col" class="px-6 py-4 font-medium text-gray-900">Price</th>
              <th scope="col" class="px-6 py-4 font-medium text-gray-900">Quantity</th>
              <th scope="col" class="px-6 py-4 font-medium text-gray-900">Total</th>
              <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
            </tr>
          </thead>

          <tbody class="divide-y divide-gray-100 border-b border-gray-300">

            <?php
            try {
              require_once 'dbconn.php';
              // Query to retrieve all requests
              $query = "SELECT * FROM requests WHERE request_Status = 'pending'";
              $statement = $conn->prepare($query);
              $statement->execute();

              while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $requestID = $row['Request_ID'];
                $productID = $row['Product_ID']; // Assuming Product_ID is the correct column
                $productDetails = getProductDetails($productID, $conn);
                // Displaying the fetched data
                echo '<tr class="hover:bg-gray-50">';
                echo '<td class="px-6 py-10">' . $productID . '</td>';
                echo '<td class="flex gap-3 px-6 py-10 font-normal text-gray-900">';
                echo '<div class="font-medium text-gray-700 text-sm flex items-center">';
                echo '<img src="../' . $productDetails['ProductImage'] . '" alt="Product Image" class="w-8 h-8 mr-2">';
                echo '<a>' . $productDetails['ProductName'] . '</a>';
                echo '</div>';
                echo '</td>';
                echo '<td class="px-6 py-10">' . $productDetails['Supplier'] . '</td>';
                echo '<td class="px-6 py-10">' . $productDetails['Category'] . '</td>';
                echo '<td class="px-6 py-10">' . $productDetails['Price'] . '</td>';
                echo '<td class="px-6 py-10">' . $row["Product_Quantity"] . '</td>';
                echo '<td class="px-6 py-10">' . $row["Product_Total_Price"] . '</td>';
                echo '<td class="px-6 py-10">';
                echo '<form action="/master/delete/requestOrder" method="POST" enctype="multipart/form-data">';
                echo '<input type="hidden" name="requestID" value="' . $requestID . '">';
                echo '<input type="submit" value="Delete"class="px-4 py-2 border border-red-600 text-red-600 rounded-md font-semibold tracking-wide cursor-pointer">';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
              }
            } catch (PDOException $e) {
              echo "Connection failed: " . $e->getMessage();
            }

            ?>
          </tbody>
          <?php
          try {
            // Query to retrieve all requests and calculate total quantity and total price
            $query = "SELECT SUM(Product_Quantity) AS total_quantity, SUM(Product_Total_Price) AS total_price FROM requests WHERE request_Status = 'pending'";
            $statement = $conn->prepare($query);
            $statement->execute();
            $totals = $statement->fetch(PDO::FETCH_ASSOC);

            // Display total quantity and total price
            $totalQuantity = $totals['total_quantity'];
            $totalPrice = $totals['total_price'];

            echo '<tfoot class="bg-gray-200">';
            echo '<tr class="border-b border-y-gray-300">';
            echo '<th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>';
            echo '<th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>';
            echo '<th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>';
            echo '<th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>';
            echo '<th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>';
            echo '<th scope="col" class="px-6 py-4 font-medium text-gray-900">Items Subtotal: ' . $totalQuantity . '</th>';
            echo '<th scope="col" class="px-6 py-4 font-medium text-gray-900">Total Amount: Php ' . $totalPrice . '</th>';
            echo '<th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>';
            echo '</tr>';
            echo '</tfoot>';
          } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
          }
          ?>
        </table>
      </div>
      <!-- View All Button -->
      <div class="flex justify-end border-none">

        <form action="/master/update/requestOrder" method="POST" enctype="multipart/form-data">
          <button type="submit" class="mr-5 py-3 px-4 border-2 border-black text-sm rounded-md bg-[#FFC955]"
            name="order_now">
            Order now
          </button>
        </form>
      </div>
    </div>
  </div>
  <script src="./../src/route.js"></script>
  <script src="./../src/form.js"></script>
</body>



</html>