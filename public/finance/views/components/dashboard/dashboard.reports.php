<div class="mt-10  h-2/4">
    <!-- Start: Header Report -->
    <div class="my-10 flex justify-between">
        <h1 class="font-sans font-bold text-3xl">Report</h1>
        <button class="font-sans font-bold text-2xl ">
            <i class="ri-download-2-line"></i>
            Generate
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
            <p class="text-gray-600 my-3 text-lg">Total: 0</p>
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

        var myPieChart = new Chart(balancePie, {
            type: 'pie',
            data: {
                labels: ['Asstes', 'Liabilities'],
                datasets: [{
                    data: [20, 30],
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


    </script>
</div>

<!-- Start: Second Section -->
<div class=" mt-10">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="col-span-1 px-5 pt-5 border-solid border-2 border-gray-200 shadow-md rounded-lg">
            <div class="flex justify-between">
                <h2 class="font-sans font-bold text-xl">Equity</h2>
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
            <p class="text-gray-600 my-3 text-lg">Total: 0</p>
            <!-- Donut Chart for Equity -->
            <div class="flex justify-center w-3/4">
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
                <canvas id="salesGrowthChart"></canvas>
            </div>
        </div>
    </div>

    <script>

        // Donut Chart Equity
        var equityDonut = document.getElementById('equityDonutChart').getContext('2d');

        var myChart = new Chart(equityDonut, {
            type: 'doughnut',
            data: {
                labels: ['Equity1', 'Equity2', 'Equity3'],
                datasets: [{
                    data: [10, 20, 30], // Replace with your equity data
                    backgroundColor: ['rgba(255, 165, 0, 0.5)', 'rgba(255, 165, 0, 0.7)', 'rgba(255, 165, 0, 0.9)'],
                    borderWidth: 2
                }]
            },
            options: {
                cutout: '70%',
                responsive: true,
                maintainAspectRatio: true,

                plugins: {
                    legend: {
                        position: 'left',
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
                        right: 50,
                        top: 50,
                        bottom: 0
                    }
                }

            }
        });

        // Initialize a new Chart.js instance
        var ctx = document.getElementById('salesGrowthChart').getContext('2d');

        // Configure the chart
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: 'Sales Growth',
                    data: [12, 19, 3, 5, 2, 3, 7], // Replace with your data
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
    </script>

</div>
<!-- End: Second Section -->