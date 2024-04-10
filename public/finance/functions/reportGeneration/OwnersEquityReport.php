<?php
require_once "public\finance\functions\reportGeneration\IncomeReport.php";
//get all account in owner's equity
//designate the percentage
//distribute the loss/profit in the owner's equity
//display in html


function calculateShare($accountNumber){
    define("CAPITAL","Capital Accounts");

    $accountNumber = getLedgerCode($accountNumber);

    if ($accountNumber === false) {
        throw new Exception("Account not found in Ledger table.");
    }

    //get share
    $accountBalance = abs(getAccountBalance($accountNumber));
    $allBalance = abs(getTotalOfAccountType(CAPITAL));
    //divide it by total share
    return $accountBalance/$allBalance;
}

function divideTheGainLoss($accountNumber, $year, $month){
    return calculateNetSalesOrLoss($year, $month) * calculateShare($accountNumber);
}

function insertShare($accountNumber, $year, $month){
    $retained = getLedgerCode("Retained Earnings/Loss");
    // if retained is 0 for the month, that means its already been processed
    if(getAccountBalance($retained, true, $year, $month) == 0){
        return;
    }

    $accountNumber = getLedgerCode($accountNumber);

    if ($accountNumber === false) {
        throw new Exception("Account not found in Ledger table.");
    }
    // default is earnings
    $debitLedger = $accountNumber;
    $creditLedger = $retained;
    
    if(calculateNetSalesOrLoss($year,$month) < 0){
        $debitLedger = $retained;
        $creditLedger = $accountNumber;
    }

    $amount = abs(divideTheGainLoss($accountNumber, $year, $month));
    //if share is 0 return
    if ($amount == 0) {
        return;
    }
    

    insertLedgerXact($debitLedger, $creditLedger, $amount, "Dividing Earnings or Loss", $year, $month);
}


function generateOEReport($year, $month){
    $db = Database::getInstance();
    $conn = $db->connect();

    $condition = getAccountCode("Capital Accounts");
    $stmt = $conn->prepare('SELECT * FROM ledger WHERE ledger.accounttype = :condition');
    $stmt->bindParam(':condition', $condition);
    $stmt->execute();
    $ledger_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Sort grouptype_data(in descending order -- needed)
    usort($grouptype_data, function($a, $b) {
        return strcmp($b['grouptype'], $a['grouptype']);
    });

    $html = "<tbody>";
    foreach ($ledger_data as $ledger) {
        if($ledger["AccountType"] != $condition){
            continue;
        }
        insertShare($ledger["ledgerno"], $year, $month);
        $html .= "<tr>";
        $html .= "<td>".$ledger["name"]."</td>"; //name

        $pastYear = $year;
        $pastMonth = $month - 1;
        if($month == 1){
            $pastYear = $year - 1;
            $pastMonth = 12;
        }
        $html .= "<td>".getAccountBalance($ledger["AccountNumber"], $pastYear, $pastMonth)."</td>"; //account balance last month
        $html .= "<td>".getInvestment($ledger['ledgerno'], $year, $month)."</td>"; // additional investment
        $html .= "<td>".divideTheGainLoss($ledger['ledgerno'], $year, $month)."</td>"; // net income/loss divided
        $html .= "<td>".getWithdrawals($ledger["AccountNumber"], $year, $month)."</td>"; //withdrawals
        $html .= "<td>".getAccountBalance($ledger["AccountNumber"])."</td>"; // get the current total
        $html .= "</tr>";
    }
    $html .= "</tbody>";
    $html .= "<tfoot>";
    $html .= "<tr>";
    $html .= "<td>Total Equity</td>"; //place holder for name
    $html .= "<td>".getTotalOfAccountType($condition,$pastYear,$pastMonth)."</td>"; //total investment last month
    $html .= "<td>".getWholeInvestment($year,$month)."</td>"; // total additional investment this month
    $html .= "<td>".calculateNetSalesOrLoss($year, $month)."</td>";// total net income/loss this month
    $html .= "<td>".getWholeWithdrawals($year,$month)."</td>"; // total withdrawals this month
    $html .= "<td>".getTotalOfAccountType($condition,$year,$month)."</td>"; // ending investment this month
    $html .= "</tr>";
    $html .= "</tfoot>";

    return $html;
}
// get the investment of the account holder total - excluding retained earnings
function getInvestment($accountNumber, $year = null, $month=null){
    $accountNumber = getLedgerCode($accountNumber);
    $retained = getLedgerCode("Retained Earnings/Loss");

    if ($accountNumber === false) {
        throw new Exception("Account not found in Ledger table.");
    }
    
    $db = Database::getInstance();
    $conn = $db->connect();
    // get everything that credited the investment account no; excluding retained earnings
    $sql = "SELECT * FROM LedgerTransaction WHERE LedgerNo = :accountNumber AND LedgerNo_Dr != :retained";
    if (is_numeric($year) && is_numeric($month) && $month >= 1 && $month <= 12) {
        $sql .= " AND YEAR(datetime) = :year AND MONTH(datetime) = :month";
    }
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':accountNumber', $accountNumber);
    $stmt->bindParam(':retained', $retained);
    if ($year !== null && $month !== null) {
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->bindParam(':month', $month, PDO::PARAM_INT);
    }
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $balance = 0;
    foreach ($result as $row) {
        $balance += $row['amount'];
    }
    return $balance;
}

// get the withdrawals of the account holder total - excluding retained earnings
function getWithdrawals($accountNumber, $year = null, $month=null){
    $accountNumber = getLedgerCode($accountNumber);
    $retained = getLedgerCode("Retained Earnings/Loss");

    if ($accountNumber === false) {
        throw new Exception("Account not found in Ledger table.");
    }
    
    $db = Database::getInstance();
    $conn = $db->connect();
    // get everything that debited the investment account no; excluding retained earnings
    $sql = "SELECT * FROM LedgerTransaction WHERE LedgerNo_dr = :accountNumber AND LedgerNo != :retained";
    if (is_numeric($year) && is_numeric($month) && $month >= 1 && $month <= 12) {
        $sql .= " AND YEAR(datetime) = :year AND MONTH(datetime) = :month";
    }
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':accountNumber', $accountNumber);
    $stmt->bindParam(':retained', $retained);
    if ($year !== null && $month !== null) {
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->bindParam(':month', $month, PDO::PARAM_INT);
    }
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $balance = 0;
    foreach ($result as $row) {
        $balance += $row['amount'];
    }
    return $balance;
}

function getWholeInvestment($year,$month){
    $retained = getLedgerCode("Retained Earnings/Loss");
    $accountTypeCode = getAccountCode("Capital Accounts");

    $db = Database::getInstance();
    $conn = $db->connect();
    // get everything that credited the investment account no; excluding retained earnings
    $sql = "SELECT * FROM LedgerTransaction lt
    JOIN Ledger l ON lt.LedgerNo = l.LedgerNo
    WHERE l.accounttype = :accountTypeCode 
    AND lt.LedgerNo_Dr != :retained";
    if (is_numeric($year) && is_numeric($month) && $month >= 1 && $month <= 12) {
        $sql .= " AND YEAR(lt.datetime) = :year AND MONTH(lt.datetime) = :month";
    }
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':accountTypeCode', $accountTypeCode);
    $stmt->bindParam(':retained', $retained);
    if ($year !== null && $month !== null) {
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->bindParam(':month', $month, PDO::PARAM_INT);
    }
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $balance = 0;
    foreach ($result as $row) {
        $balance += $row['amount'];
    }
    return $balance;
}

function getWholeWithdrawals($year, $month){
    $retained = getLedgerCode("Retained Earnings/Loss");
    $accountTypeCode = getAccountCode("Capital Accounts");

    $db = Database::getInstance();
    $conn = $db->connect();
    // get everything that credited the investment account no; excluding retained earnings
    $sql = "SELECT * FROM LedgerTransaction lt
    JOIN Ledger l ON lt.LedgerNo_Dr = l.LedgerNo
    WHERE l.accounttype = :accountTypeCode 
    AND lt.LedgerNo != :retained";
    if (is_numeric($year) && is_numeric($month) && $month >= 1 && $month <= 12) {
        $sql .= " AND YEAR(lt.datetime) = :year AND MONTH(lt.datetime) = :month";
    }
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':accountTypeCode', $accountTypeCode);
    $stmt->bindParam(':retained', $retained);
    if ($year !== null && $month !== null) {
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->bindParam(':month', $month, PDO::PARAM_INT);
    }
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $balance = 0;
    foreach ($result as $row) {
        $balance += $row['amount'];
    }
    return $balance;
}
?>