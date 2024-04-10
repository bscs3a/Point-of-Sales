<?php 
    // require_once '../../functions/reportGeneration/OwnersEquityReport.php';
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
    <title>Owner/s' Equity Report</title>
</head>
<body>
    <header>
        <div>
            <span>Owner/s' Equity Report</span>
            <span>
                <?php echo "$monthName $year"?>    
            </span>
        </div>
        <img src="..\..\img\logo_reports.png" alt="">
    </header>
    <table>
        <thead>
            <tr>
                <th>Investor</th>
                <th>Investment Last Month</th>
                <th>Additional Investment</th>
                <th>Net Income/Loss</th>
                <th>Withdrawals</th>
                <th>Ending Balance</th>
            </tr>
        </thead>
        <?php echo generateOEReport($year, $month);?>
    </table>
</body>
</html>