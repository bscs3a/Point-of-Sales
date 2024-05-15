<?php
require_once 'public/finance/functions/generalFunctions.php';
require_once 'public\finance\functions\pondo\insertPondo.php';
require_once 'public\finance\functions\pondo\generalPondo.php';
function recordBuyingInventory($amount){
    $inventory = getLedgerCode('Inventory');
    $department = "Product Order";

    

    $cashOnHand = getLedgerCode('Cash on Hand');
    $cashOnBank = getLedgerCode('Cash on Bank');


    $handValue = getRemainingPondo($department, $cashOnHand);
    $bankValue = getRemainingPondo($department, $cashOnBank);
    $total = $handValue + $bankValue;

    if($amount > $total){
        throw new Exception("Amount to be bought is greater than the remaining pondo of the department");
    }

    //get percentage
    $handPercentage = $handValue / $total;
    $bankPercentage = $bankValue / $total;

    //gets the value to insert
    $insertHand = $amount * $handPercentage;
    $insertBank = $amount * $bankPercentage;

    // fraction error handling
    if($insertHand + $insertBank != $total){
        if($handValue > $bankValue){
            $insertHand += $total - ($insertHand + $insertBank);
        }else{
            $insertBank += $total - ($insertHand + $insertBank);
        }
    }

    // divide it to the 2; to avoid error
    addTransactionPondo($inventory, $cashOnHand, $insertHand);
    addTransactionPondo($inventory, $cashOnBank, $insertBank);

    return;
}

// only use when you want to get your remaining pondo
function getRemainingProductOrderPondo(){

    $department = "Product Order";

    $cashOnHand = getLedgerCode('Cash on Hand');
    $cashOnBank = getLedgerCode('Cash on Bank');

    $handValue = getRemainingPondo($department, $cashOnHand);
    $bankValue = getRemainingPondo($department, $cashOnBank);
    return $handValue + $bankValue;
}
?>