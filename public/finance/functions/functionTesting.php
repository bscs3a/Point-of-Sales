<?php
require_once 'specialTransactions/investors.php';
require_once 'specialTransactions/payable.php';


$account = 'aries';
$asset = 'Cash on bank';
$amount = 100;

$name = "aries";
$contact = "123456789";
$contactName = "aries tagle assitant";


// echo investAsset($account, $asset, $amount);
echo withdrawAsset($account, $asset, $amount);
var_dump(getAllInvestors());
// echo addInvestor($name, $contact, $contactName);
