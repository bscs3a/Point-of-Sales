<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>View Order Details</title>

  <link href="./../src/tailwind.css" rel="stylesheet">
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
      <div class="flex items-center justify-between h-16 bg-gray-200 shadow-md px-4 py-2">
        <div class="flex items-center gap-4">
          <button id="toggleSidebar" class="text-gray-900 focus:outline-none focus:text-gray-700">
            <i class="ri-menu-line"></i>
          </button>
          <label class="text-black font-medium">Order Detail / View</label>
        </div>

        <!-- dropdown -->
        <div x-data="{ dropdownOpen: false }" class="relative my-32">
          <button @click="dropdownOpen = !dropdownOpen"
            class="relative z-10 border border-gray-400 rounded-md bg-gray-100 p-2 focus:outline-none">
            <div class="flex items-center gap-4">
              <a class="flex-none text-sm dark:text-white" href="#">David, Marc</a>
              <i class="ri-arrow-down-s-line"></i>
            </div>
          </button>

          <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"></div>

          <div x-show="dropdownOpen"
            class="absolute right-0 mt-2 py-2 w-40 bg-gray-100 border border-gray-200 rounded-md shadow-lg z-20">
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

      <!-- New Form for add product -->
      <div class="container mx-auto py-8 px-5">
        <div class="max-w-5xl h-full mx-auto bg-white border border-gray-300 rounded-lg shadow-md overflow-hidden">
          
        
              <div class="p-10">

                <div class="flex justify-between pb-3">
                    <div class="font-bold text-3xl">
                        Supplier Name
                    </div>
                    <div class="font-bold text-xl">
                        Supplier ID
                    </div>
                </div>

                <!-- Supplier Information -->
                <div class="flex item-center gap-60 px-4">
                    <ul class="text-gray-900">
                      <li class="flex py-1">
                        <span class="font-semibold w-40">Contact Name:</span>
                        <span class="font-medium text-gray-900">
                          
                        </span>
                      </li>
                      <li class="flex">
                        <span class="font-semibold w-40">Order Date:</span>
                        <span class="font-medium text-gray-900"> 
                
                        </span>
                      </li>
                      <li class="flex py-1">
                        <span class="font-semibold w-40">Order Time:</span>
                        <span class="font-medium text-gray-900"> 
                
                        </span>
                      </li>
                    </ul>

                    <ul class=" text-gray-900 ">
                      <li class="flex py-1">
                        <span class="font-semibold w-24">Location:</span>
                        <span class="font-medium text-gray-900">
                          
                        </span>
                      </li>
                      <li class="flex py-1">
                        <span class="font-semibold w-20">Status:</span>
                        <span class="font-medium text-green-900">
                          
                        </span>
                      </li>
                    </ul>
                  </div>

                <!-- Table -->
                <div class="py-4">
                  <div class="overflow-x-auto rounded-lg border border-gray-400">
                    <table class="min-w-full text-left mx-auto bg-white">
                      <thead class="bg-gray-200 border-b border-gray-400 text-xs">
                        <tr>
                          <th class="px-6 py-2 font-semibold">Product ID</th>
                          <th class="px-6 py-2 font-semibold">Product Name</th>
                          <th class="px-6 py-2 font-semibold">Supplier Name</th>
                          <th class="px-6 py-2 font-semibold">Category</th>
                          <th class="px-6 py-2 font-semibold">Price</th>
                          <th class="px-6 py-2 font-semibold">Quantity</th>
                          <th class="px-6 py-2 font-semibold">Description</th>
                          <th class="px-6 py-2 font-semibold"></th>
                        </tr>
                      </thead>

                     
                        <tr>
                          <td class="px-4 py-2">
                          </td> <!-- Display product ID -->
                          <td class="px-4 py-2 flex items-center justify-center">
                            <div>
                            </div> <!-- Display product name -->
                          </td>
                          <td class="px-4 py-2">
                          </td> <!-- Display supplier name -->
                          <td class="px-4 py-2">
                          </td> <!-- Display category -->
                          <td class="px-4 py-2">
                          </td> <!-- Display price -->
                          <td class="px-4 py-2">
                          </td> <!-- Display quantity -->
                          <td class="px-4 py-2">
                          </td> <!-- Display Description -->
                          <td class="px-4 py-2">
                          </td> <!-- Display status -->
                        </tr>
                        
                      <tfoot class="text-left bg-gray-200">
                        <tr class="border-b border-y-gray-300">
                          <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                          <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                          <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                          <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                          <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                          <th scope="col" class="px-6 py-4 ml-3 font-medium text-gray-900">
                            <div class="flex flex-col font-medium text-gray-700 gap-3">
                              <a>Items Subtotal:
                              </a>
                              <a>Total Amount: Php
                              </a>
                            </div>
                          </th>
                          <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                          <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                        </tr>
                      </tfoot>
                </table>
              </div>

            </div>

            
            <form>
                <h2 class="font-bold text-lg pb-2">Feedback</h2>
                <div class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                    <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-gray-800">
                        <label for="comment" class="sr-only">Your comment</label>
                        <textarea id="comment" rows="4" class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400" placeholder="Write a feedback..." required /></textarea>
                    </div>
                    
                </div>
            </form>


            <div class="flex justify-end gap-2">
                <button route='/po/orderDetail' class="py-2 px-6 border border-gray-600 font-bold rounded-md">
                    Back
                </button>
                <button route='/po/orderDetail' class="py-2 px-6 border border-gray-600 bg-yellow-500 font-bold rounded-md">
                    Save
                </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="./../../src/form.js"></script>
    <script src="./../../src/route.js"></script>
</body>

</html>