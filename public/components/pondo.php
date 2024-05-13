<?php require_once __DIR__ . "/finance/functions/pondo/generalPondo.php"?>
<?php require_once __DIR__ . "/finance/functions/pondo/insertPondo.php"?>

<?php 
$department = $_SESSION['user']['role'];
?>

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

    <!-- INCLUDE A SIDEBAR -->

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

            <?php require_once __DIR__ . "/logout/logout.php"?>
            <!-- End: Profile -->

        </div>

        <!-- End: Header -->
            <div class=" mb-6">
                <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-3 gap-6 ">
                    <div class=" col-span-1 bg-gradient-to-b from-[#F8B721] to-[#FBCF68] rounded-xl drop-shadow-md">
                        <div class="mx-5 my-5 py-3 px-3 text-white">
                            <h1 class="text-3xl font-bold">Given Allowance</h1>
                            <p class="mt-5 text-4xl font-medium"><?php echo pondoForEveryone($department);?></p>
                        </div>
                    </div>
                    <div class=" col-span-1 bg-gradient-to-b from-[#F8B721] to-[#FBCF68] rounded-xl drop-shadow-md">
                        <div class="mx-5 my-5 py-3 px-3 text-white">
                            <h1 class="text-3xl font-bold">Total Expenses</h1>
                            <p class="mt-5 text-4xl font-medium"><?php echo getExpensesPondo($department);?></p>
                        </div>
                    </div>
                    <div class=" col-span-1 bg-gradient-to-b from-[#F8B721] to-[#FBCF68] rounded-xl drop-shadow-md">
                        <div class="mx-5 my-5 py-3 px-3 text-white">
                            <h1 class="text-3xl font-bold">Remaining Funds</h1>
                            <p class="mt-5 text-4xl font-medium"><?php echo getRemainingPondo($department);?></p>
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
                        <?php 
                        $db = Database::getInstance();
                        $conn = $db->connect();
                        $stmt = $conn->prepare("SELECT COUNT(*) FROM funds_transaction as ft JOIN employees as e ON ft.employee_id = e.id WHERE department = :department");
                        $stmt->execute();
                        $totalRecords = $stmt->fetchColumn();

                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
                        $displayPerPage = 10;
                        $totalPages = ceil( $totalRecords / $displayPerPage) ;

                        $pondoTable = getAllTransactions($department,$page, $displayPerPage);
                        foreach($pondoTable as $row){
                        ?>
                        <tr>
                            <td class="whitespace-nowrap px-4 py-2 text-gray-700"><?php echo $row['id'];?></td>
                            <td class="whitespace-nowrap px-4 py-2 text-gray-700"><?php echo $row['details']?></td>
                            <td class="whitespace-nowrap px-4 py-2 text-gray-700"><?php echo "₱". number_format($row['amount'], 2)?></td>
                            <td class="whitespace-nowrap px-4 py-2 text-gray-700"><?php echo $row['department']?></td>
                            <td class="whitespace-nowrap px-4 py-2 text-gray-700"><?php echo $row['datetime']?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <ol class="flex justify-end mr-8 gap-1 text-xs font-medium">
            <!-- Next & Previous -->
            <?php if ($page > 1): ?>
                <li>
                    <!-- CHANGE THE ROUTE -->
                    <a route="/fin/funds/Finance=<?= $page - 1 ?>"
                        class="inline-flex size-8 items-center justify-center rounded border border-gray-100 bg-white text-gray-900 rtl:rotate-180">
                        <span class="sr-only">Prev Page</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </li>
            <?php endif; ?>
            <!-- links for pages -->
            <?php 
                $start = max(1, $page - 2);
                $end = min($totalPages, $page + 2);

                for ($i = $start; $i <= $end; $i++): 
            ?>
                <li>
                    <a route="/fin/funds/Finance=<?= $i ?>"
                        class="block size-8 rounded border <?= $i == $page ? 'border-blue-600 bg-blue-600 text-white' : 'border-gray-100 bg-white text-gray-900' ?> text-center leading-8">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <li>
                    <a route="/fin/funds/Finance=<?= $page + 1 ?>"
                        class="inline-flex size-8 items-center justify-center rounded border border-gray-100 bg-white text-gray-900 rtl:rotate-180">
                        <span class="sr-only">Next Page</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </li>
            <?php endif; ?>
        </ol>
    </main>


    <script  src="./../src/route.js"></script>
    <script  src="./../src/form.js"></script>
    <!-- Start: Sidebar -->
    <!-- End: Dashboard -->
</body>

</html>