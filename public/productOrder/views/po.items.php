<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Items</title>

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
          <div class="flex items-center justify-between h-20 bg-white shadow-md px-4 py-2">
            <div class="flex items-center gap-4">
              <button id="toggleSidebar" class="text-gray-900 focus:outline-none focus:text-gray-700">
                <i class="ri-menu-line"></i>
              </button>
              <label class="text-black font-medium">Product List</label>
              
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
        <!-- new layout of table -->
        <div class="px-10 py-4">
            <div class="justify-between items-start">
                <!-- Button -->
                <div class="flex justify-between">
                    <div class="items-start">
                        <div class="relative">
                            <div class="inline-flex items-center overflow-hidden rounded-lg border border-gray-500">
                                <!-- bg-gray-200 hover:bg-gray-300 text-gray-900 font-medium text-sm  -->
                                <button
                                    class="border-e px-4 py-2 text-sm/none bg-gray-200 hover:bg-gray-300 text-gray-900 border-gray-500">
                                    <i class="ri-calendar-2-fill"></i>
                                    Filter
                                </button>
                                
                                <div class="relative">
                                    <label for="Search" class="sr-only"> Search </label>

                                    <input type="text" id="Search" placeholder="Search by ID..."
                                        class="w-full rounded-md rounded-l-md p-1 border-gray-200 pe-10 shadow-sm sm:text-sm outline-none pl-4" />

                                    <span class="absolute inset-y-0 end-0 grid w-10 place-content-center">
                                        <button type="button" class="text-gray-600 hover:text-gray-700">
                                            <span class="sr-only">Search</span>

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                            </svg>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex place-content-end mt-2 m-3">
                      <button route='/po/addItem' class="items-end rounded-full px-2 py-1 bg-violet-950 text-white">
                      <i class="ri-add-circle-line"></i>
                      <span>Add Product</span> 
                      </button>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto rounded-lg border border-gray-400">
                <table class="min-w-full text-left mx-auto bg-white">
                    <thead class="bg-gray-200 border-b border-gray-400 text-sm">
                        <tr>
                            <th class="px-4 py-2 font-semibold">Product</th>
                            <th class="px-4 py-2 font-semibold">Product ID</th>
                            <th class="px-4 py-2 font-semibold">Supplier</th>
                            <th class="px-4 py-2 font-semibold">Category</th>
                            <th class="px-4 py-2 font-semibold">Weight</th>
                            <th class="px-4 py-2 font-semibold">Price</th>
                            <th class="px-4 py-2 font-semibold">Description</th>
                            <th class="px-4 py-2 font-semibold"></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td class="px-4 py-4 flex items-center justify-center">
                            <img src="https://via.placeholder.com/150" alt="Product Image" class="w-20 h-20 object-cover mr-4">
                                <div>Product Name</div>
                            </td>
                            <td class="px-4 py-4">12</td>
                            <td class="px-4 py-4">marc</td>
                            <td class="px-4 py-4">
                              <select class="rounded-lg border border-gray-400 border-b block px-3 py-1 bg-gray-300 text-sm placeholder-gray-400 text-black focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none">
                                <option value="id">handtool</option>
                                <option value="name">option</option>
                                <option value="name">option</option>
                              </select>
                            </td>
                            <td class="px-4 py-4">150 kg</td>
                            <td class="px-4 py-4">Php 150.00</td>
                            <td class="px-4 py-4">ssgdffh</td>
                            <td class="px-4 py-4">edit</td>
                        </tr>    
                    </tbody>
                </table>
            </div>
        </div>
     

      <div class="p-4">
        <!-- table -->
        <?php
        try {
          require_once 'dbconn.php';
          // Query to retrieve all products
          $query = "SELECT * FROM products";
          $statement = $conn->prepare($query);
          $statement->execute();
          // Check if there are any rows or results
          if ($statement->rowCount() > 0) {
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
              // Debugging statement to print image path
              $imagePath = '../' . $row['ProductImage'];

              echo '<div class="overflow-hidden rounded-lg border border-gray-300 shadow-md m-5">';
              echo '<table class="w-full border-collapse bg-white text-left text-sm text-gray-500">';
              echo '<thead class="bg-gray-200">';
              echo '<tr class="border-b border-y-gray-300">';
              echo '<th scope="col" class="px-6 py-4 font-medium text-gray-900">';
              echo 'Product Image'; // Add a heading for the image
              echo '</th>';
              echo '<th scope="col" class="px-6 py-4 font-medium text-gray-900">';
              echo 'Product ID';
              echo '</th>';
              echo '<th scope="col" class="px-6 py-4 font-medium text-gray-900">';
              echo 'Product Name';
              echo '</th>';
              echo '<th scope="col" class="px-6 py-4 font-medium text-gray-900">';
              echo 'Supplier';
              echo '</th>';
              echo '<th scope="col" class="px-6 py-4 font-medium text-gray-900">';
              echo 'Category';
              echo '</th>';
              echo '<th scope="col" class="px-6 py-4 font-medium text-gray-900">';
              echo 'Quality';
              echo '</th>';
              echo '<th scope="col" class="px-6 py-4 font-medium text-gray-900">';
              echo 'Price';
              echo '</th>';
              echo '<th scope="col" class="px-6 py-4 font-medium text-gray-900">';
              echo 'Description';
              echo '</th>';
              echo '<th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>';
              echo '</tr>';
              echo '</thead>';
              echo '<tbody class="divide-y divide-gray-100 border-b border-gray-300">';
              echo '<tr class="hover:bg-gray-50 data-row" data-id="' . $row['ProductID'] . '" data-name="' . $row['ProductName'] . '" data-supplier="' . $row['Supplier'] . '" data-category="' . $row['Category'] . '" data-quality="5 stars..." data-price="' . $row['Price'] . '" data-description="' . $row['Description'] . '">';
              echo '<td class="flex gap-3 px-6 py-4 font-normal text-gray-900">';
              echo '<div class="flex flex-col font-medium text-gray-700 text-sm">';
              echo '<img src="' . $imagePath . '" alt="" width="80" height="80">';
              echo '</div>';
              echo '</td>';
              echo '<td class="px-6 py-4">';
              echo '<div class="font-medium text-gray-700 text-sm">' . $row['ProductID'] . '</div>';
              echo '</td>';
              echo '<td class="px-6 py-4">';
              echo '<div class="font-medium text-gray-700 text-sm">' . $row['ProductName'] . '</div>';
              echo '</td>';
              echo '<td class="px-6 py-4">';
              echo '<div class="font-medium text-gray-700 text-sm">' . $row['Supplier'] . '</div>';
              echo '</td>';
              echo '<td class="px-6 py-4">';
              echo '<div class="font-medium text-gray-700 text-sm">' . $row['Category'] . '</div>';
              echo '</td>';
              echo '<td class="px-6 py-4">';
              echo '<div class="font-medium text-gray-700 text-sm">No rating yet</div>';
              echo '</td>';
              echo '<td class="px-6 py-4">';
              echo '<div class="font-medium text-gray-700 text-sm">' . $row['Price'] . '</div>';
              echo '</td>';
              echo '<td class="px-6 py-4">';
              echo '<div class="font-medium text-gray-700 text-sm">' . $row['Description'] . '</div>';
              echo '</td>';
              echo '<td class="px-6 py-4">';
              echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">';
              echo '<path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />';
              echo '</svg>';
              echo '</td>';
              echo '</tr>';
              echo '</tbody>';
              echo '</table>';
              echo '</div>';
            }
          } else {
            echo "No products found.";
          }
        } catch (PDOException $e) {
          echo "Connection failed: " . $e->getMessage();
        }
        // Close the database connection
        $conn = null;
        ?>
        <!-- //end -->
      </div>

    </div>
  </div>

  <script>
    // Filter and search functionality
    function filterAndSearch() {
      var filterValue = document.getElementById("filterSelect").value.toLowerCase();
      var searchValue = document.getElementById("searchInput").value.toLowerCase();
      var rows = document.querySelectorAll(".data-row");

      rows.forEach(row => {
        var display = "none";

        switch (filterValue) {
          case "id":
            display = row.dataset.id.toLowerCase().includes(searchValue) ? "" : "none";
            break;
          case "name":
            display = row.dataset.name.toLowerCase().includes(searchValue) ? "" : "none";
            break;
          case "supplier":
            display = row.dataset.supplier.toLowerCase().includes(searchValue) ? "" : "none";
            break;
          case "category":
            display = row.dataset.category.toLowerCase().includes(searchValue) ? "" : "none";
            break;
          case "quality":
            display = row.dataset.quality.toLowerCase().includes(searchValue) ? "" : "none";
            break;
          case "price":
            display = row.dataset.price.toLowerCase().includes(searchValue) ? "" : "none";
            break;
          case "description":
            display = row.dataset.description.toLowerCase().includes(searchValue) ? "" : "none";
            break;
          default:
            display = "";
        }

        row.style.display = display;
      });
    }

    // Event listeners for filter and search
    document.getElementById("filterSelect").addEventListener("change", filterAndSearch);
    document.getElementById("searchInput").addEventListener("input", filterAndSearch);
  </script>
</body>
<script src="./../src/route.js"></script>
<script src="./../src/form.js"></script>

</html>