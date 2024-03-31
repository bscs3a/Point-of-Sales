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
        </div>
      </div>
    </div>
  </body>
  <script  src="./../src/route.js"></script>
</html>