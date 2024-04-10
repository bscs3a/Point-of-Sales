<?php 

// require_once './../../../src/dbconn.php';

function addAccountantAuditLog($logAction = "Log") {

    $db = Database::getInstance();
    $pdo = $db->connect();
    
    $sql = "INSERT INTO tbl_fin_audit (employee_name, log_action) VALUES (:employee_name, :log_action)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":employee_name", $_SESSION['employee_name']);
    $stmt->bindParam(":log_action", $logAction);
    $stmt->execute();

}








?>