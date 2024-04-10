<?php 
    require_once 'public/finance/functions/reportGeneration/TrialBalance.php';
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
    <title>Trial Balance</title>
</head>
<body>
    <header>
        <div>
            <span>Balance Sheet</span>
            <span>
                <?php echo "$monthName $year"?>    
            </span>
        </div>
        <!-- <img src="..\..\img\logo_reports.png" alt=""> -->
    </header>
    <section>
        <?php echo generateTrialBalance($year,$month)?>
    </section>
</body>
</html>