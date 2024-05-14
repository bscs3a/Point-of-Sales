<?php
require_once 'src/dbconn.php';
require_once 'public/finance/functions/generalFunctions.php';

// check department
function checkDepartment($department){
    $validDepartments = ["delivery", "finance", "hr", "inventory", "productOrder", "sales"];
    if (in_array($department, $validDepartments)) {
        return true;
    }
    return false;
}

// check all pay
function checkPayFor($payfor){
    $valid = getValidPayFor();
    if (in_array($payfor, $valid)) {
        return true;
    }
    return false;
}

// get all valid paying
function getValidPayFor(){
    $valid = [];
    $notInclude = getNotInclude();
    $FixedAsset = getAccountCode("Fixed Asset");
    $CurrentAsset = getAccountCode("Current Asset");
    $directExpense = getAccountCode("Direct Expense");
    $indirectExpense = getAccountCode("Indirect Expense");


    $db = Database::getInstance();
    $conn = $db->connect();
    $placeholders = implode(',', array_fill(0, count($notInclude), '?'));
    $sql = "SELECT name FROM Ledger
        WHERE (accountType = ? OR accountType = ? OR accountType = ? OR accountType = ?)
        AND name NOT IN ($placeholders)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array_merge([$FixedAsset, $CurrentAsset, $directExpense, $indirectExpense], $notInclude));

    while ($row = $stmt->fetch()) {
        $valid[] = $row['name'];
    }
    return $valid;
}

//get not incluided
function getNotInclude(){
    $notIncluded = ["Cash on hand", "Cash on bank", "Inventory", "Payroll", "Tax", "Interest expense"];
    return $notIncluded;
}

// check pay using
function checkPayUsing($payusing){
    $valid = ["Cash on hand" , "Cash on bank"];
    if (in_array($payusing, $valid)) {
        return true;
    }
    return false;
}
?>