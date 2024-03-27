<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <link href="./../src/tailwind.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css">

    <?php
    require_once 'function/fetchSalesData.php';
    ?>

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
                    <p class="text-black font-medium">Sales / Returns</p>
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
            <div class="w-full max-w-6xl mt-10">
                <div class="flex justify-between items-center">
                    <h1 class="mb-3 text-xl font-bold text-black">Returns</h1>
                    <div class="relative mb-3">
                    <select id="searchType" class="px-3 py-2 border rounded-lg mr-8">
                            <option value="customerName">Customer Name</option>
                            <option value="saleId">Sale ID</option>
                            <option value="salePreference">Sale Preference</option>
                            <option value="paymentMode">Payment Mode</option>
                        </select>
                        <input type="text" id="searchInput" placeholder="Search..." title="Search by ID, Name, Sale Preferences, Payment Mode..." class="px-3 py-2 pl-5 pr-10 border rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-6a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex flex-row gap-10">
                    
                    <table id="salesTable" class="table-auto w-full mx-auto rounded-lg overflow-hidden shadow-lg text-center">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 font-semibold">Returned Item</th>
                                <th class="px-4 py-2 font-semibold">Order ID</th>
                                <th class="px-4 py-2 font-semibold">Payment Returned</th>
                                <th class="px-4 py-2 font-semibold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Fetch data from the result set -->
                                <tr class='border border-gray-200 bg-white' data-sale-id='<?php echo $saleId; ?>'>
                                    <td class='px-4 py-2'>Shovel</td>
                                    <td class='px-4 py-2'>1</td>
                                    <td class='px-4 py-2 text-red-500'>Php300</td>
                                    <td class='px-4 py-2'><button data-open-modal class="hover:font-bold hover:text-blue-500 transition-all">View</button></td>
                        </tbody>
                    </table>

                    <dialog data-modal class="modalPop rounded-lg shadow-xl max-w-[400px] max-h-full elementToFade">

                    <!-- Modal Header -->
                    <div class="w-full bg-green-800 h-10 flex flex-row-2 gap-[120px] text-center justify-end">
                        <span class="text-white text-xl font-semibold p-2">Details</span>
                        <button data-close-modal> <i class="ri-close-fill text-2xl font-bold text-white p-2"></i></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="flex flex-col gap-4 p-8">

                        <div class="flex justify-center items-center">
                        <div class="size-64 flex  rounded-full shadow-lg bg-yellow-200"></div>
                        </div>
                    
                        <div class="mt-2">
                        <div class="flex flex-row justify-between">
                        <div class="text-lg font-semibold">Item Name</div>
                        <div class="text-lg font-semibold">Php 300</div>
                        </div>
                       
                        <div class="text-s text-gray-600">Category</div>
                        </div>

                        <div>
                            <div>From Order ID: <span class="font-bold">#</span></div>
                            <div>Customer Name: <span class="font-bold">Name</span> </div>
                            <div class="text-lg">Reason for Return:</div>
                            <div class="bg-gray-200 rounded-md p-4 shadow-inner">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam sapiente expedita ex sequi, facilis rem?</div>
                        </div>
                  
                        

                    </div>
                    </dialog>
                    
                    <script>
                        document.querySelectorAll('[data-open-modal]').forEach(function(button) {
                            button.addEventListener('click', function() {
                                document.querySelector('[data-modal]').showModal();
                            });
                        });

                        document.querySelectorAll('[data-close-modal]').forEach(function(button) {
                            button.addEventListener('click', function() {
                                document.querySelector('[data-modal]').close();
                            });
                        });
                    </script>



                    <div class="flex flex-col gap-4 justify-start items-start">

                        <div class="bg-white shadow-md text-left size-44 w-64 font-bold p-4 border-gray-200 border rounded-md flex justify-start items-start text-lg">

                            <div class="flex flex-col gap-5">
                                <div class="text-lg font-semibold text-gray-800">
                                    <i class="ri-shake-hands-fill text-lg mx-2"></i> Number of Returns
                                </div>
                                <div class="text-5xl font-semibold ml-5">53</div>
                                <div class="text-sm font-semibold ml-5 text-red-700">+10% more than average</div>
                            </div>

                        </div>

                        <div class="bg-white shadow-md text-left size-44 w-64 font-bold p-4 border-gray-200 border rounded-md flex justify-start items-start text-lg">

                            <div class="flex flex-col gap-5">
                                <div>
                                    <i class="ri-funds-line text-lg mx-2"></i>Money Returned
                                </div>
                                <div class="text-5xl font-semibold ml-5">53</div>
                                <div class="text-sm font-medium ml-5 text-red-700">+10% more than average</div>
                            </div>

                        </div>

                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            // Get the search input value
            var searchValue = this.value.toLowerCase();

            // Get the selected search type
            var searchType = document.getElementById('searchType').value;

            // Get all table rows
            var rows = document.querySelectorAll('#salesTable tbody tr');

            // Loop through the rows
            rows.forEach(function(row) {
                // Get the cell based on the search type
                var cell;
                switch (searchType) {
                    case 'customerName':
                        cell = row.querySelector('td:nth-child(1)');
                        break;
                    case 'saleId':
                        cell = row.querySelector('td:nth-child(2)');
                        break;
                    case 'salePreference':
                        cell = row.querySelector('td:nth-child(4)');
                        break;
                    case 'paymentMode':
                        cell = row.querySelector('td:nth-child(5)');
                        break;
                }

                // If the cell includes the search value, show the row, otherwise hide it
                if (cell.textContent.toLowerCase().includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        document.querySelector('.sidebar-toggle').addEventListener('click', function() {
            document.getElementById('sidebar-menu').classList.toggle('hidden');
            document.getElementById('sidebar-menu').classList.toggle('transform');
            document.getElementById('sidebar-menu').classList.toggle('-translate-x-full');
            document.getElementById('mainContent').classList.toggle('md:w-full');
            document.getElementById('mainContent').classList.toggle('md:ml-64');
        });
    </script>
    <script src="./../src/form.js"></script>
    <script src="./../src/route.js"></script>
</body>

</html>