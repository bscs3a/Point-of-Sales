<?php 
require_once 'public/finance/functions/supportingFunctions/supportingPondo.php';
require_once 'public/finance/functions/generalFunctions.php';
function generalAvailableToSelect(){
    $db = Database::getInstance();
    $conn = $db->connect();

    $conditions = filterForAvailable();

    $sql = "SELECT l.name, l.ledgerno, at.AccountType, gt.grouptype FROM Ledger as l 
    JOIN accounttype as at ON l.AccountType = at.AccountType
    JOIN grouptype as gt ON at.grouptype = gt.grouptype
    $conditions";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();

    return $result;
}


function filterForAvailable(){
    $assetCode = getGroupCode('Asset');
    $expenseCode = getGroupCode('Expenses');


    $inventoryCode = getLedgerCode('Inventory');
    $payrollCode = getLedgerCode('Payroll');
    $interestExpense = getLedgerCode('Interest Expense');

    $result = "(gt.grouptype = $assetCode OR gt.grouptype = $expenseCode) ";
    $result .= "AND l.ledgerno != $inventoryCode AND l.ledgerno != $payrollCode ";


    return $result;
}