<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Trail</title>
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
                    <p class="text-black font-medium">Sales / Audit Trail</p>
                </li>

            </ul>

          
            <!-- End: Active Menu -->

            <!-- Start: Profile -->

            <ul class="ml-auto flex items-center">

            <button class="p-2 px-4 rounded-full mx-4 bg-gray-200 justify-end hover:bg-green-800 transition-colors hover:text-white shadow-inner">Clock In</button>

                <div class="relative inline-block text-left">
                     <div>
                        <a class="inline-flex justify-between w-full px-4 py-2 text-sm font-medium text-black bg-white rounded-md shadow-sm border-b-2 transition-all hover:bg-gray-200 focus:outline-none hover:cursor-pointer" id="options-menu" aria-haspopup="true" aria-expanded="true">
                            <div class="text-black font-medium mr-4 ">
                            <i class="ri-user-3-fill mx-1"></i> <?= $_SESSION['employee_name']; ?>
                            </div>
                            <i class="ri-arrow-down-s-line"></i>
                        </a>
                    </div>

                    <div class="origin-top-right absolute right-0 mt-4 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden" id="dropdown-menu" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                        <div class="py-1" role="none">
                            <a route="/sls/logout" class="block px-4 py-2 text-md text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                                <i class="ri-logout-box-line"></i>
                                Logout
                            </a>
                        </div>
                    </div>
                </div>

                <script>
                    document.getElementById('options-menu').addEventListener('click', function() {
                        var dropdownMenu = document.getElementById('dropdown-menu');
                        if (dropdownMenu.classList.contains('hidden')) {
                            dropdownMenu.classList.remove('hidden');
                        } else {
                            dropdownMenu.classList.add('hidden');
                        }
                    });
                </script>
            </ul>

            <!-- End: Profile -->

        </div>

        <!-- End: Header -->
        <div class="flex flex-col items-center min-h-screen">
            <!-- Start: Audit Trail Table -->
            <div class="w-full max-w-6xl mt-10">
                <h1 class="mb-3 text-xl font-bold text-black">Audit Trail</h1>
                <table class="table-auto w-full mx-auto text-left rounded-lg overflow-hidden shadow-lg">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 font-semibold">ID</th>
                            <th class="px-4 py-2 font-semibold">Employee Name</th>
                            <th class="px-4 py-2 font-semibold">Action</th>
                            <th class="px-4 py-2 font-semibold">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once './src/dbconn.php';
                        $database = Database::getInstance();
                        $pdo = $database->connect();

                        // Query for the audit trail
                        $sqlAuditTrail = "SELECT * FROM tbl_sls_audit ORDER BY log_date DESC";
                        $stmtAuditTrail = $pdo->query($sqlAuditTrail);
                        $auditTrails = $stmtAuditTrail->fetchAll(PDO::FETCH_ASSOC);

                        // Display the audit trail in the table
                        foreach ($auditTrails as $trail) {
                            echo "<tr class='border border-gray-200 bg-white'>";
                            echo "<td class='px-4 py-2'>" . $trail['id'] . "</td>";
                            echo "<td class='px-4 py-2'>" . $trail['employee_name'] . "</td>";
                            echo "<td class='px-4 py-2'>" . $trail['log_action'] . "</td>";
                            echo "<td class='px-4 py-2'>" . date("F j, Y, g:i a", strtotime($trail['log_date'])) . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- End: Audit Trail Table -->
        </div>
    </main>
    <script>
        document.querySelector('.sidebar-toggle').addEventListener('click', function() {
            document.getElementById('sidebar-menu').classList.toggle('hidden');
            document.getElementById('sidebar-menu').classList.toggle('transform');
            document.getElementById('sidebar-menu').classList.toggle('-translate-x-full');
            document.getElementById('mainContent').classList.toggle('md:w-full');
            document.getElementById('mainContent').classList.toggle('md:ml-64');
        });
    </script>
    <script src="./../src/route.js"></script>
</body>

</html>