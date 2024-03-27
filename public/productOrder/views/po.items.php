
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Items</title>
  <link href="./../src/tailwind.css" rel="stylesheet" />
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
          <h1 class="text-2xl font-semibold px-5">Product Order / Items</h1>
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
      <div class="p-4">
        <div class="m-5 flex justify-between items-center">
          <div class="flex flex-row">
            <select id="filterSelect"
              class="appearance-none rounded-l-lg border border-gray-400 border-b block pl-8 pr-6 py-2 bg-gray-300 text-sm placeholder-gray-400 text-black focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none">
              <option value="">Filter</option>
              <option value="id">ID</option>
              <option value="name">Name</option>
              <option value="supplier">Supplier</option>
              <option value="category">Category</option>
              <option value="quality">Quality</option>
              <option value="price">Price</option>
              <option value="description">Description</option>
            </select>
            <input id="searchInput" placeholder="Search"
              class="appearance-none rounded-l rounded-lg sm:rounded-l-none border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-gray-300 text-sm placeholder-white text-black focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
          </div>
          <div class="lg:ml-40 ml-10 space-x-8">
            <button
              class="bg-violet-950 px-4 py-2 border border-black text-white rounded-md font-semibold tracking-wide cursor-pointer">
              <a route='/po/addItem'>add item</a>
            </button>
          </div>
        </div>



        <!-- table -->
        <div class="overflow-hidden rounded-lg border border-gray-300 shadow-md m-5">
          <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
            <thead class="bg-gray-200">
              <tr class="border-b border-y-gray-300">
                <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                  Product Image <!-- Add a heading for the image -->
                </th>
                <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                  Product ID
                </th>
                <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                  Product Name
                </th>
                <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                  Supplier
                </th>
                <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                  Category
                </th>
                <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                  Quality
                </th>
                <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                  Price
                </th>
                <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                  Description
                </th>
                <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 border-b border-gray-300">
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
            </tbody>
          </table>
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