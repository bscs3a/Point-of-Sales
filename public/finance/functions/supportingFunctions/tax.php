<?php
// cannot be used without the generalFunctions.php file, make sure to include it where you are including this
function insertTax($taxPaymentMethod, $amount, $details){
    if ($amount <= 0){
        throw new Exception("Amount must be greater than 0");
    }
    if($taxPaymentMethod === "Cash on hand" || $taxPaymentMethod === "Cash on bank" || $taxPaymentMethod === "Tax Payable"){
        throw new Exception("Payment method for tax is wrong");
    }
    $TAX = "Tax";
    insertLedgerXact($TAX, $taxPaymentMethod, $amount, $details);
}
?>