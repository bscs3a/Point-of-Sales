<?php

require_once '../generalFunctions.php';
// used for getting the accountbalance
// problems:
// must consider date
// must consider closing balance table(ledgerstatement)

//calculate net sales
function calculateNetSalesOrLoss($year, $month) {
    if ($year === null || $month === null) {
        throw new Exception("Year and month must not be null.");
    }
    define("INCOME", "IC");
    define("EXPENSE", "EP");

    // income - expense = netsales or loss
    return getTotalOfGroup(INCOME, $year, $month) - getTotalOfGroup(EXPENSE, $year, $month);
}

// close the accounts

// read the retained earnings

function generateIncomeReport($year, $month) {
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

    $html = "<ul>\n";
    foreach ($grouptype_data as $group) {
        if ($group['grouptype'] != "IC" && $group['grouptype'] != "EP") {
            continue;
        }
        $html .= "<li>\n<h1>{$group['description']}</h1>\n<ul>\n";
        foreach ($accounttype_data as $account) {
            if ($account['grouptype'] == $group['grouptype']) {
                $html .= "<li>\n{$account['Description']}\n<ul>\n";
                foreach ($ledger_data as $ledger) {
                    if ($ledger['AccountType'] == $account['AccountType']) {
                        $balance = getAccountBalance($ledger['ledgerno'], true, $year, $month);
                        $html .= "<li>\n<span>{$ledger['name']}</span>&emsp;<span>{$balance}</span>\n</li>\n";
                    }
                }
                $html .= "</ul>\n</li>\n";
            }
        }
        $total = getTotalOfGroup($group['grouptype'], $year, $month);
        $resultText = $group['grouptype'] == "IC" ? "Gross Profit" : "Total Expense";
        $html .= "</ul>\n<span>{$resultText}</span>&emsp;<span>{$total}</span>\n</li>\n";
    }
    $netSalesOrLoss = calculateNetSalesOrLoss($year, $month);
    $textSalesOrLoss = $netSalesOrLoss > 0 ? "Net Sales" : "Net Loss";
    $html .= "
    <li>
        <span>{$textSalesOrLoss}</span>&emsp;<span>{$netSalesOrLoss}</span>
    <li>";

    $html .= "</ul>";

    return $html;
}
?>