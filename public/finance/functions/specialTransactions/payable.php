<?php
require_once "public/finance/functions/generalFunctions.php";
require_once "public/finance/pondo/insertPondo.php";

function getAllPayable()
{
    $db = Database::getInstance();
    $conn = $db->connect();

    $AP = getAccountCode("Accounts Payable");
    $TP = getAccountCode("Tax Payable");
    $sql = "SELECT * FROM ledger WHERE accounttype = :AP OR accounttype = :TP";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':AP', $AP);
    $stmt->bindParam(':TP', $TP);
    $stmt->execute();
    $ledgers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $results = [];
    foreach ($ledgers as $ledger) {
        $ledgerNo = $ledger['ledgerno'];
        $name = $ledger['name'];
        $results[] = [
            'ledgerno' => $ledgerNo,
            'name' => $name,
            'total_amount' => getValueOfPayable($ledgerNo)
        ];
    }
    return $results;
}


// get total value of payble minus the paid amount
function getValueOfPayable($accountNumber)
{
    return abs(getAccountBalanceV2($accountNumber));
}


// add loan to account
function borrowPayable($accountNumber, $assetCode, $amount)
{
    $accountNumber = getAccountCode($accountNumber);
    $assetCode = getAccountCode($assetCode);

    if ($amount <= 0) {
        throw new Exception("Amount must be greater than 0");
    }
    if (!$accountNumber) {
        throw new Exception("Account number not found");
    }
    if (!$assetCode) {
        throw new Exception("Asset code not found");
    }

    insertLedgerXact($assetCode, $accountNumber, $amount, "Boroww on $accountNumber with $assetCode");
    return;
}

//withdraw investment 
function payPayable($accountNumber, $assetCode, $amount)
{
    $accountNumber = getAccountCode($accountNumber);
    $assetCode = getAccountCode($assetCode);

    $currentPayable = getValueOfPayable($accountNumber);

    if ($amount <= 0) {
        throw new Exception("Amount must be greater than 0");
    }
    if ($amount > $currentPayable) {
        throw new Exception("Amount is greater than current payable");
    }
    if (!$accountNumber) {
        throw new Exception("Account number not found");
    }
    if (!$assetCode) {
        throw new Exception("Asset code not found");
    }
    
    $SALARY = getAccountCode("Salary Payable");
    $WITHHOLDING_TAX = getAccountCode("Withholding Tax Payable");

    if ($assetCode == $SALARY || $assetCode == $WITHHOLDING_TAX) {
        $HUMAN_RESOURCES = "Human Resources";
        addTransactionPondo($accountNumber, $assetCode, $amount, $HUMAN_RESOURCES);
        return;
    }
    insertLedgerXact($accountNumber, $assetCode, $amount, "Paid $accountNumber using $assetCode");
    return;
}

function addPayable($name, $contact, $contactName, $accountType)
{
    $accountType = getAccountCode($accountType);

    $db = Database::getInstance();
    $conn = $db->connect();

    $sql = "INSERT INTO Ledger (name, contactIfLE, contactName, accounttype) VALUES (:name, :contact, :contactName, :accounttype)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':contact', $contact);
    $stmt->bindParam(':contactName', $contactName);
    $stmt->bindParam(':accounttype', $accountType);
    $stmt->execute();
    return;
}

