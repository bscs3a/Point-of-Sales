<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link href="./../src/tailwind.css" rel="stylesheet" />
  </head>
  
  <body>
    <div class="flex h-screen bg-gray-100">
      
    <?php include "components/po.sidebar.php" ?>

      <!-- Navbar -->
      <div class="flex flex-col flex-1 overflow-y-auto">
        <!-- header -->
        <div
          class="flex items-center justify-between h-16 bg-zinc-200 border-b border-gray-200">
          <div class="flex items-center px-4">
            <button
              class="text-gray-500 focus:outline-none focus:text-gray-700">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16" />
              </svg>
            </button>
            <h1 class="text-2xl font-semibold px-5">Dashboard</h1>
          </div>

          <div class="flex items-center pr-4 text-xl font-semibold">
            Sample User

            <span class="p-3">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-6 h-6">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="m19.5 8.25-7.5 7.5-7.5-7.5" />
              </svg>
            </span>
          </div>
        </div>

        <!-- Main Content -->
        <div class="h-screen">
          <div class="flex flex-row justify-center gap-16 drop-shadow-md my-8">
            <div class="flex border-2 border-gray-400 rounded-md w-80 h-40 justify-center items-center">
              <a class="text-lg">Suppliers</a>
            </div>
            <div class="flex border-2 border-gray-400 rounded-md w-80 h-40 justify-center items-center">
              <a class="text-lg">Items</a>
            </div>
            <div class="flex border-2 border-gray-400 rounded-md w-80 h-40 justify-center items-center">
              <a class="text-lg">Order Request</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
