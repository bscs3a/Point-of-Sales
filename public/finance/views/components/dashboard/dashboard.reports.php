
<div id="report_generation_modal" class="modal hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50" aria-labelledby="modal-title"
    role="dialog" aria-modal="true">
    <div class=" pt-4 px-4 pb-20 text-center sm::block sm:p-0 bg-white rounded shadow-lg ">
       
    <form action="/reportGeneration" method="post" class="font-sans p-10 border-2 border-black rounded-md">
            <h2 class="font-semibold text-lg m-1">
                Generate Report
            </h2>
            <p class="italic opacity-50 m-1">
                To generate your report, please choose the type of financial report and specify the date
            </p>

            <label for="report" class="font-medium m-1">
                Type of Report
            </label>
            <select name="file" id="report"
                class="m-1 bg-gray-50 border-2 border-black text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                required>
                <option selected>Choose a report</option>
                <option value="Income">Income Report</option>
                <option value="OwnerEquity">Owners' Equity</option>
                <option value="TrialBalance">Trial Balance</option>
                <option value="CashFlow">Cash Flow</option>
            </select>
            <label for="monthYear" class="font-medium m-1">
                Date
            </label>
            <input type="month" id="monthYear" name="monthYear"
                class="m-1 border-2 bg-gray-50 border-black rounded-lg p-2.5 w-full" required>

            <br>
            <div class="m-1 gap-3 flex justify-end">
                <button id="cancel_btn" class="border-2 rounded-md border-black font-bold py-2.5 px-4 drop-shadow-md" type="button">
                    Cancel
                </button>
                <button class="border-2 rounded-md border-black bg-[#F8B721] font-bold py-2.5 px-4 drop-shadow-md"
                    type="submit">
                    Generate
                </button>
            </div>
        </form>
    </div>
</div>

<!-- for balance and income report -->
<div class="mt-10  h-2/4">
    <!-- Start: Header Report -->
    <div class="my-10 flex justify-between">
        <h1 class="font-sans font-bold text-3xl">Report</h1>
        <button id="generate_modal_btn" class="font-sans font-bold text-2xl ">
            <i class="ri-download-2-line"></i>
            Generate
        </button>
    </div>

    <script>
        // Generate Report Modal
        var report_generation_modal = document.getElementById('report_generation_modal');
        // Get the button that opens the modal
        var generate_modal_btn = document.getElementById('generate_modal_btn');

        // Get the cancel button
        var cancel_btn =document.getElementById('cancel_btn');

        // When the user clicks the button, open the modal
        generate_modal_btn.onclick = function () {
            report_generation_modal.classList.remove('hidden');
        }

        // When the user clicks the cancel button, close the modal
        cancel_btn.onclick = function () {
            report_generation_modal.classList.add('hidden');
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            if (event.target == report_generation_modal) {
                report_generation_modal.classList.add('hidden');
            }
        }
    </script>

    <div class="grid grid-co
    ls-1 md:grid-cols-2 gap-4">
        <?php include_once 'dashboard.reports.income.php' ?>


        <div class="px-5 pt-5 border-solid border-2 border-gray-200 shadow-md rounded-lg">
            <div class="flex justify-between">
                <h2 class="font-sans font-bold text-xl">Balance</h2>
                <!-- <a href="#" class="text-sm font-sans font-semibold">
                    <i class="ri-more-line text-3xl text-[#F8B721]"></i>
                </a> -->
                <div class="font-bold  border-none ">
                    <select name="" id="" class="bg-white border-collapse text-xl">
                        <option value="year" selected>Year</option>
                        <option value="month">Month</option>
                    </select>
                </div>

            </div>
            <!-- Balance Sheet in Pie Graph -->
            <div class="w-full h-3/4 flex justify-center">

                <canvas id="balancePie" class="px-3 py-3"></canvas>
            </div>
        </div>
    </div>



    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Get the context of the canvas element we want to select
        var balancePie = document.getElementById('balancePie').getContext('2d');

        var myBalancePieChart = new Chart(balancePie, {
            type: 'pie',
            data: {
                labels: ['Assets', 'Liabilities'],
                datasets: [{
                    data: [],
                    backgroundColor: ['rgb(255, 165, 0)', 'rgb(255, 205, 86)']
                }]
            },
            options: {
                responsive: true,

                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 20,
                                weight: 'bold'
                            }
                        }
                    }
                },

                layout: {
                    padding: {
                        left: 20,
                        right: 20,
                        top: 0,
                        bottom: 0
                    }
                }
            }

        });

        fetch('http://localhost/Finance/fin/getBalanceReport', {
            method: 'POST',
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data);
            updateBalanceChart(myBalancePieChart, data);
        })
        .catch((error) => {
            console.error('Error:', error);
        });
        //function to update equity Chart
        function updateBalanceChart(chart, paramData) {
            let data = [];

            data.push(paramData.asset);
            data.push(paramData.liability);

            chart.data.datasets[0].data = data;
            chart.update();

            console.log(data);
        }
    </script>
</div>

<!-- Start: Second Section -- for cashflow and equity-->
<div class=" mt-10">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="col-span-1 px-5 pt-5 border-solid border-2 border-gray-200 shadow-md rounded-lg">
            <div class="flex justify-between">
                <h2 class="font-sans font-bold text-xl">Equity</h2>
                <!-- <a href="#" class="text-sm font-sans font-semibold">
                    <i class="ri-more-line text-3xl text-[#F8B721]"></i>
                </a> -->
            </div>
            <?php 
                //equity report sharings
                //year
                $curr_year = date('Y');
                $prev_year = $curr_year - 1;
                
                //month
                $curr_month = date('m');
                
                
                $num_months = 12;
                for ($i=1; $i <= $num_months ; $i++) { 
                    insertAllShares($prev_year, $i);
                    if($curr_month > $i){
                        insertAllShares($curr_year, $i);
                    }
                }

                $CAPITAL = "Capital Accounts";
                $totalCapitalAccount = getTotalOfAccountTypeV2($CAPITAL);
            ?>
            <p class="text-gray-600 my-3 text-lg">Total: <?php echo'₱' . number_format($totalCapitalAccount,2) ?></p>
            <!-- Donut Chart for Equity -->
            <div class="flex justify-center p-5 ">
                <canvas id="equityDonutChart"></canvas>
            </div>
        </div>
        <div class="col-span-2 px-5 pt-5 border-solid border-2 border-gray-200 shadow-md rounded-lg">
            <div class="flex justify-between">

                <h2 class=" font-sans  font-bold text-xl">Cash Flow</h2>
                <!-- <a href="#" class="text-sm font-sans font-semibold">
                    <i class="ri-more-line text-3xl text-[#F8B721]"></i>
                </a> -->
                <div class="font-bold  border-none ">
                    <select name="" id="" class="bg-white border-collapse text-xl">
                        <option value="year" selected>Year</option>
                        <option value="month">Month</option>
                    </select>
                </div>
            </div>
            <div>

                <!-- Create a canvas element -->
                <canvas id="cashFlowChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Donut Chart Equity
        var equityDonut = document.getElementById('equityDonutChart').getContext('2d');

        var equityChart = new Chart(equityDonut, {
            type: 'doughnut',
            data: {
                labels: [], // Initialize with empty array
                datasets: [{
                    data: [], // Initialize with empty array
                    backgroundColor: [],
                    borderWidth: 2
                }]
            },
            options: {
                cutout: '70%',
                responsive: true,
                maintainAspectRatio: true,

                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 15,
                                weight: 'bold'
                            }

                        }
                    }
                },

                layout: {
                    padding: {
                        left: 20,
                        right: 50,
                        top: 50,
                        bottom: 0
                    }
                }

            }
        });
        //ajax for equityChart
        fetch('http://localhost/Finance/fin/getEquityReport', {
            method: 'POST',
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            updateEquityChart(equityChart, data.owners);
        })
        .catch((error) => {
            console.error('Error:', error);
        });
        //function to update equity Chart
        function updateEquityChart(chart, owners) {
            let labels = [];
            let data = [];
            let colors = [];
            for (let key in owners) {
                if (owners[key].dividedShare !== 0) {
                    labels.push(owners[key].name);
                    data.push(owners[key].dividedShare);
                    colors.push(generateRandomColor());
                }
            }
            chart.data.labels = labels;
            chart.data.datasets[0].data = data;
            chart.data.datasets[0].backgroundColor = colors;
            chart.update();
        }

        // generate random color
        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }


        // Initialize a new Chart.js instance
        var cashFlowCanvas = document.getElementById('cashFlowChart').getContext('2d');

        // Configure the chart
        var cashFlowChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Cash Flow',
                    data: [], // Replace with your data
                    backgroundColor: 'rgba(255, 165, 0, 0.4)',
                    fill: true,
                    borderColor: 'rgba(255, 165, 0, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
        //ajax for equityChart
        fetch('http://localhost/Finance/fin/getCashFlowReport', {
            method: 'POST',
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            updateCashFlowChart(cashFlowChart, data.balances);
        })
        .catch((error) => {
            console.error('Error:', error);
        });
        //function to update equity Chart
        function updateCashFlowChart(chart, balances) {
            let labels = [];
            let data = [];
            for (let key in balances) {
                if (balances[key].amount !== 0) {
                    labels.push(getMonthName(key));
                    data.push(balances[key]);
                }
            }
            chart.data.labels = labels;
            chart.data.datasets[0].data = data;
            chart.update();
        }

        function getMonthName(monthNumber) {
            monthNumber = monthNumber - 1; // 0-based index
            var date = new Date(2000, monthNumber); // year doesn't matter
            return date.toLocaleString('default', { month: 'long' });
        }
    </script>

</div>
<!-- End: Second Section -->