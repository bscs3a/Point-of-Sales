<?php
require_once "public/finance/functions/generalFunctions.php";

function getAllPayable(){
    $db = Database::getInstance();
    $conn = $db->connect();  

    $AP = getLedgerCode("Accounts Payable");
    $TP = getLedgerCode("Tax Payable");
    $sql = "SELECT * FROM Ledger WHERE accounttype = :AP OR accounttype = :TP";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':AP', $AP);
    $stmt->bindParam(':TP', $TP);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function getValueOfPayable($accountNumber){
    return abs(getAccountBalanceV2($accountNumber));
}


// add investment
function borrowAsset($accountNumber, $assetCode, $amount){
    $accountNumber = getLedgerCode($accountNumber);
    $assetCode = getLedgerCode($assetCode);

    if ($amount <= 0){
        throw new Exception("Amount must be greater than 0");
    }
    if(!$accountNumber){
        throw new Exception("Account number not found");
    }
    if(!$assetCode){
        throw new Exception("Asset code not found");
    }

    insertLedgerXact($assetCode,$accountNumber,$amount,"Boroww on $accountNumber with $assetCode");
    return;
}

//withdraw investment
function payPayable($accountNumber, $assetCode, $amount){
    $accountNumber = getLedgerCode($accountNumber);
    $assetCode = getLedgerCode($assetCode);

    $currentPayable = getValueOfPayable($accountNumber);

    if ($amount <= 0){
        throw new Exception("Amount must be greater than 0");
    }
    if($amount > $currentPayable){
        throw new Exception("Amount is greater than current payable");
    }
    if(!$accountNumber){
        throw new Exception("Account number not found");
    }
    if(!$assetCode){
        throw new Exception("Asset code not found");
    }

    insertLedgerXact($accountNumber,$assetCode,$amount,"Paid $accountNumber using $assetCode");
    return;
}

function addPayable($name, $contact, $contactName){
    $CAPITAL = getAccountCode("Capital Accounts");

    $db = Database::getInstance();
    $conn = $db->connect();

    $sql = "INSERT INTO Ledger (name, contactIfLE, contactName, accounttype) VALUES (:name, :contact, :contactName, :CAPITAL)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':contact', $contact);
    $stmt->bindParam(':contactName', $contactName);
    $stmt->bindParam(':CAPITAL', $CAPITAL);
    $stmt->execute();
    return;
}
?>