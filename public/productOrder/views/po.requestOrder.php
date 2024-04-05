<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Request Order</title>

    <link href="./../src/tailwind.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css">

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
  </head>
  <body>
    <div class="flex h-screen bg-white">
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
              <label class="text-black font-medium">Request Order</label>
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

            <!-- new layout of table -->
              <div class="px-10 py-4 mt-4">
                  <!-- Table -->
                  <div class="overflow-x-auto rounded-lg border border-gray-400">
                    <table class="min-w-full text-left mx-auto bg-white">
                        <thead class="bg-gray-200 border-b border-gray-400 text-sm">
                              <tr>
                                  <th class="px-4 py-2 font-semibold">Product ID</th>
                                  <th class="px-4 py-2 font-semibold">Product Name</th>
                                  <th class="px-4 py-2 font-semibold">Supplier</th>
                                  <th class="px-4 py-2 font-semibold">Category</th>
                                  <th class="px-4 py-2 font-semibold">Price</th>
                                  <th class="px-4 py-2 font-semibold">Weight</th>
                                  <th class="px-4 py-2 font-semibold">Total</th>
                                  <th class="px-4 py-2 font-semibold"></th>
                              </tr>
                          </thead>

                          <tbody >
                              <tr>
                                  <td class="px-4 py-10">12</td>
                                  <td class="px-4 py-10">Stanley</td>
                                  <td class="px-4 py-10">marc</td>
                                  <td class="px-4 py-10">
                                    <select class="rounded-lg border border-gray-400 border-b block px-3 py-1 bg-gray-300 text-sm placeholder-gray-400 text-black focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none">
                                      <option value="id">handtool</option>
                                      <option value="name">option</option>
                                      <option value="name">option</option>
                                    </select>
                                  </td>
                                  <td class="px-4 py-10">Php 150.00</td>
                                  <td class="px-4 py-10">15 kg</td>
                                  <td class="px-4 py-10">Php 1000</td>
                                  <td class="px-4 py-10">
                                    <button class="px-4 py-2 border border-red-600 text-red-600 rounded-md font-semibold tracking-wide cursor-pointer">delete</button>
                                  </td>
                              </tr>    
                          </tbody>

                          <tfoot class="text-left bg-gray-200">
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
                              <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                              </th>
                              <th scope="col" class="px-6 py-4 ml-3 font-medium text-gray-900">
                                <div class="flex flex-col font-medium text-gray-700 gap-3">
                                  <a>Items Subtotal: 2</a>
                                  <a>Total Amount: Php 2000</a>
                                </div>
                              </th>
                              <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                              </th>
                            </tr>
                          </tfoot>

                      </table>
                  </div>
              </div>
=======

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
              <th scope="col" class="px-6 py-4 font-medium text-gray-900">Status</th>
              <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
            </tr>
          </thead>

          <tbody class="divide-y divide-gray-100 border-b border-gray-300">

            <?php
            try {
              require_once 'dbconn.php';
              // Query to retrieve all requests
              $query = "SELECT * FROM requests WHERE request_Status = 'pending' OR request_Status = 'Ready to order'";
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
                echo '<td class="px-6 py-10">' . $row["request_Status"] . '</td>';
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
      <form action="/master/accept/requestOrder" method="POST" enctype="multipart/form-data">
          <button type="submit" class="mr-5 py-3 px-4 border-2 border-black text-sm rounded-md bg-[#FFC955]"
            name="order_now">
            Accept Request
          </button>
        </form>

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