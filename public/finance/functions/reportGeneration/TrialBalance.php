<?php
require_once "../generalFunctions.php";

function generateTrialBalance($year, $month) {
    $db = Database::getInstance();
    $conn = $db->connect();
    $asset = getGroupCode("Asset");
    $LiabilityAndOE = getGroupCode("liabilities and owner\'s equity");

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
        if ($group['grouptype'] != $asset && $group['grouptype'] != $LiabilityAndOE) {
            continue;
        }
        $html .= "<li>\n<h1>{$group['description']}</h1>\n<ul>\n";
        foreach ($accounttype_data as $account) {
            if ($account['grouptype'] == $group['grouptype']) {
                $html .= "<li>\n{$account['Description']}\n<ul>\n";
                foreach ($ledger_data as $ledger) {
                    if ($ledger['AccountType'] == $account['AccountType']) {
                        $balance = abs(getAccountBalance($ledger['ledgerno'],true, $year, $month));
                        // dont show ledger if balance is 0
                        if($balance == 0){
                            continue;
                        }
                        $balance = abs($balance);
                        $html .= "<li>\n<span>{$ledger['name']}</span>&emsp;<span>{$balance}</span>\n</li>\n";
                    }
                }
                $html .= "</ul>\n</li>\n";
            }
        }
        $total = abs(getTotalOfGroup($group['grouptype'], $year, $month));
        $resultText = $group['grouptype'] == $asset ? "Asset" : "Liabilities and Owner's Equity";
        $html .= "</ul>\n<span>{$resultText}</span>&emsp;<span>{$total}</span>\n</li>\n";
    }
    $html .= "</ul>";
    return $html;
}

?>