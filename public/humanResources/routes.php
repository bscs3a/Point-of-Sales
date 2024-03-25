<?php

$path = './public/humanResources/views';
$basePath = "$path/hr.";

$hr = [
    // Dashboard
    '/hr/dashboard' => $basePath . "dashboard.php",

    // employee profile
    '/hr/employees' => $basePath . "employees.php",
    '/hr/employees/search' => $basePath . "employees.php",
    '/hr/employees/add' => $basePath . "employees.add.php",

    // departments
    '/hr/employees/departments' => $basePath . "departments.php", // 'departments.php
    '/hr/employees/departments/product-order' => $basePath . "departments.PO.php", // 'departments.PO.php
    '/hr/employees/departments/inventory' => $basePath . "departments.inv.php", // 'departments.inv.php
    '/hr/employees/departments/sales' => $basePath . "departments.POS.php", // 'departments.POS.php
    '/hr/employees/departments/finance' => $basePath . "departments.fin.php", // 'departments.fin.php
    '/hr/employees/departments/delivery' => $basePath . "departments.dlv.php", // 'departments.dlv.php
    '/hr/employees/departments/human-resources' => $basePath . "departments.HR.php", // 'departments.HR.php

    '/hr/schedule' => $basePath . "schedule.php",
    '/hr/applicants' => $basePath . "applicants.php",
    '/hr/payroll' => $basePath . "payroll.php",
    '/hr/leave-requests' => $basePath . "leave-requests.php",
    '/hr/dtr' => $basePath . "daily-time-record.php",

    //view profile
    '/hr/employees/id={id}' => function($id) use ($basePath) {
        $_SESSION['id'] = $id;
        include $basePath . "employees.profile.php";
    },

    //update profile
    '/hr/employees/update={id}' => function($id) use ($basePath) {
        $_SESSION['id'] = $id;
        include $basePath . "employees.update.php";
    },
];

// add employees
// Function to calculate tax amount based on monthly salary | INCOME TAX
function calculateIncomeTax($monthlysalary) {
    if ($monthlysalary <= 20833.33) {
        // Over 0 but not over 20,833.33 (250,000 annual salary)
        return 0;
    } elseif ($monthlysalary <= 33333.33) {
        // Over 20,833.33 but not over 33,333.33 (400,000 annual salary)
        return ($monthlysalary - 20833.33) * 0.20;
    } elseif ($monthlysalary <= 66666.67) {
        // Over 33,333.33 but not over 66,666 (800,000 annual salary)
        return 2500 + ($monthlysalary - 33333.33) * 0.25;
    } elseif ($monthlysalary <= 166666.67) {
        // Over 66,666 but not over 166,666 (2,000,000 annual salary)
        return 10833.33 + ($monthlysalary - 66666.67) * 0.30;
    } elseif ($monthlysalary <= 666666.67) {
        // Over 166,666 but not over 666,666 (8,000,000 annual salary)
        return 40833.33 + ($monthlysalary - 166666.67) * 0.32;
    } else {
        // Over 666,666 (8,000,000 annual salary)
        return 200833.33 + ($monthlysalary - 666666.67) * 0.35;
    }
}

// Function to calculate tax amount based on monthly salary | WITHHOLDING TAX
function calculateWithholdingTax($monthlysalary) {
    if ($monthlysalary <= 20833.33) {
        // 20,833.33 and below
        return 0;
    } elseif ($monthlysalary <= 33333.33) {
        // 20,833.34 to 33,333.33
        return 0 + ($monthlysalary - 20833.33) * 0.15;
    } elseif ($monthlysalary <= 66666.67) {
        // 33,333.34 to 66,666.67
        return 1875 + ($monthlysalary - 33333.33) * 0.20;
    } elseif ($monthlysalary <= 166666.67) {
        // 66,666.68 to 166,666.67
        return 8541.80 + ($monthlysalary - 66666.67) * 0.25;
    } elseif ($monthlysalary <= 666666.67) {
        // 166,666.68 to 666,666.67
        return 33541.80 + ($monthlysalary - 166666.67) * 0.30;
    } else {
        // 666,666.68 and above
        return 183541.80 + ($monthlysalary - 666666.67) * 0.35;
    }
}

// Function to calculate SSS contribution
function calculateSSS($monthlysalary) {
    // SSS contribution is 14% of the monthly salary
    return ($monthlysalary * 0.14) * 0.32;
}

// Function to calculate Philhealth contribution
function calculatePhilhealth($monthlysalary) {
    if ($monthlysalary <= 10000.00) {
        return 500.00;
    } elseif ($monthlysalary <= 99999.99) {
        return 500.00 + ($monthlysalary - 10000.00) * 0.05;
    } else {
        return 5000.00;
    }
}

// Function to calculate Pag-IBIG fund contribution
function calculatePagibig($monthlysalary) {
    // Pag-IBIG fund contribution is fixed at P200
    return 200.00;
}

Router::post('/hr/employees/add', function () {
    $db = Database::getInstance();
    $conn = $db->connect();

    $rootFolder = dirname($_SERVER['PHP_SELF']);

    // BASIC EMPLOYEE INFORMATION
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $dateofbirth = $_POST['dateofbirth'];
    $gender = $_POST['gender'];
    $nationality = $_POST['nationality'];
    $civilstatus = $_POST['civilstatus'];
    $address = $_POST['address'];
    $contactnumber = $_POST['contactnumber'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $position = $_POST['position'];

    $query = "INSERT INTO employees (first_name, middle_name, last_name, dateofbirth, gender, nationality, civil_status, address, contact_no, email, department, position) VALUES (:firstName, :middleName, :lastName, :dateofbirth, :gender, :nationality, :civilstatus, :address, :contactnumber, :email, :department, :position);";
    $stmt = $conn->prepare($query);

    if (empty($firstName) || empty($lastName) || empty($dateofbirth) || empty($gender) || empty($nationality) || empty($civilstatus) || empty($address) || empty($department) || empty($position)) {
        header("Location: $rootFolder/hr/employees/add");
        return;
    }

    // if (empty($firstName) || empty($lastName) || empty($dateofbirth) || empty($gender) || empty($nationality) || empty($civilstatus) || empty($address) || empty($department) || empty($position)) {
    //     header("Location: $rootFolder/hr/employees/add");
    //     return;
    // }

    $stmt->execute([
        ':firstName' => $firstName,
        ':middleName' => $middleName,
        ':lastName' => $lastName,
        ':dateofbirth' => $dateofbirth,
        ':gender' => $gender,
        ':nationality' => $nationality,
        ':civilstatus' => $civilstatus,
        ':address' => $address,
        ':contactnumber' => $contactnumber,
        ':email' => $email,
        ':department' => $department,
        ':position' => $position,
    ]);

    $employeeId = $conn->lastInsertId();

    // EMPLOYMENT INFORMATION
    $dateofhire = $_POST['dateofhire'];
    $startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];

    $query = "INSERT INTO employment_info (employees_id, dateofhire, startdate, enddate) VALUES (:employeeId, :dateofhire, :startdate, :enddate);";
    $stmt = $conn->prepare($query);

    if (empty($dateofhire) || empty($startdate)) {
        header("Location: $rootFolder/hr/employees/add");
        return;
    }

    $stmt->execute([
        ':employeeId' => $employeeId,
        ':dateofhire' => $dateofhire,
        ':startdate' => $startdate,
        ':enddate' => $enddate,
    ]);

    // SALARY AND TAX INFORMATION
    // salary
    $monthlysalary = $_POST['monthlysalary'];
    $totalsalary = $_POST['totalsalary'];
    
    // Calculate total deductions
    $totalDeductions = calculatePagibig($monthlysalary) + calculateSSS($monthlysalary) + calculatePhilhealth($monthlysalary) + calculateIncomeTax($monthlysalary) + calculateWithholdingTax($monthlysalary);

    // Calculate total salary
    $totalSalary = $monthlysalary - $totalDeductions;

    $query = "INSERT INTO salary_info (employees_id, monthly_salary, total_salary) VALUES (:employeeId, :monthlysalary, :totalsalary);";
    $stmt = $conn->prepare($query);

    if (empty($monthlysalary)) {
        header("Location: $rootFolder/hr/employees/add");
        return;
    }

    $stmt->execute([
        ':employeeId' => $employeeId,
        ':monthlysalary' => $monthlysalary,
        ':totalsalary' => $totalSalary,
    ]);

    // tax
    $incometax = $_POST['incometax'];
    $withholdingtax = $_POST['withholdingtax'];

    // Calculate tax amount based on monthly salary
    $taxAmount = calculateWithholdingTax($monthlysalary);

    $query = "INSERT INTO tax_info (employees_id, income_tax, withholding_tax) VALUES (:employeeId, :incometax, :withholdingtax);";
    $stmt = $conn->prepare($query);

    $stmt->execute([
        ':employeeId' => $employeeId,
        ':incometax' => $incometax,
        ':withholdingtax' => $taxAmount,
    ]);
    
    // benefits
    $sss = $_POST['sss'];
    $pagibig = $_POST['pagibig'];
    $philhealth = $_POST['philhealth'];
    $thirteenthmonth = $_POST['thirteenthmonth'];

    // Calculate SSS contribution
    $sssContribution = calculateSSS($monthlysalary);

    // Calculate Philhealth contribution based on monthly salary
    $philhealthContribution = calculatePhilhealth($monthlysalary);

    // Calculate Pag-IBIG fund contribution based on monthly salary
    $pagibigContribution = calculatePagibig($monthlysalary);

    // Calculate total basic salary earned by the employee within the calendar year
    $totalBasicSalary = $monthlysalary * 12;

    // Calculate the minimum value for the 13th-month pay
    $minimumThirteenthMonthPay = $totalBasicSalary / 12;

    // Ensure that the 13th-month pay is not less than the minimum value
    $thirteenthmonth = max($minimumThirteenthMonthPay, $monthlysalary);

    $query = "INSERT INTO benefit_info (employees_id, sss_fund, pagibig_fund, philhealth, thirteenth_month) VALUES (:employeeId, :sss, :pagibig, :philhealth, :thirteenthmonth);";
    $stmt = $conn->prepare($query);

    $stmt->execute([
        ':employeeId' => $employeeId,
        ':sss' => $sssContribution,
        ':pagibig' => $pagibigContribution,
        ':philhealth' => $philhealthContribution,
        ':thirteenthmonth' => $thirteenthmonth,
    ]);

    // ACCOUNT INFORMATION
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['department'];

    $query = "INSERT INTO account_info (employees_id, username, password, role) VALUES (:employeeId, :username, :password, :role);";
    $stmt = $conn->prepare($query);

    if (empty($username) || empty($password) || empty($role)) {
        header("Location: $rootFolder/hr/employees/add");
        return;
    }

    $stmt->execute([
        ':employeeId' => $employeeId,
        ':username' => $username,
        ':password' => $password,
        ':role' => $role,
    ]);

    header("Location: $rootFolder/hr/employees");
});

// search employees
Router::post('/hr/employees', function () {

    $search = $_POST['search'];

    $rootFolder = dirname($_SERVER['PHP_SELF']);

    if (empty($search)) {
        header("Location: $rootFolder/hr/employees");
        return;
    }

    include './public/humanResources/views/hr.employees.php';
});

// search employees in DEPARTMENTS : Product Order
Router::post('/hr/employees/departments/product-order', function () {
    $db = Database::getInstance();
    $conn = $db->connect();

    $search = $_POST['search'];

    $rootFolder = dirname($_SERVER['PHP_SELF']);

    if (empty($search)) {
        header("Location: $rootFolder/hr/employees/departments/product-order");
        return;
    }

    include './public/humanResources/views/hr.departments.PO.php';
});

// search employees in DEPARTMENTS : Inventory
Router::post('/hr/employees/departments/inventory', function () {
    $db = Database::getInstance();
    $conn = $db->connect();

    $search = $_POST['search'];

    $rootFolder = dirname($_SERVER['PHP_SELF']);

    if (empty($search)) {
        header("Location: $rootFolder/hr/employees/departments/inventory");
        return;
    }

    include './public/humanResources/views/hr.departments.inv.php';
});

// search employees in DEPARTMENTS : Point of Sales
Router::post('/hr/employees/departments/sales', function () {
    $db = Database::getInstance();
    $conn = $db->connect();

    $search = $_POST['search'];

    $rootFolder = dirname($_SERVER['PHP_SELF']);

    if (empty($search)) {
        header("Location: $rootFolder/hr/employees/departments/sales");
        return;
    }

    include './public/humanResources/views/hr.departments.POS.php';
});

// search employees in DEPARTMENTS : Finance
Router::post('/hr/employees/departments/finance', function () {
    $db = Database::getInstance();
    $conn = $db->connect();

    $search = $_POST['search'];

    $rootFolder = dirname($_SERVER['PHP_SELF']);

    if (empty($search)) {
        header("Location: $rootFolder/hr/employees/departments/finance");
        return;
    }

    include './public/humanResources/views/hr.departments.fin.php';
});

// search employees in DEPARTMENTS : Delivery
Router::post('/hr/employees/departments/delivery', function () {
    $db = Database::getInstance();
    $conn = $db->connect();

    $search = $_POST['search'];

    $rootFolder = dirname($_SERVER['PHP_SELF']);

    if (empty($search)) {
        header("Location: $rootFolder/hr/employees/departments/delivery");
        return;
    }

    include './public/humanResources/views/hr.departments.dlv.php';
});

// search employees in DEPARTMENTS : Human Resources
Router::post('/hr/employees/departments/human-resources', function () {
    $db = Database::getInstance();
    $conn = $db->connect();

    $search = $_POST['search'];

    $rootFolder = dirname($_SERVER['PHP_SELF']);

    if (empty($search)) {
        header("Location: $rootFolder/hr/employees/departments/human-resources");
        return;
    }

    include './public/humanResources/views/hr.departments.HR.php';
});

// search applicants
Router::post('/hr/applicants', function () {
    $db = Database::getInstance();
    $conn = $db->connect();

    $search = $_POST['search'];

    $rootFolder = dirname($_SERVER['PHP_SELF']);

    if (empty($search)) {
        header("Location: $rootFolder/hr/applicants");
        return;
    }

    $query = "SELECT * FROM applicants WHERE first_name = :search OR last_name = :search OR applyingForPosition = :search OR id = :search;";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":search", $search);

    // Execute the statement
    $stmt->execute();
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

    include './public/humanResources/views/hr.applicants.php';
});

// search leave_requests
Router::post('/hr/leave-requests', function () {
    $db = Database::getInstance();
    $conn = $db->connect();

    $search = $_POST['search'];

    $rootFolder = dirname($_SERVER['PHP_SELF']);

    if (empty($search)) {
        header("Location: $rootFolder/hr/leave-requests");
        return;
    }

    $query = "SELECT leave_requests.*, employees.image_url, employees.first_name, employees.middle_name, employees.last_name, employees.position, employees.department FROM leave_requests LEFT JOIN employees ON leave_requests.employees_id = employees.id WHERE employees.first_name = :search OR employees.last_name = :search OR employees.position = :search OR employees.department = :search OR leave_requests.id = :search OR leave_requests.type = :search OR leave_requests.employees_id = :search;";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":search", $search);

    // Execute the statement
    $stmt->execute();
    $leaveRequests = $stmt->fetchAll(PDO::FETCH_ASSOC);

    include './public/humanResources/views/hr.leave-requests.php';
});

// EXAMPLE DELETE
Router::post('/delete', function () {
    $db = Database::getInstance();
    $conn = $db->connect();

    $name = $_POST['name'];

    $stmt = $conn->prepare("DELETE FROM name WHERE name = :name");
    $stmt->bindParam(':name', $name);

    // Execute the statement
    $stmt->execute();

    $rootFolder = dirname($_SERVER['PHP_SELF']);
    header("Location: $rootFolder/hr/test");
});