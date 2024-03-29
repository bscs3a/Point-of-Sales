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
    return abs(calculateNetSalesOrLoss($year, $month)) * calculateShare($accountNumber);
}

function insertShare($accountNumber, $year, $month){
    $retained = getLedgerCode("Retained Earnings/Loss");
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


function generateOEReport(){
    $db = Database::getInstance();
    $conn = $db->connect();

    
}
?>