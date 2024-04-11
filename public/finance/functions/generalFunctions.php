<?php
require_once 'src/dbconn.php';
//get the value of 1 t-account - can return negative or positive
function getAccountBalance($ledger, $considerDate = false, $year = null, $month = null) {
    $db = Database::getInstance();
    $conn = $db->connect();

    $ledgerNo = getLedgerCode($ledger);

    if ($ledgerNo === false) {
        throw new Exception("Account not found in Ledger table.");
    }

    if ($considerDate && $year !== null && $month !== null) {
        $sql = "SELECT * FROM LedgerTransaction WHERE (ledgerno = ? OR ledgerNo_Dr = ?) AND YEAR(datetime) = ? AND MONTH(datetime) = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$ledgerNo, $ledgerNo, $year, $month]);
    } else {
        $sql = "SELECT * FROM LedgerTransaction WHERE ledgerno = ? OR ledgerNo_Dr = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$ledgerNo, $ledgerNo]);
    }

    $balance = 0;
    
    while ($row = $stmt->fetch()) {
        if ($row['LedgerNo_Dr'] == $ledgerNo) {
            $balance += $row['amount'];
        } else if ($row['LedgerNo'] == $ledgerNo) {
            $balance -= $row['amount'];
        }
    }

    return $balance;
}

// used for getting the ledger code
function getLedgerCode($ledger){
    $db = Database::getInstance();
    $conn = $db->connect();

    // Check if the account exists in the Ledger table
    $sql = "SELECT ledgerno FROM Ledger WHERE ledgerno = ? OR name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$ledger, $ledger]);
    $ledgerNo = $stmt->fetchColumn();

    return $ledgerNo;

}

//get the value of 1 group type - always returns positve
function getTotalOfGroup($groupType, $year = null, $month = null) {
    $db = Database::getInstance();
    $conn = $db->connect();

    $groupType = getGroupCode($groupType);

    if ($groupType === false) {
        throw new Exception("Account not found in Ledger table.");
    }

    $sql = "SELECT lt.* FROM LedgerTransaction lt
            JOIN Ledger l ON lt.ledgerNo = l.ledgerNo
            JOIN AccountType at ON l.accountType = at.accountType
            WHERE at.groupType = :groupType";
    if ($year !== null && $month !== null) {
        $sql .= " AND YEAR(lt.datetime) = :year AND MONTH(lt.datetime) = :month";
    }
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':groupType', $groupType);
    if ($year !== null && $month !== null) {
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->bindParam(':month', $month, PDO::PARAM_INT);
    }
    $stmt->execute();

    $netAmount = 0;

    while ($row = $stmt->fetch()) {
        $netAmount += $row['amount'];
    }

    $sql = "SELECT lt.* FROM LedgerTransaction lt
            JOIN Ledger l ON lt.ledgerNo_dr = l.ledgerNo
            JOIN AccountType at ON l.accountType = at.accountType
            WHERE at.groupType = :groupType";
    if ($year !== null && $month !== null) {
        $sql .= " AND YEAR(lt.datetime) = :year AND MONTH(lt.datetime) = :month";
    }
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':groupType', $groupType);
    if ($year !== null && $month !== null) {
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->bindParam(':month', $month, PDO::PARAM_INT);
    }
    $stmt->execute();

    while ($row = $stmt->fetch()) {
        $netAmount -= $row['amount'];
    }

    return abs($netAmount);
}

function getGroupCode($groupType){
    $db = Database::getInstance();
    $conn = $db->connect();

    // Check if the account exists in the Ledger table
    $sql = "SELECT grouptype FROM grouptype WHERE grouptype = ? OR description = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$groupType, $groupType]);
    $groupCode = $stmt->fetchColumn();

    return $groupCode;

}

function getTotalOfAccountType($accountType, $year = null, $month = null) {
    $db = Database::getInstance();
    $conn = $db->connect();

    $accountType = getAccountCode($accountType);

    if ($accountType === false) {
        throw new Exception("Account not found in Ledger table.");
    }

    $sql = "SELECT lt.* FROM LedgerTransaction lt
            JOIN Ledger l ON lt.ledgerNo = l.ledgerNo
            JOIN AccountType at ON l.accountType = at.accountType
            WHERE at.accountType = :accountType";
    if ($year !== null && $month !== null) {
        $sql .= " AND YEAR(lt.datetime) = :year AND MONTH(lt.datetime) = :month";
    }
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':accountType', $accountType);
    if ($year !== null && $month !== null) {
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->bindParam(':month', $month, PDO::PARAM_INT);
    }
    $stmt->execute();

    $netAmount = 0;

    while ($row = $stmt->fetch()) {
        $netAmount += $row['amount'];
    }

    $sql = "SELECT lt.* FROM LedgerTransaction lt
            JOIN Ledger l ON lt.ledgerNo_dr = l.ledgerNo
            JOIN AccountType at ON l.accountType = at.accountType
            WHERE at.accountType = :accountType";
    if ($year !== null && $month !== null) {
        $sql .= " AND YEAR(lt.datetime) = :year AND MONTH(lt.datetime) = :month";
    }
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':accountType', $accountType);
    if ($year !== null && $month !== null) {
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->bindParam(':month', $month, PDO::PARAM_INT);
    }
    $stmt->execute();

    while ($row = $stmt->fetch()) {
        $netAmount -= $row['amount'];
    }

    return abs($netAmount);
}

function getAccountCode($accountType){
    $db = Database::getInstance();
    $conn = $db->connect();

    // Check if the account exists in the Ledger table
    $sql = "SELECT accountType FROM accounttype WHERE accountType = ? OR Description = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$accountType, $accountType]);
    $accountCode = $stmt->fetchColumn();

    return $accountCode;

}
?>