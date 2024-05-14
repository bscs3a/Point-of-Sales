<?php require_once "public/finance/functions/pondo/generalPondo.php"?>
<?php require_once "public/finance/functions/pondo/insertPondo.php"?>

<?php 
$department ="Delivery";
$db = Database::getInstance();
$conn = $db->connect();
$stmt = $conn->prepare("SELECT COUNT(*) FROM funds_transaction as ft JOIN employees as e ON ft.employee_id = e.id WHERE department = :department");
$stmt->bindParam(':department', $department);
$stmt->execute();
$totalRecords = $stmt->fetchColumn();

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$displayPerPage = 10;
$totalPages = ceil( $totalRecords / $displayPerPage) ;

$remainingPondo = getRemainingPondo($department)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- for adding transaction -->
    <div class="w-full px-6 py-3 bg-white">
                <div class="justify-between items-start">
                    <!-- Button -->
                    <div class="flex justify-end">
                        <div class="items-start mb-2">
                            <button id="openModal"
                                class="bg-gray-200 hover:bg-gray-300 text-gray-900 font-medium text-sm py-1 px-3 rounded-lg border border-gray-500">
                                <i class="ri-add-box-line"></i>
                                New Transactions
                            </button>
                        </div>
                    </div>


                    <!-- Modal -->
                    <div id="myModal"
                        class="modal hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50">
                        <div class="bg-white rounded shadow-lg w-1/3">
                            <div class="border-b pl-3 pr-3 pt-3 flex">
                                <h5 class="font-bold uppercase text-gray-600">New Transactions</h5>
                            </div>
                            <!-- form -->
                            <div class="p-5">
                                <form action="/pondo/transaction" method="POST">
                                    <div class="mb-4 relative">
                                        <label for="date" class="block text-xs font-medium text-gray-900"> Date </label>
                                        <input type="text" id="date" name="date" required readonly
                                            class="mt-1 py-1 px-7 w-full rounded-md border border-gray-400 shadow-md  sm:text-sm" />
                                        <i
                                            class="ri-calendar-fill absolute left-2 top-6 transform -translate-y-0.5 h-6 w-6 text-gray-400"></i>
                                    </div>

                                    <script>
                                        var today = new Date();
                                        var dd = String(today.getDate()).padStart(2, '0');
                                        var monthNames = ["January", "February", "March", "April", "May", "June",
                                            "July", "August", "September", "October", "November", "December"];
                                        var mm = monthNames[today.getMonth()]; //January is 0!
                                        var yyyy = today.getFullYear();

                                        today = mm + ' ' + dd + ', ' + yyyy;
                                        document.getElementById('date').value = today;
                                    </script>
                                    <div class="mb-4 relative">
                                        <label for="employee_id" class="block text-xs font-medium text-gray-900">
                                            EmployeeID
                                        </label>
                                        <input type="text" id="employee_id" name="employee_id" required readonly
                                            class="mt-1 py-1 px-3 w-full rounded-md border border-gray-400 shadow-md sm:text-sm" value = "<?php echo $_SESSION['user']['employee_id']?>"/>
                                    </div>
                                    <div class="mb-4 relative">
                                        <label for="amount" class="block text-xs font-medium text-gray-900"> Amount
                                        </label>
                                        <input type="text" id="amount" name="amount" placeholder="0.00" required
                                            class="mt-1 py-1 px-7 w-full rounded-md border border-gray-400 shadow-md sm:text-sm"
                                            onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46"
                                            oninput="validateInput(this, <?php echo $remainingPondo?>)" />

                                        <script>
                                        function validateInput(input, limit) {
                                            var value = parseFloat(input.value);
                                            if (isNaN(value) || value <= limit) {
                                                input.setCustomValidity('Please enter a number greater than ' + limit);
                                            } else {
                                                input.setCustomValidity('');
                                            }
                                        }
                                        </script>
                                        <span
                                            class="absolute left-2 top-6 transform -translate-y-0.5 text-gray-400">&#8369;</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <div class="mb-4 relative p-1 grow">
                                            <label for="payFor" class="block text-xs font-medium text-gray-900"> Pay For: </label>
                                            <select id="payFor" name="payFor" required class="mt-1 py-1 px-3 w-full rounded-md border border-gray-400 shadow-md sm:text-sm">
                                                <option value="" selected>...</option>
                                                <?php
                                                    $validDebit = validDebit();
                                                    foreach($validDebit as $row){
                                                        echo "<option value='".$row['ledgerno']."'>".$row['name']."</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="mb-4 relative p-1 grow">
                                            <label for="payUsing" class="block text-xs font-medium text-gray-900"> Pay Using: </label>
                                            <select id="payUsing" name="payUsing" required class="mt-1 py-1 px-3 w-full rounded-md border border-gray-400 shadow-md sm:text-sm">
                                                <option value="" selected>...</option>
                                                <?php 
                                                $validCredit = validCredit();
                                                foreach($validCredit as $row){
                                                    echo "<option value='".$row['ledgerno']."'>".$row['name']."</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="flex justify-end items-start mb-2">
                                        <button id="cancelModal" type="button"
                                            class="border border-gray-700 bg-gray-200 hover:bg-gray-100 text-gray-800 text-sm font-bold py-1 px-5 rounded-md ml-4 ">Cancel</button>
                                        <button type="submit"
                                            class="border border-gray-700 bg-amber-400 hover:bg-amber-300 text-gray-800 text-sm font-bold py-1 px-7 rounded-md ml-4 ">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- JavaScript -->

                    <script>
                        function closeModalAndClearInputs() {
                            document.getElementById('myModal').classList.add('hidden');
                            ['description', 'credit', 'debit', 'amount'].forEach(id => document.getElementById(id).value = '');
                        }

                        document.getElementById('openModal').addEventListener('click', function () {
                            document.getElementById('myModal').classList.remove('hidden');
                        });
                        //'closeModal',
                        ['cancelModal'].forEach(id => {
                            document.getElementById(id).addEventListener('click', function (event) {
                                event.stopPropagation();
                                closeModalAndClearInputs();
                            });
                        });
                    </script>
                </div>
            </div>
        <script src="./../src/route.js"></script>
        <script src="./../src/form.js"></script>
</body>
</html>