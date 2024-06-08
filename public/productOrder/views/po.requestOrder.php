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
        <?php require_once "public/productOrder/views/po.logout.php"?>

      </div>

      <script>
        document.getElementById('toggleSidebar').addEventListener('click', function () {
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
                <th class="px-4 py-2 font-semibold">Quantity</th>
              
                <th class="px-4 py-2 font-semibold"></th>
              </tr>
            </thead>
            <tbody>

            <?php
try {
    require_once 'dbconn.php';

    // Query to retrieve all products
    $query = "SELECT * FROM products";
    $statement = $conn->prepare($query);
    $statement->execute();

    // Displaying the fetched products
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['ProductID'] . "</td>";
        echo "<td>" . $row['ProductName'] . "</td>";
        echo "<td>" . $row['Supplier'] . "</td>";
        echo "<td>" . $row['Category'] . "</td>";
        echo "<td>" . $row['Price'] . "</td>";
        echo '<td>';
        echo '<form action="/request/insert" method="POST">';
        echo '<input type="hidden" name="productID" value="' . $row['ProductID'] . '">';
        echo '<input type="number" name="quantity" value="1" min="1" class="px-2 py-1 border border-gray-400 rounded-md">';
        echo '<input type="submit" value="Request" class="px-4 py-2 border border-blue-600 text-blue-600 rounded-md font-semibold tracking-wide cursor-pointer ml-2">';
        echo '</form>';
        echo '</td>';
        echo "</tr>";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>


            </tbody>
            
          </table>
        </div>
        <!-- View All Button -->
      
      </div>
    </div>
    <script src="./../src/route.js"></script>
    <script src="./../src/form.js"></script>
</body>

</html>