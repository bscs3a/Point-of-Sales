<?php 
    require_once 'public\finance\functions\reportGeneration\CashFlow.php';
    $today = new DateTime();
    $lastDayOfMonth = new DateTime($today->format('Y-m-t'));

if ($today < $lastDayOfMonth) {
    $today->modify('-1 month');
}

    $year = $today->format('Y');
    $month = $today->format('n');
    if (isset($_SESSION['postdata']['year']) && isset($_SESSION['postdata']['month'])){
        $year = $_SESSION['postdata']['year'];
        $month =$_SESSION['postdata']['month'];
    }

    $year = intval($year);
    $month = intval($month);
    $monthName = date('F', mktime(0, 0, 0, $month, 10));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trial Balance</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Russo+One&display=swap" rel="stylesheet">
    <link href="<?php echo $_SERVER["DOCUMENT_ROOT"].'/public\finance\views\reports\reports.css';?>"/>
</head>
<style>
    *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Monsterrat", sans-serif;
}
body{
    padding: 1.5rem;
}
table{
    width: 100%;
    border-collapse: collapse;
    margin: 1rem 0;
    font-size: 1rem;
    font-weight: 500;
}

.text-right{
    text-align: right;
}

.width-auto-wrap{
    white-space: nowrap;
    width: 1%;
}

.header1{
    font-size: 3rem;
    font-family: "Russo One", sans-serif;
}

.header2{
    font-size: 1.5rem;
    font-weight: bold;
}

.headerPartner{
    font-size: 0.75rem;
    color: #8D8B8B;
}

section > table tr > td{
    padding: 1rem;
}

thead > tr {
    border-radius: 10px; 
    overflow: hidden;
    background-color: #FFD168;
    box-shadow: 0 4px 1px #00000040;
}

thead > tr > th{
    text-align: left;
    padding: 1rem;
    border-radius: 10px; 
    font-weight: 600;
}

.content{
    text-indent: 2rem;
}

.content-amount{
    text-align: right;
}

tfoot{
    color: #262261;
    font-weight: bold;
}
</style>

<body>
    <header>
        <table>
            <tr>
                <td class="header2">Trial Balance</td>
                <td rowspan="2" class="text-right width-auto-wrap">
                    <?php 
                        $image = file_get_contents('public/finance/img/logo_reports.png');
                        $image = base64_encode($image);
                    ?>
                    <img src="data:image;base64,<?= $image?>"/>
                </td>
                <td class="header1 text-right width-auto-wrap">BSCS 3A</td>
            </tr>
            <tr>
                <td class ="headerPartner"><?php echo "For the month end: $monthName $year" ?></td>
                <td class="headerPartner text-right width-auto-wrap">Hardware Management Store</td>
            </tr>
        </table>
    </header>
    <main>
        <canvas id="imageHere" class="px-3 py-3"></canvas>
        <div id="content">

        </div>
    </main>

    <script>
    // Get the context of the canvas element we want to select
        var balancePie = document.getElementById('balancePie').getContext('2d');

        var myBalancePieChart = new Chart(balancePie, {
            type: 'pie',
            data: {
                labels: ['Assets', 'Liabilities'],
                datasets: [{
                    data: [0.93, 0.07],
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

        // fetch('http://localhost/Finance/fin/getBalanceReport', {
        //     method: 'POST',
        // })
        // .then(response => {
        //     if (!response.ok) {
        //         throw new Error('Network response was not ok');
        //     }
        //     return response.json();
        // })
        // .then(data => {
        //     updateBalanceChart(myBalancePieChart, data);
        // })
        // .catch((error) => {
        //     console.error('Error:', error);
        // });
        // //function to update equity Chart
        // function updateBalanceChart(chart, paramData) {
        //     let data = [];

        //     data.push(paramData.asset);
        //     data.push(paramData.liability);

        //     chart.data.datasets[0].data = data;
        //     chart.update();
        // }

        chartInstance.options.animation.onComplete = function() {
            var url = chartInstance.toBase64Image();

            // Create a new image element
            var img = new Image();

            // Set the image source to the data URL
            img.src = url;

            // Insert the image into the HTML content
            document.getElementById('content').appendChild(img);
        };
    </script>
</body>

</html>