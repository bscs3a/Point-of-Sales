<!DOCTYPE html>
<html>

<head>
    <title>Form Test</title>
    <link href="./../src/tailwind.css" rel="stylesheet">
</head>

<body>
    <div id="LoanModal"
        class="fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded shadow-lg w-1/3">
            <div class="border-b pl-3 pr-3 pt-3 flex">
                <h5 class="font-bold uppercase text-gray-600"><?= $results['name'] ?></h5>
                <!-- <button id="closeModal" class="ml-auto text-gray-600 hover:text-gray-800 cursor-pointer">
                                <i class="ri-close-line"></i>
                            </button> -->
            </div>
            <!-- form -->
            <?php $rootFolder = dirname($_SERVER['PHP_SELF']); ?>
            <div class="p-5">
                <!-- <form action="<?= $rootFolder . '/fin/ledger' ?>" method="POST"> -->
                <form action="/addToLoan" method="POST">
                    <input type="hidden" id="ledgerNo" name="ledgerNo" value="9" />
                    <div class="mb-4 relative">
                        <label for="description" class="block text-xs font-medium text-gray-900">
                            Description
                        </label>
                        <input type="text" id="description" name="description" required
                            class="mt-1 py-1 px-3 w-full rounded-md border border-gray-400 shadow-md sm:text-sm" />

                    </div>
                    <div class="mb-4 relative">
                        <label for="amount" class="block text-xs font-medium text-gray-900"> Amount
                        </label>
                        <input type="text" id="amount" name="amount" placeholder="0.00" required
                            class="mt-1 py-1 px-7 w-full rounded-md border border-gray-400 shadow-md sm:text-sm"
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                        <span class="absolute left-2 top-6 transform -translate-y-0.5 text-gray-400">&#8369;</span>
                    </div>


                    <?php
                    $db = Database::getInstance();
                    $conn = $db->connect();

                    $query = "SELECT name FROM ledger";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();

                    ?>
                    <div class="mb-4 relative">
                        <label for="ledgerName" class="block text-xs font-medium text-gray-900">
                            Category
                        </label>
                        <select name="ledgerName" id="ledgerName"
                            class="mt-1 py-1 px-2 w-full rounded-md border border-gray-400 shadow-md sm:text-sm">
                            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                <option value="<?= $row['name'] ?>"><?= $row['name'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="flex justify-end items-start mb-2">
                        <button id="cancelLoanModal<?= $id ?>" type="button"
                            class="border border-gray-700 bg-gray-200 hover:bg-gray-100 text-gray-800 text-sm font-bold py-1 px-5 rounded-md ml-4 ">Cancel</button>
                        <button type="submit"
                            class="border border-gray-700 bg-amber-400 hover:bg-amber-300 text-gray-800 text-sm font-bold py-1 px-7 rounded-md ml-4 ">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- <form action="/fin/test" class="flex-col">
        <input type="text" id="ledgerNo" name="ledgerNo" placeholder="Description" value="9"><br>
        <input type="text" id="date" name="date" placeholder="Date"><br>
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
        <input type="text" id="description" name="description" placeholder="Description"><br>
        <input type="text" id="amount" name="amount" placeholder="Amount"><br>
        <select id="category" name="category"><br><br>
            <?php
            // $db = Database::getInstance();
            // $conn = $db->connect();
            
            // $sql = "SELECT * FROM ledger";
            // $stmt = $conn->prepare($sql);
            
            // $stmt->execute();
            
            // echo "<option value=\"choose\" selected=\"selected\">...</option>";
            
            // if ($stmt->rowCount() > 0) {
            //     // output data of each row
            //     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            //         echo "<option value=\"{$row['ledgerno']}\">{$row['name']}</option>";
            //     }
            // } else {
            //     echo "0 results";
            // }
            ?>
        </select>


        <input type="submit" value="Submit"><br>
    </form> -->




    <script src="./../src/form.js"></script>
    <script src="./../src/route.js"></script>
</body>

</html>