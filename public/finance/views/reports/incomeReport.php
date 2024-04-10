<?php 
    // require_once '../../functions/reportGeneration/IncomeReport.php'; -- might change into ajax
    $today = new DateTime();
    $lastDayOfMonth = new DateTime($today->format('Y-m-t'));

if ($today < $lastDayOfMonth) {
    $today->modify('-1 month');
}

    $year = $today->format('Y');
    $month = $today->format('n');
    $monthName = $today->format('F');
    if (isset($_SESSION['postdata']['year']) && isset($_SESSION['postdata']['month'])){
        $year = $_SESSION['postdata']['year'];
        $month =$_SESSION['postdata']['month'];
    }

    $year = intval($year);
    $month = intval($month);
    echo $month;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income Report</title>
    <style>
        ul {
            list-style-type: none;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }
    </style>
</head>


<body>
    <header>
        <div>
            <span style="font-weight: bold; font-size: 2em;">Income Statement</span>
            <br>
            <span style="font-weight: bold; opacity: 0.5; font-size: 1.17em;">
                <?php echo "$monthName $year" ?>
            </span>
            <span>
                <table style="width: 100%; border-spacing: 0;">
                    <tr style="background-color: #FFEEA5; ">
                        <th>Assets</th>
                        <th>(Dr) Amount</th>
                    </tr>
                    <tr>
                        <td>Fixed Assets</td>
                        <td style="text-align: right;">0</td>
                    </tr>
                    <tr>
                        <td>Current Assets</td>
                        <td style="text-align: right;">Dr 0</td>
                    </tr>
                    <tr>
                        <td>Investments</td>
                        <td style="text-align: right;">0</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Total Assets</td>
                        <td style="text-align: right; font-weight: bold;">0</td>
                    </tr>
                </table>
            </span>

        </div>
        <div>

        </div>
        <!-- <img src="..\..\img\logo_reports.png" alt=""> -->
    </header>
    <?php
        // echo generateIncomeReport($year, $month);
    ?>


</body>

</html>