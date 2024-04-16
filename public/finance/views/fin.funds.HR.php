<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Fund Expenses</title>
    <link href="./../../src/tailwind.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css">
</head>

<body>

    <?php include "components/sidebar.php" ?>

    <!-- Start: Dashboard -->

    <main class="w-full md:w-[calc(100%-256px)] md:ml-64 min-h-screen transition-all main">

        <!-- Start: Header -->

        <div class="py-2 px-6 bg-white flex items-center shadow-md sticky top-0 left-0 z-30">

            <!-- Start: Active Menu -->

            <button type="button" class="text-lg sidebar-toggle">
                <i class="ri-menu-line"></i>
            </button>

            <ul class="flex items-center text-md ml-4">

                <li class="mr-2">
                    <p class="text-black font-medium">Department Fund Expenses</p>
                </li>

            </ul>

            <!-- End: Active Menu -->

            <!-- Start: Profile -->

            <ul class="ml-auto flex items-center">
                <div class="text-black font-medium">Sample User</div>
                <li class="dropdown ml-3">
                    <i class="ri-arrow-down-s-line"></i>
                </li>
            </ul>

            <!-- End: Profile -->

        </div>

        <!-- End: Header -->

        <div class="w-full p-6 bg-white">

            <div class="justify-between items-start mb-4">
                <!-- Tabs -->
                <div class="mb-4">


                    <div class="hidden sm:block">
                        <div class="border-b border-gray-200">
                            <nav class="-mb-px flex gap-6" aria-label="Tabs">
                                <a route='/fin/funds/HR'
                                    class="cursor-pointer shrink-0 border-b-2 border-sidebar px-1 pb-4 text-sm font-medium text-sidebar"
                                    aria-current="page">
                                    Human Resources
                                </a>
                                <a route='/fin/funds/PO'
                                    class="cursor-pointer shrink-0 border-b-2 border-transparent px-1 pb-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                                    Product Order
                                </a>
                                <a route='/fin/funds/Sales'
                                    class="cursor-pointer shrink-0 border-b-2 border-transparent px-1 pb-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                                    Sales
                                </a>
                                <a route='/fin/funds/Inventory'
                                    class="cursor-pointer shrink-0 border-b-2 border-transparent px-1 pb-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                                    Inventory
                                </a>
                                <a route='/fin/funds/Delivery'
                                    class="cursor-pointer shrink-0 border-b-2 border-transparent px-1 pb-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                                    Delivery
                                </a>
                                <a route='/fin/funds/Finance'
                                    class="cursor-pointer shrink-0 border-b-2 border-transparent px-1 pb-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                                    Finance
                                </a>


                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class=" mb-6">
                <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-3 gap-6 ">
                    <div class=" col-span-1 bg-gradient-to-b from-[#F8B721] to-[#FBCF68] rounded-xl drop-shadow-md">
                        <div class="mx-5 my-5 py-3 px-3 text-white">
                            <h1 class="text-3xl font-bold">Given Allowance</h1>
                            <p class="mt-5 text-4xl font-medium">₱200,000.00</p>
                        </div>
                    </div>
                    <div class=" col-span-1 bg-gradient-to-b from-[#F8B721] to-[#FBCF68] rounded-xl drop-shadow-md">
                        <div class="mx-5 my-5 py-3 px-3 text-white">
                            <h1 class="text-3xl font-bold">Total Expenses</h1>
                            <p class="mt-5 text-4xl font-medium">₱100,950.00</p>
                        </div>
                    </div>
                    <div class=" col-span-1 bg-gradient-to-b from-[#F8B721] to-[#FBCF68] rounded-xl drop-shadow-md">
                        <div class="mx-5 my-5 py-3 px-3 text-white">
                            <h1 class="text-3xl font-bold">Remaining Funds</h1>
                            <p class="mt-5 text-4xl font-medium">₱99,050.00</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto rounded-lg border border-gray-400">
                <table class="min-w-full divide-y-2 divide-gray-400 bg-white text-sm">
                  
                    <thead class="ltr:text-left rtl:text-right bg-gray-200">
                        <tr>
                            <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">ID</th>
                            <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Details</th>
                            <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Amount</th>
                            <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Department</th>
                            <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Date</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 text-center">
                        <tr>
                            <td class="whitespace-nowrap px-4 py-2 text-gray-700">0001</td>
                            <td class="whitespace-nowrap px-4 py-2 text-gray-700">Payroll</td>
                            <td class="whitespace-nowrap px-4 py-2 text-gray-700">₱50,000.00</td>
                            <td class="whitespace-nowrap px-4 py-2 text-gray-700">Human Resources</td>
                            <td class="whitespace-nowrap px-4 py-2 text-gray-700">March 31, 2024</td>
                        </tr>
                        <tr>
                            <td class="whitespace-nowrap px-4 py-2 text-gray-700">0009</td>
                            <td class="whitespace-nowrap px-4 py-2 text-gray-700">Document Materials</td>
                            <td class="whitespace-nowrap px-4 py-2 text-gray-700">₱950.00</td>
                            <td class="whitespace-nowrap px-4 py-2 text-gray-700">Human Resources</td>
                            <td class="whitespace-nowrap px-4 py-2 text-gray-700">April 6, 2024</td>
                        </tr>
                        <tr>
                            <td class="whitespace-nowrap px-4 py-2 text-gray-700">0021</td>
                            <td class="whitespace-nowrap px-4 py-2 text-gray-700">Payroll</td>
                            <td class="whitespace-nowrap px-4 py-2 text-gray-700">₱50,000.00</td>
                            <td class="whitespace-nowrap px-4 py-2 text-gray-700">Human Resources</td>
                            <td class="whitespace-nowrap px-4 py-2 text-gray-700">April 15, 2024</td>
                        </tr>

                       
                    </tbody>
                </table>
            </div>
        </div>

            
    </main>
    <script  src="./../../src/route.js"></script>
    <!-- Start: Sidebar -->
    <!-- End: Dashboard -->
</body>

</html>