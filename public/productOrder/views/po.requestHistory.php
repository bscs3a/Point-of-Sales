<?php
    // Initialize $requests variable to an empty array
    $requests = [];

    // Check if form is submitted and display search results
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['searchDate'])) {
        // Call the function to search requests by date and assign the result to $requests
        $requests = searchByDate();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Request History</title>
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
          <h1 class="text-2xl font-semibold px-5">Product Order / Request History</h1>
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

      <!-- Calender Button -->
      <div class="m-5 flex justify-between items-center">
        <div class="flex flex-col">
          <form action="/search/requestHistory" method="post"> <!-- Removed "date/requestHistory" from action -->
            <input type="date" name="searchDate"
              class="appearance-none rounded-l-lg border border-gray-400 border-b block pl-8 pr-6 py-2 bg-gray-300 text-sm placeholder-gray-400 text-black focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
            <button type="submit"
              class="border border-gray-400 border-b px-6 py-2 bg-gray-300 text-sm text-black focus:bg-white focus:text-gray-700 focus:outline-none">
              Search date
            </button>
          </form>
        </div>
      </div>

      
      <!-- Existing table -->
      <div class="overflow-overflow rounded-lg border border-gray-300 shadow-md m-5">
        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
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
          <tbody class="divide-y divide-gray-100 border-b border-gray-300">
            <?php
            // Check if form is submitted and display search results
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['searchDate'])) {
              $searchedRequests = searchByDate();

              // Loop through the search results and generate table rows dynamically
              foreach ($searchedRequests as $request) {
                ?>
                <tr class="hover:bg-gray-100">
                  <th class="flex gap-3 px-6 py-7 font-normal text-gray-900">
                    <div class="flex flex-col font-medium text-gray-700 text-sm">
                      <a>
                        <?php echo $request['ProductName']; ?>
                      </a>
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
                      <?php echo $request['Product_Total_Price']; ?> <!-- Assuming Total is the same as Price -->
                    </div>
                  </td>
                </tr>
                <?php
              }
            } else {
              // If no search date is specified, fetch and display all data by default
              $requests = fetchAllRequestsData();
              foreach ($requests as $request) {
                ?>
                <tr class="hover:bg-gray-100">
                  <th class="flex gap-3 px-6 py-7 font-normal text-gray-900">
                    <div class="flex flex-col font-medium text-gray-700 text-sm">
                      <a>
                        <?php echo $request['ProductName']; ?>
                      </a>
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
                    <div class="font-medium text-center text-gray-700 text-sm">
                    <?php echo $request['Product_Quantity']; ?>

                    </div>
                  </td>
                  <td class="px-6 py-7">
                    <div class="font-medium text-center text-gray-700 text-sm">
                      <?php echo $request['Product_Total_Price']; ?> <!-- Assuming Total is the same as Price -->
                    </div>
                  </td>
                </tr>
                <?php
              }
            }
            ?>
          </tbody>
          <?php
    // Initialize variables to hold total quantity and total price
    $totalQuantity = 0;
    $totalPrice = 0;

    // Loop through the fetched data and generate table rows dynamically
    foreach ($requests as $request) {
        // Increment total quantity
        $totalQuantity += $request['Product_Quantity'];
        
        // Calculate total price for each item and increment total price
        $totalPrice += $request['Price'] * $request['Product_Quantity'];
        ?>
        <tr class="hover:bg-gray-100">
            <!-- Your existing table row content here -->
        </tr>
    <?php
    }
?>
<!-- Your existing HTML code -->

<!-- Display total quantity and total price in table footer -->
<tfoot class="bg-gray-200">
    <tr class="border-b border-y-gray-300">
        <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
        <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
        <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
        <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
        <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
        <th scope="col" class="px-6 py-4 ml-3 font-medium text-gray-900">
            <div class="flex flex-col font-medium text-gray-700 gap-3">
                <a>Items Subtotal: <?php echo $totalQuantity; ?></a>
                <a>Total Amount: <?php echo $totalPrice; ?></a>
            </div>
        </th>
    </tr>
</tfoot>
        </table>
      </div>
    </div>
  </div>
  <script src="./../src/route.js"></script>
  <script src="./../src/form.js"></script>
</body>

</html>