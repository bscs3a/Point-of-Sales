<?php
require_once 'public\finance\functions\generalFunctions.php';

// get account balanced depending on cash
function getAccountBalanceBasedOnCash($year, $month){
    $cashOnHand = getLedgerCode("Cash on Hand");
    $cashInBank = getLedgerCode("Cash on Bank");

    if(!$cashInBank || !$cashOnHand){
        throw new Exception("Cash accounts not found");
    }
    
}

//generate cash flow report
function generateCashFlowReport($year, $month){
    
    $assets = getGroupCode("Assets");
    $liabilitiesAndOE = getGroupCode("Liability and Owner's Equity");
    $income = getGroupCode("Income");
    $expense = getGroupCode("Expenses");

    if(!$assets || !$liabilitiesAndOE || !$income || !$expense){
        throw new Exception("Group Codes not found");
    }

    $db = Database::getInstance();
    $conn = $db->connect();

    // Query data
    $grouptype_data = $conn->query('SELECT * FROM grouptype')->fetchAll();
    $accounttype_data = $conn->query('SELECT * FROM accounttype')->fetchAll();
    $ledger_data = $conn->query('SELECT * FROM ledger')->fetchAll();

    // Sort grouptype_data(in descending order -- needed)
    usort($grouptype_data, function($a, $b) {
        return strcmp($b['grouptype'], $a['grouptype']);
    });

    $html = "<section>";
    foreach ($grouptype_data as $group) {
        if ($group['grouptype'] != $income && $group['grouptype'] != $expense) {
            continue;
        }
        $html .= "<table>";
        $html .= "<thead>";
        $html .= "<tr>";
        $html .= "<th colspan='2' class='text-left'>{$group['description']}</th>";
        $html .= "</tr>";
        $html .= "</thead>";
        $html .= "<tbody>";
        foreach ($accounttype_data as $account) {
            if ($account['grouptype'] == $group['grouptype']) {
                $html .= "<tr class='table-classifier'>";
                $html .= "<td class='classifier'>{$account['Description']}</td>";
                $html .= "</tr>";
                foreach ($ledger_data as $ledger) {
                    if ($ledger['AccountType'] == $account['AccountType']) {
                        $balance = abs(getAccountBalanceInRetainedAccount($ledger['ledgerno'], $year, $month));
                        // dont show ledger if balance is 0
                        if($balance == 0){
                            continue;
                        }
                        $balance = abs($balance);
                        $html .= "<tr class='table-content'>";
                        $html .= "<td class='content'>{$ledger['name']}</td>";
                        $html .= "<td class='content-amount'>{$balance}</td>";
                        $html .= "</tr>";
                    }
                }
            }
        }
        $html .= "</tbody>";

        //result of group
        $total = abs(getGroupInRetainedAccount($group['grouptype'], $year, $month));
        $resultText = $group['grouptype'] == "IC" ? "Gross Profit" : "Total Expense";
        $html .= "<tfoot>";
        $html .= "<tr>";
        $html .= "<td>{$resultText}</td>";
        $html .= "<td>{$total}</td>";
        $html .= "</tr>";
        $html .= "</tfoot>";
        $html .= "</table>";
    }

    $html .= "</section>";
    // net sales or loss section
    $netSalesOrLoss = calculateNetSalesOrLoss($year, $month);
    $textSalesOrLoss = $netSalesOrLoss > 0 ? "Net Sales" : "Net Loss";
    $netSalesOrLoss = abs($netSalesOrLoss);
    $html .= "<section>";
    $html .= "<table>";
    $html .= "<tfoot>";
    $html .= "<tr>";
    $html .= "<td>{$textSalesOrLoss}</td>";
    $html .= "<td>{$netSalesOrLoss}</td>";
    $html .= "</tr>";
    $html .= "</tfoot>";
    $html .= "</table>";
    $html .= "</section>";
    return $html;
}
