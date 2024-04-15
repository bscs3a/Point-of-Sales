<?php 

include_once "C:/xampp/htdocs/Finance/src/dbconn.php";
 $modalId = $_POST['LedgerNo'];
 $details = $_POST['details'];
 $amount = $_POST['amount'];
 $ledgerName = $_POST['LedgerNo_Dr'];
 
 $db = Database::getInstance();
 $conn = $db->connect();        

 $sql = "INSERT INTO ledgertransaction (LedgerNo, details, amount, LedgerNo_Dr) VALUES (:modalId, :details, :amount, :ledgerNo_Dr)";
 $stmt = $conn->prepare($sql);
 
 $stmt->bindParam(':modalid', $modalId);
 $stmt->bindParam(':details', $details);
 $stmt->bindParam(':amount', $amount);
 $stmt->bindParam(':ledgerNo_Dr', $ledgerName);
 
 
 $stmt->execute();
    

 $rootFolder = dirname($_SERVER['PHP_SELF']);
 header("Location: $rootFolder/fin/test");