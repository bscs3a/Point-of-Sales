<?php 
    require_once 'public/finance/functions/reportGeneration/IncomeReport.php';
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income Report</title>
</head>
<style>
    ul {
        list-style-type: none;  
    }
    header{
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
    }
</style>

<body>
    <header>
        <div>
            <span>Income Statement</span>
            <span>
                <?php echo "$monthName $year"?>    
            </span>
        </div>
        <!-- <img src="..\..\img\logo_reports.png" alt=""> -->
    </header>
    <?php
        // echo generateIncomeReport($year, $month);
    ?>
</body>
</html>