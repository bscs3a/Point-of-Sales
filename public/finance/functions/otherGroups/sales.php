<?php
require_once "public/finance/functions/generalFunctions.php";



// parameters is SalesAmount(WITH TAX AND DISCOUNT)
// taxAmount 
// salesPaymentMethod(what is being used for salesPayment) -- options are "Cash on hand" "Cash on bank"
// discount is the amount of discount given,
function insertSalesLedger($salesAmount, $taxAmount, $salesPaymentMethod, $discount = 0){
    if ($salesAmount <= 0 || $taxAmount <= 0){
        throw new Exception("Amount must be greater than 0");
    }
    if($salesPaymentMethod !== "Cash on hand" && $salesPaymentMethod !== "Cash on bank" ){
        throw new Exception("Payment method for sales is wrong");
    }
    if($discount < 0){
        throw new Exception("Discount cannot be negative");
    }

    $SALES =  getLedgerCode("Sales");
    $salesDetails = "made a sale with tax";
    $VALUE_ADDED_TAX = getLedgerCode("Value Added Tax Payable");

    $remainingSalesAmount = $salesAmount - $taxAmount;

    insertLedgerXact($salesPaymentMethod, $SALES, $remainingSalesAmount, $salesDetails);
    insertLedgerXact($salesPaymentMethod, $VALUE_ADDED_TAX, $taxAmount, $salesDetails);

    //for discount
    if ($discount > 0){
        $DISCOUNT = "Discount";
        $discountDetails = "Discount given";
        insertLedgerXact($DISCOUNT, $salesPaymentMethod, $discount, $discountDetails);
    }
}

//for full return
//amount is the amount you are refunding
//paymentMethod can be "Cash on hand" or "Cash on bank"
function insertSalesReturn($amount, $paymentMethod){
    if ($amount <= 0){
        throw new Exception("Amount must be greater than 0");
    }
    if($paymentMethod !== "Cash on hand" && $paymentMethod !== "Cash on bank"){
        throw new Exception("Payment method cannot be null");
    }
    $SALES_RETURN = "Returns";
    $details = "Sales return";
    insertLedgerXact($SALES_RETURN, $paymentMethod, $amount, $details);
}

// for allowance
//amount is the amount you are refunding
//paymentMethod can be "Cash on hand" or "Cash on bank"
function insertSalesAllowance($amount, $paymentMethod){
    if ($amount <= 0){
        throw new Exception("Amount must be greater than 0");
    }
    if($paymentMethod !== "Cash on hand" && $paymentMethod !== "Cash on bank"){
        throw new Exception("Payment method cannot be null");
    }
    $SALES_ALLOWANCE = "Allowance";
    $details = "Sales allowance";
    insertLedgerXact($SALES_ALLOWANCE, $paymentMethod, $amount, $details);
}
?>