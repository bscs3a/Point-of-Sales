<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Suppliers</title>
  <link href="./../src/tailwind.css" rel="stylesheet" />
</head>

<body>
  <div class="flex h-screen bg-gray-100">

    <?php include "components/po.sidebar.php" ?>

    <!-- Navbar -->
    <div class="flex flex-col flex-1 overflow-y-auto">
      <!-- header -->
      <div class="flex items-center justify-between h-16 bg-zinc-200 border-b border-gray-200">
        <div class="flex items-center px-4">
          <button class="text-gray-500 focus:outline-none focus:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
          <h1 class="text-2xl font-semibold px-5">Product Order / Suppliers</h1>
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
          <div class="flex sm:flex-row flex-col">
            <div class="flex flex-row">
              <select
                class="appearance-none rounded-l-lg border border-gray-400 border-b block pl-8 pr-6 py-2 bg-gray-300 text-sm placeholder-gray-400 text-black focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none">
                <option value="id">Filter</option>
                <option value="name">Rank</option>
                <option value="name">...</option>
                <option value="name">...</option>
                <option value="name">...</option>
                <!-- Add more filter options as needed -->
              </select>
              <input placeholder="Search ID"
                class=" rounded-l rounded-lg sm:rounded-l-none border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-gray-300 text-sm placeholder-white text-white focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
            </div>
          </div>
          <div class="lg:ml-40 ml-10 space-x-8">
            <button class="bg-violet-950 px-4 py-2 rounded-md text-white font-semibold tracking-wide cursor-pointer">
              <a>add supplier</a>
            </button>
          </div>
        </div>

        <!-- Cards -->
        <?php
        try {
          require_once 'dbconn.php';
          // Query to retrieve supplier information
          $query = "SELECT * FROM suppliers";
          $statement = $conn->prepare($query);
          $statement->execute();
          // Check if there are any results
          if ($statement->rowCount() > 0) {
            // Loop through each row of the result
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
              // Output HTML code for each supplier
              echo '
            <div class="flex justify-center items-center">
            <div class="grid grid-cols-3 gap-6">
              <div class="h-72 w-96 border border-gray-400 rounded-lg drop-shadow-md">
                <div class="flex flex-col gap-2 ml-3 my-8">
                  <a class="text-2xl">Rank 1</a>
                  <div class="flex flex-row">
                    <a>Company Name:</a>
                    <a class="ml-3 text-gray-500">' . $row["Supplier_Name"] . '</a>
                  </div>
                  <div class="flex flex-row">
                    <a>Status:</a>
                    <a class="ml-3 text-green-600">Active</a>
                  </div>
                </div>

                <div class="flex justify-center items-center">
                  <button
                    class="bg-violet-950 my-3 px-4 py-1 rounded-md text-white font-semibold tracking-wide cursor-pointer">
                    <a>View</a>
                  </button>
                </div>
              </div>';

            }
          } else {
            echo "No suppliers found.";
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
  </div>
  </div>
</body>

</html>