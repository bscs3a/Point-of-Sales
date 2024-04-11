<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Suppliers</title>

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
      <div class="flex items-center justify-between h-16 bg-white shadow-md px-4 py-1">
        <div class="flex items-center gap-4">
          <button id="toggleSidebar" class="text-gray-500 focus:outline-none focus:text-gray-700">
            <i class="ri-menu-line"></i>
          </button>
          <label class="text-black font-medium">Suppliers</label>
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

          <div x-show="dropdownOpen"
            class="absolute right-0 mt-2 py-2 w-40 bg-white border border-gray-200 rounded-md shadow-lg z-20">
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

      <!-- Main Content -->
      <div class="py-4 px-10">
        <div class="justify-between items-start mt-4">
          <!-- Button -->
          <div class="flex justify-between">
            <div class="items-start">
              <div class="relative">
                <div class="inline-flex items-center overflow-hidden rounded-lg border border-gray-500">
                  <div class="flex flex-row">
                    <select id="filterSelect"
                      class="border-e px-4 py-2 text-sm/none bg-gray-200 hover:bg-gray-300 text-gray-900 border-gray-500">
                      <option value="">Filter</option>
                      <option value="id">ID</option>
                      <option value="name">Name</option>
                      <option value="supplier">Supplier</option>
                    </select>
                    <input id="searchInput" placeholder="Search"
                      class="w-full rounded-md rounded-l-md p-1 border-gray-200 pe-10-0 shadow-sm sm:text-sm outline-none pl-4" />
                  </div>
                </div>
              </div>
            </div>


            <div class="flex place-content-end mt-2 m-3">
              <button route='/po/addsupplier' class="items-end rounded-full px-2 py-1 bg-violet-950 text-white">
                <i class="ri-add-circle-line"></i>
                <span>Add Supplier</span>
              </button>
            </div>
          </div>
        </div>

        <!-- Sample cards for ranking -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 pb-4">
          <!-- Card 1 -->
          <div class="bg-white border border-gray-300 rounded-lg drop-shadow-lg p-8">
            <div class="flex flex-col gap-2 ">
              <a class="text-2xl font-semibold">No Rank Yet</a>
              <div class="flex flex-row">
                <a>Supplier Name:</a>
                <a class="ml-3 text-gray-500"></a>
              </div>
              <div class="flex flex-row">
                <a>Status:</a>
                <a class="ml-3 text-green-600">Active</a>
              </div>
            </div>
            <div class="flex justify-center items-center pt-3">
              <button route='/po/viewsupplier' class="bg-violet-950 my-3 px-4 py-1 rounded-md text-white font-semibold tracking-wide cursor-pointer">View</button>
            </div>
          </div>

          <?php
          try {
            require_once 'dbconn.php';
            // Query to retrieve all products
            $query = "SELECT * FROM suppliers";
            $statement = $conn->prepare($query);
            $statement->execute();
            // Check if there are any rows or results
            if ($statement->rowCount() > 0) {
              while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                // Debugging statement to print image path
                echo '<tr>';
                echo '<tr class="hover:bg-gray-50 data-row" data-supplier="' . $row['Supplier_Name'] . '">';
                echo '<div class="bg-white border border-gray-300 rounded-lg drop-shadow-lg p-8">';
                echo '<div class="flex flex-col gap-2 ">';
                echo '<a class="text-2xl font-semibold">No Rank Yet</a>';
                echo '<div class="flex flex-row">';
                echo '<a>Supplier Name:</a>';
                echo '<a class="ml-3 text-gray-500">' . $row['Supplier_Name'] . '</a>';
                echo '</div>';
                echo '<div class="flex flex-row">';
                echo '<a>Status:</a>';
                echo '<a class="ml-3 text-green-600">Active</a>';
                echo '</div>';
                echo '</div>';
                echo '<div class="flex justify-center items-center pt-3">';
                echo '<button href="/po/viewsupplier" class="bg-violet-950 my-3 px-4 py-1 rounded-md text-white font-semibold tracking-wide cursor-pointer">View</button>';
                echo '</div>';
                echo '</div>';
                echo '</tr>';
                
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

          <!-- Cards -->
        
          <!-- //end -->


        </div>
      </div>

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
          case "supplier":
            display = row.dataset.supplier.toLowerCase().includes(searchValue) ? "" : "none";
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