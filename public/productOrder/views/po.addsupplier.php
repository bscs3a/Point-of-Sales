<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add Supplier</title>

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
          <label class="text-black font-medium">Product Order / Add Suppliers</label>
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

      <!-- New Form -->
      <div class="container mx-auto py-3">
        <div class="max-w-4xl h-full mx-auto bg-white border border-gray-300 rounded-lg shadow-md overflow-hidden">
          <div id="main" class="m-3 pt-6">

            <!-- NEW Form -->
            <div class="px-10">
              <form  class="grid grid-cols-2 gap-6" id="productForm" action="save_product.php" method="post">

                <div>
                  <div class="mb-4">
                    <label for="productid" class="block text-black font-semibold mb-2">Supplier Name</label>
                    <input type="text" id="suppliername" name="suppliername"
                      class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400"
                      required>
                  </div>
                  <div class="mb-4">
                    <label for="productname" class="block text-black font-semibold mb-2">Contact Name</label>
                    <input type="text" id="contactname" name="cotactname"
                      class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400"
                      required>
                  </div>
                  <div class="mb-4">
                    <label for="contactnum" class="block text-black font-semibold mb-2">Contact Number</label>
                    <input type="number" id="contactnum" name="contactnum"
                      class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400"
                      required>
                  </div>
                </div>
                <div>
                  <div class="mb-4">
                    <label for="location" class="block text-black font-semibold mb-2">Status</label>
                    <input type="text" id="status" name="status"
                      class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400"
                      required>
                  </div>
                  <div class="mb-4">
                    <label for="location" class="block text-black font-semibold mb-2">Email</label>
                    <input type="text" id="email" name="email"
                      class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400"
                      required>
                  </div>
                  <div class="mb-4">
                    <label for="location" class="block text-black font-semibold mb-2">Address</label>
                    <input type="text" id="address" name="address"
                      class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400"
                      required>
                  </div>
                </div>
              </div>


              <!-- add rows function/ button -->
              <div class="flex place-content-end mt-2 m-3">
                <button id="addRows" class="items-end rounded-full px-2 py-1 bg-violet-950 text-white">
                  <i class="ri-add-circle-line"></i>
                  <span>Add Rows</span>
                </button>
              </div>

              <!-- Table for product -->
              <div class="overflow-x-auto rounded-lg border border-gray-400">
                <table id="productTable" class="min-w-full text-center mx-auto bg-white">
                  <thead class="bg-gray-200 border-b border-gray-400 text-sm">
                    <tr>
                      <th class="px-4 py-2 font-semibold">Product Image</th>
                      <th class="px-4 py-2 font-semibold">Product Name</th>
                      <th class="px-4 py-2 font-semibold">Category</th>
                      <th class="px-4 py-2 font-semibold">Price</th>
                      <th class="px-4 py-2 font-semibold">Quantity</th>
                      <th class="px-4 py-2 font-semibold">Description</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Existing rows will be added here -->
                  </tbody>
                </table>
              </div>

              <div class="flex flex-row justify-end gap-3 my-3">
                <button route='/po/suppliers'
                  class="py-2 px-6 border border-gray-600 font-bold rounded-md">Back</button>
                <button id="saveButton" type="submit"
                  class="py-2 px-6 border border-gray-600 font-bold rounded-md bg-yellow-400">Save</button>
              </div>
          </form>

              <script>
                // Function to add an image input field to the cell
                function addImageInput(cell) {
                  // Create input element of type file
                  let input = document.createElement('input');
                  input.type = 'file';
                  input.accept = 'image/*';
                  input.className = 'w-full';
                  // Set up drag and drop event listeners
                  input.addEventListener('dragover', handleDragOver);
                  input.addEventListener('drop', handleFileSelect);
                  // Append the input element to the cell
                  cell.appendChild(input);
                }

                // Function to handle file drop
                function handleFileSelect(event) {
                  event.preventDefault();
                  var files = event.dataTransfer.files;
                  var reader = new FileReader();
                  reader.onload = function (e) {
                    event.target.value = e.target.result;
                  };
                  reader.readAsDataURL(files[0]);
                }

                // Function to handle drag over
                function handleDragOver(event) {
                  event.preventDefault();
                  event.dataTransfer.dropEffect = 'copy';
                }

                document.getElementById('addRows').addEventListener('click', function () {
                  // Get the table body
                  let tableBody = document.querySelector('#productTable tbody');
                  // Create a new row
                  let newRow = tableBody.insertRow();
                  // Add cells to the new row
                  for (let i = 0; i < 6; i++) {
                    let cell = newRow.insertCell();
                    // For simplicity, add input fields in most cells
                    if (i === 0) { // If it's the cell under "Product Image"
                      // Call the function to add an image file input field
                      addImageInput(cell);
                    } else if (i === 2) { // If it's the cell under "Category"
                      cell.innerHTML = '<select class="px-4 py-2 border border-gray-300 rounded-md w-full">' +
                        '<option value="Hand Tools">Hand Tools</option>' +
                        '<option value="Power Tools">Power Tools</option>' +
                        '<option value="Category 3">Category 3</option>' +
                        // Add more categories as needed
                        '</select>';
                    } else {
                      cell.innerHTML = '<input class="px-4 py-2 border border-gray-300 rounded-md w-full">';
                    }
                  }
                });

                document.getElementById('saveButton').addEventListener('click', function () {
                  // Get the table body
                  let tableBody = document.querySelector('#productTable tbody');
                  // Loop through each row in the table body
                  tableBody.querySelectorAll('tr').forEach(row => {
                    // Get the input fields and select elements in the row
                    let inputs = row.querySelectorAll('input');
                    let selects = row.querySelectorAll('select');
                    // Assuming you have a way to retrieve the data and save it to the database
                    let rowData = [];
                    inputs.forEach(input => {
                      rowData.push(input.value);
                    });
                    selects.forEach(select => {
                      rowData.push(select.value);
                    });
                    // Now you can send `rowData` to your backend for saving to the database
                    console.log('Row data:', rowData);
                    // Replace the console log with your actual logic for saving data to the database, typically using AJAX
                  });
                });
              </script>
              <script src="./../src/route.js"></script>
              <script src="./../src/form.js"></script>

</body>


</html>