<?php 
require_once "public/finance/functions/generalFunctions.php";
function inputSalary($totalSalaryAmount, $taxAmountPartial, $paymentMethod){
    $SALARY = getLedgerCode("Payroll");
    $TAX_PAYABLE = getLedgerCode("Tax Payable");
    $PAYMENT_METHOD = getLedgerCode($paymentMethod);

    $SalaryWithoutTax = $totalSalaryAmount - $taxAmountPartial;

    insertLedgerXact($SALARY, $PAYMENT_METHOD, $SalaryWithoutTax, "Salary Payment");
    insertLedgerXact($SALARY, $TAX_PAYABLE, $taxAmountPartial, "Tax to be paid to the government");
}

function getAvailableCashOnHand(){
    $CASH_ON_HAND = getLedgerCode("Cash on hand");
    return getAccountBalanceV2($CASH_ON_HAND);
}

function getAvailableCashOnBank(){
    $CASH_ON_BANK = getLedgerCode("Cash on bank");
    return getAccountBalanceV2($CASH_ON_BANK);
}

?>