<?php
require_once "../supportingFunctions/supportingExpense.php";

//insert something in the the expense table
function insertIntoExpenseTable($department, $amount, $details, $payfor, $payusing){
    if (!checkDepartment($department)){
        throw new Exception("Department does not exist");
    }
    if ($amount <= 0){
        throw new Exception("Amount must be greater than 0");
    }
    if ($details === null || $details === ""){
        throw new Exception("Details cannot be empty");
    }
    if (!checkPayFor($payfor)){
        throw new Exception("Pay for cannot be null");
    }
    if (!checkPayUsing($payusing)){
        throw new Exception("Pay using cannot be null");
    }

    $db = Database::getInstance();
    $conn = $db->connect();
    
    $PENDING = "pending";
    $sql = "INSERT INTO requestexpense (department, amount, details, payfor, payusing, status) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$department, $amount, $details, $details, $payfor, $payusing, $PENDING]);

    return true;
}

//delete your request -- we dont really have delete, we just push it to decline
function deleteRequestInTable($id){
    if ($id === null){
        throw new Exception("Id cannot be null");
    }
    $db = Database::getInstance();
    $conn = $db->connect();

    $DECLINED = "deny";
    $sql = "UPDATE requestexpense SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$DECLINED, $id]);

    return true;
}
    
//display all your request depending on department
function viewRequestInTable($department){
    if ($department === null){
        throw new Exception("Department cannot be null");
    }
    if (!checkDepartment($department)) {
        throw new Exception("Department does not exist");
    }
    $db = Database::getInstance();
    $conn = $db->connect();

    $sql = "SELECT * FROM ExpenseRequest WHERE department = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$department]);

    $result = $stmt->fetchAll();
    return $result;
}

?>