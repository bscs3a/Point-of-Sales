<?php 
    // require_once 'public/finance/functions/reportGeneration/OwnersEquityReport.php';
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner/s' Equity Report</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Russo+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="ownerReport.css">
</head>

<body>
    <header>
        <table>
            <tr>
                <td class="header2">Income Statement</td>
                <td rowspan="2" class="text-right width-auto-wrap">
                    <!-- <img src="<?php echo $_SERVER["DOCUMENT_ROOT"].'/public/finance/img/logo_reports.png';?>"/> -->
                    <img src="../../img/logo_reports.png" alt="">
                </td>
                <td class="header1 text-right width-auto-wrap">BSCS 3A</td>
            </tr>
            <tr>
                <td class ="headerPartner"><?php echo "For the month end: $monthName $year" ?></td>
                <td class="headerPartner text-right width-auto-wrap">Hardware Management Store</td>
            </tr>
        </table>
    </header>
    <section>
        <table>
            <thead>
                <tr>
                    <th>
                        Owner's Account
                    </th>
                    <th>
                        Investment Last Month
                    </th>
                    <th>Additional Investment</th>
                    <th>Withdrawals</th>
                    <th>Net Income/Loss</th>
                    <th>Total Investment this Month</th>
                </tr>    
            </thead>
            <!-- <?php echo generateOEReport($year, $month);?> -->
        </table>
    </section>
</body>
</html>