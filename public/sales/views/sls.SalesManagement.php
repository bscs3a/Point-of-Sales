<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <link href="./../src/tailwind.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css">

</head>

<body>
    <?php include "components/sidebar.php" ?>

    <!-- Start: Dashboard -->
    <main id="mainContent" class="w-full md:w-[calc(100%-256px)] md:ml-64 min-h-screen transition-all main">

        <!-- Start: Header -->

        <div class="py-2 px-6 bg-white flex items-center shadow-md sticky top-0 left-0 z-30">

            <!-- Start: Active Menu -->

            <button type="button" class="text-lg sidebar-toggle">
                <i class="ri-menu-line"></i>
            </button>

            <ul class="flex items-center text-md ml-4">

                <li class="mr-2">
                    <p class="text-black font-medium">Sales / Transaction History</p>
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

        <div class="flex flex-col items-center min-h-screen mb-10 ">
            <!-- Target Sales Form -->
            <section id="target-sales-form" class="w-full max-w-md mx-auto mt-10">
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    <h2 class="mb-4 text-xl font-bold text-gray-700">Set Target Sales for This Month</h2>
                    <form action="/AddTarget" method="POST">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="month-year">
                                Month and Year:
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="month" id="month-year" name="month_year" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="target-sales">
                                Target Sales:
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" id="target-sales" name="target_sales" required>
                        </div>
                        <div class="flex items-center justify-between">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Set Target
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>

    <script src="./../src/form.js"></script>
    <script src="./../src/route.js"></script>
</body>

</html>