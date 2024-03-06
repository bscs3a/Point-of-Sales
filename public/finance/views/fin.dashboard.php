<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="./../src/tailwind.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css">
</head>

<body>
    <!-- Start: Sidebar -->
    <div class="fixed bg-sidebar left-0 top-0 w-64 h-full p-4 z-50 sidebar-menu transition-transform">

        <div href="#" class="flex items-center pb-4">
            <img src="https://placehold.co/50x50" alt="" class="w-10 h-10 rounded object-cover">

            <span class="text-4xl  font-russo ml-3 text-white">BSCS 3A</span>
        </div>

        <ul class="mt-3">

            <li class="mb-1 group active ">
                <a href="#" class="flex items-center py-2 px-4 bg-fuchsia-200 bg-opacity-30 rounded-lg text-white ">
                    <i class="ri-speed-up-line mr-3 text-lg  "></i>
                    <span class="text-sm font-medium ">Dashboard</span>
                    <i class="ri-arrow-right-s-line ml-auto"></i>
                </a>
            </li>

            <li class="mb-1 group">
                <a href="#" class="flex items-center py-2 px-4 bg-sidebar text-white">
                    <i class="ri-file-text-line mr-3 text-lg"></i>
                    <span class="text-sm font-medium">Invoices</span>
                    <i class="ri-arrow-right-s-line ml-auto"></i>
                </a>
            </li>

            <li class="mb-1 group">
                <a href="#" class="flex items-center py-2 px-4 bg-sidebar text-white">
                    <i class="ri-menu-search-line mr-3 text-lg"></i>
                    <span class="text-sm font-medium">Expense Category</span>
                    <i class="ri-arrow-right-s-line ml-auto"></i>
                </a>
            </li>

            <li class="mb-1 group">
                <a href="#" class="flex items-center py-2 px-4 bg-sidebar text-white">
                    <i class="ri-file-history-line mr-3 text-lg"></i>
                    <span class="text-sm font-medium">Expense Record</span>
                    <i class="ri-arrow-right-s-line ml-auto"></i>
                </a>
            </li>

            <li class="mb-1 group">
                <a href="#" class="flex items-center py-2 px-4 bg-sidebar text-white">
                    <i class="ri-box-3-line mr-3 text-lg"></i>
                    <span class="text-sm font-medium">Items</span>
                    <i class="ri-arrow-right-s-line ml-auto"></i>
                </a>
            </li>

            <li class="mb-1 group">
                <a href="#" class="flex items-center py-2 px-4 bg-sidebar text-white">
                    <i class="ri-bank-card-line mr-3 text-lg"></i>
                    <span class="text-sm font-medium">Payments</span>
                    <i class="ri-arrow-right-s-line ml-auto"></i>
                </a>
            </li>

            <li class="mb-1 group">
                <a href="#" class="flex items-center py-2 px-4 bg-sidebar text-white">
                    <i class="ri-funds-line mr-3 text-lg"></i>
                    <span class="text-sm font-medium">Revenue Record</span>
                    <i class="ri-arrow-right-s-line ml-auto"></i>
                </a>
            </li>

            <li class="mb-1 group">
                <a href="#" class="flex items-center py-2 px-4 bg-sidebar text-white">
                    <i class="ri-scales-line mr-3 text-lg"></i>
                    <span class="text-sm font-medium">Balance Sheet</span>
                    <i class="ri-arrow-right-s-line ml-auto"></i>
                </a>
            </li>

            <li class="mb-1 group">
                <a href="#" class="flex items-center py-2 px-4 bg-sidebar text-white">
                    <i class="ri-database-2-line mr-3 text-lg"></i>
                    <span class="text-sm font-medium">Database</span>
                    <i class="ri-arrow-right-s-line ml-auto"></i>
                </a>
            </li>

            <li class="mb-1 group">
                <a href="#" class="flex items-center py-2 px-4 bg-sidebar text-white">
                    <i class="ri-group-line mr-3 text-lg"></i>
                    <span class="text-sm font-medium">Users</span>
                    <i class="ri-arrow-right-s-line ml-auto"></i>
                </a>
            </li>
        </ul>

    </div>

    <div class="fixed top-0 left-0 w-full h-full z-40 md:hidden sidebar-overlay"></div>
    <!-- End: Sidebar -->

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
                    <p class="text-black font-medium">Dashboard</p>
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

        <!-- Start: Inner Dashboard Analytics-->
        <div class="w-full min-h-screen p-6 bg-white">
            <!-- Start: Top Section -->
            <div class="grid grid-cols-1 md:grid-cols-2  gap-6 mb-6">
                <!-- Start: Top Left-Side Section -->
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3  border-solid border-gray-400 shadow-md rounded-md px-5 py-4">
                    <div class="border-solid col-span-2 ">
                        <!-- Start: Welcome Message -->
                        <h1 class="font-sans font-bold  text-5xl">Hello, Sample User!</h1>
                        <p class="line-clamp-2 w-3/4 mt-3 font-sans text-xl text-gray-400 ">Welcome back! Ready to gear
                            up for another productive day?</p>
                        <!-- End: Welcome Message -->

                        <!-- Start: Mini-Dashboard Analytics -->
                        <div id="mini-dashboard" class="mt-10 grid grid-cols-1  md:grid-cols-2 md:grid-rows-2 gap-4">
                            <!-- Start: Dashboard Analytics: Total Items -->
                            <div class="bg-white rounded-md border border-gray-300 p-4 shadow-lg">
                                <div class="flex justify-between mb-4">
                                    <div>
                                        <div class="flex items-center mb-1">
                                            <div class="text-2xl font-semibold">0</div>
                                        </div>
                                        <div class="text-sm font-medium text-gray-400">Total Items</div>
                                    </div>
                                    <div>
                                        <i class="ri-file-text-line mr-3 text-4xl"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- End: Dashboard Analytics: Total Items -->
                        </div>
                        <!-- End: Mini-Dashboard Analytics -->

                        <!-- Start Script: mini-dashboard item repeater -->
                        <script>
                            var miniDashboard = document.getElementById('mini-dashboard');
                            // Array of mini-dashboard items
                            var mini_dash_items = [
                                "?",
                                "Total Expense",
                                "Balance"
                            ];
                            // Loop through the mini_dash_items array and display the mini-dashboard items
                            for (let index = 0; index < mini_dash_items.length; index++) {
                                // const element = array[index];
                                miniDashboard.innerHTML += `
                                <div class="bg-white rounded-md border border-gray-300 p-4 shadow-lg">
                                    <div class="flex justify-between mb-4">
                                        <div>
                                            <div class="flex items-center mb-1">
                                                <div class="text-2xl font-semibold">0</div>
                                            </div>
                                            <div class="text-sm font-medium text-gray-400">${mini_dash_items[index]}</div>
                                            </div>
                                            <div>
                                            <i class="ri-file-text-line mr-3 text-4xl"></i>
                                            </div>
                                            </div>
                                            </div>
                                            `;
                            }
                        </script>
                        <!-- End Script: mini-dashboard item repeater -->
                    </div>

                    <div class="text-right col-span-1">
                        <a href="#" class="font-sans font-bold text-xl">View Details(?) ></a>
                    </div>



                </div>
                <!-- End: Top Left-Side Section -->

                <!-- Start: Top Right-Side Section -->
                <div class="text-center border-2 border-solid border-black">
                    <h1 class="font-russo text-2xl mt-10">Chart</h1>
                </div>
                <!-- End: Top Right-Side Section -->
            </div>
            <!-- End: Top Section -->


            <!-- Start: Second Section -->
            <div class="mt-10 border-solid border-2 border-black py-28 px-36">

                <h1 class="font-russo text-4xl">Chart</h1>
            </div>
            <!-- End: Second Section -->
        </div>
        <!-- End: Inner Dashboard Analytics-->


    </main>
    <!-- End: Dashboard -->
</body>

</html>