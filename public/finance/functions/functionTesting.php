<?php
require_once "otherGroups\inventory.php";
require_once "otherGroups\productOrder.php";
require_once "otherGroups\salary.php";
require_once "otherGroups\sales.php";
session_start();
session_destroy();
$_SESSION['user']['role'] = "Human Resources";
$_SESSION['user']['employee_id'] = 1;


$amount = 0;
$payment_method = "Cash on bank";
$salesAmount = 0;
$taxAmount = 0;
$salesPaymentMethod = $payment_method;
$discount = 0;


$monthlySalary = 0;
$withHoldingTax = 0;

// // inventory
// echo recordStolen($amount);
// echo recountInventory($amount);


// // sales
// echo getBalanceCashAccount($payment_method);
// echo insertSalesLedger($salesAmount, $taxAmount, $salesPaymentMethod, $discount);
// echo insertSalesAllowance($amount, $payment_method);
// echo insertSalesReturn($amount, $payment_method);

// //product order
// echo recordBuyingInventory($amount);
// echo getRemainingProductOrderPondo();


// //salary
// echo getRemainingHRPondo();
// echo inputSalary($monthlySalary, $withHoldingTax);