<?php


$db = Database::getInstance();
$pdo = $db->connect();


$curr_year = date('Y');
$prev_year = $curr_year - 1;
// $curr_year = '2023';
$start_curr_year = $curr_year."-01-01";
$end_curr_year = $curr_year."-12-31";
$sql = "SELECT  * FROM IncomeStatement WHERE created_at BETWEEN :start_curr_year AND :end_curr_year ORDER BY created_at";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':start_curr_year', $start_curr_year);
$stmt->bindParam(':end_curr_year', $end_curr_year);
$stmt->execute();


$monthlyData = array();
$netSales = "0";

if ($stmt->rowCount() > 0) {
    $i = 0;
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $month = date('m', strtotime($row['created_at']));
        $monthlyData[$month] = $row['NetIncome'];
        // $monthlyData[$i] = $row;
        // $i += 1;
    }

    // $stmt->fetch(PDO::FETCH_ASSOC);

}

$start_prev_year = $prev_year."-01-01";
$end_prev_year = $prev_year."-12-31";
$sql = "SELECT  * FROM IncomeStatement WHERE created_at BETWEEN :start_prev_year AND :end_prev_year ORDER BY created_at";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':start_prev_year', $start_prev_year);
$stmt->bindParam(':end_prev_year', $end_prev_year);
$stmt->execute();


$prevMonthlyData = array();
$prevNetSales = "0";

if ($stmt->rowCount() > 0) {
    $i = 0;
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $month = date('m', strtotime($row['created_at']));
        $prevMonthlyData[$month] = $row['NetIncome'];
        // $monthlyData[$i] = $row;
        // $i += 1;
    }

    // $stmt->fetch(PDO::FETCH_ASSOC);

}

$netIncome = implode(', ', $monthlyData);
$prevNetIncome = implode(',', $prevMonthlyData);

$sql = "SELECT SUM(NetIncome) AS NetSales FROM IncomeStatement WHERE created_at BETWEEN :start_curr_year AND :end_curr_year ORDER BY created_at";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':start_curr_year', $start_curr_year);
$stmt->bindParam(':end_curr_year', $end_curr_year);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$netSales = $row['NetSales'];

$sql = "SELECT SUM(NetIncome) AS PrevNetSales FROM IncomeStatement WHERE created_at BETWEEN :start_prev_year AND :end_prev_year ORDER BY created_at";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':start_prev_year', $start_prev_year);
$stmt->bindParam(':end_prev_year', $end_prev_year);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$prevNetSales = $row['PrevNetSales'];



?>

<div class="px-3 pt-5 border-solid border-2 border-gray-200 shadow-md rounded-lg">

    <div class="flex justify-between">
        <h2 class="font-sans font-bold text-xl">Income Statement</h2>
        <!-- <a href="#" class="text-sm font-sans font-semibold">
                    <i class="ri-more-line text-3xl text-[#F8B721]"></i>
                </a> -->
        <!-- <div class="font-bold  border-none ">
            <select name="yearly_income" id="" class="bg-white border-collapse text-xl">
                <option value="year" selected>Year</option>
                <option value="previous_year">Last Year</option>
            </select>
        </div> -->

    </div>
    <?php 
        // echo date('Y');
        // echo count($monthlyData);
    ?>
    

    <p class="text-gray-600 my-3 text-lg ">Current Net Sales: <?= number_format($netSales,2)?></p>
    <p class="text-gray-600 my-3 text-lg ">Previous Net Sales: <?= number_format($prevNetSales,2)?></p>
    <canvas id="incomeBarChart"></canvas>

</div>


<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // get the canvas id of incomeBarChart
    var incomeBar = document.getElementById('incomeBarChart').getContext('2d');

    // Configure the chart
    var myChart = new Chart(incomeBar, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [
                {
                label: 'Currnet Year',
                // data: [12000, 19000, 3000, 5000, 2000, 3000, 7000, 8000, 9000, 10000, 11000, 12000], // Replace with your income data
                data: [<?= $netIncome?>], // Replace with your income data
                backgroundColor: ['#F8B721'],

                borderColor: 'rgba(255, 165, 0, 1)',
                // borderColor: 'rgba(248, 183, 33, 1)',

                // rgba(255, 165, 0, 0.2),
                //F8B721 orange
                // F6D95D pale orange
                borderWidth: 1
            }, 
            {
                label: 'Last Year',
                // data: [12000, 19000, 3000, 5000, 2000, 3000, 7000, 8000, 9000, 10000, 11000, 12000], // Replace with your income data
                data: [<?= $prevNetIncome?>], // Replace with your income data
                
                backgroundColor: ['#F6D95D'],
                // backgroundColor: ['#F8B721', '#F6D95D'],

                // borderColor: 'rgba(255, 165, 0, 1)',
                borderColor: 'rgba(248, 183, 33, 1)',

                // rgba(255, 165, 0, 0.2),
                //F8B721 orange
                // F6D95D pale orange
                borderWidth: 1
            }
        ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
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
                    top: 50,
                    bottom: 0
                }

            }
        }
    });


    myChart.data.datasets.data
</script>