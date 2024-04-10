<?php

require_once './src/dbconn.php';

function deleteEmployee($employeeId) {

    $db = Database::getInstance();
    $conn = $db->connect();

    // delete from employees table
    $query_employees = "DELETE FROM employees WHERE id = :employeeId";
    $stmt_employees = $conn->prepare($query_employees);
    $stmt_employees->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);
    $stmt_employees->execute();

    // delete from salary info table
    $query_salary = "DELETE FROM salary_info WHERE employees_id = :employeeId";
    $stmt_salary = $conn->prepare($query_salary);
    $stmt_salary->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);
    $stmt_salary->execute();

    // delete from tax info table
    $query_tax = "DELETE FROM tax_info WHERE employees_id = :employeeId";
    $stmt_tax = $conn->prepare($query_tax);
    $stmt_tax->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);
    $stmt_tax->execute();

    // delete from benefits info table
    $query_benefits = "DELETE FROM benefits_info WHERE employees_id = :employeeId";
    $stmt_benefits = $conn->prepare($query_benefits);
    $stmt_benefits->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);
    $stmt_benefits->execute();
  
}