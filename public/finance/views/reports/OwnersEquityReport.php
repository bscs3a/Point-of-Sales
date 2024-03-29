<?php 
    require_once '../../functions/reportGeneration/OwnersEquityReport.php';
    $today = new DateTime();
    $lastDayOfMonth = new DateTime($today->format('Y-m-t'));

    if ($today < $lastDayOfMonth) {
        $today->modify('-1 month');
    }

    $year = $today->format('Y');
    $month = $today->format('n');
    $monthName = $today->format('F');
    if (isset($_POST['year']) && isset($_POST['month'])){
        $year = $_POST['year'];
        $month = $_POST['month'];
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
        <tfoot>
            <tr>
                <th>Total Equity</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>