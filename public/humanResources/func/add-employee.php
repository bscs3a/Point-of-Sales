<?php

require_once './src/dbconn.php';

function insertEmployee($data) {

    // Extract data from the form
    // BASIC EMPLOYEE INFORMATION
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $birthday = $_POST['birthday'];
    $gender = $_POST['gender'];
    $nationality = $_POST['nationality'];
    $civilstatus = $_POST['civilstatus'];
    $address = $_POST['address'];
    $contactnumber = $_POST['contactnumber'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $position = $_POST['position'];

    // SALARY AND TAX INFORMATION
    // salary
    $basesalary = $_POST['basesalary'];
    $totalsalary = $_POST['totalsalary'];
    // tax
    $incometax = $_POST['incometax'];
    $withholdingtax = $_POST['withholdingtax'];
    // benefits
    $sss = $_POST['sss'];
    $pagibig = $_POST['pagibig'];
    $philhealth = $_POST['philhealth'];
    $thirteenthmonth = $_POST['thirteenthmonth'];

    $db = Database::getInstance();
    $conn = $db->connect();

    // to employees table
    $query_employees = "INSERT INTO employees (first_name, middle_name, last_name, dateofbirth, gender, nationality, civil_status, address, contact_number, email, department, position) VALUES (:firstName, :middleName, :lastName, :dateofbirth, :gender, :nationality, :civilstatus, :address, contactnumber, :email, :department, :position)";
    $stmt_employees = $conn->prepare($query_employees);
    $stmt_employees->bindParam(':firstName', $firstName, PDO::PARAM_STR);
    $stmt_employees->bindParam(':middleName', $middleName, PDO::PARAM_STR);
    $stmt_employees->bindParam(':lastName', $lastName, PDO::PARAM_STR);
    $stmt_employees->bindParam(':birthday', $birthday, PDO::PARAM_STR);
    $stmt_employees->bindParam(':gender', $gender, PDO::PARAM_STR);
    $stmt_employees->bindParam(':nationality', $nationality, PDO::PARAM_STR);
    $stmt_employees->bindParam(':civilstatus', $civilstatus, PDO::PARAM_STR);
    $stmt_employees->bindParam(':address', $address, PDO::PARAM_STR);
    $stmt_employees->bindParam(':contactnumber', $contactnumber, PDO::PARAM_STR);
    $stmt_employees->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt_employees->bindParam(':department', $department, PDO::PARAM_STR);
    $stmt_employees->bindParam(':position', $position, PDO::PARAM_STR);

    $stmt_employees->execute();
    $lastInsertedEmployeeId = $conn->lastInsertId();
  
    // to salary info table
    $query_salary = "INSERT INTO salary_info (base_salary, total_salary, employees_id) VALUES (:basesalary, :totalsalary, :employees_id)";
    $stmt_salary = $conn->prepare($query_salary);
    $stmt_salary->bindParam(':basesalary', $basesalary, PDO::PARAM_STR);
    $stmt_salary->bindParam(':totalsalary', $totalsalary, PDO::PARAM_STR);
    $stmt_salary->bindParam(':employees_id', $lastInsertedEmployeeId, PDO::PARAM_INT);
    
    $stmt_salary->execute();

    // to tax info table
    $query_tax = "INSERT INTO tax_info (income_tax, withholding_tax, employees_id) VALUES (:incometax, :withholdingtax, :employees_id)";
    $stmt_tax = $conn->prepare($query_tax);
    $stmt_tax->bindParam(':incometax', $incometax, PDO::PARAM_STR);
    $stmt_tax->bindParam(':withholdingtax', $withholdingtax, PDO::PARAM_STR);
    $stmt_tax->bindParam(':employees_id', $lastInsertedEmployeeId, PDO::PARAM_INT);

    $stmt_tax->execute();

    // to benefits info table
    $query_benefits = "INSERT INTO benefits_info (sss, pagibig, philhealth, thirteenth_month, employees_id) VALUES (:sss, :pagibig, :philhealth, :thirteenthmonth, :employees_id)";
    $stmt_benefits = $conn->prepare($query_benefits);
    $stmt_benefits->bindParam(':sss', $sss, PDO::PARAM_STR);
    $stmt_benefits->bindParam(':pagibig', $pagibig, PDO::PARAM_STR);
    $stmt_benefits->bindParam(':philhealth', $philhealth, PDO::PARAM_STR);
    $stmt_benefits->bindParam(':thirteenthmonth', $thirteenthmonth, PDO::PARAM_STR);
    $stmt_benefits->bindParam(':employees_id', $lastInsertedEmployeeId, PDO::PARAM_INT);

    $stmt_benefits->execute();
  
}