<?php
require_once 'public\finance\functions\generalFunctions.php';
// get account balanced(ledger) depending on cash
// favors debit(returns positive if the value is debit, returns negative if the value is credit)
function getAccountBalanceBasedOnCash($ledgerNo, $year, $month){
    $cashOnHand = getLedgerCode("Cash on Hand");
    $cashInBank = getLedgerCode("Cash on Bank");
    $ledgerNo = getLedgerCode($ledgerNo);
    if(!$cashInBank || !$cashOnHand || !$ledgerNo){
        throw new Exception("Ledgers accounts not found");
    }
    if(is_numeric($year) && is_numeric($month) && $month >= 1 && $month <= 12){
        throw new Exception("Year and month are wrong");
    }

    $db = Database::getInstance();
    $conn = $db->connect();

    $sql = "SELECT 
    (SUM(
        CASE 
            WHEN LedgerNo_Dr = :cashOnHand OR LedgerNo_Dr = :cashInBank THEN amount 
            ELSE 0 
        END) 
    -
    SUM(
        CASE 
            WHEN LedgerNo = :cashOnHand OR LedgerNo = :cashInBank THEN amount 
            ELSE 0 
        END)) 
    as balance
    FROM ledgertransaction
    WHERE YEAR(date) = :year AND MONTH(date) = :month AND (ledgerNo = :ledgerNo OR ledgerNo_dr = :ledgerNo)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'cashOnHand' => $cashOnHand,
        'cashInBank' => $cashInBank,
        'year' => $year,
        'month' => $month,
        'ledgerNo' => $ledgerNo
    ]);

    $row = $stmt->fetch();
    return $row['balance'];
}
// get account type balance based on cash
function getAccountTypeBalanceBasedOnCash($accounttype, $year, $month){
    $cashOnHand = getLedgerCode("Cash on Hand");
    $cashInBank = getLedgerCode("Cash on Bank");
    $accounttype = getAccountCode($accounttype);
    if(!$cashInBank || !$cashOnHand || !$accounttype){
        throw new Exception("Ledgers accounts not found");
    }
    if(is_numeric($year) && is_numeric($month) && $month >= 1 && $month <= 12){
        throw new Exception("Year and month are wrong");
    }

    $db = Database::getInstance();
    $conn = $db->connect();

    $sql = "SELECT 
    (SUM(
        CASE 
            WHEN LedgerNo_Dr = :cashOnHand OR LedgerNo_Dr = :cashInBank THEN amount 
            ELSE 0 
        END) 
    -
    SUM(
        CASE 
            WHEN LedgerNo = :cashOnHand OR LedgerNo = :cashInBank THEN amount 
            ELSE 0 
        END)) 
    as balance
    FROM ledgertransaction as lt
    JOIN ledger as cr ON lt.LedgerNo = cr.LedgerNo
    JOIN ledger as dr ON lt.LedgerNo_Dr = dr.LedgerNo_Dr
    WHERE YEAR(lt.date) = :year AND MONTH(lt.date) = :month AND (dr.accounttype = :accounttype OR cr.accounttype = :accounttype)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'cashOnHand' => $cashOnHand,
        'cashInBank' => $cashInBank,
        'year' => $year,
        'month' => $month,
        'accounttype' => $accounttype
    ]);

    $row = $stmt->fetch();
    return $row['balance'];
}
function getGroupTypeBalanceBasedOnCash($grouptype, $year, $month){
    $cashOnHand = getLedgerCode("Cash on Hand");
    $cashInBank = getLedgerCode("Cash on Bank");
    $grouptype = getGroupCode($grouptype);
    if(!$cashInBank || !$cashOnHand || !$grouptype){
        throw new Exception("Ledgers accounts not found");
    }
    if(is_numeric($year) && is_numeric($month) && $month >= 1 && $month <= 12){
        throw new Exception("Year and month are wrong");
    }

    $db = Database::getInstance();
    $conn = $db->connect();

    $sql = "SELECT 
    (SUM(
        CASE 
            WHEN LedgerNo_Dr = :cashOnHand OR LedgerNo_Dr = :cashInBank THEN amount 
            ELSE 0 
        END) 
    -
    SUM(
        CASE 
            WHEN LedgerNo = :cashOnHand OR LedgerNo = :cashInBank THEN amount 
            ELSE 0 
        END)) 
    as balance
    FROM ledgertransaction as lt
    JOIN ledger as cr ON lt.LedgerNo = cr.LedgerNo
    JOIN ledger as dr ON lt.LedgerNo_Dr = dr.LedgerNo_Dr
    JOIN accounttype as cr_at ON cr.accounttype = at.accounttype
    JOIN accounttype as dr_at ON dr.accounttype = at.accounttype
    WHERE YEAR(lt.date) = :year AND MONTH(lt.date) = :month AND (cr_at.grouptype = :grouptype OR dr_at.grouptype = :grouptype)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'cashOnHand' => $cashOnHand,
        'cashInBank' => $cashInBank,
        'year' => $year,
        'month' => $month,
        'grouptype' => $grouptype
    ]);

    $row = $stmt->fetch();
    return $row['balance'];
}
//generate cash flow report
// cash from operations, cash flow from investing
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
    $html .= generateCashFlowOperations($year, $month);
    $html .= generateCashFlowInvesting($year, $month);
    $html .= "</section>";
    $html .= generateEndingCashFlow($year, $month);
    return $html;
}

function generateCashFlowOperations($year, $month){
    $incomeCode = getGroupCode("Income");
    $expenseCode = getGroupCode("Expenses");
    //net earnings from cash
    $netEarnings = abs(getGroupTypeBalanceBasedOnCash($incomeCode, $year, $month)) - abs(getGroupTypeBalanceBasedOnCash($expenseCode, $year, $month));
    //additions
    
    //subtractions

    return $html;
}   

function generateCashFlowInvesting($year, $month){
    //all fixed assets
    $fixedAssetsCode = getAccountCode("Fixed assets");
    $allFixedAssets = getAllLedgerAccounts($fixedAssetsCode);

    $html = "<section>";
    $html .= "<table>";
    $html .= "<thead>";
    $html .= "<tr>";
    $html .= "<th colspan='2' class='text-left'>Cash Flow from Investing</th>";
    $html .= "</tr>";
    $html .= "</thead>";
    $html .= "<tbody>";
    foreach ($allFixedAssets as $ledger) {
        $balance = getAccountBalanceBasedOnCash($ledger['ledgerno'], $year, $month);
        // dont show ledger if balance is 0
        if($balance == 0){
            continue;
        }
        $html .= "<tr class='table-content'>";
        $html .= "<td class='content'>{$ledger['name']}</td>";
        $html .= "<td class='content-amount'>{$balance}</td>";
        $html .= "</tr>";
    }
    $html .= "</tbody>";

    // total section
    $total = getAccountTypeBalanceBasedOnCash($fixedAssetsCode, $year, $month);
    $html .= "<tfoot>";
    $html .= "<tr>";
    $html .= "<td>Net Total Cash from Investing</td>";
    $html .= "<td>".$total."</td>";
    $html .= "</tr>";
    $html .= "</tfoot>";
    $html .= "</table>";
    $html .= "</section>";

    return $html;
}

//generate end result
function generateEndingCashFlow($year, $month){
    if(is_numeric($year) && is_numeric($month) && $month >= 1 && $month <= 12){
        throw new Exception("Year and month are wrong");
    }
    $monthName = getMonthName($month);
    $total = getAccountBalance("Cash on Hand", $year, $month) + getAccountBalance("Cash on Bank", $year, $month);
    $html = "<section>";
    $html .= "<table>";
    $html .= "<tfoot>";
    $html .= "<tr>";
    $html .= "<td>Cash Flow for Month Ended ".$monthName." ". $year."</td>";
    $html .= "<td>{$total}</td>";
    $html .= "</tr>";
    $html .= "</tfoot>";
    $html .= "</table>";
    $html .= "</section>";

    return $html;
}

function getMonthName($month){
    if ($month < 1 || $month > 12) {
        throw new Exception("Invalid month");
    }
    return date('F', mktime(0, 0, 0, $month, 10)); 
}