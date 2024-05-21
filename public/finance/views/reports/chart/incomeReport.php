<?php 
    require_once 'public\finance\functions\reportGeneration\CashFlow.php';
    $fromDate = $_SESSION['postdata']['fromMonthYear'];
    $toDate = $_SESSION['postdata']['toMonthYear'];

    

    $fromYear = explode('-', $fromDate)[0];
    $fromMonthNumber = explode('-', $fromDate)[1];
    $fromMonth = date('F', mktime(0, 0, 0, $fromMonthNumber, 10));

    $toYear = explode('-', $toDate)[0];
    $toMonthNumber = explode('-', $toDate)[1];
    $toMonth = date('F', mktime(0, 0, 0, $toMonthNumber, 10));

    $date = "From $fromMonth, $fromYear to $toMonth, $toYear";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income Report</title>
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
                <td class="header2">Income Report</td>
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
                <td class ="headerPartner"><?php echo "$date" ?></td>
                <td class="headerPartner text-right width-auto-wrap">Hardware Management Store</td>
            </tr>
        </table>
    </header>
    <main>
        
    </main>
</body>

</html>