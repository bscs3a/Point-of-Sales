<?php 
    // require_once 'public\finance\functions\reportGeneration\IncomeReport.php';
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
    <title>Income Report</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Russo+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="reports.css">
</head>
<style>
    table,tr,td{
        border: thin solid black;
    }
</style>

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
                    <th colspan="2" class="text-left">
                        Assets
                    </th>
                </tr>    
            </thead>
            <tbody>
                <tr class = "table-classifier">
                    <td class = "classifier">
                        Fixed Assets
                    </td>
                </tr>
                <tr class="table-content">
                    <td class = "content">
                        Equipment
                    </td>
                    <td class = "content-amount">
                        P100,000
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                   <td>
                        Total
                   </td> 
                   <td class ="content-amount">
                        100,000
                   </td>
                </tr>
            </tfoot>
        </table>
    </section>
    <section>
        <table>
            <tfoot>
                <tr>
                   <td>
                        Total
                   </td> 
                   <td class = "content-amount">
                        100,000
                   </td>
                </tr>
            </tfoot>
        </table>
    </section>
    <!-- <?php
        echo generateIncomeReport($year, $month);
    ?> -->
</body>

</html>