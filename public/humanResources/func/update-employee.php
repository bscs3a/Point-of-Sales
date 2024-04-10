<?php

require_once './src/dbconn.php';

function updateEmployee($data, $employeeId) {

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
    $query_employees = "UPDATE employees SET first_name = :firstName, middle_name = :middleName, last_name = :lastName, dateofbirth = :birthday, gender = :gender, nationality = :nationality, civil_status = :civilstatus, address = :address, contact_number = :contactnumber, email = :email, department = :department, position = :position WHERE id = :employeeId";
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
    $stmt_employees->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);

    $stmt_employees->execute();
  
    // to salary info table
    $query_salary = "UPDATE salary_info SET base_salary = :basesalary, total_salary = :totalsalary WHERE employees_id = :employeeId";
    $stmt_salary = $conn->prepare($query_salary);
    $stmt_salary->bindParam(':basesalary', $basesalary, PDO::PARAM_STR);
    $stmt_salary->bindParam(':totalsalary', $totalsalary, PDO::PARAM_STR);
    $stmt_salary->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);
    
    $stmt_salary->execute();

    // to tax info table
    $query_tax = "UPDATE tax_info SET income_tax = :incometax, withholding_tax = :withholdingtax WHERE employees_id = :employeeId";
    $stmt_tax = $conn->prepare($query_tax);
    $stmt_tax->bindParam(':incometax', $incometax, PDO::PARAM_STR);
    $stmt_tax->bindParam(':withholdingtax', $withholdingtax, PDO::PARAM_STR);
    $stmt_tax->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);

    $stmt_tax->execute();

    // to benefits info table
    $query_benefits = "UPDATE benefits_info SET sss = :sss, pagibig = :pagibig, philhealth = :philhealth, thirteenth_month = :thirteenthmonth WHERE employees_id = :employeeId";
    $stmt_benefits = $conn->prepare($query_benefits);
    $stmt_benefits->bindParam(':sss', $sss, PDO::PARAM_STR);
    $stmt_benefits->bindParam(':pagibig', $pagibig, PDO::PARAM_STR);
    $stmt_benefits->bindParam(':philhealth', $philhealth, PDO::PARAM_STR);
    $stmt_benefits->bindParam(':thirteenthmonth', $thirteenthmonth, PDO::PARAM_STR);
    $stmt_benefits->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);

    $stmt_benefits->execute();
  
}