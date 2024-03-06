<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <link href="./../src/tailwind.css" rel="stylesheet">
</head>

<body>
    <div class="flex flex-col items-center min-h-screen">
        <div class="w-full max-w-6xl mt-10">
            <div class="flex justify-between items-center">
                <h1 class="mb-3 text-xl font-bold text-black">Transaction History</h1>
                <div class="relative mb-3">
                    <input type="text" placeholder="Search by ID..." class="px-3 py-2 pl-5 pr-10 border rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-6a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
            <table class="table-auto w-full mx-auto text-left rounded-lg overflow-hidden shadow-lg">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 font-semibold">Name</th>
                        <th class="px-4 py-2 font-semibold">Order ID</th>
                        <th class="px-4 py-2 font-semibold">Address</th>
                        <th class="px-4 py-2 font-semibold">Total Amount</th>
                        <th class="px-4 py-2 font-semibold">Delivery Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border border-gray-200 bg-white" onclick="location.href='/Master/sls/transaction-details'" style="cursor: pointer;">
                        <td class="px-4 py-2">John Doe</td>
                        <td class="px-4 py-2">123456</td>
                        <td class="px-4 py-2">123 Main St, Anytown, USA</td>
                        <td class="px-4 py-2">&#8369;1500.00</td>
                        <td class="px-4 py-2">Delivered</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <button onclick="location.href='/Master/sls/sample'"
            class="px-4 py-2 mt-4 text-white bg-black rounded">Go to Sales</button>
    </div>
</body>

</html>