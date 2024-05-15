<?php
require_once 'public/finance/functions/generalFunctions.php';
require_once 'public\finance\functions\pondo\insertPondo.php';
function recordBuyingInventory($amount){
    $inventory = getLedgerCode('Inventory');
    $department = "Product Order";
    $pondo = pondoForEveryone($department);

    if($amount > $pondo){
        throw new Exception("Amount to be bought is greater than the pondo of the department");
    }

    return addTransactionPondo($inventory, $pondo, $amount);
}
?>