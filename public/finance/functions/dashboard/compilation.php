<?php
require_once 'public\finance\functions\generalFunctions.php';

// used for getting the accountbalance
// problems:
// must consider date
// must consider closing balance table(ledgerstatement)


//calculate net sales
//returns negative if d kumita; positive if kumita
function calculateNetSalesOrLoss($year, $month) {
    if ($year === null || $month === null) {
        throw new Exception("Year and month must not be null.");
    }
    $INCOME = "IC";
    $EXPENSE = "EP";

    // income - expense = netsales or loss
    return abs(getGroupInRetainedAccount($INCOME, $year, $month)) - abs(getGroupInRetainedAccount($EXPENSE, $year, $month));
}

//close an account - responsible for inserting the retained earnings/loss
function closeAccount($ledgerCode, $amount, $year, $month){
    $retainedCode = getLedgerCode("Retained Earnings/Loss");
    
    //expenses default
    $debitLedger = $retainedCode;
    $creditLedger = $ledgerCode;
    //if amount is 0 dont insert
    if($amount == 0){
        return;
    }
    // if amount 0 interchange -- sales
    if($amount < 0){
        $debitLedger = $ledgerCode;
        $creditLedger = $retainedCode;
    }

    insertLedgerXact($debitLedger, $creditLedger, $amount, "closing of account", $year, $month);
}

// close all the accounts
function closeAllAccounts($year, $month) {
    $db = Database::getInstance();
    $conn = $db->connect();
    // get the all of the ledger(code) that has a group type of IC or EP
    $sql = "SELECT l.ledgerno 
        FROM Ledger l 
        INNER JOIN AccountType a ON l.AccountType = a.AccountType 
        WHERE a.grouptype IN ('ic', 'ep')";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $ledgers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($ledgers as $ledger) {
        // get the balance of each ledger - foreach loop through the map
        $balance = getAccountBalance($ledger['ledgerno'], true, $year, $month);
        // close the accounts by transfering it through retained earnings/loss
        closeAccount($ledger['ledgerno'], $balance, $year, $month);
    }
}

// read the retained earnings/loss
function getAccountBalanceInRetainedAccount($ledger, $year, $month){
    $retained = getLedgerCode("Retained Earnings/Loss");
    $ledger = getLedgerCode($ledger);

    $db = Database::getInstance();
    $conn = $db->connect();

    $sql = "SELECT SUM(amount) as TotalDebit 
    FROM LedgerTransaction 
    WHERE LedgerNo = :retained AND LedgerNo_Dr = :ledger AND YEAR(DateTime) = :year AND MONTH(DateTime) = :month";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':retained', $retained);
    $stmt->bindParam(':ledger', $ledger);
    $stmt->bindParam(':year', $year);
    $stmt->bindParam(':month', $month);
    $stmt->execute();
    $debitAmount = $stmt->fetch(PDO::FETCH_ASSOC)['TotalDebit'];

    $sql = "SELECT SUM(amount) as TotalCredit 
    FROM LedgerTransaction
    WHERE LedgerNo_Dr = :retained AND LedgerNo = :ledger AND YEAR(DateTime) = :year AND MONTH(DateTime) = :month";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':retained', $retained);
    $stmt->bindParam(':ledger', $ledger);
    $stmt->bindParam(':year', $year);
    $stmt->bindParam(':month', $month);
    $stmt->execute();
    $creditAmount = $stmt->fetch(PDO::FETCH_ASSOC)['TotalCredit'];

    $total = $debitAmount - $creditAmount;
    return $total;
}

// get the total of a group in retained earnings
function getGroupInRetainedAccount($groupType, $year = null, $month = null) {
    $db = Database::getInstance();
    $conn = $db->connect();
    $retained = getLedgerCode("Retained Earnings/Loss");
    $groupType = getGroupCode($groupType);

    if ($groupType === false) {
        throw new Exception("Account not found in grouptype table.");
    }

    $sql = "SELECT lt.* FROM LedgerTransaction lt
            JOIN Ledger l ON lt.ledgerNo = l.ledgerNo
            JOIN AccountType at ON l.accountType = at.accountType
            WHERE at.groupType = :groupType AND lt.ledgerNo_dr = :retained";
    if (is_numeric($year) && is_numeric($month) && $month >= 1 && $month <= 12) {
        $sql .= " AND YEAR(lt.datetime) = :year AND MONTH(lt.datetime) = :month";
    }
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':groupType', $groupType);
    $stmt->bindParam(':retained', $retained);
    if ($year !== null && $month !== null) {
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->bindParam(':month', $month, PDO::PARAM_INT);
    }
    $stmt->execute();

    $netAmount = 0;

    while ($row = $stmt->fetch()) {
        $netAmount += $row['amount'];
    }

    $sql = "SELECT lt.* FROM LedgerTransaction lt
            JOIN Ledger l ON lt.ledgerNo_dr = l.ledgerNo
            JOIN AccountType at ON l.accountType = at.accountType
            WHERE at.groupType = :groupType AND lt.ledgerNo = :retained";
    if (is_numeric($year) && is_numeric($month) && $month >= 1 && $month <= 12) {
        $sql .= " AND YEAR(lt.datetime) = :year AND MONTH(lt.datetime) = :month";
    }
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':groupType', $groupType);
    $stmt->bindParam(':retained', $retained);
    if ($year !== null && $month !== null) {
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->bindParam(':month', $month, PDO::PARAM_INT);
    }
    $stmt->execute();

    while ($row = $stmt->fetch()) {
        $netAmount -= $row['amount'];
    }

    return $netAmount;
}

function calculateShare($accountNumber,$year,$month){
    $CAPITAL = "Capital Accounts";

    $accountNumber = getLedgerCode($accountNumber);

    if ($accountNumber === false) {
        throw new Exception("Account not found in Ledger table.");
    }

    //get share
    $accountBalance = abs(getAccountBalanceV2($accountNumber, true, $year, $month));
    $allBalance = abs(getTotalOfAccountTypeV2($CAPITAL,$year,$month));
    //divide it by total share
    if($allBalance == 0){
        $allBalance = 1;
    }
    return round($accountBalance/$allBalance,3);
}

function insertShare($accountNumber, $year, $month){
    $retained = getLedgerCode("Retained Earnings/Loss");
    // if retained is 0 for the month, that means its already been processed
    if(abs(getAccountBalance($retained, true, $year, $month)) <= 0){
        return;
    }
    //check account if its 0
    if(abs(getAccountBalanceV2($accountNumber, true, $year,$month)) <= 0)
    {
        return;
    }
    $accountNumber = getLedgerCode($accountNumber);

    if ($accountNumber === false) {
        throw new Exception("Account not found in Ledger table.");
    }
    // default is earnings
    $debitLedger = $retained;
    $creditLedger = $accountNumber;
    
    if(calculateNetSalesOrLoss($year,$month) < 0){
        $debitLedger = $accountNumber;
        $creditLedger = $retained;
    }

    $amount = divideTheGainLoss($accountNumber, $year, $month);
    insertLedgerXact($debitLedger, $creditLedger, $amount, "Dividing Earnings or Loss", $year, $month);
}

function insertAllShares($year, $month){
    $db = Database::getInstance();
    $conn = $db->connect();
    // get the all of the ledger(code) that has a group type of IC or EP
    $CAPITAL = getAccountCode("Capital Accounts");
    $sql = "SELECT *
        FROM Ledger l 
        INNER JOIN AccountType a ON l.AccountType = a.AccountType 
        WHERE a.accounttype = :capital";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':capital', $CAPITAL);
    $stmt->execute();
    $ledgers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($ledgers as $ledger) {
        // close the accounts by transfering it through retained earnings/loss
        insertShare($ledger['ledgerno'], $year, $month);
    }

    //declare owner (the purpose of code below is to put the rest of the earnings or loss to the first owner)
    $OWNER_LEDGER = getLedgerCode("A account");
    //for getting the past month
    $pastYear = $year;
    $pastMonth = $month - 1;
    if($month == 1){
        $pastYear = $year - 1;
        $pastMonth = 12;
    }
    $addedSales =  getTotalOfAccountTypeV2($CAPITAL, $year,$month) - getTotalOfAccountTypeV2($CAPITAL,$pastYear,$pastMonth) - getWholeInvestment($year,$month) - getWholeWithdrawals($year,$month);
    $amount = calculateNetSalesOrLoss($year, $month) - $addedSales;
    if($amount != 0 && calculateNetSalesOrLoss($year, $month) != 0){
        if($amount < 0){
            $debit = $OWNER_LEDGER;
            $credit = getLedgerCode("Retained Earnings/Loss");
        }else{
            $debit = getLedgerCode("Retained Earnings/Loss");
            $credit = $OWNER_LEDGER;
        }
        insertLedgerXact($debit, $credit,$amount, "putting the rest at the owner", $year, $month);
    }

}

function divideTheGainLoss($accountNumber, $year, $month){
    return round(calculateNetSalesOrLoss($year, $month) * calculateShare($accountNumber, $year, $month), 3);
}

//returns false if its not added, return true if its added
function checkShareIfAdded($accountNumber, $year, $month){
    $db = Database::getInstance();
    $conn = $db->connect();

    $RETAINED = getLedgerCode("Retained Earnings/Loss");

    $sql = "SELECT * FROM LedgerTransaction WHERE LedgerNo = :accountNumber AND LedgerNo_Dr = :retained AND YEAR(datetime) = :year AND MONTH(datetime) = :month";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':accountNumber', $accountNumber);
    $stmt->bindParam(':retained', $RETAINED);
    $stmt->bindParam(':year', $year);
    $stmt->bindParam(':month', $month);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(!empty($result)) {
        return true;
    } 

    $sql = "SELECT * FROM LedgerTransaction WHERE LedgerNo_Dr = :accountNumber AND LedgerNo = :retained AND YEAR(datetime) = :year AND MONTH(datetime) = :month";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':accountNumber', $accountNumber);
    $stmt->bindParam(':retained', $RETAINED);
    $stmt->bindParam(':year', $year);
    $stmt->bindParam(':month', $month);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(!empty($result)) {
        return true;
    } 

    return false;
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

