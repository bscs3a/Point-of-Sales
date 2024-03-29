<?php
require_once "IncomeReport.php";
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
        if($ledger["AccountType"] != "Capital Accounts"){
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


        // $html .= "<td>".divideTheGainLoss($ledger['ledgerno'], $year, $month)."</td>"; // additional investment
        $html .= "<td>".divideTheGainLoss($ledger['ledgerno'], $year, $month)."</td>"; // net income/loss
        // $html .= "<td>".getWithdrawals($ledger["AccountNumber"], $year, $month)."</td>"; //withdrawals
        $html .= "<td>".getAccountBalance($ledger["AccountNumber"])."</td>";
        $html .= "</tr>";
    }


    $html .= "</tbody>";


}

function getInvestment($accountNumber, $year = null, $month=null){
    $accountNumber = getLedgerCode($accountNumber);
    $retained = getLedgerCode("Retained Earnings/Loss");

    if ($accountNumber === false) {
        throw new Exception("Account not found in Ledger table.");
    }
    
    
}
?>