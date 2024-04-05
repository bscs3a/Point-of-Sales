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
              <label class="text-black font-medium">Product List / Add Item</label>
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

      <!-- New Form for add product -->
      <div class="container mx-auto py-10 px-5">
        <div class="max-w-4xl h-full mx-auto bg-white border border-gray-300 rounded-lg shadow-md overflow-hidden"> 
        
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 mb-6 px-6 pt-4">
            <!-- Upload image -->
            <div class="p-5">
              <div class="flex justify-center items-center">
                <div>
                  <div class="flex size-64 border border-gray-600 rounded-md justify-center items-center relative"> 
                    <img src="placeholder.jpg" alt="img" class="w-full object-cover">
                    <input type="file" name="file" id="fileInput" class="absolute inset-0 opacity-0">
                  </div>
                  <div class="text-center py-4">
                    <label for="fileInput" class="button border border-gray-500 p-2 rounded-lg">
                      <i class="ri-image-add-line px-2"></i>Choose Image
                    </label>
                  </div>
                </div>
              </div>
            </div>

            <div class="md:col-span-2 p-6">
              <form>
                  <div class="mb-4">
                      <label for="productid" class="block text-black font-semibold mb-2">Product ID</label>
                      <input type="number" id="productid" name="productid"
                          class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400" required>
                  </div>
                  <div class="mb-4">
                      <label for="productname" class="block text-black font-semibold mb-2">Product Name</label>
                      <input type="text" id="productname" name="productname"
                          class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400" required>
                  </div>
                  <div class="mb-4">
                      <label for="supplier" class="block text-gblack font-semibold mb-2">Supplier</label>
                      <input type="text" id="supplier" name="supplier"
                          class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400" required>
                  </div>
              </form>    
            </div>
          </div>


        <!-- NEW Forms for category, weight, price, and description -->
          <div class="px-10">
            <form>
                  <div class="mb-6">
                  <label for="category" class="block text-black font-semibold mb-2">Category</label>
                    <select id="category" name="category" class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400" required>
                      <option value="">Select Category</option>
                      <option value="male">option1</option>
                      <option value="female">option2</option>
                      <option value="other">Other</option>
                    </select>
                  </div>
                  <div class="mb-4">
                      <label for="weight" class="block text-black font-semibold mb-2">Weight</label>
                      <input type="text" id="weight" name="weight" class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400" required>
                  </div>
                  <div class="mb-4">
                      <label for="price" class="block text-black font-semibold mb-2">Price</label>
                      <input type="text" id="price" name="price" class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400" required>
                  </div>
                  <div class="mb-4">
                      <label for="message" class="block text-black font-semibold mb-2">Description</label>
                      <textarea id="message" name="message"
                          class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400" rows="5"></textarea>
                  </div>
                  <div class="flex flex-row justify-end gap-3 px-8 my-3">
                    <button route='/po/items' class="py-2 px-6 border border-gray-600 font-bold rounded-md">Back</button>
                    <button type="submit" class="py-2 px-6 border border-gray-600 font-bold rounded-md bg-yellow-400">Save</button>
                </div>
            </form>
          </div>
        </div>
      </div>

      <form action="/po/addItem" method="POST" enctype="multipart/form-data">
        <!-- Add Item -->
        <div class="flex h-screen py-3 justify-center items-center bg-white">
          <div class="h-full w-1/2 border-2 border-gray-300 rounded-md drop-shadow-lg">
            <div class="flex flex-col my-8 mx-3">
              <div class="flex flex-row items-center">
                <!-- Img Item -->
                <div class="flex flex-col justify-center items-center mx-auto mt-3">
                  <div class="relative">
                    <!-- Image container with border and rounded corners -->
                    <div
                      class="w-32 h-32 border-2 border-dashed border-gray-300 rounded-lg flex justify-center items-center">
                      <!-- Image preview with rounded corners and object cover -->
                      <img id="previewImage" src="placeholder.jpg" alt=""
                        class="w-full h-full rounded-lg object-cover">
                      <!-- Placeholder icon -->
                      <div id="imageIcon"
                        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-gray-400 text-3xl">
                        +</div>
                    </div>
                    <!-- File input hidden overlaying the image container -->
                    <input type="file" name="file" id="fileInput" class="absolute inset-0 opacity-0" required
                      onchange="previewFile()">
                  </div>
                  <!-- Button to choose image -->
                  <label for="fileInput"
                    class="mt-2 bg-blue-500 text-white px-4 py-2 rounded-lg cursor-pointer hover:bg-blue-600 transition duration-300 ease-in-out">Choose
                    Image</label>
                </div>
                <!-- Forms for product name and id, suppliers name -->
                <div class="flex flex-col mr-8">
                  <!-- <label for="productid">Product ID</label>
                  <input type="number" id="productid" name="productid"
                    class="h-8 w-80 border-2 bg-white mb-3 rounded-md" required> -->

                  <label for="productname">Product Name</label>
                  <input type="text" id="productname" name="productname"
                    class="h-8 w-80 border-2 bg-white mb-3 rounded-md" required>

                  <label for="supplier">Supplier Name</label>
                  <select class="h-8 w-80 border-2 bg-gray-300 rounded-md" id="supplier" name="supplier" required>
                    <option value="">Select Supplier</option>
                    <?php
                    // Function to retrieve all suppliers from the database
                    function getAllSuppliers()
                    {
                      try {
                        // Connect to your database using PDO
                        require_once 'dbconn.php';

                        // Query to retrieve all suppliers
                        $sql = "SELECT Supplier_Name FROM suppliers";

                        // Prepare the SQL statement
                        $stmt = $conn->prepare($sql);

                        // Execute the query
                        $stmt->execute();

                        // Fetch all supplier names
                        $suppliers = $stmt->fetchAll(PDO::FETCH_COLUMN);
                        return $suppliers;
                      } catch (PDOException $e) {
                        // Handle errors
                        echo "Error: " . $e->getMessage();
                        return array(); // Return empty array if there's an error
                      }
                    }

                    // Call the function to get all suppliers
                    $allSuppliers = getAllSuppliers();

                    // Output all suppliers as options in the select dropdown
                    foreach ($allSuppliers as $supplier) {
                      echo "<option>$supplier</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>

              <!-- Forms for category, weight, price, and description -->
              <div class="flex flex-col justify-center mt-8 px-8">
                <label for="category">Category</label>
                <select class="h-8 border-2 bg-gray-300 mb-3 rounded-md" id="category" name="category" required>
    <option value="">Select Category</option>
    <?php
    // Get all category names
    $categoryNames = getAllCategories();

    // Generate options dynamically
    foreach ($categoryNames as $category) {
        echo "<option value=\"$category\">$category</option>";
    }
    ?>
</select>

                <label for="weight">Weight</label>
                <input type="text" id="weight" name="weight" class="h-8  border-2 bg-white mb-3 rounded-md" required>

                <label for="price">Price</label>
                <input type="text" id="price" name="price" class="h-8 border-2 bg-white mb-3 rounded-md" required>

                <label for="description">Description</label>
                <textarea class="h-16 border-2 bg-white px-2 resize-none rounded-md" id="description" name="description"
                  required></textarea>


                <div class="flex flex-row justify-end gap-3 px-8 mt-3">
                  <button route='/po/items' class="py-2 px-4 border-2 text-lg rounded-md">Back</button>
                  <button type="submit" class="py-2 px-4 border-2 text-lg rounded-md bg-[#FFC955]">Save</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    <script>
      function previewFile() {
        const preview = document.getElementById('previewImage');
        const icon = document.getElementById('imageIcon');
        const file = document.querySelector('input[type=file]').files[0];
        const reader = new FileReader();

        reader.onloadend = function () {
          preview.src = reader.result;
          icon.style.display = 'none'; // Hide the icon when an image is selected
        };

        if (file) {
          reader.readAsDataURL(file);
        } else {
          preview.src = "placeholder.jpg"; // If no file is selected, display a placeholder image
          icon.style.display = 'block'; // Display the icon when no image is selected
        }
      }
    </script>
    <script src="./../src/route.js"></script>
<script src="./../src/form.js"></script>
</body>


</html>