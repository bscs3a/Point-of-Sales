<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Order Details</title>

    <link href="./../src/tailwind.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css">

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
  </head>
  <body>
    <div class="flex h-screen bg-gray-100">
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
              <label class="text-black font-medium">Order Detail</label>
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
        <div class="h-screen px-10">
          <div class="flex flex-row gap-10 drop-shadow-md my-8">
              <div class="flex flex-col pl-8 border border-gray-300 bg-white rounded-lg w-64 h-40 justify-center">
                <a class="text-6xl ">5350</a>
                <a class="text-lg">Total Delivery</a>
              </div>
              <div class="flex flex-col pl-8 border border-gray-300 bg-white rounded-lg w-64 h-40 justify-center">
                <a class="text-6xl">1214</a>
                <a class="text-lg">To Receive</a>
              </div>
            </div>
          
          <!-- NEW Table -->
            <div class="overflow-x-auto rounded-lg border border-gray-400">
                <table class="min-w-full text-left mx-auto bg-white">
                    <thead class="bg-gray-200 border-b border-gray-400">
                        <tr>
                            <th class="px-4 py-2 font-semibold">Supplier ID</th>
                            <th class="px-4 py-2 font-semibold">Supplier Name</th>
                            <th class="px-4 py-2 font-semibold">Order Date</th>
                            <th class="px-4 py-2 font-semibold">Time</th>
                            <th class="px-4 py-2 font-semibold">Status</th>
                            <th class="px-4 py-2 font-semibold"></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td class="px-4 py-10">12</td>
                            <td class="px-4 py-10">marc</td>
                            <td class="px-4 py-10">03/12/2024</td>
                            <td class="px-4 py-10">09:23:43 AM</td>
                            <td class="px-4 py-10">
                              <select class="rounded-lg border border-gray-400 border-b block px-3 py-1 bg-gray-300 text-sm placeholder-gray-400 text-black focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none">
                              <option value="id">Pending</option>
                              <option value="name">Completed</option>
                              <option value="name">To Receive</option>
                              </select>
                            </td>
                            <td route='/po/viewdetails' class="px-4 py-4">
                              <div>
                                <button route='/po/viewdetails'>view</button>
                              </div>
                            </td>
                        </tr>    
                    </tbody>
                </table>
            </div>

          <!-- table -->
          <div class="overflow-hidden rounded-lg border border-gray-300 shadow-md m-5">

            <table
              class="w-full border-collapse bg-white text-left text-sm text-gray-500">
              <thead class="bg-gray-200">
                <tr class="border-b border-y-gray-300">
                  <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                    ID
                  </th>
                  <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                    Supplier Name
                  </th>
                  <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                    Date Order
                  </th>
                  <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                    Time 
                  </th>
                  <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                    Status
                  </th>
                  <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                  </th>
                </tr>
              </thead>

              <tbody class="divide-y divide-gray-100 border-b border-gray-300">
                <tr class="hover:bg-gray-50">
                  <th class="px-6 py-4 font-normal text-gray-900">
                    <div class="font-medium text-gray-700 text-sm">1023141</div>
                  </th>
                  <td class="px-6 py-4">
                    <div class="font-medium text-gray-700 text-sm">Marc Toolbox</div>
                  </td>
                  <td class="px-6 py-4">
                    <div class="font-medium text-gray-700 text-sm">
                      04/23/2024
                    </div>
                  </td>
                  <td class="px-6 py-4">
                    <div class="font-medium text-gray-700 text-sm">
                      04/26/2024
                    </div>
                  </td>
                  <td class="px-6 py-4">
                    <select class="rounded-lg border border-gray-400 border-b block px-3 py-1 bg-gray-300 text-sm placeholder-gray-400 text-black focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none">
                      <option value="id">Pending</option>
                      <option value="name">Completed</option>
                      <option value="name">To Receive</option>
                    </select>
                  </td>
                  <td class="px-6 py-4">
                    <div class="font-medium text-gray-700 text-sm">
                      View
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>