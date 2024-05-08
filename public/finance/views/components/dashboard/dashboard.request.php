<!-- Start: Request Section -->
<div class="mt-10  grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Start: Request -->
    <div class="px-5 border-2 border-solid border-gray-300 shadow-lg">
        <!-- Start: Header -->
        <div class="flex justify-between mt-5 ">
            <div>
                <h1 class="font-sans text-xl font-bold">
                    Request
                    <span class="text-white bg-[#F8B721] inline-flex items-center rounded-full px-2 py-1">99+</span>
                </h1>

            </div>
            <div>
                <a href="#" class="text-sm font-sans font-semibold">
                    <i class="ri-more-line text-3xl text-[#F8B721]"></i>
                </a>
            </div>
        </div>
        <!-- End: Header -->
        <!-- Start: Tab -->
        <div class="flex justify-stretch overflow-x-auto hide-scrollbar">
            <button
                class="btn btn_dept btn_active flex-grow px-10 py-2 font-xl font-semibold text-[#F8B721] border-b-2 border-[#F8B721] focus:outline-none" id="btn1">All</button>
            <button
                class="btn btn_dept flex-grow px-10 py-2 font-xl font-semibold text-black border-b-2 border-slate-300  hover:text-[#F8B721] hover:border-[#F8B721] focus:outline-none" id="btn2">HR</button>
            <button
                class="flex-grow px-10 py-2 font-xl font-semibold text-black border-b-2 border-slate-300  hover:text-[#F8B721] hover:border-[#F8B721] focus:outline-none">Sales</button>
            <button
                class="flex-grow px-10 py-2 font-xl font-semibold text-black border-b-2 border-slate-300  hover:text-[#F8B721] hover:border-[#F8B721] focus:outline-none">PO</button>
            <button
                class="flex-grow px-10 py-2 font-xl font-semibold text-black border-b-2 border-slate-300  hover:text-[#F8B721] hover:border-[#F8B721] focus:outline-none">Delivery</button>
            <button
                class="flex-grow px-10 py-2 font-xl font-semibold text-black border-b-2 border-slate-300  hover:text-[#F8B721] hover:border-[#F8B721] focus:outline-none">Inventory</button>
        </div>
        <!-- End: Tab -->

        <script>
            var buttons = document.getElementsByClassName('btn_dept');

            for (var i = 0; i < buttons.length; i++) {
                // console.log(i);
                buttons[i].addEventListener('click', function () {
                    var current_btn_dept = document.getElementsByClassName('btn_active');

                    // If there's an active button, remove its active class
                    if (current_btn_dept.length > 0) {
                        current_btn_dept[0].classList.remove('btn_active');
                        // this.classList.remove(' text-[#F8B721] border-[#F8B721]');
                        // this.classList.add('text-black border-slate-300');
                    }
                    
                    // Add the active class to the current/clicked button
                    this.classname += ' btn_active text-[#F8B721] border-[#F8B721]';

                    // for (var j = 0; j < buttons.length; j++) {
                    //     if (buttons[j].classList.contains('btn_active')) {
                    //         buttons[j].classList.remove('btn_active');
                    //     }
                    // }
                    // this.classList.add('btn_active');
                });
            }
        </script>

        <!-- Start: Table -->
        <div class="table" id="table1">
            <table class="table-fixed my-5 w-full" id="table_request">
                <tr class="flex justify-between py-5 font-medium text-xl">
                    <td class="mr-4 text-xl">
                        <p class="font-semibold">Sample User</p>
                        <p>HR Dept</p>
                    </td>

                    <td class="mr-4 line-clamp-2">
                        <p>Salary Request</p>
                    </td>

                    <td class="mr-4 line-clamp-2">
                        <p>March 4, 2024</p>
                    </td>
                    <td class="mr-4">
                        <button class="bg-[#F8B721] rounded-lg px-8 py-3 shadow-md shadow-black-300">
                            <p class="text-white text-lg font-bold ">View</p>
                        </button>
                    </td>
                </tr>

            </table>

        </div>

        <!-- <div class="table " id="table2">
            <table class="table-fixed my-5 w-full" id="table_request">
                <tr class="flex justify-between py-5 font-medium text-xl">
                    <td class="mr-4 text-xl">
                        <p class="font-semibold">HAHAH User</p>
                        <p>HR Dept</p>
                    </td>

                    <td class="mr-4 line-clamp-2">
                        <p>Salary Request</p>
                    </td>

                    <td class="mr-4 line-clamp-2">
                        <p>March 4, 2024</p>
                    </td>
                    <td class="mr-4">
                        <button class="bg-[#F8B721] rounded-lg px-8 py-3 shadow-md shadow-black-300">
                            <p class="text-white text-lg font-bold ">View</p>
                        </button>
                    </td>
                </tr>

            </table>

        </div> -->
        <script>

            var buttons = document.getElementsByClassName('.btn');
            var tables = document.getElementsByClassName('.table');


            for (var i = 0; i < buttons.length; i++) {
                buttons[i].addEventListener('click', function () {
                    var tableId = this.id.replace('btn', 'table');
                    for (var j = 0; j < tables.length; j++) {
                        if (tables[j].id === tableId) {
                            tables[j].style.display = 'block';
                        } else {
                            tables[j].style.display = 'none';
                        }
                    }
                });
            }

            let table_request = document.getElementById('table_request');

            for (let index = 0; index < 2; index++) {
                table_request.innerHTML += `
                                <tr class="flex justify-between py-5 font-medium text-xl">
                                <td class="mr-4 text-xl">
                                    <p class="font-semibold">Sample User</p>
                                    <p>HR Dept</p>
                                </td>

                                <td class="mr-4 line-clamp-2">
                                    <p>Salary Request</p>
                                </td>

                                <td class="mr-4 line-clamp-2">
                                    <p>March 4, 2024</p>
                                </td>
                                <td class="mr-4">
                                    <button class="bg-[#F8B721] rounded-lg px-8 py-3 shadow-md shadow-black-300">
                                        <p class="text-white text-lg font-bold ">View</p>
                                    </button>
                                </td>
                            </tr>
                                `;

            }
        </script>
        <!-- End: Table -->
    </div>
    <!-- End: Request -->

    <!-- Start: Salary Request -->
    <div class="px-5 border-2 border-solid border-gray-300 shadow-lg flex flex-col">
        <!-- Start: Header -->
        <div class="flex justify-between mt-5 ">
            <div>
                <h1 class="font-sans text-xl font-bold">
                    General Ledger
                </h1>
            </div>
        </div>
        <!-- End: Header -->
        <div class="h-full">
            <table class="table-fixed my-5 w-full text-center border-spacing-y-4" id="general_ledger">
                <thead class="text-xl font-semibold">
                    <td>Date</td>
                    <td>Amount</td>
                    <td>Debit</td>
                    <td>Credit</td>
                </thead>
                <tbody>                
                <?php $transaction = getLedgerTransactions(10); ?>                
                <?php foreach ($transaction as $trans){ ?>
                    <tr class="text-md font-medium">
                        <td><?php echo $trans['DateTime']?></td>
                        <td><?php echo $trans['amount']?></td>
                        <td><?php echo $trans['dr_name']?></td>
                        <td><?php echo $trans['cr_name']?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>


        <div class="text-center mb-5">
            <button class="border-2 border-[#F8B721] w-full text-[#F8B721] py-2 px-2 font-bold text-xl hover:text-slate-100 hover:bg-[#F8B721] transition-colors">
                <p> <i class="ri-add-line"> </i> New Transaction</p>
            </button>
        </div>
    </div>
    <!-- End: Salary Request -->

</div>
<!-- End: Request Section -->